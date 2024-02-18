<?php

class GfIdelUserController extends BaseController {

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
        $criteria->condition='f_vip=0';
        $criteria->condition=get_like($criteria->condition,'non_account',$keywords,'');
        $criteria->order = 'non_account';
		$data = array();
        parent::_list($model, $criteria, 'index', $data);
    }
	public function actionIndex_vip($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition='f_vip=1';
        $criteria->condition=get_like($criteria->condition,'non_account',$keywords,'');
        $criteria->order = 'non_account';
		$data = array();
        parent::_list($model, $criteria, 'index_vip', $data);
    }
	
    public function actionUpdate($id) {
        $ids = explode(',',$id);
        foreach($ids as $d){
            $modelName = $this->model;
            $model = $this->loadModel($d, $modelName);
            $model->f_vip=1;
            $sn=$model->save();
        }
        show_status($sn,'保留成功',Yii::app()->request->urlReferrer,'失败');
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
       $modelName = $this->model;
	//   show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败');   
    }
	
    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

}
