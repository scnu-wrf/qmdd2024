
<?php
/**
 * 说说-前端接口
 * @author xiyan
 */
class Io_gfimController extends BaseController {
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
    /**
     * 查找会员
     */
	public function actionSearch_user(){
        $param=decodeAskParams($_REQUEST,1);
		userlist::model()->searchUser($param);
    }
    /**
     * 获取会员资料
     */
	public function actionGet_user_info(){
        $param=decodeAskParams($_REQUEST,1);
		GfGroupInfo::model()->getFriendInfo($param);
    }
    /**
     * 获取好友列表
     */
	public function actionGet_friends(){
        $param=decodeAskParams($_REQUEST,1);
		GfGroupInfo::model()->getAllFriend($param);
    }

    /**
     * 申请添加好友
     */
	public function actionAdd_friend_apply(){
        $param=decodeAskParams($_REQUEST,1);
		GfFriendApply::model()->addRecord($param);
    }
    /**
     * 回复添加好友申请
     */
	public function actionReply_add_friend(){
        $param=decodeAskParams($_REQUEST,1);
		GfFriendApply::model()->Reply($param);
    }
    /**
     * 新朋友记录（待操作的申请记录（用户申请加好友／其他会员向该用户申请加好友））
     */
	public function actionGet_add_friend(){
        $param=decodeAskParams($_REQUEST,1);
		GfFriendApply::model()->getAddFriend($param);
    }
    
    /**
     * 删除好友 （将申请者好友列表中移除该会员，对方好友列表不变，发送7-删除好友）
     */
	public function actionDel_friend(){
        $param=decodeAskParams($_REQUEST,1);
		GfGroupInfo::model()->delFriend($param);
	}
    /**
     * 设置好友备注名
     */
	public function actionSet_friend_memo(){
        $param=decodeAskParams($_REQUEST,1);
		GfGroupInfo::model()->setFriendMemo($param);
    }
    /**
     * 设置好友查看动动圈权限
     */
	public function actionSet_friend_mood(){
        $param=decodeAskParams($_REQUEST,1);
		GfGroupInfo::model()->setFriendMood($param);
    }
    
    /**
     * 创建群
     */
	public function actionCreate_crowd(){
        $param=decodeAskParams($_REQUEST,1);
		GfCrowdBase::model()->createCrowd($param);
    }
    /**
     * 群列表
     */
	public function actionGet_crowd(){
        $param=decodeAskParams($_REQUEST,1);
		GfCrowdBase::model()->getCrowd($param);
    }
    /**
     * 群资料
     */
	public function actionGet_crowd_info(){
        $param=decodeAskParams($_REQUEST,1);
		GfCrowdBase::model()->getCrowdInfo($param);
    }
    /**
     * 群主修改群名称、群头像、群背景
     */
	public function actionEdit_crowd(){
        $param=decodeAskParams($_REQUEST,1);
		GfCrowdBase::model()->editCrowd($param);
    }
    /**
     * 群成员昵称设置
     */
	public function actionSet_crowd_member_name(){
        $param=decodeAskParams($_REQUEST,1);
		GfCrowdMember::model()->setCrowdMemberName($param);
    }
    /**
     * 群成员
     */
	public function actionCrowd_member(){
        $param=decodeAskParams($_REQUEST,1);
		GfCrowdMember::model()->getCrowdMember($param);
    }
    /**
     * 查找群
     */
	public function actionSearch_crowd(){
        $param=decodeAskParams($_REQUEST,1);
		GfCrowdBase::model()->searchCrowd($param);
    }
    
    /**
     * 加群申请
     */
	public function actionApply_join_crowd(){
        $param=decodeAskParams($_REQUEST,1);
		GfCrowdApplyJoin::model()->applyJoinCrowd($param);
    }
    /**
     * 群主回复加群申请
     * reply 1-同意，2-拒绝
     */
	public function actionAudit_join_crowd_apply(){
        $param=decodeAskParams($_REQUEST,1);
		GfCrowdApplyJoin::model()->replyJoinCrowd($param);
    }
    /**
     * 群主／群成员邀请会员加群
     */
	public function actionInvite_join_crowd(){
        $param=decodeAskParams($_REQUEST,1);
		GfCrowdInviteMember::model()->inviteCrowdMember($param);
    }
    /**
     * 受邀者回复加群邀请
     * reply 1-同意，2-拒绝
     */
	public function actionReply_join_crowd_invite(){
        $param=decodeAskParams($_REQUEST,1);
		GfCrowdInviteMember::model()->replyCrowdInvite($param);
    }
    /**
     * 群主审核群成员邀请会员加群
     * reply 1-同意，2-拒绝
     */
	public function actionAudit_join_crowd_invite(){
        $param=decodeAskParams($_REQUEST,1);
		GfCrowdInviteMember::model()->CrowdCreaterAudit($param);
    }
    /**
     * 群主删除群成员
     */
	public function actionDel_crowd_member(){
        $param=decodeAskParams($_REQUEST,1);
		GfCrowdMember::model()->deleteCrowdMember($param);
    }
    /**
     * 群主解散群
     */
	public function actionCreater_del_crowd(){
        $param=decodeAskParams($_REQUEST,1);
		GfCrowdBase::model()->deleteCrowd($param);
    }
    /**
     * 群成员退出群
     */
	public function actionMember_del_crowd(){
        $param=decodeAskParams($_REQUEST,1);
		GfCrowdMember::model()->MemberDeleteCrowd($param);
    }
    
    /**
     * 1.说说首页
     */
    public function actionGet_memu_setting(){
        $param = decodeAskParams($_REQUEST, 0);
        $gfid = $param['visit_gfid'];
		$cr = new CDbCriteria;
        $cr->condition='function_area_id=2';
        $cr->select="function_id as id,if(IFNULL(dispay_title,'')='',function_name,dispay_title) as name,IFNULL(dispay_icon,'') as img,IFNULL(dispay_click_icon,'') as click_img";
        $cr->order="dispay_num desc";
        $data0 = QmddFuntionData::model()->findAll($cr,array(),false);
        $cr->condition='function_area_id=48';
        $data1 = QmddFuntionData::model()->findAll($cr,array(),false);
        $cr->condition='function_area_id=49';
        $data2 = QmddFuntionData::model()->findAll($cr,array(),false);
//        $noReadRecord = JlbMoodCommentReadRecord::model()->findAll('read_gfid='.$gfid.' AND is_read=0');
//        $noReadNum = count($noReadRecord);
        $gcount = Yii::app()->db->createCommand('select count(*) as countq from jlb_mood_comment_read_record where read_gfid='.$gfid.' AND is_read=0')->queryAll();
		$noReadNum = !empty($gcount)&&$gcount[0]['countq']>0?$gcount[0]['countq']:0;
        $d = array('main_menu'=>$data0,'top_menu'=> $data1,'service_menu'=> $data2,'service_menu_name'=>'服务功能','recent_chat_name'=>'最近聊天','recent_chat_none'=>'暂无聊天记录','ddq_noread_num'=>$noReadNum);
        $rs = array('error'=>'0','msg'=>'获取成功','datas'=>$d);
		set_error($rs,0,'获取成功',1);
    }

    /**
     * 接口：读完未读点赞/评论/回复后将其标记为已读。
     *  gfid 阅读者的gfid
     *  typeIdArr 要标记为已读的点赞/评论/回复的ID组
     */
    public function actionSetTypeRead(){
        $param = decodeAskParams($_REQUEST, 0);
        $gfid  = $param['visit_gfid'];
        $typeIdArr = $param['typeIdArr'];
        foreach ($typeIdArr as $typeId){
            JlbMoodCommentReadRecord::model()->updateAll(array('is_read'=>1),'read_gfid='.$gfid.' AND type_id='.$typeId);
        }
    }

