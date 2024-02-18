<?php

class ClubListZlhb extends BaseModel {
	public $club_list_pic='';
	public $about_me_temp = '';
	public $brand_name = '';
	public $brand_logo = '';
	public $brand_lock = '';
	public $show=0;
    public function tableName() {
        return '{{club_list}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        $s2='club_code,club_name,company,apply_club_gfnick,club_logo_pic,apply_club_gfid,
		club_type,partnership_type,apply_club_id_card,apply_club_phone,
		id_card_face,certificates_number,valid_until,contact_phone,
		email,apply_id_card,contact_id_card_back,certificates,bank_name,bank_account,club_area_country,
		club_area_province,club_area_district,club_area_township,club_area_city,club_area_street,club_address,latitude,
		Longitude,apply_time,state,reasons_adminid,
		reasons_adminname,uDate,if_del,bank_branch_name,bank_pic,contact_id_card_face,id_card_back,valid_until_start,apply_name,apply_club_gfaccount,con_address,company_registered_capital,company_type_id,company_type,invoice_distribution_mode,invoice_authorized_book,enter_project_id,taxpayer_type,taxpayer_start_time,taxpayer_end_time,taxpayer_pic,edit_state,edit_state_name,approve_state,club_area_code,unit_state,unit_state_name,lock_date_start,lock_date_end,invoice_category,edit_apply_time,qualification_pics,is_read,reasons_for_failure,pass_time,edit_pass_time,edit_reasons_for_failure,use_club_id,recommend,recommend_clubcode,recommend_clubname,edit_adminid,edit_adminname,logon_way';
		if($_REQUEST['r']=='clubListZlhb/update_data'){
			if($this->show==0){
				if($this->edit_state==1538||$this->edit_state==721||is_Null($this->edit_state)){
					return [
						['club_name', 'required', 'message' => '{attribute} 不能为空'],
						['club_logo_pic', 'required', 'message' => '{attribute} 不能为空'],
						['partnership_type', 'required', 'message' => '{attribute} 不能为空'],
						['taxpayer_type', 'required', 'message' => '{attribute} 不能为空'],
						// ['taxpayer_pic', 'required', 'message' => '{attribute} 不能为空'],
						['bank_name', 'required', 'message' => '{attribute} 不能为空'],
						['bank_branch_name', 'required', 'message' => '{attribute} 不能为空'],
						['bank_account', 'required', 'message' => '{attribute} 不能为空'],
						// ['bank_account' , 'match' , 'pattern' => '/([\d]{4})([\d]{4})([\d]{4})([\d]{4})([\d]{0,})?/' , 'message' => '银行卡号格式错误'],
						['apply_club_gfnick', 'required', 'message' => '{attribute} 不能为空'],
						['apply_club_phone', 'required', 'message' => '{attribute} 不能为空'],
						// ['apply_club_phone' , 'match' , 'pattern' => "/(^(86)\-(0\d{2,3})\-(\d{7,8})\-(\d{1,4})$)|(^0(\d{2,3})\-(\d{7,8})$)|(^0(\d{2,3})\-(\d{7,8})\-(\d{1,4})$)|(^(86)\-(\d{3,4})\-(\d{7,8})$)|(13|15)[0-9]{9}$/|/^1[34578]\d{9}$/" , 'message' => '电话格式错误'],
						['apply_club_id_card', 'required', 'message' => '{attribute} 不能为空'],
						// ['apply_club_id_card' , 'match' , 'pattern' => "/^[1-9]([0-9]{14}|[0-9]{17})$/" , 'message' => '身份证格式错误'],
						['id_card_face', 'required', 'message' => '{attribute} 不能为空'],
						['id_card_back', 'required', 'message' => '{attribute} 不能为空'],
						array('apply_name', 'required', 'message' => '{attribute} 不能为空'),
						array('apply_club_gfaccount', 'required', 'message' => '{attribute} 不能为空'),
						array('contact_phone', 'required', 'message' => '{attribute} 不能为空'),
						// ['contact_phone' , 'match' , 'pattern' => "/(^(86)\-(0\d{2,3})\-(\d{7,8})\-(\d{1,4})$)|(^0(\d{2,3})\-(\d{7,8})$)|(^0(\d{2,3})\-(\d{7,8})\-(\d{1,4})$)|(^(86)\-(\d{3,4})\-(\d{7,8})$)|(13|15)[0-9]{9}$/|/^1[34578]\d{9}$/" , 'message' => '电话格式错误'],
						array('email', 'required', 'message' => '{attribute} 不能为空'),
						['email' , 'email' , 'message' => '邮箱格式错误'],
						array('company', 'required', 'message' => '{attribute} 不能为空'),
						array('valid_until_start', 'required', 'message' => '{attribute} 不能为空'),
						array('certificates', 'required', 'message' => '{attribute} 不能为空'),
						array('company_type_id', 'required', 'message' => '{attribute} 不能为空'),
						array('is_read', 'required', 'requiredValue'=>'649','strict'=> true, 'message' => '请阅读并同意社区单位服务协议'),
						array($s2,'safe',), 
					];
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
		}else{
			if($this->show==0){
				if($this->state==1538||$this->state==721){
					return [
						array('apply_name', 'required', 'message' => '{attribute} 不能为空'),
						array('apply_club_gfaccount', 'required', 'message' => '{attribute} 不能为空'),
						array('contact_phone', 'required', 'message' => '{attribute} 不能为空'),
						// ['contact_phone' , 'match' , 'pattern' => "/(^(86)\-(0\d{2,3})\-(\d{7,8})\-(\d{1,4})$)|(^0(\d{2,3})\-(\d{7,8})$)|(^0(\d{2,3})\-(\d{7,8})\-(\d{1,4})$)|(^(86)\-(\d{3,4})\-(\d{7,8})$)|(13|15)[0-9]{9}$/|/^1[34578]\d{9}$/" , 'message' => '电话格式错误'],
						array('email', 'required', 'message' => '{attribute} 不能为空'),
						['email' , 'email' , 'message' => '邮箱格式错误'],
						array('company', 'required', 'message' => '{attribute} 不能为空'),
						array('valid_until_start', 'required', 'message' => '{attribute} 不能为空'),
						array('certificates', 'required', 'message' => '{attribute} 不能为空'),
						array('company_type_id', 'required', 'message' => '{attribute} 不能为空'),
						array($s2,'safe',), 
					];
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
	}
	public function check_save($show) {
        $this->show=$show;
    }

	public function checkUsername($attribute , $params){
		// echo $this->attribute , '<br />>';
		if($this->$attribute == 649){
			$this->addError($attribute , $params['message']);
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
			'enter_project' => array(self::BELONGS_TO, 'ProjectList', 'enter_project_id'),
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
			'club_name' => '服务平台名称',
			'club_logo_pic' => 'LOGO',
			'apply_club_gfid' => 'ID',
			'apply_club_gfaccount' => '帐号',
			'club_type' => '类型',
			'club_type_name' => '类型',
			'partnership_type' => '战略伙伴类型',
			'partnership_name' => '战略伙伴类型',
			'individual_enterprise' => '申请方式',
			'individual_enterprise_name' => '申请方式',
			'company' => '单位名称',
			'apply_club_gfnick' => '法人',
			'apply_club_id_card' => '法人身份证号',
			'apply_club_phone' => '法人电话',
			'apply_club_email' => '法人邮箱',
			'id_card_face' => '法人身份证正面',
			'id_card_back' => '法人身份证反面',
			'organization_code' => '机构代码',
			'certificates_number' => '统一社会信用代码',
			'certificates'=>'营业执照',
			'valid_until_start' => '营业期限',
			'valid_until'=> '至',
			'management_category' => '经营类目',
			'apply_name' => '联系人',
			'contact_phone' => '联系电话',
			'email' => '联系邮箱',
			'apply_id_card' => '身份证号码',
			'con_address' => '联系地址',
			'contact_id_card_back' => '联系人身份证反面',
			'contact_id_card_face' => '联系人身份证正面',
			'club_list_pic' => '营业执照',
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
			'edit_apply_time' => '申请日期',
			'uDate' => '更新时间',
			'pass_time'=>'审核时间',
			'edit_pass_time'=>'审核时间',
			'reasons_adminid' => '操作员',
			'reasons_adminname' => '操作员',
			'isRecommend' => '是否推荐社区',
			'recommend_club_name' => '推荐社区名',
			'recommend' => '推荐单位id',
			'recommend_clubcode' => '推荐单位账号',
			'recommend_clubname'=>'推荐单位名称',
			'is_invoice' => '开发票',
			'invoice_category' => '发票类型',
			'invoice_distribution_mode' => '发票配送方式',
			'invoice_authorized_book' => '票种核定书',
			'invoice_product_id' => '发票收费关联商品',
			'about_me'=> '关于我们',
			'state' => '审核状态',
			'state_name' => '审核状态',
			'edit_state' => '审核状态',
			'edit_state_name' => '审核状态',
			'if_del' => '是否删除',
			'news_clicked' => '点击率',
			'book_club_num' => '订阅数',
			'beans' => '社区体育豆',
			'club_credit' => '收益积分',
			'dispay_xh' => '显示序号',
			'reasons_for_failure'=>'备注',
			'edit_reasons_for_failure'=>'备注',
			'data_belong_code' => '单位归属编码',
			'mall_belong_code' => '商城数据归属码',
			'visible' => '是否显示前端',  // 0不显示，1显示',
            'club_area_code' => '社区单位区域编号',
            'company_registered_capital' => '注册资本',
            'company_type_id' => '单位性质',
			'company_type' => '单位性质',
			'enter_project_id' => '入驻项目',
			'approve_state' => '认证方式',
			'qualification_pics' => '上传协议',
			'taxpayer_type' => '是否为一般纳税人',
			'taxpayer_start_time' => '一般纳税人证明有效期',
			'taxpayer_end_time' => '至',
			'taxpayer_pic' => '一般纳税人证明上传',
			'unit_state' => '状态',
			'unit_state_name' => '状态',
			'lock_date_start' => '注销时间',
			'lock_date_end' => '注销结束时间',
			'is_read' => '已阅读并同意《<a target="_Blank" href="https://gw.gfinter.net/?device_type=7&c=info&a=page_switch&category=rule&page=partner_service-agreement" >GF平台战略伙伴服务协议</a>》'
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
}
