<?php

class MemberCardController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->order = 'card_code';
        $criteria->condition=get_like('1','card_name,card_code',$keywords,''); 
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('update');
        $data = array();
        parent::_create($model, 'update', $data, get_cookie('_currentUrl_'));
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        parent::_create($model, 'update', $data, get_cookie('_currentUrl_'));
    }

	
	//删除
  public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
		$count=$model->deleteAll('f_id in('.$id.')');
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }

   
}
