<?php

class VideoLiveProgramsController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

//回放列表
    public function actionIndex($keywords = '') {
        $now=date('Y-m-d H:i:s');
        $this->ShowView($keywords,'video_live.club_id='.get_session('club_id'),' and video_live.live_end>"'.$now.'"',1,'index');
    }
//各单位回放列表
    public function actionIndex_club($keywords = '') {
        $now=date('Y-m-d H:i:s');
        $this->ShowView($keywords,get_where_club_project('video_live.club_id',''),' and video_live.live_end>"'.$now.'"',11,'index_club');
    }
//历史回放列表
    public function actionIndex_log($keywords = '') {
        $now=date('Y-m-d H:i:s');
        $this->ShowView($keywords,'video_live.club_id='.get_session('club_id'),' and video_live.live_end<"'.$now.'"',2,'index');
    }
//各单位历史回放列表
    public function actionIndex_clublog($keywords = '') {
        $now=date('Y-m-d H:i:s');
        $this->ShowView($keywords,get_where_club_project('video_live.club_id',''),' and video_live.live_end<"'.$now.'"',22,'index_club');
    }

    public function ShowView($keywords = '',$club,$time,$type,$viewfile) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d H:i:s');
        $criteria->join= "JOIN video_live on t.live_id=video_live.id";
        $criteria->join.= " JOIN boutique_video on t.id=boutique_video.live_program_id";
        $criteria->join.= " JOIN gf_material on boutique_video.video_source_id=gf_material.id";
        $cr=$club;
        $cr.= ' and video_live.if_del=648 and video_live.live_state=2 and video_live.state=1364';
        $cr.=' and t.program_end_time<"' . $now . '"';
        $cr=get_like($cr,'video_live.title,t.program_code,t.title',$keywords,'');
        $criteria->condition=$cr;
        $criteria->group='t.id';
        $criteria->order = 'program_end_time DESC';
        $data = array();
        $data['type'] =$type;
        parent::_list($model, $criteria, $viewfile, $data);
    }
//节目单发送群发通知列表
    public function actionIndex_order($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d H:i:s');
        $criteria = new CDbCriteria;
        $criteria->join = "JOIN video_live on t.live_id=video_live.id";
        $cr='video_live.club_id='.get_session('club_id');
        $cr.=' and program_end_time>"' . $now . '"';
        $cr=get_like($cr,'t.program_code,t.title,video_live.title',$keywords,'');
        $criteria->condition=$cr;
        $criteria->group='t.id';
        $criteria->order = 'program_time ASC';
        $data = array();
        $data['remind_type'] = BaseCode::model()->getCode(1430);
        parent::_list($model, $criteria, 'index_order', $data);
    }

 // 根据节目单发送群发通知
    public function actionSending($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $arr = array();
        $videolive=VideoLive::model()->find('id='.$model->live_id);
        $program_id=$model->id;
        $msg = $_POST['msg'];
        $type = $_POST['type'];
        $arr[0]['id']=$videolive->id;
        $arr[0]['live_program_id']=$program_id;
        $admin_id=get_session('admin_id');
        $basepath=BasePath::model()->getPath(141);
        $pic=$basepath->F_WWWPATH;  
        if (!empty($videolive) && !empty($model)) {
            $pic=$pic.$videolive->logo;
            $title=$videolive->title.'直播-'.$model->title;
            $sendArr=array('type'=>'直播提醒通知','pic'=>$pic,'title'=>$title,'content'=>$msg,'type_id'=>10,'datas'=>$arr,'notify_type'=>$type);
            new_message_send(315,$admin_id,$program_id,json_encode($sendArr),20);
            ajax_status(1, '通知发送成功', get_cookie('_currentUrl_'));
        } else {  
            ajax_status(0, '没有获取到直播信息，通知发送失败');          
        }

    }

    public function actionOrderLog($detail_id) {
        $model = PersonalCollection::model();
        $criteria = new CDbCriteria;
        $criteria->condition= 'news_type=863 and news_id='.$detail_id;
        $criteria->order = 'id ASC';
        $data = array();
        //$data['detail']=MallPriceSetDetails::model()->find('id='.$detail_id);
        parent::_list($model, $criteria, 'orderlog', $data,20);
    }
	
