<?php

class QualificationClub extends BaseModel {

    public $introduct_temp = '';

    public function tableName() {
        return '{{qualification_club}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
		array('club_id,project_id,qualification_person_id,qualification_type,state,logon_way,logon_way_name', 'safe'), 
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'qualifications_person' => array(self::BELONGS_TO, 'QualificationsPerson','qualification_person_id'),
            'base_code' => array(self::BELONGS_TO, 'BaseCode', array('qualification_type' => 'f_id')),
			'qualification_invite' => array(self::BELONGS_TO, 'QualificationInvite', 'invite_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'club_id'=>'所属单位',
            'club_name'=>'所属单位',
            'qcode'=>'编号',
            'qualification_person_id'=>'资质人id',
            'qcode'=> '编号',
            'account'=> '帐号',
            'name'=> '姓名',
            'level_title'=>'资质等级',
            'level_name'=>'服务者等级',
            'end_date'=>'资质有效期',
            'ccie_date'=>'服务者有效期',
            'type_name'=>'服务者类型',
            'state_name'=>'绑定状态',
            'project_id'=> '项目',
            'project_name'=> '项目名称',
            'uDate'=> '邀请时间',
            'udate'=> '操作时间',
            'gfaccount'=> '帐号',
            'qualification_name'=> '姓名',
            'qualification_type'=>'类型',
            'introduct'=>'资质人介绍',
            'add_date'=>'操作时间',
            'logon_way' => '注册方式',
            'logon_way_name' => '注册方式',
            'binding_way' => '绑定方式',
        );
    }
	
	public function getCode() {
        return array( 
            array('f_id' => '1','F_NAME' => '机构'),
            array('f_id' => '2','F_NAME' => '其他'),);
    }

   public function getProject($clubid) {
      return $this->findAll('club_id='.$clubid);
    }

   public function getClub($qpid) {
      return $this->findAll('qualification_person_id='.$qpid);
    }

    /**
     * Returns the static model of the specified AR class.
	 模型关联返信息
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function afterFind() {
        parent::afterFind();

        if ($this->club_id ==-2) {
            
            $qualificatioName = QualificationsPerson::model()->findAll('qualification_person_id=' . $this->id);
            $arr = array();
            foreach ($qualificatioName as $v) {
                $arr[0][] = $v->head_pic;
                $arr[1][] = $v->qualification_name;
                $arr[2][] = $v->gf_code;
                $arr[3][] =$v->end_date;
            }
            $this->head_pic = implode(',', $arr[0]);
			$this->qualification_name = implode(',', $arr[1]);
			$this->gf_code = implode(',', $arr[2]);
			$this->end_date = implode(',', $arr[3]);
	    }

        $basepath = BasePath::model()->getPath(131);
        if ($this->introduct != '') {
            $this->introduct_temp = get_html($basepath->F_WWWPATH . $this->introduct, $basepath);
        }
     
        return true;
    }

}
