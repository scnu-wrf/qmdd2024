<?php

class GfFriendApply extends BaseModel {

    public function tableName() {
        return '{{gf_friend_apply}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array($this->safeField()),
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
	protected function beforeSave() {
        parent::beforeSave();
		
        return true;
    }

	/**
	 * 申请添加好友
	 * 写入申请记录，并向对方发出通知5
	 * ? 待考虑：1.申请是否有时限；2.申请是否可以撤销；3.申请是否可以重复
	 */
	function addRecord($param) {
		$data=get_error(1,"验证信息发送失败");
		checkArray($param,'visit_gfid,gfid,gf_account,gf_name,ask_msg',1);
		$vgf_info=userlist::model()->getUserInfo($param['visit_gfid']);
		if(empty($vgf_info)){
			set_error($data,2,'您的账号已被冻结或注销',1);
		}
		$gf_info=userlist::model()->getUserInfo($param['gfid']);
		if(empty($gf_info)){
			set_error($data,2,'对方账号已被冻结或注销',1);
		}
		$isfriend=GfGroupInfo::model()->isFriend($param);
		if($isfriend==1){
			set_error($data,100,'对方已经是您的好友',1);
		}
        $cr = new CDbCriteria;
        $cr->condition='apply_state=0 and invalid_time is null and apply_gfid='.$param['visit_gfid'].' and to_gfid = '.$gf_info['gf_id'];
        $cr->order="id desc";
        $record=$this->find($cr);
        $update=0;
        if(empty($record)){
	        $record = new GfFriendApply;
	        unset($record->id);
        	$record->apply_state = 0;
        }else{
        	$update=1;
        	$add_msg=array("apply_msg"=>$record->apply_msg,"apply_time"=>$record->apply_time);
        	if(empty($record->apply_record)){
        		$apply_record=array();
        		$apply_record[0]=$add_msg;
        	}else{
        		$apply_record=json_decode($record->apply_record,true);
        		$apply_record[count($apply_record)]=$add_msg;
        	}
        	$record->apply_record =json_encode($apply_record,320);
        }
        $record->apply_gfid = $param['visit_gfid'];
        $record->apply_account = $vgf_info['gf_account'];
        $record->apply_name = $vgf_info['gf_name'];
        $record->apply_icon = $vgf_info['gf_icon_dir'];
        $record->apply_msg = $param['ask_msg'];
        $record->apply_time=get_date();
        $record->to_gfid = $gf_info['gf_id'];
        $record->to_account = $gf_info['gf_account'];
        $record->to_name = $gf_info['gf_name'];
        $record->to_icon = $gf_info['gf_icon_dir'];
        $res=$update==1?$record->update($record):$record->insert($record);	
        $data['apply_id']=$record->id;
        $data['apply_time']=$record->apply_time;
        if($res){//S_GF_ID,S_GF_ACCOUNT,R_GF_ID,R_GF_ACCOUNT,M_MESSAGE,M_TYPE,S_G
        	$content=array('id'=>$data['apply_id'],'s_gfid'=>$vgf_info['gf_id'],'s_gfaccount'=>$vgf_info['gf_account'],'s_nick'=>$vgf_info['gf_name'],'s_head'=>$vgf_info['gf_icon'],'s_sex'=>$vgf_info['sex'],'s_requestBuf'=>'','s_msg'=>$param['ask_msg'],'section_code'=>'A01',"section_name"=>"好友通知","title"=>$vgf_info['gf_account'].'/'.$vgf_info['gf_name']."申请添加好友","content"=>$param['ask_msg']);
        	$notify=GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>$vgf_info['gf_id'],'S_GF_ACCOUNT'=>$vgf_info['gf_account']
        	,'R_GF_ID'=>$gf_info['gf_id'],'R_GF_ACCOUNT'=>$gf_info['gf_account']
        	,'M_MESSAGE'=>base64_encode(json_encode($content,320)),'M_TYPE'=>5,'S_G'=>0));
        }
		set_error_tow($data,$res,0,'验证信息发送成功',1,'验证信息发送失败',1);
	}
	
	/**
	 * 回复添加好友申请
	 * 修改回复状态，同意-添加好友，并发送通知6，不同意-发送通知336
	 */
	public function Reply($param){
		$data=get_error(1,"操作失败");
		checkArray($param,'visit_gfid,id,reply',1);
        $reply=$param['reply'];//1-agree,2-refuse
		$where="id=".$param['id'];
        $cr = new CDbCriteria;
        $cr->condition=$where;
        $apply=$this->find($cr,array(),false);
        if(!empty($apply)&&$apply['apply_state']==0&&$param['visit_gfid']==$apply['to_gfid']){
    		if($reply==1){
    			$re_data=GfGroupInfo::model()->addFriend($apply['apply_gfid'],$apply['to_gfid']);
    			if($re_data['error']!=0){
    				set_error($data,$re_data['error'],$re_data['msg'],1);
    			}
    		}
        	$res=$this->updateAll(array('apply_state'=>$reply,'reply_time'=>get_date()),$where);
        	if($res){
        		$content=array('id'=>$param['id'],'s_gfid'=>$apply['to_gfid'],'s_nick'=>$apply['to_name'],'s_head'=>getShowUrl('file_path_url').$apply['to_icon'],'section_code'=>'A01',"section_name"=>"好友通知","title"=>$apply['to_account'].'/'.$apply['to_name'].($reply==1?'同意':'拒绝')."添加好友");
        	$notify=GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>$apply['to_gfid'],'S_GF_ACCOUNT'=>$apply['to_account']
        	,'R_GF_ID'=>$apply['apply_gfid'],'R_GF_ACCOUNT'=>$apply['apply_account']
        	,'M_MESSAGE'=>json_encode($content,320),'M_TYPE'=>$reply==1?6:336,'S_G'=>0));
				set_error($data,0,$reply==1?'添加成功':'已拒绝',1);
        	}
        }
        if(!empty($apply)&&$apply['apply_state']==$reply){
        	set_error($data,0,$reply==1?'添加成功':'已拒绝',1);
        }	
		set_error($data,1,'操作失败',1);
	}
	/**
	 * 新朋友记录（待操作的申请记录（用户申请加好友／其他会员向该用户申请加好友））
	 */
	public function getAddFriend($param){
		$data=get_error(1,"获取失败");
		checkArray($param,'visit_gfid',1);
		$cr = new CDbCriteria;
        $cr->condition="apply_state=0 and invalid_time is null and (apply_gfid=".$param['visit_gfid']." or to_gfid=".$param['visit_gfid'].")";
//        $cr->select="apply_gfid,apply_account,apply_name,apply_icon,apply_msg as ask_msg,apply_state as state,apply_time as add_date,invalid_time as out_of_date,to_gfid as gfid,to_account as gf_account,to_name as gf_name,to_icon as gf_icon";
//        $datas1=$this->findAll($cr,array(),false);
//        $cr->union="select * from gf_friend_apply where apply_state=0 and to_gfid=".$param['visit_gfid'];
        $cr->order=" id desc";
        $datas=$this->findAll($cr,array(),false);
        $url=getShowUrl('file_path_url');
        foreach($datas as $k=>$v){
        	$datas[$k]['ask_msg']=$v['apply_msg'];
        	$datas[$k]['apply_icon']=$url.$v['apply_icon'];
        	$datas[$k]['to_icon']=$url.$v['to_icon'];
        	$datas[$k]['invalid_time']=empty($v['invalid_time'])?'':$v['invalid_time'];
        }
        $data['datas']=$datas;
		set_error($data,0,'获取成功',1);
	}
}
