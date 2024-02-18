<?php
//http://127.0.0.1/qmdd_admin/admin/qmdd2018/index.php?r=io_game/getdata&data=
class io_gameController extends BaseController {
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
 public function oldp() {
      
global $p_gf_service_data,$p_basepath,$p_common_tool,$p_gf_user_login_history;
$param=$p_gf_user_login_history->checkREQUEST($_POST,0);
$data=$p_gf_user_login_history->get_error(1,"非法操作！");
$action = $param['action'];

if ($action == 'get_game_list') {//赛事列表
	global $p_gamelist;
	$p_gamelist->new_get_all_games_desc($param);
} else if ($action == 'get_game_detail') {//赛事详情
	global $p_gamelist;
	$p_gamelist->get_game_detail($param);
} else if ($action == 'get_game_notice') {//赛事通告
	global $p_gamelist;
	$p_gamelist->get_game_notice($param);
} else if ($action == 'get_game_notice_detail') {//赛事通告详情
	global $p_gamelist;
	$p_gamelist->get_game_notice_detail($param);
}elseif ($action == 'get_game_live_program') {//获取赛事直播节目单
	global $p_videolive_programs;
	$p_videolive_programs->getGameLiveProgramList($param);
} else if ($action == 'get_single_game_index') {//获取赛事首页
    global $p_gamelist;
    $p_gamelist->get_single_game_index($param);
}else if($action == 'check_join_game'){
	global $s_game_service;
	$s_game_service->newCheckJoinGame($param);
}else if ($action == 'join_game') {//参加赛事
	global $s_game_service;
	$s_game_service->apply_join_game($param,1);
}else if($action == 'apply_join_game'){//申请赛事报名、报项目
	global $s_game_service;
	$s_game_service->apply_join_game($param,1);
}else if($action == 'notify_game_applicants'){//前端请求apply_join_game后调用赛事报名、报项目申请后判断是否自动审核并通知报名者缴费
	global $p_gf_service_data;
	$p_gf_service_data->notify_game_applicants($param);
}else if ($action == 'new_apply_join_game') {//参加赛事（单个项目报名申请／组队申请）
	global $s_game_service;
	$s_game_service->new_apply_join_game($param);
 }elseif($action == 'get_join_game'){//获取竞赛项目、可加入赛事（返回所有赛事项目）
	global $s_game_service;
	$s_game_service->new_get_game_join_project($param);
 } else if ($action == 'get_lh_top') {//排名榜
 	global $p_top_score;
 	$p_top_score->get_lh_top($param);
 }  else if ($action == 'applaud_game_discuss') {//对某赛事的评论点赞
    $discuss_id = $param['discuss_id'];//评论ID
    $gfid = $param['gfid'];//gfid
    global $p_comment_praise;
    $p_comment_praise->applaud_club_news_discuss($data,$gfid,1,$discuss_id);
}else if($action == 'get_service_entered_list'){//获取服务报名申请列表  
	global $p_gf_service_data;
	$p_gf_service_data->getServiceEnteredList($param);
}else if($action == 'get_service_entered_detail'){//获取服务报名申请详细
	global $p_gf_service_data;
	$p_gf_service_data->getServiceEnteredDetail($param);
}else if($action == 'get_game_entered_list'){//获取我的赛事报名申请列表  
	global $p_gf_service_data;
	$p_gf_service_data->getGameEnteredList($param);
}else if($action == 'get_game_entered_detail'){//获取我的赛事报名申请详细
	global $p_gf_service_data;
	$p_gf_service_data->getGameEnteredDetail($param);
}else if($action == 'revoke_service_entered'){//撤销／删除服务报名申请
	$ret=$p_gf_service_data->revoke_service_entered($param);
}elseif($action == 'submission_to_audit'){//服务报名提交审核
	global $p_gf_service_data;
	$p_gf_service_data->SubmissionToAudit($param);
}else if($action == 'get_add_order_details'){//获取服务报名下单确认信息
	global $p_mall_shopping_car_copy;
    $p_mall_shopping_car_copy->getAddServiceOrderInfo($param);
}else if($action == 'add_game_order'){//服务报名下单
	global $p_gf_service_data;
	$p_gf_service_data->serviceAddPayOrder($param);
}else if ($action == 'apply_sign_train') {//报名培训
    global $p_club_store_train;
    $p_club_store_train->apply_sign_train($param);
}else if($action == 'get_train_type'){//培训类型
 	global $p_mall_products_type_snameDao;
    $p_mall_products_type_snameDao->getTrainTypeList(1);
}else if($action == 'get_can_join_game_friend'){//获取可以参加本赛事的好友
 	 global $p_game_list_data;
     $p_game_list_data->canJoinFriendList($param);
}else if($action == 'get_can_join_game_crowd_member'){//获取可以参加本赛事的群成员
 	 global $p_game_list_data;
     $p_game_list_data->canJoinCrowdMemberList($param);
}else if($action == 'get_joiner_team_member'){//获取团队成员列表
 	 global $p_game_sign_list;
     $p_game_sign_list->getTeamDetail($param);
}else if($action == 'get_game_team_member'){//获取团队成员列表(组队详情)
 	 global $p_game_sign_list;
     $p_game_sign_list->getGameTeamDetail($param);
}else if($action == 'change_team_member'){//团队成员调整(废弃)
 	 global $p_game_sign_list;
     $p_game_sign_list->changeTeamMember($param);
}else if($action == 'add_team_member'){//服务报名详情中，组队中状态，对团队成员调整-添加
 	 global $p_game_sign_list;
     $p_game_sign_list->addTeamMember($param);
}else if($action == 'add_team_member_more'){//服务报名详情中，组队中状态，添加团队成员 +多人
 	 global $p_game_sign_list;
     $p_game_sign_list->addTeamMemberMore($param);
}else if($action == 'edit_team_member'){//服务报名详情中，组队中状态，团队成员短名、备注调整
 	 global $p_game_sign_list;
     $p_game_sign_list->editTeamMember($param);
}else if($action == 'edit_team_info'){//服务报名详情中，组队中状态，修改团队名称、短名、负责人
 	 global $p_game_team_table;
     $p_game_team_table->EditTeamInfo($param);
}else if($action == 'delete_team_member'){//服务报名详情中，组队中状态，对团队成员调整-删除
 	 global $p_game_sign_list;
     $p_game_sign_list->deleteTeamMember($param);
}else if($action == 'game_team_member_invite_detail'){//服务报名详情中，组队中状态，被邀请详情
 	 global $p_game_sign_list;
     $p_game_sign_list->TeamMemberInviteDetail($param);
}else if($action == 'team_member_reply'){//服务报名详情中，组队中状态，邀请团队成员后，被邀请者回复
 	 global $p_game_sign_list;
     $p_game_sign_list->TeamMemberReply($param);
}else if($action == 'commit_apply_game'){//服务报名详情中，组队中状态提交审核
 	 global $p_game_sign_list;
     $p_game_sign_list->commit_apply_game($param);
}else if($action == 'check_referees_join_game'){//裁判员申请加入赛事判断
	global $p_game_referees_list;
	$p_game_referees_list->check_referees_join_game($param);
}else if($action == 'get_referees_join_project'){//裁判可加入赛事项目
	global $p_game_referees_list;
	$p_game_referees_list->get_referees_join_project($param);
}else if($action == 'referees_join_game'){//裁判加入赛事项目
	global $p_game_referees_list;
	$p_game_referees_list->referees_join_game($param);
}else if($action == 'get_game_referees_list'){//赛事裁判
	global $p_game_referees_list;
	$p_game_referees_list->get_game_referees_list($param);
}else if($action == 'get_game_player'){//赛事选手
	global $p_game_sign_list;
	$p_game_sign_list->get_game_player($param);
}else if($action == 'get_game_data_player'){//赛事竞赛项目参赛名单
	global $p_game_sign_list;
	$p_game_sign_list->get_game_data_player($param);
}elseif($action == 'my_sign_service'){//签到历史记录
	global $p_gf_user_signin;
	$p_gf_user_signin-> getSignServiceList($param);
}elseif($action == 'sign_in_out'){//签到／签退
	global $p_gf_user_signin;
	$p_gf_user_signin-> signInOut($param);
}elseif($action == 'get_entry_nformation'){//赛事报名须知
	global $s_game_service;
	$s_game_service->getEntryInformation($param);
}elseif($action == 'get_detail_game_video'){//获取赛事视频详情
	global $p_game_news;
	$p_game_news->getVideoNewsDetail($param);
}elseif($action == 'get_competition_project'){//获取赛事竞赛项目
	global $p_game_list_arrange;
	$p_game_list_arrange->getArrangeCompetitionProject($param);
}elseif($action == 'get_event_schedule'){//获取赛事日程表
	global $p_game_list_arrange;
	$p_game_list_arrange->getEventSchedule($param);
}elseif($action == 'get_competition_project_round_match'){//获取赛事安排的轮次／场次
	global $p_game_list_arrange;
	$p_game_list_arrange->getArrangeRound($param);
}elseif($action == 'get_game_arrange'){//根据轮次场次获取赛程安排
	global $p_game_list_arrange;
	$p_game_list_arrange->getArrange($param);
}elseif($action == 'get_game_arrange_fro_web'){//根据轮次场次获取赛程安排
	global $p_game_list_arrange;
	$p_game_list_arrange->getArrangeForWeb($param);
}elseif($action == 'get_game_last_result'){//赛事轮次成绩、实时成绩
	global $p_game_list_arrange;
	$p_game_list_arrange->getGameLastResult($param);
}elseif($action == 'get_game_last_result_for_web'){//赛事轮次成绩、实时成绩
	global $p_game_list_arrange;
	$p_game_list_arrange->getGameLastResultForWeb($param);
}elseif($action == 'get_game_rounds_result_for_web'){//赛事轮次成绩
	global $p_game_list_arrange;
	$p_game_list_arrange->getGameRoundsResultForWeb($param);
}elseif($action == 'get_game_palyer_result'){//参赛选手赛事场次成绩
	global $p_game_list_arrange;
	$p_game_list_arrange->getGamePlayerResult($param);
}elseif($action == 'get_game_palyer_result_new'){//参赛选手赛事场次成绩 datas['member']返回每场赛事参赛选手／队伍
	global $p_game_list_arrange;
	$p_game_list_arrange->getGamePlayerResult_new($param);
}elseif($action == 'new_get_event_category'){ //获取赛事 项目、竞赛项目、轮次、场地、小组，比赛开始／结束时间，以供筛选
	global $p_game_list_arrange;
	$p_game_list_arrange->getEventCategory($param,1);
}elseif($action == 'new_get_event_schedule'){ //获取赛程-竞赛日程
	global $p_game_list_arrange;
	$p_game_list_arrange->getNewEventSchedule($param);
}elseif($action == 'new_get_event_schedule2'){ //获取赛程-竞赛日程(对抗类：时间／场地、对战、状态、小组)
	global $p_game_list_arrange;
	$p_game_list_arrange->getNewEventSchedule2($param);
}elseif($action == 'new_get_event_competition'){ //获取赛程-对战表
	global $p_game_list_arrange;
	$p_game_list_arrange->getNewEventCompetition($param);
}elseif($action == 'new_get_game_matches_result'){//成绩查询-场次成绩
	global $p_game_list_arrange;
	$p_game_list_arrange->getNewGameMatchesResult($param);
}elseif($action == 'new_get_game_total_result'){//成绩查询-总成绩／名次
	global $p_game_list_arrange;
	$p_game_list_arrange->getNewGameTotalResult($param);
}elseif($action == 'new_get_game_person_result'){//成绩查询-选手每场成绩
	global $p_game_list_arrange;
	$p_game_list_arrange->getNewGamePersonResult($param);
} else if ($action == 'get_game_news') {//获取赛事动态列表
    global $p_game_news;
	$p_game_news->fun_get_game_news($param);
} else if ($action == 'get_single_game_information') {//通过ID获取单个赛事常规图文信息详细
	global $p_game_news;
	$p_game_news->getInformationDetail($param);
} else if ($action == 'get_single_game_picture') {//通过ID获取单个赛事图集详细
    global $p_game_news;
	$p_game_news->getMapsDetail($param);
} else if ($action == 'get_single_game_video') {//通过ID获取单个赛事视频详细
    global $p_game_news;
	$p_game_news->getVideoDetail($param);
} else if ($action == 'get_insurance_set') {//保险的公司列表，保险种类列表
    global $p_gf_member_insurance;
	$p_gf_member_insurance->getInsuranceSet($param);
} else if ($action == 'add_insurance') {//添加保险
    global $p_gf_member_insurance;
	$p_gf_member_insurance->AddInsuredInsurance($param);
} else if ($action == 'get_insurance_list') {//获取保险列表
    global $p_gf_member_insurance;
	$p_gf_member_insurance->getInsuranceList($param);
} else if ($action == 'get_insurance_detail') {//获取保险详情
    global $p_gf_member_insurance;
	$p_gf_member_insurance->getInsuranceDetail($param);
} else if ($action == 'delete_insurance') {//删除保险
    global $p_gf_member_insurance;
	$p_gf_member_insurance->DeleteInsurance($param);
} else if ($action == 'send_insurance_to_friend') {//保险单分享给好友
    global $p_gf_member_insurance;
	$p_gf_member_insurance->SendInsuranceToFriend($param);
} else if ($action == 'relate_insurance') {//关联保险单
    global $p_gf_member_insurance;
	$p_gf_member_insurance->RelateInsurance($param);
} else if ($action == 'cancel_relate_insurance') {//取消关联保险单
    global $p_gf_member_insurance;
	$p_gf_member_insurance->DeleteInsuranceRelation($param);
} else if ($action == 'get_insurance_no_relation_friend') {//该保险单，好友未关联名单，用于前端发送分享
    global $p_gf_member_insurance;
	$p_gf_member_insurance->get_insurance_no_relation_friend($param);
} else if ($action == 'get_activity_detail') {//活动详情
	global $p_activity_list;
	$p_activity_list->getActivityDetail($param);
} else if ($action == 'apply_join_activity') {//活动报名
	global $p_activity_list;
	$p_activity_list->apply_join_activity($param);
}else if($action == 'get_activity_entered_list'){//获取我的活动报名申请列表  
	global $p_activity_sign_list;
	$p_activity_sign_list->getActivityEnteredList($param);
}else if($action == 'get_activity_entered_detail'){//获取我的活动报名申请详细
	global $p_activity_sign_list;
	$p_activity_sign_list->getActivityEnteredDetail($param);
}elseif ($action == 'get_activity_live_program') {//获取活动直播节目单
	global $p_videolive_programs;
	$p_videolive_programs->getActivityLiveProgramList($param);
}
$p_gf_user_login_history->exit_json($data);
}


public function actionGet_activity_list($exit=1) {
		$state= $_POST['activity_state'];
		$project_id=$_POST['project_id'];
		$keyword=$_POST['keyword'];
		$default=$_POST['default'];    
	    $tmp=BaseCode::model()->getByType('ACTIVITYSTATE');
	    $data['activity_state']=toIoArray($tmp,"f_id:id,F_NAME:f_name",array('id'=>'-1','name'=>'不限'));//状态
	    $data['default']=$data['activity_state'][0];
	  	$ws=get_where("1",$project_id,"project_id",$project_id);
	    $ws=get_where_like($ws,$keyword,"ActivityList.activity_title",$keyword);
	    if($default==1){
	       ActivityList::model()->getActivityStateNameDefault($ws,$data);
	     }  
        $criteria = new CDbCriteria;

        $criteria->with = 'ActivityList';  
        $criteria->condition=$ws;
        $tmpdata=parent::_getDataPage(ActivityListData::model(), $criteria,$_POST['pageSize'],$_POST['page']);

      	$pic_path=BasePath::model()->get_base_path('activity_list','activity_small_pic');	
	     $da=array();
	     foreach($tmpdata['tmplist'] as $k=>$v){
            	  $da[$k]['id']=$v->ActivityList->id;
            	  $da[$k]['activity_title']=$v->ActivityList->activity_title;
	  			  $da[$k]['activity_small_pic']=$pic_path.$v->ActivityList->activity_small_pic;
				  $da[$k]['activity_state']=$v->ActivityList->getState();
				  $da[$k]['activity_state_name']=$v->ActivityList->getStateName();
				  $da[$k]['activity_address']=$v->ActivityList->activity_address;
				  $da[$k]['udate']=$v->ActivityList->uDate;
				  $da[$k]['activity_club_id']=$v->ActivityList->activity_club_id;
				  $da[$k]['activity_club_name']=$v->ActivityList->activity_club_name;
				  $da[$k]['activity_time']=$v->ActivityList->activity_time;
				  $da[$k]['activity_time_end']=$v->ActivityList->activity_time_end;
				  $da[$k]['sign_up_date']=$v->ActivityList->sign_up_date;
				  $da[$k]['effective_time']=$v->ActivityList->effective_time;
				  $da[$k]['activity_point']=$v->ActivityList->latitude.','.$v->ActivityList->Longitude;
				  $da[$k]['min_price']=$v->activity_money;
				  $da[$k]['max_price']=$v->activity_money;
				  $da[$k]['activity_project']=$v->project_name;
		  }
		$data['datas'] = $da;
		$data['nowpage'] = $_POST['page'];
	    $data['total_count'] = $tmpdata['count'];
		BasePath::model()->set_error($data,0,"获取成功",$exit);
		return $exit==2?$data : $da;
	   }


