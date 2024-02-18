<?php

class GfCrowdInviteMember extends BaseModel {

    public function tableName() {
        return '{{gf_crowd_invite_member}}';
    }

    /**
     * 模型验证规则
  `id` bigint(64) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `crowd_id` bigint(64) unsigned NOT NULL COMMENT '群id',
  `crowd_name` varchar(100) NOT NULL DEFAULT '' COMMENT '群名称',
  `crowd_img` varchar(100) NOT NULL COMMENT '群头像',
  `to_gfid` bigint(64) unsigned NOT NULL COMMENT '受邀会员gfid',
  `to_account` varchar(100) NOT NULL COMMENT '受邀会员的gf账号',
  `to_name` varchar(100) NOT NULL COMMENT '受邀会员的gf昵称',
  `to_icon` varchar(100) NOT NULL COMMENT '受邀会员的gf头像',
  `invite_state` int NOT NULL COMMENT '0-邀请中，1-同意，2-拒绝，3-过期／被撤回',
  `add_time` datetime NOT NULL COMMENT '邀请时间',
  `invalid_time` datetime NOT NULL COMMENT '失效时间',
  `reply_time` datetime NOT NULL COMMENT '回复时间',
  `inviter_gfid` int(32) unsigned NOT NULL COMMENT '邀请人的gfid',
  `inviter_account` varchar(100) NOT NULL COMMENT '邀请人的gf账号',
  `inviter_name` varchar(100) NOT NULL COMMENT '邀请人的群昵称',
  `creater_gfid` int(32) unsigned NOT NULL COMMENT '群主的gfid',
  `audit_state` int NOT NULL COMMENT '邀请人非群主时，需要群主审核；状态：0-待确认，1-同意，2-拒绝',
  `audit_time` datetime NOT NULL COMMENT '群主审核时间',
     */
    public function rules() {
        return array(
            array('id,crowd_id,crowd_name,crowd_img,to_gfid,to_account,to_name,to_icon,invite_state,add_time,invalid_time,reply_time,inviter_gfid,inviter_account,inviter_name,creater_gfid,audit_state,audit_time','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
        );
    }

    /**
     * 属性标签
     */   
    public function attributeLabels() {
        return array();
    }
    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
	}

