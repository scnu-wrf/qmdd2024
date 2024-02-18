<?php

class ClubFeeDayController extends BaseController {
    
    protected $model = '';

    public function init() {
        // $this->model = substr(__CLASS__, 0, -10);
        $this->model = 'ClubFeeDay';
        parent::init();
    }

    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_like($criteria->condition,'f_name',$keywords,'');
        $criteria->order = 'id';
        // $data = array();
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
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['project_list'] = ProjectList::model()->findAll();
            $this->render('update', $data);
        } else {
            $this->saveData($model,@$_POST[$modelName]);
        }
    }

    function saveData($model,$post) {
        $model->attributes = $post;
        $sv=$model->save();
        show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }

    public function actionDelete($id) {
        parent::_clear($id);
    }
}