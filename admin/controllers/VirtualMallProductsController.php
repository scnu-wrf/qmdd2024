<?php
    class VirtualMallProductsController extends BaseController {

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
            $criteria->condition = get_like($criteria->condition,'product_code,product_name',$keywords,'');
            $criteria->order = '';
            $data = array();
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
            if(!Yii::app()->request->isPostRequest){
                $data['model'] = $model;
                $this->render('update', $data);
            }
            else{
                $this->saveData($model,$_POST[$modelName]);
            }
        }

        function saveData($model,$post){
            $model->attributes = $post;
            // $model->display = get_check_code($_POST['submitType']);
            $sv = $model->save();
            show_status($sv,'操作成功',get_cookie('_currentUrl_'),'操作失败');
        }

        public function actionDelete($id){
            parent::_clear($id);
        }
    }