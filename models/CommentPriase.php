<?php

class CommentPriase extends BaseModel {


    public function tableName() {
        return '{{comment_priase}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
            'base_code_sex' => array(self::BELONGS_TO, 'BaseCode', 'real_sex'),
            'base_code_status' => array(self::BELONGS_TO, 'BaseCode', 'club_status'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'member_project_id'),
        );
    }

    /**
     * 属性标签
     */  
    public function attributeLabels() {
        return array(
            'id'=>'ID',
            'source_gfid'=>'点赞人gfid',
            'info_id'=>'评论id',//对应comment_list表评论id
            'praise_time' => '点赞时间',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function afterFind() {
        parent::afterFind();

        
        return true;
    }

    protected function beforeSave() {
        parent::beforeSave();
        

        return true;
    }


}
