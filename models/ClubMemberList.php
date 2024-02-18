<?php


class ClubMemberList extends BaseModel {


    public $member_level_register_time='';
    public $start_time='';
    public $unbund_time='';
    public $end_time='';

    public function tableName() {
        return '{{club_member_list}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
       // $s2=$this->safeField();
        return array(
            ['gf_account,member_project_id,project_level_xh', 'required', 'message' => '{attribute} 不能为空'],
            array($this->safeField(),'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
            'base_code_sex' => array(self::BELONGS_TO, 'BaseCode', 'real_sex'),
            'base_code_status' => array(self::BELONGS_TO, 'BaseCode', 'club_status'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'member_project_id'),
            'club_member' => array(self::BELONGS_TO,'ClubMember','user_member_id'),
            'gf_user' => array(self::BELONGS_TO, 'userlist', 'member_gfid'),
            'upgrade_list' => array(self::BELONGS_TO, 'ClubMemberUpgrade',array('member_gfid'=>'gf_id','member_project_id'=>'project_id','project_level_xh'=>'member_level_xh')),
            // 不要删除这个level_xh   不要删除这个level_xh   不要删除这个level_xh
            'level_xh' => array(self::BELONGS_TO,'ServicerLevel',array('project_level_xh'=>'card_xh'),'condition'=>'type in(1472,210)'),
        );
    }

    /**
     * 属性标签
     */ 
    public function attributeLabels() {
        return array(
            'id'=>'ID',
            'club_id' => '所属单位',
            'club_name'=>'单位名称',
            'member_gfid'=>'社区成员GFID',
            'gf_account'=>'账号',
            'zsxm' => '姓名',
            'real_sex'=>'性别',
            'member_project_id'=>'项目',//'项目ID，关联project_list表id'
            'project_name'=>'项目名称',
            'project_level_id'=>'龙虎等级',//关联member_card表id
            'project_level_xh'=>'龙虎等级',
            'project_level_name'=>'龙虎等级',
            'integral'=>'龙虎积分',
            'club_status'=>'状态',//'状态，关联base_code表STATE类型，id:496-申请加入 337-在位  338-已退出 339-申请退出 499-无效 497解除中  498邀请中'
            'club_status_name'=>'状态',
            'user_member_id'=>'会员表',//'使用会员表id,关联club_member表id'
            'udate'=>'更新时间',
            'apply_time'=>'申请日期',
            'grade_achieve_time'=>'注册时间',


            //club_member表
            'member_level_register_time'=>'申请时间',
            'start_time'=>'加入社区日期',
            'unbund_time'=>'申请解绑时间',
            'end_time'=>'退出社区日期',
            
            // userlist表
            'native' => '籍贯',
            'nation' => '民族',
            'real_birthday' => '出生日期',
            'id_card_type' => '证件类型',
            'id_card' => '证件号码',
            'id_card_validity_start' => '证件有效期开始时间',
            'id_card_validity_end' => '证件有效期截止时间',
            'id_card_pic' => '证件正面',
            'id_pic' => '证件反面',
            'GF_NAME' => '昵称',
            'PHONE' => '手机号码',
            'EMAIL' => '邮箱',
            'GRQM' => '个性签名',
            'TXNAME' => '头像',
            'guardian' => '监护人',
            'guardian_contact_information' => '监护人联系电话',
            'BLOOD' => '血型',
            'height' => '身高',
            'weight' => '体重',
            'FamilyHistory' => '家族病史',
            'occupation' => '职业',
            'work_unit' => '工作单位',
            'INTEREST' => '个人爱好',
            'IDNAME' => '免冠头像',
            // 'BLOOD' => '家庭住址',

            'logon_way'=>'注册方式',
            'logon_way_name'=>'注册方式',
            'certificate_type'=>'资质证书',
            'qualification_code'=>'资质编号',
            'qualification_image'=>'上传资质',
        );  
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function afterFind() {
        parent::afterFind();        
        return true;
    }

    protected function beforeSave() {
        parent::beforeSave();
        $this->udate = date('Y-m-d H:i:s');
		if ($this->isNewRecord) {
			$this->apply_time = date('Y-m-d h:i:s');
        }
        return true;

    }
	
	public function getClubmember($project_id) {
        return $this->findAll('member_project_id='.$project_id.' AND club_status=337');
    }
	
	public function getClubmember2() {
        $cooperation= $this->findAll();
         $arr = array();$r=0;
        foreach ($cooperation as $v) {
                $arr[$r]['gf_account'] = $v->gf_account;
				$arr[$r]['level'] = $v->project_level_id;
                $r=$r+1;
        }
        return $arr;
    }
    
    
    /**
     * 用户项目龙虎等级列表,及项目学员所在单位
     */
    public function getMemberProjectLevel($param){
    	$gfid=$param['gfid'];
    	$project_id=empty($param['project_id'])?'':$param['project_id'];
        
		$cr = new CDbCriteria;
        $cr->condition="t.t.member_gfid=".$gfid;
        $cr->condition=get_where($cr->condition,$project_id,'t.member_project_id',$project_id,'');
        $cr->join = "JOIN servicer_level on servicer_level.servicer_level.type in(1472,210) and servicer_level.card_xh=t.project_level_xh";
        $cr->select="group_concat(distinct (case when t.club_status in(337,339,497) and ifnull(t.club_id,0)>0 then t.club_id else 0 end)) as club_id,t.member_project_id,t.project_name as member_project_name,IFNULL(t.project_level_xh,0) as member_level,servicer_level.card_name as member_level_name";
        $cr->group='t.member_project_id';
        return $this->findAll($cr,array(),false);
    }

    public function getProjectLevel($gfid,$project_id=''){    
        $w1="member_gfid=".$gfid;
        if($project_id) $w1.=" and member_project_id='".$project_id."'";
        $tmp=$this->findAll($w1);
        $s1='member_project_id,project_name:member_project_name,project_level_xh:level,';
        $s1.='project_level_name:level_name,club_id,club_status,club_status_name';
        $data=toIoArray($tmp,$s1);
        return $data;
    }

}
