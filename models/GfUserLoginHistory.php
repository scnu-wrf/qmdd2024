<?php

class GfUserLoginHistory extends BaseModel {

    public $location ='';
    public function tableName() {
        return '{{gf_user_login_history}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('id,type,gf_id,login_ip,login_time,login_address,gf_login_client,client_device_code,login_dev,client_version,encryption', 'safe'),
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
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        parent::beforeSave();
        
        if ($this->isNewRecord) {
            
            $this->login_time = date('Y-m-d H:i:s');
        }
        
        return true;
    }
	
    
    /**
     * 返回最新登录设备ID
     */
    function getLoginDev($gfid, $type) {
         return $this->get_value_last("gf_id={$gfid} and gf_login_client={$type}",'login_dev');
    }

    /**
     * 获得登录记录的密
     * 返回 访问动态密钥
     */
   public function get_encryption($gf_id){
     return $this->get_value_last('gf_id='.$gf_id,'encryption');
    }

   /**
     * 获得登录记录的密
     * 返回 访问动态密钥
     */
   public function get_encryption_by_ip($gf_id,$ip){
     return $this->get_value_last('gf_id='.$gf_id.' and login_ip','encryption');
    }

   public function get_value_last($w1,$field){
     $tmp=$this->find($w1.' order by id desc');
     $rs="";
     if(!empty($tmp)){
       $rs=$tmp[$field];
     }
     return $rs;
    }
    
    /**
     * 插入登录设备记录
     * 返回 访问动态密钥
     */
    function addLoginLog($param) {
        global $p_common_tool;
        $ip = $p_common_tool->get_client_ip();
        $login_time=parent::get_now_datetime();
        $param['login_ip']=$ip;
        $param['login_time']=$login_time;
        $param['type']=empty($param['gf_id'])?0:$param['type'];
        $param['client_version']=empty($param['client_version'])?"":$param['client_version'];
        $param['login_dev']=empty($param['login_dev'])?$_SERVER['HTTP_USER_AGENT']:$param['login_dev'];
        $param['encryption']=md5($param['gf_id'].$ip.microtime());
        $res = parent :: insertItem($param);
        if (empty ($address)) {
            $address_list = parent :: get_data_list("login_ip='{$ip}' and IFNULL(login_address,'')<>''", "login_address", "", "", 0, 0, "login_address");
            $address = count($address_list) > 0 ? $address_list[0]['login_address'] : "";
            if (empty ($address)) {
                $address_json=$p_common_tool->GetIpLookup($ip);
                $address = $address_json['code'] == 0 ? $address_json['country'] . ':' . $address_json['region'] . ':' . $address_json['city'] . ':' . $address_json['county'] : "";
            }
            if(!empty($address)){
                parent :: update('login_address,'.$address,"login_ip='{$ip}'");
            }
        }
        return array('id'=>$res,"login_sign_key"=>($res?$param['encryption']:0));
    }

    /**
     * 获取访问密钥
     */
    function getLoginKey($id,$array=0,$limit=0,$gfid=0){
		if(empty($id)&&empty($gfid)){
			return "";
		}
        $cl = new CDbCriteria() ; 
		if(empty($id)&&!empty($gfid)){
			$cl->condition="gf_id=".$gfid;
		}else{
			$cl->condition="id=".$id;
		}
        $cl->order = 'id desc';
        $list=$this->findAll($cl);
        $list=cArray($list,"id as visit_id,type as visit_type,gf_id as visit_gfid,gf_login_client as device_type,login_dev,client_version,encryption as visit_key");
		$param=array();
		if($array==1&&count($list)>0){
			$param=$list[0];
			return $param;
		}
		if($array==1){
			return count($list)==0?array():$list[0];
		}
		if(count($list)==0||($limit==1&&time()-strtotime($list[0]['login_time'])>24*3600)){
			return "";
		}else{
			return $list[0]['visit_key'];
		}
    }
    
