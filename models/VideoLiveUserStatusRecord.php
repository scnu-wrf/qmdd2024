<?php

class VideoLiveUserStatusRecord extends BaseModel{
	public $invite_count = '';
	public $GF_ACCOUNT = '';
	public $GF_NAME = '';

    public function tableName() {
        return '{{video_live_user_status_record}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('live_id,live_program_id,live_program_title,live_program_time,live_program_end_time,login_id,
                    s_gfid,s_gfaccount,m_type,add_time,inviter_gfid,last_time','safe'),
        );
    }

    /**
     * 模型验证规则
     */
    public function relations() {
        return array(
            
        );
    }

    /**
     * 属性
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'live_msg_code' => '年月日_id',  // 如20190328_68',
            'live_id' => '直播名称',  // 表明哪条直播频道',
            'live_program_id' => '直播节目id',  // video_live_programs表ID,
            'live_program_title' => '节目单名称 ',
            'live_program_time' => '直播开始时间',
            'live_program_end_time' => '直播结束时间',
            'login_id' => '发送GF_ID', // 对应表gf_user_login_history的id',
            's_gfid' => '发送者', 
            's_gfaccount' => '发送者账号',
            's_gfname' => '发送者昵称',
            'add_time' => '发送时间',
            'm_type' => '消息类型',  // 33-用户进入直播，34-用户离开直播,35-直播结束
            'inviter_gfid' => '直播邀请人',//直播邀请人gfid，用户进入直播时填入，可用于统计邀请榜
            'last_time' => '观看视频时长',//单位秒，m_type=34,且live_program_id为回放直播时，记录其离开时观看视频时长
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        parent::beforeSave();
        return true;
    }
}