<?php

class ServicerCertificateController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }


    public function actionIndex($fater_id='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'if_del=510';
        $criteria->order = 'f_code';
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionAddForm(){
        if($_POST['change']=='create'){
            $model = new ServicerCertificate;
            $model->isNewRecord = true;
            unset($model->id);
        }else{
            $model = ServicerCertificate::model()->find('id='.$_POST['data_id']);
        }
        $model->f_code=$_POST['f_code'];
        if(empty($_POST['fater_id'])){
            $model->f_name=$_POST['f_name'];
        }else{
            $model->f_type_name=$_POST['f_type_name'];
            $model->fater_id=$_POST['fater_id'];
            $model->F_COL1=$_POST['F_COL1'];
            $model->F_COL3=$_POST['F_COL3'];
        }
        $sv=$model->save();
        // $sv=0;
        show_status($sv,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
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

    function saveData($model,$post) {
        $model->attributes =$post;
         $st=$model->save();
         show_status($st,'保存成功',get_cookie('_currentUrl_'),'保存失败');
    }

    public function actionDelete($id) {
        parent::_delete($id);
    }


}
