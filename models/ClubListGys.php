<?php

class ClubListGys extends BaseModel {
	public $club_list_pic='';
	public $about_me_temp = '';
	public $brand_name = '';
	public $brand_logo = '';
	public $brand_lock = '';
	public $remove_brand_ids = '';
	public $show=0;
    public function tableName() {
        return '{{club_list}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        $s2='club_code,club_name,company,apply_club_gfnick,financial_code,club_logo_pic,apply_club_gfid,
		partnership_type,individual_enterprise,apply_club_id_card,apply_club_phone,apply_club_email,
		id_card_face,organization_code,certificates_number,valid_until,management_category,contact_phone,
		email,apply_id_card,contact_id_card_back,certificates,recommend,bank_name,bank_account,club_area_country,
		club_area_township,club_area_street,club_address,latitude,
		Longitude,service_hotline,isRecommend,dispay_xh,club_list_pic,reasons_for_failure,reasons_adminid,
		reasons_adminname,uDate,if_del,about_me,about_me_temp,data_belong_code,mall_belong_code,bank_branch_name,visible,brand_ids,contact_id_card_face,id_card_back,valid_until_start,apply_name,apply_club_gfaccount,con_address,bank_pic,taxpayer_type,taxpayer_pic,qualification_pics,is_read,apply_gfaccount,company_type_id,club_type,recommend,recommend_clubcode,recommend_clubname,edit_adminid,edit_adminname,logon_way,pass_time,edit_pass_time,apply_time,edit_apply_time,state,edit_state,edit_reasons_for_failure';
		if($this->show==0){
			if( $this->state == 721 ){
				return array(
					array('company', 'required', 'message' => '{attribute} 不能为空'),
					array('company_type_id', 'required', 'message' => '{attribute} 不能为空'),
					array('club_address', 'required', 'message' => '{attribute} 不能为空'),
					array('valid_until_start', 'required', 'message' => '{attribute} 不能为空'),
					array('apply_name', 'required', 'message' => '{attribute} 不能为空'),
					array('contact_phone', 'required', 'message' => '{attribute} 不能为空'),
					array('certificates', 'required', 'message' => '{attribute} 不能为空'),
					array('apply_gfaccount', 'required', 'message' => '{attribute} 不能为空'),
					array('email', 'required', 'message' => '{attribute} 不能为空'),
					array('recommend', 'numerical', 'integerOnly' => true),
					array($s2,'safe',),
				);

			}else if($this->state == 2 && ( is_Null($this->edit_state) || $this->edit_state == 721 || $this->edit_state == 1538 )){
				return array(
					array('club_name', 'required', 'message' => '{attribute} 不能为空'),
					array('apply_club_gfnick', 'required', 'message' => '{attribute} 不能为空'),
					array('apply_club_phone', 'required', 'message' => '{attribute} 不能为空'),
					array('apply_club_id_card', 'required', 'message' => '{attribute} 不能为空'),
					array('id_card_face', 'required', 'message' => '{attribute} 不能为空'),
					array('id_card_back', 'required', 'message' => '{attribute} 不能为空'),
					array('club_logo_pic', 'required', 'message' => '{attribute} 不能为空'),
					array('bank_name', 'required', 'message' => '{attribute} 不能为空'),
					array('bank_branch_name', 'required', 'message' => '{attribute} 不能为空'),
					array('bank_account', 'required', 'message' => '{attribute} 不能为空'),
					array('bank_pic', 'required', 'message' => '{attribute} 不能为空'),
					array('partnership_type', 'required', 'message' => '{attribute} 不能为空'),
					array('is_read', 'required', 'message' => '{attribute} 不能为空'),
					array($s2,'safe',),
				);
			}else{
				return [
					array($s2,'safe',),
				];
			}
		}else{
			return [
				array($s2,'safe',),
			];
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
		    'club_project' => array(self::HAS_MANY, 'ClubProject', 'club_id'),
			'individual_way' => array(self::BELONGS_TO, 'BaseCode', 'individual_enterprise'),
			'clubtype' => array(self::BELONGS_TO, 'BaseCode', 'club_type'),
			'partnertype' => array(self::BELONGS_TO, 'BaseCode', 'partnership_type'),
			'club_list_pic' => array(self::HAS_MANY, 'ClubListPic', 'club_id'),
			'base_code' => array(self::BELONGS_TO, 'BaseCode', 'state'),
			'club_products_type' => array(self::BELONGS_TO, 'ClubProductsType', 'management_category'),
            'baseCode_edit_state' => array(self::BELONGS_TO,'BaseCode',array('edit_state'=>'f_id')),
            'QmddAdministrators_id' => array(self::BELONGS_TO,'QmddAdministrators',array('reasons_adminid'=>'id')),
            'club_servicer_type_record' => array(self::BELONGS_TO,'ClubServicerType',array('partnership_type'=>'member_second_id')),
			'reasonsAdmin' => array(self::BELONGS_TO, 'QmddAdministrators', 'reasons_adminid'),
			'editAdmin' => array(self::BELONGS_TO, 'QmddAdministrators', 'edit_adminid'),

		);
    }


    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'no' => '序号',
			'club_code' => '单位管理账号',
			'financial_code' => '财务编码',
			'club_name' => '商家名称',
			'club_logo_pic' => 'LOGO',
			'apply_club_gfid' => 'ID',
			'apply_club_gfaccount' => '申请人帐号',
            'apply_gfaccount' => '账号',
			'club_type' => '类型',
			'club_type_name' => '类型',
			'partnership_type' => '商家类型',
			'partnership_name' => '商家类型',
			'individual_enterprise' => '申请方式',
			'individual_enterprise_name' => '申请方式',
			'company' => '供应商名称',
			'apply_club_gfnick' => '法人/负责人姓名*',
			'apply_club_id_card' => '身份证号码',
			'apply_club_phone' => '电话号码',
			'apply_club_email' => '邮箱',
			'id_card_face' => '身份证正面',
			'id_card_back' => '身份证反面',
			'organization_code' => '机构代码',
			'certificates_number' => '统一社会信用代码',
			'certificates'=>'营业执照',
			'valid_until_start' => '营业开始时间',
			'valid_until'=> '营业结束时间',
			'management_category' => '经营类目',
			'apply_name' => '联系人',
			'contact_phone' => '联系人电话',
			'email' => '联系人邮箱',
			'apply_id_card' => '联系人身份证',
			'con_address' => '联系人地址',
			'contact_id_card_back' => '联系人身份证反面',
			'contact_id_card_face' => '联系人身份证正面',
			'club_list_pic' => '营业执照',
			'recommend' => '推荐单位',
			'bank_name' => '开户名称',
			'bank_branch_name' => '开户行支行名称',
			'bank_account' => '银行帐号',
            'bank_pic' => '银行开户许可证',
			'club_area_country' => '国家',
			'club_area_province' => '省',
			'club_area_district' => '区县',
			'club_area_city' => '市',
			'club_area_street' => '所在区域街道',
			'club_address' => '单位所在地',
			'latitude' => '纬度',
			'Longitude' => '经度',
			'service_hotline' => '客服服务热线',
			'apply_time' => '申请日期',
			'uDate' => '更新时间',
			'isRecommend' => '是否推荐社区',
			'recommend_club_name' => '推荐社区名',
			'is_invoice' => '开发票',
			'invoice_category' => '发票类型',
			'invoice_product_id' => '发票收费关联商品',
			'about_me'=> '关于我们',
			'state' => '审核状态',
			'state_name' => '状态名称',
			'edit_state' => '认证状态',
			'edit_state_name' => '认证状态',
			'if_del' => '是否删除',
			'news_clicked' => '点击率',
			'book_club_num' => '订阅数',
			'beans' => '社区体育豆',
			'club_credit' => '收益积分',
			'dispay_xh' => '显示序号',
			'reasons_for_failure'=>'操作备注',
			'edit_reasons_for_failure'=>'操作备注',
			'data_belong_code' => '单位归属编码',
			'mall_belong_code' => '商城数据归属码',
			'visible' => '是否显示前端',  // 0不显示，1显示',
			'brand_name' => '品牌名称',
			'brand_logo' => '品牌logo',
			'brand_lock' => '品牌简介',
			'brand_id' => '品牌id',
			'brand_ids' => '品牌id合集',
			'club_area_code' => '社区单位区域编号',
            'taxpayer_type' => '是否为一般纳税人',
            'taxpayer_pic' => '一般纳税人证明上传',
            'qualification_pics' => '资质附件',
            'is_read' => '已阅读并同意',
            'company_type_id' => '供应商类型',
            'pass_time' => '审核时间',
            'edit_apply_time' => '申请时间',
            'edit_pass_time' => '审核时间',





		);
	}
    public function gysAttributeLabels() {
        return array(
			'club_code' => '供应商编码',
			'club_name' => '供应商名称',
			'partnership_type' => '供应商类别',
			'management_category' => '经营类目',
			'club_address' => '所在地区',
			'apply_name' => '联系人',
			'contact_phone' => '联系电话',
			'apply_time' => '创建时间',
			'state_name' => '入驻状态',
		);
	}

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
	}

	protected function afterSave() {
		parent::afterSave();
		if ($this->isNewRecord) {
			ClubList::model()->updateByPk($this->id,array('use_club_id'=>$this->id));
		}
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
            }
			if (isset($rs['filename'])) {
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
			if(empty($this->apply_time)&&$this->state==371){
				$this->apply_time = date('Y-m-d h:i:s');
			}
        }

        $this->uDate = date('Y-m-d H:i:s');

        return true;
	}

    public function getCode($club_type) {
        return $this->findAll('club_type=' . $club_type);
    }

	public function getID($id) {
        return $this->findAll('id=' . $id);
	}

	public function getRecursionName($id,$t='') {
		$fater_id = ClubProductsType::model()->find('id='.$id);
		$text=$t;
		if(!empty($fater_id->ct_name)){
			$text=$fater_id->ct_name.'-'.$text;
		}
		if(!empty($fater_id->fater_id)){
			$this->getRecursionName($fater_id->fater_id,$text);
		}else{
			if($_REQUEST['r']=='clubList/index'){
				echo rtrim($text, '-').'<br>';
			}else{
				echo rtrim($text, '-');
			}
		}
    }
}
