<?php

class GfKnowledgeBaseRelation extends BaseModel {

	public $not_null = '123';
    public function tableName() {
        return '{{gf_knowledge_base_relation}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
			array('pro_id', 'required', 'message' => '{attribute} 不能为空'),
			array('relation_pro_id', 'required', 'message' => '{attribute} 不能为空'),
            array('id,pro_id,relation_pro_id', 'safe'),
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
			'pro_id' => '问题ID',
			'relation_pro_id' => '关联问题ID',
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
