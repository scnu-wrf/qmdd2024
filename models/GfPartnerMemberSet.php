<?php

class GfPartnerMemberSet extends BaseModel {

    public $program_list = '';
    public $attr_values_lsit = '';
    public $rules_description_temp = '';

    public $attr_data = '';
    public $remove_attribute = '';
    public $remove_inputset = '';
    public function tableName() {
        return '{{gf_partner_member_set}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('code', 'required', 'message' => '{attribute} 不能为空'),
            array('title', 'required', 'message' => '{attribute} 不能为空'),
            array('type', 'required', 'message' => '{attribute} 不能为空'),
            array('project_id', 'required', 'message' => '{attribute} 不能为空'),
            // array('if_certificate', 'required', 'message' => '{attribute} 不能为空'), 
            array('rules', 'required', 'message' => '{attribute} 不能为空'),
            array('club_id', 'required', 'message' => '{attribute} 不能为空'), 
            //array('rules_description_temp', 'required', 'message' => '{attribute} 不能为空'),
            array('intro_project,live_source_RTMP_N, live_source_FLV_H, live_source_FLV_N, reasons_for_failure, if_no_chinese, club_name, live_address, longitude, latitude,rules_description,rules_description_temp,if_pay_item', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'units' => array(self::BELONGS_TO, 'BaseCode', 'type'),
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'if_certificate'),
            'rule' => array(self::BELONGS_TO, 'BaseCode', 'rules'),
			'gf_partner_member_inputset' => array(self::HAS_MANY, 'GfPartnerMemberInputset', array('set_id' => 'id')),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' =>'类别编码',
            'code' => '模板编号',
            'title' => '模板名称',
            'type' => '类型',
            'type_name' => '类型名称',
            'club_id' => '入会单位',
            'club_name' => '发布单位',
            'project_id' => '项目名称',
            'project_name' => '项目名称',
            'if_pay_item' => '是否存在收费项目',
            'if_certificate' => '是否含纸证书',
            'rules' => '是否显示协议',
            'rules_description' => '协议内容',
            'attr_values_lsit' => '可选属性值',
            'rules_description_temp' => '协议内容'
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
        // 图文描述处理
        $basepath = BasePath::model()->getPath(148);
        if($this->rules_description_temp != ''){
            // 判断是否存储过，没有存储过则保存新文件
            if($this->rules_description != ''){
                set_html($this->rules_description, $this->rules_description_temp, $basepath);
            }
            else{
                $rs = set_html('', $this->rules_description_temp, $basepath);
                $this->rules_description = $rs['filename'];
            }
        }
        else{
            $this->rules_description = '';
        }
        return true;
    }

    public function getCode($id) {
        return $this->findAll('id=' . $id);
    }

}
