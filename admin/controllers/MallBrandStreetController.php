<?php

class MallBrandStreetController extends BaseController {

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
		//$criteria->with = array('mall_brand_project');
        $criteria->condition = 'state = 2 and if_del = 510';
		$criteria->condition=get_where($criteria->condition,!empty($online),' brand_state',$online,'');
        $criteria->condition=get_like($criteria->condition,'brand_title,brand_no,club_name',$keywords,'');
        $criteria->order = 'f_userdate DESC';
        parent::_list($model, $criteria);
    }

    public function actionIndex_publish($keywords = '', $online = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->with = array('mall_brand_project');
        $criteria->condition=get_where('1=1',!empty($online),' brand_state',$online,'');
        $criteria->condition=get_like($criteria->condition,'brand_title,brand_no',$keywords,'');
        $criteria->order = 'brand_id DESC';
        parent::_list($model, $criteria,'index_publish');
    }

	public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            //$data['project_list'] = ProjectList::model()->getAll();
            $data['model'] = $model;
            $this->render('create', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

	
	 public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            //$data['project_list'] = ProjectList::model()->getAll();
            $data['model'] = $model;
            $this->render('update_new', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
	
	function saveData($model,$post) {
       $model->attributes =$post;
       $st=$model->save();
	   $this->save_project_list($model->brand_id,$post['project_list']);
	    show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败'); 
    }
	
	public function save_project_list($id,$project_list){       
    //删除原有项目
    MallBrandProject::model()->deleteAll('brand_id='.$id);
    if(!empty($project_list)){
        $model2 = new MallBrandProject();
        $club_list_pic = array();
        $club_list_pic = explode(',', $project_list);
        $club_list_pic = array_unique($club_list_pic);
        foreach ($club_list_pic as $v) {
            $model2->isNewRecord = true;
              unset($model2->id);
              $model2->brand_id = $id;
              $model2->project_id = $v;
              $model2->save();
        }
    }
  }


    //上线
    public function  actionOn_line(){
        //$GF_IDArray  = explode(",",$GF_ID);
        //$thawMode  = $thawMode;
        $id = $_GET['id'];
        $modelName = $this->model;
        $model = $modelName::model();
        $idArray = explode(",",$id);
        $count=0;
        //$count=$model->deleteAll('id in('.$id.')');
        foreach ($idArray as $d) {
            $model->updateByPk($d,array('brand_state'=>649));
            $count++;
        }
        if ($count > 0) {
            ajax_status(1, '上线成功',get_cookie('_currentUrl_'));
        } else {
            ajax_status(0, '上线失败');
        }


        //show_status($sv,'撤销成功',get_cookie('_currentUrl_'),'保存失败');
    }

    //下线
    public function  actionOff_line(){
        //$GF_IDArray  = explode(",",$GF_ID);
        //$thawMode  = $thawMode;
        $id = $_GET['id'];
        $modelName = $this->model;
        $model = $modelName::model();
        $idArray = explode(",",$id);
        $count=0;
        //$count=$model->deleteAll('id in('.$id.')');
        foreach ($idArray as $d) {
            $model->updateByPk($d,array('brand_state'=>648));
            $count++;
        }
        if ($count > 0) {
            ajax_status(1, '下线成功',get_cookie('_currentUrl_'));
        } else {
            ajax_status(0, '下线失败');
        }


        //show_status($sv,'撤销成功',get_cookie('_currentUrl_'),'保存失败');
    }


	/*
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
    */


    //逻辑删除
  public function actionDelete($brand_id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $brand_id);
        $count=0;
        foreach ($club as $d) {
                $model->delete('brand_id='.$d);
                MallBrandProject::model()->deleteAll('brand_id='.$d);
                $count++;
            
        }
        
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }
	


}
