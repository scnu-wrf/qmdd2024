<?php

class GfRecommendClubController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition=get_like($criteria->condition,'club_code,club_name',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
		$old_pic='';
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['club_list'] = array();
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }


    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $data['club_list'] = array();
            $data['club_list'] = ClubList::model()->findAll('id in (' . $model->club_list . ')');
          
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
    }
  
 function saveData($model,$post) {
       $model->attributes =$post;
       $sv=$model->save();
       show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');  
 }
 
  
 
     //删除
  public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $count=0;
        $count=$model->deleteAll('id in (' . $id . ')');
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }
  
	public function actionClubmore($keywords = '', $partnership_type = 0,$club_type = '',$club_id = '') {
		$data = array();
        $model = ClubList::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'unit_state=648 and state=2 and edit_state=2';
        $criteria->select = 'id select_id,club_name select_title,club_code select_code,partnership_name,club_type_name';
		if ($keywords != '') {
            $criteria->condition .= ' AND (club_name like "%' . $keywords . '%" OR club_code like "%' . $keywords . '%")';
        }
        if ($partnership_type > 0) {
            $criteria->condition .= ' AND partnership_type=' . $partnership_type;
        }
		if ($club_type != '') {
            $criteria->condition .= ' AND club_type=' . $club_type;
        }
        if ($club_id != '') {
            $arr='-1';
            $rec_club=GfRecommendClub::model()->find('club_id='.$club_id);
            if(!empty($rec_club->club_list)){
                $arr=$rec_club->club_list;
            }
            $criteria->condition .= ' AND id in (' .$arr. ')';
        }
		parent::_list($model, $criteria, 'clubmore', $data,10);
    }

}
