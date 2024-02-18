<?php

class ProjectListGame extends BaseModel {

    public function tableName() {
        return '{{project_list_game}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('project_id','required','message'=>'{attribute} 不能为空'),
            array('project_id,project_code,game_item,game_model,game_sex,game_age,game_weight,game_man_num,game_team_num,game_team_mem_num', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_sex' => array(self::BELONGS_TO, 'BaseCode', 'game_sex'),
            'base_age' => array(self::BELONGS_TO, 'BaseCode', 'game_age'),
            'base_weight' => array(self::BELONGS_TO, 'BaseCode', 'game_weight'),
            'base_man_num' => array(self::BELONGS_TO, 'BaseCode', 'game_man_num'),
            'base_team_num' => array(self::BELONGS_TO, 'BaseCode', 'game_team_num'),
            'base_team_man_num' => array(self::BELONGS_TO, 'BaseCode', 'game_team_mem_num'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
           'id' => 'ID',
           'project_id' => '项目ID',  // 关联project_list表ID',
           'project_code' => '竞赛项目编号',
           'game_item' => '比赛项目',
           'game_model' => '比赛方式',  // 多值使用逗号“,”隔开，关联base_code表MAN_TEAM值',
           'game_sex' => '要求性别',  // 关联base_code表Yes_No类型ID',
           'game_age' => '要求年龄',  // 关联base_code表Yes_No类型ID',
           'game_weight' =>'要求体重',  // 关联base_code表Yes_No类型ID',
           'game_man_num' => '要求人数',  // 关联base_code表Yes_No类型ID',
           'game_team_num' => '要求队数',  // 关联base_code表Yes_No类型ID',
           'game_team_mem_num' => '要求队数人数',  // 关联base_code表Yes_No类型ID',
        );
    }

    public function getProjectGame_id2() {
        $cooperation= $this->getProjectGame_id2_all();
        $arr = array();$r=0;
        foreach ($cooperation as $v) {
                $arr[$r]['id'] = $v->id;
                $arr[$r]['project_id'] = $v->project_id;
                $arr[$r]['game_sex'] = $v->game_sex;
                $arr[$r]['game_item'] = $v->game_item;
                $arr[$r]['game_model'] = $v->game_model;
                $arr[$r]['game_weight'] = $v->game_weight;
                $r=$r+1;
        }
        return $arr;
    }

    public function getProjectGame_id2_all() {
        return  $this->findAll();
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        parent::beforeSave();
        if(empty($this->project_code)){
            $project = ProjectList::model()->find('id='.$this->project_id);
            if(!empty($project)){
                $len = strlen($project->CODE);
                $zero = '00';
				$day = $this->find('project_id='.$this->project_id.' and left(project_code,'.$len.')="'.$project->CODE.'" order by project_code DESC');
				$code = (!empty($day)) ? substr($day->project_code,$len) : $zero;
				$this->project_code = $project->CODE.substr((101+substr($code, -2)),1,2);
            }
        }
        return true;
    }

    public function getAll(){
        return $this->findAll('project_id in' .$project_id);
    }
	public function getItem($project_id){
        return $this->findAll('project_id =' .$project_id);
    }

    public function getCode($game_model){
        return $this->findAll('game_model=' . $game_model);
    }
}
