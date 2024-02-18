<?php

class GfPartnerMemberInputset extends BaseModel {

    public $attr_values_lsit = '';
    public $program_list = '';
    
    public function tableName() {
        return '{{gf_partner_member_inputset}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            // array('set_id', 'required', 'message' => '{attribute} 不能为空'),
            array('attr_name', 'required', 'message' => '{attribute} 不能为空'),
            array('type', 'required', 'message' => '{attribute} 不能为空'),
            array('attr_input_type', 'required', 'message' => '{attribute} 不能为空'),
            //array('attr_unit', 'required', 'message' => '{attribute} 不能为空'),
            //array('attr_values', 'required', 'message' => '{attribute} 不能为空'),
            // array('sort_order', 'required', 'message' => '{attribute} 不能为空'),
            array('attr_name,set_id,type,attr_input_type,attr_unit,sort_order,adminid','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'units' => array(self::BELONGS_TO, 'BaseCode', 'type'),
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'attr_input_type'),
            'gf_partner_member_set' => array(self::BELONGS_TO, 'GfPartnerMemberSet',array('set_id' => 'id')),
            'isInvite' => array(self::BELONGS_TO, 'BaseCode', 'is_invite'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id'=>'ID',
            'set_id' => '会员入驻id',
            'apply_name'=>'录入方式',//关联base_code表INPUT类型id：720手功录入+下拉选择
            'apply_address'=>'申请单位地址',//关联base_code表INPUT类型id： 678-从列表中选择
            'attr_name' => '属性名称',
            'attr_unit' => '属性单位',
            'attr_input_type' => '属性录入方式',  // 关联base_code表INPUT类型id：677-手工录入 678-从列表中选择 681-多行文本框 682-从列表中选择+收费 683-文件上传 720手功录入+下拉选择'
            'attr_combo_id' => '选项类型',
            'sort_order' => '排序',
            'attr_values'=> '可选属性值',
            'type'=> '会员类型',//关联base_code表INDIVIDUAL类型， id:403个人，404单位
            'sort_order' => '排序号',
            'test_str' => '',
            'adminid' => '管理员'
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
        return true;
    }

}
