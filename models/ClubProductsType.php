<?php

class ClubProductsType extends BaseModel {
    public function tableName() {
        return '{{club_products_type}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('ct_code', 'required', 'message' => '{attribute} 不能为空'),
            array('ct_name', 'required', 'message' => '{attribute} 不能为空'),
            array('ct_code,ct_name,ct_mark,fater_id','safe',), 
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
		);
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'ct_code' => '经营类目编码',
			'ct_name' => '经营类目名称',
			'ct_mark' => '经营类目级别',
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
