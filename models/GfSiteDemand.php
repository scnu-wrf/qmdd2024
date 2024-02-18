<?php

class GfSiteDemand extends BaseModel {
	public $cluSite_id = '';
	public $project_list = '';
	public $site_description_temp='';
	public $club_name = '';
	public $club_contacts='';
	public $club_contacts_phone = '';
	public $claim_time='';
	public $state = '';
	
    public function tableName() {
        return '{{gf_site}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
		//array('site_name', 'required', 'message' => '{attribute} 不能为空'),
        array('contact_phone', 'numerical', 'integerOnly' => true),
		//array('site_date_start', 'required', 'message' => '{attribute} 不能为空'),
		//array('site_date_end', 'required', 'message' => '{attribute} 不能为空'),
		//array('contact_phone', 'required', 'message' => '{attribute} 不能为空'),
		//array('site_address', 'required', 'message' => '{attribute} 不能为空'),
		//array('site_belong', 'required', 'message' => '{attribute} 不能为空'),
		//array('site_pic', 'required', 'message' => '{attribute} 不能为空'),
		//array('site_prove', 'required', 'message' => '{attribute} 不能为空'),
		array('site_name,site_pic,site_date_start,site_date_end,site_prove,site_envir,contact_phone,site_address,site_description,site_facilities,site_level,user_club_id,user_club_name,rent,site_state,reasons_for_failure,reasons_adminID,project_list,site_belong,site_description_temp', 'safe'),
		);
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'gf_site_project' => array(self::HAS_MANY, 'GfSiteProject', array('site_code' => 'site_code')),
			'club_list' => array(self::BELONGS_TO, 'ClubList', 'user_club_id'),
			'base_code_envir' => array(self::BELONGS_TO, 'BaseCode', 'site_envir'),
			'base_code_belong' => array(self::BELONGS_TO, 'BaseCode', 'site_belong'),
			'base_code_belong_name' => array(self::BELONGS_TO, 'BaseCode', 'belong_name'),
			'gf_site_project_list' => array(self::BELONGS_TO, 'GfSiteProject', 'project_list'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
			'id' => 'ID',
            'site_code' => '场地编码',
            'site_name' => '场地名称',
            'site_pic' => '缩略图',
			'site_date_start' => '使用期限开始时间',
            'site_date_end' => '使用期限结束时间',
            'site_prove' => '场地使用证明',
            'site_area' => '场地面积',
			'site_envir' => '场地环境',  // 关联base_code表AMBIENT类型ID，为668-室内 669-室外
            'contact_phone' => '场地电话',
            'site_address' => '场地地址',
            'site_longitude' => '场地经度',
            'site_latitude' => '场地纬度',
            'site_description' => '场地描述',
			'site_description_temp' => '场地描述',
			'site_facilities' => '场地设施',  // 关联auto_filter_set表sitefac类型的ID，多个使用逗号“，”隔开
            'site_level' => '场地等级',  // 关联base_code表SITE类型id
            'site_belong' => '场地所属单位',  // 关联base_code表MEMBERTYPE类型id:502-服务机构210-GF会员
            'belong_id' => '产权所属人/单位ID',  // site_belong为0时为club_id，为1时为gf_id
            'belong_name' => '产权所属人/单位名称',
			'user_club_id' => '场地使用单位',  // 关联club_list表id
			'user_club_name' => '使用单位名称',
            'rent' => '租金',
            'register_time' => '登记时间',
            'site_state' => '状态',
            'site_state_name' => '场地状态',
			'reasons_for_failure' => '操作备注',
            'reasons_time' => '审核时间',
            'reasons_adminID' => '审核管理员ID',  // 关联qmdd_administrators表ID,
            'reasons_adminname' => '操作管理员',
			'project_list'=>'可用项目',
			'if_del' => '逻辑删除'   // 关联base_code表DATA类型 509-逻辑删除 510正常',
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
        $basepath = BasePath::model()->getPath(171);
        if ($this->site_description_temp != '') {
            // 判断是否存储过，没有存储过则保存新文件
            if ($this->site_description != '') {
                set_html($this->site_description, $this->site_description_temp, $basepath);
            } else {
                $rs = set_html('', $this->site_description_temp, $basepath);
            }
			if (isset($rs['filename'])) {
                $this->site_description = $rs['filename'];
            }
        } else {
            $this->site_description = '';
        }
        if ($this->isNewRecord) {
            
            // 生成视频编号
            $site_code = '';
            $site_code.=date('Ym');
            $this->site_code = $site_code.rand(100,999);
        }
        return true;
    }

}
