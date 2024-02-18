<?php

class AndroidPhone extends BaseModel {

	/*public $qualifications_person = '';
    public $qualification_club = '';*/

    public function tableName() {
        return '{{android_phone}}';
    }
	
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

	public function rules() {

        return array(
            //version_code
            array('name', 'required', 'message' => '{attribute} 不能为空'),
            array('ptype', 'required', 'message' => '{attribute} 不能为空'),
            array('url', 'required', 'message' => '{attribute} 不能为空'),
            array('version', 'required', 'message' => '{attribute} 不能为空'),
            array('version_content', 'required', 'message' => '{attribute} 不能为空'),
            array('app_id,app_name,version_code,version,name,ptype,url,version_content,if_state_dispay,if_state_dispay_name,dispay_time,v_qmddid,v_qmddname,v_time,state,state_name,reasons_for_failure','safe'),

        );
    }


    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'app_id'=>'应用ID',            
            'dispay_time'=>'更新时间',
            'name'=>'软件安装包',
            'state_name'=>'状态',
            'app_name'=>'应用名称',
            'version_code'=>'版本号',
            'version'=>'版本名称',
            'ptype'=>'支持安装类型',
            'url'=>'安装包地址',
            'version_content'=>'更新内容',
            'if_state_dispay'=>'是否审核通过立即显示更新',
            'if_state_dispay_name'=>'',
            'v_qmddid'=>'发布人id',
            'v_qmddname'=>'发布人名称',
            'v_time'=>'申请时间',
            'state_name'=>'审核状态名称',
            'reasons_for_failure'=>'操作原因',
            's_qmddid'=>'审核人ID',
            's_qmddname'=>'审核人名称',
            's_time'=>'审核时间',

        );
    }

	protected function beforeSave() {
        parent::beforeSave();
        return true;
	}	
	
}
