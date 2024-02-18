<?php

class QualificationsPersonController extends BaseController {

    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    /**
     * 服务者申请列表
     */

    public function actionIndex_apply($keywords = '',$start_date='',$end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $w1 = 'check_state=1 and is_del=0 ';
        $num=$model->count($w1);
        $w1 = get_like($w1,'gfaccount,qualification_name',$keywords,'');
        $w1=get_where($w1,$start_date,'uDate>=',$start_date,'"');
        $criteria->condition=get_where($w1,$end_date,'uDate<=',$end_date,'"');
        $criteria->order = 'qcode';
        $data = array();
        $data['num'] =$num;
        parent::_list($model, $criteria, 'index_apply', $data);
    }

    /**
     * 服务者待审核列表
     */
    public function actionIndex_h($keywords='',$start_date='',$end_date='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $w1 = 'check_state>1 and is_del=0 ';
        $num=$model->count($w1);
        $w1=get_like($w1,'gfaccount,qualification_name',$keywords,'');
        $w1=get_where($w1,$start_date,'uDate>=',$start_date,'"');
        $criteria->condition=get_where($w1,$end_date,'uDate<=',$end_date,'"');
        $criteria->order = 'qcode';
        $data = array();
        $data['startDate']=$start_date;
        $data['endDate']=$end_date;
        parent::_list($model, $criteria, 'index_h', $data);
    }

    // 撤销提交审核
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

    
    public function actionIndex_examine($keywords='',$start_date='',$end_date=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $w1 = 'check_state>1 and is_del=0 ';
        $num=$model->count($w1);
        $w1=get_like($w1,'gfaccount,qualification_name',$keywords,'');
        $w1=get_where($w1,$start_date,'uDate>=',$start_date,'"');
        $criteria->condition=get_where($w1,$end_date,'uDate<=',$end_date,'"');
        $criteria->order = 'qcode';
        $data = array();
        $data['startDate']=$start_date;
        $data['endDate']=$end_date;
        $data['num'] = $num;
        $data['num0'] = $model->count('check_state>1');
        $data['num1'] = $model->count('check_state=1');
        parent::_list($model, $criteria, 'index_examine', $data);
    }

