<?php

class GameRefereesListController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = 'GameRefereesList';
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '',$game_id=0,$data_id=0,$game='',$state='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$cr = ($game_id==0) ? '1' : 't.game_id='.$game_id;
		if ($data_id>0) {
		  	$cr .= ' AND FIND_IN_SET('.$data_id.',t.sign_game_data_id)';
        }
		$cr=get_where($cr,$game,'game_id',$game,'');
		$cr=get_where($cr,$state,'agree_state',$state,'');
		$criteria->condition=get_like($criteria->condition,'real_name,referee_gfaccount',$keywords,'');
        $criteria->order = 't.id';
		$data = array();
		$data['state'] = BaseCode::model()->getCode(370);
		$data['game'] = GameList::model()->getGame();
		$data['data_id'] = $data_id;
		$data['game_data'] = GameListData::model()->findAll('game_id='.$game_id.' ');
        parent::_list($model, $criteria, 'index', $data);
	}
	
	public function actionPlayer($game_id='',$project_id='',$star_time=''){
		set_cookie('_currentUrl_',Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		$game_id = empty($game_id) ? 0 : $game_id;
		$project_id = empty($project_id) ? 0 : $project_id;
		$star_time = empty($star_time) ? date('Y-m-d') : $star_time;
		$criteria->condition = 'game_id='.$game_id.' and project_id='.$project_id.' and left(send_date,10)>="'.$star_time.'"';
		$data = array();
		$data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and state=2 and datediff(now(),game_time_end)<60');
		$data['star_time'] = $star_time;
		parent::_list($model, $criteria, 'player', $data);
	}

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
			$data['game_data'] = array();
			$data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and state=2 and datediff(now(),game_time_end)<60');
            $this->render('update', $data);
        }else{
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
		   //$data['arr'] = array();
		   $data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and state=2 and datediff(now(),game_time_end)<60');
		   if (!empty($model->sign_game_data_id)) {
                $data['game_data'] = GameListData::model()->findAll('id in (' . $model->sign_game_data_id . ')');
            } else {
                $data['game_data'] = array();
            }
			//$data['arr'] = userlist::model()->getUser();
           $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
    function saveData($model,$post) {
		$model->attributes =$post;
		$title="";
		if (isset($_POST['submitType']) && ($_POST['submitType'] == 'shenhe')) {
			$model->agree_state = 371;
		} else if (isset($_POST['submitType']) && ($_POST['submitType'] == 'baocun')) {
			$model->agree_state = 721;
		} else if (isset($_POST['submitType']) && ($_POST['submitType'] == 'tongguo')) {
			$model->agree_state = 2;
			$title='恭喜，您参与的“'.$model->game_name.'”裁判报名，审核已通过。';
		} else if (isset($_POST['submitType']) && ($_POST['submitType'] == 'butongguo')) {
			$model->agree_state = 373;
			$title='抱歉，您参与的“'.$model->game_name.'”裁判报名，审核未通过。';
		} else {
			$model->agree_state = 721;
		}
		$st=$model->save();

		if($model->agree_state==2 || $model->agree_state==373) {
			$basepath=BasePath::model()->getPath(191);
			$project='';
			if(!empty($model->project_name)) {
				$project=$model->project_name;
			}
			$pic=$basepath->F_WWWPATH;
			$content='赛事信息：'.$model->game_name.'-'.$project;
		
			$url='';
			$type_id=23;
			$datas=$model->order_num;
			if($model->game_id!='') {
				$game_r=GameList::model()->find('id='.$model->game_id);
				$pic=$pic.$game_r->game_small_pic;
			}
			$sendArr=array('type'=>'赛事通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>$url,'type_id'=>$type_id,'datas'=>$datas);
			game_audit($model->club_id,$model->referee_gfid,$sendArr);
		}
     	show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败');   
    }
	
	 // 裁判帐号验证
    public function actionValidate($gf_account) {
		$project_id= $_POST['project_id'];		
		$user=userlist::model()->find('GF_ACCOUNT="'.$gf_account.'"');
		$person=QualificationsPerson::model()->find('gfaccount="'.$gf_account.'" AND project_id='.$project_id.' AND qualification_type_id=261 AND check_state=2 AND auth_state=931');
		if(!empty($user)) {
			if($user->passed==2) {
				if(!empty($person)) {
						ajax_status_gamereferee(1, $user->GF_ID, $user->ZSXM,$user->IDNAME,$user->PHONE, $user->real_sex,$user->real_sex_name,$person->gf_code);							
				} else {
					ajax_status(0, '帐号没有该赛事项目的裁判资质');
				}
			} else {
				ajax_status(0, '帐号未实名');
			}
		} else {
			ajax_status(0, '帐号不存在');
		}

	}

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
	}

	// public function actionData_id($game_id){
	// 	$data = GameListData::model()->findAll('game_id='.$game_id.' group by project_id');
	// 	$row = array();
	// 	if(!empty($data)){
	// 		foreach($data as $d => $val){
	// 			// array_push($row,[$d->id,$d->game_data_name]);
	// 			$row[$d]['id'] = $val->id;
	// 			$row[$d]['project_id'] = $val->project_id;
	// 			$row[$d]['project_name'] = $val->project_name;
	// 		}
	// 		echo CJSON::encode($row);
	// 	}
	// }
	
	public function actionData_id($game_id){
		$data = GameListData::model()->findAll('game_id='.$game_id.' ');
		$game_data = GameListData::model()->findAll('game_id='.$game_id.' '.' group by project_id');
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

	// 赛事历史记录裁判列表
	public function actionIndex_history($keywords='',$game_id='',$data_id=''){
		set_cookie('_currentUrl_',Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		$game_id = empty($game_id) ? 0 : $game_id;
		$criteria->condition = 'game_id='.$game_id;
		$criteria->condition = get_where($criteria->condition,!empty($data_id),'sign_game_data_id',$data_id,'');
		$criteria->condition = get_like($criteria->condition,'referee_gfaccount,real_name',$keywords,'');
		$data = array();
		$data['data_list'] = GameListData::model()->findAll('game_id='.$game_id.' ');
		parent::_list($model,$criteria,'index_history',$data);
	}

}
