<?php

class QmddRoleClub extends BaseModel {
    public $tmp=array();
    public function tableName() {
        return '{{qmdd_role_club}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
           // array('f_rcode', 'required', 'message' => '{attribute} 不能为空'),
            array('f_roleid,f_rcode,f_rname,f_club_item_type,f_club_item_type_name,f_club_type,f_club_type_name' ,'safe'),
        );
    }


    public function attributeLabels() {
        return array(
            'f_roleid' =>'角色',
            'f_rcode' => '角色编码',
            'f_rname' => '角色名称',
            'f_club_item_type' => '单位类型',
            'f_club_item_type_name' =>'类型名称',
            'f_club_type' => '二级类型',
            'f_club_type_name' => '二级类型名称',
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



}
