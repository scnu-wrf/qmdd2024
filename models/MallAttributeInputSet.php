<?php

class MallAttributeInputSet extends BaseModel {

    public function tableName() {
        return '{{mall_attribute_inputSet}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {

        return array(
            //version_code
            array('attr_name', 'required', 'message' => '{attribute} 不能为空'),
            array('attr_type', 'required', 'message' => '{attribute} 不能为空'),
            array('sort_order', 'numerical', 'integerOnly' => true),
            
            array('attr_id,cat_id,attr_input_type,attr_values,attr_index,sort_order,is_linked,attr_group','safe'),

        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(

           'm_id' => array(self::BELONGS_TO, 'MallAttributeType', 'cat_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
		    'attr_id' =>'ID',
		    'cat_id' =>'商品类型',
            'attr_name' =>'属性名称',
            'attr_type'=>'属性类型',
            'attr_input_type'=>'属性值的录入方式',
            'attr_values'=>'可选值列表',
            'attr_index'=>'属性指标',
            'sort_order'=>'排序顺序',
            'is_linked'=>'相同属性值的商品是否关联',
            'attr_group'=>'属性组',
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
	
	public function getAttr() {
        return $this->findAll();
    }
	
	public function getAttr_type2_all() {
        return  $this->findAll();
    }

 }