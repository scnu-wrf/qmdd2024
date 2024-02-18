<?php

class QmddServerPerson extends BaseModel {

	public $introduct_temp = '';
	public $video_list = '';

    public function tableName() {
        return '{{qmdd_server_person}}';
    }

	public function rules() {
		return array(
            array('project_id', 'required', 'message' => '{attribute} 不能为空'),
			// array('gfaccount', 'required', 'message' => '{attribute} 不能为空'),
			array('servic_site_name', 'required', 'message' => '{attribute} 不能为空'),
			// array('server_name', 'required', 'message' => '{attribute} 不能为空'),
			array('person_id', 'required', 'message' => '{attribute} 不能为空'),
			// array('area_address', 'required', 'message' => '{attribute} 不能为空'),
			// array('navigatio_address', 'required', 'message' => '{attribute} 不能为空'),
			array('head_pic', 'required', 'message' => '{attribute} 不能为空'),
			array('qualification_image', 'required', 'message' => '{attribute} 不能为空'),
			// array('phone', 'required', 'message' => '{attribute} 不能为空'),
			// array('phone','numerical', 'integerOnly' => true),
			array('server_name,gfid,gfaccount,qualification_title,if_del,project_id,qualification_type_id,
				qualification_code,qualification_time,start_date,end_date,identity_num,qualification_level,if_apply_display,
				check_state,reasons_for_failure,phone,email,qualification_name,qualification_image,introduct,introduct_temp,person_id,
				video_url,level_name,qualification_score,code_project,code_type,code_year,
				code_num,gf_code,area_address,area_country,area_province,area_city,area_district,area_township,
				area_street,latitude,Longitude,club_id,servic_site_id,qcode,qualificate_id,head_pic,servic_site_name,anchored_project_id,navigatio_address','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
		return array(
			//'videos' => array(self::BELONGS_TO, 'QualificationVideos', 'vidio_list'),
			'base_code' => array(self::BELONGS_TO, 'BaseCode', 'identity_num'),
			'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
			'qmddsite' => array(self::BELONGS_TO, 'GfSite', 'servic_site_id'),
			'qmdd_user_type' => array(self::BELONGS_TO, 'QmddServerUsertype', 'qualification_type_id'),
		);
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'video_url'=>'视频',
			'person_id'=>'服务者',
            'qcode'=>'资源编号',
			'server_name'=>'资源名称',  // 服务名称
			'gfid'=>'id',
			'phone'=> '场馆电话',  // 联系电话
			'email'=> '电子邮箱',
			'gfaccount'=> '帐号',
			'qualification_name'=> '服务者',  // 服务者名称
			'qualification_type_id'=>'服务者类别',
			'qualification_type'=>'类别',
			'code_project'=> '项目编码',
			'code_type'=> '类型编码',
			'code_year'=> '年份',
			'code_num'=>'编号',
			'gf_code'=> '服务者编码',
			'identity_num'=>'证书等级',  // 资质等级
			'qualification_title'=>'资质等级',    // 证书名
			'qualification_code'=>'证书编号',
			'qualification_image'=>'详情图',
			'head_pic'=>'缩略图',
			'club_id'=>'发布单位',
			'anchored_project_id' => '挂靠项目',
			'project_id'=>'登记项目',  // 服务项目
			'project_name'=>'服务项目',
			'process_id'=>'审核员',
			'process_account'=>'操作人帐号',
			'process_nick'=>'处理人',
			'uDate'=> '登记时间',
			'state_time'=> '审核时间',  // 操作更新时间
			'check_state'=>'审核状态',
			'check_state_name'=>'审核状态',
			'reasons_for_failure'=>'备注',  // 未通过原因
			'qualification_time'=> '获得资质时间',
			'synopsis'=>'简介',
			'introduct'=>'服务者人介绍',
			'introduct_temp'=>'服务者人介绍',
			'qualification_level'=> '服务者等级',
			'level_name'=>'资源等级',
			'qualification_score'=>'服务分',
			'order_num'=>'订单号',
			'is_pay'=>'支付状态',
			'start_date'=> '资质期限开始日期',
			'end_date'=> '资质期限结束日期',  // 有限期至
			'if_apply_display'=>'求职显示',
			'if_del'=>'服务者状态',
			'auth_state_name'=>'申请状态',
			'area_address'=>'场馆地点',  // 服务地址,驻场地点
			'servic_site_id'=>'服务场地',
			'servic_site_name'=>'驻场场馆',  // 驻场场地名称
			'qualificate_id'=>'服务者',  // 关联qualifications_person表id
			'is_display' => '是否删除',
			'navigatio_address' => '场馆定位',  // 导航定位
			'is_salable' => '是否可售',  // 0：否，1：是
			'is_release' => '是否发布',  // 0：否，1：是
			'set_salable_time' => '是否可售 的设置时间',

			'area_address1' => '驻场场地',
			'area_address2' => '驻场/归属场地',
			'area_address_phone' => '驻场电话',
			'check_state1' => '状态',
			'servic_site_id1' => '驻场场地名称',
			'qmdd_user_type1' => '服务类型',
			'club_id1' => '所属单位',
			'check_state1' => '状态',
			'uDate1' => '申请时间',
        );
    }

    protected function beforeSave() {
        parent::beforeSave();
		// 图文描述处理
        $basepath = BasePath::model()->getPath(269);
        if ($this->introduct_temp != '') {
            if ($this->introduct != '') {
                set_html($this->introduct, $this->introduct_temp, $basepath);
            } else {
                $rs = set_html('', $this->introduct_temp, $basepath);
            }
			if (isset($rs['filename'])) {
                $this->introduct = $rs['filename'];
            }
        } else {
            $this->introduct = '';
		}
		if($this->check_state==2 || $this->check_state==373 || $this->check_state==1538){
			$this->state_time = date('Y-m-d h:i:s');
		}
		if(empty($this->qcode)){
			$club_list = ClubList::model()->find('id='.$this->club_id);
			$type_list = QmddServerUsertype::model()->find('id='.$this->qualification_type_id);
			$date = substr(date('Y'),2).date('m');
			$club_code = !empty($club_list) ? $club_list->club_code : '';
			$type_code = !empty($type_list) ? $type_list->t_code.$type_list->f_ucode : '';
			$num = '000';
			$code = $club_code.$date.$type_code;
			// 20190001551912FW01001
			$this_qcode = $this->find('left(qcode,18)="'.$code.'" order by qcode desc');
			if(!empty($this_qcode)){
				$num = $this_qcode->qcode;
			}
			$num1 = 1001+substr($num, -3);
			$this->qcode = $code.substr(''.$num1,1,3);
		}
		$this->process_id = Yii::app()->session['admin_id'];
        $this->process_nick = Yii::app()->session['gfnick'];
        return true;
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}