<?php

class MallLogisticsFreight extends BaseModel {
    public function tableName() {
        return '{{mall_logistics_freight}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('logistic_id', 'required', 'message' => '{attribute} 不能为空'),
            array('send_area_id', 'required', 'message' => '{attribute} 不能为空'),
            array('get_area_id', 'required', 'message' => '{attribute} 不能为空'),
            array('first_weight', 'required', 'message' => '{attribute} 不能为空'),
            array('next_weight', 'required', 'message' => '{attribute} 不能为空'),
            array('first_pay', 'required', 'message' => '{attribute} 不能为空'),
            array('next_pay', 'required', 'message' => '{attribute} 不能为空'),
            array('logistic_id,send_area_id,get_area_id,first_weight,next_weight,first_pay,next_pay','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
                //'mall_logistics_freight' => array(self::BELONGS_TO, 'MallLogistic', array('logistic_id' => 'f_id')),
                't_region_send' => array(self::BELONGS_TO, 'TRegion','send_area_id'),
                't_region_get' => array(self::BELONGS_TO, 'TRegion','get_area_id'),
            );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'supplier_id' => '供应商',    //供应商，关联表club_list表club_type=3的club_name值
            'logistic_id' => '物流公司ID',    //关联mall_logistic的id，物流公司id   //关联mall_logistic的id，物流公司id
            'send_area_id' => '寄件地',
            'get_area_id' => '目的地',
            'send_area' => '寄件地',
            'get_area' => '目的地',
            'first_weight' => '首重量(kg)',
            'next_weight' => '续重量(kg)',
            'first_pay' => '首付费',
            'next_pay' => '续付费',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getCode($club_type) {
        return $this->findAll('club_type=' . $club_type);
    }

    protected function beforeSave() {
        parent::beforeSave();

        if ($this->isNewRecord) {
            $this->uDate = date('Y-m-d H:i:s');
            
        }
        
        return true;
    }
}
