<?php

class GfPartnerMemberValues extends BaseModel {

    public function tableName() {
        return '{{gf_partner_member_values}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('set_input_id,set_id,attr_values,attr_input_type', 'safe'),
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
        return array(
            'id' => 'ID',
            'attr_input_type' => '录入方式',
            'attr_values' => '可选属性值',
            'attr_unit' => '属性单位',
            'effective_date'=>'有效期天数',
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

        //$this->uDate = date('Y-m-d H:i:s');

        return true;
    }

   

}
