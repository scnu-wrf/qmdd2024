<?php

class QmddGfSite extends BaseModel {
	public $site_description_temp='';
    public $sites_list = '';

   public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{qmdd_gf_site}}';
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
			'club_list' => array(self::BELONGS_TO, 'ClubList', 'user_club_id'),
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'site_envir'),
            //'level' => array(self::BELONGS_TO, 'BaseCode', 'site_level'),
            'gf_site_project' => array(self::HAS_MANY, 'GfSite', array('site_id' => 'id')),
            'sitetype' => array(self::BELONGS_TO, 'BaseCode', 'site_type'),
			'project_list' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
            'parent' => array(self::BELONGS_TO, 'QmddGfSite', 'site_parent'),
        );
    }
    /*** 模型验证规则*/
    public function rules() {
      return $this->attributeRule();
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }
    public function attributeSets() {
        return array(
		'id' => 'ID',
        'site_code' => '资源编号',
        'site_name' => '场地名称',
		'site_id' => '场馆名称', // 所属场馆
        'site_pic' => '场地图片',    //缩略图
        'site_level' => '资源等级',
		'site_date_start' => '使用开始',
        'site_date_end' => '期限结',
        'site_prove' => '滚动图',
        'site_area' => '场地面积',
		'site_envir' => '场地环境',
        'contact_phone' => '场馆电话',
        'site_address' => '场馆地址',
        'site_location' => '导航定位',
        'site_longitude' => '场地经度',
        'site_latitude' => '场地纬度',
        'site_description' => '场地介绍',
		'site_description_temp' => '场地介绍',
		'site_facilities' => '场地设施',
        'site_level' => '场地等级',
        'site_belong' => '所属类型',
        'belong_id' => '产权所属人/单位ID',  // site_belong为0时为club_id，为1时为gf_id
        'belong_name' => '产权所属人/单位名称',
		'user_club_id' => '登记单位',
		'user_club_name' => '所属单位',
        'rent' => '租金',
        'register_time' => '登记时间',
        'apply_time' => '申请时间',
        'site_state' => '状态',
        'site_state_name' => '审核状态',
		'reasons_for_failure' => '备注',
        'reasons_time' => '审核时间',
        'reasons_adminID' => '审核员',  // 关联qmdd_administrators表ID,
        'reasons_adminname' => '操作管理员',
		'project_ids'=>'可用项目',
		'if_del' => '逻辑删除',   // 关联base_code表DATA类型 509-逻辑删除 510正常'
		'server_name' => '服务名称',
		'project_id'=>'服务项目',
        'site_type'=>'场地类型',
        'site_parent'=>'关联场地',
        );
    }

   public function picLabels() {
        return 'site_pic,site_prove';//,site_description_tem
    }
    public function pathLabels(){ return '';}
            //自动图片加上路径
    protected function afterFind(){
      parent::afterFind();
    }

	protected function beforeSave() {
        parent::beforeSave();
        // 图文描述处理
        $this->site_description=getAboutMe($tmp,'site_description');
		$this->reasons_adminID = Yii::app()->session['admin_id'];
        $this->reasons_adminname = Yii::app()->session['gfnick'];
        $this->reasons_time = date('Y-m-d h:i:s');
        return true;
    }

}
