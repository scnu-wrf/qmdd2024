<?php

class MallAttributeValue extends BaseModel {

    public function tableName() {
        return '{{mall_attribute_value}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
           // array('product_id', 'required', 'message' => '{attribute} 不能为空'),
			//array('cat_id', 'required', 'message' => '{attribute} 不能为空'),
			//array('mall_attr_id', 'required', 'message' => '{attribute} 不能为空'),
            array('product_id,cat_id,mall_attr_id,attr_value', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'mall_products' => array(self::BELONGS_TO, 'MallProducts', 'product_id'),
			'mall_attribute_type' => array(self::BELONGS_TO, 'MallAttributeType', 'cat_id'),
			'mall_attribute_inputSet' => array(self::BELONGS_TO, 'MallAttributeInputSet', 'mall_attr_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'product_id' => '商品',
            'cat_id' => '商品类型',
            'mall_attr_id' => '商品属性',
			'attr_value' => '属性值',
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
