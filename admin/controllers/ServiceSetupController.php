<?php

    class ServiceSetupController extends BaseController {

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
            $w1='lang_type='.$lang_type.(($lang_type=='0') ? '' : ' and club_id='.$club_id);
            $criteria->condition=get_where_club_project('club_id','');
            $criteria->condition=get_like($w1,'admin_gfaccount,admin_gfnick',$keywords,'');//get_where
            // $criteria->group='t.club_id='.get_session('club_id');
            $criteria->order = 'id DESC';
            $data = array();
			parent::_list($model, $criteria, 'index', $data);
        }

        public function actionCreate() {
            $modelName = $this->model;
            $model = new $modelName('create');
            $data = array();
            if (!Yii::app()->request->isPostRequest) {
                $data['model'] = $model;
                $this->render('update', $data);
            }else{
                $this-> saveData($model,$_POST[$modelName]);
            }
        }
    
        public function actionUpdate($id) {
            $modelName = $this->model;
            $model = $this->loadModel($id, $modelName);
            $data = array();
            if (!Yii::app()->request->isPostRequest) {
                $data['model'] = $model;
                $data['model']->admin_level=explode(',',$data['model']->admin_level);
                $data['project_list'] = ClubadminProject::model()->findAll('qmdd_admin_id='.$model->id);
                $this->render('update', $data);
            } else {
                $this-> saveData($model,$_POST[$modelName]);
            }
        }

        public function actionCustomer_service_index($keywords = '') {
            set_cookie('_currentUrl_', Yii::app()->request->url);
            $modelName = $this->model;
            $model = $modelName::model();
            $criteria = new CDbCriteria;
			$w1 = get_where_club_project('club_id','');
            $w1.=' and find_in_set(admin_level,266)';
            $criteria->condition=get_like($w1,'admin_gfaccount,admin_gfnick',$keywords,'');
            $criteria->order = 'id DESC';
            $data = array();
			parent::_list($model, $criteria, 'customer_service_index', $data);
        }

        public function actionCustomer_service_create() {
            $modelName = "ClubServiceMember";
            $model = new $modelName('create');
            $data = array();
            if (!Yii::app()->request->isPostRequest) {
                $data['model'] = $model;
                $this->render('customer_service_update', $data);
            }else{
                $this-> saveData($model,$_POST[$modelName]);
            }
        }
    
        public function actionCustomer_service_update($id) {
            $modelName = "ClubServiceMember";
            $model = $this->loadModel($id, $modelName);
            $data = array();
            if (!Yii::app()->request->isPostRequest) {
                $data['model'] = $model;
                $data['model']->admin_level=explode(',',$data['model']->admin_level);
                $data['project_list'] = ClubadminProject::model()->findAll('qmdd_admin_id='.$model->id);
                $this->render('customer_service_update', $data);
            } else {
                $this-> saveData($model,$_POST[$modelName]);
            }
        }
        
        function saveData($model,$post) {
            if (empty($model->id)){
                $modelName = $this->model;
                $tmp1=$modelName::model()->find('club_id='.$post['club_id']." and admin_gfaccount='".$post['admin_gfaccount']."'");
                if (!empty($tmp1)){
                    $model=$tmp1;
                }
            }
            $model->attributes =$post;
            $model->admin_level=gf_implode(',',$post['admin_level']);
            $Role = new Role;
            $model->role_name=$Role->RoleName($model->admin_level);
            $sv=$model->save();
            ClubadminProject::model()->deleteAll('qmdd_admin_id='.$model->id); 
            $this->save_project_list($model->id,$post['project_list']);
            show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');
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

        public function actionStatus($id, $status = 0) {
            parent::_status($id, $status);
        }

        public function actionDelete($id) {
            parent::_clear($id);
        }

   

        public function actionSaveLevel(){
            $modelName = $this->model;
            $model = $modelName::model();
            $qmdd = new QmddAdministrators();
            for($i=1;$i<15;$i++){
                if(isset($_POST["type_che".$i])){
                    $arr=array(
                        'admin_level_type'=>(isset($_POST["type_item".$i]) ? 887 : ''),
                    );
                    $qmdd->updateAll($arr,'id='.$_POST["type_che".$i]);
                }
            }
            ajax_status(1, '保存成功',Yii::app()->request->urlReferrer);
        }
    }