<?php
    class VirtualMallPriceSetController extends BaseController {

        protected $model = '';

        public function init() {
            $this->model = substr(__CLASS__, 0, -10);
            parent::init();
        }

        public function actionIndex($keywords='',$star_time='',$end_time=''){
            set_cookie('_currentUrl_',Yii::app()->request->url);
            $modelName = $this->model;
            $model = $modelName::model();
            $criteria = new CDbCriteria;
            $criteria->condition = 'if_del=648';
            $criteria->condition = get_where($criteria->condition,!empty($star_time),'left(star_time,10)>=',$star_time,'"');
            $criteria->condition = get_where($criteria->condition,!empty($end_time),'left(end_time,10)<=',$end_time,'"');
            $criteria->condition = get_like($criteria->condition,'code,name',$keywords,'');
            $criteria->order = '';
            $data = array();
            $data['base_code'] = BaseCode::model()->getStateType();
            $data['userstate'] = BaseCode::model()->getCode(647);
            $data['product_type'] = BaseCode::model()->getOrderType();
            $data['supplier_id'] = ClubList::model()->findAll();
            parent::_list($model,$criteria,'index',$data);
        }

        public function actionCreate(){
            $modelName = $this->model;
            $model = new $modelName('create');
            $data = array();
            if(!Yii::app()->request->isPostRequest){
                $data['model'] = $model;
                $this->render('update', $data);
            }
            else{
                $this->saveData($model,$_POST[$modelName]);
            }
        }

        public function actionUpdate($id){
            $modelName = $this->model;
            $model = $this->loadModel($id,$modelName);
            $data = array();
            if (!Yii::app()->request->isPostRequest) {
                $data['model'] = $model;
                $data['product_list'] = VirtualMallPriceSetDetails::model()->findAll('set_id='.$model->id);
                $this->render('update', $data);
            } else {
                $this->saveData($model,$_POST[$modelName]);
            }
        }

        function saveData($model,$post){
            $model->attributes = $post;
            $model->f_check = 2;//get_check_code($_POST['submitType']);
            $sv = $model->save();
            $this->save_details($model,$post['product']);
            show_status($sv,'操作成功',get_cookie('_currentUrl_'),'操作失败');
        }

        public function actionDelete($id){
            $modelName = $this->model;
            $model = $modelName::model();
            $count = 0;
            $ld = explode(',',$id);
            foreach($ld as $d){
                $table_name = 'virtual_mall_price_set';
                $model->updateByPk($d,array('if_del'=>649,'is_user'=>648));
                $mall_set = MallPriceSet::model()->find('data_sourcer_table="'.$table_name.'" and data_sourcer_id='.$d);
                if(!empty($mall_set)){
                    $mall_set->updateAll(array('if_del'=>649,'if_user_state'=>648),'id='.$mall_set->id);
                    MallPriceSetDetails::model()->updateAll(array('if_dispay'=>649),'set_id='.$mall_set->id);
                    MallPricingDetails::model()->updateAll(array('if_user'=>648),'set_id='.$mall_set->id);
                    VirtualMallPriceSetDetails::model()->updateAll(array('if_dispay'=>649),'set_id='.$d);
                    $mpsd = MallPriceSetDetails::model()->findAll('set_id='.$mall_set->id);
                    $cid = 0;
                    if(!empty($mpsd))foreach($mpsd as $mp){
                        $cid .= $mp->id.',';
                    }
                    VirtualchangeSets::model()->updateAll(
                        array(
                            'state'=>373,
                            'reasons_for_failure'=>'商品已删除'
                        ),
                        'pricing_details_id in('.rtrim($cid,",").')'
                    );
                }
                $count++;
            }
            if ($count > 0) {
                ajax_status(1, '删除成功',Yii::app()->request->urlReferrer);
            } else {
                ajax_status(0, '删除失败');
            }
        }

        public function save_details($model,$product){
            $table_name = 'virtual_mall_price_set';
            $mall_price_set = MallPriceSet::model()->find('data_sourcer_table="'.$table_name.'" and data_sourcer_id='.$model->id);
            if(!empty($mall_price_set)){
                MallPriceSetDetails::model()->updateAll(array('sale_bean2'=>-1),'set_id='.$mall_price_set->id);//做临时删除标识
                MallPricingDetails::model()->updateAll(array('no'=>-1),'set_id='.$mall_price_set->id);//做临时删除标识
            }
            VirtualMallPriceSetDetails::model()->updateAll(array('no'=>0),'set_id='.$model->id);
            $base_code = BaseCode::model()->find('f_id=364');

            // 商品上架方案表
            if(empty($mall_price_set)){
                $mall_price_set = new MallPriceSet;
                $mall_price_set->isNewRecord = true;
                unset($mall_price_set->id);
            }
            $mall_price_set->event_title = $model->name;
            $mall_price_set->start_sale_time = $model->star_time;
            $mall_price_set->down_time = $model->end_time;
            $mall_price_set->supplier_id = get_session('club_id');
            $mall_price_set->supplier_name = get_session('club_name');
            $mall_price_set->if_user_state = 649;
            $mall_price_set->pricing_type = 364;
            $mall_price_set->pricing_type_name = $base_code->F_NAME;
            $mall_price_set->star_time = $model->star_time;
            $mall_price_set->end_time = $model->end_time;
            $mall_price_set->add_adminid = get_session('admin_id');
            $mall_price_set->update_date = get_date();
            $mall_price_set->f_check = 2;
            $mall_price_set->data_sourcer_table = $table_name;
            $mall_price_set->data_sourcer_id = $model->id;
            $sm = $mall_price_set->save();
            $model->mall_price_set_id = $mall_price_set->id;
            $model->save();
            if(isset($_POST['product'])){
                foreach($_POST['product'] as $v){
                    $product_detail=MallPriceSetDetails::model()->find('id='.$v['mall_pricing_details_id']);
                    if(empty($product_detail)){
                        // 商品数量明细表
                        $product_detail = new MallPriceSetDetails();
                        $product_detail->isNewRecord = true;
                        unset($product_detail->id);
                        $product_detail->set_id = $mall_price_set->id;
                        $product_detail->set_code = $mall_price_set->event_code;
                    }
                    $product_detail->product_id = $v['product_id'];
                    $product_detail->product_code = $v['product_code'];
                    $product_detail->product_name = $v['product_name'];
                    $product_detail->Inventory_quantity = $v['Inventory_quantity'];
                    $product_detail->sale_price = $v['shopping_price'];
                    $product_detail->purpose = 94;
                    $product_detail->shop_purpose = 94;
                    $product_detail->star_time = $model->star_time;
                    $product_detail->start_sale_time = $model->star_time;
                    $product_detail->end_time = $model->end_time;
                    $product_detail->down_time = $model->end_time;
                    $product_detail->supplier_id = $model->club_id;
                    $product_detail->pricing_type = 364;
                    $product_detail->if_dispay = 648;
                    $product_detail->f_check = 2;
                    $product_detail->sale_bean2 = 0;
                    $product_detail->save();

                    // 商品价格明细表
                    $mall_id = '';
                    $pricing_detail=MallPricingDetails::model()->find('set_details_id='.$product_detail->id);
                    if(empty($pricing_detail)){
                        $pricing_detail = new MallPricingDetails();
                        $pricing_detail->isNewRecord = true;
                        unset($pricing_detail->id);
                        $pricing_detail->set_id = $mall_price_set->id;
                        $pricing_detail->code = $mall_price_set->event_code;
                        $pricing_detail->set_details_id = $product_detail->id;
                    }
                    $pricing_detail->product_id = $v['product_id'];
                    $pricing_detail->product_name = $v['product_name'];
                    $pricing_detail->shopping_price = $v['shopping_price'];
                    $pricing_detail->inventory_quantity = $v['Inventory_quantity'];
                    // $pricing_detail->shopping_beans = $v['sale_bean'];
                    $pricing_detail->star_time = $product_detail->star_time;
                    $pricing_detail->end_time = $product_detail->end_time;
                    $pricing_detail->start_sale_time = $product_detail->star_time;
                    $pricing_detail->supplier_id = $model->club_id;
                    $pricing_detail->pricing_type = 364;
                    $pricing_detail->if_user = 649;
                    $pricing_detail->f_check = 2;
                    $pricing_detail->no = 0;
                    $pricing_detail->save();
                    $mall_id = $pricing_detail->set_details_id;

                    // 虚拟商品上架明细表
                    $virtual_set_details = VirtualMallPriceSetDetails::model()->find('id='.$v['id']);
                    if(empty($virtual_set_details)){
                        $virtual_set_details = new VirtualMallPriceSetDetails;
                        $virtual_set_details->isNewRecord = true;
                        unset($virtual_set_details->id);
                        $virtual_set_details->set_id = $model->id;
                        $virtual_set_details->set_code = $model->code;
                        $virtual_set_details->set_name = $model->name;
                    }
                    $virtual_set_details->mall_pricing_details_id = $mall_id;
                    $virtual_set_details->pricing_type = 364;
                    $virtual_set_details->product_id = $v['product_id'];
                    $virtual_set_details->product_code = $v['product_code'];
                    $virtual_set_details->product_name = $v['product_name'];
                    $virtual_set_details->Inventory_quantity = $v['Inventory_quantity'];
                    $virtual_set_details->shopping_price = $v['shopping_price'];
                    $virtual_set_details->sale_bean = $v['sale_bean'];
                    $virtual_set_details->star_time = $model->star_time;
                    $virtual_set_details->end_time = $model->end_time;
                    $virtual_set_details->no = 1;
                    $virtual_set_details->save();
                }
            }
            MallPriceSetDetails::model()->deleteAll('set_id='.$mall_price_set->id.' and sale_bean2=-1');
            MallPricingDetails::model()->deleteAll('set_id='.$mall_price_set->id.' and no=-1');
            VirtualMallPriceSetDetails::model()->deleteAll('set_id='.$model->id.' and no=0');
        }
    }