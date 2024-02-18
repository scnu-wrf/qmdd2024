<?php

class VideoLivePrograms extends BaseModel {

    public $programs_list = '';
    public function tableName() {
        return '{{video_live_programs}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('live_id', 'required', 'message' => '所属直播 不能为空'),
            array('programs_list', 'required', 'message' => '{attribute} 不能为空'),
            array('program_type,live_id', 'numerical', 'integerOnly' => true),
            array('program_code,title,program_time,program_end_time,uDate,playback_url,duration', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'video_live' => array(self::BELONGS_TO, 'VideoLive', 'live_id'),
            'basecode' => array(self::BELONGS_TO, 'BaseCode', 'online'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => '节目名称',
            'program_code' => '节目单号',
            'program_type' => '节目状态',
            'program_time' => '开始时间',
            'program_end_time' => '结束时间',
            'uDate' => '消息插入时间',
            'live_id' => '直播名称',
            'playback_url' => '回放地址',
            'duration' => '视频时长',
            'online' => '状态',
            'programs_list' => '直播节目单',
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
 /*       
        if ($this->isNewRecord) {
            // 生成节目单编号
            $service_code = '';
            $live= VideoLive::model()->find('id='.$this->live_id);
            $service_code=$live->code;
            $code_num ='01';
            $live_program=$model->find('live_id=' . $live->id . ' and program_code is not null order by program_code DESC');
            if (!empty($live_program)) {
                $num=intval(substr($live_program->program_code, -2));
                $code_num = substr('00' . strval($num + 1), -2);
            }
            $service_code.=$code_num;
            $this->program_code = $service_code;
        } 
*/

        
        $this->uDate = date('Y-m-d H:i:s');

        return true;
    }

}
