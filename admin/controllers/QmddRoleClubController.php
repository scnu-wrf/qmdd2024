<?php

class QmddRoleClubController extends BaseController {

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
        $criteria->order = 'f_type_code';
        if (Yii::app()->request->isPostRequest) {
          $this->saveData($model,$_POST[$modelName]['tmp']);
         }
        parent::_list($model, $criteria,'index',array(),25);
    }

   


  
 function saveData($model,$ptmp) {
    $model->updateAll(array('f_type_code'=>'dele'),'id>=0');
    foreach ($ptmp as $v){
      if (!empty($v[2]) ){
          $tmp1= QmddRoleClub::model()->find('f_club_type='.$v[0]);
          if(empty($tmp1)){
            $tmp1=new  QmddRoleClub();
            $tmp1->isNewRecord = true;
            unset($tmp1->id);
          }
          $tmp1->f_roleid = $v[2];
          $tmp1->f_rcode =$v[3];
          $tmp1->f_rname =$v[4];
          $tmp1->f_club_type =$v[0];
          $tmp1->f_club_item_type =$v[0];
          $tmp1->f_type_code ='use';
          $tmp1->save();
        }
     }
    $model->deleteAll("f_type_code='dele'");
  }

  public function actionDelete($id) {
        parent::_clear($id,'','f_id');
    }
 
 
}


