<?php

class QmddServiceGame extends BaseModel {
    public function tableName() {
        return '{{qmdd_service_game}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
                array('service_code,service_type,title,type_code,type_name,project_id,project_name,level_code,imgUrl,service_pic_img,introduceUrl,site_contain,local_and_phone,area,check_way,about_state,state,reasons_for_failure,reasons_time,club_id,detail_gfid,detail_gfaccount,detail_gfname,budget_amount,deal,uDate,if_dispay,if_del,servic_person_ids,servic_site_ids,area_country,area_province,area_city,area_district,area_township,area_street,game_item,longitude,latitude,server_name,site_id', 'safe'),
        );
    }
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'service_code' => '资源编码',//'社区单位编码的后6位数+年份+4位序号',
            'service_no' => '服务序号',//'服务序号，如1，2',
            'service_type' => '服务类型',//'服务类型，关联base_code表ABOUT类型ID,520-用户约起 521-单位服务',
            'service_type_name' => '服务类型名称',//'服务类型名称，关联base_code表ABOUT类型ID,520-用户约起 521-单位服务',
            'title' => '资源名称',
			'server_name' => '服务名称',
            'type_code' => '服务类型编码',//'服务类型编码，关连mall_products_type_sname表tn_code字段为D06分类的ID',
            'type_name' => '服务类型名称',
            'project_id' => '服务项目',
            'project_name' => '项目名称',
            'data_id' => '服务主体ID',// ，根据type=197-179为服务者id关联qualifications_person表,174场地id关联gf_site表',
            'data_name' => '服务主体(资源)名称',
            'level_code' => '等级编码',//约起时使用，单位发起需求关联表使用，service_type=521时，服务者根据data_id取qualifications_person表等，data_id=174场地取gf_site表site_leve值，需求发起为长期服务类型会随着当月的服务质量等变化升降级；type为520约起时type_code为D02-D06为服务者金银铜等级和D07赛事服务单位0-9星级关auto_filter_set表ID为     值，type=D01为 0-5星关联auto_filter_set表ID为57-62值',
            'imgUrl' => '缩略图',//'缩列图片地址',
            'service_pic_img' => '详情图',//'滚动图片，多图片用“，”分开',
            'introduceUrl' => '简介链接URL',//'简介链接URL,文件命名规则为service_code.html,存放路径相关表为base_path表',
            'site_contain' => '服务数量',//'服务数量，type_code为1服务者是为被服务人数，2场馆时为场地容纳人数，3赛事服务时为参赛人数',
            'local_and_phone' => '联系电话',
            'longitude' => '经度',
            'latitude' => '纬度',
            'area' => '场地地址',
            'check_way' => '购买审核方式，关联base_code表CHECK类型 792人工审核 793自动审核',
            'about_club_num' => '约起申请商家数量',
            'about_state' => '约起用户确认状态，关联base_code类型STATE类型，id为：  371审核中 2通过 373不通过 374撤销',
            'about_state_name' => '约起用户确认状态说明',
            'state' => '审核状态：关联base_code类型STATE类型，id为：  371审核中 2通过 373不通过 374撤销 721编辑中',
            'state_name' => '审核状态',
            'reasons_for_failure' => '未通过原因',
            'reasons_adminID' => '操作员id,关联qmdd_administrators表ID',
            'reasons_adminname' => '操作员名称',
            'reasons_time' => '操作时间',
            'club_id' => '发布单位',
            'club_name' => '发布单位',
            'detail_gfid' => '发布用户户ID,根据service_type=520-用户约起时为发起服务需求者GFID关联userlist表，service_type=521-单位服务管理员ID关联qmdd_administrators表id',
            'detail_gfaccount' => '用户GF帐号',
            'detail_gfname' => '用户名称',
            'budget_amount' => '服务预算金额',
            'deal' => '成交量',
            'uDate' => '登记时间',
            'if_dispay' => '是否显示：关联base_code表yes_no类型id 648=否，649是',
            'if_del' => '是否删除/取消联盟关系,关联base_code表DATA类型 509-逻辑删除 510正常',
            'servic_person_ids' => '服务者信息ID,用逗号分开，来源社区服务者qualification_club的ID',
            'servic_site_ids' => '赛事服务场地信息ID集合，来源qmdd_gf_site的ID',
            'servic_project_ids' => '课举办的赛事项目信息ID，来源于club_project的 ID',
			'game_item' => '赛事模式',
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
        $num = date('Ymd');
        $num1= '000000';
        $s_code = $this->find("left(service_code,8)='".$num."' order by service_code DESC");
        if(!empty($s_code)){
            $num1=$s_code->service_code;
        }

        if ($this->isNewRecord) {
            $this->service_code=$num.substr(''.(1000001+substr($num1, -6)),1,6);
            $this->uDate=date('Y-m-d H:i:s');
        }
		$this->reasons_adminID = Yii::app()->session['admin_id'];
        $this->reasons_adminname = Yii::app()->session['gfnick'];
        $this->reasons_time = date('Y-m-d h:i:s');
        return true;
    }

}
