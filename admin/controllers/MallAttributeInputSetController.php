<?php

class MallAttributeInputSetController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        
    }


    public function actionIndex($type_id='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1=1 ';
        $criteria->order = 'attr_id DESC ' ;//排序条件


        if ($type_id != "所有商品类型" and $type_id != "") {
            $criteria->condition=get_like($criteria->condition,'cat_id',$type_id,'');
            
        }

         parent::_list($model, $criteria);
    }


    public function actionCreate($type_id) {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        $model->cat_id=$type_id;
        parent::_create($model, 'update', $data, get_cookie('_currentUrl_'));
    }



    public function actionUpdate($attr_id) {
        $modelName = $this->model;
        $model = $this->loadModel($attr_id, $modelName);
        $data = array();
        parent::_update($model, 'update', $data, get_cookie('_currentUrl_'));
    }



   public function actionDelete($id) {
        parent::_clear($id,'','attr_id');

    }

}

