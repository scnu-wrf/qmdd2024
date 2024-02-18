<?php
/**
 * (user_state=0 or user_state=506) and (if_del=0 or if_del=510)
 */
class GfUser1 extends BaseModel {
    public $location ='';
    public $GF_PASS2 = '';
    public $cult = '';
    public $area='';//,$AGE=0;
        /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{gf_user_1}}';
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
        'states' => array(self::BELONGS_TO,'BaseCode','state'),
        'sexs' => array(self::BELONGS_TO,'BaseCode','SEX'),
        'tcountry' => array(self::BELONGS_TO,'TCountry','COUNTRY'),
        'tnation' => array(self::BELONGS_TO,'Nation','nation'),
        'tregion' => array(self::BELONGS_TO,'TRegion','PROVINCE'),
        'tcity' => array(self::BELONGS_TO,'TRegion','CITY'),
        'base_health' => array(self::BELONGS_TO,'BaseCode','health_state'),
        );
    }
  public function picLabels() {
     return 'TXADD,TXNAME,mood_bigpic_url,IDNAME,IDADD,id_card_pic,id_pic';
     //return $s1;
    }
    public  function pathLabels(){
        return '';
    }

   /*** 模型验证规则*/
    public function rules() {
      return $this->attributeRule();
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }
    public function attributeSets() {
        return array(
        'GF_ID' => 'ID',
        'GF_ACCOUNT' => 'GF账号',
        'GF_NAME' => '昵称',
        'GF_PASS' => '密码',
        'pay_pass' => '支付密码',
        'PHONE' => '联系电话',
        'EMAIL' => '电子邮箱',
        'GF_REG_IP' => '注册IP',
        'gf_reg_address' => '注册IP地址',
        'gf_reg_client' => '注册客户端', // 3、IPHONE 4、IPAD 5、APHONE 6、APAD 7、web，8其他',
        'client_device_code' => '客户端设备',
        'client_device_uuid' => '移动识别码',
        'REGTIME' => '注册时间',
        'TXADD' => '头像地址',//TXADD,TXNAME
        'TXNAME' => '头像',
        'SEX' => '性别',
        'AGE' => '年龄',
        'YEAR_' => '出生年',  // （用户信息表）',
        'MONTH_' => '出生月',  // （用户信息表）',
        'DAY_' => '出生日',  // （用户信息表）',
        'FamilyHistory' => '家族病史',
        'location' => '所在地区',
        'COUNTRY' => '国家',
        'PROVINCE' => '省',
        'CITY' => '市',
        'CONSTELLATION' => '星座',
        'ZODIAC' => '生肖',
        'BLOOD' => '血型',
        'JOB' => '工作',
        'LANGUAGE' => '语言',
        'GRQM' => '个性签名',
        'BYXX' => '毕业学校',
        'guardian' => '紧急联系人',
        'guardian_contact_information' => '联系人电话',
        'guardian_relationship' => '与监护人关系',
        'height' => '身高(cm)',
        'weight' => '体重(kg)',
        'INTEREST' => '兴趣爱好',  // 兴趣爱好
        'mood_bigpic_url' => '小世界封面',//TXADD,TXNAME，mood_bigpic_url
        'getpasstime' => '获取密码时间',
        'SECURITYQUESTION' => '密保问题',  // 使用json base64',
        'security_phone_country_code' => '手机区号',  // 默认中国86',
        'security_phone' => '绑定手机号',  // 密保/登录绑定手机号
        'security_email' => '密保邮箱',
        'heart_time' => '免冠头像提交时间',
        'ZSXM' => '姓名',
        'IDNAME' => '免冠照片(1寸)',//TXADD,TXNAME，mood_bigpic_url,IDNAME,IDADD
        'IDADD' => '免冠照片',
        'CLIENTVER' => '用户资料版本号',
        'nation' => '民族',
        'native' => '籍贯/地区',
        'id_card_pic' => '正面证件照',//TXADD,TXNAME，mood_bigpic_url,IDNAME,IDADD,id_card_pic
        'realname_time' => '实名时间',
        'id_pic' => '反面证件照',//id_pic
        'id_card_type' => '证件类型',
        'id_card_type_name' => '证件类型',
        'id_card' => '证件号码',
        'id_card_validity_start' => '证件有效期',  // 有效期开始时间
        'id_card_validity_end' => '证件有效期',  // 有效期结束时间
		'passed'=>'实名状态',
		'passed_name'=>'实名状态',
        'real_birthday' => '出生日期',
        'real_sex' => '性别',
        'real_sex_name' => '性别',
		'realname_entertime'=>'实名确认',
		'operater_gfid'=>'审核操作',
		'club_id'=>'俱乐部ID',
		'health_date'=>'体检日期',
		'health_state'=>'是否健康',
		'medical_history'=>'过往病史',
		'examination_report'=>'体检报告表',
		'CREDIT'=>'可消费积分',
		'ready_credit'=>'待发放积分',
		'beans'=>'体育豆数量',
		'ready_beans'=>'冻结体育豆',
		'fens'=>'粉丝数',
		'wallet'=>'钱包余额',
		'coupons'=>'优惠券个数',
		'if_open_project'=>'接收邀请',
		'if_del'=>'是否删除',
        'user_state' => '账号状态',
        'user_state_name' => '账号状态',
        'lock_reason' => '冻结原因',
        'LOCK_R' => '临时使用',
        'admin_gfid' => '操作员',
        'admin_gfname' => '操作员',
        'fail_auth_reason' => '未通过原因',
        'uDate' => '更新时间',
        'examine_time' => '审核时间',
        'achi_h_num' => '好评数',
        'achi_h_ratio' => '好评数',
        'achi_z_num' => '中评数',
        'achi_z_ratio' => '中评率',
        'achi_c_num' => '差评数',
        'achi_c_ratio' => '差评率',
		'idname_add_time'=>'头像更新时间',
		'lock_date_start'=>'冻结开始',
        'lock_date_end'=>'冻结结束',
        'occupation'=>'职业',
        'work_unit'=>'工作单位',
        'logon_way'=>'注册方式',
        'logon_way_name'=>'注册方式',
        'athlete_rank'=>'运动员等级',
        'valid_date'=>'有效开始日期',
        'end_valid_date'=>'有效结束日期',
        'GF_PASS2'=>'确认密码',
        'cult'=>'未通过原因',
        'subordinate_club' => '所属单位',
        'subordinate_project' => '项目',
        'subordinate_record' => '会员身份',
        'dragon_tiger_project' => '项目',
        'dragon_tiger_leven' => '龙虎等级',
        'dragon_tiger_time' => '注册时间',
        );
    }


    protected function afterFind(){
      parent::afterFind();
      $this->area = $this->COUNTRY.$this->PROVINCE.$this->CITY;
      $this->AGE=getAge($this->real_birthday);
      return true;
    }
    protected function beforeSave() {
        parent::beforeSave();
        $this->uDate = date('Y-m-d H:i:s');
        if ($this->isNewRecord) {
            $this->REGTIME = date('Y-m-d H:i:s');
            if(empty($this->GF_PASS)) $this->GF_PASS = md5($this->GF_PASS);
            $this->examine_time = date('Y-m-d H:i:s');
            $this->admin_id=get_session('admin_id');
            $this->admin_gfid=get_session('gfid');
            $this->admin_gfname =get_session('admin_name');
            $this->realname_entertime = date('Y-m-d H:i:s');
            $this->end_valid_date = '长期';
        }
        return true;
    }

	public function getUser() {
        $tmp= $this->findAll('user_state=506');
        $s1='GF_ID,GF_ACCOUNT,ZSXM,real_sex,real_sex_name,id_card_type_name,';
        $s1.='id_card,real_birthday,passed,user_state,PHONE,IDNAME,health_date';
        return toIoArray($tmp,$s1);
    }

	/**
	 * 账号正常用户判断
	 * @parma $gfid 可为空／0/空字符
	 * @param $normal 0-账号状态不正常（被注销／冻结），>0账号状态正常
	 */
    public function UserSql($gfid,$normal=1,$table_name=''){
    	$t=empty($table_name)?'':($table_name.'.');
    	return $t.'if_del=0'.(empty($gfid)?'':(' and '.$t.'GF_ID='.$gfid)).($normal?' and '.$t.'user_state=506':'');
    }

    /**
     * 会员状态
     * (user_state=0 or user_state=506) and (if_del=0 or if_del=510)
     */
    public function getUserInfo($gfid,$normal=1){
        $gf_info= $this->find($this->UserSql($gfid,$normal));

        $s1='GF_ID:gf_id,GF_ACCOUNT:gf_account,GF_NAME:gf_name,TXNAME:gf_icon_dir,';
        $s1.='TXNAME:gf_icon,passed,user_state,real_sex:sex:AGE:age,';
        $arr = array();
        if (!empty($gf_info)) {
            $arr['gf_id'] = $gf_info->GF_ID;
            $arr['gf_account'] = $gf_info->GF_ACCOUNT;
            $arr['gf_name'] = $gf_info->GF_NAME;
            $arr['gf_icon_dir'] = $gf_info->TXNAME;
            $arr['gf_icon'] =$gf_info->TXNAME;
            $arr['passed'] = $gf_info->passed;
			$arr['user_state'] = $gf_info->user_state;
			$arr['sex'] = $gf_info->real_sex;
			$arr['age'] = $gf_info->AGE;
			$arr['area'] = $gf_info->COUNTRY.$gf_info->PROVINCE.$gf_info->CITY;
			$arr['country'] = $gf_info->COUNTRY;
			$arr['province'] = $gf_info->PROVINCE;
			$arr['city'] = $gf_info->CITY;
			$arr['grqm'] = $gf_info->GRQM;
			$arr['interest'] = $gf_info->INTEREST;
			$arr['mood_bigpic_url'] =$gf_info->mood_bigpic_url;
        }
        return $arr;
    }

 	/**
     * 查找会员
     * GF账号（完整账号）/昵称（模糊）
     */
	public function searchUser($param){
		$data=get_error(1,"获取失败");
		checkArray($param,'visit_gfid,keyword,page,per_page',1);
        $page=empty($param['page'])||$param['page']<1?1:$param['page']; //第几页
        $_GET['page']=$page;
        $pageSize=empty($param['per_page'])?0:$param['per_page'];       //每页条数
		$cr = new CDbCriteria;
        $cr->condition="user_state=506 and (GF_ACCOUNT='".$param['keyword']."' or GF_NAME like '%".$param['keyword']."%')";
        $cr->select="GF_ID as gfid,GF_ACCOUNT as gf_account,GF_NAME as gf_name,TXNAME as gf_icon,GRQM as grqm";
        $count = $this->count($cr);
        $pages = new CPagination($count);
        $pages->pageSize = $pageSize;
        $pages->applylimit($cr);
        $datas=$this->findAll($cr,array(),false);
        $url=getShowUrl('file_path_url');
        foreach($datas as $k=>$v){
        	$datas[$k]['gf_icon']=$url.$v['gf_icon'];
        }
        $data['datas']=$datas;
        $data['total_count'] = $count;
		set_error_tow($data,$count,0,'获取成功',0,'未查找到相关GF会员',1);
	}

	/**
	 * 获取报名信息
	 * @param $no_hide 0-隐藏身份证号，绑定手机，
	 * @param project_id 有项目返回用户该项目的龙虎等级，无项目返回用户所有项目的龙虎等级
	 * @return
	 */
	public function GetRegistrationDatas($param,$no_hide=0){
		checkArray($param,'visit_gfid',1);
        $gfid=$param['visit_gfid'];
        $project_id=empty($param['project_id'])?'':$param['project_id'];
		$cr = new CDbCriteria;
        $cr->condition="user_state=506 and passed=372 and GF_ID=".$gfid;
        $cr->select="GF_NAME as gf_name,GF_ACCOUNT as gf_account,ZSXM as real_name,real_sex,real_sex_name as sex,real_birthday as born,native,nation,id_card,height,weight,short_name,recent_photo,insurance_pic,registration_area,registration_phone,security_phone";

        $datas=$this->find($cr,array(),false);
        $url=getShowUrl('file_path_url');
        if(!empty($datas)){
        	$v=CommonTool::model()->getKeyArray($datas,'gf_name,gf_account,real_name,real_sex,sex,born,native,nation,id_card,height,weight,short_name,recent_photo,insurance_pic,registration_area,registration_phone,security_phone');
        	$v['height_unit']='cm（厘米）';
        	$v['weight_unit']='Kg（公斤）';
        	$v['registration_phone']=empty($v['registration_phone'])?(empty($v['security_phone'])?'':$v['security_phone']):$v['registration_phone'];
        	if(empty($no_hide)){
        		$v['id_card']=CommonTool::model()->HideKeyContent($v['id_card']);
        		$v['registration_phone']=CommonTool::model()->HideKeyContent($v['registration_phone']);
	        	$v['recent_photo']=CommonTool::model()->addto_url_dir($url,$v['recent_photo'],',',',');
	        	$v['insurance_pic']=CommonTool::model()->addto_url_dir($url,$v['insurance_pic'],',',',');
        	}

        	$lh_datas=ClubMemberList::model()->getMemberProjectLevel(array('gfid'=>$gfid,'project_id'=>$project_id));
        	$v['lh']='';
        	$v['lh_datas']=$lh_datas;
        	foreach($lh_datas as $k=>$lh_bean){
        		if($lh_bean['member_level']==0){
        			continue;
        		}
        		if($k>0){
        			$v['lh'].='、';
        		}
        		$v['lh'].=$lh_bean['member_project_name'].$lh_bean['member_level_name'];
        	}
        	$v['lh']=empty($v['lh'])?'无':$v['lh'];
        	unset($v['security_phone']);
        	return $v;
        }
		return null;
	}
	/**
	 * 修改报名信息
	 * 身高、体重、报名信息-手机号码(手机号隐藏一致，不修改)、报名信息-短名、报名信息-所在区域、报名信息-近期照片、报名信息-保险证明图
	 */
	public function UpdateRegistrationDatas(&$param){
		checkArray($param,'visit_gfid',1);
        $gfid=$param['visit_gfid'];
        $user_info=$this->find("GF_ID=".$gfid);
        $url=getShowUrl('file_path_url');
        $tadd=-1;
        if(!empty($user_info)){
        	if(isset($param['height'])){
				$user_info->height=$param['height'];
        	}
			if(isset($param['weight'])){
				$user_info->weight=$param['weight'];
			}
			$user_info->short_name=$param['short_name'];
			$user_info->registration_area=$param['registration_area'];
			if($param['registration_phone']==CommonTool::model()->HideKeyContent($user_info->registration_phone)){
				//提交手机号隐藏与当前手机号隐藏一致，为提交默认手机号
				$param['registration_phone']=$user_info->registration_phone;
			}else{
				$user_info->registration_phone=$param['registration_phone'];
			}
			$user_info->recent_photo=CommonTool::model()->get_fullurl_name($url,$param['recent_photo']);
			$user_info->insurance_pic=CommonTool::model()->get_fullurl_name($url,$param['insurance_pic']);
			$tadd=$user_info->update($user_info);
        	$param['id_card']=$user_info['id_card'];
        }
        return $tadd;
	}

}
