<?php

class MainMenu extends BaseModel {
    public function tableName() {
        return '{{qmdd_menu_main}}';
    }

    /**health_list
     * 模型验证规则
     */
    public function rules() {
        return array(
            array($this->safeField(), 'safe',),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array();
    }

    /**
     * 属性标签若没有自定义则调用父类方法自动自动显示全部字段
     */
    public function attributeLabels(){
        $a1=$this->DiyAttributeLabels();
        return empty($a1)?$this->AutoGetAttributeLabels():$a1;
    }

    /**
     * 自定义属性标签
     * */
    public function DiyAttributeLabels(){
        return array(
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getMenu(){
        $w1=" and loginshow='0'";
        if($_SESSION['admin_id']==1) $w1 ="";
        return MainMenu::model()->findAll("f_show = '1' ".$w1.'order by f_no');
    }

}
