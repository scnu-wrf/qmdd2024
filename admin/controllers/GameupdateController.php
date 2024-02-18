<?php

class GameupdateController extends BaseController {

    protected $model = '';
	
	public function init() {
        $this->model = substr(__CLASS__, 0, -10);
		//$this->model = 'GameListArrange';
        parent::init();
    }

    public function actionIndex($keywords = '', $type='', $pid='',$game_id=0,$data_type=0,$data_id=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'fater_id is NULL';
        $criteria->condition=get_where($criteria->condition,!empty($game_id),'game_id',$game_id,'');
        $criteria->condition=get_where($criteria->condition,!empty($data_id),'game_data_id',$data_id,'');
        if($data_type>0 && ($data_type==666 || $data_type==982)){
		 	$criteria->condition.=' AND game_data_id=0';
		}
		$criteria->condition=get_like($criteria->condition,'arrange_code,game_name',$keywords,'');//get_where
        $criteria->order = 'id DESC';
        $data = array();
        $data['data_id'] = $data_id;
		$all_num=0;
		$gamedata = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510');
		foreach ($gamedata as $n) {
			$all_num=$all_num+$n->number_of_join_now;
		}
		$data['all_num'] = $all_num;
		$data['game_data1'] = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510');
        $data['game_list1'] = GameList::model()->findAll('id='.$game_id);
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionGeturl() {
        $modelName = $this->model;
        $list =  Gameupdate::model()->findAll();;
        echo json_encode(toArray($list,'id,f_code,f_urls,f_verification'));
    }

    public function actionGetdata($data='') {
      $d_m1= explode("&",$data);
      $data=array();
      foreach($d_m1 as $s1)
       {
         $d2= explode('=',$s1);
         $data[strtoupper($d2[0])]=$d2[1];
       }
      $this->save_score_pingpeng($data);
    }
//{"FNO":"1","FGAME":"1","FTA":"CHN","FNA":"\u738b\u3000\u707f","FFA":"2","FSA":"0","FBA":"0","FTB":"DJH","FNB":"\u4e01\u4fca\u8f89","FFB":"1","FSB":"14","FBB":"14","FCH":"2","FN1":"1","FCLE":"0","FYN":"0","FNUM":"3","FPS":"0","FIS":"0","GTYPE":"1"} 

function save_score_pingpeng($data){
$nw=0;
$old_data=get_session('update_data');
 if($old_data!==$data){
    $nw=1;
    set_session('update_data',$data);
    $this->save_table_name($data);
  
  }
  $this->save_table_name($data);
  $fs=0+$data['FFA']+$data['FFB']+$data['FSA']+$data['FSB'];
  if(($nw==1) && ($fs>=1)){
       
      $update_ids=get_session('update_ids');
      if(!is_array($update_ids)){
          $update_ids=array(array('tno'=>'FNb'),array('name'=>'FNb'),array('name'=>'FNb'));
        }
      if(!($update_ids[0]['gtn']=$data['GTYPE'] && $update_ids[0]['tno']===$data['FNO'] && $update_ids[1]['name']===$data['FNA'] && $update_ids[2]['name']===$data['FNB'])){
          
              $w="star_time<=now() and game_site='".$data['FNO']." '"; 
              $w.=" and star_time>='".date("Y-m-d")."' and game_over<>908";
              $tmp0= GameListArrange::model()->findAll($w);
              $update_ids=array();
              if(!empty($tmp0)){
                   foreach($tmp0 as $tmp){
                    $gtype=($tmp->game_project_name=='乒乓球') ? 'tt' : 'bs';
                    $gtype=$data['GTYPE'];
                    $update_ids[0]=array('id'=>$tmp->id,'game_data_id'=>$tmp->game_data_id,'gt'=>$gtype,'tno'=>$data['FNO']);
                   
                    $w2='game_data_id='.$tmp->game_data_id." and left(arrange_tcode,7)='".substr($tmp->arrange_tcode,0,7)."'";
                    $w2.=" and substring(arrange_tcode,8,1)>' '";
                  //$w1=" (sign_name='".$data['FNA']."' or team_name='".$data['FNA']."')";
                    $tmp1= GameListArrange::model()->findAll($w2);
                    $nw=0;
                    foreach($tmp1 as $v){
                        $nw=$nw+1;
                        $update_ids[$nw]=array('id'=>$v->id,'game_data_id'=>$v->game_data_id,'name'=>trim($v->f_sname));
                    }
                    if($update_ids[1]['name']===$data['FNA'] && $update_ids[2]['name']===$data['FNB']){
                      set_session('update_ids',$update_ids);
                      break;
                    }
                  }
              }
      
        }
        $gtype=$update_ids[0]['gt'];
        
        $c1='A';$c2='B';
        $id1=$update_ids[1]['id'];
        $id2=$update_ids[2]['id'];
        $data['FCA']=($data['FCH']=='1' ? "1" :'0');
        $data['FCB']=($data['FCH']=='1' ? "0" :'1');
        $data['bureau']=(2*intval($data['FNUM'])-1);
        $data['bureau_num']=$data['FNUM'];//rem_time
        $data['rem_time']='';
        $data['id_0']=$update_ids[0]['id'];
        $data['IDA']=$id1;
        $data['IDB']=$id2;
        $this->set_data(0,$data,$id1,$c1);
        $this->set_data(1,$data,$id2,$c2);
        $game_over=901;//比赛中
        $this-> update_score_auto('A',$data);
        $this-> update_score_auto('B',$data);
        $this->Save_score_data($data,$game_over, $gtype);
        //$this->actionMessage($model,$_POST,$model->game_data_id,$name,'bs');
        GameListArrange::model()->sendMessage($update_ids[0]['id']);
        
    }

    echo CJSON::encode(1);
 }

//ID,局分，局小分，球权
 function save_table_name($data){
  $update_tables=get_session('update_tables');
  if(!is_array($update_tables)){
    $update_tables=array('tno'=>$data['FNO'],'namea'=>$data['FNA'],'nameb'=>'FNb','f_time'=>0);
  }
     $w1=" and f_namea='".$data['FNA']."'  and f_nameb='".$data['FNB']."' ";
     $tmp1= Gametableno::model()->find("f_date='".date("Y-m-d")."' and f_no='".$data['FNO']."' " .$w1);
     if(empty($tmp1)){
        $tmp1 = new Gametableno;
        $tmp1->isNewRecord = true;
        unset($tmp1->id); 
        $tmp1->f_no=$data['FNO'];
        $tmp1->f_date=date("Y-m-d");
        $tmp1->f_namea=$data['FNA'];
        $tmp1->f_nameb=$data['FNB'];
        $tmp1->f_time= date("Y-m-d H:i:s");
        $tmp1->save();
     $tmp1= Gametableno::model()->find("f_date='".date("Y-m-d")."' and f_no='".$data['FNO']."' " .$w1);
     $update_tables['nameb']=$data['FNB'];
     $update_tables['id']=$tmp1->id;//strtotime('now')
     $update_tables['time']=strtotime('now');
     set_session('update_tables',$update_tables);
 }
  //}
  $t1=strtotime('now');
  $t2=floor(($t1- $update_tables['time'])%86400%60);
  if(empty($t2)) $t2=20;
  if($t2-10>0){
    Gametableno::model()->updateAll(array('f_time'=> date("Y-m-d H:i:s")),'id='.$update_tables['id']);
    $update_tables['time']=$t1;
    set_session('update_tables',$update_tables);
  }
}
//ID,局分，局小分，球权$second=floor((strtotime($enddate)-strtotime($startdate))%86400%60);
 function update_score_auto($c1,$data){
    $data1=array(
        //    'sign_name'=>$data['FN'.$c1],
            'winning_bureau' => $data['FF'.$c1],
            'bureau_score' => $data['FS'.$c1],
            'single_score' => $data['FB'.$c1],
            'ball_right'=>$data['FC'.$c1],
            'uDate' => date('Y-m-d H:i:s'),
       //       'game_site'=>$data['FNO'],
        );
        GameListArrange::model()->updateAll($data1,'game_over<>908 and id='.$data['ID'.$c1]);
 }

    // 台球实时保存分数
    public function Save_score_data($data,$game_over,$ball_type){    
        $st='';$ss="";
        $this->get_show_sscore($data,$st,$ss,$ball_type);
        GameListArrange::model()->save_time_score($data,$game_over);
        GameListArrange::model()->update_vs_score($data['id_0'],$st,$ss);
       // $this->actionMessage($model,$data,$model->game_data_id,$name,$ball_type);
    }


     function get_show_sscore($data,&$show_title,&$show_score,$gtype){
        $s3='   ';
        if($gtype=='1'){
          $st=(($data['ball_right_0']=='1') ? ">>" : "  ").$s3;
          $st.=($data['ball_right_0']=='1') ? $data['single_score_0'] : $s3;
          $st.=$s3.$data['bureau_score_0'].$s3;
          $st.=$data['winning_bureau_0'].$s3;
          $st.=$s3."(" .$data['bureau']. ")".$s3;//bureau,bureau_num
          $st.=$s3.$data['winning_bureau_1'].$s3;
          $st.=$data['bureau_score_1'].$s3;
          $st.=($data['ball_right_1']=='1') ? $data['single_score_1'] : $s3;
          $st.=(($data['ball_right_1']=='1') ? "<<" : "  ");
     
        } else

        { //九球
          $st=(($data['ball_right_0']=='1') ? ">>" : "  ");
         // $st.=$data['bureau_score_0'].$s3;
          $st.=$data['winning_bureau_0'].$s3.$s3;
          $st.=$s3."(" .$data['bureau']. ")".$s3.$s3;//bureau,bureau_num
          $st.=$s3.$data['winning_bureau_1'].$s3;
       //   $st.=$data['bureau_score_1'].$s3;
          $st.=(($data['ball_right_1']=='1') ? "<<" : "  ");
        }
        $show_score=$st;
        $s3.=$s3.$s3.$s3.$s3;
        $show_title='成绩'.$s3.' vs '.$s3.'成绩';
    }
 
 

 function set_data($i,&$data,$id1,$c1){
       $data['id_'.$i]=$id1;
       $data['winning_bureau_'.$i]=$data['FF'.$c1];
       $data['bureau_score_'.$i]=$data['FS'.$c1];
       $data['single_score_'.$i]=$data['FB'.$c1];
       $data['ball_right_'.$i]=$data['FC'.$c1];    
    }

 function team_score_to_str($id,$winning_bureau,$bureau_score,$single_score,$ball_right){
     return array(
                  (($id==0) ? "rem_time" :  'id' ) => $id,
                    'ball_right'=>$ball_right,
                    'rem_time' => '',
                    'single_score' => $single_score,
                    'bureau_score' => $bureau_score,
                    'winning_bureau' => $winning_bureau,
                    'uDate' => date('Y-m-d H:i:s'),
                );
         
    }

//ID,局分，局小分，球权
 function save_score_ing($id,$winning_bureau,$bureau_score,$single_score,$ball_right,$winning_bureaub,$score_record,$game_over){
     $udata=$this->team_score_to_str(0,$winning_bureau,$bureau_score,$single_score,$ball_right);
     $tmp1=$this->find('id='.$id);
     $udata['score_record']=$score_record;
     $udata['game_over']=$game_over;
     if($game_over==908){
       $udata['game_order'] =$win;
       $udata['is_promotion']=($win=='1') ? 1006 : 1008;
       $udata['achievement_show_title'] ='获胜局          积分          GF积分';
       $this-> update_term($id,$win);
     }
     GameListArrange::model()->updateAll($udata,'game_over<>908 ad id='.$id);
   }


//ID,局分，局小分，球权
 function update_term($id,$win){
     $tmp21= GameListArrange::model()->find("id=".$id);
     $data_id=$tmp21->game_data_id;
     $w1=' game_data_id= '.$tmp21->game_data_id;
     $w1=" and upper_order=".$win." and left(arrange_tcode,7)='".substr($tmp21->arrange_tcode,0,7)."' AND upper_code<>' '";
     $tmp22= GameListArrange::model()->find($w1); //'要'
     if(!empty($tmp22)){
        $data1=array(
            'sign_id'=>$tmp21->sign_id,
            'sign_name'=>$tmp21->sign_name,
            'team_id'=>$tmp21->team_id,
            'team_name'=>$tmp21->team_name,
        );
        $d1="game_data_id=".$data_id." AND arrange_tcode='".$tmp22->upper_code."' ";
        GameListArrange::model()->updateAll($data1,$d1);
     }
 }


function saveData($model,$post) {
        $model->attributes =$post;
        if ($_POST['submitType'] == 'shenhe') {
            $model->state = 371;
        } else if ($_POST['submitType'] == 'baocun') {
            $model->state = 721;
        } else if ($_POST['submitType'] == 'tongguo') {
            $model->state = 2;
            $model->game_over = 908;
        } else if ($_POST['submitType'] == 'butongguo') {
            $model->state = 373;
        } else {
            $model->state = 721;
        }
        $st=$model->save(); 
        $this->save_sign($model->id, $post['game_play_id'],$model->state);
        show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败'); 
    }
    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }
	
  function actionSendSms($mobile,$content) {
      
        $rs= sendSms($mobile,$content); 
 
        
    }

   
}