<?php

class GiftAssociation extends BaseModel {

    public function tableName() {
        return '{{gift_association}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('type', 'required', 'message' => '{attribute} 不能为空'),
            array('type_id', 'required', 'message' => '{attribute} 不能为空'),
            array('relation_type', 'required', 'message' => '{attribute} 不能为空'),
            array('relation_id', 'required', 'message' => '{attribute} 不能为空'),
            array('type,type_id,relation_type,relation_id', 'numerical', 'integerOnly' => true),
            array('relation_ico, relation_name, relation_json_attr, relation_num', 'safe'),
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
            'id' => 'ID',
            'type' => '商品来源类型',
            'type_id' => '商品来源类型ID',
            'relation_type' => '赠送商品来源类型',
            'relation_id' => '赠送商品来源类型ID',
            'relation_ico' => '赠品商品缩略图',
            'relation_name' => '赠品商品名称',
            'relation_json_attr' => '赠品商品规格属性',
            'relation_num' => '赠品商品数量',
            'support' => '',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
