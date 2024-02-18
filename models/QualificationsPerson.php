<?php

class QualificationsPerson extends BaseModel {

	public $show=0;
    public function tableName() {
        return '{{qualifications_person}}';
    }
 /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**  * 模型关联规则  */
    public function relations() {
        return array();
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
         'id' =>'id',
          'qcode' => '资质编号',//年份+月份+四位数序号，如2016050001',
          'gfid' => '资质人gfid',
          'phone' => '联系电话',
          'email' => '电子邮箱',
          'address' => '联系地址',
          'area_code' => '所在地区',//，关联t_region表id，以,隔开
          'gfaccount' => '服务者帐号',
          'qualification_name' => '服务者姓名',
          'sex' => '性别',//，0-女，1-男
          'qualification_type_id' => '资质人类型',
          'qualification_type' => '资质人类型',
          'code_project' => '质资证代码',
          'code_year' =>'质资年份',
          'code_num' => '质资编号',
          'gf_code' => '服务者编码',
          'identity_type'=>'证书类型',
          'identity_type_name' => '证书类型名称',
          'identity_num' => '持证证书等级',
          'qualification_title' =>'证书标题',
          'identity_score' => '证书等级',
          'qualification_code' => '持证证书编号',
          'qualification_image' => '证书扫描件',
          'experience' =>'从业经验描述',
          'example' => '从业作品',
          'head_pic' => '资质人免冠头像',
          'project_id' => '资质项目id',
          'project_name' => '资质项目名',
          'process_id' => '处理人id',
          'process_account' => '处理人account',
          'process_nick' => '处理人昵称',
          'uDate' => '入驻时间',
          'auth_state'=>'申请状态',
          'auth_state_name' => '申请状态名称',
          'check_state' =>'状态',
          'check_state_name' => '审核名称',
          'reasons_failure' => '未通过原因',
          'state_time' => '操作时间',
          'qualification_time' => '获得资质时间',
          'synopsis' => '简短介绍',
          'introduct' => '资质人介绍URL',
          'qualification_level'=>'资质等级',
          'level_name' => '等级基本名称',
          'qualification_score' => '资质分',
          'order_num' => '订单号',
          'is_pay' =>'支付状态',
          'is_pay_name' => '支付状态说明',
          'start_date' => '证书日期',
          'end_date' => '证书结束日期',
          'if_del' => '冻结',
          'lock_date_start' => '冻结开始',
          'lock_date_end' => '冻结结束',
          'lock_reason' => '冻结/解冻原因',
          'lock_time' => '冻结/解冻操作时间',
          'if_apply_display' => '是否开启求职显示',
          'achi_h_num'=>'好评数',
          'achi_h_ratio' => '好评率',
          'achi_z_num' =>'',
          'achi_z_ratio'=> '中评率',
          'achi_c_num'=>'差评数',
          'achi_c_ratio'=> '差评率',
          'cost_admission' => '入驻费',
          'free_charge' => '入驻免费（优惠）',
          'cost_account' => '实际缴费',
          'cost_adminid' =>'确认缴费',
          'cost_oper' => '确认缴费操作员',
          'renew' => '续费',
          'renew_free' => '续费免费（优惠）',
          'renew_date' => '续费到期时间',
          'renew_order_num' => '续费单号',
          'renew_oper' => '续费费处理操作员',
          'send_oper' => '通知人',
          'send_date' => '通知时间',
          'cut_date' => '缴费截止日期',
          'free_state_Id'=>'缴费通知状态',
          'free_state_name' => '缴费通知状态名称',
          'entry_validity' => '入驻时间',
          'expiry_date_start' => '有效期开始时间',
          'expiry_date_end' => '有效期截止日期',
          'ccheck_state'=>'续签状态',
          'ccheck_state_name' => '续签审核状态名称',
          'reasons_for_failure' => '续签审核未通过原因',
          'cstate_time' => '续签操作更新时间',
          'cis_pay'=>'续签支付状态',
          'pay_way'=>'收费方式',
          'pay_way_name' => '收费方式',
          'pay_blueprint'=>'缴费方案',
          'pay_blueprint_name' => '缴费方案',
          'unit_state'=>'是否注销',
          'unit_state_name' => '是否注销',
          'unit_cause' => '注销原因',
          'is_del'=>'是否删除',
          'logon_way' => '注册方式',
          'logon_way_name' => '注册方式名称',
          'band_club_num' => '绑定单位数量',
          'unit_apply_date' => '注销申请日期',
        );
    }
    
    public function setDefaultValue() {
      $pathpic='head_pic,qualification_image';
     // $s1='Basecod,state:id,state_name:f_name;';
      $s1='process_id:admin_id,process_account:gfaccount';
      $relations='BaseCode,free_state_Id:f_id,free_state_name:F_NAME';//$s1;
      $rs=array(
      'sess'=>$s1.',process_nick:admin_name',//保持登录信息
      'date'=>'state_time',//保存修改
      'def_sess'=>'',//保持第一次操作信息
      'def_date'=>'uDate',//保存地一次修改信息
      'pcipath'=>$pathpic,//属性名:模型名称，模型空取上一个模型
      'relations'=>$relations//关联取值
      );
      return $s1;
    } 
  
    protected function beforeSave() {
        parent::beforeSave();
        // 生成服务者编码
        if (empty($this->gf_code)) {
            $this->gf_code=getAutoNo('QualificationsPerson');
        }
        return true;
    }

   protected function afterFind(){
      parent::afterFind();
      $this->start_date=nullDateToStr($this->start_date);
      $this->end_date=nullDateToStr($this->end_date);
     }
    public function getPerson($pid,$type) {
        $w1='project_id='.$id.' AND qualification_type_id='.$type;
        return $this->findAll($w1);
    }

    public function getPerson2($project_id,$type) {
        $tmp= $this->getPerson($project_id,$type);
        $s1='gf_account:gfaccount,gf_code,project_id,type:qualification_type_id';
        return toIoArray($tmp,$s1);
    }
}
