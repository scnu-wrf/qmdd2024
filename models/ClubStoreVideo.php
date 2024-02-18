<?php

class ClubStoreVideo extends BaseModel {

    public $show=0;
    
    public function tableName() {
        return '{{club_store_video}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        $s2='course_id,video_pic,video_title,video_duration,video_id';
        if($this->show==0){
            $a = array(
                array($s2,'safe'),
            );
        } else{
            $a = array(
                array($s2,'safe'),
            );
        }
        return $a;
    }

    public function check_save($show) {
        $this->show=$show;
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'gf_material' => array(self::BELONGS_TO, 'GfMaterial', 'video_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => '自增id',
            'video_pic' => '课程缩略图',
            'video_title' => '视频标题',
            'video_duration' => '视频时长',
            'video_id' => '视频内容',
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
