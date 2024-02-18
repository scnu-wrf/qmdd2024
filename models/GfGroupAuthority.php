<?php

class GfGroupAuthority extends BaseModel {

    public $user_list = '';

    public function tableName() {
        return '{{gf_group_authority}}';
    }

    public static function model($className = __CLASS__) {
    return parent::model($className);
    }

    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }
}