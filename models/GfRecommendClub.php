<?php

class GfRecommendClub extends BaseModel {

    //public $project_list = '';

    public function tableName() {
        return '{{gf_recommend_club}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('club_id', 'required', 'message' => '{attribute} 不能为空'),
			//array('brand_content', 'length', 'allowEmpty'=> true),
			array('club_id,club_code,club_name,club_list,rec_type,add_time','safe'), 
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
		//'mall_brand_project' => array(self::HAS_MANY, 'MallBrandProject', 'brand_id'),
		//'qmdd_administrators' => array(self::BELONGS_TO, 'QmddAdministrators', 'f_user_id'),
            
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'club_id' => '单位id',
            'club_code' => '单位帐号',
			'club_name' => '服务平台名称',
            'partnership_type' => '单位类别',
            'club_list' => '可推送至单位',
            'add_time' => '添加时间',
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
            $this->add_time = date('Y-m-d h:i:s');
        }

        return true;
    }

}