   	/**
   	 * 2.获取离线消息
   	 *
   	 */
    public function actionGet_offline_message_count3(){
        $param = decodeAskParams($_REQUEST, 0);
        $gfid  = $param['visit_gfid'];
//        $is_sync = $param['is_sync'];
        $w0 = 'S_TIME >= now()-interval 3 day';

        // 单聊
//        $w1 = '(SELECT ID FROM gf_group_1 WHERE GF_ID='.$gfid.' AND GF_GROUP_NAME !="黑名单")'; // 好友分组
//        $friends = GfGroupInfo::model()->findAll('GP_ID IN'.$w1);
//        $fri_ids = array_column($friends,'GF_ID'); //全部好友ID
//        foreach ($fri_ids as $fri_id){
//            $w2 = 'R_GFID='.$gfid.' AND S_GFID='.$fri_id;
//            $maxMessage = GfMessageOffline::model()->findAll($w2);
//            if(!empty($maxMessage)){
//                $maxMessageIds = array_column($maxMessage,'MAX_MESSAGE_ID');
//                foreach ($maxMessageIds as $maxMessageId){
//                    $w3 = 'ID='.$maxMessageId.' AND if(S_GF_ID='.$gfid.',IS_S_DELETE,IS_R_DELETE)=0';
//                    $criteria = new CDbCriteria;
//                    $criteria->condition=$w3;
//                    $criteria->select="*,IFNULL(recall_time,'') recall_time";
//                    $message = GfMessage::model()->findAll($criteria);
//                    if(!empty($message)){
//                        $s0 = 'S_GF_ID:S_GFID,S_GF_ACCOUNT:S_GF_ACCOUNT,R_GF_ID:R_GFID,R_GF_ACCOUNT:R_GF_ACCOUNT,S_TIME:S_TIME,'.
//                            'M_MESSAGE:M_MESSAGE,M_TYPE:M_TYPE,F_TYPE:F_TYPE,S_LEN:S_LEN,S_G:S_G,recall_time:recall';
//                        $d0 = toIoArray($message,$s0);
//                        foreach ($d0 as $value){
//                            $a[$value['S_GFID']] = $value;
//                        }
//                    }
//                }
//                $tmp = GfMessage::model()->findAll('R_GF_ID='.$gfid.' AND S_GF_ID='.$fri_id.' AND IS_READ=1 AND '.$w0);
//                $syncCount = count($tmp); // 近3天需同步消息数
//                foreach ($maxMessage as $value){
//                    $a[$value['S_GFID']]['MAX_MESSAGE_ID'] = $value['MAX_MESSAGE_ID'];
//                    if ($is_sync == '是'){// 近3天已读和所有未读
//                        $a[$value['S_GFID']]['COUNT'] = $value['COUNT'] + $syncCount;
//                    }else {// 所有未读
//                        $a[$value['S_GFID']]['COUNT'] = $value['COUNT'];
//                    }
//                }
//            }
//        }
//        $d0 = array();
//        if(isset($a)){
//            $d0 = array_values($a);
//        }
			$criteria = new CDbCriteria;
            $criteria->condition='s_g=0 and S_GF_ID>0 and S_TIME >= now()-interval 30 day and ((R_GF_ID='.$gfid.' and is_read=0 and IS_R_DELETE=0) or (S_GF_ID='.$gfid.' and IS_S_DELETE=0 and M_TYPE not in(348,349,350,351,352,353,354,1000)  and S_TIME >= (now()-interval 3 day )))';
            $criteria->select="max(id) as MAX_MESSAGE_ID,S_GF_ID as S_GFID,R_GF_ID as R_GFID,S_G,count(id) as COUNT";
            $criteria->group='S_GF_ID,R_GF_ID';
            $d0 = GfMessage::model()->findAll($criteria,array(),false);

        // 群聊
        $criteria->condition='GF_ID='.$gfid;
        $criteria->select="max(MEMBER_READED_LAST_ID) as MEMBER_READED_LAST_ID,CROWD_ID";
        $criteria->group='CROWD_ID';
        $d1 = GfCrowdMember::model()->findAll($criteria,array(),false);

        // 客服咨询
//        $w4 = 'm_type!=1000 and s_gfid='.$gfid.' AND (is_read=648 OR '.$w0.') AND is_delete=0';
//        $customerService =  GfCustomerServiceMessage::model()->findAll($w4);
//        $s2 = 'id:ID,s_gfid:S_GFID,s_gf_account:S_GFACCOUNT,s_time:S_TIME,m_message:M_MESSAGE,m_type:M_TYPE,'.
//            'f_type:F_TYPE,s_len:S_LEN,is_read:IS_READ,s_manber:isCustomerSend,r_adminid:admin_id,'.
//            'r_adminaccount:admin_gfaccount,message_id:cs_id';
//        $d2 = toIoArray($customerService,$s2);
//        foreach ($d2 as $key=>$value){
//            $d2[$key]['s_g'] = 5;
//        }
			$cr = new CDbCriteria;
		$cr->select="t.ID,if(t.s_manber=1,sl.club_id,t.s_gfid) as S_GF_ID,if(t.s_manber=1,sl.r_adminaccount,t.s_gf_account) as S_GF_ACCOUNT,if(t.s_manber=1,t.s_gfid,sl.club_id) as R_GF_ID,if(t.s_manber=1,t.s_gf_account,sl.r_adminaccount) as R_GF_ACCOUNT,t.S_TIME,t.M_MESSAGE,t.M_TYPE,t.F_TYPE,t.S_LEN,'5' as S_G,t.IS_READ,if(t.s_manber=0,1,0) as isCustomerSend,sl.r_adminid as admin_id,sl.id as cs_id";
		$cr->condition="t.M_TYPE!=1000 and t.s_gfid=".$gfid.($param['device_type']<>7?" and ((t.s_manber in(1,2) and t.is_read=648) or t.".$w0.") AND is_delete=0":"");
		$cr->join=" join gf_customer_service_list sl on sl.id=t.message_id ";
        $d2 =  GfCustomerServiceMessage::model()->findAll($cr,array(),false);
        $admin_map=array();
        foreach($d2 as $k=>$v){
        	if(empty($v['admin_id'])){
        		continue;
        	}
        	if(empty($admin_map[$v['admin_id']])){
        		$qa=QmddAdministrators::model()->find('id='.$v['admin_id']);
        		$admin_map[$v['admin_id']]=$qa;
        	}else{
        		$qa=$admin_map[$v['admin_id']];
        	}
        	$d2[$k]['admin_gfaccount']=empty($qa)||empty($qa->admin_gfaccount)?'':$qa->admin_gfaccount;
        	$d2[$k]['admin_gfnick']=empty($qa)||empty($qa->admin_gfnick)?'':$qa->admin_gfnick;
        }
        
        // 直播提醒
        $unReadMsgIds = '(SELECT msg_id FROM video_live_realtime_interaction_message_readed WHERE read_gfid='.$gfid.
            ' AND ISNULL(read_time))';
        $collectIds = '(SELECT news_id FROM personal_collection WHERE news_type=863 and if_remind=870 and gf_user_type=210 and gfid='.$gfid.')';
        $unReadMsgs = VideoLiveMessage::model()->findAll('id not IN '.$unReadMsgIds.' and live_program_id in '.$collectIds.' AND m_type=315 and s_time>now()-interval 30 minute'); 
        if (!empty($unReadMsgs)){
            $s3 = 'id:id,s_gfid:s_gfid,s_gfaccount:s_gfaccount,r_gfid:r_gfid,r_gfaccount:r_gfaccount,s_time:s_time,'.
                'm_message:m_message,m_type:m_type';
        }
        $d3 = array();
        if(isset($s3)){
            $d3 = toIoArray($unReadMsgs,$s3);
            foreach ($d3 as $key=>$value){
                $d3[$key]['s_g'] = 20;
            }
        }

        $d = array('single'=>$d0,'crowd'=>$d1,'customer_service'=>$d2,'live_notify'=>$d3);
        $rs = array('error'=>'0','msg'=>'获取成功','datas'=>$d);
        set_error($rs,0,'获取成功',1);
    }

    /**
     * 3.获取单聊IM离线未读消息
     * 通过gfid及消息最后ID获取单聊IM离线未读消息
     */
    public function actionGet_offline_messages_by_count(){
        $param=decodeAskParams($_REQUEST,1);
        $gfid=$param['visit_gfid'];
    	$s_gfid=$param['s_gfid'];
    	$r_gfid=$param['r_gfid'];
    	$message_id=$param['message_id'];
    	$fetch_count=$param['fetch_count'];
    	
        $w1 = " S_G=0 and S_TIME >= now()-interval 30 day and ((R_GF_ID=".$r_gfid." and S_GF_ID=".$s_gfid.") or (R_GF_ID=".$s_gfid." and S_GF_ID=".$r_gfid.")) and ((R_GF_ID=".$gfid." and is_read=0 and IS_R_DELETE=0) or (S_GF_ID=".$gfid." and IS_S_DELETE=0 and M_TYPE not in(348,349,350,351,352,353,354)  and S_TIME >= now()-interval 3 day ))";
        if ($message_id != ''){
            $w1 .= ' and ID<='.$message_id;
        }
        $w1 .=' order by id desc limit '.$fetch_count;
		$criteria = new CDbCriteria;
		$criteria->condition=$w1;
		$criteria->select='ID,S_GF_ID,R_GF_ID,S_TIME,M_MESSAGE,M_TYPE,F_TYPE,'.
        'S_LEN,S_G,R_GF_ACCOUNT,S_GF_ACCOUNT,if(isnull(recall_time),0,1) recall';
        $data0 = GfMessage::model()->findAll($criteria,array(),false);
        $rs = array('error'=>'0','msg'=>'获取离线消息成功','datas'=>$data0,'stime'=>time());
		set_error($rs,0,'获取离线消息成功',1);
    }

