<?php

class ClubServiceDetailed extends BaseModel {

    public function tableName() {
        return '{{club_service_detailed}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('saleable_quantity', 'numerical', 'integerOnly' => true),
            array('service_code, service_date, service_datatime_start, service_datatime_end, time_declare, auantity_sold', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'gift_association' => array(self::HAS_MANY, 'GiftAssociation', 'type_id', 'condition' => 'gift_association.type=353'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'service_id' => '服务ID',  // 关联club_service_data表ID
            'service_code' => '服务编号',
            'service_date' => '服务日期',
            'service_datatime_start' => '开始时间',
            'service_datatime_end' => '结束时间',
            'time_declare' => '服务说明',
            'if_del' => '是否删除下架',  // 关联base_code表DATA类型 509-逻辑删除 510正常
            'saleable_quantity' => '可销售数量',
            'auantity_sold' => '已销售数量',
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
