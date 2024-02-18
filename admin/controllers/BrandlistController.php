<?php

class BrandlistController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($keywords = '', $online = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
		if ($online != '') {
            $criteria->condition.=' AND brand_state=' . $online;
        }
        if ($keywords !== '') {
            $criteria->condition.=' AND (brand_title like "%' . $keywords . '%" OR brand_no like "%' . $keywords . '%")';
        }
        $criteria->order = 'brand_id ASC';
        parent::_list($model, $criteria, 'index');
    }
	
	public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['project_list'] = ProjectList::model()->getAll();
            $data['model'] = $model;
            $this->render('create', $data);
        } else {
            //dump($_POST);exit;
            $model->attributes = $_POST[$modelName];
            // 启动事务

            if ($model->save()) {
                $pid = $model->brand_id;
                // 关联项目添加
                $model2 = new MallBrandProject();
                $project_list = explode(',', $_POST[$modelName]['project_list']);
                $project_list = array_unique($project_list);
                foreach ($project_list as $v) {
                    //dump($v);
                    $model2->isNewRecord = true;
                    unset($model2->id);
                    $model2->brand_id = $pid;
                    $model2->project_id = $v;
                    $model2->save();
                }

                
                //$transaction->rollBack();
                ajax_status(1, '添加成功', get_cookie('_currentUrl_'));
            } else {
                //$transaction->rollBack();
                ajax_status(0, '添加失败');
            }
        }
    }

	
	 public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['project_list'] = ProjectList::model()->getAll();
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $model->attributes = $_POST[$modelName];
            // 启动事务
            //$error = array();
            //$transaction = $model->dbConnection->beginTransaction();
            if ($model->save()) {
                $pid = $model->brand_id;
                // 关联项目
                $model2 = new MallBrandProject();
                $project_list = explode(',', $_POST[$modelName]['project_list']);
                $project_list = array_unique($project_list);
                MallBrandProject::model()->deleteAll('brand_id=' . $pid);
                foreach ($project_list as $v) {
                    //dump($v);
                    $model2->isNewRecord = true;
                    unset($model2->id);
                    $model2->brand_id = $pid;
                    $model2->project_id = $v;
                    $model2->save();
                }
                //$transaction->rollBack();
                ajax_status(1, '更新成功', get_cookie('_currentUrl_'));
            } else {
                //$transaction->rollBack();
                ajax_status(0, '更新失败');
            }
        }
    }

  //public function actionDelete($id) {
     //   ajax_status(1, '删除成功');
   //     parent::_clear($id);
    //}
	
	public function actionDelete($brand_id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $count = $model->deleteAll('brand_id in(' . $brand_id . ')');
        if ($count > 0) {
            MallBrandProject::model()->deleteAll('brand_id in(' . $brand_id . ')');
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }
	


}
