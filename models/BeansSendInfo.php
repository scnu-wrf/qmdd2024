<?php

class BeansSendInfo extends BaseModel {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{beans_send_info}}';
    }

   public function rules() {
      return $this->attributeRule();
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }
    public function attributeSets() {
        return array(
        return array(
            'id' => 'ID',
            'code' => '方案编号',
            'name' => '方案标题',
            'admin_id' => '申请人',
            'admin_gfnick' => '申请人',
            'add_time' => '申请时间',
            'f_userid' => '审批人',
            'f_username' => '审批人',
            'check_time' => '审批时间',
            'opinion' => '审批意见',
            'remark' => '方案备注',
            'state' => '状态',
            'state_name' => '审核状态',
            'uDate' => '操作时间',
        );
    }

    protected function beforeSave() {
        parent::beforeSave();

        return true;
    }

}
