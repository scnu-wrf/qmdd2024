<?php

class ClubList extends BaseModel { 
	public $club_list_pic='';
	public $about_me_temp = '';
	public $show=0;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{club_list}}';
    }
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
	    'club_project' => array(self::HAS_MANY, 'ClubProject', 'club_id'),
		'individual_way' => array(self::BELONGS_TO, 'BaseCode', 'individual_enterprise'),
		'clubtype' => array(self::BELONGS_TO, 'BaseCode', 'club_type'),
		'partnertype' => array(self::BELONGS_TO, 'BaseCode', 'partnership_type'),
		'club_list_pic' => array(self::HAS_MANY, 'ClubListPic', 'club_id'),
		'base_code' => array(self::BELONGS_TO, 'BaseCode', 'state'),
		'lockAdmin' => array(self::BELONGS_TO, 'QmddAdministrators', 'lock_adminid'),
		);
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
        'id' => 'ID',
        'no' => '序号',
		'club_code' => '单位账号:k',
		'financial_code' => '财务编码',
		'club_name' => '名称:k',
		'club_logo_pic' => 'LOGO:k',
		'apply_club_gfid' => 'ID',
		'apply_club_gfaccount' => '申请人帐号',
		'club_type' => '类型',
		'club_type_name' => '类型',
		'partnership_type' => '单位类型',
		'partnership_name' => '单位类型',
		'individual_enterprise' => '入驻类型',
		'individual_enterprise_name' => '入驻类型',
		'company' => '公司名称',
		'company_type_id' => '单位性质',
		'apply_club_gfnick' => '法人/负责人姓名',
		'apply_club_id_card' => '身份证号码',
		'apply_club_phone' => '联系电话',
		'apply_club_email' => '法人邮箱',
		'id_card_face' => '身份证正面',//club_logo_pic/id_card_face
		'id_card_back'  => '身份证反面',//id_card_back,certificates
		'organization_code' => '机构代码',
		'certificates_number' => '营业证编号',
		'certificates'=>'执照/从业证明',
		'valid_until_start' => '营业期限',
		'valid_until'=> '至',
		'management_category' => '经营类目',
		'apply_name' => '联系人',
		'contact_phone' => '联系电话',
		'apply_gfaccount' => '账号',
		'email' => '电子邮箱',
		'apply_id_card' => '身份证号码',//apply_id_card,club_list_pic,bank_pic
		'contact_id_card_back' => '身份证照',
		'club_list_pic' => '营业执照',
		'recommend' => '推荐单位',
		'bank_name' => '开户名称',
		'bank_branch_name' => '开户行支行名称',
		'bank_account' => '银行帐号',
		'bank_pic' => '银行开户许可证',
        'taxpayer_type' => '是否为一般纳税人',
        'taxpayer_pic' => '一般纳税人证明',//apply_id_card,club_list_pic,bank_pic,taxpayer_pic
		'club_area_country' => '国家',
		'club_area_province' => '省',
		'club_area_district' => '区域区县',
		'club_area_city' => '社区单位：市',
		'club_area_street' => '所在区域街道',
		'club_address' => '单位所在地',
		'latitude' => '纬度',
		'Longitude' => '经度',
		'service_hotline' => '客服服务热线',
		'apply_time' => '创办时间',
		'uDate' => '更新时间',
		'isRecommend' => '是否推荐社区',
		'recommend_club_name' => '推荐社区名',
		'is_invoice' => '开发票',
		'invoice_category' => '发票类型',
		'invoice_product_id' => '发票关联商品',
		'about_me'=> '关于我们',
		'state' => '当前状态',
		'state_name' => '状态名称',
		'if_del' => '是否删除',
		'news_clicked' => '点击率',
		'book_club_num' => '订阅数',
		'beans' => '社区体育豆',
		'club_credit' => '收益积分',
		'dispay_xh' => '显示序号',
		'reasons_for_failure'=>'操作备注',
		'data_belong_code' => '单位归属码',
		'mall_belong_code' => '商城归属码',
		'visible' => '是否禁止前端显示',  // 0不显示，1显示',
		'reasons_adminid' => '操作员',
		'reasons_adminname' => '操作员',
		'lock_reason' => '注销原因',
		'lock_date' => '注销时间',
		'enter_project_id' => '入驻项目',
		'approve_state' => '认证方式',
		'qualification_pics' => '上传协议',
		'about_me_time' => '发布日期',
		'lock_adminid' => '操作员',
		'lock_adminname' => '操作员',
		'recommend_clubcode' => '推荐单位账号',
		'recommend_clubname' => '推荐单位名称',
        'member_type' => '申请入驻类型',

        'contact_id_card_face' => '身份证照',
        'edit_apply_time' => '申请时间',    //意向入驻申请时间
        'edit_state' => '',
        'apply_card_id' => '',
        'apply_card' => '',
        'club_area_township' => '',
        'club_area_code' => '',
        'company_type' => '',
        'is_read' => '',
        'pass_time' => '',
        'edit_pass_time' => '',
        'unit_state' => '',
        'unit_state_name' => '',
        'edit_reasons_for_failure' => '',
        'about_me_temp' => '',
		);
	}

    public function picLabels() {
        $s1='club_logo_pic,id_card_face,contact_id_card_face';
        $s1.='id_card_back,certificates,contact_id_card_face,';
        return $s1.'apply_id_card,club_list_pic,bank_pic,taxpayer_pic';
    }
    public function pathLabels(){ return '';}

    public function getrelations() {
      $s1='ClubList,recommend_clubcode:club_code,recommend:id&recommend_clubname:club_name;';
      $s1.='userlist,apply_club_gfid:gf_id,apply_gfaccount:GF_ACCOUNT&apply_name:ZSXM';
      $s1.='&apply_club_gfaccount:apply_gfaccount';
      return $s1;
    }

        public function keySelect(){
        return array('1=1','id','club_name');
    }

   
	protected function afterSave() {
		parent::afterSave();
        if($this->state==2){
            QmddAdministrators::model()->checkClubUser($this);
        }
	}


	protected function beforeSave() {
        parent::beforeSave();
		// 图文描述处理
        $this->about_me_time = date('Y-m-d h:i:s');
        $this->about_me=getAboutMe($this,'about_me');
		if ($this->isNewRecord) {
			$this->apply_time = date('Y-m-d h:i:s');
        }
        $this->reasons_adminid = Yii::app()->session['admin_id'];
        $this->reasons_adminname = Yii::app()->session['gfnick'];
        $this->uDate = date('Y-m-d h:i:s');
        $this->setDistrict();
        return true;
	}

   public function setDistrict() {
      $ds=TRegion::model()->getDistrict($this->club_area_code);
      $this->club_area_province=$ds['province'];
      $this->club_area_city=$ds['city'];
      $this->club_area_district=$ds['district'];
    }

    public function getCode($club_type) {
        return $this->findAll('club_type=' . $club_type);
    }

	public function getID($id) {
        return $this->findAll('id=' . $id);
    }

    /**
     * 提交入驻申请
     */
    public function addClubApply($param){
        $data=get_error(1,"");
        $club_id =empty($param['apply_id'])?0: $param['apply_id'];
        unset($param['apply_id']);
        $param['apply_time']=get_date();
        $param['state']=371;
        $tmp= ClubList::model()->find('id='.$club_id);
        if(tmpty($tmp)){
            $tmp=new ClubList();
            $this->isNewRecord=true;
            unset($tmp->id);
        } 
        $tmp->attributes=$param;
        $tmp->save();
        $data=recToArray($tmp,'club_id:apply_id,state,state_name,apply_time');
        $data['error']=0;
        return $data;
    }
    /**
     * 获取入驻中列表
     * state 1-意向入驻；2-待认证；3-认证通过
     * 意向入驻：提交-待审核--撤销申请，撤销-已撤销-删除，待修改-退回修改-修改资料、删除，未通过-审核未通过-删除，未通过-已注销-删除
     * 认证中：意向通过-待认证--，待修改-退回修改-，未通过-审核未通过-删除，未通过-已注销-删除
     * 认证通过：认证成功，认证成功-注销-删除
     */
    public function getApplyList($param){
        $data=get_error(1,"请求失败");
        if(!checkArray($param,"visit_gfid,state,club_type",0)){
            return $data;
        }
        $per_page = empty($param['per_page'])?20:$param['per_page'];
        $page=empty($param['page'])?1:$param['page'];
        $page_s = ($page-1)*$per_page;
        $state=$param['state'];

        $where="apply_club_gfid=".$param['visit_gfid'].' and club_type='.$param['club_type'];
        switch($state){
            case 1:
                $where.=' and state<>2';
                break;
            case 2:
                $where.=' and state=2 and ifnull(edit_state,371)<>2';//
                break;
            case 3:
                $where.=' and state=2 and edit_state=2';
                break;
        }
        $cr = new CDbCriteria;
        $cr->condition=$where;
        $cr->select='id';
        $total=$this->count($cr,array());
        $data['total_count']=$total;
        $data['now_page']=$page;
        if($page_s>=0&&$total>$page_s){
            $cr->condition=$where ." limit ".$page_s.",".$per_page;
            $cr->select="id as apply_id,if(individual_enterprise=403,apply_name,company) as apply_name,club_name,uDate as control_time,state,state_name,ifnull(edit_state,371) as edit_state,edit_state_name,unit_state";//,pass_time,edit_pass_time,lock_date
            if($param['club_type']==8){
                $cr->select.=',individual_enterprise,individual_enterprise_name';
            }
            $datas=$this->findAll($cr,array(),false);


            foreach($datas as $k=>$v){
                $v['can_del']=1;
//                 $v['control_time']=$v['pass_time'];
                switch($v['state']){
                    case 371:
                        $v['can_del']=0;
                        $v['control_name']='提交';
                        break;
                    case 373: $v['state_name']=$v['state_name'];
                        $v['control_name']='未通过';
                        break;
                    case 374: $v['control_name']='已撤销'; break;
                    case 1538:$v['control_name']='退回修改'; break;
                    case 2:
                        if($v['edit_state']==2){
                            $v['state_name']='';
                            $v['control_name']='认证成功';
                        }else if($v['edit_state']==371){
                            $v['can_del']=0;
                            $v['state_name']='待认证';
                            $v['control_name']='意向通过';
                        }else if($v['edit_state']==374){
                            $v['state_name']=$v['edit_state_name'];
                            $v['control_name']='未通过';
                        }else if($v['edit_state']==1538){
                            $v['state_name']=$v['edit_state_name'];
                            $v['control_name']='待修改';
                        }
                        break;
                }
                if($v['unit_state']==649){
                    $v['state_name']='已注销';
                }
                $datas[$k]=$v;
            }
            $data['datas']=$datas;
        }else{
            $data['datas']=array();
        }
        return $data;
    }
    /**
     * 获取入驻申请详情
     *
     * 意向入驻：提交-待审核--撤销申请，撤销-已撤销-删除，待修改-退回修改-修改资料、删除，未通过-审核未通过-删除，未通过-已注销-删除
     * 认证中：意向通过-待认证--，待修改-退回修改-，未通过-审核未通过-删除，未通过-已注销-删除
     * 认证通过：认证成功，认证成功-注销-删除
     *
     * control 1-撤销申请，2-删除，3-修改资料；
     */
    public function GetApplyDetail($param){
        $data=get_error(1,"请求失败");
        if(!checkArray($param,"visit_gfid,apply_id",0)){
            return $data;
        }
        $cr = new CDbCriteria;
        $cr->condition="apply_club_gfid=".$param['visit_gfid']." and id=".$param['apply_id'];
        $cr->select="club_type,club_type_name,partnership_type,partnership_name,individual_enterprise,individual_enterprise_name,club_code,club_name,state,state_name,ifnull(edit_state,371) as edit_state,edit_state_name,reasons_for_failure,edit_reasons_for_failure,unit_state,lock_reason,uDate";//,pass_time,edit_pass_time,lock_date
        $list=$this->find($cr,array(),false);
        if(empty($list)){
            return $data;
        }
        $list['customer_service_club']=array('club_id'=>2450,'club_name'=>'GF平台运维事业群');//平台客服单位
        $list['state_name']='意向入驻-'.$list['state_name'];
        $list['state_content']='';
        $list['control']='';
        $list['notify']='';
        $list['club_detail_title']='';
        $list['club_detail']='';
        $club_type_name=$list['club_type_name'];
        $qmdd_url=getShowUrl('qmdd_url');
        switch($list['state']){
            case 371:
                $list['state_content']='1-3个工作日内完成审核';
                $list['control']='1';
                break;
            case 373:
                $list['state_content']='备注：<font color="#FF0000">'.$list['reasons_for_failure'].'</font>';
                $list['notify']='提示：对于提交申请后长期未完成入驻流程或审核未通过的单位，平台将定期进行账号注销处理。';
                $list['control']='2';
                break;
            case 374:
                $list['state_content']='您已撤销'.$club_type_name.'入驻申请';
                $list['control']='2';
                break;
            case 1538:
                $list['state_content']='备注：<font color="#FF0000">'.$list['reasons_for_failure'].'</font>';
                $list['control']='3,2';
                break;
            case 2:
                $list['state_name']='';
                $list['state_content']='备注：<font color="#FF0000">'.$list['edit_reasons_for_failure'].'</font>';
                if($list['edit_state']==2){
                    $list['state_name']='单位认证-审核通过';
                    $list['club_detail_title']=$club_type_name.'认证审核通过啦！';
                    $list['club_detail']=$list['club_detail_title'].'<br/>管理后台地址        <font color="#297fd6">'.$qmdd_url.'/admin/index.php</font><br/>单位管理账号        <font color="#297fd6"> ['.$list['club_code'].']</font><br/>服务机构类型        <font color="#297fd6">['.($list['club_type']==8?$club_type_name.'/'.$list['individual_enterprise_name']:$list['partnership_name']).']</font><br/>服务平台名称        <font color="#297fd6">'.$list['club_name'].'</font> <br/><font color="#808080">'.date("Y/m/d H:i",strtotime($list['uDate'])).'</font>';
                    $list['notify']='*提示：<br/>1.认证时一并申请项目的，请在“项目”查看进度，注册项目成功后服务平台方可展示前端；<br/>2.认证时未申请项目的，请继续进行项目注册。';
                    $list['control']=$list['unit_state']==648?'':'2';
                }else if($list['edit_state']==371){
                    $list['state_name']='意向审核通过-待认证';
                    $list['club_detail_title']=$club_type_name.'-意向入驻审核通过啦！';
                    $list['club_detail']=$list['club_detail_title'].'<br/>请登录管理后台-账号管理-单位认证，完善资料后提交认证！<br/>管理后台地址        <font color="#297fd6">'.$qmdd_url.'/admin/index.php</font><br/>单位管理账号        <font color="#297fd6"> ['.$list['club_code'].']</font><br/>初始密码        <font color="#297fd6">[123456]</font>，登录后请及时更改！ <br/><font color="#808080">'.date("Y/m/d H:i",strtotime($list['uDate'])).'</font>';
                }else if($list['edit_state']==373){
                    $list['state_name']='单位认证-'.$list['edit_state_name'];
                    $list['state_content']='备注：<font color="#FF0000">'.$list['reasons_for_failure'].'</font>';
                    $list['notify']='提示：对于提交申请后长期未完成入驻流程或审核未通过的单位，平台将定期进行账号注销处理。';
                    $list['control']='2';
                }else if($list['edit_state']==374){
                    $list['state_name']='单位认证-'.$list['edit_state_name'];
                    $list['control']='2';
                }else if($list['edit_state']==1538){
                    $list['state_name'].=$list['edit_state_name'];
                    $list['control']='3,2';
                }
                break;
        }
        if($list['unit_state']==649){
            $list['state_name']='账号已注销';
            $list['state_content']='注销原因：<font color="#FF0000">'.$list['lock_reason'].'</font>';
            $list['control']='2';
            $list['club_detail']='<font color="#FF0000">账号已被注销！</font><br/>管理后台地址         <font color="#297fd6">'.$qmdd_url.'/admin/index.php</font><br/>单位管理账号        <font color="#297fd6"> ['.$list['club_code'].']</font><br/>服务机构类型        <font color="#297fd6">['.($list['club_type']==8?$club_type_name.'/'.$list['individual_enterprise_name']:$list['partnership_name']).']</font><br/>服务平台名称        <font color="#297fd6">'.$list['club_name'].'</font><br/><font color="#808080">'.date("Y/m/d H:i",strtotime($list['uDate'])).'</font>';
        }
        $data['error']=0;
        $data['datas']=$list;
        return $data;
    }

    /**
     * 入驻申请操作
     * 意向入驻：提交-待审核--撤销申请，撤销-已撤销-删除，待修改-退回修改-修改资料、删除，未通过-审核未通过-删除，未通过-已注销-删除
     * 认证中：意向通过-待认证，待修改-退回修改，未通过-审核未通过-删除，未通过-已注销-删除
     * 认证通过：认证成功，认证成功-注销-删除
     * control 1-撤销申请 state=371，2-删除
     */
    public function ApplyControl($param){
        $data=get_error(1,"请求失败");
        if(!checkArray($param,"visit_gfid,apply_id,control",0)){
            return $data;
        }
        $where="apply_club_gfid=".$param['visit_gfid']." and id=".$param['apply_id'];
        $control_str=$param['control']==1?'撤销申请':'删除';
        set_error($data,1,$control_str.'失败',0);
        $club=$this->find($where);
        if(empty($club)){
            return $data;
        }
        if($param['control']==1&&$club->state==371){
            $res=$this->updateAll(array('state'=>374),$where);
            set_error_tow($data,$res,0,$control_str.'成功',1,$control_str.'失败',0);
        }
        if($param['control']==2&&($club->state==373||$club->state==374||$club->state==1538
            ||($club->state==2&&($club->edit_state==373||$club->unit_state==649)))){
                $res=$this->updateAll(array('if_del'=>509),$where);
            set_error_tow($data,$res,0,$control_str.'成功',1,$control_str.'失败',0);
        }
        return $data;
    }
    /**
     * 社区单位+战略伙伴
     * club_type =8,189
     */
    public function getClubList($param) {
        $club_type=empty($param['club_type'])?'8,189':$param['club_type'];
        $key=empty($param['key'])?'':$param['key'];
        $type_id=empty($param['partnership_type'])?'':$param['partnership_type'];
        $project_id=empty($param['project_id'])?'':$param['project_id'];

        $per_page = empty($param['per_page'])?20:$param['per_page'];
        $page=empty($param['page'])?1:$param['page'];
        $page_s = ($page-1)*$per_page;

		$where="t.unit_state=648 and t.club_type in(".$club_type.")";
		$where=get_where_like($where,$key,"t.club_name",$key);
		$where=get_where($where,$type_id,"t.partnership_type",$type_id);
		$where=get_where($where,$project_id,"club_project.project_id",$project_id);
        $cr = new CDbCriteria;
		$cr->condition=$where;
		$cr->join=" join club_project on club_project.club_id=t.id and club_project.project_state in(1,506) and club_project.auth_state in(5,461) and club_project.state in(2,2)";
        $cr->select='t.id';
        $total=$this->count($cr,array());
		$data['total_count']=$total;
		$data['now_page']=$page;
		$img_dir=getShowUrl('file_path_url');
		if($page_s>=0&&$total>$page_s){
			$cr->condition=$where ." limit ".$page_s.",".$per_page;
		    $cr->select="t.id as club_id,t.club_name,(case when ifnull(t.club_logo_pic,'')='' then '' else concat('".$img_dir."',t.club_logo_pic) end) as club_logo,t.partnership_name as club_partnership_name,group_concat(distinct club_project.project_id) as project_id,group_concat(distinct club_project.project_name) as project_name";
	        $datas=$this->findAll($cr,array(),false);
		}else{
			$datas=[];
		}
        $data['datas']=$datas;
    	return $data;
    }
}
