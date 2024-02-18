<?php

class DragonTigerAnswerController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = 'DragonTigerAnswer';
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '',$pid='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
         $criteria->condition.=' AND (questions_id ='. $pid . ')';
        if ($keywords !== '') {
            $criteria->condition.=' AND (type_name like "%' . $keywords . '%" OR subject_code like "%' . $keywords . '%")';
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


            $this->render('create', $data);
        } else {
            $model->attributes = $_POST[$modelName];
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
        $pid = $_REQUEST['pid'];
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            
           // 获取题目
            $data['programs'] = DragonTigerAnswer::model()->findAll('que_or_aws=900 AND subject_code="' .$model->subject_code.'"');
            //
            if (!empty($data['programs'])) {
                foreach ($data['programs'] as $v) {
                    $model->answer_list =1; 
                    $model->answer = $v['answer'];
                    $model->answer_result = $v['answer_result'];
                }
                

            }

            $this->render('update', $data);
        } else {
            $model->attributes = $_POST[$modelName];

            // 启动事务
            $errors = array();
            if ($model->save()) {
                //删除原题目
                DragonTigerAnswer::model()->deleteAll('que_or_aws=900 AND subject_code="' .$model->subject_code.'"');
                //保存题目
                if (isset($_POST['programs'])) {
                    $programs = new DragonTigerAnswer;
                    foreach ($_POST['programs'] as $v) {
                        if ($v['answer']==null  && $v['answer_result'] == '') {
                            continue;
                        }
                        $programs->isNewRecord = true;
                        unset($programs->id);
                        $programs->subject = $model->subject;
                        $programs->subject_code = $model->subject_code;
                        $programs->type = $model->type;
                        $programs->subject_score = $model->subject_score;
                        $programs->answer = $v['answer'];
                        $programs->answer_result = $v['answer_result'];
                        if (!$programs->save()) {
                            $errors[] = $programs->getErrors();
                        }
                    }
                }
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
