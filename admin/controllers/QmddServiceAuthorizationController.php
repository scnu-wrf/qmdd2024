<?php
    class QmddServiceAuthorizationController extends BaseController {

        protected $model = '';

        public function init() {
            $this->model = substr(__CLASS__,0,-10);
            parent::init();
        }

        // 动动约签到授权
        public function actionIndex_move($keywords='',$back_url='') {
            set_cookie('_currentUrl_', Yii::app()->request->url);
            $modelName = $this->model;
            $model = $modelName::model();
            $criteria = new CDbCriteria;
            $criteria->condition = get_where_club_project('club_id');
            // $criteria->condition = get_like($criteria->condition,'service_type_name,',$keywords,'');
            if(!empty($keywords)){
                $criteria->condition .= ' and (service_type_name like "%'.$keywords.'%" or exists(select gu.GF_ID,gu.GF_ACCOUNT from gf_user_1 gu where gu.passed=372 and gu.GF_ID in(t.authorized_person_id) and (gu.GF_NAME like "%'.$keywords.'%" or gu.GF_ACCOUNT like "%'.$keywords.'%")))';
            }
            $data = array();
            parent::_list($model, $criteria, 'index_move', $data);
        }

        // 动动约签到授权
        public function actionCreate_move(){
            $modelName = $this->model;
            $model = new $modelName('create');
            if(!Yii::app()->request->isPostRequest){
                $data['model'] = $model;
                $this->render('update_move',$data);
            }
            else{
                $this->saveData($model,$_POST[$modelName]);
            }
        }

        // 动动约签到授权
        public function actionUpdate_move($id){
            $modelName = $this->model;
            $model = $this->loadModel($id, $modelName);
            $data = array();
            if(!Yii::app()->request->isPostRequest){
                $data['model'] = $model;
                $this->render('update_move',$data);
            }
            else{
                $this->saveData($model,$_POST[$modelName]);
            }
        }

        function saveData($model,$post){
            $model->attributes = $post;
            $sv = $model->save();
            show_status($sv,'保存成功',get_cookie('_currentUrl_'),'保存失败');
        }

        public function actionDelete($id) {
            //ajax_status(1, '删除成功');
            parent::_clear($id);
        }

        public function actionGetChangeQuery($club_id,$service_type){
            $list = QmddServiceAuthorization::model()->find('club_id='.$club_id.' and service_type='.$service_type);
            echo (empty($list)) ? 0 : 1;
        }
    }