<?php

class  GameRefereesList extends BaseModel {

    public function tableName() {
        return '{{game_referees_list}}';
    }

    /**
     * 模型验证规则
     */
    
     public function rules() {
        return array(
			array('referee_gfaccount', 'required', 'message' => '{attribute} 不能为空'),          
            array('referee_gfid,referee_gfaccount,referee_gfnick,referee_code,real_name,sex,game_id,sign_game_data_id,project_id,project_name,referee_type,type_name,uDate,agree_state,agree_state_name,send_msg,send_date,rec_date', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'sex'),
            'game_list' => array(self::BELONGS_TO, 'GameList', 'game_id'),
            'game_list_data' => array(self::BELONGS_TO, 'GameListData', 'sign_game_data_id'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'game_id' => '选择赛事',  // 所属赛事
            'game_name' => '赛事名称',
            'project_id' => '赛事项目',
            'project_name' => '项目名称',
            'sign_game_data_id' => '执裁项目',
            'sign_type'=>'报名发起方',  // 210会员 502单位',
            'referee_gfid'=>'裁判GF_id',
            'referee_gfaccount'=>'GF账号',
            'referee_gfnick'=>'裁判员昵称',
            'referee_code' => '资质编码',
            'real_name' => '姓名',
            'sex' => '性别',
            'referee_type' => '裁判类型',
            'type_name' => '裁判类型',
            'uDate' => '更新时间',
            'agree_state' => '审核状态',
            'agree_state_name' => '审核状态',
            'send_msg' => '邀请信息',
            'send_date' => '报名/邀请时间',
            'rec_date' => '回复时间',
            'club_id' => '服务单位',
            'order_num' => '服务流水号',

            'send_date1' => '申请时间',
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
             $this->send_date = date('Y-m-d h:i:s');
         }

        $this->uDate = date('Y-m-d h:i:s');
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

    public function getCode($fater_id) {
        return $this->findAll('fater_id=' . $fater_id);
    }

}
