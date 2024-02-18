<?php

class MallAttributeType extends BaseModel {

    public function tableName() {
        return '{{mall_attribute_type}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {

        return array(
            //version_code
            array('cat_name', 'required', 'message' => '{attribute} 不能为空'),
            array('attr_group', 'required', 'message' => '{attribute} 不能为空'),
            array('enabled', 'required', 'message' => '{attribute} 不能为空'),
 
            array('cat_id,cat_name,enabled,attr_group','safe'),

        );
    }



    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
           // 'attrtype' => array(self::BELONGS_TO, 'BaseCode', 'attr_type'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
		    'cat_id' =>'ID',
            'cat_name' =>'商品类型名称',
            'attr_group'=>'属性分组',
            'enabled'=>'状态',
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
	
	public function getAttr_type2() {
        $cooperation= MallAttributeInputSet::model()->getAttr_type2_all();
         $arr = array();$r=0;
        foreach ($cooperation as $v) {
			    $arr[$r]['attr_id'] = $v->attr_id;
                $arr[$r]['cat_id'] = $v->cat_id;
                $arr[$r]['cat_name'] = $v->attr_name;
                $r=$r+1;
        }
        return $arr;
    }



}
