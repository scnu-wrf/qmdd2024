<?php

class GfRecommendController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '',$recommend_type = 0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
		$club_id=get_session('club_id');
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d H:i:s');
        $criteria = new CDbCriteria;
		$criteria->condition='t.recommend_type='.$recommend_type.' and t.club_id='.$club_id;
		if($recommend_type==0){
			$criteria->join = "join video_live on t.video_live_id=video_live.id";
			$criteria->condition.=' and if_del=648 and live_state=2 and state=1364 and live_end>"'.$now.'"';
		}else if($recommend_type==1){
			$criteria->join = "join club_news on t.video_live_id=club_news.id";
			$criteria->condition.=' and club_news.news_date_end>"' . $now . '"';
		}else if($recommend_type==2){
			$criteria->join = "join game_list on t.video_live_id=game_list.id";
			$criteria->condition.=' and game_list.dispay_end_time>"' . $now . '"';
		}
        $criteria->condition=get_like($criteria->condition,'t.video_live_code,t.video_live_title',$keywords,'');
        $criteria->order = 't.id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }


    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['club_list'] = array();
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }


    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
			if(empty($model->recommend_club_id)){
				$data['club_list'] = array();
			}else{
				$data['club_list'] = ClubList::model()->findAll('id in (' . $model->recommend_club_id . ')');
			}
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
    }
  
 function saveData($model,$post) {
       $model->attributes =$post;
       $sv=$model->save();
       show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');  
 }
 
  
 
     //删除
  public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $count=0;
        $count=$model->deleteAll('id in (' . $id . ')');
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }
  
	//选择直播
	public function actionVideoLive($keywords = '', $club_id = '',$video_live_id='',$video_live_id_new='') {
		$data = array();
        $model = VideoLive::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d H:i:s');
		$criteria->condition= 't.if_del=648 and t.live_state=2 and t.state=1364 and t.live_end>"'.$now.'"';
        $criteria->condition=get_where($criteria->condition,!empty($club_id),' t.club_id',$club_id,'');
        $criteria->condition=get_like($criteria->condition,'t.title',$keywords,'');
		if($video_live_id==$video_live_id_new){
			$criteria->condition.=' and r.id is null';
		}else{
			if(empty($video_live_id)&&!empty($video_live_id_new)){
				$criteria->condition.=' and r.id is null and t.id<>'.$video_live_id_new;
			}else if(!empty($video_live_id)&&!empty($video_live_id_new)){
				$criteria->condition.=' and (r.id is null or t.id<>'.$video_live_id_new.') and t.id<>'.$video_live_id_new;
			}
		}
		$criteria->order = 't.id DESC';
		$criteria->join = 'left join gf_recommend r on r.recommend_type=0 and r.video_live_id=t.id';
        parent::_list($model, $criteria, 'videolive', $data);
    }
	
	//选择资讯
    public function actionClubNews($keywords = '', $club_id = '',$video_live_id='',$video_live_id_new='') {
		$data = array();
        $model = ClubNews::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d H:i:s');
        $criteria->condition= 't.if_del=506 and t.state=2 and t.news_date_end>"'.$now.'"';
        $criteria->condition=get_where($criteria->condition,!empty($club_id),' t.club_id',$club_id,'');
        $criteria->condition=get_like($criteria->condition,'t.news_title',$keywords,'');
		if($video_live_id==$video_live_id_new){
			$criteria->condition.=' and r.id is null';
		}else{
			if(empty($video_live_id)&&!empty($video_live_id_new)){
				$criteria->condition.=' and r.id is null and t.id<>'.$video_live_id_new;
			}else if(!empty($video_live_id)&&!empty($video_live_id_new)){
				$criteria->condition.=' and (r.id is null or t.id<>'.$video_live_id_new.') and t.id<>'.$video_live_id_new;
			}
		}
        $criteria->order = 't.id DESC';
		$criteria->join = 'left join gf_recommend r on r.recommend_type=1 and r.video_live_id=t.id';
        parent::_list($model, $criteria, 'clubnews', $data);
    }
	
	//选择赛事
    public function actionGame($keywords = '', $club_id = '',$video_live_id='',$video_live_id_new='') {
		$data = array();
        $model = GameList::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d H:i:s');
        $criteria->condition= 't.t.state=2 and t.dispay_end_time>"'.$now.'"';
        $criteria->condition=get_where($criteria->condition,!empty($club_id),' t.game_club_id',$club_id,'');
        $criteria->condition=get_like($criteria->condition,'t.title',$keywords,'');
		if($video_live_id==$video_live_id_new){
			$criteria->condition.=' and r.id is null';
		}else{
			if(empty($video_live_id)&&!empty($video_live_id_new)){
				$criteria->condition.=' and r.id is null and t.id<>'.$video_live_id_new;
			}else if(!empty($video_live_id)&&!empty($video_live_id_new)){
				$criteria->condition.=' and (r.id is null or t.id<>'.$video_live_id_new.') and t.id<>'.$video_live_id_new;
			}
		}
        $criteria->order = 't.id DESC';
		$criteria->join = 'left join gf_recommend r on r.recommend_type=2 and r.video_live_id=t.id';
        parent::_list($model, $criteria, 'game', $data);
    }
   

}
