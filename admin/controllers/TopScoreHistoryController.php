<?php

class TopScoreHistoryController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($gf_id='',$project_id='',$get_type='',$keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state=2';
        $criteria->condition = get_where($criteria->condition,!empty($gf_id),'t.gf_id',$gf_id,'');
        $criteria->condition = get_where($criteria->condition,!empty($project_id),'project_id',$project_id,'');
        $criteria->condition = get_where($criteria->condition,!empty($get_type),'get_type',$get_type,'');
        $criteria->join = "JOIN userlist t2 on t.gf_id = t2.GF_ID";
        $criteria->condition=get_like($criteria->condition,'t2.ZSXM,t2.GF_ACCOUNT',$keywords,'');
        $criteria->order = 'uDate DESC';
        $data = array();
        $data['project_list'] = ProjectList::model()->getProject();
        $data['get_type'] = BaseCode::model()->getReturn('893,895,1375');
        parent::_list($model, $criteria, 'index', $data);
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
        $modelName = $this->model;
        $model->attributes=$_POST[$modelName];
        $model->state = get_check_code($_POST['submitType']);
        $model->audit_time = date('Y-m-d H:i:s');
        $st=$model->save();

        show_status($st,'保存成功',get_cookie('_currentUrl_'),'保存失败');
    }


    public function actionIndex_verify($state='', $start_date = '', $end_date = '', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        if($state==''){
            $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
            $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
            $criteria->condition = 'get_type=895 and state=2';
        }else{
            $criteria->condition = 'get_type=895 and state='.$state;
        }
        if ($start_date != '') {
            $criteria->condition.=' and left(audit_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(audit_time,10)<="' . $end_date . '"';
        }
        $criteria->join = "JOIN userlist t2 on t.gf_id = t2.GF_ID";
        $criteria->condition=get_like($criteria->condition,'t2.ZSXM,t2.GF_ACCOUNT',$keywords,'');
        $criteria->order = 'audit_time DESC';
        $data = array();
        $data['count1'] = $model->count('get_type=895 and state=371');
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        parent::_list($model, $criteria, 'index_verify', $data);
    }
    
    public function actionUpdate_verify($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_verify', $data);
        } else {
			$this->saveConfirmData($model,$_POST);
        }
    }

    /**
     * 确认
     */
    function saveConfirmData($model,$post) {
        $modelName = $this->model;
        $model->attributes=$_POST[$modelName];
        $model->state = get_check_code($_POST['submitType']);
        $model->audit_time = date('Y-m-d H:i:s');
        $st=$model->save();

        show_status($st,'已确认',get_cookie('_currentUrl_'),'确认失败');
    }
    public function actionConfirmed($id) {
        $modelName = $this->model;
        $n = explode(',',$id);
        foreach($n as $v){
            $model = $this->loadModel($v,$modelName);
            $model->state = 2;
            $model->audit_time = date('Y-m-d H:i:s');
            $st=$model->save();
        }
        show_status($st,'已确认',Yii::app()->request->urlReferrer,'确认失败');
    }

    public function actionDelete($id) {
        parent::_clear($id);
    }



}
