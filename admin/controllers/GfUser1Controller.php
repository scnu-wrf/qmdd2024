<?php

class GfUser1Controller extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = 'GfUser1';
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords='',$passed='',$user_state='',$realname_time='',$realname_entertime='',$real_sex='',$country='',$province='',$to_day=0, $logon_way='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $REGTIME = '';
        $criteria->condition = 'passed in(136,371,372,373)';
        if($to_day==1){
            $criteria->condition .= ' and left(REGTIME,10)="'.date('Y-m-d').'"';
        }
        $criteria->condition=get_where($criteria->condition,!empty($passed),'passed',$passed,'');
        $criteria->condition=get_where($criteria->condition,!empty($logon_way),'logon_way',$logon_way,'');
        $criteria->condition=get_where($criteria->condition,!empty($user_state),'user_state',$user_state,'');
        if($realname_time==''&&$realname_entertime==''){
            $realname_time=date('Y-m-d');
            $realname_entertime=date('Y-m-d');
        }
        $criteria->condition=get_where($criteria->condition,!empty($realname_time),'left(REGTIME,10)>=',$realname_time,'"');
        $criteria->condition=get_where($criteria->condition,!empty($realname_entertime),'left(REGTIME,10)<=',$realname_entertime,'"');
        $criteria->condition=get_where($criteria->condition,!empty($real_sex),'real_sex',$real_sex,'"');
        $criteria->condition=get_where($criteria->condition,!empty($country),'country',$country,'"');
        if ($province !== '') {
            $pr = str_replace(['省','市'],'',$province);
            $criteria->condition.=' AND PROVINCE like "%' . $pr . '%"';
        }
        $criteria->condition=get_like($criteria->condition,'GF_ACCOUNT,GF_NAME,security_phone',$keywords,'');
        $criteria->order = 'REGTIME DESC';
        $data = array();
        $data['count1'] = $model->count('left(REGTIME,10)="'.date('Y-m-d').'"');
        $data['passed'] = BaseCode::model()->getReturn('136,371,372,373');
        $data['user_state'] = BaseCode::model()->getCode(505);
        $data['real_sex'] = BaseCode::model()->getReturn('205,207');
        $data['country_name'] = TCountry::model()->findAll('is_visible=649');
        $data['logon_way'] = BaseCode::model()->getCode(1354);
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionIndex_m($keywords='',$passed='',$user_state='',$realname_time='',$realname_entertime='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'if_del=510';
        $criteria->condition=get_where($criteria->condition,!empty($passed),'passed',$passed,'');
        $criteria->condition=get_where($criteria->condition,!empty($user_state),'user_state',$user_state,'');
        $criteria->condition=get_where($criteria->condition,($realname_time!=""),'realname_time>=',$realname_time,'"');
        $criteria->condition=get_where($criteria->condition,($realname_time!=""),'realname_time<=',$realname_time,'"');
        $criteria->condition=get_like($criteria->condition,'GF_ACCOUNT,ZSXM,GF_NAME',$keywords,'');
        $criteria->order = 'REGTIME DESC';
        $data = array();
        $data['passed'] = BaseCode::model()->getCode(370);
        $data['user_state'] = BaseCode::model()->getCode(505);
        parent::_list($model, $criteria, 'index_m', $data);
    }

    /**
     * 未审核实名列表
     */
    public function actionIndex_apply($keywords='',$star_time='',$end_time='',$state=0,$country='',/*$province='',*/$real_sex='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        // $star_time=empty($star_time) ? date("Y-m-d") : $star_time;
        // $end_time=empty($end_time) ? date("Y-m-d") : $end_time;
        $criteria = new CDbCriteria;
        $criteria->condition = 'user_state=506 and passed=371';
        if($state==1){
            $realname_time='';$realname_entertime='';
            $criteria->condition = 'user_state=506 and passed=371 and left(realname_time,10)="'.date("Y-m-d").'"';
        };
        if ($star_time != '') {
            $criteria->condition.=' AND left(REGTIME,10)>="' . $star_time . '"';
        }
        if ($end_time != '') {
            $criteria->condition.=' AND left(REGTIME,10)<="' . $end_time . '"';
        }
        $criteria->condition=get_where($criteria->condition,!empty($country),'COUNTRY',$country,'"');
        // if ($province !== '') {
        //     $pr = str_replace(['省','市'],'',$province);
        //     $criteria->condition.=' AND PROVINCE like "%' . $pr . '%"';
        // }
        $criteria->condition=get_where($criteria->condition,!empty($real_sex),'real_sex',$real_sex,'"');
        $criteria->condition=get_like($criteria->condition,'GF_ACCOUNT,GF_NAME,PHONE',$keywords,'');
        $criteria->order = 'uDate DESC';
        $data = array();
        $data['count1'] = $model->count('user_state=506 and passed=371 and left(realname_time,10)="'.date("Y-m-d").'"');
        $data['country_name'] = TCountry::model()->findAll('is_visible=649');
        $data['real_sex'] = BaseCode::model()->getReturn('205,207');
        parent::_list($model, $criteria, 'index_apply', $data);
    }
    /**
     * 实名审核
     */
    public function actionIndex_exam($keywords='',$passed='',$user_state='',$REGTIME='',$realname_time='',$realname_entertime='',$nation='',$real_sex='',$id_card_type='',$country='',/*$province='',*/$city='',$state='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $realname_time=empty($realname_time) ? date("Y-m-d") : $realname_time;
        $realname_entertime=empty($realname_entertime) ? date("Y-m-d") : $realname_entertime;
        $criteria = new CDbCriteria;
        $f_id = '372,373';
        if($state==1){$passed=371;$f_id = '371';$realname_time='';$realname_entertime='';}
        $criteria->condition = 'user_state=506 and passed in('.$f_id.')';
        $criteria->condition=get_where($criteria->condition,!empty($passed),'passed',$passed,'');
        $criteria->condition=get_where($criteria->condition,!empty($nation),'nation',$nation,'"');
        $criteria->condition=get_where($criteria->condition,!empty($real_sex),'real_sex',$real_sex,'');
        $criteria->condition=get_where($criteria->condition,!empty($id_card_type),'id_card_type',$id_card_type,'');
        $criteria->condition=get_where($criteria->condition,!empty($country),'country',$country,'"');
        $criteria->condition=get_where($criteria->condition,!empty($user_state),'user_state',$user_state,'');
        if($state==1){
            if ($realname_time != '') {
                $criteria->condition.=' and left(REGTIME,10)>="' . $realname_time . '"';
            }
            if ($realname_entertime != '') {
                $criteria->condition.=' and left(REGTIME,10)<="' . $realname_entertime . '"';
            }
        }else{
            if ($realname_time != '') {
                $criteria->condition.=' and left(examine_time,10)>="' . $realname_time . '"';
            }
            if ($realname_entertime != '') {
                $criteria->condition.=' and left(examine_time,10)<="' . $realname_entertime . '"';
            }
        }
        $criteria->condition=get_like($criteria->condition,'GF_ACCOUNT,GF_NAME,ZSXM,PHONE',$keywords,'');
        // if ($province !== '') {
        //     $pr = str_replace(['省','市'],'',$province);
        //     $criteria->condition.=' and PROVINCE like "%' . $pr . '%"';  //  OR PROVINCE like "%'.$province.'省'.'%" OR PROVINCE like "%'.$province.'市'.'%"
        // }
        $criteria->order = 'find_in_set(`passed`,"136,721"),uDate DESC';
        $data = array();
        $data['passed'] = BaseCode::model()->getReturn($f_id);
        $data['nation'] = Nation::model()->findAll();
        $data['real_sex'] = BaseCode::model()->getReturn('205,207');
        $data['id_card_type'] = BaseCode::model()->getCode(842);
        $data['user_state'] = BaseCode::model()->getCode(505);
        $data['country_name'] = TCountry::model()->findAll('is_visible=649');
        $data['count1'] = $model->count('user_state=506 and passed=371');
        $data['realname_time'] = $realname_time;
        $data['realname_entertime'] = $realname_entertime;
        parent::_list($model, $criteria, 'index_exam', $data);
    }

    public function actionIndex_unregist($keywords='',$time_start='',$time_end='',$passed=''){
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $date=date('Y-m-d H:m:s');
        $time_start=empty($time_start) ? date("Y-m-d") : $time_start;
        $time_end=empty($time_end) ? date("Y-m-d") : $time_end;
        if($passed==136){
            $criteria->condition = 'end_valid_date<>"长期" and end_valid_date<"'.$date.'"';
            $criteria->condition = get_where($criteria->condition,!empty($time_start),'left(REGTIME,10)>=',$time_start,'"');
            $criteria->condition = get_where($criteria->condition,!empty($time_end),'left(REGTIME,10)<=',$time_end,'"');
        }elseif($passed==373){
            $criteria->condition = get_where($criteria->condition,!empty($time_start),'left(examine_time,10)>=',$time_start,'"');
            $criteria->condition = get_where($criteria->condition,!empty($time_end),'left(examine_time,10)<=',$time_end,'"');
        }
        $criteria->condition=get_where($criteria->condition,!empty($passed),'passed',$passed,'');
        $criteria->condition = get_like($criteria->condition,'GF_ACCOUNT,GF_NAME',$keywords,'');
        if($passed==136){
            $criteria->order = 'REGTIME DESC';
        }elseif($passed==373){
            $criteria->order = 'examine_time DESC';
        }
        $data = array();
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        parent::_list($model,$criteria,'index_unregist',$data);
    }
    /**
     * 实名会员
     */
    public function actionIndex_real_name($valid_date='',$end_valid_date='',$keywords='',$nation='',$real_sex='',$id_card_type='',$state=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        // $f_id = '372';

        $criteria->condition = 'user_state in(506,507,1282,1283) and passed=372';
        if($state==1){
            // $criteria->condition = 'user_state=506 and passed=372 and left(realname_entertime,10)='.date("Y-m-d");
            $criteria->condition=get_where($criteria->condition,!empty($state),'left(realname_entertime,10)',date("Y-m-d"),'');
        };
        $criteria->condition=get_where($criteria->condition,!empty($nation),'nation',$nation,'"');
        $criteria->condition=get_where($criteria->condition,!empty($real_sex),'real_sex',$real_sex,'');
        $criteria->condition=get_where($criteria->condition,!empty($id_card_type),'id_card_type',$id_card_type,'');
        if($valid_date==''){
            $valid_date=date('Y-m-d');
        }else{
            $valid_date=$valid_date;
        }
        if($end_valid_date==''){
            $end_valid_date=date('Y-m-d');
        }else{
            $end_valid_date=$end_valid_date;
        }
        $criteria->condition=get_where($criteria->condition,!empty($valid_date),'left(realname_entertime,10)>=',$valid_date,'"');
        $criteria->condition=get_where($criteria->condition,!empty($end_valid_date),'left(realname_entertime,10)<=',$end_valid_date,'"');
        $criteria->condition=get_like($criteria->condition,'GF_ACCOUNT,GF_NAME,ZSXM,security_phone,id_card',$keywords,'');
        $criteria->order = 'realname_entertime DESC';
        $data = array();
        $data['nation'] = Nation::model()->findAll();
        $data['real_sex'] = BaseCode::model()->getReturn('205,207');
        $data['id_card_type'] = BaseCode::model()->getCode(842);
        $data['country_name'] = TCountry::model()->findAll('is_visible=649');
        $data['count1'] = $model->count('user_state=506 and passed=372 and left(realname_entertime,10)="'.date("Y-m-d").'"');
        $data['valid_date'] = $valid_date;
        $data['end_valid_date'] = $end_valid_date;
        parent::_list($model, $criteria, 'index_real_name', $data);
    }

    public function actionGetUser() {
        $modelName = $this->model;
        $gf="0";//
        if (isset($_REQUEST['gfaccount'])) { $gf=$_REQUEST['gfaccount'];};
        $data = array();
        $model= $modelName::model()->find("GF_ACCOUNT='".$gf."'");
        $data['GF_ACCOUNT']="";
        if(isset($model->GF_ACCOUNT))
        if($model->GF_ACCOUNT==$gf){
            $data['GF_ID']=$model->GF_ID;
            $data['GF_ACCOUNT']=$model->GF_ACCOUNT;
            $data['passed']=$model->passed;
        }
        echo CJSON::encode($data);
    }
    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('create', $data);
        } else {
			$this->saveData($model,$_POST[$modelName]);
        }
    }
    public function actionUpdate_c($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('create', $data);
        } else {
			$this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
			$this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate_m($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_m', $data);
        } else {
			$this->saveData($model,$_POST[$modelName]);
        }
    }

	// 昵称是否存在
    public function actionExist($name=0) {
        $count=GfUser1::model()->count('GF_NAME="'.$name.'"');
        if($count>0) {
            ajax_status(0, '该昵称已被注册');
        }

    }

    /**
     * 实名审核
     */
    public function actionUpdate_exam($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_exam', $data);
        } else {
			$this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionLook($gf_account){
        // set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = ClubMemberList::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'gf_account='.$gf_account;
        $criteria->order = 'udate';
        $data = array();
        parent::_list($model, $criteria, 'look', $data);
    }

    public function actionHistory($gf_id){
        // set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = GfUserLoginHistory::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'gf_id='.$gf_id;
        $criteria->order = 'login_time DESC';
        $data = array();
        parent::_list($model, $criteria, 'history', $data, 50);
    }

	// function saveData($model,$post) {
 //        $model->attributes =$post;
 //        $i = '保存成功'; $f = '保存失败';
 //        if($_POST['submitType']=='quxiao'){
 //            $model->passed = 136;
 //            $model->end_valid_date = date("Y-m-d",strtotime('+30day'));
 //            $i = '注册成功'; $f = '注册失败';
 //        }else{
 //            $model->passed =get_check_code($_POST['submitType']);
 //        }
 //        if($model->passed==721){ $i = '取消成功'; $f = '取消失败';}
 //        if($model->passed==372&&$_POST['submitType']=='tongguo'){
 //            if(empty($model->GF_ID)){
 //                $qp=GfUser1::model()->find("id_card_type=".$model->id_card_type." and id_card='".$model->id_card."'");
 //            }else{
 //                $qp=GfUser1::model()->find("GF_ID<>".$model->GF_ID." and id_card_type=".$model->id_card_type." and id_card='".$model->id_card."'");
 //            }
 //        }
 //        if(!empty($qp)){
 //            $st=0;
 //            $f = '实名审核失败，该证件已实名';
 //        }else{
 //            $st=$model->save();
 //        }
 //        if($st==1){
 //            if($_GET['r']=='gfUser1/create'){
 //                // GfIdelUser::model()->deleteAll('non_account='.$model->GF_ACCOUNT);
 //                $mo = GfIdelUserAllNumber::model()->find('account='.$model->GF_ACCOUNT);
 //                $mo->is_use=1;
 //                $sn=$mo->update($mo);
 //            }
 //            if($model->passed==372){
 //                $i = '审核成功'; $f = '审核失败';
 //                system_message1($model->GF_ID,'恭喜您实名登记成功！');
 //            } else if($model->passed==373) {
 //                system_message1($model->GF_ID,'实名登记审核未通过');
 //            }
 //        }
 //        //$errors = array();
 //        show_status($st,$i,get_cookie('_currentUrl_'),$f);
 //    }

    function saveData($model,$post) {
        // $model = new GfUser1;
        // $model->setIsNewRecord(false);
        $model->attributes =$post;
        $i = '保存成功'; $f = '保存失败';
        if($_POST['submitType']=='quxiao'){
            $model->passed = 136;
            $model->end_valid_date = date("Y-m-d",strtotime('+30day'));
            $i = '注册成功'; $f = '注册失败';
        }else{
            $model->passed =get_check_code($_POST['submitType']);
        }
        if($model->passed==721){ $i = '取消成功'; $f = '取消失败';}
        $gid=empty($model->GF_ID) ? "0" : $model->GF_ID;
        $w1 ="id_card_type='".$model->id_card_type."'";
        $w1.=" and id_card='".$model->id_card."' and GF_ID<>'".$gid."'";
        $qp=GfUser1::model()->find($w1);
        if(!empty($qp)){
            $st=0;
            $f = '该证件已冲突！！';
        }else{
            $st=$model->save();
            // $st=$model->update($post);
            // $record = new GfUser1;
            // unset($record->id);
            // $st=0;
        }
        if($st==1 &&$gid=='0'){
            $rs=array('is_use'=>1);
            GfIdelUserAllNumber::model()->updataAll($rs,'account='.$model->GF_ACCOUNT);
        }
        //$errors = array();
        show_status($st,$i,get_cookie('_currentUrl_'),$f);
        // sleep(1);
    }

    // 删除未登记
    public function actionDelete1($id) {
        parent::_clear($id);
    }

	//逻辑删除
    public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
		$club=explode(',', $id);
        $count=0;
		foreach ($club as $d) {
			$model->updateByPk($d,array('if_del'=>509));
			$count++;
		}
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }

    // public function actionProvince($id){
    //     // $province = TRegion::model()->findAll(array('select'=>array('id','country_id','region_name_c'),'condition'=>'country_id='.$id.' and level=1'));
    //     $province = TRegion::model()->findAll(array('select'=>array('id','country_id','region_name_c'), 'order'=>'id','condition'=>'country_id='.$id.' and level=1'));
    //     $rows = array();
    //     foreach($province as $i=>$user) {
    //         $rows[$i]['id'] = $user->id;
    //         $rows[$i]['country_id'] = $user->country_id;
    //         $rows[$i]['region_name_c'] = $user->region_name_c;
    //     }
    //     // if(!empty($rows)){
    //         echo json_encode($rows);
    //     // }
    // }

    public function actionProvince($id=41){
        if(!is_numeric($id)) $id=41;
        $province = TRegion::model()->findAll('country_id='.$id.' and level=1');
        $rows = toArray($province,'id,country_id,region_name_c');
        echo json_encode($rows);
    }

    public function actionIndex_pretty($keywords='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'GF_NAME="保留号" and user_state=507';
        $criteria->condition=get_like($criteria->condition,'GF_ACCOUNT',$keywords,'');
        $criteria->order = 'GF_ACCOUNT';
        $data = array();
        parent::_list($model, $criteria, 'index_pretty', $data,500);
    }
    public function actionCancel($id,$al) {
        $ids = explode(',',$id);
        foreach($ids as $d){
            $modelName = $this->model;
            $model = $this->loadModel($d, $modelName);
            // $gf_idel_user = GfIdelUser::model()->find('non_account='.$model->GF_ACCOUNT);
            // if(empty($gf_idel_user)){
                // $gf_idel_user = new GfIdelUser();
                // $gf_idel_user->isNewRecord=true;
                // unset($gf_idel_user->id);
            // }
            // $gf_idel_user->non_account=$model->GF_ACCOUNT;
            // $gf_idel_user->is_use=0;
            // $gf_idel_user->f_vip=1;
            // $sn=$gf_idel_user->save();

			$mo = GfIdelUserAllNumber::model()->find('account='.$model->GF_ACCOUNT);
			$mo->is_use=0;
			$sn=$mo->update($mo);

            // $lock_model=GfUserLock::model()->find('GF_ID='.$d);
            // if(empty($lock_model)){
                $lock_model = new GfUserLock;
                $lock_model->isNewRecord = true;
                unset($lock_model->ID);
            // }
            $lock_model->GF_ID=$model->GF_ID;
            $lock_model->GF_ACCOUNT=$model->GF_ACCOUNT;
            $lock_model->GF_NAME=$model->GF_NAME;
            $lock_model->ZSXM=$model->ZSXM;
            $lock_model->if_del=510;
            $lock_model->user_state=649;
            $lock_model->user_state_name='是';
            $lock_model->admin_gfid=get_session('gfid');
            $lock_model->admin_gfname=get_session('admin_name');
            $lock_model->lock_reason='系统注销';
            $lock_model->uDate=date('Y-m-d H:i:s');
            $lock_model->security_phone_country_code=$model->security_phone_country_code;
            $lock_model->security_phone=$model->security_phone;
            $sv=$lock_model->save();

            if($sn==1&&$sv==1){
                $this->notice(2,$lock_model->ID);
                ThirdPartyLogin::model()->updateAll(array('logout'=>649),'gf_id='.$lock_model->GF_ID);
                $model->deleteAll('GF_ID in(' . $d . ')');
				$clubMember=ClubMember::model()->find('member_gfid='.$d);
				if(count($clubMember)>0){
					$clubMember->deleteAll('member_gfid='.$d);
				}
            }
        }
        show_status($sn,$al,Yii::app()->request->urlReferrer,'失败');
    }

    // 解冻gf账号列表
    public function actionIndex_thaw($keywords='',$user_state='') {
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'user_state in(1282,1283,507)';
        $day=date('Y-m-d H:i:s',strtotime('+3 day'));
        if($user_state==1282){
            $criteria->condition=get_where($criteria->condition,!empty($user_state),'user_state',$user_state,'');

        }elseif($user_state==1283){
            $criteria->condition=get_where($criteria->condition,!empty($user_state),'user_state',$user_state,'');
        }elseif($user_state==507){
            $criteria->condition=get_where($criteria->condition,!empty($user_state),'user_state',$user_state,'');
        }
        if(empty($user_state)){
            $criteria->condition .= ' and lock_date_end<="'.$day.'" and lock_date_end>="'.date('Y-m-d H:i:s').'"' ;
        }

        $criteria->order = 'GF_ID DESC';
        $criteria->condition=get_like($criteria->condition,'GF_ACCOUNT,GF_NAME',$keywords,'');
        $data = array();
        parent::_list($model, $criteria, 'index_thaw', $data);
    }

    public function  actionTothaw(){
        $GF_ID = $_GET['GF_ID'];
        $GF_IDArray = explode(",",$GF_ID);

        $thawMode = $_GET['thawMode'];
        foreach ($GF_IDArray as $v1){
            $user = GfUser1::model()->find('GF_ID='.$v1);
            $user->user_state=506;
            if ($thawMode == 0){
                $user->valid_date=date('Y-m-d H:i:s');
            }elseif ($thawMode == 1 && $user->user_state!=507){
                $user->valid_date=$user->lock_date_end;
            }

            $user1 = new GfUserLock;
            $user1->isNewRecord = true;
            unset($user1->ID);
            $user1->GF_ID=$v1;
            $user1->user_state=506;
            $user1->lock_date_start=$user->lock_date_start;
            $user1->lock_date_end=$user->lock_date_end;
            if ($thawMode == 0){
                $user1->lock_date_end=date('Y-m-d H:i:s');
                $user->lock_date_end=date('Y-m-d H:i:s');
            }
            $b=BaseCode::model()->find('f_id='.$user1->user_state);
            $user1->user_state_name=$b->F_NAME;
            $user1->remedy_btn=$thawMode;
            $user1->admin_gfid=get_session('admin_id');
            $user1->admin_gfname=get_session('admin_name');
            $sv=$user->save();
            if($sv==1){
                $sv=$user1->save();
            }
            if($sv==1){
                $this->notice(0,$user1->ID);
            }
        }
        show_status($sv,'解冻成功'.$user->valid_date.'开始生效',Yii::app()->request->urlReferrer,'操作失败');
    }

    // 334——GF账号注销／冻结／解冻通知，前端接收通知后弹出提示
    // 1、"type": "邀请函", //类型
    // 2、"title": "海南中数", //标题
    // 3、"content":"内容",//提示：因何原因注销／冻结，冻结时间内容
    // 4、"content_html":"内容",// html格式的内容简要，纯文字 (优先使用该数据显示，如该内容为空字符时，使用content显示)
    // 5、gf_state状态 ：0-正常，1-冻结，2-注销；
    // 6、state_name 操作状态名，如：冻结7天
	function notice($gf_state,$lock_id){
        $admin_id = get_session('admin_id');
        $lock=GfUserLock::model()->find('ID='.$lock_id);
        if($gf_state==0){
            $type = '【解冻通知】';
        }elseif($gf_state==1){
            $type = '【冻结通知】';
        }elseif($gf_state==2){
            $type = '【注销通知】';
        }
        $base_code=BaseCode::model()->find('f_id='.$lock->user_state);
        if($lock->user_state==649){
            $content='GF账号（'.$lock->GF_ACCOUNT.'）违反了账号使用规范，已被注销收回。如有疑问，请联系客服！';
        }elseif($lock->user_state==506){
            $content='GF账号（'.$lock->GF_ACCOUNT.'）已解冻，解除限制后可正常登陆使用。';
        }
		$data = array(
			'type' => $type,
			'content' => $content,
			'gf_state' => $gf_state,
			'state_name' => $base_code->F_NAME
        );
        send_msg(334,$admin_id,$lock->GF_ID,$data);
	}
    //选择账号 后端
    public function actionSelectUser($keywords = '',$real_sex=0,$ms_start='',$ms_end='',$passed_name='',$code=0,$lang_type=0,$logon_way='') {
        $data = array();
        $model = GfUser1::model();
        $criteria = new CDbCriteria;
        if($keywords!='')
            $criteria->addSearchCondition('security_phone',$keywords);
        else $criteria->addCondition('security_phone <> ""');
        if($passed_name!=''){
            $criteria->addCondition('passed_name="'.$passed_name.'"');
        }
        if($logon_way!=''){
            $criteria->addCondition('passed_name="'.$logon_way.'"');
        }
        parent::_list($model, $criteria, 'select', $data);
    }
    public function actionSelectAdminUser($keywords = '') {
        $data = array();
        $model = QmddAdministrators::model();
        $criteria = new CDbCriteria;
        if($keywords!='')
            $criteria->addSearchCondition('club_code',$keywords);
        else $criteria->addCondition('club_code <> ""');
        parent::_list($model, $criteria, 'select', $data);
    }
    //小程序登录/注册 小程序接口
    public function actionwxLogin($code,$phone_code=""){
        $openid=GfUser1::model()->getwxOpenid($code);
        //
        $user=GfUser1::model()->find('openid="'.$openid.'"');
        //没有注册就注册一下
        if(empty($user)&&$phone_code){
            $user = GfUser1::model()->newWxUser($openid,$phone_code);
        }
        $res=$user->getWxInfo();
        if(empty($res)) $res=array();
        $code = empty($res['id'])?201:200;
        JsonSuccess($res,$code);
    }
    //更新基本信息 小程序接口
    public function actionwxUpdateBaseInfo($data){
        $data = json_decode($data);
        $openid = $data->openid;
        $user=GfUser1::model()->find('openid="'.$openid.'"');
        if(!$user){
            JsonSuccess('用户不存在','500');return;
        }
        $user->updateBaseInfo($data)?JsonSuccess($user->getWxInfo()):JsonSuccess('保存失败','501');
    }
    //提交角色申请
    public function actionwxClaimRole($data){
        $data = json_decode($data,true);
        $openid = $data['openid'];
        $user=GfUser1::model()->find('openid="'.$openid.'"');
        if(!$user){
            JsonSuccess('用户不存在','500');return;
        }
        //检查是否重复
        $check = GfUserRole::model()->checkDump($user->GF_ID,$data['type'],$data['code']);
        if(!empty($check)){
            $code="201";
            switch($check->state){
                case 371:$code='201';break;//等待审核中
                case 372:$code='202';break;//审核通过
                default:$code="201";
            }
            JsonSuccess('已有记录',$code);
            return;
        }
        $user->claimRole($data)?JsonSuccess('提交成功'):JsonSuccess('保存失败','501');
    }
    //角色申请页面初始化 小程序接口
    //1.身份类型
    //2.可选的场馆与俱乐部
    public function actionwxClaimRoleInit(){
        //1
        $roles = GfUSerRole::model()->getRoles();
        //2 todo 等场馆，场地与俱乐部的模型
        $sta=GfUSerRole::model()->getMultiselection();
        $res = array();
        $res['roles']=$roles;
        $res['sta']=$sta;
        JsonSuccess($res);
    }
    //阿里云实名认证 小程序接口
    public function actionwxRealNameAuthen($name,$idNo,$openid){
        $user=GfUser1::model()->find('openid="'.$openid.'"');
        if(!$user){
            JsonSuccess('用户不存在','500');return;
        }
        $data=$user->readlNameAuthen($name,$idNo);
        if($data['respCode']!="0000"){//匹配失败
            $msg=$data["respMessage"];
            JsonSuccess($msg,'201');return;
        }
        //绑定信息
        JsonSuccess();
    }
    //获取场馆信息 小程序接口
    public function actionGetStadiumList(){
        JsonSuccess(GfUSerRole::model()->stadiumList());
    }
    public function actionUploadHeadPic(){
        $data = array();
        $file1=$_FILES['file'];
        $openid=$_POST['openid'];//更改图片名字为openid
        if(empty($file1)||$file1['error']==4) {JsonFail('上传失败，稍后再试');return;}
        if($file1['error']==5) {JsonFail('上传失败，上传文件大小为0');return;}
        if($file1['error']==1) {JsonFail('上传文件大小超出范围');return;}
        //修改php.ini中的upload_max_filesize来增大范围
        $attach = CUploadedFile::getInstanceByName('file');
        $pathDetail = '/uploads/userHeadPic/';//服务器储存图片的相对路径
        $savepath = ROOT_PATH . $pathDetail;//服务器路径
        $sitepath = SITE_PATH . $pathDetail;//小程序数据库路径
        $prefix='';
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'content-type:application/octet-stream',
                'content' => file_get_contents($attach->tempName),
            ),
        );
        $file = stream_context_create($options);
        $fileName=$openid.date('Y-m-d-H-i-s'). '.'.$attach->extensionName;
        if($attach->saveAs($savepath.$fileName))
        {
            $model=GfUser1::model()->find('openid="'.$openid.'"');
            $model->TXADD = $sitepath.$fileName;
            $model->save();
            JsonSuccess($model->TXADD);return;
        } 
        JsonFail('保存失败');
    }
    /**
     * 新增角色页面 后端
     */
    public function actionupdateRole($id){
        $data=array();
        $user = GfUser1::model()->find('GF_ID='.$id);
        $role = new GfUserRole;
        if(!Yii::app()->request->isPostRequest){
            $staList = testStadium::model()->findAll();//场馆信息
            $venList = testVenue::model()->findAll();//场地信息
            $clubList =testUnion::model()->findAll();//俱乐部信息
            $data['staList']=$staList;
            $data['user']=$user;
            $data['venList']=$venList;
            $data['clubList']=$clubList;
            $data['role']=$role;
            $this->render('update_role',$data);
        }
        else{
            $post =$_POST['GfUserRole'];
            $roleCode = $post['roleCode'];
            $code = $post['code'];
            $roles = GfUserRole::model()->getRoles();
            $temp=GfUserRole::model()->checkValid($roleCode,$code);
            if(empty($temp)){
                show_status(0,'',get_cookie('_currentUrl_'),'标识码为'.$code.'的'.$roles[$roleCode].'不存在');
                return;
            }
            $msg = array(
                'staCode'=>'',
                'type'=>$roleCode,
                'code'=>$code,
                'name'=>$temp->name,
            );
            //查重
            //检查是否重复
            $check = GfUserRole::model()->find('userId='.$user->GF_ID.' and code="'.$code.'"');
            if(!empty($check)){
                if($check->state==371||$check->state==372)
                    show_status(0,'添加成功',get_cookie('_currentUrl_'),'已有相同申请，请检查审核列表或审核记录');
                return;
            }
            show_status($user->claimRole($msg),'添加成功',get_cookie('_currentUrl_'),'添加失败');
        }
    }
    //获取用户的角色申请历史 小程序接口
    public function actionGetClaimHistory($openid){
        $user = GfUser1::model()->find('openid="'.$openid.'"');
        if(!$user){
            //出现这种情况代表非法访问接口
            JsonFail('用户不存在');return;
        }
        JsonSuccess($user->getClaimHistory());
    }

}
