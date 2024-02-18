<?php

class ClubNewsRecommend extends BaseModel {

    public function tableName() {
        return '{{club_news_recommend}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('news_id,recommend_clubid', 'numerical', 'integerOnly' => true),
            array('news_id,recommend_clubid', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'club_news' => array(self::BELONGS_TO, 'ClubNews', 'news_id'),
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'recommend_clubid'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'news_id' => '信息源',
            'recommend_clubid' => '推荐到单位',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
