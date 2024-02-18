<?php

class ServicerCertificate extends BaseModel {


    public $location ='';
    public function tableName() {
        return '{{servicer_certificate}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('f_code, f_name, f_type_name, F_COL1, F_COL2, F_COL3, fater_id', 'safe'),
        );
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
            'id' => 'id',
            'f_code' => '编码',
            'f_name' => '证书名称',
            'f_type_name' => '等级',
            'F_COL1' => '置换服务者等级分标准',
            'F_COL2' => '置换社区单位星级分标准',
            'F_COL3' => '资质置换龙虎积分标准',
            'fater_id' => '父级id',
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
