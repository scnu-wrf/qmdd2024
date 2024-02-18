<?php

class ClubFeeDay extends BaseModel {
    public function tableName() {
        return '{{club_fee_day}}';
    }

    /**
     * * 模型验证规则
     */
    public function rules() {
        return array(
            array('id,f_code,f_name,f_day', 'safe'),
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
            'f_code' => '编码',
            'f_name' => '名称',
            'f_day' => '天数',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        return true;
    }

}
