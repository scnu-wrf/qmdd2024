<?php

class ClubProductsTypeController extends BaseController {
    
    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($keywords = '',$fater_id='') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        // $criteria->condition = get_like($criteria->condition,'f_uname',$keywords,'');
        // $criteria->condition = get_where($criteria->condition,!empty($ftypeid),'t_server_type_id',$ftypeid,'');
        $criteria->order = 'ct_code';
        if(empty($fater_id)){
            $criteria->condition = 'isNull(fater_id)';
        }else{
            $criteria->condition = 'fater_id='.$fater_id;
        }
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
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
        $sv=$model->save();
        show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }

    public function actionDelete($id) {
        $len = explode(',',$id);
        foreach($len as $d){
            parent::_clear($d);
        }
    }

    // public function actionDelete($id) {
    //     ajax_status(1, '删除成功');
    //     parent::_clear($id);
    // }
}


