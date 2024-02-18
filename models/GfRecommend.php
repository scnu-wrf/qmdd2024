<?php

class GfRecommend extends BaseModel {

    public function tableName() {
        return '{{gf_recommend}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('video_live_id', 'numerical', 'integerOnly' => true),
            array('video_live_id,recommend_club_id,club_id,recommend_type', 'safe'),
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
            'video_live_id' => '推送内容ID',
            'video_live_code' => '推送内容编号',
            'video_live_title' => '推送内容名称',
            'recommend_club_id' => '推送到单位',
            'recommend_type' => '推送类型',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
