<?php 
    class QmddServerTimePriceInfoController extends BaseController {
        protected $model = '';

        public function init() {
            // $this->model = 'QmddServerTimePriceInfo';
            $this->model = substr(__CLASS__, 0, -10);
            parent::init();
        }

        public function actionIndex($keywords = '', $ftypeid='') {
            set_cookie('_currentUrl_', Yii::app()->request->url);
            $modelName = $this->model;
            $model = $modelName::model();
            $criteria = new CDbCriteria;
            // $criteria->condition = 'club_id='.get_session('club_id');
            $criteria->condition = get_where_club_project('club_id','');
            $criteria->condition = get_where($criteria->condition,!empty($ftypeid),'f_typeid',$ftypeid,'');
            $criteria->condition = get_like($criteria->condition, 'tp_code,tp_name', $keywords, '');
            $criteria->order = 'id';
            $data = array();
            $data['ftypeid'] = QmddServerType::model()->findAll();
            parent::_list($model, $criteria, 'index', $data);
        }

        public function actionCreate() {
            $modelName = $this->model;
            $model = new $modelName('create');
            $data = array();
            if(!Yii::app()->request->isPostRequest) {
                $data['model'] = $model;
                $this->render('update', $data);
            } else{
                $this->saveData($model,$_POST[$modelName]);
            }
        }

        public function actionUpdate($id) {
            $modelName = $this->model;
            $model = $this->loadModel($id, $modelName);
            if(!Yii::app()->request->isPostRequest) {
                $data = array();
                $data['model'] = $model;
                $this->render('update', $data);
            } else{
                $this->saveData($model,$_POST[$modelName]);
            }
        }

        function saveData($model,$post) {
            $model->attributes = $post;
            $model->state = get_check_code($model->state);
            $sv=$model->save();
            $this->save_service_time($model,$post);
            show_status($sv,'保存成功', get_cookie('_currentUrl_'), '保存失败');
        }

        public function actionDelete($id) {
            $modelName = $this->model;
            $model = $modelName::model();
            $lode = explode(',', $id);
            $count=0;
            foreach($lode as $d){
                $model->deleteAll('id='.$d);
                QmddServerTimePriceData::model()->updateAll(array('if_del'=>509),'info_id='.$d);
                $count++;
            }
            if ($count > 0) {
                ajax_status(1, '删除成功');
            } else {
                ajax_status(0, '删除失败');
            }
        }

        public function save_service_time($model,$post){
            $server_time = new QmddServerTimePriceData();
            $server_time->updateAll(array('f_dname'=>1),'info_id='.$model->id);
            if(!empty($_POST['service_time'])){
                foreach($_POST['service_time'] as $v){
                    // for($i=1;$i<8;$i++){
                        if($v['f_dname1']==''/* || $v['f_dname2']=='' || $v['f_dname3']=='' || $v['f_dname4']=='' || $v['f_dname5']=='' || $v['f_dname6']=='' || $v['f_dname7']=='' || $v['f_dname8']==''*/){
                            continue;
                        }
                    // }
                    if($v['id']=='null'){
                        $server_time->isNewRecord = true;
                        unset($server_time->id);
                    }
                    else{
                        $server_time = QmddServerTimePriceData::model()->find('id='.$v['id']);
                    }
                    $server_time->info_id = $model->id;
                    $server_time->f_uid = $model->f_uid;
                    $server_time->t_code = $model->t_code;
                    $server_time->t_name = $model->t_name;
                    $server_time->tp_code = $model->tp_code;
                    $server_time->tp_name = $model->tp_name;
                    $server_time->f_ucode = $model->f_ucode;
                    $server_time->f_uname = $model->f_uname;
                    $server_time->f_typeid = $model->f_typeid;
                    $server_time->project_ids = $model->project_ids;
                    $server_time->f_dcode = $v['f_dcode'];
                    $server_time->f_level = $v['f_level'];
                    for($i=1;$i<18;$i++){
                        if(isset($v['f_dname'.$i])){
                            $server_time{'f_dname'.$i} = $v['f_dname'.$i];
                            $server_time{'f_price'.$i} = $v['f_price'.$i];
                        }
                    }
                    $server_time->f_levelname = $v['f_levelname'];
                    $server_time->f_member_type = $v['f_member_type'];
                    $server_time->f_dname = 0;
                    $server_time->save();
                }
            }
            QmddServerTimePriceData::model()->deleteAll('f_dname=1 AND info_id='.$model->id);
        }
    }