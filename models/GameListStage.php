<?php

class  GameListStage extends BaseModel {
    public $programs_list = '';
	public $not_null = '123';
    public function tableName() {
        return '{{game_list_stage}}';
    }

    /**
     * 模型验证规则
     */
     public function rules() {
        return array(
            // array('arrange_tname', 'required', 'message' => '{attribute} 不能为空'),
			array('not_null', 'required', 'message' => '{attribute} 不能为空'),
            array('game_id,game_data_id,project_id', 'safe'),
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
            'stage_code' => '赛段编码',
            'stage_name' => '赛段名称',
            'game_id' => '赛事id',
            'game_name' => '赛事名称',
            'game_data_id' => '比赛项目',
            'game_data_name' => '比赛项目名称',
            'project_id' => '赛事项目',
            'game_project_name' => '赛事项目名称',
            'pick_amount' => '总签位数',
            'group_amount' => '总组数',
            'pick_per_group' => '每组签位数',
            
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

    protected function afterFind() {
        parent::afterFind();
    }

}
