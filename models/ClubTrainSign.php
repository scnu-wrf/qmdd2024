<?php

class  ClubTrainSign extends BaseModel {

    public $show=0;
    public $if_notice=648;
    
    public function tableName() {
        return '{{club_train_sign}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        $s2='train_club_id,train_id,train_code,train_title,train_data_id,train_data_content,sign_gfid,sign_sex,sign_account,sign_name,sige_phone,work_unit,Photo,train_identity_type,train_identity_rank,train_identity_code,train_identity_image,state,audit_time,adminid,adminname,logon_way,if_notice,free_state_Id,pay_confirm_time';
        if($this->show==0){
            return array(
                // array('train_id,train_data_id', 'required', 'message' => '{attribute} 不能为空'),
                array($s2, 'safe'),
            );
        } else{
            return array(
                array($s2, 'safe'),
            );

        }
    }

    public function check_save($show) {
        $this->show=$show;
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'train_list' => array(self::BELONGS_TO, 'ClubStoreTrain', 'train_id'),
            'train_data' => array(self::BELONGS_TO, 'ClubTrainData', 'train_data_id'),
            'user' => array(self::BELONGS_TO, 'userlist', 'sign_gfid'),
            'gData' => array(self::BELONGS_TO, 'GfServiceData', ['order_num'=>'order_num']),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'train_club_id' => '发布活动单位id ，关联club_list表id',
            'train_id' => '培训id，关联club_store_train表id',
            'train_code' => '培训编号',
            'train_title' => '培训标题',
            'train_data_id' => '培训内容',
            'train_data_content' => '培训内容',
            'sign_gfid' => '参与人ID',
            'sign_account' => '账号',
            'sign_name' => '报名人',
            'sign_sex' => '性别',
            'sige_phone' => '联系电话',
            'work_unit' => '工作单位',
            'Photo' => '一寸照片',
            'train_identity_type' => '职称要求',
            'train_identity_rank' => '职称等级',
            'train_identity_code' => '证书编号',
            'train_identity_image' => '上传图片',
            'uDate' => '更新时间，自动更新',
            'state' => '状态',
            'state_name' => '审核状态',
            'audit_time' => '审核日期',
            'adminid' => '审核操作员id,关联qmdd_administrators表id',
            'adminname' => '审核员',
            'if_notice' => '发送通知'
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        if ($this->isNewRecord) {
            
        }
        return true;
    }

}
