<?php

class GfAppController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        
    }

    public function actionIndex($type_name = '',  $item_name = '', $keywords = '',$sortord='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1=1 ';
        $criteria->order = 'add_time DESC,app_name ASC' ;//排序条件
        if ($type_name != "所有应用类型" and $type_name != "") {
            $criteria->condition=get_like($criteria->condition,'app_type_name',$type_name,'');
        }
        if ($item_name != "所有应用项目" and $item_name != "") {
           $criteria->condition=get_like($criteria->condition,'app_item_name',$item_name,'');
        }
        if ($keywords !="请输入应用名称/编号")  {
         $criteria->condition=get_like($criteria->condition,'app_code,app_name',$keywords,'');
        }
        parent::_list($model, $criteria);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest){
            $data['model'] = $model;
            $this->render('update',$data);
        } else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest){
            $data['model'] = $model;
            $this->render('update',$data);
        } else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

    function saveData($model,$post){
        $model->attributes = $post;
        $sv = $model->save();
        show_status($sv,'保存成功',get_cookie('_currentUrl_'),'保存失败');
    }
}

