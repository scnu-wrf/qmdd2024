<?php

class VideoLiveRecommend extends BaseModel {

    public function tableName() {
        return '{{video_live_recommend}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('video_live_id', 'numerical', 'integerOnly' => true),
            array('video_live_id,recommend_club_id,club_id', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'video_live' => array(self::BELONGS_TO, 'VideoLive', 'video_live_id'),
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'club_id' => '单位信息',
            'club_code' => '单位帐号',
            'club_name' => '服务平台名称',
            'video_live_id' => '直播id',
            'video_live_code' => '直播编号',
            'video_live_title' => '直播名称',
            'recommend_club_id' => '推荐到单位',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
