<?php

class GfMemberInsurance extends BaseModel {

    public $user_list = '';

    public function tableName() {
        return '{{gf_member_insurance}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            // array('gf_name', 'required', 'message' => '{attribute} 不能为空'),
            // array('health_date', 'required', 'message' => '{attribute} 不能为空'),
            // array('health_state', 'required', 'message' => '{attribute} 不能为空'),
            // array('gf_account', 'required', 'message' => '{attribute} 不能为空'), 
            array('policy_code,policy_number,gf_id,gf_account,gf_name,gf_phone,id_card_type,id_card,company_id,insurance_type,insurance_item,insurance_date_star,insurance_date_end,insurance_img,user_type,user_service,user_service_name,user_service_data,user_service_data_name,shopping_type,shopping_address,product_data_id,state','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            //'base_code' => array(self::BELONGS_TO, 'BaseCode', 'health_state'),
			'user_insurance' => array(self::HAS_MANY, 'GfInsuredInsurance', array('insurance_id' => 'id')),
            'userservice' => array(self::BELONGS_TO, 'GameList', 'user_service'),
			'userservice_data' => array(self::BELONGS_TO, 'GameListData', 'user_service_data'),
            'in_type' => array(self::BELONGS_TO, 'MallProductsTypeSname','insurance_type'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' =>'ID',
            'policy_code' =>'流水号',
			'policy_number' =>'保险单号',
            'gf_id' => '用户',//关联userlist表id
            'gf_account' => '帐号',
            'gf_name' => '姓名',
            'company_id' => '保险公司', 
            'company_name' => '保险公司',
            'insurance_type' => '保险类型',
            'insurance_date_star' => '生效日期',
            'insurance_date_end' => '保障期限',
            'insurance_img' => '保险证明',
			'product_data_id' => '商品属性',
			
			'gf_phone' =>'联系电话',
            'id_card_type' =>'证件类型',
			'id_card' =>'证件号',
            'insurance_item' => '投保方式',
            'user_type' => '服务类型',
            'user_service' => '服务名称',
            'user_service_name' => '服务名称', 
            'user_service_data' => '服务规格',
            'user_service_data_name' => '服务规格',
			'shopping_type' =>'购买方式',
            'id_card_type' =>'证件类型',
			'shopping_address' =>'购买地址',
			'state' =>'审核状态',
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
