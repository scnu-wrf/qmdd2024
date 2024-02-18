<?php

class ClubServiceData extends BaseModel {

    public $type_code_person = '';
    public $introduceUrl_temp = '';

    public function tableName() {
        return '{{club_service_data}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            //array('club_id', 'required', 'message' => '{attribute} 不能为空'),
            array('title', 'required', 'message' => '{attribute} 不能为空'),
            //array('type_code', 'required', 'message' => '{attribute} 不能为空'),
            //array('data_id', 'required', 'message' => '{attribute} 不能为空'),
            //array('imgUrl', 'required', 'message' => '{attribute} 不能为空'),
            //array('service_pic_img', 'required', 'message' => '{attribute} 不能为空'),
            array('project_id', 'required', 'message' => '{attribute} 不能为空'),
            array('site_contain', 'required', 'message' => '{attribute} 不能为空'),
            array('club_id,service_type,service_no,site_contain,state,if_dispay,if_del', 'numerical', 'integerOnly' => true),
            array('imgUrl,service_pic_img,type_code,data_id,introduceUrl,local_and_phone,longitude,latitude,area,reasons_for_failure,introduceUrl_temp,type_code_person', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
            'club_service_detailed' => array(self::HAS_MANY, 'ClubServiceDetailed', array('service_id' => 'id')),
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
            'base_code' => array(self::BELONGS_TO, 'BaseCode', array('state' => 'f_id')),
            'mall_products_type_sname' => array(self::BELONGS_TO, 'MallProductsTypeSname', 'type_code'),
			
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'service_no' => '服务序号',
            'service_code' => '服务编号',
            'service_type' => '服务类型',
            'service_type_name' => '服务类型名称',  // 关联base_code表ABOUT类型ID,520-用户约起 521-单位服务
            'title' => '服务标题',
            'type_code' => '服务类型',  // 关连mall_products_type_sname表tn_code字段为D06分类的ID
            'type_name' => '服务类型名称',
            'project_id' => '服务项目',
            'project_name' => '项目名称',
            'data_id' => '服务人/场地',  // 根据type=197-179为服务者id关联qualifications_person表,174场地id关联gf_site表
            'data_name' => '服务主体(资源)名称',
            'level_code' => '等级编码',
            'imgUrl' => '缩略图',
            'service_pic_img' => '滚动图',
            'introduceUrl' => '简介',
            'introduceUrl_temp' => '简介',
            'site_contain' => '可接收人数',
            'local_and_phone' => '联系电话',
            'longitude' => '经度',
            'latitude' => '纬度',
            'area' => '服务地区',
            'check_way' => '购买审核方式',  // 关联base_code表CHECK类型 792人工审核 793自动审核
            'about_club_num' => '约起申请商家数量',
            'about_state' => '约起用户确认状态',  // 关联base_code类型STATE类型，id为：  371审核中 2通过 373不通过 374撤销
            'about_state_name' => '约起用户确认状态说明',
            'state' => '审核状态',
            'state_name' => '审核状态说明',
            'reasons_for_failure' => '审核意见',
            'reasons_adminID' => '管理员',
            'reasons_adminname' => '管理员名称',
            'reasons_time' => '操作时间',
            'club_id' => '发布单位',
            'club_name' => '发布单位名称',
            'detail_gfid' => 'ID',  // 根据service_type=520-用户约起时为发起服务需求者GFID关联userlist表，service_type=521-单位服务管理员ID关联qmdd_administrators表id
            'detail_gfaccount' => '用户帐号',
            'detail_gfname' => '用户名称',
            'budget_amount' => '服务预算金额',
            'deal' => '成交量',
            'uDate' => '发布时间',
            'if_dispay' => '是否显示',
            'if_del' => '销售状态',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function afterFind() {
        parent::afterFind();
        if ($this->introduceUrl != '') {
            $basepath = BasePath::model()->getPath(136);
            $this->introduceUrl_temp = get_html($basepath->F_WWWPATH . $this->introduceUrl, $basepath);
        }
        return true;
    }

    protected function beforeSave() {
        parent::beforeSave();
        // 图文描述处理
        $basepath = BasePath::model()->getPath(136);
        if (!empty($this->introduceUrl_temp)) {
            // 判断是否存储过，没有存储过则保存新文件
            if (!empty($this->introduceUrl)) {
                set_html($this->introduceUrl, $this->introduceUrl_temp, $basepath);
            } else {
                $rs = set_html('', $this->introduceUrl_temp, $basepath);
            }
			if (isset($rs['filename'])) {
                $this->introduceUrl = $rs['filename'];
            }
        } else {
            $this->introduceUrl = '';
        }

        if ($this->isNewRecord) {
            $this->uDate = date('Y-m-d H:i:s');
            $this->if_del = 510;
            if (empty($this->service_code)) {
                // 生成服务编号
                $service_code = '';
                $club = ClubList::model()->findByPk($this->club_id);
                $service_code.=substr($club->club_code, -6);
                $service_code.=date('Y');
                $service_code_start = $service_code . '0000';
                $count = $this->count('club_id=' . $this->club_id . ' AND service_code>' . $service_code_start);
                $code = substr('0000' . strval($count + 1), -4);
                $service_code.=$code;
                $this->service_code = $service_code;
            }
        }
        $this->reasons_adminID = Yii::app()->session['admin_id'];
        $this->detail_gfname = Yii::app()->session['gfnick'];
        $this->reasons_time = date('Y-m-d H:i:s');
        return true;
    }

}
