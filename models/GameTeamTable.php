<?php

class  GameTeamTable extends BaseModel {
	public $data_type = '';
	public $money = '';
	public $check_team = '';

    public function tableName() {
        return '{{game_team_table}}';
    }

    /**
     * 模型验证规则
     */
    
     public function rules() {
        return array(
            array('game_id', 'required', 'message' => '{attribute} 不能为空'),
            // array('logo', 'required', 'message' => '{attribute} 不能为空'),
            // array('name', 'required', 'message' => '{attribute} 不能为空'),
            // array('code', 'required', 'message' => '{attribute} 不能为空'),
            array('game_id,logo,name,tvcode,tvname,club_id,state,sign_game_data_id,draw_num,sign_project_id,state,
                    order_num,money,game_money,create_account,coach_name,tour_leader_name,team_doctor_name,coach_phone,
                    tour_leader_phone,team_doctor_phone,add_type', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'game_list' => array(self::BELONGS_TO, 'GameList', 'game_id'),
            'game_list_data' => array(self::BELONGS_TO, 'GameListData', 'sign_game_data_id'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'sign_project_id'),
            'basecode' => array(self::BELONGS_TO, 'BaseCode', 'state'),
            'gf_id' => array(self::BELONGS_TO, 'userlist', array('create_account'=>'GF_ACCOUNT')),
            'order_num_service' => array(self::BELONGS_TO, 'GfServiceData', array('order_num'=>'order_num')),
            'sign_game_time' => array(self::BELONGS_TO, 'GameList', 'game_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'game_id' => '所属赛事',
            'game_name' => '赛事名称',
            'sign_game_data_id' => '竞赛项目',  // 关联game_list_data表ID',
            'sign_game_data_name' => '竞赛项目名称',
            'sign_project_id' => '赛事项目',
            'sign_project_name' => '赛事项目',
            'code' => '团队编码',
            'logo' => '团队LOGO',
            'name' => '团队名称',
            'tvcode' => 'TVG短名',
            'tvname' => '短名称',
            'club_id' => '服务单位',
            'club_name' => '单位名称',
            'draw_num' => '签号',
            'votes' => '投票数',
            'score' => '赛事得分',
            'ranking' => '赛事排名',
            'order_num' => '服务流水号',  // 服务单号 关联gf_service_data表order_num',
            'info_order_num' => '销售单号',
            'game_money' => '赛事费用',
            'insurance' => '保险费用',
            'is_pay' => '支付状态',  // 463未支付  464已支付',
            'is_pay_name' => '支付状态名称',
            'pay_type' => '支付方式',
            'pay_type_name' => '支付方式说明 ',
            'pay_supplier_type' => '支付平台类型',  // 关联base_code表PAY类型id;',
            'pay_supplier_type_name' => '支付平台类型说明',
            'payment_code' => '支付后产生的交易码',
            'pay_time' => '支付时间',
            'state' => '审核状态',  // 关联base_code类型STATE类型，id为：  371审核中 2通过 373不通过 374撤销退出',
            'state_name' => '审核状态名称',
			'state_time' => '审核日期',
            'add_time' => '添加时间',
            'udate' => '操作时间',
            'if_del' => '是否删除',  // 关联base_code表DATA类型 509-逻辑删除/未支付取消服务 510正常',
            'create_account' => 'GF账号',  // 创建者账号
            'coach_name' => '教练',
            'tour_leader_name' => '领队',
            'team_doctor_name' => '队医（选填）',
            'coach_phone' => '联系电话',  // 教练联系电话
            'tour_leader_phone' => '联系电话',  // 领队联系电话
            'team_doctor_phone' => '联系电话',  // 队医联系电话
            'pay_confirm' => '缴费确认',  //  0：未确认 1：已确认
            'pay_confirm_time' => '确认时间',
            'add_type' => '添加类型',  // 添加方式 0：前端 1：后台

            'uptype' => '报名类型',
            'dg_level' => '龙虎等级',
            'name1' => '团队/成员名称',
            'add_time1' => '申请日期',
            'state1' => '状态',
            'name1' => '姓名',
            'sign_sex' => '性别',
            'game_money1' => '实缴报名费',
            'coach_phone1' => '教练联系电话',
            'team_phone' => '联系电话',
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
        if($this->isNewRecord) {
            $this->add_time = date('Y-m-d H:i:s');
            $path = BasePath::model()->get_www_path();
            $pic = '2019/06/17/09/85_qf_600__1709291607910.png';
            if(empty($this->logo)){
                $this->logo = $path.$pic;
            }
        }
        // $this->add_type = 1;
        if($this->state==2){
            $this->state_time = date('Y-m-d H:i:s');
        }
        $this->udate = date('Y-m-d H:i:s');
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


	/**
	 * 插入赛事报名团队信息
	 * 参赛单位participants
	 * 教练coach_name,coach_phone、领队tour_leader_name,tour_leader_phone、队医team_doctor_name,team_doctor_phone
	 * "name":"参赛团队名","tvname":"参赛团队短名","logo":"团队logo"
	 * @return int 0-缺少关键参数；-1团队名已被使用，>0写入成功
	 */
	public function addTeam($param){
		if(!checkArray($param,'sign_game_data_id,game_id',0)){
			return 0;
		}
		$param=CommmonTool::model()->ArrayNullToStr($param);
		if(!empty($param['name'])){
			$game_team=$this->find("name='".$param['name']."' and state=2 and sign_game_data_id=".$param['sign_game_data_id']);
			if(!empty($game_team)){
				return -2;
			}
		}
		$game_team=new GameTeamTable;
		$res=$game_team->insertItem($param);
		return $res;	
	}

	/**
	 * 插入赛事报名团队信息
	 * 参赛单位participants
	 * 教练coach_name,coach_phone、领队tour_leader_name,tour_leader_phone、队医team_doctor_name,team_doctor_phone
	 * "name":"参赛团队名","tvname":"参赛团队短名","logo":"团队logo"
	 * @return int 0-缺少关键参数；-1团队名已被使用，>0写入成功
	 */
	public function EditGameTeamInfo($param){
		checkArray($param,'team_id',1);
		$data=get_error(1,'');
		$team_info=CommonTool::model()->ChangeArrayKey($param,array('team_name'=>'name','team_logo'=>'logo','team_sname'=>'tvname'));
		$team_info=CommmonTool::model()->ArrayNullToStr($team_info);
		if(!empty($team_info['name'])){
			$game_team=$this->find("name='".$team_info['name']."'");
			if(!empty($game_team)&&$game_team->id!=$team_info['team_id']){
				set_error($data,1,'该团队名称已被使用',1);
			}
		}
		$game_team=$this->find("id=".$team_info['team_id']);
		if(empty($game_team)){
			set_error($data,1,'提交失败',1);
		}
		$game_team=new GameTeamTable;
		$res=$game_team->update($team_info);
		set_error_tow($data,$res,0,'提交成功',1,'提交失败',1);	
	}
}
