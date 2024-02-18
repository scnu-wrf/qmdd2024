<?php

class DragonTigerUserlistController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex( $keywords = '',$if_pass='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition='1';
        $criteria->condition=get_where($criteria->condition,!empty($if_pass),'if_pass',$if_pass,'');
        $criteria->condition=get_like($criteria->condition,'check_number,gf_account,gf_name',$keywords,'');
        
        $criteria->order = 'id ASC';
        $data = array();
        $data['if_pass'] = BaseCode::model()->getCode(647);

        parent::_list($model, $criteria, 'index', $data);
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
            // $model->state= ($_POST['submitType'] != 'shenhe') ? 721 : (($model->state == '') ? 371 : $model->state);
            $errors = array();
            $transaction = $model->dbConnection->beginTransaction();
        if ($model->save()) {
            $transaction->commit();
            ajax_status(1, '更新成功', get_cookie('_currentUrl_'));  
        } else {
            $transaction->rollBack();
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
            //$data['member_type'] = DragonTigerUseranswer::model()->findAll('check_number="'.$model->check_number.'"');
            // 获取项目
            if (!empty($model->project_name)) {
                //找到项目列表里的项目id等于当前字段id，并保存到当前数组
                $data['project_name'] = ProjectList::model()->findAll('id in (' . $model->project_id . ')');

            } else {
                //否则该数组为空
                $data['project_name'] = array();
            }

            $this->render('update', $data);
        } else {
            $model->attributes = $_POST[$modelName];
           

            // 启动事务
            $errors = array();
            $transaction = $model->dbConnection->beginTransaction();
            if ($model->save()) {
               
                //dump($errors);
                if (!empty($errors)) {
                    $transaction->rollBack();
                    ajax_status(0, ' 更新失败');
                } else {
                    $transaction->commit();
                    ajax_status(1, '更新成功', get_cookie('_currentUrl_'));
                }
            } else {
                $transaction->rollBack();
                ajax_status(0, '更新失败');
            }
        }
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

}
