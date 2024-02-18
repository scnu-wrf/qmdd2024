<?php

class DragonTigerQuestion extends BaseModel {

    public  $type='';
    public  $type_name='';
    public  $subject='';
    public  $subject_code='';
    public  $answer_list='';
    public  $answer_result='';
    public  $programs='';
    
    public function tableName() {
        return '{{dragon_tiger_questions}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            // array('', 'required', 'message' => '{attribute} 不能为空'),
            // array('', 'required', 'message' => '{attribute} 不能为空'),
            // array('', 'required', 'message' => '{attribute} 不能为空'),
            // array('', 'required', 'message' => '{attribute} 不能为空'),
            // array('', 'required', 'message' => '{attribute} 不能为空'),
            array('member_type,project_id,grade,type,subject,qualified_score,questions_529type_num,questions_530type_num,questions_528type_num,exam_time', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'member_type'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList','project_id'),
            'member_card' => array(self::BELONGS_TO, 'MemberCard','grade'),
            'types' => array(self::BELONGS_TO, 'BaseCode', 'type'),
            'answers' => array(self::BELONGS_TO, 'DragonTigerAnswer', 'answer_result'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'project_id' => '项目',  //关联Project_list表
            'project_name' => '项目名称',  
            'member_type' => '会员类型',             //会员类型，关联base_code表MEMBERTYPE类型id: 210-GF会员  501 服务者
            'member_type_name' => '会员类型名称',
                          
            'grade' => '等级',                     //会员等级，关联member_card表id
            'grade_name'=>'会员等级名称',
            'exam_time' => '考核用时最长时间(秒)',  
            'qualified_score' => '考核标准合格分',     
            'questions_528type_num' => '单选题数量', 
            'questions_529type_num' => '多选题数量',         
            'questions_530type_num' => '判断选题数量',
            'add_time' => '添加时间',
            'udate' => '更新时间',         //关联base_code表ANSWER类型ID532-正确 533-不正确
            'subject' => '题目', 
            'type' => '题目类型', 
            'answer_list' => '答案',         
            'answer_result' => '答案结果',
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


        // if ($this->isNewRecord) {
        //     if (empty($this->code)) {
        //         // 生成服务编号
        //         $code =rand(100, 999);
        //         $count = $this->count();
        //         $code = substr(strval($count + 1), -3);
        //         $code.=$code;
                
        //         $this->code = $code;
        //     }
        // }

//        if (Yii::app()->session['club_id'] != 1) {
//            unset($this->is_dispay);
//            unset($this->state);
//        }
        return true;
    }
}
