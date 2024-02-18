<?php

class GfFriendshipLink extends BaseModel {


    public function tableName() {
        return '{{gf_friendship_link}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            // array('project_list', 'required', 'message' => '{attribute} 不能为空'),
            // array('advertisement_type', 'required', 'message' => '{attribute} 不能为空'),
            // array('ADVER_TITLE', 'required', 'message' => '{attribute} 不能为空'),
            // array('advertisement_pic', 'required', 'message' => '{attribute} 不能为空'),
            // array('ADVER_DATE_START', 'required', 'message' => '{attribute} 不能为空'),
            // array('ADVER_DATE_END', 'required', 'message' => '{attribute} 不能为空'),
            // array('ADVER_URL_ID', 'required', 'message' => '{attribute} 不能为空'),
            array('email', 'required', 'message' => '{attribute} 不能为空'),
            array('link_address', 'required', 'message' => '{attribute} 不能为空'),
            // array('ADVER_PID,ADVER_STATE,state,advertisement_number,ADVER_WHERE,club_id', 'numerical', 'integerOnly' => true),
            array('title,link_address,logo,email,introduction,add_time,state,state_name,state_qmddid,state_qmddname,reasons_for_failure,udate', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            // 'advertisement_project' => array(self::HAS_MANY, 'AdvertisementProject', 'adv_id'),
			// 'advertisement_insert' => array(self::HAS_MANY, 'AdvertisementInsert', 'adv_id'),
            // 'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
            // 'adver_name' => array(self::BELONGS_TO, 'AdverName', 'advertisement_type'),
            // 'adver_url' => array(self::BELONGS_TO, 'AdverName', 'advertisement_type'),
            // 'mall_products' => array(self::BELONGS_TO, 'MallProducts', 'ADVER_WHERE'),
            // 'mall_product_data' => array(self::BELONGS_TO, 'MallProductData', 'ADVER_WHERE'),
            // 'base_code' => array(self::BELONGS_TO, 'BaseCode', array('state' => 'state')),
            // 'base_code' => array(self::BELONGS_TO, 'BaseCode', 'state_name'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => '编号',
            'title' => '网站名称',
            'logo' => 'LOGO',
            'link_address' => '网址',
            'email' => '邮箱',
            'introduction' => '网站介绍',
            'add_time' => '添加时间',
            'state' => '状态',
            'state_name' => '审核',
            'reasons_for_failure' => '操作备注',
            'state_qmddid' => '审核管理员',
            'state_qmddname' => '操作人',
            'udate' => '更新时间',
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
            $this->add_time=date('Y-m-d H:m:s');
        }
    //    $this->udate=date('Y-m-d H:m:s');

        return true;
    }

}
