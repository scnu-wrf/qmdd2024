<?php

class GameListOrganizational extends BaseModel {

    public function tableName() {
        return '{{game_list_organizational}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('game_id,organizational_type,organizational','safe'),
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
            'id' => 'ID',
            'game_id' => '赛事ID',
            'organizational_type' => '组织单位类型',
            'organizational' => '赛事组织单位',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}
