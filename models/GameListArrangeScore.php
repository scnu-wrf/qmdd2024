<?php

class  GameListArrangeScore extends BaseModel {

    public $team_data = '';
    public $team_ida = '';
    public $sign_ida = '';
    public $colour = '';
    public $game_votes_num = '';
    public $game_score = '';
    public $game_rank = '';
    public $listArrange = '';
    public $game_play_id = '';
    public $game_integral_score = '';
    public function tableName() {
        return '{{game_list_arrange}}';
    }

    /**
     * 模型验证规则
     */
     public function rules() {
        return array(
            array('code,describe,game_id,game_data_id,if_votes,rounds,matches,star_time,end_time,game_over,votes_star_time,votes_end_time,school_report,reasons_for_failure,state,state_qmddid,state_qmddname', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'game_over'),
            'game_list' => array(self::BELONGS_TO, 'GameList', 'game_id'),
            'game_list_data' => array(self::BELONGS_TO, 'GameListData', array('game_data_id'=>'id')),
            'game_list_order' => array(self::BELONGS_TO, 'GameListOrder', array('id'=>'arrange_id')),
            'game_sign_lista' => array(self::BELONGS_TO, 'GameSignList', 'sign_ida'),
            'game_sign_listb' => array(self::BELONGS_TO, 'GameSignList', 'sign_idb'),
            'game_team_tablea' => array(self::BELONGS_TO, 'GameTeamTable', 'team_ida'),
            'game_team_tableb' => array(self::BELONGS_TO, 'GameTeamTable', 'team_idb'),
            'game_team_table' => array(self::BELONGS_TO, 'GameTeamTable', 'game_player_id'),
            'base_code_game_format' => array(self::BELONGS_TO, 'BaseCode', 'game_format'),
            'base_game_player_id' => array(self::BELONGS_TO, 'BaseCode', 'game_player_id'),
            'base_is_promotion' => array(self::BELONGS_TO, 'BaseCode', 'is_promotion'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'arrange_tcode' => '赛程编码',
            'arrange_tname' => '名称',
            'arrange_code' => '赛程编码',
            'describe' => '赛程描述',
            'game_id' => '赛事',//ID,关联base_code表game_list表
            'fater_id' => '上级ID',  // 分场管理
            'game_name' => '赛事名称',
            'game_data_id' => '竞赛项目',//id,关联game_list_data表id
            'game_data_name' => '竞赛项目名称',//关联game_list_data表
            'game_area' => '赛事等级',  // 161世界级，160国家级，159省级，162社区单位级',
            'game_mode' => '赛事模式',  // 关联base_code表GAME_MODE类型ID 661考核赛 662对抗赛 663表演赛',
            'project_id' => '赛事项目',
            'game_project_name' => '赛事项目',
            'game_player_id' => '参赛团队/个人',  // 关联base_code表MAN_TEAM类型ID 665-个人 666-团队',
            'game_format' => '赛制',
            'rounds' => '轮次名称',
            'matches' => '场次名称',
            'game_site' => '比赛场地',
            'if_votes' => '是否开通投票',
            'if_votes_name' => '是否开通投票说明',
            'votes_star_time' => '投票开始时间',
            'votes_end_time' => '投票结束时间',
            'if_votes_over' => '投票状态是否完成',  // 关联base_code表yes_no类型id 648=否，649是',
            'star_time' => '比赛开始时间',//采用24小时制
            'end_time' => '比赛结束时间',//采用24小时制
            'game_date' => '添加时间',
            'game_over' => '赛事状态',//0未比赛，1在比赛，2比赛结束
            'game_over_name' => '比赛状态名称',
            'uDate' => '修改日期',
            'school_report' => '成绩单',//多图使用逗号“,”分开,路径及命名见base_parh表
            'state' =>  '状态',//关联base_code表STATE类型状态id：371-374
            'state_name' => '审核名称',
            'state_qmddid' => '审核管理员',//GFID，关联qmdd_administrators表ID
            'state_qmddname' => '管理员名称',
			'reasons_for_failure' => '审核备注',
            'game_group_name' => '循环分组名称',
			'upper_order' =>'小组晋级名次',
			'upper_code' =>'晋级编码' ,
			'game_order' =>'本场名次' ,
			'game_mark' => '本场成绩' ,
			'game_score' =>'本场得分' ,
			'group_sort_code' => '小组排序编码',
			'total_sort_code' => '总排序编码',
			'total_sore_base' => '当场比赛相对总名次值',
			'total_score_mark' => '总成绩',
			'total_score_order' => '总成绩排名次',
			'is_promotion' => '是否晋级(赛事结果)',  // 关联base_code表EVENT_RESULT类型id 1006胜 1007 平 1008 负',
            'total_score' => '比赛时的分',
            'group_score_mark' => '小组成绩',
            'group_score_order' => '小组成绩名次',
            'group_score' => '小组得分',
            'team_id' => '参赛团队ID',
            'team_name' => '参赛团队名称',
            'team_logo' => '',
            'sign_id' => '参赛成员ID',
            'sign_name' => '参赛会员id',
            'sign_logo' => '',
            'colour' => '颜色',
            'runway' => '跑道',
            'upper_order_user' => '小组名次',
            'upper_code_user' => '晋级方向编码',
            
            'type' => '类型',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->game_date = date('Y-m-d h:i:s');
        }
        $this->state_qmddid = Yii::app()->session['admin_id'];
        $this->state_qmddname = Yii::app()->session['gfnick'];
        $this->uDate = date('Y-m-d h:i:s');
        return true;
    }
}
