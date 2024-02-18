<?php

class MallBrandStreet extends BaseModel {

    public $project_list = '';

    public function tableName() {
        return '{{mall_brand_street}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
           // array('project_list', 'required', 'message' => '{attribute} 不能为空'),
            array('brand_title', 'required', 'message' => '{attribute} 不能为空'),
            array('brand_logo_pic', 'required', 'message' => '{attribute} 不能为空'),
            array('brand_date_begin', 'required', 'message' => '{attribute} 不能为空'),
            array('brand_date_end', 'required', 'message' => '{attribute} 不能为空'),
            array('brand_state', 'required', 'message' => '{attribute} 不能为空'),
			//array('brand_content', 'length', 'allowEmpty'=> true),
			array('brand_no,brand_title,brand_logo_pic,brand_url,brand_content,brand_type,brand_state,brand_date_begin,brand_date_end,brand_date,f_user_id,f_user_name,f_userdate','safe'), 
        );
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

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'project_list' => '项目',
            'brand_id' => 'ID',
            'brand_no' => '编号',
            'brand_logo_pic' => '品牌LOGO',
			'brand_date' => '提交日期',
            'brand_title' => '品牌名称',
            'brand_date_begin' => '上架时间',
            'brand_date_end' => '下架时间',
            'brand_state' => '上架状态',
            'brand_content' => '品牌描述',
            'brand_type_id' => '品牌类型',
            'brand_certificate' => '品牌资质',
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
            if (empty($this->brand_no)) {
                // 生成编号
				$brand_no = '';
                $brand_no.=date('Y');
				$brand_no.=date('m');
				$brand_no.=date('d');
				$code = substr('0000' . strval(rand(1, 9999)), -4);
				$brand_no.=$code;				
                $this->brand_no = $brand_no;
            }
			$this->brand_date = date('Y-m-d');
        }
        $this->f_user_id = get_session('admin_id');
        $this->f_user_name = get_session('admin_name');
        $this->f_userdate = date('Y-m-d h:i:s');

//        if (Yii::app()->session['club_id'] != 1) {
//            unset($this->is_dispay);
//            unset($this->state);
//        }
        return true;
    }

}
