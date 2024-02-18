<?php

class RoleController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
	
	public function actionGetClubAjax($type = '', $keywords = '') {
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'if_del=510';
        if ($keywords != '') {
            if ($type == 'code') {
                $criteria->condition.=' AND club_code like "%' . $keywords . '%"';
            } else if ($type == 'name') {
                $criteria->condition.=' AND club_name like "%' . $keywords . '%"';
            } else {
                ajax_exit(array('error' => 1, 'msg' => '非法操作'));
            }
        }
        $criteria->limit = 500;
        $arclist = $model->findAll($criteria);
        $arr = array();
        foreach ($arclist as $v) {
            $arr[$v->id]['id'] = $v->id;
            $arr[$v->id]['club_code'] = $v->club_code;
            $arr[$v->id]['club_name'] = $v->club_name;
            $arr[$v->id]['club_type_name'] = $v->club_type_name;
        }
        if (empty($arr)) {
            ajax_exit(array('error' => 1, 'msg' => '未搜索到数据'));
        }
        ajax_exit(array('error' => 0, 'datas' => $arr));
         $criteria = new CDbCriteria;
       if ($club_id<0) $club_id=get_session('club_id'); 
        $w1='lang_type='.$lang_type.(($lang_type=='0') ? '' : ' and club_id='.$club_id);  
        $criteria->condition=get_like($w1,'admin_gfaccount,admin_gfnick',$keywords,'');
        $criteria->order = 'admin_gfaccount';
        parent::_list($model, $criteria);
    }
  

    public function actionIndex($keywords = '',$f_tcode="",$club_id=-1) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $wn=strlen($f_tcode);
        if ($club_id<0) $club_id=get_session('club_id');
        $w1=" f_type=" . ($wn+1).' and club_id='.$club_id;
        $w1.=($wn==0) ? " " : (" and left(f_tcode,".strlen($f_tcode).")='".$f_tcode."'");
        $criteria->condition=get_like($w1,'f_rname,f_rcode',$keywords,'');
        $criteria->order = 'f_tcode';
        parent::_list($model, $criteria);
    }

    public function actionCreate() {   
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        }else{
            $this-> saveData($model,$_POST[$modelName],0);
        }
    }

    public function actionUpdate($f_id) {
        $modelName = $this->model;
        //$this->get_opter();
        $model = $this->loadModel($f_id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
           $data['model']->if_delete=$data['model']->f_opter;
           $data['model']->f_opter=explode(',',$data['model']->f_opter);
           $this->render('update', $data);
        } else {
          $this-> saveData($model,$_POST[$modelName],1);
        }
    }


   function get_chose($p1,$p2,$pscode,$plist,$pmname){
    if(!empty($p2)){
    $da2=explode('|',$p2);
    foreach ($da2 as $c){
          foreach ($pmname as $c1){
                  if ($c==$c1['f_id']){
                      $pmname1=$c1['f_mname'];
                      $c5=0;
                      foreach ($plist as $c2){
    
                            if (($pmname1==$c2['f_name'])&&($pscode==$c2['f_opcode'])){
                              $p1.=(($p1) ? "," : '').$c2['f_id'];$c5=1;
                                break;
                             }
                        }
                      if($c5==1)   break;

                    }
            }
      }
    }
    return  $p1;
   }
    function get_opter() {
      $list = Role::model()->findAll("left(f_opter,1)=' '");
      $mn = Menu::model()->findAll();
      $menuidstr='';
      $modelName = $this->model;
      $i=0;
     foreach ($list as $da1){
      
        $menuidstr='';
        $menuidstr=$this->get_chose($menuidstr,$da1['if_state'],'shehe',$list1,$mn);
        $menuidstr=$this->get_chose($menuidstr,$da1['if_inster'],'creat',$list1,$mn);
        $menuidstr=$this->get_chose($menuidstr,$da1['if_update'],'update',$list1,$mn); 
        $menuidstr=$this->get_chose($menuidstr,$da1['if_select'],'index',$list1,$mn);
        $menuidstr=$this->get_chose($menuidstr,$da1["if_delete"],'delete',$list1,$mn);
        $model0 = Role::model()->find('f_id='.$da1['f_id']);
       $model0->f_opter='0';
       $model0->f_opter=$menuidstr;
       $model0->save();
       $i=$i+1;
       if($i>=15){
        break;
       }
        
      }
     return ;  
  }
  
 function saveData($model,$post,$new) {
      $model->attributes =$post;
      $tmp_opter=$post['tmp_opter2'];
      $b1="";$s1="";

        foreach ($tmp_opter as $v){
             if (!empty($v))
             foreach ($v as $v2){
                if (!empty($v2)){
                foreach ($v2 as $v1){
                  if (!empty($v1)){
                    $s1.=$b1.$v1;
                    $b1=",";
                   }
                 }
              }
             }
        }
      $model->f_opter= $model->if_delete;//$s1;
      $model->if_delete='';
   //    $model->f_user_type=$post['f_user_type'];
      if(strlen(trim($model->f_rcode))<=3)  $model->club_id=0; 
  
       $st2= $model->save();
      if (($model->f_type<=-1) && ($model->club_id>0)){
        $modelName = $this->model;
        $s1='f_club_item_type='.$model->f_club_item_type;
        $s1.=' and f_club_type='.$model->f_club_type;
        $s2='club_id=0 and f_type=1 and '.$s1;
        $v2 = $modelName::model()->find($s2);
        if(!empty($v2)){
             $s2="club_id=0 and left(f_tcode,1)='".substr($v2->f_tcode,0,1)."'";
        }
        $model1 = $modelName::model()->findALL($s2);
        foreach ($model1 as $v) {
            $s2='club_id='.$model->club_id.' and '.$s1.' and f_type='.$v->f_type;
            $s2.=' and f_user_type='.$v->f_user_type;
            $v2 = $modelName::model()->find($s2);
            if(empty($v2)){
                $model2 = new $modelName();
                $model2->isNewRecord = true;
                $model2->club_id=$model->club_id; 
                $model2->f_club_item_type=$v->f_club_item_type; 
                $model2->f_club_type=$v->f_club_type;
                $model2->f_user_type=$v->f_user_type;
                
                $model2->f_type=$v->f_type;
                $model2->f_tcode=$v->f_tcode; 
                $model2->f_rcode=$v->f_rcode;
                $model2->f_rname=$v->f_rname;
                $model2->f_opter=$v->f_opter; 
                if(strlen(trim($model2->f_rcode))<=3) {
                  $model2->club_id=0; 
                }
                unset($model2->f_id);
                $model2->save();
            } else{
               $model->f_opter=$v->f_opter; 
                if(strlen(trim($model->f_rcode))<=3) {
                  $model->club_id=0; 
                }
           
               $model->save();
            }
        }
    }
       show_status($st2,'保存成功', get_cookie('_currentUrl_'),'保存失败');  
  }

    public function actionDelete($id) {
        parent::_clear($id,'','f_id');
    }
 
 
}


