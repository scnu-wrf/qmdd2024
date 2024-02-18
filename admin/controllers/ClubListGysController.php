<?php

class ClubListGysController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex_apply($keywords='',$start_date='',$end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);

        $modelName = $this->model;
        $model = $modelName::model();
        $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
        $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('id','').' and club_type=380 and state in(721) and left(uDate,10)="'.date("Y-m-d").'"';
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'left(uDate,10)>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'left(uDate,10)<=',$end_date,'"');
        $criteria->condition=get_like($criteria->condition,'club_code,club_name,company',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_apply', $data);
    }


    public function actionIndex_wait_exam($keywords='',$start_date = '', $end_date = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'club_type=380 and unit_state=648';
        $criteria->condition .= ' and state in(371,373,1538)';
        if ($start_date != '') {
            $criteria->condition.=' and left(apply_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(apply_time,10)<="' . $end_date . '"';
        }
        $criteria->condition=get_like($criteria->condition,'club_code,club_name,company',$keywords,'');
        $criteria->order = 'uDate DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_wait_exam', $data);
    }

    public function actionIndex_exam($keywords='',$start_date='',$end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);

        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'club_type=380 and unit_state=648';
        $criteria->condition .= ' and state in(2,373,1538)';
        $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
        $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        if ($start_date != '') {
            $criteria->condition.=' and left(pass_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(pass_time,10)<="' . $end_date . '"';
        }
        $criteria->condition=get_like($criteria->condition,'club_code,club_name,company',$keywords,'');
        $criteria->order = 'pass_time DESC';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['count1'] = $model->count('club_type=380 and state in(371) and unit_state=648');
        parent::_list($model, $criteria, 'index_exam', $data);
    }

    public function actionIndex_no_exam($keywords='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'club_type=380 and unit_state=648';
        $criteria->condition .= ' and state=371';
        $criteria->condition=get_like($criteria->condition,'club_code,club_name,company',$keywords,'');
        $criteria->order = 'apply_time DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_no_exam', $data);
    }



    public function actionIndex_join($keywords='',$location='',$start_date='',$end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'club_type=380 and unit_state=648';
        $criteria->condition .= ' and state=2';
        $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
        $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        if ($start_date != '') {
            $criteria->condition.=' and left(pass_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(pass_time,10)<="' . $end_date . '"';
        }
        $criteria->condition=get_like($criteria->condition,'club_area_province,club_area_district,club_area_city',$location,'');
        $criteria->condition=get_like($criteria->condition,'club_code,club_name,company',$keywords,'');
        $criteria->order = 'pass_time DESC';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['company_type'] = BaseCode::model()->getCode(1089);
        parent::_list($model, $criteria, 'index_join', $data);
    }

    public function actionIndex_cancel_nopass($keywords='',$location='',$start_date='',$end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'club_type=380 and unit_state=648';
        $criteria->condition .= ' and state in(373)';
        $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
        $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        if ($start_date != '') {
            $criteria->condition.=' and left(pass_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(pass_time,10)<="' . $end_date . '"';
        }
        $criteria->condition=get_like($criteria->condition,'club_code,club_name,company',$keywords,'');
        $criteria->condition=get_like($criteria->condition,'club_area_province,club_area_district,club_area_city',$location,'');
        $criteria->order = 'pass_time DESC';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        parent::_list($model, $criteria, 'index_cancel_nopass', $data);
    }

    ///列表搜索
     public function actionIndex($state = '', $type = '', $province = '', $city = '', $area = '', $start_date = '', $end_date = '', $keywords = '',$club_type='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition=get_where('if_del=510',!empty($state),' state',$state,'');
        $criteria->condition=get_where($criteria->condition,!empty($type),' partnership_type',$type,'');
        $criteria->condition=get_where($criteria->condition,!empty($club_type),' club_type',$club_type,'');

        if ($province !== '') {
            $criteria->condition.=' AND t.club_address like "%' . $province . '%"';
        }

        if ($city == '市辖区' || $city == '市辖县' || $city == '省直辖县级行政区划') {
            $city = '';
        }
        if ($area == '市辖区' || $area == '市辖县' || $area == '省直辖县级行政区划') {
            $area = '';
        }

        if ($city != '') {
            $criteria->condition.=' AND t.club_address like "%' . $city . '%"';
        }

        if ($area != '') {
            $criteria->condition.=' AND t.club_address like "%' . $area . '%"';
        }
		$criteria->condition=get_where($criteria->condition,($start_date!=""),'apply_time>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'apply_time<=',$end_date,'"');
		$criteria->condition=get_like($criteria->condition,'club_name,club_code',$keywords,'');

        $criteria->order = 'id DESC';
        $data = array();
        $data['base_code'] = BaseCode::model()->getStateType();
        if(!empty($_REQUEST['club_type'])&&$_REQUEST['club_type']==380){
            $data['partnertype'] = BaseCode::model()->getCode(380);
        }else{
            $data['partnertype'] = BaseCode::model()->getClub_type2_all();
        }


        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['province']='';
            $data['city']='';
            $data['area']='';
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST);

        }

    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();

        if (!Yii::app()->request->isPostRequest) {
			$basepath = BasePath::model()->getPath(216);
            $model->about_me_temp=get_html($basepath->F_WWWPATH.$model->about_me, $basepath);
            $data['model'] = $model;
            $data['ids'] = ClubBrand::model()->findAll('club_id='.$model->id);
            $data['province']=$model->club_area_province;
            $data['city']=$model->club_area_city;
            $data['area']=$model->club_area_district;
            // 获取经营类目
            if (!empty($model->management_category)) {
                $data['management_category'] = ClubProductsType::model()->findAll('id in (' . $model->management_category . ')');
                $data['ctMark'] = ClubProductsType::model()->findAll();
            } else {
                $data['management_category'] = array();
            }
            $this->render('update', $data);
        } else {
			$this-> saveData($model,$_POST);
        }
    }

    function saveData($model,$post) {
        $model->check_save(1);
        $modelName = $this->model;
        $model->attributes = $_POST[$modelName];
		if ($_POST['submitType'] == 'shenhe') {
            $model->state = 371;
            $yes='提交成功';
            $no='提交失败';
        } else if ($_POST['submitType'] == 'baocun') {
            $model->state = 721;
            $yes='保存成功';
            $no='保存失败';
        } else if ($_POST['submitType'] == 'tongguo') {
            $model->state = 2;
            // $model->pass_time = date('Y-m-d H:i:s');
            // $model->reasons_adminid = get_session('admin_id');
            // $model->reasons_adminname = get_session('admin_name');
            $yes='操作成功';
            $no='操作失败';
        } else if ($_POST['submitType'] == 'butongguo') {
            $model->state = 373;
            $model->pass_time = date('Y-m-d H:i:s');
            $model->reasons_adminid = get_session('admin_id');
            $model->reasons_adminname = get_session('admin_name');
            $yes='操作成功';
            $no='操作失败';
        } else if ($_POST['submitType'] == 'tuihui') {
            $model->state = 1538;
            $model->pass_time = date('Y-m-d H:i:s');
            $model->reasons_adminid = get_session('admin_id');
            $model->reasons_adminname = get_session('admin_name');
            $yes='退回成功';
            $no='退回失败';
        } else if ($_POST['submitType'] == 'quxiao') {
            $model->state = 721;
            $yes='撤销成功';
            $no='撤销失败';
        } else {
            $model->state = 721;
            $yes='保存成功';
            $no='保存失败';
        }

        if(!empty($_POST['level1'])){
            $model->club_area_code=$_POST['level1'];
            $tregion1 = TRegion::model()->find('id="'.$_POST['level1'].'"');
            $model->club_area_province = $tregion1->region_name_c;
        }
        if(!empty($_POST['level2'])){
            $model->club_area_code.=','.$_POST['level2'];
            $tregion2 = TRegion::model()->find('id="'.$_POST['level2'].'"');
            $model->club_area_city = $tregion2->region_name_c;
        }
        if(!empty($_POST['level3'])){
            $model->club_area_code.=','.$_POST['level3'];
            $tregion3 = TRegion::model()->find('id="'.$_POST['level3'].'"');
            $model->club_area_district = $tregion3->region_name_c;
        }
        if(!empty($_POST['level4'])){
            $model->club_area_code.=','.$_POST['level4'];
            $tregion4 = TRegion::model()->find('id="'.$_POST['level4'].'"');
            $model->club_area_township = $tregion4->region_name_c;
        }
        $st=$model->save();

        if($st==1){
            // 保存图集
            ClubListPic::model()->deleteAll('club_id=' . $model->id);
            if(isset($_POST[$modelName]['club_list_pic'])){
                $model2 = new ClubListPic();
                $club_list_pic = array();
                $club_list_pic = explode(',', $_POST[$modelName]['club_list_pic']);
                $club_list_pic = array_unique($club_list_pic);
                foreach ($club_list_pic as $v) {
                    $model2->isNewRecord = true;
                    unset($model2->id);
                    $model2->club_id = $model->id;
                    $model2->club_aualifications_pic = $v;
                    $model2->save();
                }
            }

            if($model->state==2){
                $data = QmddAdministrators::model()->find('club_id='.$model->id);
                // $role = QmddRoleClub::model()->find('f_club_item_type='.$model->club_type);
                if(empty($data)){
                    $data = new QmddAdministrators();
                    $data->isNewRecord=true;
                    unset($data->f_id);

                }
                $data->club_id=$model->id;
                //$data->club_code=$model->club_code;
                $data->admin_gfaccount=$model->club_code;
                $data->club_name=$model->company;
                $data->lang_type=0;
                // $data->admin_level=$role->id;
                // $data->role_name=$role->f_rname;
                $role1 = Role::model()->find('f_rcode = "T03" ');
                $data->admin_level = $role1->f_id;
                $data->role_name = $role1->f_rname;
                //$data->admin_level=258;
                //$data->role_name='临时用户_供应商管理员';
                $st=$data->save();
                $title='【供应商-意向入驻审核通知】';
                $content='恭喜您申请入驻【得闲体育-供应商】初审已通过！';
               
            }elseif($model->state==373){
                $basepath=BasePath::model()->getPath(123);
               
                $title='【供应商-意向入驻审核通知】';
                $content='很抱歉，“'.$model->company.'供应商”意向入驻申请初审未通过。';
          
            }
            $url=wwwsportnet();
         
            $club=ClubList::model()->find("id=".get_session('club_id'));
            $pic=$club->club_logo_pic;
            $url.='index.php?r=clubListGys/message_content&id='.$model->id.'&state='.$model->state;
            $type_id=5;
            $sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>$url,'type_id'=>$type_id);
            game_audit(get_session('club_id'),$model->apply_club_gfid,$sendArr);
            sendSupplierEmail($time= null, $model->email, $url,$model->club_code, $gfaccount= null, $subject = null, $content = null);
        }
        if ($st) {

            // 保存品牌
            if(isset($_POST['add_tag'])){
                foreach ($_POST['add_tag'] as $n) {
                    if(!empty($n['brand_id'])){
                        $brand_model= ClubBrand::model()->find('id='.$n['brand_id']);
                    }
                    if(!empty($brand_model)&&$n['brand_id']==$brand_model->id){
                        $model3=$brand_model;
                    }
                    if($n['brand_id']==0){
                        $model3 = new ClubBrand();
                        $model3->isNewRecord=true;
                        unset($model3->id);
                    }

                    $mallBrandModel= MallBrandStreet::model()->find('brand_title="'.$n['brand_name'].'"');
                    if(empty($mallBrandModel)){
                        $mallBrandModel = new MallBrandStreet();
                        $mallBrandModel->isNewRecord=true;
                        unset($mallBrandModel->brand_id);
                        $mallBrandModel->brand_title=$n['brand_name'];
                        $mallBrandModel->brand_logo_pic=$n['brand_logo'];
                        $mallBrandModel->brand_content=$n['brand_lock'];
                        $mallBrandModel->brand_state=649;
                        $mallBrandModel->brand_date_begin='0000-00-00 00:00:00';
                        $mallBrandModel->brand_date_end='0000-00-00 00:00:00';
                    }
                    if ($_POST['submitType'] == 'tongguo'){
                        $mallBrandModel->state=2;
                    }else{
                        $mallBrandModel->state=371;
                    }
                    $st=$mallBrandModel->save();

                    $model3->brand_id=$mallBrandModel->brand_id;
                    $model3->brand_title=$n['brand_name'];
                    $model3->brand_logo_pic=$n['brand_logo'];
                    $model3->brand_content=$n['brand_lock'];
                    // $model3->brand_type=$model->management_category;
                    $model3->brand_state=649;
                    $model3->brand_state_name='是';
                    $model3->club_id=$model->id;
                    $model3->club_name=$model->club_name;
                    $st=$model3->save();
                }
            }
            if(!empty($_POST['ClubList']['remove_brand_ids'])){
                $remove_val=explode(',', $_POST['ClubList']['remove_brand_ids']);
                foreach ($remove_val as $r) {
                    if(!empty($r))ClubBrand::model()->deleteAll('id='.$r);
                }
            }
	    }
	  show_status($st,$yes, get_cookie('_currentUrl_'),$no);
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

      public function actionIndex_prove_apply($start_date = '', $end_date = '', $keywords='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('id','').' and club_type=380 and state=2 and edit_state = 721';
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'left(uDate,10)>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'left(uDate,10)<=',$end_date,'"');
        $criteria->condition .=' and edit_state in(721)';
        $criteria->condition=get_like($criteria->condition,'club_name,club_code',$keywords,'');
        $criteria->order = 'uDate DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_prove_apply', $data);
    }

    public function actionIndex_prove_wait_exam($keywords='',$start_date='',$end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('id','').' and club_type=380 and state=2';
        $criteria->condition .= ' and edit_state in(371,373,1538) and unit_state=648';

        $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
        $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        if ($start_date != '') {
            $criteria->condition.=' and left(edit_apply_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(edit_apply_time,10)<="' . $end_date . '"';
        }
        $criteria->condition=get_like($criteria->condition,'club_code,club_name,company',$keywords,'');
        $criteria->order = 'edit_apply_time DESC';

        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        parent::_list($model, $criteria, 'index_prove_wait_exam', $data);
    }

    public function actionIndex_prove_exam($keywords='',$start_date='',$end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);

        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('id','').' and club_type=380 and state=2';
        $criteria->condition .= ' and edit_state in(2,373,1538) and unit_state=648';
        $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
        $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        if ($start_date != '') {
            $criteria->condition.=' AND left(edit_pass_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' AND left(edit_pass_time,10)<="' . $end_date . '"';
        }
        $criteria->condition=get_like($criteria->condition,'club_code,club_name,company',$keywords,'');
        $criteria->order = 'id DESC';

        $data = array();
        $data['count1'] = $model->count('club_type=380 and state=2 and edit_state=371');
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        parent::_list($model, $criteria, 'index_prove_exam', $data);
    }

    public function actionIndex_prove_no_exam($keywords='',$start_date='',$end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('id','').' and club_type=380 and state=2';
        $criteria->condition .= ' and edit_state=371 and unit_state=648';
        $start_date='';$end_date='';
        if ($start_date != '') {
            $criteria->condition.=' AND left(edit_apply_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' AND left(edit_apply_time,10)<="' . $end_date . '"';
        }
        $criteria->condition=get_like($criteria->condition,'club_code,club_name,company',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        parent::_list($model, $criteria, 'index_prove_no_exam', $data);
    }


    public function actionIndex_prove_cancel_nopass($keywords='',$location='',$start_date='',$end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);

        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('id','').' and club_type=380 and state=2';
        $criteria->condition .= ' and edit_state=373 and unit_state=648';
        $criteria->condition=get_like($criteria->condition,'club_area_province,club_area_district,club_area_city',$location,'');
        if ($start_date != '') {
            $criteria->condition.=' AND left(edit_pass_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' AND left(edit_pass_time,10)<="' . $end_date . '"';
        }
        $criteria->condition=get_like($criteria->condition,'club_code,club_name,company',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        parent::_list($model, $criteria, 'index_prove_cancel_nopass', $data);
    }


    public function actionUpdate_data($id) {
        if($id==0){
            $id=get_session('club_id');
            $url = Yii::app()->request->urlReferrer;
        }else{
            $url = get_cookie('_currentUrl_');
        }
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['qualification_pics'] = explode(',', $model->qualification_pics);

            if(!empty($model->enter_project_id))$data['model2'] = QualificationClub::model()->findAll('club_id='.$model->id.' and project_id='.$model->enter_project_id);
            $data['project'] = ProjectList::model()->getProject();
            $data['type'] = BaseCode::model()->getCode(383);
            $data['province']=$model->club_area_province;
            $data['city']=$model->club_area_city;
            $data['area']=$model->club_area_district;
            $this->render('update_data', $data);
        } else {
            $this->saveData_prove($model,$_POST,$url);
        }
    }

    public function actionUpdate_prove($id) {
        if($id==='0'){
            $id=get_session('club_id');
            $url = Yii::app()->request->urlReferrer;
        }else{
            $url = get_cookie('_currentUrl_');
        }
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['qualification_pics'] = explode(',', $model->qualification_pics);

            if(!empty($model->enter_project_id))$data['model2'] = QualificationClub::model()->findAll('club_id='.$model->id.' and project_id='.$model->enter_project_id);
            $data['project'] = ProjectList::model()->getProject();
            $data['type'] = BaseCode::model()->getCode(383);
            $data['province']=$model->club_area_province;
            $data['city']=$model->club_area_city;
            $data['area']=$model->club_area_district;
            $this->render('update_prove', $data);
        } else {
            $this->saveData_prove($model,$_POST,$url);
        }
    }

    function saveData_prove($model,$post,$return_url) {
        $model->check_save(1);
        $modelName = $this->model;
        $model->attributes = $_POST[$modelName];
		if ($_POST['submitType'] == 'shenhe') {
            $model->edit_state = 371;
            $model->edit_apply_time = date('Y-m-d h:i:s');
            $yes='提交成功';
            $no='提交失败';
        } else if ($_POST['submitType'] == 'baocun') {
            if(get_session("club_code")!=$model->club_code){
                $model->edit_state = 721;
            }else{
                $model->edit_state = null;
                $model->edit_state_name = null;
            }
            $yes='保存成功';
            $no='保存失败';
        } else if ($_POST['submitType'] == 'tongguo') {
            $model->edit_state = 2;
            $model->edit_pass_time = date('Y-m-d H:i:s');
            $model->edit_adminid = get_session('admin_id');
            $model->edit_adminname = get_session('admin_name');
            $yes='操作成功';
            $no='操作失败';
        } else if ($_POST['submitType'] == 'butongguo') {
            $model->edit_state = 373;
            $model->edit_pass_time = date('Y-m-d H:i:s');
            $model->edit_adminid = get_session('admin_id');
            $model->edit_adminname = get_session('admin_name');
            $yes='操作成功';
            $no='操作失败';
        } else if ($_POST['submitType'] == 'tuihui') {
            $model->edit_state = 1538;
            $model->edit_pass_time = date('Y-m-d H:i:s');
            $model->edit_adminid = get_session('admin_id');
            $model->edit_adminname = get_session('admin_name');
            $yes='退回成功';
            $no='退回失败';
        } else if ($_POST['submitType'] == 'quxiao') {
            $model->edit_state = 721;
            $yes='撤销成功';
            $no='撤销失败';
        } else {
            $model->edit_state = 721;
            $yes='保存成功';
            $no='保存失败';
        }

        $st=$model->save();
        $title='【社区商家认证审核通知】';
        $content='很抱歉，您申请入驻【得闲体育-供应商】审核未通过！';
        if($st==1&&$model->edit_state==2){
            $data = QmddAdministrators::model()->find('club_id='.$model->id);
            //$role1 = Role::model()->find('f_rcode = "D01" ');
            if($model->partnership_type == 605){
                $data->admin_level = 211;
                $data->role_name = "普通商家";

            }else{
                $data->admin_level = 263;
                $data->role_name = "自营商家";
            }
            //$data->admin_level=211;
            //$data->role_name='供应商';
            $data->club_name=$model->club_name;
            $st=$data->save();
            $basepath=BasePath::model()->getPath(123);
            $club=ClubList::model()->find("id=".get_session('club_id'));
            $pic=$basepath->F_WWWPATH.$club->club_logo_pic;
            $title='【社区商家认证审核通知】';
            $content='恭喜您成功入驻【得闲体育-供应商】！';
        }
         $club=ClubList::model()->find("id=".get_session('club_id'));
        $pic=$club->club_logo_pic;

        $url.='index.php?r=clubListGys/message_content&id='.$model->id.'&edit_state='.$model->edit_state;
        $type_id=5;
        $sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>$url,'type_id'=>$type_id);
        game_audit(get_session('club_id'),$model->apply_club_gfid,$sendArr);
        sendSupplierEmail4($time= null, $model->email, $url,$model->club_code, $gfaccount= null, $subject = null, $content = null);

     
	    show_status($st,$yes, $return_url,$no);
    }


	 // 帐号验证
     public function actionExist($name=0) {
        $club_name=ClubList::model()->find('club_name="'.$name.'" and unit_state=648 and if_del=510');
        if(!empty($club_name)) {
            ajax_status(0, '该名称已被注册');
        }
     }

	 // 单位帐号验证
     public function actionvalidateCode($code=0) {
        $club=ClubList::model()->find('club_code='.$code);
        if(!empty($club)) {
            $club_arr=['club_id'=>$club->id,'club_code'=>$club->club_code,'club_name'=>$club->club_name,];
            ajax_status(1,'',$club_arr);
         } else {
             ajax_status(0, '帐号不存在');
         }
     }

    public function actionIndex_gys($keywords='',$start_date='',$end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('id','').' and club_type=380 and state=2';
        $criteria->condition .= ' and edit_state=2';
        $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
        $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        if ($start_date != '') {
            $criteria->condition.=' AND left(edit_pass_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' AND left(edit_pass_time,10)<="' . $end_date . '"';
        }
        $criteria->condition=get_like($criteria->condition,'club_code,club_name,company',$keywords,'');
        $criteria->order = 'edit_pass_time DESC';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        parent::_list($model, $criteria, 'index_gys', $data);
    }


    public function actionIndex_gys_destroy($keywords='',$start_date='',$end_date='',$to_day=0) {
        $start_date2 = substr($start_date,0,10);
        $end_date2 = substr($end_date,0,10);

        set_cookie('_currentUrl_', Yii::app()->request->url);

        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'club_type = 380 and unit_state = 649';
        if($to_day==1){
            $criteria->condition .= ' and left(apply_time,10)="'.date('Y-m-d').'"';
        }
        $criteria->order = 'id DESC';
        $criteria->condition=get_like($criteria->condition,'club_code,club_name,company',$keywords,'');
        $criteria->condition=get_where($criteria->condition,($start_date2!=""),'left(apply_time,10)>=',$start_date2,'"');
        $criteria->condition=get_where($criteria->condition,($end_date2!=""),'left(apply_time,10)<=',$end_date2,'"');

        $data = array();


        date_default_timezone_set('Asia/Shanghai');
        $current_time = (date("Y-m-d"));

        $data['count_gys_destroy'] = $model->count('club_type = 380 and unit_state = 649 and left(lock_date,10) = "'.$current_time.'"');
        //$criteria->condition=get_where($criteria->condition,($current_time!=""),'left(apply_time,10)=',$current_time,'"');
        //$data['count1'] = $model->count('club_type=189 and state=2 and edit_state=371');
        parent::_list($model, $criteria, 'index_gys_destroy', $data);
    }


//逻辑删除
   public function actionDelete($id) {
        parent::_delete($id);
    }

    // 撤销申请
    public function actionCancel($id,$new='',$del='',$yes='',$no='') {
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'id in(' . $id . ')';
        $count = $model->updateAll(array($new => $del), $criteria);
        if ($count > 0) {
            ajax_status(1, $yes, get_cookie('_currentUrl_'));
        } else {
            ajax_status(0, $no);
        }
    }

    public function actionMessage_content($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        $this->set_check_in();//$_SESSION['gfaccount'])
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('message_content',$data);
        } else {
            $this->saveCompleteData($model,$_POST,$url);
        }
    }



}



