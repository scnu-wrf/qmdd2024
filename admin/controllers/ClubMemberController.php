<?php

class ClubMemberController extends BaseController {

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
        $criteria->condition='agree_club != 337';
        
        $criteria->condition=get_like($criteria->condition,'zsxm,gf_account',$keywords,'');
        $criteria->order = 'gf_account';
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
            $this->render('update', $data);
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
       if ($model->save()) {
            ajax_status(1, '更新成功', get_cookie('_currentUrl_'));  
           } else {
            ajax_status(0, '更新失败');
          }
      // show_state($model->save(),'保存成功', get_cookie('_currentUrl_'),'保存失败');  
 }


    public function actionDelete($id) {
        parent::_clear($id);
    }
 
    // public function actionGetClubAjax($type = '', $keywords = '') {
    //     $modelName = $this->model;
    //     $model = $modelName::model();
    //     $criteria = new CDbCriteria;
    //     $criteria->condition = 'if_del=510';
    //     if ($keywords != '') {
    //         if ($type == 'code') {
    //             $criteria->condition.=' AND club_code like "%' . $keywords . '%"';
    //         } else if ($type == 'name') {
    //             $criteria->condition.=' AND club_name like "%' . $keywords . '%"';
    //         } else {
    //             ajax_exit(array('error' => 1, 'msg' => '非法操作'));
    //         }
    //     }
    //     $criteria->limit = 500;
    //     $arclist = $model->findAll($criteria);
    //     $arr = array();
    //     foreach ($arclist as $v) {
    //         $arr[$v->id]['id'] = $v->id;
    //         $arr[$v->id]['club_code'] = $v->club_code;
    //         $arr[$v->id]['club_name'] = $v->club_name;
    //         $arr[$v->id]['club_type_name'] = $v->club_type_name;
    //     }

    //     if (empty($arr)) {
    //         ajax_exit(array('error' => 1, 'msg' => '未搜索到数据'));
    //     }
    //     ajax_exit(array('error' => 0, 'datas' => $arr));
    // }

}
