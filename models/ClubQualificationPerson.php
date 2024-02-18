<?php

class ClubQualificationPerson extends BaseModel {

    public  $video_list='';
    public  $sub_product_list='';
	public $introduct_temp = '';
    
    public function tableName() {
        return '{{qualifications_person}}';
    }

    /**
     * 模型关联规则
     */
    public function relations() {
    return array( 
            //'videos' => array(self::BELONGS_TO, 'QualificationVideos', 'vidio_list'),
			'base_code' => array(self::BELONGS_TO, 'BaseCode', 'identity_num'),
			'sex' => array(self::BELONGS_TO, 'BaseCode', 'sex'),
            'userlist' => array(self::BELONGS_TO, 'userlist', array('gfid'=>'GF_ID')),
			'acc_status' => array(self::BELONGS_TO, 'BaseCode', 'if_del'),
      );
    }


 public function rules() {
        return array(	
            array('gfid,gfaccount,sex,qualification_title,if_del,project_id,qualification_type_id,qualification_code,qualification_time,start_date,end_date,identity_num,qualification_level,if_apply_display,check_state,reasons_for_failure,vidio_list,phone,email,qualification_name,qualification_image,head_pic,introduct,introduct_temp,address,area_code,experience,example,free_state_Id,free_state_name,expiry_date_start,expiry_date_end,qcode,logon_way,logon_way_name,cost_adminid,cost_oper,state_time,process_id,process_account,process_nick','safe'), 
        );
        
    }


    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'vidio_list'=>'视频',
            'qcode'=>'流水编号',
			'gfid'=>'id',
			'phone'=> '联系电话',
			'email'=> '电子邮箱',
            'address' => '详细地址',
            'area_code' => '所在地区',
			'gfaccount'=> '帐号',
			'qualification_name'=> '姓名',
			'qualification_type_id'=>'服务者类型',
			'qualification_type'=>'服务者类型',
			'code_project'=> '项目',
			'code_type'=> '类型编码',
			'code_year'=> '年份',
			'code_num'=>'编号',
			'gf_code'=> '服务者编码',
			'identity_num'=>'服务者资质',
			'qualification_title'=>'服务者资质',
			'qualification_code'=>'证书编号',
			'qualification_image'=>'证书扫描件',
			'head_pic'=>'免冠照片',
			'club_name'=>'服务单位',
			'project_id'=>'项目',
			'project_name'=>'项目',
			'process_id'=>'操作人',
			'process_account'=>'操作人帐号',
			'process_nick'=>'处理人',
			'uDate'=> '添加时间',
			'check_state'=>'状态',
			'check_state_name'=>'状态名称',
			'reasons_for_failure'=>'操作备注',
			'qualification_time'=> '获得时间',
			'synopsis'=>'简介',
			'introduct'=>'服务者人介绍',
			'introduct_temp'=>'服务者人介绍',
			'qualification_level'=> '服务者等级',
			'level_name'=>'等级名称',
			'qualification_score'=>'服务者等级分',
			'order_num'=>'订单号',
			'is_pay'=>'支付状态',
			'start_date'=> '资质获得时间',
			'end_date'=> '有限期至',
			'if_apply_display'=>'求职显示',
			'achi_h_ratio' => '好评率',
            'if_del'=>'状态',
            'lock_date_start'=>'冻结开始日期',
            'lock_date_end'=>'冻结结束日期',
            'lock_reason'=>'冻结原因',
			'auth_state_name'=>'申请状态',
			'experience' => '从业经验描述',
			'example' => '从业作品',
			'free_state_Id' => '缴费状态',
			'free_state_name' => '缴费状态名称',
			'expiry_date_start' => '入驻有效期',
			'expiry_date_end' => '至',
			'check_state' => '续签状态',
			'check_state_name' => '续签状态',
			'reasons_for_failure' => '续签审核未通过原因',
			'is_pay' => '续签缴费',
			'is_pay_name' => '续签缴费',
            'state_time' => '操作更新时间',
            'pay_way' => '收费方式',
            'pay_way_name' => '收费方式',
            'pay_blueprint' => '缴费方案',
            'pay_blueprint_name' => '缴费方案',
            'unit_state' => '状态',
            'unit_state_name' => '是否注销',
            'unit_cause' => '注销原因',
            'logon_way' => '入驻方式',
            'logon_way_name' => '入驻方式',
            'sex' => '性别',
			
            'native' => '籍贯',
            'nation' => '民族',
            'real_birthday' => '出生日期',
            'id_card_type' => '证件类型',
            'id_card' => '证件号码',
            'id_card_validity_start' => '证件有效期开始时间',
            'id_card_validity_end' => '证件有效期开始时间',
            'id_card_pic' => '证件正面',
            'id_pic' => '证件反面',
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
			$this->uDate=date('Y-m-d H:i:s');
        }
        // 生成服务者编码
        if (empty($this->gf_code)&&$this->check_state==2) {
            $project_code='';
            if(!empty($this->project_id)){
                $projectList=ProjectList::model()->find('id='.$this->project_id);
                $project_code=$projectList->CODE;
            }

            $B_CODE=ClubServicerType::model()->find('member_second_id='.$this->qualification_type_id);
            $type_code=$B_CODE->code;
            $year = date('Y');
            $year_all = $this->find("code_year='".$year."' order by code_num DESC");
            if(!empty($year_all)){
                $code=$year_all->code_num+1;
            }else{
                $code=1;
            }
            $this->code_year = $year;	
            $this->code_num = $code;	
            $code1 = substr('000000' . strval($this->code_num), -6);
            $gf_code=$project_code.'_'.$type_code.'_'.$this->code_year.$code1;	
            $this->gf_code = $gf_code;

        }
        $bs = BaseCode::model()->find('f_id='.$this->free_state_Id);
        $this->free_state_name = $bs->F_NAME;
        $this->state_time = date('Y-m-d H:i:s');
        $this->process_id = get_session('admin_id');
        $this->process_account = get_session('gfaccount');
        $this->process_nick = get_session('admin_name');
        
        return true;
    }


	public function getAge($toTime) {
        //转时间戳
        $fromTime = time();
        $toTime = strtotime($toTime);
        //计算时间差
        $newTime = $toTime - $fromTime;
        return round($newTime / 86400)-1 . '天' . 
        round($newTime % 86400 / 3600) . '小时' . 
        round($newTime % 86400 % 3600 / 60) . '分钟';
    }
}
