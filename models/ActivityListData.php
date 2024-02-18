<?php

class ActivityListData extends BaseModel {

	public $explain_temp = '';
    public $show=0;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{activity_list_data}}';
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
  public function rules() {
      return $this->attributeRule();
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }
    public function attributeSets() {
        return array(
            'id' => '自增id',
            'activity_id' => '活动id',//，关联activity_list表id
            'project_id' => '项目id',
            'project_name' => '项目名称',
            'activity_content' => '活动内容',
            'activity_money' => '活动费用（元）',
            'apply_number' => '可报名人数',
            'apply_check_way' => '报名审核方式',
            'min_age' => '报名最小年龄',
            'max_age' => '报名最大年龄',
            'activity_time' => '开始时间',
            'activity_time_end' => '截止时间'
        );
    }

    protected function beforeSave() {
        parent::beforeSave();

        return true;
    }


}
