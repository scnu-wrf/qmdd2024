<?php

class AdvertisementInsert extends BaseModel {

    public function tableName() {
        return '{{advertisement_insert}}';
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
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'id'),
			'boutique_video' => array(self::BELONGS_TO, 'BoutiqueVideo', 'id'),
			'video_live' => array(self::BELONGS_TO, 'VideoLive', 'id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'club_id' => '单位',
            'video_id' => '点播',
			'live_id' => '直播',
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
