<?php 
    class GiftTypeController extends BaseController {

        protected $model = '';

        public function init() {
            $this->model = substr(__CLASS__, 0, -10);
            parent::init();
        }

        public function actionIndex($keywords='',$is_use=649,$interact=''){
            set_cookie('_currentUrl_',Yii::app()->request->url);
            $modelName = $this->model;
            $model = $modelName::model();
            $criteria = new CDbCriteria;
            $criteria->condition = 'is_use='.$is_use;
            $criteria->condition = get_where($criteria->condition,!empty($interact),'interact_type',$interact,'');
            $criteria->condition = get_like($criteria->condition,'code,name',$keywords,'');
            $criteria->order = 'code';
            $data = array();
            $data['is_use'] = BaseCode::model()->getCode(647);
            $data['interact'] = BaseCode::model()->getCode(1393);
            parent::_list($model,$criteria,'index',$data);
        }

        public function actionCreate(){
            $modelName = $this->model;
            $model = new $modelName('create');
            $data = array();
            if(!Yii::app()->request->isPostRequest){
                $data['model'] = $model;
                $this->render('update',$data);
            } else{
                $this->saveData($model,$_POST[$modelName]);
            }
        }

        public function actionUpdate($id){
            $modelName = $this->model;
            $model = $this->loadModel($id,$modelName);
            $data = array();
            if(!Yii::app()->request->isPostRequest){
                $data['model'] = $model;
                $this->render('update',$data);
            } else{
                $this->saveData($model,$_POST[$modelName]);
            }
        }

        function saveData($model,$post){
            $model->attributes = $post;
            $sv = $model->save();
            show_status($sv,'保存成功',get_cookie('_currentUrl_'),'保存失败');
        }

        public function actionDelete($id){
            parent::_clear($id);
        }
    }