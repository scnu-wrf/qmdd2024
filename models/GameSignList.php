<?php

class  GameSignList extends BaseModel {
    public $money = '';
	public $dis = '';
	public $check_team = '';
	public $game_player_team='';
    public function tableName() {
        return '{{game_sign_list}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('sign_game_contect', 'numerical', 'integerOnly' => true),
			//array('sign_account', 'required', 'message' => '{attribute} 不能为空'),
            array('team_id,team_name,sign_gfid,sign_account,sign_name,sign_sname,sign_game_id,
                    sign_game_name,sign_project_id,sign_project_name,games_desc,sign_game_contect,
                    sign_height,sign_weight,sign_game_contect,agree_state,sign_head_pic,sign_game_data_id,
                    sign_sex,medical_checkup,draw_num,insurance_policy,guardian,guardian_contact_information,
                    guardian_relationship,sign_project_id,game_man_type,game_man_name,athlete_rank,health_date,add_type', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'game_list_data' => array(self::BELONGS_TO, 'GameListData', 'sign_game_data_id'),
            'game_team_table' => array(self::BELONGS_TO, 'GameTeamTable', 'team_id'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'sign_project_id'),
            'usersex' => array(self::BELONGS_TO,'BaseCode','sign_sex'),
            'user' => array(self::BELONGS_TO, 'userlist', 'sign_gfid'),
            'sign_type' => array(self::BELONGS_TO, 'BaseCode', 'game_man_type'),
            'sign_game_time' => array(self::BELONGS_TO, 'GameList', 'sign_game_id'),
            'club_member_level' => array(self::BELONGS_TO, 'ClubMemberList', array('sign_gfid'=>'member_gfid','sign_project_id'=>'member_project_id')),
            // 'arrange_sign_id' => array(self::BELONGS_TO,'GameListArrange',array('id'=>))
            'member_card' => array(self::BELONGS_TO, 'MemberCard', 'athlete_rank'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => '编码',  // 编码规则报名的赛事game_list表的code加6位序号
			'sign_game_id'=>'所属赛事',
			'sign_game_name'=>'赛事名称',
			'sign_game_data_id'=>'竞赛项目',
			'games_desc'=>'竞赛项目',
            'code' => '流水号',
            'team_id' => '所属团队',
            'team_name' => '所属团队名称',
            'sign_gfid' => '账号',
            'sign_account' => '账号',
            'sign_name' => '姓名',
			'sign_game_contect' => '联系方式',
            'sign_sname' => '短名称',
			'sign_project_id'=>'赛事项目',
            'sign_project_name' => '赛事项目',
            'agree_state' => '邀请状态',
            'agree_name' => '邀请状态',
            'sign_height' => '身高',
            'sign_weight' => '体重',
			'sign_sex' => '性别',
            'uDate' => '更新时间',
			'is_pay' => '支付状态',
            'pay_name' => '支付状态名称',
            'if_del' => '是否删除',  // 关联base_code表DATA类型 509-逻辑删除 510正常',
			'order_num' => '服务流水号',
			'sign_game_vote'=>'投票数',
            'sign_game_score' => '赛事得分',
            'sing_game_ranking' => '赛事排名',
			//'games_desc'=>'报名组别描述',
			'sign_head_pic'=>'免冠头像',
			'add_time'=>'报名时间',
			'medical_checkup'=>'体检单扫描件',
			'draw_num'=>'签号信息',
			'game_man_type'=>'成员职务',
			'game_man_name'=>'团队身份',
			'insurance_policy'=>'保险单号',
			'guardian'=>'姓名',
			'guardian_contact_information'=>'联系方式',
			'guardian_relationship'=>'与选手关系',
			'state' => '审核状态',
			'state_time' => '审核日期',
            'game_money' => '赛事费用',
            'insurance' => '保险费用',
            're_club' => '发布单位',
            'athlete_rank' => '运动员等级',
            'health_date' => '体检有效期',
            'pay_confirm' => '缴费确认',  //  0：未确认 1：已确认
            'pay_confirm_time' => '确认时间',
            'add_type' => '添加类型',  // 添加方式 0：前端 1：后台

            'uptype' => '报名类型',
            'add_time1' => '申请日期',
            'dg_level' => '龙虎等级',
            'date_birth' => '出生日期',
            'card_num' => '证件号码',
            'id_card_pic' => '身份证正面',
            'id_pic' => '身份证反面',
            'sign_account1' => '参赛者账号',
            'sign_game_contect1' => '联系电话',
            'uDate1' => '操作时间',
            'state1' => '状态',
            'game_money1' => '实缴报名费',
            'game_money2' => '报名费',
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
			$this->add_time = date('Y-m-d h:i:s');
        }
        // $this->add_type = 1;
        if($this->state==2 || $this->state==373){
            $this->state_time = date('Y-m-d H:i:s');
        }
        $this->uDate = date('Y-m-d H:i:s');
        return true;
    }

	protected function afterFind() {
        parent::afterFind();
        if ($this->id != null) {
			$game_list_data=GameListData::model()->find("id=".$this->sign_game_data_id);
            $this->game_player_team = $game_list_data->game_player_team;
        }
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
     * 竞赛项目报名成员添加
     */
    public function addSign($sign_m){
		if(empty($param['sign_gfid'])){
			return -1;
		}
    	$game_code=$sign_m['game_code'];
    	unset($sign_m['game_code']);
		$gsl_insert=new GameSignList;
		$sign_add=$gsl_insert->insert($sign_m);//写入成员表
		if($sign_add<=0) return 0;
    	$sign_id=$gsl_inser->id;
    	$cr = new CDbCriteria;
        $cr->condition="sign_game_id=".$gsl_inser->sign_game_id.' and id<='.$sign_id;
        $in_count=$this->count($cr);
	    $in_count=1+($in_count>0?$in_count:0);
        //开始生成订单，插入订单表
	    $gsl_insert->code=$game_code.str_pad($in_count,6,"0",STR_PAD_LEFT);
	    $sign_up=$gsl_insert->update($gsl_insert);

//    	if($sign_id&&empty($gsl_insert->code)){
//    		$add_id=$sign_id;
//    		$gsl_insert->code=BaseNo::mode->get_table_code_base(array('table_name'=>'game_sign_list','code_param'=>'code','id_param'=>'id','code_length'=>'6','table_id'=>$add_id,'code_year'=>'','code_month'=>'','code_day'=>'','code_head'=>$game_code));
//    		if(empty($gsl_insert->code)){
//    			return null;
//    		}
//    		$add=$gsl_insert->update($gsl_insert);
//    		if(empty($gsl_insert->code)){
//    			return null;
//    		}
//    	}
    	return $sign_id;
    }

    /**
	 * 获取某用户该赛事已报名项目,根据已报名项目 判断是否符合报名game_data_id条件
	 * $param array(visit_gfid,game_id,game_data_id,project_id,f_exclusive_id)
	 */
	function getSignGameData($param){
		$gfid=empty($param['visit_gfid'])?'':$param['visit_gfid'];
		$game_id=empty($param['game_id'])?'':$param['game_id'];
		$game_data_id=empty($param['game_data_id'])?'':$param['game_data_id'];
		$cr = new CDbCriteria;
        $cr->condition="t.if_del in(0,510) and t.order_num<>'' and t.game_man_type=997 and t.state<>373 and t.state<>374";
	    $cr->condition=get_where($cr->condition,$gfid,"t.sign_gfid",$gfid);
	    $cr->condition=get_where_in($cr->condition,$game_data_id,"t.sign_game_data_id",$game_data_id);
	    $cr->condition=get_where_in($cr->condition,$game_id,"t.sign_game_id",$game_id);
        $cr->join = "JOIN gf_service_data on gf_service_data.order_num=t.order_num and gf_service_data.state<>373 and (case when gf_service_data.order_state=1169 and gf_service_data.is_pay=463 and
if(gf_service_data.effective_time is null , (UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(gf_service_data.state_time))>=1800 , UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(gfc.effective_time)>0) then 374 else gf_service_data.state end)<>374";
        $cr->select="t.*";
        $cr->group="t.id";
        $join_list=$this->findAll($cr,array(),false);

        $result_data=array('join_list'=>$join_list);
        if(checkArray($param,'visit_gfid,game_id,game_data_id,project_id,f_exclusive_id',0)){
        	$gamesame="f_exclusive_id";//可同时兼报项目
			foreach($join_list as $k=>$v){
				if($v['sign_game_data_id']==$game_data_id){
					$result_data['is_join']=1;
					break;
				}
				if($param['project_id']==$v['project_id']){
					if(empty($v[$gamesame])
						||(indexof(','.$v[$gamesame].',',$game_data_id)==-1
							&&indexof(','.$param[$gamesame].',',$v['sign_game_data_id'])==-1)){
						$result_data['cont_join']=1;
					}
				}
			}
        }
		return $result_data;
	}

	/**
	 * 报名参加赛事
	 * game_id，game_data_id
	 * 参赛单位participants
	 * 教练coach_name,coach_phone、领队tour_leader_name,tour_leader_phone、队医team_doctor_name,team_doctor_phone
	 * "team_name":"参赛团队名","team_sname":"参赛团队短名","team_logo":"团队logo"
	 * sign_member 队员gfids，使用,隔开
	 * registration_data 根据visit_gfid获取
	 */
	public function ApplyJoinGame($post_param){
		checkArray($post_param,"visit_gfid,game_id,game_data_id,sign_member,registration_phone,recent_photo",1);
		$game_id = $post_param['game_id'];//赛事ID
		$game_data_id=$post_param['game_data_id'];//竞赛项目id
		$gfid = $post_param['visit_gfid'];//报名申请人GFID
		$club_id = $post_param['club_id'];
		$contact = $post_param['registration_phone'];//报名申请人联系方式
//		$game_type=base64_decode($post_param['game_type']);

		$data=get_error(1,"申请报名失败！");

		$cr = new CDbCriteria;
        $cr->condition="if_del=510  and game_state=151 and (now() between a.Signup_date and a.Signup_date_end) and id=".$game_id;
        $cr->select="game_code,game_title,game_small_pic as game_ico,game_club_id,game_club_name,game_address,game_time,game_time_end";
		$game_info=GameList::model()->find($cr,array(),false);//赛事
		if(empty($game_info)){
			set_error($data,1,"申请报名失败！",1);
		}
		$ask_param=CommonTool::model()->getKeyArray($post_param,'visit_gfid,game_data_id');
		$game_check=GameListData::model()->CheckAppliedProject($ask_param,null);//竞赛项目
		if($game_check['error']){
			set_error($data,$game_check['error'],$game_check['msg'],1);
		}
		$data_info=$game_check['game_data'];
		$game_player_team=$data_info['game_player_team'];
		if($game_player_team==666){
			if(checkArray($post_param,"tour_leader_name,tour_leader_phone,coach_name,coach_phone")){
				set_error($data,2,$data_info['game_project_name']."缺少领队或教练信息",1);
			}
		}
		$gfinfo=$game_check['gf_data'];//申请人信息

		$gamesame="f_exclusive_id";//可同时兼报项目
		$ask_param['project_id']=$data_info['project_id'];
		$ask_param[$gamesame]=$data_info[$gamesame];
		$join_data=$this->getSignGameData($ask_param,array());//获取某用户该赛事已报名项目
		if(!empty($join_data['is_join'])){
			set_error($data,5,"您已报名该赛事竞赛项目",1);
		}
		if(!empty($join_data['cont_join'])){
			set_error($data,1,"申请报名失败，已报名其他项目，不可兼报此项目！",1);
		}

		$picurl=getShowUrl('file_path_url');
		$game_info['game_ico']=CommonTool::model()->get_fullurl_name($picurl,$game_info['game_ico']);

		$game_code=$game_info['game_code'];
		$enter_datetime=get_date();

		$order_type=351;
		$order_type_name=BaseCode::model()->getName($order_type);

		$price_set=MallPricingDetails::model()->getNormalPrice($order_type,$game_info['game_club_id'],$game_id,$game_data_id);
		if(count($price_set)<=0){
			set_error($data,1,"申请报名失败",1);
		}
		$sign_fee=empty($price_set['shopping_price'])?'0.00':$price_set['shopping_price'];
		$sign_bean=empty($price_set['shopping_beans'])?0:$price_set['shopping_beans'];

		$game_desc=$data_info['game_data_name'];
		$enter_project=array();
		$car_order_data=array();
		$invite_member_msg=array();
			$add_car_array=array(
				'order_type'=>$order_type,
				'order_type_name'=>$order_type_name,
				'check_way'=>$data_info['game_check_way'],
				'udate'=>$enter_datetime,
				'order_no'=>0,
				'supplier_id'=>$game_info['game_club_id'],
				'supplier_name'=>$game_info['game_club_name'],
				'service_id'=>$game_id,
				'service_code'=>$game_info['game_code'],
				'service_name'=>$game_info['game_title'],
				'service_ico'=>$game_info['game_ico'],
				'service_data_id'=>$game_data_id,
				'service_data_name'=>$game_desc,
				'service_address'=>$game_info['game_address'],
				'servic_time_star'=>$game_info['game_time'],
				'servic_time_end'=>$game_info['game_time_end'],
				'buy_price'=>$sign_fee,
				'buy_bean'=>$sign_bean,
				'price_set_id'=>$price_set['set_details_id'],
				'set_code'=>$price_set['set_code'],
				'set_name'=>$price_set['set_name'],
				'gfid'=>$gfid,
				'gf_name'=>$gfinfo['gf_name'],
				'gf_account'=>$gfinfo['gf_account'],
				'buy_count'=>1,
				'game_user_type'=>789,
				'contact_phone'=>$contact,
				'project_id'=>$data_info['project_id'],
				'project_name'=>$data_info['project_name'],'state'=>721,'order_state'=>1167);

		$add_order=GfServiceData::model()->addServiceData($add_car_array);//写入服务报名表
    	if(empty($add_order['order_num'])){
			set_error($data,1,"申请报名失败",1);
		}
		$order_num=$add_order['order_num'];
    	//-----写入表game_team_table------
		$sign_m_array=explode(",", $post_param['sign_member']);
		$sign_count=count($sign_m_array);
		if($game_player_team==665||($sign_count<=$data_info['team_member']&&$sign_count>=$data_info['minimum_team'])){
			$team_info=CommonTool::model()->ChangeArrayKey($post_param,array('team_name'=>'name','team_logo'=>'logo','team_sname'=>'tvname','game_data_id'=>'sign_game_data_id'));
			$team_info['create_account']=$gfinfo['gf_account'];
			$team_info['state']=721;
			$team_info['order_num']=$order_num;
			$team_id=GameTeamTable::model()->addTeam($team_info);//写入团队表
			if($team_id<=0){
				if(!empty($order_num)){
					$this->updateSQL("call apply_join_game_cancel(".$order_num.")");
				}
				set_error($data,1,"申请报名失败！",1);
			}
		}else if($data_info!=null&&($game_player_team!=665)){
			if(!empty($order_num)){
				$this->updateSQL("call apply_join_game_cancel(".$order_num.")");
			}
			$notify_str=$sign_count>$data_info['team_member']?"超过最大报名人数":"不足";
			set_error($data,1,$data_info['game_project_name']."团队报名人数".$notify_str."！",1);
		}
    	//-----写入表game_sign_list------
		$sign_data=array('sign_game_id'=>$game_id,'sign_game_data_id'=>$game_data_id, 'games_desc'=>$game_desc,'uDate'=>$enter_datetime,'agree_state'=>371, 'state'=>371,'if_del'=>510,'game_man_type'=>997,'order_num'=>$order_num);
		if($data_info['game_player_team']!=665){
			$sign_data['team_id']=$team_id;
			$sign_data['state']=721;
		}
		$sign_data['sign_gfid']=$gfid;
		$sign_data['agree_state']=2;
		$sign_data['sign_id']=$team_id;

		$sign_data['game_code']=$game_code;
		$registration=toIoArray($gfinfo,'real_name:sign_name,short_name:sign_sname,native:native,nation:nation,registration_area:registration_area,recent_photo:sign_head_pic,insurance_pic:insurance_pic,id_card:id_card,born:sign_born,height:sign_height,weight:sign_weight,real_sex:sign_sex,registration_phone:sign_game_contect',array());
				$sign_m=array_merge($registration,$sign_data);
				$sign_add=$this->addSign($sign_m);//写入成员表
				if(empty($sign_add)){
					if(!empty($order_num)){
						$this->updateSQL("call apply_join_game_cancel(".$order_num.")");
					}
					set_error($data,1,"申请报名失败！",1);
				}
		$invit_rt=$this->InviteFriendJoinGame(array('visit_gfid'=>$gfid,'team_id'=>$team_id,'sign_member'=>$post_param['sign_member'],'data_info'=>$data_info,'game_info'=>$game_info,'gf_info'=>$gfinfo,'order_num'=>$order_num));
		if(empty($invit_rt)){
			set_error($data,1,"申请报名失败！",1);
		}else if($invit_rt['error']>0){
			set_error($data,$invit_rt['error'],$invit_rt['msg'],1);
		}

		//-----自动审核，缴费通知(未完成)------
		if(!empty($order_num)){//自动审核

			$cr = new CDbCriteria;
	        $cr->condition="t.order_num='".$order_num."' and t.check_way=793 and t.order_state=1169";
	        $cr->select="t.order_num,t.state,t.buy_price,t.buy_bean,t.service_data_name,(case when game_list_data.game_player_team=665 then game_list_data.number_of_member-game_list_data.number_of_join_now else game_list_data.number_of_member-game_list_data.max_num_team end) join_num";
	        $cr->join="join game_list_data on game_list_data.id=t.service_data_id";
	        $cr->group='t.order_num';
	        $service_info=GfServicedata::model()->findAll($cr,array(),false);

			$sendArr=array('section_code'=>'A06',"section_name"=>"赛事通知","type_id"=>23,"type"=>"缴费通知消息","pic"=>$game_info['game_ico'],"title"=>$game_info['game_title'],"content"=>"点击本条信息进入缴费界面");
			foreach($service_info as $k=>$v){
			    if($v['join_num']<0){
			        $over_member_notify.=empty($over_member_notify)?"":"、";
			        $over_member_notify.=$v['service_data_name'];
			        continue;
			    }
			    if(!empty($over_member_notify)){
			        continue;
			    }

		    	if($sign_fee<=0&&$sign_bean<=0){//免费
					$where="order_num='".$order_num."'";
					$update_array=array('is_pay'=>464,'order_state'=>1462);
					$res=GfServiceData::model()->updateAll($update_array,$where);
					unset($update_array['order_state']);
					$res=GameSignList::model()->updateAll($update_array,$where);
					$res=GameteamData::model()->updateAll($update_array,$where);
		    	}else{//生产缴费订单
		    		$add_pay=array('visit_gfid'=>$gfid,'order_num'=>$v['order_num'], 'price_set'=>$price_set,'gf_info'=>$gfinfo);
		    		$add_pay_rt=GfServiceData()->addGamePayOrder($add_pay);
		    		if($add_pay_rt['error']==0){
		    			$border_num=$add_pay_rt['pay_order_num'];
		    		}
		    	}
//			     $notify_io_rul=getShowUrl('gw_url')."?c=io&a=io_game&device_type=7"; //下单接口
//			     $param=array('action'=>'get_add_order_details','car_num'=>$order_num,'get_insurance'=>1,'pay'=>1);
//			     $add_order_str=get_data_from_url($notify_io_rul,$param);
//			     $add_order=json_decode($add_order_str,true);
//				$border_num=$add_order['order_num'];
				if($v['buy_price']>0&&isset($border_num)&&!empty($border_num)){//消息通知
					$sendArr['content_html']="<font>".$v['service_data_name']."</font><br><font>恭喜您！您的赛事报名审核已通过。</font><br><font>点击本条信息进入缴费界面</font>";
					$sendArr['datas']=array(array('order_num'=>$v['order_num']));
					$notify=GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>0,'S_GF_ACCOUNT'=>0
        	,'R_GF_ID'=>$gfid,'R_GF_ACCOUNT'=>0
        	,'M_MESSAGE'=>json_encode($sendArr,320),'M_TYPE'=>315,'S_G'=>0));
					if($notify['error']==0){
        				GfServicedata::model()->updateAll(array('sending_notice_time'=>get_date(),'notice_content'=>$sendArr['content_html']),"order_num='".$v['order_num']."'");
					}
				}
			}
			if(!empty($over_member_notify)){
					if(!empty($order_num)){
						$this->updateSQL("call apply_join_game_cancel(".$order_num.")");
					}
			    set_error($data,1,$over_member_notify."的报名名额已满！",1);
			}
		}
		$data['car_order_num']=$order_num;
		set_error_tow($data,strlen($order_num),0,"申请报名成功",1,"申请报名失败",1);

	}

	/**
	 * 服务报名详情中，组队中状态，邀请团队成员后，被邀请者回复
	 */
	public function TeamMemberReply($param){
		global $p_common_tool,$p_gf_service_data,$p_gfmessage;
		checkArray($param,'order_num,visit_gfid,invite_id,actionType',1);
		if($param['actionType']==1){
			checkArray($param,'registration_phone,recent_photo',1);
		}
		$gfid=$param['visit_gfid'];
		$data=get_error(1,"");
        $where="order_num='".$param['order_num']."' and sign_gfid=".$gfid." and id=".$param['invite_id'];
        $sign_info=$this->find($where);//t.sign_gfid,t.sign_account,t.sign_name,t.agree_state,t.state,t.if_del
		if(empty($sign_info)){
			parent::set_error($data,3,"操作异常",1);
		}
		if($sign_info['if_del']==509){
			parent::set_error($data,3,"已撤销邀请",1);
		}
		switch($sign_info['agree_state']){
			case 2:
				parent::set_error($data,3,"已同意",1);
			break;
			case 373:
				parent::set_error($data,3,"已拒绝",1);
			break;
			case 374:
				parent::set_error($data,3,"已撤销邀请",1);
			break;
		}
		//gfid,service_data_name as game_desc,service_name,service_ico
		$sign_order=GfServiceData::model()->find("order_state=1167 and order_num='".$param['order_num']."'");
		if(empty($sign_order)){
			parent::set_error($data,3,"操作异常",1);
		}
        $picurl=getShowUrl('file_path_url');
		$sign_info->agree_state=$param['actionType']==1?2:373;
		if($param['actionType']==1){
			$cr = new CDbCriteria;
	        $cr->condition="user_state=506 and passed=2 and GF_ID=".$gfid;
	        $cr->select="ZSXM,real_sex,real_birthday,native,nation,id_card,registration_phone";
	        $user_info=userlist::model()->find($cr,array(),false);
	        if(empty($user_info)){
	        	parent::set_error($data,3,"操作异常",1);
	        }
			$sign_info->sign_name=$user_info['ZSXM'];
			$sign_info->sign_sex=$user_info['real_sex'];
			$sign_info->sign_born=$user_info['real_birthday'];
			$sign_info->native=$user_info['native'];
			$sign_info->nation=$user_info['nation'];
			$sign_info->id_card=$user_info['id_card'];
			$sign_info->sign_sname=$param['short_name'];
			$sign_info->sign_height=$param['height'];
			$sign_info->sign_weight=$param['weight'];
			$sign_info->registration_area=$param['registration_area'];
			$sign_info->sign_game_contect=$user_info['registration_phone'];
			$sign_info->sign_head_pic=CommonTool::model()->get_fullurl_name($picurl,$param['recent_photo']);
			$sign_info->insurance_pic=CommonTool::model()->get_fullurl_name($picurl,$param['insurance_pic']);
		}
		$res=$sign_info->update($sign_info);
		if($res){
			$sendArr=array('section_code'=>'A06',"section_name"=>"赛事通知","type_id"=>27,"type"=>"赛事邀请通知","pic"=>$picurl.$sign_order['service_ico'],"title"=>$sign_order['service_name']);
			$sendArr['datas']=array(array('game_id'=>$sign_info['sign_game_id'],'invite_id'=>$param['invite_id'],'order_num'=>$param['order_num']));
			$sendArr["content"]=($param['actionType']==1?"恭喜您！":"很抱歉！").$sign_info['sign_name']."(".$sign_info['sign_account'].")".($param['actionType']==1?"已同意":"已拒绝")."您的邀请参加竞赛项目".$sign_order['service_data_name'];
			$sendArr['content_html']="<font>".$sign_order['service_data_name']."</font><br><font>".($param['actionType']==1?"恭喜您！":"很抱歉！").$sign_info['sign_name']."(".$sign_info['sign_account'].")".($param['actionType']==1?"已同意":"已拒绝")."您的邀请参加。</font>";

        	$notify=GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>$gfid,'S_GF_ACCOUNT'=>$sign_info['sign_account']
        	,'R_GF_ID'=>$sign_order['gfid'],'R_GF_ACCOUNT'=>$sign_order['gf_account']
        	,'M_MESSAGE'=>json_encode($sendArr,320),'M_TYPE'=>315,'S_G'=>0));
		}
		set_error_tow($data,$res,0,"操作成功",1,"操作失败",1);
	}

	/**
	 * 邀请好友
	 */
	public function InviteFriendJoinGame($param){
		$data=get_error(0,'');
		$gfid=$param['visit_gfid'];
		$team_id=$param['team_id'];
		$sign_m_array=explode(",", $param['sign_member']);
		$sign_count=count($sign_m_array);
		$data_info=$param['data_info'];
		if(empty($data_info)){
			$gfinfo=userlist::model()->getUserInfo($gfid,1);
			if(empty($gfinfo)){
				set_error($data,1,"提交失败！",0);
				return $data;
			}

			$team_info=$this->find('apply_gfid=sign_gfid and team_id='.$team_id);
			if(empty($team_info)){
				set_error($data,1,"提交失败！",0);
				return $data;
			}
			$game_data_id=$team_info['sign_game_data_id'];
			$game_id=$team_info['sign_game_id'];
			$order_num=$team_info['order_num'];

			$cr = new CDbCriteria;
	        $cr->condition="if_del=510  and game_state=151 and (now() between a.Signup_date and a.Signup_date_end) and id=".$game_id;
	        $cr->select="game_code,game_title,game_small_pic as game_ico,game_club_id,game_club_name,game_address,game_time,game_time_end";
			$game_info=GameList::model()->find($cr,array(),false);//赛事
			if(empty($game_info)){
				set_error($data,1,"提交失败！",0);
				return $data;
			}
			$picurl=getShowUrl('file_path_url');
			$game_info['game_ico']=CommonTool::model()->get_fullurl_name($picurl,$game_info['game_ico']);
			$data_info=$this->getGameDataInfoById($game_data_id);
			if(empty($data_info)){
				set_error($data,1,"提交失败！",0);
				return $data;
			}
		}else{
			$gfinfo=$param['gf_info'];
			$game_info=$param['game_info'];
			$game_data_id=$data_info['id'];
			$game_id=$data_info['game_id'];
			$order_num=$param['order_num'];
		}

		$game_desc=$data_info['game_data_name'];
		$sign_data=array('sign_game_id'=>$game_id,'sign_game_data_id'=>$game_data_id, 'games_desc'=>$game_desc,'uDate'=>get_date(),'agree_state'=>371, 'state'=>371,'if_del'=>510,'game_man_type'=>997,'order_num'=>$order_num,'sign_id'=>$team_id);
		$sign_data['team_id']=$team_id;
		$sign_data['state']=721;

		$sign_data['game_code']=$game_info['game_code'];
		$invite_member_msg=array();
		for($j=0;$j<$sign_count;$j++){//写入参赛成员、组队负责人信息
			$sign_gfid=$sign_m_array[$j];
			if($sign_gfid==$gfid){
				continue;
			}
			//判断报名条件
			$sgame_check=GameListData::model()->CheckAppliedProject(array('visit_gfid'=>$sign_gfid,'game_data_id'=>$game_data_id),$data_info);
			$sign_gf=$sgame_check['gf_datas'];
			$ask_param['visit_gfid']=$sign_gfid;
			$join_data=$this->getSignGameData($ask_param,array());//获取某用户该赛事已报名项目
			if(!empty($join_data['is_join'])){
				if(!empty($order_num)){
					$this->updateSQL("call apply_join_game_cancel(".$order_num.")");
				}
				set_error($data,5,$sign_gf['gf_name']."已报名该赛事竞赛项目",1);
			}
			if(!empty($join_data['cont_join'])){
				if(!empty($order_num)){
					$this->updateSQL("call apply_join_game_cancel(".$order_num.")");
				}
                set_error($data,1,'申请报名失败，\'.$sign_gf[\'gf_name\'].\'已报名其他项目，不可兼报此项目！',1);
			}
			if($sgame_check['error']){
				if(!empty($order_num)){
					$this->updateSQL("call apply_join_game_cancel(".$order_num.")");
				}
				set_error($data,$sgame_check['error'],$sgame_check['msg'],1);
			}

			$sign_data['sign_gfid']=$sign_gfid;
			$sign_data['agree_state']=371;
				$sign_id=$this->addSign($sign_data);//写入成员表
				if(empty($sign_id)){
					if(!empty($order_num)){
						$this->updateSQL("call apply_join_game_cancel(".$order_num.")");
					}
					set_error($data,1,"申请报名失败！",1);
				}
				$invite_member_msg[count($invite_member_msg)]=array('game_id'=>$game_id,'game_data_id'=>$game_data_id,'games_desc'=>$game_desc,'invite_id'=>$sign_id,'order_num'=>$order_num,'sign_gfid'=>$sign_gfid);
		}
		//-----邀请通知------
		$sendArr=array('section_code'=>'A06',"section_name"=>"赛事通知","type_id"=>26,"type"=>"赛事邀请通知","pic"=>$game_info['game_ico'],"title"=>$game_info['game_title']);
		foreach($invite_member_msg as $sign=>$sign_info){
			$sendArr["content"]=$gfinfo['gf_name']."(".$gfinfo['gf_account'].")邀请您一起组队参加赛事竞赛项目".$sign_info['games_desc'];
			$sendArr['content_html']="<font>".$sign_info['games_desc']."</font><br><font>您好！".$gfinfo['gf_name']."(".$gfinfo['gf_account'].")邀请您一起组队参加赛事。</font><br><font>点击本条信息进入详情界面</font>";
			$sendArr['datas']=array(CommonTool::model()->getKeyArray($sign_info,"game_id,invite_id,order_num"));

        	$notify=GfMessage::model()->addMsgAndSend(array('S_GF_ID'=>$gfid,'S_GF_ACCOUNT'=>0
        	,'R_GF_ID'=>$sign_info['sign_gfid'],'R_GF_ACCOUNT'=>0
        	,'M_MESSAGE'=>json_encode($sendArr,320),'M_TYPE'=>315,'S_G'=>0));
			if($notify['error']==0){
        		$this->updateAll(array('sending_notice_time'=>get_date(),'notice_content'=>$sendArr['content_html']), 'id='.$sign_info['invite_id']);
			}
		}
		return $data;
	}

}
