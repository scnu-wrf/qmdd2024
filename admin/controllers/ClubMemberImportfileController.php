<?php

class ClubMemberImportfileController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    ///列表搜索
    public function actionIndex($regtime = '',$endregtime = '',$key_club='', $keywords = '',$is_excel='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition=get_where_club_project('club_id','');
        $criteria->condition.=' and club_type in(8,189)';
        $regtime=empty($regtime) ? date("Y-m-d",strtotime("-1 months",time())) : $regtime;
        $endregtime=empty($endregtime) ? date("Y-m-d") : $endregtime;
        if ($regtime != '') {
            $criteria->condition.=' and left(add_time,10)>="' . $regtime . '"';
        }
        if ($endregtime != '') {
            $criteria->condition.=' and left(add_time,10)<="' . $endregtime . '"';
        }
        $criteria->condition=get_like($criteria->condition,'club_name',$key_club,'');
        $criteria->condition=get_like($criteria->condition,'club_name,zsxm,gf_account,project_name',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['regtime']=$regtime;
        $data['endregtime']=$endregtime;
		if(!isset($is_excel) || $is_excel!='1'){
            parent::_list($model, $criteria, 'index', $data);
		}else{
		    $arclist = $model->findAll($criteria);
		    $data=array();
            $title=array();
            $titlefiled = array(
                'gf_account',
                'zsxm',
                'real_sex',
                'id_card',
                'member_type',
                'club_type',
                'club_name',
                'REGTIME',
            );
            foreach ($titlefiled as $fv) {
                array_push($title, $model->getAttributeLabel($fv));
		    }
            array_push($data, $title);
		    foreach ($arclist as $v) {
		        $item = array();
		        foreach ($titlefiled as $fv) {
		            $s = '';
		            if ($v->club_type == 189) {
		                if ($fv == 'gf_account') {
                            $s = $v->gf_member->gf_account;
                        } elseif ($fv == 'zsxm') {
                            $s = $v->gf_member->zsxm;
                        } elseif ($fv == 'real_sex') {
                            $s = $v->gf_member->sex;
                        } elseif ($fv == 'id_card') {
                            $s = $v->gf_member->id_card;
                        } elseif ($fv == 'member_type') {
                            $s = '成员';
                        } elseif ($fv == 'club_type') {
                            $s = '战略伙伴';
                        } elseif ($fv == 'club_name') {
                            $s = $v->gf_member->club_name;
                        } elseif ($fv == 'REGTIME') {
                            $s = $v->gf_member->gf_user->REGTIME;
                        } else {
                            $s = $v->$fv;
                        }
		            } else if ($v->club_type == 8) {
		                if ($fv == 'gf_account') {
                            $s = $v->club_menber->gf_account;
                        } elseif ($fv == 'zsxm') {
                            $s = $v->club_menber->zsxm;
                        } elseif ($fv == 'real_sex') {
                            $s = $v->club_menber->base_code_sex->F_NAME;
                        } elseif ($fv == 'id_card') {
                            $s = $v->club_menber->id_card;
                        } elseif ($fv == 'member_type') {
                            $s = '学员';
                        } elseif ($fv == 'club_type') {
                            $s = '社区单位';
                        } elseif ($fv == 'club_name') {
                            $s = $v->club_menber->club_name;
                        } elseif ($fv == 'REGTIME') {
                            $s = $v->club_menber->gf_user->REGTIME;
                        } else {
                            $s = $v->$fv;
                        }
                    }
		            array_push($item, $s);
		        }
		        array_push($data, $item);
		    }
		    parent::_excel($data,'学员列表.xls');
        }
    }
    ///学员导入
    public function actionIndex_student($regtime = '',$endregtime = '',$key_club='', $keywords = '',$is_excel='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition='club_type in(8,189) and club_id='.get_session('club_id');
        $regtime=empty($regtime) ? date("Y-m-d",strtotime("-1 months",time())) : $regtime;
        $endregtime=empty($endregtime) ? date("Y-m-d") : $endregtime;
        if ($regtime != '') {
            $criteria->condition.=' and left(add_time,10)>="' . $regtime . '"';
        }
        if ($endregtime != '') {
            $criteria->condition.=' and left(add_time,10)<="' . $endregtime . '"';
        }
        $criteria->condition=get_like($criteria->condition,'club_name',$key_club,'');
        $criteria->condition=get_like($criteria->condition,'club_name,zsxm,gf_account,project_name',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['regtime']=$regtime;
        $data['endregtime']=$endregtime;
        parent::_list($model, $criteria, 'index_student', $data);
    }

    //成员导入
    public function actionIndex_member($regtime = '',$endregtime = '',$key_club='', $keywords = '',$is_excel='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition='club_type in(189) and club_id='.get_session('club_id');
        $regtime=empty($regtime) ? date("Y-m-d",strtotime("-1 months",time())) : $regtime;
        $endregtime=empty($endregtime) ? date("Y-m-d") : $endregtime;
        if ($regtime != '') {
            $criteria->condition.=' and left(add_time,10)>="' . $regtime . '"';
        }
        if ($endregtime != '') {
            $criteria->condition.=' and left(add_time,10)<="' . $endregtime . '"';
        }
        $criteria->condition=get_like($criteria->condition,'club_name',$key_club,'');
        $criteria->condition=get_like($criteria->condition,'club_name,zsxm,gf_account,project_name',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['regtime']=$regtime;
        $data['endregtime']=$endregtime;
        parent::_list($model, $criteria, 'index_member', $data);
    }


    ///列表搜索
    public function actionIndex_server($regtime = '',$endregtime = '', $keywords = '',$key_club='',$is_excel='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition='logon_way=1461 and club_type in(501,502)';
        $regtime=empty($regtime) ? date("Y-m-d",strtotime("-1 months",time())) : $regtime;
        $endregtime=empty($endregtime) ? date("Y-m-d") : $endregtime;
        if ($regtime != '') {
            $criteria->condition.=' and left(add_time,10)>="' . $regtime . '"';
        }
        if ($endregtime != '') {
            $criteria->condition.=' and left(add_time,10)<="' . $endregtime . '"';
        }
        $criteria->condition=get_like($criteria->condition,'club_name',$key_club,'');
        $criteria->condition=get_like($criteria->condition,'club_name,zsxm,gf_account,project_name',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['regtime']=$regtime;
        $data['endregtime']=$endregtime;
        $data['count1']=$model->count('logon_way=1461 and club_type in(501,502) and pay_confirm=0');
        parent::_list($model, $criteria, 'index_server', $data);
    }

    ///列表搜索
    public function actionIndex_club($regtime = '',$endregtime = '',$key_club='', $keywords = '',$is_excel='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition='logon_way=1460 and club_type in(501,502) and club_id='.get_session('club_id');
        $regtime=empty($regtime) ? date("Y-m-d",strtotime("-1 months",time())) : $regtime;
        $endregtime=empty($endregtime) ? date("Y-m-d") : $endregtime;
        if ($regtime != '') {
            $criteria->condition.=' and left(add_time,10)>="' . $regtime . '"';
        }
        if ($endregtime != '') {
            $criteria->condition.=' and left(add_time,10)<="' . $endregtime . '"';
        }
        $criteria->condition=get_like($criteria->condition,'club_name',$key_club,'');
        $criteria->condition=get_like($criteria->condition,'club_name,zsxm,gf_account,project_name',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['regtime']=$regtime;
        $data['endregtime']=$endregtime;
        parent::_list($model, $criteria, 'index_club', $data);
    }

    /**
     * 确认
     */
    public function actionConfirmed($id) {
        $modelName = $this->model;
        $n = explode(',',$id);
        foreach($n as $v){
            $model = $this->loadModel($v,$modelName);
            $r_sex='';
            if($model->sex=='男'){
                $r_sex=205;
            }elseif($model->sex=='女'){
                $r_sex=207;
            }
            $gfUser=userlist::model()->find('id_card_type=843 and id_card="'.trim($model->id_card).'"');
            if(empty($gfUser)){
                $gfUser = new userlist();
                $gfUser->isNewRecord = true;
                unset($gfUser->id);
                // $gfIdelUser=GfIdelUser::model()->find('id order by rand()');
                // $gfUser->GF_ACCOUNT=$gfIdelUser->non_account;
                $GfIdelUserAllNumber=GfIdelUserAllNumber::model()->findBySql('SELECT t1.id,t1.account FROM gf_idel_user_all_number as t1 JOIN (SELECT ROUND(RAND() * ((SELECT MAX(id) FROM gf_idel_user_all_number)-(SELECT MIN(id) FROM gf_idel_user_all_number))+(SELECT MIN(id) FROM gf_idel_user_all_number)) AS id from gf_idel_user_all_number limit 10) AS t2 on t1.id=t2.id WHERE t1.is_use=0 and t1.f_vip=0 LIMIT 1');
                $gfUser->GF_ACCOUNT=$GfIdelUserAllNumber->account;
                $gfUser->GF_PASS='123456';
                $gfUser->logon_way=$model->logon_way;
                $base=BaseCode::model()->find('f_id='.$model->logon_way);
                if(!empty($base))$gfUser->logon_way_name=$base->F_NAME;
                $gfUser->GF_NAME=$model->zsxm;
                $gfUser->ZSXM=$model->zsxm;
                $gfUser->real_sex = $r_sex;
                $gfUser->id_card_type=843;
                $gfUser->id_card=trim($model->id_card);
            }
            $gfUser->native=$model->native;
            $gfUser->real_birthday=$model->real_birthday;
            $gfUser->PHONE=$model->phone;
            if($gfUser->passed!=2){
                $gfUser->passed=2;
                $gfUser->valid_date=date('Y-m-d H:i:s');
                $gfUser->end_valid_date='长期';
                if($gfUser->passed!=371){
                    $gfUser->realname_time=date('Y-m-d H:i:s');
                }
                $gfUser->realname_entertime=date('Y-m-d H:i:s');
            }
            $sa = $gfUser->save();
            if($sa==1){
                // GfIdelUser::model()->deleteAll('non_account='.$gfUser->GF_ACCOUNT);
            	$mo = GfIdelUserAllNumber::model()->find('account='.$gfUser->GF_ACCOUNT);
            	$mo->is_use=1;
            	$sn=$mo->update($mo);
            }

            if($model->club_type==8){
                $model2=ClubMemberList::model()->find('club_id='.$model->club_id.' and member_project_id="'.$model->project_id.'" and id_card_type=843 and id_card="'.trim($model->id_card).'"');
                if(!empty($model2->user_member_id)){
                    $clubMember=ClubMember::model()->find('id='.$model2->user_member_id);
                }else{
                        $clubMember = new ClubMember();
                        $clubMember->isNewRecord = true;
                        unset($clubMember->id);
                }
                $clubMember->club_id=$model->club_id;
                $clubMember->member_gfid=$gfUser->GF_ID;
                $clubMember->gf_account=$gfUser->GF_ACCOUNT;
                $clubMember->real_sex=$gfUser->real_sex;
                $clubMember->zsxm=$gfUser->ZSXM;
                $clubMember->member_project_id=$model->project_id;
                $clubMember->agree_club=2;
                $clubMember->member_level_register_time=date('Y-m-d H:i:s');
                $clubMember->start_time=date('Y-m-d H:i:s');
                $sn=$clubMember->save();

                if(empty($model2)){
                    $model2 = new ClubMemberList();
                    $model2->isNewRecord = true;
                    unset($model2->id);
                }
                $model2->club_id=$model->club_id;
                $model2->member_gfid=$gfUser->GF_ID;
                $model2->gf_account=$gfUser->GF_ACCOUNT;
                $model2->zsxm=$gfUser->ZSXM;
                $model2->idname=$gfUser->IDNAME;
                $model2->id_card_type=843;
                $model2->id_card_type_name='身份证';
                $model2->id_card=trim($model->id_card);
                $model2->real_birthday=$model->real_birthday;
                $model2->real_sex=$gfUser->real_sex;
                $model2->member_project_id=$model->project_id;
                $model2->club_status=337;
                $model2->user_member_id=$clubMember->id;
                $model2->logon_way=1375;
                $sc = $model2->save();
            }elseif($model->club_type==189){
                $model2=GfPartnerMemberApply::model()->find('partner_id="'.$model->club_id.'" and project_id="'.$model->project_id.'" and id_card="'.trim($model->id_card).'"');
                if(empty($model2)){
                    $model2 = new GfPartnerMemberApply();
                    $model2->isNewRecord = true;
                    unset($model2->id);
                }
                $model2->code=$model->import_code;
                $model2->type=403;
                $model2->partner_id=$model->club_id;
                $model2->project_id=$model->project_id;
                $model2->gfid=$gfUser->GF_ID;
                $model2->gf_account=$gfUser->GF_ACCOUNT;
                $model2->head_pic=$gfUser->IDNAME;
                $model2->zsxm=$model->zsxm;
                $model2->sex=$model->sex;
                $model2->native=$model->native;
                $model2->nation=$model->nation;
                $model2->birthdate=$model->real_birthday;
                $model2->id_card=trim($model->id_card);
                $model2->apply_phone=$model->phone;
                $model2->apply_email=$model->email;
                $model2->state=2;
                $model2->auth_state=931;
                $model2->entry_validity=date('Y-m-d H:i:s');
                $sc = $model2->save();

                $datas=[
                    "2102"=>["677"=>$gfUser->GF_ACCOUNT],
                    "2103"=>["677"=>$model->zsxm],
                    "2104"=>["677"=>$model->sex],
                    "2105"=>["677"=>$model->nation],
                    "2106"=>["677"=>$model->native],
                    "2107"=>["677"=>$model->real_birthday],
                    "2108"=>["677"=>trim($model->id_card)],
                    "2109"=>["677"=>''],
                    "2110"=>["677"=>''],
                    "2111"=>["677"=>$model->phone],
                    "2112"=>["677"=>$model->email],
                    "2113"=>["683"=>$gfUser->IDNAME]
                ];
                if(isset($datas))foreach($datas as $s2 => $s3){
                    $content = GfPartnerMemberContent::model()->find("apply_id=".$model2->id." and attr_id=".$s2);
                    if(empty($content)){
                        $content = new GfPartnerMemberContent();
                        $content->isNewRecord = true;
                        unset($content->id);
                    }
                    $content->apply_id = $model2->id;
                    $content->attr_id = $s2;
                    $input=GfPartnerMemberInputset::model()->find('id='.$s2);
                    $content->attr_name = $input->attr_name;
                    $content->attr_unit = $input->attr_unit;
                    foreach($s3 as $y => $y2){
                        $content->attr_value_type = $y;
                        if($y==677){
                            $content->attr_content = $y2;
                            $content->attr_value_id = '';
                            $content->attr_pic = '';
                        }
                        else if($y==678){
                            foreach($y2 as $j => $j2){
                                $content->attr_value_id = $j;
                                $content->attr_content = $j2;
                                $content->attr_pic = '';
                            }
                        }
                        else if($y==681){
                            $content->attr_content = $y2;
                            $content->attr_value_id = '';
                            $content->attr_pic = '';
                        }
                        else if($y==683){
                            $content->attr_pic = $y2;
                            $content->attr_content = '';
                            $content->attr_value_id = '';
                        }
                        else if($y==720){
                            $content->attr_content = $y2;
                            $content->attr_pic = '';
                            $content->attr_value_id = '';
                        }
                    }
                    $sc=$content->save();
                }
            }elseif($model->club_type==501){
                $cType=ClubServicerType::model()->find('type=501 and member_second_id='.$model->qualification_type);
                if($cType->if_project==649){
                    $model2=ClubQualificationPerson::model()->find('unit_state=648 and if_del=506 and gfid='.$gfUser->GF_ID.' and qualification_type_id='.$model->qualification_type.' and project_id='.$model->project_id.' and auth_state=931 and check_state=2 and free_state_Id=1202');
                }else{
                    $model2=ClubQualificationPerson::model()->find('unit_state=648 and if_del=506 and gfid='.$gfUser->GF_ID.' and qualification_type_id='.$model->qualification_type.' and auth_state=931 and check_state=2 and free_state_Id=1202');
                }
                if(empty($model2)){
                    if($cType->if_project==649){
                        $model2=ClubQualificationPerson::model()->find('unit_state=648 and if_del=506 and gfid='.$gfUser->GF_ID.' and qualification_type_id='.$model->qualification_type.' and project_id='.$model->project_id);
                    }else{
                        $model2=ClubQualificationPerson::model()->find('unit_state=648 and if_del=506 and gfid='.$gfUser->GF_ID.' and qualification_type_id='.$model->qualification_type);
                    }
                }
                
                if(empty($model2)){
                    $model2 = new ClubQualificationPerson();
                    $model2->isNewRecord = true;
                    unset($model2->id);
                }
                $model2->gfaccount=$gfUser->GF_ACCOUNT;
                $model2->gfid=$gfUser->GF_ID;
                $model2->qualification_name=$model->zsxm;
                $model2->qualification_type_id=$model->qualification_type;
                $model2->project_id=$model->project_id;
                $model2->phone=$model->phone;
                if(!empty($cType->certificate_type)){
                    $model2->identity_type=$model->identity_type;
                    $model2->identity_num=$model->qualification_num;
                }
                $score=0;
                if(!empty($model2->identity_num)){
                    $score=ServicerCertificate::model()->find('id='.$model2->identity_num);
                }
                if(!empty($score)){
                    $model2->qualification_score = $score->F_COL1;
                }
                $old = ServicerLevel::model()->find('member_second_id='.$model2->qualification_type_id.' and card_score<='.$model2->qualification_score.' and (card_end_score>='.$model2->qualification_score.')');
                if(!empty($old)){
                    $model2->qualification_level = $old->id;
                    $model2->level_name = $old->card_name;
                }
                $model2->email=$model->email;
                $model2->qualification_code=$model->qualification_code;
                $model2->start_date=$model->start_date;
                $model2->end_date=$model->end_date;
                $model2->check_state=2;
                $model2->auth_state=931;
                $model2->free_state_Id=1202;
                $model2->uDate=date('Y-m-d H:i:s');
                $model2->state_time=date('Y-m-d H:i:s');
                $model2->process_id=get_session('admin_id');
                $model2->process_account=get_session('gfaccount');
                $model2->process_nick=get_session('admin_name');
                $model2->entry_validity=date('Y-m-d H:i:s');
                $model2->expiry_date_start=date('Y-m-d H:i:s');
                $day='';
                $day=date('Y-m-d H:i:s', strtotime("".$cType->renew_time." day"));
                $model2->expiry_date_end=$day;
                $model2->pay_way=1374;
                $model2->logon_way=$model->logon_way;
                $base=BaseCode::model()->find('f_id='.$model->logon_way);
                if(!empty($base))$model2->logon_way_name=$base->F_NAME;
                $sc = $model2->save();
                if($sc==1){
                    $model->import_code=$model2->gf_code;
                }
            }elseif($model->club_type==502){
                $cType=ClubServicerType::model()->find('type=501 and member_second_id='.$model->qualification_type);
                if($cType->if_project==649){
                    $person=ClubQualificationPerson::model()->find('unit_state=648 and if_del=506 and gfid='.$gfUser->GF_ID.' and qualification_type_id='.$model->qualification_type.' and project_id='.$model->project_id.' and auth_state=931 and check_state=2 and free_state_Id=1202');
                }else{
                    $person=ClubQualificationPerson::model()->find('unit_state=648 and if_del=506 and gfid='.$gfUser->GF_ID.' and qualification_type_id='.$model->qualification_type.' and auth_state=931 and check_state=2 and free_state_Id=1202');
                }
                if(empty($person)){
                    if($cType->if_project==649){
                        $person=ClubQualificationPerson::model()->find('unit_state=648 and if_del=506 and gfid='.$gfUser->GF_ID.' and qualification_type_id='.$model->qualification_type.' and project_id='.$model->project_id);
                    }else{
                        $person=ClubQualificationPerson::model()->find('unit_state=648 and if_del=506 and gfid='.$gfUser->GF_ID.' and qualification_type_id='.$model->qualification_type);
                    }
                }
                
                if(empty($person)){
                    $person = new ClubQualificationPerson();
                    $person->isNewRecord = true;
                    unset($person->id);
                }
                $person->pay_way=1374;
                $person->logon_way=$model->logon_way;
                $base=BaseCode::model()->find('f_id='.$model->logon_way);
                if(!empty($base))$person->logon_way_name=$base->F_NAME;
                $person->gfaccount=$gfUser->GF_ACCOUNT;
                $person->gfid=$gfUser->GF_ID;
                $person->qualification_name=$model->zsxm;
                $person->qualification_type_id=$cType->member_second_id;
                $person->project_id=$model->project_id;
                $person->phone=$model->phone;
                if(!empty($cType->certificate_type)){
                    $person->identity_type=$model->identity_type;
                    $person->identity_num=$model->qualification_num;
                }
                $score=0;
                if(!empty($person->identity_num)){
                    $score=ServicerCertificate::model()->find('id='.$person->identity_num);
                }
                if(!empty($score)){
                    $person->qualification_score = $score->F_COL1;
                }
                $old = ServicerLevel::model()->find('member_second_id='.$person->qualification_type_id.' and card_score<='.$person->qualification_score.' and (card_end_score>='.$person->qualification_score.')');
                if(!empty($old)){
                    $person->qualification_level = $old->id;
                    $person->level_name = $old->card_name;
                }
                $person->email=$model->email;
                $person->qualification_code=$model->qualification_code;
                $person->start_date=$model->start_date;
                $person->end_date=$model->end_date;
                if($person->check_state!=2&&$model->logon_way==1460){
                    $person->check_state=371;
                    $person->auth_state=929;
                    $person->free_state_Id=1201;
                }else{
                    $person->check_state=2;
                    $person->auth_state=931;
                    $person->free_state_Id=1202;
                }
                $person->uDate=date('Y-m-d H:i:s');
                $person->state_time=date('Y-m-d H:i:s');
                $person->process_id=get_session('admin_id');
                $person->process_account=get_session('gfaccount');
                $person->process_nick=get_session('admin_name');
                $person->entry_validity=date('Y-m-d H:i:s');
                $person->expiry_date_start=date('Y-m-d H:i:s');
                $day='';
                $day=date('Y-m-d H:i:s', strtotime("".$cType->renew_time." day"));
                $person->expiry_date_end=$day;
                $sc = $person->save();
                
                $model2=QualificationClub::model()->find('qualification_person_id='.$person->id.' and club_id='.$model->club_id.' and state in(337)');
                if(empty($model2)){
                	$model2=QualificationClub::model()->find('qualification_person_id='.$person->id.' and club_id='.$model->club_id);
                }
                if(empty($model2)){
                    $model2 = new QualificationClub();
                    $model2->isNewRecord = true;
                    unset($model2->id);
                }
                if($model->logon_way==1460){
                    $model2->logon_way=1460;
                    $model2->logon_way_name='单位导入';
                }else{
                    $model2->logon_way=1461;
                    $model2->logon_way_name='平台导入';
                }
                $model2->club_id=$model->club_id;
                $model2->qualification_person_id=$person->id;
                $model2->project_id=$person->project_id;
                $model2->qualification_type=$person->qualification_type_id;
                if($person->check_state!=2&&$model2->state!=337&&$model->logon_way==1460){
                    $model2->state=371;
                }else{
                    $model2->state=337;
                }
                $sc = $model2->save();
                if($sc==1){
                    $model->import_code=$person->gf_code;
                }
            }
        }
        if($sa==1 && $sn==1 && $sc==1){
            $model->import_id=$model2->id;
            $model->gfid=$gfUser->GF_ID;
            $model->gf_account=$gfUser->GF_ACCOUNT;
            $model->pay_confirm=1;
            $model->pay_confirm_time=date('Y-m-d H:i:s');
            $model->adminid=get_session('admin_id');
            $model->adminname=get_session('admin_name');
            $sf = $model->save();
        }else{
            $sf = 0;
        }
        show_status($sf,'已确认',Yii::app()->request->urlReferrer,'确认失败');
    }

//逻辑删除
    public function actionDelete($id) {
        parent::_clear($id);
    }            

}