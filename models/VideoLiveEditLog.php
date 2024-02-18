<?php

class VideoLiveEditLog extends BaseModel {

    public $project_list = '';
    public $programs_list = '';
    public $intro_temp = '';
    public $persons = '';
    public $content = '';

    public function tableName() {
        return '{{video_live_edit_log}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('code, udate', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array();
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => '更新编号',
            'udate' => '更改日期',
            'admin_id' => '管理员ID',
            'admin_nick' => '管理员昵称'
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
