<?php

class ClubMember extends BaseModel {

    public $news_content_temp = '';
    public function tableName() {
        return '{{club_member}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('zsxm,real_sex,gf_account,club_id,member_project_id,agree_club,member_level_register_time,start_time,remove_reason,unbund_time,end_time,project_name,agree_state_name,member_content,invite_initiator','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
            'base_code_sex' => array(self::BELONGS_TO, 'BaseCode', 'real_sex'),
            'base_code_agree' => array(self::BELONGS_TO, 'BaseCode', 'agree_club'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'member_project_id'),
        );
    }

    /**
     * 属性标签
     */ 
    public function attributeLabels() {
        return array(
            'id'=>'ID',
            'zsxm' => '姓名',
            'real_sex'=>'性别',
            'gf_account'=>'帐号',
            'club_id' => '所属单位',
            'member_gfid'=>'社区成员ID',
            'member_project_id'=>'学员所属项目',
            'project_name'=>'项目名称',
            'project_level_id' => '项目等级',
            'project_level_name' => '项目等级名称',
            'invite_initiator'=>'邀请方发起者',//邀请方发起者 502社区单位   210会员
            'agree_club'=>'是否同意加入社区',//是否同意加入社区,关联base_code类型STATE类型，id为：  371审核中 2审核通过 374撤销
            'member_content'=>'邀请加入说明',
            'agree_state_name'=>'申请状态',
            'member_level_register_time'=>'申请日期',
            'start_time'=>'加入日期',
            'del_initiator'=>'解除发起方',
            'if_del'=>'社区单位/资质人是否审核同意解除',
            'remove_reason'=>'解除原因描述',
            'unbund_time'=>'申请解绑时间',//（如7天未操默认为同意退出）
            'end_time'=>'实际退出社区日期',//解除时间满7天if_del=371的状态变更511状态
            'uDate'=>'更新时间',
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
        

        $this->uDate = date('Y-m-d H:i:s');
        return true;
    }


}
