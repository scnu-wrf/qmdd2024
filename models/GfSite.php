<?php

class GfSite extends BaseModel {  

	public $project_list = '';
	public $site_description_temp='';
    public $show=371;

    public function tableName() {
        return '{{gf_site}}';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function check_save($show) {
        $this->show=$show;
    }

    public function relations() {
        return array(
            'gf_site_project'=>array(self::HAS_MANY, 'GfSiteProject', array('site_id' => 'id')),
			'club_list' => array(self::BELONGS_TO, 'ClubList', 'user_club_id'),
            //'envir' => array(self::BELONGS_TO, 'BaseCode', 'site_envir'),
            'level' => array(self::BELONGS_TO, 'ServicerLevel', 'site_level'),
			'sitebelong' => array(self::BELONGS_TO, 'BaseCode', 'site_belong'),
            'origin' => array(self::BELONGS_TO, 'BaseCode', 'site_origin'),
        );
    }

    public function rules() {
      return $this->attributeRule();
    }

    public function attributeLabels() {
        return $this->getAttributeSet();
    }

    public function attributeSets() {
        return array(
		'id' => 'ID',
        'site_code' => '场馆编号',
        'site_name' => '场馆名称',
        'contact_phone' => '联系电话',
        'site_address' => '场馆地址',
        'site_level_name' => '场馆等级',
        'reasons_adminname' => '操作员',
        'reasons_gfaccount' => '操作员编号',
        'reasons_time' => '操作日期',
        'site_longitude' => '场馆经度',
        'site_latitude' => '场馆纬度',
        'site_area' => '场馆面积',
        'gem_project' => '场馆项目:k',
        'reasons_for_failure' => '审核意见:k',
        'site_state_name' => '状态'
        );
    }

    // public function picLabels() {
    //     return 'site_pic,site_scroll,facilities_pic';
    // }

    public function pathLabels(){ 
        return '';
    }

	protected function afterFind() {
        parent::afterFind();
        //$this->project_list =GfSiteProject::model()->getProjectIds($this->id);
        return true;
    }

	protected function beforeSave() { 
        parent::beforeSave();
        // 图文描述处理
        // $this->site_description=getHtmlFile($this,'site_description');
        // if ($this->isNewRecord) {
        //   	$this->user_club_id=get_session('club_id');
		// 	$this->belong_id=get_session('club_id');
        // }
        return true;
    }

}
