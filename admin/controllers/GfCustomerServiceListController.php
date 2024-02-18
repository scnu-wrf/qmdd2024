<?php

class GfCustomerServiceListController extends BaseController {

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
        $criteria->condition="club_id=".get_session("club_id");
		$criteria->order="id desc";
		$data = array();
        parent::_list($model, $criteria, 'index', $data);
    }
	
    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('update', $data);
        } else{
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

    public function actionCancel($id,$al){
        $ids = explode(',',$id);
        foreach($ids as $d){
            $modelName = $this->model;
            $model = $this->loadModel($d, $modelName);
            $model->f_vip=0;
            $sn=$model->save();
        }
        show_status($sn,$al,Yii::app()->request->urlReferrer,'失败');
    }

    function saveData($model,$post) {
		$model->attributes =$post;
		$sv=$model->save(); 
        show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }
	
    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }
	
	//历史记录
    public function actionCustomer_servic_chat($message_id="") {
		$data = array();
        $model = GfCustomerServiceMessage::model();
        $criteria = new CDbCriteria;
		$criteria->condition='message_id='.$message_id.' and m_type<>1000';
		// $criteria->order = 'id DESC';
        parent::_list($model, $criteria, 'customer_servic_chat', $data);
    }

}
