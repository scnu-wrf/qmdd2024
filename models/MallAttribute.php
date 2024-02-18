<?php

class MallAttribute extends BaseModel {

    public function tableName() {
        return '{{mall_attribute}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('attr_name', 'required', 'message' => '{attribute} 不能为空'),
            array('attr_type', 'required', 'message' => '{attribute} 不能为空'),
            array('if_del', 'required', 'message' => '{attribute} 不能为空'), 
			array('attr_value', 'length', 'allowEmpty'=> true),
            array('attr_code,attr_name,attr_type,if_del,attr_value,parent', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'attrtype' => array(self::BELONGS_TO, 'BaseCode', 'attr_type'),
			'ifdel' => array(self::BELONGS_TO, 'BaseCode', 'if_del'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
		    'id' =>'ID',
            'attr_code' =>'财务编号',
            'attr_name' => '属性名',
            'attr_type' => '类型',
            'if_del' => '是否删除',
            'attr_value' => '属性值',
			'add_date' => '更新时间',
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
	
	public function getColor($fater_id) {
        return $this->findAll('parent=' . $fater_id);
    }
	
	public function getAttr2() {
        $cooperation= $this->getAttr2_all();
         $array = array();$i=0;
        foreach ($cooperation as $v) {
                $array[$i]['id'] = $v->id;
				$array[$i]['parent'] = $v->parent;
                $array[$i]['attr_name'] = $v->attr_name;
                $array[$i]['attr_value'] = $v->attr_value;
                $i=$i+1;
        }
        return $array;
    }

   public function getAttr2_all() {
        return  $this->findAll();
    }

}
