<?php

class ClubChangeList extends BaseModel {
    
    public $description_temp="";
    public $show=0;
    public function tableName() {
        return '{{club_change_list}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        $s2='service_type,service_id,code,title,logo,pic,club_id,club_code,club_name,description,type_id,type_name,type2_id,type2_name,if_live,dispay_start_time,dispay_end_time,buy_start,buy_end,start_time,end_time,apply_way,address,GPS,men,phone,organizational,longitude,latitude,change_adminid,change_adminname,change_time,state,project_id,grade,money';
        if($this->show==0){
            $a = array(
                array($s2,'safe'),
            );
        } else{
            $a = array(
                array($s2,'safe'),
            );
        }
        return $a;
    }

    public function check_save($show) {
        $this->show=$show;
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
			'online' => array(self::BELONGS_TO, 'BaseCode', 'if_live'),
			'way' => array(self::BELONGS_TO, 'BaseCode', 'apply_way'),
			'admin' => array(self::BELONGS_TO, 'QmddAdministrators', 'change_adminid'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => '编号',
            'title' => '标题',
            'logo' => '缩列图',
            'pic' => '滚动图',
            'club_id' => '发布单位',
            'club_code' => '发布服务的单位账号',
            'club_name' => '发布服务的单位名称',
            'description' => '介绍',
            'type_id' => '培训类型',
            'type_name' => '培训类型说明',
            'type2_id' => '培训类别',
            'type2_name' => '培训类别说明',
            'if_live' => '显示前端',
            'dispay_start_time' => '信息显示开始时间',
            'dispay_end_time' => '信息显示结束时间',
            'buy_start' => '培训报名开始时间',
            'buy_end' => '培训报名结束时间',
            'start_time' => '培训开始时间',
            'end_time' => '培训结束时间',
            'apply_way' => '是否开通报名',
            'address' => '培训地点',
            'GPS' => '导航定位',
            'men' => '联系人',
            'phone' => '联系电话',
            'organizational' => '组织单位',
            'longitude' => '经度',
            'latitude' => '纬度',
            'change_adminid' => '操作人员',
            'change_adminname' => '更改信息操作员',
            'change_time' => '信息更改时间',
            'project_id' => '项目',
            'project_name' => '项目',
            'grade' => '课程难度',
            'grade_name' => '课程难度',
            'money' => '费用（元）',
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
        return true;
    }
    
    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }

    
    public function save_set($model){
        if($this->train_state==2){
            $this->update_MallPriceSet($this); //*定价方案开始*/
            $this->update_MallPriceSetDetails($this);
        }
    }
    
	public function getAge($birthday) {
        //格式化出生时间年月日
        $byear=date('Y',$birthday);
        $bmonth=date('m',$birthday);
        $bday=date('d',$birthday);

        //格式化当前时间年月日
        $tyear=date('Y');
        $tmonth=date('m');
        $tday=date('d');

        //开始计算年龄
        $age=$tyear-$byear;
        if($bmonth>$tmonth || $bmonth==$tmonth && $bday>$tday){
            $age--;
        }
        return $age;
    }
}