 	/**
     * 群主／群成员邀请会员加群
     * invite_gfid  多个使用,隔开
     * 邀请成功，群主邀请-发送通知340给被邀请会员，群成员邀请-发送通知343给邀请会员
     */
	public function inviteCrowdMember($param){
		$data=get_error(1,"获取失败");
		checkArray($param,'visit_gfid,crowd_id,invite_gfid',1);
		$crowd_id=$param['crowd_id'];
		$gfid=$param['visit_gfid'];
        $crowd_info=GfCrowdBase::model()->CrowdInfo($crowd_id);
        if(empty($crowd_info)){
        	set_error($data,3,'该群已解散',1);
        }
		$member=GfCrowdMember::model()->CrowdMemberInfo($gfid,$crowd_id);
        if(empty($member)){
        	set_error($data,5,'你已经不是该群成员',1);
        }
		$add_gfid_data = explode(',',$param['invite_gfid']); 
		$add_id=array();
		$add_num=0;
		foreach($add_gfid_data as $k=>$add_gfid){
			$add_id[$add_gfid]=-1;
			$tis_member=GfCrowdMember::model()->isCrowdMember($add_gfid,$crowd_id);
	        if($tis_member!=-1){
//	        	set_error($data,4,'对方已经是该群成员',1);
				$add_id[$add_gfid]=0;
				$add_num++;
	        }
	        $where="crowd_id=".$crowd_id." and to_gfid=".$gfid;
	        $apply=$this->find($where);
	        if(!empty($apply)&&$apply['apply_state']==0){
//	        	set_error($data,2,'已邀请该会员入群，等待验证',1);
				$add_id[$add_gfid]=$apply->id;
				$add_num++;
	        }
		}
		if($add_num==count($add_gfid_data)){
			set_error($data,0,"发送成功",1);
		}
		$add_account=array();
		$cadd=0;
		foreach($add_id as $add_gfid=>$apply_id){
			if($apply_id==-1){
		        $gf_info=userlist::model()->getUserInfo($add_gfid,0);
		        if(empty($gf_info)){
		        	continue;
		        }
		        $ask=new GfCrowdInviteMember;
		        unset($ask->id);
		        $ask->crowd_id=$crowd_id;
		        $ask->crowd_name=$crowd_info['BASE_NAME'];
		        $ask->crowd_img=$crowd_info['BASE_IMG'];
		        $ask->to_gfid=$add_gfid;
		        $ask->to_account=$gf_info['gf_account'];
		        $ask->to_name=$gf_info['gf_name'];
		        $ask->to_icon=$gf_info['gf_icon'];
		        $ask->invite_state=0;
		        $ask->add_time=get_date();
		//        $ask->invalid_time;
		        $ask->inviter_gfid=$gfid;
		        $ask->inviter_account=$member['GF_ACCOUNT'];
		        $ask->inviter_name=$member['MEMBER_MARK'];
		        $ask->creater_gfid=$crowd_info['BASE_CREATE_GFID'];
		        $res=$ask->insert($ask);
				if($res){
					$add_id[$add_gfid]=$ask->id;
					$add_account[$cadd]=$gf_info;
				}
			}
		}	
		$content=array('crowd_id'=>$crowd_id,'crowd_name'=>$crowd_info['BASE_NAME'],'crowd_icon'=>getShowUrl('file_path_url').$crowd_info['BASE_IMG'],'gf_id'=>$gfid,'gf_account'=>$member['GF_ACCOUNT'],'gf_name'=>$member['MEMBER_MARK'],'section_code'=>'A02',"section_name"=>"群通知","title"=>$member['MEMBER_MARK']."邀请你加入".$crowd_info['BASE_NAME']);
        foreach($add_account as $k=>$gf_info){
        	$content['id']=$add_id[$gf_info['gf_id']];
        	$notify=GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>$gfid,'S_GF_ACCOUNT'=>$member['GF_ACCOUNT']
        	,'R_GF_ID'=>$gf_info['gf_id'],'R_GF_ACCOUNT'=>$gf_info['gf_account']
        	,'M_MESSAGE'=>base64_encode(json_encode($content,320)),'M_TYPE'=>$member['MEMBER_ADMIN']==2?340:343,'S_G'=>0));
        }
        $data['apply']=$add_id;
		set_error_tow($data,count($add_id)==count($add_gfid_data),0,'发送成功',1,'发送失败',1);
	}
	
	/**
     * 受邀者回复加群邀请
     * reply 1-同意，2-拒绝
     * 同意-发送341给邀请者，并判断
     * 			邀请人是群主，会员同意直接加入群，发送通知303给群成员，；
     * 			邀请人不是群主，会员同意后还需发通知345给群主审核，群主同意后才加入群；
     * 拒绝-发送342给邀请者
     */
	public function replyCrowdInvite($param){
		$data=get_error(1,"操作失败");
		checkArray($param,'visit_gfid,id,reply',1);
        $reply=$param['reply'];//1-agree,2-refuse
		$where="id=".$param['id'];
        $apply=$this->find($where);
        if(!empty($apply)&&$apply['invite_state']>0){
            set_error_tow($data,$apply['invite_state']==$reply,0,$reply==1?'添加成功':'已拒绝'
                ,3,$reply==1?'已同意邀请':'已拒绝邀请',1);
        }
        if(!empty($apply)&&$apply['invite_state']==0&&$param['visit_gfid']==$apply['to_gfid']){
	        $crowd_info=GfCrowdBase::model()->CrowdInfo($apply['crowd_id']);
	        if(empty($crowd_info)){
	        	set_error($data,3,'该群已解散',1);
	        }
    		if($reply==1&&$apply['inviter_gfid']==$apply['creater_gfid']){
    			$re_data=GfCrowdMember::model()->addMember($apply['to_gfid'],$apply['crowd_id']);
    			if($re_data['error']!=0){
    				set_error($data,$re_data['error'],$re_data['msg'],1);
    			}
    		}
        	$res=$this->updateAll(array('invite_state'=>$reply,'reply_time'=>get_date()),$where);
        	if($res){
        		$content=array('id'=>$apply['id'],'crowd_id'=>$apply['crowd_id'],'crowd_name'=>$apply['crowd_name'],'crowd_icon'=>getShowUrl('file_path_url').$apply['crowd_img'],'gf_id'=>$apply['to_gfid'],'gf_account'=>$apply['to_account'],'gf_name'=>$apply['to_name'],'section_code'=>'A02',"section_name"=>"群通知","title"=>$apply['to_name'].($reply==1?'同意':'拒绝')."加入".$apply['crowd_name']);
        		$notify=GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>$apply['to_gfid'],'S_GF_ACCOUNT'=>$apply['to_account']
        	,'R_GF_ID'=>$apply['inviter_gfid'],'R_GF_ACCOUNT'=>$apply['inviter_account']
        	,'M_MESSAGE'=>json_encode($content,320),'M_TYPE'=>$reply==1?341:342,'S_G'=>0));
	        	if($reply==1){
	        		if($apply['inviter_gfid']==$apply['creater_gfid']){
	        			$add_content=array('crowd_id'=>$apply['crowd_id'],'crowd_name'=>$apply['crowd_name'],'crowd_icon'=>getShowUrl('file_path_url').$apply['crowd_img'],'member_type'=>2,'gfid'=>$apply['to_gfid'],'gfaccount'=>$apply['to_account'],'gfnick'=>$apply['to_name'],'section_code'=>'A02',"section_name"=>"群通知","title"=>$apply['to_name']."加入群");
	        			$notify=GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>$apply['to_gfid'],'S_GF_ACCOUNT'=>$apply['to_account']
	        	,'R_GF_ID'=>$apply['crowd_id'],'R_GF_ACCOUNT'=>0
	        	,'M_MESSAGE'=>json_encode($add_content,320),'M_TYPE'=>303,'S_G'=>1));
	        		}else{//会员同意群成员邀请加入群，待群主审核
	        			$content['inviter_gfid']=$apply['inviter_gfid'];
	        			$content['inviter_name']=$apply['inviter_name'];
	        			$notify=GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>$apply['to_gfid'],'S_GF_ACCOUNT'=>$apply['to_account']
        	,'R_GF_ID'=>$apply['creater_gfid'],'R_GF_ACCOUNT'=>0
        	,'M_MESSAGE'=>json_encode($content,320),'M_TYPE'=>345,'S_G'=>0));
	        		}
	        	}
				set_error($data,0,$reply==1?'添加成功':'已拒绝',1);
        	}
        }	
		set_error($data,1,'操作失败',1);
	}
	
	/**
     * 群主审核群成员邀请会员加群
     * reply 1-同意，2-拒绝
     * 同意-写入群成员信息，更新状态，发送通知346给被邀请者，并发送通知303给群成员
     * 拒绝-更新状态，发送通知347给被邀请者
     */
	public function CrowdCreaterAudit($param){
		$data=get_error(1,"操作失败");
		checkArray($param,'visit_gfid,id,reply',1);
		$where="id=".$param['id'];
        $apply=$this->find($where);
        if(!empty($apply)&&$apply['invite_state']==1&&$apply['audit_state']==0&&$param['visit_gfid']==$apply['creater_gfid']){
	        $crowd_info=GfCrowdBase::model()->CrowdInfo($apply['crowd_id']);
	        if(empty($crowd_info)){
	        	set_error($data,3,'该群已解散',1);
	        }
        	$reply=$param['reply'];//1-agree,2-refuse
    		if($reply==1){
    			$re_data=GfCrowdMember::model()->addMember($apply['to_gfid'],$apply['crowd_id']);
    			if($re_data['error']!=0){
    				set_error($data,$re_data['error'],$re_data['msg'],1);
    			}
    		}
        	$res=$this->updateAll(array('audit_state'=>$reply,'audit_time'=>get_date()),$where);
        	if($res){
        		$content=array('crowd_id'=>$apply['crowd_id'],'crowd_name'=>$apply['crowd_name'],'crowd_icon'=>getShowUrl('file_path_url').$apply['crowd_img'],'inviter_gfid'=>$apply['inviter_gfid'],'inviter_name'=>$apply['inviter_name'],'gf_name'=>$apply['to_name'],'section_code'=>'A02',"section_name"=>"群通知","title"=>'群主'.($reply==1?'同意':'拒绝')."你加入".$apply['crowd_name']);
        		$notify=GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>$apply['to_gfid'],'S_GF_ACCOUNT'=>$apply['to_account']
        	,'R_GF_ID'=>$apply['inviter_gfid'],'R_GF_ACCOUNT'=>$apply['inviter_account']
        	,'M_MESSAGE'=>json_encode($content,320),'M_TYPE'=>$reply==1?346:347,'S_G'=>0));
	        	if($reply==1){
	        			$add_content=array('crowd_id'=>$apply['crowd_id'],'crowd_name'=>$apply['crowd_name'],'crowd_icon'=>getShowUrl('file_path_url').$apply['crowd_img'],'member_type'=>2,'gfid'=>$apply['to_gfid'],'gfaccount'=>$apply['to_account'],'gfnick'=>$apply['to_name'],'section_code'=>'A02',"section_name"=>"群通知","title"=>$apply['to_name']."加入群");
	        			$notify=GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>$apply['to_gfid'],'S_GF_ACCOUNT'=>$apply['to_account']
	        	,'R_GF_ID'=>$apply['crowd_id'],'R_GF_ACCOUNT'=>0
	        	,'M_MESSAGE'=>json_encode($add_content,320),'M_TYPE'=>303,'S_G'=>1));
	        	}
				set_error($data,0,$reply==1?'添加成功':'已拒绝',1);
        	}
        }	
		set_error($data,1,'操作失败',1);
	}
	
}
