<?php

    class ClubMembershipFeeController extends BaseController {

        protected $model = '';

        public function init() {
            $this->model = 'ClubMembershipFee';
            parent::init();
        }

        public function actionIndex($keywords = '') {
            set_cookie('_currentUrl_', Yii::app()->request->url);
            $modelName = $this->model;
            $model = $modelName::model();
            $criteria = new CDbCriteria;
            $criteria->condition = '1';
            $criteria->condition=get_like($criteria->condition,'product_code,name',$keywords,'');//get_where
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

        public function actionDelete($id) {
            //ajax_status(1, '删除成功');
            parent::_clear($id);
        }
        
        function saveData($model,$post) {
            $modelName = $this->model;
            $model->attributes = $_POST[$modelName];
            $st=$model->save();
            show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败'); 
        }

    }
