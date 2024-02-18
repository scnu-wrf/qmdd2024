<?php

class EcsSessions extends BaseModel {

    public function tableName() {
        return '{{ecs_sessions}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array();
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'ecs_sessions_data' => array(self::BELONGS_TO, 'EcsSessionsData', array('sesskey' => 'sesskey')),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array();
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        return true;
    }

}