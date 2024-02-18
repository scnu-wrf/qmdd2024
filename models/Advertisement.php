<?php

class Advertisement extends BaseModel {

    public $project_list = '';
	public $video_live = '';
	public $boutique_video = '';

    public function tableName() {
        return '{{advertisement}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('project_list', 'required', 'message' => '{attribute} 不能为空'),
            array('advertisement_type', 'required', 'message' => '{attribute} 不能为空'),
            array('ADVER_TITLE', 'required', 'message' => '{attribute} 不能为空'),
            array('advertisement_pic', 'required', 'message' => '{attribute} 不能为空'),
            array('ADVER_DATE_START', 'required', 'message' => '{attribute} 不能为空'),
            array('ADVER_DATE_END', 'required', 'message' => '{attribute} 不能为空'),
            array('ADVER_URL_ID', 'required', 'message' => '{attribute} 不能为空'),
            //array('ADVER_WHERE', 'required', 'message' => '{attribute} 不能为空'),
            //array('club_id', 'required', 'message' => '{attribute} 不能为空'),
            array('ADVER_PID,ADVER_STATE,state,advertisement_number,ADVER_WHERE,club_id', 'numerical', 'integerOnly' => true),
            array('advertisement_type,ADVER_NAME,sname_id,ADVER_TITLE,advertisement_pic,advertisement_number,ADVER_DATE_START,ADVER_DATE_END,ADVER_STATE,ADVER_URL,ADVER_URL_ID,ADVER_WHERE,adver_insert_mode,add_time,club_id,ADVER_PID,state,reasons_for_failure,ver,show_all_club', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'advertisement_project' => array(self::HAS_MANY, 'AdvertisementProject', 'adv_id'),
			'advertisement_insert' => array(self::HAS_MANY, 'AdvertisementInsert', 'adv_id'),
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
            'adver_name' => array(self::BELONGS_TO, 'AdverName', 'advertisement_type'),
            'adver_url' => array(self::BELONGS_TO, 'AdverName', 'advertisement_type'),
            'mall_products' => array(self::BELONGS_TO, 'MallProducts', 'ADVER_WHERE'),
            'mall_product_data' => array(self::BELONGS_TO, 'MallProductData', 'ADVER_WHERE'),
            'base_code' => array(self::BELONGS_TO, 'BaseCode', array('state' => 'f_id')),
			'mall_products_type_sname' => array(self::BELONGS_TO, 'MallProductsTypeSname', 'sname_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'project_list' => '项目',
            'id' => 'ID',
            'adver_code' => '广告编码',
            'advertisement_type' => '广告类型',
            'ADVER_NAME' => '广告分类名称',
            'ADVER_TITLE' => '广告标题',
            'advertisement_pic' => '封面图',
            'advertisement_number' => '排序',
            'ADVER_DATE_START' => '上线日期',
            'ADVER_DATE_END' => '下线日期',
            'ADVER_STATE' => '上线状态',
            'ADVER_URL' => '具体内容',
            'ADVER_URL_ID' => '跳转类型',
            'ADVER_URL_NAME' => '关联名称',
            'ADVER_WHERE' => '具体内容',
            'uDate' => '申请时间',
            'club_id' => '发布单位',
            'ADVER_PID' => '父广告',
            'state' => '审核状态',
            'reasons_for_failure' => '审核备注',
            'ver' => '版本号',
			'adver_insert_mode'=>'插播设置',
			'sname_id'=>'分类',
            'show_all_club'=>'推荐全部',
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

        // 广告类型
        $adver_name = AdverName::model()->find('id='.$this->advertisement_type);
        if ($adver_name == null) {
            return false;
        }
        $this->ADVER_NAME = $adver_name->adv_name;

        // 跳转类型
        $adver_url = AdverUrl::model()->find($this->ADVER_URL_ID);
        if ($adver_url == null) {
            return false;
        }
        $this->ADVER_URL_NAME = $adver_url->ADV_URL_NAME;

        if ($this->isNewRecord) {
            $this->add_time = date('Y-m-d H:i:s');
            // 广告编码
            $count = $this->count();
            $code = substr('00000' . strval($count + 1), -5);
            $this->adver_code = strtoupper($adver_name->adv_code) . $code;
			$this->add_time = date('Y-m-d H:i:s');
        }
        $this->admin_id = get_session('admin_id');
        $this->admin_gfnick = get_session('admin_name');
        $this->uDate = date('Y-m-d H:i:s');
//        if (Yii::app()->session['club_id'] != 1) {
//            $this->club_id = Yii::app()->session['club_id'];
//            unset($this->ADVER_STATE);
//            unset($this->state);
//        }

        return true;
    }

}
