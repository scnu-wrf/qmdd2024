<?php

class MallProductsPricePost extends BaseModel {

    //public $project_list = '';
	public function tableName() {
        return '{{mall_products_price_post}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
		   array('set_id,type,count_min,count_max,price_min,price_max,post_count,post_max,post_money,post_price,logistics_id', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
           // 'mall_product_data' => array(self::HAS_MANY, 'MallProductData', array('Fid' => 'id')),
			'base_code' => array(self::BELONGS_TO, 'BaseCode', 'type'),
			'logistics' => array(self::BELONGS_TO, 'MallLogistic', 'logistics_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
		    'id' =>'ID',
            'code' =>'方案编码',
            'title' => '方案标题',
			'post_no' => '邮费序号',
			'purpose' => '上架类型来源',
			'shop_purpose' => '销售方式',
			'product_id' => '商品',
			'product_name' => '商品名称',
			'product_data_id' => '商品属性ID',
			'product_code' => '商品属性编码',
			'json_attr' => '商品属性名称',
			'type' => '计算方式',
			'no' => '商品运费计算方式',
			'price_min' => '单件最低总价',
			'price_max' => '单件最高总价',
			'count_min' => '单件最低数量',
			'count_max' => '单件最高数量',
			'post_count' => '可免邮数量',
			'post_price' => '单件邮费',
			'post_max' => '最高邮费',
			'post_money' => '总邮费',
			'logistics_id' => '物流公司',
			'logistics_company' => '最高邮费',
			'add_adminid' => '操作员',
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
        $this->add_adminid = Yii::app()->session['admin_id'];
        //$this->admin_nick = Yii::app()->session['gfnick'];
        //$this->update = date('Y-m-d h:i:s');

        return true;
    }

}
