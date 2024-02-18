<?php

class MallAttributeTypeController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        
    }


    public function actionIndex() {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1=1 ';
        $criteria->order = 'cat_id DESC' ;//排序条件

         parent::_list($model, $criteria);
    }


    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        parent::_create($model, 'update', $data, get_cookie('_currentUrl_'));
    }


    public function actionUpdate($cat_id) {
        $modelName = $this->model;
        $model = $this->loadModel($cat_id, $modelName);
        $data = array();
        parent::_update($model, 'update', $data, get_cookie('_currentUrl_'));
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        // parent::_clear($id);
        parent::_clear($id,'','cat_id');

    }


}

