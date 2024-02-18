<?php

    class ClubMembershipFeeScaleInfoController extends BaseController {

        protected $model = '';

        public function init() {
            $this->model = 'ClubMembershipFeeScaleInfo';
            parent::init();
        }

        public function actionIndex($keywords = '') {
            set_cookie('_currentUrl_', Yii::app()->request->url);
            $modelName = $this->model;
            $model = $modelName::model();
            $criteria = new CDbCriteria;
            $criteria->condition = '1';
            $criteria->condition=get_like($criteria->condition,'code,name',$keywords,'');//get_where
            $criteria->order = 'id';
            parent::_list($model, $criteria);
        }

        public function actionCreate() {
            $modelName = $this->model;
            $model = new $modelName('create');
            $data = array();
            if (!Yii::app()->request->isPostRequest) {
                $data['model'] = $model;
                $this->render('update', $data);
            } else {
                $this->saveData($model,$_POST[$modelName]);
            }
        }

        public function actionUpdate($id) {
            $modelName = $this->model;
            $model = $this->loadModel($id, $modelName);
            $data = array();
            if (!Yii::app()->request->isPostRequest) {
                $data = array();
                $data['model'] = $model;
                $this->render('update', $data);
            } else{
                $this->saveData($model,$_POST[$modelName]);
            }
        }

        public function actionUpdate_list($keywords='',$id=0,$club_id=0,$type=0) {
            $data = array();
            $modelName = $this->model;
            $model = ClubMembershipFeeDataList::model();
            $criteria = new CDbCriteria;
            $criteria->condition = 'scale_info_id='.$id;
            $criteria->condition=get_like($criteria->condition,'gf_id,gf_name,levelname',$keywords,'');//get_where
            $criteria->order = 'id';
            parent::_list($model, $criteria, 'update_list', $data, 30);
        }

        // public function actionDelete($id) {
        //     //ajax_status(1, '删除成功');
        //     parent::_clear($id);
        // }
        public function actionDelete($id) {
            $modelName = $this->model;
            $model = $modelName::model();
            $service=explode(',', $id);
            $count=0;
            foreach ($service as $d) {
                $model->deleteAll('id='.$d);
                ClubMembershipFeeData::model()->deleteAll('scale_info_id='.$d);
                ClubMembershipScaleList::model()->deleteAll('scale_info_id='.$d);
                $count++;
            }
            if ($count > 0) {
                ajax_status(1, '删除成功');
            } else {
                ajax_status(0, '删除失败');
            }
        }
        
        public function actionGetType(){
            $id = $_POST['id'];
            $cType = ClubType::model()->find('id='.$id);
            $f_code = ClubType::model()->findAll('left(f_ctcode,3)="'.$cType->f_ctcode.'" and length(f_ctcode)>3');
            $ar = array();
            if(!empty($f_code))foreach($f_code as $key => $val){
                $ar[$key]['id'] = $val->id;
                $ar[$key]['f_ctcode'] = $val->f_ctcode;
                $ar[$key]['f_ctname'] = $val->f_ctname;
            }
            echo CJSON::encode($ar);
        }

        function saveData($model,$post) {
            $model->attributes = $post;
            $st=$model->save();
            $this->save_fee_data($model,$post);
            show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败');
        }

        public function save_fee_data($model,$post){
            $model->attributes = $post;
            if(!empty($_POST['scale_info'])){
                $fee_data = new ClubMembershipFeeData();
                $fee_data->updateAll(array('is_tmp'=>-1),'scale_info_id='.$model->id);
           

                foreach($_POST['scale_info'] as $v){
                    if($v['id_null']=='null'){
                        // if($v['scale_amount']==''){
                        //     continue;
                        // }
                        $fee_data = new ClubMembershipFeeData();
                        $fee_data->isNewRecord = true;
                        unset($fee_data->id);
                    }
                    else{
                        $fee_data = ClubMembershipFeeData::model()->find('id='.$v['id_null']);
                    }
                    $fee_data->scale_info_id = $model->id;
                    // $fee_data->scale_list_Id = $scale_list->id;
                    $fee_data->scale_code = $model->fee_code;
                    $fee_data->gf_club_id = $model->club_id;
                    $fee_data->feeid = $model->feeid;
                    $fee_data->code = $model->code;
                    $fee_data->name = $model->name;
                    $fee_data->is_tmp = 0;
                    $fee_data->product_id = $model->product_id;
                    $fee_data->product_code = $model->product_code;
                    $fee_data->product_name = $model->product_name;
                    $fee_data->levetypeid = $model->levetypeid;
                    $fee_data->levetypename = $model->levetypename;
                    $fee_data->member_type = $v['member_type'];
                    // $fee_data->member_name = $model->lowerleveltypename;
                    $fee_data->entry_way = $v['entry_way'];
                    $fee_data->levelid = $v['levelid'];
                    $fee_data->levelname = $v['card_name'];
                    $fee_data->json_attr = '元';
                    $fee_data->scale_amount = $v['scale_amount'];
                    $fee_data->date_start_scale = $model->date_start_scale;
                    $fee_data->date_end_scale = $model->date_end_scale;
                    $fee_data->save();
                }
                ClubMembershipFeeData::model()->deleteAll('scale_info_id='.$model->id.' and is_tmp=-1');
                // ClubMembershipFeeDataList::model()->deleteAll('scale_info_id='.$model->id.' and f_tmpmark=-1');
            }
        }
    }
