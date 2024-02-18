<?php

class GfSiteCredit extends BaseModel {

    public function tableName() {
        return '{{gf_site_credit}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('facilities_name','required','message'=>'{attribute} 不能为空'),
            array('facilities_pic','required','message'=>'{attribute} 不能为空'),
		    array('facilities_name,credit,facilities_pic,grade_id', 'safe'),
		);
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            //'gf_site' => array(self::BELONGS_TO, 'GfSite', 'site_id'),
           // 'project_list' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'facilities_name' => '场馆配套',
            'facilities_pic' => '设施logo',
            'credit' => '积分',
            'item_name' => '积分项名称',
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
