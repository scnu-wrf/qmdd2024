<?php

class GfKnowledgeBase extends BaseModel {

	public $not_null = '123';
	public $tible = '123';
    public function tableName() {
        return '{{gf_knowledge_base}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
			array('problem_title', 'required', 'message' => '{attribute} 不能为空'),
			array('reply_content', 'required', 'message' => '{attribute} 不能为空'),
			array('keywords', 'required', 'message' => '{attribute} 不能为空'),
			array('type_id', 'required', 'message' => '{attribute} 不能为空'),
			array('validity_type', 'required', 'message' => '{attribute} 不能为空'),
            array('id,problem_title,reply_content,keywords,club_id,type_id,validity_type', 'safe'),
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
			'type_id' => '选择分类',//分类ID
			'type_name' => '分类名称',
			'problem_title' => '问题标题',
			'keywords' => '关健字(多个关健字使用“,”分开)',
			'reply_content' => '回复内容',
			'validity_type' => '生效时间',//是否永久有效，648=否，649是
			'validity_add_time' => '有效开始时间',//(时间戳)
			'validity_last_time' => '有效结束时间',//(时间戳)
			'club_id' => '单位ID',
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
