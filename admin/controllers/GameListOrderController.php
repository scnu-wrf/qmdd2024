<?php

class GameListOrderController extends BaseController {
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
  public function actionIndex($data_id=0,$sign_id=0,$game_id=0,$team_id=0,$keywords='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = ($game_id==0) ? '1' : 'game_id='.$game_id;
		$criteria->condition=get_where($criteria->condition,!empty($data_id),'game_data_id',$data_id,'');
		$criteria->condition=get_where($criteria->condition,!empty($sign_id),'sign_ida',$sign_id,'');
		if($team_id!=0) {
			$criteria->condition.=' AND team_ida='.$team_id.' AND sign_ida is NULL';
		}
		$criteria->condition=get_where($criteria->condition,!empty($team_id),'team_ida',$team_id,'');
		$criteria->condition=get_like($criteria->condition,'name,game_name',$keywords,'');
        $criteria->order = 'id DESC';
		$data['data_id'] = $data_id;
		$data['game_data'] = GameListData::model()->findAll('game_id='.$game_id.' ');
        parent::_list($model, $criteria, 'index', $data);
    }

   public function actionCreate() {    
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();        
       parent::_create($model, 'update', $data, get_cookie('_currentUrl_'));
    }
    

  public function actionUpdate($id) {
      $modelName = $this->model;
      $model = $this->loadModel($id, $modelName);

      $data = array();        
     parent::_update($model, 'update', $data, get_cookie('_currentUrl_'));
    }
  public function actionDelete($id) {
        parent::_clear($id);
    }
 
  }
 