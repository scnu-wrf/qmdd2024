<?php

class ClubChangeData extends BaseModel {

	public $explain_temp = '';
    public $show=0;
    
    public function tableName() {
        return '{{club_change_data}}';
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
            'change_id' => '关联id',//change_list表
            'data_id' => '培训类型',//关联club_train_data表id，活关联activity_list_data表id
            'type_id' => '类别',//，关联club_store_type表id
            'type_name' => '类别名称',
            'project_id' => '项目id',
            'project_name' => '项目名称',
            'content' => '服务内容',
            'money' => '服务费用（元）',
            'apply_number' => '可报名人数',
            'apply_check_way' => '审核方式',//0自动 1 手动；
            'min_age' => '最小年龄',
            'max_age' => '最大年龄',
            'start_time' => '培训开始',
            'end_time' => '培训结束',
            'train_identity_type' => '职称要求',
            'train_identity_type_name' => '职称要求',
            'train_identity_rank' => '职称等级',
            'train_identity_rank_name' => '职称等级',
            'period' => '培训周期',
            'video_pic' => '缩略图',
            'video_title' => '视频标题',
            'video_duration' => '视频时长',
            'video_id' => '视频内容',
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
