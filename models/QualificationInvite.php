<?php

class QualificationInvite extends BaseModel {

    public function tableName() {
        return '{{qualification_invite}}';//qualification_club
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
           'qualifications_person' => array(self::BELONGS_TO, 'QualificationsPerson',array('qualification_person_id' => 'id')),
		   'qualification_club' => array(self::BELONGS_TO, 'QualificationClub', 'invite_id'),
        );
    }


 public function rules() {
      $s1=$this->safeField();
   
        return array(
            array('qualification_person_id', 'required', 'message' => '{attribute} 不能为空'),
            // array('project_id', 'required', 'message' => '{attribute} 不能为空'),
           // array('', 'required', 'message' => '{attribute} 不能为空'),
            array($s1,'safe'), 
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
'invite_code'=> '邀请单编码',
'club_id'=>'社区id',
'qualification_person_id'=> '资质人',
'qualification_person_account'=> '资质人账号',
'qualification_name'=> '姓名',
'qualification_type'=> '类型',
'type_name'=> '类型',
'project_id'=>'项目id',
'project_name'=> '项目名称',
'initiator_name'=>'邀请者',
'invite_initiator'=>'邀请方发起者',
'invite_content' => '邀请内容',
'agree_club'=> '类型',
'uDate' => '邀请时间',
'start_time' => '加入社区日期',
'del_name'=> '解除发起',
'if_del'=> '解除状态',
'remove_type'=> '解除名称',
'remove_reason' => '解除原因',
'agree_club_time' => '发起解除时间',
'end_time' => '实际解除时间',
'phone'=> '联系电话',
'email'=> '电子邮箱',
'gfaccount'=> '帐号',
'qualification_name'=> '姓名',
'qualification_type_id'=>'类型',
'qualification_type'=>'类型',
'code_project'=> '项目',
'code_type'=> '类型编码',
'code_year'=> '年份',
'code_num'=>'编号',
'gf_code'=> '资质人编码',
'identity_num'=>'证书等级',
'qualification_title'=>'证书名',
'qualification_code'=>'证书编号',
'qualification_image'=>'证书扫描件',
'head_pic'=>'免冠头像',
'project_id'=>'项目',
'project_name'=>'项目名',
'process_id'=>'处理人id',
'process_account'=>'处理人account',
'process_nick'=>'处理人',
'check_state'=>'审核状态',
'check_state_name'=>'状态名称',
'reasons_for_failure'=>'未通过原因',
'qualification_time'=> '获得时间',
'synopsis'=>'个字简介',
'introduct'=>'资质人介绍',
'qualification_pic'=> '证书图片',
'qualification_level'=> '资质等级',
'level_name'=>'等级名称',
'qualification_score'=>'资质分',
'order_num'=>'订单号',
'is_pay'=>'支付状态',
'start_date'=> '资质期限开始',
'end_date'=> '资质期限结束',
'if_apply_display'=>'求职显示',

        );
    }
    public function getCode() {
        return array( 
            array('f_id' => '1','F_NAME' => '机构'),
            array('f_id' => '2','F_NAME' => '其他'),);
    }

   public function getProject($clubid) {
      return $this->findAll('club_id='.$clubid);
    }


    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * 服务者申请绑定单位
     * $param=array(qualification_person_id,club_id);
     * @return array(error,invite_id,band_id);
     */
    public function addServantBandClub($param){
    	$invite=new QualificationInvite();
		unset($invite->id);
		$invite->invite_initiator=501;
		$invite->agree_club=371;
		$res=$invite->insert($param);
		$data=array('error'=>1,'invite_id'=>0);
		if($res){
			$data['error']=0;
			$data['invite_id']=$invite->id;
			$band=QualificationClub::model()->find('qualification_person_id='.$param['qualification_person_id'].' and club_id='.$param['club_id']);
			if(empty($band)){
				$band=new QualificationClub();
				unset($band->id);
			}
			$band->invite_id=$invite->id;
			$band->state=496;
			$res=$band->insert($param);
			if($res){
				$data['band_id']=$band->id;
			}
		}
		return $data;
    }

    /**
     * 获取服务者绑定单位记录
     * state 337-在职 ；338-已退出if_del=1or if_del=2；339-申请退出if_del=0；496-申请绑定agree_club=0；497-解除中；498-邀请中；787系统解除
     * 绑定中：申请加入、单位已拒绝-已拒绝、撤销申请、单位邀请-同意/拒绝、单位已撤销、拒绝邀请-已拒绝、已绑定-查看
     * 解除中：服务者申请解除-待申请、单位拒绝解除-已拒绝、单位申请解除-同意/拒绝、服务者拒绝解除-已拒绝
     * 已解除：服务者已同意解除-已解除、单位已同意解除-已解除，系统解除-已解除
     * band_state:0-全部,1-绑定中，2-已绑定，3-解除中，4-已解除
     * join:0-历史记录,1-进行中记录（最近一条操作）
     * @return array('datas'=>$datas,'now_page'=>$page,'total_count'=>$total)
     */
    public function servantBand($param){
    	$param['visit_gfid']=empty($param['visit_gfid'])?0:$param['visit_gfid'];
    	$param['servant_id']=empty($param['servant_id'])?0:$param['servant_id'];
    	$param['club_id']=empty($param['club_id'])?0:$param['club_id'];
    	$param['type_id']=empty($param['type_id'])?0:$param['type_id'];
    	$param['project_id']=empty($param['project_id'])?0:$param['project_id'];
        $per_page = empty($param['per_page'])?20:$param['per_page'];
        $page=empty($param['page'])?1:$param['page'];
        $page_s = ($page-1)*$per_page;
        $band_state=empty($param['band_state'])?0:$param['band_state'];
        $where='t.is_del=648';
        switch($band_state){
        	case 1:
        		$where.=' and t.agree_club in(371,373,374)';
        	break;
        	case 2:
        		$where.=' and t.agree_club=2 and (t.if_del is null or t.if_del=374)';
        		$param['join']=1;
        	break;
        	case 3:
        		$where.=' and t.agree_club=2 and t.if_del in(371,373) and (UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(t.agree_club_time))<604800';
        		$param['join']=1;
        	break;
        	case 4:
        		$where.=' and t.agree_club=2 and (t.if_del=2 or (t.if_del in(371,373) and (UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(t.agree_club_time))>=604800))';
        	break;
        }
    	$where=get_where($where,$param['visit_gfid'],'qualification_club.gfid',$param['visit_gfid']);
    	$where=get_where($where,$param['servant_id'],'t.qualification_person_id',$param['servant_id']);
    	$where=get_where($where,$param['club_id'],'qualification_club.club_id',$param['club_id']);
    	$where=get_where($where,$param['type_id'],'t.qualification_type',$param['type_id']);
    	$where=get_where($where,$param['project_id'],'t.project_id',$param['project_id']);
        $cr = new CDbCriteria;
		$cr->condition=(empty($where)?'1=1':$where) ." limit ".$page_s.",".$per_page;
	    $control_name_sql="(case when t.invite_initiator=501 and t.agree_club=371 then '申请加入' " .
	    		"when t.invite_initiator=501 and t.agree_club=373 then '单位已拒绝' " .
	    		"when t.invite_initiator=501 and t.agree_club=374 then '撤销申请' " .
	    		"when t.invite_initiator=502 and t.agree_club=371 then '单位邀请' " .
	    		"when t.invite_initiator=502 and t.agree_club=373 then '已拒绝' " .
	    		"when t.invite_initiator=502 and t.agree_club=374 then '单位已撤销' " .
	    		"when t.del_initiator=501 and t.if_del=371 and (UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(t.agree_club_time))<604800 then '服务者申请解除' " .
	    		"when t.del_initiator=501 and t.if_del=373 and (UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(t.agree_club_time))<604800 then '单位拒绝解除' " .
	    		"when t.del_initiator=502 and t.if_del=371 and (UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(t.agree_club_time))<604800 then '单位申请解除' " .
	    		"when t.del_initiator=502 and t.if_del=373 and (UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(t.agree_club_time))<604800 then '服务者拒绝解除' " .
	    		"when t.del_initiator=501 and t.if_del=2 then '单位已同意解除' " .
	    		"when t.del_initiator=502 and t.if_del=2 then '服务者已同意解除' " .
	    		"when t.del_initiator=502 and (t.if_del in(371,373) and (UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(t.agree_club_time))>=604800) then '系统解除' " .
	    		"else '已绑定' end)";
     
	    $state_name_sql="(case when t.invite_initiator=501 and t.agree_club=371 then '待审核' " .
	    		"when t.invite_initiator=501 and t.agree_club=373 then '已拒绝' " .
	    		"when t.invite_initiator=501 and t.agree_club=374 then '已撤销' " .
	    		"when t.invite_initiator=502 and t.agree_club=371 then '同意/拒绝' " .
	    		"when t.invite_initiator=502 and t.agree_club=373 then '已拒绝' " .
	    		"when t.invite_initiator=502 and t.agree_club=374 then '已撤销' " .
	    		"when t.del_initiator=501 and t.if_del=371 and (UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(t.agree_club_time))<604800 then '待审核' " .
	    		"when t.del_initiator=501 and t.if_del=373 and (UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(t.agree_club_time))<604800 then '已拒绝' " .
	    		"when t.del_initiator=502 and t.if_del=371 and (UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(t.agree_club_time))<604800 then '同意/拒绝' " .
	    		"when t.del_initiator=502 and t.if_del=373 and (UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(t.agree_club_time))<604800 then '已拒绝' " .
	    		"when t.if_del=2 then '已解除' " .
	    		"when (t.if_del in(371,373) and (UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(t.agree_club_time))>=604800) then '已解除' " .
	    		"else '查看' end)";		
	    $can_del_sql="if(t.agree_club in(373,374) or t.if_del in(2,373) or (t.if_del in(371,373) and (UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(t.agree_club_time))>=604800),1,0)";
        $cr->select="t.id as invite_id,qualification_club.id as band_id,t.qualification_person_id as servant_id,qualification_club.club_id,qualification_club.club_name,qualification_club.club_partnership_name,ifnull(t.project_name,'') as project_name,t.type_name,qualification_club.state,".$control_name_sql." as control_name,(case when t.agree_club in(371,373,374) or t.if_del=374 then t.uDate else t.agree_club_time end) as control_time,".$state_name_sql." as state_name,if(t.if_del in(371,373),DATE_SUB(t.agree_club_time, INTERVAL -7 DAY),'') as unband_autotime,".$can_del_sql." as can_del";
        
	    $cr->join=' join qualification_club on qualification_club.club_id=t.club_id and qualification_club.qualification_person_id=t.qualification_person_id';
	    $cr->join.=empty($param['join'])?'':' and qualification_club.invite_id=t.id';
        $datas=$this->findAll($cr,array(),false);
        $data=array('datas'=>$datas,'now_page'=>$page);
        if($page==1){
			$cr->condition=empty($where)?'1=1':$where;
	        $cr->select='t.id';
	        $total=$this->count($cr,array());
			$data['total_count']=$total;
        }
        return $data;
    }
    
    
}
