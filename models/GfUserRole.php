<?php
//小程序身份表，一条数据就是一个身份
class GfUserRole extends BaseModel {
    public $staName="";//临时储存场馆名称
    public $comName="";//临时储存社区名称
    public function tableName() {
        return '{{gf_user_role}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('roleCode', 'required', 'message' => '{attribute} 不能为空'),
            array('phone', 'required', 'message' => '{attribute} 不能为空'),
            array('claim_time', 'required', 'message' => '{attribute} 不能为空'),
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
            'roleCode'=>'角色码',//关联qmdd_role_new表，目前有两个功能1=>277:场地方,276:俱乐部,278:场馆方。2=>'279':活动发布者
            //场地方，运营方，俱乐部
            'staCode' => '场馆编码',  // 可以为空
            'roleName'=>'角色',
            'code' => '申请的场地或俱乐部编码',// 类似地区码，下级在上级码的基础上增加若干字符
            'name' => '场地或俱乐部名称',
            //活动发布权限

            //审核通用
            'phone' => '申请人电话',
            'openid' => '申请人openid',
            'claim_time' => '申请时间',
            'state' => '申请状态',  // 关联base_code表ID为371-374',371:待审核,2:审核通过,373:审核未通过,374:已撤销
            'if_del' => '是否解除',  // 0正常  1解除，state=2通过时使用',
            'judge_time'=>'审核时间',
        );
    }
    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    //获取总的身份类型
    public function getRoles(){
        $roles=array();
        $roles['276']='俱乐部';
        $roles['277']='场地方';
        $roles['278']='场馆方';
        $roles['279']='活动发布者';
        return $roles;
    }
    //检查roleCode是否为场馆方及其下级
    public function isRoleSta($roleCode=0){
        if($roleCode==0) $roleCode=$this->roleCode;
        if($roleCode=='276'||$roleCode=='277'||$roleCode=='278') return true;
        return false;
    }
    //检查roleCode是否为活动发布者
    public function isRoleAct($roleCode=0){
        if($roleCode==0) $roleCode=$this->roleCode;
        if($roleCode=='279') return true;
        return false;
    }
    //通过角色码获取角色名称
    public function getRoleName(){
        if(!$this->roleCode) return '';
        $roles = $this->getRoles();
        if(!isset($roles[$this->roleCode])) return '';
        return $roles[$this->roleCode];
    }
    public function getStateName($state=''){
        if(!$state) $state=$this->state;
        switch($state){
            case '371': return '待审核';
            case '2': return '审核通过';
            case '373': return '审核未通过';
            case '374': return '已撤销';
            default : return '';
        }
    }
    //检查是否重复
    public function checkDump($userId,$roleCode,$code){
        $check='';
        if($this->isRoleSta($roleCode)){
            $check = $this->find('userId='.$userId.' and roleCode='.$roleCode.' and code="'.$code.'" and (state=2 or state=371)');
        }
        else if($this->isRoleAct($roleCode)){
            $check = $this->find('userId='.$userId.' and roleCode='.$roleCode.'  and (state=2 or state=371)');
        }
        return $check;
    }
    public function saveJudge($submitType){
        if($submitType=='accept'){
            $this->state=2;
        }
        else if($submitType=='reject'){
            $this->state=373;
        }
        else{//非法调用
            show_status(0,'',get_cookie('_currentUrl_'),'非法调用');return;
        }
        $this->judge_time=date('Y-m-d H:i:s');
        $this->judger_id = $_SESSION['gfid'];
        $this->judger=$_SESSION['gfnick'];
        show_status($this->save(),BaseCode::model()->getName($this->state).',保存成功',get_cookie('_currentUrl_'),'保存失败');
    }
    //获取所有场馆场地俱乐部的多级选择 社区=>场馆=>场地+社区=>场馆=>俱乐部
    //1.在小程序申请角色页面用到
    public function getMultiselection(){
        $sta = testStadium::model()->findAll();//场馆信息
        $ven = testVenue::model()->findAll();//场地信息
        $club =testUnion::model()->findAll();//俱乐部信息
        $selections=array();
        $ven_res=array();
        $club_res=array();
        foreach($sta as $k=>$v){
            if(!array_key_exists($v->comCode,$selections)){
                $selections[$v->comCode]=$this->getSelectOption($v->comName,$v->comCode);
            }
            $selections[$v->comCode]['children'][$v->code]=$this->getSelectOption($v->name,$v->code);
        }
        $club_res=$selections;
        $ven_res=$selections;
        foreach($ven as $k=>$v){
            $ven_res[$v->comCode]['children'][$v->staCode]['children'][]=$this->getSelectOption($v->name,$v->code,false);
        }
        foreach($club as $k=>$v){
            $club_res[$v->comCode]['children'][$v->staCode]['children'][]=$this->getSelectOption($v->name,$v->code,false);
        }
        $ven_res=array_values($ven_res);
        $club_res=array_values($club_res);
        return array('ven'=>$ven_res,'club'=>$club_res);
    }
    //
    private function getSelectOption($text,$value,$child=true){
        if($child)
        return array(
                'text'=>$text,
                'value'=>$value,
                'children'=>array(),
            );
        else return array(
                'text'=>$text,
                'value'=>$value,
            );
    }
    //
    public function stadiumList(){
        $sta = testStadium::model()->findAll();//场馆信息
        $res=array();
        foreach($sta as $k=>$v){
            if(!array_key_exists($v->comCode,$res)){
                $res[$v->comCode]=$this->getSelectOption($v->comName,$v->comCode);
            }
            $res[$v->comCode]['children'][$v->code]=$this->getSelectOption($v->name,$v->code,false);
        }
        return array_values($res);
    }
    public function checkValid($roleCode,$code){
        $modelName="";
        switch($roleCode){
            case '276': $modelName= 'testUnion';break;
            case '277': $modelName= 'testVenue';break;
            case '278': $modelName= 'testStadium';break;
            default : $modelName='';
        }
        $model = $modelName::model()->find('code="'.$code.'"');
        if(empty($model)){//错误
            return;
        }
        return $model;
    }

}