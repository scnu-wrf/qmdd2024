<?php

class GfUserFootShow extends BaseModel {

    public function tableName() {
        return '{{gf_user_foot_show}}';
    }

    public static function model($className = __CLASS__) {
    return parent::model($className);
    }

    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }
}