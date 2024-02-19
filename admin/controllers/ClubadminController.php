<?php

class ClubadminController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '',$lang_type='0',$club_id=-1) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        if ($club_id<0) $club_id=get_session('club_id'); 
        $w1='lang_type='.$lang_type.(($lang_type=='0') ? '' : " and club_id=".$club_id); 
        $w1.=" and admin_gfaccount<>'0' ";
        $criteria->condition=get_like($w1,'admin_gfaccount,admin_gfnick,club_name',$keywords,'');//get_where
        $criteria->order = 'id DESC';
        parent::_list($model, $criteria);
    }
    //弃用
    public function actionCreate() {
        $modelName = $this->model;
        $model = new Clubadmin;
        $model->password='123456';
        $model->pay_pass='123456';
        if (!Yii::app()->request->isPostRequest) {
            $roles = role::model()->getParentAndChildren();
            $data = array();
            $data['roles']=$roles;
            $data['isNew']=true;

            $data['model'] = $model;
            $this->render('update', $data);
        }else{
            $post=array(
                'admin_gfaccount'=>$_REQUEST['admin_gfaccount'],
                'admin_gfnick'=>$_REQUEST['admin_gfnick'],
                'club_name'=>$_REQUEST['club_name'],
                'pay_pass'=>$_REQUEST['pay_pass'],
                'password'=>$_REQUEST['password'],
            );
            if(isset($_REQUEST['f_id'])){
                $post['admin_level'] = $_REQUEST['f_id'];
            }
            $this->saveData($model,$post);
        }
    }
 
    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $roles = role::model()->getParentAndChildren();
            $data = array();
            $data['roles']=$roles;
            $data['model'] = $model;
            $data['modelName']=$modelName;
            //$data['model']->admin_level=explode(',',$data['model']->admin_level);
            //$data['project_list'] = ClubadminProject::model()->findAll('qmdd_admin_id='.$model->id);
            $this->render('update', $data);
        } else {
            //
            $post=array(
                'admin_gfaccount'=>$_REQUEST['admin_gfaccount'],
            );
            if(isset($_REQUEST['f_id'])){
                $post['admin_level'] = $_REQUEST['f_id'];
            }
            $this->saveData($model,$post);
        }
    }
	
	function saveData($model,$post,$password='') {
        //查重
        if (empty($model->id)){
            $modelName = $this->model;
            $tmp1=$modelName::model()->find('admin_level='.$post['admin_level']." and admin_gfaccount='".$post['admin_gfaccount']."'");
            if (!empty($tmp1)){
                //报错
                show_status(0,'','','已有账号为:'.$post['admin_gfaccount'].'的授权用户,请修改已有角色的权限,无法重复添加');
                return;
                //$model=$tmp1;
            }
        }
        //put_msg('查重结束');
        //put_msg('赋值开始');
        $model->attributes =$post;
        //$model->admin_level=gf_implode(',',$post['admin_level']);
        //put_msg('赋值结束');
        // if($post['password']!=$password){
        //     $model->ec_salt = rand(1,9999);
        //     $model->club_code = empty($model->club_code) ? get_session('club_code') : $model->club_code;
        //     $acc = ($model->club_code==$model->admin_gfaccount) ? $model->club_code : $model->club_code.'#'.$model->admin_gfaccount;
        //     $p = md5(trim($acc).$model->password);
        //     $model->password = pass_md5($model->ec_salt,$p);
        // }
        $Role = new Role;
        //put_msg('rolename赋值开始');
        $model->role_name=$Role->RoleName($model->admin_level);
        //put_msg('rolename赋值结束');
        //put_msg('save开始');
        //put_msg($model->attributes);
        $sv=$model->save();
        //put_msg($model->getErrors());
        //put_msg('save结束');
        //put_msg('delete开始');
        if($model->id)
            ClubadminProject::model()->deleteAll('qmdd_admin_id='.$model->id); 
        //put_msg('delete结束');
        //put_msg('savelist开始');
        //$this->save_project_list($model->id,$post['project_list']);
        //put_msg('savelist结束');
        show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败.');
    }
	
	public  function save_project_list($id,$project_list){       
    //删除原有项目
    //ClubadminProject::model()->deleteAll('qmdd_admin_id='.$id);	
    if(!empty($project_list)){
        ClubadminProject::model()->deleteAll('qmdd_admin_id='.$id);   
    
        $model2 = new ClubadminProject();
        $club_list_pic = array();
        $club_list_pic = explode(',', $project_list);
        $club_list_pic = array_unique($club_list_pic);
        foreach ($club_list_pic as $v) {
            $model2->isNewRecord = true;
            unset($model2->id);
            $model2->qmdd_admin_id = $id;
            $model2->project_id = $v;
            $model2->save();
        }
    }
  }
 

    function actionresetPassword($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $model->ec_salt =rand(1000,9999);
        $pass=rand(100000,999999);
        $model->password=pass_md5( $model->ec_salt,$pass );
        system_message($model->admin_gfid,"账号：".substr($model->admin_gfaccount,1,4).'XXXX,后台登录密码：'.$pass);
        $model->save();
         ajax_status(1, '密码设置成功', get_cookie('_currentUrl_'));   

//        show_status($model->save(), '密码设置成功',get_cookie('_currentUrl_'),'密码设置失败');
    }
	
	public function actionAccountsecurity($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
		if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('accountsecurity', $data);
        } else {
		    $this-> saveData($model,$_POST[$modelName]);
        }
    }

    // 修改密码
    public function actionChange_password($id=0) {
        if($id==0){
            $id=get_session('admin_id');
        }
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('change_password', $data);
        } else {
		    $this->saveChangeData($model,$_POST[$modelName]);
        }
    }
    // 修改密码
	function saveChangeData($model,$post) {
        $model->attributes =$post;
        $model->ec_salt = rand(1,9999);
        $acc = ($model->lang_type==1) ? $model->club_code.'#'.$model->admin_gfaccount: $model->club_code ;
        $p = md5(trim($acc).$model->password);
        $model->password = pass_md5($model->ec_salt,$p);
        $sv=$model->save();
        show_status($sv,'保存成功', Yii::app()->request->urlReferrer,'保存失败.');
    }
	// 验证密码是否正确
    public function actionVerifyPassword($id=0,$password=0) {
        if($id>0)$model=Clubadmin::model()->find('id='.$id);
        if(!empty($model)){
            $ec_salt=$model->ec_salt;
            $acc = ($model->lang_type==1) ? $model->club_code.'#'.$model->admin_gfaccount : $model->club_code;
            $p = md5(trim($acc).$password);
            $pass = pass_md5($ec_salt,$p);
            if($pass!=$model->password){
                ajax_status(0, '密码错误');
            }
        }
    }

    public function actionStatus($id, $status = 0) {
        parent::_status($id, $status);
    }

    public function actionDelete($id) {
       parent::_clear($id);
    }
	

}
