<?php

class ClubServicerType extends BaseModel {


    public $location ='';
    public function tableName() {
        return '{{club_servicer_type}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('type,member_type_id, member_second_id, code, entry_way, if_project, certificate_type, renew_time,renew_notice_time, is_rely_on_partner,is_rely_on_partner_by_project, rely_on_partner_number, is_rely_on_community, is_rely_on_community_by_project, rely_on_community_number,is_club_qualification,is_join_member,is_project_member,member_num,get_type,is_show,if_del', 'safe'),
        );
    }
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'baseCode' => array(self::BELONGS_TO,'BaseCode','is_show'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        if($_REQUEST['r']=='clubServicerType/create_sqdw'||$_REQUEST['r']=='clubServicerType/update_sqdw'||$_REQUEST['r']=='clubServicerType/index_sqdw'){
            $is_join_member = '是否可注册学员';
            $member_num = '学员注册方式';
        }elseif($_REQUEST['r']=='clubServicerType/create_zlhb'||$_REQUEST['r']=='clubServicerType/update_zlhb'||$_REQUEST['r']=='clubServicerType/index_zlhb'){
            $is_join_member = '是否可注册成员';
            $member_num = '可注册成员员数量';
        }else{
            $is_join_member = '';
            $member_num = '';
        }

        return array(
            'f_id' => '自增编号',
            'member_type_id' => '会员类型',
            'member_type_code' => '会员类型(一级)',
            'member_type_name' => '会员类型(一级)',
            'member_second_id' => '会员类型(二级)',
            'member_second_code' => '会员类型(二级)',
            'member_second_name' => '会员类型(二级)',
            'code' => '服务者代码',
            'short_name' => '短名',
            'entry_way' => '入驻方式',
            'if_project' => '是否按项目入驻',
            'renew_time' => '有效期（天）',
            'renew_notice_time' => '到期前通知天数',
            'certificate_type' => '资质要求',

            'is_rely_on_partner' => '是否可挂靠',
            'is_rely_on_partner_by_project' => '是否按项目挂靠',
            'rely_on_partner_number' => '可挂靠战略伙伴数量',

            'is_rely_on_community' => '是否可挂靠',
            'is_rely_on_community_by_project' => '是否按项目挂靠',
            'rely_on_community_number' => '可挂靠社区单位数量',
            'is_club_qualification' => '设置资质人',
            'is_join_member' => $is_join_member,
            'is_project_member' => '是否按项目注册',
            'member_num' => $member_num,
            'get_type' => '积分来源',
            'is_show' => '是否显示前端'
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

        }
        return true;
    }
	
	public function getTypeData($param){
		$member_type_id=empty($param['member_type_id'])?'':$param['member_type_id'];
		$cr = new CDbCriteria;
		$cr->condition='is_show=649 and member_type_id in('.$member_type_id.')';
		$cr->select='member_second_id as id,member_second_name as name';
		return $this->findAll($cr,array(),false);
	}

}
