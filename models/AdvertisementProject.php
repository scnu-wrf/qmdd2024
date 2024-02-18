<?php

class AdvertisementProject extends BaseModel {

    public function tableName() {
        return '{{advertisement_project}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('adv_id', 'required', 'message' => '{attribute} 不能为空'),
            array('project_id', 'required', 'message' => '{attribute} 不能为空'),
            array('adv_id, project_id', 'numerical', 'integerOnly' => true),
                //array('', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'advertisement' => array(self::BELONGS_TO, 'Advertisement', 'adv_id'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'adv_id' => '广告',
            'project_id' => '项目',
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
