<?php

class ClubStoreRankController extends BaseController {

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
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionAddForm(){
        if($_POST['change']=='create'){
            $model = new ClubStoreRank();
            $model->isNewRecord = true;
            unset($model->id);
        }else{
            $model = ClubStoreRank::model()->find('id='.$_POST['data_id']);
        }
        $model->code=$_POST['code'];
        if(empty($_POST['fater_id'])){
            $model->type_name=$_POST['type_name'];
        }else{
            $model->rank_name=$_POST['rank_name'];
            $model->fater_id=$_POST['fater_id'];
        }
        $sv=$model->save();
        // $sv=0;
        show_status($sv,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }

    public function actionDelete($id) {
        parent::_delete($id);
    }


}
