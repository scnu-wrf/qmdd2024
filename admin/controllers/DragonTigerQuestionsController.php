<?php

class DragonTigerQuestionsController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = 'DragonTigerQuestions';
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';

        if ($keywords !== '') {
            $criteria->condition.=' AND (member_type_name like "%' . $keywords . '%" OR project_name like "%' . $keywords . '%" OR grade_name like "%' . $keywords . '%")';
        }
        $criteria->order = 'id DESC';
        parent::_list($model, $criteria);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;


            $this->render('update', $data);
        } else {
            $model->attributes = $_POST[$modelName];

            // 启动事务
            $errors = array();
            if ($model->save()) {
               
                if (!empty($errors)) {
                    ajax_status(0, ' 更新失败');
                } else {
                    ajax_status(1, '更新成功', get_cookie('_currentUrl_'));
                }
            } else {
                ajax_status(0, '更新失败');
            }
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;

            //$data['answer']=DragonTigerAnswer::model()->findAll('questions_id='.$model->id);
           

            $this->render('update', $data);
        } else {
            $model->attributes = $_POST[$modelName];

            // 启动事务
            $errors = array();
            if ($model->save()) {
                if (!empty($errors)) {
                    ajax_status(0, ' 更新失败');
                } else {
                    ajax_status(1, '更新成功', get_cookie('_currentUrl_'));
                }
            } else {
                ajax_status(0, '更新失败');
            }
        }
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

}