    /**
     * 游客登录返回访问密钥（24小时内有效）
     */
    function UnregisteredTourists($param){
        global $p_gf_secret_key,$p_aes_encode_class,$p_ras_openssl_class;
        $data=parent::get_error(1,"");
        $aesKey=$p_gf_secret_key->RsaDecode($param['aes_key']);//"CJwcm9kdWN0X2lkIjoiMTk5OCIsIm9yZ";//
        $sign_key=json_decode(base64_decode($p_aes_encode_class->aesDecrypt($param['sign'],$aesKey)),true);//array('device_uuid'=>'0ppp0','device_code'=>'oppo0','vesion'=>'1.0.91','ts'=>'3125333400000');//
//      $s_logger->write_to_file('aes_key='.$aesKey.';sign='.json_encode($sign_key));
//      $rsaPublic=$p_gf_secret_key->getRsaPublicKey(0);
//      $data['aes_key']=$p_ras_openssl_class->rsa_public_encrypt($aesKey,base64_decode($rsaPublic));
//      $data['sign']=$p_aes_encode_class->aesEncrypt(base64_encode(json_encode($sign_key)),$aesKey);
        if($param['device_type']!=7&&!isset($sign_key['device_uuid'])){
            parent::set_error($data,1,"请求参数异常",1);
        }
        $login_param = array (
            'gf_id' => 0,
            'type'=>1,
            'login_address' => "",
            'gf_login_client' => $param['device_type'],
            'login_dev' => $sign_key['device_uuid'],
            'client_device_code' => $sign_key['device_code'],
            'client_version'=>$sign_key['client_version']
        );
        global $p_publicpath;
        $data['upload_url']=$p_publicpath->upload_url;
        $data['db_num']=$p_publicpath->db_data;
        $data['msg_key']=$p_gf_secret_key->getAESKey();//aesKey 用于接收到通知信息解密
        $data['datas']=$this->addLoginLog($login_param);
        $data['datas'] = $p_aes_encode_class->aesEncrypt(json_encode($data['datas']),$aesKey);
        parent::set_error($data,0,"",1);
    }
    
    /**
     * 客服登录登记
     */
    function customer_service_login($param){
        global $p_qmdd_administrators,$p_aes_encode_class,$p_gf_secret_key,$p_common_tool;
        $data=parent::get_error(1,"");
        $p_common_tool->checkArray($param,"adminid",1);
        $adminid=$param['adminid'];
        $list=$p_qmdd_administrators->get_data_list("id=".$adminid);
        if(count($list)==0){
            parent::set_error($data,1,"不存在该客服",1);
        }
        $aesKey=md5($list[0]['id'].$list[0]['ec_salt'],false);
        if($list[0]['is_on_line']==948){
            $p_qmdd_administrators->update("is_on_line,947","id=".$adminid,"",1);
        }
        $login_param = array (
            'gf_id' => $adminid,
            'type'=>2,
            'login_address' => "",
            'gf_login_client' => $param['device_type'],
            'login_dev' => $param['device_uuid'],
            'client_device_code' =>"",
            'client_version'=>$param['client_version']
        );
        $data['msg_key']=$p_gf_secret_key->getAESKey();//aesKey 用于接收到通知信息解密
        $data['datas']=$this->addLoginLog($login_param);
        $data['endatas'] = $p_aes_encode_class->aesEncrypt(json_encode($data['datas']),$aesKey);
        parent::set_error($data,0,"",1);
    }
    
