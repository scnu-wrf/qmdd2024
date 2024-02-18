<?php

class QualificationsRenewal extends BaseModel {

    public function tableName() {
        return '{{qualifications_renewal}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
		array('check_state,check_state_name,qualification_type', 'safe'), 
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'qualifications_person' => array(self::BELONGS_TO, 'QualificationsPerson','qualifications_id'),
            'base_code' => array(self::BELONGS_TO, 'BaseCode', array('qualification_type' => 'f_id')),
			'qualification_invite' => array(self::BELONGS_TO, 'QualificationInvite', 'invite_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'qualifications_id'=>'资质人id',
            'qualifications_code'=> '编号',
            'gfaccount'=> 'GF帐号',
            'qualification_name'=> '姓名',
			'phone'=> '联系电话',
			'email'=> '电子邮箱',
			'address' => '联系地址',
			'head_pic'=>'免冠照片',
            'check_state' => '续签审核',
            'check_state_name' => '续签审核',
            'reasons_for_failure' => '审核未通过原因',
            'state_time' => '操作时间',
            'order_num' => '订单号',
            'is_pay' => '续签缴费',
            'is_pay_name' => '续签缴费',
            'pay_time' => '缴费时间',
            'cost_admission' => '入驻／续费',
            'free_charge' => '入驻／续免费（优惠）',
            'cost_account' => '实际缴费',
            'entry_validity' => '服务者有效期',
            'time_remaining' => '剩余天数',
            'state_name' => '服务者状态',
            'cost_oper' => '缴费处理操作员',
            'send_oper' => '通知人',
            'send_date' => '通知时间',
            'sex' => '性别',
            'project_id' => '项目',
            'project_name' => '项目',
            'qualification_type_id' => '类型',
            'qualification_type' => '类型',
            'identity_num' => '资质等级',
            'qualification_title' => '资质等级',
            'qualification_level' => '服务者等级',
            'level_name' => '服务者等级',
			'qualification_code'=>'证书编号',
			'qualification_image'=>'证书扫描件',
			'start_date'=> '资质获得时间',
			'end_date'=> '有限期至',
        );
    }
	
	public function getCode() {
        return array( 
            array('f_id' => '1','F_NAME' => '机构'),
            array('f_id' => '2','F_NAME' => '其他'),);
    }

   public function getProject($clubid) {
      return $this->findAll('club_id='.$clubid);
    }

   public function getClub($qpid) {
      return $this->findAll('qualification_person_id='.$qpid);
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

        }
        return true;
    }

}
