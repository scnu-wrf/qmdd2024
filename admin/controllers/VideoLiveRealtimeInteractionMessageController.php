<?php
    class LiveMessageController extends BaseController {
        protected $model = '';

        public function init() {
            $this->model = substr(__CLASS__, 0, -10);
            parent::init();
        }

        public function actionIndex($keywords = '') {
            set_cookie('_currentUrl_', Yii::app()->request->url);
            $modelName = $this->model;
            $model = $modelName::model();
            $criteria = new CDbCriteria;
            $criteria->condition = 'set_details_id>0 and is_pay=464';
            $criteria->condition = get_like($criteria->condition,'s_gfaccount',$keywords,'');
            $criteria->order ='id DESC';
            $data = array();
            parent::_list($model, $criteria, 'index', $data);
        }

        // 体育币充值明细
        public function actionIndex_details($keywords = '') {
            set_cookie('_currentUrl_', Yii::app()->request->url);
            $modelName = $this->model;
            $model = $modelName::model();
            $criteria = new CDbCriteria;
            $criteria->condition = 'exchange_id<>0 and is_pay=464';
            $criteria->condition = get_like($criteria->condition,'s_gfaccount',$keywords,'');
            $criteria->order ='pay_time DESC';
            $data = array();
            parent::_list($model, $criteria, 'index_details', $data);
        }
//直播通知列表
    public function actionIndex_order($keywords='',$live_title='',$programs_title ='',$star='',$end='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d H:i:s');
        $nowday=date('Y-m-d');
        if ($star=='') $star=$nowday;
        $criteria = new CDbCriteria;
        $criteria->join = "JOIN video_live_programs on t.live_program_id=video_live_programs.id JOIN video_live on t.live_id=video_live.id and video_live.club_id=".get_session('club_id');
        $cr='m_type=315';
        $cr.=' and video_live_programs.program_end_time>"' . $now . '"';
        $cr=get_where($cr,$star,'t.s_time>=',$star.' 00:00:00',"'");
        $cr=get_where($cr,$end,'t.s_time<=',$end.' 23:59:59',"'");
        $cr=get_like($cr,'video_live.title',$live_title,'');
        $cr=get_like($cr,'video_live_programs.title',$programs_title,'');
        $cr=get_like($cr,'t.r_gfaccount',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 't.live_program_time ASC';
        $data = array();
        $data['star'] = $star;
        $data['end'] = $end;
        parent::_list($model, $criteria, 'index_order', $data);
    }
        public function actionCreate() {
            $modelName = $this->model;
            $model = new $modelName('create');
            $data = array();
            if(!Yii::app()->request->isPostRequest){
                $data['model'] = $model;
                $this->render('update',$data);
            }
            else{
                $this->saveDate($model,$_POST[$modelName]);
            }
        }

        public function actionUpdate($id) {
            $modelName = $this->model;
            $model = $this->loadModel($id,$modelName);
            $data = array();
            if(!Yii::app()->request->isPostRequest){
                $data['model'] = $model;
                $this->render('update',$data);
            }
            else{
                $this->saveDate($model,$_POST[$modelName]);
            }
        }

        function saveDate($model,$post){
            $model->attributes = $post;
            $model->is_pay = 464;
            $model->is_pay_name = '已支付';
            // $model->pay_time = get_date();
            $model->s_time = get_date();
            $sv = $model->save();
            $this->save_gfUser($model);
            $this->save_available($model);
            show_status($sv,'保存成功',get_cookie('_currentUrl_'),'保存失败');
        }

        function save_gfUser($model){
            $user = GfUser1::model()->find('GF_ID='.$model->s_gfid);
            if(!empty($user)){
                $user->updateByPk($user->GF_ID,array('virtual_coin'=>$user->virtual_coin+$model->rechange_virtual_coin));
            }
        }

        function save_available($model){
            $available = VirtualMallPriceSetDetails::model()->find('id='.$model->set_details_id);
            if(!empty($available)){
                $available->updateByPk($available->id,array('available_quantity'=>$available->available_quantity+1));
            }
        }
    }