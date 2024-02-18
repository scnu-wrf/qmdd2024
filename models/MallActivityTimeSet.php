<?php

class  MallActivityTimeSet extends BaseModel {

    public function tableName() {
        return '{{mall_activity_time_set}}';
    }

    /**
     * 模型验证规则
     */
    
     public function rules() {
        return array(
            array('star_time,end_time', 'safe'),
        );
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
			'star_time'=>'开始时间',
			'end_time'=>'结束时间',
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
       
        if ($this->isNewRecord) {
            
            
        }
        return true;
    }

}
