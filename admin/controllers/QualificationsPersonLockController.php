<?php

class QualificationsPersonLockController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }


    public function actionIndex($start_date='',$end_date='',$keywords = '',$state='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '(1=1)';
        $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
        $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        if ($start_date != '') {
            $criteria->condition.=' AND left(add_time,10)>="'.$start_date.'"';
        }
        if ($end_date != '') {
            $criteria->condition.=' AND left(add_time,10)<="'.$end_date.'"';
        }
		$criteria->join = "JOIN qualifications_person on t.qualification_person_id=qualifications_person.id";
		$criteria->condition=get_like($criteria->condition,'qualifications_person.gfaccount,qualifications_person.gf_code,qualifications_person.qualification_name',$keywords,'');
        $criteria->condition=get_where($criteria->condition,!empty($state),'state',$state,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['state']=BaseCode::model()->getReturn('1282,1283,506,507');
        $data['start_date']=$start_date;
        $data['end_date']=$end_date;
        $data['count1'] = $model->count('state<>506 and left(add_time,10)="'.date("Y-m-d").'"');
        $data['count2'] = $model->count('state=506 and left(add_time,10)="'.date("Y-m-d").'"');
        parent::_list($model, $criteria, 'index', $data);
    }
    
    // 服务者账号处理
    public function actionAddForm(){
        $qModel = ClubQualificationPerson::model()->find('id='.$_POST['qualification_id']);
        $qModel->if_del=$_POST['if_del'];
        if($_POST['if_del']==1282){
            $qModel->lock_date_start=date('Y-m-d H:i:s'); 
            $qModel->lock_date_end=date('Y-m-d H:i:s', strtotime('7 days'));
        }else if($_POST['if_del']==1283){
            $qModel->lock_date_start=date('Y-m-d H:i:s'); 
            $qModel->lock_date_end=date('Y-m-d H:i:s', strtotime('30 days'));
        }else if($_POST['if_del']==507){
            $qModel->lock_date_start=date('Y-m-d H:i:s'); 
            $qModel->lock_date_end='9999-00-00 00:00:00';
        }else{
            $qModel->lock_date_start=''; 
            $qModel->lock_date_end='';
        }
        $qModel->lock_reason=$_POST['lock_reason'];
        $qModel->lock_time=date('Y-m-d H:i:s');
        $sv=$qModel->save();
        if($sv==1){
            $model = new QualificationsPersonLock();
            $model->isNewRecord = true;
            unset($model->id);
            $model->qualification_person_id=$qModel->id;
            $model->state=$qModel->if_del;
            $model->lock_date_start=$qModel->lock_date_start;
            $model->lock_date_end=$qModel->lock_date_end;
            $model->lock_reason=$qModel->lock_reason;
            $model->add_time=date('Y-m-d H:i:s'); 
            $model->save();
        }
        show_status($sv,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }
    function saveData($model,$post) {
        $model->attributes =$post;
        $st=$model->save();
        show_status($st,'保存成功',get_cookie('_currentUrl_'),'保存失败');
    }



    public function actionDelete($id) {
        parent::_clear($id);
    }


}
