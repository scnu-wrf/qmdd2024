<?php

class DirectShoppersController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        
    }


    public function actionIndex($project_id = '',$club_star='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1=1 ';
        $criteria->order = 'id DESC' ;//排序条件

        if ($project_id != "所有项目" and $project_id != "") {
            $criteria->condition=get_like($criteria->condition,'project_id',$project_id,'');
        }


        if ($club_star != "所有等级" and $club_star != "") {
            $criteria->condition=get_like($criteria->condition,'club_star',$club_star,'');
        }

         parent::_list($model, $criteria);
    }


    public function actionCreate() {   
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;          
            $this->render('create', $data);
        }else{
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           parent::_update($model, 'update', $data, get_cookie('_currentUrl_'));
        } else {
            $this-> updateData($model,$_POST[$modelName]);
         }
    }

    function saveData($model,$post) {

        $project_list = explode(',', $post['project_list']);
        foreach ($project_list as $v) {
              $project = new DirectShoppers;
              $project->attributes = $post;
              unset($project->id);
              $project->project_id = $v;
            $project->save();
            }
 
      show_status(1==1,'保存成功', get_cookie('_currentUrl_'),'保存失败');   
    }

    function updateData($model,$post) {
        $model->attributes =$post;
        $model->project_id=$post['project_list'];
        $model->save();

      show_status(1==1,'保存成功', get_cookie('_currentUrl_'),'保存失败');   
    }


    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }


}