    /**
     * 对请求参数分析，解密
     * $encode =1 必须使用visit_id+enparams（除接口 unregistered_tourists、login 其他接口后续整理）
     * 针对visit_id 获取用户信息gfid，admin_id，根据gfid／admin_id 限制用户访问信息权限（如gfid只能访问个人数据，不能访问其他会员的私人信息；admin_id只能访问该客服的信息，不能访问其他客服的信息）
     * @return $param
     */
    function checkREQUEST($REQUEST,$encode=0){
        global $p_aes_encode_class,$p_publicpath;
        if(empty($REQUEST['action'])){
            parent::set_error($data,1,"非法操作！",1);
        }
        $action=$REQUEST['action'];
        if(isset($_POST['visit_id'])&&isset($_POST['iosign'])){
            $data=parent::get_error(1,"");
            parent::checkTime($_POST['ts'],1);
            $login_key=$this->getLoginKey($_POST['visit_id']);
            if(empty($login_key)||$_POST['iosign']!=MD5($_POST['action'].$_POST['visit_id'].$_POST['ts'].$login_key)){
                parent::set_error($data,101,"访问过期",1);
            }
        }else if(isset($REQUEST['visit_id'])&&isset($REQUEST['enparams'])){
            $data=parent::get_error(1,"");
            $login_key=$this->getLoginKey($REQUEST['visit_id'],1);
            $deparam=base64_decode($p_aes_encode_class->aesDecrypt($REQUEST['enparams'],$login_key['encryption']));
            if(empty($login_key['encryption'])||empty($deparam)){
                parent::set_error($data,101,"访问过期",1);
            }
            $param=json_decode($deparam,true);
            $param['visit_id']=$login_key['visit_id'];
            $param['visit_key']=$login_key['encryption'];
            $param['visit_gfid']=$login_key['gf_id'];
            $param['visit_gfaccount']=$login_key['gf_account'];
            $param['visit_phone']=$login_key['security_phone'];
            $param['client_version']=$login_key['client_version'];
            parent::checkTime($param['ts'],1);
        }else if($encode==0
            ||$action == 'unregistered_tourists'||$action == 'get_memu_setting'||$action == 'login'
            ||$p_publicpath->add_order_head!="S"){
            $param=$REQUEST;
        }else{
            parent::set_error($data,1,"验证信息错误",1);
        }
        $param['device_type']=empty($param['device_type'])?$_REQUEST['device_type']:$param['device_type'];
        $param['action']=$REQUEST['action'];
        if($param['action']=='get_clubs_by_gfid'){//io_club
            $param['gfid'] =empty($param['gfid'])? $_REQUEST['gfid']:$param['gfid'];
        }
        if(empty($REQUEST['visit_id'])){
            return $param;
        }
        if($_GET['a']=='io_customer_service'){//Adjusted 已调整
            if($param['action']=='get_customer_msg_history'||$param['action']=='close_consultation'||$param['action']=='customer_service_login'||$param['action']=='get_not_close_consulting_by_admin'){
                if($login_key['type']==2){//0-游客，1-前端，2-后台（管理员）
                    if($param['action']=='customer_service_login'){
                        $param['adminid']=$param['visit_gfid'];
                    }else{
                        $param['admin_id']=$param['visit_gfid'];
                    }
                }else{
//                  parent::set_error($data,1101,"请求异常",1);
                }
            }else if($param['action']=='unregistered_tourists'){
            }elseif($login_key['type']==2){//客服访问权限，暂未限制
                $param['admin_id']=$param['visit_gfid'];
            }else{// if(!empty($param['gfid']))
                $param['gfid']=$param['visit_gfid'];
            }
        }elseif($login_key['type']==2){//客服访问权限，暂未限制（需要根据客服所在单位及角色限制其访问数据权限）
            
        }elseif($_GET['a']=='io_club'||$_GET['a']=='io_person'||$_GET['a']=='io_servant'||$_GET['a']=='io_service'){//Adjusted 已调整
            if($param['action']=='get_communication'&&empty($param['gfid'])){
                
            }else{
                $param['gfid']=$param['visit_gfid'];
            }
            //io_servant ,servant_application_order,club_invite_qualification,,get_club_invite_qualification_list,delete_qualification_invite,,get_qualification_ex_credit_detail
        }elseif($_GET['a']=='io_game'){//Adjusted 已调整
            //get_add_order_details,get_joiner_team_member  不限制访问条件
            if($param['action']=='add_insurance'){
                $param['submit_gfid']=$param['visit_gfid'];
            }else if($param['action']=='add_insurance'){
                $param['source_gfid']=$param['visit_gfid'];
            }else{
                $param['gfid']=$param['visit_gfid'];
            }
        }elseif($_GET['a']=='io_gfim'){//Adjusted 已调整
            if($param['action']=='get_gf_info_by_account'){
                $param['gfaccount']=$param['visit_gfaccount'];
//          }else if($param['action']=='readed_offline_message'||$param['action']=='get_offline_messages_by_count'||$param['action']=='get_offline_messages_by_scroll'||$param['action']=='get_offline_messages_by_id_page'){
//              $param['r_gfid']=$param['visit_gfid'];
//          }else if($param['action']=='readed_single_message'||$param['action']=='readed_my_self'){
//              if($param['S_G']==1){
//                  $param['sourceGfid']=$param['visit_gfid'];
//              }
            }else if($param['action']=='get_grmsg_and_relation'){
                $param['sourceGfid']=$param['visit_gfid'];
            }else if($param['action']=='get_grmsg'||$param['action']=='get_gf_info_by_id'){
                $param['login_gfid']=$param['visit_gfid'];
            }else if($param['action']=="edit_pass"||$param['action']=="edit_grmsg"||$param['action']=="get_frlist"||$param['action']=="edit_frbeizhu"||$param['action']=="del_friend"||$param['action']=="add_friend"){
                $param['gf_id']=$param['visit_gfid'];
            }else if($param['action']=='operate_crowd_member_by_id'){
                $param['operate_gfid']=$param['visit_gfid'];
            }else if($param['action']=='login'){
            }else{
                $param['gfid']=$param['visit_gfid'];
            }
        }elseif($_GET['a']=='io_mall'){//Adjusted 已调整
            //get_shelves_sale_detail   不限制访问条件
            if($param['action']=='add_product_to_shopping_car'){
                $param['car_gfid']=$param['visit_gfid'];
            }else if($param['action']=='production_paying'){
                $param['paying_gfid']=$param['visit_gfid'];
            }else{
                $param['gfid']=$param['visit_gfid'];
            }
        }elseif($_GET['a']=='io_order'){//Adjusted 已调整
            if($param['action']=='insert_order_comments'){
                $param['gf_id']=$param['visit_gfid'];
            }else{
                $param['gfid']=$param['visit_gfid'];
            }
        }elseif($_GET['a']=='io_phone'){//Adjusted 已调整
            if($param['action']=='band_phone'){
                $param['gf_id']=$param['visit_gfid'];
            }else{
                $param['gfid']=$param['visit_gfid'];
            }
        }elseif($_GET['a']=='io_public'){//Adjusted  add_site-belong_id,get_apply_site_detail,apply_for_revocation
            if($param['action']=='get_foot'){
                $param['my_gfid']=$param['visit_gfid'];
            }elseif($param['action']=='band_phone'){
                $param['gf_id']=$param['visit_gfid'];
            }else{
                $param['gfid']=$param['visit_gfid'];
            }
        }elseif($_GET['a']=='io_user'){//Adjusted  getEmail
            if($param['action']=='settingEmail'||$param['action']=='sendEmail'||$param['action']=='unboudEmail'){
                $param['gfaccount']=$param['visit_gfaccount'];
            }else if($param['action']=='help_friend_get_password'){
                $param['account']=$param['visit_gfaccount'];
            }else if($param['action']=='vote_by_bean'){
                $param['gf_id']=$param['visit_gfid'];
            }else{
                $param['gfid']=$param['visit_gfid'];
            }
        }elseif($_GET['a']=='io'){//Adjusted   getAccountSafe
            $param['gfid']=$param['visit_gfid'];
        }elseif($_GET['a']=='io_mood'){//Adjusted
            if($param['action']=='edit_mood_bg'){
                $param['gf_id']=$param['visit_gfid'];
            }elseif($param['action']=='GetOnlyMyWorld'){
                $param['v_gfid']=$param['visit_gfid'];
            }elseif($param['action']=='GetMoodsDedail'){
                $param['v_gfid']=$param['visit_gfid'];
            }elseif($param['action']=='ReplyMoods'){
                $param['m_gfid']=$param['visit_gfid'];
            }else{
                $param['gfid']=$param['visit_gfid'];
            }
        }
        return $param;
    }
    

}
