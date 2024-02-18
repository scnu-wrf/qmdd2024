<?php

class GameListArrangeScoreController extends BaseController {

    protected $model = '';
	
	public function init() {
        $this->model = substr(__CLASS__, 0, -10);
		//$this->model = 'GameListArrange';
        parent::init();
    }

    public function actionIndex($keywords = '', $type='', $pid='',$game_id=0,$data_type=0,$data_id=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'fater_id is NULL';
        $criteria->condition=get_where($criteria->condition,!empty($game_id),'game_id',$game_id,'');
        $criteria->condition=get_where($criteria->condition,!empty($data_id),'game_data_id',$data_id,'');
        if($data_type>0 && ($data_type==666 || $data_type==982)){
			$criteria->condition.=' AND game_data_id=0';
		}
		$criteria->condition=get_like($criteria->condition,'arrange_code,game_name',$keywords,'');//get_where
        $criteria->order = 'id DESC';
        $data = array();
        $data['data_id'] = $data_id;
		$all_num=0;
		$gamedata = GameListData::model()->findAll('game_id='.$game_id);
		foreach ($gamedata as $n) {
			$all_num=$all_num+$n->number_of_join_now;
		}
		$data['all_num'] = $all_num;
		$data['game_data1'] = GameListData::model()->findAll('game_id='.$game_id);
        $data['game_list1'] = GameList::model()->findAll('id='.$game_id);
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model; 
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
            $data['model'] = $model;
            // $data['arrange']=GameListArrange::model()->findAll('game_data_id='.$model->game_data_id);
            $data['game_order']=GameListOrder::model()->findAll('arrange_id='.$id.' AND game_data_id order by game_data_id DESC limit 1');
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
    function saveData($model,$post) {
        $model->attributes =$post;
        if ($_POST['submitType'] == 'shenhe') {
            $model->state = 371;
        } else if ($_POST['submitType'] == 'baocun') {
            $model->state = 721;
        } else if ($_POST['submitType'] == 'tongguo') {
            $model->state = 2;
            $model->game_over = 908;
        } else if ($_POST['submitType'] == 'butongguo') {
            $model->state = 373;
        } else {
            $model->state = 721;
        }
        $st=$model->save(); 
        $this->save_sign($model->id, $post['game_play_id'],$model->state);
        show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败'); 
    }
    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }
	
    public  function save_sign($arrange_id,$game_play_id,$state){
        $model2 = new GameListOrder();
        if(!empty($_POST['team_data'])){
            foreach($_POST['team_data'] as $v){
                if ($v['sign_no'] == '') {
                    continue;
                }
                if($v['id']=='null'){
                    $model2->isNewRecord = true;
                    unset($model2->id);
                    $model2->state = $state;
                    $model2->colour = $v['game_score'];
                    $model2->sign_no = $v['game_rank'];
                    $model2->game_integral_score = $v['game_integral_score'];
                    $model2->sign_no = $v['is_promotion'];
                    $model2->save();
                }
                else{
                    if($game_play_id == 665){
                        $model2->updateByPk($v['id'],array(
                            'game_rank' => $v['game_rank'],
                            'game_integral_score' => $v['game_integral_score'],
                            'game_score' => $v['game_score'],
                            'is_promotion' => $v['is_promotion']
                        ));
                    }
                    else{
                        $game_order=GameListOrder::model()->findAll('team_ida='.$v['tean_name_ida']);
                        foreach($game_order as $v2){
                            $v2->game_score = $v['game_score'];
                            $v2->game_rank = $v['game_rank'];
                            $v2->game_integral_score = $v['game_integral_score'];
                            $v2->is_promotion = $v['is_promotion'];
                            $v2->state = $state;
                            $v2->save();
                        }
                        $model2->updateByPk($v['id'],array(
                            'game_rank' => $v['game_rank'],
                            'game_integral_score' => $v['game_integral_score'],
                            'game_score' => $v['game_score'],
                            'is_promotion' => $v['is_promotion']
                        ));
                    }
                }
            }
        }
    }
}