    // 审核操作
    public function actionUpdate_examine($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id,$modelName);
        $data = array();
        if(!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['modelName']=$modelName;
            $model2=userlist::model()->find('GF_ID="'.$model->gfid.'"');
            if(empty( $model2)){
                 $model2=new userlist();
            }
            $data['model2']=$model2;
            $this->render('update_examine', $data);
        } else{
            if(!isset($_POST['submitType'])){
                show_status(0,'保存成功',get_cookie('_currentUrl_'),'保存失败,错误码510');
            }
            $submitType=$_POST['submitType'];
            $model->saveJudge($submitType);
        }
    }

    /**
     * 服务者审核未通过列表
     */
    public function actionIndex_not($keywords = '',$start_date = '', $end_date = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $model->updateAll(array('free_state_Id'=>1400,'auth_state'=>927),'!isNull(cut_date) and cut_date<"'.date('Y-m-d H:i:s').'" and free_state_Id=1195');
        $criteria->condition = 'check_state in(373) and is_del=648 and unit_state=648';
        if ($start_date != '') {
            $criteria->condition.=' AND left(state_time,10)>="'.$start_date.'"';
        }
        if ($end_date != '') {
            $criteria->condition.=' AND left(state_time,10)<="'.$end_date.'"';
        }
        $criteria->condition = get_like($criteria->condition,'gfaccount,qualification_name',$keywords,'');
        $criteria->order = 'state_time DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_not', $data);
    }

    /**
     * 服务者入驻待缴费列表
     */


    public function actionIndex_pay_notice($keywords = '',$time_start='',$time_end='',$type='',$project='',$paymen_state='',$free_state_Id='1200') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $model->updateAll(array('free_state_Id'=>1400,'auth_state'=>927),'!isNull(cut_date) and cut_date<"'.date('Y-m-d H:i:s').'" and free_state_Id=1195');
        $date=date('Y-m-d H:i:s',strtotime('-3 day'));
        $criteria->condition = 'check_state=2 and is_del=648 and unit_state=648';
        $criteria->condition .= ' and free_state_Id in(1200)';
        $time_start = ($time_start=='') ? '' : $time_start;
        $time_end = ($time_end=='') ? '' : $time_end;
        if ($time_start != '') {
            $criteria->condition.=' AND left(state_time,10)>="'.$time_start.'"';
        }
        if ($time_end != '') {
            $criteria->condition.=' AND left(state_time,10)<="'.$time_end.'"';
        }
        // $criteria->condition .= ' AND not exists(select qualifications_person_id from club_membership_fee_data_list where qualifications_person_id=t.id)';
        $criteria->condition = get_where($criteria->condition,!empty($type),'qualification_type_id',$type,'');
        $criteria->condition = get_where($criteria->condition,!empty($project),'project_id',$project,'');
        $criteria->condition = get_where($criteria->condition,!empty($paymen_state),'free_state_Id',$paymen_state,'');
        $criteria->condition = get_like($criteria->condition,'gfaccount,qualification_name,gf_code',$keywords,'');//get_where
        if($free_state_Id==''){
            $criteria->order = 'send_date DESC';
        }else{
            $criteria->order = 'state_time DESC';
        }
        $data = array();
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
		$data['type'] = ClubServicerType::model()->findAll('type=501');
        $data['paymen_state'] = BaseCode::model()->getCode(1194);
        $data['project'] = ProjectList::model()->getProject();
        $data['fee_list'] = ClubMembershipFeeScaleInfo::model()->findAll('fee_code="TS20" and club_id='.get_session('club_id'));
        parent::_list($model, $criteria, 'index_pay_notice', $data);
    }

    /**
     * 已通知待支付
     */
    public function actionIndex_pay($keywords = '',$time_start='',$time_end='',$type='',$project='',$paymen_state='',$free_state_Id='1195') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $model->updateAll(array('free_state_Id'=>1400,'auth_state'=>927),'!isNull(cut_date) and cut_date<"'.date('Y-m-d H:i:s').'" and free_state_Id=1195');
        $date=date('Y-m-d H:i:s',strtotime('-3 day'));
        $criteria->condition = 'check_state=2 and is_del=648 and unit_state=648';
        $criteria->condition .= ' and free_state_Id in(1195) and pay_way=12';
        $time_start=$time_start=='' ? date("Y-m-d") : $time_start;
        $time_end=$time_end=='' ? date("Y-m-d") : $time_end;
        if ($time_start != '') {
            $criteria->condition.=' AND left(state_time,10)>="'.$time_start.'"';
        }
        if ($time_end != '') {
            $criteria->condition.=' AND left(state_time,10)<="'.$time_end.'"';
        }
        // $criteria->condition .= ' AND not exists(select qualifications_person_id from club_membership_fee_data_list where qualifications_person_id=t.id)';
        $criteria->condition = get_where($criteria->condition,!empty($type),'qualification_type_id',$type,'');
        $criteria->condition = get_where($criteria->condition,!empty($project),'project_id',$project,'');
        $criteria->condition = get_where($criteria->condition,!empty($paymen_state),'free_state_Id',$paymen_state,'');
        $criteria->condition = get_like($criteria->condition,'gfaccount,qualification_name,gf_code',$keywords,'');//get_where
        if($free_state_Id==''){
            $criteria->order = 'send_date DESC';
        }else{
            $criteria->order = 'state_time DESC';
        }
        $data = array();
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        $data['type'] = ClubServicerType::model()->findAll('type=501');
        $data['paymen_state'] = BaseCode::model()->getCode(1194);
        $data['project'] = ProjectList::model()->getProject();
        $data['fee_list'] = ClubMembershipFeeScaleInfo::model()->findAll('fee_code="TS20" and club_id='.get_session('club_id'));
        parent::_list($model, $criteria, 'index_pay', $data);
    }

    public function actionIndex_overtime($keywords = '',$time_start='',$time_end='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $model->updateAll(array('free_state_Id'=>1400,'auth_state'=>927),'!isNull(cut_date) and cut_date<"'.date('Y-m-d H:i:s').'" and free_state_Id=1195');
        $date=date('Y-m-d H:i:s',strtotime('-3 day'));
        $criteria->condition = 'free_state_Id=1400 and is_del=648 and unit_state=648';
        $time_start=$time_start=='' ? date("Y-m-d") : $time_start;
        $time_end=$time_end=='' ? date("Y-m-d") : $time_end;
        if ($time_start != '') {
            $criteria->condition.=' AND left(state_time,10)>="'.$time_start.'"';
        }
        if ($time_end != '') {
            $criteria->condition.=' AND left(state_time,10)<="'.$time_end.'"';
        }
        $criteria->condition = get_like($criteria->condition,'gfaccount,qualification_name,gf_code',$keywords,'');//get_where
        $criteria->order = 'state_time DESC';
        $data = array();
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        parent::_list($model, $criteria, 'index_overtime', $data);
    }
    /**
     * 服务者入驻待确认列表
     */
    public function actionIndex_confirming($keywords = '',$type='',$project='',$time_start='',$time_end='',$free_state_Id='1201') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $model->updateAll(array('free_state_Id'=>1400,'auth_state'=>927),'!isNull(cut_date) and cut_date<"'.date('Y-m-d H:i:s').'" and free_state_Id=1195');
        $criteria->condition = 'check_state=2 and free_state_Id=1201 and is_del=648 and unit_state=648';
        $criteria->condition = get_where($criteria->condition,!empty($type),'qualification_type_id',$type,'');
        $criteria->condition = get_where($criteria->condition,!empty($project),'project_id',$project,'');
        $criteria->condition = get_like($criteria->condition,'order_num,project_name,qualification_name,qcode,gfaccount',$keywords,'');
        $time_start=$time_start=='' ? '' : $time_start;
        $time_end=$time_end=='' ? '' : $time_end;
        if ($time_start != '') {
            $criteria->condition.=' AND left(state_time,10)>="'.$time_start.'"';
        }
        if ($time_end != '') {
            $criteria->condition.=' AND left(state_time,10)<="'.$time_end.'"';
        }
        $criteria->order = 't.state_time DESC';
        $data = array();
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
		$data['type'] = ClubServicerType::model()->findAll('type=501');
        $data['project'] = ProjectList::model()->getProject();
        parent::_list($model, $criteria, 'index_confirming', $data);
    }

    /**
     * 服务者入驻已确认
     */
    public function actionIndex_confirmed($keywords = '',$type='',$project='',$time_start='',$time_end='',$free_state_Id='1202') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $model->updateAll(array('free_state_Id'=>1400,'auth_state'=>927),'!isNull(cut_date) and cut_date<"'.date('Y-m-d H:i:s').'" and free_state_Id=1195');
        $criteria->condition = 'check_state=2 and free_state_Id=1202 and is_del=648 and unit_state=648';
        $criteria->condition = get_where($criteria->condition,!empty($type),'qualification_type_id',$type,'');
        $criteria->condition = get_where($criteria->condition,!empty($project),'project_id',$project,'');
        $criteria->condition = get_like($criteria->condition,'order_num,project_name,qualification_name,qcode,gfaccount',$keywords,'');
        $time_start=$time_start=='' ? '' : $time_start;
        $time_end=$time_end=='' ? '' : $time_end;
        if ($time_start != '') {
            $criteria->condition.=' AND left(state_time,10)>="'.$time_start.'"';
        }
        if ($time_end != '') {
            $criteria->condition.=' AND left(state_time,10)<="'.$time_end.'"';
        }
        $criteria->order = 't.state_time DESC';
        $data = array();
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        $data['type'] = ClubServicerType::model()->findAll('type=501');
        $data['project'] = ProjectList::model()->getProject();
        parent::_list($model, $criteria, 'index_confirmed', $data);
    }


    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['base_path'] = BasePath::model()->getPath(173);
            //保存资质图片
            $data['qualification_image']=array();
            $data['sub_product_list'] = array();
            $data['club_list'] = array();
            $this->render('update', $data);
        } else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }
    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id,$modelName);
        $data = array();
        if(!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['qualification_image'] = explode('|', $model->qualification_image);
            $this->render('update', $data);
        } else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }
    function saveData($model,$post) {
        $model->check_save(1);
        $model->attributes = $post;
        $post['gfid']?:$model->gfid=227627;//暂时没有gfid
        if(!empty($_POST['level1'])){
            $model->area_code=$_POST['level1'];
        }
        if(!empty($_POST['level2'])){
            $model->area_code.=','.$_POST['level2'];
        }
        if(!empty($_POST['level3'])){
            $model->area_code.=','.$_POST['level3'];
        }
        if(!empty($_POST['level4'])){
            $model->area_code.=','.$_POST['level4'];
        }

        $no='保存失败';
        $yes='保存成功';

        $cType=ClubServicerType::model()->find('type=501 and member_second_id='.$model->qualification_type_id);

        if($cType->if_project==649){
            if(!empty($model->id)){
                $qp=QualificationsPerson::model()->find("id<>".$model->id." and unit_state=648 and if_del=506 and is_del=648 and check_state<>373 and auth_state<>927 and free_state_Id<>1400 and project_id=".$model->project_id." and gfid=".$model->gfid." and qualification_type_id=".$model->qualification_type_id);
            }else{
                $qp=QualificationsPerson::model()->find("unit_state=648 and if_del=506 and is_del=648 and check_state<>373 and auth_state<>927 and free_state_Id<>1400 and project_id=".$model->project_id." and gfid=".$model->gfid." and qualification_type_id=".$model->qualification_type_id);
            }
        }else{
            if(!empty($model->id)){
                $qp=QualificationsPerson::model()->find("id<>".$model->id." and unit_state=648 and if_del=506 and is_del=648 and check_state<>373 and auth_state<>927 and free_state_Id<>1400 and gfid=".$model->gfid.' and qualification_type_id='.$model->qualification_type_id);
            }else{
                $qp=QualificationsPerson::model()->find("unit_state=648 and if_del=506 and is_del=648 and check_state<>373 and auth_state<>927 and free_state_Id<>1400 and gfid=".$model->gfid.' and qualification_type_id='.$model->qualification_type_id);
            }
        }
        if(!empty($qp)&&$qp->id!=$model->id&&$qp->unit_state==648){
            $sv=0;
            $no='操作失败，该服务者已存在';
        }else{
            //put_msg($_POST['submitType']);
            //get_check_code函数未实现
            //$model->check_state = get_check_code($_POST['submitType']);
            if($_POST['submitType']=='shenhe'){
                $yes='提交成功';
                $no='提交失败';
            }
            if($_POST['submitType']=='quxiao'){
                $model->check_state=374;
                $yes='撤销成功';
                $no='撤销失败';
            }
            if($_POST['submitType']=='tuihui'){
                $yes='退回成功';
                $no='退回失败';
            }
            if($model->check_state==2&&$model->logon_way==1460){
                $model->auth_state=931;
                $model->free_state_Id=1202;
                //QualificationClub::model()->updateAll(array('state'=>337),'logon_way=1460 and qualification_person_id='.$model->id);
            }
            $sv = $model->save();
            $basepath=BasePath::model()->getPath(191);
            $club=ClubList::model()->find("id=".get_session('club_id'));
            $pic=$basepath->F_WWWPATH.$club->club_logo_pic;
            $title='服务者入驻审核通知';
            $url='';
            $type_id=24;
            $datas=array(array('id'=>$model->id,'auth_state'=>$model->auth_state,'auth_state_name'=>$model->auth_state_name));
            if($sv==1&&$model->check_state==2&&$model->logon_way!=1460){
                $this->examine($model,$post);
                $yes='审核通过成功';
                $content='恭喜，您的资料已通过初审，稍后会给您发送相关服务费通知。';
                $sendArr=array('type'=>'【服务者入驻审核通知】','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>$url,'type_id'=>$type_id,'datas'=>$datas);
                //game_audit函数未实现
                //game_audit(get_session('club_id'),$model->gfid,$sendArr);
            }
            if($sv==1&&$model->check_state==373&&$model->logon_way!=1460){
                $yes='审核未通过成功';

                $content='抱歉，您的资料审核未通过，您可修改资料后重新提交申请。';
                $sendArr=array('type'=>'【服务者入驻审核通知】','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>$url,'type_id'=>$type_id,'datas'=>$datas);
                //game_audit函数未实现
                //game_audit(get_session('club_id'),$model->gfid,$sendArr);
            }
        }
        show_status($sv,$yes,get_cookie('_currentUrl_'),$no);
    }

    public function actionCheck($id,$state){
        $st=0;
        $no='';
        $count = explode(',',$id);
        foreach($count as $d){
            $modelName = $this->model;
            $model = $this->loadModel($d, $modelName);
            $cType=ClubServicerType::model()->find('type=501 and member_second_id='.$model->qualification_type_id);
            if($cType->if_project==649){
                $qp=QualificationsPerson::model()->find("id<>".$model->id." and unit_state=648 and if_del=506 and is_del=648 and check_state<>373 and auth_state<>927 and project_id=".$model->project_id." and gfid=".$model->gfid.' and qualification_type_id='.$model->qualification_type_id);
            }else{
                $qp=QualificationsPerson::model()->find("id<>".$model->id." and unit_state=648 and if_del=506 and is_del=648 and check_state<>373 and auth_state<>927 and gfid=".$model->gfid.' and qualification_type_id='.$model->qualification_type_id);
            }
            if(!empty($qp)&&$qp->id!=$model->id&&$qp->unit_state==648){
                $st=0;
                $no='，'.$model->qualification_type.'类型-'.$model->project_name.'项目-'.$model->gfaccount.'服务者已存在';
            }else{
                $model->check_state = $state;
                if($model->check_state==2&&$model->logon_way==1460){
                    $model->auth_state=931;
                    $model->free_state_Id=1202;
                    QualificationClub::model()->updateAll(array('state'=>337),'logon_way=1460 and qualification_person_id='.$model->id);
                }
                $st = $model->save();

                $basepath=BasePath::model()->getPath(191);
                $club=ClubList::model()->find("id=".get_session('club_id'));
                $pic=$basepath->F_WWWPATH.$club->club_logo_pic;
                $title='服务者入驻审核通知';
                $url='';
                $type_id=24;
                $datas=array(array('id'=>$model->id,'auth_state'=>$model->auth_state,'auth_state_name'=>$model->auth_state_name));
                if($st==1&&$model->check_state==2&&$model->logon_way!=1460){
                    $post=[];
                    $this->examine($model,$post);
                    $content='恭喜，您的资料已通过初审，稍后会给您发送相关服务费通知。';
                    $sendArr=array('type'=>'【服务者入驻审核通知】','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>$url,'type_id'=>$type_id,'datas'=>$datas);
                    game_audit(get_session('club_id'),$model->gfid,$sendArr);
                }
                if($st==1&&$model->check_state==373&&$model->logon_way!=1460){
                    $content='抱歉，您的资料审核未通过，您可修改资料后重新提交申请。';
                    $sendArr=array('type'=>'【服务者入驻审核通知】','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>$url,'type_id'=>$type_id,'datas'=>$datas);
                    game_audit(get_session('club_id'),$model->gfid,$sendArr);
                }
            }
        };
        show_status($st,'审核成功',Yii::app()->request->urlReferrer,'审核失败'.$no);
    }


    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

    public function actionScales($info_id){
        $data = ClubMembershipFeeData::model()->findAll(
            array(
                'select'=>array('id','scale_info_id','levelid','levelname','scale_amount,member_type,member_name'),
                'order'=>'levelid,scale_info_id',
                'condition'=>'scale_info_id='.$info_id
            )
        );
        if(!empty($data)){
            echo CJSON::encode($data);
        }
    }

    /**
     * 审核通过时填入资质分
     */
    public function examine($model,$post){
        if(!empty($model->identity_num)){
            $base_code=ServicerCertificate::model()->find('id='.$model->identity_num);
        }
        if(!empty($base_code)){
            $model->qualification_score = $base_code->F_COL1;
        }
        $old = ServicerLevel::model()->find('member_second_id='.$model->qualification_type_id.' and card_score<='.$model->qualification_score.' and (card_end_score>='.$model->qualification_score.')');
        if(!empty($old)){
            $model->qualification_level = $old->id;
            $model->level_name = $old->card_name;
        }
        $sv=$model->save();
    }

    public function actionScaleInfo($id,$par,$check_all,$time_start,$time_end){
        $modelName = $this->model;
        $count = explode(',',$id);
        $fee_info = ClubMembershipFeeScaleInfo::model()->find('id='.$par);
        $sv=0;
        $al='';
        if($check_all==0){
            foreach($count as $d){
                $model = $this->loadModel($d,$modelName);
                if(!empty($fee_info->id) && !empty($model->qualification_level)){
                    $data_info = ClubMembershipFeeData::model()->find(' product_id='.$fee_info->product_id.' and scale_info_id='.$fee_info->id.' and member_type='.$model->qualification_type_id.' and levelid='.$model->qualification_level);
                    if(!empty($data_info)){
                        $perseon=QualificationsPerson::model()->find('unit_state=648 and if_del=506 and id='.$d.' and cost_admission='.$data_info->scale_amount.' and pay_blueprint='.$fee_info->id);
                        if(empty($perseon)){
                            $sv=QualificationsPerson::model()->updateByPk($d, array('cost_admission' => $data_info->scale_amount,'cost_account'=>$data_info->scale_amount,'pay_blueprint'=>$fee_info->id,'pay_blueprint_name'=>$fee_info->name));
                        }else{
                            $sv=1;
                        }

                    }else{
                        $sv=0;
                        $al='，没有该数据费用明细';
                    }
                    $fee_info->use_default = 1;
                    $fee_info->save();
                }
            }
        }
        $fee_info2 = ClubMembershipFeeScaleInfo::model()->findAll('id<>'.$par.' and club_id='.get_session('club_id').' and levetypename="服务者"');
        foreach($fee_info2 as $fo2){
            $fo2->use_default = 0;
            $fo2->save();
        }
        if($sv==0){
            show_status($sv,'操作成功',Yii::app()->request->urlReferrer,'操作失败'.$al);
        }
    }

    /**
     * 免费/有偿入驻操作
     */
    public function actionWhole($id) {
        $this->actionSend($id);
    }

    /**
     * 免费/有偿入驻的执行actionSend这个方法
     * 免费/有偿入驻的首先查找会员相关收费项目表club_membership_fee这个表的入驻商品编号.
     * 然后查找会员等级明细表club_membership_fee_data，把符合等级的并且价格不为0的数据存入商品编号进入购物车表mall_shopping_settlement与mall_shopping_car_copy.
     *
     * 通知缴费操作会保存一条信息到购物车列表.
     * 缴费后确认缴费操作回填一条到会员信息明细表club_membership_fee_data_list.
     *
     * 通知缴费操作.
     * 分别存购物车账单表和购物车详细表.
     */
    public function actionSend($id) {
        $modelName = $this->model;
        $count = explode(',',$id);
        $freeId='';
        foreach($count as $d){
            $model = $this->loadModel($d, $modelName);
            $base_code = BaseCode::model()->find('f_id=357');
       
            if($model->free_state_Id!=1200){
                $sf = 0;
                continue;
            }
            // $ship_fee = ClubMembershipFee::model()->find('code="TS20"');
            $ship_info = ClubMembershipFeeScaleInfo::model()->find('club_id='.get_session('club_id').' and id='.$model->pay_blueprint);
            if(!empty($ship_info)){
                $fee_data = ClubMembershipFeeData::model()->find('gf_club_id='.get_session('club_id').' and levelid='.$model->qualification_level.' and member_type='.$model->qualification_type_id.' and product_id='.$ship_info->product_id.' and scale_info_id='.$model->pay_blueprint);
            }
            // 如果$fee_data不等于空并且$fee_data->scale_amount大于0，就执行保存到购物车，否则保存到会员明细表
            if(empty($fee_data->id)){
                $sf=0;
                $al='未设置费用明细';
            }elseif( $fee_data->scale_amount>0){
                // 购物车账单
		        $order_data=array('order_type'=>357
		        	,'buyer_type'=>210
			        ,'order_gfid'=>$model->gfid
			        ,'money'=>$fee_data->scale_amount
			        ,'order_money'=>$fee_data->scale_amount
			        ,'total_money'=>$fee_data->scale_amount
			        ,'effective_time'=>date('Y-m-d H:i:s',strtotime('+3 day')));
				$add_order=Carinfo::model()->addOrder($order_data);
				if(empty($add_order['order_num'])){
					$sv=0;
				}else{
					$sv=1;
	                // 购物车详细
	                $cat_copy = new CardataCopy();
	                $cat_copy->isNewRecord = true;
	                unset($cat_copy->id);
	                $cat_copy->order_num = $add_order['order_num'];
	                $cat_copy->order_type = 357;
	                $cat_copy->order_type_name = $base_code->F_NAME;
	                $cat_copy->product_id = $fee_data->product_id;
	                $cat_copy->product_code = $fee_data->product_code;
	                $cat_copy->product_title = $fee_data->product_name;
	                $cat_copy->product_data_id = $fee_data->product_id;
	                $cat_copy->json_attr = $fee_data->json_attr;
	                $cat_copy->supplier_id = $fee_data->gf_club_id;
	                $cat_copy->buy_price = $fee_data->scale_amount;  // 商品单价
	                $cat_copy->buy_amount = $fee_data->scale_amount;  // 购买实际金额
	                $cat_copy->project_id = $model->project_id;
	                $cat_copy->project_name = $model->project_name;
	                $cat_copy->buy_level = $model->qualification_level;
	                $cat_copy->buy_level_name = $model->level_name;
	                $cat_copy->buy_count = 1;
	                $cat_copy->total_pay = $fee_data->scale_amount;
	                $cat_copy->gfid = $model->gfid;
	                $cat_copy->gf_name = $model->qualification_name;
	                $cat_copy->uDate = date('Y-m-d H:i:s');
	                $cat_copy->gf_club_id = get_session('club_id');
	                $cat_copy->effective_time = $order_data['effective_time'];
	                $st=$cat_copy->save();
				}

                if($sv==1 && $st==1 ){
                    $sd=QualificationsPerson::model()->updateByPk($d, array('state_time' => date('Y-m-d H:i:s'),'order_num'=>$add_order['order_num'],'send_oper'=>get_session('admin_name'),'send_date'=>date('Y-m-d H:i:s'),'cut_date'=>date('Y-m-d H:i:s', strtotime('3 days')),'free_state_Id'=>1195,'auth_state'=>930,'pay_way'=>12));
                }
    
                if($sv==1 && $st==1 && $sd==1 ){
                    $sf=1;
                    if($sf==1){
                        $basepath=BasePath::model()->getPath(191);
                        $club=ClubList::model()->find("id=".get_session('club_id'));
                        $pic=$basepath->F_WWWPATH.$club->club_logo_pic;
                        $title=$fee_data->product_name;
                        $content='恭喜，您的资料已通过初审！服务者入驻费用为：'.$fee_data->scale_amount.'元/项目/年，请您在支付时间内完成支付。';
                        $url='';
                        $sendArr=array('type'=>'【服务者入驻缴费通知】','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>$url,'order_num'=>$add_order['order_num']);
                        send_msg(314,get_session('club_id'),$model->gfid,$sendArr);
                    }
                }
                else{
                    $sf=0;
                }
            }elseif($fee_data->scale_amount<=0){
                $freeId.=$d.',';
            }
        }
        if($freeId!=''){
            $this->actionFree( rtrim($freeId, ','),1373);
        }
        show_status($sf,'发送成功',Yii::app()->request->urlReferrer,'发送失败');
    }

    /**
     * 免单入驻,直接存进会员明细表club_membership_fee_data_list.
     * 不生成订单号，如果金额不为空，金额填入会员明细表.
     *
     * 识别价格为0的也执行这个方法.
     */
    public function actionFree($id,$pay_way='') {
        $modelName = $this->model;
        $len = explode(',',$id);
        foreach($len as $v){
            $model = $this->loadModel($v,$modelName);
            $ship_fee = ClubMembershipFee::model()->find('code="TS20"');
            $ship_info = ClubMembershipFeeScaleInfo::model()->find('id='.$model->pay_blueprint);
            if(!empty($ship_fee) && !empty($ship_info)){
                $fee_data = ClubMembershipFeeData::model()->find('gf_club_id='.get_session('club_id').' and levelid='.$model->qualification_level.' and member_type='.$model->qualification_type_id.' and product_id='.$ship_fee->product_id.' and scale_info_id='.$ship_info->id);
            }
            $fee_list = new ClubMembershipFeeDataList;
            $fee_list->isNewRecord = true;
            unset($fee_list->id);
            if(!empty($fee_data)){
                $fee_list->scale_list_Id = $fee_data->scale_list_Id;
                $fee_list->scale_data_id = $fee_data->id;
                $fee_list->scale_code = $fee_data->scale_code;
                $fee_list->feeid = $fee_data->feeid;
                $fee_list->code = $fee_data->code;
                $fee_list->name = $fee_data->name;
                $fee_list->levetypeid = $fee_data->levetypeid;
                $fee_list->product_id = $fee_data->product_id;
                $fee_list->product_code = $fee_data->product_code;
                $fee_list->product_name = $fee_data->product_name;
                $fee_list->json_attr = $fee_data->json_attr;
                $fee_list->fee_type = 403;
                $fee_list->f_userdate = date('Y-m-d H:i:s');
                // $fee_list->club_id = get_session('club_id');
                // $fee_list->club_name = get_session('club_name');
                $fee_list->gf_id = $model->gfid;
                $fee_list->gf_name = $model->qualification_name;
                $fee_list->project_id = $model->project_id;
                $fee_list->project_name = $model->project_name;
                $fee_list->levelid = $model->qualification_level;
                $fee_list->levelname = $model->level_name;
                $fee_list->f_username = get_session('admin_name');
                $fee_list->f_freemark = 0;  // 0代表免费
                $fee_list->qualifications_person_id = $model->id;
                $sv=$fee_list->save();
            }

            if($pay_way==''){
                $pay_way=1374;
            }
            if($sv==1){
                $sn=QualificationsPerson::model()->updateByPk($v, array('is_pay' => 464,'auth_state'=>1391,'free_charge'=>$model->cost_admission,'cost_account'=>0,'state_time'=>date('Y-m-d H:i:s'),'send_oper'=>get_session('admin_name'),'send_date'=>date('Y-m-d H:i:s'),'free_state_Id'=>1201,'pay_way'=>$pay_way));
            }

            if($sv==1 && $sn==1){
                $sf=1;
                if($sf==1){
                    $basepath=BasePath::model()->getPath(191);
                    $club=ClubList::model()->find("id=".get_session('club_id'));
                    $pic=$basepath->F_WWWPATH.$club->club_logo_pic;
                    $title='服务者入驻缴费通知';
                    $content='恭喜，您的资料已通过初审！服务者入驻费用为：'.$model->cost_admission.'元/项目/年（已免单）。';
                    $url='';
                    $type_id=24;
                    $datas=array(array('id'=>$model->id,'auth_state'=>$model->auth_state,'auth_state_name'=>$model->auth_state_name));
                    $sendArr=array('type'=>'【服务者入驻缴费通知】','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>$url,'type_id'=>$type_id,'datas'=>$datas);
                    game_audit(get_session('club_id'),$model->gfid,$sendArr);
                }
            }
            else{
                $sf=0;
            }
        }
        show_status($sf,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }

    /**
     * 取消通知，通过删除购物车数据来取消
     */
    public function actionUnsend($id) {
        $len = explode(',',$id);
        foreach($len as $v){
            $model = QualificationsPerson::model()->find('unit_state=648 and if_del=506 and id='.$v);
            if(!empty($model)){
                // $count->updateByPk($count->id,array('if_del'=>649));
                Carinfo::model()->deleteAll('order_num="'.$model->order_num.'"');
                CardataCopy::model()->deleteAll('order_num="'.$model->order_num.'"');
                ClubMembershipFeeDataList::model()->deleteAll('qualifications_person_id='.$model->id);
                $model->updateByPk($v,array('order_num'=>'','free_state_Id'=>1200,'free_state_name'=>'待通知','is_pay'=>463,'auth_state'=>929,'pay_way'=>null,'pay_way_name'=>''));
                $sf=1;
            }
            else{
                $sf=0;
            }
        }
        show_status($sf,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }

    /**
     * 待确认
     */
    public function actionConfirmed($id) {
        $modelName = $this->model;
        $n = explode(',',$id);
        foreach($n as $v){
            $model = $this->loadModel($v,$modelName);
            if($model->free_state_Id==1202) {
                $sf=0;
                continue;
            }
            if($model->identity_score>0){
                $cType=ClubServicerType::model()->find('type=501 and member_second_id='.$model->qualification_type_id);
                if($cType->if_project==649){ //判断该类型是否按项目入驻
                    $exchange=QualificationExchange::model()->find('type=501 and qua_id='.$model->identity_num.' and get_score_gfid='.$model->gfid.' and get_score_project_id='.$model->project_id.' and type_id='.$model->qualification_type_id);
                }else{
                    $exchange=QualificationExchange::model()->find('type=501 and qua_id='.$model->identity_num.' and get_score_gfid='.$model->gfid.' and type_id='.$model->qualification_type_id);
                }
                if(empty($exchange)){
                    $exchange = new QualificationExchange();
                    $exchange->isNewRecord = true;
                    unset($exchange->id);
                }
                $exchange->type=501;
                $exchange->qua_id=$model->identity_num;
                $exchange->person_code=$model->qualification_code;
                $exchange->person_pic=$model->qualification_image;
                $exchange->get_score_gfid=$model->gfid;
                $exchange->get_score_project_id=$model->project_id;
                $exchange->state=2;
                $exchange->state_time=date('Y-m-d H:i:s');
                $exchange->type_id=$model->qualification_type_id;
                $sa=$exchange->save();
            }else{
                $sa=1;
            }
            if($sa==1){
                $mall_info = MallSalesOrderInfo::model()->find('order_num="'.$model->order_num.'"');
                $ship_fee = ClubMembershipFee::model()->find('code="TS20"');
                $ship_info = ClubMembershipFeeScaleInfo::model()->find('id='.$model->pay_blueprint);
                if(!empty($ship_info)){
                    $fee_data = ClubMembershipFeeData::model()->find('gf_club_id='.get_session('club_id').' and levelid='.$model->qualification_level.' and member_type='.$model->qualification_type_id.' and product_id='.$ship_info->product_id.' and scale_info_id='.$ship_info->id);
                }
                $fee_list = ClubMembershipFeeDataList::model()->find('qualifications_person_id='.$model->id);
                if(empty($fee_list)){
                    $fee_list = new ClubMembershipFeeDataList;
                    $fee_list->isNewRecord = true;
                    unset($fee_list->id);
                }
                if(!empty($fee_data)){
                    $fee_list->scale_info_id = $fee_data->scale_info_id;
                    $fee_list->scale_list_Id = $fee_data->scale_list_Id;
                    $fee_list->scale_data_id = $fee_data->id;
                    $fee_list->scale_code = $fee_data->scale_code;
                    $fee_list->feeid = $fee_data->feeid;
                    $fee_list->code = $fee_data->code;
                    $fee_list->name = $fee_data->name;
                    $fee_list->levetypeid = $fee_data->levetypeid;
                    $fee_list->product_id = $fee_data->product_id;
                    $fee_list->product_code = $fee_data->product_code;
                    $fee_list->product_name = $fee_data->product_name;
                    $fee_list->json_attr = $fee_data->json_attr;
                }
                if(!empty($mall_info)){
                    $fee_list->scale_no = $mall_info->payment_code;
                    $fee_list->scale_type = $mall_info->pay_supplier_type_name;
                    $fee_list->date_start_scale = $mall_info->order_Date;
                    $fee_list->date_end_scale = $mall_info->pay_time;
                    $fee_list->date_scale = $mall_info->pay_time;
                    $fee_list->scale_amount = $mall_info->total_money;
                }
                $fee_list->fee_type = 403;
                $fee_list->gf_id = $model->gfid;
                $fee_list->gf_name = $model->qualification_name;
                $fee_list->project_id = $model->project_id;
                $fee_list->project_name = $model->project_name;
                $fee_list->levelid = $model->qualification_level;
                $fee_list->levelname = $model->level_name;
                $fee_list->f_username = get_session('admin_name');
                $fee_list->qualifications_person_id = $model->id;
                $fee_list->order_num = $model->order_num;
                $sv=$fee_list->save();

                $day='';
                $cType=ServicerLevel::model()->find('type=501 and id='.$model->qualification_level);
                $day=date('Y-m-d H:i:s', strtotime("".$cType->renew_time." day"));
                $sn=QualificationsPerson::model()->updateByPk($v, array('cost_adminid'=>get_session('admin_id'),'cost_oper' => get_session('admin_name'),'auth_state'=>931,'is_pay'=>464,'free_state_Id'=>1202,'entry_validity'=>date('Y-m-d H:i:s'),'expiry_date_start'=>date('Y-m-d H:i:s'),'expiry_date_end'=> $day));
                if($sv==1 && $sn==1){
                    $sf=1;

                    // 服务者入驻报名确认之后服务者兑换消费积分
                    $credit_set=GfCredit::model()->find('object=1476 and item_type=357 and consumer_type=210');
                    if(!empty($credit_set)){
                        if(round($model->cost_account/($credit_set->value/$credit_set->credit))>0){
                            $gl = new GfCreditHistory();
                            $gl->isNewRecord = true;
                            unset($gl->id);
                            $gl->object=501;
                            $gl->gf_id=$model->gfid;
                            $gl->get_object=501;
                            $gl->get_id=$model->gfid;
                            $gl->item_code=$credit_set->id;
                            $gl->service_source='服务者入驻';
                            $gl->order_num=$model->order_num;
                            $gl->add_or_reduce=1;
                            $gl->credit=round($model->cost_account/($credit_set->value/$credit_set->credit));
                            $gl->add_time=date('Y-m-d H:i:s');
                            $gl->save();
                        }

                        // 服务者续签才会有服务者挂靠单位
                        // $cList=QualificationClub::model()->findAll('qualification_person_id='.$model->id.' and state=337');
                        // if(!empty($cList))foreach($cList as $t){
                        //     $club=ClubList::model()->find('id='.$t->club_id);
                        //     $cr=0;
                        //     if($club->club_type==8){
                        //         $cr=$model->cost_account/(sqdw_value/sqdw_gredit);
                        //     }elseif($club->club_type==9){
                        //         $cr=$model->cost_account/(sjyj_value/sjyj_gredit);
                        //     }elseif($club->club_type==189){
                        //         $cr=$model->cost_account/(zlhb_value/zlhb_gredit);
                        //     }
                        //     if(round($cr)>0){
                        //         $hl = new GfCreditHistory();
                        //         $hl->isNewRecord = true;
                        //         unset($hl->id);
                        //         $hl->object=502;
                        //         $hl->gf_id=$t->club_id;
                        //         $hl->get_object=501;
                        //         $hl->get_id=$model->gfid;
                        //         $hl->item_code=$credit_set->id;
                        //         $hl->service_source='服务者入驻';
                        //         $hl->order_num=$model->order_num;
                        //         $hl->add_or_reduce=1;
                        //         $hl->credit=round($cr);
                        //         $hl->add_time=date('Y-m-d H:i:s');
                        //         $hl->save();
                        //     }
                        // }
                    }

                    $basepath=BasePath::model()->getPath(191);
                    $club=ClubList::model()->find("id=".get_session('club_id'));
                    $pic=$basepath->F_WWWPATH.$club->club_logo_pic;
                    $title='服务者入驻成功';
                    $content='恭喜，您于'.date('Y-m-d',strtotime($model->uDate)).'申请的'.$model->project_name.'-'.$model->qualification_type.'入驻成功。服务者编码为'.$model->gf_code.',可在个人中心-我是服务者处查看相关信息。';
                    $url='';
                    $type_id=19;
                    $datas=array(array('id'=>$model->id,'name'=>$model->project_name.'-'.$model->qualification_type));
                    $sendArr=array('type'=>'【服务者入驻成功】','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>$url,'type_id'=>$type_id,'datas'=>$datas);
                    game_audit(get_session('club_id'),$model->gfid,$sendArr);
                }
                else{
                    $sf=0;
                }
            }
        }
        show_status($sf,'已确认',Yii::app()->request->urlReferrer,'操作失败');
    }

    /**
     * 服务者入驻费列表
     */
    public function actionIndex_ad_fee($start_date = '', $end_date = '', $keywords = '',$type='',$project='',$pay_way='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = ClubMembershipFeeDataList::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'fee_type=403 and qualifications_person_id>0';
        $criteria->condition = get_where($criteria->condition,!empty($project),'project_id',$project,'');

        $start_date=empty($start_date)?date("Y-m-d"):$start_date;
        $end_date=empty($end_date)?date("Y-m-d"):$end_date;
        if ($start_date != '') {
            $criteria->condition.=' and left(f_userdate,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(f_userdate,10)<="' . $end_date . '"';
        }
        $criteria->join = "JOIN qualifications_person t2 on t.qualifications_person_id=t2.id";
        $criteria->condition = get_where($criteria->condition,!empty($type),'t2.qualification_type_id',$type,'');
        $criteria->condition = get_where($criteria->condition,!empty($pay_way),'t2.pay_way',$pay_way,'');

        $criteria->condition = get_like($criteria->condition,'t.gf_name,t2.gfaccount',$keywords,'');
        $criteria->order = 'f_userdate DESC';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
		$data['type'] = ClubServicerType::model()->findAll('type=501');
        $data['project'] = ProjectList::model()->getProject();
        $data['pay_way'] = BaseCode::model()->getCode(1370);
        parent::_list($model, $criteria, 'index_ad_fee', $data, 30);
    }

    //小程序接口，获取服务者与排班信息,初始化
    public function actionworkSchAll($club_id,$ymd=''){
        if(!$ymd) $ymd = date('Y/m/d');//默认为今天
    }
    public function actionworkSchOne($q_id,$ymd=''){
        if(!$ymd) $ymd = date('Y/m/d');//默认为今天
        $weekDates = QmddWorkSchdule::model()->getWeekDates($ymd);
    }
    //小程序接口，返回可选教练
    public function actionValidCouch($club_id=0){//测试阶段，没有俱乐部id
        $valid_id=array('1239','1241','1251','1286','1371','1386');//后端可用的测试数据
        $modelName = $this->model;
        $criteria=new CDbCriteria;
        $criteria->addInCondition('id',$valid_id);
        $couch = $modelName::model()->findAll($criteria);
        $wx_data = toIoArray($couch,'id,phone,email,qualification_name,sex,achi_h_ratio:good_rate,achi_c_ratio:bad_rate');
        JsonSuccess($wx_data);
    }

}
