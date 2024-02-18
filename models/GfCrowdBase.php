<?php

class GfCrowdBase extends BaseModel {

    public function tableName() {
        return '{{gf_crowd_base}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('ID,BASE_CREATE_GFID,BASE_NAME,BASE_MARK,BASE_INTRO,BASE_IMG,BASE_NUMBER,BASE_NNT,BASE_TYPE,BASE_VERSION,uDate,encryption,if_del','safe'),
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
        return array(
            'ID' => 'ID',
            'BASE_CREATE_GFID' => '群组创建者的GFID',
            'BASE_NAME' => '群组名称',
            'BASE_MARK' => '群组标签',
            'BASE_INTRO' => '群组简介',
            'BASE_IMG' => '群组头像  路径：http://upload.gf41.net/crowd_head/',
            'BASE_NUMBER' => '群号码',
            'BASE_NNT' => '群当前人数',
            'BASE_TYPE' =>  '群类型，0普通 1社区群 2其它',
            'BASE_VERSION' => '群更新版本号',
            'uDate' => '创建时间',
            'encryption' => '加密密钥AES',
            'if_del' => '是否删除，关联base_code表DATA类型 509-逻辑删除 510正常',
        );
    }
    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
	}

 	/**
     * 群信息
     */
	public function CrowdInfo($crowd_id){
        $where="ID=".$crowd_id;
        return $this->find($where);
	}
	
	/**
	 * 创建群
	 * 写入群资料，群成员信息（群主）
	 */
	public function createCrowd($param){
		$data=get_error(1,"创建失败");
		checkArray($param,'visit_gfid,crowd_name',1);
		$gfid=$param['visit_gfid'];
		$gf_info=userlist::model()->getUserInfo($gfid);
		if(empty($gf_info)){
			set_error($data,2,'创建失败，账号已被冻结或注销。',1);
		}
        $where="BASE_NAME='".$param['crowd_name']."'";
        $crowd= $this->find($where);
		if(!empty($crowd)){
			set_error($data,1,'群名已被使用，创建失败！',1);
		}
		$add=new GfCrowdBase;
		unset($add->ID);
		$add->BASE_CREATE_GFID=$param['visit_gfid'];
		$add->BASE_NAME=$param['crowd_name'];
		$add->encryption=md5($param['visit_gfid'].$param['crowd_name'].time());
		$add->uDate=get_date();
		$res=$add->insert($add);
		if ($res) {
			$member_add=new GfCrowdMember;
			unset($member_add->ID);
			$member_add->CROWD_ID=$add->ID;
			$member_add->GF_ID=$param['visit_gfid'];
			$member_add->MEMBER_JOIN_TIME=$add->uDate;
			$member_add->MEMBER_ADMIN=2;
			$member_add->GF_ACCOUNT=$gf_info['gf_account'];
			$member_add->MEMBER_MARK=$gf_info['gf_name'];
			$res=$member_add->insert($member_add);
			$data['crowd_id'] = $add->ID;
			$data['aes_key']=$add->encryption;
			set_error($data,0,"创建群成功！",1);
		} else {
			set_error($data,3,"创建群失败！",1);
		}
	}
 	/**
     * 群列表
     */
	public function getCrowd($param){
		$data=get_error(1,"获取失败");
		checkArray($param,'visit_gfid',1);
		$gfid=$param['visit_gfid'];
		
		$cr = new CDbCriteria;
        $cr->condition="GF_ID='".$gfid."'";
        $cr->select="group_concat(distinct CROWD_ID) as crowd_ids";
		$join_crowd=GfCrowdMember::model()->find($cr,array(),false);
        $cr->condition="(BASE_CREATE_GFID='".$gfid."'";
        if(!empty($join_crowd)&&!empty($join_crowd['crowd_ids'])){
        	$cr->condition.=" or ID in(".$join_crowd['crowd_ids'].")";
        }
        $cr->condition.=")";
        $cr->select="ID as crowd_id,BASE_NAME as crowd_name,BASE_IMG as crowd_icon,BASE_CREATE_GFID as creater_gfid,BASE_NNT as member_num,encryption as aes_key";
        $datas=$this->findAll($cr,array(),false);
        $url=getShowUrl('file_path_url');
        foreach($datas as $k=>$v){
        	$datas[$k]['crowd_icon']=$url.$v['crowd_icon'];
        }
        $data['datas']=$datas;
		set_error_tow($data,count($datas),0,'获取成功',0,'无️群信息',1);
	}
	
	/**
	 * 群资料
	 */
	function getCrowdInfo($param){
		$data=get_error(1,"获取失败");
		checkArray($param,'visit_gfid,crowd_id',1);
		$cr = new CDbCriteria;
        $cr->condition="ID=".$param['crowd_id'];
        $cr->select="ID,BASE_NAME,BASE_IMG,crowd_bg,BASE_NNT,BASE_CREATE_GFID,encryption";
        $crowd=$this->find($cr);
		if(empty($crowd)){
			set_error($data,1,'该群已不存在',1);
		}
		$url=getShowUrl('file_path_url');
		$data['datas']=array();
		$data['datas']['crowd_id']=$crowd->ID;
		$data['datas']['crowd_name']=$crowd->BASE_NAME;
		$data['datas']['crowd_icon']=$url.$crowd->BASE_IMG;
		$data['datas']['crowd_bg']=$url.$crowd->crowd_bg;
		$data['datas']['crowd_member_num']=$crowd->BASE_NNT;
		$data['datas']['creater_gfid']=$crowd->BASE_CREATE_GFID;
		$data['datas']['crowd_member_admin']=-1;
		$member=GfCrowdMember::model()->CrowdMemberInfo($param['visit_gfid'],$param['crowd_id']);
		if(!empty($member)){
			$data['datas']['aes_key']=$crowd->encryption;
			$data['datas']['crowd_member_memo']=$member->MEMBER_MARK;
			$data['datas']['crowd_dont_disturb']=$member->MESSAGE_SET;
			$data['datas']['crowd_member_admin']=$member->MEMBER_ADMIN;
		}
		set_error($data,0,"获取成功",1);
	}
	
 	/**
     * 查找群
     */
	public function searchCrowd($param){
		$data=get_error(1,"获取失败");
		checkArray($param,'visit_gfid,keyword,page,per_page',1);
        $page=empty($param['page'])||$param['page']<1?1:$param['page']; //第几页
        $_GET['page']=$page;
        $pageSize=empty($param['per_page'])?0:$param['per_page'];       //每页条数
		$cr = new CDbCriteria;
        $cr->condition="BASE_NAME like '%".$param['keyword']."%'";
        $cr->select="ID as crowd_id,BASE_NAME as crowd_name,BASE_IMG as crowd_icon,BASE_NNT as member_num";
        $count = $this->count($cr);
        $pages = new CPagination($count);
        $pages->pageSize = $pageSize;
        $pages->applylimit($cr);
        $datas=$this->findAll($cr,array(),false);
        $url=getShowUrl('file_path_url');
        foreach($datas as $k=>$v){
        	$datas[$k]['crowd_icon']=$url.$v['crowd_icon'];
        }
        $data['datas']=$datas;
        $data['total_count'] = $count;
		set_error_tow($data,$count,0,'获取成功',0,'未查找到相关群信息',1);
	}
	/**
     * 群主修改群名称、群头像、群背景
     * type（1-名称，2-头像URL地址，3-背景图URL地址）
     */
	public function editCrowd($param){
		$data=get_error(1,"设置失败");
		checkArray($param,'visit_gfid,crowd_id,type,content',1);
        $where="ID=".$param['crowd_id'];
        $crowd= $this->find($where);
		if(empty($crowd)){
			set_error($data,1,'该群已不存在',1);
		}
		$type=$param['type'];
		$content=$param['content'];
        $url=getShowUrl('file_path_url');
		switch($type){
			case 1:
			if($content==$crowd->BASE_NAME){
				set_error($data,0,'设置成功',1);
			}else{
				$where="BASE_NAME='".$content."'";
        		$ocrowd= $this->find($where);
        		if(!empty($ocrowd)){
        			set_error($data,1,'设置失败，群名已被使用',1);
        		}
			}
			$crowd->BASE_NAME=$content;
			break;
			case 2:
			$crowd->BASE_IMG=str_replace($url,"",$content);
			break;
			case 3:
			$crowd->crowd_bg=str_replace($url,"",$content);
			break;
		}
		$res=$crowd->update($crowd);
		set_error_tow($data,$res,0,'设置成功',0,'设置失败',1);
	}
	
 	/**
     * 群主解散群
     */
	public function deleteCrowd($param){
		$data=get_error(1,"操作失败");
		checkArray($param,'visit_gfid,crowd_id',1);
		$crowd_id=$param['crowd_id'];
		$gfid=$param['visit_gfid'];
        $where="ID=".$crowd_id;
        $crowd= $this->find($where);
		if(empty($crowd)){
			set_error($data,0,"群已解散",1);
		}
        $where="MEMBER_ADMIN=2 and CROWD_ID=".$crowd_id." and GF_ID=".$gfid;
        $member=GfCrowdMember::model()->find($where);
		if(empty($member)){
			set_error($data,2,'无权限操作',1);
		}
        $res=GfCrowdMember::model()->deleteAll("CROWD_ID=".$crowd_id);
        if($res){
        	$res=$this->delete("ID=".$crowd_id);
        	$content=array("crwod_id"=>$crowd_id,"crowd_id"=>$crowd_id,'crowd_name'=>$crowd['BASE_NAME'],'section_code'=>'A02',"section_name"=>"群通知","title"=>$crowd['BASE_NAME']." 已解散");
        	$notify=GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>$gfid,'S_GF_ACCOUNT'=>$member['GF_ACCOUNT']
        	,'R_GF_ID'=>$crowd_id,'R_GF_ACCOUNT'=>0
        	,'M_MESSAGE'=>base64_encode(json_encode($content,320)),'M_TYPE'=>305,'S_G'=>1));
        }
        set_error_tow($data,$res,0,$crowd['BASE_NAME']."群已解散",1,"解散群失败",1);
	}
}
