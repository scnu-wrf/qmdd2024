<?php

class PersonalCollectionController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($live_title = '',$programs_title = '',$keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d H:i:s');
        $criteria = new CDbCriteria;
        $criteria->join = "JOIN video_live_programs on t.news_id=video_live_programs.id JOIN video_live on video_live_programs.live_id=video_live.id and video_live.club_id=".get_session('club_id');
		$cr='if_remind=870 and news_type=863';
        $cr.=' and video_live_programs.program_end_time>"' . $now . '"';
        $cr=get_like($cr,'video_live.title',$live_title,'');
        $cr=get_like($cr,'video_live_programs.title',$programs_title,'');
        $cr=get_like($cr,'video_live_programs.program_code,video_live.code',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'video_live_programs.program_time ASC';
        $data = array();
        $data['remind_type'] = BaseCode::model()->getCode(1430);
        parent::_list($model, $criteria, 'index', $data);
    }

 // 根据会员发通知
    public function actionGfidSending() {
        $id_str = $_POST['id'];
        $msg = $_POST['msg'];
        $type = $_POST['type'];
        $basepath=BasePath::model()->getPath(141);
        $pic=$basepath->F_WWWPATH; 
        $admin_id=get_session('admin_id');
        $id_arr=explode(',', $id_str);
        $count=0;
        $count_no=0;
        foreach ($id_arr as $d) {
            $arr = array();
            $model=PersonalCollection::model()->find('id='.$d);
            $program=VideoLivePrograms::model()->find('id='.$model->news_id);
            if(!empty($program)){
                $videolive=VideoLive::model()->find('id='.$program->live_id);
            }
            $arr[0]['live_program_id']=$model->news_id;
            if (!empty($videolive)) {
                $arr[0]['id']=$videolive->id;
                $pic=$pic.$videolive->logo;
                $title=$videolive->title.'直播-'.$program->title;
                $sendArr=array('type'=>'直播提醒通知','pic'=>$pic,'title'=>$title,'content'=>$msg,'type_id'=>10,'datas'=>$arr,'notify_type'=>$type);
                game_audit($admin_id,$model->gfid,$sendArr);
                $count++;
                
            } else{
                $count_no++;
            }
            
        }
        if ($count > 0) {
            ajax_status(1, $count . '条通知发送成功，' . $count_no . '条通知发送失败，', get_cookie('_currentUrl_'));
        } else {
            ajax_status(0, '通知发送失败');
        }
        

    }
   

}
