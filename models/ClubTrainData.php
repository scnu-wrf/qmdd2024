<?php

class ClubTrainData extends BaseModel {

	public $explain_temp = '';
    public $show=0;
    
    public function tableName() {
        return '{{club_train_data}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        $s2='train_id,type_id,project_id,project_name,train_content,train_money,apply_number,apply_check_way,min_age,max_age,train_time,train_time_end,train_identity_type,train_identity_rank,period';
        if($this->show==0){
            $a = array(
                // array('game_code', 'required', 'message' => '{attribute} 不能为空'),
                array($s2,'safe'),
            );
        } else{
            $a = array(
                array($s2,'safe'),
            );
        }
        return $a;
    }

    public function check_save($show) {
        $this->show=$show;
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'check_way' => array(self::BELONGS_TO, 'BaseCode', 'apply_check_way'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => '自增id',
            'train_id' => '活动id，关联activity_list表id',
            'type_id' => '培训类别，关联club_store_type表id',
            'project_id' => '项目id',
            'project_name' => '项目名称',
            'train_content '=> '活动内容',
            'train_money' => '活动费用（元）',
            'apply_number' => '可报名人数',
            'apply_check_way' => '报名审核方式,关联base_code表id 792人工，793自动；',
            'min_age' => '报名年龄（最小）,为null或0000-00-00为不限',
            'max_age' => '报名年龄（最大）,为null或0000-00-00为不限',
            'train_time' => '培训开始时间',
            'train_time_end' => '培训结束时间',
            'train_identity_type' => '职称要求,关联club_store_rank表id',
            'train_identity_type_name' => '职称要求',
            'train_identity_rank' => '职称等级,关联club_store_rank表id',
            'train_identity_rank_name' => '职称等级',
            'period' => '培训周期',
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
