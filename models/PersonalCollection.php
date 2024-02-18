<?php

class PersonalCollection extends BaseModel {

    public function tableName() {
        return '{{personal_collection}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
             array('', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'remind_state'),
            'user' => array(self::BELONGS_TO, 'userlist', 'gfid'),
            'programs' => array(self::BELONGS_TO, 'VideoLivePrograms', 'news_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'if_remind' => '订阅方式',
            'news_id' => '节目单',
            'gfid' => '预约人',
            'remind_state' => '状态',
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
