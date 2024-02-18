<?php

class GameListData extends BaseModel {
	public $weight='';
	public $game_item='';
	public $game_player_team='';
	public $game_dg_level_name='';
	public $isSignOnline_name='';

    public function tableName() {
        return '{{game_list_data}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
		$s1="game_id,game_name,game_data_name,project_name,game_project_name,game_item,game_item_name";
		$s1.="project_id,game_name_id,F_SAMEGAME_ID,F_exclusive_ID,game_sex,game_age,game_age_name,game_mode";
		$s1.="game_mode_name,game_format,game_format_name,weight_min,weight_max,game_dg_level,game_player_team";
		$s1.="min_num_team,max_num_team,team_member,minimum_team,number_of_member,number_of_member_min,number_of_join_now";
		$s1.="game_group_star,game_group_end,game_apply_way_referee,isSignOnline,game_score_way,game_score_detail,game_online";
		$s1.="game_physical_examination,signup_date,game_check_way,signup_date_end,game_money,insurance,insurance_set,insurance_id,insurance_code,insurance_title,sum_insured,weight";
        return array(
            array($s1,'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'game_list' => array(self::BELONGS_TO, 'GameList', 'game_id'),
			'project_list' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
			'project_list' => array(self::BELONGS_TO, 'ProjectList', 'game_name_id'),
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'game_player_team'),
            'base_code_sex' => array(self::BELONGS_TO, 'BaseCode', 'game_sex'),
            'base_code_age' => array(self::BELONGS_TO, 'BaseCode', 'game_age'),
            'mall_insurance_id' => array(self::HAS_MANY, 'MallProductData', array('insurance_id'=>'id')),
            'level' => array(self::BELONGS_TO, 'ServicerLevel', array('game_dg_level'=>'card_xh'),'condition'=>'type in(210,1472)'),
            'base_isSignOnline' => array(self::BELONGS_TO, 'BaseCode', 'isSignOnline'),
            'base_game_check_way' => array(self::BELONGS_TO, 'BaseCode', 'game_check_way'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
			'id' => 'ID',
			'game_name' => '赛事名称',
			'game_data_code' => '比赛项目编号',
			'game_data_name' => '比赛项目',
			'game_id' => '比赛ID',
			'project_id' => '赛事项目',
			'project_name' => '赛事项目',
			'game_name_id' => '二级比赛项目',
			'game_project_name' => '二级比赛项目名称',
			'game_item' => '比赛项目',  // 关联project_list_game表ID
			'game_item_name' => '项目名称',
			// 'F_SAMEGAME_ID' => '同时报项目',
			'F_exclusive_ID' => '可兼报项目',
			'game_sex' => '参赛性别',
			'game_age' => '比赛组别',  // 关联base_code表GAMEGROUP类型ID'
			'game_age_name' => '组别名称',  // 关联base_code表GAMEGROUP类型ID
			'game_dg_level' => '参赛会员',  // 龙虎等级
			'game_mode' => '比赛方法',
			'game_mode_name' => '比赛方法名称',
			'game_format' => '赛制',
			'game_format_name' => '赛制名称',
			'weight_min' => '最小公斤级',
			'weight_max' => '最大公斤级',
			'game_player_team' => '比赛方式',
			'min_num_team' => '参赛队数（最少）',  // 最小队数
			'max_num_team' => '参赛队数（最多）',  // 最大队数
			'team_member' => '队数人数（最多）',  // 团队最大参与人数
			'minimum_team' => '队数人数（最少）',  // 团队最小参与人数
			'number_of' => '人数/队数',  // 原：参与数
			'number_of_member' => '报名名额（个）',  // 最大参与数
			'number_of_member_min' => '参赛人数（最少）',  // 最小参与数
			'number_of_join_now' => '当前参与人数',
			'game_group_star' => '参赛年龄（最大）',  // 可报名出生开始日期
			'game_group_end' => '参赛年龄（最小）',  // 可报名出生结束日期
			'game_apply_way_referee' => '裁判报名方式',
			'isSignOnline' => '报名方式',
			'game_physical_examination' => '体检有效日期',
			'signup_dateing' => '报名时间',
			'signup_date' => '报名开始时间',
			'game_check_way' => '报名审核',//关联base_code表CHECK类型id 792-人工，793自动
			'signup_date_end' => '报名结束时间',
			'game_online' => '上线状态',
			'online_name' => '上线',
			'uDate' => '更新时间',
			'game_score_way' => '得分方式',
			'game_score_detail' => '得分规则',
			'game_money' => '报名费用（元）',
			'insurance' => '保险费用',
			'insurance_set' => '保险要求',  // 关联base_code表INSURANCESET类型ID',
			'insurance_id' => '保险商品ID',  // 关联mall_product_data表ID',
			'insurance_code' => '保险货号',
			'insurance_title' => '保险名称',
			'sum_insured' => '最高金额',

			'isSignOnline1' => '报名方式',
			'group_num' => '人数/队伍要求',
			'game_money1' => '报名费',
			'weight_level' => '公斤级',
			'number_of1' => '人数/队伍要求',
		);
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }


 public function getProjects($id=0) {
   $tmp=$this->findAll('game_id='.$id.' limit 2');
   $rs=''; 
   $r=0;
   foreach($tmp as $v){
     if($r<2)
     { $r++; $rs.=' '.$v->project_name; }
    }
    $rs.=($r>=2) ?'...' :'';
   return $rs;
  }
				

	protected function afterFind() {
        parent::afterFind();
        if ($this->id != null) {
			if(empty($this->game_dg_level)){
				$this->game_dg_level_name = '不限';
			}else{
				$game_dg_level_ServicerLevel=ServicerLevel::model()->findBySql('select GROUP_CONCAT(card_name) as card_name from servicer_level where type in(1472)  and card_xh in (' . $this->game_dg_level . ')');
				$this->game_dg_level_name = $game_dg_level_ServicerLevel->card_name;
			}
			$isSignOnline_BaseCode=BaseCode::model()->find("f_id=".$this->isSignOnline);
            $this->isSignOnline_name = $isSignOnline_BaseCode->F_NAME;
        }
    }

	protected function beforeSave(){
		parent::beforeSave();
		if(empty($this->game_data_code)){
			$project = ProjectList::model()->find('id='.$this->project_id);
			$game_list = GameList::model()->find('id='.$this->game_id);
			if(!empty($project)){
				$zero = '00';
				$len = strlen($project->CODE);
				$len1 = strlen($game_list->game_code);
				$len2 = $len+$len1;
				$day = $this->find('game_id='.$this->game_id.'  and left(game_data_code,'.$len2.')="'.$game_list->game_code.$project->CODE.'" order by game_data_code DESC');
				$code = (!empty($day)) ? substr($day->game_data_code,$len2) : $zero;
				$this->game_data_code = $game_list->game_code.$project->CODE.substr((101+substr($code, -2)),1,2);
			}
		}
		if($this->isNewRecord){
			if(empty($this->team_member)) $this->team_member = 2;
			if(empty($this->minimum_team)) $this->minimum_team = 2;
		}
		return true;
	}
	
	
  	/**
  	 * 赛事项目信息
  	 */
	public function getGameDataInfoById($game_data_id){
  		return $this->find("id=".$game_data_id);
  	}
	
    /**
	 * 判断用户是否符合报名竞赛项目条件
	 * $param array(visit_gfid,game_data_id)
	 * $game_data  赛事项目信息
	 * @return array('game_data','gf_data',sex,born,club,lh)
	 */
	public function CheckAppliedProject($param,$game_data){
		$data=array('sex'=>0,'born'=>0,'club'=>0,'lh'=>0,'real'=>0);
		$gfid=empty($param['visit_gfid'])?'':$param['visit_gfid'];
		if(empty($game_data)){
			$game_data_id=empty($param['game_data_id'])?'':$param['game_data_id'];
			$game_data=$this->getGameDataInfoById($game_data_id);
			if(empty($game_data)){
				set_error($data,1,'申请报名失败',0);
				return $data;
			}
			if(($game_data['game_player_team']==665&&$game_data['number_of_join_now']>=$game_data['number_of_member'])
				||($game_data['game_player_team']!=665&&$game_data['number_of_join_now']>=$game_data['max_num_team'])){
				set_error($data,1,"申请报名失败,报名名额已满！",1);
			}
	        $data['game_data']=$game_data;
		}
		$gfinfo=userlist::model()->GetRegistrationDatas(array('visit_gfid'=>$gfid,'project_id'=>$game_data['project_id']),0);//申请人信息
		if(empty($gfinfo)){
			set_error($data,1,'申请报名失败，申请人信息异常',0);
			return $data;
		}
		$data['real']=1;
        $data['gf_data']=$gfinfo;
		if($game_data['game_sex']==220||$game_data['game_sex']==$gfinfo['real_sex']){//判断性别
			$data['sex']=1;
			set_error($data,2,'申请报名失败,不符合竞赛项目报名条件',0);
		}
		$start=strtotime($game_data['game_group_star']);
		$end=strtotime($game_data['game_group_end']);
		$born=strtotime($gfinfo['born']);
		if(($start==0&&$end==0)||($start<=$born&&$end==0)||($start==0&&$born<=$end)||($start<=$born&&$born<=$end)){//判断出生日期
			$data['born']=1;
			set_error($data,2,'申请报名失败,不符合竞赛项目报名条件',0);
		}
		foreach($gfinfo['lh_datas'] as $k=>$v){//判断项目学员及等级
			if($v['club_id']!=0){
				$data['club']=1;
				set_error($data,2,'申请报名失败,不符合竞赛项目报名条件',0);
			}
			if($game_data['game_dg_level']==-1||$game_data['game_dg_level']==$v['member_level']){
				$data['lh']=1;
				set_error($data,2,'申请报名失败,不符合竞赛项目报名条件',0);
			}
		}
        return $data;
	}
	
}
