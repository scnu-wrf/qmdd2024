<?php

class GfHealthyList extends BaseModel {

    public $attr_name = '';
    public $attr_values = '';
    public $gf_healthy_model = '';
    public $attr_unit = '';
    public $attr_input_type = '';

    public function tableName() {
        return '{{gf_healthy_list}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            // array('gf_name', 'required', 'message' => '{attribute} 不能为空'),
            array('health_date', 'required', 'message' => '{attribute} 不能为空'),
            // array('health_state', 'required', 'message' => '{attribute} 不能为空'),
            array('gf_account', 'required', 'message' => '{attribute} 不能为空'),
            array('code,gf_id,gf_account,gf_name,health_date,health_state,health_pic,club_id,club_name,add_time,attr_name,attr_values,attr_unit,attr_input_type','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'health_state'),
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
            'userlist' => array(self::BELONGS_TO, 'userlist', 'gf_id'),
            'values' => array(self::HAS_ONE, 'GfHealthyValues','h_id'),
            // 'gfmodel' => array(self::HAS_ONE, 'GfHealthyModel',''),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' =>'ID',
            'code' =>'编号',//编码HV+6位数序号,
            'gf_id' => '用户',//关联userlist表id
            'gf_account' => '用户帐号',//类型，关联base_code表INDIVIDUAL类型， id:403个人，404单位',
            'gf_name' => '姓名',
            'health_date' => '体检日期', 
            'health_state' => '是否健康',
            'health_pic' => '体检扫描件',
            'club_id' => '录入单位',
            'club_name' => '单位名称',
            'add_time' => '录入时间',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    // protected function beforeSave() {
    //     parent::beforeSave();
    //     if ($this->isNewRecord) {
    //         if (empty($this->code)) {
    //             // 生成编号
    //             $code = 'HV'.rand(100000, 999999);
    //             $count = $this->count();
    //             $code = substr(strval($count + 1), -6);
    //             $code .= $code;
    //             $this->code =$code;
    //         }
    //         $this->add_time = date('Y-m-d H:i:s');
    //     }
    //     return true;
    // }

    protected function beforeSave() {
        parent::beforeSave();
        if($this->isNewRecord) {
            if(empty($this->code)) {
                // 生成编号
                $code = 'HV';
                $count = $this->count();
                $code .= substr('000000'.strval($count + 1), -6);
                $code = $code;
                $this->code = $code;
            }
        }
        return true;
    }
}
