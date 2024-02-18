<?php

class GfPartnerMemberContent extends BaseModel {


 
    public function tableName() {
        return '{{gf_partner_member_content}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('apply_id,attr_id,attr_content,attr_value_id,attr_pic','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            // 'content' => array(self::HAS_MANY, 'GfPartnerMemberApply', 'apply_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'apply_id' => '入驻申请ID',//关联gf_partner_member_apply表ID
            'attr_id' => '属性ID',//关联gf_partner_member_inputset表attr_id',
            'attr_content' => '属性值内容',
            'attr_value_id' => '属性值可选ID',//，关联gf_partner_member_values表ID',
            'attr_pic' => '属性附件相对路径文件名',//，路径及命名查看base_parh表',
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
    
    public function select($apply_id){
         return $this->findAll('apply_id=' . $apply_id);
    }
 

}
