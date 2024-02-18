<?php 

class ClubStoreDemand extends BaseModel {

    public $time_list = '';
    public $clubStore_id = '';
    public $type_code_person = '';
    public $club_reply = '';
    public $club_detailed = '';
    public $club_update = '';
    public $club_order_code = '';
    public $club_reply_id = '';
    public $club_project = '';
    public $club_state = '';
    public $club_num = '';
    public $introduceUrl_temp = '';
    public function tableName() {
        return '{{club_service_data}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            // array('club_id', 'required', 'message' => '{attribute} 不能为空'),
            // array('title', 'required', 'message' => '{attribute} 不能为空'),
            // array('type_code', 'required', 'message' => '{attribute} 不能为空'),
            // array('level_code', 'required', 'message' => '{attribute} 不能为空'),
            // array('detail_gfaccount', 'required', 'message' => '{attribute} 不能为空'),
            // array('local_and_phone', 'required', 'message' => '{attribute} 不能为空'),
            // array('data_id', 'required', 'message' => '{attribute} 不能为空'),
            // array('imgUrl', 'required', 'message' => '{attribute} 不能为空'),
            // array('service_pic_img', 'required', 'message' => '{attribute} 不能为空'),
            // array('project_id', 'required', 'message' => '{attribute} 不能为空'),
            // array('site_contain', 'required', 'message' => '{attribute} 不能为空'),
            // array( => true),
            array('service_code,service_type,service_type_name,service_no,title,type_code,type_name,project_name,
                    project_id,data_id,data_name,level_code,imgUrl,service_pic_img,introduceUrl,introduceUrl_temp,
                    site_contain,local_and_phone,longitude,latitude,area,state,state_name,reasons_for_failure,
                    reasons_adminID,reasons_adminname,reasons_time,club_id,club_name,detail_gfid,deal,uDate,if_dispay,
                    if_del,check_way,about_club_num,about_state,about_state_name,detail_gfaccount,detail_gfname,
                    budget_amount,type_code_person,club_detailed,club_reply,club_update,club_order_code,club_reply_id,
                    club_project,club_state,club_order_num,time_list', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
            'club_service_detailed' => array(self::HAS_MANY, 'ClubServiceDetailed', array('service_code' => 'service_code'),'condition'=>'club_service_detailed.service_id>0'),
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
            'base_code' => array(self::BELONGS_TO, 'BaseCode', array('state' => 'f_id')),
            'base_code_if_del' => array(self::BELONGS_TO, 'BaseCode', 'if_del'),
            'mall_products_type_sname' => array(self::BELONGS_TO, 'MallProductsTypeSname', 'type_code'),
            'qualifications_person' => array(self::BELONGS_TO, 'QualificationsPerson', 'data_id'),
            'gf_site' => array(self::BELONGS_TO, 'GfSite', 'data_id'),
            'qmdd_administrators' => array(self::BELONGS_TO, 'QmddAdministrators', 'reasons_adminID'),
            'base_code_service_type' => array(self::BELONGS_TO, 'BaseCode', 'service_type'),
            'userlist' => array(self::BELONGS_TO, 'userlist', 'detail_gfid'),
            'club_service_reply' => array(self::HAS_MANY, 'ClubServiceReply', array('order_detail_code' => 'service_code')),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'service_code' => '服务编号',
            'service_type' => '服务类型',
            'service_type_name' => '服务类型名称',
            'service_no' => '服务序号',
            'title' => '服务标题',
            'type_code' => '服务类型',
            'type_name' => '服务类型名称',
            'project_name' => '项目名称',
            'project_id' => '服务项目',
            'data_id' => '服务人/场地',
            'data_name' => '服务主体(资源)名称',
            'level_code' => '服务等级',
            'imgUrl' => '缩略图',
            'service_pic_img' => '滚动图',
            'introduceUrl' => '简介',
            'introduceUrl_temp' => '简介',
            'site_contain' => '可接收人数',
            'local_and_phone' => '联系电话',
            'longitude' => '经度',
            'latitude' => '纬度',
            'area' => '服务区域',
            'state' => '审核状态',
            'state_name' => '审核状态说明',
            'reasons_for_failure' => '操作备注',
            'reasons_adminID' => '操作员',
            'reasons_adminname' => '操作员名称',
            'reasons_time' => '操作时间',
            'club_id' => '发布单位',
            'club_name' => '发布单位名称',
            'detail_gfid' => '约起会员',
            'detail_gfaccount' => '用户帐号',
            'detail_gfname' => '用户名称',
            'deal' => '成交量',
            'uDate' => '发布时间',
            'if_dispay' => '是否显示',
            'if_del' => '删除状态',
            'check_way' => '购买审核方式',
            'about_club_num' => '申请认领数量',
            'about_state' => '服务状态',  // 约起用户确认状态
            'about_state_name' => '服务状态名称',  // 约起用户确认状态说明
            'budget_amount' => '服务预算',
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
        if ($this->introduceUrl_temp != '') {

            // 判断是否存储过，没有存储过则保存新文件
            if ($this->introduceUrl != '') {
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

        $this->reasons_adminID = Yii::app()->session['admin_id'];
        $this->detail_gfname = Yii::app()->session['gfnick'];
        $this->reasons_time = date('Y-m-d H:i:s');

        // if (Yii::app()->session['club_id'] != 1) {
        //     unset($this->is_dispay);
        //     unset($this->state);
        // }
        return true;
    }
}