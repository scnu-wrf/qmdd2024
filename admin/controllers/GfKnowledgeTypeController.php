<?php

class GfKnowledgeTypeController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
	public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition="club_id=".get_session("club_id")." and (fater_id is null or fater_id<=0)";
		$data = array();
        parent::_list($model, $criteria, 'index', $data,100);
    }
	
    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('update', $data);
        } else{
            // $this->saveData($model,$_POST[$modelName]);
			parent::_create($model,'create', $_POST[$modelName]);
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
            $this->actionSaveData($model,$_POST[$modelName]);
        }
    }

    public function actionCancel($id,$al){
        $ids = explode(',',$id);
        foreach($ids as $d){
            $modelName = $this->model;
            $model = $this->loadModel($d, $modelName);
            $model->f_vip=0;
            $sn=$model->save();
        }
        show_status($sn,$al,Yii::app()->request->urlReferrer,'失败');
    }

    public function actionSaveData() {
		$modelName = $this->model;
        $model = new $modelName('create');
		$model->title=$_POST['title'];
		$model->fater_id=$_POST['fater_id'];
		$model->club_id=$_POST['club_id'];
		$sv=$model->save();
		ajax_exit(array('status' => $sv, 'msg' => ($sv==1?"保存成功":'保存失败'), 'redirect' => get_cookie('_currentUrl_'),'id'=>$model->id));
    }
	
    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

}
