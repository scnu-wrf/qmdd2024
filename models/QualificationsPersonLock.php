<?php

class QualificationsPersonLock extends BaseModel {


    public $location ='';
    public function tableName() {
        return '{{qualifications_person_lock}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array($this->safeField(), 'safe'),
        );
    }
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'qualifications_person' => array(self::BELONGS_TO, 'QualificationsPerson', 'qualification_person_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' =>'ID',
            'qualification_person_id' => '资质人id，关联qualifications_person表id',
            'lock_date_start' => '冻结开始时间',
            'lock_date_end' => '冻结结束时间',
            'lock_reason' => '冻结/解冻原因',
            'add_time' => '添加时间',
            'state' => '账号状态',
            'state_name' => '账号状态',

            'gf_code' => '服务者编码',  // 规则项目简码+类型简码+年份+6位序号，如TC-M-2017000001， 从qualification_person_no上自动增长',
            'gfaccount' => '帐号',
            'qualification_name' => '姓名',
            'project_id' => '项目',
            'project_name' => '项目',
            'qualification_type_id' => '服务者类型',  
            'qualification_type' => '服务者类型',
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

        }
        $this->process_id = get_session('admin_id');
        $this->process_account = get_session('gfaccount');
        $this->process_nick = get_session('admin_name');
        return true;
    }


}
