<?php

class QmddServerSourcer extends BaseModel {
	public $s_address='';
    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function tableName() {
        return '{{qmdd_server_sourcer}}';//社区动动约资源名称设置';
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
           'site' => array(self::BELONGS_TO, 'GfSite', 'site_id'),
		   's_usertype' => array(self::BELONGS_TO, 'QmddServerUsertype', 't_stypeid'),
		   's_type' => array(self::BELONGS_TO, 'QmddServerType', 't_typeid'),
           'qmddperson' => array(self::BELONGS_TO, 'QmddServerPerson', 's_name_id'),
           'sitetype' => array(self::BELONGS_TO, 'BaseCode', 'site_type'),
        );
    }

    /*** 模型验证规则*/
    public function rules() {
      return $this->attributeRule();
    }
    //关联数据自动处理
    public function getrelations() {
      $s1='club_list,club_id:id,club_name';     
     // $s1.='goodsreport,f_rid:id,f_timeid:timeid&f_timetype:timetype';
      return $s1;
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }
   
    public function attributeSets() {
        return array(
        'id' =>'ID',
        'club_id'=>'发布单位',
        'club_name'=>'单位名称',
        's_code'=>'资源编号',
        's_name'=>'资源名称',
        'server_name'=>'服务名称',
        's_value' => '取值说明',//??
        's_gfid'=>'服务者',
        's_gfname'=>'服务者姓名',
        's_levelid'=>'等级',
        's_levelname'=>'等级',
        's_level_logo' =>'等级logo',
        's_name_id' => '资源所在表ID',//根据t_typeid获取' 
        't_typeid'=>'服务类型',
        't_stypeid'=>'服务子类',
        't_eday' ==> '每日一个单位',
        't_count' => '每天数量',
        't_timeset' => '时间段数',
        't_daymore' => '跨天操作',//，一般用于酒店的，酒店是
        'if_user' => ' 是否使用',//，0 否  1是',
        'if_user_name' => '是否使用',
        'if_del' => '是否删除',//，0 否  1是',
        'add_time' => '添加时间',
        'area_country' => '地区',//
        'area_province' => '省代码',//社区单位地区：
        'area_city' => '市代码',
        'area_district' => '区县',
        'area_township' => '镇',
        'area_street' => '街道',
        'latitude' => '纬度',
        'Longitude' => '经度',
        'logo_pic' => '缩略图',
        's_picture' => '资源详情图',
        'description' => '资源描述',
        'project_ids' =>'项目id',//集合，用","分开
        'json_data' => '其他描述',//的数据，用JSON数组表示
        'contact_number' => '联系电话',
        'state' => '审核状态',
        'state_name' => '审核状态',
        'reasons_adminID' => '操作员',//id,
        'reasons_adminname' => '操作员',
        'reasons_time' => '操作时间',
        'reasons_for_failure' => '未通过原因',
        'deal_total' => '销量',
        'server_name' => '服务名称',
        'achi_h_ratio' =>'好评率',
        'achi_mark' => '服务评价',//平均分，1-5分
        'area' => '场馆',
        'area_location' => '定位地址',
        'site_id' => '归属场馆',//，关联gf_site表的id
        'site_name' => '场馆名',
        'site_parent' => '关联场地',//，关联qmdd_gf_site表id，逗号隔开
        'site_type' => '场地类型',// 1=单场，2=半场，0=全场
        'site_typename' => '场地类型名',
        'is_online' => '是否上线',//  0  下线  1 上线
        'online_start' => '上线时间',
        'online_end' => '下线时间',

        );
    }

	protected function beforeSave() {
        parent::beforeSave();
        if ($this->isNewRecord) {
			$this->add_time = date('Y-m-d h:i:s');
        }
        return true;
    }

}
