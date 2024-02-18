<?php

class ClubListZlhbController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    ///列表搜索
     public function actionIndex($company_type = '', $state = '', $type = '', $province = '', $city = '', $area = '', $start_date = '', $end_date = '', $keywords = '' , $index = '' , $today='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'club_type=189 and unit_state=648';
        if($index==1){
            $criteria->condition .= ' and state in(2,373,1538)';
            $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
            $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        }elseif($index==2){
            $criteria->condition .= ' and state=371';
            $start_date='';$end_date='';
        }elseif($index==3){
            $criteria->condition .= ' and state in(373)';
        }elseif($index==4){
            $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
            $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
            $criteria->condition .= ' and state=2';
        }elseif($index==5){
            if($today==''){
                $criteria->condition .= ' and state in(371,373,1538)';
            }else{
                $criteria->condition .= ' and state in(371,373,1538) and left(apply_time,10)="'.$today.'"';
            }
        }
        $criteria->condition=get_where($criteria->condition,!empty($company_type),' company_type_id',$company_type,''); 
        $criteria->condition=get_where($criteria->condition,!empty($state),' state',$state,''); 
        $criteria->condition=get_where($criteria->condition,!empty($type),' partnership_type',$type,''); 
        if($province !== ''){
            $criteria->condition.=' AND club_area_province like "%' . $province . '%"';
        }
        if ($city == '市辖区' || $city == '市辖县' || $city == '省直辖县级行政区划') {
            $city = '';
        }
        if ($area == '市辖区' || $area == '市辖县' || $area == '省直辖县级行政区划') {
            $area = '';
        }
        if ($city != '') {
            $criteria->condition.=' AND (club_area_city like "%' . $city . '%" or club_area_district like "%' . $city . '%" or club_area_township like "%' . $city . '%")';
        }

        if ($area != '') {
            $criteria->condition.=' AND ( club_area_city like "%' . $area . '%" or club_area_district like "%' . $area . '%" or club_area_township like "%' . $area . '%")';
        }
        if($index==5){
            if ($start_date != '') {
                $criteria->condition.=' and left(apply_time,10)>="' . $start_date . '"';
            }
            if ($end_date != '') {
                $criteria->condition.=' and left(apply_time,10)<="' . $end_date . '"';
            }
        }else{
            if ($start_date != '') {
                $criteria->condition.=' and left(pass_time,10)>="' . $start_date . '"';
            }
            if ($end_date != '') {
                $criteria->condition.=' and left(pass_time,10)<="' . $end_date . '"';
            }
        }
        $criteria->condition=get_like($criteria->condition,'club_code,club_name,company',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['count1'] = $model->count('club_type=189 and state in(371) and unit_state=648');
        $data['count2'] = $model->count('club_type=189 and state=371 and left(apply_time,10)="'.date("Y-m-d").'"');
        $data['base_code'] = BaseCode::model()->getStateType();
        $data['company_type'] = BaseCode::model()->getCode(1403);
        $data['state'] = BaseCode::model()->getReturn('371,373,1538');
        parent::_list($model, $criteria, 'index', $data);
    }
    

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
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
            // $model->about_me_temp=get_html($basepath->F_WWWPATH.$model->about_me, $basepath);
            $data['model'] = $model;
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
            $model->pass_time = date('Y-m-d H:i:s');
            $model->reasons_adminid = get_session('admin_id');
            $model->reasons_adminname = get_session('admin_name');
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
        if(empty($_POST[$modelName]['club_area_city'])){
            $model->club_area_city='';
        }else if(empty($_POST[$modelName]['club_area_district'])){
            $model->club_area_district='';
        }else if(empty($_POST[$modelName]['club_area_township'])){
            $model->club_area_township='';
        }
        if(!empty($model->company_type_id)){
            $b_type = BaseCode::model()->find('f_id='.$model->company_type_id);
            $model->company_type=$b_type->F_NAME;
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
            $title='【意向入驻审核】通知';
            $content='抱歉，您的“'.$model->company.'”意向入驻申请审核未通过。';
            if($model->state==2){
                $data = QmddAdministrators::model()->find('club_id='.$model->id);
                // $role = QmddRoleClub::model()->find('f_club_item_type='.$model->club_type);
                if(empty($data)){
                    $data = new QmddAdministrators();
                    $data->isNewRecord=true;
                    unset($data->f_id);
                    
                }
                $data->club_id=$model->id;
                $data->club_code=$model->club_code;
                $data->club_name=$model->club_name;
                $data->lang_type=0;
                $data->admin_gfaccount=$model->club_code;
                $data->club_name=$model->company;
                $data->admin_level=186;
                $data->role_name='临时用户_战略伙伴管理员';
                $st=$data->save();
                $title='【意向入驻审核】通知';
                $content='恭喜您，您申请入驻【得闲体育-战略伙伴】初审已通过！';       
            }
           $url=wwwsportnet();
            if($_SERVER['SERVER_NAME']==wwwsportnet()){
                $url=wwwsportnet();
            }else if($_SERVER['SERVER_NAME']==wwwsportnet()){
                $url=wwwsportnet();
            }
            $club=ClubList::model()->find("id=".get_session('club_id'));
            $pic=$club->club_logo_pic;
            $url.='/index.php?r=clubListZlhb/message_content&id='.$model->id.'&state='.$model->state;
            $type_id=5;
            $sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>$url,'type_id'=>$type_id);
            game_audit(get_session('club_id'),$model->apply_club_gfid,$sendArr);
        }
	    show_status($st,$yes, get_cookie('_currentUrl_'),$no); 
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

    public function actionIndex_data( $type = '', $start_date = '', $end_date = '', $keywords = '',$state=0, $edit_state = '', $index = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        // if($state==1){$edit_state=371;$start_date='';$end_date='';}else{$edit_state=$edit_state;}
        $criteria->condition = get_where_club_project('id','').' and club_type=189 and state=2';
        if($index==1){
            $criteria->condition .= ' and edit_state in(2,373,1538) and unit_state=648';
            $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
            $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        }elseif($index==2){
            $criteria->condition .= ' and club_type=189 and state=2 and edit_state=371 and unit_state=648';
            $start_date='';$end_date='';
        }elseif($index==3){
            $criteria->condition .= ' and club_type=189 and state=2 and edit_state=373 and unit_state=648';
        }elseif($index==4){
            $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
            $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
            $criteria->condition .= ' and edit_state=2';
        }elseif($index==5){
            $criteria->condition .= ' and unit_state=649';
        }elseif($index==6){
            $criteria->condition .= ' and edit_state in(371,373,1538) and unit_state=648';
        }
        $criteria->condition=get_where($criteria->condition,!empty($type),' partnership_type',$type,''); 
        if($index==6||$index==2){
            if ($start_date != '') {
                $criteria->condition.=' AND left(edit_apply_time,10)>="' . $start_date . '"';
            }
            if ($end_date != '') {
                $criteria->condition.=' AND left(edit_apply_time,10)<="' . $end_date . '"';
            }
        }else{
            if ($start_date != '') {
                $criteria->condition.=' AND left(edit_pass_time,10)>="' . $start_date . '"';
            }
            if ($end_date != '') {
                $criteria->condition.=' AND left(edit_pass_time,10)<="' . $end_date . '"';
            }
        }
        $criteria->condition=get_like($criteria->condition,'club_name,club_code',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['partnership_type'] = ClubServicerType::model()->findAll('type=1124');
        $data['count1'] = $model->count('club_type=189 and state=2 and edit_state=371 and unit_state=648');
        parent::_list($model, $criteria, 'index_data', $data);
    }

    public function actionIndex_list( $start_date = '', $end_date = '', $keywords = '',$state=0, $edit_state = '', $date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        if($state==721){
            $st='721';
        }else{
            $st=$state;
        }
        $criteria->condition = get_where_club_project('id','').' and club_type=189 and state in('.$st.') and unit_state=648';
        if($date==1){
            if($state==721){
                $criteria->condition = get_where_club_project('id','').' and club_type=189 and state in('.$st.') and left(uDate,10)="'.date("Y-m-d").'"';
            }elseif($state==2&&$edit_state==721){
                $criteria->condition = get_where_club_project('id','').' and club_type=189 and state='.$state.' and left(uDate,10)="'.date("Y-m-d").'"';
            }
        }
        // $criteria->condition=get_where($criteria->condition,!empty($edit_state),' edit_state',$edit_state,''); 
        if($state==721){
            $criteria->condition=get_where($criteria->condition,($start_date!=""),'left(uDate,10)>=',$start_date,'"');
            $criteria->condition=get_where($criteria->condition,($start_date!=""),'left(uDate,10)<=',$end_date,'"');
            $criteria->condition=get_like($criteria->condition,'company,club_code',$keywords,'');
        }elseif($state==2&&$edit_state==721){
            $criteria->condition=get_where($criteria->condition,($start_date!=""),'left(uDate,10)>=',$start_date,'"');
            $criteria->condition=get_where($criteria->condition,($start_date!=""),'left(uDate,10)<=',$end_date,'"');

            $criteria->condition .=' and edit_state in(721)';
            $criteria->condition=get_like($criteria->condition,'club_name,club_code',$keywords,'');
        }
        $criteria->order = 'id DESC';
        $data = array();
        if($state==721){
            $data['count1'] = $model->count(get_where_club_project('id','').' and club_type=189 and left(apply_time,10)="'.date("Y-m-d").'"');
        }elseif($state==2&&$edit_state==721){
            $data['count1'] = $model->count(get_where_club_project('id','').' and club_type=189 and left(edit_apply_time,10)="'.date("Y-m-d").'"');
        }
        parent::_list($model, $criteria, 'index_list', $data);
    }

    public function actionUpdate_data($id) {
        if($id=='[:club_id]'){
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
            $this->render('update_data', $data);
        } else {
			$this->saveCompleteData($model,$_POST,$url);
        }
    }

	function saveCompleteData($model,$post,$return_url) {
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
        if(!empty($model->edit_state)){
            $b = BaseCode::model()->find('f_id='.$model->edit_state);
            $model->edit_state_name = $b->F_NAME;
        }
        if(!empty($model->company_type_id)){
            $b_type = BaseCode::model()->find('f_id='.$model->company_type_id);
            $model->company_type=$b_type->F_NAME;
        }
        $st=$model->save();
        if($st==1){
            if($model->edit_state==2){
                if(!empty($model->recommend)){ //推荐单位获得积分
                    $g=GfCredit::model()->find('item_type=1478');
                    if(!empty($g)){
                        $gData=GfCreditHistory::model()->find('item_code='.$g->id.' and object=502 and gf_id='.$model->recommend);
                        if(empty($gData)){
                            $gData = new GfCreditHistory();
                            $gData->isNewRecord=true;
                            unset($gData->id);
                        }
                        $gData->object=502;
                        $gData->gf_id=$model->recommend;
                        $gData->item_code=$g->id;
                        $gData->add_or_reduce=1;
                        $gData->credit=$g->credit;
                        $gData->service_source=$model->club_name;
                        $gData->add_time=date('Y-m-d H:i:s');
                        $gData->admin_id=get_session('admin_id');
                        $gData->state=371;
                        $gData->save();
                    }
                }

                $m_message='恭喜您，您的信息认证审核已通过！如已申请项目，请等待项目入驻通知。如未申请项目，请登录后台-项目-项目申请进行项目申请。';
                $basepath=BasePath::model()->getPath(123); 
                $club=ClubList::model()->find("id=".get_session('club_id'));
                $pic=$basepath->F_WWWPATH.$club->club_logo_pic;
                $title='【信息认证审核】通知';
                $content='恭喜您，您的信息认证审核已通过！';
                $url='';
                $type_id=5;
                $sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>$url,'type_id'=>$type_id);
                backstage_send_message(get_session('admin_id'),$model->club_code,$m_message,$title,315,'B'.$model->club_code,$sendArr);
            }elseif($model->edit_state==373){
                $r_admin=QmddAdministrators::model()->find('club_code='.$model->club_code);
                $m_message='抱歉，您的信息认证审核未通过。';
                $basepath=BasePath::model()->getPath(123); 
                $club=ClubList::model()->find("id=".get_session('club_id'));
                $pic=$basepath->F_WWWPATH.$club->club_logo_pic;
                $title='【信息认证审核】通知';
                $content='抱歉，您的信息认证审核未通过。';
                $url='';
                $type_id=5;
                $sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>$url,'type_id'=>$type_id);
                backstage_send_message(get_session('admin_id'),$model->club_code,$m_message,$title,315,'B'.$model->club_code,$sendArr);
            }
            if(!empty($model->enter_project_id)){ //是否带项目入驻
                $clubProject=ClubProject::model()->find('club_id='.$model->id.' and project_id='.$model->enter_project_id);
                if(empty($clubProject)){
                    $clubProject = new ClubProject();
                    $clubProject->isNewRecord=true;
                    unset($clubProject->id);
                }
                $clubProject->club_id = $model->id;
                $clubProject->p_code = $model->club_code;
                $clubProject->project_id = $model->enter_project_id;
                $clubProject->club_type = $model->club_type;
                $clubProject->club_type_name = $model->club_type_name;
                $clubProject->partnership_type = $model->partnership_type;
                $clubProject->partnership_name = $model->partnership_name;
                $clubProject->approve_state = $model->approve_state;
                

                $club_list_pic2=ClubListPic::model()->findall('club_id='.$model->id);
                $pic='';
                foreach ($club_list_pic2 as $p) {
                    $pic.=$p->club_aualifications_pic.'|';
                }
                $clubProject->qualification_pics = rtrim($pic, "|");

                $clubProject->state = $model->edit_state;
                if($model->edit_state==721){
                    $clubProject->auth_state = 457;
                }elseif($model->edit_state==371){
                    $clubProject->auth_state = 459;
                }elseif($model->edit_state==2){
                    $clubProject->auth_state = 460;
                }elseif($model->edit_state==373){
                    $clubProject->auth_state = 456;
                }

                if(!empty($model->approve_state)){
                    $a_name=BaseCode::model()->find('f_id='.$model->approve_state);
                    $clubProject->approve_state_name = $a_name->F_NAME;
                }
                $st=$clubProject->save();
            }
        }
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

    //  城市选择
    public function actionScales($info_id){
        $data = TRegion::model()->findAll(
            array(
                'select'=>array('id','CODE','country_id','country_code','region_name_e','level','upper_region','region_name_c'),
                'order'=>'id',
                'condition'=>'upper_region='.$info_id
            )
        );
        if(!empty($data)){
            echo CJSON::encode($data);
        }
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

}

 

