<?php

class MallLogisticController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = 'MallLogistic';
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
        if ($keywords !== '') {
            $criteria->condition.=' AND (f_name like "%' . $keywords . '%" OR f_code like "%' . $keywords . '%" OR f_url like "%' . $keywords . '%")';
        }                                                                  
        $criteria->order = 'f_id ASC';
        parent::_list($model, $criteria);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        parent::_create($model, 'create', $data, get_cookie('_currentUrl_'));
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        parent::_update($model, 'update', $data, get_cookie('_currentUrl_'));
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id,'','f_id');
    }

}
