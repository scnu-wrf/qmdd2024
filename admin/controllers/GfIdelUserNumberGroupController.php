<?php

class GfIdelUserNumberGroupController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
	public function actionIndex($is_category = '',$keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		if(!empty($keywords)){
			$criteria->condition = $keywords.' BETWEEN number_range_start AND number_range_end';
		}
		$criteria->condition=get_where($criteria->condition,!empty($is_category),' is_category',$is_category,''); 
        $criteria->order = 'number_length,number_range_start';
		$data = array();
        parent::_list($model, $criteria, 'index', $data);
    }
	public function actionIndex_normal($is_category = '',$keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->join = "join (select count(gf_idel_user_all_number.id) as count,gf_idel_user_all_number.group_id from gf_idel_user_all_number where gf_idel_user_all_number.f_vip=0 group by group_id) as a on t.id=a.group_id";
        $criteria->condition ="a.count>0";
		if(!empty($keywords)){
			$criteria->condition = $keywords.' BETWEEN number_range_start AND number_range_end';
		}
		$criteria->condition=get_where($criteria->condition,!empty($is_category),' is_category',$is_category,'');
        $criteria->order = 'number_length,number_range_start';
		$data = array();
        parent::_list($model, $criteria, 'index_normal', $data);
    }
	public function actionIndex_vip($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->join = "join (select count(gf_idel_user_all_number.id) as count,gf_idel_user_all_number.group_id from gf_idel_user_all_number where gf_idel_user_all_number.f_vip=1 group by group_id) as a on t.id=a.group_id";
        $criteria->condition ="a.count>0";
		if(!empty($keywords)){
			$criteria->condition .= ' and '. $keywords.' BETWEEN number_range_start AND number_range_end';
		}
        $criteria->order = 'number_length,number_range_start';
		$data = array();
        parent::_list($model, $criteria, 'index_vip', $data);
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
	//详情
    public function actionDetail($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('detail', $data);
        } else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }
    public function actionDetail_normal($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('detail_normal', $data);
        } else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }
    public function actionDetail_vip($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('detail_vip', $data);
        } else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }
	//分类
    public function actionSorting($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('sorting', $data);
        } else{
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
		// show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败');   
    }
	
	public function actionSaveSorting() {
		$match_arr=json_decode($_POST["match_arr"],true);
		foreach($match_arr as $k=>$v){
			foreach($v["match_number"] as $m=>$n){
				$modelName = new GfIdelUserAllNumber;
				$model = $this->loadModel($n["id"], $modelName);
				$model->f_vlevel=$v["level_id"];
				$model->mode_id=$v["mode_id"];
				$model->f_vip=1;
				$sn=$model->update($model);
			}
		}
		$this->actionIs_category($_POST["group_id"]);
		show_status($sn,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }
	
	public function actionIs_category($group_id,$ret=0) {
		$modelName = new GfIdelUserNumberGroup;
        $model = $this->loadModel($group_id, $modelName);
		$model->is_category=649;
		$model->nomal_count=GfIdelUserAllNumber::model()->count('group_id='.$group_id.' and f_vip=0');
		$model->vip_count=GfIdelUserAllNumber::model()->count('group_id='.$group_id.' and f_vip=1');
        $sn=$model->update($model);
		if($ret){
			show_status($sn,'保存成功', get_cookie('_currentUrl_'),'保存失败');
		}else{
			return 1;
		}
    }
	
    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

}
