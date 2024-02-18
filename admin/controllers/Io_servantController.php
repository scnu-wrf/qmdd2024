<?php
/**
 * 前端接口-服务者
 * @author xiyan
 */
class Io_servantController extends BaseController {
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
    
    /**
     * 服务者入驻申请／修改
     */
    public function actionServant_apply(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"请求失败");
		checkArray($param,"visit_gfid,phone,email,type,area,address_detail,head_pic",1);
		$img_dir=getShowUrl('file_path_url');
    	$param['certificate_img']=CommonTool::model()->get_fullurl_name($img_dir,$param['certificate_img']);
     	$servant_id =empty($param['apply_id'])?-1: $param['apply_id'];
     	$gfid=$param['visit_gfid'];
    	$param=CommonTool::model()->getKeyArray($param,'area,certificate_level_type,end_date,head_pic,certificate_img,certificate_level,type,certificate_num,address_detail,project_id,phone,email,start_date',array('type'=>'qualification_type_id','area'=>'area_code','address_detail'=>'address','project_id'=>'project_id','certificate_level_type'=>'identity_type','certificate_level'=>'identity_num','certificate_num'=>'qualification_code','certificate_img'=>'qualification_image'));
    	
    	$param['gfid']=$gfid;
    	$param['uDate']=get_date();
    	$param['check_state']=371;
    	$where="gfid=".$gfid;
     	$where.=(empty($servant_id)||$servant_id<=0)?"":" and id=".$servant_id;
     	$where=get_where($where,$param['qualification_type_id'],"qualification_type_id",$param['qualification_type_id']);
    	if(empty($param['identity_num'])){
    		unset($param['identity_num']);
    		unset($param['qualification_code']);
    		unset($param['qualification_image']);
    		unset($param['start_date']);
    		unset($param['end_date']);
    	}else{
    		$where=get_where($where,$param['identity_num'],"identity_num",$param['identity_num']);
    	}
		if(empty($param['project_id'])){
			unset($param['project_id']);
		}else{
			$where=get_where($where,$param['project_id'],"project_id",$param['project_id']);
		}
        $cr = new CDbCriteria;
        $cr->condition=$where;
        $cr->order = 'state';
        $cr->select="id,check_state,(case when check_state=2 or check_state=1 then 0 when check_state=374 or check_state=3 then 2 else 1 end) state";
        $list=QualificationsPerson::model()->find($cr);
		if(empty($list)){
			$list=new QualificationsPerson();
			unset($list->id);
    		unset($param['id']);
			$res=$list->insert($param);
		}else{
			$servant_state=$list->check_state;
			if($servant_state==371||$servant_state==2){
	    		set_error($data,4,"该服务者已申请，请去管理列表中查看入驻状态！",1);
	    	}
			$res=$list->update($param);
		}
    	if($res){
			$servant_id=$list->id;
	         $data['error'] = 0;
	         $data['msg'] = empty($param['id'])?"服务者入驻申请提交成功":"修改服务者入驻申请成功";
	         $data['servant_id'] = $servant_id;
		     $data['apply_time'] = $param['uDate'];
		     $data['auth_state'] = 0;
		     $data['auth_state_name'] = '待审核';
    	}else{
	         $data['error'] = 1;
	         $data['msg'] = empty($param['id'])?"服务者入驻申请提交失败":"修改服务者入驻申请失败" ;
	     }
        set_error($data,$data['error'],$data['msg'],1);
    }
    /**
     * 获取入驻中列表
     * 申请-待审核-371，撤销-已撤销-374，待修改-返回修改-1538，未通过-审核未通过-373
     * ，审核通过-待通知，已通知-待缴费，已支付-待确认，超时未付-入驻失败
     */
    public function actionServant_apply_list(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"请求失败");
		checkArray($param,"visit_gfid",1);
        $type_id=empty($param['type_id'])?'':$param['type_id'];
        $project_id=empty($param['project_id'])?'':$param['project_id'];
        
        $per_page = empty($param['per_page'])?20:$param['per_page'];
        $page=empty($param['page'])?1:$param['page'];
        $page_s = ($page-1)*$per_page;
        
		$where="is_del=648 and auth_state<>931 and gfid=".$param['visit_gfid'];
		$where=get_where($where,$type_id,"qualification_type_id",$type_id);
		$where=get_where($where,$project_id,"project_id",$project_id);
        $cr = new CDbCriteria;
		$cr->condition=$where;
        $cr->select='id';
        $total=QualificationsPerson::model()->count($cr,array());
		$data['total_count']=$total;
		$data['now_page']=$page;
		if($page_s>=0&&$total>$page_s){
			$cr->condition=$where ." limit ".$page_s.",".$per_page;
	        $cr->select="id as apply_id,qualification_type_id as type_id,qualification_type as type_name,project_id as project_id,project_name as project_name,uDate as control_time,auth_state as state,check_state,free_state_id,(case when check_state=2 and free_state_Id=1400 then '入驻失败' when check_state=2 then free_state_name else check_state_name end) as state_name,(case when check_state=371 then '申请' when check_state=374 then '撤销' when check_state=1538 then '待修改' when check_state=373 then '未通过' when check_state=2 and free_state_Id=1200 then '审核通过' when check_state=2 and free_state_Id=1195 then '已通知' when check_state=2 and free_state_Id=1201 then '已支付' when check_state=2 and free_state_Id=1400 then '超时未付' else '' end) as control_name,ifnull(cut_date,'') as end_time,if(check_state in(373,374,1538) or (check_state=2 and free_state_Id=1400),1,0) as can_del";
	        $datas=QualificationsPerson::model()->findAll($cr,array(),false);
			$data['datas']=$datas;
		}else{
			$data['datas']=array();
		}
		if(!empty($param['get_menu'])){//拉取第一页全部数据是返回项目、分类
			if($total==0){
				$data['project']=array(array('id'=>'0','name'=>'全部项目'));
				$data['type']=array(array('id'=>'0','name'=>'全部类型'));
			}else{
				$cr->condition=$where." and project_id>0";
				$cr->group='project_id';
		        $cr->select='project_id as id,project_name as name';
				$project=QualificationsPerson::model()->findAll($cr,array(),false);
	        	$no_limit=array('id'=>'0','name'=>'全部项目');
	            array_unshift($project,$no_limit);
				$data['project']=$project;
				
				$cr->condition=$where;
				$cr->group='qualification_type_id';
		        $cr->select='qualification_type_id as id,qualification_type as name';
				$type=QualificationsPerson::model()->findAll($cr,array(),false);
	        	$no_limit=array('id'=>'0','name'=>'全部类型');
	            array_unshift($type,$no_limit);
				$data['type']=$type;
			}
		}
        set_error($data,0,count($data['datas'])==0?'无相关记录':'获取成功',1);
    }
    /**
     * 获取入驻申请详情
     * 申请-待审核-371，撤销-已撤销-374，待修改-返回修改-1538，未通过-审核未通过-373
     * ，审核通过-待通知，已通知-待缴费，已支付-待确认，超时未付-入驻失败
     * 
     * 待审核-撤销申请；已撤销-删除；返回修改-修改资料、删除；审核未通过-删除；审核通过（待缴费通知）-撤销申请；
     * 待缴费-撤销申请、去支付；已支付-订单详情；入驻失败-订单详情、删除；
     * 
     * control 1-撤销申请，2-删除，3-修改资料，4-支付，5-订单详情；
     */
    public function actionServant_apply_detail(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"请求失败");
		checkArray($param,"visit_gfid,apply_id",1);
        $cr = new CDbCriteria;
        $cr->condition="gfid=".$param['visit_gfid']." and id=".$param['apply_id'];
        $cr->select="auth_state,check_state,check_state_name,reasons_for_failure,free_state_Id,free_state_name,cut_date as end_time,order_num";
        $list=QualificationsPerson::model()->find($cr,array(),false);
        if(empty($list)){
        	set_error($data,1,'获取服务者入驻申请详情失败',1);
        }
        $list['customer_service_club']=array('club_id'=>2450,'club_name'=>'GF平台运维事业群');//平台客服单位
		$list['state_name']='服务者入驻-';
        switch($list['check_state']){
        	case 371:
		        $list['state_name'].=$list['check_state_name'];
		        $list['state_content']='1-3个工作日内完成审核';
		        $list['control']='1';
        	break;
        	case 373:
		        $list['state_name'].=$list['check_state_name'];
		        $list['state_content']='备注：<font color="#FF0000">'.$list['reasons_for_failure'].'</font>';
		        $list['control']='2';
        	break;
        	case 374:
		        $list['state_name'].=$list['check_state_name'];
		        $list['state_content']='您已撤销服务者入驻申请';
		        $list['control']='2';
        	break;
        	case 1538:
		        $list['state_name'].=$list['check_state_name'];
		        $list['state_content']='备注：<font color="#FF0000">'.$list['reasons_for_failure'].'</font>';
		        $list['control']='3,2';
        	break;
        	case 2:
        	//when check_state=2 and free_state_Id=1200 then '审核通过' when check_state=2 and free_state_Id=1195 then '已通知' when check_state=2 and free_state_Id=1201 then '已支付' when check_state=2 and free_state_Id=1400 then '超时未付'
        		if($list['free_state_Id']==1200){
        			$list['state_name'].='审核通过(待缴费通知)';
		        	$list['state_content']='备注：<font color="#FF0000">'.$list['reasons_for_failure'].'</font>';
			        $list['control']='1';
        		}elseif($list['free_state_Id']==1195){
        			$list['state_name'].='待缴费';
		        	$list['state_content']='';
			        $list['control']='1,4';
        		}elseif($list['free_state_Id']==1201){
        			$list['state_name'].='已支付（待确认）';
		        	$list['state_content']='系统将24小时内完成确认';
			        $list['control']='5';
        		}elseif($list['free_state_Id']==1400){
        			$list['state_name'].='入驻失败';
		        	$list['state_content']='订单超时未支付（已关闭），入驻失败';
			        $list['control']='5,2';
        		}
        	
        	break;
        }
        $list['order_type']=357;
        $data['datas']=$list;
        set_error($data,0,'获取服务者入驻申请详情成功',1);
    }
    
    /**
     * 服务者入驻申请操作
     * control 1-撤销申请，2-删除，
     * 
     * 待审核-撤销申请；已撤销-删除；返回修改-修改资料、删除；审核未通过-删除；审核通过（待缴费通知）-撤销申请；
     * 待缴费-撤销申请、去支付；已支付-订单详情；入驻失败-订单详情、删除；
     */
    public function actionServant_apply_control(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"请求失败");
		checkArray($param,"visit_gfid,apply_id,control",1);
        $where="gfid=".$param['visit_gfid']." and id=".$param['apply_id'];
        $control_str=$param['control']==1?'撤销':'删除';
        $servant=QualificationsPerson::model()->find($where);
        if(empty($servant)){
        	set_error($data,1,$control_str.'失败',1);
        }
        $check_state=$servant->check_state;
        $pay_state=$servant->free_state_Id;
        $res=0;
        if($param['control']==1&&($check_state==371||($check_state==2&&($pay_state==1200||$pay_state==1195)))){
        	$res=QualificationsPerson::model()->updateAll(array('check_state'=>374,'state_time'=>get_date()),$where);
        }elseif($param['control']==2&&($check_state==373||$check_state==374||$check_state==1538||($check_state==2&&($pay_state==1400)))){
        	$res=QualificationsPerson::model()->updateAll(array('is_del'=>649),$where);
        }
        set_error_tow($data,$res,0,$control_str.'成功',1,$control_str.'失败',1);
    }
    
    /**
     * 获取入驻申请资料信息
     */
    public function actionServant_apply_info(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"请求失败");
		checkArray($param,"visit_gfid,apply_id",1);
        $cr = new CDbCriteria;
        $cr->condition="gfid=".$param['visit_gfid']." and id=".$param['apply_id'];
        $cr->select="head_pic,phone,email,if(sex=207,'女','男') as sex,qualification_type_id,qualification_type,area_code,address,project_id,project_name,identity_type,identity_type_name,identity_num,qualification_title,qualification_code,qualification_image,start_date,end_date";
        $list=QualificationsPerson::model()->find($cr,array(),false);
        if(empty($list)){
        	set_error($data,1,'获取服务者入驻申请明细失败',1);
        }
        $datas=CommonTool::model()->ChangeArrayKey2($list,array('type'=>'qualification_type_id','area'=>'area_code','address_detail'=>'address','certificate_level_type'=>'identity_type','certificate_level_type_name'=>'identity_type_name','certificate_level'=>'identity_num','certificate_level_name'=>'qualification_title','certificate_num'=>'qualification_code','certificate_img'=>'qualification_image'));
        $datas=CommonTool::model()->ArrayNullToStr($datas,'');
		$url=getShowUrl('file_path_url');
		$datas['area_name']=empty($datas['area'])?'':TRegion::model()->getRegionname($datas['area']);
        $datas['head_pic']=CommonTool::model()->addto_url_dir($url,$datas['head_pic'],',',',');
        $datas['certificate_img']=CommonTool::model()->addto_url_dir($url,$datas['certificate_img'],',',',');
        $datas['phone']=CommonTool::model()->HideKeyContent($datas['phone']);
        $datas['email']=CommonTool::model()->HideKeyContent($datas['email']);
        
        $type_set=ClubServicerType::model()->find('member_second_id='.$datas['type']);
        $datas['if_project']=!empty($type_set)&&$type_set->if_project==649?1:0;
        $datas['certificate']=!empty($type_set)&&!empty($type_set->certificate_type)?1:0;
        
        $data['datas']=$datas;
        set_error($data,0,'获取服务者入驻申请明细成功',1);
    }
    
    /**
     * 获取服务者列表（已入驻）
     * 申请-待审核-371，撤销-已撤销-374，待修改-返回修改-1538，未通过-审核未通过-373
     * ，审核通过-待通知，已通知-待缴费，已支付-待确认，超时未付-入驻失败
     */
    public function actionServant_list(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"请求失败");
		checkArray($param,"visit_gfid",1);
        $type_id=empty($param['type_id'])?'':$param['type_id'];
        $project_id=empty($param['project_id'])?'':$param['project_id'];
        
        $per_page = empty($param['per_page'])?20:$param['per_page'];
        $page=empty($param['page'])?1:$param['page'];
        $page_s = ($page-1)*$per_page;
        
		$where="check_state=2 and auth_state=931 and is_del=648 and gfid=".$param['visit_gfid'];
		$where=get_where($where,$param['type_id'],"qualification_type_id",$param['type_id']);
		$where=get_where($where,$param['project_id'],"project_id",$param['project_id']);
        $cr = new CDbCriteria;
		$cr->condition=$where;
        $cr->select='id';
        $total=QualificationsPerson::model()->count($cr,array());
		$data['total_count']=$total;
		$data['now_page']=$page;
		if($page_s>=0&&$total>$page_s){
			$cr->condition=$where ." limit ".$page_s.",".$per_page;
	        $cr->select="id as servant_id,qualification_type_id as type_id,qualification_type as type_name,project_id as project_id,project_name as project_name,qualification_title,level_name,band_club_num as join_num,expiry_date_start as start_date,expiry_date_end as end_date,if_del,unit_state";
	        $datas=QualificationsPerson::model()->findAll($cr,array(),false);
	        foreach($datas as $k=>$v){
	        	$datas[$k]['state_name']=$v['unit_state']==649?'注销':($v['if_del']==507?'冻结':'');
	        	$datas[$k]['show_name']=(empty($v['project_name'])?'':("<font color=\"#ff7e00\">".$v['project_name']."</font>-")).$v['type_name'];
	        	$empty_str='&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;';
	        	$datas[$k]['show_content']="资质等级".$empty_str.(empty($v['qualification_title'])?'无':($v['qualification_title'].'/'.$v['level_name']))."<br/>绑定单位".$empty_str."<font color=\"#808080\">".$v['join_num']."</font><br/>有效期&#160;&#160;&#160;&#160;".$empty_str.date("Y/m/d",strtotime($v['start_date']))."  至  ".date("Y/m/d",strtotime($v['end_date']));
	        }
			$data['datas']=$datas;
		}else{
			$data['datas']=array();
		}
		if(!empty($param['get_menu'])){//拉取第一页全部数据是返回项目、分类
			if($total==0){
				$data['project']=array(array('id'=>'0','name'=>'全部项目'));
				$data['type']=array(array('id'=>'0','name'=>'全部类型'));
			}else{
				$cr->condition=$where." and project_id>0";
				$cr->group='project_id';
		        $cr->select='project_id as id,project_name as name';
				$project=QualificationsPerson::model()->findAll($cr,array(),false);
	        	$no_limit=array('id'=>'0','name'=>'全部项目');
	            array_unshift($project,$no_limit);
				$data['project']=$project;
				
				$cr->condition=$where;
				$cr->group='qualification_type_id';
		        $cr->select='qualification_type_id as id,qualification_type as name';
				$type=QualificationsPerson::model()->findAll($cr,array(),false);
	        	$no_limit=array('id'=>'0','name'=>'全部类型');
	            array_unshift($type,$no_limit);
				$data['type']=$type;
			}
		}
    	
		$data['now_page']=$page;
        set_error($data,0,count($data['datas'])==0?'无相关记录':'获取成功',1);
    }
	/**
     * 获取服务者详情
     */
    public function actionServant_info(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"请求失败");
		checkArray($param,"visit_gfid,servant_id",1);
        $cr = new CDbCriteria;
        $cr->condition="gfid=".$param['visit_gfid']." and id=".$param['servant_id'];
	    $cr->select="id as servant_id,qcode as servant_code,qualification_type_id as type_id,qualification_type as type_name,project_id as project_id,project_name as project_name,qualification_title as certificate_level,level_name as servant_level,qualification_score as integral,band_club_num as join_num,expiry_date_start as start_date,expiry_date_end as end_date,if_del,unit_state,unit_cause as cancellation_reason,ifnull(unit_apply_date,'') as cancellation_datetime";
        $detail=QualificationsPerson::model()->find($cr,array(),false);
        if(empty($detail)){
        	set_error($data,1,'获取服务者详情失败',1);
        }
        $detail['servant_name']=(empty($detail['project_name'])?'':($detail['project_name']."-")).$detail['type_name'];
        $detail['expiry_date']=date("Y/m/d",strtotime($detail['start_date']))."  至  ".date("Y/m/d",strtotime($detail['end_date']));
        $detail['control']=$detail['unit_state']==649?3:1;//1-申请注销，2-撤销申请，3-删除
        $detail['cancellation_state']=$detail['unit_state']==649?'【'.$detail['servant_name'].'】服务者资格已注销':'';//'服务者申请注销-待审核'
        $detail['cancellation_datetime']=empty($detail['cancellation_datetime'])?'':date("Y/m/d H:i",strtotime($detail['cancellation_datetime']));
        $data['datas']=$detail;
        
		$cr->condition="qualification_person_id=".$param['servant_id'];
	    $cr->select="state_name as freezing_name,lock_reason as freezing_reason,IFNULL(lock_date_start,'') as start_date,IFNULL(lock_date_end,'') as end_date,state";
        $frozen=QualificationsPersonLock::model()->findAll($cr,array(),false);
        $frozen_datas=array();
        $data['freezing_num']=count($frozen);
        if($data['freezing_num']>0){
        	$i=0;
	        foreach($frozen as $k=>$v){
	        	if($v['state']!=506){
	        		$v['freezing_state']=1;
	        		$v['freezing_state_name']='冻结中';
	        		$frozen_datas[$i]=$v;
	        		$i++;
	        	}elseif($v['state']==506&&count($frozen_datas)==$i){
	        		$frozen_datas[$i-1]['freezing_state']=2;
	        		$frozen_datas[$i-1]['freezing_state_name']='已解冻';
	        		$frozen_datas[$i-1]['end_date']=$v['end_date'];
	        	}
	        }
        	$data['freezing_name']=$frozen_datas[$i-1]['freezing_name'];
	        $data['freezing_reason']=$frozen_datas[$i-1]['freezing_reason'];
	        $data['freezing_state_name']=$frozen_datas[$i-1]['freezing_state_name'];
        }
        $data['frozen_datas']=$frozen_datas;
        set_error($data,0,'获取服务者详情成功',1);
    }
	/**
     * 获取服务者冻结记录
     */
    public function actionServant_frozen_list(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"请求失败");
		checkArray($param,"visit_gfid,servant_id",1);
        $cr = new CDbCriteria;
		$cr->condition="qualification_person_id=".$param['servant_id'];
	    $cr->select="state_name as freezing_name,lock_reason as freezing_reason,IFNULL(lock_date_start,'') as start_date,IFNULL(lock_date_end,'') as end_date,state";
        $frozen=QualificationsPersonLock::model()->findAll($cr,array(),false);
        $frozen_datas=array();
        $data['total_count']=count($frozen);
        if($data['total_count']>0){
        	$i=0;
	        foreach($frozen as $k=>$v){
	        	if($v['state']!=506){
	        		$v['freezing_state']=1;
	        		$v['freezing_state_name']='冻结中';
	        		$frozen_datas[$i]=$v;
	        		$i++;
	        	}elseif($v['state']==506&&count($frozen_datas)==$i){
	        		$frozen_datas[$i-1]['freezing_state']=2;
	        		$frozen_datas[$i-1]['freezing_state_name']='已解冻';
	        		$frozen_datas[$i-1]['end_date']=$v['end_date'];
	        	}
	        }
        }
        $data['datas']=$frozen_datas;
        set_error($data,0,'获取成功',1);
    }
	/**
     * 服务者注销申请
     */
    public function actionServant_cancellation(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"请求失败");
		checkArray($param,"visit_gfid,servant_id,reason",1);
        $where="gfid=".$param['visit_gfid']." and id=".$param['servant_id'];
        $control_str='注销申请';
        $servant=QualificationsPerson::model()->find($where);
        if(empty($servant)){
        	set_error($data,1,$control_str.'失败',1);
        }
        $unit_state=$servant->unit_state;
        if($unit_state==649){
        	set_error($data,0,'已申请',1);
        }
		$res=QualificationsPerson::model()->updateAll(array('unit_state'=>649,'unit_cause'=>$param['reason'],'unit_apply_date'=>get_date()),$where);
        set_error_tow($data,$res,0,$control_str.'成功',1,$control_str.'失败',1);
    }
	/**
     * 服务者注销申请操作
     * control 2-撤销申请，3-删除
     */
    public function actionServant_cancellation_control(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"请求失败");
		checkArray($param,"visit_gfid,servant_id,control",1);
        $where="gfid=".$param['visit_gfid']." and id=".$param['servant_id'];
        $control_str=$param['control']==1?'撤销':'删除';
        $servant=QualificationsPerson::model()->find($where);
        if(empty($servant)){
        	set_error($data,1,$control_str.'失败',1);
        }
        $unit_state=$servant->unit_state;
        if($unit_state==649){
        	$res=QualificationsPerson::model()->updateAll(array('is_del'=>649),$where);
        }
        set_error_tow($data,$res,0,$control_str.'成功',1,$control_str.'失败',1);
    }
    /**
     * 获取服务者积分记录
     */
    public function actionServant_integral_list(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"请求失败");
		checkArray($param,"visit_gfid,servant_id,year_month",1);
        $servant=QualificationsPerson::model()->find('id='.$param['servant_id']);
        if(empty($servant)){
        	set_error($data,1,'获取失败',1);
        }
        
        $cr = new CDbCriteria;
		$cr->condition="qualification_id=".$param['servant_id'].' and left(udeta,7)='.$param['year_month'];
	    $cr->select="type_name as name,if_add,concat(if(if_add=0,'+','-'),credit) as add_subtract,IFNULL(udeta,'') as add_datetime";
        $datas=QualificationsCertificateDetail::model()->findAll($cr,array(),false);
        $data['total_integral']=$servant['qualification_score'];
        $data['datas']=$datas;
        set_error($data,0,'获取成功',1);
    }
    /**
     * 获取服务者绑定单位记录
     */
    public function actionServant_band_club_list(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"请求失败");
		checkArray($param,"visit_gfid,servant_id",1);
        $servant=QualificationsPerson::model()->find('id='.$param['servant_id']);
        if(empty($servant)){
        	set_error($data,1,'获取失败',1);
        }
        $param['join']=1;
        $data=QualificationInvite::model()->servantBand($param);
        set_error($data,0,count($data['datas'])==0?'无相关记录':'获取成功',1);
    }
    /**
     * 获取用户绑定单位列表
     */
    public function actionUser_servant_band_club_list(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"请求失败");
		checkArray($param,"visit_gfid,band_state",1);
        $data=QualificationInvite::model()->servantBand($param);
        
		if(!empty($param['get_menu'])){//拉取第一页全部数据是返回项目、分类
			if($data['total_count']==0){
				$data['project']=array(array('id'=>'0','name'=>'全部项目'));
				$data['type']=array(array('id'=>'0','name'=>'全部类型'));
			}else{
        		$cr = new CDbCriteria;
				$where="check_state=2 and auth_state=931 and is_del=648 and gfid=".$param['visit_gfid'];
				$cr->condition=$where." and project_id>0";
				$cr->group='project_id';
		        $cr->select='project_id as id,project_name as name';
				$project=QualificationsPerson::model()->findAll($cr,array(),false);
	        	$no_limit=array('id'=>'0','name'=>'全部项目');
	            array_unshift($project,$no_limit);
				$data['project']=$project;
				
				$cr->condition=$where;
				$cr->group='qualification_type_id';
		        $cr->select='qualification_type_id as id,qualification_type as name';
				$type=QualificationsPerson::model()->findAll($cr,array(),false);
	        	$no_limit=array('id'=>'0','name'=>'全部类型');
	            array_unshift($type,$no_limit);
				$data['type']=$type;
			}
		}
        set_error($data,0,count($data['datas'])==0?'无相关记录':'获取成功',1);
    }
    
    /**
     * 获取服务者绑定单位/解除绑定详情
     * 
     * control 1-撤销申请；2-删除；3-同意绑定邀请；4-拒绝绑定邀请；5-申请解除；6-同意解除；7-拒绝解除；8-撤销解除,9-已拒绝（无操作）
     */
    public function actionServant_band_club_detail(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"请求失败");
		checkArray($param,"visit_gfid,invite_id",1);
        $cr = new CDbCriteria;
        $cr->condition=" id=".$param['invite_id'];
        $cr->select="club_id,invite_initiator,agree_club,invite_content as band_detail,ifnull(project_name,'') as project_name,type_name,uDate as apply_band_time,agree_club_time as band_time" .
        		",del_initiator,if_del,remove_type as unband_reason,remove_reason as unband_detail,if(if_del in(371,373),'',DATE_SUB(agree_club_time, INTERVAL -7 DAY)) as unband_autotime,agree_club_time";
        $invite=QualificationInvite::model()->find($cr,array(),false);
        if(empty($invite)){
        	set_error($data,1,'获取失败',1);
        }
        $datas=CommonTool::model()->ArrayNullToStr($invite,'');
        $datas['title']='绑定详情';
        $datas['right_control']='';
        $datas['right_url']='';
        $datas['unband_type']='';
		$datas['band_type']=($invite['invite_initiator']==501?'服务者申请':'单位邀请').'绑定';
		$datas['state_name']=$datas['band_type'].'-';
        switch($invite['agree_club']){
        	case 371:
		        $datas['state_name'].=$invite['invite_initiator']==501?'待审核':'待确认';
		        $datas['state_content']=$invite['invite_initiator']==501?'您已提交绑定申请，请等待单位审核确认':'请确认是否同意';
		        $datas['control']=$invite['invite_initiator']==501?'1':'3,4';
        	break;
        	case 373:
		        $datas['state_name'].=($invite['invite_initiator']==502?'服务者':'单位').'已拒绝';
		        $datas['state_content']=$invite['invite_initiator']==501?'单位已拒绝您的申请':'您已拒绝单位邀请';
		        $datas['control']='9,2';
        	break;
        	case 374:
		        $datas['state_name'].='已撤销';
		        $datas['state_content']=$invite['invite_initiator']==501?'您已撤销加入申请':'单位已撤销邀请';
		        $datas['control']='2';
        	break;
        	case 2:
				$datas['unband_type']=($invite['del_initiator']==501?'服务者':'单位').'绑定';
				$datas['state_name']=$datas['unband_type'].'-';
        		if(empty($invite['if_del'])||$invite['if_del']==374){
        			$datas['state_name']='已绑定';
		        	$datas['state_content']='服务者与单位绑定成功';
			        $datas['control']='5';
        		}elseif($datas['if_del']==371){
        			$datas['title']='解除详情';
			        $datas['state_name'].=$invite['del_initiator']==501?'待审核':'待确认';
			        $datas['state_content']=$invite['del_initiator']==501?'您已提交解除申请，请等待单位审核确认':'请确认是否同意';
			        $datas['control']=$invite['del_initiator']==501?'8':'6，7';
        			$datas['right_control']='解除说明';
        			$datas['right_url']='';
        		}elseif($datas['if_del']==373){
        			$datas['title']='解除详情';
        			$datas['state_name'].=($invite['del_initiator']==502?'服务者':'单位').'已拒绝';
		        	$datas['state_content']='如申请解除人未撤销申请，自申请之日起7日后视为自动解除';
			        $datas['control']=$invite['del_initiator']==501?'8':'';
        			$datas['right_control']='解除说明';
        			$datas['right_url']='';
        		}else{
        			$datas['state_name']='已解除';
		        	$datas['state_content']='服务者与单位已解除绑定';
			        $datas['control']='2';
        		}
        	
        	break;
        }
        
        $cr->condition="club_id=".$invite['club_id'];
        $cr->select="club_name,club_partnership_name";
        $club=QualificationClub::model()->find($cr,array(),false);
        $datas['club_name']=empty($club)?'':$club['club_name'];
        $datas['club_partnership_name']=empty($club)?'':$club['club_partnership_name'];
        
        $data['datas']=$datas;
        set_error($data,0,'获取成功',1);
    }
    
	/**
     * 服务者绑定单位／解除操作
     * control 1-撤销申请；2-删除；3-同意绑定邀请；4-拒绝绑定邀请；5-申请解除；6-同意解除；7-拒绝解除；8-撤销解除
     */
    public function actionServant_band_club_control(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"请求失败");
		checkArray($param,"visit_gfid,invite_id,control",1);
        $where="id=".$param['invite_id'];
		$iwhere="invite_id = ".$param['invite_id'];
        $servant=QualificationInvite::model()->find($where);
        if(empty($servant)){
        	set_error($data,1,'操作失败',1);
        }
        $control_str='操作';
        switch($param['control']){//agree_club,if_del
        	case 1:
        	$res=QualificationInvite::model()->updateAll(array('agree_club'=>374),$where);
        	$res=QualificationClub::model()->updateAll(array('state'=>449),$iwhere);
        	break;
        	case 2:
        	$res=QualificationInvite::model()->updateAll(array('is_del'=>649),$where);
        	break;
        	case 3:
        		$band_club=QualificationClub::model()->find($iwhere);
	        	if(empty($band_club)){
        			set_error($data,1,'操作失败',1);
	        	}
	        	if($band_club->club_partnership_type==642){
	        		$club=QualificationClub::model()->find('club_partnership_type=624 and state in(337,339,497) and qualification_person_id='.$servant['qualification_person_id']);
	        		if(!empty($club)){
	        			set_error($data,1,'操作失败',1);
	        		}
	        	}
        	$res=QualificationInvite::model()->updateAll(array('agree_club'=>2,'start_time'=>get_date()),$where);
        	$res=QualificationClub::model()->updateAll(array('state'=>337),$iwhere);
        	break;
        	case 4:
        	$res=QualificationInvite::model()->updateAll(array('agree_club'=>373),$where);
        	break;
        	case 5:
        	$res=QualificationInvite::model()->updateAll(array('del_initiator'=>501,'if_del'=>371,'remove_type'=>$param['unband_reason_type'],'remove_reason'=>$param['unband_detail'],'agree_club_time'=>get_date()),$where);
        	$res=QualificationClub::model()->updateAll(array('state'=>339),$iwhere);
        	break;
        	case 6:
        	$res=QualificationInvite::model()->updateAll(array('if_del'=>2,'end_time'=>get_date()),$where);
        	$res=QualificationClub::model()->updateAll(array('state'=>338),$iwhere);
        	break;
        	case 7:
        	$res=QualificationInvite::model()->updateAll(array('if_del'=>373),$where);
        	break;
        	case 8:
        	$res=QualificationInvite::model()->updateAll(array('if_del'=>374),$where);
        	$res=QualificationClub::model()->updateAll(array('state'=>337),$iwhere);
        	break;
        }
        set_error_tow($data,$res,0,$control_str.'成功',1,$control_str.'失败',1);
    }
    
    /**
     * 服务者绑定单位-查找单位
     * get_menu 1-获取单位类型、项目
     */
    public function actionSearch_club(){
        $param=decodeAskParams($_REQUEST,0);
		checkArray($param,"key",1);
		$data=ClubList::model()->getClubList($param);
		if(!empty($param['get_menu'])){
			$type=ClubServicerType::model()->getTypeData(array('member_type_id'=>'623,585'));
        	$no_limit=array('id'=>'0','name'=>'全部机构');
            array_unshift($type,$no_limit);
            $data['type_datas']=$type;
			$project=ProjectList::model()->getShowProject();
        	$no_limit=array('id'=>'0','name'=>'全部项目');
            array_unshift($project,$no_limit);
            $data['project_datas']=$project;
		}
        set_error($data,0,'获取成功',1);
    }
    
    /**
     * 服务者绑定单位-根据单位查询用户可绑定服务者（已绑定该单位的服务者不返回）
     */
    public function actionGet_can_band_servant(){
        $param=decodeAskParams($_REQUEST,0);
		checkArray($param,"visit_gfid,club_id",1);
		$data=get_error(1,"请求失败");
		
		$club=ClubList::model()->find('id='.$param['club_id']);
		if(empty($club)){
			set_error($data,1,'获取失败',1);
		}
        $cr = new CDbCriteria;
		$cr->condition='club_id='.$param['club_id']." and project_state in(1,506) and auth_state in(5,461) and state in(2,2)";
        $cr->select="project_id as id,project_name as name";
	    $project=ClubProject::model()->findAll($cr,array(),false);
	    if(count($project)==0){
	    	set_error($data,1,'获取失败',1);
	    }
	    $cproject_id='';
	    foreach($project as $k=>$v){
	    	$cproject_id.=(empty($cproject_id)?'':',').$v['id'];
	    }
	    
        $type_id=empty($param['type_id'])?'':$param['type_id'];
        $project_id=empty($param['project_id'])?'':$param['project_id'];
        
        $cr = new CDbCriteria;
		$where="t.check_state=2 and t.auth_state=931 and t.is_del=648 and t.gfid=".$param['visit_gfid'];
		$where.=' and qualification_club.club_id<>'.$param['club_id'];
		$where.=' and (t.project_id=0 or t.project_id in('.$cproject_id.')';
		$where=get_where($where,$type_id,"t.partnership_type",$type_id);
		$where=get_where($where,$project_id,"club_project.project_id",$project_id);
		$cr->condition=$where.' and qualification_club.club_id<>'.$param['club_id'];
		$cr->join=' left join qualification_club on t.id=qualification_club.qualification_person_id and qualification_club.state in(337,339,497,496,498)';
        $cr->select="t.id as servant_id,t.qualification_type_id as type_id,t.qualification_type as type_name,t.project_id as project_id，t.project_name as project_name";
        $cr->group='t.id';
	    if($club->partnership_type==642){//社区单位
	    	$cr->select.=",group_concat(distinct if(qualification_club.club_partnership_type=642,qualification_club.club_name,'')) as band_club_name,(case when qualification_club.state in(337,339,497) then '已绑定' when qualification_club.state in(498，496) then '绑定中' else '' end) as band_club_state_name";
	    }else{
	    	$cr->select.=",'' as band_club_name,'' as band_club_state_name";
	    }
         
	    $servant=QualificationsPerson::model()->findAll($cr,array(),false);
		if(count($servant)==0){
			$data['datas']=[];
			set_error($data,0,'获取成功',1);
		}
		
		if(!empty($param['get_menu'])){
			$cr->condition="check_state=2 and auth_state=931 and is_del=648 and gfid=".$param['visit_gfid'];
			$cr->join='';
        	$cr->select="qualification_type_id as id,qualification_type as name";
        	$cr->group='';
			$type=QualificationsPerson::model()->findAll($cr,array(),false);
        	$no_limit=array('id'=>'0','name'=>'全部类型');
            array_unshift($type,$no_limit);
            $data['type_datas']=$type;
        	$no_limit=array('id'=>'0','name'=>'全部项目');
            array_unshift($project,$no_limit);
            $data['project_datas']=$project;
		}
        set_error($data,0,'获取成功',1);
    }
    /**
     * 服务者申请绑定单位
     */
    public function actionServant_band_club(){
        $param=decodeAskParams($_REQUEST,0);
		checkArray($param,"visit_gfid,servant_id,club_id",1);
		$data=get_error(1,"请求失败");
		$club=ClubList::model()->find('id='.$param['club_id']);
		if(empty($club)){
			set_error($data,1,'请求失败',1);
		}
		$param['join']=1;
		$invite_data=QualificationInvite::model()->servantBand($param);
		if(count($invite_data['datas'])>0){
			$state=$invite_data['datas'][0]['state'];
			if($state!=338&&$state!=787&&$state!=449){
				set_error($data,0,'您已经申请加入该单位',1);
			}
		}
    	if($club->partnership_type==642){//社区单位
    		$joined_club=QualificationClub::model()->find('qualification_person_id='.$param['servant_id'].' and club_partnership_type=642 and state in(337,339,497)');
    		if(!empty($joined_club)){
    			set_error($data,1,'请求失败，服务者只能绑定一个社区单位，该服务者已经绑定其他社区单位',1);
    		}
    	}
    	$add=array('qualification_person_id'=>$param['servant_id'],'club_id'=>$param['club_id']);
    	$add_data=QualificationInvite::model()->addServantBandClub($add);
    	$data['invite_id']=$add_data['invite_id'];
    	set_error($data,$data['invite_id'],0,'请求成功',1,'请求失败',1);
    }
}

?>