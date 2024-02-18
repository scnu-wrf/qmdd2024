<?php

class ClubNewsProject extends BaseModel {

    public function tableName() {
        return '{{club_news_project}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('club_news_id,project_id', 'numerical', 'integerOnly' => true),
             array('project_id,','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'club_news_id' => array(self::BELONGS_TO, 'ClubNews', 'news_id'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'club_news_id' => '信息源',
            'project_id' => '项目',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
