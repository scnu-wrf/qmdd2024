<?php

class ClubBrand extends BaseModel {

    public $project_list = '';

    public function tableName() {
        return '{{club_brand}}';
    }


    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
		'mall_brand_project' => array(self::HAS_MANY, 'MallBrandProject', 'brand_id'),
		'qmdd_administrators' => array(self::BELONGS_TO, 'QmddAdministrators', 'f_user_id'),
        'base_code_brand_type_id' => array(self::BELONGS_TO, 'BaseCode', 'brand_type_id'),
        'base_code_state' => array(self::BELONGS_TO, 'BaseCode', 'state'),
        'ClubList_record' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
        'base_code_yes_no' => array(self::BELONGS_TO, 'BaseCode', 'brand_state'), 
        );
    }
    public function rules() {
      return $this->attributeRule();
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }
    public function attributeSets() {
        return array(
            'project_list' => '项目',
            'brand_id' => 'ID',
            'brand_no' => '编号',
            'brand_logo_pic' => '品牌LOGO',
			'brand_date' => '操作时间',
            'brand_title' => '品牌名称',
            'brand_date_begin' => '上架时间',
            'brand_date_end' => '下架时间',
            'brand_state' => '上架状态',
            'brand_content' => '品牌描述',
            'brand_certificate' => '品牌资质',
            'brand_type_id' => '品牌类型',
            'state' => '状态',

        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        parent::beforeSave();

        if ($this->isNewRecord) {
			$this->brand_date = date('Y-m-d H:i:s');
        }
        if (empty($this->brand_no)) {
                // 生成编号     
                $this->brand_no = getAutoNo('club_brand','','');
        }
        $this->f_user_id = get_session('admin_id');
        $this->f_user_name = get_session('admin_name');
        $this->f_userdate = date('Y-m-d H:i:s');

//        if (Yii::app()->session['club_id'] != 1) {
//            unset($this->is_dispay);
//            unset($this->state);
//        }
        return true;
    }

}
