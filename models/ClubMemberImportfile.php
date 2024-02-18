<?php

class ClubMemberImportfile extends BaseModel {

	public $show=0;
    public function tableName() {
        return '{{club_member_importfile}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        $s2='club_type,import_id,import_code,club_id,zsxm,phone,email,id_card,sex,native,nation,real_birthday,project_id,pay_confirm,pay_confirm_time,adminid,adminname,logon_way,qualification_type,identity_type,qualification_num,qualification_code,start_date,end_date';
		if($this->show==0){
            return array(
                array($s2,'safe'), 
            );
        }else{				
            return [
                array($s2,'safe',), 
            ];
        }
    }
	public function check_save($show) {
        $this->show=$show;
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'club_menber' => array(self::BELONGS_TO, 'ClubMemberList', 'import_id'),
            'gf_member' => array(self::BELONGS_TO, 'GfPartnerMemberApply', 'import_id'),
            'gf_user' => array(self::BELONGS_TO, 'userlist', 'gfid'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'import_id' => '会员类型',
            'gf_account'=>'账号',
            'zsxm' => '姓名',
            'real_sex'=>'性别',
            'native'=>'籍贯/地区',
            'phone'=>'联系电话',
            'id_card' => '身份证号码',
            'member_type' => '会员类型',
            'club_type' => '归属单位类型',
            'club_name' => '归属单位',
            'real_birthday' => '出生年月日',
            'project_id' => '项目',
            'project_name' => '项目名称',
            'qualification_type' => '服务者类型',
            'qualification_type_name' => '服务者类型',
            'identity_type' => '服务者资质证书',
            'identity_type_name' => '服务者资质证书',
            'qualification_num' => '持证证书等级，servicer_certificate表id',
            'qualification_title' => '服务者资质等级',
            'qualification_code' => '资质编号',
            'start_date' => '资质有效期开始时间',
            'end_date' => '资质有效期结束时间',
            'add_time' => '导入日期',
            'pay_confirm' => '是否确认 0：未确认，1：已确认',
            'pay_confirm_time' => '确认时间',
            'remark' => '备注',
            'adminid' => '操作员',
            'adminname' => '操作员',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }


    protected function beforeSave() {
        parent::beforeSave();
        if($this->isNewRecord){
            // $this->uDate = date('Y-m-d H:i:s');
        }
        return true;
    }

}
