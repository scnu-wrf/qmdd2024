<?php

class GfPaySetController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionGfPay($client = 0) {
       set_cookie('_currentUrl_', Yii::app()->request->url);
        $data = array();
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1=1 ';
        
        if ($client>0){
            $criteria->condition.=' AND pay_client='.$client;
        }

        parent::_list($model, $criteria, 'gfPay', $data);

    }


    public function actionChangeSwitch() {
        $modelName = $this->model;
        $model = $modelName::model();
        $id = intval($_POST['id']);

        $state=intval($_POST['state']);
        
        $count = $model->updateByPk($id, array('is_open_user' => $state));
        if ($count > 0) {
            ajax_exit(array('status' => 1, 'msg' => '设置成功'));
        } else {
            ajax_exit(array('status' => 0, 'msg' => '设置失败'));
        }
    }
	

    public function actionChangeName() {
        $modelName = $this->model;
        $model = $modelName::model();
        $id = intval($_POST['id']);
        $dispName=$_POST['dispName'];
        $count = $model->updateByPk($id, array('pay_dispay_name' => $dispName));
        if ($count > 0) {
            ajax_exit(array('status' => 1, 'msg' => '设置成功'));
        } else {
            ajax_exit(array('status' => 0, 'msg' => '设置失败'));
        }
    }
}