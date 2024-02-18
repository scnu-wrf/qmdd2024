<?php

class MallLogistic extends BaseModel {

    public function tableName() {
        return '{{mall_logistic}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('f_code', 'required', 'message' => '{attribute} 不能为空'),
            array('f_name', 'required', 'message' => '{attribute} 不能为空'),
            array('f_mark', 'required', 'message' => '{attribute} 不能为空'),
            array('f_url', 'required', 'message' => '{attribute} 不能为空'),
            array('f_mobilec', 'required', 'message' => '{attribute} 不能为空'),
            array('f_mobilec', 'numerical', 'integerOnly' => true),
                //array('', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'f_mark'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'f_code' => '物流编号',
            'f_name' => '物流名称',
            'f_mark' => '物流类型',
            'f_url' => '连接网地址',
            'f_mobilec' => '联系电话',
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
