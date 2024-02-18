<?php

class MallPricing extends BaseModel {

    public function tableName() {
        return '{{mall_pricing}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('title,shopping_type,member_type,grade,discount,bean,add_date', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
           // 'mall_price_set' => array(self::BELONGS_TO, 'MallPriceSet', 'set_id'),
			//'mall_price_set_details' => array(self::BELONGS_TO, 'MallPriceSetDetails', 'set_details_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
		    'id' =>'ID',
            'title' =>'方案名称',
			'shopping_type' =>'销售方式',			
            'member_type' => '会员类型',
            'grade' => '等级',
			'discount' => '折扣率',
			'bean' => '体育豆',
            'add_date' => '添加时间',

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

			$this->add_date = date('Y-m-d h:i:s');
        }


        return true;
    }

}
