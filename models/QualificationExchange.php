<?php

class QualificationExchange extends BaseModel {

    public $gf_account='';
    public $zsxm='';
    public function tableName() {
        return '{{qualification_exchange}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
		if($_REQUEST['r']=='clubMemberList/create_dragon_tiger'){
            return array(
                ['gf_account', 'required', 'message' => '{attribute} 不能为空'],
                ['zsxm', 'required', 'message' => '{attribute} 不能为空'],
                ['get_score_project_id', 'required', 'message' => '{attribute} 不能为空'],
                ['qua_id', 'required', 'message' => '{attribute} 不能为空'],
                ['person_code', 'required', 'message' => '{attribute} 不能为空'],
                ['person_pic', 'required', 'message' => '{attribute} 不能为空'],
                ['type_id', 'required', 'message' => '{attribute} 不能为空'],
                array('type,qua_id,person_code,person_pic,get_score,state,reasons_for_failure,is_user,type_id,get_score_gfid','safe'),
            );
        }else{
            return array(
                array('type,qua_id,person_code,person_pic,get_score,state,reasons_for_failure,is_user,type_id,get_score_gfid,get_score_project_id','safe'),
            );
        }
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_code_type' => array(self::BELONGS_TO, 'BaseCode', 'type'),
			'base_code_qua' => array(self::BELONGS_TO, 'ServicerCertificate', 'qua_id'),
			'gf_user_name' => array(self::BELONGS_TO, 'userlist', 'get_score_gfid'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'get_score_project_id'),
        );
    }

    /**
     * 属性标签
     */   
    public function attributeLabels() {
        return array(
            'code'=>'流水号',
            'type' => '兑换类型',
            'qua_id' => '资质等级',
            'person_name'=>'资质等级',
            'person_code'=>'资质编号',
            'person_pic'=>'上传资质',
            'get_score' => '置换龙虎积分',
            'get_score_gfid'=>'兑换会员',
            'gf_account'=>'账号',
            'zsxm' => '姓名',
            'get_score_project_id'=>'项目',
                                             
            'is_user'=>'是否使用',
            'uDate'=>'申请时间',
            'state'=>'审核状态',
            'reasons_for_failure'=>'审核备注',
            'state_qmddid'=>'审核员',
            'state_qmddname'=>'管理员',
            'state_time'=>'审核时间',
            'type_id'=>'资质类型',
            'type_name'=>'资质类型'
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

        if ($this->isNewRecord) {
            $this->uDate = date('Y-m-d H:i:s');  
        }
        $this->state_qmddid = get_session('admin_id');
        return true;
    }


}
