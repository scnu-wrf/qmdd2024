<?php

class GfUserLockController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    // gf账号已冻结列表
    public function actionIndex_lock_list($keywords='',$user_state='',$start_date = '', $end_date = '') {

        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        // $start_date == '';
        // $end_date == '';
        if(Yii::app()->request->getParam('state') == 0) {
        //     if($start_date == '') $start_date = date('Y-m-d');
        //     if($end_date == '') $end_date = date('Y-m-d');
        // }else {}
            $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
            $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        }

        $criteria = new CDbCriteria;
        $criteria->condition = 'user_state in(506,507,1282,1283,1284)';    // and state = 2
        if(Yii::app()->request->getParam('state') == 0) {
            $criteria->condition .= ' and remedy_btn = 0 and user_state not in (648,649) or unix_timestamp(lock_date_end) < unix_timestamp(now()) and user_state not in (648,649)';
        }else if(Yii::app()->request->getParam('state') == 1) {
            $criteria->condition .= ' and remedy_btn = 1 and lock_date_end = \'9999-09-09 00:00:00\' and user_state not in (648,649) or unix_timestamp(lock_date_end) > unix_timestamp(now()) and remedy_btn = 1 and user_state not in (648,649)';
        }else if(Yii::app()->request->getParam('state') == 2) {
            $criteria->condition .= ' and remedy_btn = 1 and lock_date_end not in (\'9999-09-09 00:00:00\') and unix_timestamp(lock_date_end) <= unix_timestamp(now())+259200 and unix_timestamp(lock_date_end) >= unix_timestamp(now())';
        }
        $criteria->order = 'uDate DESC';
        if(Yii::app()->request->getParam('state') == 1) {
            $criteria->condition=get_where($criteria->condition,$start_date,'lock_date_start>=',$start_date.' 00:00:00',"'");
        }else /*if(Yii::app()->request->getParam('state') == 0)*/{
            $criteria->condition=get_where($criteria->condition,$start_date,'lock_date_end>=',$start_date.' 00:00:00',"'");
        }
        $criteria->condition=get_where($criteria->condition,$end_date,'lock_date_end<=',$end_date.' 23:59:59',"'");
        $criteria->condition=get_where($criteria->condition,!empty($user_state),'user_state',$user_state,'');
        $criteria->condition=get_like($criteria->condition,'GF_ACCOUNT,ZSXM,GF_NAME',$keywords,'');

/*        if ($start_date != '') {
            $criteria->condition.=' AND left(uDate,10)>="' . $start_date . '"';
        }

        if ($end_date != '') {
            $criteria->condition.=' AND left(uDate,10)<="' . $end_date . '"';
        }*/

        $data = array();
        $data['count1'] = $model->count('user_state in(506,507,1282,1283,1284) and remedy_btn = 1 and lock_date_end = \'9999-09-09 00:00:00\' or unix_timestamp(lock_date_end) > unix_timestamp(now()) and remedy_btn = 1 and user_state in(506,507,1282,1283,1284)');
        $data['user_state'] = BaseCode::model()->getCode(505);
        $data['startDate']=$start_date;
        $data['endDate']=$end_date;
        parent::_list($model, $criteria, 'index_lock_list', $data);
    }

    // 申请冻结列表
    public function actionIndex($keywords='',$user_state='',$start_date = '', $end_date = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        // $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
        // $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        $criteria = new CDbCriteria;
        $criteria->condition = 'if_del = 510 and user_state not in (648,649) and lock_way not in (0,1)';
        // $criteria->condition .= 'and lock_state = 371';
        $criteria->order = 'uDate DESC';
        // $criteria->condition=get_where($criteria->condition,!empty($start_date),'uDate',$start_date,'"');
        // $criteria->condition=get_where($criteria->condition,!empty($end_date),'uDate',$end_date,'"');
        $criteria->condition=get_where($criteria->condition,!empty($user_state),'user_state',$user_state,'');
        $criteria->condition=get_like($criteria->condition,'GF_ACCOUNT,ZSXM,GF_NAME',$keywords,'');
        /* if ($start_date != '') {
            $criteria->condition.=' AND left(uDate,10)>="' . $start_date . '"';
        }

        if ($end_date != '') {
            $criteria->condition.=' AND left(uDate,10)<="' . $end_date . '"';
        } */
        $data = array();
        $data['user_state'] = BaseCode::model()->getCode(505);
        // $data['startDate']=$start_date;
        // $data['endDate']=$end_date;
        parent::_list($model, $criteria, 'index', $data);
    }

    // 冻结审核列表
    public function actionIndex_lock_exam($keywords = '', $user_state = '', $start_date = '', $end_date = '', $state) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        if($start_date == '' && $_REQUEST['state'] == '0') $start_date = date('Y-m-d');
