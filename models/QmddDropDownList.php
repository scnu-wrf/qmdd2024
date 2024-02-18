<?php

class QmddDropDownList extends BaseModel {
    public $row_0='';
    public $row_1='';
    public $row_2='';
    public $row_3='';
    public $row_4='';
    public $row_5='';
    public $row_6='';
    public $row_7='';
    public $row_8='';
    public $row_9='';
    public $row_10='';
    public $row_11='';
    public $row_12='';
    public $row_13='';
    public $row_14='';
    public $row_15='';
    public $row_16='';
    public $row_17='';
    public $row_18='';
    public $row_19='';
    public $row_20='';
    public $row_21='';
    public $row_22='';
    public $row_23='';
    public $row_24='';
    public $row_25='';
    public $row_26='';
    public $row_27='';
    public $row_28='';
    public $row_29='';
    
    public $field_0='';
    public $field_1='';
    public $field_2='';
    public $field_3='';
    public $field_4='';
    public $field_5='';
    public $field_6='';
    public $field_7='';
    public $field_8='';
    public $field_9='';
    public $field_10='';
    public $field_11='';
    public $field_12='';
    public $field_13='';
    public $field_14='';
    public $field_15='';
    public $field_16='';
    public $field_17='';
    public $field_18='';
    public $field_19='';
    public $field_20='';
    public $field_21='';
    public $field_22='';
    public $field_23='';
    public $field_24='';
    public $field_25='';
    public $field_26='';
    public $field_27='';
    public $field_28='';
    public $field_29='';

    public function tableName() {
        return '{{base_path}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
                //array('', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
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

    public function getPath($f_id) {
        return $this->find('f_id=' . $f_id);
    }

}
