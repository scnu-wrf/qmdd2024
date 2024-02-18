<?php

class GameListEdit extends BaseModel {
    public $game_code = '';
    public $level_name = '';
	
    public function tableName() {
        return '{{game_list_edit}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        $s2='game_id,game_title,udate,admin_id,admin_account,admin_name,admin_club_id,admin_club_name';
        $a = array(
			array('game_id', 'required', 'message' => '{attribute} 不能为空'),
			array($s2,'safe'),
		);
        return $a;
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
            'id'=>'ID',
            'game_id'=>'赛事id',
            'udate'=>'更改时间',
            'admin_id'=>'操作人员',
            'admin_account'=>'操作人员账号',
            'admin_name'=>'操作人员名称',
            'admin_club_id'=>'操作单位',
            'admin_club_name'=>'操作单位名称',
            'game_code'=>'赛事编号',
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
