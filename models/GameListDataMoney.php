<?php

class GameListDataMoney extends BaseModel {

    public function tableName() {
        return '{{game_list_data_money}}';
    }
 
    /**
     * 模型验证规则
     */
    public function rules() {
            return array(
                array('game_data_id,money_name,money','safe'),
            );
    }
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'game_list_data' => array(self::BELONGS_TO, 'GameListData', array('game_id'=> 'id')),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'game_data_id' => '竞赛项目表id',
            'money_name' => '费用名称',
            'money' => '费用金额',
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