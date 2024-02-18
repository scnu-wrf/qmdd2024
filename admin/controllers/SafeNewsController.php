<?php

class SafeNewsController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '',$start_date='',$end_date='',$state='',$news_type='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition=get_where_club_project('club_id','');
		$criteria->condition.=' AND if_del=506';
        $criteria->condition=get_where($criteria->condition,!empty($state),'state',$state,'');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'news_date_start>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'news_date_end<=',$end_date,'"');
        $criteria->condition=get_like($criteria->condition,'news_title,news_code,news_club_name',$keywords,'');//get_where
        $criteria->order = 'id DESC';
        $data = array();
        $data['state'] = BaseCode::model()->getCode(370);
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
		$old_pic='';
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }


    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$old_pic=$model->news_pic;
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $basepath = BasePath::model()->getPath(257);
           $model->news_content_temp=get_html($basepath->F_WWWPATH.$model->news_content, $basepath);
           $data['model'] = $model;
          
           $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
    }
  
 function saveData($model,$post) {
       $model->attributes =$post;
		$model->state=get_check_code($_POST['submitType']);
       $sv=$model->save();  
       show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');  
 }

     //逻辑删除
  public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $count = $model->updateByPk($id,array('if_del'=>507));
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }


}
