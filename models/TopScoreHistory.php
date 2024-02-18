<?php

class TopScoreHistory extends BaseModel {

    public function tableName() {
        return '{{top_score_history}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('id,gf_id,member_level,member_level_xh,get_type,get_score_game_reson,come_id,project_id,get_score,credit,state,uDate,audit_time','safe'),
        );
    }
        
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'gfUser' => array(self::BELONGS_TO, 'userlist', 'gf_id'),
            'getType' => array(self::BELONGS_TO, 'BaseCode', 'get_type'),
            'base_game_area' => array(self::BELONGS_TO, 'BaseCode', 'game_area'),
            'projectList' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
            'come' => array(self::BELONGS_TO, 'QualificationExchange', 'come_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'game_arrange_id' => '',
            'gf_id' => 'GFID',
            'GF_ACCOUNT' => 'GF账号',
            'ZSXM' => '姓名',
            'member_level' => '会员等级ID',
            'member_level_xh' => '等级序号',
            'get_type' => '积分来源',
            'come_id' => '来源表',
            'get_score_game_reson' => '来源内容',
            'project_id' => '项目',
            'get_score' => '得分',
            'credit' => '项目积分',
            'club_score' => '俱乐部积分',
            'province_score' => '省级赛积分',
            'country_score' => '国家级积分',
            'world_score' => '世界级积分',
            'game_area' => '赛事等级',
            'state' => '状态',
            'uDate' => '添加时间',
            'audit_time' => '确认日期',
            
            'qua_id' => '资质等级',
            'person_code'=>'资质编号',
            'person_pic'=>'上传资质',
            'type_id'=>'资质类型',
            'type_name'=>'资质类型',
            'get_score_game_reson'=>'积分来源',
            'credit_type'=>'积分状态'
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

        if ($this->isNewRecord) {

        }
        return true;
    }

}
