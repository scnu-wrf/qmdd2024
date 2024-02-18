<?php

class ClubReport extends BaseModel {

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
			array('service_level,service_department,service_adminid,service_admin_name,audit_status,audit_status_name,account_service_department,account_service_department,report_processing_msg_id,report_processing_obj_id,udate,admin_id,admin_account', 'safe'),

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
            'stateName' => array(self::BELONGS_TO, 'BaseCode', 'state'),
			'club_admin' => array(self::BELONGS_TO, 'Clubadmin', 'service_adminid'),
            'auditStatusName' => array(self::BELONGS_TO, 'BaseCode', 'audit_status'),
            'admin_name' => array(self::BELONGS_TO, 'QmddAdministrators', 'admin_id'),
            'productId' => array(self::BELONGS_TO, 'MallProducts', array('connect_id'=>'id')),

            'clubNews' => array(self::BELONGS_TO, 'ClubNews', 'connect_id'),
            'videoLive' => array(self::BELONGS_TO, 'VideoLive', 'connect_id'),
            'boutiqueVideo' => array(self::BELONGS_TO, 'BoutiqueVideo', 'connect_id'),
            'gameList' => array(self::BELONGS_TO, 'GameList', 'connect_id'),
            'clubStoreTrain' => array(self::BELONGS_TO, 'ClubStoreTrain', 'connect_id'),
            'qmddServerSourcer' => array(self::BELONGS_TO, 'QmddServerSourcer', 'connect_id'),
            'gfCrowdBase' => array(self::BELONGS_TO, 'GfCrowdBase', 'connect_id'),
            'jlbMoodselse' => array(self::BELONGS_TO, 'JlbMoods', 'connect_id'),
            'commentList' => array(self::BELONGS_TO, 'CommentList', 'connect_id'),
            'qmddAchievemenData' => array(self::BELONGS_TO, 'QmddAchievemenData', 'connect_id'),
        ); 
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'type' => '举报类型',
            'report_type_id'=> '举报原因',
            'connect_code'=> '被举报人或编码',
            'connect_title'=> '举报内容',
            'gf_account'=> '举报人帐号',
            'connect_name'=> '举报人昵称',
            'connect_number'=> '联系电话',
            'connect_eamil'=> '电子邮箱',
            'add_time'=> '举报时间',
            'state'=> '内容处理状态',
            'report_detail'=>'详细描述',
            'report_pic'=>'证据截图',
            'reasons_for_failure'=>'操作备注',
            'report_content'=>'举报原因',
            'connect_publisher_code'=>'被举报人账号',
            'connect_publisher_title'=>'被举报人',
            'audit_status'=>'审核状态',
            'audit_status_name'=>'审核状态',
            'udate'=>'操作时间',
            'admin_id'=>'操作人id',
            'admin_account'=>'操作人账号',
            'help_url' => '举报链接',

			'rtype_id' => '类别ID',
            'rtype_name' => '举报类别名称',
            'the_infringed_type' => '被侵权人类型',
            'the_infringed_name' => '被侵权人个人姓名／单位名称',
            'the_infringed_id_card_type' => '被侵权人证件类型 仅个人',
            'the_infringed_id_card' => '被侵权人证件号（个人）／法人名称（单位）',
            'the_infringed_concat' => '联系电话',
            'the_infringed_eamil' => '联系地址',
            'the_infringed_card_pic' => '被侵权人证件类型图片',
            'appeal_id' => '被举报id',

			'service_level'=>'优先级别',
            'service_department'=>'处理部门',
            'account_service_department'=>'违规账号处理部门',
            'service_adminid'=>'处理人',
            'report_processing_msg_id'=>'处理方式',
            'report_processing_msg_name'=>'违规内容处理方式',
            'report_processing_obj_id'=>'违规账号处理方式',
            'report_processing_obj_name'=>'违规账号处理方式',
            'report_processing_obj_state'=>'对违规账号的受理状态',
            'report_processing_obj_state_name'=>'对违规账号的受理状态'
        );
    }

    public function labelsOfList()
    {
        return array(
            'connect_publisher_title',
            'connect_title',
            'report_content',
            'add_time'
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
    

    
    public function appeaAttributeLabels() {
        return array(
            'connect_publisher_title'=>'申诉人',
            'connect_title'=> '申诉内容',
            'add_time'=> '申诉时间',
        );
    }
    public function appealLabelsOfList()
    {
        return array(
            'connect_publisher_title',
            'connect_title',
            'add_time'
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
        return true;
    }

}
