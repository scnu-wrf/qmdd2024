<?php

class testPriceinfoController extends BaseController {
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

 public function actionDelete($id) {
      parent::_clear($id,'','id');
    }
    
  public function actionCreate() {   
       $this-> viewUpdate(0);
   } 

   public function actionUpdate($id) {
        $this-> viewUpdate($id);
    }/*曾老师保留部份，---结束*/
  
  public function viewUpdate($id=0) {
      $modelName = $this->model;
      $model = ($id==0) ? new $modelName('create') : $this->loadModel($id, $modelName);
      if (!Yii::app()->request->isPostRequest) {
         $data = array();
         $data['model'] = $model;
         $this->render('update', $data);
      } else {
         $this-> saveData($model,$_POST[$modelName]);
      }
  }/*曾老师保留部份，---结束*/
  
  function saveData($model,$post) {
       $model->attributes =$post;
       show_status($model->save(),'保存成功', get_cookie('_currentUrl_'),'保存失败');  
    }

    public function actionIndex($keywords="",$type="",$policy="") {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $w1= get_like('1','code,name',$keywords,'');
        $w1= get_where($w1,$type,'place_type');
        $w1= get_where($w1,$policy,'policy_name');
      
        $criteria->order='code';
        $place_type=testPlaceType::model()->findAll();
        $time_policy=testTimePolicy::model()->findAll();
        $data = array();
        $data['place_type']=$place_type;
        $data['time_policy']=$time_policy;
      //  parent::_list($model, $criteria, 'index', $data);
        parent::display($model, $criteria, 'index', $data);
    }

}

