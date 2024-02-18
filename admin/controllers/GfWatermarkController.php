<?php

class GfWatermarkController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		// $criteria->condition=get_where_club_project('club_id','');
		$criteria->condition=get_like($criteria->condition,'w_title',$keywords,'');
        $criteria->order = 'id DESC';
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
        if (!Yii::app()->request->isPostRequest) {
            
        }
        parent::_update($model, 'update', $data, get_cookie('_currentUrl_'));
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

}
