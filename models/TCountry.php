<?php

class TCountry extends BaseModel {

    public function tableName() {
        return '{{t_country}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('country_code_three', 'required', 'message' => '{attribute} 不能为空'),
            array('country_code_two', 'required', 'message' => '{attribute} 不能为空'),
            array('country_code_num', 'required', 'message' => '{attribute} 不能为空'),
            array('english_name', 'required', 'message' => '{attribute} 不能为空'),
            array('chinese_name', 'required', 'message' => '{attribute} 不能为空'),
			array('country_hzsc', 'required', 'message' => '{attribute} 不能为空'),
			array('is_visible', 'required', 'message' => '{attribute} 不能为空'),
			array('country_code', 'required', 'message' => '{attribute} 不能为空'),
            array('chinese_name', 'unique', 'message' => '{attribute} 数据已存在'),
            array('country_code_three', 'unique', 'message' => '{attribute} 数据已存在'),
            array('country_code_two', 'unique', 'message' => '{attribute} 数据已存在'),
            array('country_code_num', 'numerical', 'integerOnly' => true),
            array($this->safeField(), 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'mall_product_data' => array(self::BELONGS_TO, 'MallProductData', 'product_data_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'country_code_three' => '英文简称',//3位数
            'country_code_num' => '地区编号',
            'english_name' => '英文名',
            'country_code_two' => '英文简称',//2位数
			'chinese_name' => '中文名',
			'location' => '所在洲',
			'local_language' => '官方语言',
			'country_code' => '国际区号',
			'country_hzcode' => '全拼音首字母',
			'country_hzsc' => '第一个字首字母',
			'chinese_name' => '中文名',
			'is_visible' => '显示使用',
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
    public function getCode($is_visible) {
        return $this->findAll('is_visible='.$is_visible);
    }

    public function getTypeCode() {
        return $this->getCode(0);
    }

}
