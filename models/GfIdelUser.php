<?php

class GfIdelUser extends BaseModel {

    public function tableName() {
        return '{{gf_idel_user}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('id,non_account,is_use', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
			'base_state' => array(self::BELONGS_TO, 'BaseCode', 'state'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
		    'id' => 'ID',
            'non_account' => '未注册号码',
            'is_use' => '是否在使用0否，1在用,-1 表示占用',
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
