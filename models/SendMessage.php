<?php

class SendMessage extends BaseModel {

    public function tableName() {
        return '{{qmdd_administrators_send_message}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        $s2='s_type,s_adminid,s_club_code,s_admin_gfaccount,r_club_code,r_admin_gfaccount,r_admin_level,s_time,m_message,m_type,clienttype,from_msg_id';
        return [
            array($s2,'safe',), 
        ];
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

             if(empty($this->s_time)){
                 $this->s_time = date('Y-m-d h:i:s');
             }
         }
        return true;
    }

}