	/**
	 * 判断是否符合报名竞赛项目条件
	 * $param['visit_gfid','game_data_id'];
	 */
	public function actionCheckJoinGameData(){
        $param=decodeAskParams($_REQUEST,1);
		$game_check=GameListData::model()->CheckAppliedProject($param,null);//竞赛项目
		$data=CommonTool::model()->getKeyArray($game_check,'error,msg,sex,born,lh,club,real');
		if(!isset($game_check['game_data'])){
			set_error($data,$game_check['error'],$game_check['msg'],1);
		}
		$orange_color="<font color=\"#FF6600\">";
		$black_color="<font color=\"#000000\">";
		$front_str="</font>";
		$br_str="<br/>";
		$fail_notify=$black_color."很抱歉，报名该赛事未满足以下条件，亲请继续加油哦！".$front_str.$br_str.$br_str;
		//√ ×
		$realname_notify=" 符合GF平台实名制会员；";
		if(!isset($game_check['gf_data'])){
			$realname_notify=$orange_color."× ".$realname_notify;
		}else{
			$realname_notify=$black_color."√ ".$realname_notify;
		}
		$realname_notify.=$front_str.$br_str;
		$project_notify=" 符合赛事发布的竞赛项目在位单位学员；";
		if(isset($game_check['club'])){
			$project_notify=$black_color."√ ".$project_notify;
		}else{
			$project_notify=$orange_color."× ".$project_notify;
		}
		$project_notify.=$front_str.$br_str;
		$fail_notify.=$realname_notify.$project_notify;
		$data['msg_html']=$fail_notify;
		$data['realname']=!empty($game_check['real'])?0:1;
		$data['project']=!empty($game_check['club'])?0:1;
		unset($game_check['gf_data']);
		unset($game_check['game_data']);
		if($game_check['error']){
			set_error($data,$game_check['error'],$game_check['msg'],1);
		}
    }
	
