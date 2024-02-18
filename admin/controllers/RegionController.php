<?php

class RegionController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = 'TRegion';
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
    public function actionIndex($keywords = '',$pid = 0,$level = 1,$country_code='',$country_id='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
        if ($pid == 0) {
            $criteria->condition.=' AND (country_id ='. $country_id . ' AND level = '.$level.  ' AND country_code = "'.$country_code. '")';
        }else if($pid > 0) {
            $criteria->condition.=' AND (upper_region ='. $pid . ' AND country_code = "'.$country_code. '")';
        }
        
        if ($keywords !== '') {
            $criteria->condition.=' AND (region_name_e like "%' . $keywords . '%" OR region_name_c like "%' . $keywords . '%")';
        }
        $criteria->order = 'CODE ASC';
        
        parent::_list($model, $criteria);
    }
    
    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        
        parent::_create($model, 'create', $data, get_cookie('_currentUrl_'));
      
        
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            
        }
        parent::_update($model, 'update', $data, get_cookie('_currentUrl_'));
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }
    

}