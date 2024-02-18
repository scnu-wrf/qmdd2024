<?php

class ClubServiceGroupController extends BaseController {

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
		$model->group_name=$post['group_name'];
		$model->problem_type=$post['problem_type'];
		$sv=$model->save(); 
        show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }
	
    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }
	
	//添加客服组成员-客服列表
    public function actionCustomer_service_list($keywords = '',$group_id="") {
		$data = array();
        $model = ClubServiceMember::model();
        $criteria = new CDbCriteria;
		$criteria->condition='club_id='.get_session('club_id');
		$criteria->condition.=" and !FIND_IN_SET('".$group_id."',group_id)";
		$criteria->order = 'id DESC';
        parent::_list($model, $criteria, 'customer_service_list', $data);
    }
	
	//添加客服组成员接口
	public function actionAdd_group_member() {
		$group_id=$_POST["group_id"];
		$ids=$_POST["ids"];
        $data=array();
		Yii::app()->db->createCommand("UPDATE gf_club_customer_service_group_member,(select GROUP_CONCAT(g.id) as group_id from gf_club_customer_service_group g,gf_club_customer_service_group_member m  where find_in_set(g.id,m.group_id) and find_in_set(m.id,'{$ids}')) a SET gf_club_customer_service_group_member.group_id=concat_ws(',',a.group_id,'{$group_id}') WHERE find_in_set(id,'{$ids}')")->execute();
        echo CJSON::encode($data);
    }
	
	//删除客服组成员接口
	public function actionDel_group_member() {
		$group_id=$_POST["group_id"];
		$id=$_POST["id"];
		$member=ClubServiceMember::model()->find("id=".$id);
		$groups=explode(",",$member->group_id);
		foreach($groups as $k=>$v){
			if($v==$group_id){
				array_splice($groups, $k, 1);
				break;
			}
		}
		$new_group_id=join(",", $groups);
		ClubServiceMember::model()->updateAll(array("group_id"=>$new_group_id),'id='.$id);
        $data=array();
        echo CJSON::encode($data);
    }

}
