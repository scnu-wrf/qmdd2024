<?php

class QualificationsCertificateDetail extends BaseModel {

    public function tableName() {
        return '{{qualifications_certificate_detail}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
		return array(
                array($this->safeField(),'safe'),
            );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'type_id' => array(self::BELONGS_TO, 'club_servicer_type', 'member_second_id'),
        );
    }

    /**
     * 属性标签
     */   
    public function attributeLabels() {
        return array();
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function afterFind() {
        parent::afterFind();
        
        return true;
    }

    protected function beforeSave() {
        parent::beforeSave();
        if ($this->isNewRecord) {
            $this->udate = date('Y-m-d H:i:s');  
        }
        return true;
    }


}
