<?php

class MallClubAddress extends BaseModel {

    public function tableName() {
        return '{{mall_club_address}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('consignee', 'required', 'message' => '{attribute} 不能为空'),
            array('address', 'required', 'message' => '{attribute} 不能为空'),
            array('phone', 'required', 'message' => '{attribute} 不能为空'),
            array('club_id,club_name,consignee,address,phone,zipcode', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'club_id' => '供应商',
            'club_name' => '供应商',
            'consignee' => '收货人姓名',
            'address' => '收货地址',
            'phone' => '联系电话',
            'zipcode' => '邮编',
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
