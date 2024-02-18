<?php

class CooperationClub extends BaseModel {

    public function tableName() {
        return '{{cooperation_club}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('club_id, invite_club_id, project_id, join_or_del, join_state', 'numerical', 'integerOnly' => true),
            array('join_reason', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'club' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
            'invite_club' => array(self::BELONGS_TO, 'ClubList', 'invite_club_id'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'join_state'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'club_id' => '邀请单位',
            'invite_club_id' => '被邀请单位',
            'project_id' => '项目',
            'join_or_del' => '加盟或解除',
            'join_reason' => '操作原因',
            'join_time' => '操作时间',
            'join_state' => '操作状态',
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

        $this->join_time = date('Y-m-d H:i:s');

        return true;
    }

}
