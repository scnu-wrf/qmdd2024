<?php

class  GameListArrange extends BaseModel {
    public $arrange_list = '';
    public $arrange_tab1 = '';
    public $team_data = '';
    public $team_ida = '';
    public $sign_ida = '';
    public $colour = '';
    public $game_play_id = '';
    public $tean_name_ida = '';
    public function tableName() {
        return '{{game_list_arrange}}';
    }

    /**
     * 模型验证规则
     */
     public function rules() {
        return array(
            // array('arrange_tcode', 'required', 'message' => '{attribute} 不能为空'),
            // array('arrange_tname', 'required', 'message' => '{attribute} 不能为空'),
            // array('sign_id', 'numerical', 'max' => 1000),
            // array('team_id', 'numerical', 'max' => 1000),
            array('arrange_code,arrange_tcode,arrange_tname,describe,game_id,fater_id,game_name,game_data_id,game_data_name,
                project_id,game_project_name,game_player_id,game_format,if_votes,if_votes_name,rounds,matches,game_site,star_time,
                end_time,game_date,upper_order,upper_code,game_order,game_mark,game_score,group_sort_code,total_sort_code,
                total_sore_base,arrange_tname,game_over,game_over_name,votes_star_time,votes_end_time,school_report,reasons_for_failure,
                ball_right,show_score,state,state_qmddid,game_group_name,group_sore,group_sore_mark,group_sore_order,team_id,team_name,
                team_logo,sign_id,sign_name,sign_logo,colour,runway,upper_order_user,upper_code_user,sign_ida,if_rele,rele_date_start,
                game_mode,group_score,group_score_mark,group_score_order,total_score_mark,total_score_order,chief_umpire,game_time,
                score_record,bureau_num,achievement_show_title,gf_game_score,gf_votes_score,victory_num,transport_num,ball_right,
                order_confirm,score_confirm,total_upper_order,actual_total_upper_order', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'game_over'),
            'game_list' => array(self::BELONGS_TO, 'GameList', array('game_id'=>'id')),
            'game_list_data' => array(self::BELONGS_TO, 'GameListData', array('game_data_id'=>'id')),
            'game_list_order' => array(self::BELONGS_TO, 'GameListOrder', array('id'=>'arrange_id'),'condition'=>'length(arrange_tcode)=2'),
            'game_sign_lista' => array(self::BELONGS_TO, 'GameSignList', 'sign_ida'),
            'game_team_tablea' => array(self::BELONGS_TO, 'GameTeamTable', 'team_ida'),
            'game_team_table' => array(self::BELONGS_TO, 'GameTeamTable', 'game_player_id'),
            'base_code_game_format' => array(self::BELONGS_TO, 'BaseCode', 'game_format'),
            'base_game_player_id' => array(self::BELONGS_TO, 'BaseCode', 'game_player_id'),
            'base_if_rele' => array(self::BELONGS_TO, 'BaseCode', 'if_rele'),
            'base_game_mode' => array(self::BELONGS_TO, 'BaseCode', 'game_mode'),
            'base_is_promotion' => array(self::BELONGS_TO, 'BaseCode', 'is_promotion'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'arrange_code' => '赛程编码',
            'arrange_tcode' => '赛程编码',
            'arrange_tname' => '参赛队伍/选手',  // 名称/签号   项目/赛程/组/场/签号
            'describe' => '赛程描述',
            'game_id' => '赛事',//ID,关联base_code表game_list表
            'fater_id' => '上级ID',  // 分场管理
            'game_name' => '赛事名称',
            'game_data_id' => '比赛项目',//id,关联game_list_data表id
            'game_data_name' => '竞赛项目名称',//关联game_list_data表
            'game_area' => '赛事等级',  // 161世界级，160国家级，159省级，162社区单位级',
            'game_mode' => '比赛方法',  // 关联base_code表GAME_MODE类型ID 661考核赛 662对抗赛 663表演赛',
            'project_id' => '赛事项目',
            'game_project_name' => '赛事项目',
            'game_player_id' => '参赛队伍/选手',  // 团队/个人 关联base_code表MAN_TEAM类型ID 665-个人 666-团队',
            'game_format' => '赛制',
            'rounds' => '轮次名称',
            'matches' => '场次',
            'game_site' => '比赛场地',
            'if_votes' => '是否投票',
            'if_votes_name' => '是否开通投票说明',
            'votes_star_time' => '投票开始时间',
            'votes_end_time' => '投票结束时间',
            'star_time' => '比赛开始时间',//采用24小时制
            'end_time' => '比赛结束时间',//采用24小时制
            'game_date' => '添加时间',
            'game_over' => '比赛状态',//0未比赛，1在比赛，2比赛结束
            'game_over_name' => '比赛状态说明',
            'uDate' => '修改日期',
            'school_report' => '成绩单扫描件',//多图使用逗号“,”分开,路径及命名见base_parh表
            'state' =>  '状态',//关联base_code表STATE类型状态id：371-374
            'state_name' => '审核名称',
            'state_qmddid' => '审核管理员',//GFID，关联qmdd_administrators表ID
            'state_qmddname' => '管理员名称',
			'reasons_for_failure' => '审核备注',
			'game_group_name' => '循环分组名称',
			'upper_order' =>'小组晋级名次',
			'upper_code' =>'晋级编码' ,
			'game_order' =>'本场名次' ,
			'game_mark' => '本场成绩' ,
			'game_score' =>'积分',  // 本场得分
			'group_sort_code' => '小组排序编码',
			'total_sort_code' => '总排序编码',
			'total_sore_base' => '当场比赛相对总名次值',
            'team_id' => '参赛团队ID',
            'team_name' => '参赛团队名称',
            'team_logo' => '团队logo',
            'sign_id' => '参赛成员ID',
            'sign_name' => '参赛队伍/选手',
            'sign_logo' => '成员logo',
            'colour' => '颜色',
            'runway' => '跑道',
            'upper_order_user' => '实际小组名次', // 实际比赛取得的小组名次
            'upper_code_user' => '晋级方向编码',
            'group_score' => '小组得分',
            'group_score_mark' => '小组成绩',
            'group_score_order' => '小组名次',
            'total_score_mark' => '总成绩',
            'total_score_order' => '总成绩排名次',
            'if_rele' => '是否发布',
            'rele_date_start' => '开始发布时间',
            'is_promotion' => '胜负',  // (赛事结果)，关联base_code表EVENT_RESULT类型id 1006胜 1007 平 1008 负',
            'chief_umpire' => '主裁判',
            'rem_time' => '游戏计时',
            'winning_bureau' => '获胜局',
            'bureau_score' => '局比分',
            'single_score' => '单杆分',
            'score_record' => '比分记录',
            'del_score_record' => '删除记录,留作恢复',
            'gf_game_score' => '积分(赛事)',
            'gf_votes_score' => '积分(投票)',
            'bureau_num' => '局数',  //（如：五局三胜，三局两胜）'
            'victory_num' => '胜场次',
            'transport_num' => '负场次',
            'achievement_show_title' => '成绩标题',  // 用于前端展示成绩排名的成绩标题（根据arrange_tcode关联表game_list_order的arrange_tcode，对应achievement_show）
            'ball_right' => '球权',
            'order_confirm' => '成绩确认',
            'score_confirm' => '积分确认',
            'total_order_confirm' => '名次确认',  // 总
            'total_score_confirm' => '积分确认',  // 总
            'upper_order_user' => '实际比赛取得的小组名次',
            'upper_code_user' => '实际比赛取得的小组名次后的晋级方向编码',
            'total_upper_order' => '总名次',
            'actual_total_upper_order' => '实际晋级总名次',

            'type' => '类型',
            'group' => '小组',
            'game_time' => '比赛日期',
            'game_ready_time' => '比赛起始时间',
            'arrange_tname1' => '签号',
            'arrange_tname2' => '项目/赛程/组/场/签号',
            'upper_code1' => '晋级方向',

            /* total_score */
            'gf_game_score_total' => 'GF赛事积分（总）',
            'gf_rank' => '名次',
            'describe1' => '对阵',
            'winning_bureau1' => '比分',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    function set_code($gid,$gdid,$atc,$ccname,$describe='',$gformat='',$game_mode='') {
        $w1="arrange_tcode='".$atc." '";
        $tmp0=$this->find('game_id='.$gid.' and game_data_id='.$gdid.' and '.$w1);
        if(empty($tmp0)){
            $this->isNewRecord=true;
            $this->arrange_tcode=$atc;
            $this->arrange_tname=$ccname;
            $this->game_id=$gid;
            $this->game_data_id=$gdid;
            $this->describe=$describe;
            $this->game_format=$gformat;
            $this->game_mode=$game_mode;
            unset ($this->id);
            $this->save();
        }
        if(!empty($gformat)){
            GameListArrange::model()->updateAll(array('game_format'=>$gformat),'game_id='.$gid.' and game_data_id='.$gdid.' and arrange_tcode="'.substr($atc,0,4).'"');
        }
    }

    //添加一个赛程
    public function add_new_arrange($game_id,$game_data_id) {
        if(($game_id>0)&&($game_data_id>0)){
            $w1=" and substr(arrange_tcode,4,1)<>' ' and substr(arrange_tcode,5,1)=' '";
            $tmp=$this->find(array(
                'order'=>'arrange_tcode desc',
                'condition'=>'game_data_id='.$game_data_id.$w1,
            ));
            if (empty($tmp)){
                $tmp1= GameListData::model()->find('id='.$game_data_id);
                $tmp2= ProjectList::model()->find('id='.$tmp1->project_id);
                $tc=substr($tmp2->CODE,0,2);
                $this->set_code($game_id,$game_data_id,$tc,$tmp2->project_name);
                $tc1='01';
            } 
            else{
               $tc0=trim($tmp->arrange_tcode);
               $tc=substr($tc0,0,2);
               $tc0=1+intval(substr($tc0,2,2));
               $tc1=(($tc0<10) ? '0' : '').$tc0;
            }
            $this->set_code($game_id,$game_data_id,$tc.$tc1,'第'.$tc1.'阶段');
        }
    }

    // 最大5队，循环成10
    function get_round($num) {
       $rs=array('01,02','03,01','02,03');
       if($num==4) $rs=array('01,02','03,04','01,03','02,04','01,04','02,03');
       if($num==5) $rs=array('01,02','03,04','01,05','02,03','04,05',
        '01,03','02,04','02,05','01,04','03,05');
       return $rs;
    }

    // 输入多少就是多少
    function get_strlen($num){
        $data = array();
        for($i=1;$i<=$num;$i++){
            for($j=1;$j<=$num;$j++){
                $f = ($i<10) ? '0'.$i : $i;
                $g = ($j<10) ? '0'.$j : $j;
                if($f==$g) continue;
                $h = $f.','.$g;
                $k = explode(',',$h);
                if($k[0]>$k[1]) continue;
                array_push($data,$h);
            }
        }
        // 随机打散数组
        // shuffle($data);
        return $data;
    }

    function isOdd($num){
        return ($num % 2 == 0) ? true : false;
    }

    public function add_new_group($gr_id,$gcode,$gname,$gnum,$gformat,$game_mode,$group_num='') {
        $tmp=$this->find('id='.$gr_id);
        $odd = $this->isOdd($gnum);
        if (!empty($tmp)){
            $gcode=trim($gcode);
            $tc=substr($tmp->arrange_tcode,0,4).$gcode;
            $game_id=$tmp->game_id;
            $game_data_id=$tmp->game_data_id;
            if(strlen($gname)<2) $gname.='组';
            $this->set_code($game_id,$game_data_id,$tc,$gname,'',$gformat,$game_mode);//小组名称
            $gn=0;
            if($gformat==988){//循环赛
                $ar=$this->get_strlen($gnum);
                foreach($ar as $v){
                    $va=explode(',',$v);
                    $gn=$gn+1;
                    $tc1=$tc.(($gn<10) ? '0' : '').$gn;
                    $tstr=$gcode.$va[0].' vs '.$gcode.$va[1];
                    $this->set_code($game_id,$game_data_id,$tc1,'第'.$gn.'场',$tstr,$gformat,$game_mode);
                    $this->set_code($game_id,$game_data_id,$tc1.'01',$gcode.$va[0],'',$gformat,$game_mode);
                    $this->set_code($game_id,$game_data_id,$tc1.'02',$gcode.$va[1],'',$gformat,$game_mode);
                }
            } else{ //985淘汰赛
                // 判断对抗类
                $md = array();
                if($game_mode==662){
                    for($k=1;$k<=$gnum;$k++){
                        array_push($md,$k);
                    }
                    $array_odd = array_filter($md,function($var){
                        return ($var & 1);
                    });
                    // $array_odd = array_filter($md);
                    // $array_odd = array_map(function ($var) { return $var ?: null; }, $array_odd);
                    $s_num = 1;
                    foreach($array_odd as $od){
                        // $s_num++;
                        $g_num = $s_num+1;
                        $gn = $gn+1;
                        $gh = $od+1;
                        $l_num = ($od<10) ? '0'.$od : $od;
                        $k_num = ($gh<10) ? '0'.$gh : $gh;
                        $tc1 = $tc.(($gn<10) ? 0 : '').$s_num;
                        // $tstr = '第'.$gh.'队 vs 第'.$od.'队';
                        $tstr = $gcode.$l_num.' vs '.$gcode.$k_num;
                        $this->set_code($game_id,$game_data_id,$tc1,'第'.$gn.'场',$tstr,$gformat,$game_mode);
                        $this->set_code($game_id,$game_data_id,$tc1.'01',$gcode.$l_num,'',$gformat,$game_mode);
                        $this->set_code($game_id,$game_data_id,$tc1.'02',$gcode.$k_num,'',$gformat,$game_mode);
                        $s_num++;
                    }
                }
                else{
                    $n = 1;
                    for($i=1;$i<=$group_num;$i++){
                        $gn = $gn+1;
                        $tc1 = $tc.(($gn<10) ? '0' : '').$gn;
                        $this->set_code($game_id,$game_data_id,$tc1,'第'.$i.'场','',$gformat,$game_mode);
                        for($j=1;$j<=$gnum;$j++){
                            $k = ($j<10) ? '0'.$j : $j;
                            $l = ($n<10) ? '0'.$n : $n;
                            $this->set_code($game_id,$game_data_id,$tc1.$k,$gcode.$l,'',$gformat,$game_mode);
                            $n++;
                        }
                    }
                }
            }
        }
    }
    function get_echar($i){
        return substr(' ABCDEFGHIJKLMNOPRSTUVWXYZ',$i,1);
    }

    public function getGame_arrange($game_data_id) {
        $cooperation=$this->findAll(array(
            'order'=>'arrange_tname',
            'group'=>'arrange_tname',
            'condition'=>'game_data_id='.$game_data_id,
        ));
        $arr = array();
		$r=0;
        foreach($cooperation as $v){
			$arr[$r]['id'] = $v->id;
			$arr[$r]['arrange_tcode'] = $v->arrange_tcode;
			$arr[$r]['game_data_id'] = $v->game_data_id;
			$arr[$r]['arrange_tname'] = $v->arrange_tname;
			$arr[$r]['team_id'] = $v->team_id;
			$arr[$r]['team_name'] = $v->team_name;
			$arr[$r]['sign_id'] = $v->sign_id;
			$arr[$r]['sign_name'] = $v->sign_name;
			$arr[$r]['upper_order'] = $v->upper_order;
			$arr[$r]['upper_code'] = $v->upper_code;
			$arr[$r]['is_promotion'] = $v->is_promotion;
			$arr[$r]['game_over'] = $v->game_over;
			$arr[$r]['game_over_name'] = $v->game_over_name;
			$arr[$r]['total_score_mark'] = $v->total_score_mark;
			$arr[$r]['total_score_order'] = $v->total_score_order;
			$arr[$r]['fater_id'] = $v->fater_id;
			$arr[$r]['team_logo'] = $v->team_logo;
			$arr[$r]['sign_logo'] = $v->sign_logo;
			$r=$r+1;
        }
        return $arr;
    }

    protected function beforeSave() {
        parent::beforeSave();
        if ($this->isNewRecord) {
            $this->game_date = date('Y-m-d h:i:s');
        }
        if(empty($this->club_id)){
            $tmp = GameList::model()->find('id='.$this->game_id);
            $this->club_id=$tmp->game_club_id;
        }
        $path = BasePath::model()->get_www_path();
        $pic = '2019/06/17/09/85_qf_600__1709291607910.png';
        if($this->game_player_id==665){
            $this->sign_logo = (empty($this->sign_logo)) ? $pic : str_replace($path,'',$this->sign_logo);
        }
        elseif(!empty($this->game_player_id)){
            $this->team_logo = (empty($this->team_logo)) ? $pic : str_replace($path,'',$this->team_logo);
        }
        if(!empty($this->game_player_id) && empty($this->f_sname)){
            $fname = ($this->game_player_id==665) ? $this->sign_name : $this->team_name;
            $this->f_sname = $fname;
        }
        $this->uDate = date('Y-m-d h:i:s');
        return true;
    }

    protected function afterFind() {
        parent::afterFind();
        // $pa = BasePath::model()->get_www_path();
        // if(!empty($this->team_logo)) {
        //     $this->team_logo = $pa.$this->team_logo;
        // }
        // if(!empty($this->sign_logo)) {
        //     $this->sign_logo = $pa.$this->sign_logo;
        // }
    }

    //ID,局分，局小分，球权
    function update_term($id){
        $tmp21= $this->find("id=".$id);
        $win=$tmp2['game_order'];
        $data_id=$tmp21->game_data_id;
        $w1=' game_data_id= '.$tmp21->game_data_id;
        $w1=" and upper_order=".$win." and left(arrange_tcode,7)='".substr($tmp21->arrange_tcode,0,7)."' AND upper_code<>' '";
        $tmp22= $this->find($w1); //'要'
        if(!empty($tmp22)){
            $data1=array(
                'sign_id'=>$tmp21->sign_id,
                'sign_name'=>$tmp21->sign_name,
                'team_id'=>$tmp21->team_id,
                'team_name'=>$tmp21->team_name,
            );
            $d1="game_data_id=".$data_id." AND arrange_tcode='".$tmp22->upper_code."' ";
            $this->updateAll($data1,$d1);
        }
    }

    //保存比赛分数
    //$data 分数记录，$game_over比赛结束
    public function save_time_score($data,$game_over,$show_title=""){
        $data1 =array(
            'a'=>GameListArrange::model()->score_to_str($data['id_0'],0,$data),
            'b'=>GameListArrange::model()->score_to_str($data['id_1'],1,$data),
        );
        $tmp1=$this->find('id='.$data['id_0']);
        $score_record=base64_encode(json_encode($data1));//当前记录   
        $score_record=(empty($tmp1->score_record) ? '' : $tmp1->score_record.',').$score_record;
        for($i=0;$i<2;$i++){
            $this->save_score_ing($i,$data,$score_record,$game_over,$show_title);
        }
    }

    function score_to_str($id,$r,$data){
        $ssc = (isset($data['single_score_'.$r])) ? $data['single_score_'.$r] : '';
        return array(
            (($id==0) ? "rem_time" :  'id' ) => $id,
            'winning_bureau' => $data['winning_bureau_'.$r],
            'bureau_score' => $data['bureau_score_'.$r],
            'single_score' => $ssc,
            'ball_right'=>$data['ball_right_'.$r],
            'rem_time' => $data['rem_time'],
            'uDate' => date('Y-m-d H:i:s'),
        );
         
    }

    //更改比赛场次成绩
    function update_vs_score($id,$stitle,$sscore){
        $tmp1=$this->find('id='.$id);
        $str_tcode=substr($tmp1->arrange_tcode,0,7);
        $w1="game_data_id=".$tmp1->game_data_id." and arrange_tcode='".$str_tcode." '";
        $udata['achievement_show_title'] =$stitle;
        $udata['show_score'] =$sscore;
        $udata['game_over'] =$tmp1->game_over;
        $this->updateAll($udata,$w1);
    }



    //ID,局分，局小分，球权
    function save_score_ing($r,$data,$s_record,$game_over,$show_title){
        $id=$data['id_'.$r];
        $model = GameListArrange::model()->find('id='.$id);
        $bureau_scoreb=$data['winning_bureau_'.(($r==0) ? '1' :'0')];
        $udata=$this->score_to_str(0,$r,$data);
        $udata['game_over']=$game_over;
        $udata['achievement_show_title'] =$show_title;
        $udata['show_score']=$data['winning_bureau_'.$r];
        $udata['bureau_num']=$data['bureau'].','.$data['bureau_num'];
        if(isset($data['GameListArrange']['chief_umpire'])){
            $udata['chief_umpire']=$data['GameListArrange']['chief_umpire'];
        }
        $tmp1=$this->find('id='.$id);
        $udata['score_record']=$s_record;
        if($game_over==908){
            $is_promotion=0;$order=0;$score=0;
            $this->get_game_order($data['winning_bureau_'.$r],$bureau_scoreb,$is_promotion,$order,$score);
            $score = (($model->team_name=='轮空' || $model->sign_name=='轮空') && (empty($model->team_id) && empty($model->sign_id))) ? 0 : $score;
            $udata['game_order'] = $order;
            $udata['gf_game_score'] = $score;
            $udata['is_promotion'] = $is_promotion;
            $udata['game_rank'] = $order;
            $udata['end_time'] = date('Y-m-d H:i:s');
            if($is_promotion==1006 && $model->game_format==985){
                $udata['game_score'] = 1;
            }
        }
        $this->updateAll($udata,'id='.$id);
    }

    //检查两个队的成绩及名称
    function get_game_order($sc1,$sc2,&$is_promotion,&$order,&$score){
        $sc1= intval($sc1);
        $sc2= intval($sc2);
        $order = 2;
        $is_promotion = 1008;
        $score=1;
        if($sc1>$sc2){
            $order = 1;
            $is_promotion = 1006;
            $score=3;
        }
        else if($sc1==$sc2){
            $order = 1;
            $is_promotion = 1007;
            $score=2;
        }
    }

    // 发送分数变化通知信息
    public function sendMessage($id){
        $channel_id = 44;
        $sg = 24;
        $tmp=$this->find('id='.$id);
        $data = array(
            "game_data_id" => $tmp->game_data_id,
            "matches_code" => $tmp->arrange_tcode,
            "sign_no" => $tmp->arrange_tname,
            "game_over" => $tmp->game_over,
            "game_over_name" => $tmp->game_over_name,
            "show_score" => $tmp->show_score
        );
        // if($tmp->game_over==901){
        //     $data["show_score"] = $tmp->show_score;
        // }
        game_message($channel_id,0,$tmp->game_data_id,$data,$sg);
    }

}
