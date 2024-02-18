<?php

class MemberCard extends BaseModel {

    public function tableName() {
        return '{{member_card}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('card_code,mamber_type,card_name,card_xh,short_name,up_type,if_project,job_partner_num,job_club_num,description,card_level,card_score,card_end_score,renew_time,renew_notice_time,salesperson_show,type,if_service,club_display', 'safe'),
        );
    }
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'states' => array(self::BELONGS_TO,'BaseCode','state'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'f_id' => 'ID',
            'card_code' => '会员编码',
            'mamber_type' => '会员类型',
			'card_name' => '名称',
            'card_xh' => '等级序号',
			'short_name' => '短名',
            'up_type' => '是否支持二次上架',
			'if_project' => '是否绑定项目',
            'job_partner_num' => '可加入战略伙伴数量',
			'job_club_num' => '可加入社区单位数量',
			'description' => '会员描述',
			'card_level' => '晋级级别序号',
			'card_score' => '晋级起始积分数',
			'card_end_score' => '晋级结束积分数',
			'renew_time' => '有效期天数',
			'renew_notice_time' => '有效期结束提前通知天数',
			'salesperson_show' => '毛利分配设置时是否显示',  // 0不显示，1 显示,
			'charge' => '是否参与毛利分配',  // 0不参与，1 参与,
			'if_service' => '动动约服务',  // 0不支持，1 支持,
			'club_display' => '单位服务者列表',  //  0不显示，1 显示,
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        //parent::beforeSave();
        return true;
    }
	
	// 获取单条数据，主表名转换为模型返回
    public function getOne($id, $ismodel = true) {
        $rs = $this->find('f_id=' . $id);
        if (!$ismodel) {
            return $rs;
        }

        if ($rs != null && $rs->user_table != '') {
            $modelName = explode(',',$rs->user_table);
            $arr = explode('_', $modelName[0]);
            $modelName[0] = '';
            foreach ($arr as $v) {
                $modelName[0].=ucfirst($v);
            }
            $rs->user_table = implode(',', $modelName);
            return $rs;
        } else {
            return $rs;
        }
    }

    public function getCode($mamber_type) {
        return $this->findAll('mamber_type=' . $mamber_type);
    }
	
	public function getLevel_all() {
        return $this->findAll('type in (501,502)');
    }

    public function getClubLevel() {
        return $this->findAll("left(card_code,1)='D'");
    }
    //$ple=0,全部，=1是虎，2是龙
    public function getMemberLevel($ple=0) {
        return $this->findAll("left(card_code,1)='A' OR left(card_code,1)='B'");
    }

    public function getServicLevel() {//服务者级别
        return $this->findAll("left(card_code,1)='Q'");
    }
	
	public function getLevel($f_id) {
        return $this->findAll('mamber_type=210 AND f_id<>'.$f_id);
    }
    
}
