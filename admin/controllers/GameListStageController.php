<?php

class GameListStageController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($game_id,$data_id='',$project_id='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->select = "t.*,GROUP_CONCAT(t.stage_name) as stage_name";
		$criteria->condition='game_id='.$game_id;
		$criteria->condition = get_where($criteria->condition,!empty($project_id),'project_id',$project_id,'');
		$criteria->condition = get_where($criteria->condition,!empty($data_id),'game_data_id',$data_id,'');
		$criteria->condition .= " group by game_data_id";
        $data = array();
        $data['game_id']=$game_id;
		$data['data_id'] = $data_id;
		$data['project_id'] = $project_id;
		$game=GameList::model()->find('id='.$game_id);
        $data['game_name']=$game->game_title;
		$project_list=GameListData::model()->findAll('game_id=' . $game_id .'  group by project_id');
		$data['project_list'] = $project_list;
        parent::_list($model, $criteria, 'index',$data,10);
    }

    public function actionCreate($game_id,$data_id='',$project_id='') {
        $modelName = $this->model;
        $model = new $modelName('create');
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
			$data['programs'] = array();
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
    
    public function actionDelete($id) {
        $modelName = $this->model;
        $count = 0;
        $ex = explode(',',$id);
        foreach($ex as $d){
            $model = $this->loadModel($d, $modelName);
            if(!empty($model)){
                $modelName::model()->deleteAll('game_data_id='.$model->game_data_id);
                $count++;
            }
        }
        if($count > 0){
            ajax_status(1, '删除成功', Yii::app()->request->urlReferrer);
        }else{
            ajax_status(0, '删除失败');
        }
    }

	//生成赛程
    public function actionCreate_arrange($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$game_id=$model->game_id;
		$game_data_id=$model->game_data_id;
		$project_id=$model->project_id;
		GameListArrange::model()->updateAll(array('fater_id'=>'-1'),'game_data_id='.$game_data_id);//做临时删除标识
        $stage=GameListStage::model()->findAll('game_data_id='.$game_data_id);
        $count=0;
        foreach ($stage as $v) {
			if($v['game_format']==986){
				$programs = new GameListArrange(); 
				$programs->isNewRecord = true;
				unset($programs->id);
				$programs->game_data_id = $game_data_id;
				$programs->game_format = $v['game_format'];
				$sv=$programs->save();
				$count++;
			}
        }
		GameListArrange::model()->deleteAll('fater_id="-1"');
        if ($count > 0) {
            ajax_status(1, '操作成功');
        } else {
            ajax_status(0, '操作失败');
        }
    }
}
