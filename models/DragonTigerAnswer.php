<?php

class DragonTigerAnswer extends BaseModel {


   
    public  $answer_list='';
    public function tableName() {
        return '{{dragon_tiger_answer}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            //array('answer', 'required', 'message' => '{attribute} 不能为空'),
            array('questions_id,answer,answer_result,type,subject,subject_score', 'safe'),
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
            'id'=>'ID',
            'questions_id'=>'用户id',
            'subject_code'=>'编码',
            'type'=>'题目类型',
            'type_name'=>'题目类型名称',
            'subject'=>'题目',
            'subject_score'=>'小题得分',
            'answer_list'=>'答案',
            'answer'=>'答案',
            'answer_result'=>'答案结果',
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
