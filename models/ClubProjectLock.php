<?php

class ClubProjectLock extends BaseModel {
	public $show=0;

    public function tableName() {
        return '{{club_project_lock}}';
    }

	public function rules() {
        $s2='club_project_id,lock_date_start, lock_date_end, lock_reason, add_time,remedy_btn,state';
            return [
                array($s2,'safe',), 
            ];
    }
	public function check_save($show) {
        $this->show=$show;
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'cpd' => array(self::BELONGS_TO, 'ClubProject', 'club_project_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' =>'ID',
            'club_project_id' => '资质人id，关联club_project表id',
            'lock_date_start' => '冻结开始时间',
            'lock_date_end' => '冻结结束时间',
            'lock_reason' => '冻结/解冻原因',
            'add_time' => '添加时间',
            'state' => '账号状态',
            'state_name' => '账号状态',
            'process_id' => '处理人id（管理员）',
            'process_account' => '处理人account（管理员）',
            'process_nick' => '处理人昵称（管理员）',
            
			'club_name'=>'服务平台名称',
            'p_code' => '单位管理账号',
            'club_type' => '单位类型',  
            'club_type_name' => '单位类型名称',
            'project_id' => '项目',
            'project_name' => '项目',
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
