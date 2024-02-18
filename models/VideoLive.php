<?php

class VideoLive extends BaseModel {

    public $project_list = '';
    public $programs_list = '';
    public $intro_temp = '';
    public $persons = '';
    public $content = '';
	public $cult = '';

    public function tableName() {
        return '{{video_live}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('club_id', 'required', 'message' => '{attribute} 不能为空'),
            array('title', 'required', 'message' => '{attribute} 不能为空'),
            array('live_type', 'required', 'message' => '{attribute} 不能为空'),
            array('is_single', 'required', 'message' => '{attribute} 不能为空'),
            array('live_start_check', 'required', 'message' => '{attribute} 不能为空'),
            array('live_end_check', 'required', 'message' => '{attribute} 不能为空'),
            array('once_time', 'required', 'message' => '{attribute} 不能为空'),
            array('airtime_check', 'required', 'message' => '{attribute} 不能为空'),
            array('total_time', 'required', 'message' => '{attribute} 不能为空'),
            array('club_contacts', 'required', 'message' => '{attribute} 不能为空'),
            array('address', 'required', 'message' => '{attribute} 不能为空'),
            array('club_contacts_phone', 'required', 'message' => '{attribute} 不能为空'),
            array('live_address', 'required', 'message' => '{attribute} 不能为空'),
            array('club_contacts_email', 'required', 'message' => '{attribute} 不能为空'),
            array('logo', 'required', 'message' => '{attribute} 不能为空'),
            // array('programs_list', 'required', 'message' => '{attribute} 不能为空'),
            array('live_start', 'required', 'message' => '{attribute} 不能为空'),
            array('live_end', 'required', 'message' => '{attribute} 不能为空'),
            array('live_mode', 'required', 'message' => '{attribute} 不能为空'),
            array('project_is', 'required', 'message' => '{attribute} 不能为空'),
            array('if_no_chinese', 'required', 'message' => '{attribute} 不能为空'),
            array('open_club_member', 'required', 'message' => '{attribute} 不能为空'),
            array('live_show', 'required', 'message' => '{attribute} 不能为空'),
            array('isHot, open_club_member, channelState, isRecord, clicked, is_rtmp,club_contacts_phone', 'numerical', 'integerOnly' => true),
            array('watermark_id, intro, intro_temp, live_source_RTMP, live_source_HLS_H, live_source_HLS_N, 
                    live_source_RTMP_H,live_source_RTMP_N, live_source_FLV_H, live_source_FLV_N, reasons_for_failure, if_no_chinese, 
                    club_name, live_address, longitude, latitude,channel_id,state,recommend_type,live_source_time,
                    live_source_secret,checkin_code,checkin_img,live_state,live_state_time,state_time,live_state_reasons_for_failure,
					live_state_admin_id,live_state_admin_nick,admin_id,admin_nick,if_del,is_online,
                    is_reward,is_talk,line_show,open_comments,is_uplist,is_reward_state,is_reward_time,is_reward_admin_id,
                    is_reward_add_time,is_reward_admin_name,is_reward_oper_time,club_contacts_email,project_is,live_mode,
                    live_show,viewers,gf_price,member_price,t_duration,leader,leader_phone,guest,live_content,barrage,director,camera,
					monitor,toning,media,apply_time,check_time,playback_is,online_users,cut_title,cut_type,cut_size,cut_material_id,address,
					is_single,once_time,total_time,live_start_check,live_end_check,airtime_check', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            //'club_store_train' => array(self::BELONGS_TO, 'ClubStoreTrain', 'belong_id', 'condition' => 't.belong_id=723'),
            //'game_list' => array(self::BELONGS_TO, 'GameList', 'belong_id', 'condition' => 't.belong_id=705'),
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'state'),
            'gf_watermark' => array(self::BELONGS_TO, 'GfWatermark', 'watermark_id'),
            'livetype' => array(self::BELONGS_TO, 'VideoClassify', 'live_type'),
			'video_live_programs' => array(self::HAS_MANY, 'VideoLivePrograms', array('live_id' => 'id')),
			'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
            'livebelong' => array(self::BELONGS_TO, 'BaseCode', 'live_belong'),
            'clubmember' => array(self::BELONGS_TO, 'BaseCode', 'open_club_member'),
            'livemode' => array(self::BELONGS_TO, 'BaseCode', 'live_mode'),
            'base_is_reward_state' => array(self::BELONGS_TO, 'BaseCode', 'is_reward_state'),
            'gfmaterial' => array(self::BELONGS_TO, 'GfMaterial', 'cut_material_id'),
            'cuttype' => array(self::BELONGS_TO, 'BaseCode', 'cut_type'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => '直播编号',
            'title' => '直播名称',
            'logo' => '缩略图',
            'isHot' => '推荐到GF视频',
            'live_type' => '直播类型',
            'watermark_id' => '水印设置',
            'intro' => '直播简介',
            'intro_project' => '直播岗位',
            'live_start' => '开始显示时间',
            'live_end' => '结束显示时间',
            'info_date' => '操作时间',
            'live_source_secret' => '推流密钥',
            'live_source_time' => '创建推流地址时间',
            'live_source_RTMP' => '推流地址',
            'live_source_RTMP_H' => 'RTMP地址 原始码率',
            'live_source_RTMP_N' => 'RTMP地址 标清码率',
            'live_source_HLS_H' => 'HLS地址 原始码率',
            'live_source_HLS_N' => 'HLS地址 标清码率',
            'live_source_FLV_H' => 'FLV地址 原始码率',
            'live_source_FLV_N' => 'FLV地址 标清码率',
            'live_belong' => '直播归类所属',
            'live_belong_name' => '直播归类所属',
            'belong_id' => '直播所属',
            'belong_name' => '直播所属名称',
            'order_num' => '排序',
            'open_club_member' => '开放观看对象',
            'open_club_member_name' => '开放观看对象名称',
            'channel_id' => '腾讯云频道ID',
            'channelState' => '频道状态',
            'isRecord' => '是否开启视频录制',
            'is_rtmp' => '是否推流',
            'is_pay' => '观看条件',
            'if_no_chinese' => '是否涉外',
            'product_id' => '收费商品ID',
            'club_id' => '直播单位',
            'club_name' => '单位名称',
            'club_contacts' => '直播负责人',
            'club_contacts_phone' => '联系电话',
            'club_contacts_email' => '联系邮箱',
            'address' => '直播地点',
            'live_address' => '定位地址',
            'longitude' => '经度',
            'latitude' => '纬度',
            'recommend_type' => '推荐至单位',
			
            'apply_time' => '申请时间',
            'live_state' => '审核状态',
            'live_state_name' => '审核状态名称',
            'live_state_time' => '审核时间',
            'live_state_reasons_for_failure' => '审核备注',//直播数据审核未通过原因，state状态等于373时才有
            'live_state_admin_id' => '操作员',//直播数据审核
            'live_state_admin_nick' => '操作员',//直播数据审核
            'cult'=>'未通过原因',
			
            'checkin_code' => '备案编号',
            'checkin_img' => '备案扫描件',
            'check_time' => '备案时间',
            'state' => '备案状态',
            'state_name' => '备案状态名称',
            'state_time' => '审核时间',
            'reasons_for_failure' => '备案备注',
            'admin_id' => '操作员',
            'admin_nick' => '操作员',
			
            'clicked' => '点击量',
            'if_del' => '是否删除',  // 648=否，649是
            'is_online' => '推流控制',  // 0，断流，1打开
            'is_reward' => '状态',  // 0，关闭打赏，1允许打开
            'is_reward_state' => '申请状态',  // 打赏申请审核状态
            'is_reward_time' => '审核时间',  // 打赏申请审核时间
            'is_reward_admin_id' => '审核员',  // 打赏审核人
            'is_reward_admin_name' => '打赏审核人名',
			'is_reward_reasons_for_failure' => '审核备注', // 赞赏审核备注
            'is_reward_add_time' => '申请日期',
            'is_reward_oper_time' => '操作时间',
            'is_talk' => '直播互动',  // 0，关闭，1打开允许
            'line_show' => '切播控制',  // 0是直播，1是切播
            'open_comments' => '直播评论',  // 0=关闭，1=打开
            'is_uplist' => '是否上架',  // 0：下架  1：上架
            'is_reward_red_packets' => '赞赏红包',
			'project_is' => '展示项目',
            'club_list' => '推荐到单位',
            'intro_temp' => '直播简介',
            'programs_list' => '直播节目单',
            'live_source_time' => '创建推流地址时间',
            'live_source_secret' => '推流密钥',
            'live_mode' => '直播方式',
            'live_show' => '直播展示位置',
            'viewers' => '预估观看人数',
            'gf_price' => 'GF会员收费',
            'member_price' => '本单位学员收费',
            't_duration' => '试看时长',

            'leader' => '总负责人',
            'leader_phone' => '联系电话',
            'guest' => '主要嘉宾',
            'live_content' => '直播内容负责人',
            'barrage' => '弹幕审核员',
            'director' => '导播',
            'camera' => '摄影摄像',
            'monitor' => '监听监看',
            'toning' => '调音台',
            'media' => '视音频',
            'playback_is' => '回放功能',
            'online_users' => '同时在线人数',

            'cut_title' => '名称',
            'cut_type' => '类型',
            'cut_size' => '规格',
            'cut_material_id' => '内容上传',

            'is_open_comments' => '直播评论',
            'gift_reward' => '礼物打赏',
			
            'is_single' => '直播场次',//1-单场，0-连续多场
            'once_time' => '单次时长（分钟）',
            'total_time' => '总时长（分钟）',
            'live_start_check' => '直播开始日期',
            'live_end_check' => '直播结束日期',
            'airtime_check' => '播出时间',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function afterFind() {
        parent::afterFind();

        if ($this->id != null) {
            $project = VideoLiveProject::model()->findAll('video_live_id=' . $this->id);
            $arr = array();
            foreach ($project as $v) {
                $arr[] = $v->project_id;
            }
            if(!empty($arr)){
                $this->project_list = implode(',', $arr);
            } else{
                $this->project_list ='';
            }

        }
		

        return true;
    }

    protected function beforeSave() {
        parent::beforeSave();

        // 图文描述处理
        $basepath = BasePath::model()->getPath(131);
        if ($this->intro_temp != '') {
            // 判断是否存储过，没有存储过则保存新文件
            if ($this->intro != '') {
                set_html($this->intro, $this->intro_temp, $basepath);
            } else {
                $rs = set_html('', $this->intro_temp, $basepath);
            }
			if (isset($rs['filename'])) {
                $this->intro = $rs['filename'];
            }
        } else {
            $this->intro = '';
        }

        if ($this->isNewRecord) {
            // 生成直播编号
            $service_code = '';
            $club = ClubList::model()->findByPk($this->club_id);
            $service_code.=substr($club->club_code, -6);
            $service_code.=date('Y');
            $service_code_start = $service_code . '0000';
            $count = $this->count('club_id=' . $this->club_id . ' AND code>' . $service_code_start);
            $code = substr('0000' . strval($count + 1), -4);
            $service_code.=$code;
            $this->code = $service_code;
            $this->state=1362;
        }

        $this->admin_id = Yii::app()->session['admin_id'];
        $this->admin_nick = Yii::app()->session['gfnick'];
        $this->info_date = date('Y-m-d H:i:s');
        $this->is_reward_oper_time = date('Y-m-d H:i:s');

        return true;
    }

}
