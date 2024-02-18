<?php
    class VideoLiveSignSettingController extends BaseController {

        protected $model = '';

        public function init(){
            $this->model = substr(__CLASS__, 0, -10);
            parent::init();
        }

        public function actionIndex($keywords='',$video_live_id='',$return_state=''){
            set_cookie('_currentUrl_',Yii::app()->request->url);
            $modelName = $this->model;
            $model = $modelName::model();
            $criteria = new CDbCriteria;
            // $criteria->with = array('videoLive_id');
            $criteria->condition = 'exists(select * from video_live vlp where '.get_where_club_project('vlp.club_id').' and vlp.if_del=648 and vlp.live_state=2)';// and videoLive_id.live_end>"'.date('Y-m-d H:i:s').'"
            $criteria->condition = get_where($criteria->condition,!empty($video_live_id),'t.video_live_id',$video_live_id,'');
            $criteria->condition = get_like($criteria->condition,'t.video_live_title,t.gf_account',$keywords,'');
            $criteria->order = 't.id';
            $data = array();
            parent::_list($model,$criteria,'index',$data);
        }

        public function actionCreate($video_live_id){
            $modelName = $this->model;
            $model = new $modelName('create');
            $data = array();
            if(!Yii::app()->request->isPostRequest){
                $data['model'] = $model;
                // $cond = get_where_club_project('club_id').' and if_del=648 and live_state=2 and live_end>"'.date('Y-m-d H:i:s').'"';
                $data['video_live'] = VideoLive::model()->find('id='.$video_live_id);
                $this->render('update',$data);
            }
            else{
                $this->saveData($model,$_POST[$modelName]);
            }
        }

        public function actionUpdate($id){
            $modelName = $this->model;
            $model = $this->loadModel($id,$modelName);
            if(!Yii::app()->request->isPostRequest){
                $data = array();
                $data['model'] = $model;
                // $cond = get_where_club_project('club_id').' and if_del=648 and live_state=2 and live_end>"'.date('Y-m-d H:i:s').'"';
                // $data['video_live'] = VideoLive::model()->findAll($cond);
                $this->render('update',$data);
            }
            else{
                $this->saveData($model,$_POST[$modelName]);
            }
        }

        function saveData($model,$post){
            $model->attributes = $post;
            $sv = $model->save();
            $this->save_sign($model);
            show_status($sv,'操作成功',get_cookie('_currentUrl_'),'操作失败');
        }

        public function actionDelete($id) {
            $modelName = $this->model;
            $model = $modelName::model();
            $len = explode(',',$id);
            $count = 0;
            foreach($len as $d){
                $model->deleteAll('id='.$d);
                VideoLiveSign::model()->deleteAll('video_live_sign_setting_id='.$d);
                $count++;
            }
            if ($count > 0) {
                ajax_status(1, '删除成功', Yii::app()->request->urlReferrer);
                
            } else {
                ajax_status(0, '删除失败');
            }
        }

        public function actionReturnPrograms($id){
            $modelName = 'VideoLive';
            $model = $this->loadModel($id,$modelName);
            $data = VideoLivePrograms::model()->findAll('live_id='.$id);  // 直播结束后也可以打赏，所以去掉结束时间 .' and program_end_time>="'.date('Y-m-d H:i:s').'"'
            $club = ClubList::model()->find('id='.$model->club_id);
            $data1 = array();
            $data2 = array();
            if(!empty($data))foreach($data as $key => $val){
                $data1[$key]['id'] = $val->id;
                $data1[$key]['title'] = $val->title;
            }
            if(!empty($club)){
                $data2['code'] = $club->club_code;
                $data2['name'] = $club->club_name;
                $data2['logo'] = $club->club_logo_pic;
            }
            echo CJSON::encode([$data1,$data2]);
        }

        function save_sign($model){
            VideoLiveSign::model()->updateAll(array('sign_delete'=>1),'video_live_sign_setting_id='.$model->id);
            $post = $_POST['account_list'];
            if(!empty($post))foreach($post as $v){
                $live_sign = VideoLiveSign::model()->find('id='.$v['id']);
                if($v['id']=='null'){
                    $live_sign = new VideoLiveSign;
                    $live_sign->isNewRecord = true;
                    unset($live_sign->id);
                    $live_sign->add_time = date('Y-m-d H:i:s');
                    $live_sign->video_live_id = $model->video_live_id;
                    $live_sign->video_live_programs_id = $model->video_live_programs_id;
                    $live_sign->video_live_sign_setting_id = $model->id;
                }
                $live_sign->gf_account = $v['gf_account'];
                $live_sign->gf_name = $v['gf_name'];
                $live_sign->gf_zsxm = $v['gf_zsxm'];
                $live_sign->show_name = $v['show_name'];
                $live_sign->show_icon = $v['show_icon'];
                $live_sign->sort_num = $v['sort_num'];
                $live_sign->uDate = date('Y-m-d H:i:s');
                $live_sign->sign_delete = 0;
                $live_sign->save();
            }
            VideoLiveSign::model()->deleteAll('video_live_sign_setting_id='.$model->id.' and sign_delete=1');
            VideoLiveSignSetting::model()->updateByPk($model->id,array('live_num'=>count($post)));
        }

        public function actionGet_club($id){
            $modelName = 'VideoLive';
            $model = $this->loadModel($id,$modelName);
            $club = ClubList::model()->find('id='.$model->club_id);
            $data = array();
            $data['code'] = $model->code;
            $data['title'] = $model->title;
            if(!empty($club->club_logo_pic)){
                $data['logo'] = $club->club_logo_pic;
            }
            echo CJSON::encode($data);
        }
    }