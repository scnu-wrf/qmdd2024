<?php

class ProjectList extends BaseModel {

    public $project_game = '';
    public $project_id = '';
    public $game_item = '';
    public $game_model = '';
    public $game_sex = '';
    public $game_age = '';
    public $game_weight = '';
    public $game_man_num = '';
    public $game_team_num = '';
    public $game_team_mem_num = '';
    public $project_description_temp='';
    public $ProjectSerivce='';
    
      /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{project_list}}';
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'visible' => array(self::BELONGS_TO, 'BaseCode', 'IF_VISIBLE'),
            'default' => array(self::BELONGS_TO, 'BaseCode', 'IF_DEFAULT'),
            'project_list_game' => array(self::HAS_MANY, 'ProjectListGame', array('project_id' => 'id')),
        );
    }

    /*** 模型验证规则*/
    public function rules() {
      return $this->attributeRule();
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }

    public function attributeSets() {
        return array(
        'id' => 'ID',
        'project_type' => '项目类型:k',  // 1=大项目，2是二级项目
        'CODE' => '项目编码:k',
		'financial_code'=>'财务编码:k',
        'IF_VISIBLE' => '是否上线:k',
        'IF_DEFAULT' => '是否显示:k',
        'if_visible_name' => '是否显示',
        'if_default_name' => '默认显示',
        'project_name' => '项目名称:k',
		'project_e_name'=>'英文名称',
        'project_simple_code' => '首字母简写',
        'project_logo' => '项目图标',
        'project_jl' => '单位教练最低',
        'project_cp' => '裁判员最低',
        'project_m' => '管理员最低',
        'project_serivce_cp' => '裁判员数量',
        'project_serivce_jl' => '教练员数量',
        'project_serivce_m' => '管理员数量',
        'project_description' => '介绍详情',  // 存放路径和命名根据base_parh表查询'
        'project_description_temp'=>'项目简介',
        'if_del' => '是否删除',  // 关联base_code表yes_no类型id 648=否，649是'
        'uDate' => '更新时间',
        'project_name1' => '赛事项目',
        'project_name2' => '比赛项目',
        'project_id' => '项目ID',
        'game_item' => '竞赛项目',
        'game_model' => '比赛方式',
        'game_sex' => '性别要求',
        'game_age' => '要求年龄',
        'game_weight' =>'要求体重',
        'game_man_num' => '参赛人数',
        'game_team_num' => '参赛队数',
        'game_team_mem_num' => '队数人数',
        );
    }
    public function picLabels() {return 'project_logo';}
    public  function pathLabels(){ return '';}
       //关联数据自动处理
    public function getrelations() {
      $s1='goods,f_goodsid:id,f_code&f_name&f_scode&f_sname&f_specs;';     
      return '';
    }
    public function keySelect(){
        return array('IF_VISIBLE=1','id','project_name:project_name');
    }
    public function labelsOfList()
    {
        return array('id', 'project_type', 'CODE','financial_code','IF_VISIBLE',
            'IF_DEFAULT','project_name', 'project_e_name','uDate',);
    }

    public function getProject_id2($act='') {
        $tmp= $this->getProject_id2_all($act);
        return toIoArray($tmp,'id,fater_id,project_name,project_type,CODE');
    }

    public function getProject_id2_all($act='') {
        return  $this->findAll($act);
    }

    public function getName($id) {
        return  $this->readValue('id=' . $id,'project_name');
    }

    public function getAll() {
        return $this->findAll();
    }

    public function getProject($ptype=1) {
        return $this->findAll('project_type in('.$ptype.')');
    }
	
	public function getClubProject() {
        return $this->getProject_id2('1');
    }

    public function getCode($IF_VISIBLE) {
        return $this->findAll('IF_VISIBLE=' . $IF_VISIBLE);
    }
  
    protected function afterFind() {
        parent::afterFind();
        return true;
    }

    protected function beforeSave() {
        parent::beforeSave();

        // 图文描述处理
        $basepath = BasePath::model()->getPath(183);
        if ($this->project_description_temp != '') {
            // 判断是否存储过，没有存储过则保存新文件
            if ($this->project_description != '') {
                set_html($this->project_description, $this->project_description_temp, $basepath);
            } else {
                $rs = set_html('', $this->project_description_temp, $basepath);
                $this->project_description = $rs['filename'];
            }
        } else {
            $this->project_description = '';
        }
        $this->uDate = date('Y-m-d H:i:s');
        return true;
    }

	public function getShowProject(){
        $tmp=$this->findAll();//'if_del=648 and IF_VISIBLE=649'
		return toIoArray($tmp,'id,project_name as name');
	}
}
