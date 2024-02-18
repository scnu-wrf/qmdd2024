<?php

class QmddServerUsertype extends BaseModel {
    public function tableName() {
        return '{{qmdd_server_usertype}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
                array('f_ucode','required','message'=>'{attribute} 不能为空'),
                // array('f_uname','required','message'=>'{attribute} 不能为空'),
                array('f_member_type','required','message'=>'{attribute} 不能为空'),
                array('t_server_type_id','required','message'=>'{attribute} 不能为空'),
                array('project_ids','required','message'=>'{attribute} 不能为空'),
                array('id,f_ucode,f_uname,f_member_type,t_server_type_id,t_code,t_name,project_ids,if_send,if_user_name,if_del,add_time,
                    tn_icon,tn_click_icon,tn_web_icon,tn_web_click_icon,queue_number,display,service_type', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_code_if_send' => array(self::BELONGS_TO, 'BaseCode', 'if_send'),
            'base_code_if_del' => array(self::BELONGS_TO, 'BaseCode', 'if_del'),
            'member_type' => array(self::BELONGS_TO, 'MemberCard', 'f_member_type'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id'=>'id',
            'f_ucode' => '服务类别编码',
            'f_uname' => '服务类别',
            'f_member_type' => '服务类型',//服务类型MEMBER类型，参见member_card''mamber_type,
            't_server_type_id' => '服务类型',
            't_code' => '服务类型编码',
            't_name' => '服务类型',
            'project_ids' => '项目集合',
            'if_send' => '是否使用',//是否可以发布小时,是否使用，关联base_code表yes_no类型id 648=否，649是,
            'if_user_name' => '是否使用说明',
            'if_del'  => '是否删除',//是否删除，关联base_code表DATA类型 509-逻辑删除 510正常',
            'add_time' => '添加时间',
            'tn_icon' => '默认手机图片',//'手机图片文件名称，存在路径查看base_parh表ID 150',
            'tn_click_icon'  => '选中手机图片',//'手机选中图片文件名称，存在路径查看base_parh表ID 150',
            'tn_web_icon'  => '默认网页图片',//'手机图片文件名称，存在路径查看base_parh表ID 150',
            'tn_web_click_icon'  => '选中网页图片',//'网页选中图片文件名称，存在路径查看base_parh表ID 150',
            'queue_number' => '排序',//显示排序号，*排序号值越大越往前排',
            'display' => '是否展示前端',//'是否作为服务资源类型在前端展示，关联base_code表yes_no类型id 648=否，649是',
            'service_type' => '服务者类型', // 关联club_type表id
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
        if($this->isNewRecord){
            $this->add_time = date('Y-m-d H:i:s');
        }
        return true;
    }

 
	public function getServerusertype() {
		return $this->findAll('if_del=510');
    }
	public function getType($type_id) {
		return $this->findAll('t_server_type_id='.$type_id);
    }
	public function getServerusertype_all() {
        $cooperation= $this->getServerusertype();
         $arr = array();$r=0;
        foreach ($cooperation as $v) {
                $arr[$r]['id'] = $v->id;
                $arr[$r]['f_uname'] = $v->f_uname;
                $arr[$r]['t_typeid'] = $v->t_server_type_id;
				$arr[$r]['f_member_type'] = $v->f_member_type;
                $r=$r+1;
        }
        return $arr;
    }
}
