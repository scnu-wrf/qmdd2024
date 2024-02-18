<?php

class ClubTypeController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }


    public function actionIndex() {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'if_del=510';
        $criteria->order = 'f_ctcode ASC';
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }


    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;

            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }
    function saveData($model,$post) {
        $model->attributes =$post;
        $st=$model->save();
        // show_status($st,'保存成功',get_cookie('_currentUrl_'),'保存失败');
    }


    // 保存‘添加动作’
    public function actionSendInvite() {
        $modelName = $this->model;
        $model = $modelName::model();
        $data = array();
        $f_ctcode = $_POST['f_ctcode'];
        $f_ctname = $_POST['f_ctname'];
        $check_val = $_POST['check_val'];
        $check_val2 = implode(",", $check_val);
        $log = new ClubType;
        $log->isNewRecord = true;
        //unset($log->id);
        //mb_strlen($v->f_ctcode) > 3
        $log->f_ctcode = $f_ctcode;
        $log->f_ctname = $f_ctname;
        $log->member_attribute = $check_val2;
        if (mb_strlen($f_ctcode) > 3){
            $log->f_level = 2;
        }else{
            $log->f_level = 1;
        }

        $log->save();
        ajax_status(1, '保存成功', get_cookie('_currentUrl_'));
    }


    // 保存‘编辑动作’
    public function actionSaveEdit() {
        $modelName = $this->model;
        $model = $modelName::model();

        $data = array();
        $id = $_GET['id'];
        $f_ctcode = $_GET['f_ctcode'];
        $f_ctname = $_GET['f_ctname'];
        $check_val_edit = $_GET['check_val_edit'];
        $check_val_edit2 = implode(",", $check_val_edit);
        $club_type1 = ClubType::model()->find('id='.$id);
        $club_type1->f_ctcode = $f_ctcode;
        $club_type1->f_ctname = $f_ctname;
        $club_type1->member_attribute = $check_val_edit2;
        if (mb_strlen($f_ctcode) > 3){
            $club_type1->f_level = 2;
        }else{
            $club_type1->f_level = 1;
        }
        if($sv=1){
            $sv=$club_type1->save();
        }
        ajax_status(1, '保存成功', get_cookie('_currentUrl_'));

    }

    public function actionDelete($id) {
        parent::_delete($id);
    }

}
