<?php

class ActivityDiy extends BaseModel {  



    public function tableName() {
        return '{{diy_module}}';  
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function check_save($show) {
        $this->show=$show;
    }

    public function picLabels() {
         return 'image';
     }

    public function relations() {
        return array(

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
		'id' => 'id',
        'code'=>'code',
        //'w_name'=>'w_name'
         'name'=>'name',
         'image'=>'image',
         'div_html'=>'div_html',
         'set_html'=>'set_html'
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
