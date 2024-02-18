<?php

class  ActivitySignList extends BaseModel {

    public $show=0;
    public $if_notice=648;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{activity_sign_list}}';
    }
    public function check_save($show) {
        $this->show=$show;
    }
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'activity_list' => array(self::BELONGS_TO, 'ActivityList', 'activity_id'),
            'activity_data' => array(self::BELONGS_TO, 'ActivityListData', 'activity_data_id'),
            'user' => array(self::BELONGS_TO, 'userlist', 'sign_gfid'),
            'gData' => array(self::BELONGS_TO, 'GfServiceData', ['order_num'=>'order_num']),
        );
    }
public function rules() {
      return $this->attributeRule();
    }
    /** * 属性标签 */
public function attributeLabels() {
        return $this->getAttributeSet();
    }
public function attributeSets() {
        return array(
        'id' => 'ID',
        'activity_id' => '活动标题',
        'activity_code' => '活动编号',
        'activity_title' => '活动标题',
        'activity_data_id' => '活动内容',
        'activity_data_content'=> '活动内容',
        'sign_gfid' => '参与人ID',
        'sign_account' => '账号',
        'sign_name' => '报名人',
        'sign_sex' => '性别',
        'sige_phone' => '联系电话',
        'uDate' => '更新时间，自动更新',
        'state' => '状态',
        'state_name' => '审核状态',
        'audit_time' => '审核日期',
        'adminid' => '审核操作员id',
        'adminname' => '审核员',
        'if_notice' => '发送通知'
        );
    }

    protected function beforeSave() {
        if ($this->isNewRecord) {
        }
        return true;
    }

}
