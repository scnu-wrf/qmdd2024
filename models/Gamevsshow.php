<?php

class Gamevsshow extends BaseModel {

    public function tableName() {
        return '{{game_vs_show}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('id,f_type,f_show', 'safe'),
        );
    }


    public function attributeLabels() {
        return array(
          'id' => '内部ID',
          'f_type' =>  '比赛类型，单淘汰，双淘汰',
          'f_show' => '显示方式 4  表示显示是四分之一',
          'f_order' =>'显示顺序',
          'f_code' => '轮次',
          'f_col' =>'轮次序号',
          'f_rowa' =>'主对的行',
          'f_rowd' =>'时间显示所长的行',
          'f_rowb' =>'对所在的',
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
