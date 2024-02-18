<?php

class commercialTenant extends BaseModel {  


    public function tableName() {
        return '{{commercialTenant}}';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function check_save($show) {
        $this->show=$show;
    }

    public function relations() {
        return array();
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
        'organization_name' => '单位名称',
        'organization_type' => '单位类型',
        'ct_name' => '商户名称',
        'ct_id' => '商户id',
        'ct_registered_capital' => '注册资本',
        'ct_certificates_number' => '营业执照编号',
        'ct_certificates_img' => '营业执照照片'
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
