<?php

class GfSiteProject extends BaseModel {

    public function tableName() {
        return '{{gf_site_project}}'; //场地项目
    }
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'gf_site' => array(self::BELONGS_TO, 'GfSite', 'site_id'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
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
        'site_id' => '场地id',  // 关联gf_site表',
        'site_name' => '场馆名称',
        'project_id' => '项目ID',  // 关联project_list表id',
        'project_name' => '项目名称',
		);
    }

       //关联数据自动处理
    public function getrelations() {
        return 'GfSite,site_id:id,site_name;ProjectList,project_id:id,project_name';
    }
	
	protected function beforeSave() {
        parent::beforeSave();
        return true;
    }

    protected function afterSave() {
        parent::afterSave();
        $this->getProjectIds($this->site_id);
        return true;
    }
    public function getProjectIds($site_id) {
        $tmp=$this->findAll('site_id='.$site_id);
        $rs= getIds($tmp,"project_id");
        updatAll(array('project_list'=>$rs),'id='.$site_id);
    }

}
