<?php

class DragonTigerUserAnswer extends BaseModel {
    public function tableName() {
        return '{{dragon_tiger_useranswer}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('order_num,check_number,questions_id,questions_subject_code,subject,type_name,user_answer,whether_right,whether_right_name,earned_score','safe'),
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
            'order_num' => '订单号',
            'check_number' => '考核编号',
            'questions_id' => '题目',
            'questions_subject_code' => '题目编码',
            'subject' => '题目',
            'type_name' => '题目类型名称',
            'user_answer' => '用户答题答案数组',//'用户答题答案数组，编写格式：答案ID：用户答案（选择：532；不选择：533），多选题使用逗号“，”分开，编写为：1:532,2:533'
            'whether_right' => '答案是否匹配',
            'whether_right_name' => '答案名称',
            'earned_score' => '小题得分得分',
            'udate' => '发生时间',
        );
    }
    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getCode($club_type) {
        return $this->findAll('club_type=' . $club_type);
    }
}
