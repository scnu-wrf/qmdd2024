<?php

class MenuController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '',$f_code='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->order = 'f_code';
         if (Yii::app()->request->isPostRequest) {
          $num=0;
          if(isset($_POST['num'])){
            $num=$_POST['num'];}
          for($i=0;$i<$num;$i++){
            if(isset($_POST['name'.$i]) && isset($_POST['na'.$i])){
              if($_POST['name'.$i]!==$_POST['na'.$i]){
                $ch=array('f_name'=>$_POST['name'.$i],'f_name'=>$_POST['name'.$i]);
                $model->model()->updateAll(array('f_name'=>$_POST['name'.$i]),'f_id='.$_POST['id'.$i]);
              }
             }
             if(isset($_POST['code'.$i]) && isset($_POST['co'.$i])){
              if($_POST['code'.$i]!==$_POST['co'.$i]){
                $this->update_code($_POST['code'.$i],$_POST['co'.$i]);
              }
           }
          }
        }
        $data['model'] = $model;
        $data['main_menu']= MenuMain::model()->findAll();
        $this->render('index', $data);
    }

    public function actionIndexsort($keywords = '',$f_code='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->order = 'f_code';
         if (Yii::app()->request->isPostRequest) {
          if(!empty($_POST['code'])){//添加
              $this->add_code($_POST['code'],$_POST['name']);
          } else{ //修改
          $num=0;
          if(isset($_POST['num'])){
            $num=$_POST['num'];}
          for($i=0;$i<$num;$i++){
            if(isset($_POST['name'.$i])){
              $ids=explode(",",$_POST['id'.$i]);//id,bcode,bname,code
              $w1='f_id='.$ids[0];
              $ln=strlen(trim($ids[3]));
            if(($_POST['name'.$i]!==$ids[2]) ||( $_POST['code'.$i]!==$ids[1]) ||( $ln<=3)){
                $ch=array('f_btype'=>substr($_POST['code'.$i],0,1),'f_bcode'=>$_POST['code'.$i],'f_bname'=>$_POST['name'.$i]);
                if ( $ln<=3){
                    $ch['f_imgshow']='images/Backstage-icon/menu/'.$_POST['cshow'.$i];
                    $ch['f_imgdown']='images/Backstage-icon/menu/'.$_POST['cdown'.$i];
                }
                $model->model()->updateAll($ch,$w1);
                if(strlen($_POST['code'.$i])>3){
                 $this->update_bcode($w1,$model,$ids[3],$_POST['code'.$i]);}
              }
             }
          }
         }
        }
        $data['model'] = $model;
        $data['main_menu']= MenuMain::model()->findAll("f_name<>' '");
        $this->render('indexsort', $data);
    }

  function update_bcode($w1,$model,$f_code,$ncode){
      $bcode=trim($f_code);
      $ncode=trim($ncode);
      $bt=substr($ncode,0,1);
      $w1="left(f_code,5)='".$bcode."' and f_mtype=4"; 
      $tmp0= $model->model()->findAll($w1);
      foreach($tmp0 as $v0){
        $ch=array('f_btype'=>$bt,'f_bcode'=>$ncode.substr($v0['f_code'],5,4));
        $model->model()->updateAll($ch,'f_id='.$v0['f_id']);
      }
  }

  function add_code($f_code,$f_name){
      $bcode=trim($f_code);
      $ln=strlen($bcode);
      $tmp0= Menu::model()->findAll("f_bcode='".$f_code."'");
      if((($ln==3) || ($ln==5))&&(empty($tmp0))){
            $model2 = new Menu();
            $model2->isNewRecord = true;
            unset($model2->f_id);
            $model2->f_code=$f_code;
            $model2->f_name=$f_name;
            $model2->f_nameb=$f_name;
            $model2->f_type=substr($f_code,0,1);
            $model2->f_mtype=($ln==3) ? 1 : 2;

            $model2->f_bcode=$f_code;
            $model2->f_bname=$f_name;
            $model2->f_btype=substr($f_code,0,1);
         
            $model2->save();
 
      }
  }
  public function update_code($c1,$c2) {
      $modelName = $this->model;
      $model1 = $modelName::model();
      $tmp=$model1->model()->findAll("left(f_code,5)='".$c2."'");
        foreach($tmp as $v0){
           $c2=$c1+substr($v0['f_code'],5);
           $model1->model()->updateAll(array('f_code'=>$c2),'f_id='.$v0['id']);
        }                                   
    }

  public function actionMainMenu($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
       // $modelName = $this->model;
        $model =  MenuMain::model();
        $criteria = new CDbCriteria;
        $criteria->order = 'f_code';
        if (Yii::app()->request->isPostRequest) {
    
          $num=$_POST['num'];
          for($i=0;$i<$num;$i++){
            if(isset($_POST['name'.$i]) && isset($_POST['na'.$i])){
            $ch=array('f_name'=>$_POST['name'.$i],'f_image'=>$_POST['f_image'.$i]);
              $model->model()->updateAll($ch,'f_id='.$_POST['id'.$i]);
            //}
           }
          }
        }
        $data['model'] = $model;
        $this->render('mainMenu', $data);      
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }
 

}
