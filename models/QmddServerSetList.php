<?php

class QmddServerSetList extends BaseModel {

    public function tableName() {
        return '{{qmdd_server_set_list}}';
    }
 
    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
			'info' => array(self::BELONGS_TO, 'QmddServerSetInfo', 'info_id'),
            'sourcer' => array(self::BELONGS_TO, 'QmddServerSourcer', 'server_sourcer_id'),
			's_type' => array(self::BELONGS_TO, 'QmddServerType', 't_typeid'),
			's_usertype' => array(self::BELONGS_TO, 'QmddServerUsertype', 't_stypeid'),
            'sitetype' => array(self::BELONGS_TO, 'BaseCode', 'site_type'),
            'site' => array(self::BELONGS_TO, 'GfSite', 'site_id'),
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
         'info_id' =>'上架方案id',
         'server_sourcer_id' => '资源id',
         'club_id' => '社区名称',
		 'star_time' => '上线时间',
		 'end_time' => '下线时间',
		 'down_time' => '下架时间',
          'club_name' => '社区名称',
          'server_start' => '服务开始日期',
          'server_end' => '服务结束日期',
          's_code' => '资源编码',//，多个资源时，逗号隔开
          's_name' => '服务名称',//，多个资源时，逗号隔开
          's_value' => '取值说明',//，是队名字说明一部分
          's_gfid' => '服务者',//,来源于club_member_list的member_gfid
          's_gfname' => '服务者',//，来源club_member_list的zsxm
          's_levelid' => '资源等级',
          's_levelname' => '资源等级',
          't_typeid'  => '子分类',
          't_stypeid' => '子分类',
          't_eday' => '每日单位',
          't_count' => '每天数量',//每个服务
          't_timeset' => '时间段数',//每天
          't_daymore' => '跨天操作',//，一般用于酒店的，酒店是
          'if_user' => '是否使用',//，关联base_code表yes_no类型id 648=否，649是
          'if_user_name' => '是否使用',// 0 否  1是
          'if_del' => '是否删除',//0 否 1 是  ，关联base_code表DATA类型 509-逻辑删除 510正常
          'add_time' => '添加时间',
          'f_check' => '审核状态',//，关联base_code表DATA类型 509-逻辑删除 510正常
          'f_checkname' =>'审核状态',//2审核通过 373审核未通过 374撤销 721编辑中'',',
          'sale_price' => '销售价',
          'sale_bean' => '销售豆',
          'Inventory_quantity' => '上架数量',//,下架单的时候表示下架数量'
          'available_quantity' => '销售数量',
          'return_quantity' => '退货数量',//，表销售时间在本方案的时间内产生的换货商品数量合计数'',
          'total' => '销售总数',//
          'project_ids' => '项目id集合，用","分开',
          'site_type' => '场地类型',// 1518=单场，1519=半场，1520=全场
          'site_id' => '归属场馆',//，关联gf_site表的id
          
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
