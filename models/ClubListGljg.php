<?php

class ClubListGljg extends BaseModel {
	public $club_list_pic='';
    public $project_list = '';
	public $remove_project_ids = '';
	public $about_me_temp = '';
    public $show=0;
    public function tableName() {
        return '{{club_list}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        $s2='club_code,club_name,company,apply_club_gfnick,financial_code,club_logo_pic,apply_club_gfid,
        club_type,partnership_type,individual_enterprise,apply_club_id_card,apply_club_phone,apply_club_email,
        id_card_face,organization_code,certificates_number,valid_until,management_category,contact_phone,
        email,apply_id_card,contact_id_card_back,certificates,recommend,bank_name,bank_account,club_area_country,
        club_area_province,club_area_district,club_area_township,club_area_city,club_area_street,club_address,latitude,
        Longitude,service_hotline,apply_time,isRecommend,state,dispay_xh,club_list_pic,reasons_for_failure,reasons_adminid,
        reasons_adminname,uDate,if_del,about_me,data_belong_code,mall_belong_code,bank_branch_name,visible,brand_ids,contact_id_card_face,id_card_back,valid_until_start,apply_name,apply_club_gfaccount,con_address,bank_pic,taxpayer_type,taxpayer_pic,qualification_pics,is_read,apply_gfaccount,company_type_id,member_code,member_code_second';
        if ($this->show == 0) {
            return array(
                    array('company', 'required', 'message' => '{attribute} 不能为空'),
                    array('member_code', 'required', 'message' => '{attribute} 不能为空'),
                    array('member_code_second', 'required', 'message' => '{attribute} 不能为空'),
                    array('company_type_id', 'required', 'message' => '{attribute} 不能为空'),
                    array('club_address', 'required', 'message' => '{attribute} 不能为空'),
                    array('valid_until_start', 'required', 'message' => '{attribute} 不能为空'),
                    //array('valid_until', 'required', 'message' => '{attribute} 不能为空'),
                    array('apply_club_gfnick', 'required', 'message' => '{attribute} 不能为空'),
                    array('apply_club_phone', 'required', 'message' => '{attribute} 不能为空'),
                    // ['apply_club_phone', 'match', 'pattern' => '/^1[34578]\d{9}$/', 'message' => '手机格式错误'],
                    array('apply_club_id_card', 'required', 'message' => '{attribute} 不能为空'),
                    // ['apply_club_id_card', 'match', 'pattern' => '/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/', 'message' => '身份证格式错误'],
                    //['apply_club_id_card', 'match', 'pattern' => '/^[1-9]([0-9]{14}|[0-9]{17})$/', 'message' => '身份证格式错误'],

                    array('id_card_face', 'required', 'message' => '{attribute} 不能为空'),
                    array('id_card_back', 'required', 'message' => '{attribute} 不能为空'),
                    array('apply_name', 'required', 'message' => '{attribute} 不能为空'),
                    array('contact_phone', 'required', 'message' => '{attribute} 不能为空'),
                    // ['contact_phone', 'match', 'pattern' => '/^1[34578]\d{9}$/', 'message' => '手机格式错误'],
                    array('club_list_pic', 'required', 'message' => '{attribute} 不能为空'),
                    array('apply_gfaccount', 'required', 'message' => '{attribute} 不能为空'),
                    array('email', 'required', 'message' => '{attribute} 不能为空'),
                    ['email', 'email', 'message' => '邮箱格式错误'],
                    array($s2, 'safe',),
                );
        }else{
            return array(
                array('member_code', 'required', 'message' => '{attribute} 不能为空'),
                array('member_code_second', 'required', 'message' => '{attribute} 不能为空'),
                array($s2, 'safe',),
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
		    'club_project' => array(self::HAS_MANY, 'ClubProject', 'club_id'),
			'individual_way' => array(self::BELONGS_TO, 'BaseCode', 'individual_enterprise'),
			'clubtype' => array(self::BELONGS_TO, 'BaseCode', 'club_type'),
			'partnertype' => array(self::BELONGS_TO, 'BaseCode', 'partnership_type'),
			'club_list_pic' => array(self::HAS_MANY, 'ClubListPic', 'club_id'),
			'base_code' => array(self::BELONGS_TO, 'BaseCode', 'state'),
			'club_products_type' => array(self::BELONGS_TO, 'ClubProductsType', 'management_category'),
			// 't_region' => array(self::HAS_MANY, 'TRegion', 'club_id'),
            'baseCode_company_type_id' => array(self::BELONGS_TO,'BaseCode',array('company_type_id'=>'f_id')),
            'baseCode_state' => array(self::BELONGS_TO,'BaseCode',array('state'=>'f_id')),
            'baseCode_edit_state' => array(self::BELONGS_TO,'BaseCode',array('edit_state'=>'f_id')),
            'QmddAdministrators_id' => array(self::BELONGS_TO,'QmddAdministrators',array('reasons_adminid'=>'id')),
            'club_type_f_ctcode' => array(self::BELONGS_TO,'ClubType',array('member_code_second'=>'f_ctcode')),
			
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
			'partnership_type' => '团体类型',
			'partnership_name' => '团体类型',
			'individual_enterprise' => '申请方式',
			'individual_enterprise_name' => '申请方式',
			'company' => '申请单位名称',
			'apply_club_gfnick' => '法人姓名',
			'apply_club_id_card' => '身份证号',
			'apply_club_phone' => '联系电话',
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
			'contact_phone' => '联系电话',
			'email' => '联系邮箱',
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
			'state' => '当前状态',
			'state_name' => '状态名称',
			'if_del' => '是否删除',
			'news_clicked' => '点击率',
			'book_club_num' => '订阅数',
			'beans' => '社区体育豆',
			'club_credit' => '收益积分',
			'dispay_xh' => '显示序号',
			'reasons_for_failure'=>'操作备注',
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
            'qualification_pics' => '商家资质',
            'is_read' => '已阅读并同意',
            'company_type_id' => '单位性质',
            'pass_time' => '意向审核时间',
            'edit_apply_time' => '认证申请时间',
            'edit_pass_time' => '认证审核时间',
            'member_code' => '一级会员类型',
            'member_code_second' => '二级会员类型',
            'project_list' => '开通项目',
            'remove_project_ids' => '',



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
    }

    public function setDefaultValue() {
      $s1='club_logo_pic:clublist,id_card_face,contact_id_card_face';
      $s1.='id_card_back,certificates,contact_id_card_face,';
      $pathpic=$s1.'apply_id_card,club_list_pic,bank_pic,taxpayer_pic';
      $s1='Basecod,state:id,state_name:f_name;';
      $s1.='userlist,apply_club_gfid:gf_id,apply_gfaccount:GF_ACCOUNT';
      $relations=$s1.'&apply_name:ZSXM&apply_club_gfaccount:apply_gfaccount';
      $rs=array(
      'sess'=>'reasons_adminid:admin_id,reasons_adminname:gfnick',//保持登录信息
      'date'=>'about_me_time,uDate',//保存修改
      'def_sess'=>'',//保持第一次操作信息
      'def_date'=>'apply_time',//保存地一次修改信息
      'pcipath'=>$pathpic,//属性名:模型名称，模型空取上一个模型
      'relations'=>$relations//关联取值
      );
      return $rs;
    } 

    
protected function beforeSave() {
    parent::beforeSave();
    $this->about_me=getAboutMe($this,'about_me');
    // 图文描述处理
    return true;
}

protected function afterFind() {
    parent::afterFind();
    if ($this->id != null) {
     $project = VideoLiveProject::model()->findAll('video_live_id='.$this->id);
    }
    return true;
}

public function getCode($club_type) {
    return $this->findAll('club_type=' . $club_type);
}
    
    public function getID($id) {
        return $this->findAll('id=' . $id);
    }


}
