<?php

class ClubReportRecordController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        // $criteria->condition = 'club_id='.get_session('club_id');
        // $criteria->order = 'club2_code';
		$criteria->order = 'add_time DESC';
        // $data = array();
        parent::_list($model, $criteria,'index');
    }
	
    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
          
           $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
    }
    function saveData($model,$post) {
        $model->attributes = $post;
        $model->club_id=get_session('club_id');
        $clubCode = ClubList::model()->find('id='.get_session('club_id'));
        $model->club_code=$clubCode->club_code;
        $model->club_name=get_session('club_name');
        $sv=$model->save();
        show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

}
