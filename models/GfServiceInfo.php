<?php

class GfServiceInfo extends BaseModel {

    public $show=0;
    
    public function tableName() {
        return '{{gf_service_info}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        $s2='code,type,gf_gross,club_gross,product_id,product_code,product_name,json_attr,content,admin_gfnick,add_time,user_name,check_time';
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
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' =>'ID',
            'code' => '编号',
            'type' => '商品类别',
            'gf_gross' => '平台毛利（%）',
            'club_gross' => '发布单位毛利（%）',
            'product_id' => '绑定商品',
            'product_code' => '商品编码',
            'product_name' => '商品名称',
            'json_attr' => '规格',
            'content' => '备注说明',
            'admin_gfnick' => '申请人',
            'add_time' => '申请日期',
            'user_name' => '审批人',
            'check_time' => '审批日期',
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
