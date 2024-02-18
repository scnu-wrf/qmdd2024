<?php

class QmddFuntionDataController extends BaseController {
    
    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($keywords = '',$function_area_id = '', $club_id = '') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition=get_where_club_project('club_id','');
        $criteria->condition=get_where($criteria->condition,!empty($function_area_id),'function_area_id',$function_area_id,'');
        $criteria->condition=get_where($criteria->condition,!empty($club_id),'club_id',$club_id,'');
        $criteria->condition = get_like($criteria->condition,'function_id,function_name,function_area_id,club_id',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['function_area_id'] = QmddFunctionArea::model()->findAll();
        $data['club_id'] = ClubList::model()->findAll();
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('create', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            // 获取经营类目
            if (!empty($model->dispay_type)) {
                $data['dispay_type'] = BaseCode::model()->findAll('f_id in (' . $model->dispay_type . ')');
            } else {
                $data['dispay_type'] = array();
            }
            $data['project_list'] = ProjectList::model()->findAll('id in('.$model->project_id.')');
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    function saveData($model,$post) {
        $model->attributes = $post;
        $sv=$model->save();
        show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }

    public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $count = $model->deleteAll('id in(' . $id . ')');
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }
}