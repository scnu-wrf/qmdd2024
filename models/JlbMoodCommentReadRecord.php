<?php

class JlbMoodCommentReadRecord extends BaseModel {


    public function tableName() {
        return '{{jlb_mood_comment_read_record}}';
    }

    public static function model($className = __CLASS__) {
    return parent::model($className);
    }

    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }
}