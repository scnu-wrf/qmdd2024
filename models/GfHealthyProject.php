<?php

class GfHealthyProject extends BaseModel {

    public function tableName() {
        return '{{gf_healthy_project}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            // 'base_code' => array(self::BELONGS_TO, 'BaseCode', 'attr_input_type'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            `id` => 'ID',
            `healthy_id` => '体检项目ID',  // 关联gf_healthy_model表id'
            `project_id` => '项目ID',
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
