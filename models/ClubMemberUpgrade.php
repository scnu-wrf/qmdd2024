<?php

class ClubMemberUpgrade extends BaseModel {


    public $location ='';
    public function tableName() {
        return '{{club_member_upgrade}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('auth_state,free_state_Id,send_date,cut_date,pay_blueprint,pay_blueprint_name,pay_way,send_oper', 'safe'),
        );
    }
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'gfUser' => array(self::BELONGS_TO, 'userlist', 'gf_id'),
            'member' => array(self::BELONGS_TO, 'ClubMemberList', ['project_id'=>'member_project_id','gf_id'=>'member_gfid']),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => '内部自增id',
            'gf_id' =>'id',
            'GF_ACCOUNT' => '账号',
            'ZSXM' => '姓名',
            'project_id' =>  '注册项目',
            'project_name' => '项目名称',
            'member_level' => '注册等级',
            'member_level_xh' => '成员的项目龙虎等级序号',
            'member_level_name' => '龙虎级别名称',
            'achieve_time' => '达到该积分的时间',
            'order_num' => '缴费单号',
            'auth_state' => '注册状态',
            'auth_state_name' =>'',
            'free_state_Id' => '支付状态',
            'free_state_name' => '支付状态',
            'send_date' => '通知时间',
            'cut_date' => '缴费截止日期',
            'is_pay' => '支付状态，463未支付  464已支付',
            'grade_achieve_time' => '确认时间',
            'cost_admission'=> '注册费用(元)',
            'free_charge'=> '入驻免费（优惠）',
            'cost_account'=> '实付金额',
            'entry_validity' => '入驻有效期',
            'cost_oper' => '入驻费处理操作员',
            'renew'=> '续费',
            'renew_free'=> '续费免费（优惠）',
            'renew_date' => '续费到期实际',
            'renew_order_num' => '续费单号',
            'renew_oper'=> '续费费处理操作员',
            'add_time' => '申请时间',
            'integral' => '当前龙虎积分',
            'pay_blueprint' => '缴费方案',
            'pay_blueprint_name' => '缴费方案',
            'pay_way' => '收费方式',
            'pay_way_name' => '收费方式',
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

        }
        return true;
    }


}
