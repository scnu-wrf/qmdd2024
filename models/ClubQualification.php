<?php

class ClubQualification extends BaseModel {

    public function tableName() {
        return '{{qualification_club}}';
    }

    /**
     * 模型关联规则
     */
    public function relations() {
    return array(
    'qualifications_person' => array(self::BELONGS_TO, 'QualificationsPerson',array('qualification_person_id' => 'id')),
    'qualification_invite' => array(self::BELONGS_TO, 'ClubQualificationInvite',array('invite_id' => 'id')),
	'project_list' => array(self::BELONGS_TO, 'ProjectList',array('project_id' => 'id')),
    );
	
    }



 public function rules() {
      $s1="club_id,project_order,project_id,project_name,apply_contentchar,";
      $s1.="project_statetiny,approve_state,auth_state,valid_until,state,refuse,qualification_pic";
        return array(
         //   array('p_code', 'required', 'message' => '{attribute} 不能为空'),
            array('project_id', 'required', 'message' => '{attribute} 不能为空'),
           // array('', 'required', 'message' => '{attribute} 不能为空'),
            array($s1,'safe'), 
        );
    }



    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'qcode'=>'编号',
'qualification_person_id'=>'资质人id',
'qcode'=> '编号',
'account'=> '帐号',
'name'=> '姓名',
'level_name'=>'级别',
'qualification_type'=>'类型',
'type_name'=>'类型',
'project_id'=> '项目',
'project_name'=> '项目名称',
'code_type'=> '类型编码',
'uDate'=> '邀请时间',
'udate'=> '更新时间',
'start_time'=>'实际加入',
'order_num'=>'订单号',
'state_name'=>'状态',
'start_date'=> '资质期限开始',
'end_date'=> '资质期限结束',
'if_apply_display'=>'求职显示',
'phone'=> '联系电话',
'email'=> '电子邮箱',
'gfaccount'=> '帐号',
'qualification_name'=> '姓名',
'qualification_type_id'=>'类型',
'qualification_type'=>'类型',
'code_project'=> '项目',
'code_type'=> '类型编码',
'code_year'=> '年份',
'code_num'=>'编号',
'gf_code'=> '资质人编码',
'identity_num'=>'证书等级',
'qualification_title'=>'证书名',
'qualification_code'=>'证书编号',
'qualification_image'=>'证书扫描件',
'head_pic'=>'免冠头像',
'project_id'=>'项目',
'project_name'=>'项目名',
'process_id'=>'处理人id',
'process_account'=>'处理人account',
'process_nick'=>'处理人',
'uDate'=> '添加时间',
'check_state'=>'审核状态',
'check_state_name'=>'状态名称',
'reasons_for_failure'=>'未通过原因',
'qualification_time'=> '获得时间',
'synopsis'=>'个字简介',
'introduct'=>'资质人介绍',
'qualification_pic'=> '证书图片',
'qualification_level'=> '资质等级',
'level_name'=>'等级名称',
'qualification_score'=>'资质分',
'order_num'=>'订单号',
'is_pay'=>'支付状态',
'start_date'=> '资质期限开始',
'end_date'=> '资质期限结束',
'if_apply_display'=>'求职显示',
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
//ClubQualification->getClub($qpid);
    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
