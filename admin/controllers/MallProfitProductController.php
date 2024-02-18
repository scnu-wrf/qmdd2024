<?php

    class MallProfitProductController extends BaseController {
        protected $model = '';

        public function init() {
            $this->model = 'MallProfitProduct';
            parent::init();
        }

        public function actionIndex($keywords = '') {
            set_cookie('_currentUrl_', Yii::app()->request->url);
            $modelName = $this->model;
            $model = $modelName::model();
            $criteria = new CDbCriteria;
            $criteria->limit = '5';
            $criteria->condition=get_like($criteria->condition,'product_code,product_name',$keywords,'');
            $criteria->order ='id DESC';
            $data = array();
            parent::_list($model, $criteria, 'index');
        }

       
    }