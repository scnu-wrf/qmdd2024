<?php

class QmddFunctionVer extends BaseModel {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{qmdd_funtion_ver}}';
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
        'id' => '菜单ID',
        'F_ver' => '版本号',
        'f_data' => '菜单列表',
        );
    }

    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }

}
