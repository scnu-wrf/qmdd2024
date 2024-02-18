<?php

class QmddServerTimeController extends BaseController {
    
    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_like($criteria->condition,'timename',$keywords,'');
        $criteria->order = 'timename';
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
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    function saveData($model,$post) {
        $model->attributes = $post;
        $model->timename=$model->start_time.'-'.$model->end_time;
        $sv=$model->save();
        show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }

    public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $count = $model->deleteAll('id in(' . $id . ')');
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }

    public function actionAddForm(){
        $model = new QmddServerTime;
        if(isset($_POST['table_tag']))
        foreach($_POST['table_tag'] as $v){
            $model->isNewRecord = true;
            unset($model->id);
            $model->start_time = $v['start_time'];
            $model->end_time = $v['end_time'];
            $model->timename = $v['start_time'].'-'.$v['end_time'];
            $sv=$model->save();
        }
        show_status($sv,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }
}