	/**
	 * 获取赛事报名信息
	 */
	public function actionGetGameRegistrationDatas(){
        $param=decodeAskParams($_REQUEST,1);
        $param['exit']=1;
        $data=get_error(1,'获取失败');
        $data['show_data']=json_decode(base64_decode('W3sgICJ0eXBlX3N0YXRlIjogMCwgImhpZGUiOiAxLCAidHlwZV90aXRsZSI6ICLlp5PlkI0iLCAidHlwZV9ub3RpZnkiOiAiIiwicGFyYW0iOiAicmVhbF9uYW1lIn0sIHsgInR5cGVfc3RhdGUiOiA1LCAidHlwZV90aXRsZSI6ICLnn63lkI0iLCAidHlwZV9ub3RpZnkiOiAi6K+36L6T5YWlIiwgICJwYXJhbSI6ICJzaG9ydF9uYW1lIn0sIHsidHlwZV9zdGF0ZSI6MCwgInR5cGVfdGl0bGUiOiAi5oCn5YirIiwgInR5cGVfbm90aWZ5IjogIiIsICJwYXJhbSI6ICJzZXgiIH0sICAgeyJ0eXBlX3N0YXRlIjowLCAidHlwZV90aXRsZSI6ICLlh7rnlJ/ml6XmnJ8iLCAidHlwZV9ub3RpZnkiOiAiIiwgInBhcmFtIjogImJvcm4iIH0seyJ0eXBlX3N0YXRlIjoyMSwidHlwZV90aXRsZSI6IiJ9LCAgeyAidHlwZV9zdGF0ZSI6IDAsICJ0eXBlX3RpdGxlIjogIuexjei0ryIsICJ0eXBlX25vdGlmeSI6ICIiLCAicGFyYW0iOiAibmF0aXZlIiB9LHsidHlwZV9zdGF0ZSI6IDAsICJ0eXBlX3RpdGxlIjogIuawkeaXjyIsICJ0eXBlX25vdGlmeSI6ICIiLCAicGFyYW0iOiAibmF0aW9uIn0seyAidHlwZV9zdGF0ZSI6IDAsICJ0eXBlX3RpdGxlIjogIui6q+S7veivgeWPtyIsICJ0eXBlX25vdGlmeSI6ICIiLCAicGFyYW0iOiAiaWRfY2FyZCIgfSx7InR5cGVfc3RhdGUiOiAxMiwgInR5cGVfdGl0bGUiOiAi5omL5py65Y+356CBKiIsICJ0eXBlX25vdGlmeSI6ICLor7fovpPlhaUiLCAicGFyYW0iOiAicmVnaXN0cmF0aW9uX3Bob25lIiB9LHsidHlwZV9zdGF0ZSI6IDExLCAidHlwZV90aXRsZSI6ICLmiYDlnKjljLrln58iLCAidHlwZV9ub3RpZnkiOiAi6K+36YCJ5oupIiwgInBhcmFtIjogInJlZ2lzdHJhdGlvbl9hcmVhIiB9LHsidHlwZV9zdGF0ZSI6MjEsInR5cGVfdGl0bGUiOiIifSwgIHsidHlwZV9zdGF0ZSI6IDUsICJ0eXBlX3RpdGxlIjogIuS9k+mHjShLZykiLCAidHlwZV9ub3RpZnkiOiAi6K+36L6T5YWlIiwgICJwYXJhbSI6ICJ3ZWlnaHQifSwgeyJ0eXBlX3N0YXRlIjogNSwgInR5cGVfdGl0bGUiOiAi6Lqr6auYKGNtKSIsICJ0eXBlX25vdGlmeSI6ICLor7fovpPlhaUiLCAicGFyYW0iOiAiaGVpZ2h0In0sIHsidHlwZV9zdGF0ZSI6MjEsInR5cGVfdGl0bGUiOiIifSx7InR5cGVfc3RhdGUiOjAsICJ0eXBlX3RpdGxlIjogIum+meiZjuetiee6pyIsICJ0eXBlX25vdGlmeSI6ICIiLCAicGFyYW0iOiAibGgiIH0seyJ0eXBlX3N0YXRlIjoyMSwidHlwZV90aXRsZSI6IiJ9LCAgeyJ0eXBlX3N0YXRlIjoxMDQsICJ0eXBlX3RpdGxlIjogIui/keacn+eFp+eJhyoiLCAidHlwZV9ub3RpZnkiOiAiKOi/keacn+acrOS6uu+8muWFjeWGoOWktOWDj+OAgeWNiui6q+eFp+OAgeWFqOi6q+eFpykiLCAicGFyYW0iOiAicmVjZW50X3Bob3RvIn0sIHsidHlwZV9zdGF0ZSI6IDEwNCwgInR5cGVfdGl0bGUiOiAi5L+d6ZmpIiwgInR5cGVfbm90aWZ5IjogIiIsICJwYXJhbSI6ICJpbnN1cmFuY2VfcGljIn1d'));
		$datas=userlist::model()->GetRegistrationDatas($param,0);
		if(!empty($datas)){
			$data['datas']=$datas;
			set_error($data,0,'获取成功',1);
		}
		set_error($data,0,'报名信息获取失败',1);
    }
    
