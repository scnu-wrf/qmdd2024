<?php

class AreaController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = 'TCountry';
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition =get_like('1','english_name,chinese_name',$keywords,'');
        $criteria->order = 'id ASC';
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
    
    //  城市选择
    public function actionScales($info_id){
        $ws=array(
        'select'=>array('id','CODE','country_id','country_code','region_name_e','level','upper_region','region_name_c'),
        'order'=>'id',
        'condition'=>'upper_region='.$info_id
        )
        $data = TRegion::model()->findAll($ws);
        if(!empty($data)){
            echo CJSON::encode($data);
        }
    }
    //  城市选择
    public function actionSearch(){
        $name=$_POST['name'];
        $level=$_POST['level'];
        $m=new TRegion(); 
        $w1='(region_name_c="'.$name.'" and level='.$level.')';
        $tmp =$m->find($w1.' order by id ASC');
        $arr = array();
        if(!empty($tmp)){
            $region=$m->findAll('upper_region='.$tmp->id);
            $r=0;
            if(!empty($region)){
                foreach ($region as $v) {
                    $arr[$r]['region_name_c'] = $v->region_name_c;
                    $r=$r+1;
                }
                ajax_exit($arr);
            }
        }
    }

}
