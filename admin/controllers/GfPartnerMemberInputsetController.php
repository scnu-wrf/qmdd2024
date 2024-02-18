<?php

class GfPartnerMemberInputsetController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
    public function actionIndex($keywords = '',$pid='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
        $criteria->condition.=' AND (set_id = "'.$pid. '")';
        $criteria->condition=get_like($criteria->condition,'set_id,attr_name,type,attr_input_type,attr_unit',$keywords,'');
        $criteria->order = 'sort_order DESC';
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
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionIndex_unify($keywords = '',$type='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'type='.$type;
        $criteria->condition=get_like($criteria->condition,'attr_name,type,attr_unit',$keywords,'');
        $criteria->order = 'sort_order';
        $data = array();
        parent::_list($model, $criteria, 'index_unify', $data);
    }

    public function actionCreate_unify() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_unify', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }
    public function actionUpdate_unify($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_unify', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    function saveData($model,$post) {
        $model->attributes =$post;
        $sv=$model->save();
        $this->save_value($model->id, $post['program_list']);
        show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

    public function save_value($id, $program_list){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $gf_partner=GfPartnerMemberValues::model()->findAll('set_input_id='.$id);
        $arr=array();
        $programs = new GfPartnerMemberValues();
        if(!empty($_POST['program_list'])){
            foreach ($_POST['program_list'] as $v){
                if($v['attr_values'] == ''){
                    continue;
                }
                if($v['id']=='null'){
                    $programs->isNewRecord = true;
                    unset($programs->id);
                    $programs->set_id = $model->set_id;
                    $programs->set_input_id = $model->id;
                    $programs->attr_unit = $model->attr_unit;
                    $programs->attr_values = $v['attr_values'];
                    $programs->save();
                }
                else{
                    $programs->updateByPk($v['id'],array('attr_values' => $v['attr_values']));
                    $arr[]=$v['id'];
                }
            }
        }
        if(isset($gf_partner)){
            foreach($gf_partner as $k){
                if(!in_array($k->id,$arr)){
                    GfPartnerMemberValues::model()->deleteAll('id='.$k->id);
                }
            }
        }
    }
}