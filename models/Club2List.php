<?php

class Club2List extends BaseModel {
    public function tableName() {
        return '{{club2_list}}';
    }
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'clubCode'=>array(self::BELONGS_TO,'ClubList',array('club_id'=>'id')),
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
            'id'=>'ID',
            'club_id' => '一级单位ID',
            'club_code' => '社区编码',
            'club_name' => '社区单位名称',
            'club2_code' => '部门编码',
            'club2_name' => '部门名称',
            'club_memo' => '说明',
            'state' => '状态',
            'state_name' => '状态',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        return true;
    }
}
