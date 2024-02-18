<?php

class ProjectSerivce extends BaseModel {

    public $location ='';
      /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{project_serivce}}';
    }

   /*** 模型验证规则*/
    public function rules() {
      return $this->attributeRule();
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }

    public function attributeSets() {
        return array(
        'id' =>'ID',
        'qualification_type_id' => '资质类型',//，关联club_servicer_type表member_second_id
        'project_id' => '项目',//，关联project_list表id
        'min_count' => '资质人最低',//人数
        'max_count' => '资质人最高',
        );
    }

    protected function beforeSave() {
        parent::beforeSave();
        //if ($this->isNewRecord) {
        return true;
    }


}
