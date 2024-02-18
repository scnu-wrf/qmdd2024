<?php
//服务者的排班表，同quanlificationperson相关
class QmddWorkSchdule extends BaseModel {
    public function tableName() {
        return '{{qmdd_workSchdule}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array();
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array();
    }
    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id'=>'ID',
            'qualificationperson_id' => '服务者id',
            'personName' => '服务者姓名',
            'ymd' => '日期',//年月日
            'weekDay'=>'周几',//，1-7
            'workTime_start'=> '开始时间',//小时:分钟，例如9:20
            'workTime_end'=>'结束时间',//小时：分钟
            'club_id'=>'管理团体的唯一标识，俱乐部',
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
    public function getWeekDates($dateStr=''){
        if($dateStr=='') $dateStr=date('Y/m/d');
        $date = DateTime::createFromFormat('Y/m/d', $dateStr);
        $weekDates = array();
        // 设置日期为给定日期的星期一
        $date->modify('monday');
        // 循环获取一周七天的日期
        for ($i = 0; $i < 7; $i++) {
            $weekDates[] = $date->format('Y/m/d');
            $date->modify('+1 day');
        }
        return $weekDates;
    }


}