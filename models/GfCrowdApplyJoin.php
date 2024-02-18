<?php

class GfCrowdApplyJoin extends BaseModel {

    public function tableName() {
        return '{{gf_crowd_apply_join}}';
    }

    /**
     * 模型验证规则
  `id` bigint(64) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `crowd_id` bigint(64) unsigned NOT NULL COMMENT '群id',
  `crowd_name` varchar(100) NOT NULL DEFAULT '' COMMENT '群名称',
  `crowd_img` varchar(100) NOT NULL COMMENT '群头像',
  `apply_gfid` bigint(64) unsigned NOT NULL COMMENT '申请会员gfid',
  `apply_account` varchar(100) NOT NULL COMMENT '申请会员的gf账号',
  `apply_name` varchar(100) NOT NULL COMMENT '申请会员的gf昵称',
  `apply_icon` varchar(100) NOT NULL COMMENT '申请会员的gf头像',
  `apply_msg` varchar(100) NOT NULL COMMENT '申请附言',
  `apply_state` int NOT NULL COMMENT '0-申请中，1-同意，2-拒绝，3-过期／被撤回',
  `apply_time` datetime NOT NULL COMMENT '申请时间',
  `invalid_time` datetime NOT NULL COMMENT '失效时间',
  `creater_gfid` int(32) unsigned NOT NULL COMMENT '群主的gfid',
  `creater_account` varchar(100) NOT NULL COMMENT '群主的gf账号',
  `creater_name` varchar(100) NOT NULL COMMENT '群主的群昵称',
  `reply_time` datetime NOT NULL COMMENT '回复时间',
     */
    public function rules() {
        return array(
            array('id,crowd_id,crowd_name,crowd_img,apply_gfid,apply_account,apply_name,apply_icon,apply_msg,apply_state,apply_time,invalid_time,creater_gfid,creater_account,creater_name,reply_time','safe'),
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
     * 申请加群，发送通知337给群主
     */
	public function applyJoinCrowd($param){
		$data=get_error(1,"获取失败");
		checkArray($param,'visit_gfid,crowd_id,crowd_name,ask_msg',1);
		$crowd_id=$param['crowd_id'];
		$gfid=$param['visit_gfid'];
        $gf_info=userlist::model()->getUserInfo($gfid);
        if(empty($gf_info)){
        	set_error($data,5,'您的账号已被冻结或注销',1);
        }
		$is_member=GfCrowdMember::model()->isCrowdMember($gfid,$crowd_id);
        if($is_member!=-1){
        	set_error($data,4,'已经是该群成员',1);
        }
        $where="crowd_id=".$crowd_id." and apply_gfid=".$gfid;
        $apply=$this->find($where);
        if(!empty($apply)&&$apply['apply_state']==0){
        	set_error($data,2,'已提交入群申请，请等待验证',1);
        }
        $crowd_info=GfCrowdBase::model()->CrowdInfo($crowd_id);
        if(empty($crowd_info)){
        	set_error($data,3,'该群已解散',1);
        }
        $creater=GfCrowdMember::model()->CrowdMemberInfo($crowd_info['BASE_CREATE_GFID'],$crowd_id);
        $ask=new GfCrowdApplyjoin;
        unset($ask->id);
        $ask->crowd_id=$crowd_id;
        $ask->crowd_name=$crowd_info['BASE_NAME'];
        $ask->crowd_img=$crowd_info['BASE_IMG'];
        $ask->apply_gfid=$gfid;
        $ask->apply_account=$gf_info['gf_account'];
        $ask->apply_name=$gf_info['gf_name'];
        $ask->apply_icon=$gf_info['gf_icon'];
        $ask->apply_msg=$param['ask_msg'];
        $ask->apply_state=0;
        $ask->apply_time=get_date();
//        $ask->invalid_time;
        $ask->creater_gfid=$crowd_info['BASE_CREATE_GFID'];
        $ask->creater_account=$creater['GF_ACCOUNT'];
        $ask->creater_name=$creater['MEMBER_MARK'];
        $res=$ask->insert($ask);
        if($res){
        	$data['apply_id']=$ask->id;
        	$content=array('id'=>$data['apply_id'],'crowd_id'=>$crowd_id,'crowd_name'=>$crowd_info['BASE_NAME'],'crowd_icon'=>getShowUrl('file_path_url').$crowd_info['BASE_IMG'],'gfid'=>$gf_info['gf_id'],'gf_account'=>$gf_info['gf_account'],'gf_name'=>$gf_info['gf_name'],'s_msg'=>$param['ask_msg'],'section_code'=>'A02',"section_name"=>"群通知","title"=>$gf_info['gf_account'].'/'.$gf_info['gf_name']."申请加入群","content"=>$param['ask_msg']);
        	$notify=GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>$gf_info['gf_id'],'S_GF_ACCOUNT'=>$gf_info['gf_account']
        	,'R_GF_ID'=>$creater['GF_ID'],'R_GF_ACCOUNT'=>$creater['GF_ACCOUNT']
        	,'M_MESSAGE'=>base64_encode(json_encode($content,320)),'M_TYPE'=>337,'S_G'=>0));
        }
		set_error_tow($data,$res,0,'验证信息发送成功',1,'验证信息发送失败',1);
	}
	
