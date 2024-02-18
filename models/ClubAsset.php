<?php

class ClubAsset extends BaseModel {

    public function tableName() {
        return '{{club_list}}';
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
           // 'mall_product_data' => array(self::BELONGS_TO, 'MallProductData', 'product_data_id'),
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
		    'id' => 'ID',
            'club_code' => '单位编码',
            'club_name' => '单位名称',
            'beans' => '体育豆',
            'club_credit' => '积分',
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        parent::beforeSave();

        return true;
    }

}
