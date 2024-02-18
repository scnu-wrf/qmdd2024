<?php

class ClubStoreTypeController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }


    public function actionIndex($fater_id='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'if_del=510';
        $criteria->order = 'code';
        $data = array();
        $data['train_type'] = BaseCode::model()->getReturn('1504,1505,1506');
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionAddForm(){
        if($_POST['change']=='create'){
            $model = new ClubStoreType;
            $model->isNewRecord = true;
            unset($model->id);
            $id=-1;
        }else{
            $model = ClubStoreType::model()->find('id='.$_POST['data_id']);
            $id=$_POST['data_id'];
        }
        $model->code=$_POST['code'];
        if(empty($_POST['fater_id'])){
            $model->f_id=$_POST['f_id'];
            $b_code=BaseCode::model()->find('f_id='.$_POST['f_id']);
            if(!empty($b_code)){
                $model->type=$b_code->F_NAME;
            }
            if(!empty($_POST['display']))$model->display=$_POST['display'];
        }else{
            $model->classify=$_POST['classify'];
            $model->fater_id=$_POST['fater_id'];
        }
        $count=$model->count('id<>'.$id.'  and code="'.$_POST['code'].'"');
        $no='';
        if($count>0){
            $sv=0;
            $no=',该编号已存在';
        }else{
            $sv=$model->save();
        }
        show_status($sv,'保存成功',Yii::app()->request->urlReferrer,'保存失败'.$no);
    }

    public function actionDelete($id) {
        parent::_delete($id);
    }


}
