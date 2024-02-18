<?php

class GfIdelUserNumberLevel extends BaseModel {

	public $not_null = '123';
    public function tableName() {
        return '{{gf_idel_user_number_level}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
			array('not_null', 'required', 'message' => '{attribute} 不能为空'),
            array('id,level_name,create_time', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
			'base_state' => array(self::BELONGS_TO, 'BaseCode', 'state'),
			'f_vip_state' => array(self::BELONGS_TO, 'BaseCode', 'f_vip'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
		    'id' => 'ID',
			'level_name' => '星级名称',
			'create_time' => '创建时间',
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
