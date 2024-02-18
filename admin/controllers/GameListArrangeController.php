<?php

class GameListArrangeController extends BaseController {

    protected $model = '';

    public function init() {
        //$this->model = 'GameListArrange';
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
 
    public function actionIndex2($keywords = '', $type='', $pid='', $star_time='', $end_time='',$game_id=0,$data_type=0,$data_id=0,$game_player=0,$arrange_index=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr= "substr(arrange_tcode,10,1)=' '";
        $cr=get_where($cr,$game_id,'game_id',$game_id,'');
        $cr=get_where($cr,$data_id,'game_data_id',$data_id,'');
        $cr=get_where($cr,$game_player,'game_player_id',$game_player,'');
        $cr=get_where($cr,($star_time!=""),'t.star_time>=',$star_time,'"');
        $cr=get_where($cr,($star_time!=""),'t.star_time<=',$end_time,'"');
		$cr=get_like($cr,'arrange_tcode,team_name',$keywords,'');//get_where
        $data = array();
        //666=团体,$data_type==982混双
        if($data_type==666 || $data_type==982){
			$criteria->condition.=' AND game_data_id=0';
        }
        if($arrange_index==7){
            $criteria->condition.=" AND substr(arrange_tcode,8,1)=' '";
            $data['arrange_index'] = 7;
        }
        if($data_id==0){
            $g_dataid = GameListData::model()->findAll('game_id='.$game_id);
            if(!empty($g_dataid)){
                $criteria->condition .= ' AND game_data_id='.$g_dataid[0]->id;
                $data_id = $g_dataid[0]->id;
            }
        }
        $data['data_id'] = $data_id;
        $criteria->order = 'arrange_tcode,rele_date_start,game_format';
    	$data['all_num'] = $this->get_game_join($game_id);
    	$data['game_data1'] = GameListData::model()->findAll('game_id='.$game_id.' AND if_del=510');
		$data['game_list1'] = GameList::model()->findAll('id='.$game_id);
        $data['arrange'] = GameListArrange::model()->findAll($criteria);
        $data['base_upper'] = BaseCode::model()->getCode(1005);
        $data['base_state'] = BaseCode::model()->getCode(899);
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionIndex1($keywords = '',$game_id=0,$name='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr=get_where('',$game_id,'game_id',$game_id,'');
        $cr=get_like($cr,'team_name,sign_name',$name,'');
        $criteria->condition=get_like($cr,'game_name,game_data_name',$keywords,'');
        $criteria->order = 'arrange_tcode';
        $data = array();
        parent::_list($model, $criteria, 'index1',$data);
    }

    public function actionGame_list_arrange($game_id,$data_id='',$project_id='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->select = "t.*,GROUP_CONCAT(t.arrange_tname) as arrange_tname";
		$criteria->condition='game_id='.$game_id;
		$criteria->condition = get_where($criteria->condition,!empty($project_id),'project_id',$project_id,'');
		$criteria->condition = get_where($criteria->condition,!empty($data_id),'game_data_id',$data_id,'');
		$criteria->condition .= " and length(arrange_tcode)=4 group by game_data_id";
        $criteria->order = 'arrange_tcode';
        $data = array();
        $data['game_id']=$game_id;
		$data['data_id'] = $data_id;
		$data['project_id'] = $project_id;
		$game=GameList::model()->find('id='.$game_id);
        $data['game_name']=$game->game_title;
		$project_list=GameListData::model()->findAll('game_id=' . $game_id .' and if_del=510 group by project_id');
		$data['project_list'] = $project_list;
        parent::_list($model, $criteria, 'game_list_arrange',$data,10);
    }

    public function actionAdd_arrange($game_id,$data_id='',$project_id='') {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
		$game=GameList::model()->find('id='.$game_id);
        $data['game_id']=$game_id;
		$data['data_id'] = $data_id;
		$data['project_id'] = $project_id;
        $data['game_name']=$game->game_title;
		$project_list=GameListData::model()->findAll('game_id=' . $game_id .' and if_del=510 group by project_id');
		$data['project_list'] = $project_list;
        if(!Yii::app()->request->isPostRequest){
            $data['model'] = $model; 
            $this->render('add_arrange', $data);
        }else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionIndex($game_id,$keywords = '',$g_id='',$gd_id='') {
      $this->show_schedule_view($keywords ,$g_id,$gd_id,$game_id,'index');
    }

    public function actionSchedule($keywords = '',$game_id='',$data_id='') {
        $this->show_schedule_view($keywords ,$game_id,$data_id,'schedule',0);
    }
    
    public function actionList($keywords='',$game_id=0,$data_id=0,$submitType='',$check_team='0',$arrange_tcode='') {
        set_session('delete','1');
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $game_id = empty($game_id) ? 0 : $game_id;
        $data_id = empty($data_id) ? 0 : $data_id;
        $cps= get_where_club_project('club_id','');
        $criteria->condition = $cps.'  and game_data_id='.$data_id.' and ';
        $criteria->condition .= ($check_team=='on') ? '' : ' substr(arrange_tcode,8,1)=" " and ';
        $criteria->condition .= ($game_id==0) ? 'state=-1 ' : 'state>=0';
        if(!empty($keywords)){
            $key_count = strlen($keywords);
            $criteria->condition .= ' and left(arrange_tcode,'.$key_count.')="'.$keywords.'"';
        }
        if($arrange_tcode!='all'){
            $arr_list = $model->findAll($cps.' and game_id='.$game_id.' and game_data_id='.$data_id.' and length(arrange_tcode)=4');
            if(!empty($arr_list)){
                $arrange_tcode = empty($arrange_tcode) ? $arr_list[0]->arrange_tcode : $arrange_tcode;
                $criteria->condition .= ' and left(arrange_tcode,4)="'.$arrange_tcode.'"';
            }
        }
        $criteria->order = 'game_data_id,arrange_tcode';
        $data = array();
        $data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149  ');//  and game_time_end>now() and dispay_end_time>now()and datediff(now(),game_time_end)<=7
        //$counts = $model->count($criteria);
        parent::_list($model, $criteria,'list',$data,5000);
    }

    public function actionArrangeAdd($game_id='',$data_id='',$ln) {
        $s1=Yii::app()->request->url;
        $s2=get_session('delete');
        $modelName = $this->model;
        $model = $modelName::model();
        $model->add_new_arrange($game_id,$data_id);
        $this->show_schedule_view('',$game_id,$data_id,'list','0');
    }
    
    public function actionGroupAdd(){
        $modelName = $this->model;
        $model = $modelName::model();
        $gr_id=$_POST['gr_id'];
        $g_id=$_POST['game_id'];
        $gd_id=$_POST['data_id'];
        $r = 0;
        for($i=0;$i<50;$i++){
            if(isset($_POST['gformat_'.$i]) && !empty($_POST['gformat_'.$i])){
                $group_code = $_POST['group_code_'.$i];  // 组编码
                $group_name = $_POST['group_name_'.$i];  // 组名称
                $gformat = $_POST['gformat_'.$i];  // 赛制
                $game_mode = $_POST['game_mode_'.$i];  // 对阵方式
                $group_peop = '';
                if(($_POST['gformat_'.$i]==985 || $_POST['gformat_'.$i]==988) && $_POST['game_mode_'.$i]==662){
                    $group_len = $_POST['group_len_'.$i];  // 参赛人数/队数
                }
                else{
                    $group_len = $_POST['group_total_site_'.$i];  // 每场总人数/队数
                    $group_peop = $_POST['group_total_peop_'.$i];  // 总场次
                }
                $model->add_new_group($gr_id,$group_code,$group_name,$group_len,$gformat,$game_mode,$group_peop);
                $r++;
            }
        }
        // set_session('delete','1');
        show_status($r, '保存成功',Yii::app()->request->urlReferrer,'保存失败');
    }

    public function show_schedule_view($keywords = '',$game_id='',$data_id='',$viewfile,$ch='0') {
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr= get_where_club_project('club_id','').' and ';
        $cr.= ($game_id==0) ? 'state=-1 ' : 'state>=0';
        $cr.= ($ch=='on') ? '' : " and substr(arrange_tcode,8,1)=' '";
        $cr=get_where($cr,$game_id,'game_id',$game_id,'');
        $cr=get_where($cr,$data_id,'game_data_id',$data_id,'');
        $criteria->condition=get_like($cr,'game_name,game_data_name',$keywords,'');
        $criteria->order = 'game_data_id,arrange_tcode';
        $data = array();
		// $data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and datediff(now(),game_time_end)<60');
		$data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and state=2 and dispay_end_time>now()');
        parent::_list($model, $criteria,$viewfile,$data,50);
    }

    function get_game_join($game_id){
        $gamedata=GameListData::model()->findAll(array('select'=>'sum(number_of_join_now) as weight','condition'=>'game_id='.$game_id));
        $rs = 0;
        if(!empty($gamedata)) {
            $rs =$gamedata[0]->weight;
        }
        return $rs; 
    }

    public function actionGameArrange($data_id,$game_id,$team){
        $modelName = $this->model;
        $model = $modelName::model();
        $arrange = new GameListArrange();
        for($i=1;$i<=100;$i++){
            if(isset($_POST["arrange_tab".$i])){
               if($team==665){
                    $arr=array('sign_id'=>$_POST["arrange_sign_id".$i],
                        'sign_name'=>$_POST["arrange_tname".$i],
                        'sign_logo'=>$_POST["arrange_logo".$i],
                    );
                }
                else{
                    $arr=array('team_id'=>$_POST["arrange_team_id".$i],
                        'team_name'=>$_POST["arrange_tname".$i],
                        'team_logo'=>$_POST["arrange_logo".$i],
                    );
                }
                // $arrange->updateAll($arr,"arrange_tcode='".$_POST["arrange_tcode".$i]."' AND game_data_id='".$data_id."' AND game_id='".$game_id."'");
                $arrange->updateAll($arr,"arrange_tname='".$_POST["arrange_tab".$i]."' AND game_data_id='".$data_id."' AND game_id='".$game_id."'");
            }
        }
        ajax_status(1, '保存成功',Yii::app()->request->urlReferrer);
    }

    public function actionGameArrangeProm($data_id,$game_id){
        $modelName = $this->model;
        $model = $modelName::model();
        $arrange = new GameListArrange();
        $arrange->updateAll(array(
                    'team_id'=>0,'team_name'=>'', 'sign_id'=>0,'sign_name'=>'',
                ),"substr(arrange_tcode,8,1)=' ' AND game_data_id='".$data_id."' AND game_id='".$game_id."'");
        for($j=1;$j<=1000;$j++){
            if(isset($_POST["arrange_code_id".$j])){
                $arrange->updateAll(array(
                    'upper_order'=>$_POST["arrange_order".$j],
                    'upper_code'=>$_POST["arrange_upper".$j],
                ),"id='".$_POST["arrange_code_id".$j]."' AND game_data_id='".$data_id."' AND game_id='".$game_id."'");
            }  else { $j=100000;}
        }
        ajax_status(1, '保存成功',Yii::app()->request->urlReferrer);
    }

    public function actionGameGroupProm($data_id,$game_id){
        $arrange = new GameListArrange();
        for($j=1;$j<=1000;$j++){
            if(isset($_POST["group_prom_upper".$j])){
                $arrange->updateAll(array(
                    'upper_order'=>$_POST["group_prom_tcode".$j],
                    'upper_code'=>$_POST["group_prom_upper".$j],
                ),"id='".$_POST["group_prom_id".$j]."' AND game_data_id='".$data_id."' AND game_id='".$game_id."'");
            } else { $j=100000;}
        }
        ajax_status(1, '保存成功',Yii::app()->request->urlReferrer);
    }

    /* 没有引用，先注释 */
    // public function actionGameArrangeOrder($data_id,$game_id,$team){
    //     $modelName = $this->model;
    //     $model = $modelName::model();
    //     $arrange = new GameListArrange();
    //     $len=$_POST["code"]; 
    //     $row=$_POST["row"];
    //     $group=($len<5) ? "total" : "group";
    //     $team_name = 0;
    //     for($k=1;$k<=$row;$k++){
    //         $tcode=$_POST["grou_tcode".$k];
    //         $tscore=$_POST[$group."_score".$k];
    //         $tmark=$_POST[$group."_score_mark".$k];
    //         $torder=$_POST[$group."_score_order".$k];
    //         $team_id=$_POST["grou_team_id".$k];
    //         $team_name=$_POST["grou_team_name".$k];
    //         if(empty($team_id)){
    //             $team_id=0;
    //         }
    //         if(empty($tmark)){
    //             $tmark=0;
    //         }
    //         $gr=GameListArrange::model()->find("game_data_id=".$data_id." AND arrange_tcode='".substr($tcode,0,4)."'");
    //         $cd=0;
    //         if(!empty($gr)){
    //             $cd=$gr->game_format; //赛制
    //         }
    //         if($len<=5){//总成绩
    //             $data=array(
    //                 $group."_score_mark"=>$tmark,
    //                 $group."_score_order"=>$torder,
    //                 $group."_score"=>$tscore,
    //             );
    //             $w1=(($team==665) ?"sign_id" :"team_id").'='.$team_id;
    //             $w1.=(($len==5) ? " and game_data_id=".$data_id : "")." and game_id=".$game_id;
    //         }
    //         else if($len==7){  //场次
    //             $data=array(
    //                 'game_order'=>$torder,
    //                 'game_score'=>$tscore,
    //                 'game_mark'=>$tmark,
    //                 'is_promotion'=>$_POST["option_is_promotion".$k],
    //                 'game_over'=>$_POST["option_game_over1"],
    //             );
    //             $w1="id=".$_POST["grou_id".$k];
    //         }
    //         $arrange->updateAll($data, $w1);
    //         $tmp=GameListArrange::model()->find($w1);
    //         $tcode1= substr($tcode,0,$len);
    //         if(!empty($tmp)){
    //             $w1="game_data_id=".$data_id." and ".(($team==665) ? "sign_ida" : "team_ida").'='.$team_id;
    //             $w1.=" and arrange_tcode='".$tcode1."'"; //修改小组成绩或对成绩
    //             $w1.=" and arrange_id=".$tmp->id;
    //             $this->save_order($game_id,$data_id,$torder,$tmark,$tscore,$tcode1,$len,$w1,$tmp);
    //         }

    //         if($len>=5) {
    //             if(($cd==988 && $len==5) || ($cd==985 && $len==7)){
    //                 $this->actionGameGroupOrder($game_id,$data_id,$team,$tcode,$torder,$tmark,$tscore,$team_name,$team_id,$len);
    //             }
    //         }
    //     }
    //     ajax_status(1, '保存成功',Yii::app()->request->urlReferrer);
    // }

    function save_order($game_id,$data_id,$torder,$tmark,$tscore,$tcode1,$len,$w1,$tmp,$km=0){
        $gameorder=GameListOrder::model()->find($w1);//查找
        if(empty($gameorder)){
            $gameorder = new GameListOrder();
            $gameorder->isNewRecord = true;
        }
        if($len<=5){
            $gameorder->game_integral_score =$tscore;
        }
        if($km==1){
            $gameorder->game_top_score =$tscore;
        }
        $gameorder->game_id = $game_id;
        $gameorder->game_data_id = $data_id;
        $gameorder->arrange_id =$tmp->id;//场次比赛赛
        $gameorder->arrange_tcode = $tcode1;//场次比赛赛
        $gameorder->game_score = $tmark;
        $gameorder->game_rank =$torder;
        $gameorder->state = 2;
        $gameorder->sign_ida =$tmp->sign_id;
        $gameorder->gf_namea =$tmp->sign_name;
        $gameorder->team_ida = $tmp->team_id;
        $gameorder->team_name =$tmp->team_name;
        $gameorder->is_promotion =$tmp->is_promotion;
        $gameorder->save();
    }

    /**
     * 晋级处理.
     * $game_id ：赛事id.
     * 
     * $data_id ：竞赛项目id
     * 
     * $team ：参赛方式 个人、团队、双人、混双
     * 
     * $tcode ： arrange_tcode
     * 
     * $score_order ： 晋级名次 upper_order || game_order
     * 
     * $score_mark ：　本场比赛成绩记录　game_mark
     * 
     * $group_score　：　本场比赛得分　game_score
     * 
     * $team_name　：　参赛成员　||　团队 名称
     * 
     * $team_id　：　参赛成员　||　团队　id
     * 
     * $len ： 本场次编码长度
     * 
     * $game_format ： 赛制  985=淘汰赛 988=循环赛
     */
    public function actionGameGroupOrder($game_id,$data_id,$team,$tcode,$score_order,$score_mark,$group_score,$len,$game_format){
        $ln=strlen($tcode);
        $w1='game_data_id='.$data_id." AND left(arrange_tcode,".$len.")='".substr($tcode,0,$len)."' and length(arrange_tcode)=9 and upper_order=".$score_order;
        $is_upcode = ($game_format==985) ? ' and (upper_code<>" " or total_upper_order<>" ")' : '';
        $arrange = GameListArrange::model()->find($w1.$is_upcode);
        if(!empty($arrange)){
            $is_gorder = ' and left(arrange_tcode,'.$len.')="'.substr($tcode,0,$len).'" and game_order='.$score_order;
            $gw = 'game_data_id='.$data_id;
            $upper_tname = GameListArrange::model()->find($gw.$is_gorder);

            $tid = ($team==665) ? 'sign_id' : 'team_id';
            $tname = ($team==665) ? 'sign_name' : 'team_name';
            $tlogo = ($team==665) ? 'sign_logo' : 'team_logo';
            if(!empty($upper_tname)){
                if($game_format==985){
                    $data1=array(
                        'f_sname' => $upper_tname->f_sname,
                        $tid => $upper_tname->$tid,
                        $tname => $upper_tname->$tname,
                        $tlogo => $upper_tname->$tlogo,
                    );
                    GameListArrange::model()->updateAll(array('upper_order_user' => $score_order,'upper_code_user' => $arrange->upper_code),$gw.$is_gorder);
                    GameListArrange::model()->updateAll($data1,'game_data_id='.$data_id." and arrange_tcode='".$arrange->upper_code."'");
                    $arrange->updateByPk($arrange->id,array('actual_total_upper_order'=>$upper_tname->total_upper_order));
                }
            }
        }
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if(!Yii::app()->request->isPostRequest){
            $data['model'] = $model; 
            $this->render('update', $data);
        }else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if(!Yii::app()->request->isPostRequest){
            $data['model'] = $model;
            $this->render('update', $data);
        }else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }
    
    public function actionCopy($id) {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
			if($id!=0) {
				$data['model'] = $model->find('id='.$id);
			} else {
				$data['model'] = $model;
			}
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }
    
    function saveData($model,$post) {
        $model->attributes = $post;
        if ($_POST['submitType'] == 'baocun') {
            $model->state = 2;
        }
        $len=strlen($model->arrange_tcode);
        $game_format=GameListArrange::model()->find("game_data_id=".$model->game_data_id." AND arrange_tcode='".substr($model->arrange_tcode,0,4)."'");
        if($len==7 && !empty($game_format->game_format)){
            $model->game_format=$game_format->game_format;
        }
        $st=$model->save();
        $player_id=($model->game_player_id==665) ? $model->sign_id : $model->team_id;
        $this->save_sign($model->id, $post['game_play_id'],$model->state,$model->game_id,$model->game_data_id,$player_id);
        show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }
    
    public function actionDelete($id) {
        // set_session('delete','1');
        $modelName = $this->model;
        $count = 0;
        $ex = explode(',',$id);
        foreach($ex as $d){
            $model = $this->loadModel($d, $modelName);
            if(!empty($model)){
                $len = strlen($model->arrange_tcode);
                $modelName::model()->deleteAll('game_data_id='.$model->game_data_id.' and left(arrange_tcode,'.$len.')="'.$model->arrange_tcode.'"');
                $model->deleteAll('id='.$d);
                $count++;
            }
        }
        if($count > 0){
            ajax_status(1, '删除成功', Yii::app()->request->urlReferrer);
        }else{
            ajax_status(0, '删除失败');
        }
        // parent::_clear($id);
    }

    /* index引用，但index页面未使用，先注释 */
    // public function actionGetgroupscore($data_id,$game_id,$game_code,$team=''){
    //     $ln=strlen($game_code);
    //     $s1='game_data_id='.$data_id." AND left(arrange_tcode,".$ln.")='".$game_code."'".' AND fater_id is null';
    //     $s1.=" and substr(arrange_tcode,9,1)<>' ' and substr(arrange_tcode,10,1)=' '";
    //     $rou1=array('order'=>'arrange_tname','group'=>'arrange_tname','condition'=>$s1,);
  
    //     if($ln==2){

    //         $rou1=array(
    //                 'order'=>'rounds DESC,total_score_order',
    //                 'select'=>'team_name,team_id,arrange_tcode,total_score,total_score_mark,total_score_order,count(team_name) rounds',
    //                 'group'=>'team_name',
    //                 'condition'=>$s1." and team_name<>' '",
    //         );
    //         if($team==665){

    //             $rou1=array(
    //                 'order'=>'rounds DESC,total_score_order',
    //                 'select'=>'sign_name,sign_id,arrange_tcode,total_score,total_score_mark,total_score_order,count(sign_name) rounds',
    //                 'group'=>'sign_name',
    //                 'condition'=>$s1." and sign_name<>' '",
    //           );
    //         }
    //     }
    //     $rou=GameListArrange::model()->findAll($rou1);
    //     echo CJSON::encode($rou);
    // }

    public function save_sign($id,$game_play_id,$state,$game_id,$game_data_id,$player_id){
        $gameorder=GameListArrange::model()->findAll('fater_id='.$id);
	    $arr=array();
        if(!empty($_POST['team_data'])){
            foreach($_POST['team_data'] as $v){
                if($v['t_s_id'] == ''){
                    continue;
                }
                if($v['id']=='null'){
                    $all_ange = new GameListArrange();
                    $all_ange->isNewRecord = true;
                    unset($all_ange->id);
                    $all_ange->game_id = $game_id;
                    $all_ange->game_data_id = $game_data_id;
                    $all_ange->game_player_id = $game_play_id;
                    $all_ange->fater_id = $id;
                    $all_ange->state = $state;
                    $all_ange->arrange_tcode = $v['t_no'];
                    $all_ange->arrange_tname = $player_id;
                    $all_ange->colour = $v['colour'];
                    $all_ange->runway = $v['runway'];
                    $all_ange->sign_id = $v['t_s_id'];
                    $all_ange->sign_name = $v['t_s_name'];
                    $all_ange->save();
                }
                else{
                    $all_ange = new GameListArrange();
                        $all_ange->updateByPk($v['id'],array(
                            'arrange_tcode' => $v['t_no'],
                            'sign_id' => $v['t_s_id'],
                            'sign_name' => $v['t_s_name'],
                            'colour' => $v['colour'],
                            'runway' => $v['runway']
                        ));
                        $arr[]=$v['id'];
                
                }
            }
        }
        if(isset($gameorder)){
            foreach($gameorder as $k){
                if(!in_array($k->id,$arr)){
                    GameListArrange::model()->deleteAll('fater_id='.$k->id);
                }
            }
        }
    }
    public function actionGame_group($game_id,$data_id,$code,$length){
        $l=$length==5?4:5;
        $data = GameListArrange::model()->findAll('game_id='.$game_id.' and game_data_id='.$data_id.' and LEFT(arrange_tcode,'.$l.')="'.$code.'" and length(arrange_tcode)='.$length.'');
        echo CJSON::encode($data);
    }
    
    public function actionGet_register($id,$ck){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $model->game_score=$model->game_score+(($ck==1) ? 1 : -1);
        $sn=$model->save();
        show_status($sn,'登记成功',Yii::app()->request->urlReferrer,'失败');
    }

    // 查询晋级方向,数量查询、是否有编码
    public function actionUpper_code($id,$code){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if(!empty($model->game_data_id)){
            if(strlen($code)==5){  //  && ($model->game_mode==662 && $model->game_format==988) || ($model->game_mode==663 && $model->game_format==985)
                $str = GameListArrange::model()->findAll(
                    'game_data_id='.$model->game_data_id.
                    ' and game_mode='.$model->game_mode.
                    ' and game_format='.$model->game_format.
                    ' and left(arrange_tcode,5)="'.$code.'" and length(arrange_tcode)=9 group by arrange_tname order by upper_order,arrange_tcode'
                );
    
            }
            elseif(strlen($code)==7){  //  && $model->game_mode==662 && $model->game_format==985
                $str = GameListArrange::model()->findAll(
                    'game_data_id='.$model->game_data_id.
                    ' and game_mode='.$model->game_mode.
                    ' and game_format='.$model->game_format.
                    ' and (left(arrange_tcode,5)="'.$code. '" OR left(arrange_tcode,7)="'.$code.'") and length(arrange_tcode)=9 group by arrange_tname order by upper_order'
                );
            }
            if(!empty($str)){
                $data = array();
                foreach($str as $key => $val){
                    $model1 = $modelName::model()->find("arrange_tcode='".$val->upper_code."' and game_data_id=".$model->game_data_id);
                    $data[$key]['id'] = $val->id;
                    $data[$key]['upper_order'] = $val->upper_order;
                    $data[$key]['upper_code'] = $val->upper_code;
                    $data[$key]['total_order'] = $val->total_upper_order;
                    if(!empty($model1)){
                        $data[$key]['arrange_tname'] = $model1->arrange_tname;
                    }
                }
                echo CJSON::encode($data);
            }
        }
    }

    // 保存晋级方向
    public function actionGame_order($id){
        $modelName = $this->model;
        $k = 0;
        for($i=0;$i<50;$i++){
            if(isset($_POST['id_'.$i])){
                $torder = ($_POST['total_code'.$i]=='') ? 0 : $_POST['total_code'.$i];
                $data = array(
                    'upper_order'=>$_POST['upper_no'.$i],
                    'upper_code'=>$_POST['upp_code'.$i],
                    'total_upper_order'=>$torder,
                );
                $modelName::model()->updateByPk($_POST['id_'.$i],$data);
            }
            $k = 1;
        }
        show_status($k,'保存成功',Yii::app()->request->urlReferrer,'保存失败');
    }

    // 签号录入   
    public function actionSignnumber($game_id='',$data_id=''){
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$game_id = empty($game_id) ? 0 : $game_id;
        $data_id = empty($data_id) ? 0 : $data_id;
        $data1 = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510');
        $data_id = (!empty($data1) && empty($data_id)) ? $data1[0]->id : $data_id;
        $criteria->condition = 'game_id='.$game_id.' and game_data_id='.$data_id.' and length(arrange_tcode)=9';
        if(!empty($data1) && $data1[0]->game_player_team==666){
            $criteria->group = 'left(arrange_tname,3)';
            // $criteria->select = '*,substr(arrange_tcode,1,7)';
        }
        $criteria->order = 'arrange_tcode,arrange_tname';
        $len = $model->count($criteria);
        $data = array();
        $data['data_id'] = $data_id;
        $data['arr_data1'] = $model->findAll('game_id='.$game_id.' and game_data_id='.$data_id.' and game_format=988 and length(arrange_tcode)=9 group by left(arrange_tname,3) order by arrange_tcode');
        $data['arr_data2'] = $model->findAll('game_id='.$game_id.' and game_data_id='.$data_id.' and game_format=985 and length(arrange_tcode)=9 order by arrange_tcode');
        $data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and datediff(now(),game_time_end)<=7');
    	$data['game_data1'] = GameListData::model()->findAll('game_id='.$game_id.' AND if_del=510');
        parent::_list($model, $criteria, 'signnumber', $data, $len);
    }

    // 签号输入框失焦保存
    public function actionSaveSign($data_id,$arrange_tcode){
        $modelName = $this->model;
        $model = $modelName::model()->find('game_data_id='.$data_id.' and left(arrange_tcode,4)="'.$arrange_tcode.'" and arrange_tname="'.$_POST['this_val'].'"');
        $sv = 0;
        if(!empty($model)){
            $tid = ($model->game_player_id==665) ? 'sign_id' : 'team_id';
            $tname = ($model->game_player_id==665) ? 'sign_name' : 'team_name';
            $logo = ($model->game_player_id==665) ? 'sign_logo' : 'team_logo';
            $slogo = '';
            if($model->game_player_id==665){
                $sid = GameSignList::model()->find('id='.$_POST["id"]);
            }
            else{
                $sid = GameTeamTable::model()->find('id='.$_POST["id"]);
            }
            if(!empty($sid)){
                $slogo = ($model->game_player_id==665) ? $sid->sign_head_pic : $sid->logo;
            }
            $sv = $model->updateAll(
                array(
                    $tid=>$_POST["id"],
                    $tname=>$_POST["gfname"],
                    $logo=>$slogo
                )
                ,'game_data_id='.$model->game_data_id.' and left(arrange_tcode,5)="'.substr($model->arrange_tcode,0,5).'" and arrange_tname="'.$model->arrange_tname.'"'
            );
        }
        $txt = ($sv==0) ? '没有这个签号或已有签号' : '成功';
        ajax_status($sv,$txt);
    }

    // 查询竞赛项目
    public function actionData_id($game_id){
		$data = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510');
		$row = array();
		if(!empty($data)){
			foreach($data as $d => $val){
				// array_push($row,[$d->id,$d->game_data_name]);
				$row[$d]['id'] = $val->id;
				$row[$d]['game_data_name'] = $val->game_data_name;
			}
		}
        echo CJSON::encode($row);
    }
    
    // 查询签号归属数量与数据    
    public function actionSignnum($id){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $arr = array();
        if(!empty($model)){
            $arrange = GameListArrange::model()->findAll('game_data_id='.$model->game_data_id.' and left(arrange_tcode,5)="'.$model->arrange_tcode.'" and length(arrange_tcode)=9 group by arrange_tname');
            if(!empty($arrange)){
                foreach($arrange as $v => $val){
                    $arr[$v]['id'] = $val->id;
                    $arr[$v]['game_id'] = $val->game_id;
                    $arr[$v]['game_data_id'] = $val->game_data_id;
                    $arr[$v]['arrange_tcode'] = $val->arrange_tcode;
                    $arr[$v]['arrange_tname'] = $val->arrange_tname;
                    $arr[$v]['game_player_id'] = $val->game_player_id;
                    if($model->game_player_id==665){
                        $arr[$v]['s_id'] = $val->sign_id;
                        $arr[$v]['s_name'] = $val->sign_name;
                        $arr[$v]['s_logo'] = $val->sign_logo;
                    }
                    else{
                        $arr[$v]['s_id'] = $val->team_id;
                        $arr[$v]['s_name'] = $val->team_name;
                        $arr[$v]['s_logo'] = $val->team_logo;
                    }
                }
                echo CJSON::encode($arr);
            }
        }
    }

    // 保存签号   
     public function actionGame_signnum($id){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $arrange1 = GameListArrange::model()->findAll('game_id='.$model->game_id.' and game_data_id='.$model->game_data_id.' and left(arrange_tcode,5)="'.$model->arrange_tcode.'" and length(arrange_tcode)=9 group by arrange_tname');
        $sum = count($arrange1);
        $p_id = ($model->game_player_id==665) ? 'sign_id' : 'team_id';
        $p_na = ($model->game_player_id==665) ? 'sign_name' : 'team_name';
        $p_lg = ($model->game_player_id==665) ? 'sign_logo' : 'team_logo';
        $j = 0;
        $arr = new GameListArrange;
        for($i=0;$i<$sum;$i++){
            if(isset($_POST['t_name'.$i])){
                $arr->updateAll(array(
                    $p_id => $_POST['sign_id'.$i],
                    $p_na => $_POST['sign_name'.$i],
                    $p_lg => $_POST['team_logo'.$i],
                ),'id='.$_POST['sid'.$i]);
            }
            $j++;
        }
        $k = ($j==0) ? 0 : 1;
        show_status($k,'保存成功',Yii::app()->request->urlReferrer,'保存失败');
    }

    // 赛程保存地址与时间
    public function actionSaveSiteTime(){
        $form = $_POST['form'];
        $filed = $_POST['filed'];
        $colid = $_POST['colid'];
        $arrid = $_POST['arrid'];
        $star_time_ten = $_POST['star_time_ten'];
        $modelName = $this->model;
        $model = $this->loadModel($arrid, $modelName);
        $star_time = empty(substr($model->star_time,0,10)) ? '0000-00-00' : substr($model->star_time,0,10);
        $form = ($filed=='star_time_ten') ? $star_time.' '.$form : $form;
        $form = ($filed=='star_time') ? $form.' '.$star_time_ten : $form;
        $filed = ($filed=='star_time_ten') ? "star_time" : $filed;
        $modelName::model()->updateAll(array($filed=>$form),'game_data_id='.$model->game_data_id.' and left(arrange_tcode,7)="'.substr($model->arrange_tcode,0,7).'"');
        echo 1;
    }
    
    // 赛程是否发布与发布时间
    public function actionShowdate($game_id='',$data_id=''){
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$game_id = empty($game_id) ? 0 : $game_id;
        $data_id = empty($data_id) ? 0 : $data_id;
        $criteria->condition = 'length(arrange_tcode)=4';
        $criteria->condition .= ' and game_id='.$game_id.' and game_data_id='.$data_id;
        $data = array();
		$data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and datediff(now(),game_time_end)<=7');
        parent::_list($model,$criteria,'showdate',$data);
    }

    // 保存是否发布字段
    public function actionrele($id,$if_rele){
        $modelName = $this->model;
        $model = $this->loadModel($id,$modelName);
        $rele = ($if_rele==1) ? 649 : 648;
        $data = array('if_rele'=>$rele);
        $model->updateAll($data,'id='.$id);
        $arr = GameListArrange::model()->find('id='.$id);
        if(!empty($arr->game_data_id)){
            $arr->updateAll($data,'game_data_id='.$arr->game_data_id.' and left(arrange_tcode,4)="'.$arr->arrange_tcode.'"');
        }
    }
    
    // 保存赛程发布时间
    public function actionSaveReleTime($length){
        $arr = new GameListArrange;
        for($i=1;$i<=$length;$i++){
            if(isset($_POST['rele_date_start_'.$i])){
                $data = array('rele_date_start' => $_POST['rele_date_start_'.$i]);
                $id = GameListArrange::model()->find('id='.$_POST['arr_id_'.$i]);
                if(!empty($id->game_data_id)){
                    $arr->updateAll($data,'game_data_id='.$id->game_data_id.' and left(arrange_tcode,4)="'.$id->arrange_tcode.'"');
                }
                // $arr->updateAll($data,'id='.$_POST['arr_id_'.$i]);
            }
        }
        echo CJSON::encode(1);
    }

	// 赛事历史记录赛程列表
	public function actionIndex_history($keywords='',$game_id='',$data_id=''){
		set_cookie('_currentUrl_',Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		$game_id = empty($game_id) ? 0 : $game_id;
		$criteria->condition = 'game_id='.$game_id;
		$criteria->condition = get_where($criteria->condition,!empty($data_id),'game_data_id',$data_id,'');
		$criteria->condition = get_like($criteria->condition,'arrange_tcode,arrange_tname',$keywords,'');
		$data = array();
		$data['data_list'] = GameListData::model()->findAll('game_id='.$game_id);
		parent::_list($model,$criteria,'index_history',$data);
    }
    
    // 赛事成绩录入列表
    public function actionIndex_results($kewords='',$game_id='',$data_id='',$check_box=9){
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$game_id = empty($game_id) ? 0 : $game_id;
        $data_id = empty($data_id) ? 0 : $data_id;
   
        $num = ($check_box==9) ? 7 : 5;
        $sym = ($check_box==9) ? '=' : '>=';
        $act = ($check_box==9) ? '' : ' and length(t.arrange_tcode)=9';
        $group = ($check_box==9) ? 'left(t.arrange_tcode,'.$num.'),t.game_order' : 'left(t.arrange_tcode,'.$num.'),left(a.arrange_tcode,'.$num.'),t.group_score_order';
        $order = ($check_box==9) ? 't.arrange_tcode,t.game_order' : 'arrange_tcode,group_score_order';
        $cond = 't.game_id='.$game_id.' and t.game_data_id='.$data_id.' and length(t.arrange_tcode)'.$sym.$check_box.$act;
        $criteria->select = '*';
        $criteria->join = 'left join game_list_arrange a ON t.id=a.id and left(t.arrange_tcode,'.$num.')=left(a.arrange_tcode,'.$num.') and t.game_order<=a.game_order';
        $criteria->condition = $cond;
        $criteria->group = $group;
        $len = $model->count($cond);
        $data = array();
		$data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and game_state<>149 and datediff(now(),game_time_end)<=7');
        parent::_list($model,$criteria,'index_results',$data,$len);
    }

    // 单场成绩
    public function actionIndex_results1($game_id='',$game_data_id='',$matches_val=1,$star_time='',$end_time='',$arrange_tcode=''){
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $game_id = empty($game_id) ? 0 : $game_id;
        $game_data_id = empty($game_data_id) ? 0 : $game_data_id;
        $data1 = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510');
        $game_data_id = (!empty($data1) && empty($game_data_id)) ? $data1[0]->id : $game_data_id;
        $over = ($matches_val==1) ? '' : ' and game_over<>908';
        $star_time = empty($star_time) ? date('Y-m-d') : $star_time;
        $end_time = empty($end_time) ? date('Y-m-d') : $end_time;
        $criteria->condition = 'length(arrange_tcode)=7 and game_id='.$game_id. ' and game_data_id='.$game_data_id.$over;
        $criteria->condition = get_where($criteria->condition,$star_time,'left(star_time,10)>=',$star_time,'"');
        $criteria->condition = get_where($criteria->condition,$end_time,'left(star_time,10)<=',$end_time,'"');
        $arr_list = $model->findAll(get_where_club_project('club_id').' and game_id='.$game_id.' and game_data_id='.$game_data_id.' and length(arrange_tcode)=4');
        if(!empty($arr_list)){
            $arrange_tcode = empty($arrange_tcode) ? $arr_list[0]->arrange_tcode : $arrange_tcode;
            $criteria->condition .= ' and left(arrange_tcode,4)="'.$arrange_tcode.'"';
        }
        // $criteria->order = 'find_in_set(908,game_over),star_time';
        $criteria->order = 'field(game_over,"901","900","908"),star_time';
        $data = array();
        // $len = $model->count($criteria);
        $data['data_id'] = $game_data_id;
        $data['game_data_id'] = $game_data_id;
        $data['matches_val'] = $matches_val;
        $data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and datediff(now(),game_time_end)<=7');  //  and game_state<>149
    	$data['game_data1'] = $data1; 
        $data['filename'] = '';
        $data['page_name'] = '';
        $data['star_time'] = $star_time;
        $data['end_time'] = $end_time;
        $path = 'index_results1';
        if(!empty($game_data_id)){
            $page_name = 'obj_';
            $proj_data_id = GameListData::model()->find('id='.$game_data_id);
            if(!empty($proj_data_id)){
                $page = ProjectList::model()->find('id='.$proj_data_id->project_id);
                if(!empty($page)){
                    $page_name .= $page->CODE;
                }
            }
            $page_name = strtolower($page_name);
            $filename = $_SERVER['DOCUMENT_ROOT'].'/'.Yii::app()->request->baseUrl.'/admin/views/gameListArrange/'.$page_name.'.php';
            if(!file_exists($filename)){
                $path = 'index_results2';
            }
            $data['page_name'] = $page_name;
            $data['filename'] = $filename;
        }
     if($path=='index_results2'){
            $this->actionIndex_results2($game_id,$game_data_id,$matches_val,$star_time,$end_time,$arrange_tcode);
            return false;
        }        parent::_list($model,$criteria,$path,$data);
    }

    // 单场赛事成绩
    public function actionIndex_results2($game_id='',$game_data_id='',$matches_val=1,$star_time='',$end_time='',$arrange_tcode=''){
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $game_id = empty($game_id) ? 0 : $game_id;
        $game_data_id = empty($game_data_id) ? 0 : $game_data_id;
        $data1 = GameListData::model()->findAll('game_id='.$game_id.' AND if_del=510');
        $game_data_id = (!empty($data1) && empty($game_data_id)) ? $data1[0]->id : $game_data_id;
        $criteria->condition = 'length(arrange_tcode)=7 and game_id='.$game_id.' and game_data_id='.$game_data_id;
        $criteria->condition = get_where($criteria->condition,!empty($star_time),'left(star_time,10)>=',$star_time,'"');
        $criteria->condition = get_where($criteria->condition,!empty($end_time),'left(end_time,10)<=',$end_time,'"');
        $arr_list = $model->findAll(get_where_club_project('club_id').' and game_id='.$game_id.' and game_data_id='.$game_data_id.' and length(arrange_tcode)=4');
        if(!empty($arr_list)){
            $arrange_tcode = empty($arrange_tcode) ? $arr_list[0]->arrange_tcode : $arrange_tcode;
            $criteria->condition .= ' and left(arrange_tcode,4)="'.$arrange_tcode.'"';
        }
        $criteria->order = 'arrange_tcode,star_time';
        $data = array();
        $data['matches_val'] = $matches_val;
        $data['game_data_id'] = $game_data_id;
        $data['arrange_tcode'] = $arrange_tcode;
        $data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and datediff(now(),game_time_end)<=7');  // and game_state<>149 
    	$data['game_data1'] = $data1;
        // $len = $model->count($criteria);
        parent::_list($model,$criteria,'index_results2',$data);
    }

// 单场成绩
    public function actionIndexvs($game_id='',$data_id='',$matches_val=1,$star_time='',$end_time='',$arrange_tcode=''){
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $game_data_id=$data_id;
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $game_id = empty($game_id) ? 0 : $game_id;
        $game_data_id = empty($game_data_id) ? 0 : $game_data_id;
        $data1 = GameListData::model()->findAll('game_id='.$game_id.' ');
        $ws= 'game_id=-1 and game_data_id='.$game_data_id;
        $criteria->condition =$ws;
        $data = array();
        $data['data_id'] = $game_data_id;
        $data['game_data_id'] = $game_data_id;
        $data['matches_val'] = $matches_val;
        $data['game_id'] = GameList::model()->findAll(' id='.$game_id);  //  
        $max_r=0;$max_c=0; 
        $data['vs_data']=$this->get_vsdata($game_data_id,$arrange_tcode,$max_c,$max_r);
        $data['game_data1'] = $data1; 
        $data['filename'] = '';
        $data['page_name'] = '';
        $data['max_c'] = $max_c;
        $data['max_r'] = $max_r;
        $data['star_time'] = $star_time;
        $data['end_time'] = $end_time;
       
        parent::_list($model,$criteria,'indexvs',$data);
    }

    // 比赛时间与投票时间设置
    public function get_vsdata($game_data_id,$ptcode,&$max_c,&$max_r){
        $w2="game_data_id=".$game_data_id." and arrange_tcode>='".$ptcode."'";
        $w1=$w2." and SUBSTR(arrange_tcode,5,1)=' ' and SUBSTR(arrange_tcode,4,1)<>' ' ";
        $wa=array('order'=>'arrange_tcode','condition'=>$w1);
        $tmp1=GameListArrange::model()->findAll($wa);
        $ad=array();
        if($tmp1){
            if($tmp1[0]->game_format==988){//988循环，985淘汰
               for($i=0;$i<=256;$i++){
                    for($j=0;$j<=13;$j++)$ad[$i][$j]='';
                }
                $ad[1][1]="";
                $gn=$this->get_gamen($tmp1[0]->arrange_tcode,$game_data_id);
                $ds=$this->get_vs($gn);
                $w1=$w2."  and SUBSTR(arrange_tcode,5,1)<>' '  and arrange_tcode>='".$ptcode."' and game_format=988";
                $wa=array('order'=>'arrange_tcode','condition'=>$w1);
             
                $tmp2=GameListArrange::model()->findAll($wa);
                $r1=0;$r2=0;$max_r=0;$max_c=0;  $tg0=-1;
                $dtn=array(0,0,0,0,0);
                foreach ($tmp2 as $v) {
                    $n1=intval(substr($v->arrange_tname,1,2));
                    if($max_c<$n1) $max_c=$n1;
                }
                $max_c=$max_c+1;
                foreach ($tmp2 as $v) {
                    if(strlen(trim($v->arrange_tcode))==5) {
                      $tg0=$tg0+$max_r+3;
                      $r1=0;
                      $dtn[1]=$v;
                    }
                    if(strlen(trim($v->arrange_tcode))==7) {
                      $dtn[2]=$v;
                      $r1=2;
                    }
                    if(strlen(trim($v->arrange_tcode))==9) {
                      $r1=$r1+1;
                      $dtn[$r1]=$v;
                     }
                  
                
                      if($r1==4){ //队名称 
                        $pdate=$dtn[2]->game_site.','.$dtn[2]->star_time;
                        $this->set_gropu_name($tg0,$dtn[3],$dtn[4],$pdate,$ad,$max_c);
                        $this->set_gropu_name($tg0,$dtn[4],$dtn[3],$pdate,$ad,$max_c);
                        $ad[$tg0][1]=$dtn[1]->arrange_tname;//组名
                        $ad[$tg0+1][1]='签号/姓名';
                        $ad[$tg0+1][$max_c+1]='场数';
                        $ad[$tg0+1][$max_c+2]='胜';
                        $ad[$tg0+1][$max_c+3]='负';
                        $ad[$tg0+1][$max_c+4]='平';
                        $ad[$tg0+1][$max_c+5]='积分';
                        $ad[$tg0+1][$max_c+6]='名次';
                       
                        $n1=intval(substr($dtn[3]->arrange_tname,1,2));
                        if($max_r<$n1) $max_r=$n1;
                         $n1=intval(substr($dtn[4]->arrange_tname,1,2));
                        if($max_r<$n1) $max_r=$n1;
                        $r1=0;
                        }
                    }
                $max_r=$tg0+$max_r+3;
                $max_c=$max_c+7;
            }
            else{
                for($i=0;$i<=256;$i++){
                    for($j=0;$j<=10;$j++)$ad[$i][$j]='';
                }
                $gn=$this->get_gamen($tmp1[0]->arrange_tcode,$game_data_id);
                if($gn){
                    $ds=$this->get_vs($gn);
                    $w1=$w2."  and SUBSTR(arrange_tcode,6,1)<>' '  and arrange_tcode>='".$ptcode."'";
                    $wa=array('order'=>'arrange_tcode','condition'=>$w1);
                    $tmp2=GameListArrange::model()->findAll($wa);
                    $r1=0;$r2=0;$max_r=0;$max_c=0;  
                    foreach ($tmp2 as $v) {
                        $r1=$r1+1;
                        $r3=1;
                        $S1='f_rowd';
                        if($r1==2){ $S1='f_rowa'; }
                        if($r1==3){ $S1='f_rowb';  }
                        $col=$ds[$r2]['f_col'];
                        $rol=$ds[$r2][$S1];
                        $sv=$v->star_time;
                        if($r1>=2){
                            $sv=($v->sign_name) ? $v->sign_name : $v->arrange_tname;
                            $sv.=($v->sign_name) ?','.$v->winning_bureau.'' : "";
                        }
                        if($col>$max_c) $max_c=$col;
                        if($rol>$max_r) $max_r=$rol;
                        $ad[$rol][$col]=$sv;
                        if($r1==3){
                            $r1=0; $r2=$r2+1;
                            if($r2>=128) $r2=127;
                        }
                    }
                }
                $max_c=$max_c+2;
            }
        }
        return $ad;
    }

    //$tg0,$ptname,&$ad当前组的行，组队名数组，
    public function set_gropu_name($tg0,$pta,$ptb,$pdate,&$ad,$max_c){
     
        $ta=intval(substr($pta->arrange_tname,1,2));
        $tb=intval(substr($ptb->arrange_tname,1,2));
        $vs=($pta->game_over=900) ? "" : $pta->bureau_score." vs ".$ptb->bureau_score;
        $sn=($pta->sign_name) ? ($pta->sign_name) : (($pta->team_name) ? $pta->team_name :$pta->arrange_tname);
        $ad[$tg0+1][1+$ta]=$sn;
        $ad[$tg0+1+$ta][1+$ta]="#";
        $ad[$tg0+1+$ta][1]=$sn;
        if($pta->game_over==908){
          for($j=$max_c+1;$j<=$max_c+5;$j++) $ad[$tg0+1+$ta][$j]=($ad[$tg0+1+$ta][$j]=='') ? 0 : $ad[$tg0+1+$ta][$j];
          $ad[$tg0+1+$ta][$max_c+1]=$ad[$tg0+1+$ta][$max_c+1]+ 1;
          $ad[$tg0+1+$ta][$max_c+2]=$ad[$tg0+1+$ta][$max_c+2]+(($pta->winning_bureau>$ptb->winning_bureau) ? 1 : 0);
          $ad[$tg0+1+$ta][$max_c+3]=$ad[$tg0+1+$ta][$max_c+3]+(($pta->winning_bureau<$ptb->winning_bureau) ? 1: 0);
          $ad[$tg0+1+$ta][$max_c+4]=$ad[$tg0+1+$ta][$max_c+4]+(($pta->winning_bureau==$ptb->winning_bureau) ? 1 : 0);
          $ad[$tg0+1+$ta][$max_c+5]=$ad[$tg0+1+$ta][$max_c+5]+$pta->gf_game_score;
        }
        $ad[$tg0+1+$ta][$tb+1]=$vs.','.$pdate;  
    }

    // 比赛时间与投票时间设置
    public function get_gamen($ptcode,$game_data_id){
         $w2="game_data_id=".$game_data_id." and left(arrange_tcode,4)='".$ptcode."'";
        $w1=$w2."  and SUBSTR(arrange_tcode,9,1)<>' ' ";   
        $tmp1=GameListArrange::model()->findAll($w1);
        $r1=count($tmp1);
        $r2 = 0;
        if($r1>128) $r2=256;
        if(($r1>64)&&($r1<=128)) $r2=128;
        if(($r1>32)&&($r1<=64)) $r2=64;
        if(($r1>16)&&($r1<=32)) $r2=32;
        if(($r1>8)&&($r1<=16)) $r2=16;
        if(($r1>4)&&($r1<=8)) $r2=8;
        if(($r1>2)&&($r1<=4)) $r2=4;
        if(($r1>1)&&($r1<=2)) $r2=2;
        if($r1==1) $r2=1;
      
        return $r2;
    }

 public function get_vs($gn){
     $w1="f_type='".'单淘汰'."' and f_show=".$gn;
     $tmp1=Gamevsshow::model()->findAll(array('order'=>'f_order','condition'=>$w1));
     $ds=array();$r1=0;
    foreach ($tmp1 as $v) {
       $ds[$r1]=$v->attributes;
       $r1=$r1+1;
     }
        return $ds;
    }
    // 比赛时间与投票时间设置
    public function actionSave_set($id){
        $modelName = $this->model;
        $model = $modelName::model();
        $data = array(
            'star_time' => $_POST['star_time'],
            'end_time' => $_POST['end_time'],
            'votes_star_time' => $_POST['votes_star_time'],
            'votes_end_time' => $_POST['votes_end_time'],
        );
        $sv = $model->updateAll($data,'id='.$id);
        show_status($sv,'保存成功',Yii::app()->request->urlReferrer,'保存失败');
    }

    // 比赛时间与投票时间设置:立即开始与立即结束
    public function actionSave_time($id,$column){
        $modelName = $this->model;
        $model = $modelName::model();
        $date = date('Y-m-d H:i:s');
        $votes = 648;
        if($column=='votes_star_time' || $column=='votes_end_time') $votes = 649;
        $sv = $model->updateAll(array($column=>$date,'if_votes'=>$votes),'id='.$id);
        show_status($sv,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }

    // 总成绩 列表
    public function actionTotal_score($game_id=0,$data_id=0,$score_confirm='',$index='total_score',$arrange_tcode=''){
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $game_id = empty($game_id) ? 0 : $game_id;
        $data_id = empty($data_id) ? 0 : $data_id;
        $act = ($data_id>0) ? ' and id='.$data_id : '';
        $data1 = GameListData::model()->findAll('game_id='.$game_id.$act);
        $data_id = (empty($data_id)) ? (!empty($data1)) ? $data1[0]->id : $data_id : $data_id;
        $criteria->condition = 'length(arrange_tcode)=9 and game_id='.$game_id.' and game_data_id='.$data_id.' and actual_total_upper_order>0';
        $criteria->condition = get_where($criteria->condition,!empty($arrange_tcode),'left(arrange_tcode,4)',$arrange_tcode,'"');
        if($score_confirm==648){
            $criteria->condition .= ' and total_order_confirm=0';
        } else if($score_confirm==649){
            $criteria->condition .= ' and total_order_confirm=1';
        }
        if(!empty($data1)){
            $tname = ($data1[0]->game_player_team==665) ? '(sign_name<>"" and sign_name is not null and sign_name<>"轮空")' : '(team_name<>"" and team_name is not null and team_name<>"轮空")';
            $criteria->condition .= ' and ('.$tname.'or (f_sname<>""))';
            $namec = ($data1[0]->game_player_team==665) ? 'sign_name' : 'team_name';
            // $criteria->group = 'if(sign_name="" or sign_name is null,f_sname,'.$namec.')';
        }
        // $order = ($index=='total_score2') ? 'total_score_order!=0 DESC,total_score_order,victory_num DESC' : 'total_score_order!=0 DESC,total_score_order';
        $criteria->order = 'find_in_set(0,actual_total_upper_order<>0),actual_total_upper_order';
        $data = array();
        $data['data_id'] = $data_id;
        $data['game_id'] = GameList::model()->findAll(get_where_club_project('game_club_id').' and datediff(now(),game_time_end)<=7');  //  and game_state<>149
    	$data['game_data1'] = GameListData::model()->findAll('game_id='.$game_id.' AND if_del=510');
        // $data['game_list1'] = GameList::model()->findAll('id='.$game_id);
        parent::_list($model,$criteria,$index,$data);
    }

    public function actionTotal_score2($game_id=0,$data_id=0,$score_confirm=''){
        $this->actionTotal_score($game_id,$data_id,$score_confirm,'total_score2');
    }

    // 总成绩保存数据->total_score页面
    public function actionSaveTotalScore($id){
        $data = array(
            'victory_num' => $_POST['victory_num'],
            'transport_num' => $_POST['transport_num'],
            'gf_game_score' => $_POST['game_integral_score'],
            'total_score_order' => $_POST['total_score_order'],
        );
        GameListArrange::model()->updateByPk($id,$data);
        echo 1;
    }

    // 名次确认  total_score2页面
    public function actionSaveTotalScore2($id,$n){
        GameListArrange::model()->updateAll(['total_order_confirm'=>$n],'id in('.$id.')');
        $modelName = $this->model;
        $count = explode(',',$id);
        $ln = 0;
        foreach($count as $d){
            $model = $this->loadModel($d,$modelName);
            $act = 'arrange_id='.$model->id.' and length(arrange_tcode)=2';
            if($n==1){
                $this->save_order_list($model,$n,$act,2,1);
            }
            else{
                GameListOrder::model()->deleteAll('arrange_id='.$d.' and length(arrange_tcode)=2');
            }
            $ln = 1;
        }
        $co = ($n==1) ? '确认成功' : '取消成功';
        $cx = ($n==1) ? '确认失败' : '取消失败';
        show_status($ln,$co,Yii::app()->request->urlReferrer,$cx);
    }

    // 返回赛程信息
    public function actionInterface($id){
        $modelName = $this->model;
        $model = $this->loadModel($id,$modelName);
        $arrange = $modelName::model()->findAll('game_data_id='.$model->game_data_id.' and left(arrange_tcode,7)="'.$model->arrange_tcode.'" and length(arrange_tcode)=9');
        $data = array();
        $data1 = array();
        $data1['star_time']  = $model->star_time;
        $data1['chief_umpire']  = $model->chief_umpire;
        $data1['rem_time']  = $model->rem_time;
        $data1['game_over']  = $model->game_over;
        $data1['bureau_num']  = $model->bureau_num;
        $path = BasePath::model()->get_www_path();
        if(!empty($arrange))foreach($arrange as $key => $val){
            $data[$key]['id'] = $val->id;
            $data[$key]['player_name'] = ($model->game_player_id==665) ? $val->sign_name : $val->team_name;
            $data[$key]['pic_logo'] = ($model->game_player_id==665) ? $path.str_replace('http://upload.gfinter.net/','',$val->sign_logo) : $path.str_replace('http://upload.gfinter.net/','',$val->team_logo);
            $data[$key]['winning_bureau'] = $val->winning_bureau;
            $data[$key]['bureau_score'] = $val->bureau_score;
            $data[$key]['single_score'] = $val->single_score;
        }
        echo CJSON::encode([$data,$data1]);
    }

    /**
     * 返回成员更新信息
     */
    function return_data($i,$post,$game_over,$achievement_show_title){
        $data1=GameListArrange::model()->score_to_str(0,$post['winning_bureau_'.$i],$post['bureau_score_'.$i],
            $post['single_score_'.$i],$post['ball_right_'.$i],$post['rem_time']);
        $data1['game_over'] =$game_over;
        $data['achievement_show_title'] =$achievement_show_title;
        return $data1;
    }

    // 台球实时保存分数
    public function actionSave_billiards_score($id,$game_over){    
        $this->Save_score_data($_POST,$game_over,'bs');
        GameListArrange::model()->sendMessage($id);
        $this->actionSave_retime($id);
        echo CJSON::encode(1);
    }

    // 保存乒乓球分数
    public function actionSave_table_tennis($id,$game_over){
        $this->Save_score_data($_POST,$game_over,'tt');
        GameListArrange::model()->sendMessage($id);
        $this->actionSave_retime($id);
        echo CJSON::encode(1);
    }

    // 台球实时保存分数
    public function Save_score_data($data,$game_over,$ball_type){
        $st='';$ss="";
        $this->get_show_sscore($data,$st,$ss,$ball_type);
        GameListArrange::model()->save_time_score($data,$game_over);
        GameListArrange::model()->update_vs_score($data['id_0'],$st,$ss);
       // $this->actionMessage($model,$data,$model->game_data_id,$name,$ball_type);
    }

    // 保存比赛时间、胜盘制、裁判
    public function actionSave_retime($id){
        GameListArrange::model()->updateByPk($id,array(
            'bureau_num'=>$_POST['bureau'].','.$_POST['bureau_num'],
            'rem_time'=>$_POST['rem_time'],
            'chief_umpire'=>$_POST['GameListArrange']['chief_umpire'],
            'star_time'=>$_POST['GameListArrange']['star_time'])
        );
        echo 1;
    }

    // 更改比赛状态
    public function actionSave_game_state($id){
        $modelName = $this->model;
        $model = $this->loadModel($id,$modelName);
        GameListArrange::model()->updateAll(array('game_over'=>901),'game_data_id='.$model->game_data_id.' and left(arrange_tcode,7)="'.$model->arrange_tcode.'"');
        echo 1;
    }

    // 实时存储时间
    public function actionSave_game_time($id){
        $modelName = $this->model;
        $model = $this->loadModel($id,$modelName);
        GameListArrange::model()->updateAll(array('rem_time'=>$_POST['rem_time']),'game_data_id='.$model->game_data_id.' and left(arrange_tcode,7)="'.$model->arrange_tcode.'"');
        echo 1;
    }

    // 撤销最后一个
    // 用base64保存
    public function actionRevoke($id,$gtype='bs'){
        $modelName = $this->model;
        $model1 = $this->loadModel($id,$modelName);
        $w1='game_data_id='.$model1->game_data_id.' and left(arrange_tcode,7)="'.$model1->arrange_tcode.'" and length(arrange_tcode)=9';
        $model=$model1->find($w1);
        $score_record = explode(',',$model->score_record);
        $len = count($score_record);
        $rearr = '';
        $data=array();
        if($len>1){ //表示可以恢复的数据
            $len=$len-1;
            $tmp1 = $score_record[$len-1];
            $str="";$bs=',';
            for($i=0;$i<$len-1;$i++){
                if(!empty($str)) $str .= $bs;
                $str .= $score_record[$i];
            }
            GameListArrange::model()->updateAll(array('score_record'=>$str),$w1);
            $data0 =json_decode(base64_decode($tmp1),true);
            for($i=0;$i<2;$i++){
                $data1=$data0[($i==0) ? "a" : 'b'];
                $data['id_'.$i]= $data1['id'];
                $data['winning_bureau_'.$i]=$data1['winning_bureau'];
                $data['bureau_score_'.$i]=$data1['bureau_score'];
                $data['single_score_'.$i]=$data1['single_score'];
                $data['ball_right_'.$i]=$data1['ball_right'];  
            }
            $ds=explode(',',$model->bureau_num.',0,0');
            $data['bureau']=$ds[0];
            $data['bureau_num']=$ds[1];
            $data['rem_time']=$model->rem_time;
            $this->Save_score_data($data,$model->game_over,$gtype);
        } else{
            GameListArrange::model()->updateByPk($id,array('show_score'=>''));
            GameListArrange::model()->updateAll(array('score_record'=>'','winning_bureau'=>0,'bureau_score'=>0,'single_score'=>0),$w1);
        }
        GameListArrange::model()->sendMessage($id);
        echo json_encode($data);
    }

    function get_show_sscore($data,&$show_title,&$show_score,$gtype){
        $s3='&#160;&#160;&#160;&#160;';
        $fl = '<font>';
        $fr = '</font>';
        $sp1 = ($data['bureau_score_0']<10) ? '&#160;' : '&#160;&#160;';
        $sp2 = ($data['bureau_score_1']<10) ? '&#160;' : '&#160;&#160;';
        $sp3 = ($data['ball_right_0']=='0') ? $sp2 : '';
        $sp4 = ($data['ball_right_0']=='1') ? $sp1 : '';
        $sp5 = ($data['bureau_score_0']<10) ? '' : '&#160;&#160;';
        $sk1 = (($data['bureau_score_0']>9 && $data['ball_right_1']=='1') || ($data['bureau_score_1']>9 && $data['ball_right_1']=='1')) ? '&#160;&#160;' : '';
        $sk2 = (($data['bureau_score_1']>9 && $data['ball_right_0']=='1') || ($data['bureau_score_1']>9 && $data['ball_right_0']=='1')) ? '&#160;&#160;' : '';
        $sj1 = ($data['bureau_score_0']<10) ? $s3.$sp4.$sp2.$sk1.$sk2 : $s3.$sk2;
        $sj2 = ($data['bureau_score_0']<10) ? '' : '&#160;';
        $sj3 = ($data['bureau_score_0']<10) ? $sp3.$sp5 : '';
        $sj4 = ($data['bureau_score_1']>9) ? '&#160;&#160;&#160;' : $s3.$sp1.$sk1.$sj2;
        $st=$fl.$fl.(($data['ball_right_0']=='1') ? $sj3."&gt;&gt; " : $sj1).$data['bureau_score_0'];
        $st.=$s3.$data['winning_bureau_0'].$fr;
        $st.=($gtype=='bs' && ($data['ball_right_0']=='1')) ? $data['bureau_score_0'] : '';
        $st.=$fl.$s3."(" .$data['bureau']. ")".$s3.$fr;//bureau,bureau_num
        $st.=($gtype=='bs' && ($data['ball_right_1']=='1')) ? $data['bureau_score_1'] : '';
        $st.=$fl.$data['winning_bureau_1'].$s3.$data['bureau_score_1'].$fr;
        $st.=$fl.(($data['ball_right_1']=='1') ? " &lt;&lt;".$sj2 : $sj4).$fr.$fr;
        $show_score=$st;
        // $s3.=$s3.$s3.$s3.$s3;
        $show_title='成绩                vs                成绩';

        // <font>
        //     <font>&#160;&#160;&#160;&#160;&#160;0&#160;&#160;&#160;&#160;3</font>
        //     <font>&#160;&#160;&#160;&#160;(5)&#160;&#160;&#160;&#160;</font>
        //     <font>1&#160;&#160;&#160;&#160;0</font>
        //     <font> &lt&lt</font>
        // </font>
        // $fm = 
        // '<font>'.
        //     '<font>'.(($data['ball_right_0']=='1') ? $sj3."&gt;&gt; " : $sj1).$data['bureau_score_0'].$s3.$data['winning_bureau_0'].'</font>'.
        //     '<font>'.'</font>'.
        // '</font>';
    }

    /**
     * 返回本场存储字段数组
     */
    function return_arr($star_time,$chief_umpire,$rem_time,$uDate,$game_over,$bureau_num,$score_record){
        return array(
            'star_time' => $star_time,
            'chief_umpire' => $chief_umpire,
            'rem_time' => $rem_time,
            'uDate' => $uDate,
            'game_over' => $game_over,
            'bureau_num' => $bureau_num,
            'score_record' => $score_record
        );
    }

    /**
     * 返回成员更新的字段数组
     */
    function return_arr1($id,$ball_right,$rem_time,$single_score,$winning_bureau,$uDate){
        return array(
            'id' => $id,
            'ball_right' => $ball_right,
            'rem_time' => $rem_time,
            'single_score' => $single_score,
            'winning_bureau' => $winning_bureau,
            'uDate' => $uDate,
        );
    }

    // 保存当场分数  index_results2页面
    public function actionSave_results1(){
        $modelName = $this->model;
        $model = $this->loadModel($_POST['id'],$modelName);
        $data = array($_POST['attrname'] => $_POST['this_val']);
        if($_POST['attrname']=='is_promotion'){
            $data['gf_game_score'] = $_POST['gf_game_score'];
            $data['gf_votes_score'] = $_POST['gf_votes_score'];
 			$data['game_order'] = ($_POST['this_val']==1006) ? 1 : 2;        }
        $model->updateByPk($model->id,$data);
        $str_tcode = substr($model->arrange_tcode,0,7);
        $modelName::model()->updateAll(array('achievement_show_title'=>'获胜局          积分          GF积分'),'arrange_tcode="'.substr($model->arrange_tcode,0,4).'" and game_data_id='.$model->game_data_id);
        $w1 = "game_data_id=".$model->game_data_id." and arrange_tcode='".$str_tcode."' and arrange_id=".$model->id;
        $this->save_order($model->game_id,$model->game_data_id,$model->game_order,$tmark=0,$model->gf_votes_score,$str_tcode,0,$w1,$model);
        $this->remove_confirm($_POST['master_id']);
        echo CJSON::encode(1);
    }

    /**
     * 修改成绩同时清除积分确认、成绩确认
     */
    function remove_confirm($id){
        $modelName = $this->model;
        $model = $this->loadModel($id,$modelName);
        GameListArrange::model()->updateAll(array('score_confirm'=>0,'state'=>721),'game_id='.$model->game_id.' and game_data_id='.$model->game_data_id.' and left(arrange_tcode,7)="'.$model->arrange_tcode.'"');
        $this->save_order_score($model,0);
        $this->order_eliminate($id);
    }

    // 返回项目所属界面 如:obj_tt
    public function actionData_query($id,$name){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if(!Yii::app()->request->isPostRequest){
            $data["model"] = $model;
            $title = "";
            $game = GameList::model()->find("id=".$model->game_id);
            $data1 = GameListData::model()->find("id=".$model->game_data_id);
            $title = $game->game_title.'-'.$data1->game_data_name;
            $data["title"] = $title;
            $this->render($name, $data);
        }
    }

    // 赛程列表修改
    public function actionClick_window($id){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array(
            "arrange_tcode" => $model->arrange_tcode,
            "arrange_tname" => $model->arrange_tname
        );
        echo CJSON::encode($data);
    }

    // 赛程列表修改
    public function actionSave_window($id){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array(
            "arrange_tcode" => $_POST["arrange_tcode"],
            "arrange_tname" => $_POST["arrange_tname"]
        );
        $model->updateByPk($id,$data);
        ajax_status(1,'修改成功',Yii::app()->request->urlReferrer);
    }

    // 获取签号，输出到晋级方向
    public function actionCheckTcode($code,$id){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $model1 = $modelName::model()->find("arrange_tcode='".$code."' and game_data_id=".$model->game_data_id);
        $data = '';
        if(!empty($model1->arrange_tname)){
            $data = $model1->arrange_tname;
        }
        echo CJSON::encode($data);
    }

    public function actionGet_time($game_id,$data_id){
        $modelName = $this->model;
        $model = $modelName::model()->findAll("game_id=".$game_id." and game_data_id=".$data_id.' and length(arrange_tcode)=4');
        $data = array();
        if(!empty($model))foreach($model as $key => $val){
            $data[$key]["id"] = $val->id;
            $data[$key]["arrange_tcode"] = $val->arrange_tcode;
            $data[$key]["arrange_tname"] = $val->arrange_tname;
            $data[$key]["if_rele"] = $val->if_rele;
            $data[$key]["rele_date_start"] = $val->rele_date_start;
        }
        echo CJSON::encode($data);
    }

    // 保存签号
    public function actionSave_signmember($id,$player){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $slogo = "";
        $tid = ($player==665) ? 'sign_id' : 'team_id';
        $tname = ($player==665) ? 'sign_name' : 'team_name';
        if(!empty($_POST["sign_id"])){
            if($player==665){
                $sid = GameSignList::model()->find('id='.$_POST["sign_id"]);
            }
            else{
                $sid = GameTeamTable::model()->find('id='.$_POST["sign_id"]);
            }
            if(!empty($sid)){
                $slogo = ($player==665) ? $sid->sign_head_pic : $sid->logo;
            }
        }
        // 同项目、同组别、同签号视为循环赛（同一人）
        $model->updateAll(
            array(
                $tid=>$_POST["sign_id"],
                $tname=>$_POST["sign_name"],
                "sign_logo"=>$slogo
            )
            ,'game_data_id='.$model->game_data_id.' and left(arrange_tcode,5)="'.substr($model->arrange_tcode,0,5).'" and arrange_tname="'.$model->arrange_tname.'"'
        );
    }

    // 成绩确认&取消确认  /   积分确认&取消确认
    public function actionOrderConfirm($id,$confirm,$num){
        $modelName = $this->model;
        $len = explode(',',$id);
        $st = 0;
        foreach($len as $d){
            $model = $this->loadModel($d, $modelName);
            // 修改成绩||积分确认状态
            // GameListOrder::model()->updateAll($a1,$w1);
            if($num==0){
                $this->remove_confirm($d);
            }
            $state = ($num==1) ? 2 : 721;
            GameListArrange::model()->updateAll(array($confirm=>$num,'state'=>$state),'game_id='.$model->game_id.' and game_data_id='.$model->game_data_id.' and left(arrange_tcode,7)="'.$model->arrange_tcode.'"');
            if($confirm=='order_confirm'){
                // 更新成绩表、晋级
                $this->save_order_upper($model,$num);
                $st = 1;
            }
            else{
                // 更新积分
                $this->save_order_score($model,$num);
                $st = 1;
            }
        }
        $co = ($num==1) ? '确认成功' : '取消成功';
        $cx = ($num==1) ? '确认失败' : '取消失败';
        show_status($st,$co,Yii::app()->request->urlReferrer,$cx);
    }

    /**
     * 更新成绩
     */
    function save_order_upper($model,$num){
        $model1 = GameListArrange::model()->findAll('game_data_id='.$model->game_data_id.' and left(arrange_tcode,7)="'.$model->arrange_tcode.'" and id<>'.$model->id);
        if(!empty($model1))foreach($model1 as $m1){
            if($num==1){
                // 更新成绩
                $this->save_order_list($m1,$num,'arrange_id='.$m1->id);
                // 更新展示的标题
                $this->achievement_show_title($model);
                // 晋级,确认成绩
                if($m1->game_format==985){
                    $this->actionGameGroupOrder($m1->game_id,$m1->game_data_id,$m1->game_player_id,$m1->arrange_tcode,$m1->upper_order,$m1->game_mark,$m1->game_score,strlen($model->arrange_tcode),$m1->game_format);
                }
                // if($m1->game_format==988) break;
            }
            else{
                // 取消确认，做清除字段
                $this->order_eliminate($m1->id);
            }
        }
    }

    /**
     * 更新成绩.
     * $m1：传递获取的模型的值
     * 
     * $num：0=取消，1=确认
     * 
     * $act：传递条件判断game_list_order表是否有值
     * 
     * $len：编码长度，2=总成绩，7=场次成绩
     * 
     * $score：积分
     */
    function save_order_list($m1,$num,$act='',$len=7,$score=0,$rank=0){
        $order_list = GameListOrder::model()->find($act);
        if(empty($order_list)){
            $order_list = new GameListOrder;
            $order_list->isNewRecord = true;
            unset($order_list->id);
            $order_list->arrange_id = $m1->id;
            $order_list->game_id = $m1->game_id;
            $order_list->game_data_id = $m1->game_data_id;
            $order_list->arrange_tcode = substr($m1->arrange_tcode,0,$len);
            $order_list->project_id = $m1->project_id;
            $order_list->game_area = $m1->game_area;
            $order_list->game_mode = $m1->game_mode;
            $order_list->game_player_id = $m1->game_player_id;
            $order_list->sign_no = $m1->arrange_tname;
            $order_list->team_ida = $m1->team_id;
            if($m1->game_player_id!=665){
                $order_list->team_name = (!empty($m1->team_name)) ? $m1->team_name : $m1->f_sname;
            }
            $order_list->sign_ida = $m1->sign_id;
            $order_list->gf_namea = (!empty($m1->sign_name)) ? $m1->sign_name : $m1->f_sname;
            $order_list->state = 2;
        }
        $order_list->game_top_score = $m1->gf_game_score;
        $order_list->game_score = $m1->game_score;
        $arank = (empty($rank)) ? $m1->actual_total_upper_order : $rank;
        $srank = ($len==2) ? $arank : $m1->game_order;
        $order_list->game_rank = $srank;
        $order_list->is_promotion = ($len==2) ? '' : $m1->is_promotion;
        $order_list->total_confirm = $m1->total_order_confirm;
        $order_list->score_confirm = $m1->score_confirm;
        $order_list->order_confirm = $num;
        // 更新展示的成绩
        // if($len==2){
            $gfsc = ($m1->score_confirm==1) ? $m1->gf_game_score : 0;
            $gsc = ($m1->score_confirm==1) ? $m1->game_score : 0;
            $score = empty($score) ? 0 : $gfsc;
            $game_score = ($m1->game_format==985) ? '' : $gsc;
            $order_list->achievement_show = $m1->winning_bureau.'              '.$game_score.'              '.$score;  // 未确认积分，所以为0 .$m1->gf_game_score;
        // }
        $order_list->save();
    }

    /**
     * 清除成绩，修改确认状态
     */
    function order_eliminate($id){
        $model = GameListArrange::model()->find('id='.$id);
        $tid = ($model->game_player_id==665) ? 'sign_id' : 'team_id';
        $tname = ($model->game_player_id==665) ? 'sign_name' : 'team_name';
        $tlogo = ($model->game_player_id==665) ? 'sign_logo' : 'team_logo';
        $xname = (empty($model->$tname)) ? 'f_sname' : $tname;
        GameListOrder::model()->updateAll(array('achievement_show'=>'','order_confirm'=>0),'arrange_id='.$id);
      
        GameListArrange::model()->updateAll(array($tid=>0,$xname=>'',$tlogo=>''),'game_data_id='.$model->game_data_id.' and arrange_tcode="'.$model->upper_code_user.'"');
        GameListArrange::model()->updateByPk($id,array('upper_order_user'=>'','upper_code_user'=>'','actual_total_upper_order'=>0));
    }
    

    // 更新阶段成绩的显示标题
    function achievement_show_title($model){
        $title = ($model->game_format==988) ? '获胜局          积分          GF积分' : '获胜局                        GF积分';
        GameListArrange::model()->updateAll(array('achievement_show_title'=>$title),'arrange_tcode="'.substr($model->arrange_tcode,0,4).'" and game_data_id='.$model->game_data_id);
    }

    /**
     * 积分确认
     */
    function save_order_score($model,$num){
        $arrange_list = GameListArrange::model()->findAll('game_data_id='.$model->game_data_id.' and left(arrange_tcode,7)="'.$model->arrange_tcode.'" and id<>'.$model->id);
        if(!empty($arrange_list))foreach($arrange_list as $al){
            $sc = ($num==1) ? $al->gf_game_score : 0;
            $format = ($al->game_format==988) ? $al->game_score : '';
            $scg = $al->winning_bureau.'              '.$format.'              '.$sc;
            $gts = ($num==1) ? $al->gf_game_score : '';
            // 保存至排名记录表
            GameListOrder::model()->updateAll(array('score_confirm'=>$num,'achievement_show'=>$scg,'game_top_score'=>$gts),'arrange_id='.$al->id);
            $this->save_top_score_history($al);
        }
    }

    /**
     * 确认积分的同时保存进排名榜记录表
     */
    function save_top_score_history($model){
        $data_list = GameListData::model()->find('id='.$model->game_data_id);
        $order_list = GameListOrder::model()->find('arrange_id='.$model->id);
        if($model->game_player_id==665){
            $history_list = TopScoreHistory::model()->find('get_type=893 and game_arrange_id='.$order_list->arrange_id.' and gf_id='.$order_list->gf_ida.' and come_id='.$order_list->id);
            if(empty($history_list)){
                $history_list = new TopScoreHistory;
                $history_list->isNewRecord = true;
                $history_list->uDate = date('Y-m-d H:i:s');
            }
            $history_list->game_arrange_id = $order_list->arrange_id;
            $history_list->gf_id = $order_list->gf_ida;
            $history_list->get_type = 893;  // 893=赛事积分
            $history_list->come_id = $order_list->id;
            $history_list->get_score_game_reson = '参加赛事-'.$data_list->game_data_name.'所得';
            $history_list->project_id = $order_list->project_id;
            $history_list->get_score = $order_list->game_top_score;
            $history_list->game_area = $order_list->game_area;
            $history_list->state = $order_list->state;
            $history_list->save();
        }
        else{
            $table_list = GameTeamTable::model()->find('id='.$model->team_id);
            if(!empty($table_list)){
                $sign_list = GameSignList::model()->findAll('team_id='.$table_list->id);
                $data = array();
                if(!empty($sign_list))foreach($sign_list as $sl){
                    $data1 = array();
                    $history_list = TopScoreHistory::model()->find('get_type=893 and game_arrange_id='.$order_list->arrange_id.' and gf_id='.$sl->sign_gfid.' and come_id='.$order_list->id);
                    // if(empty($history_list)){
                    //     $history_list = new TopScoreHistory;
                    //     $history_list->isNewRecord = true;
                    // }
                    $data1['id'] = empty($history_list) ? '' : $history_list->id;
                    $data1['uDate'] = empty($history_list) ? date('Y-m-d H:i:s') : $history_list->uDate;
                    $data1['game_arrange_id'] = $order_list->arrange_id;
                    $data1['gf_id'] = $sl->sign_gfid;
                    $data1['get_type'] = 893;  // 893=赛事积分
                    $data1['come_id'] = $order_list->id;
                    $data1['get_score_game_reson'] = '参加赛事-'.$data_list->game_data_name.'所得';
                    $data1['project_id'] = $order_list->project_id;
                    $data1['get_score'] = $order_list->game_top_score;
                    $data1['game_area'] = $order_list->game_area;
                    $data1['state'] = $order_list->state;
                    // $history_list->save();
                    $data[] = $data1;
                }
                $column = 'id,uDate,game_arrange_id,gf_id,get_type,come_id,get_score_game_reson,project_id,get_score,game_area,state';
                batch_insert_on_update('top_score_history',$column,$data);
            }
        }
    }

    /**
     * index_score_confirm页面.
     * 积分确认界面-保存修改积分
     */
    public function actionSave_score_votes($id){
        $s = GameListArrange::model()->updateByPk($id,array($_POST['attrname']=>$_POST['attrval']));
        echo $s;
    }

    // 计时计分实时获取分数改变
    public function actionGetScore($id,$bs){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = GameListArrange::model()->findAll('game_data_id='.$model->game_data_id.' and left(arrange_tcode,7)="'.$model->arrange_tcode.'" and length(arrange_tcode)=9 order by arrange_tcode');
        $arr = [];
        if(!empty($data))foreach($data as $key => $val){
            $arr[$key]['id'] = $val->id;
            $arr[$key]['winning_bureau'] = $val->winning_bureau;
            if($bs==1){
                $arr[$key]['single_score'] = $val->single_score;
            }
            $arr[$key]['bureau_score'] = $val->bureau_score;
            $arr[$key]['ball_right'] = $val->ball_right;
            $arr[$key]['rem_time'] = $val->rem_time;
        }
        echo CJSON::encode($arr);
    }

    // 获取赛事状态
    public function actionGetGameOver($id){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        echo CJSON::encode($model->game_over);
    }

    // 单场赛事积分确认
    public function actionIndex_score_confirm($game_id='',$data_id='',$star_time='',$end_time='',$score_confirm=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $where = get_where_club_project('game_club_id').' and if_del=510';// and datediff(now(),game_time_end)<7';
        $star_time = empty($star_time) ? date('Y-m-d') : $star_time;
        $end_time = empty($end_time) ? date('Y-m-d') : $end_time;
        $criteria->condition = 'length(arrange_tcode)=7 and order_confirm=1';
        $criteria->condition .= ' and exists(select * from game_list gl where t.game_id=gl.id and '.$where.')';
        if($score_confirm==648){
            $criteria->condition .= ' and score_confirm=0';
        } else if($score_confirm==649){
            $criteria->condition .= ' and score_confirm=1';
        }
        $criteria->condition = get_where($criteria->condition,!empty($game_id),'game_id',$game_id,'');
        $criteria->condition = get_where($criteria->condition,!empty($data_id),'game_data_id',$data_id,'');
        $criteria->condition = get_where($criteria->condition,!empty($star_time),'left(star_time,10)>=',$star_time,'"');
        $criteria->condition = get_where($criteria->condition,!empty($end_time),'left(end_time,10)<=',$end_time,'"');
        $criteria->order = 'find_in_set(1,score_confirm),arrange_tcode';
        $data = array();
        $data['star_time'] = $star_time;
        $data['end_time'] = $end_time;
        $data['game_id'] = GameList::model()->findAll($where.' and datediff(now(),game_time_end)<7');
        parent::_list($model, $criteria, 'index_score_confirm', $data);
    }

    // 总赛事积分确认
    public function actionIndex_total_score($game_id='',$data_id='',$score_confirm=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $game_id = empty($game_id) ? 0 : $game_id;
        $data_id = empty($data_id) ? 0 : $data_id;
        $data1 = GameListData::model()->find('id='.$data_id);
        $tname = '';
        $where = get_where_club_project('game_club_id').' and datediff(now(),game_time_end)<7';
        $criteria->condition = 'length(arrange_tcode)=9 and game_id='.$game_id.' and game_data_id='.$data_id;
        if($score_confirm==648){
            $criteria->condition .= ' and total_score_confirm=0';
        } else if($score_confirm==649){
            $criteria->condition .= ' and total_score_confirm=1';
        }
        if(!empty($data1)){
            $tname = ($data1->game_player_team==665) ? ' and (sign_name<>"" and sign_name is not null and sign_name<>"轮空")' : ' and (team_name<>"" and team_name is not null and team_name<>"轮空")';
            $criteria->condition .= $tname;
            $criteria->group = ($data1->game_player_team==665) ? 'sign_name' : 'team_name';
        }
        $criteria->order = 'total_score_confirm!=0 DESC,total_score_order';
        $data = array();
        $data['game_id'] = GameList::model()->findAll($where);
        parent::_list($model, $criteria, 'index_total_score', $data);
    }

    // 对比台号、对战人员
    public function actionSelectSign($id=0){
        $modelName = 'Gametableno';
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'f_time>=DATE_SUB(now(), INTERVAL 60 MINUTE)';
        $criteria->order = 'f_time DESC';
        $data = array();
        $data['arr_id'] = $id;
        parent::_list($model,$criteria,'selectSign',$data);
    }

    // 保存台号、比赛人员
    public function actionSaveSelectSign($arr_id,$id){
        $model = Gametableno::model()->find('id='.$id);
        $arrange = GameListArrange::model()->find('id='.$arr_id);
        if(!empty($arrange)){
            Gametableno::model()->updateAll(array('f_selected'=>0),'f_selected='.$arr_id);
            $model->f_selected = $arr_id;
            $model->save();
            $arrange->updateAll(array('game_site'=>$model->f_no),'game_data_id='.$arrange->game_data_id.' and left(arrange_tcode,7)="'.$arrange->arrange_tcode.'"');
            $arrange_list = GameListArrange::model()->findAll('game_data_id='.$arrange->game_data_id.' and left(arrange_tcode,7)="'.$arrange->arrange_tcode.'" and id<>'.$arrange->id);
            foreach($arrange_list as $key => $val){
                $name = ($key==0) ? $model->f_namea : $model->f_nameb;
                // f_sname：短名
                $val->f_sname = $name;
                $val->save();
            }
        }
        echo 1;
    }

    // 清除选中的台号、比赛人员
    public function actionRemoveSelectSign($id){
        $modelName = 'Gametableno';
        $model = $this->loadModel($id, $modelName);
        $arr = GameListArrange::model()->find('id='.$model->f_selected);
        if(!empty($arr)){
            $arr_list = GameListArrange::model()->findAll('game_data_id='.$arr->game_data_id.' and left(arrange_tcode,7)="'.$arr->arrange_tcode.'" and id<>'.$arr->id);
            if(!empty($arr_list))foreach($arr_list as $al){
                $al->f_sname = ($al->game_player_id==665) ? $al->sign_name : $al->team_name;
                $al->save();
            }
        }
        Gametableno::model()->updateByPk($id,['f_selected'=>0]);
        echo 1;
    }

    // index_results2页面 获取小组的数据
    public function actionGet_data_score($id){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        $name = ($model->game_player_id==665) ? 'sign_name' : 'team_name';
        // $cont = 'game_data_id='.$model->game_data_id.' and left(arrange_tcode,5)="'.$model->arrange_tcode.'" and length(arrange_tcode)=9 group by ifnull('.$name.',f_sname) order by upper_order_user';
        // 先排序后分组
        $sql = 'select * from (select * from game_list_arrange where game_data_id='.$model->game_data_id.' and left(arrange_tcode,5)="'.$model->arrange_tcode.'" and length(arrange_tcode)=9 order by arrange_tcode desc) a group by ifnull(a.'.$name.',a.f_sname)';
        $list = Yii::app()->db->createCommand($sql)->queryAll();
        // $list = $modelName::model()->findAll($cont);
        $is_up = 0;
        if(!empty($list))foreach($list as $key => $val){
            $namec = (empty($val[$name])) ? 'f_sname' : $name;
            $vict_num = $this->get_vict_num($val);
            $is_up = $vict_num[3];
            $total_order = (empty($val['upper_order_user'])) ? $val['total_upper_order'] : $val['upper_order_user'];
            $data[$key]['id'] = $val['id'];
            $data[$key]['name'] = $val[$namec];
            $data[$key]['vict_num'] = $vict_num[0];
            $data[$key]['defe_num'] = $vict_num[1];
            $data[$key]['group_score'] = $vict_num[2];
            $data[$key]['upper_order_user'] = $total_order;
        }
        // 初始按积分降序排
        array_multisort(array_column($data,'group_score'),SORT_DESC,$data);
        echo CJSON::encode([$data,$is_up]);
    }

    /**
     * 获取个人||团队小组内胜、败、积分总和、是否晋级
     */
    function get_vict_num($model){
        $name = ($model['game_player_id']==665) ? 'sign_name' : 'team_name';
        $tname = (empty($model[$name])) ? 'f_sname' : $name;
        $cont = 'game_data_id='.$model['game_data_id'].' and left(arrange_tcode,5)="'.substr($model['arrange_tcode'],0,5).'" and length(arrange_tcode)=9 and '.$tname.'="'.$model[$tname].'"';
        $list = GameListArrange::model()->findAll($cont);
        $vict = 0;  // 胜局
        $defe = 0;  // 败局
        $score = 0;  // 积分
        $is_true = 0;  // 0=未选择晋级，1=已选择晋级
        if(!empty($list))foreach($list as $val){
            if($val->order_confirm==1){
                if($val->is_promotion==1006) $vict = $vict + 1;
                if($val->is_promotion==1008) $defe = $defe + 1;
                $score = $score + $val->game_score;
                if($val->upper_order_user>0) $is_true = 1;
            }
        }
        return [$vict,$defe,$score,$is_true];
    }

    // 小组成绩
    public function actionSave_data_score(){
        $modelName = $this->model;
        $st = 0;
        if(!empty($_POST)){
            for($i=0;$i<$_POST['datalen'];$i++){
                $model = $this->loadModel($_POST['id_'.$i], $modelName);
                $data = array('group_score'=>$_POST['group_score_'.$i],'group_score_order'=>$_POST['upper_order_user_'.$i],'upper_code_user'=>'');
                $data['upper_order_user'] = ($_POST['check_box']==1) ? $_POST['upper_order_user_'.$i] : '';
                $upper_list_order = 0;
                if($_POST['check_box']){
                    $tid = ($model->game_player_id==665) ? 'sign_id' : 'team_id';
                    $tname = ($model->game_player_id==665) ? 'sign_name' : 'team_name';
                    $tlogo = ($model->game_player_id==665) ? 'sign_logo' : 'team_logo';
                    $data1 = array('f_sname' => $model->f_sname,$tid => $model->$tid,$tname => $model->$tname,$tlogo => $model->$tlogo);
                    $act = 'game_data_id='.$model->game_data_id.' and left(arrange_tcode,5)="'.substr($model->arrange_tcode,0,5).'"';
                    $act .= ' and length(arrange_tcode)=9 and upper_order='.$_POST['upper_order_user_'.$i];
                    $act .= ' and ((upper_code<>"" and upper_code is not null) or total_upper_order>0)';
                    $upper_list = GameListArrange::model()->find($act);
                    if(!empty($upper_list)){
                        if(!empty($upper_list->upper_code)){
                            GameListArrange::model()->updateAll($data1,'game_data_id='.$model->game_data_id.' and arrange_tcode="'.$upper_list->upper_code.'"');
                        }
                        $data['upper_code_user'] = $upper_list->upper_code;
                        $upper_list_order = $upper_list->total_upper_order;
                    }
                }
                $data['actual_total_upper_order'] = ($_POST['check_box']==1) ? $upper_list_order : 0;
                $model->updateAll($data,'game_data_id='.$model->game_data_id.' and arrange_tname="'.$model->arrange_tname.'" and left(arrange_tcode,5)="'.substr($model->arrange_tcode,0,5).'" order by arrange_tcode desc limit 1');

                $st = 1;
            }
        }
        show_status($st,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }

    // 赛事列表 成绩
    public function actionGame_list_sign($game_id,$data_id='',$arrange_tcode='',$back=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $act = ($data_id>0) ? ' and id='.$data_id : '';
        $gamelist = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510'.$act);
        $data_id = (empty($data_id)) ? 0 : $data_id;
        $data_id = (!empty($gamelist)) ? $gamelist[0]->id : $data_id;
        $criteria->condition = 'game_id='.$game_id.' and game_data_id='.$data_id.' and length(arrange_tcode)=7 and order_confirm=1';
        $criteria->condition = get_where($criteria->condition,!empty($arrange_tcode),'left(arrange_tcode,4)',$arrange_tcode,'"');
        $data = array();
        $data['data_list'] = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510');
        $data['data_id'] = $data_id;
        parent::_list($model,$criteria,'game_list_sign',$data);
    }

    // 赛事列表 名次公告
    public function actionGame_list_publicorder($game_id,$data_id){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $act = ($data_id>0) ? ' and id='.$data_id : '';
        $gamelist = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510'.$act);
        $data_id = (empty($data_id)) ? 0 : $data_id;
        $data_id = (!empty($gamelist)) ? $gamelist[0]->id : $data_id;
        $criteria->condition = 'game_id='.$game_id.' and game_data_id='.$data_id.' and total_order_confirm=1';
        $criteria->order = 'actual_total_upper_order';
        $data = array();
        $data['data_list'] = GameListData::model()->findAll('game_id='.$game_id.' and if_del=510');
        $data['data_id'] = $data_id;
        parent::_list($model,$criteria,'game_list_publicorder',$data);
    }
}
