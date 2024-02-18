<?php

class ClubListController extends BaseController {

    protected $model = '';
   //删除
    public function actionDelete($id) {
        parent::_delete($id);
    }
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionGetClubAjax($type = '', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition =get_like('1','club_name,club_code',$keywords,''); 
        $criteria->limit = 100;
        $tmp = $model->findAll($criteria);
        $arr = toIoArray($tmp,'id,club_code,club_name,club_type_name');
        if (empty($arr)) {
            ajax_exit(array('error' => 1, 'msg' => '未搜索到数据'));
        }
        ajax_exit(array('error' => 0, 'datas' => $arr));
    }

    ///列表搜索
    public function actionIndex($keywords = '',$club_type='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr = get_where('1',$club_type,' club_type',$club_type,'');
		$criteria->condition = get_like($cr,'club_name,club_code',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionIndex1($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr= 'id='.get_session('club_id');
		$criteria->condition=get_like($cr,'club_name,club_code',$keywords,'');
        $criteria->order = 'id DESC';
        parent::_list($model, $criteria, 'index1');
    }

    // 服务单位-意向入驻审核
    public function actionIndex_service_exam($start_date = '', $end_date = '', $keywords = '', $club_type='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr = get_where('1',$club_type,' club_type',$club_type,'');
        $cr=getDateCondition($cr,$start_date,$end_date,'edit_apply_time');
        $criteria->condition = get_like($cr,'club_name,club_code',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['count1'] = $model->count('edit_state=1');
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        parent::_list($model, $criteria, 'index_service_exam', $data);
    }
    
     

    // 服务单位-意向入驻添加
    public function actionIndex_service( $start_date = '', $end_date = '', $keywords = '',$state=0, $edit_state = '', $date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $st=($state==1) ? '1' : $state;
        $cr=getDateCondition('1',$start_date,$end_date,'uDate');
        $s1='company,apply_name,club_name,club_code';
        $criteria->condition=get_like($cr,$s1,$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        parent::_list($model, $criteria, 'index_service', $data);
    }

  public function actionCreate() {   
       $this-> viewUpdate(0);
   } 
   public function actionUpdate($id) {
        $this-> viewUpdate($id);
    }/*曾老师保留部份，---结束*/
  public function viewUpdate($id=0) {
        $modelName = $this->model;
        $model = ($id==0) ? new $modelName('create') : $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
           $data['qualification_pics'] = explode(',', $model->qualification_pics);
           $this->render('update', $data);
        } else {
           $this-> saveData($model,$_POST[$modelName]);
        }
    }

    // 服务单位详情页
    public function actionCreate_service() {
        $this->serviceUpdate(0);
    }

    public function actionUpdate_service($id) {
        $this->serviceUpdate($id);
    }

  public function serviceUpdate($id=0) {
        $modelName = $this->model;
        $model = ($id==0) ? new $modelName('create') : $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
           $this->render('update_service', $data);
        } else {
           $this-> saveData($model,$_POST[$modelName]);
        }
    }
	function saveData($model,$post) {
        $model->check_save(1);
        $modelName = $this->model;
        $rs=getShenheState($_POST['submitType'],$model->edit_state,$model->state);
        $model->attributes = $_POST[$modelName];
       	$model->state =$rs['state'];
		$model->edit_state =$rs['edit'];
        $model->club_area_code =TRegion::model()->getAreaCode($_POST);
        $st=$model->save();
        if ($st) { // 保存图集
            ClubListPic::model()->savePics( $model->id, $model->club_list_pic);
            QmddAdministrators::model()->checkClubUser($model);
            ClubProject::model()->saveProject( $model);
	    }
	    show_status($st,'保存成功',Yii::app()->request->urlReferrer,'保存失败');
    }

	 // 帐号验证
     public function actionExist($name=0) {
        $club_name=ClubList::model()->find('club_name="'.$name.'" ');
        if(!empty($club_name)) {
                ajax_status(0, '该名称已被注册');
         }
     }

 

    // 注销单位列表
    public function actionIndex_can($keywords='',$unit_state='',$start_date = '', $end_date = '', $club_type='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
        $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        $criteria = new CDbCriteria;
        $cr = get_where_club_project('id','').'  and club_type='.$club_type;
        $criteria->order = 'lock_date DESC';
        $cr=get_where($cr,$unit_state,'unit_state',$unit_state,'');
        $cr=getDateCondition($cr,$start_date,$end_date,'lock_date');
        $criteria->condition=get_like($cr,'club_code,club_name',$keywords,'');
        $data = array();
        $data['unit_state'] = BaseCode::model()->getCode(505);
        $data['startDate']=$start_date;
        $data['endDate']=$end_date;
        parent::_list($model, $criteria, 'index_can', $data);
    }

    // 单位账号处理
    public function actionUpdata_club(){
        $modelName = $this->model;
        $model = $modelName::model();
        if(isset($_POST['deal_id'])){
            $sv=$model->updateByPk($_POST['deal_id'],array('unit_state'=>$_POST['user_state'],'lock_reason'=>$_POST['lock_reason'],'lock_date'=>date('Y-m-d H:i:s'),'lock_adminid'=>get_session('admin_id'),'reasons_adminname'=>get_session('admin_name')));
            if($_POST['user_state']==649){
                QmddAdministrators::model()->deleteAll('club_id='.$_POST['deal_id']);
                ClubProject::model()->updateAll(array('if_del' => 509,'unit_state' => 649), 'club_id='.$_POST['deal_id']);
            }
        }
        show_status($sv,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }

	// 帐号验证
    public function actionValidate($gf_account=0) {
        $user=userlist::model()->find('GF_ACCOUNT="'.$gf_account.'"');
        if(!empty($user)) {
            if($user->passed==2) {
                ajax_status_gamesign(1, $user->GF_ID);
            } else {
                ajax_status(0, '帐号未实名');
            }
         } else {
             ajax_status(0, '帐号不存在');
         }
     }

    public function actionIndex_about_me($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr = 'about_me<>"" and !isnull(about_me) ';
		$criteria->condition=get_like($cr,'club_name,club_code',$keywords,'');
        $criteria->order = 'uDate DESC';
        parent::_list($model, $criteria, 'index_about_me');
    }

    public function actionAbout_me($id=0) {
        $url = get_cookie('_currentUrl_');
        if($id==0){
            $id=get_session('club_id');
            $url = Yii::app()->request->urlReferrer;
        }
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
			$basepath = BasePath::model()->getPath(216);
            $model->about_me_temp=get_html($basepath->F_WWWPATH.$model->about_me, $basepath);
            $data['model'] = $model;
            $this->render('about_me', $data);
        } else {
			$this->saveAboutData($model,$_POST,$url);
        }
    }
	function saveAboutData($model,$post,$url='') {
        $model->check_save(1);
        $modelName = $this->model;
        $model->attributes = $post[$modelName];
        $model->state = $model->state;
        $model->edit_state = $model->edit_state;
        $st=$model->save();
	    show_status($st,'保存成功',Yii::app()->request->urlReferrer,'保存失败');
    }
}



