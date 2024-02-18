<?php

class ClubProject extends BaseModel {

	/*public $qualifications_person = '';
    public $qualification_club = '';*/
	public $show=0;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{club_project}}';
    }
	public function check_save($show) {
        $this->show=$show;
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
        //'qualification_club' => array(self::BELONGS_TO, 'QualificationClub','club_id','condition' => 't.project_id=$id'),
		'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
		'project_list' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
		'projectstate' => array(self::BELONGS_TO, 'BaseCode', 'project_state'),
		'authstate' => array(self::BELONGS_TO, 'BaseCode', 'auth_state'),
		'approvestate' => array(self::BELONGS_TO, 'BaseCode', 'approve_state'),
		'mall_order_num' => array(self::BELONGS_TO, 'Carinfo', array('order_num'=>'order_num')),
        'fee_id' => array(self::BELONGS_TO, 'ClubMembershipFeeDataList', array('id'=>'club_project_id')),
        'fee_order_num' => array(self::BELONGS_TO, 'ClubMembershipFeeDataList', array('order_num'=>'order_num')),
        'base_club_type' => array(self::BELONGS_TO, 'BaseCode', 'club_type'),
        'base_partnership_type' => array(self::BELONGS_TO, 'BaseCode', 'partnership_type'),
		'mall_data_num' => array(self::BELONGS_TO, 'MallSalesOrderData', array('order_num'=>'order_num')),
		'auditAdmin' => array(self::BELONGS_TO, 'QmddAdministrators', 'audit_adminid'),
		'sendAdmin' => array(self::BELONGS_TO, 'QmddAdministrators', 'send_adminid'),
		'confirmAdmin' => array(self::BELONGS_TO, 'QmddAdministrators', array('confirm_adminid', 'send_adminname')),
        );
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
        'id' => 'ID',
        'club_id' => '单位',
		'club_name'=>'服务平台名称',
        'p_code' => '单位管理账号',
        'project_order' => '序号',
        'project_id' => '注册项目',
        'project_name' => '项目名称',
        'qualification_pics' => '资质证明',
        'apply_content' => '申请原因',
        'project_state' => '项目状态',
        'state_name' => '项目状态',
        'project_level' => '项目等级',
        'level_name' => '等级',
        'project_credit' => '项目积分',
        'approve_state' => '入驻方式',
        'approve_state_name' => '入驻方式',
        'auth_state' => '认证状态',
        'auth_state_name' => '认证状态',
        'pay_way' => '收费方式',
        'pay_way_name' => '收费方式',
        'uDate' => '操作日期',
        'effective_date' => '注册时间',
        'add_time' => '申请时间',
        'valid_until' => '项目有效期',
        'state' => '审核状态',
        'refuse_state_name' => '审核状态',
        'admin_gfid' => '管理员',
        'admin_gfname' => '管理员名称',
        'send_adminid' => '操作员',
        'send_adminname' => '通知操作员',
        'confirm_adminid' => '操作员',
        'confirm_adminname' => '通知操作员',
        'refuse' => '操作备注',
        'order_num' => '支付订单号',
        'cost_admission' => '入驻费用',
        'free_charge' => '入驻免费（优惠）',
        'cost_account' => '实付金额',  // 实际缴费
        'entry_validity' => '入驻有效期',
        'cost_oper' => '入驻费操作员',
        'renew' => '续费',
        'renew_free' => '续费免费',//
        'renew_date' => '续费到期',
        'renew_order_num' => '续费编码',
        'renew_oper' => '续费操作员',
        'club_type' => '单位类型',  // 8双创单位 9gf官方社区 189战略合作伙伴 380供应商',
        'club_type_name' => '单位类型',
        'partnership_type' => '单位类别',  // 单位类型二级 
        'partnership_name' => '二级名称',
        'qualifications_person' => '',
        'qualification_club' => '',
        'send_oper'=>'通知人',
        'send_date'=>'通知时间',
        'cut_date'=>'缴费截止时间',
        'free_state_Id'=>'缴费状态',
        'free_state_name'=>'缴费状态',
        'pay_blueprint'=>'费用方案',
        'pay_blueprint_name'=>'缴费方案',
        'lock_date_start'=>'冻结开始',
        'lock_date_end'=>'冻结结束',
        'lock_reason'=>'冻结原因',
        'lock_time'=>'操作时间',
		'audit_adminid' => '审核员',
        'audit_adminname' => '操作员',
        'audit_time' => '审核时间'
    );
    }

    public function picLabels() {return 'qualification_pics';}
    public function pathLabels(){ return '';}

	protected function beforeSave() {
        parent::beforeSave();
		if ($this->isNewRecord) {
			$this->add_time = date('Y-m-d H:i:s');
        }
        $this->admin_gfid = Yii::app()->session['gfid'];
        $this->admin_gfname = Yii::app()->session['gfnick'];
        $this->uDate = date('Y-m-d H:i:s');
        return true;
    }

	public function getClubProject2($club_id) {
        return $this->findAll('club_id='.$club_id);
    }

    public function getCode_id2($club_id) {
        $tmp= $this->getClubProject2($club_id);
        return toIoArray($tmp,'id,project_id,project_name');
    }

	public function getClubProject() {
        $tmp= $this->findAll('state<>373 and free_state_Id<>1400');
        return toIoArray($tmp,'id,club_id,project_id');;
    }
    public function getProject($club_id) {
        return $this->findAll('club_id='.$club_id);
    }

    public function saveProject($model){
        $pid=$model->enter_project_id;
        $club_id=$model->id;
        if(!empty($pid)){
            $tmp=ClubProject::model()->find('club_id='.$club_id.' and project_id='.$pid);
            if(empty($tmp)){
                $tmp = new ClubProject();
                $tmp->isNewRecord=true;
                unset($tmp->id);
            }
            $s1='club_id:id,p_code:club_code,project_id:enter_project_id,';
            $s1.='club_type,club_type_name,ppartnership_type,partnership_name,';
            $s1.='approve_state';
            $tmp-> getFrom($model,$s1);
            $tmp->qualification_pics =ClubListPic::model()->getPics($club_id);
            $tmp->state = $model->state;
            $tmp->auth_state = 1;
            $tmp->save();  
        }
    }
}
