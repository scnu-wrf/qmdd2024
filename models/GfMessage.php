<?php

class GfMessage extends BaseModel {

    public function tableName() {
        return '{{gf_message}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('ID','S_GF_ID','S_GF_ACCOUNT','R_GF_ID','R_GF_ACCOUNT','S_TIME','M_MESSAGE'
            ,'M_TYPE','F_TYPE','S_LEN','S_G','IS_READ','clientType','from_msg_id','recall_time')
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array();
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
	 * 写入消息,并发出通知
	 */
	function addMsgAndSend($param) {
// 		checkArray($param,'S_GF_ID,S_GF_ACCOUNT,R_GF_ID,R_GF_ACCOUNT,M_MESSAGE,M_TYPE',1);
		$param['S_G']=empty($param['S_G'])?0:$param['S_G'];
        $param['S_TIME']=get_date();    
        $param['clientType']=7;   
	    $notify_content=$param['M_MESSAGE'];
	    $param['M_MESSAGE']=base64_encode($notify_content);
        $gf_msg =new GfMessage;
        unset($gf_msg->ID);
        $gf_msg->S_GF_ID = $param['S_GF_ID'];
        $gf_msg->S_GF_ACCOUNT = $param['S_GF_ACCOUNT'];
        $gf_msg->R_GF_ID = $param['R_GF_ID'];
        $gf_msg->R_GF_ACCOUNT = $param['R_GF_ACCOUNT'];
        $gf_msg->M_MESSAGE = $param['M_MESSAGE'];
        $gf_msg->M_TYPE = $param['M_TYPE'];
        $gf_msg->S_G = $param['S_G'];
        $gf_msg->S_TIME=get_date();
        $gf_msg->clientType = 7;
        $res=empty($gf_msg->ID)?$gf_msg->insert($gf_msg):$gf_msg->update($gf_msg);//$gf_msg->save(true,$gf_msg);
        if($res){
        	$msg_id=$gf_msg->ID;
//	     $data=array("action"=>'notify',"targetGfid"=>$param['R_GF_ID'],"sourceGfid"=>$param['S_GF_ID'],"S_G"=>$param['S_G'],
//	        "channel_id"=>$param['M_TYPE'],"lParm"=>0,"notify_content"=>$notify_content,"save_buf"=>$param['M_MESSAGE'],'msg_id'=>$msg_id);
	     	$dat= new_message_send($param['M_TYPE'],$param['S_GF_ID'],$param['R_GF_ID'],$notify_content,$param['S_G'],$msg_id);
        }
	    return json_decode($dat, true);
	}
}