//        $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
//        $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        $criteria = new CDbCriteria;
        $criteria->condition = 'if_del = 510';
        if(Yii::app()->request->getParam('state') == 1) {
            $criteria->condition .= ' and state = 371';
        }else if(Yii::app()->request->getParam('state') == 0) {
            $criteria->condition .= ' and state in (2,373)';
        }
        $criteria->condition .= ' and user_state not in (648,649) and lock_way not in (0,1)';
        $criteria->order = 'uDate DESC';

        $criteria->condition=get_where($criteria->condition,$start_date,'uDate>=',$start_date.' 00:00:00',"'");
        $criteria->condition=get_where($criteria->condition,$end_date,'uDate<=',$end_date.' 23:59:59',"'");
        $criteria->condition=get_where($criteria->condition,!empty($user_state),'user_state',$user_state,'');
        $criteria->condition=get_like($criteria->condition,'GF_ACCOUNT,ZSXM,GF_NAME',$keywords,'');
/*        if ($start_date != '') {
            $criteria->condition.=' AND left(uDate,10)>="' . $start_date . '"';
        }

        if ($end_date != '') {
            $criteria->condition.=' AND left(uDate,10)<="' . $end_date . '"';
        }*/
        $data = array();
        $data['count1'] = $model->count('state = 371 and lock_way not in (0,1)');
        $data['user_state'] = BaseCode::model()->getCode(505);
        $data['startDate']=$start_date;
        $data['endDate']=$end_date;
        parent::_list($model, $criteria, 'index_lock_exam', $data);
    }

    // 解冻确认列表
    // public function actionIndex_lock_release($keywords='',$user_state='',$start_date = '', $end_date = '', $state) {
    //     set_cookie('_currentUrl_', Yii::app()->request->url);
    //     $modelName = $this->model;
    //     $model = $modelName::model();
    //     if($start_date == '') $start_date = date('Y-m-d');
    //     $criteria = new CDbCriteria;
    //     $criteria->condition = 'user_state in(506,507,1282,1283,1284)';
    //     $criteria->order = 'uDate DESC';
    //     $criteria->condition=get_where($criteria->condition,$start_date,'uDate>=',$start_date.' 00:00:00',"'");
    //     $criteria->condition=get_where($criteria->condition,$end_date,'uDate<=',$end_date.' 23:59:59',"'");
    //     $criteria->condition=get_where($criteria->condition,!empty($user_state),'user_state',$user_state,'');
    //     $criteria->condition=get_like($criteria->condition,'GF_ACCOUNT,ZSXM,GF_NAME',$keywords,'');
    //     $data = array();
    //     $data['count1'] = $model->count('if_del=510'); // 待确认解冻
    //     $data['count2'] = $model->count('if_del=510'); // 超时未解冻
    //     $data['user_state'] = BaseCode::model()->getCode(505);
    //     $data['startDate']=$start_date;
    //     $data['endDate']=$end_date;
    //     parent::_list($model, $criteria, 'index_lock_release', $data);
    // }

    // gf账号注销列表
    // public function actionIndex_can($keywords='',$start_date = '', $end_date = '') {
    //     set_cookie('_currentUrl_', Yii::app()->request->url);
    //     $modelName = $this->model;
    //     $model = $modelName::model();
    //     $start_date=empty($start_date) ? date("Y-m-d", strtotime("-1 month")) : $start_date;
    //     $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
    //     $criteria = new CDbCriteria;
    //     $criteria->condition = 'user_state in(648,649)';
    //     $criteria->order = 'uDate DESC';
    //     $criteria->condition=get_like($criteria->condition,'GF_ACCOUNT,ZSXM,GF_NAME',$keywords,'');
    //     if ($start_date != '') {
    //         $criteria->condition.=' AND left(uDate,10)>="' . $start_date . '"';
    //     }

    //     if ($end_date != '') {
    //         $criteria->condition.=' AND left(uDate,10)<="' . $end_date . '"';
    //     }
    //     $data = array();
    //     $data['startDate']=$start_date;
    //     $data['endDate']=$end_date;
    //     parent::_list($model, $criteria, 'index_can', $data);
    // }

    public function actionIndex_shutdown($keywords='',$start_date = '', $end_date = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $start_date=empty($start_date) ? date("Y-m-d", strtotime("-1 month")) : $start_date;
        $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        $criteria = new CDbCriteria;
        $criteria->condition = 'user_state in(506,648,649) and lock_way not in (507,1282,1283)';
        $criteria->order = 'uDate DESC';
        $criteria->condition=get_like($criteria->condition,'GF_ACCOUNT,ZSXM,GF_NAME',$keywords,'');
        if ($start_date != '') {
            $criteria->condition.=' AND left(uDate,10)>="' . $start_date . '"';
        }

        if ($end_date != '') {
            $criteria->condition.=' AND left(uDate,10)<="' . $end_date . '"';
        }
        $data = array();
        $data['startDate']=$start_date;
        $data['endDate']=$end_date;
        parent::_list($model, $criteria, 'index_shutdown', $data);
    }

    public function actionIndex_shutdown_exam($keywords='',$start_date = '', $end_date = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        if(Yii::app()->request->getParam('state') == 0) {
            $start_date=empty($start_date) ? date("Y-m-d", strtotime("-1 month")) : $start_date;
            $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        }
        $criteria = new CDbCriteria;
        if(Yii::app()->request->getParam('state') == 1) {
            $criteria->condition = 'user_state in (506,648,649) and lock_way in (0,1) and state = 371';
        }else if(Yii::app()->request->getParam('state') == 0) {
            $criteria->condition = 'user_state in (506,648,649) and lock_way in (0,1) and state in (2,373)';
        }
        $criteria->order = 'uDate DESC';
        $criteria->condition=get_like($criteria->condition,'GF_ACCOUNT,ZSXM,GF_NAME',$keywords,'');
        if ($start_date != '') {
            $criteria->condition.=' AND left(uDate,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' AND left(uDate,10)<="' . $end_date . '"';
        }
        $data = array();
        $data['count1'] = $model->count('lock_way in (0,1) and state = 371');
        $data['startDate']=$start_date;
        $data['endDate']=$end_date;
        parent::_list($model, $criteria, 'index_shutdown_exam', $data);
    }

    public function actionIndex_shutdown_list($keywords='',$start_date = '', $end_date = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $start_date=empty($start_date) ? date("Y-m-d", strtotime("-1 month")) : $start_date;
        $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        $criteria = new CDbCriteria;
        $criteria->condition = 'user_state in(649)';
        $criteria->order = 'uDate DESC';
        $criteria->condition=get_like($criteria->condition,'GF_ACCOUNT,ZSXM,GF_NAME',$keywords,'');
        if ($start_date != '') {
            $criteria->condition.=' AND left(uDate,10)>="' . $start_date . '"';
        }

        if ($end_date != '') {
            $criteria->condition.=' AND left(uDate,10)<="' . $end_date . '"';
        }
        $data = array();
        $data['startDate']=$start_date;
        $data['endDate']=$end_date;
        parent::_list($model, $criteria, 'index_shutdown_list', $data);
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
			$this->saveData($model, $_POST[$modelName]);
        }
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $model->isNewRecord = true;
        unset($model->ID);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
			$this->saveData($model, $_POST[$modelName]);
        }
    }

    // 审核详情
    public function actionUpdate_exam($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            // $data['user_state'] = 649;
            $this->render('update_exam', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }

	function saveData($model,$post) {
        $model->attributes = $post;
        $st=$model->save();
        show_status($st, '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }

    // gf会员账冻结号处理
    public function actionAddForm(){
        // $model=GfUserLock::model()->find('GF_ID='.$_POST['gf_id']);
        $gfUser=userlist::model()->find('GF_ID='.$_POST['gf_id']);
        if(isset($_POST['gf_id'])){
            // if(empty($model)){
                $model = new GfUserLock;
                $model->isNewRecord = true;
                unset($model->ID);
            // }
            $model->GF_ID=$gfUser->GF_ID;
            $model->GF_ACCOUNT=$gfUser->GF_ACCOUNT;
            $model->GF_NAME=$gfUser->GF_NAME;
            $model->ZSXM=$gfUser->ZSXM;
            $model->if_del=510;
            $model->user_state=$_POST['user_state'];
            if(!empty($_POST['user_state'])){
                $b2 = BaseCode::model()->find('f_id='.$_POST['user_state']);
                $model->user_state_name=$b2->F_NAME;
            }
            $model->admin_gfid=get_session('gfid');
            $model->adimin_gfaccount=get_session('gfaccount');
            $model->admin_gfname=get_session('admin_name');
            $model->lock_reason=$_POST['lock_reason'];
            $model->uDate=date('Y-m-d H:i:s');
            if($_POST['user_state']==1282){
                $model->lock_date_start=date('Y-m-d H:i:s');
                $model->lock_date_end=date('Y-m-d H:i:s', strtotime('7 days'));
            }else if($_POST['user_state']==1283){
                $model->lock_date_start=date('Y-m-d H:i:s');
                $model->lock_date_end=date('Y-m-d H:i:s', strtotime('30 days'));
            }else if($_POST['user_state']==507){
                $model->lock_date_start=date('Y-m-d H:i:s');
                $model->lock_date_end='9999-09-09';
                // $model->lock_date_end=date('9999-12-31 23:59:59');
            }else{
                $model->lock_date_start='';
                $model->lock_date_end='';
            }
            $sn=$model->save();

            $gfUser->user_state=$_POST['user_state'];
            if($_POST['user_state']==1282){
                $gfUser->lock_date_start=date('Y-m-d H:i:s');
                $gfUser->lock_date_end=date('Y-m-d H:i:s', strtotime('7 days'));
            }else if($_POST['user_state']==1283){
                $gfUser->lock_date_start=date('Y-m-d H:i:s');
                $gfUser->lock_date_end=date('Y-m-d H:i:s', strtotime('30 days'));
            }else if($_POST['user_state']==507){
                $gfUser->lock_date_start=date('Y-m-d H:i:s');
                $gfUser->lock_date_end='9999-09-09';
                // $gfUser->lock_date_end=date('9999-12-31 23:59:59');
            }else{
                $gfUser->lock_date_start='';
                $gfUser->lock_date_end='';
            }
            $gfUser->valid_date=$gfUser->lock_date_end;
            $sq=$gfUser->save();
            if($sn==1&&$sq==1){
                $sv=1;
                $this->notice(1,$model->ID);
            }else{
                $sv=0;
            }
        }
        show_status($sv,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }

    // 立即解冻
    public function actionUnlock($id,$user_state,$remedy_btn=0) {
        $count = GfUserLock::model()->updateByPk($id,array('remedy_btn'=>$remedy_btn, 'uDate'=>date('Y-m-d H:i:s'), 'user_state'=>$user_state));
        show_status($count,'解冻成功',Yii::app()->request->urlReferrer,'解冻失败');
    }

    // 撤销申请
    public function actionRollback($id,$state) {
        $count = GfUserLock::model()->updateByPk($id,array('state'=>$state, 'uDate'=>date('Y-m-d H:i:s')));
        show_status($count,'撤销成功',Yii::app()->request->urlReferrer,'撤销失败');
    }

    // GF会员账号注销处理
    public function actionCancel(){
        $model=GfUserLock::model()->find('GF_ID='.$_POST['gf_id']);
        $gfUser=userlist::model()->find('GF_ID='.$_POST['gf_id']);
        if(isset($_POST['gf_id'])){
            if(empty($model)){
                $model = new GfUserLock;
                $model->isNewRecord = true;
                unset($model->ID);
            }
            $model->GF_ID=$gfUser->GF_ID;
            $model->GF_ACCOUNT=$gfUser->GF_ACCOUNT;
            $model->GF_NAME=$gfUser->GF_NAME;
            $model->ZSXM=$gfUser->ZSXM;
            $model->if_del=510;
            $model->user_state=$_POST['user_state'];
            if(!empty($_POST['user_state'])){
                $b2 = BaseCode::model()->find('f_id='.$_POST['user_state']);
                $model->user_state_name=$b2->F_NAME;
            }
            $model->admin_gfid=get_session('gfid');
            $model->admin_gfname=get_session('admin_name');
            $model->lock_reason=$_POST['lock_reason'];
            $model->uDate=date('Y-m-d H:i:s');
            $model->security_phone_country_code=$gfUser->security_phone_country_code;
            $model->security_phone=$gfUser->security_phone;
            $sv=$model->save();

            if($model->user_state==649){
                // $gf_idel_user = new GfIdelUser();
                // $gf_idel_user->isNewRecord=true;
                // unset($gf_idel_user->id);
                // $gf_idel_user->non_account=$gfUser->GF_ACCOUNT;
                // $gf_idel_user->is_use=0;
                // $sn=$gf_idel_user->save();
				$mo = GfIdelUserAllNumber::model()->find('account='.$gfUser->GF_ACCOUNT);
				$mo->is_use=0;
				$sn=$mo->update($mo);
                if($sn==1&&$sv==1){
                    ThirdPartyLogin::model()->updateAll(array('logout'=>649),'gf_id='.$_POST['gf_id']);
                    $gfUser->deleteAll('GF_ID='.$_POST['gf_id']);
					$clubMember=ClubMember::model()->find('member_gfid='.$_POST['gf_id']);
					if(count($clubMember)>0){
						$clubMember->deleteAll('member_gfid='.$_POST['gf_id']);
					}
                    $this->notice(2,$model->ID);
                }
            }
        }
        show_status($sv,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }

    // 逻辑删除
    public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $lode = explode(',', $id);
        $count=0;
        foreach($lode as $d){
            $model->updateAll(array('if_del'=>509),'id='.$d);
            $count++;
        }
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }


    //删除
    // public function actionDelete($id) {
    //     parent::_clear($id);
    // }

    // 334——GF账号注销／冻结／解冻通知，前端接收通知后弹出提示
    // 1、"type": "邀请函", //类型
    // 2、"title": "广州中数", //标题
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
            $content='当前GF账号（'.$lock->GF_ACCOUNT.'）违反了账号使用规范，已被注销。如有疑问，请联系客服！';
        }elseif($lock->user_state==507){
            $content='当前GF账号（'.$lock->GF_ACCOUNT.'）违反了账号使用规范，已被'.$base_code->F_NAME.'，冻结期间限制登录。如有疑问，请联系客服！';
        }else{
            $content='当前GF账号（'.$lock->GF_ACCOUNT.'）违反了账号使用规范，已被'.$base_code->F_NAME.'，冻结期间限制登录，冻结账号将于'.$lock->lock_date_end.'解除限制。如有疑问，请联系客服！';
        }
		$data = array(
			'type' => $type,
			'content' => $content,
			'gf_state' => $gf_state,
			'state_name' => $base_code->F_NAME
        );
        send_msg(334,$admin_id,$lock->GF_ID,$data);
	}
}
