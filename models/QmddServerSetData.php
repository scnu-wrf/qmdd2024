<?php

class QmddServerSetData extends BaseModel {

    public function tableName() {
        return '{{qmdd_server_set_data}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('id,info_id,server_code,server_set_type,server_set_typename,list_id,s_code,s_name,s_date,s_gfid,
                s_gfname,club_id,club_name,star_time,end_time,down_time,s_timename,s_timestar,s_timeend,order_project_id,
                order_project_name,down,site_id,area_location,site_type', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_server_set_type' => array(self::BELONGS_TO, 'BaseCode', 'server_set_type'),
            'server_order_num' => array(self::BELONGS_TO, 'GfServiceData', array('order_num'=>'order_num')),
            'base_site_type' => array(self::BELONGS_TO, 'BaseCode', 'site_type'),
            'server_sourcer_list' => array(self::BELONGS_TO, 'QmddServerSourcer', 'server_sourcer_id'),
            'server_set_list' => array(self::BELONGS_TO, 'QmddServerSourcer', 'list_id'),
            'gf_order_gfid' => array(self::BELONGS_TO, 'userlist', 'order_gfid'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID', 
            'info_id' => '上架单ID',//qmdd_server_set_//info 的ID
            'server_code' => '发布编码',//(INFO_set_code+四位序号)，
            'server_set_type' => '服务类型',//
            'server_set_typename' => '服务类型',//(INFO_set_code+四位序号)，
            'list_id' => 'set_list',//qmdd_server_set_list 的ID
            'server_sourcer_id' => '发部资源ID',
            'server_order' => '序号',
            'club_id' => '社区',//id，来源CLUB_LIST
            'club_name' => '社区名称',//，来源CLUB_LIST
            'star_time' => '开始日期',
            'end_time' => '结束日期',
            'down_time' => '下架时间',
            's_code' => '服务类型',
            's_name' => '服务名称',
            's_timename' => '时间段名称',
            's_timestar' => '服务开始时间',
            's_timeend' => '服务结束时间',
            's_date' => '服务日期',
            's_gfid' => '服务者ID',  // 来源于club_member_list的member_gfid',
            's_gfname' => '服务资源',  // 服务者姓名 来源club_member_list的zsxm',
            't_typeid' => '服务类型ID',  // 大类ID（服务者，一级分类)',
            't_typename' => '服务类型ID',  // 大类ID（服务者，一级分类)',
            't_stypeid' => '服务子类ID',  // 如服务者的教练（二级分类）',
            't_stypename' => '服务类型ID',  // 大类ID（服务者，一级分类)',
            't_eday' => '每日一个单位',
            't_count' => '每个服务每天包括数量',
            't_timeset' => '每天时间段数',
            't_daymore' => '是否跨天',//操作，一般用于酒店的，酒店是
            'if_user' => ' 是否使用',//0 1
            'if_user_name' => '是否使用说明',
            'if_del' => '是否删除',  // 关联base_code表DATA类型 509-逻辑删除 510正常',
            'add_time' => '添加时间',
            'f_check' => '审核状态',  // 关联base_code表ID371审核中 2审核通过 373审核未通过 374撤销 721编辑中',
            'f_checkname' => '审核状态',  // 关联base_code表ID371审核中 2审核通过 373审核未通过 374撤销 721编辑中',
            'sale_price' => '销售价',
            'sale_bean' => '销售豆',
            'Inventory_quantity' => '上架数量',  // 下架单的时候表示下架数量',
            'available_quantity' => '销售数量',
            'return_quantity' => '退货数量',  // 表销售时间在本方案的时间内产生的换货商品数量合计数',
            'total' => '销售总数量',
            'project_ids' => '项目id集合，用","分开',
            'order_project_id' => '服务项目',  // 预定的项目
            'order_project_name' => '预定的项目名称',
            'order_gfid' => '预定的人 ID',
            'order_account' => '预定的的账号',
            'order_name' => '预定的姓名',
            'order_date' => '预定的日期',
            'level_id' => '等级ID',
            'down' => '关闭服务',  // 0否，1是
            'order_num' => '服务流水号',  // 表gf_service_data的order_num
            'site_type' => '场地类型',  // 1518=单场，1519=半场，1520=全场

            // 自定义字段
            'server_feferee' => '服务裁判',
            'server_site' => '服务场地',
            'site_name' => '场地名称',
            'about_type' => '约赛方式',
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
			$this->add_time = date('Y-m-d H:i:s');
        }
        return true;
    }

}
