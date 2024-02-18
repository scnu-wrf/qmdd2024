<?php

class SafePriceSetController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
	
	public function actionIndex($keywords = '',$state='',$type='',$userstate='',$supplier='',$star_time='',$end_time='',$pricing='') {
		set_cookie('_currentUrl_', Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		$criteria->condition='';//get_where_club_project('supplier_id','');
		$criteria->condition.= '  down_up>=0 ';
		$criteria->condition=get_where($criteria->condition,!empty($state),' f_check',$state,'');
		$criteria->condition=get_where($criteria->condition,!empty($userstate),' if_user_state',$userstate,'');
		$criteria->condition=get_where($criteria->condition,!empty($type),' pricing_type',$type,'');
		$criteria->condition=get_where($criteria->condition,$pricing,' pricing_type',$pricing,'');
		$criteria->condition=get_like($criteria->condition,'event_code,event_title',$keywords,'');
		$criteria->condition=get_like($criteria->condition,'supplier_name',$supplier,'');
		//$criteria->condition=get_where($criteria->condition,!empty($supplier_id),'supplier_id',$supplier_id,'');
		$criteria->condition=get_where($criteria->condition,($star_time!=""),'star_time>=',$star_time,'"');
		$criteria->condition=get_where($criteria->condition,($end_time!=""),'end_time<=',$end_time,'"');
		$criteria->order = 'id DESC';
		$data = array();
		$data['base_code'] = BaseCode::model()->getStateType();
		$data['userstate'] = BaseCode::model()->getCode(647);
		$data['product_type'] = BaseCode::model()->getOrderType();
		$data['supplier_id'] = ClubList::model()->findAll();
		parent::_list($model, $criteria, 'index', $data);
    }
	
	public function actionIndex_check($keywords = '',$state='',$userstate='',$supplier='',$star_time='',$end_time='',$pricing='') {
		set_cookie('_currentUrl_', Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		$criteria->condition= 'down_up>=0 ';
		$criteria->condition.= ' and f_check=371';
		$criteria->condition=get_where($criteria->condition,!empty($userstate),' if_user_state',$userstate,'');
		$criteria->condition=get_like($criteria->condition,'event_code,event_title',$keywords,'');
		$criteria->condition=get_like($criteria->condition,'supplier_name',$supplier,'');
		$criteria->condition=get_where($criteria->condition,($star_time!=""),'star_time>=',$star_time,'"');
		$criteria->condition=get_where($criteria->condition,($end_time!=""),'end_time<=',$end_time,'"');
		$criteria->order = 'id DESC';
		$data = array();
		$data['base_code'] = BaseCode::model()->getStateType();
		$data['userstate'] = BaseCode::model()->getCode(647);
		parent::_list($model, $criteria, 'index_check', $data);
    }
	
	public function actionCreate() {
		$modelName = $this->model;
		$model = new $modelName('create');
		$data = array();
		if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			$data['product_list'] =array();
			$this->render('update', $data);
		} else {
			$this-> saveData($model,$_POST[$modelName]);
		}
    }

    public function actionUpdate($id) {
		set_cookie('_updatecurrent_', Yii::app()->request->url);
		$modelName = $this->model;
		$model = $this->loadModel($id, $modelName);
		$data = array();
		if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			//$data['PriceInfo'] =array();
			//$data['PriceInfo'] =MallMemberPriceInfo::model()->find('id='.$model->mall_member_price_id);
			$data['product_list'] =array();
			$data['product_list'] = MallPriceSetDetails::model()->findAll('set_id='.$model->id.' AND flash_sale=0');
			$this->render('update', $data);
		} else {
			$this-> saveData($model,$_POST[$modelName]);
		}
  	}
	
	public function actionUpdate_check($id) {
		set_cookie('_updatecurrent_', Yii::app()->request->url);
		$modelName = $this->model;
		$model = $this->loadModel($id, $modelName);
		$data = array();
		if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			$data['product_list'] =array();
			$data['product_list'] = MallPriceSetDetails::model()->findAll('set_id='.$model->id.' AND flash_sale=0');
			$this->render('update_check', $data);
		} else {
			$model->attributes =$_POST[$modelName];
			$model->f_check =get_check_code($_POST['submitType']);
			$st=$model->save();
			show_status($st,'已审核',$this->createUrl('mallPriceSet/index_check'),'审核失败');
		}
  	}

	function saveData($model,$post) {
		$model->attributes =$post;
		//$model->pricing_type=361;
		$model->f_check =get_check_code($_POST['submitType']);
		$sv=$model->save();
		MallPriceSetDetails::model()->updateAll(array('f_check'=>$model->f_check ),'set_id='.$model->id.' AND flash_sale=1');
		MallPricingDetails::model()->updateAll(array('f_check'=>$model->f_check ),'set_id='.$model->id.' AND flash_sale=1');
		$this->save_mall_price_set_details($model->id,$model->mall_member_price_id,$post['product']);
		$action=$this->createUrl('update', array('id'=>$model->id));
		show_status($sv,'保存成功', $action,'保存失败'); 
	}
	
	 //////////////////////////////// 保存商品/////////////////// 
    public function save_mall_price_set_details($id,$price_id,$product){
		$model= MallPriceSet::model()->find('id='.$id);
		$product_detail=new MallPriceSetDetails();
		$product_detail->updateAll(array('sale_bean2'=>-1,'f_check'=>$model->f_check ),'set_id='.$id.' AND flash_sale=0');//做临时删除标识
		$pricing_detail = new MallPricingDetails();
		$pricing_detail->updateAll(array('no'=>-1 ,'f_check'=>$model->f_check),'set_id='.$id.' AND flash_sale=0');//做临时删除标识
		$pricedata= MallMemberPriceData::model()->findAll('infoid='.$price_id);
		$price_data= MallMemberPriceData::model()->find('infoid='.$price_id);
		$arr=array();
		if (isset($_POST['product'])) { 
			$product_detail = new MallPriceSetDetails();
			$pricing_detail = new MallPricingDetails();
			foreach ($_POST['product'] as $v) {
				if ($v['id']=='null') {
					$product_detail->isNewRecord = true;
					unset($product_detail->id);
				} else{
					$product_detail=MallPriceSetDetails::model()->find('id='.$v['id']);
				}
				$inventory=0;
				$available=0;
				$show_id=0;
				$show_name='';
				if(!empty($price_data) && $price_data->sale_show_id==1134){
					$inventory=0;
					$available=0;
				} else {
					$inventory=$v['Inventory_quantity'];
					$available=$v['available_quantity'];
				}
				$product_detail->set_id = $id;
				$product_detail->product_id = $v['product_id'];
				$product_detail->Inventory_quantity = $inventory;
				$product_detail->available_quantity = $available;
				$product_detail->purchase_price = $v['purchase_price'];
				$product_detail->oem_price = $v['oem_price'];
				$product_detail->sale_price = $v['sale_price'];
				$product_detail->sale_bean = $v['sale_bean'];
				$vp2=0;
				$product_detail->purpose=94;
				$product_detail->shop_purpose=94;
				$product_detail->star_time=$model->star_time;
				$product_detail->end_time=$model->end_time;
				$product_detail->down_time=$model->down_time;
				$product_detail->supplier_id = $model->supplier_id;
				
				$product_detail->sale_price2 = $v['sale_price2'];//$vp2;
				$product_detail->sale_bean2 = 0;//$v['sale_bean2'];
				$product_detail->post_price = $v['post_price'];
				$product_detail->up_price_id = $price_id;
				$product_detail->f_check = $model->f_check;
				$product_detail->save();
				if(!empty($pricedata)) 
				{
					foreach ($pricedata as $p) {
						$ex="  product_id=".$v['product_id'].' and set_details_id='.$product_detail->id;
						$ex.=" and mall_memmber_price_id=".$p->id;
						$pricing_detail=MallPricingDetails::model()->find($ex);
						if (empty($pricing_detail)){
							$pricing_detail = new MallPricingDetails();
							$pricing_detail->isNewRecord = true;
							unset($pricing_detail->id);
						}
						if($p->sale_show_id<>1135){
							$show_id=$p->sale_show_id;
							$show_name=$p->sale_show_name;
						}
						$pricing_detail->set_id=$id;
						$pricing_detail->set_details_id=$product_detail->id;
						$pricing_detail->customer_type=$p->sale_sourcena;
						$pricing_detail->no=0;
						$pricing_detail->flash_sale=0;
						$pricing_detail->product_id=$v['product_id'];
						$pricing_detail->customer_level_id=$p->sale_levela;
						$pricing_detail->level_code=$p->sale_levelcodea;
						$pricing_detail->shopping_beans=round(($p->sale_beana/100)*$v['sale_bean']);
						$pricing_detail->shopping_price=($p->sale_pricea/100)*$v['sale_price'];
						$pricing_detail->oem_price = $v['oem_price'];
						$pricing_detail->sale_price = $v['sale_price'];	
						$pricing_detail->sale_bean = $v['sale_bean'];	

						$pricing_detail->inventory_quantity=$product_detail->Inventory_quantity;	
						$pricing_detail->sale_show_id=$show_id;
						$pricing_detail->sale_show_name=$show_name;
						$pricing_detail->mall_memmber_price_id=$p->id;
						$pricing_detail->sale_max=$p->sale_counta;
						$pricing_detail->discount_price=$p->sale_pricea;
						$pricing_detail->discount_beans=$p->sale_beana;
						$pricing_detail->star_time=$product_detail->star_time;
						$pricing_detail->end_time=$product_detail->end_time;
						$pricing_detail->down_time=$product_detail->down_time;
						$pricing_detail->supplier_id = $model->supplier_id;
						$pricing_detail->f_check = $model->f_check;
						$pricing_detail->save();
					}
				}
			}
		} 
		MallPriceSetDetails::model()->deleteAll('set_id='.$id.' and sale_bean2=-1 AND flash_sale=0');
		MallPricingDetails::model()->deleteAll('set_id='.$id.' and no=-1 AND flash_sale=0');
  	}
	//查看会员折扣价
	public function actionMemberprice($detail_id) {
        $data = array();
        $model = MallPricingDetails::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'set_details_id='.$detail_id;
        $criteria->order = 'level_code ASC';
        parent::_list($model, $criteria, 'memberprice', $data);
    }

	
	//删除
 	public function actionDelete($id) {
		$modelName = $this->model;
		$model = $modelName::model();
		$club=explode(',', $id);
		$count=$model->deleteAll('id in('.$id.')');
		if(!empty($count)) {
			foreach ($club as $d) {
				MallPriceSetDetails::model()->deleteAll('set_id='.$d);
				MallPricingDetails::model()->deleteAll('set_id ='.$d);
			}
			ajax_status(1, '删除成功');
		} else {
			ajax_status(0, '删除失败');
		}
	}
	
	public function actionRefresh($id){
		$modelName = $this->model;
		$model = $this->loadModel($id,$modelName);
		$model->data_sourcer_bz = $model->data_sourcer_bz+1;
		$sv=$model->save();
		show_status($sv,'刷新成功',Yii::app()->request->urlReferrer,'刷新失败');
	}
}
