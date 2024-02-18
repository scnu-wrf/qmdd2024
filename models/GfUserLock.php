<?php

class GfUserLock extends BaseModel {


    public $location ='';
    public function tableName() {
        return '{{gf_user_lock}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array($this->safeField(), 'safe'),
            array('GF_ACCOUNT', 'required', 'message' => '请选择 {attribute}'),
            array('lock_way', 'required', 'message' => '{attribute} 不能为空'),
        );
    }
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'gfId' => array(self::BELONGS_TO,'userlist','GF_ID'),
            // 'gfId' => array(self::BELONGS_TO,'userlist','GF_ID'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'ID' => 'ID',
            'deal_code' => '单位编号',
            'deal_name' => '名称',
            'GF_ID' => 'GF_ID',
            'GF_ACCOUNT' => 'GF账号',
            'GF_NAME' => '昵称',
            'ZSXM' => '真实姓名',
            'operater_gfid' => '审核操作人GFID',
            'club_id' => '实名的俱乐部ID',
            'if_del' => '关联base_code表DATA类型510-使用中，509-逻辑删除',
            'user_state' => '账号状态',
            'user_state_name' => '使用状态名称',
            'LOCK_R' => '冻结状态',     //临时使用
            'admin_gfid' => '操作员',
            'admin_gfaccount' => '操作员账号',
            'admin_gfname' => '操作员',
            'lock_reason' => '冻结原因',
            'uDate' => '操作时间',
            'lock_way' => '冻结处理',
            'lock_date_start' => '冻结日期',
            'lock_date_end' => '解冻日期',
            'remedy_btn' => '解冻方式',
            'state' => '审核状态',
            'state_name' => '审核状态'
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

        if ($this->isNewRecord) {
            $this->uDate=date('Y-m-d H:i:s');
        }
        //$this->admin_gfaccount = Yii::app()->session['gfaccount'];
        $this->admin_gfid = Yii::app()->session['admin_id'];
        $this->admin_gfname = Yii::app()->session['admin_name'];
        return true;
    }
}
