<?php

class ClubReportController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    // 普通举报列表
    public function actionIndex($searchtext = '' ,$rtype_id = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'type != 751';
        $criteria->condition = get_where($criteria->condition,!empty($rtype_id),'rtype_id',$rtype_id,'');
        // $criteria->condition = 'type != 751 and rtype_id = 1180';
        if ($searchtext != '') {
            $criteria->condition.=" AND ( connect_code like '%{$searchtext}%' OR connect_title like '%{$searchtext}%' )";
        }
		$criteria->order = 'add_time DESC';
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
        // if(!isset($is_excel) || $is_excel!='1'){
        //     parent::_list($model, $criteria, 'index', $data);
        // }else{
        //     $arclist = $model->findAll($criteria);
        //     $data=array();
        //     $title = array();
        //     foreach ($model->labelsOfList() as $fv) {
        //         array_push($title, $model->attributeLabels()[$fv]);
        //     }
        //     array_push($data, $title);
        //     foreach ($arclist as $v) {
        //         $item = array();
        //         foreach ($model->labelsOfList() as $fv) {
        //             $s = '';
        //             if ($fv=='report_type_id'){
        //                 $s = ReportVersion::model()->getName($v->$fv);
        //             }elseif($fv=='state' || $fv=='type'){
        //                 $s = BaseCode::model()->getName($v->$fv);
        //             }else{
        //                 $s= $v->$fv ;
        //             }
        //             array_push($item, $s);
        //         }
        //         array_push($data, $item);
        //     }
        //     parent::_excel($data,'投诉举报列表.xls');
        // }
    }

    // 普通举报详情
    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['state_name'] = BaseCode::model()->getCode(752);
            $data['model'] = $model;
			$data['report_pic'] = explode(',', $model->report_pic);
            $this->render('update', $data);
        } else {
            // $model->setAttribute('audit_status', $_POST[$modelName]['audit_status']);
            // if($_POST[$modelName]['audit_status']==2){
                $cookie = get_cookie('_currentUrl_');
                if($_POST['submitType'] == 'tongguo'){
                    $model->audit_status  = 2;
                    // $model->setAttribute('reasons_for_failure',$_POST[$modelName]['reasons_for_failure']);
                    $model->setAttribute('admin_id',get_session('admin_id'));
                    $model->setAttribute('admin_account',get_session('gfaccount'));
                    $model->setAttribute('udate', date("Y-m-d H:i:s"));
                    $b = BaseCode::model()->find('f_id='.$model->audit_status);
                    $model->setAttribute('audit_status_name',$b->F_NAME);
                    $cookie = Yii::app()->request->urlReferrer;
                    $sv=$model->save();
                }else if($_POST['submitType'] == 'butongguo'){
                    $model->audit_status  = 373;
                    // $model->setAttribute('reasons_for_failure',$_POST[$modelName]['reasons_for_failure']);
                    $model->setAttribute('admin_id',get_session('admin_id'));
                    $model->setAttribute('admin_account',get_session('gfaccount'));
                    $model->setAttribute('udate', date("Y-m-d H:i:s"));
                    $b = BaseCode::model()->find('f_id='.$model->audit_status);
                    $model->setAttribute('audit_status_name',$b->F_NAME);
                    $cookie = Yii::app()->request->urlReferrer;
                    $sv=$model->save();
                    
                    // 审核不通过通知，申诉审核不通过不通知
                    if($model->rtype_id!=1182){
                        $basepath=BasePath::model()->getPath(191);
                        $pic='';
                        $b2 = BaseCode::model()->find('f_id='.$model->type);
                        $title=$b2->F_NAME.$model->connect_title; //举报内容
                        $report_reason=$model->report_content; //举报原因
                        $report_result='根据信息暂时无法判断存在违规行为。'; //审核结果
                        $report_processing=''; //处理方式
                        $report_id=$model->id;
                        if($model->rtype_id==1181){
                            $if_appeal=1;
                        }else{
                            $if_appeal=0;
                        }
                        $sendArr=array('type'=>'举报不成功通知','pic'=>$pic,'title'=>$title,'report_reason'=>$report_reason,'report_result'=>$report_result,'report_processing'=>$report_processing,'report_id'=>$report_id,'report_send_obj'=>0,'if_appeal'=>$if_appeal,'audit_state'=>0,'retype_id'=>$model->rtype_id);
                        send_msg(333,get_session('club_id'),$model->gfid,$sendArr);
                    }else{
                        $basepath=BasePath::model()->getPath(191);
                        $pic='';
                        $b2 = BaseCode::model()->find('f_id='.$model->type);
                        $title=$b2->F_NAME.$model->connect_title; //举报内容
                        $report_reason=''; //举报原因
                        $report_result='根据申诉证明材料，申诉未成功。'; //审核结果
                        $report_processing=''; //处理方式
                        $report_id=$model->id;
                        $if_appeal=0;
                        $sendArr=array('type'=>'申诉不成功通知','pic'=>$pic,'title'=>$title,'report_reason'=>$report_reason,'report_result'=>$report_result,'report_processing'=>$report_processing,'report_id'=>$report_id,'report_send_obj'=>1,'if_appeal'=>$if_appeal,'audit_state'=>0,'retype_id'=>$model->rtype_id);
                        send_msg(333,get_session('club_id'),$model->informant_gfid,$sendArr);
                    }
                }else{
                    if(!empty($_POST[$modelName]['state'])){
                        $model->setAttribute('state',$_POST[$modelName]['state']);
                        $b = BaseCode::model()->find('f_id='.$_POST[$modelName]['state']);
                        $model->setAttribute('state_name', $b->F_SHORTNAME);
                    }
                    if(!empty($_POST[$modelName]['report_processing_obj_state'])){
                        $model->setAttribute('report_processing_obj_state',$_POST[$modelName]['report_processing_obj_state']);
                        $b2 = BaseCode::model()->find('f_id='.$_POST[$modelName]['report_processing_obj_state']);
                        $model->setAttribute('report_processing_obj_state_name', $b2->F_SHORTNAME);
                    }
                    if(!empty($_POST[$modelName]['service_department'])){
                        $model->setAttribute('service_department', $_POST[$modelName]['service_department']);
                        $b3 = Club2List::model()->find('id='.$_POST[$modelName]['service_department']);
                        $model->setAttribute('service_department_name', $b3->club2_name);
                    }
                    if(!empty($_POST[$modelName]['account_service_department'])){
                        $model->setAttribute('account_service_department', $_POST[$modelName]['account_service_department']);
                        $b4 = Club2List::model()->find('id='.$_POST[$modelName]['account_service_department']);
                        $model->setAttribute('account_service_department_name', $b4->club2_name);
                    }
                    if(!empty($_POST[$modelName]['report_processing_msg_id'])){
                        $model->setAttribute('report_processing_msg_id', $_POST[$modelName]['report_processing_msg_id']);
                        $b5 = BaseCode::model()->find('f_id='.$_POST[$modelName]['report_processing_msg_id']);
                        $model->setAttribute('report_processing_msg_name', $b5->F_NAME);
                    }
                    if(!empty($_POST[$modelName]['report_processing_obj_id'])){
                        $model->setAttribute('report_processing_obj_id', $_POST[$modelName]['report_processing_obj_id']);
                        $b6 = BaseCode::model()->find('f_id='.$_POST[$modelName]['report_processing_obj_id']);
                        $model->setAttribute('report_processing_obj_name', $b6->F_NAME);
                    }
                    $sa=$model->save();
                    
                    
                    $sn=0;
                    if(!empty($model->service_department)){
                        $re_data = new ClubReportRecord();
                        $re_data->isNewRecord=true;
                        unset($re_data->id);
                        $re_data->report_id=$model->id;
                        $re_data->club2_id=$model->service_department;
                        $b2 = Club2List::model()->find('id='.$model->service_department);
                        $re_data->club2_name=$b2->club2_name;
                        $re_data->connect_id=get_session('gfid');
                        $re_data->connect_code=get_session('gfaccount');
                        // $re_data->connect_title=$model->admin_name->role_name.'-'.get_session('admin_name');
                        $re_data->connect_title=get_session('admin_name');
                        $re_data->content="'已将违规内容指派给【".$model->service_department_name."】处理'";
                        $re_data->add_time=date("Y-m-d H:i:s");
                        $re_data->state=$model->state;
                        $re_data->state_name=$model->state_name;
                        $re_data->deal_state=$model->report_processing_msg_id;
                        $re_data->deal_state_name=$model->report_processing_msg_name;
                        $sn=$re_data->save();
                    }
                    // if(!empty($model->report_processing_msg_id)){
                    if(!empty($model->report_processing_msg_id)&&$model->state==755){
                        $re_data = ClubReportRecord::model()->find('report_id='.$model->id.' and deal_state='.$model->report_processing_msg_id);
                        if(empty($re_data)){
                            $re_data = new ClubReportRecord();
                            $re_data->isNewRecord=true;
                            unset($re_data->id);
                        }
                        $re_data->report_id=$model->id;
                        $re_data->connect_id=get_session('gfid');
                        $re_data->connect_code=get_session('gfaccount');
                        $re_data->connect_title=get_session('admin_name');
                        // $re_data->connect_title=$model->admin_name->role_name.'-'.get_session('admin_name');
                        $re_data->content="'已将违规内容做【".$model->report_processing_msg_name."】处理'";
                        $re_data->add_time=date("Y-m-d H:i:s");
                        $re_data->state=$model->state;
                        $re_data->state_name=$model->state_name;
                        $re_data->deal_state=$model->report_processing_msg_id;
                        $re_data->deal_state_name=$model->report_processing_msg_name;
                        $re_data->dispose_time=date("Y-m-d H:i:s");
                        $sn=$re_data->save();
                        // $sn=1;
                        
                        if($model->rtype_id==1182){
                            $vl=506;
                            $vl2=649;
                            $vl3=510;
                        }else{
                            $vl=507;
                            $vl2=648;
                            $vl3=509;
                        }
                        if($model->type==737||$model->type==738||$model->type==739||$model->type==741||$model->type==742){   //信息、图集、视频屏蔽处理
                            $sn2=ClubNews::model()->updateByPk($model->connect_id, array( 'if_del' => $vl));
                            if($sn!=1&&$sn2!=1){
                                $sn=0;
                            }
                        }else if($model->type==744){  //直播屏蔽处理
                            $sn2=VideoLive::model()->updateByPk($model->connect_id, array( 'if_del' => $vl2));
                            if($sn!=1&&$sn2!=1){
                                $sn=0;
                            }
                        }else if($model->type==745){  //点播屏蔽处理
                            $sn2=BoutiqueVideo::model()->updateByPk($model->connect_id, array( 'if_del' => $vl2));
                            if($sn!=1&&$sn2!=1){
                                $sn=0;
                            }
                        }else if($model->type==740){  //赛事详情屏蔽处理
                            $sn2=GameList::model()->updateByPk($model->connect_id, array( 'if_del' => $vl3));
                            if($sn!=1&&$sn2!=1){
                                $sn=0;
                            }
                        }else if($model->type==977){  //培训详情屏蔽处理
                            $sn2=ClubStoreTrain::model()->updateByPk($model->connect_id, array( 'if_del' => $vl3));
                            if($sn!=1&&$sn2!=1){
                                $sn=0;
                            }
                        }else if($model->type==981){  //动动约详情屏蔽处理
                            $sn1=QmddServerSourcer::model()->updateByPk($model->connect_id, array( 'if_del' => $vl3));
                            $sn2=QmddServerSetList::model()->updateAll(array( 'if_del' => $vl3),'server_sourcer_id='.$model->connect_id);
                            $sn3=QmddServerSetData::model()->updateAll(array( 'if_del' => $vl3),'server_sourcer_id='.$model->connect_id);
                            if($sn!=1&&$sn1!=1&&$sn2!=1&&$sn3!=1){
                                $sn=0;
                            }
                        }else if($model->type==749){  //商品详情屏蔽处理
                            $sn2=MallProducts::model()->updateByPk($model->connect_id, array( 'IS_DELETE' => $vl3));
                            if($sn!=1&&$sn2!=1){
                                $sn=0;
                            }
                        }else if($model->type==747){  //动动群屏蔽处理
                            $sn2=GfCrowdBase::model()->updateByPk($model->connect_id, array( 'if_del' => $vl3));
                            if($sn!=1&&$sn2!=1){
                                $sn=0;
                            }
                        }else if($model->type==958){  //动动圈心情内容屏蔽处理
                            $sn2=JlbMoods::model()->updateByPk($model->connect_id, array( 'if_del' => $vl3));
                            if($sn!=1&&$sn2!=1){
                                $sn=0;
                            }
                        }else if($model->type==743){  //评论屏蔽处理
                            $sn2=CommentList::model()->updateByPk($model->connect_id, array( 'if_del' => $vl3));
                            if($sn!=1&&$sn2!=1){
                                $sn=0;
                            }
                        }else if($model->type==980){  //评价屏蔽处理
                            $sn2=QmddAchievemenData::model()->updateByPk($model->connect_id, array( 'if_del' => $vl3));
                            if($sn!=1&&$sn2!=1){
                                $sn=0;
                            }
                        }
                    }
                    if(!empty($model->account_service_department)){
                        $re_data = new ClubReportRecord();
                        $re_data->isNewRecord=true;
                        unset($re_data->id);
                        $re_data->report_id=$model->id;
                        $re_data->club2_id=$model->account_service_department;
                        $b2 = Club2List::model()->find('id='.$model->account_service_department);
                        $re_data->club2_name=$b2->club2_name;
                        $re_data->connect_id=get_session('gfid');
                        $re_data->connect_code=get_session('gfaccount');
                        // $re_data->connect_title=$model->admin_name->role_name.'-'.get_session('admin_name');
                        $re_data->connect_title=get_session('admin_name');
                        $re_data->content="'已将违规账号指派给【".$model->account_service_department_name."】处理'";
                        $re_data->add_time=date("Y-m-d H:i:s");
                        $re_data->state=$model->report_processing_obj_state;
                        $re_data->state_name=$model->report_processing_obj_state_name;
                        $re_data->deal_state=$model->report_processing_obj_id;
                        $re_data->deal_state_name=$model->report_processing_obj_name;
                        $sn=$re_data->save();
                    }
                    // if(!empty($model->report_processing_obj_id)){
                    if(!empty($model->report_processing_obj_id)&&$model->report_processing_obj_state==755){
                        $re_data = ClubReportRecord::model()->find('report_id='.$model->id.' and deal_state='.$model->report_processing_obj_id);
                        if(empty($re_data)){
                            $re_data = new ClubReportRecord();
                            $re_data->isNewRecord=true;
                            unset($re_data->id);
                        }
                        $re_data->report_id=$model->id;
                        $re_data->connect_id=get_session('gfid');
                        $re_data->connect_code=get_session('gfaccount');
                        // $re_data->connect_title=$model->admin_name->role_name.'-'.get_session('admin_name');
                        $re_data->connect_title=get_session('admin_name');
                        $re_data->content="'已将违规账号做【".$model->report_processing_obj_name."】处理'";
                        $re_data->add_time=date("Y-m-d H:i:s");
                        $re_data->state=$model->report_processing_obj_state;
                        $re_data->state_name=$model->report_processing_obj_state_name;
                        $re_data->deal_state=$model->report_processing_obj_id;
                        $re_data->deal_state_name=$model->report_processing_obj_name;
                        $re_data->dispose_time=date("Y-m-d H:i:s");
                        $sn=$re_data->save();
                        // $sn=1;

                        if($model->connect_publisher_type==210){
                            $gfUser=userlist::model()->find('GF_ID='.$model->connect_publisher_id);
                            $GfUserLock = new GfUserLock;

                            $GfUserLock->isNewRecord = true;
                            unset($GfUserLock->ID);
                            $GfUserLock->GF_ID=$model->connect_publisher_id;
                            $GfUserLock->GF_ACCOUNT=$gfUser->GF_ACCOUNT;
                            $GfUserLock->GF_NAME=$gfUser->GF_NAME;
                            $GfUserLock->ZSXM=$gfUser->ZSXM;
                            $GfUserLock->club_id=$gfUser->club_id;
                            $GfUserLock->if_del=510;
                            if($model->report_processing_obj_id==1273){
                                $GfUserLock->user_state=1284;
                                $b2 = BaseCode::model()->find('f_id=1284');
                                $GfUserLock->user_state_name=$b2->F_NAME;
                                
                                $gfUser->user_state=1284;
                            }else if($model->report_processing_obj_id==1274){
                                $GfUserLock->user_state=1282;
                                $b2 = BaseCode::model()->find('f_id=1282');
                                $GfUserLock->lock_date_start=date('Y-m-d H:i:s'); 
                                $GfUserLock->lock_date_end=date('Y-m-d H:i:s', strtotime('7 days'));
                                $GfUserLock->user_state_name=$b2->F_NAME;

                                $gfUser->user_state=1282;
                                $gfUser->lock_date_start=date('Y-m-d H:i:s'); 
                                $gfUser->lock_date_end=date('Y-m-d H:i:s', strtotime('7 days'));
                            }else if($model->report_processing_obj_id==1275){
                                $GfUserLock->user_state=1283;
                                $b2 = BaseCode::model()->find('f_id=1283');
                                $GfUserLock->user_state_name=$b2->F_NAME;
                                $GfUserLock->lock_date_start=date('Y-m-d H:i:s'); 
                                $GfUserLock->lock_date_end=date('Y-m-d H:i:s', strtotime('30 days'));
                                $gfUser->user_state=1283;
                                
                                $gfUser->lock_date_start=date('Y-m-d H:i:s'); 
                                $gfUser->lock_date_end=date('Y-m-d H:i:s', strtotime('30 days'));
                            }else if($model->report_processing_obj_id==1276){
                                $GfUserLock->user_state=507;
                                $b2 = BaseCode::model()->find('f_id=507');
                                $GfUserLock->user_state_name=$b2->F_NAME;
                                $GfUserLock->lock_date_start=date('Y-m-d H:i:s'); 
                                $GfUserLock->lock_date_end='9999-09-09';
                                $gfUser->user_state=507;
                                
                                $gfUser->lock_date_start=date('Y-m-d H:i:s'); 
                                $gfUser->lock_date_end='9999-09-09';
                            }else if($model->report_processing_obj_id==1280||$model->report_processing_obj_id==1281){
                                $GfUserLock->user_state=506;
                                $b2 = BaseCode::model()->find('f_id=506');
                                $GfUserLock->user_state_name=$b2->F_NAME;
                                $gfUser->user_state=506;
                            }
                            $GfUserLock->admin_gfid=get_session('gfid');
                            $GfUserLock->admin_gfname=get_session('admin_name');
                            // $GfUserLock->lock_reason=$_POST['lock_reason'];
                            $GfUserLock->uDate=date('Y-m-d H:i:s'); 
                            $sa=$GfUserLock->save();
                            $sb=$gfUser->save();
                            if($sa==1&&$sb==1&&$sn==1){
                                $sn=1;
                            }else{
                                $sn=0;
                            }
                        }else if($model->connect_publisher_type==502){
                            if($model->connect_publisher_project_id!=0){
                                $projectId= explode(',', $model->connect_publisher_project_id);
                            }
                            if(!empty($projectId))foreach($projectId as $p_id){
                                $clubProject=ClubProject::model()->find('id='.$p_id);
                                $clubProject->project_state=$model->report_processing_obj_id;
                                $sb=$clubProject->save();
                                if($sb==1&&$sn==1){
                                    $sn=1;
                                }else{
                                    $sn=0;
                                }
                            };
                        }
                    }
                    if($model->report_processing_obj_state==754){
                        $re_data = ClubReportRecord::model()->find('report_id='.$model->id.' and deal_state='.$model->report_processing_obj_id);
                        if(empty($re_data)){
                            $re_data = new ClubReportRecord();
                            $re_data->isNewRecord=true;
                            unset($re_data->id);
                        }
                        $re_data->report_id=$model->id;
                        $re_data->connect_id=get_session('gfid');
                        $re_data->connect_code=get_session('gfaccount');
                        // $re_data->connect_title=$model->admin_name->role_name.'-'.get_session('admin_name');
                        $re_data->connect_title=get_session('admin_name');
                        $re_data->content="【违规账号】不处理";
                        $re_data->add_time=date("Y-m-d H:i:s");
                        $sn=$re_data->save();
                    }
                    
                    if($model->state==755&&$model->report_processing_obj_state==755){
                        $basepath=BasePath::model()->getPath(191);
                        $pic='';
                        $b2 = BaseCode::model()->find('f_id='.$model->type);
                        $title=$b2->F_NAME.$model->connect_title; //举报内容
                        $report_processing=$model->report_processing_msg_name.','.$model->report_processing_obj_name.'。'; //处理方式
                        $report_id=$model->id;
                        if($model->rtype_id==1181){
                            $if_appeal=1;
                        }else{
                            $if_appeal=0;
                        }
                        if($model->rtype_id==1182){
                            $type='申诉成功通知';
                            $type2='申诉成功通知';
                            $report_result='根据申诉证明材料，确认未存在违规行为。'; //审核结果
                            $report_reason=''; //举报原因
                        }else{
                            $type='举报成功通知';
                            $type2='被举报处理通知';
                            $report_result='确认存在违规行为'; //审核结果
                            $report_reason=$model->report_content; //举报原因
                        }
                        $sendArr=array('type'=>$type,'pic'=>$pic,'title'=>$title,'report_reason'=>$report_reason,'report_result'=>$report_result,'report_processing'=>$report_processing,'report_id'=>$report_id,'report_send_obj'=>0,'if_appeal'=>$if_appeal,'audit_state'=>1,'retype_id'=>$model->rtype_id);
                        $sendArr2=array('type'=>$type2,'pic'=>$pic,'title'=>$title,'report_reason'=>$report_reason,'report_result'=>$report_result,'report_processing'=>$report_processing,'report_id'=>$report_id,'report_send_obj'=>1,'if_appeal'=>$if_appeal,'audit_state'=>1,'retype_id'=>$model->rtype_id);
                        if($model->connect_publisher_type==210){
                            if($model->rtype_id==1182){
                                $gf_id=$model->informant_gfid;
                            }else{
                                $gf_id=$model->connect_publisher_id;
                            }
                        }else if($model->connect_publisher_type==502){
                            if($model->rtype_id==1182){
                                $gf_id=$model->informant_gfid;
                            }else{
                                $club_gf_id=ClubList::model()->find('id='.$model->connect_publisher_id);
                                $gf_id=$club_gf_id->apply_club_gfid;
                            }
                        }
                        // 举报人通知
                        send_msg(333,get_session('club_id'),$model->gfid,$sendArr);
                        // 被举报人通知
                        send_msg(333,get_session('club_id'),$gf_id,$sendArr2);
                    }
                    if($sa==1&&$sn==1){
                        $sv=1;
                    }else{
                        $sv=0;
                    }
                }
                
            // }
            show_status($sv,"保存成功",$cookie,"保存失败");
        }
    }
    

    // public function actionDelete($id) {
    //     $modelName = $this->model;
    //     $model = $modelName::model();
    //     $count = $model->deleteAll('id in(' . $id . ') OR ADVER_PID in(' . $id . ')');
    //     if ($count > 0) {
    //         AdvertisementProject::model()->deleteAll('adv_id in(' . $id . ')');
    //         ajax_status(1, '删除成功');
    //     } else {
    //         ajax_status(0, '删除失败');
    //     }
    // }

}
