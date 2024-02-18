<?php

class GfInsuredInsurance extends BaseModel {


    public function tableName() {
        return '{{gf_insured_insurance}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            //'base_code' => array(self::BELONGS_TO, 'BaseCode', 'health_state'),
            //'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
            //'userlist' => array(self::BELONGS_TO, 'userlist', 'gf_id'),
            //'in_type' => array(self::HAS_ONE, 'MallProductsTypeSname','insurance_type'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' =>'ID',
            'insurance_id' =>'保险单id',
            'gf_id' => '用户',//关联userlist表id
            'gf_account' => '帐号',
            'gf_name' => '姓名',
			
			'gf_phone' =>'联系电话',
            'id_card_type' =>'证件类型',
			'id_card' =>'证件号',
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