	/**
	 * 提交赛事报名信息
	 * game_id，game_data_id
	 * 参赛单位participants
	 * 教练coach_name,coach_phone、领队tour_leader_name,tour_leader_phone、队医team_doctor_name,team_doctor_phone
	 * "team_name":"参赛团队名","team_sname":"参赛团队短名","team_logo":"团队logo"
	 * sign_member 队员gfids，使用,隔开
	 */
	public function actionApplyJoinGame(){
        $param=decodeAskParams($_REQUEST,1);
		GameSignList::model()->ApplyJoinGame($param);
    }
	/**
	 * 组队信息修改
	 */
	public function actionEditGameTeamInfo(){
        $param=decodeAskParams($_REQUEST,1);
		GameTeamTable::model()->EditGameTeamInfo($param);
    }
    
	/**
	 * 邀请好友 组队
	 * $param['visit_gfid','team_id','sign_member'];
	 */
	public function actionInviteFriendJoinGame(){
        $param=decodeAskParams($_REQUEST,1);
		GameSignList::model()->InviteFriendJoinGame($param);
    }
    
	/**
	 * 回复赛事组队邀请，并提交赛事报名信息
	 */
	public function actionUpdateRegistrationDatas(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"操作失败");
		checkArray($param,'visit_gfid,registration_phone,recent_photo',1);
		$tadd=userlist::model()->UpdateRegistrationDatas($param);
		if($tadd<0){
			set_error($data,1,'提交报名信息失败',1);
		}
		GameSignList::model()->TeamMemberReply($param);
    }
    
    
    
}

?>