    // 4.群聊离线消息
    public function actionGet_offline_msg_by_crowd_id(){
        $param=decodeAskParams($_REQUEST,1);
        $CROWD_ID=$param['CROWD_ID'];
        $message_id=$param['message_id'];
        $gfid=$param['visit_gfid'];
        $page=$param['page'];
        $per_page=$param['per_page'];
        $w1 = "ifnull(recall_time,'')='' and S_G=1 and S_TIME >= now()-interval 30 day".' and R_GF_ID='.$CROWD_ID;
        if ($message_id != ''){
            $w1 .= ' and ID>'.$message_id;
        }
        $w1 = $w1.' limit '.(($page-1)*$per_page).','.$per_page;
        $unreadCrowdMsgs = GfMessage::model()->findAll($w1);
        $count = count($unreadCrowdMsgs);
        $s0 = 'ID:ID,S_GF_ID:S_GF_ID,R_GF_ID:R_GF_ID,S_TIME:S_TIME,M_MESSAGE:M_MESSAGE,M_TYPE:M_TYPE,'.
            'F_TYPE:F_TYPE,S_LEN:S_LEN,R_GF_ACCOUNT:R_GF_ACCOUNT,S_GF_ACCOUNT:S_GF_ACCOUNT';
        $data = toIoArray($unreadCrowdMsgs,$s0);
        $rs = array('error'=>'0','msg'=>'获取群离线消息成功','datas'=>$data,'total_count'=>$count,'stime'=>time());
        // 群聊消息变单聊形式，用于处理标识用户清空自己群消息
        $receiveGfAccount = userlist::model()->find('GF_ID='.$gfid)->attributes['GF_ACCOUNT'];
        foreach ($unreadCrowdMsgs as $unreadCrowdMsg){
            $sendMsgGfid = $unreadCrowdMsg->attributes['S_GF_ID'];
            $msg = new GfMessage();
            $msg->S_GF_ID = $sendMsgGfid;
            $msg->S_GF_ACCOUNT = $unreadCrowdMsg->attributes['S_GF_ACCOUNT'];
            $msg->R_GF_ID = $gfid;
            $msg->R_GF_ACCOUNT = $receiveGfAccount;
            $msg->S_TIME = $unreadCrowdMsg->attributes['S_TIME'];
            $msg->M_MESSAGE = $unreadCrowdMsg->attributes['M_MESSAGE'];
            $msg->M_TYPE = $unreadCrowdMsg->attributes['M_TYPE'];
            $msg->F_TYPE = $unreadCrowdMsg->attributes['F_TYPE'];
            $msg->S_LEN = $unreadCrowdMsg->attributes['S_LEN'];
            $msg->S_G = 10;
            $msg->C_GF_ID = $unreadCrowdMsg->attributes['R_GF_ID'];
            $msg->IS_READ = 1;
            $msg->IS_S_DELETE = 0;
            $msg->IS_R_DELETE = 0;
            $msg->clientType = $unreadCrowdMsg->attributes['clientType'];
            $msg->from_msg_id = $unreadCrowdMsg->attributes['from_msg_id'];
            $msg->recall_time = $unreadCrowdMsg->attributes['recall_time'];
            $msg->insert();
        }
        set_error($rs,0,'获取群离线消息成功',1);
    }

    // 5.标记消息已接收
    public function actionReaded_single_message(){
        $param=decodeAskParams($_REQUEST,1);
        $msg_id=$param['msg_id'];
        $S_G=$param['S_G'];
        $target_gfid=$param['target_gfid'];
        $rec_gfid=$param['rec_gfid'];
        if ($S_G == 0){
            GfMessage::model()->updateAll(array('IS_READ' => 1),'ID='.$msg_id);
        }
        if ($S_G == 1){
            GfCrowdMember::model()->updateAll(array('MEMBER_READED_LAST_ID' => $msg_id),'CROWD_ID='.$target_gfid.' and GF_ID='.$rec_gfid.' and MEMBER_READED_LAST_ID<'.$msg_id);
        }
        if ($S_G == 5){
            GfCustomerServiceMessage::model()->updateAll(array('is_read' => 649),'message_id='.$msg_id);
        }
        $rs = array('error'=>'0','msg'=>'标记成功');
        set_error($rs,0,'标记成功',1);
    }

    // 7.标识：删除即时消息
    public function actionDelete_im_message(){
        $param=decodeAskParams($_REQUEST,1);
        $gfid=$param['visit_gfid'];
        $rs = array('error'=>'0','msg'=>'删除消息成功');
        if(empty($param['msg_id'])){
        	set_error($rs,0,'删除消息成功',1);
        }
        $msg_id=$param['msg_id'];
        GfMessage::model()->updateAll(array('IS_S_DELETE' => 1),'ID='.$msg_id.' AND S_GF_ID='.$gfid);
        GfMessage::model()->updateAll(array('IS_R_DELETE' => 1),'ID='.$msg_id.' AND R_GF_ID='.$gfid.' AND IS_READ=1');
        set_error($rs,0,'删除消息成功',1);
    }

    // 8.标识：清空即时消息
    public function actionClear_im_message(){
        $param=decodeAskParams($_REQUEST,1);
        $id=$param['visit_gfid'];
        $s_g=$param['s_g'];
        $gfid=$param['gfid'];
        if ($s_g == 0 || $s_g == '0'){
            $w0 = 'S_GF_ID='.$id.' AND R_GF_ID='.$gfid.' AND s_g=0 AND IS_READ=1';
            GfMessage::model()->updateAll(array('IS_S_DELETE' => 1),$w0);
            $w1 = 'S_GF_ID='.$gfid.' AND R_GF_ID='.$id.' AND s_g=0 AND IS_READ=1';
            GfMessage::model()->updateAll(array('IS_R_DELETE' => 1),$w1);
        }elseif ($s_g == 1 || $s_g == '1'){
            $w2 = 'R_GF_ID='.$id.' AND C_GF_ID='.$gfid.' AND S_G=10 AND IS_R_DELETE=0';
            $asReceiver = GfMessage::model()->findAll($w2);
            if (!empty($asReceiver)){
                GfMessage::model()->updateAll(array('IS_R_DELETE'=>1),$w2);
            }
            $w3 = 'S_GF_ID='.$id.' AND C_GF_ID='.$gfid.' AND S_G=10 AND IS_S_DELETE=0';
            $asSender = GfMessage::model()->findAll($w3);
            if (!empty($asSender)){
                GfMessage::model()->updateAll(array('IS_S_DELETE'=>1,'IS_R_DELETE'=>1),$w3);
            }
        }elseif ($s_g == 5 || $s_g == '5'){
            $w4 = 's_gfid='.$id.' AND r_adminid='.$gfid.' AND is_read=649';
            GfCustomerServiceMessage::model()->updateAll(array('is_delete' => 1),$w4);
        }
        $rs = array('error'=>'0','msg'=>'清空消息成功');
        set_error($rs,0,'清空消息成功',1);
    }
	
