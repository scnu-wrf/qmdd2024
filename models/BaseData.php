<?php

class BaseData extends BaseModel {




    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{base_data}}';
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
        'F_CODE' => '编号',
        'F_NAME' => '数据名称',
        'F_ver' => '版本号',
        'f_data' => 'json数据',
        );
    }
    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }

}