	/**
     * 群主回复加群申请
     * reply 1-同意，2-拒绝
     * 同意-写入群成员信息，更新状态，发通知338给被同意加入群的会员，并发送通知303给所有群成员
     * 拒绝-更新状态，发通知339给被拒绝加入群的会员
     */
	public function replyJoinCrowd($param){
		$data=get_error(1,"操作失败");
		checkArray($param,'visit_gfid,id,reply',1);
		$where="id=".$param['id'];
        $apply=$this->find($where);
        if(!empty($apply)&&$apply['apply_state']==0&&$param['visit_gfid']==$apply['creater_gfid']){
	        $crowd_info=GfCrowdBase::model()->CrowdInfo($apply['crowd_id']);
	        if(empty($crowd_info)){
	        	set_error($data,3,'该群已解散',1);
	        }
        	$reply=$param['reply'];//1-agree,2-refuse
    		if($reply==1){
    			$re_data=GfCrowdMember::model()->addMember($apply['apply_gfid'],$apply['crowd_id']);
    			if($re_data['error']!=0){
    				set_error($data,$re_data['error'],$re_data['msg'],1);
    			}
    		}
        	$res=$this->updateAll(array('apply_state'=>$reply,'reply_time'=>get_date()),$where);
        	if($res){
        		$content=array('crowd_id'=>$apply['crowd_id'],'crowd_name'=>$apply['crowd_name'],'crowd_icon'=>getShowUrl('file_path_url').$apply['crowd_img'],'section_code'=>'A02',"section_name"=>"群通知","title"=>$apply['crowd_name'].($reply==1?'同意':'拒绝')."你加入群");
        		$notify=GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>$apply['creater_gfid'],'S_GF_ACCOUNT'=>$apply['creater_account']
        	,'R_GF_ID'=>$apply['apply_gfid'],'R_GF_ACCOUNT'=>$apply['apply_account']
        	,'M_MESSAGE'=>json_encode($content,320),'M_TYPE'=>$reply==1?338:339,'S_G'=>0));
	        	if($reply==1){
	        		$content=array('crowd_id'=>$apply['crowd_id'],'crowd_name'=>$apply['crowd_name'],'member_type'=>2,'gfid'=>$apply['apply_gfid'],'gfaccount'=>$apply['apply_account'],'gfnick'=>$apply['apply_name'],'crowd_icon'=>getShowUrl('file_path_url').$apply['crowd_img'],'section_code'=>'A02',"section_name"=>"群通知","title"=>$apply['apply_name']."加入群");
	        		$notify=GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>$apply['creater_gfid'],'S_GF_ACCOUNT'=>$apply['creater_account']
	        	,'R_GF_ID'=>$apply['crowd_id'],'R_GF_ACCOUNT'=>0
	        	,'M_MESSAGE'=>json_encode($content,320),'M_TYPE'=>303,'S_G'=>1));
	        	}
				set_error($data,0,$reply==1?'添加成功':'已拒绝',1);
        	}
        }	
		set_error($data,1,'操作失败',1);
	}
}
