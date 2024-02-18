<?php

class GameListDataController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords='',$game_mode='',$project_id='',$game_id=0,$type=0) {
        $this-> show_index($keywords,$game_mode,$project_id,$game_id,$type,'index');
    }
    
    public function actionIndex1($keywords = '',$game_mode='',$project_id='',$game_id=0,$type=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr= ' if_del=510 ';
        $cr=get_where($cr,$game_id,'game_id',$game_id,'');
        $cr=get_where($cr,$game_mode,'game_mode',$game_mode,'');
        $cr=get_where($cr,$project_id,'project_id',$project_id,'');
        $criteria->condition=get_like($criteria->condition,'game_name',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['game_mode'] = BaseCode::model()->getCode(660);
        $data['game_id'] = GameList::model()->findAll('id='.$game_id);
        $data['project_id'] = ProjectList::model()->getProject();
        parent::_list($model, $criteria, 'index1', $data);
    }

    public function actionShindex($keywords = '',$game_mode='',$project_id='',$game_id=0,$type=0) {
        $this-> show_index($keywords,$game_mode,$project_id,$game_id,$type,'shindex');
    }

    public function show_index($keywords = '',$game_mode='',$project_id='',$game_id=0,$type=0,$vfile) {
       set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr= ' if_del=510 ';
        $cr=get_where($cr,$game_id,'game_id',$game_id,'');
        $cr=get_where($cr,$game_mode,'game_mode',$game_mode,'');
        $cr=get_where($cr,$project_id,'project_id',$project_id,'');
        $criteria->condition=get_like($cr,'game_data_code,game_data_name',$keywords,'');
        $criteria->order = 'game_data_code';
        $data = array();
        $data['game_mode'] = BaseCode::model()->getCode(660);
        $data['project_id'] = ProjectList::model()->getProject();
        parent::_list($model, $criteria, $vfile, $data);
    }

    public function actionCreate($game_id,$title,$type) {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['F_SAMEGAME_ID']=array();
            $data['F_exclusive_ID']=array();
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id,$game_id,$type,$title) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['insurance_id'] = array();
            if(!empty($model->insurance_id)){
                $data['insurance_id'] = MallProductData::model()->findAll('id='.$model->insurance_id);
            }
            $this->render('update', $data);
        }
        else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }
	
	public function actionAdd_game_data() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        $data['model'] = $model;
		$this->render('add_game_data', $data);
    }

    // 不可编辑项目详情
    public function actionUpdate_notedit($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_notedit', $data);
        }
    }

    public function actionShupdate($id,$game_id,$type,$title) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['insurance_id'] = array();
            if(!empty($model->insurance_id)){
                $data['insurance_id'] = MallProductData::model()->findAll('id='.$model->insurance_id);
            }
            $this->render('shupdate', $data);
        }
        else{
           show_status(1,'完成', $this->createUrl('gameListData/shindex&game_id='.$game_id),'');
        }
    }

    //failshow
    public function actionFailshow($id,$game_id,$type='',$title='') {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['insurance_id'] = array();
            $this->render('failshow', $data);
        }
        else{
           show_status(1,'完成', $this->createUrl('gameListData/Fiaillist&game_id='.$game_id),'');
        }
    }

    //逻辑删除
    public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $lode = explode(',', $id);
        $count = 0;
		foreach ($lode as $d) {
			$model->updateByPk($d,array('if_del'=>509));
			$count++;
		}
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }

    function saveData($model,$post){
        $modelName = $this->model;
        $model->attributes = $_POST[$modelName];
        $model->attributes = $post;
        $sv=$model->save();
        if($sv){
            $weight_min = $model->weight_min;
            $weight_max = $model->weight_max;
            if($weight_min!=''){
                $weight_min = ' / '.$model->weight_min;
            };
            if($weight_max!=''){
                $weight_max = ' - '.$model->weight_max;
            };
            $game_data=GameList::model()->find('id='.$model->game_id);
            $game_data->state=721;
            $model->signup_date = $game_data->Signup_date;
            $model->signup_date_end = $game_data->Signup_date_end;
            $game_data->save();
            if($model->insurance_set!=1002){
                $model->insurance_id='';
                $model->insurance_code='';
                $model->insurance_title='';
                $model->insurance='';
                $model->sum_insured='';
                $model->save();
            }
            if(!empty($model->game_item)){
                $item = ProjectListGame::model()->find('id='.$model->game_item);
                if(!empty($item) && $item->id==$model->game_item){
                    $model->game_item_name = $item->game_item;
                }
            }
            $gn=$model->game_data_name;
            if(empty($gn)){
                $gn=$model->game_item_name.' /'.$model->base_code->F_NAME.' /'.$model->base_code_sex->F_NAME.' /';
                $gn.=($model->game_age==222) ? $model->game_age_name : $model->base_code_age->F_NAME;
                $gn.=($model->weight==648) ? "" : $weight_min.$weight_max;
                $model->game_data_name=$gn;
            }
            if($model->game_dg_level==''){
                $model->game_dg_level = -1;
            }
            $model->save();
            $w1='sign_game_data_id='.$model->id;
            GameSignList::model()->updateAll(array('games_desc'=>$gn),$w1);
            GameTeamTable::model()->updateAll(array('sign_game_data_name'=>$gn),$w1);
            GameListArrange::model()->updateAll(array('game_data_name'=>$gn),'game_data_id='.$model->id);
            
            // 保存费用
            if(isset($_POST['money'])){
                $this->save_money($model,$post);
            }
        }
        $action = ($_POST['submitType']=='next') ? $this->createUrl('gameIntroduction/index&game_id='.$model->game_id.'&title='.$model->game_name) : get_cookie('_currentUrl_');
        // show_status($sv,'保存成功', $this->createUrl('gameListData/index&game_id='.$model->game_id.'&title='.$model->game_name),'保存失败');
        show_status($sv,'保存成功', $action,'保存失败');
    }

    public function actionInsura($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        // $model = $modelName::model();
        $site_code = $_POST['site_code'];
        $user_club_name = $_POST['user_club_name'];
        if(isset($site_code) && isset($user_club_name)) {
            $gf_site_demand = new MallProductData();
            $gf_site_demand->isNewRecord = true;
            unset($gf_site_demand->id);
            $gf_site_demand->site_code = $model->site_code;
            $gf_site_demand->club_id = get_session('club_id');
            $gf_site_demand->club_name = get_session('club_name');
            $gf_site_demand->club_contacts_phone = $model->contact_phone;
            $gf_site_demand->state = 371;
            // $gf_site_demand->if_del = $model->if_del;
            $gf_site_demand->save();
            ajax_status(1, '申请成功',Yii::app()->request->urlReferrer);
        } else {
            ajax_status(0, '申请失败');
        }
    }

    // 保存组织单位
    public function save_money($model,$post){
        $s_id = '';
        foreach($_POST['money'] as $o){
            $org = GameListDataMoney::model()->find('game_data_id='.$model->id.' and id='.$o['id']);
            if($o['id']=='null'){
                $org = new GameListDataMoney();
                $org->isNewRecord = true;
                unset($org->id);
            }
            $org->game_data_id = $model->id;
            $org->money_name = $o['money_name'];
            $org->money = $o['money'];
            $org->save();
            $s_id .= $org->id.',';
        }
        GameListDataMoney::model()->deleteAll('game_data_id='.$model->id.' and id not in('.rtrim($s_id,',').')');
    }
}

