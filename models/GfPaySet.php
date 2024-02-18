<?php

class GfPaySet extends BaseModel {

    public function tableName() {
        return '{{gf_pay_set}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(

        );
    }


    public function attributeLabels() {
        return array(
            'pay_name' => '支付类型名称',
            'pay_dispay_name'=> '支付方式显示名称',


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
