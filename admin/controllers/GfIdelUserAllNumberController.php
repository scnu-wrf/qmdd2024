<?php

class GfIdelUserAllNumberController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
	public function actionIndex($f_vip = '',$f_vlevel = '',$is_use = '',$keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->condition=get_where($criteria->condition,($f_vip!=''),' f_vip',$f_vip,''); 
		$criteria->condition=get_where($criteria->condition,!empty($f_vlevel),' f_vlevel',$f_vlevel,''); 
		$criteria->condition=get_where($criteria->condition,($is_use!=''),' is_use',$is_use,''); 
        $criteria->condition=get_like($criteria->condition,'account',$keywords,'');
        $criteria->order = 'account';
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
			$this->saveData();
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

    function saveData() {
		if(empty($_POST['all_num_val'])){
			show_status(0,'保存成功', get_cookie('_currentUrl_'),'未显示号码');
		}
		$ss = explode(',',$_POST['all_num_val']);
		$_POST['number_range_start']=$ss[0];
		$_POST['number_range_end']=$ss[count($ss)-1];
		$exist=GfIdelUserAllNumber::model()->findAll("account in (".$_POST['all_num_val'].")");
		if(count($exist)>0){
			show_status(0,'保存成功', get_cookie('_currentUrl_'),'此范围号码已存在');
		}
		$id = $this->add_group();
		$_POST['group_id']=$id;
		$st = $this->save_i();
		show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败');   
    }
	
	function save_i(){
		$number_length=$_POST['number_length'];
		$group_id=$_POST['group_id'];
		$ss = explode(',',$_POST['all_num_val']);
		foreach($ss as $k=>$v){
			$mo = new GfIdelUserAllNumber;
			$mo->isNewRecord;
			unset($mo->id);
			$mo->account=$v;
			$main_number=substr($v,0,4);
			$mo->main_number = $main_number;
			$mo->secondary_number = substr($v,strlen($main_number));
			$mo->number_length = $number_length;
			$mo->group_id = $group_id;
			$m=$mo->insert($mo);
			if(!$m){
				show_status($m,'保存成功', get_cookie('_currentUrl_'),'保存失败');   
			}
		}
		$modelName = new GfIdelUserNumberGroup;
        $model = $this->loadModel($group_id, $modelName);
		$model->total_count=GfIdelUserAllNumber::model()->count('group_id='.$group_id);
		$model->nomal_count=GfIdelUserAllNumber::model()->count('group_id='.$group_id.' and f_vip=0');
        $sn=$model->update($model);
		return 1;
	}
	
	function add_group(){
		$number_range_start=$_POST["number_range_start"];
		$number_range_end=$_POST["number_range_end"];
		$number_length=$_POST["number_length"];
		$exist=GfIdelUserNumberGroup::model()->findAll("number_range_start=".$number_range_start." or number_range_end=".$number_range_end);
		if(count($exist)>0){
			show_status(0,'保存成功', get_cookie('_currentUrl_'),'此范围号码已存在');
		}
		$mo = new GfIdelUserNumberGroup;
		$mo->isNewRecord;
		unset($mo->id);
		$mo->number_length = $number_length;
		$mo->number_range_start = $number_range_start;
		$mo->number_range_end = $number_range_end;
		$mo->create_time = date('Y-m-d');
		$m=$mo->save();
		if(!$m){
			show_status(0,'保存成功', get_cookie('_currentUrl_'),'保存失败');   
		}
		return $mo->id;
	}
	
    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

}
