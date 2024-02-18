<?php

class MallProductData extends BaseModel {

    public function tableName() {
        return '{{mall_product_data}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
		    array('Fid,product_name,code,json_attr,purchase_price,price,unit,count,product_LOG', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'mall_products' => array(self::BELONGS_TO, 'MallProducts', 'Fid'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
		   'id' =>'ID',
            'code' =>'商家货号',
            'json_attr' => '规格名称',
            'product_LOG' => '规格图片',
            'purchase_price' => '采购价',
            'price' => '建议销售价格',
			'unit' => '单位',
			'count' => '数量',
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
	
	public function getProductData($Fid) {
		$cooperation= $this->findAll('Fid=' . $Fid);
         $arr = array();$r=0;
        foreach ($cooperation as $v) {
                $arr[$r]['code'] = $v->code;
                $arr[$r]['json_attr'] = $v->json_attr;
				$arr[$r]['product_LOG'] = $v->product_LOG;
				$arr[$r]['purchase_price'] = $v->purchase_price;
				$arr[$r]['price'] = $v->price;
				$arr[$r]['unit'] = $v->unit;
				$arr[$r]['count'] = $v->count;
                $r=$r+1;
        }
        return $arr;
    }

}
