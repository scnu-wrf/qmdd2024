<?php

class GfGroupInfo extends BaseModel {

    public function tableName() {
        return '{{gf_group_info_1}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('ID','GF_ID','GF_MEMO_NAME','GP_ID','gf_gfid','is_look','is_show','encryption'),
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
	 * 两会员是否互为好友；一方为好友，另一方不为好友是为非好友；
	 * @return 0-非好友，1-互为好友,2-对方在自己的好友列表
	 */
	function isFriend($param) {
		checkArray($param,'visit_gfid,gfid',1);
        $cr = new CDbCriteria;
        $cr->condition="GF_ID=".$param['gfid']." and gp_gfid=".$param['visit_gfid'];
        $cr->select="id";
        $datas=$this->find($cr,array(),false);
        if(empty($datas)){
        	return 0;
        }
        $cr->condition="GF_ID=".$param['visit_gfid']." and gp_gfid=".$param['gfid'];
        $cr->select="id";
        $datas=$this->find($cr,array(),false);
        if(empty($datas)){
        	return 2;
        }
        return 1;
	}

	/**
	 * 加为好友
	 * 好友表gf_group_info_1（gp_gfid用户，GF_ID好友）；
	 * 需要相互都有好友记录
	 */
	public function addFriend($gf_id,$tgf_id) {
		$gf_info=userlist::model()->getUserInfo($gf_id);
		if(empty($gf_info)){
			return array('error'=>2,'msg'=>'对方账号被冻结或已注销');
		}
	    $gp_id=GfGroup::model()->getGP($gf_id);
	    $tgp_id=GfGroup::model()->getGP($tgf_id);
        if($gp_id<=0||$tgp_id<=0){
            return array('error'=>5,'msg'=>'添加好友失败');
        }
        $encryption=md5($gf_id.time().$tgf_id);
		
    	$record = $this->find('gp_gfid='.$gf_id.' and GF_ID='.$tgf_id);
    	if(empty($record)){
	    	$record = new GfGroupInfo;
	    	unset($record->ID);
    	}
    	$record->GF_ID = $tgf_id;
    	$record->GF_MEMO_NAME = '';
    	$record->GP_ID = $gp_id;
    	$record->gp_gfid = $gf_id;
    	$record->encryption = $encryption;
    	$add=empty($record->ID)?$record->insert($record):$record->update($record);//$record->save(true,$record);
	    if($add){
	    	$record = $this->find('gp_gfid='.$tgf_id.' and GF_ID='.$gf_id);
	    	if(empty($record)){
		    	$record = new GfGroupInfo;
		    	unset($record->ID);
	    	}
	    	$record->GF_ID = $gf_id;
	    	$record->GF_MEMO_NAME = '';
	    	$record->GP_ID = $tgp_id;
	    	$record->gp_gfid = $tgf_id;
	    	$record->encryption = $encryption;
	    	$tadd=empty($record->ID)?$record->insert($record):$record->update($record);//$record->save(true,$record);
	        if($tadd){
            	return array('error'=>0,'msg'=>'添加好友成功');
	        }
            return array('error'=>3,'msg'=>'添加好友失败');
	    }else{
            return array('error'=>4,'msg'=>'添加好友失败');
	    }
	}

	/**
	 * 删除好友 （将申请者好友列表中移除该会员，对方好友列表不变，发送通知7-删除好友）
	 */
	public function delFriend($param) {
		$data=get_error(1,"删除失败");
		checkArray($param,'visit_gfid,gfid,gf_account',1);
		$gf_info=userlist::model()->getUserInfo($param['visit_gfid'],0);
		if(empty($gf_info)){
			set_error($data,1,'删除失败',1);
	    }
		$where='gp_gfid='.$param['visit_gfid'].' and GF_ID='.$param['gfid'];
		$pre=$this->find($where);
		if(empty($pre)){
			$del=1;
		}else{
			$del = $this->deleteAll($where);
		}
		$gwhere='gp_gfid='.$param['gfid'].' and GF_ID='.$param['visit_gfid'];
    	$record = $this->find($gwhere);
    	if(!empty($record)){
    		$delkey=empty($record->encryption)?1:$this->updateByPk($record->ID,array('encryption'=>''));
    	}
	    if($del&&!empty($delkey)){
	    	$content=array('s_gfid'=>$param['visit_gfid'],'s_nick'=>$gf_info['gf_name'],'s_head'=>getShowUrl('file_path_url').$gf_info['gf_icon']);
        	$notify=GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>$param['visit_gfid'],'S_GF_ACCOUNT'=>$gf_info['gf_account']
        	,'R_GF_ID'=>$param['gfid'],'R_GF_ACCOUNT'=>$param['gf_account']
        	,'M_MESSAGE'=>json_encode($content,320),'M_TYPE'=>7,'S_G'=>0));
	    }
		set_error($data,0,'删除成功',1);
	}
	
	/**
	 * 会员基本资料
	 * 昵称／账号／头像/性别/年龄／地址（国省市）/个性签名/兴趣爱好／动动圈背景图/该用户在动动圈发布的图片信息（最后一条）/gf_memo_name（好友备注名）
islook//设置是否查看该好友动动圈信息(0表示查看/1表示不查看) 
is_show//该好友是否能查看自己小世界信息 0-查看 1-不查看
isshow//是否显示动动圈信息(1显示/0不显示)
	 */
	public function getFriendInfo($param) {
		$data=get_error(1,"获取失败");
		checkArray($param,'visit_gfid,gfid',1);
		$gf_info=userlist::model()->getUserInfo($param['gfid'],0);
		if(empty($gf_info)){
			set_error($data,1,'获取失败',1);
	    }
        unset($gf_info['gf_icon_dir']);
		$gf_info['isshow']=0;
        $cr = new CDbCriteria;
        $cr->condition="GF_ID=".$param['gfid']." and gp_gfid=".$param['visit_gfid'];
        $cr->select="ID,GF_MEMO_NAME,is_look,is_show,encryption";
        $friend=$this->find($cr);
        if(!empty($friend)){
	        $gf_info['gf_memo_name']=$friend->GF_MEMO_NAME;
	        $gf_info['is_friend']=0;
	        if(!empty($friend->encryption)){
	        	$cr->condition="GF_ID=".$param['visit_gfid']." and gp_gfid=".$param['gfid'];
		        $gfriend=$this->find($cr);
		        if(!empty($gfriend)){
		        	$gf_info['is_friend']=1;
		        	$gf_info['aes_key']=$friend->encryption;
		        	$gf_info['is_look']=$friend->is_look;
		        	$gf_info['is_show']=$friend->is_show;
		        	$gf_info['isshow']=$friend->is_look==0&&$gfriend->is_show==0?1:0;
		        	$gf_info['mood_pic']=JlbMoods::model()->getLastMoodPic($param['gfid'],$param['visit_gfid']);
		        	$gf_info['mood_pic']=CommonTool::model()->addto_url_dir(getShowUrl('file_path_url'),$gf_info['mood_pic'],'|',',');
		        }
	        }
        }
        $data['datas']=$gf_info;
	    set_error($data,0,'获取成功',1);
	}
	
	/**
	 * 获取好友列表
	 */
	public function getAllFriend($param) {
		$data=get_error(1,"获取失败");
		checkArray($param,'visit_gfid',1);
        $cr = new CDbCriteria;
        $cr->condition="t.gp_gfid=".$param['visit_gfid'];
        $cr->join = "JOIN userlist on userlist.GF_ID=t.GF_ID and ".userlist::model()->UserSql(0,1,'userlist');
        $cr->group = 't.GF_ID';
        $cr->select="t.GF_ID as gfid,t.GF_MEMO_NAME gf_memo_name,t.encryption as aes_key,userlist.GF_NAME as gf_name,userlist.GF_ACCOUNT as gf_account,userlist.TXNAME as gf_icon,userlist.GRQM as grqm,userlist.CLIENTVER as version";
        $list=$this->findAll($cr,array(),false);
        $datas=array();
        foreach($list as $k=>$v){
	        $v['gf_icon']=getShowUrl('file_path_url').$v['gf_icon'];
        	$datas[$k]=$v;
        }
        $data['datas']=$datas;
	    set_error($data,0,'获取成功',1);
	}
	
	/**
	 * 设置好友备注名
	 */
	public function setFriendMemo($param) {
		$data=get_error(1,"设置失败");
		checkArray($param,'visit_gfid,gfid,gf_memo_name',1);
        $cr = new CDbCriteria;
        $cr->condition="GF_ID=".$param['visit_gfid']." and gp_gfid=".$param['gfid'];
        $cr->select="id";
        $datas=$this->find($cr,array(),false);
        if(empty($datas)){
        	set_error($data,5,'设置失败，你已经不是对方的好友',1);
        }
        $where="GF_ID=".$param['gfid']." and gp_gfid=".$param['visit_gfid'];
        $friend=$this->find($where);
        if(empty($friend)){
        	set_error($data,5,'设置失败，你已经不是对方的好友',1);
        }
        if($friend->GF_MEMO_NAME==$param['gf_memo_name']){
        	set_error($data,0,'设置成功',1);
        }
        $friend->GF_MEMO_NAME=$param['gf_memo_name'];
        $tadd=$friend->update($friend);
		set_error_tow($data,$tadd,0,'设置成功',1,'设置失败',1);
	}
	/**
	 * 设置好友查看动动圈权限
	 */
	public function setFriendMood($param) {
		$data=get_error(1,"设置失败");
		checkArray($param,'visit_gfid,gfid',1);
        $cr = new CDbCriteria;
        $cr->condition="GF_ID=".$param['visit_gfid']." and gp_gfid=".$param['gfid'];
        $cr->select="id";
        $datas=$this->find($cr,array(),false);
        if(empty($datas)){
        	set_error($data,5,'设置失败，你已经不是对方的好友',1);
        }
        $where="GF_ID=".$param['gfid']." and gp_gfid=".$param['visit_gfid'];
        $friend=$this->find($where);
        if(empty($friend)){
        	set_error($data,5,'设置失败，你已经不是对方的好友',1);
        }
        if($friend->is_look==$param['is_look']&&$friend->is_show==$param['is_show']){
        	set_error($data,0,'设置成功',1);
        	
        }
        if($param['is_look']!=-1){
        	$friend->is_look=$param['is_look'];
        }
        if($param['is_show']!=-1){
        	$friend->is_show=$param['is_show'];
        }
        $tadd=$friend->update($friend);
		set_error_tow($data,$tadd,0,'设置成功',1,'设置失败',1);
	}
	
}
