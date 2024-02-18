<?php

class GfUserFoot extends BaseModel {

    public function tableName() {
        return '{{gf_user_foot}}';
    }

    public static function model($className = __CLASS__) {
    return parent::model($className);
    }

    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }
}