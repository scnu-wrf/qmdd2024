<?php

class ClubReleaseInformationRecord extends BaseModel {

    public function tableName() {
        return '{{club_release_information_record}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('id,news_type,news_id,news_title,news_pic,club_id,add_time,online_start_time,online_end_time', 'safe'),
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
