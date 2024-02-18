<?php

class GameTeamTableController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = 'GameTeamTable';
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '',$game_id=0,$data_id=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = ($game_id==0) ? '1' : 'game_id='.$game_id;
		if ($data_id >0) {
          $criteria->condition.=' AND sign_game_data_id='. $data_id;
        }
		$criteria->condition=get_like($criteria->condition,'name,game_name',$keywords,'');
		$criteria->order = 'id DESC';
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
	
	public function actionIndex_rank($keywords = '',$game_id=0,$data_id=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = ($game_id==0) ? '1' : 'game_id='.$game_id;
		if ($data_id >0) {
          $criteria->condition.=' AND sign_game_data_id='. $data_id;
        }
		$criteria->condition=get_like($criteria->condition,'name',$keywords,'');
        $criteria->order = 'ranking ASC'.',udate desc';
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

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        }else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
           $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }
    function saveData($model,$post) {
		$model->attributes =$post;
		$data_type = $post['data_type'];
		$gamesign = new GameSignList();
		$count_sign=0;
		$w1='team_id='.$model->id .' and sign_game_data_id='.$post['sign_game_data_id'].' and if_del=510';
		if(!empty($model->id)){
				$count_sign = GameSignList::model()->count($w1);
		}
		if($model->state==200) {
			ajax_status(0, '已审核，数据无法修改');
		} else {
			if ($_POST['submitType'] == 'shenhe') {
				if($count_sign>0){
					$model->state = 2;
					if($_POST['submitType']=='shenhe') {
						$model->is_pay = 464;
					}
					$st=$model->save();
					$this->save_Service($model,$model->state,$model->check_team);
					$action=$this->createUrl('index', array('data_id'=>$model->sign_game_data_id,'game_id'=>$model->game_id,'game_name'=>$model->game_name,'data_type'=>$data_type));
				} else {
					ajax_status(0, '团队没有成员，无法审核');
				}
			} else if ($_POST['submitType'] == 'baocun') {
				$model->state = 721;
				$st=$model->save();
				$action=$this->createUrl('update', array('id'=>$model->id,'data_id'=>$model->sign_game_data_id,'game_id'=>$model->game_id,'game_name'=>$model->game_name));
			} else if ($_POST['submitType'] == 'tongguo') {
				$model->state = 2;
				if($model->add_type==1 || ($model->game_list_data->game_check_way==792 && (empty($model->game_money) || $model->game_money==0.00))) {
					$model->is_pay = 464;
				}
				$action=$this->createUrl('index', array('data_id'=>$model->sign_game_data_id,'game_id'=>$model->game_id,'game_name'=>$model->game_name,'data_type'=>$data_type));
				$st=$model->save();
				$this->save_Service($model,$model->state,$post['check_team']);
			} else if ($_POST['submitType'] == 'butongguo') {
				$model->is_pay = 463;
				$model->state = 373;
				$st=$model->save();
				$service_data = GfServiceData::model()->find('order_num="'.$model->order_num.'"');
				$service_data->state = $model->state;
				$service_data->order_state = ($model->state==373) ? 373 : $service_data->order_state;
				$service_data->reasons_for_failure = ($model->state==373) ? '参赛成员不符合赛事要求' : '';
				$service_data->save();
				$action=$this->createUrl('index', array('data_id'=>$model->sign_game_data_id,'game_id'=>$model->game_id,'game_name'=>$model->game_name,'data_type'=>$data_type));
				$service_list = GfServiceData::model()->find('service_id='.$model->sign_game_id.'service_data_id='.$model->sign_game_data_id.' and gf_account="'.$model->create_account.'"');
				if(!empty($service_list)){
					$this->notice($service_list->gfid,$service_list->gf_account,$service_list->service_name,$service_list->service_data_id,$service_list->service_data_name,$service_list->order_num,$service_list->service_ico,315,1,1);
				}
			} else {
				$model->state = 721;
				$st=$model->save();
				$action=$this->createUrl('update', array('id'=>$model->id,'data_id'=>$model->sign_game_data_id,'game_id'=>$model->game_id,'game_name'=>$model->game_name));
			}
			//$st=$model->save();
		}
		$_POST['sign_id'] = (empty($_POST['sign_id'])) ? 0 : $_POST['sign_id'];
		$this->delete_sign($_POST['sign_id'],$model->sign_game_data_id,$model->id,'');
		// show_status($st,'保存成功', $action,'保存失败');
		show_status($st,'操作成功', get_cookie('_currentUrl_'),'操作失败');
    }

	function save_Service($model,$state,$box){
		$this->save_sign_update($model,$state,$box);
	}

	/**
	 * 更新成员与服务的审核状态与缴费状态
	 */
	function save_sign_update($model,$state,$box){
		// $game_sign_list = GameSignList::model()->findAll('team_id='.$model->id.' and sign_game_data_id='.$model->sign_game_data_id);
		$gf_service_data = GfServiceData::model()->find('order_num="'.$model->order_num.'"');
		$game_data = GameListData::model()->find('id='.$model->sign_game_data_id);
		$sign_money = $game_data->game_money;
		$order_state = ($state==371 || ($state==2 && $game_data->game_money==0)) ? 1462 : $gf_service_data->order_state;
		$is_pay = $model->is_pay;
		$n = 0;
		// if(($game_data->game_check_way==792 && $state==2) || ($model->add_type==1)){
		if($model->add_type==1 || ($game_data->game_check_way==792 && (empty($model->game_money) || $model->game_money==0.00))) {
			// $state = 2;
			$is_pay = 464;
			$order_state = 1462;
			$n = 1;
		}
		GameSignList::model()->updateAll(array('state'=>$model->state,'state_time'=>date('Y-m-d H:i:s'),'is_pay'=>$is_pay),'team_id='.$model->id.' and sign_game_data_id='.$model->sign_game_data_id);
		// if(!empty($game_sign_list))foreach($game_sign_list as $gl){
		// 	$gl->state = $state;
		// 	$model->state = (($game_data->game_check_way==793) && $state==371) ? 2 : $state;
		// 	$gl->is_pay = $is_pay;
		// 	$gl->save();
		// 	// $sign_money = $sign_money+$gl->game_money;
		// }
		GfServiceData::model()->updateAll(array('state'=>$model->state,'is_pay'=>$is_pay,'order_state'=>$order_state),'order_num="'.$model->order_num.'"');
		// if(!empty($gf_service_data)){
		// 	$gf_service_data->state = $state;
		// 	$gf_service_data->is_pay = $is_pay;
		// 	$gf_service_data->order_state = $order_state;  // ($model->game_money>0) ? ($state==2) ? 1169 : $gf_service_data->order_state :
		// 	$gf_service_data->save();
		// }
		// 生成购物车信息 人工审核box=1 发送通知 或 自动审核793 发送通知
		// 审核状态不发通知
		if($box==1 && $n==0){  //  || ($game_data->game_check_way==793 && $state==2)) && $state==2
			$this->save_shopping($model,$gf_service_data,$sign_money);
		}
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

	public function actionDelete($id) {
        $modelName = $this->model;
		$model = $modelName::model();
        $lode = explode(',', $id);
        $count = 0;
		foreach ($lode as $d) {
			$dl = explode(':', $d);
			if($dl[1]==0){
				$team_no = GameSignList::model()->find('id='.$dl[0]);
			}
			else{
				$team_no = GameTeamTable::model()->find('id='.$dl[0]);
			}
			GameSignList::model()->deleteAll('team_id='.$team_no->id.' AND sign_game_data_id='.$team_no->sign_game_data_id);
			if(!empty($team_no->order_num)){
				GfServiceData::model()->deleteAll('service_data_id='.$team_no->sign_game_data_id.' AND order_num='.$team_no->order_num);
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
	
	// 赛事报到团队列表
    public function actionEvent_mem_index($keywords = '',$game_id=0,$data_id=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = ($game_id==0) ? '1' : 'game_id='.$game_id.' and is_pay=464';
		if ($data_id >0) {
          $criteria->condition.=' AND sign_game_data_id='. $data_id;
        }
		$criteria->condition=get_like($criteria->condition,'name,game_name',$keywords,'');
        $criteria->order = 'id DESC';
		$data['data_id'] = $data_id;
		
		$data['game_data'] = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510');
        parent::_list($model, $criteria, 'event_mem_index', $data);
	}
	
    // 添加报到
    public function actionGet_add_register(){
		$id = $_POST['id'];
		
        $modelName = $this->model;
		$model = $this->loadModel($id, $modelName);
		// $s_id=GameSignList::model()->find('team_id='.$id);
		$servicedata = GfServiceData::model()->find('order_num='.$model->order_num);
		if(empty($servicedata)){
			$servicedata = new GfServiceData();
			$servicedata->isNewRecord = true;
			unset($servicedata->id);
		}
		$game=GameList::model()->find('id='.$model->game_id);
		$gamed=GameListData::model()->find('id='.$model->sign_game_data_id);
		$order_sign=GameSignList::model()->find('id='.$model->id.' ');
		$servicedata->order_num = $model->order_num;
		$servicedata->order_no=0;
		$servicedata->order_type=351;
		$servicedata->game_user_type = 789;
		$servicedata->project_id=$model->sign_project_id;
		$servicedata->supplier_id=$game->game_club_id;
		$servicedata->contact_phone = $order_sign['sign_game_contect'];
		$servicedata->service_id=$model->game_id;
		$servicedata->service_code = $game->game_code;
		$servicedata->service_ico = $game->game_small_pic;
		$servicedata->service_name = $model->game_name;
		$servicedata->service_data_id = $model->sign_game_data_id;
		$servicedata->service_data_name = $model->sign_game_data_name;
		$servicedata->servic_time_star = $game->game_time;
		$servicedata->servic_time_end = $game->game_time_end;
		$servicedata->buy_count =1;
		$servicedata->buy_price = $gamed->game_money;
		$servicedata->udate = date('Y-m-d h:i:s');
		$servicedata->check_way = $gamed->game_check_way;
		$servicedata->state = ($gamed->game_check_way==793 && $model->state==371) ? 2 : $model->state;
		$servicedata->order_itme = 757;
		$servicedata->is_pay = $model->is_pay;
		$servicedata->order_state=1170;
		$servicedata->add_time=$model->add_time;
		$sv=$servicedata->save();
		show_status($sv,'添加成功',Yii::app()->request->urlReferrer,'操作失败');
	}

	// 报名
	public function actionPlayer($game_id='',$data_id=''){
		set_cookie('_currentUrl_', Yii::app()->request->url);
		if($data_id>0){
			$gamedata = GameListData::model()->find('id='.$data_id);
			if($gamedata->game_player_team==665){
				// 如果是个人，跳转到个人表
				// Yii::app()->runController('GameSignList/player/game_id='.$game_id.'/data_id='.$data_id);
				$this->redirect(array('GameSignList/player','game_id'=>$game_id,'data_id'=>$data_id));
			}
		}
		$modelName = $this->model;
        $model = $modelName::model();
		$criteria = new CDbCriteria;
		$criteria->condition = 'state=721 and if(add_type=0,state<>721,1=1)';
		$criteria->condition = get_where($criteria->condition,!empty($game_id),'game_id',$game_id,'');
		$criteria->condition = get_where($criteria->condition,!empty($data_id),'sign_game_data_id',$data_id,'');
		$data = array();
		$data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and state=2 and Signup_date_end>now()');
		parent::_list($model, $criteria, 'player', $data);
	}

	// 查询项目
	public function actionData_id($game_id){
		$data = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510');  // .' and game_player_team in(666,982)'
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

	// 成员帐号验证
    public function actionValidate($game_id=0,$data_id=0,$gf_account=0) {
		$this->redirect(array('GameSignList/validate','game_id'=>$game_id,'data_id'=>$data_id,'gf_account'=>$gf_account));
	}

	// 添加团队
	public function actionAddsign(){
		$modelName = $this->model;
		$model = new $modelName('addsign');
		$data = array();
		if(!Yii::app()->request->isPostRequest){
			$data['model'] = $model;
			$this->render('addsign', $data);
		}
		else{
			$this->actionAddForm($model,$_POST[$modelName],0);
		}
	}

	public function actionAddForm($model,$post,$n){
		$model->attributes = $post;
		$model->add_type = 1;  // 后台添加的状态为1
		$state = get_check_code($_POST['submitType']);
		$model->state = ($state==371 && $state!=721 && $state!=373) ? 2 : $state;
		$sv = $model->save();
		$game_data_id = GameListData::model()->find('id='.$model->sign_game_data_id);
		$s_id = '';
		if(!empty($_POST['add_form']))foreach($_POST['add_form'] as $key => $v){
			if($v['sign_account']==''){
				continue;
			}
			if($key==1){
				$model->updateByPk($model->id,array('create_account'=>$v['sign_account']));
				$this->save_Servicec($model,$v['sign_account'],$game_data_id->project_id);
			}
			$gfuser = userlist::model()->find('GF_ACCOUNT="'.$v['sign_account'].'" and passed=2 and user_state=506');
			$model1 = GameTeamTable::model()->find('id='.$model->id);
			if(!empty($gfuser)){
				$signlist = new GameSignList;
				$signlist->isNewRecord = true;
				unset($signlist->id);
				$signlist->team_id = $model->id;
				$signlist->team_name = $model->name;
				$signlist->sign_game_id = $game_data_id->game_id;
				$signlist->sign_game_data_id = $game_data_id->id;
				$signlist->sign_game_name = $game_data_id->game_name;
				$signlist->games_desc = $game_data_id->game_data_name;
				$signlist->sign_project_id = $game_data_id->project_id;
				$signlist->sign_project_name = $game_data_id->project_name;
				$signlist->game_money = $game_data_id->game_money;
				$signlist->sign_gfid = $gfuser->GF_ID;
				$signlist->sign_sname = $v['sign_sname'];
				$signlist->health_date = (empty($v['health_date'])) ? $gfuser->health_date : $v['health_date'];
				$signlist->game_man_name = $v['game_man_name'];
				$signlist->athlete_rank = (empty($v['athlete_rank'])) ? $gfuser->athlete_rank : $v['athlete_rank'];
				$signlist->sign_name = $gfuser->ZSXM;
				$signlist->sign_game_contect = $gfuser->PHONE;
				$signlist->sign_height = $gfuser->height;
				$signlist->sign_weight = $gfuser->weight;
				$signlist->sign_sex = $gfuser->real_sex;
				$signlist->sign_head_pic = $gfuser->TXNAME;
				$signlist->if_del = 510;
				$signlist->state = $model->state;
				$signlist->is_pay = 463;  // 后台添加的为免单并已支付
				$signlist->add_time = date('Y-m-d H:i:s');
				$signlist->add_type = 1;  // 后台添加的状态为1
				if(!empty($model1)){
					$signlist->order_num = $model1->order_num;
				}
				$signlist->save();
				$s_id .= $signlist->id.',';
				// $this->redirect(array('GameSignList/save_serviceData','model'=>$signlist));
			}
			$sv = 1;
		}
		if($n==1){
			$this->save_Servicec($model,$model->create_account,$game_data_id->project_id,1,1);
			$_POST['sign_id'] = (empty($_POST['sign_id'])) ? 0 : $_POST['sign_id'];
			$this->delete_sign($_POST['sign_id'],$model->sign_game_data_id,$model->id,$s_id);
			$sv = 1;
		}
		show_status($sv,'保存成功',get_cookie('_currentUrl_'),'保存失败');
	}

	/**
	 * 添加服务报名 团队只添加队长一条.
	 * $ac=0：添加  $ac=1 修改
	 */
	public function save_Servicec($model,$account,$project_id,$ac=0) {
		$ms='service_id ='.$model->game_id.' and service_data_id ='.$model->sign_game_data_id;
		$servicedata = GfServiceData::model()->find($ms.' and gf_account="'.$model->create_account.'"');
		$game = GameList::model()->find('id='.$model->game_id);
		$gamed = GameListData::model()->find('id='.$model->sign_game_data_id);
		$gf_user = userlist::model()->find('GF_ACCOUNT="'.$account.'"');
		if(empty($servicedata)){
	        $servicedata = new GfServiceData();
	        $servicedata->isNewRecord = true;
			unset($servicedata->id);
			$servicedata->order_num = $this->get_max_order_num();
			$servicedata->order_type = 351;
			$servicedata->game_user_type = 789;
			$servicedata->project_id = $project_id;
			$servicedata->supplier_id = (!empty($model->game_id)) ? $model->game_list->game_club_id : '';
			$servicedata->gfid = (!empty($gf_user)) ? $gf_user->GF_ID : '';
			$servicedata->gf_account = $account;
			$servicedata->gf_name = (!empty($gf_user)) ? $gf_user->ZSXM : '';
			$servicedata->contact_phone = (!empty($gf_user)) ? $gf_user->security_phone : '';
			$servicedata->service_id = $model->game_id;
			$servicedata->service_code = $game->game_code;
			$servicedata->service_ico = $game->game_small_pic;
			$servicedata->service_name = $game->game_title;
			$servicedata->service_data_id = $model->sign_game_data_id;
			$servicedata->service_data_name = $gamed->game_data_name;
			$servicedata->servic_time_star = $game->game_time;
			$servicedata->servic_time_end = $game->game_time_end;
			$servicedata->buy_count = 1;
			$servicedata->buy_price = $gamed->game_money;
			$servicedata->check_way = $gamed->game_check_way;
			$servicedata->adminid = get_session('admin_id');
			$servicedata->order_itme = 757;
		}
		$servicedata->free_make = ($model->add_type==1) ? 0 : 1;  // 后台添加的为免单0
		$servicedata->free_money = $gamed->game_money;
		$servicedata->state = $model->state;
		$servicedata->udate = date('Y-m-d h:i:s');
		$money1 = $gamed->game_money;
		$order_state = ($model->state==373) ? 373 : 1169;
		// if($model->state==371 || ($model->state==2 && empty($money1))) {
			$servicedata->is_pay = (($model->state==2 && (empty($money1) || $money1==0.00 || $money1=='0.00'))) ? 464 : $servicedata->is_pay;
			$servicedata->order_state = (($model->state==2 && (empty($money1) || $money1==0.00 || $money1=='0.00'))) ? 1462 : $order_state;  // $servicedata->order_state=$servicedata->is_pay;
		// }
		$sv = $servicedata->save();
		if($ac==0){
			if($sv){
				GameTeamTable::model()->updateByPk($model->id,array('order_num'=>$servicedata->order_num));
			}
			$this->base_no($servicedata->id,$account,$servicedata->order_num);
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

	// 删除成员
	function delete_sign($post,$data_id,$team_id,$s_id){
		$sid = $s_id;
		if(isset($post) && !empty($post))foreach($post as $n){
			$sid .= $n['id'].',';
		}
		$sid = (empty($sid)) ? 0 : $sid;
		GameSignList::model()->updateAll(array('if_del'=>509),'team_id='.$team_id .' and sign_game_data_id='.$data_id.' and id not in('.rtrim($sid,',').')');
	}

	public function actionPlayer_update($id){
		$modelName = $this->model;
		$model = $this->loadModel($id,$modelName);
		$data = array();
		if(!Yii::app()->request->isPostRequest){
			$data['model'] = $model;
			$this->render('player_update',$data);
		}
		else{
			if($_POST['submitType']=='baocun'){
				$this->actionAddForm($model,$_POST[$modelName],1);
		
			}
			else{
				$this->saveData($model,$_POST[$modelName]);
			}
		}
	}

	// player撤销审核与提交审核操作
	public function actionClickCheck($id,$state,$box=0){
		$modelName = $this->model;
		$st = explode(',',$id);
		$r = 0;
		foreach($st as $d){
			$ex = explode(':',$d);
			// $state = 2;
			if($ex[1]==1){
				$model = $this->loadModel($ex[0],$modelName);
				$money = $model->game_money;
				$is_pay = (((empty($money) || $money=='0.00' || $money==0.00) && $state==2) || ($state==371)) ? 464 : $model->is_pay;
				$model->state = ($state==371) ? 2 : $state;
				$model->is_pay = $is_pay;
				$model->save();
			}
			else{
				$model = GameSignList::model()->find('id='.$ex[0]);
				$model->updateByPk($ex[0],array('state'=>($state==371) ? 2 : $state));
				$money = $model->game_money;
				// $state1 = (($model->game_list_data->game_check_way==793) && $state==371) ? 2 : $state;
				$is_pay = (((empty($money) || $money=='0.00' || $money==0.00) && $state==2) || ($state==371)) ? 464 : $model->is_pay;
                GameSignList::model()->updateAll(array('state'=>$state1),'team_id='.$model->id);
				$money = $model->game_money;
				$model->state = ($state==371) ? 2 : $state;
				$model->is_pay = $is_pay;
				$model->save();
			}
			$this->save_sign_update($model,$state,$box);
			$r++;
		}
		show_status($r,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
	}

	// 报名审核列表
	public function actionIndex_exam($keywords='',$game_id='',$data_id='',$time_start='',$time_end=''){
		set_cookie('_currentUrl_',Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		if($data_id>0){
			$gamedata = GameListData::model()->find('id='.$data_id);
			if($gamedata->game_player_team==665){
				// 如果是个人，跳转到个人表
				$this->redirect(array('GameSignList/index_exam','game_id'=>$game_id,'data_id'=>$data_id,'keywords'=>$keywords,'time_start'=>$time_start,'time_end'=>$time_end));
			}
		}
		$criteria->condition = 'state not in(721,371) and if_del=510';
		$criteria->condition .= ' and exists(select * from game_list where '.get_where_club_project('game_club_id').' and id=t.game_id and game_state<>149)';
		$criteria->condition = get_where($criteria->condition,!empty($game_id),'game_id',$game_id,'');
		$criteria->condition = get_where($criteria->condition,!empty($data_id),'sign_game_data_id',$data_id,'');
		$criteria->condition = get_where($criteria->condition,!empty($time_start),'left(state_time,10)>=',$time_start,'"');
		$criteria->condition = get_where($criteria->condition,!empty($time_end),'left(state_time,10)<=',$time_end,'"');
		$criteria->condition = get_like($criteria->condition,'sign_account,sign_name',$keywords,'');
		$data = array();
		$data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and state=2 and Signup_date_end>now()');
		$data['count1'] = $model->count('state=371 and exists(select * from game_list_data gl where t.sign_game_data_id=gl.id and gl.state=2 and gl.gl.signup_date_end>now())');
		$data['count2'] = GameSignList::model()->count('state=371 and team_id is null and exists(select * from game_list_data gl where t.sign_game_data_id=gl.id and gl.state=2 and gl.gl.signup_date_end>now())');
		parent::_list($model,$criteria,'index_exam',$data);
	}

	// 待审核
	public function actionTo_audited($game_id='',$data_id=''){
		set_cookie('_currentUrl_',Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		// $game_id = empty($game_id) ? 0 : $game_id;
		// $data_id = empty($data_id) ? 0 : $data_id;
		if($data_id>0){
			$gamedata = GameListData::model()->find('id='.$data_id);
			if($gamedata->game_player_team==665){
				// 如果是个人，跳转到个人表
				$this->redirect(array('GameSignList/to_audited','game_id'=>$game_id,'data_id'=>$data_id));
			}
		}
		$criteria->condition = 'state=371';  //  and game_id='.$game_id.' and sign_game_data_id='.$data_id
		$criteria->condition .= ' and exists(select * from game_list_data gl where t.sign_game_data_id=gl.id and gl.state=2 and gl.gl.signup_date_end>now())';  //
		$criteria->condition = get_where($criteria->condition,!empty($game_id),'game_id',$game_id,'');
		$criteria->condition = get_where($criteria->condition,!empty($data_id),'sign_game_data_id',$data_id,'');
		$data = array();
		$data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and state=2 and Signup_date_end>now()');
		$data['count1'] = $model->count('state=371 and exists(select * from game_list_data gl where t.sign_game_data_id=gl.id and gl.state=2 and gl.gl.signup_date_end>now())');
		$data['count2'] = GameSignList::model()->count('state=371 and team_id is null and exists(select * from game_list_data gl where t.sign_game_data_id=gl.id and gl.state=2 and gl.gl.signup_date_end>now())');
		parent::_list($model,$criteria,'to_audited',$data);
	}

	// 取消/审核未通过
	public function actionIndex_tobe_exam($keywords='',$time_start='',$time_end=''){
		set_cookie('_currentUrl_',Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		$criteria->condition = 'state in(373,374) and if_del=510';
		$criteria->condition .= ' and exists(select * from game_list where '.get_where_club_project('game_club_id').' and id=t.game_id)';
		$criteria->condition = get_where($criteria->condition,!empty($time_start),'left(state_time,10)>=',$time_start,'"');
		$criteria->condition = get_where($criteria->condition,!empty($time_end),'left(state_time,10)<=',$time_end,'"');
		$criteria->condition = get_like($criteria->condition,'game_name',$keywords,'');
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
			if($gamedata->game_player_team==665){
				// 如果是个人，跳转到个人表
				$this->redirect(array('GameSignList/sign_exam','game_id'=>$game_id,'data_id'=>$data_id,'back'=>$back));
			}
		}
		$criteria->condition = 'state=2 and pay_confirm=1';
		$criteria->condition .= ' and exists(select * from game_list where '.get_where_club_project('game_club_id').' and id=t.game_id)';
		$criteria->condition = get_where($criteria->condition,!empty($game_id),'game_id',$game_id,'');
		$criteria->condition = get_where($criteria->condition,!empty($data_id),'sign_game_data_id',$data_id,'');
		$criteria->condition = get_where($criteria->condition,!empty($time_start),'left(state_time,10)>=',$time_start,'"');
		$criteria->condition = get_where($criteria->condition,!empty($time_end),'left(state_time,10)<=',$time_end,'"');
		$criteria->condition = get_like($criteria->condition,'create_account,name',$keywords,'');
		$data = array();
		$data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and state=2 and if_del=510');  //  and Signup_date_end>now()
		$data['count1'] = GameSignList::model()->count('state=371 and team_id is null and exists(select * from game_list_data gl where t.sign_game_data_id=gl.id and gl.state=2 and gl.gl.signup_date_end>now())');
		$data['count2'] = GameTeamTable::model()->count('state=371 and exists(select * from game_list_data gl where t.sign_game_data_id=gl.id and gl.state=2 and gl.gl.signup_date_end>now())');
		parent::_list($model,$criteria,'sign_exam',$data);
	}

	/**
	 * 生成购物车信息
	 */
	function save_shopping($model,$service,$sign_money=0){
		$game_list = GameList::model()->find('id='.$model->game_id);
		$base_code = BaseCode::model()->find('f_id=351');
		$sign_level = ClubMemberList::model()->find('gf_account='.$model->create_account.' and member_project_id='.$model->sign_project_id.' and club_status=337');
		if($sign_money>0){
	        $order_data=array('order_type'=>351
	        	,'buyer_type'=>210
		        ,'order_gfid'=>$sign_list->member_gfid
		        ,'money'=>(empty($sign_money)) ? $model->game_money : $sign_money
		        ,'order_money'=>(empty($sign_money)) ? $model->game_money : $sign_money
		        ,'total_money'=>(empty($sign_money)) ? $model->game_money : $sign_money
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
				$cat_copy->buy_price = (empty($sign_money)) ? $model->game_money : $sign_money;  // 商品单价
				$cat_copy->buy_amount = (empty($sign_money)) ? $model->game_money : $sign_money;  // 购买实际金额
				$cat_copy->project_id = $model->sign_project_id;
				$cat_copy->project_name = $model->sign_project_name;
				$cat_copy->buy_level = $sign_level->project_level_id;
				$cat_copy->buy_level_name = $sign_level->project_level_name;
				$cat_copy->buy_count = 1;
				$cat_copy->gfid = $sign_level->member_gfid;
				$cat_copy->gf_name = $sign_level->zsxm;
				$cat_copy->service_id = $game_list->id;
				$cat_copy->service_code = $game_list->game_code;
				$cat_copy->service_ico = $game_list->game_small_pic;
				$cat_copy->service_name = $game_list->game_title;
				$cat_copy->service_data_id = $model->sign_game_data_id;
				$cat_copy->service_data_name = $model->sign_game_data_name;
				$cat_copy->uDate = date('Y-m-d H:i:s');
				$cat_copy->gf_club_id = $sign_level->club_id;
				$cat_copy->gf_service_id = $service->id;
				$cat_copy->effective_time = $game_list->effective_time;
				$st=$cat_copy->save();
			}
		}

		// 加入购物车成功后发送缴费通知
		$code = ($sign_money>0) ? 314 : 315;
		$pic = BasePath::model()->get_www_path().$game_list->game_small_pic;
		$order_num = ($code==315) ? $service->order_num : $add_order['order_num'];
		$this->notice($sign_level->member_gfid,$model->create_account,$game_list->game_title,$model->sign_game_data_id,$model->sign_game_data_name,$order_num,$pic,$code);
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
	 * $data_name = 竞赛项目名称.
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
	 * {"type":"赛事通知","pic":"http://xxx.png","title":"XXXX赛事","content":"报名审核通过，快去选择项目报名吧","url":"http://gf41.net/xxx.html?gfid=1888",”type_id”:”3”, "datas": [{"id":"91"}
	 */
	function notice($sign_gfid,$sign_account,$sign_game_name,$data_id,$data_name,$order_num,$pic,$code='',$noi=0,$num1=0){
		$type_id = 23;
		$admin_id = get_session('admin_id');
		$type = ($num1==0) ? '【缴费通知消息】' : '【审核通知】';
		$txt1 = '点击本条信息进入缴费界面';
		$txt2 = '点击本条信息进入查看界面';
		$txt3 = '恭喜您！您的赛事报名审核已通过';
		$txt4 = '很抱歉！您的赛事报名审核未通过';
		$noti1 = ($noi==0) ? $txt3 : $txt4;
		$noti2 = ($noi==0) ? $txt1 : $txt2;
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
			'content' => $data_name,
			'content_html' => $content_html,
			'order_num' => $order_num
		);
		if($code==315){
			new_message_send(315,$admin_id,$sign_gfid,json_encode($data315),0);
		}
		if($code==314){
			new_message_send(314,$admin_id,$sign_gfid,json_encode($data314),0);
		}
		GfServiceData::model()->updateAll(array('notice_content'=>$content_html,'sending_notice_time'=>date('Y-m-d H:i:s')),'service_data_id='.$data_id.' and gf_account="'.$sign_account.'"');
	}

	// 赛事列表 查看报名成员
	public function actionGame_list_sign($game_id,$data_id='',$game_player='',$back=''){
		set_cookie('_currentUrl_', Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		$data_id = empty($data_id) ? 0 : $data_id;
		if($data_id>0){
			if($game_player==665){
				$this->redirect(array('GameSignList/game_list_sign','game_id'=>$game_id,'data_id'=>$data_id,'back'=>$back));
			}
		}
		$criteria->condition = 'game_id='.$game_id.' and sign_game_data_id='.$data_id.' and state<>374 and is_pay=464 and pay_confirm=1';
		$data = array();
		$data['data_list'] = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510');
		parent::_list($model,$criteria,'game_list_sign',$data);
	}
}
