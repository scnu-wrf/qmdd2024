<?php

class DragonTigerQuestionController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = 'DragonTigerQuestion';
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
            $criteria->condition.=' AND (member_type like "%' . $keywords . '%" OR project_id like "%' . $keywords . '%" OR grade like "%' . $keywords . '%" OR subject like "%' . $keywords . '%")';
        }
        $criteria->order = 'id ASC';
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

            // 启动事务
            $errors = array();
            $transaction = $model->dbConnection->beginTransaction();
            if ($model->save()) {
               //  //保存节目
                if (isset($_POST['programs'])) {
                    $programs = new DragonTigerAnswer;
                    foreach ($_POST['programs'] as $v) {
                        if ($v['answer']==null  && $v['answer_result'] == '') {
                            continue;
                        }
                        $programs->isNewRecord = true;
                        unset($programs->id);
                        $programs->questions_id = $model->id;
                        $programs->subject = $model->subject;
                        $programs->type = $model->type;
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

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;

            // 获取节目
            $data['programs'] = DragonTigerAnswer::model()->findAll('questions_id=' . $model->id);
            //
            if (!empty($data['programs'])) {
                foreach ($data['programs'] as $v) {
                    
                    $model->answer_list =1; 
                    $model->type =$v['type'];
                    $model->subject = $v['subject'];
                }
                

            }

            $this->render('update', $data);
        } else {
            $model->attributes = $_POST[$modelName];

            // 启动事务
            $errors = array();
            if ($model->save()) {
                //删除原节目
                DragonTigerAnswer::model()->deleteAll('questions_id=' . $model->id);
                //保存节目
                if (isset($_POST['programs'])) {
                    $programs = new DragonTigerAnswer;
                    foreach ($_POST['programs'] as $v) {
                        if ($v['answer']==null  && $v['answer_result'] == '') {
                            continue;
                        }
                        $programs->isNewRecord = true;
                        unset($programs->id);
                        $programs->questions_id = $model->id;
                        $programs->subject = $model->subject;
                        $programs->type = $model->type;
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
