<?php

class CooperationClubList extends BaseModel {

    public function tableName() {
        return '{{cooperation_club_list}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array();
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'club' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
            'invite_club' => array(self::BELONGS_TO, 'ClubList', 'invite_club_id'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'cooperation_state'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'club_id' => '单位名称',
            'invite_club_id' => '联盟单位名称',
            'project_id' => '联盟项目',
            'cooperation_state' => '联盟状态',
            'udate' => '更新时间',
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

        if ($this->isNewRecord) {
            // 如果已邀请则跳过
            $rs = $this->find('((club_id=' . $this->club_id . ' AND invite_club_id=' . $this->invite_club_id . ') '
                    . 'OR (invite_club_id=' . $this->club_id . ' AND club_id=' . $this->invite_club_id . ')) AND project_id=' . $this->project_id);
            if ($rs != null) {
                return false;
            }
        }

        $this->udate = date('Y-m-d H:i:s');
        return true;
    }

    public function getLastDeleteLog() {
        $my_club_id = Yii::app()->session['club_id'];
        $patner_club_id = $this->club_id == $my_club_id ? $this->invite_club_id : $this->club_id;
        return CooperationClub::model()->find(array('condition' => '((club_id=' . $my_club_id . ' AND invite_club_id=' . $patner_club_id . ') OR (club_id=' . $patner_club_id . ' AND invite_club_id=' . $my_club_id . ')) AND project_id=' . $this->project_id, 'order' => 'id DESC'));
    }

}
