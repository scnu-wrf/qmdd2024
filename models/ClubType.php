<?php
class ClubType extends BaseModel {

    public function tableName() {
        return '{{club_type}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('f_id,f_ctcode,f_ctname,f_level,member_attribute,if_del', 'safe'),
        );
    }
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_f_id' => array(self::BELONGS_TO,'BaseCode','f_id'),
            'base_member_attribute' => array(self::BELONGS_TO,'BaseCode','member_attribute'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => '内部编码',
            'f_id' => '关联base_code', // 关联base_code的f_id字段
            'f_ctcode' => '会员编码',
            'f_ctname' => '会员名称',
            'f_level' => '会员级别',
            'member_attribute' => '会员性质',  
            'if_del' => '是否删除',  // base_code表id 509-逻辑删除 510正常',
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
