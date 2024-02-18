<?php

class Vipmode extends BaseModel {

   /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{gf_idel_user_vipmode}}';
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
        'id' => 'ID',
        'f_code' => '代码',
        'f_name' => '名称',
        'f_mode' => '格式',
        'f_lvevl' => '级别',
        'f_len' => '长度',
        );
    }
}
