<?php

class VideoSeries extends BaseModel {

	public $programs_list = '';
	public $video_classify_name = '';
	public $publish_classify_name = '';
    public function tableName() {
        return '{{boutique_video_series_publish}}';
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
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => '视频集ID',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}
