<?php

class GfCrowdMember extends BaseModel {

    public function tableName() {
        return '{{gf_crowd_member}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('ID,CROWD_ID,GF_ID,GF_ACCOUNT,MEMBER_JOIN_TIME,MEMBER_ADMIN,MEMBER_MARK,MEMBER_MEMO,MEMBER_SET,MEMBER_READED_LAST_ID,MEMBER_READED_LAST_ID_IPHONE,MEMBER_READED_LAST_ID_PC,MEMBER_READED_LAST_ID_MAC,MEMBER_READED_LAST_ID_IPAD,MEMBER_READED_LAST_ID_APAD,MEMBER_READED_LAST_ID_OTHER','safe'),
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
     * 群成员信息
     */
	public function CrowdMemberInfo($gfid,$crowd_id){
        $where="CROWD_ID=".$crowd_id." and GF_ID=".$gfid;
        return $this->find($where);
	}
	
 	/**
     * 是否群成员
     * @return -1不是群成员；0-普通成员，2-群主
     */
	public function isCrowdMember($gfid,$crowd_id){
		$data=get_error(1,"获取失败");
        $where="CROWD_ID=".$crowd_id." and GF_ID=".$gfid;
        $member=$this->find($where);
        return empty($member)?-1:$member['MEMBER_ADMIN'];
	}
	
	
 	/**
     * 群成员
     */
	public function getCrowdMember($param){
		$data=get_error(1,"获取失败");
		checkArray($param,'visit_gfid,crowd_id',1);
		$cr = new CDbCriteria;
        $cr->condition="CROWD_ID =".$param['crowd_id'];
        $cr->join=" join userlist on userlist.GF_ID=t.GF_ID";
        $cr->select="t.ID as id,t.GF_ID as gfid,t.MEMBER_MARK as gf_name,userlist.GF_ACCOUNT as gf_account,userlist.TXNAME as gf_icon,MEMBER_ADMIN as crowd_member_admin";
        $datas=$this->findAll($cr,array(),false);
        $url=getShowUrl('file_path_url');
        foreach($datas as $k=>$v){
        	$datas[$k]['gf_icon']=$url.$v['gf_icon'];
        }
        $data['datas']=$datas;
		set_error_tow($data,count($datas),0,'获取成功',0,'该群已解散',1);
	}
	
	/**
	 * 群成员加入
	 */
	public function addMember($gfid,$crowd_id){
		$gf_info=userlist::model()->getUserInfo($gfid);
		if(empty($gf_info)){
			return array('error'=>2,'msg'=>'对方账号已被冻结或注销');
		}
        $crowd_info=GfCrowdBase::model()->CrowdInfo($crowd_id);
        if(empty($crowd_info)){
        	return array('error'=>3,'msg'=>'该群已解散');
        }
        $is_member=$this->isCrowdMember($gfid,$crowd_id);
        if($is_member!=-1){
        	return array('error'=>0,'msg'=>'已是该群成员');
        }
        $last_msg=GfMessage::model()->find('S_G=1 and R_GF_ID='.$crowd_id.' order by ID desc');
        $last_msg_id=empty($last_msg)?0:$last_msg['ID'];
        
		$record = new GfCrowdMember;
	    unset($record->ID);
    	$record->CROWD_ID = $crowd_id;
    	$record->GF_ID = $gfid;
    	$record->GF_ACCOUNT = $gf_info['gf_account'];
    	$record->MEMBER_JOIN_TIME = get_date();
    	$record->MEMBER_ADMIN = 0;
    	$record->MEMBER_MARK = $gf_info['gf_name'];
    	$record->MEMBER_READED_LAST_ID = $last_msg_id;
    	$record->MEMBER_READED_LAST_ID_IPHONE = $last_msg_id;
    	$record->MEMBER_READED_LAST_ID_PC = $last_msg_id;
    	$record->MEMBER_READED_LAST_ID_MAC = $last_msg_id;
    	$record->MEMBER_READED_LAST_ID_IPAD = $last_msg_id;
    	$record->MEMBER_READED_LAST_ID_APAD = $last_msg_id;
    	$record->MEMBER_READED_LAST_ID_OTHER = $last_msg_id;
    	$add=$record->insert($record);	
	    if($add){
	        return array('error'=>0,'msg'=>'添加成功');
	    }else{
            return array('error'=>4,'msg'=>'添加失败');
	    }
	}
	
 	/**
     * 删除群成员
     * 删除群成员信息，并发送通知303到群，通知311到被删除的群成员账号
     */
	public function deleteCrowdMember($param){
		$data=get_error(1,"删除失败");
		checkArray($param,'visit_gfid,delete_gfid,crowd_id',1);
		$crowd_id=$param['crowd_id'];
		$gfid=$param['delete_gfid'];
        $crowd=GfCrowdBase::model()->CrowdInfo($crowd_id);
		if(empty($crowd)){
			set_error($data,1,'该群已不存在',1);
		}
		if($this->isCrowdMember($param['visit_gfid'],$crowd_id)!=2){
			set_error($data,1,"目前只支持群主删除群成员",1);
		}
        $where="CROWD_ID=".$crowd_id." and GF_ID in(".$gfid.")";
        $members=$this->findAll($where);
        $res=$this->deleteAll($where);
        if($res){	
        $content=array("crwod_id"=>$crowd_id,"crowd_id"=>$crowd_id,"member_type"=>0,'crowd_name'=>$crowd['BASE_NAME'],'crowd_icon'=>getShowUrl('file_path_url').$crowd['BASE_IMG'],'section_code'=>'A02',"section_name"=>"群通知");
        	$content['BASE_NAME']=$content['crowd_name'];
        	$content['BASE_IMG']=$content['crowd_icon'];
        	$content['BASE_NUMBER']='';
        foreach($members as $k=>$member){
        	$content['gf_id']=$member['GF_ID'];
        	$content['gf_account']=$member['GF_ACCOUNT'];
        	$content['gf_name']=$member['MEMBER_MARK'];
        	$content['title']=$member['MEMBER_MARK']." 已被移出群";
        	$content['gfid']=$content['gf_id'];
        	$content['gfaccount']=$content['gf_account'];
        	$content['gfnick']=$content['gf_name'];
        	$notify=GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>$member['GF_ID'],'S_GF_ACCOUNT'=>$member['GF_ACCOUNT']
        	,'R_GF_ID'=>$crowd_id,'R_GF_ACCOUNT'=>0
        	,'M_MESSAGE'=>base64_encode(json_encode($content,320)),'M_TYPE'=>303,'S_G'=>1));
			//同时向目标GFID发出311
        	$content['title']="您已被移出群 ".$content['crowd_name'];
        	$notify=GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>0,'S_GF_ACCOUNT'=>0
        	,'R_GF_ID'=>$member['GF_ID'],'R_GF_ACCOUNT'=>$member['GF_ACCOUNT']
        	,'M_MESSAGE'=>base64_encode(json_encode($content,320)),'M_TYPE'=>311,'S_G'=>0));
        }
        }
        set_error_tow($data,$res,0,"删除成功",1,"删除失败",1);
	}
 	/**
     * 群成员退出群
     * 删除群成员信息，并发送通知303到群，通知311到申请方（多端登陆时才发送）
     */
	public function MemberDeleteCrowd($param){
		$data=get_error(1,"退群失败");
		checkArray($param,'visit_gfid,crowd_id',1);
		$crowd_id=$param['crowd_id'];
		$gfid=$param['visit_gfid'];
        $crowd=GfCrowdBase::model()->CrowdInfo($crowd_id);
		if(empty($crowd)){
			set_error($data,1,'该群已不存在',1);
		}
        $where="CROWD_ID=".$crowd_id." and GF_ID=".$gfid;
        $member=$this->find($where);
		if(empty($member)){
			set_error($data,0,'已退群',1);
		}
		$res=$this->deleteAll($where);
        if($res){
        	$content=array("crwod_id"=>$crowd_id,"crowd_id"=>$crowd_id,"member_type"=>0,'crowd_name'=>$crowd['BASE_NAME'],'crowd_icon'=>getShowUrl('file_path_url').$crowd['BASE_IMG'],'gf_id'=>$gfid,'gf_account'=>$member['GF_ACCOUNT'],'gf_name'=>$member['MEMBER_MARK'],'section_code'=>'A02',"section_name"=>"群通知","title"=>$member['MEMBER_MARK']." 已退出群");
        	$content['BASE_NAME']=$content['crowd_name'];
        	$content['BASE_IMG']=$content['crowd_icon'];
        	$content['BASE_NUMBER']='';
        	$content['gfid']=$content['gf_id'];
        	$content['gfaccount']=$content['gf_account'];
        	$content['gfnick']=$content['gf_name'];
        	$notify=GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>$gfid,'S_GF_ACCOUNT'=>$member['GF_ACCOUNT']
        	,'R_GF_ID'=>$crowd_id,'R_GF_ACCOUNT'=>0
        	,'M_MESSAGE'=>base64_encode(json_encode($content,320)),'M_TYPE'=>303,'S_G'=>1));
			//同时向目标GFID发出311
        	$content['title']="您已退出群 ".$content['crowd_name'];
        	$notify=GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>0,'S_GF_ACCOUNT'=>0
        	,'R_GF_ID'=>$gfid,'R_GF_ACCOUNT'=>$member['GF_ACCOUNT']
        	,'M_MESSAGE'=>base64_encode(json_encode($content,320)),'M_TYPE'=>311,'S_G'=>0));
        }
        set_error_tow($data,$res,0,"退群成功",1,"退群失败",1);
	}
	
	/**
     * 群成员昵称设置
     */
	public function setCrowdMemberName($param){
		$data=get_error(1,"设置失败");
		checkArray($param,'visit_gfid,crowd_id,member_name',1);
		$crowd_id=$param['crowd_id'];
		$gfid=$param['visit_gfid'];
        $crowd=GfCrowdBase::model()->CrowdInfo($crowd_id);
		if(empty($crowd)){
			set_error($data,1,'该群已不存在',1);
		}
        $where="CROWD_ID=".$crowd_id." and GF_ID=".$gfid;
        $member=$this->find($where);
		if(empty($member)){
			set_error($data,2,'该成员已退群',1);
		}
		$member->MEMBER_MARK=$param['member_name'];
		$res=$crowd->update($crowd);
		set_error_tow($data,$res,0,'设置成功',0,'设置失败',1);
	}
}
