<?php

class GfMessageOffline extends BaseModel {

    public $user_list = '';

    public function tableName() {
        return '{{gf_message_offline}}';
    }

    public static function model($className = __CLASS__) {
    return parent::model($className);
    }

    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }
}