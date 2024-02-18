<?php

class BoutiqueVideoClickRecord extends BaseModel {

    public function tableName() {
        return '{{boutique_video_click_record}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
  'boutiquevideo' => array(self::BELONGS_TO, 'boutiquevideo', 'video_id'),
//  'boutiquevideoseries' => array(self::BELONGS_TO, 'boutiqueVideoSeries', 'video_series_id'),
   
            );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array();
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
