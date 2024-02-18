<?php

class SensitiveWords extends BaseModel {

    public function tableName() {
        return '{{sensitive_words}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            // array('sensitive_type', 'required', 'message' => '{attribute} 不能为空'),
            // array('sensitive_type_name', 'required', 'message' => '{attribute} 不能为空'),
            array('sensitive_content', 'required', 'message' => '{attribute} 不能为空'),

            array('sensitive_type, sensitive_type_name, sensitive_content' ,'safe'),
        );
    }


    public function attributeLabels() {
        return array(
            'sensitive_type' => '敏感类型',
            'sensitive_type_name'=> '敏感词类型名称',
            'sensitive_content'=> '敏感词内容',

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
