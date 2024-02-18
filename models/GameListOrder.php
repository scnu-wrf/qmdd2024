<?php

class  GameListOrder extends BaseModel {
 
    public function tableName() {
        return '{{game_list_order}}';
    }

    /**
     * 模型验证规则
     */
     public function rules() {
        return array(
            array('', 'safe'),
        );
    }


    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
       //'base_code' => array(self::BELONGS_TO, 'BaseCode', 'game_over'),
	   'idr'=>array(self::BELONGS_TO,'GameListArrange','arrange_id'), 
       
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'arrange_id' => '赛程id',  // 关联game_list_arrange表ID',
            'game_id' => '赛事',
            'game_data_id' => '竞赛项目',
            'project_id' => '参赛大赛项目',
            'game_area' => '赛事等级',  // 161世界级，160国家级，159省级，162社区单位级',
            'game_mode' => '赛事模式',  // 关联base_code表GAME_MODE类型ID 661考核赛 662对抗赛 663表演赛',
            'game_player_id' => '个人或团队参赛',  // 关联base_code表MAN_TEAM类型ID 665-个人 666-团队',
            'sign_no' => '签号',
            'team_ida' => '参赛团队',  // 关联game_team_table表id',
            'team_name' => '团队名称',
            'sign_ida' => '参赛成员',  // 关联game_sign_list表id',
            'gf_ida' => '参赛会员GFid',  // 关联userlist表id，从game_sign_list取数据',
            'gf_accounta' => '用户参赛会员帐号',
            'gf_namea' => '成员姓名',
            'colour' => '颜色说明',
            'game_votes_num' => '投票数量',
            'game_integral_score' => '赛事积分',
            'game_team_score' => '团队赛事得分',
            'game_score' => '本场成绩(赛事成绩)',
            'game_top_score' => '赛事转换GF排名积分',
            'game_rank' => '本场名次',
            'is_promotion' => '是否晋级',  // 关联base_code表yes_no类型id 648=否，649是',
            'state' => '状态',  // 关联base_code表STATE类型状态id：371-374',
            'game_score'=>'本场成绩',
            'game_team_score'=>'本场成绩',
            'game_data_name'=>'竞赛项目',
            'describe'=>'场次描述',
            'game_area'=>'赛事等级',
            'game_mode'=>'赛事模式',
            'star_time'=>'比赛开始时间',
            'end_time'=>'比赛结束时间',
            'game_over'=>'比赛状态',
            'game_over_name'=>'比赛状态说明',
            'votes_star_time'=>'投票开始时间',
            'votes_end_time' =>'投票结束时间',
            'achievement_show' => '用于前端展示成绩排名的成',  // （格式使用arrange_tcode关联表game_list_arrange的arrange_tcode，对应achievement_show_title）',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
       
        return true;
    }

    

}
