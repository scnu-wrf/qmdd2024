<?php

class GfFriendshipLinkController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '',$state='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition=get_where($criteria->condition,!empty($state),'state',$state,'');
        $criteria->condition=get_like($criteria->condition,'state_name,title,link_address,email',$keywords,'');//get_where
        $criteria->order = 'id DESC';
        $data = array();
        $data['state'] = BaseCode::model()->getCode(370);
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {   
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('create', $data);
        }else{
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
           $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
  
 function saveData($model,$post) {
       $model->attributes =$post;
       if ($_POST['submitType'] == 'shenhe') {
            $model->state = 371;
        } else if ($_POST['submitType'] == 'baocun') {
            $model->state = 721;
        } else if ($_POST['submitType'] == 'tongguo') {
            $model->state = 2;
        } else if ($_POST['submitType'] == 'butongguo') {
            $model->state = 373;
        } else {
            $model->state = 721;
        }
		   $sv=$model->save();
		   show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');
 }

    public function actionDelete($id) {
        parent::_clear($id);
    }
 
 //public function getParent($pfieldname,$pcode) {
   //   return $this->findAll("f_tcode='".$pcode."'");
     // return $this->findAll(array('select' =>array('f_id ',$pfieldname.' f_rname'),'condition'=>"f_tcode='".$pcode."'"));
   // }


}


