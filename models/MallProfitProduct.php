<?php

class MallProfitProduct extends BaseModel {

    public function tableName() {
        return '{{mall_profit_product}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
		   //array('event_title', 'required', 'message' => '{attribute} 不能为空'),
		   array('info_id,product_code,product_name,json_attr,star_time,end_time', 'safe'),
        
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
			'info' => array(self::BELONGS_TO, 'MallProfitInfo', 'info_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
		    'id' =>'ID',
            'info_id' => '结算毛利方案',
			'product_code' => '商品编号',
            'product_name' => '商品名称',
            'json_attr' => '型号规格',

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
            //$this->u_date = date('Y-m-d H:i:s');
        }
        return true;
    }

}