    // 9.发表动动圈消息
    public function actionPublish_ddq_message(){
        $param=decodeAskParams($_REQUEST,1);
        $gfid=$param['visit_gfid'];
        $content=$param['content'];
        $address=$param['address'];
        $gfwb=$param['gfwb'];
        $pubType=$param['pubType'];
        $web_link=$param['web_link'];
        $media_url=$param['media_url'];
        $if_remind=$param['if_remind'];
        $remind_friends=$param['remind_friends'];
        $is_show=$param['is_show'];
        $show_friends=$param['show_friends'];
        $publisherInfo = userlist::model()->getUserInfo($gfid);
        $mood = new JlbMoods();
        $mood->GF_ID = $gfid;
        $mood->content = $content;
        $mood->address = $address;
        $mood->gfwb = $gfwb;
        $mood->pubType = $pubType;
        $mood->web_link = $web_link;
        $mood->media_url = $media_url;
        $mood->if_remind = $if_remind;
        $mood->remind_friends = $remind_friends;
        $mood->is_show = $is_show;
        $mood->show_friends = $show_friends;
        $mood->GF_NAME = $publisherInfo['gf_name'];
        $mood->gf_icon = $publisherInfo['gf_icon_dir'];
        $mood->ttime = get_date();
        $result = $mood->save();
        $data['xq_id']=$mood->xq_id;
        $data['GF_NAME']=$mood->GF_NAME;
        $data['gf_icon']=$mood->gf_icon;
        $data['ttime']=$mood->ttime;
        $data['is_show']=$mood->is_show;
        $data['show_friends']=$mood->show_friends;
        if ($result){
            $noticeMsg = array('xq_id'=>$data['xq_id'],'f_gfid'=>$gfid,'gf_name'=>$data['GF_NAME'],
                    'gf_icon'=>$data['gf_icon'],'ttime'=>$data['ttime'],'address'=>$address,
                    'content'=>$content,'web_link'=>$web_link,"pubType"=>$pubType,
                    "media_url"=>$media_url,"if_remind"=>$if_remind,"remind_gfid"=>$remind_friends);
            // 根据可视范围来判断给谁推送通知
            if($data['is_show'] == 0 || $data['is_show'] == 1 || $data['is_show'] == '0'){ //全部好友
                $w0 = '(SELECT ID FROM gf_group_1 WHERE GF_ID='.$gfid.' AND GF_GROUP_NAME !="黑名单")'; // 好友分组
                $friends = GfGroupInfo::model()->findAll('is_look=0 and GP_ID IN'.$w0);
                $sfrienfs=GfGroupInfo::model()->findAll('is_show=0 and GF_ID ='.$gfid);
                $show_map=array();
                foreach($sfrienfs as $k=>$f){
                	$show_map[$f->gp_gfid]=1;
                }
//                $fri_ids = array_column($friends,'GF_ID'); //全部好友ID
                foreach ($friends as $k=>$fri_id){
                	if(empty($show_map[$fri_id->GF_ID])){
                		continue;
                	}
                    $friendInfo = userlist::model()->getUserInfo($fri_id->GF_ID);
                    if (!empty($friendInfo)){
                        GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>$publisherInfo['gf_id'],'S_GF_ACCOUNT'=>$publisherInfo['gf_account'],
                            'R_GF_ID'=>$friendInfo['gf_id'],'R_GF_ACCOUNT'=>$friendInfo['gf_account'],
                            'M_MESSAGE'=>base64_encode(json_encode($noticeMsg,320)),'M_TYPE'=>348,'S_G'=>0));
                    }
                }
            }elseif ($data['is_show'] == 2 || $data['is_show'] == '2'){
                // 设为私密时不需要推送消息
            }elseif ($data['is_show'] == 3 || $data['is_show'] == '3'){ //部分好友
                $showFriends = explode(',',$data['show_friends']);
                foreach ($showFriends as $showFriend){
                    $showFriendInfo = userlist::model()->getUserInfo($showFriend);
                    if(!empty($showFriendInfo)){
                        GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>$publisherInfo['gf_id'],'S_GF_ACCOUNT'=>$publisherInfo['gf_account'],
                            'R_GF_ID'=>$showFriendInfo['gf_id'],'R_GF_ACCOUNT'=>$showFriendInfo['gf_account'],
                            'M_MESSAGE'=>base64_encode(json_encode($noticeMsg,320)),'M_TYPE'=>348,'S_G'=>0));
                    }
                }
            }
        }
        $rs = array('error'=>'0','msg'=>'发表成功');
        set_error($rs,0,'发表成功',1);
    }
		
	// 10.动动圈分组设置
    public function actionSetGroupAuthority(){
		$param=decodeAskParams($_REQUEST,1);
        $gfid=$param['visit_gfid'];
        $group_name=$param['group_name'];
        $gfids=$param['gfids'];
        if($param['group_id']){
			$group_id = $param['group_id'];
        }else{
            $group_id = 0;
        }
        $group_arr = GfGroupAuthority::model()->find('id='.$group_id);
        if(!empty($group_arr)){ // 修改分组
            GfGroupAuthority::model()->updateAll(array('group_name' => $group_name,'group_gfid' => $gfids),'gfid='.$gfid);
        }else{ // 新增分组
            $newGroup = new GfGroupAuthority();
            $newGroup->gfid =$gfid;
            $newGroup->group_name =$group_name;
            $newGroup->group_gfid =$gfids;
            $newGroup->save();
            $group_id = $newGroup->attributes['id'];
        }
        $rs = array('error'=>'0','msg'=>'设置成功','group_id'=>$group_id);
        set_error($rs,0,'设置成功',1);
    }

    // 11.获取动动圈分组设置
    public function actionGroupAuthority(){
        $param=decodeAskParams($_REQUEST,1);
        $gfid=$param['visit_gfid'];
        $tmp0 = GfGroupAuthority::model()->findAll('gfid='.$gfid);
        $s0 = 'id:group_id,group_name:group_name,group_gfid:group_gfid';
        $d = toIoArray($tmp0,$s0);
        $rs = array('datas'=>$d);
		set_error($rs,0,'获取成功',1);
    }

    // 12.动动圈信息拉取
    public function actionGet_ddq_message() {
        $param = decodeAskParams($_REQUEST,1);
        $gfid = $param['visit_gfid'];
        $last_id=empty($param['id'])?0:$param['id'];
        $direction = empty($param['direction'])?0:$param['direction'];
        $per_page = empty($param['per_page'])?10:$param['per_page'];
//        $w0 = '(SELECT ID FROM gf_group_1 WHERE GF_ID='.$gfid.' AND GF_GROUP_NAME !="黑名单")';
//        $w1 = '(SELECT GF_ID FROM gf_group_info_1 WHERE GP_ID IN '.$w0.')';
//        $where='(GF_ID=' . $gfid . ' OR GF_ID IN '.$w1.')';
        $f_gfids=Yii::app()->db->createCommand("select group_concat(GF_ID) as gfids from gf_group_info_1 where ifnull(encryption,'')<>'' and is_show=0 and gp_gfid=".$gfid)->queryAll();
        $l_gfids=Yii::app()->db->createCommand("select group_concat(gp_gfid) as gfids from gf_group_info_1 where ifnull(encryption,'')<>'' and is_look=0 and gf_id=".$gfid)->queryAll();
        $f_gfids=empty($f_gfids)||count($f_gfids)==0||empty($f_gfids[0]['gfids'])?$gfid:($gfid.','.$f_gfids[0]['gfids']);
        $l_gfids=empty($l_gfids)||count($l_gfids)==0||empty($l_gfids[0]['gfids'])?$gfid:($gfid.','.$l_gfids[0]['gfids']);
		$where='(GF_ID IN ('.$f_gfids.') and GF_ID IN ('.$l_gfids.'))';
        $get_count = Yii::app()->db->createCommand('select count(xq_id) as c from jlb_moods where '.$where)->queryAll();
        $total=count($get_count)>0?$get_count[0]['c']:0;
        if (empty($last_id)&&($direction == 0 || $direction == '0')) {
            $w2 = $where.' order by ttime DESC limit 0,'.$per_page;
        }else{
            $w2 = $where.' and xq_id<'.$last_id.' order by ttime desc limit 0,'.$per_page;
        }
        $tmp = JlbMoods::model()->findAll($w2);
        $s = 'xq_id:xq_id,GF_ID:f_gfid,ttime:ttime,address:address,content:content,web_link:web_link,pubType:pubType,'.
            'media_url:media_url,gf_icon:gf_icon,GF_NAME:GF_NAME,data_position:data_position,data_comment:data_comment,remind_friends:remind_friends';
        $d0 = toIoArray($tmp,$s);
        $img_url=getShowUrl('file_path_url');
        foreach ($d0 as $k=>$value){
        	$remind_friends="|".$value['remind_friends']."|";
        	$d0[$k]['if_remind']=indexof($remind_friends,'|'.$gfid.'|',0)>=0?1:2;
        	$d0[$k]['media_url']=CommonTool::model()->addto_url_dir($img_url,$value['media_url'],'|',',');
            $xq_id = $value['xq_id'];
            $cr = new CDbCriteria;
        	$cr->condition='type=1 and xq_id='.$xq_id.' and (like_id IN ('.$f_gfids.') and like_id IN ('.$l_gfids.'))';
        	$cr->select='like_id as position_gfid,1 as mType,ttime as uDate,type_gf_name as gf_name,type_gf_icon as gf_icon';
        	$cr->order='ID';
        	$data_position=JlbMoodComment::model()->findAll($cr,array(),false);
        	$d0[$k]['if_praise']=0;
        	if(!empty($data_position)){
        		foreach($data_position as $pk=>$pv){
	        		if($pv['position_gfid']==$gfid){
	        			$d0[$k]['if_praise']=1;
	        			break;
	        		}
	        	}
        	}
        	$d0[$k]['data_position']=$data_position;
        	$cr->condition='type in(2,3) and is_content=0 and xq_id='.$xq_id.' and (C_GFID IN ('.$f_gfids.') and C_GFID IN ('.$l_gfids.'))';
        	$cr->select='id as comment_id,C_GFID as comment_gfid,parent_id as reply_id,content,ttime as uDate,type_gf_name as gf_name,type_gf_icon as gf_icon';
        	$cr->order='ID';
        	$data_comment=JlbMoodComment::model()->findAll($cr,array(),false);
        	$d0[$k]['data_comment']=$data_comment;
//            $a[$value['xq_id']] = $value;
//            $xq_comment=JlbMoodComment::model()->find('xq_id='.$xq_id.' AND like_id='.$gfid);
//            $is_like = empty($xq_comment)||$xq_comment->is_like==0?0:1;
//            if ($is_like == "0"){
//                $a[$value['xq_id']]['if_praise'] = 1;
//            }else{
//                $a[$value['xq_id']]['if_praise'] = 0;
//            }
        }
//        $d = array();
//        if(isset($a)){
//            $d = array_values($a);
//        }
        $rs = array('error' => '0', 'datas'=>$d0, 'total' => $total, 'msg' => '获取成功', 'stime' => time());
        if ($direction == 0 || $direction == '0') {
        	$user_info=userlist::model()->find('GF_ID='.$gfid);
        	if(!empty($user_info)){
        		$rs['mood_pic']=CommonTool::model()->url_path_name($img_url,$user_info->mood_bigpic_url);
        	}
        }
        set_error($rs,0,'获取成功',1);
    }

    // 13.会员已发表动动圈列表
    public function actionPublishedList() {
        $param = decodeAskParams($_REQUEST,1);
        $gfid = $param['visit_gfid'];
        $vgfid=$param['gfid'];
        
        $page = $param['page'];
        $per_page = $param['per_page'];
        if($vgfid!=$gfid){
        	$cr = new CDbCriteria;
	        $cr->condition="ifnull(encryption,'')<>'' and GF_ID=".$vgfid." and gp_gfid=".$gfid;
	        $cr->select="is_look";
	        $friend=GfGroupInfo::model()->find($cr);
	        $cr->condition="ifnull(encryption,'')<>'' and GF_ID=".$gfid." and gp_gfid=".$vgfid;
	        $cr->select="is_show";
			$gfriend=GfGroupInfo::model()->find($cr);
			$rs=get_error(1,'');
			if(empty($friend)||$friend['is_look']==1||empty($gfriend)||$gfriend['is_show']==1){
				$rs['total']=0;
				$rs['datas']=[];
				set_error($rs,0,'获取成功',1);
			}
        }
        
        $w = 'GF_ID='.$vgfid.' order by ttime desc limit '.(($page-1)*$per_page).','.$per_page;
        $tmp = JlbMoods::model()->findAll($w);
        $s = 'xq_id:xq_id,GF_ID:f_gfid,ttime:ttime,address:address,content:content,web_link:web_link,'.
            'pubType:pubType,media_url:media_url,gf_icon:gf_icon,GF_NAME:GF_NAME';
        $d = toIoArray($tmp,$s);
        $get_count = Yii::app()->db->createCommand('select count(xq_id) as c from jlb_moods where '.$w)->queryAll();
        $total=count($get_count)>0?$get_count[0]['c']:0;
        $rs = array('error' => '0','datas'=>$d, 'total' => $total, 'msg' => '获取成功', 'stime' => time());
        set_error($rs,0,'获取成功',1);
    }

    // 14.会员动动圈信息详情
    public function actionGetMoodsDetail() {
        $param = decodeAskParams($_REQUEST, 0);
//        $v_gfid = $param['v_gfid'];
        $xq_id = $param['xq_id'];
        $gfid = $param['visit_gfid'];
        $w = 'xq_id = '.$xq_id;
        $tmp = JlbMoods::model()->findAll($w);
//        $like_count = array_column($tmp,'like_count');
//        foreach ($like_count as $value){
//            $if_praise = (int)$value;
//        }
        $s = 'xq_id:xq_id,GF_ID:f_gfid,ttime:ttime,address:address,content:content,web_link:web_link,'.
            'pubType:pubType,media_url:media_url,if_remind:if_remind,gf_icon:gf_icon,GF_NAME:GF_NAME,'.
            'data_position:data_position,data_comment:data_comment,is_show:is_show,remind_friends:remind_friends';
        $data = toIoArray($tmp, $s);
        $rs = get_error(1,'');
        if(count($data)==0){
        	set_error($rs,1,'获取失败',1);
        }
        $f_gfids=Yii::app()->db->createCommand("select group_concat(GF_ID) as gfids from gf_group_info_1 where ifnull(encryption,'')<>'' and is_show=0 and gp_gfid=".$gfid)->queryAll();
        $l_gfids=Yii::app()->db->createCommand("select group_concat(gp_gfid) as gfids from gf_group_info_1 where ifnull(encryption,'')<>'' and is_look=0 and gf_id=".$gfid)->queryAll();
        $f_gfids=empty($f_gfids)||count($f_gfids)==0||empty($f_gfids[0]['gfids'])?$gfid:($gfid.','.$f_gfids[0]['gfids']);
        $l_gfids=empty($l_gfids)||count($l_gfids)==0||empty($l_gfids[0]['gfids'])?$gfid:($gfid.','.$l_gfids[0]['gfids']);
            $cr = new CDbCriteria;
        	$cr->condition='type=1 and xq_id='.$xq_id.' and (like_id IN ('.$f_gfids.') and like_id IN ('.$l_gfids.'))';
        	$cr->select='like_id as position_gfid,1 as mType,ttime as uDate,type_gf_name as gf_name,type_gf_icon as gf_icon';
        	$cr->order='ID';
        	$data_position=JlbMoodComment::model()->findAll($cr,array(),false);
        	$if_praise=0;
        	if(!empty($data_position)){
        		foreach($data_position as $pk=>$pv){
	        		if($pv['position_gfid']==$gfid){
	        			$if_praise=1;
	        			break;
	        		}
	        	}
        	}
        	$remind_friends="|".$data[0]['remind_friends']."|";
        	$data[0]['if_remind']=indexof($remind_friends,'|'.$gfid.'|',0)>=0?1:2;
        	
        	$data[0]['data_position']=$data_position;
        	$cr->condition='type in(2,3) and is_content=0 and xq_id='.$xq_id.' and (C_GFID IN ('.$f_gfids.') and C_GFID IN ('.$l_gfids.'))';
        	$cr->select='id as comment_id,C_GFID as comment_gfid,parent_id as reply_id,content,ttime as uDate,type_gf_name as gf_name,type_gf_icon as gf_icon';
        	$cr->order='ID';
        	$data_comment=JlbMoodComment::model()->findAll($cr,array(),false);
        	$data[0]['data_comment']=$data_comment;
//        $xq_comment=JlbMoodComment::model()->find('xq_id='.$xq_id.' AND like_id='.$gfid);
//        $if_praise = empty($xq_comment)||$xq_comment->is_like==0?0:1;
        $rs = array('if_praise' => $if_praise, 'datas'=>$data, 'error'=>'0', 'msg'=>'获取成功', 'stime'=>time());
        set_error($rs,0,'获取成功',1);
    }

    // 15.对动动圈信息发表评论
    public function actionComment(){
        $param = decodeAskParams($_REQUEST, 0);
        $gfid = $param['visit_gfid'];
        $xq_id = $param['xq_id'];
        $content = $param['content'];
        $mood=JlbMoods::model()->find('xq_id='.$xq_id);
        $rs = get_error(1,"");
        if(empty($mood)){
        	set_error($rs,1,"操作失败",1);
        }
        $publisherId = $mood->attributes['GF_ID'];
        $publisherInfo = userlist::model()->getUserInfo($publisherId);
        $commentInfo = userlist::model()->getUserInfo($gfid);
        $friendGroupIds = '(SELECT ID FROM gf_group_1 WHERE GF_ID='.$gfid.' AND GF_GROUP_NAME !="黑名单")';
        $friendIds = '(SELECT GF_ID FROM gf_group_info_1 WHERE GP_ID IN '.$friendGroupIds.')';
        $w0 = 'xq_id='.$xq_id.' AND type=1 AND like_id IN '.$friendIds;
        $w1 = 'xq_id='.$xq_id.' AND type=2 AND C_GFID IN '.$friendIds;
        $w2 = 'belong_xq='.$xq_id.' AND type=3 AND C_GFID IN '.$friendIds;
        $w3 = $w0.' OR '.$w1.' OR '.$w2;
        $others = JlbMoodComment::model()->findAll($w3);

        $comment = new JlbMoodComment();
        $comment->C_GFID = $gfid;
        $comment->xq_id = $xq_id;
        $comment->belong_xq = $xq_id;
        $comment->content = $content;
        $comment->type = 2;
        $comment->ttime = get_date();
        $result = $comment->save();
        $data['GF_NAME']=$mood->GF_NAME;
        $data['gf_icon']=$mood->gf_icon;
        $data['ttime']=$mood->ttime;
        $data['web_link']=$mood->web_link;
        $data['pubType']=$mood->pubType;
        $data['media_url']=$mood->media_url;
        if ($result) {
            $noticeMsg = array('xq_id' => $xq_id, 'f_gfid' => $gfid, 'gf_name' => $data['GF_NAME'],
                'gf_icon' => $data['gf_icon'], 'comment_content' => $content,'ttime' => get_date(),
                'content' => $mood->content,'web_link' => $data['web_link'], "pubType" => $data['pubType'],
                "media_url" => $data['media_url'],'type'=>$comment->type,'type_id'=>$comment->ID);
            if($gfid!=$publisherInfo['gf_id']){//评论者与动动圈发布者相同不通知
            	GfMessage::model()->addMsgAndSend(array('S_GF_ID' => $commentInfo['gf_id'], 'S_GF_ACCOUNT' => $commentInfo['gf_account'],
            'R_GF_ID' => $publisherInfo['gf_id'], 'R_GF_ACCOUNT' => $publisherInfo['gf_account'],
            'M_MESSAGE' => base64_encode(json_encode($noticeMsg, 320)), 'M_TYPE' =>350, 'S_G' => 0));
            }
            
            if (!empty($others)){
                foreach ($others as $other){
                    $otherId = $other->attributes['like_id'];
                    $otherInfo = userlist::model()->getUserInfo($otherId);
                    GfMessage::model()->addMsgAndSend(array('S_GF_ID' => $commentInfo['gf_id'], 'S_GF_ACCOUNT' => $commentInfo['gf_account'],
                        'R_GF_ID' => $otherInfo['gf_id'], 'R_GF_ACCOUNT' => $otherInfo['gf_account'],
                        'M_MESSAGE' => base64_encode(json_encode($noticeMsg, 320)), 'M_TYPE' => 350, 'S_G' => 0));
                }
            }
        }
        set_error($rs,0,'评论成功',1);
    }

    // 16.对评论进行回复
    public function actionReplyComment(){
        $param = decodeAskParams($_REQUEST, 0);
        $m_gfid = $param['m_gfid'];
        $comment_id = $param['comment_id'];
        $content = $param['content'];
        $publisherId = JlbMoodComment::model()->find('ID='.$comment_id)->attributes['P_GFID'];
        $publisherInfo = userlist::model()->getUserInfo($publisherId);
        $commenterId = JlbMoodComment::model()->find('ID='.$comment_id)->attributes['C_GFID'];
        $commenterInfo = userlist::model()->getUserInfo($commenterId);
        $replyInfo = userlist::model()->getUserInfo($m_gfid);

        $moodId = JlbMoodComment::model()->find('ID='.$comment_id)->attributes['xq_id'];
        $reply = new JlbMoodComment();
        $reply->C_GFID = $m_gfid;
        $reply->parent_id = $comment_id;
        $reply->content = $content;
        $reply->type = 3;
        $reply->belong_xq = $moodId;
        $reply->ttime = get_date();
        $result = $reply->save();
        $data['type_gf_name']=$reply->type_gf_name;
        $w0 = 'xq_id='.$moodId;
        $mood = JlbMoods::model()->find($w0);
        $data['GF_ID']=$mood->GF_ID;
        $data['GF_NAME']=$mood->GF_NAME;
        $data['gf_icon']=$mood->gf_icon;
        $data['ttime']=$mood->ttime;
        $data['web_link']=$mood->web_link;
        $data['pubType']=$mood->pubType;
        $data['media_url']=$mood->media_url;
        if ($result) {
            $noticeMsg = array('xq_id' => $moodId, 'f_gfid' => $data['GF_ID'], 'gf_name' => $data['GF_NAME'],
                'gf_icon' => $data['gf_icon'], 'comment_gfid' => $comment_id, 'comment_gf_name' => $data['type_gf_name'],'reply_content'=>$content,
                'ttime' => get_date(), 'content' => $mood->content,'web_link' => $data['web_link'], "pubType" => $data['pubType'],
                "media_url" => $data['media_url'],'type'=>$reply->type,'type_id'=>$reply->ID);
            if($m_gfid!=$publisherInfo['gf_id']){//评论者与动动圈发布者相同不通知
	            GfMessage::model()->addMsgAndSend(array('S_GF_ID' => $replyInfo['gf_id'], 'S_GF_ACCOUNT' => $replyInfo['gf_account'],
	                'R_GF_ID' => $publisherInfo['gf_id'], 'R_GF_ACCOUNT' => $publisherInfo['gf_account'],
	                'M_MESSAGE' => base64_encode(json_encode($noticeMsg, 320)), 'M_TYPE' => 351, 'S_G' => 0));
            }
            GfMessage::model()->addMsgAndSend(array('S_GF_ID' => $replyInfo['gf_id'], 'S_GF_ACCOUNT' => $replyInfo['gf_account'],
                'R_GF_ID' => $commenterInfo['gf_id'], 'R_GF_ACCOUNT' => $commenterInfo['gf_account'],
                'M_MESSAGE' => base64_encode(json_encode($noticeMsg, 320)), 'M_TYPE' =>351, 'S_G' => 0));
        }
        $rs = array('error'=>'0', 'msg'=>'回复成功');
        set_error($rs,0,'回复成功',1);
    }

    // 17.点赞/取消点赞发布的动动圈信息
    public function actionLike(){
        $param = decodeAskParams($_REQUEST, 0);
        $gfid = $param['visit_gfid'];
        $xq_id = $param['xq_id'];
        $publisherId = JlbMoods::model()->find('xq_id='.$xq_id)->attributes['GF_ID'];
        $publisherInfo = userlist::model()->getUserInfo($publisherId);
        $likerInfo = userlist::model()->getUserInfo($gfid);
        $friendGroupIds = '(SELECT ID FROM gf_group_1 WHERE GF_ID='.$gfid.' AND GF_GROUP_NAME !="黑名单")';
        $friendIds = '(SELECT GF_ID FROM gf_group_info_1 WHERE GP_ID IN '.$friendGroupIds.')';
        $w3 = 'xq_id='.$xq_id.' AND type=1 AND like_id IN '.$friendIds;
        $w4 = 'xq_id='.$xq_id.' AND type=2 AND C_GFID IN '.$friendIds;
        $w5 = 'belong_xq='.$xq_id.' AND type=3 AND C_GFID IN '.$friendIds;
        $w6 = $w3.' OR '.$w4.' OR '.$w5;
        $others = JlbMoodComment::model()->findAll($w6);

        $w0 = 'xq_id='.$xq_id.' AND like_id='.$gfid;
        $likeAgain = JlbMoodComment::model()->findAll($w0.' AND type=4');
        $w1 = 'xq_id='.$xq_id;
        if (!empty($likeAgain)){ //取消点赞后再次点赞
            JlbMoodComment::model()->updateAll(array('is_like'=>1,'type'=>1),$w0);
            $mood = JlbMoods::model()->find($w1);
            $mood->like_count += 1;
            $result = $mood->save();
            $data['GF_NAME']=$mood->GF_NAME;
            $data['gf_icon']=$mood->gf_icon;
            $data['ttime']=$mood->ttime;
            $data['content']=$mood->content;
            $data['web_link']=$mood->web_link;
            $data['pubType']=$mood->pubType;
            $data['media_url']=$mood->media_url;
            if ($result) {
                $noticeMsg = array('xq_id' => $xq_id, 'f_gfid' => $gfid, 'gf_name' => $data['GF_NAME'],
                    'gf_icon' => $data['gf_icon'], 'ttime' => get_date(), 'content' => $data['content'],
                    'web_link' => $data['web_link'], "pubType" => $data['pubType'], "media_url" => $data['media_url'],'type'=>1,'type_id'=>$likeAgain[0]['ID']);
                if($gfid!=$publisherInfo['gf_id']){//点赞者与动动圈发布者相同不通知
                GfMessage::model()->addMsgAndSend(array('S_GF_ID' => $likerInfo['gf_id'], 'S_GF_ACCOUNT' => $likerInfo['gf_account'],
                    'R_GF_ID' => $publisherInfo['gf_id'], 'R_GF_ACCOUNT' => $publisherInfo['gf_account'],
                    'M_MESSAGE' => base64_encode(json_encode($noticeMsg, 320)), 'M_TYPE' => 349, 'S_G' => 0));
                }
                if (!empty($others)){
                    foreach ($others as $other){
                        $otherId = $other->attributes['like_id'];
                        $otherInfo = userlist::model()->getUserInfo($otherId);
                        GfMessage::model()->addMsgAndSend(array('S_GF_ID' => $likerInfo['gf_id'], 'S_GF_ACCOUNT' => $likerInfo['gf_account'],
                            'R_GF_ID' => $otherInfo['gf_id'], 'R_GF_ACCOUNT' => $otherInfo['gf_account'],
                            'M_MESSAGE' => base64_encode(json_encode($noticeMsg, 320)), 'M_TYPE' => 349, 'S_G' => 0));
                    }
                }
            }
            $rs = array('error'=>'0', 'msg'=>'点赞成功');
            set_error($rs,0,'点赞成功',1);
        }else{ //第一次点赞或取消点赞
            $w2 = $w0.' AND type=1';
            $liked = JlbMoodComment::model()->findAll($w2);
            if (empty($liked)){ //点赞
                $like = new JlbMoodComment();
                $like->xq_id = $xq_id;
                $like->belong_xq = $xq_id;
                $like->like_id = $gfid;
                $like->type = 1;
                $like->save();
                $mood = JlbMoods::model()->find($w1);
                $mood->like_count += 1;
                $result = $mood->save();
                $data['GF_NAME']=$mood->GF_NAME;
                $data['gf_icon']=$mood->gf_icon;
                $data['ttime']=$mood->ttime;
                $data['content']=$mood->content;
                $data['web_link']=$mood->web_link;
                $data['pubType']=$mood->pubType;
                $data['media_url']=$mood->media_url;
                if ($result) {
                    $noticeMsg = array('xq_id' => $xq_id, 'f_gfid' => $gfid, 'gf_name' => $data['GF_NAME'],
                        'gf_icon' => $data['gf_icon'], 'ttime' => get_date(), 'content' => $data['content'],
                        'web_link' => $data['web_link'], "pubType" => $data['pubType'], "media_url" => $data['media_url'],'type'=>1,'type_id'=>$like->ID);
                    if($gfid!=$publisherInfo['gf_id']){//点赞者与动动圈发布者相同不通知
                    GfMessage::model()->addMsgAndSend(array('S_GF_ID' => $likerInfo['gf_id'], 'S_GF_ACCOUNT' => $likerInfo['gf_account'],
                        'R_GF_ID' => $publisherInfo['gf_id'], 'R_GF_ACCOUNT' => $publisherInfo['gf_account'],
                        'M_MESSAGE' => base64_encode(json_encode($noticeMsg, 320)), 'M_TYPE' => 349, 'S_G' => 0));
                    }
                    if (!empty($others)){
                        foreach ($others as $other){
                            $otherId = $other->attributes['like_id'];
                            $otherInfo = userlist::model()->getUserInfo($otherId);
                            GfMessage::model()->addMsgAndSend(array('S_GF_ID' => $likerInfo['gf_id'], 'S_GF_ACCOUNT' => $likerInfo['gf_account'],
                                'R_GF_ID' => $otherInfo['gf_id'], 'R_GF_ACCOUNT' => $otherInfo['gf_account'],
                                'M_MESSAGE' => base64_encode(json_encode($noticeMsg, 320)), 'M_TYPE' => 349, 'S_G' => 0));
                        }
                    }
                }
                $rs = array('error'=>'0', 'msg'=>'点赞成功');
                set_error($rs,0,'点赞成功',1);
            }else{ //取消点赞
                JlbMoodComment::model()->updateAll(array('is_like'=>1,'type' => 4),$w2);
                $mood = JlbMoods::model()->find($w1);
                $mood->like_count -= 1;
                $result = $mood->save();
                if ($result) {
                    $noticeMsg = array('xq_id' => $xq_id, 'gfid' => $gfid);
                    GfMessage::model()->addMsgAndSend(array('S_GF_ID' => $likerInfo['gf_id'], 'S_GF_ACCOUNT' => $likerInfo['gf_account'],
                        'R_GF_ID' => $publisherInfo['gf_id'], 'R_GF_ACCOUNT' => $publisherInfo['gf_account'],
                        'M_MESSAGE' => base64_encode(json_encode($noticeMsg, 320)), 'M_TYPE' => 353, 'S_G' => 0));
                }
                $rs = array('error'=>'0', 'msg'=>'取消点赞成功');
                set_error($rs,0,'取消点赞成功',1);
            }
        }
    }

    // 18.删除自己发布的动动圈信息
    public function actionDelMyMood(){
        $param = decodeAskParams($_REQUEST, 0);
        $gfid = $param['visit_gfid'];
        $xq_id = $param['xq_id'];
        $w0 = 'GF_ID = '.$gfid.' and xq_id='.$xq_id;
        $mood = JlbMoods::model()->find($w0.' AND if_del=510');
        if (!empty($mood)){
            $result = JlbMoods::model()->updateAll(array('if_del'=>509), $w0);
            $publisherInfo = userlist::model()->getUserInfo($gfid);
            $w1 = 'xq_id='.$xq_id.' OR belong_xq='.$xq_id;
            $allActions = JlbMoodComment::model()->findAll($w1);
            $likeGfids = array_column($allActions,'like_id');
            $likeGfids = array_diff($likeGfids, [0]);
            $commentAndReplyGfids = array_column($allActions,'C_GFID');
            $commentAndReplyGfids = array_diff($commentAndReplyGfids, [0]);
            $allActionsGfids = array_keys(array_flip($likeGfids) + array_flip($commentAndReplyGfids));
            $noticeMsg = array('xq_id' => $xq_id);
            foreach ($allActionsGfids as $actionsGfid){
                $actionInfo = userlist::model()->getUserInfo($actionsGfid);
                if ($result) {
                    GfMessage::model()->addMsgAndSend(array('S_GF_ID' => $publisherInfo['gf_id'], 'S_GF_ACCOUNT' => $publisherInfo['gf_account'],
                        'R_GF_ID' => $actionInfo['gf_id'], 'R_GF_ACCOUNT' => $actionInfo['gf_account'],
                        'M_MESSAGE' => base64_encode(json_encode($noticeMsg, 320)), 'M_TYPE' => 354, 'S_G' => 0));
                }
            }
            $rs = array('error'=>'0', 'msg'=>'删除成功');
            set_error($rs,0,'删除成功',1);
        }
    }

    // 19.对自己发布的动动圈信息设置为私密／公开
    public function actionSetShowOrNot(){
        $param = decodeAskParams($_REQUEST, 0);
        $gfid = $param['visit_gfid'];
        $xq_id = $param['xq_id'];
        $is_show = $param['is_show'];
        $w1 = 'GF_ID = '.$gfid.' and xq_id = '.$xq_id.' and is_show = '.$is_show;
        if ($is_show == 2) {
            JlbMoods::model()->updateAll(array('is_show'=>'0'), $w1);
        } else {
            JlbMoods::model()->updateAll(array('is_show'=>'2'), $w1);
        }
        $rs = array('error'=>'0', 'msg'=>'设置成功');
        set_error($rs,0,'设置成功',1);
    }

    // 20.动圈背景图设置
    public function actionEdit_mood_bg() {
        $param = decodeAskParams($_REQUEST, 0);
        $gfid = $param['visit_gfid'];
        $pic = $param['pic'];
        $w1 = 'GF_ID = '.$gfid;
        userlist::model()->updateAll(array('mood_bigpic_url'=>$pic), $w1);
        $rs = array('error'=>'0', 'msg'=>'设置成功');
        set_error($rs,0,'设置成功',1);
    }

    // 21.会员足迹
    public function actionGet_foot() {
        $param = decodeAskParams($_REQUEST, 0);
        $rs =get_error(1,'');
        $visit_gfid = $param['visit_gfid'];
        $gfid = empty($param['gfid'])?$visit_gfid:$param['gfid'];
        $page = $param['page'];
        $per_page = $param['per_page'];
        $d0 = array();
        
            $w0 = 'GF_ID = '.$gfid;
            $userInfo = userlist::model()->findAll($w0);
            $s0 = 'GF_NAME:name,TXNAME:gf_icon,SEX:sex,AGE:age,mood_bigpic_url:mood_pic';
            $d0 = toIoArray($userInfo,$s0);
            if(count($d0)==0){
            	set_error($rs,1,'获取信息失败',1);
            }
            $userFootShow = GfUserFootShow::model()->find($w0);
            $d0[0]['is_show'] = empty($userFootShow)?1:$userFootShow['is_show'];
        if($d0[0]['is_show']==1||$visit_gfid==$gfid){
        	$w1 = 'GF_ID = '.$gfid.' order by time limit '.(($page-1)*$per_page).','.$per_page;
	        $userFeet = GfUserFoot::model()->findAll($w1);
	        $s1 = 'time:time,content:content';
	        $d1 = toIoArray($userFeet,$s1);
	        $get_count = Yii::app()->db->createCommand('select count(id) as c from gf_user_foot where GF_ID = '.$gfid)->queryAll();
	        $total=count($get_count)>0?$get_count[0]['c']:0;
        	$rs = array('error'=>'0', 'msg'=>$total==0?'暂无足迹':'获取信息成功', 'user'=>$d0[0], 'foot'=>$d1, 'total_count'=>$total,
            'page'=>$page);
        }else{
        	$rs = array('error'=>'0', 'msg'=>$d0[0]['name'].'的足迹未公开', 'user'=>$d0[0], 'foot'=>array(), 'total_count'=>0,
            'page'=>$page);
        }
        
        set_error($rs,$rs['error'],$rs['msg'],1);
    }

    // 22. 对自己足迹设置为私密／公开
    public function actionSet_foot_show(){
        $param = decodeAskParams($_REQUEST, 0);
        $gfid = $param['visit_gfid'];
        $is_show = $param['is_show'];
        $w0 = 'GF_ID='.$gfid;
        $footShow = GfUserFootShow::model()->find($w0);
        if (!empty($footShow)){
            GfUserFootShow::model()->updateAll(array('is_show'=>$is_show), $w0);
        }else{
            $show = new GfUserFootShow();
            $show->GF_ID = $gfid;
            $show->is_show = $is_show;
            $show->save();
        }
        $rs = array('error'=>'0', 'msg'=>'设置成功');
        set_error($rs,0,'设置成功',1);
    }

    // 23.获取离线动动圈消息列表
    public function actionGetOfflineMood(){
        $param = decodeAskParams($_REQUEST, 0);
        $gfid = $param['visit_gfid'];
        $w0 = '(SELECT ID FROM gf_group_1 WHERE GF_ID='.$gfid.' AND GF_GROUP_NAME !="黑名单")';
        $w1 = '(SELECT GF_ID FROM gf_group_info_1 WHERE GP_ID IN '.$w0.')';
        $w2 = '(SELECT max_xq_id FROM jlb_mood_comment WHERE V_GFID='.$gfid.' limit 1)';
        $offlineMoods = JlbMoods::model()->findAll('xq_id>' .$w2.' AND (GF_ID='.$gfid.' OR GF_ID IN '.$w1.')');
        $s0 = 'xq_id:xq_id,content:content,web_link:web_link,pubType:pubType,media_url:media_url';
        $d0 = toIoArray($offlineMoods,$s0);
        foreach ($d0 as $value){
            $a[$value['xq_id']] = $value;
        }
        $offlineMoodIds = array_column($offlineMoods, 'xq_id');
        foreach ($offlineMoodIds as $offlineMoodId){
            $w3 = '(xq_id='.$offlineMoodId.' OR belong_xq='.$offlineMoodId.') AND ((C_GFID='.$gfid.' OR C_GFID IN '.$w1.
                ') OR (like_id='.$gfid.' OR like_id IN '.$w1.'))';
            $allActions = JlbMoodComment::model()->findAll($w3);
            if(!empty($allActions)){
                foreach ($allActions as $k=>$v){
                    $type = $v['type'];
                    if($type == 1 or $type == '1'){
                        $a[$v['xq_id']][$k]['type'] = 1;
                        $a[$v['xq_id']][$k]['type_id'] = $v['ID'];
                        $a[$v['xq_id']][$k]['f_gfid'] = $v['like_id'];
                        $a[$v['xq_id']][$k]['gf_name'] = $v['type_gf_name'];
                        $a[$v['xq_id']][$k]['gf_icon'] = $v['type_gf_icon'];
                        $a[$v['xq_id']][$k]['ttime'] = $v['ttime'];
                    }
                    if ($type == 2 or $type == '2'){
                        $a[$v['xq_id']][$k]['type'] = 2;
                        $a[$v['xq_id']][$k]['type_id'] = $v['ID'];
                        $a[$v['xq_id']][$k]['f_gfid'] = $v['C_GFID'];
                        $a[$v['xq_id']][$k]['gf_name'] = $v['type_gf_name'];
                        $a[$v['xq_id']][$k]['gf_icon'] = $v['type_gf_icon'];
                        $a[$v['xq_id']][$k]['ttime'] = $v['ttime'];
                        $a[$v['xq_id']][$k]['comment_content'] = $v['content'];
                    }
                    if ($type == 3 or $type == '3'){
                        $a[$v['belong_xq']][$k]['type'] = 3;
                        $a[$v['belong_xq']][$k]['type_id'] = $v['ID'];
                        $a[$v['belong_xq']][$k]['f_gfid'] = $v['like_id'];
                        $a[$v['belong_xq']][$k]['gf_name'] = $v['type_gf_name'];
                        $a[$v['belong_xq']][$k]['gf_icon'] = $v['type_gf_icon'];
                        $a[$v['belong_xq']][$k]['ttime'] = $v['ttime'];
                        $a[$v['belong_xq']][$k]['comment_gfid'] = $v['C_GFID'];
                        $a[$v['belong_xq']][$k]['comment_gf_name'] = $v['type_gf_name'];
                        $a[$v['belong_xq']][$k]['reply_content'] = $v['content'];
                    }
                }
            }
        }
        $d = array();
        if(isset($a)){
            $d = array_values($a);
        }
        $rs = array('error'=>'0','msg'=>'设置成功','mood_notify'=>$d);
        set_error($rs,0,'设置成功',1);
    }

    /**
     * 接口：更新用户读过的最大动动圈心情ID，第一次打开则新增。
     * gfid：查看动动圈心情的用户
     * maxMoodId：用户读过的最大动动圈心情ID
     */
    public function actionUpdateMaxMood(){
        $param = decodeAskParams($_REQUEST, 0);
        $gfid  = $param['visit_gfid'];
        $maxMoodId = $param['maxMoodId'];
        $maxMoodRecord =  JlbMoodComment::model()->find('V_GFID='.$gfid);
        if (empty($maxMoodRecord)){
            $maxMood = new JlbMoodComment();
            $maxMood->V_GFID = $gfid;
            $maxMood->max_xq_id = $maxMoodId;
            $maxMood->save();
        }else{
            JlbMoodComment::model()->updateAll(array('max_xq_id'=>$maxMoodId),'V_GFID='.$gfid);
        }
    }

    // 获取动动约订单列表
    public function actionGetOrderList(){
        $param = decodeAskParams($_REQUEST,1);
        $id = $param['visit_gfid'];
        $page = empty($param['page'])||$param['page']<1?1:$param['page'];
        $per_page = empty($param['per_page'])?10:$param['per_page'];
        $order_state = $param['order_state'];
        $type_code = $param['type_code'];
        $order_state_list = array(
            array('id'=>'0','name'=>'全部'),
            array('id'=>'1','name'=>'待支付'),
            array('id'=>'2','name'=>'已支付'),
            array('id'=>'3','name'=>'已关闭'),
        );
        $data['order_state_list'] = $order_state_list;

        $w0 = 'order_type=353 AND is_show=649 AND gfid='.$id;
        $w0 = get_where($w0,$type_code,'t_stypeid',$type_code);
        $w1 = ($page-1)*$per_page.','.$per_page;
        if ($order_state == 0){
            $w2 = $w0.' LIMIT '.$w1;
        }elseif ($order_state == 1){
            $w2 = $w0.' AND order_state_name="待支付" LIMIT '.$w1;
        }elseif ($order_state == 2){
            $w2 = $w0.' AND order_state_name="已支付" LIMIT '.$w1;
        }elseif ($order_state == 3){
            $w2 = $w0.' AND order_state_name="已关闭" LIMIT '.$w1;
        }
        $cr = new CDbCriteria;
        $cr->condition = $w2;
        $cr->select = 'shopping_order_num as order_num,concat(order_type_name,"|",supplier_name) as show_order_title,'.
            'order_state_name as state_name,effective_time,'.
            'service_ico as service_pic,service_name,buy_price as service_fee,'.
            'concat(ifnull(show_service_data_title,show_service_title)," ¥",buy_price) as service_content';
        $datas = GfServiceData::model()->findAll($cr,array(),false);
        foreach ($datas as $d){
            $stateName = $d['state_name'];
            if($stateName == '待支付'){
                $d['control'] = '1,2';
            }elseif($stateName == '已支付'){
                $d['control'] = '';
            }elseif($stateName == '已关闭'){
                $d['control'] = '3';
            }
        }
        $count = count($datas);
        $data['datas'] = $datas;
        $data['total'] = $count;
        set_error_tow($data,$count,0,"拉取成功",0,"无数据",1);
    }

    // 根据销售订单号获取动动约订单详情
    public function actionGetOrderDetailsByOrderNum(){
        $param = decodeAskParams($_REQUEST,1);
        $id = $param['visit_gfid'];
        $order_num = $param['order_num'];
        $data = get_error(1,"");
        $w0 = 'order_type=353 AND is_show=649 AND shopping_order_num="'.$order_num.'" AND gfid='.$id;
        $order = GfServiceData::model()->find($w0);
        if(empty($order)){
            set_error($data,1,"该订单不存在",1);
        }
        $w1 = 'type=757 and order_type=353 and order_gfid='.$id;
        if($order->is_pay == 464 && !empty($order->info_order_num)){
            $w1 .= ' and pay_gfcode="'.$order->shopping_order_num.'"';
            $orderInfo = MallSalesOrderInfo::model()->find($w1);
        }else{
            $w1 .= ' and order_num="'.$order->shopping_order_num.'"';
            $orderInfo = Carinfo::model()->find($w1);
        }
        if(empty($orderInfo)){
            set_error($data,1,"订单错误",1);
        }
        $payType = empty($orderInfo['pay_supplier_type_name'])?'':$orderInfo['pay_supplier_type_name'];
        $payTime = empty($orderInfo['pay_time'])?'':$orderInfo['pay_time'];
        $datas['order_detail'] = '订单编号：'.$orderInfo['order_num'].'<br/>预 定 人：'.$orderInfo['order_gfaccount'].'/'.
            $orderInfo['order_gfname'].'<br/>联系电话：'.$orderInfo['contact_phone']. '<br/>支付方式：'.$payType.'<br/>支付时间：'.$payTime;
        $datas['show_order_title'] = $order['order_type_name'].' | '.$order['supplier_name'];;
        $datas['state_name'] = $order['state_name'];
        $datas['state_notify'] = '请注意服务单开始时间 ';
        $datas['effective_time'] = $order['effective_time'];
        $stateName = $order['state_name'];
        if($stateName == '待支付'){
            $datas['control'] = '1,2';
        }elseif($stateName == '已支付'){
            $datas['control'] = '';
        }elseif($stateName == '已关闭'){
            $datas['control'] = '3';
        }
        $datas['service_pic'] = $order['service_ico'];
        $datas['service_name'] = $order['service_name'];
        $datas['service_type'] = $order['service_type'];
        $datas['service_fee_title'] = '订单总价';
        $serviceFee = 0.00;
        $serverDatas = array();
        $cr = new CDbCriteria;
        $cr->condition = $w0;
        $cr->select = 'buy_price as service_fee,ifnull(show_service_data_title,show_service_title) as content';
        $all = GfServiceData::model()->findAll($cr,array(),false);
        foreach($all as $k=>$v){
            $serviceFee += $v['service_fee'];
            $serverDatas[$k]['fee'] = '¥'.$v['service_fee'];
            $serverDatas[$k]['content'] = $v['content'];
        }
        $datas['service_fee'] = '¥'.number_format($serviceFee,'2');
        $datas['service_datas'] = $serverDatas;
        $data['datas'] = $datas;
        set_error($data,0,'获取成功',1);
    }
}
?>