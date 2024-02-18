<?php

class ReportComplaint extends BaseModel {

    public $project_list = '';
	public $video_live = '';
	public $boutique_video = '';

    public function tableName() {
        return '{{club_report}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
           
            array('state', 'required', 'message' => '{attribute} 不能为空'),
			array('service_level,service_department,service_adminid', 'safe'),

        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_code' => array(self::BELONGS_TO, 'BaseCode', array('state' => 'f_id')),
			'm_type' => array(self::BELONGS_TO, 'BaseCode', 'type'),
			'r_type' => array(self::BELONGS_TO, 'ReportVersion', 'report_type_id'),
			'club_admin' => array(self::BELONGS_TO, 'Clubadmin', 'service_adminid'),
        ); 
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'type' => '反馈模块',
            'report_type_id'=> '反馈类型',
            'connect_code'=> '信息流水号',
            'connect_title'=> '信息标题',
            'gf_account'=> '反馈人帐号',
            'connect_name'=> '反馈人昵称',
            'connect_number'=> '联系电话',
            'connect_eamil'=> '电子邮箱',
            'add_time'=> '反馈时间',
            'state'=> '受理状态',
            'report_detail'=>'详细描述',
            'report_pic'=>'界面截图',
            'reasons_for_failure'=>'操作备注',
			
			'service_level'=>'优先级别',
            'service_department'=>'受理部门',
            'service_adminid'=>'受理人',
        );
    }

    public function labelsOfList()
    {
        return array(
            'type',
            'report_type_id',
            'connect_code',
            'connect_title',
            'gf_account',
            'connect_name',
            'connect_number',
            'connect_eamil',
            'add_time',
            'state'
        );
    }
    
    public function labelsOfDetail()
    {
        return array(
            'type',
            'report_type_id',
            'connect_code',
            'connect_title',
            'report_detail',
            'report_pic',
            'connect_name',
            'connect_number',
            'connect_eamil',
            'add_time',
        );
    }
    
    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
