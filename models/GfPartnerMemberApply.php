<?php

class GfPartnerMemberApply extends BaseModel {

	//public $attr_value_name='';
    public $attr_content='';
    public $attr_value_id='';
    public $attr_pic='';
   // public $attr_unit='';
   // public $attr_name='';
    // public $attr_id='';
    public $setlist='';
    public $pay_item='';
    
    public $content = '';
    public function tableName() {
        return '{{gf_partner_member_apply}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        $s2='code,partner_code,partner_id,partner_name,type,type_name,gfid,gf_account,zsxm,id_card,club_id,club_logo,club_name,club_address,project_id,project_name,member_type_id,member_type_name,member_type_date,
        admin_id,admin_name,state,auth_state,reasons_for_failure,state_certificate_code,effective_start_time,effective_end_time,apply_time,order_num,sex,native,nation,birthdate,apply_phone,apply_address,apply_email,pcode,head_pic,certificates,resume,duty,company_type_id,company_type,company_registered_capital,fax_no,club_phone,apply_club_gfnick,apply_club_phone,certificates_number,entry_validity,apply_relieve_time,relieve_time,invite_initiator,del_initiator,check_time';
        if(!empty($_REQUEST['type'])&&$_REQUEST['type']==403){
            if($_REQUEST['r']=='gfPartnerMemberApply/create'){
                return array(
                    array('partner_id', 'required', 'message' => '{attribute} 不能为空'),
                    array('project_id', 'required', 'message' => '{attribute} 不能为空'),
                    array($s2,'safe'),
                );
            }else{
                return array(
                    array('code', 'required', 'message' => '{attribute} 不能为空'),
                    array('partner_id', 'required', 'message' => '{attribute} 不能为空'),
                    array('project_id', 'required', 'message' => '{attribute} 不能为空'),
                    array('gf_account', 'required', 'message' => '{attribute} 不能为空'),
                    array($s2,'safe'),
                );
            }
        }elseif(!empty($_REQUEST['type'])&&$_REQUEST['type']==404){
            if($_REQUEST['r']=='gfPartnerMemberApply/create'||$_REQUEST['r']=='gfPartnerMemberApply/create_club'||$this->auth_state==1485||$this->auth_state==929){
                return array(
                    array('type', 'required', 'message' => '{attribute} 不能为空'),
                    array('partner_id', 'required', 'message' => '{attribute} 不能为空'),
                    array('project_id', 'required', 'message' => '{attribute} 不能为空'),
                    array($s2,'safe'),
                );
            }elseif($_REQUEST['r']=='gfPartnerMemberApply/update'){
                return array(
                    array('code', 'required', 'message' => '{attribute} 不能为空'),
                    array('type', 'required', 'message' => '{attribute} 不能为空'),
                    array('project_id', 'required', 'message' => '{attribute} 不能为空'),
                    array('partner_id', 'required', 'message' => '{attribute} 不能为空'),
                    array($s2,'safe'),
                );
            }else{
                return array(
                    array($s2,'safe'),
                );
            }
        }else{
            return array(
                array($s2,'safe'),
            );
        }
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_code_type' => array(self::BELONGS_TO, 'BaseCode', 'type'),
            'base_code_state' => array(self::BELONGS_TO, 'BaseCode', 'auth_state'),
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
            'partner_club' => array(self::BELONGS_TO, 'ClubList', 'partner_id'),
            'content' => array(self::BELONGS_TO, 'GfPartnerMemberContent', 'id'),
            'gf_values' => array(self::BELONGS_TO, 'GfPartnerMemberValues', array('member_type_id'=>'id')),
            'gf_user' => array(self::BELONGS_TO, 'userlist', 'gfid'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' =>'会员编号',//入驻编号,规则年份+月份+四位数序号，如2016050001',
            'partner_code'=>'入会单位账号',
            'partner_id' => '所属单位名称',//入会的战略伙伴ID，关联club_list表club_id值',
            'partner_name' => '所属单位名称',
            'type' => '会员类型',//类型，关联base_code表INDIVIDUAL类型， id:403个人，404单位',
            'type_name' => '类型名称',
            'gfid' => '申请人id',//申请人GF_ID，关联userlist表id',
            'gf_account' => '账号',//申请人GF_ID，关联userlist表id',
            'zsxm' => '姓名', //真实姓名
            'sex' => '性别',
            'id_card' => '身份证号',
            'native' => '籍贯',
            'nation' => '民族',
            'birthdate' => '出生年月', 
            'apply_phone' => '联系电话',
            'apply_address' => '联系地址',
            'apply_email' => '电子邮箱',
            'pcode' => '邮政编码',
            'head_pic' => '免冠头像',
            'certificates' => '证书上传',
            'resume' => '个人简历',
            'duty' => '工作单位',
            'club_id' => '申请单位',//加入的社区单位ID，type=404单位时，关联club_list表club_id值,如不在平台上的单位该值为NULL',
            'club_code' => '申请单位账号',
            'club_logo' => '单位图标',
            'club_name' => '申请单位名称',
            'club_region' => '所在地区',
            'club_address' => '单位地址',
            'club_phone' => '联系电话',
            'company_type_id' => '单位性质',
            'company_type' => '单位性质',
            'company_registered_capital' => '注册资金',
            'fax_no' => '传真号码',
            'project_id' => '入会项目',//入会项目ID，关联project_list表ID',
            'project_name' => '入会项目',
            'member_type_id' => '会员类型',//会员类型ID，关联gf_partner_member_values表ID',
            'member_type_name' => '会员类型',
            'member_type_date' => '会员有效期天数',
            'admin_id' => '管理员ID',
            'admin_name' => '管理员名称',
			'state' => '审核状态',//审核状态 371-374',
			'state_name' => '状态',
            'auth_state' => '状态',
            'auth_state_name' => '会员状态名称',
            'reasons_for_failure' => '操作备注',//审核未通过原因，state状态等于1时才有',
            'state_certificate_code' => '会员编号',
            'entry_validity' => '加入日期',// '证书有效开始时间',
            'effective_start_time' => '入会时间',// '证书有效开始时间',
            'effective_end_time' => '到期时间',// '证书有效结束时间',
            'apply_time' => '申请时间',
            'order_num' => '订单号',//订单号，关联表mall_sales_order_info表order_num',
            'update' => '审核日期',
            'attr_content' => '属性值内容',
            'attr_unit' => '属性单位',
            'attr_pic' => '属性附件',
            'apply_club_gfnick' => '法定代表人',
            'apply_club_phone' => '法定人联系电话',
            'certificates_number' => '统一信用证号码',
            'apply_relieve_time' => '申请解除时间',
            'relieve_time' => '正式解除时间',
            'invite_initiator' => '邀请方/申请方发起者 502单位   210会员',
            'del_initiator' => '解除发起方  502单位   210会员',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    protected function afterFind() {
        parent::afterFind();
        return true;
    }
    
    protected function beforeSave() {
        parent::beforeSave();
        if ($this->isNewRecord) {
            $this->apply_time = date('Y-m-d H:i:s');
        }
        $this->admin_id = Yii::app()->session['admin_id'];
        $this->admin_name = Yii::app()->session['gfnick'];
        $this->update = date('Y-m-d H:i:s');
        return true;
    }

}
