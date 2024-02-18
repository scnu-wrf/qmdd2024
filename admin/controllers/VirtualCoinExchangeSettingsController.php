<?php
    class VirtualCoinExchangeSettingsController extends BaseController {

        protected $model = '';

        public function init() {
            $this->model = substr(__CLASS__, 0, -10);
            parent::init();
        }

        public function actionIndex($keywords=''){
            set_cookie('_currentUrl_',Yii::app()->request->url);
            $modelName = $this->model;
            $model = $modelName::model();
            $criteria = new CDbCriteria;
            $criteria->condition = 'state=721';
            $criteria->order = '';
            $data = array();
            parent::_list($model,$criteria,'index',$data);
        }

        // 审核
        public function actionIndex_exam($keywords='',$state=371){
            set_cookie('_currentUrl_',Yii::app()->request->url);
            $modelName = $this->model;
            $model = $modelName::model();
            $criteria = new CDbCriteria;
            $criteria->condition = 'state='.$state;
            $criteria->order = '';
            $data = array();
            $data['state'] = BaseCode::model()->getReturn('371,372,373');
            parent::_list($model,$criteria,'index_exam',$data);
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
            if(!Yii::app()->request->isPostRequest){
                $data['model'] = $model;
                $this->render('update', $data);
            }
            else{
                $this->saveData($model,$_POST[$modelName]);
            }
        }

        public function actionUpdate_exam($id){
            $modelName = $this->model;
            $model = $this->loadModel($id,$modelName);
            $data = array();
            if(!Yii::app()->request->isPostRequest){
                $data['model'] = $model;
                $this->render('update_exam', $data);
            }
            else{
                $this->saveData($model,$_POST[$modelName]);
            }
        }

        function saveData($model,$post){
            $model->attributes = $post;
            $model->state = get_check_code($_POST['submitType']);
            $sv = $model->save();
            show_status($sv,'操作成功',get_cookie('_currentUrl_'),'操作失败');
        }

        public function actionDelete($id){
            parent::_clear($id);
        }
    }