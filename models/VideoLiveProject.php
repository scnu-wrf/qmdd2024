<?php

class VideoLiveProject extends BaseModel {

    public function tableName() {
        return '{{video_live_project}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('video_live_id,project_id', 'numerical', 'integerOnly' => true),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'video_live' => array(self::BELONGS_TO, 'VideoLive', 'video_live_id'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'video_live_id' => '直播频道',
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