//节目单列表
    public function actionIndex_program($keywords = '',$live_id=null,$title='',$program_time_start='',$program_time_end='') {
		set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		if(empty($program_time_start)){
			$program_time_start=date("Y-m-d");
		}
		if(empty($program_time_end)){
			$program_time_end=date("Y-m-d");
		}
		$criteria->condition='video_live.id is not null and program_time>="'.$program_time_start.' 00:00:00" and program_time<="'.$program_time_end.' 23:59:59"';
		$criteria->condition=get_like($criteria->condition,'title',$keywords,'');
		$criteria->condition=get_where($criteria->condition,!empty($live_id),'live_id',$live_id,'');
		$criteria->join="left join video_live on video_live.id=t.live_id and video_live.club_id=".get_session('club_id');
		$data = array();
        $data['time_start'] = $program_time_start;
        $data['time_end'] = $program_time_end;
		$data["live_list"]=VideoLive::model()->findAll('live_state=2 and state=1364 and is_uplist=1 and live_end>now() and club_id=' . get_session('club_id')." order by id desc");
		parent::_list($model, $criteria, 'index_program', $data);
    }
	
	public function actionUpdate_program($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('update_program', $data);
        } else{
			$programs=VideoLivePrograms::model()->find('id='.$id);
			$programs->title = $_POST[$modelName]['title'];
            $programs->program_time = $_POST[$modelName]['program_time'];
            $programs->program_end_time = $_POST[$modelName]['program_end_time'];
			$sv=$programs->update($programs);
			$live=VideoLive::model()->find('id='.$programs->live_id);
			$res=$this->control_record(md5($live->code));//关闭录制
			show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败'); 
        }
    }
	//关闭录制
	function control_record($name){
		$purl=BasePath::model()->java_web."Live/control_record";
		$post_data=array('name'=>$name,'type'=>2);
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $purl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取数据返回  true
        curl_setopt($ch, CURLOPT_POST, 1); //POST数据// 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); //post变量true
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// https请求 不验证证书和hosts
        $dat = curl_exec($ch);
        curl_close($ch);
        return $dat;
	}
	
    public function actionCreate() {
		$modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
		$data["live_list"]=VideoLive::model()->findAll('live_state=2 and state=1364 and is_uplist=1 and live_end>now() and club_id=' . get_session('club_id')." order by id desc");
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('create_program', $data);
        } else {
			$model->save();
            $this->save_programs($_POST[$modelName]);
			
        }
    }
  
	function saveData($model,$post) {
		$model->attributes =$post;
		$sv=$model->save();
		show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');  
	}
	
	//保存节目单
    public function save_programs($post){
		$id=$post["live_id"];
        if (isset($_POST['programs_list'])) {
			foreach ($_POST['programs_list'] as $v) {
				if ($v['title'] == '' || $v['program_time']=='' || $v['program_end_time']=='') {
					continue;
				}
				$programs = new VideoLivePrograms; 
				$programs->isNewRecord = true;
				unset($programs->id);
				$service_code = '';
				$live= VideoLive::model()->find('id='.$id);
				$service_code=$live->code;
				$code_num ='01';
				$live_program=VideoLivePrograms::model()->find('live_id=' . $id . ' and program_code is not null order by program_code DESC');
				if (!empty($live_program)) {
					$num=intval(substr($live_program->program_code, -2));
					$code_num = substr('00' . strval($num + 1), -2);
				}
				$service_code.=$code_num;
				$programs->program_code = $service_code;
					
				$programs->live_id = $id;
				$programs->title = $v['title'];
				$programs->program_time = $v['program_time'];
				$programs->program_end_time = $v['program_end_time'];
				$sv=$programs->insert($programs);
			}
		}
        show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }
 
	//下线处理
    public function actionDown($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
                $model->updateByPk($d,array('online'=>648));
                $count++;
        }
        if ($count > 0) {
            ajax_status(1, '下线成功');
        } else {
            ajax_status(0, '下线失败');
        }
    }
	//上线处理
    public function actionOnline($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
                $model->updateByPk($d,array('online'=>649));
                $count++;
        }
        if ($count > 0) {
            ajax_status(1, '上线成功');
        } else {
            ajax_status(0, '上线失败');
        }
    }
	public function actionEnd($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
                $model->updateByPk($d,array('program_end_time'=>date('Y-m-d H:i:s')));
                $count++;
        }
        if ($count > 0) {
            ajax_status(1, '直播结束成功');
        } else {
            ajax_status(0, '直播结束失败');
        }
    }
	//视频播放
	public function actionVideo_player($url) {
        if (!Yii::app()->request->isPostRequest) {
            $data['url'] = $url;
            $this->render('video_player', $data);
        } else {
            //$this->saveData($model,$_POST[$modelName]);
        }
    }
	
	public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }
   

}
