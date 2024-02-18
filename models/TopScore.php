<?php

class TopScore extends BaseModel {

    public  $club_list = '';
    public  $rank;
    public function tableName() {
        return '{{top_score}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('id,top_gfid,score_type,top_gfaccount,top_gfzsxm,top_gfidname,top_gfsex,top_gfbirthday,top_gf_country,
                top_gf_province,club_id,sponsor_logo,club_area_country,club_area_province,top_project_id,top_project_name,
                credit,club_score,province_score,country_score,world_score,member_level,votes,clicks,if_agreed_sign,uDate','safe'),
        );
    }
        
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'club_lists' => array(self::BELONGS_TO,'ClubList','club_id'),
            'base_sex' => array(self::BELONGS_TO,'BaseCode','top_gfsex'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'top_gfid' => 'GFID',
            'score_type' => '排名榜类型',
            'top_gfaccount' => '账号',
            'top_gfzsxm' => '姓名',
            'top_gfidname' => '实名免冠照片文件名',
            'top_gfsex' => '性别',
            'top_gfbirthday' => '出生年月',
            'top_gf_country' => '所在地区：国家',
            'top_gf_province' => '所在地区：省份',
            'club_id' => '归属单位',  // 学员所属单位ID
            'sponsor_logo' => '赞助单位LOGO',
            'club_area_country' => '社区单位地区：国家',
            'club_area_province' => '社区单位地区：省份',
            'top_project_id' => '项目',  // 积分项目ID
            'top_project_name' => '项目名称',  // 积分项目名
            'credit' => '积分',
            'club_score' => '社区单位级',  // 龙虎积分排名-俱乐部积分排名
            'municipal_score' => '市级',  // 赛事积分排名
            'province_score' => '省级',  // 赛事积分排名
            'country_score' => '国家级',  // 赛事积分排名
            'world_score' => '国际级',  // 赛事积分排名
            'member_level' => '会员等级ID',
            'votes' => '票数',
            'clicks' => '点击率',
            'if_agreed_sign' => '签署榜协议',//是否同意签署入选候选候选榜/明星榜协议
            'uDate' => '更新时间',
            'game_area' => '赛事等级',  // base_code 赛事等级，多个用英文逗号“,”分隔，161世界级，160国家级，159省级，1488市级，162社区单位级
            'municipal_level' => '市级',
            'provincial_level' => '省级',
            'national_level' => '国家级',
            'International_level' => '国际级',

            /* index_real_time_ranking页面自定义属性 */
            'real_time_ranks' => '排名',
            'naming_club' => '冠名单位',
            /* update_real_time_ranking页面自定义属性 */
            'box_group' => '组别',
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
