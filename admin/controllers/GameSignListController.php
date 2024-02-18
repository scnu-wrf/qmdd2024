<?php

class GameSignListController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = 'GameSignList';
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '',$game_id=0,$order_num='',$game='',$state='',$is_pay='',$data_id=0,$data_type=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->condition = ($game_id==0) ? 'team_id is NULL' : 'team_id is NULL AND sign_game_id='.$game_id;
		$criteria->condition=get_where($criteria->condition,!empty($order_num),'order_num',$order_num,'');
		$criteria->condition=get_where($criteria->condition,!empty($game),'sign_game_id',$game,'');
		$criteria->condition=get_where($criteria->condition,!empty($data_id),'sign_game_data_id',$data_id,'');
		$criteria->condition=get_where($criteria->condition,!empty($state),'state',$state,'');
		$criteria->condition=get_where($criteria->condition,!empty($is_pay),'is_pay',$is_pay,'');
		if($data_type>0 && ($data_type==666 || $data_type==982)){
			$criteria->condition.=' AND sign_game_data_id=0';
		}
        $criteria->condition=get_like($criteria->condition,'sign_name,sign_account',$keywords,'');
        $criteria->order = 'id DESC';
		$data = array();
		$data['state'] = BaseCode::model()->getCode(370);
		$data['is_pay'] = BaseCode::model()->getCode(462);
		$data['game'] = GameList::model()->getGame();
		// $all_num=0;
		// $gamedata = GameListData::model()->findAll('game_id='.$game_id);
		// foreach ($gamedata as $n) {
		// 	$all_num=$all_num+$n->number_of_join_now;
		// }
		// $data['all_num'] = $all_num;
		if($data_id==0){
            $g_dataid = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510');
            if(!empty($g_dataid)){
                $criteria->condition .= ' AND sign_game_data_id='.$g_dataid[0]->id;
                $data_id = $g_dataid[0]->id;
            }
        }
		$data['data_id'] = $data_id;
		$data['game_data'] = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510');
        parent::_list($model, $criteria, 'index', $data);
    }
	
	  public function actionShowsale($keywords = '',$game_id=0,$order_num='',$game='',$state='',$is_pay='',$data_id=0,$data_type=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->condition = 'is_pay=464 and sign_game_id='.$game_id;
		$criteria->condition=get_where($criteria->condition,$is_pay,'is_pay',$is_pay,'');
	    $criteria->condition=get_like($criteria->condition,'sign_name,sign_account,games_desc',$keywords,'');
        $criteria->order = 'id';
		$data = array();
		// $data['state'] = BaseCode::model()->getCode(370);
		// $data['is_pay'] = BaseCode::model()->getCode(462);
		$data['game'] = GameList::model()->getGame();
		$data['data_id'] = $data_id;
		$data['all_num'] =0;
        parent::_list($model, $criteria, 'showsale', $data);
    }


	public function actionIndex_team($game_id=0,$order_num='',$team_id=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition=get_where($criteria->condition,!empty($team_id),'team_id',$team_id,'');
		$criteria->condition=get_where($criteria->condition,!empty($order_num),'order_num',$order_num,'');
        $criteria->order = 'id DESC';
		$data = array();
        parent::_list($model, $criteria, 'index_team', $data);
    }
	
	public function actionIndex_rank($keywords = '',$game_id=0,$data_id=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = ($game_id==0) ? 'sing_game_ranking is not NULL AND team_id is NULL' : 'sing_game_ranking is not NULL AND team_id is NULL AND sign_game_id='.$game_id;
		//$criteria->condition = ' AND sign_game_data_id='.$data_id;
		$criteria->condition=get_where($criteria->condition,!empty($data_id),'sign_game_data_id',$data_id,'');
        $criteria->condition=get_like($criteria->condition,'sign_name,sign_account',$keywords,'');
        $criteria->order = 'sing_game_ranking ASC'. ',uDate DESC'; 
		$data = array();
		// $all_num=0;
		// $gamedata = GameListData::model()->findAll('game_id='.$game_id);
		// foreach ($gamedata as $n) {
		// 	$all_num=$all_num+$n->number_of_join_now;
		// }
		// $data['all_num'] = $all_num;
		if($data_id==0){
            $g_dataid = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510');
            if(!empty($g_dataid)){
                $criteria->condition .= ' AND sign_game_data_id='.$g_dataid[0]->id;
                $data_id = $g_dataid[0]->id;
            }
        }
		$data['data_id'] = $data_id;
		$data['game_data'] = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510');
        parent::_list($model, $criteria, 'index_rank', $data);
	}
	
	public function actionIndex_reg($keywords='',$project='',$project_item='',$game='',$time_start='',$time_end='',$num=0){
		set_cookie('_currentUrl_', Yii::app()->request->url);
		$modelName = $this->model;
        $model = $modelName::model();
		$criteria = new CDbCriteria;
		if($num==0 || $num==''){$num=15;}
		if($time_start==''){ $time_start = date('Y-m-01',strtotime(date('Y-m-d'))); }
		if($time_end==''){ $time_end = date('Y-m-d'); }
		$criteria->condition = 'state=2 and is_pay=464 and if_del=510';
		// $criteria->condition .= ' AND exists(select * from game_list where club_id='.get_session('club_id').' and id=t.sign_game_id)';
		$criteria->condition = get_where($criteria->condition,!empty($project),'sign_project_id',$project,'');
		$criteria->condition = get_where($criteria->condition,!empty($game),'sign_game_id',$game,'');
		$criteria->condition = get_where($criteria->condition,!empty($time_start),'left(add_time,10)>="'.$time_start.'"',$time_start,'"');
		$criteria->condition = get_where($criteria->condition,!empty($time_end),'left(add_time,10)<="'.$time_end.'"',$time_end,'"');
		$criteria->condition = get_like($criteria->condition,'games_desc',$project_item,'');
		$data = array();
		$data['time_start'] = $time_start;
		$data['time_end'] = $time_end;
		$data['count'] = $model->count($criteria->condition);
		$data['project'] = ProjectList::model()->getProject();
		// $data['project_item'] = GameListData::model()->findAll();
		$data['game'] = GameList::model()->findAll('game_club_id='.get_session('club_id'));
		parent::_list($model, $criteria, 'index_reg', $data, $num);
	}
	
	public function actionIndex_detail($keywords='',$project='',$project_item='',$game_id='',$num=0){
		set_cookie('_currentUrl_', Yii::app()->request->url);
		$modelName = $this->model;
        $model = $modelName::model();
		$criteria = new CDbCriteria;
		if($num==0 || $num==''){$num=15;}
		$criteria->condition = '';
		$criteria->condition = get_where($criteria->condition,!empty($project),'sign_project_id',$project,'');
		$criteria->condition = get_where($criteria->condition,!empty($game),'sign_game_id',$game,'');
		$criteria->condition = get_like($criteria->condition,'games_desc',$project_item,'');
		$data = array();
		$data['project'] = ProjectList::model()->getProject();
		// $data['project_item'] = GameListData::model()->findAll();
		$data['game'] = GameList::model()->findAll('game_club_id='.get_session('club_id'));
		parent::_list($model, $criteria, 'index_detail', $data, $num);
	}

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('update');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
			$data['user']= array();
			$data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and state=2 and datediff(now(),game_time_end)<60');
            $this->render('update', $data);
        }else{
			//$this-> saveServiceData($model,$_POST[$modelName]);
            $this->saveData($model,$_POST[$modelName]);
        }
    }
	public function actionCreate_team() {
        $modelName = $this->model;
        $model = new $modelName('update');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
			$data['user']= array();
            $this->render('update_team', $data);
        }else{
            
			$this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if(!Yii::app()->request->isPostRequest) {
			$data = array();
			$data['model'] = $model;
			$data['user']= array();
			if(isset($model->sign_account) && !empty($model->sign_account)) {
				$data['user'] = userlist::model()->find('GF_ACCOUNT="'.$model->sign_account.'"');
			}
			$this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }
	
	public function actionUpdate_team($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
			$data = array();
			$data['model'] = $model;
			$data['user']= array();
			if(isset($model->sign_account) && !empty($model->sign_account)) {
				$data['user'] = userlist::model()->find('GF_ACCOUNT="'.$model->sign_account.'"');
			}
			$this->render('update_team', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
	}

    function saveData($model,$post) {
		$model->attributes = $post;
		$model->state = ($_POST['submitType']=='quxiao') ? 721 : get_check_code($_POST['submitType']);
		if($model->state==2 || $model->state==371){
			if($model->add_type==1 || ($model->game_list_data->game_check_way==792 && (empty($model->game_money) || $model->game_money==0.00))) {
				$model->is_pay = 464;
				$model->state = ($model->state==371) ? 2 : $model->state;
			}
		}
		$model->sign_game_contect = trim($model->sign_game_contect);
		$st=$model->save();
		// GfServiceData::model()->updateAll(array('state'=>$model->state,'order_state'=>1168),'order_num="'.$model->order_num.'"');
		$service_data = GfServiceData::model()->find('order_num="'.$model->order_num.'"');
		$service_data->state = $model->state;
		$service_data->order_state = ($model->state==373) ? 373 : $service_data->order_state;
		$service_data->reasons_for_failure = ($model->state==373) ? '参赛成员不符合赛事要求' : '';
		$service_data->save();
		if($model->state==371 || $model->state==2){
			$post['check_team'] = (!isset($post['check_team'])) ? 0 : $post['check_team'];
			$this->actionClickCheck($model->id.':0',$model->state,$post['check_team']);
		}
		else{
			$this->save_Service($model,$post);
		}
		if($post['dis']>0){
			ajax_exit(array('status' => $st, 'msg' => '保存成功', 'redirect' => Yii::app()->request->urlReferrer));
		}
		else{
			show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败');   
		}
	}

	//添加服务报名--调用下单接口	
	public function save_Service($model,$post) {
        $model->attributes =$post;
		$ms='service_id ='.$post['sign_game_id'].' and service_data_id ='.$post['sign_game_data_id'].' and state<>374';
		$servicedata = GfServiceData::model()->find($ms.' and gfid ='. $post['sign_gfid']);
		$game=GameList::model()->find('id='.$post['sign_game_id']);
		$gamed=GameListData::model()->find('id='.$post['sign_game_data_id']);
		$money1 = $gamed->game_money;
		$order_state = ($model->state==373) ? 1170 : 1169;
		$is_pay = $servicedata->is_pay;
		$n = 0;
		if($model->add_type==1 || ($gamed->game_check_way==792 && (empty($money1) || $money1==0.00))) {
			$is_pay = 464;
			$order_state = 1462;
			$n = 1;
		}
		$is_pay = ($model->state==373) ? 463 : $is_pay;
		$servicedata->state = $model->state;
		$servicedata->udate = date('Y-m-d h:i:s');
		$servicedata->reasons_for_failure = ($model->state==373) ? '参赛成员不符合赛事要求' : '';
		$servicedata->is_pay = $is_pay;
		$servicedata->order_state = $order_state;
		$model->updateAll(array('order_num'=>$servicedata->order_num),'id='.$model->id);
		$servicedata->save();
		$this->base_no($servicedata->id,$servicedata->gf_account,$servicedata->order_num);
		$game_data = GameListData::model()->find('id='.$model->sign_game_data_id);
		// 后台添加的不发通知通知
		if(isset($post['check_team']) && $post['check_team']==1 && $n==0){  //  && $model->game_money>0) || ($model->state==371 && $game_data->game_check_way==793 && $model->game_money>0)
			$this->save_shopping($model,$servicedata);
		}
		if($model->state==373){
			// $mall_set_details = MallPriceSetDetails::model()->find('pricing_type=351 and service_id='.$model->sign_game_id.' and service_data_id='.$model->sign_game_data_id);
			// $mall_pric_details = MallPricingDetails::model()->find('pricing_type=351 and service_id='.$model->sign_game_id.' and service_data_id='.$model->sign_game_data_id);
			// if(!empty($mall_set_details)){
			// 	$mall_set_details->sale_order_data_quantity = $mall_set_details->sale_order_data_quantity-1;
			// 	$mall_set_details->save();
			// }
			// if(!empty($mall_pric_details)){
			// 	$mall_pric_details->sale_order_data_quantity = $mall_pric_details->sale_order_data_quantity-1;
			// 	$mall_pric_details->save();
			// }
			$this->notice($model->sign_gfid,$model->sign_account,$model->sign_game_name,$model->sign_game_data_id,$model->games_desc,$model->order_num,$game->game_small_pic,315,1,1);
		}
	}

	/**
	 * 检查序号表base_no的序号是否和获取的一样，如果一样则修改数字序号，如果不一样则添加一条
	 */
	function base_no($id,$account,$order_num,$table_name='gf_service_data'){
		$modelName = $this->model;
		$base_no = BaseNo::model()->find('code_year='.date('Y').' and code_month="'.date('m').'" and code_day="'.date('d').'" and code_gfaccount="'.$account.'" and table_name="'.$table_name.'" order by code_num DESC');
		$s_num = substr($order_num,-2,2);
		if(empty($base_no)){
			$base_no = new BaseNo();
			$base_no->isNewRecord = true;
			unset($base_no->id);
			$base_no->table_name = $table_name;
			$base_no->code_year = date('Y');
			$base_no->code_month = date('m');
			$base_no->code_day = date('d');
			$base_no->code_gfaccount = $account;
		}
		$base_no->code_num = $s_num;
		$base_no->table_id = $id;
		$sv = $base_no->save();
		return $sv;
	}

	/**
	 * 获取流水号
	 */
	function get_max_order_num(){
		$num = date('Ymd');
        $num1= '000000';  
        $orderinfo = GfServiceData::model()->find("left(order_num,8)='".$num."' order by order_num DESC");
        if(!empty($orderinfo)){
            $num1=$orderinfo->order_num;
        }
        return $num.substr(''.(1000001+substr($num1, -6)),1,6);
	}

	/**
	 * 生成购物车信息，
	 */
	function save_shopping($model,$service){
		$game_data = GameListData::model()->find('id='.$model->sign_game_data_id);
		$sid = ($game_data->game_player_team==665) ? 'id=' : 'team_id=';
		$sign_list = GameSignList::model()->find($sid.$model->id);
		$game_list = GameList::model()->find('id='.$sign_list->sign_game_id);
		$base_code = BaseCode::model()->find('f_id=351');
		$sign_level = ClubMemberList::model()->find('gf_account='.$sign_list->sign_account.' and member_project_id='.$sign_list->sign_project_id.' and club_status=337');
		if($sign_list->game_money>0){
	        $order_data=array('order_type'=>351
	        	,'buyer_type'=>210
		        ,'order_gfid'=>$sign_list->sign_gfid
		        ,'money'=>$sign_list->game_money
		        ,'order_money'=>$sign_list->game_money
		        ,'total_money'=>$sign_list->game_money
		        ,'effective_time'=>$game_list->effective_time);
			$add_order=Carinfo::model()->addOrder($order_data);
			if(empty($add_order['order_num'])){
				$sv=0;
			}else{
				$sv=1;
				GfServiceData::model()->updateByPk($service->id,array('shopping_order_num'=>$add_order['order_num'],'effective_time'=>$game_list->effective_time));
				
				// 购物车详细
				$cat_copy = new CardataCopy();
				$cat_copy->isNewRecord = true;
				unset($cat_copy->id);
				$cat_copy->order_num = $add_order['order_num'];
				$cat_copy->order_type = 351;
				$cat_copy->order_type_name = $base_code->F_NAME;
				$cat_copy->supplier_id = $game_list->game_club_id;
				$cat_copy->buy_price = $sign_list->game_money;  // 商品单价
				$cat_copy->buy_amount = $sign_list->game_money;  // 购买实际金额
				$cat_copy->project_id = $sign_list->sign_project_id;
				$cat_copy->project_name = $sign_list->sign_project_name;
				$cat_copy->buy_level = $sign_level->project_level_id;
				$cat_copy->buy_level_name = $sign_level->project_level_name;
				$cat_copy->buy_count = 1;
				$cat_copy->gfid = $sign_list->sign_gfid;
				$cat_copy->gf_name = $sign_list->sign_name;
				$cat_copy->service_id = $game_list->id;
				$cat_copy->service_code = $game_list->game_code;
				$cat_copy->service_ico = $game_list->game_small_pic;
				$cat_copy->service_name = $game_list->game_title;
				$cat_copy->service_data_id = $sign_list->sign_game_data_id;
				$cat_copy->service_data_name = $sign_list->games_desc;
				$cat_copy->uDate = date('Y-m-d H:i:s');
				$cat_copy->gf_club_id = $sign_level->club_id;
				$cat_copy->gf_service_id = $service->id;
				$cat_copy->effective_time = $game_list->effective_time;
				$st=$cat_copy->save();
			}
		}
	
		// 加入购物车成功后发送缴费通知
		$code = ($sign_list->game_money>0) ? 314 : 315;
		$pic = BasePath::model()->get_www_path().$sign_list->sign_game_time->game_small_pic;
		$order_num = ($code==315) ? $service->order_num : $add_order['order_num'];
		$nu1 = ($sign_list->game_money>0) ? 0 : 1;
		$this->notice($sign_list->sign_gfid,$sign_list->sign_account,$sign_list->sign_game_name,$sign_list->sign_game_data_id,$sign_list->games_desc,$order_num,$pic,$code);
	}

	/**
	 * 发送缴费通知.
	 * 
	 * $sign_gfid = 成员gfid.
	 * 
	 * $sign_account = 成员gf账号.
	 * 
	 * $sign_game_name = 赛事名称.
	 * 
	 * $data_id = 竞赛项目id.
	 * 
	 * $data_name = 项目名称.
	 * 
	 * $order_num = 购物车订单号.
	 * 
	 * $pic = 赛事图标
	 * 
	 * 发314通知，前端直接跳转到订单详情界面去支付 发送购物车的order_num
	 * 
	 * 发315通知 type_id=23  前端跳转进入服务订单详情界面（赛事、裁判等）datas [{"order_num":"服务订单流水号"}] 发送服务订单号
	 * 
	 * 1、"type": "邀请函", //通知标题
	 * 2、"pic":"http://xxx.png" //图片
	 * 3、"title": "广州中数", //标题
	 * 4、"content":"内容",// 内容简要
	 * 5、"url":"http://gf41.net",//url内容链接
	 * 6、"type_id":”1”// 链接跳转类型，参考附件
	 * 7、"datas": [{"id":"91"}]// 链接类型对应内容，参考附件
	 * 8、"notify_type":"通知类型id"//目前仅type_id=10时使用
	 * {"type":"赛事通知","pic":"http://xxx.png","title":"XXXX赛事","content":"报名审核通过，快去选择项目报名吧","url":"http://gf41.net/xxx.html?gfid=1888",”type_id”:”3”, "datas": [{"id":"91"}]}
	 * 9、"content_html":"HTML格式的内容"
	 */
	function notice($sign_gfid,$sign_account,$sign_game_name,$data_id,$data_name,$order_num,$pic,$code,$noi=0,$num1=0){
		$type_id = 23;
		$admin_id = get_session('admin_id');
		$type = ($num1==0) ? '【缴费通知消息】' : '【审核通知】';
		$txt1 = '点击本条信息进入缴费界面';
		$txt2 = '恭喜您！您的赛事报名审核已通过';
		$txt3 = '很抱歉！您的赛事报名审核未通过';
		$txt4 = '点击本条信息进入查看界面';
		$noti1 = ($noi==0) ? $txt2 : $txt3;
		$noti2 = ($noi==0 && $num1==0) ? $txt1 : $txt4;
		$content_html = '<font>'.$data_name.'</font><br><font>'.$noti1.'</font><br><font>'.$noti2.'</font>';
		$data315 = array(
			'type' => $type,
			'pic' => $pic,
			'title' => $sign_game_name,
			'content' => $txt1,
			'content_html' => $content_html,
			'datas' => [array('order_num'=>$order_num)],
			'type_id' => $type_id
		);
		$data314 = array(
			'type' => $type,
			'pic' => $pic,
			'title' => $sign_game_name,
			'content' => $txt1,
			'content_html' => $content_html,
			'order_num' => $order_num
		);
		if($code==315){
			new_message_send(315,$admin_id,$sign_gfid,json_encode($data315),0);
		}
		if($code==314){
			new_message_send(314,$admin_id,$sign_gfid,json_encode($data314),0);
		}
		GfServiceData::model()->updateAll(array('notice_content'=>$content_html,'sending_notice_time'=>date('Y-m-d H:i:s')),'service_data_id='.$data_id.' and gf_account="'.$sign_account.'" and order_type=351');
	}

	 // 成员帐号验证
    public function actionValidate($game_id=0,$data_id=0,$gf_account=0) {
        $modelName = $this->model;
        $model = $modelName::model();
		$game = GameList::model()->find('id='.$game_id);
		$game_data = GameListData::model()->find('id='.$data_id);
		$user = userlist::model()->find('GF_ACCOUNT="'.$gf_account.'"');
		$sign = $model->find('sign_game_id='.$game_id.' and sign_game_data_id='.$data_id.' and sign_account="'.$gf_account.'" and state in(2)');
		if(!empty($user)) {
			$member = ClubMemberList::model()->find('gf_account="'.$user->GF_ACCOUNT.'" AND member_project_id='.$game_data->project_id.' AND club_status=337');
			if($user->passed==2) {
				if($game_data->game_sex==220 || $user->real_sex==$game_data->game_sex) {
					$health_day = $game->game_time_end-$user->health_date;
				   	// if($game_data->game_physical_examination<$user->health_date) {
						// if($user->real_birthday>$game_data->game_group_star && $user->real_birthday<$game_data->game_group_end) {   
							if(!empty($member)) {
								// $top_score = TopScore::model()->find('score_type=839 and top_gfaccount="'.$gf_account.'" and top_project_id='.$game_data->project_id);
								$member_list = ClubMemberList::model()->find('member_project_id='.$game_data->project_id.' and gf_account="'.$gf_account.'" and club_status=337 and real_sex='.$user->real_sex);
								// if($game_data->game_dg_level==$member->project_level_id || $game_data->game_dg_level==0) {
									// ajax_status_gamesign(1, $user->GF_ID, $user->ZSXM,$user->IDNAME,$user->PHONE, $user->real_sex,$user->real_sex_name,$user->real_birthday,$user->id_card_type_name,$user->id_card);
									$data = array();
									if(empty($sign)){
										// if(empty($sign) && !empty($game_data->F_exclusive_ID) && strpos($game_data->F_exclusive_ID,$game_data->id)>-1){
											$data['status'] = 1;
											$data['ZSXM'] = $user->ZSXM;
											$data['sex'] = $user->real_sex;
											if(!empty($member_list)){
												$data['level'] = $member_list->level_xh->card_name;
												$data['level_id'] = $member_list->project_level_xh;
											}
											echo CJSON::encode($data);
										// } else{
										// 	ajax_status(0,'已报名不可兼报项目：<br>【'.$game_data->game_data_name.'】');
										// }
									} else{
										// $sn = ($game_data->game_player_team==665) ? '本项目' : '"'.$sign->team_name.'"';
										switch(true){
											// case ($game_data->game_player_team==665):
											// 	$sn = '本项目';
											// 	break;
											case ($game_data->game_player_team==666):
												$sn = '"'.$sign->team_name.'"';
												break;
											default:
												$sn = '本项目';
										}
										ajax_exit(array('status'=>0,'msg'=>'账号已在<span class="red">'.$sn.'</span>报名'));
									}
								// } else {
								// 	ajax_status(0, 'GF帐号等级不符合该赛事');
								// }							   
							} else {
								ajax_status(0, '帐号还未注册该项目的学员，无法报名参加比赛');
							}
						// } else {
						// 	ajax_status(0, '年龄不符合该赛事项目');
						// }
					// } else {
					// 	ajax_status(0, '体检报告已过期');
					// }
				} else {
					ajax_status(0, '性别不符合该赛事项目');
				}
			} else {
				ajax_status(0, '帐号未实名');
			}
		} else {
			ajax_status(0, '帐号不存在');
		}
	}

   	// public function actionDelete($id) {
    //     //ajax_status(1, '删除成功');
    //     parent::_clear($id);
	// }
	public function actionDelete($id) {
        $modelName = $this->model;
		$model = $modelName::model();
        $lode = explode(',', $id);
        $count = 0;
		foreach ($lode as $d) {
			$dl = explode(':', $d);
			if($dl[1]==0){
				$sign_no = GameSignList::model()->find('id='.$dl[0]);
			}
			else{
				$sign_no = GameTeamTable::model()->find('id='.$dl[0]);
			}
			if(!empty($sign_no->order_num)){
				GfServiceData::model()->deleteAll('order_num="'.$sign_no->order_num.'"');
			}
			if($sign_no->state==2){
				$game_id = ($dl[1]==0) ? $sign_no->sign_game_id : $sign_no->game_id;
				$mall_set_details = MallPriceSetDetails::model()->find('pricing_type=351 and service_id='.$game_id.' and service_data_id='.$sign_no->sign_game_data_id);
				$mall_pric_details = MallPricingDetails::model()->find('pricing_type=351 and service_id='.$game_id.' and service_data_id='.$sign_no->sign_game_data_id);
				if(!empty($mall_set_details)){
					$mall_set_details->sale_order_data_quantity = $mall_set_details->sale_order_data_quantity-1;
					$mall_set_details->save();
				}
				if(!empty($mall_pric_details)){
					$mall_pric_details->sale_order_data_quantity = $mall_pric_details->sale_order_data_quantity-1;
					$mall_pric_details->save();
				}
			}
			$model->deleteAll('id='.$dl[0]);
			$count++;
		}
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
   
    }

	public function actionCancelsvi($id) {
		$modelName = $this->model;
		$model = $modelName::model();
		$count = $model->updateByPk($id,array('agree_state'=>374));
		if ($count > 0) {
			ajax_status(1, '服务取消成功');
		} else {
			ajax_status(0, '已取消服务，请勿重复操作');
		}
	}
	

	// 赛事报到成员列表
	public function actionEvent_mem_index($keywords = '',$game_id=0,$data_id=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->condition = ($game_id==0) ? 'team_id is NULL' : 'team_id is NULL AND sign_game_id='.$game_id.' and is_pay=464';
		$criteria->condition=get_where($criteria->condition,!empty($data_id),'sign_game_data_id',$data_id,'');
        $criteria->condition=get_like($criteria->condition,'sign_name,sign_account',$keywords,'');
        $criteria->order = 'id DESC';
		$data = array();
		$data['state'] = BaseCode::model()->getCode(370);
		$data['is_pay'] = BaseCode::model()->getCode(462);
		$data['game'] = GameList::model()->getGame();
		$data['data_id'] = $data_id;
		
		$data['game_data'] = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510');
        parent::_list($model, $criteria, 'event_mem_index', $data);
    }
    // 添加报到
    public function actionAdd_register(){
		$id = $_POST['id'];
        $modelName = $this->model;
		$model = $this->loadModel($id, $modelName);
		// $servicedata = GfServiceData::model()->find('gfid='.$model->sign_gfid.' and service_id='.$model->sign_game_id.' and service_data_id='.$model->sign_game_data_id);
		$servicedata = GfServiceData::model()->find('order_num='.$model->order_num);
		$game=GameList::model()->find('id='.$model->sign_game_id);
		$gamed=GameListData::model()->find('id='.$model->sign_game_data_id);
		if(empty($servicedata)){
			$servicedata = new GfServiceData();
			$servicedata->isNewRecord = true;
			unset($servicedata->id);
			$servicedata->order_num = $model->order_num;
		}
		$servicedata->order_no=0;
		$servicedata->order_type=351;
		$servicedata->project_id=$model->sign_project_id;
		$servicedata->game_user_type=789;
		$servicedata->supplier_id=$game->game_club_id;
		$servicedata->gfid=$model->sign_gfid;
		$servicedata->contact_phone=$model->sign_game_contect;
		$servicedata->service_id=$model->sign_game_id;
		$servicedata->service_code = $game->game_code;
		$servicedata->service_ico = $game->game_small_pic;
		$servicedata->service_name = $model->sign_game_name;
		$servicedata->service_data_id = $model->sign_game_data_id;
		$servicedata->service_data_name = $model->games_desc;
		$servicedata->servic_time_star = $game->game_time;
		$servicedata->servic_time_end = $game->game_time_end;
		$servicedata->buy_count =1;
		$servicedata->buy_price = $gamed->game_money;
		$servicedata->udate = date('Y-m-d h:i:s');
		$servicedata->check_way = $gamed->game_check_way;
		$servicedata->state = $model->agree_state;
		$servicedata->state_time = $model->uDate;
		$servicedata->order_itme = 757;
		$servicedata->is_pay = $model->is_pay;
		$servicedata->order_state=1170;
		$servicedata->add_time=$model->add_time;
		$servicedata->service_address= $game->game_address;
		$sv=$servicedata->save();
		show_status($sv,'添加成功',Yii::app()->request->urlReferrer,'操作失败');
	}

	// 报名
	public function actionPlayer($keywords='',$game_id='',$data_id=''){
		set_cookie('_currentUrl_', Yii::app()->request->url);
		if($data_id>0){
			$gamedata = GameListData::model()->find('id='.$data_id);
			if($gamedata->game_player_team!=665){
				// 如果非个人，跳转到团队表
				// Yii::app()->runController('GameTeamTable/player');
				$this->redirect(array('GameTeamTable/player','game_id'=>$game_id,'data_id'=>$data_id));
			}
		}
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		$criteria->condition = 'state=721 and team_id is null and if(add_type=0,state<>721,1=1)';
		$criteria->condition = get_where($criteria->condition,$game_id,'sign_game_id',$game_id,'');
		$criteria->condition = get_where($criteria->condition,$data_id,'sign_game_data_id',$data_id,'');
		$criteria->condition = get_like($criteria->condition,'sign_name,sign_account',$keywords,'');
		$data = array();
		$data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and state=2 and Signup_date_end>now()');
		parent::_list($model, $criteria, 'player', $data);
	}

	public function actionData_id($game_id){
		$data = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510');
		$game_data = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510 group by project_id');
		$row = array();
		$poj = array();
		if(!empty($data)){
			foreach($data as $d => $val){
				// array_push($row,[$d->id,$d->game_data_name]);
				$row[$d]['id'] = $val->id;
				$row[$d]['game_data_name'] = $val->game_data_name;
			}
			foreach($game_data as $g => $pj){
				$poj[$g]['project_id'] = $pj->project_id;
				$poj[$g]['project_name'] = $pj->project_name;
			}
		}
		echo CJSON::encode([$row,$poj]);
	}

	// 赛事历史记录成员列表
	public function actionIndex_history($keywords='',$game_id='',$data_id=''){
		set_cookie('_currentUrl_',Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		$game_id = empty($game_id) ? 0 : $game_id;
		$criteria->condition = 'sign_game_id='.$game_id;
		$criteria->condition = get_where($criteria->condition,!empty($data_id),'sign_game_data_id',$data_id,'');
		$criteria->condition = get_like($criteria->condition,'sign_account,sign_name',$keywords,'');
		$data = array();
		$data['data_list'] = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510');
		parent::_list($model,$criteria,'index_history',$data);
	}

	// player撤销审核与提交审核操作
	public function actionClickCheck($id,$state,$box=0){
		$modelName = $this->model;
		$sid = explode(',',$id);
		$st = 0;
		foreach($sid as $d){
			$ex = explode(':',$d);
			// $ex[1]==0：个人成员  $ex[1]==1：团队成员
			if($ex[1]==0){
				$model = $this->loadModel($ex[0],$modelName);
				$money = $model->game_money;
				// $model->is_pay = ((empty($money) || $money=='0.00') && $state==2) ? 464 : $model->is_pay;
				$model->state = ($state==371) ? 2 : $state;  // (($model->game_list_data->game_check_way==793) && $state==371) ? 2 : $state;
				$model->is_pay = ($model->add_type==1 || ($model->game_list_data->game_check_way==792 && (empty($model->game_money) || $model->game_money==0.00))) ? 464 : $model->is_pay;  // (((empty($money) || $money=='0.00') && $state==2) || (($model->game_list_data->game_check_way==793) && $state==371)) ? 464 : $model->is_pay;
				$model->save();
			}
			else{
				$model = GameTeamTable::model()->find('id='.$ex[0]);
				$money = $model->game_money;
				$state1 = ($state==371) ? 2 : $state;  // (($model->game_list_data->game_check_way==793) && $state==371) ? 2 : $state;
				// $is_pay = ($state==371) ? 464 : $model->is_pay;  // (((empty($money) || $money=='0.00') && $state==2) || (($model->game_list_data->game_check_way==793) && $state==371)) ? 464 : $model->is_pay;
                GameSignList::model()->updateAll(array('state'=>$state1),'team_id='.$model->id);
				$model->state = $state1;
				$model->is_pay = (($state==2 || $state==371) && (empty($money) || $money=='0.00')) ? 464 : $model->is_pay;
				$model->save();
			}
			$this->save_sign_update($model,$state,$box);
			$st++;
		}
		show_status($st,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
	}

	/**
	 * 更新服务的审核状态与缴费状态
	 */
	function save_sign_update($model,$state,$box){
		$gf_service_data = GfServiceData::model()->find('order_num="'.$model->order_num.'"');
		$game_data = GameListData::model()->find('id='.$model->sign_game_data_id);
		// if($game_data->game_check_way==793 && $model->state==371){
		// 	$model->state = 2;
		// }
		$n = 0;
		$order_state = ($state==371 || ($state==2 && $game_data->game_money==0)) ? 1462 : $gf_service_data->order_state;
		$is_pay = $model->is_pay;
		if($model->add_type==1 || ($game_data->game_check_way==792 && (empty($model->game_money) || $model->game_money==0.00))) {
			// $state = 2;
			$is_pay = 464;
			$order_state = 1462;
			$n = 1;
		}
		if(!empty($gf_service_data)){
	
			$gf_service_data->state = ($state==371) ? 2 : $state;
			$gf_service_data->is_pay = $is_pay; 
			$gf_service_data->order_state = $order_state; 
			$gf_service_data->save();
		}
		// 生成购物车信息
		// 后台审核通过不发通知
		if($box==1 && $n==0){  // || ($game_data->game_check_way==793 && $model->state==2)) && $model->state==2
			$this->save_shopping($model,$gf_service_data);
		}
	}

	/**
	 * 保存或更新服务信息
	 */
	public function save_serviceData($model,$state){
		$model1 = $this->model;
		// $ms='service_id ='.$model->sign_game_id.' and service_data_id ='.$model->sign_game_data_id;
		// $servicedata = GfServiceData::model()->find($ms.' and gfid ='. $model->sign_gfid);
		$game=GameList::model()->find('id='.$model->sign_game_id);
		$gamed=GameListData::model()->find('id='.$model->sign_game_data_id);
		// if (empty($servicedata)){
	        $servicedata = new GfServiceData();
	        $servicedata->isNewRecord = true;
			$servicedata->order_num = $this->get_max_order_num();
			unset($servicedata->id);
		// }
		$servicedata->order_type = 351;
		$servicedata->game_user_type = 789;
		$servicedata->project_id = $model->sign_project_id;
		$servicedata->supplier_id = get_session('club_id');
		$servicedata->gfid = $model->sign_gfid;
		$servicedata->gf_account = $model->sign_account;
		$servicedata->gf_name = $model->sign_name;
		$servicedata->contact_phone = $model->sign_game_contect;
		$servicedata->service_id =$model->sign_game_id;
		$servicedata->service_code = $game->game_code;
		$servicedata->service_ico = $game->game_small_pic;
		$servicedata->service_name = $game->game_title;
		$servicedata->service_data_id =$model->sign_game_data_id;
		$servicedata->service_data_name = $gamed->game_data_name;
		$servicedata->servic_time_star = $game->game_time;
		$servicedata->servic_time_end = $game->game_time_end;
		$servicedata->buy_count = 1;
		$servicedata->buy_price = $gamed->game_money;
		$servicedata->check_way = $gamed->game_check_way;
		$servicedata->adminid = get_session('admin_id');
		$servicedata->order_itme = 757;
		$servicedata->free_make = ($model->add_type==1) ? 0 : 1;  // 后台添加的为免单0
		$servicedata->free_money = $gamed->game_money;
		$servicedata->state = $state;
		$servicedata->udate = date('Y-m-d h:i:s');
		// if(($model->game_money==0)&&($model->state = 2)) {
			$servicedata->is_pay = 463;
			$servicedata->order_state = ($state==371 || $state==2) ? 1462 : 1167;  // $servicedata->order_state=$servicedata->is_pay;
		// }
		if($state==371){
			$servicedata->order_state = 1168;
		}
		$model1::model()->updateByPk($model->id,array('order_num'=>$servicedata->order_num));
		$sv = $servicedata->save();
		$this->base_no($servicedata->id,$servicedata->gf_account,$servicedata->order_num);
	}

	// 获取报名类型，如：个人  团队  混双
	// 暂时不用
	public function actionChangeDataid($data_id){
		$model = GameListData::model()->find('id='.$data_id);
		$data = array();
		if(!empty($model)){
			$data = array('name'=>$model->game_player_team_name);
		}
		echo CJSON::encode($data);
	}

	// 添加成员
	public function actionAddsign(){
		$modelName = $this->model;
		$model = new $modelName('addsign');
		$data = array();
		if(!Yii::app()->request->isPostRequest){
			$data['model'] = $model;
			$this->render('addsign', $data);
		}
		else{
			$this->actionAddForm($_POST['GameSignList']['sign_game_id'],$_POST['GameSignList']['sign_game_data_id']);
		}
	}

	public function actionAddForm($game_id,$data_id){
		$modelName = $this->model;
		$signlist = new $modelName;
		
		$game_data_id = GameListData::model()->find('id='.$data_id);
		$sv = 0;
		$pic = '';
		$state = 721;
		if(!empty($_POST['add_form']))
			foreach($_POST['add_form'] as $v){
              $sacc=$v['sign_account'];
			  $gfuser = userlist::model()->find('GF_ACCOUNT="'.$sacc.'" and passed=2 and user_state=506');
			  $old =$signlist->find('sign_game_data_id ='.$data_id." and sign_account='".$sacc."'");
			if($sacc=='' || empty($gfuser) || !empty($old)){
			    $sv+=(!empty($old)) ? 1 : 0;
				continue;
			}
			$signlist->isNewRecord = true;
			unset($signlist->id);
			$signlist->sign_game_id = $game_id;
			$signlist->sign_game_data_id = $data_id;
			$signlist->sign_gfid = $gfuser->GF_ID;
			$signlist->sign_account =$sacc;
		
			$signlist->sign_game_name = $game_data_id->game_name;
			$signlist->games_desc = $game_data_id->game_data_name;
			$signlist->sign_project_id = $game_data_id->project_id;
	
			$signlist->sign_project_name = $game_data_id->project_name;
			$signlist->game_money = $game_data_id->game_money;
			$signlist->sign_sname = $v['sign_sname'];
			$signlist->health_date = $v['health_date'];
			$signlist->sign_name = $gfuser->ZSXM;
		
			$signlist->sign_height = $gfuser->height;
			$signlist->sign_weight = $gfuser->weight;
			$signlist->sign_sex = $gfuser->real_sex;

			$signlist->sign_head_pic = $gfuser->TXNAME;
			$signlist->athlete_rank = $gfuser->athlete_rank;
		
			$signlist->state = $state;
			$signlist->if_del = 510;
			$signlist->is_pay = 463;  // 后台添加的提交后为免单并已支付
			$signlist->add_type = 1;  // 后台添加的状态为1
			
			$sb=$signlist->save();
			$pic .= $signlist->sign_head_pic.',';
			$this->save_serviceData($signlist,$signlist->state);
			$sv++;
		}

		show_status($sv,'保存成功',get_cookie('_currentUrl_'),'保存失败');
	}



	// 报名审核列表
	public function actionIndex_exam($keywords='',$game_id='',$data_id='',$time_start='',$time_end=''){
		set_cookie('_currentUrl_',Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		if($data_id>0){
			$gamedata = GameListData::model()->find('id='.$data_id);
			if($gamedata->game_player_team!=665){
				// 如果是个人，跳转到个人表
				// Yii::app()->runController('GameTeamTable/player');
				$this->redirect(array('GameTeamTable/index_exam','game_id'=>$game_id,'data_id'=>$data_id,'keywords'=>$keywords,'time_start'=>$time_start,'time_end'=>$time_end));
			}
		}
		$criteria->condition = 'team_id is null and state not in(721,371)';
		$criteria->condition .= ' and exists(select * from game_list where '.get_where_club_project('game_club_id').' and id=t.sign_game_id and game_state<>149 and Signup_date_end>now())';
		$criteria->condition = get_where($criteria->condition,!empty($game_id),'sign_game_id',$game_id,'');
		$criteria->condition = get_where($criteria->condition,!empty($data_id),'sign_game_data_id',$data_id,'');
		$criteria->condition = get_where($criteria->condition,!empty($time_start),'left(state_time,10)>=',$time_start,'"');
		$criteria->condition = get_where($criteria->condition,!empty($time_end),'left(state_time,10)<=',$time_end,'"');
		$criteria->condition = get_like($criteria->condition,'sign_account,sign_name',$keywords,'');
		$data = array();
		$data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and state=2 and Signup_date_end>now()');
		$data['count1'] = $model->count('state=371 and team_id is null and exists(select * from game_list_data gl where t.sign_game_data_id=gl.id and gl.state=2 and gl.gl.signup_date_end>now())');
		$data['count2'] = GameTeamTable::model()->count('state=371 and exists(select * from game_list_data gl where t.sign_game_data_id=gl.id and gl.state=2 and gl.gl.signup_date_end>now())');
		parent::_list($model,$criteria,'index_exam',$data);
	}

	// 待审核
	public function actionTo_audited($game_id='',$data_id=''){
		set_cookie('_currentUrl_',Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		if($data_id>0){
			$gamedata = GameListData::model()->find('id='.$data_id);
			if($gamedata->game_player_team!=665){
				// 如果是团队，跳转到团队表
				// Yii::app()->runController('GameTeamTable/player');
				$this->redirect(array('GameTeamTable/to_audited','game_id'=>$game_id,'data_id'=>$data_id));
			}
		}
		$criteria->condition = 'state=371 and team_id is null';  //  and sign_game_id='.$game_id.' and sign_game_data_id='.$data_id
		$criteria->condition .= ' and exists(select * from game_list_data gl where t.sign_game_data_id=gl.id and gl.state=2 and gl.gl.signup_date_end>now())';
		$criteria->condition = get_where($criteria->condition,!empty($game_id),'sign_game_id',$game_id,'');
		$criteria->condition = get_where($criteria->condition,!empty($data_id),'sign_game_data_id',$data_id,'');
		$data = array();
		$data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and state=2 and Signup_date_end>now()');
		$data['count1'] = $model->count('state=371 and team_id is null and exists(select * from game_list_data gl where t.sign_game_data_id=gl.id and gl.state=2 and gl.gl.signup_date_end>now())');
		$data['count2'] = GameTeamTable::model()->count('state=371 and exists(select * from game_list_data gl where t.sign_game_data_id=gl.id and gl.state=2 and gl.gl.signup_date_end>now())');
		parent::_list($model,$criteria,'to_audited',$data);
	}

	// 取消/审核未通过
	public function actionIndex_tobe_exam($keywords='',$time_start='',$time_end=''){
		set_cookie('_currentUrl_',Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		$criteria->condition = 'state in(373,374) and team_id is null';
		$criteria->condition .= ' and exists(select * from game_list where '.get_where_club_project('game_club_id').' and id=t.sign_game_id)';
		$criteria->condition = get_where($criteria->condition,!empty($time_start),'left(state_time,10)>=',$time_start,'"');
		$criteria->condition = get_where($criteria->condition,!empty($time_end),'left(state_time,10)<=',$time_end,'"');
		$criteria->condition = get_like($criteria->condition,'sign_game_name',$keywords,'');
		$criteria->order = 'id DESC';
		$data = array();
		parent::_list($model,$criteria,'index_tobe_exam',$data);
	}

	// 查看报名成功
	public function actionSign_exam($keywords='',$game_id='',$data_id='',$time_start='',$time_end='',$back=''){
		set_cookie('_currentUrl_',Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		if($data_id>0){
			$gamedata = GameListData::model()->find('id='.$data_id);
			if($gamedata->game_player_team!=665){
				// 如果是个人，跳转到个人表
				$this->redirect(array('GameTeamTable/sign_exam','game_id'=>$game_id,'data_id'=>$data_id,'back'=>$back));
			}
		}
		$criteria->condition = 'team_id is null and state=2 and pay_confirm=1';
		$criteria->condition .= ' and exists(select * from game_list where '.get_where_club_project('game_club_id').' and id=t.sign_game_id)';
		$criteria->condition = get_where($criteria->condition,!empty($game_id),'sign_game_id',$game_id,'');
		$criteria->condition = get_where($criteria->condition,!empty($data_id),'sign_game_data_id',$data_id,'');
		$criteria->condition = get_where($criteria->condition,!empty($time_start),'left(state_time,10)>=',$time_start,'"');
		$criteria->condition = get_where($criteria->condition,!empty($time_end),'left(state_time,10)<=',$time_end,'"');
		$criteria->condition = get_like($criteria->condition,'sign_account,sign_name',$keywords,'');
		$data = array();
		$data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and state=2 and if_del=510');  //  and Signup_date_end>now()
		$data['count1'] = $model->count('state=371 and team_id is null and exists(select * from game_list_data gl where t.sign_game_data_id=gl.id and gl.state=2 and gl.gl.signup_date_end>now())');
		$data['count2'] = GameTeamTable::model()->count('state=371 and exists(select * from game_list_data gl where t.sign_game_data_id=gl.id and gl.state=2 and gl.gl.signup_date_end>now())');
		parent::_list($model,$criteria,'sign_exam',$data);
	}

	// 赛事列表 查看报名成员
	public function actionGame_list_sign($game_id,$data_id='',$game_player='',$back='',$project_id='',$keywords=''){
		set_cookie('_currentUrl_', Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		$project_list=GameListData::model()->findAll('game_id=' . $game_id .' and if_del=510 group by project_id');
		$criteria->select = "t.id,CASE b.game_player_team WHEN 665 THEN t.sign_name WHEN 666 THEN CONCAT(t.team_name,'队') ELSE GROUP_CONCAT(CONCAT(t.sign_name,'(',if(u.real_sex=205,'男','女'),')') SEPARATOR '<br>') END as sign_name,t.team_id,t.sign_project_name,t.games_desc,t.add_type,t.game_money,t.add_time,t.state_time,t.pay_time,t.pay_confirm_time,t.sign_game_data_id";
		$criteria->condition = 't.sign_game_id='.$game_id.' AND t.state=2 and t.is_pay=464 and t.pay_confirm=1';
		$criteria->condition = get_like($criteria->condition,'sign_name',$keywords,'');
		$criteria->condition = get_where($criteria->condition,!empty($data_id),'sign_game_data_id',$data_id,'');
		$criteria->condition .= ' GROUP BY CASE b.game_player_team WHEN 665 THEN t.id ELSE t.team_id END';
		$criteria->join = "LEFT JOIN game_list_data b ON t.sign_game_data_id=b.id LEFT JOIN userlist u ON t.sign_gfid=u.GF_ID";
		$data = array();
		$data['project_list'] = $project_list;
		$data['data_id'] = $data_id;
		$data['project_id'] = $project_id;
		parent::_list($model,$criteria,'game_list_sign',$data,10);
	}

	public function actionGetDataByProject($game_id,$project_id){
		$data = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510'.(empty($project_id)?'':' and project_id='.$project_id));
		$row = array();
		if(!empty($data)){
			foreach($data as $d => $val){
				$row[$d]['id'] = $val->id;
				$row[$d]['game_data_name'] = $val->game_data_name;
				$row[$d]['game_mode'] = $val->game_mode;
				$row[$d]['game_mode_name'] = $val->game_mode_name;
			}
		}
		echo CJSON::encode([$row]);
	}
}