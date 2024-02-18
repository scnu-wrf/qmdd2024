<?php

class GameListEditController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($keywords = '',$project_id = '',$game_level = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->select = "t.*,g.game_code,g.level_name";
		$criteria->condition='t.admin_club_id='.get_session('club_id');
		$criteria->condition = get_where($criteria->condition,!empty($game_level),'g.game_level',$game_level,'');
        $criteria->condition = get_like($criteria->condition,'g.game_title,g.game_code,d.project_name',$keywords,'');
		$criteria->condition = get_where($criteria->condition,!empty($project_id),'d.project_id',$project_id,'');
		$criteria->join = " left join game_list_data d on d.game_id=t.game_id left join game_list g on g.id=t.game_id";
		//$criteria->group = "t.game_id,t.id";
        $data = array();
        $data['project_list'] = ClubProject::model()->findAll('state=2 and auth_state=461 and club_id='.get_session('club_id'));
        $data['game_level'] = BaseCode::model()->getCode(163,' order by F_CODE');
        parent::_list($model, $criteria, 'index',$data,10);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if(!Yii::app()->request->isPostRequest){
            $data['model'] = $model; 
            $this->render('update', $data);
        }else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$game_id=$model->game_id;
		$data_id=$model->game_data_id;
		$project_id=$model->project_id;
        $data = array();
		$game=GameList::model()->find('id='.$game_id);
        $data['game_id']=$game_id;
		$data['data_id'] = $data_id;
		$data['project_id'] = $project_id;
        $data['game_name']=$game->game_title;
		$project_list=GameListData::model()->findAll('game_id=' . $game_id .'  group by project_id');
		$data['project_list'] = $project_list;
        if(!Yii::app()->request->isPostRequest){
            $data['model'] = $model;
			$data['programs'] = GameListStage::model()->findAll('game_data_id=' . $data_id);
            if (!empty($data['programs'])) {
                $model->programs_list = 1;
            }
            $this->render('update', $data);
        }else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }
    
    function saveData($model,$post) {
        $model->attributes = $post;
		$game_id=$model->game_id;
		$project_id=$model->project_id;
		$game_data_id=$model->game_data_id;
        $st=$model->save();
		GameListStage::model()->updateAll(array('pick_amount'=>'-1'),'game_data_id='.$game_data_id);//做临时删除标识
		if (isset($_POST['programs_list'])) {
			foreach ($_POST['programs_list'] as $v) {
				if ($v['id']=='null') {
					$programs = new GameListStage(); 
					$programs->isNewRecord = true;
					unset($programs->id);
				} else{
					$programs=GameListStage::model()->find('id='.$v['id']);
				}
				if (empty($programs->stage_code)) {// 生成编号
					$service_code = '';
					$live= GameListData::model()->find('id='.$game_data_id);
					$service_code=$live->game_data_code;
					$code_num ='01';
					$live_program=GameListStage::model()->find('game_data_id=' . $game_data_id . ' and stage_code is not null order by id DESC');
					if (!empty($live_program)) {
						$num=intval(substr($live_program->stage_code, -2));
						$code_num = substr('00' . strval($num + 1), -2);
					}
					$service_code.='-'.$code_num;
					$programs->stage_code = $service_code;
				}
				$programs->game_id = $game_id;
				$programs->game_data_id = $game_data_id;
				$programs->project_id = $project_id;
				$programs->stage_name = $v['stage_name'];
				$programs->game_format = $v['game_format'];
				$programs->pick_amount = $v['pick_amount'];
				$programs->group_amount = $v['group_amount'];
				$programs->pick_per_group = $v['pick_per_group'];
				$programs->programs_list = 1;
				$sv=$programs->save();
			}
		}
		GameListStage::model()->deleteAll('pick_amount="-1"');
        show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }
	//赛事修改-添加修改选择赛事
    public function actionGame_select($keywords = '') {
        $data = array();
        $model = GameList::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state=2';
        $criteria->condition .=' and '.get_where_club_project('game_club_id');
		$criteria->condition=get_like($criteria->condition,'game_title,game_code',$keywords,'');
        parent::_list($model, $criteria, 'game_select', $data,10);
    }
}
