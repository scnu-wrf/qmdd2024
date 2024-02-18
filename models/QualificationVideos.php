<?php

class QualificationVideos extends BaseModel {


    public function tableName() {
        return '{{qualification_videos}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            //array('answer', 'required', 'message' => '{attribute} 不能为空'),
            array('qualificate_id,material_id', 'safe'),
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
            'id'=>'id',
            'video_title'=>'视频标题',
            'video_pic'=>'视频封面图片',
            'video_files'=>'视频文件ID',

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
