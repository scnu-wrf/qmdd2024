<?php

class GfHealthyModelController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = 'GfHealthyModel';
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '', $gf_healthy_project='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
        // $criteria->join = "JOIN gf_healthy_project on t.id=gf_healthy_project.healthy_id";
        // $criteria->with = 'gf_healthy_project';
        $criteria->condition=get_where($criteria->condition,!empty($gf_healthy_project),'t.gf_healthy_project',$gf_healthy_project,'');
        $criteria->condition=get_like($criteria->condition,'attr_name',$keywords,'');
        // if($gf_healthy_project != '') {
        //     $criteria->condition.=' AND t.gf_healthy_project = ' . $gf_healthy_project;
        // }
        $criteria->order = 'sort_order DESC';
        $data = array();
        $data['project_list'] = ProjectList::model()->getAll();
        $data['base_code'] = BaseCode::model()->getCode(676);
        $data['project_name'] = array();
        // $project = ProjectList::model()->findAll('IF_VISIBLE=649');
        // foreach ($project as $v) {
        //     $data['project_name'][$v->id] = $v->project_name;
        // }
        parent::_list($model, $criteria,'index',$data);
    }
    
    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            // 获取项目
            if (!empty($model->project_name)) {
                $data['project_name'] = ProjectList::model()->findAll('id in (' . $model->project_name . ')');
            } else {
                $data['project_name'] = array();
            }
            $this->render('update', $data);
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
            // 获取项目
            if (!empty($model->project_name)) {
                $data['project_name'] = GfHealthyProject::model()->findAll('id in (' . $model->project_name . ')');
            } else {
                $data['project_name'] = array();
            }
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    function saveData($model,$post) {
        $model->attributes =$post;
        $sv=$model->save();
        $this->save_project_name($model->id,$post['project_name']);
        show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }
    
    public function save_project_name($id,$project_name){
        GfHealthyProject::model()->deleteAll('healthy_id='.$id);
        if(!empty($project_name)){
            $model2 = new GfHealthyProject();
            $gf_project_model = array();
            $gf_project_model = explode(',',$project_name);
            $gf_project_model = array_unique($gf_project_model);
            foreach($gf_project_model as $v){
                $model2->isNewRecord = true;
                unset($model2->id);
                $model2->healthy_id = $id;
                $model2->project_id = $v;
                $model2->save();
            }
        }
    }
}