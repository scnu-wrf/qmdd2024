<?php
    class GfSiteCreditController extends BaseController{
        protected $model = '';

        public function init() {
            $this->model = substr(__CLASS__, 0, -10);
            parent::init();
        }

        // 场馆积分设置
        public function actionIndex() {
            set_cookie('_currentUrl_', Yii::app()->request->url);
            $modelName = $this->model;
            $model = $modelName::model();
            $criteria = new CDbCriteria;
            $criteria->condition = '1=1';
            $criteria->order = 'id';
            $data = array();
            parent::_list($model, $criteria, 'index', $data);
        }

        public function actionCreate(){
            $modelName = $this->model;
            $model = new $modelName('create');
            $data = array();
            if(!Yii::app()->request->isPostRequest){
                $data['model'] = $model;
                $this->render('update',$data);
            }
            else{
                $this->saveData($model,$_POST[$modelName]);
            }
        }

        public function actionUpdate($id){
            $modelName = $this->model;
            $model = $this->loadModel($id, $modelName);
            $data = array();
            if(!Yii::app()->request->isPostRequest){
                $data['model'] = $model;
                $this->render('update',$data);
            }
            else{
                $this->saveData($model,$_POST[$modelName]);
            }
        }

        function saveData($model,$post) {
            $model->attributes = $post;
            $st=$model->save();
            show_status($st,'保存成功',get_cookie('_currentUrl_'),'保存失败');
        }

        public function actionDelete($id) {
            // parent::_clear($id);
            $modelName = $this->model;
            $model = $modelName::model();
            $count = 0;
            if($id!='id'){
                $count = $model->deleteAll('id in (' . $id . ')');
            }
            show_status($count,'删除成功',get_cookie('_currentUrl_'),'删除失败');
        }
    }