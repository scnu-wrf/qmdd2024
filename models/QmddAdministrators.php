<?php

class QmddAdministrators extends BaseModel {
//得闲体育后台管理员帐号表
    public function tableName() {
        return '{{qmdd_administrators}}';
    }
  public static function model($className = __CLASS__) {
        return parent::model($className);
    }
 
     /*** 模型验证规则*/
    public function rules() {
      return $this->attributeRule();
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }
    public function attributeSets() {
        return array(
        'id' =>'id',
        'club_id' => '单位ID',//，数据值club_list表—ID
        'club_code' => '单位账号',
        'club_name' =>'社区名称',
        'partnership_type' => '单位二级类型',
        'partnership_name' =>'单位二级类型',
        'lang_type' =>'个人账号',//：0为单位 1为个人
        'admin_gfid'=> '管理者',
        'admin_gfaccount' => '管理者帐号',
        'admin_gfnick' =>'管理者昵称',
        'password'=> '密码',
        'ec_salt' =>'登录验证',
        'pay_pass' =>'支付密码',
        'pay_salt' =>'支付验证',
        'phone'=>'手机',
        'email' =>'邮箱',
        'if_del' => '是否删除',//0否  1 是
        'uDate'=> '添加时间',
        'last_login'=> '最后登录时间',
        'last_ip' => '最后登录IP',
        'is_on_line' => '在线状态', //0 否  1 是
        'admin_remark' =>'管理员类型',
        'sys_user' => '平台用户',//平台用户0不是，1 是
        'admin_level' => '权限',//，关联表qmdd_role表ID
        'admin_level_type' => '权限类型',//，关联表qmdd_role表f_user_type，多个使用逗号“,”区分
        'role_name' => '角色名称',
        'if_auto_access' => '自动接入',//0 否 1 是
        'max_access'=>'最大接入量',
        'if_auto_greet' => '自动发送',//0否  1 是
        'to_greet' => '问题语内容',
        'customer_service'=>'是否客服',//0 否 1 是
        );
    }

    public function getAdmin() {
        $rs = $this->findAll();
        foreach ($rs as $k => $v) {
            if (strlen($v->adv_code) != 1) {
                unset($rs[$k]);
            }
        }
        return $rs;
    }
    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }

  public function checkClubUser($tmp){
        $data= QmddAdministrators::model()->find('club_id='.$tmp->id);
        if(empty($data)){
            $data = new QmddAdministrators();
            $data->isNewRecord=true;
            unset($data->f_id);
            $s1='club_id:id,admin_gfaccoun:club_code,club_name:company';
            $data->toRec($tmp,'club_id,');
            $data->lang_type=0;
            $role1 = Role::model()->find('f_rcode = "B01"');
            $data->admin_level = $role1->f_id;
            $data->role_name = $role1->f_rname;
            $data->save();
        }
    }

}
