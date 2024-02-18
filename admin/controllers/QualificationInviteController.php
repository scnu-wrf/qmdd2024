<?php

class QualificationInviteController extends BaseController {

    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($keywords = '',$club_id) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition=get_where(" 1=1 ",!empty($club_id),'club_id',$club_id,'');//get_where
        $criteria->order = 'id ASC';
        if ($keywords != '') {
            $criteria->condition.=' AND t.title like "%' . $keywords . '%"';
        }
        $criteria->order = 't.id DESC';
        $data = array();
        $data['project_list'] = ProjectList::model()->getAll();
        $data['base_code'] = BaseCode::model()->getCode(370);
        $data['type_code'] = MallProductsTypeSname::model()->getCode(173);
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {    
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        $data['model'] = $model;
        $data['qualification_pics']=array();
       if (!Yii::app()->request->isPostRequest) {
         $this->render('update', $data);
        }else{
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
           // $data['qualification_pics'] = explode('|', $model->qualification_pics);
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
  }
  

 function saveData($model,$post) {
           $model->attributes =$post;
          if ($model->save()) {
            ajax_status(1, '保存成功', get_cookie('_currentUrl_'));  
           } else {
            ajax_status(0, '保存失败');
          }
         }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

}
        //ajax_status(1, '删除成功');
        //
   // clubproject test save bbb{"ClubProject":{"apply_content":"\u516b\u6b21","project_id":"235","project_state":"119","project_level":"33","approve_state":"","auth_state":"459","valid_until":"0000-00-00 00:00:00","qualification_pics":"","state":"371","refuse":""},"submitType":"baocun"}
  