<?php

class ClubListUpdate extends BaseModel {
	public $club_list_pic='';
	public $about_me_temp = '';
    public function tableName() {
        return '{{club_list_update}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
		if($this->individual_enterprise==404) {
			 return array(
            array('club_name', 'required', 'message' => '{attribute} 不能为空'),
			array('club_logo_pic', 'required', 'message' => '{attribute} 不能为空'),
			array('club_type', 'required', 'message' => '{attribute} 不能为空'),
            array('partnership_type', 'required', 'message' => '{attribute} 不能为空'),
			array('individual_enterprise', 'required', 'message' => '{attribute} 不能为空'),
            //array('financial_code', 'required', 'message' => '{attribute} 不能为空'),
			array('company', 'required', 'message' => '{attribute} 不能为空'),
			//array('organization_code', 'required', 'message' => '{attribute} 不能为空'),
			array('certificates_number', 'required', 'message' => '{attribute} 不能为空'),
            array('apply_club_gfaccount', 'required', 'message' => '{attribute} 不能为空'),
			array('certificates', 'required', 'message' => '{attribute} 不能为空'),
            array('apply_name', 'required', 'message' => '{attribute} 不能为空'),
			array('contact_phone', 'required', 'message' => '{attribute} 不能为空'),
            array('email', 'required', 'message' => '{attribute} 不能为空'),
			array('apply_id_card', 'required', 'message' => '{attribute} 不能为空'),
            array('contact_id_card_back', 'required', 'message' => '{attribute} 不能为空'),
			array('bank_name', 'required', 'message' => '{attribute} 不能为空'),
            array('bank_branch_name', 'required', 'message' => '{attribute} 不能为空'),
			array('bank_account', 'required', 'message' => '{attribute} 不能为空'),
            array('club_address', 'required', 'message' => '{attribute} 不能为空'),
			array('recommend', 'numerical', 'integerOnly' => true),
			array('club_code,club_name,management_category,company,apply_club_gfnick,financial_code,club_logo_pic,apply_club_gfid,club_type,partnership_type,individual_enterprise,apply_club_id_card,apply_club_phone,apply_club_email,id_card_face,organization_code,certificates_number,valid_until,management_category,contact_phone,email,apply_id_card,contact_id_card_back,certificates,recommend,bank_name,bank_account,club_area_country,club_area_province,club_area_district,club_area_city,club_area_street,club_address,latitude,Longitude,service_hotline,apply_time,isRecommend,state,dispay_xh,club_list_pic,reasons_for_failure,reasons_adminid,reasons_adminname,uDate,if_del,about_me,about_me_temp','safe',), 
		);
		} else {
			return array(
            array('club_name', 'required', 'message' => '{attribute} 不能为空'),
			array('club_logo_pic', 'required', 'message' => '{attribute} 不能为空'),
			array('club_type', 'required', 'message' => '{attribute} 不能为空'),
            array('partnership_type', 'required', 'message' => '{attribute} 不能为空'),
			array('individual_enterprise', 'required', 'message' => '{attribute} 不能为空'),
            //array('financial_code', 'required', 'message' => '{attribute} 不能为空'),
			//array('company', 'required', 'message' => '{attribute} 不能为空'),
			//array('organization_code', 'required', 'message' => '{attribute} 不能为空'),
			//array('certificates_number', 'required', 'message' => '{attribute} 不能为空'),
            array('apply_club_gfaccount', 'required', 'message' => '{attribute} 不能为空'),
			array('certificates', 'required', 'message' => '{attribute} 不能为空'),
            array('apply_name', 'required', 'message' => '{attribute} 不能为空'),
			array('contact_phone', 'required', 'message' => '{attribute} 不能为空'),
            array('email', 'required', 'message' => '{attribute} 不能为空'),
			array('apply_id_card', 'required', 'message' => '{attribute} 不能为空'),
            array('contact_id_card_back', 'required', 'message' => '{attribute} 不能为空'),
			array('bank_name', 'required', 'message' => '{attribute} 不能为空'),
            array('bank_branch_name', 'required', 'message' => '{attribute} 不能为空'),
			array('bank_account', 'required', 'message' => '{attribute} 不能为空'),
            array('club_address', 'required', 'message' => '{attribute} 不能为空'),
			array('recommend', 'numerical', 'integerOnly' => true),
			array('club_code,club_name,management_category,company,apply_club_gfnick,financial_code,club_logo_pic,apply_club_gfid,club_type,partnership_type,individual_enterprise,apply_club_id_card,apply_club_phone,apply_club_email,id_card_face,organization_code,certificates_number,valid_until,management_category,contact_phone,email,apply_id_card,contact_id_card_back,certificates,recommend,bank_name,bank_account,club_area_country,club_area_province,club_area_district,club_area_city,club_area_street,club_address,latitude,Longitude,service_hotline,apply_time,isRecommend,state,dispay_xh,club_list_pic,reasons_for_failure,reasons_adminid,reasons_adminname,uDate,if_del,about_me,about_me_temp','safe',), 
		);
		}
        
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
		    'club_project' => array(self::HAS_MANY, 'ClubProject', 'club_id'),
			'individual_way' => array(self::BELONGS_TO, 'BaseCode', 'individual_enterprise'),
			'clubtype' => array(self::BELONGS_TO, 'BaseCode', 'club_type'),
			'partnertype' => array(self::BELONGS_TO, 'BaseCode', 'partnership_type'),
			'club_list_pic' => array(self::HAS_MANY, 'ClubListPic', 'club_id'),
			'base_code' => array(self::BELONGS_TO, 'BaseCode', 'state'),
		);
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
                'no' => '序号',
			 'club_code' => '社区编码',
			 'financial_code' => '财务编码',
			 'club_name' => '名称',
			 'club_logo_pic' => 'LOGO',
			 'apply_club_gfid' => 'ID',
			 'apply_club_gfaccount' => '申请人帐号',
			 'club_type' => '类型',
			 'club_type_name' => '类型',
			 'partnership_type' => '团体类型',
			 'partnership_name' => '团体类型',
			 'individual_enterprise' => '申请方式',
			 'individual_enterprise_name' => '申请方式',
			 'company' => '公司名称',
			 'apply_club_gfnick' => '法人',
			 'apply_club_id_card' => '法人身份证号',
			 'apply_club_phone' => '法人电话',
			 'apply_club_email' => '法人邮箱',
			 'id_card_face' => '法人身份证',
			 'organization_code' => '机构代码',
			 'certificates_number' => '营业证编号',
			 'certificates'=>'执照/从业证明',
			 'valid_until'=> '有效期',
			 'management_category' => '经营类目',
			 'apply_name' => '联系人',
			 'contact_phone' => '联系人电话',
			 'email' => '联系人邮箱',
			 'apply_id_card' => '联系人身份证',
			 'contact_id_card_back' => '身份证照',
			 'club_list_pic' => '经营证明',
			 'recommend' => '推荐单位',
			 'bank_name' => '开户名称',
			 'bank_branch_name' => '开户行支行名称',
			 'bank_account' => '银行帐号',
			 'club_area_country' => '国家',
			 'club_area_province' => '省',
			 'club_area_district' => '区域区县',
			 'club_area_city' => '社区单位：市',
			 'club_area_street' => '所在区域街道',
			 'club_address' => '详细地址',
			 'latitude' => '纬度',
			 'Longitude' => '经度',
			 'service_hotline' => '客服服务热线',
			 'apply_time' => '创办时间',
			 'uDate' => '更新时间',
			 'isRecommend' => '是否推荐社区',
			 'recommend_club_name' => '推荐社区名',
			 'is_invoice' => '开发票',
			 'invoice_category' => '发票类型',
			 'invoice_product_id' => '发票收费关联商品',
			 'about_me'=> '关于我们',
			 'state' => '当前状态',
			 'state_name' => '状态名称',
			 'if_del' => '是否删除',
			 'news_clicked' => '点击率',
			 'book_club_num' => '订阅数',
			 'beans' => '社区体育豆',
			 'club_credit' => '收益积分',
			 'dispay_xh' => '显示序号',
			 'reasons_for_failure'=>'操作备注',
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
		
		// 图文描述处理
        $basepath = BasePath::model()->getPath(123);
        if ($this->about_me_temp != '') {
            if ($this->about_me != '') {
                set_html($this->about_me, $this->about_me_temp, $basepath);
            } else {
                $rs = set_html('', $this->about_me_temp, $basepath);
                    $this->about_me = $rs['filename'];
            }
        } else {
            $this->about_me = '';
        }
		
		if ($this->isNewRecord) {
           // if (empty($this->club_code)) {
                // 生成社区编码
			//	$club_code = '';
           //     $club_code.=date('Y');
			//	$code = substr('000000' . strval(rand(1, 999999)), -6);
			//	$club_code.=$code;			
            //    $this->club_code = $club_code;
           // }
			$this->apply_time = date('Y-m-d h:i:s');
        }
        
        $this->reasons_adminid = Yii::app()->session['admin_id'];
        $this->reasons_adminname = Yii::app()->session['gfnick'];
        $this->uDate = date('Y-m-d h:i:s');
		
        return true;
	}

    public function getCode($club_type) {
        return $this->findAll('club_type=' . $club_type);
    }
	
	public function getID($id) {
        return $this->findAll('id=' . $id);
    }
}
