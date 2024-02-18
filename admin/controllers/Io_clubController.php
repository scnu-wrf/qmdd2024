
<?php
class Io_clubController extends BaseController {
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
//         init();
    }

	/**
	 * 获取用户订阅服务机构列表
	 * 订阅表book_club，服务机构表club_list，服务机构项目表club_project，服务机构发布信息表club_release_information_record
	 * 只返回用户订阅了，且该服务机构至少有一个项目是正常的，并返回该服务机构最新发布信息
	 */
	public function actionGet_book_club(){
        $param=decodeAskParams($_REQUEST,1);
		$data=get_error(1,"获取失败");
		$gfid=$param['gfid'];
		$page=empty($param['page'])?0:$param['page'];
		$pageSize=empty($param['pageSize'])?0:$param['pageSize'];
        $path_www=getShowUrl('file_path_url');
        $cr = new CDbCriteria;
        $cr->condition='t.book_gfid= '.$gfid;
        $cr->join = " JOIN club_list as clublist on clublist.id=t.club_id " .
        		" left join club_project on club_project.club_id=t.club_id and club_project.project_state=506 and club_project.auth_state=461 and club_project.state=2";
        $cr->group='t.club_id';
        $cr->order = 't.id DESC';
        $cr->select="t.club_id,t.udate,clublist.club_name,clublist.club_logo_pic,clublist.book_club_num,min(case when clublist.clublist.unit_state=648 and clublist.state=2 and clublist.edit_state=2 and club_project.club_project.unit_state=648 then 0 else 1 end) as if_del";
        if($pageSize>0&&$page>0){
        	$cr->limit=$pageSize;
        	$cr->offset=($page - 1) * $pageSize;
        }
        $datas=BookClub::model()->findAll($cr,array(),false);
		$data["datas"] = $datas;
        foreach($datas as $k=>$v){
        	$data["datas"][$k]['club_logo_pic']=empty($v['club_logo_pic'])?"":($path_www.$v['club_logo_pic']);
	        $cr = new CDbCriteria;
	        $cr->condition='t.club_id= '.$v['club_id'];
	        $cr->order = 't.id DESC';
        	$cr->limit=1;
            $club_record=ClubReleaseInformationRecord::model()->find($cr);
        	$data["datas"][$k]['content']=empty($club_record)?'未发布信息':$club_record->news_title;
        }
		set_error_tow($data,1, 0, '获取成功',1,'获取失败',1);
    }

    /**
     * 个人提交社区单位入驻申请/修改
     */
    public function actionClub_apply_person(){
        $param=decodeAskParams($_REQUEST,0);
        checkArray($param,"visit_gfid,club_area_code,club_address,contact_phone,email,apply_id_card,contact_id_card_face,contact_id_card_back,project_id,apply_card_id,certificates,agree_rule",1);
        $param=CommonTool::model()->getKeyArray($param,'visit_gfid,club_area_code,club_address,contact_phone,email,apply_id_card,contact_id_card_face,contact_id_card_back,project_id,apply_card_id,certificates,recommend_clubcode,agree_rule',array('visit_gfid'=>'apply_club_gfid','project_id'=>'apply_project_id','agree_rule'=>'is_read'));
        $param['club_type']=8;
        $param['individual_enterprise']=403;
        $img_dir=getShowUrl('file_path_url');
        $param['contact_id_card_face']=CommonTool::model()->get_fullurl_name($img_dir,$param['contact_id_card_face']);
        $param['contact_id_card_back']=CommonTool::model()->get_fullurl_name($img_dir,$param['contact_id_card_back']);
        $param['partnership_type']=624;
        $data=ClubList::model()->addClubApply($param);
        set_error_tow($data,$data['error']==0,0,"提交申请成功",1,"提交申请失败",1);
    }
    
    /**
     * 单位提交社区单位入驻申请/修改
     */
    public function actionClub_apply_company(){
        $param=decodeAskParams($_REQUEST,0);
        checkArray($param,"visit_gfid,company,company_type_id,club_area_code,club_address,contact_phone,email,project_id,valid_until_start,certificates,agree_rule",1);
        $param=CommonTool::model()->getKeyArray($param,'visit_gfid,company,company_type_id,club_area_code,club_address,contact_phone,email,project_id,valid_until_start,valid_until,certificates,recommend_clubcode,agree_rule',array('visit_gfid'=>'apply_club_gfid','project_id'=>'apply_project_id','agree_rule'=>'is_read'));
        $param['club_type']=8;
        $param['individual_enterprise']=404;
        $data=ClubList::model()->addClubApply($param);
        set_error_tow($data,$data['error']==0,0,"提交申请成功",1,"提交申请失败",1);
    }
    
    /**
     * 获取社区单位入驻申请列表
     */
    public function actionGet_club_apply_list(){
        $param=decodeAskParams($_REQUEST,0);
        checkArray($param,"visit_gfid,state",1);
        $param['club_type']=8;
        $data=ClubList::model()->getApplyList($param);
        set_error($data,0,count($data['datas'])==0?'无相关记录':'获取成功',1);
    }
    /**
     * 单位提交战略伙伴入驻申请/修改
     */
    public function actionInstitution_apply(){
        $param=decodeAskParams($_REQUEST,0);
        checkArray($param,"visit_gfid,company,company_type_id,club_area_code,club_address,contact_phone,email,project_id,valid_until_start,certificates,agree_rule",1);
        $param=CommonTool::model()->getKeyArray($param,'visit_gfid,company,company_type_id,club_area_code,club_address,contact_phone,email,project_id,valid_until_start,valid_until,certificates,recommend_clubcode,agree_rule',array('visit_gfid'=>'apply_club_gfid','project_id'=>'apply_project_id','agree_rule'=>'is_read'));
        $param['club_type']=189;
        $param['individual_enterprise']=404;
        $data=ClubList::model()->addClubApply($param);
        set_error_tow($data,$data['error']==0,0,"提交申请成功",1,"提交申请失败",1);
    }
    /**
     * 获取战略伙伴入驻申请列表
     */
    public function actionGet_institution_apply_list(){
        $param=decodeAskParams($_REQUEST,0);
        checkArray($param,"visit_gfid,state",1);
        $param['club_type']=189;
        $data=ClubList::model()->getApplyList($param);
        set_error($data,0,count($data['datas'])==0?'无相关记录':'获取成功',1);
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
    public function actionGet_apply_detail(){
        $param=decodeAskParams($_REQUEST,0);
        checkArray($param,"visit_gfid,apply_id",1);
        $data=ClubList::model()->GetApplyDetail($param);
        set_error_tow($data,$data['error']==0,0,'获取服务者入驻申请详情成功',1,'获取入驻申请详情失败',1);
    }
    /**
     * 获取入驻申请资料
     */
    public function ActionGet_apply_info(){
        $param=decodeAskParams($_REQUEST,0);
        checkArray($param,"visit_gfid,apply_id",1);
        $cr = new CDbCriteria;
        $cr->condition="id=".$param['apply_id']." and apply_club_gfid=".$param['visit_gfid'];
        $club=ClubList::model()->find($cr,array(),false);
        $cr->condition='club_id='.$param['apply_id'];
        $cr->select='club_aualifications_pic';
        $clublistpic=ClubListPic::model()->find($cr,array(),false);
        $data=get_error(1,'');
        if(empty($club)){
            set_error($data,1,'该入驻申请不存在',1);
        }
        $img_dir=getShowUrl('file_path_url');
        $get_str='id,club_type,club_type_name,individual_enterprise,individual_enterprise_name,club_area_code,club_address,contact_phone,email,apply_project_id,recommend_clubcode,recommend_clubname,is_read';
        if($club['club_type']==8&&$club['individual_enterprise']==403){
            $datas=CommonTool::model()->getKeyArray($club,$get_str.',apply_id_card,contact_id_card_face,contact_id_card_back,apply_card_id,apply_card',array('apply_project_id'=>'project_id','is_read'=>'agree_rule','apply_card'=>'apply_card_id_name'));
            $datas['apply_id_card']=CommonTool::model()->HideKeyContent($datas['apply_id_card']);
            $datas['contact_id_card_back']=CommonTool::model()->url_path_name($img_dir,$datas['contact_id_card_back']);
            $datas['contact_id_card_face']=CommonTool::model()->url_path_name($img_dir,$datas['contact_id_card_face']);
        }else{
            $datas=CommonTool::model()->getKeyArray($club,$get_str.',company,company_type_id,company_type,valid_until_start,valid_until',array('company_type'=>'company_type_name','apply_project_id'=>'project_id','is_read'=>'agree_rule'));
        }
        $datas['club_area']=$club['club_area_province'].$club['club_area_city'].$club['club_area_district'];
        
        $datas['certificates']=empty($clublistpic)?'':CommonTool::model()->url_path_name($img_dir,$clublistpic['club_aualifications_pic']);
        
        $datas['contact_phone']=CommonTool::model()->HideKeyContent($datas['contact_phone']);
        $datas['email']=CommonTool::model()->HideKeyContent($datas['email']);
        $datas['project_name']='';
        if(!empty($datas['project_id'])){
            $cr->condition="id in(".$datas['project_id'].")";
            $cr->select='group_concat(project_name) as name';
            $project=ProjectList::model()->find($cr,array(),false);
            $datas['project_name']=empty($project)?'':$project['name'];
        }
        $data['datas']=$datas;
        set_error($data,0,'获取成功',1);
    }
    
    /**
     * 入驻申请操作
     * 意向入驻：提交-待审核--撤销申请，撤销-已撤销-删除，待修改-退回修改-修改资料、删除，未通过-审核未通过-删除，未通过-已注销-删除
     * 认证中：意向通过-待认证，待修改-退回修改，未通过-审核未通过-删除，未通过-已注销-删除
     * 认证通过：认证成功，认证成功-注销-删除
     * control 1-撤销申请 state=371，2-删除
     */
    public function ActionApply_control(){
        $param=decodeAskParams($_REQUEST,0);
        checkArray($param,"visit_gfid,apply_id,control",1);
        $data=ClubList::model()->ApplyControl($param);
        set_error($data,$data['error'],$data['msg'],1);
    }
}

?>