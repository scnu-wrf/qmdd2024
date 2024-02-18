<?php

class QmddServerUsertypeController extends BaseController {
    
    protected $model = '';

    public function init() {
        // $this->model = substr(__CLASS__, 0, -10);
        $this->model = 'QmddServerUsertype';
        parent::init();
    }

    public function actionIndex($keywords = '',$ftypeid='') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'if_del=510';
        $criteria->condition = get_like($criteria->condition,'f_uname',$keywords,'');
        $criteria->condition = get_where($criteria->condition,!empty($ftypeid),'t_server_type_id',$ftypeid,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['ftypeid'] = QmddServerType::model()->findAll();
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
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
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['project_list'] = ProjectList::model()->findAll();
            $this->render('update',$data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    function saveData($model,$post) {
        $model->attributes = $post;
        if(!empty($model->service_type)){
            $s_type = ClubType::model()->find('id='.$model->service_type);
            if(empty($model->f_uname) && !empty($s_type)){
                $model->f_uname = $s_type->f_ctname;
            }
        }
        if(!empty($model->t_server_type_id)){
            $ts_type = QmddServerType::model()->find('id="'.$model->t_server_type_id.'"');
            if(!empty($ts_type)){
                $model->t_code = $ts_type->t_code;
                $model->t_name = $ts_type->t_name;
            }
        }
        $sn = $model->save();
        show_status($sn,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }

    // public function actionDelete($id) {
    //     $modelName = $this->model;
    //     $model = $modelName::model();
    //     $len = explode(',',$id);
    //     foreach($len as $d){

    //     }
    //     $count = $model->updateAll(array('if_del'=>509),'id='.$id);
    //     if ($count > 0) {
    //         ajax_status(1, '删除成功');
    //     } else {
    //         ajax_status(0, '删除失败');
    //     }
    // }

    public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $lode = explode(',', $id);
        $count=0;
        foreach($lode as $d){
            $model2 = QmddServerUsertype::model()->find('id='.$d);
            // $model->deleteAll('id='.$d);
            $model->updateAll(array('if_del'=>509),'id='.$d);
            $str = QmddServerUsertype::model()->count('t_code in("'.$model2->t_code.'") ');
            if($str<1){
                // QmddServerType::model()->deleteAll('t_code="'.$model2->t_code.'"');
                QmddServerType::model()->updateAll(array('if_del'=>509),'t_code="'.$model2->t_code.'"');
            }
            $count++;
        }
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }
}


