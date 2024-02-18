<?php

class RewardController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    // 审核列表
    public function actionIndex($keywords='',$time_start='',$time_end='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = new VideoLive();
        $criteria = new CDbCriteria;
        $time_start = empty($time_start) ? date('Y-m-d') : $time_start;
        $time_end = empty($time_end) ? date('Y-m-d') : $time_end;
        $criteria->condition = get_where_club_project('club_id').' and if_del=648 and is_reward_state in(2,373,1538)';
        $criteria->condition = get_where($criteria->condition,!empty($time_start),'left(is_reward_time,10)>=',$time_start,'"');
        $criteria->condition = get_where($criteria->condition,!empty($time_end),'left(is_reward_time,10)<=',$time_end,'"');
        $criteria->condition = get_like($criteria->condition,'code,title',$keywords,'');
        $criteria->order = 'is_reward_state,is_reward_time DESC';
        $data = array();
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        $data['count1'] = $model->count(get_where_club_project('club_id').' and if_del=648 and is_reward_state=371');
        parent::_list($model, $criteria, 'index', $data, 10);
    }

    // 申请审核列表
    public function actionIndex_exam($keywords=''/*,$time_start='',$time_end=''*/) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = new VideoLive();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('club_id').' and if_del=648 and is_reward_state=371';
        // $criteria->condition = get_where($criteria->condition,!empty($time_start),'left(is_reward_time,10)>=',$time_start,'"');
        // $criteria->condition = get_where($criteria->condition,!empty($time_end),'left(is_reward_time,10)<=',$time_end,'"');
        $criteria->condition = get_like($criteria->condition,'code,title',$keywords,'');
        $criteria->order = 'id';
        $data = array();
        parent::_list($model, $criteria, 'index_exam', $data, 10);
    }

    // 直播打赏上架列表
    public function actionUpList($keywords='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = new VideoLive();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('club_id').' and live_state=2 and state=1364 and if_del=648 and is_uplist=1 and live_end>now() and is_reward_state=2';
        $criteria->condition = get_like($criteria->condition,'code,title',$keywords,'');
        $criteria->order = 'id';
        $data = array();
        parent::_list($model, $criteria, 'upList', $data, 10);
    }

    // 直播打赏礼物查询
    public function actionGift_query($club_list='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = new VideoLive();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('club_id').' and is_reward=1 and live_state=2 and if_del=648 and live_end>"'.date('Y-m-d H:i:s').'" and is_reward_state=2';  // and is_online=1
        $criteria->condition = get_where($criteria->condition,!empty($club_list),'club_id',$club_list,'');
        $criteria->order = 'id';
        $data = array();
        $data['club_list'] = ClubList::model()->findAll(get_where_club_project('id').' and club_name<>"" and state=2 and unit_state=648');  // and edit_state=2 and (valid_until>"'.date('Y-m-d H:i:s').'" OR valid_until="长期")
        parent::_list($model, $criteria, 'gift_query', $data, 10);
    }

    // 打赏下架列表
    public function actionDownList() {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = new VideoLive();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('club_id').' and is_reward=0 and if_del=648';
        $criteria->order = 'id';
        $data = array();
        parent::_list($model, $criteria, 'downList', $data, 10);
    }

    // 直播打赏申请
    public function actionIndex_apply() {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = new VideoLive;
        $criteria = new CDbCriteria;
        $criteria->condition = get_where_club_project('club_id').' and if_del=648 and is_reward_state not in(2,373)';
        $criteria->condition .= 'and exists(select count(*) from video_live_reward d where d.video_live_id=t.id and if_down=648 and if_del=648 having count(*)>0)';
        $criteria->order = 'is_reward_state DESC';
        $data = array();
        parent::_list($model,$criteria,'index_apply',$data, 10);
    }

    public function actionCreate(){
        $modelName = 'VideoLive';
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $cond = get_where_club_project('club_id').' and if_del=648 and is_reward_state<>2 and state=1364';  //  and live_start>"'.date('Y-m-d H:i:s').'" and live_state=721
            $cond .= ' and (exists(select count(*) from video_live_reward d where d.video_live_id=t.id and if_down=648 and if_del=648 having count(*)<1)';
            $cond .= ' or t.is_reward_state=373)';
            $data['video_live'] = VideoLive::model()->findAll($cond);
            $this->render('update_apply', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate_apply($id){
        $modelName = 'VideoLive';
        $model = $this->loadModel($id,$modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $cond = get_where_club_project('club_id').' and if_del=648 and live_start>"'.date('Y-m-d H:i:s').'" and live_state=721 and state=1364';
            $cond .= ' and exists(select count(*) from video_live_reward d where d.video_live_id=t.id and if_down=648 and if_del=648 having count(*)<1)';
            $data['video_live'] = VideoLive::model()->findAll($cond);
            $data['Reward'] = Reward::model()->findAll('video_live_id='.$id.' and if_del=648 and if_down=648 and reward_state<>373');
            $this->render('update_apply', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate_exam($id){
        $modelName = 'VideoLive';
        $model = $this->loadModel($id,$modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $cond = get_where_club_project('club_id').' and if_del=648 and live_start>"'.date('Y-m-d H:i:s').'" and live_state=721';
            $cond .= ' and exists(select count(*) from video_live_reward d where d.video_live_id=t.id and if_down=648 and if_del=648 having count(*)<1)';
            $data['video_live'] = VideoLive::model()->findAll($cond);
            $data['Reward'] = Reward::model()->findAll('video_live_id='.$id.' and if_del=648 and if_down=648');
            $this->render('update_exam', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionDelete($id) {
        $len = explode(',',$id);
        $count = 0;
        foreach($len as $d){
            Reward::model()->updateAll(array('if_del'=>649),'video_live_id='.$d);
            // parent::_clear($d);
            $count++;
        }
        if($count>0){
            ajax_status(1,'删除成功',Yii::app()->request->urlReferrer);
        }
        else{
            ajax_status(0,'删除失败');
        }
    }

    function saveData($model,$post) {
        $model->attributes = $post;
        $is_state = get_check_code($_POST['submitType']);
        if($_POST['submitType']=='quxiao'){
            $is_state = 721;
            $st = VideoLive::model()->updateByPk($model->id,array('is_reward_state'=>$is_state));
        }
        else{
            if($is_state==2 || $is_state==373){
                $st = $this->actionUpdateState($post['video_live_id'],$is_state);
            }
            else{
                $st = $this->save_reward($post['video_live_id'],$is_state);
            }
        }
        show_status($st,'操作成功', get_cookie('_currentUrl_'),'操作失败');
    }

    // 保存申请信息
    function save_reward($video_live_id,$is_state){
        $num=0;
        $date = date('Y-m-d H:i:s');
        VideoLive::model()->updateByPk($video_live_id,array('is_reward_oper_time'=>$date,'is_reward_add_time'=>$date));
        Reward::model()->updateAll(array('reward_price'=>-1),'video_live_id='.$video_live_id);
        $gift_count = GiftType::model()->count('is_use=649');
        $data = [];
        for($i=1;$i<=$gift_count;$i++){
            $data1 = [];
            if(isset($_POST['reward_'.$i])){
                foreach($_POST['reward_'.$i] as $v){
                    $reward = Reward::model()->find('id='.$v['id']);
                    if($v['reward_price']=='') continue;
                    if($v['id']=='null'){
                        $reward = new Reward;
                        $reward->isNewRecord = true;
                        unset($reward->id);
                    }
                    $data1['id'] = $v['id']=='null' ? '' : $v['id'];
                    $data1['video_live_id'] = $video_live_id;
                    $data1['interact_type'] = $v['interact_type'];
                    $data1['gift_type'] = $v['gift_type'];
                    $data1['reward_id'] = $v['reward_id'];
                    $data1['reward_code'] = $v['reward_code'];
                    $data1['reward_name'] = $v['reward_name'];
                    $data1['reward_price'] = $v['reward_price'];
                    $data1['if_use'] = $v['if_use'];
                    if(!empty($v['sort_num'])){
                        $data1['sort_num'] = $v['sort_num'];
                    }
                    $data1['reward_state'] = $is_state;
                    $data1['reward_time'] = $date;
                    $data1['reward_pic'] = str_replace(BasePath::model()->get_www_path(),'',$v['reward_pic']);
                    $data1['reward_gif'] = str_replace(BasePath::model()->get_www_path(),'',$v['reward_gif']);
                    $data[] = $data1;
                }
            }
            $num=1;
        }
        $column = implode(',',array_keys($data[1]));
        // $column = 'id,video_live_id,interact_type';
        $num = batch_insert_on_update('video_live_reward',$column,$data);
        VideoLive::model()->updateByPk($video_live_id,array('is_reward_state'=>$is_state));
        Reward::model()->deleteAll('video_live_id='.$video_live_id.' and reward_price=-1');
        return $num;
    }

    // 申请审核
    public function actionUpdateState($id,$state) {
        $lid = explode(',',$id);
        $len = 0;
        foreach($lid as $d){
            $data = array(
                'is_uplist'=>1,
                'is_reward'=>1,
                'is_reward_state'=>$state,
                'is_reward_time'=>date('Y-m-d H:i:s'),
                'is_reward_admin_id'=>get_session('gfaccount'),
                'is_reward_admin_name'=>get_session('admin_name'),
            );
            VideoLive::model()->updateAll($data,'id='.$d);
            Reward::model()->updateAll(array('reward_state'=>$state),'video_live_id='.$d);
            $len = 1;
        }
        // ajax_status(1,'审核操作成功',Yii::app()->request->urlReferrer);
        // show_status($len,'审核操作成功',Yii::app()->request->urlReferrer,'操作失败');
        return $len;
    }

    public function actionStatus($id){
        $st = VideoLive::model()->updateByPk($id,array('is_reward_state'=>721));
        show_status($st,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }

    // 直播打赏下架
    public function actionDown($id) {
        VideoLive::model()->updateAll(array('is_reward'=>0,'is_reward_state'=>721),'id='.$id);
        Reward::model()->updateAll(array('if_down'=>649),'video_live_id='.$id);
        ajax_status(1,'操作成功',Yii::app()->request->urlReferrer);
    }

    // 获打赏人员
    public function actionDetails($id=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = new VideoLiveMessage;
        $criteria = new CDbCriteria;
        $criteria->condition = 'live_reward_id<>0 and live_reward_gfid<>0 and exchange_id=0 and live_id='.$id;
        $criteria->group = 'live_reward_gfid';
        $criteria->order = 'id DESC';
        $data = array();
        $data['video_id'] = VideoLive::model()->find('id='.$id);
        parent::_list($model, $criteria, 'details', $data, 30);
    }

    // 人员获打赏明细
    public function actionDetails_child($id='',$account=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = new VideoLiveMessage;
        $criteria = new CDbCriteria;
        $str = '';
        if(!empty($account)) $str = ' and s_gfaccount="'.$account.'"';
        $criteria->condition = 'live_reward_id<>0 and exchange_id=0 and live_id='.$id.$str;
        $criteria->order = 'pay_time DESC';
        $data = array();
        $data['video_id'] = VideoLive::model()->find('id='.$id);
        parent::_list($model, $criteria, 'details_child', $data, 30);
    }

    // 打赏明细查询
    public function actionIndex_details($keywords='',$time_start='',$time_end='',$video_live=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = new VideoLiveMessage;
        $criteria = new CDbCriteria;
        $time_start = empty($time_start) ? date('Y-m-d') : $time_start;
        $time_end = empty($time_end) ? date('Y-m-d') : $time_end;
        $criteria->with = array('video_live_id');
        $criteria->condition = 't.is_pay=464 and t.exchange_id=0';
        $criteria->condition = get_where($criteria->condition,!empty($video_live),'video_live_id.id',$video_live,'');
        $criteria->condition = get_like($criteria->condition,'video_live_id.code,video_live_id.club_name',$keywords,'');
        // $criteria->condition .= ' and left(video_live_id.live_start,10) like "%' . $time_start . '%" and left(video_live_id.live_end,10) like "%' . $time_end . '%"';
        if(!empty($time_start) || !empty($time_end)){
            // $criteria->condition .= ' and exists(select * from video_live v where v.id=t.live_id and live_start>="'.$time_start.'" and live_end<="'.$time_end.'")';
            $criteria->condition .= ' and left(t.pay_time,10)>="'.$time_start.'" and left(t.pay_time,10)<="'.$time_end.'"';
        }
        $criteria->order = 't.id DESC';
        $data = array();
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        $data['video_live'] = VideoLive::model()->findAll(get_where_club_project('club_id').' and live_end>"'.date('Y-m-d H:i:s').'" and if_del=648');
        parent::_list($model, $criteria, 'index_details', $data);
    }

    // 打赏统计查询
    public function actionStatistics_details($keywords='',$time_start='',$time_end=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = new VideoLiveMessage;
        $criteria = new CDbCriteria;
        $time_start = empty($time_start) ? date('Y-m-d') : $time_start;
        $time_end = empty($time_end) ? date('Y-m-d') : $time_end;
        // $criteria->with = array('video_live_id');
        $criteria->condition = "t.is_pay=464 and t.exchange_id<1";
        // $criteria->condition .= " and exists(select * from video_live v where".get_where_club_project('v.club_id')." and v.id=t.live_id and v.live_start>='".$time_start."' and v.live_end<='".$time_end."')";
        $criteria->condition .= ' and left(t.pay_time,10)>="'.$time_start.'" and left(t.pay_time,10)<="'.$time_end.'"';
        $criteria->condition .= " and exists(select * from video_live vl where".get_where_club_project('vl.club_id')." and vl.id=t.live_id and (vl.code like '%".$keywords."%' OR vl.club_name like '%".$keywords."%'))";
        $criteria->group = 't.live_id';
        $criteria->order = 't.id DESC';
        $data = array();
        $data['count'] = Yii::app()->db->createCommand('SELECT count(*) FROM video_live_realtime_interaction_message t where '.$criteria->condition)->queryScalar();
        $data['price'] = Yii::app()->db->createCommand('SELECT sum(live_reward_price) FROM video_live_realtime_interaction_message t where '.$criteria->condition.' and t.m_type=32 and t.live_reward_id>0')->queryScalar();
        $data['redevn'] = Yii::app()->db->createCommand('SELECT sum(buy_price) FROM video_live_realtime_interaction_message t where '.$criteria->condition.' and t.m_type=40')->queryScalar();

        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        parent::_list($model, $criteria, 'statistics_details', $data);
    }
}
