<?php
class Io_serviceController extends BaseController {
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }


	/**
	 * 获取动动约类型接口
	 */
    public function actionGet_service_type() {
        $data=get_error(1,"");
        $param=decodeAskParams($_REQUEST,0);
        $device_type=empty($param['device_type'])?5:$param['device_type']; 
		$img_param=$device_type==7?"tn_web_icon":"tn_icon";
        $img_click_param=$device_type==7?"tn_web_click_icon":"tn_click_icon";

        $qType=QmddServerUsertype::model()->findAll('display=649');
        $list=array();
        $path_www=getShowUrl('file_path_url');
        foreach($qType as $index=>$v){
            $list[$index]['id']=$v->id;
            $list[$index]['tn_image']=$path_www.$v[$img_param];
            $list[$index]['tn_image_clicked']=$path_www.$v[$img_click_param];
            $list[$index]['name']=$v->f_uname;
            $list[$index]['f_member_type']=$v->f_member_type;
            $list[$index]['server_type']=$v->t_server_type_id;
            $list[$index]['service_type']=$v->service_type;
        }
        $no_limit=array('id'=>'-1','name'=>'不限');
        
		for($i=0,$s=count($list);$i<$s;$i++){
			if(empty($list[$i]['service_type'])&&$list[$i]['server_type']!=1){
                if($list[$i]['server_type']!=3){
                    $list[$i]['level_datas']=array($no_limit);
                }else{
                    $list[$i]['level_datas']=array();
                }
				continue;
            }
            if($list[$i]['server_type']==1){//场地
            	$level_datas=ServicerLevel::model()->findAll('type=1157 and if_del=510');
            }else{
            	$level_datas=ServicerLevel::model()->findAll('type=501 and member_second_id='.$list[$i]['service_type']);
            }
            $level_datas=cArray($level_datas,'id,card_name as name,card_level_logo as logo');
            array_unshift($level_datas,$no_limit);
			$list[$i]['level_datas']=$level_datas;
        }
		$data['datas']=$list;
		
        //param_datas约起业务，已废弃
//        $s1 = 'id,name';
//        $s2 = AutoFilterSet::model()->findAll('fater_id=68 and id order by (case when id=75 then 0 else id end)');
//        $service_time_datas = toArray($s2,$s1);
//
//        $site_envir_datas = BaseCode::model()->findAll('fater_id=667');
//        $site_envir_datas=cArray($site_envir_datas,'f_id as id,F_NAME as name');
//        array_unshift($site_envir_datas,$no_limit);
//        
//        $site_facilities_datas=AutoFilterSet::model()->findAll('fater_id=226');
//        $site_facilities_datas=cArray($site_facilities_datas);
//        array_unshift($site_facilities_datas,$no_limit);
//        
//        $sex_datas=array($no_limit,array('id'=>'1','name'=>'女'),array('id'=>'2','name'=>'男'));
//		$data['param_datas']=array();
//		$data['param_datas'][0]=array('param'=>'start_time','title'=>'开始时间');
//		$data['param_datas'][1]=array('param'=>'end_time','title'=>'结束时间');
//		$data['param_datas'][2]=array('param'=>'service_time','title'=>'服务时长','param_datas'=>$service_time_datas);
//		$data['param_datas'][3]=array('param'=>'area','title'=>'区域');
//		$data['param_datas'][4]=array('param'=>'project_id','title'=>'项目');
//		$data['param_datas'][5]=array('param'=>'type_code','title'=>'类别');
//		$data['param_datas'][6]=array('param'=>'level_code','title'=>'级别');
//		$data['param_datas'][7]=array('param'=>'site_envir','title'=>'场地环境','param_datas'=>$site_envir_datas,'hide_type_id'=>'2');
//		$data['param_datas'][8]=array('param'=>'site_facilities','title'=>'场地设施','param_datas'=>$site_facilities_datas,'hide_type_id'=>'2');
//		$data['param_datas'][9]=array('param'=>'sex','title'=>'性别','param_datas'=>$sex_datas,'hide_type_id'=>'1,3');
//		$data['param_datas'][10]=array('param'=>'age','title'=>'年龄范围','hide_type_id'=>'1,3');
		set_error_tow($data,count($list),0,"拉取成功",1,"拉取失败",1);
        
    }

	/**
	 * 获取近期待签到服务单个数
	 */
	public function actionGet_service_singular(){
        $data=get_error(1,"");
        $param=decodeAskParams($_REQUEST,1);
        $gfid=$param['gfid'];     //预订人gfid
        $count=GfServiceData::model()->count('order_type=353 and gfid='.$gfid.' and state=2 and is_show=649 and is_pay=464 and isNull(sign_come) and servic_time_end>now()');
        $data['count']=$count;
		set_error_tow($data,$count,0,"成功",1,"失败",1);
    }

	/**
	 * 获取近期待签到服务单列表
	 */
	public function actionGet_service_list(){
        $data=get_error(1,"");
        $param=decodeAskParams($_REQUEST,1);
        $gfid=$param['gfid'];     //预订人gfid
        $date=empty($param['date'])?'':$param['date'];     //不填返回所有
        $path_www=getShowUrl('file_path_url');

        $cr = new CDbCriteria;
        $cr->condition='order_type=353 and gfid='.$gfid.' and state=2 and is_show=649 and is_pay=464 and isNull(sign_come) and servic_time_end>now()';
        if ($date != '') {
            $cr->condition.=' and left(service_data_name,10)="' . $date . '"';
        }
        $cr->order = 'servic_time_star';
        $lists=GfServiceData::model()->findAll($cr);
        $s1='id,order_num,info_order_num,project_id,project_name,service_id,service_ico,service_name,service_data_id,service_data_name,servic_time_star,servic_time_end,sign_code';
        $list=toArray($lists,$s1);
        $datas=$list;
        foreach($lists as $i=>$d){
            $datas[$i]['service_ico']=$path_www.$d->service_ico;
            if(!empty($d->t_stypeid))$usertype=QmddServerUsertype::model()->find('id='.$d->t_stypeid);      
            $datas[$i]['t_typeid']=empty($usertype)?'':$usertype->t_server_type_id;
            $datas[$i]['t_typename']=empty($usertype)?'':$usertype->t_name;
            $datas[$i]['t_stypeid']=$d->t_stypeid;
            $datas[$i]['t_stypename']=$d->t_stypename;
            $setList=QmddServerSetList::model()->find('id='.$d->qmdd_server_set_list_id);
            $datas[$i]['site_type']=empty($setList)?'':$setList->site_type;
            if(!empty($setList->site_type)&&$setList->site_type>0)$site_type=BaseCode::model()->find('f_id='.$setList->site_type);
            $datas[$i]['site_type_name']=empty($site_type)?'':$site_type->F_NAME;
            $datas[$i]['buy_price']=$d->buy_price*$d->buy_count-$d->free_money;
        };
		$data=array('error'=>1,'msg'=>'fail');
		$data['datas']=$datas;
		set_error_tow($data,count($datas),0,"拉取数据成功",0,"无数据",1);
    }

	/**
	 * 获取动动约列表接口 ，可根据发布单位、类型、项目、服务时间段、区域、等级（场地、服务者）、关键字模糊查找（标题、项目、等级、发布单位）
	 * 目前仅实现了场地、服务者类型数据拉取
	 * 场地信息根据场馆来获取，服务者信息根据登记服务者来获取
	 */
	public function actionServiceList(){
        $data=get_error(1,"");
        $param=decodeAskParams($_REQUEST,0);
		$club_id=!empty($param['club_id'])&&$param['club_id']>0?$param['club_id']:'';       //单位查询
        $type_code=$param['type_code'];   //资源类型查询
		$project_id=$param['project_id']; //项目查询
		$start_time=$param['start_time']; //开始时间查询
		$end_time=$param['end_time'];     //结束时间查询
		$keywords=empty($param['key'])?'':$param['key'];          //关键字查询
		$area=empty($param['area'])?'':$param['area'];          //地区查询
//		$longitude=empty($param['longitude'])?'':$param['longitude'];          //经度查询
//		$latitude=empty($param['latitude'])?'':$param['latitude'];          //纬度查询
		// $orderby=$param['orderby'];       //排序
        $page=empty($param['page'])||$param['page']<1?1:$param['page']; //第几页
        $_GET['page']=$page;
        $pageSize=empty($param['pageSize'])?0:$param['pageSize'];       //每页条数
        $path_www=getShowUrl('file_path_url');

        $type=QmddServerUsertype::model()->find('id='.$type_code);
        $cr = new CDbCriteria;
        $cr->condition='t.t.f_check=2 and t.if_user=649';
        $cr->condition=get_where($cr->condition,!empty($club_id),'t.club_id',$club_id,'');
        $cr->condition=get_where($cr->condition,!empty($type_code),'t.t_stypeid',$type_code,'');
        
        if($type->t_server_type_id==1){
            $cr->join = "JOIN qmdd_server_set_data t2 on t.t_stypeid=t2.t_stypeid and !isNull(t.site_id) and t.site_id>0 and t2.site_id=t.site_id and t2.down=0";
        }elseif($type->t_server_type_id==2){
            $cr->join = "JOIN qmdd_server_set_data t2 on t.t_stypeid=t2.t_stypeid and  t2.server_sourcer_id=t.server_sourcer_id and t2.down=0";
        }
        if ($start_time != '') {
            $cr->condition.=' AND t2.s_timestar>="' . $start_time . '"';
        }
        if ($end_time != '') {
            $cr->condition.=' AND t2.s_timeend<="' . $end_time . '"';
        }
        if(!empty($project_id)){
            $cr->condition.=' and find_in_set("'.$project_id.'",t.project_ids)';
        }
        $cr->condition=get_like($cr->condition,'t.s_name,t.project_ids,t.s_levelname,t.club_name',$keywords,'');
        $cr->condition=get_like($cr->condition,'t2.area_location',$area,'');
//		$p1=pi()/180.00;
//		$ps1=SIN($latitude*$p1);
//	    $pc1=SIN($latitude*$p1);
//	    $pc1=COS($latitude*$p1);
//        $disct_sql=$longitude<0||$latitude<0?0:"(6378137.0*ACOS({$ps1}*SIN(t2.latitude*{$p1})+{$pc1}*COS(t2.latitude*{$p1})*COS(({$longitude}-t2.longitude)*{$p1})))";
//        $cr->order = $disct_sql.' desc';

//		$cr->order = 't.id desc';//是否影响查询速度
        $cr->group='t.server_sourcer_id';
        if($type->t_server_type_id==1){
            $cr->group = 't.site_id';
        }
        $count = QmddServerSetList::model()->count($cr);
        $pages = new CPagination($count);
        $pages->pageSize = $pageSize;
        $pages->applylimit($cr);
        
//		$cr->join .= " LEFT JOIN qmdd_server_sourcer t3 on t3.id=t.server_sourcer_id";
        $cr->select="t.id,t.info_id,t.server_sourcer_id,t.site_id,t.t_typeid,t.s_name,t.t_stypeid,t.club_id,t.club_name,group_concat(distinct t.project_ids) as project_ids,min(t2.sale_price) as min_price,max(t2.sale_price) as max_price";//,t3.area,t3.Longitude,t3.latitude,t3.logo_pic,t3.server_name,t3.project_ids,t3.s_levelid,t3.s_levelname,t3.s_level_logo,t3.site_name,t3.s_name_id
       
        $list=QmddServerSetList::model()->findAll($cr,array(),false);
        $datas=array();
        $pcr = new CDbCriteria;
        foreach($list as $i=>$v){
            $sourcer=QmddServerSourcer::model()->find('id='.$v['server_sourcer_id']);
            if(empty($sourcer)){
            	$v['area']='';
            	$v['Longitude']='';
            	$v['latitude']='';
            	$v['logo_pic']='';
            	$v['server_name']='';
            	$v['project_ids']='';
            	$v['s_levelid']='';
            	$v['s_levelname']='';
            	$v['s_level_logo']='';
            	$v['site_name']='';
            	$v['s_name_id']='';
            }else{
            	$v['area']=$sourcer->area;
            	$v['Longitude']=$sourcer->Longitude;
            	$v['latitude']=$sourcer->latitude;
            	$v['logo_pic']=$sourcer->logo_pic;
            	$v['server_name']=$sourcer->server_name;
            	$v['project_ids']=$sourcer->project_ids;
            	$v['s_levelid']=$sourcer->s_levelid;
            	$v['s_levelname']=$sourcer->s_levelname;
            	$v['s_level_logo']=$sourcer->s_level_logo;
            	$v['site_name']=$sourcer->site_name;
            	$v['s_name_id']=$sourcer->s_name_id;
            }
//            if($type->t_server_type_id==1){
//                $set_data = QmddServerSetData::model()->findAll('info_id='.$v['info_id']);
//            }elseif($type->t_server_type_id==2){
//                $set_data = QmddServerSetData::model()->findAll('list_id='.$v['id']);
//            }
//            $min=0.00;$max=0.00;
//            if(!empty($set_data)){
//                $min=$set_data[0]->sale_price;
//                $max=$set_data[0]->sale_price;
//
//                foreach($set_data as $index=>$h){
//                    if($min>$set_data[$index]->sale_price){
//                        $min = $set_data[$index]->sale_price;
//                    }
//                    if($max<$set_data[$index]->sale_price){
//                        $max = $set_data[$index]->sale_price;
//                    }
//                }
//            }
            if($v['t_typeid']==1){//场地
                $site=GfSite::model()->find('id='.$v['site_id']);
                $datas[$i]['id']=$v['site_id'];
                $datas[$i]['logo_pic']=!empty($site)?$path_www.$site->site_pic:'';
                $datas[$i]['s_name']=!empty($site)?$site->site_name:'';

	            $gProjectId='';
	            $gProjectNmae='';
				if(!empty($v['project_ids'])){
					$pcr->condition="id in(".$v['project_ids'].")";
					$pcr->select="group_concat(distinct id) as ids,group_concat(distinct project_name) as name";
					$pn=ProjectList::model()->find($pcr,array(),false);
					$gProjectId=$v['project_ids'];//empty($pn)?'':$pn['ids'];
					$gProjectNmae=empty($pn)?'':$pn['name'];
				}
				
                $datas[$i]['project_id']=rtrim($gProjectId, ',');
                $datas[$i]['project_name']=rtrim($gProjectNmae, ',');
                $datas[$i]['level']=!empty($site)?$site->site_level:'';
                $datas[$i]['level_name']=!empty($site)?$site->site_level_name:'';
                $datas[$i]['level_logo']=!empty($site)?$path_www.$site->site_level_logo:'';
            	$datas[$i]['content_html']='<b>'.$datas[$i]['s_name']."</b><br/><font color=\"#ff7e00\">".$datas[$i]['level_name']."</font>"."<br/><font color=\"#808080\">".$datas[$i]['project_name'];
            }elseif($v['t_typeid']==2){
            	if(!empty($v['s_name_id']))$person=QmddServerPerson::model()->find('id='.$v['s_name_id']);
                $datas[$i]['id']=$v['server_sourcer_id'];
                $datas[$i]['logo_pic']=!empty($v['logo_pic'])?$path_www.$v['logo_pic']:'';
                $datas[$i]['s_name']=!empty($v['s_name'])?$v['s_name']:'';
                $datas[$i]['project_id']=!empty($v['project_ids'])?$v['project_ids']:'';
                $datas[$i]['project_name']=!empty($person)&&!empty($person->project_name)?$person->project_name:'';
                $datas[$i]['level']=!empty($v['s_levelid'])?$v['s_levelid']:'';
                $datas[$i]['level_name']=!empty($v['s_levelname'])?$v['s_levelname']:'';
                $datas[$i]['level_logo']=!empty($v['s_level_logo'])?$path_www.$v['s_level_logo']:'';
            	$datas[$i]['content_html']='<b>'.$datas[$i]['s_name']."</b><br/><font color=\"#ff7e00\">".$datas[$i]['project_name'].(empty($datas[$i]['project_name'])?'':' ').(!empty($person)?$person->qualification_title.'/':'').$datas[$i]['level_name']."</font>"."<br/><font color=\"#808080\">".(!empty($v['site_name'])?$v['site_name']:'');
            }
            $datas[$i]['area']=!empty($v['area'])?$v['area']:'';
            $datas[$i]['Longitude']=!empty($v['Longitude'])?$v['Longitude']:'';
            $datas[$i]['latitude']=!empty($v['latitude'])?$v['latitude']:'';
            $datas[$i]['min_price']=$v['min_price'];//$min;
            $datas[$i]['max_price']=$v['max_price'];//$max;
            $datas[$i]['t_typeid']=$v['t_typeid'];
            $datas[$i]['t_stypeid']=$v['t_stypeid'];
            $datas[$i]['sourcer_id']=$v['server_sourcer_id'];
            $datas[$i]['club_id']=$v['club_id'];
            $datas[$i]['club_name']=$v['club_name'];
            $datas[$i]['content_html'].='<br/>'.$datas[$i]['area']."</font>";
        }
		$data['datas']=$datas;
		$data['totalCount']=$pages->getItemCount();
		$data['now_page']=$page;
		set_error_tow($data,$pages->getItemCount(),0,"拉取数据成功",0,"无数据",1);
    }

	/**
	 * 获取动动约服务详情,根据类型+id 获取
	 */
	public function actionGet_service_nav_detail(){
        $data=get_error(1,"");
        $param=decodeAskParams($_REQUEST,0);
        $id=$param['id'];   //ServiceList的id
        $gfid=$param['gfid'];   //gfid
        $t_typeid=$param['t_typeid'];   //ServiceList的t_typeid
        $site_type=empty($param['site_type'])?'':$param['site_type']; //场地类型 1518=单场，1519=半场，1520=全场

        $path_www=getShowUrl('file_path_url');

        $project_list=array();
        $cr = new CDbCriteria;
        $cr->condition='f_check=2 and if_user=649 and s_timestar>now()';
        // $cr->condition='(1=1)';
        if($t_typeid==1){
            $cr->condition.=' and site_id='.$id;
            
            $site=GfSite::model()->find('id='.$id);
            $club_id=$site->user_club_id;   //club_id
            $cl = new CDbCriteria;
            $cl->condition='t_typeid=1 and f_check=2 and if_user=649 and site_id='.$id;
            $cl->condition=get_where($cl->condition,!empty($t_typeid),'t_typeid',$t_typeid,'');
            $cl->order = 'id DESC';
            $list=QmddServerSetList::model()->findAll($cl);
            $list=cArray($list,'id as list_id,s_name');
            
            if(!empty($site))$gProject=GfSiteProject::model()->findAll('site_id='.$site->id);
            $gProjectId='';
            if(!empty($gProject))foreach($gProject as $g){
                $gProjectId.=$g->project_id.',';
            }
            if(!empty($gProjectId))$project_list=ProjectList::model()->findAll('id in('.rtrim($gProjectId, ',').')');
        }elseif($t_typeid==2){
            $cr->condition.=' and server_sourcer_id='.$id;
            
            $list=QmddServerSetList::model()->find('server_sourcer_id='.$id);
            $club_id=$list->club_id;   //club_id
            if(!empty($list))$sourcer=QmddServerSourcer::model()->find('id='.$list->server_sourcer_id);
            if(!empty($sourcer))$person=QmddServerPerson::model()->find('id='.$sourcer->s_name_id);
            if(!empty($person))$per=QualificationsPerson::model()->find('id='.$person->qualificate_id);
            
            if(!empty($list))$project_list=ProjectList::model()->findAll('id in('.$list->project_ids.')');
        }
        $cr->condition=get_where($cr->condition,!empty($t_typeid),'t_typeid',$t_typeid,'');
        $cr->condition.=' and down=0';
        $cr->order = 'id DESC';
        $cr->group = 's_date';
        $cr->select = 's_date,t_typename,t_stypename';
        $s_data = QmddServerSetData::model()->findAll($cr);
        
        $stime = QmddServerTime::model()->findAll('state=2');
        $stime=toArray($stime,'id,timename');

        $project_list=toArray($project_list,'id,project_name');
        $collect_news_type=1522;//动动约类型对应的订阅类型id=1522-服务者,1523-场地,1524-约赛，1525-约练
        if($t_typeid==1){
        	$collect_news_type=1523;
        	//获取该场馆可预订的场地类型
	            $ct = new CDbCriteria;
                $ct->group = 'site_type';
            foreach($project_list as $in=>$p){
	            $ct->condition='t_typeid=1 and down=0 and f_check=2 and if_user=649 and site_id='.$id.' and find_in_set("'.$p['id'].'",t.project_ids)';
                $site_type = QmddServerSetData::model()->findAll($ct);
                $site_type=toArray($site_type,'site_type');
                foreach($site_type as $si=>$s){
                	if(!empty($s['site_type'])){
                		$s_type=BaseCode::model()->find('f_id='.$s['site_type']);
                    	$site_type[$si]['site_type_name']=empty($s_type)?'':$s_type->F_NAME;
                	}
                }
                $project_list[$in]['site_type']=$site_type;
            }
        }

        $data=array('error'=>1,'msg'=>'fail','collect_type'=>$collect_news_type,'order_type'=>353,'order_type_name'=>'动动约','t_typename'=>!empty($s_data)?$s_data[0]->t_typename:'','t_stypename'=>!empty($s_data)?$s_data[0]->t_stypename:'');

		//是否订阅该服务，0-否，1-是
        $data['is_subscribe']=PersonalSubscription::model()->isSubscription(array('news_type'=>$collect_news_type,'news_id'=>$id,'gfid'=>$gfid));
        //是否订阅该服务的发布单位，0-否，1-是
        $data['is_book_club']=BookClub::model()->isBook(array('club_id'=>$club_id,'gfid'=>$gfid));
        
        if($t_typeid==1){
            $data['loge']=!empty($site)?$path_www.$site->site_pic:'';
            $data['slide']=!empty($site)?$site->site_scroll:'';
            $data['name']=!empty($site)?$site->site_name:'';
            $data['address']=!empty($site)?$site->site_address:'';
            $data['latitude']=!empty($site)?$site->site_latitude:'';
            $data['Longitude']=!empty($site)?$site->site_longitude:'';
            $data['phone']=!empty($site)?$site->contact_phone:'';
            $data['club_id']=!empty($site)?$site->user_club_id:'';
            $data['club_name']=!empty($site)?$site->user_club_name:'';
            $data['levelid']=!empty($site)?$site->site_level:'';
            $data['levelname']=!empty($site)?$site->site_level_name:'';
            $data['level_logo']=!empty($site)?$path_www.$site->site_level_logo:'';
            $data['site_envir']=!empty($site)?$site->site_envir:'';
            $data['site_envir_name']='';
            if(!empty($site)){
            	$base_code=BaseCode::model()->findAll('f_id in('.$site->site_envir.')');
            	$site_envir=toArray($base_code,'F_NAME');
            	foreach($site_envir as $sek=>$sev){
            		$data['site_envir_name'].=(empty($data['site_envir_name'])?'':' ').$sev['F_NAME'];
            	}
            }
			$basepath = BasePath::model()->getPath(171);
            $data['introduct_temp']=!empty($site)?get_html($basepath->F_WWWPATH.$site->site_description, $basepath):'';
            $facility=array();
            if(!empty($site))$facility=GfSiteCredit::model()->findAll('id in('.$site->site_facilities.')');
            $facility=toArray($facility,'id,item_name,facilities_name,facilities_pic');
//            $facility=toArray($facility,'id as id,item_name as item_name,facilities_name as name,facilities_pic as logo');
            $data['facility']=$facility;
            $data['site_list']=$list;
            $data['describe_html']="场馆：".$data['name']."<br/>地区：".$data['address']."<br/>电话：".$data['phone']."<br/>等级：".(empty($data['level_logo'])?'':("<img src=\"".$data['level_logo']."\"/>  "))."<font color=\"#ff7e00\">".$data['levelname']."</font><br/><b>环境：".$data['site_envir_name'].'</b>';
        }elseif($t_typeid==2){
            $data['loge']=!empty($sourcer)?$path_www.$sourcer->logo_pic:'';
            $data['slide']=!empty($sourcer)?$sourcer->s_picture:'';
            $data['name']=(!empty($sourcer)?$sourcer->s_name:'');
            $data['site_name']=!empty($person)?$person->servic_site_name:'';
            $data['address']=!empty($sourcer)?$sourcer->area:'';
            $data['latitude']=!empty($sourcer)?$sourcer->latitude:'';
            $data['Longitude']=!empty($sourcer)?$sourcer->Longitude:'';
            $data['phone']=!empty($sourcer)?$sourcer->contact_number:'';
            $data['club_id']=!empty($person)?$person->club_id:'';
            $data['club_name']=!empty($person)?$person->club_name:'';
            $data['levelid']=!empty($sourcer)?$sourcer->s_levelid:'';
            $data['levelname']=(!empty($person)?$person->qualification_title.'/':'').(!empty($sourcer)?$sourcer->s_levelname:'');
            $data['level_logo']=!empty($sourcer)?$path_www.$sourcer->s_level_logo:'';
            $data['identity_type']=!empty($per)?$per->identity_type:'';
            $data['identity_type_name']=!empty($per)?$per->identity_type_name:'';
            $data['identity_num']=!empty($per)?$per->identity_num:'';
            $data['identity_title']=!empty($per)?$per->qualification_title:'';
			$basepath = BasePath::model()->getPath(269);
            $data['introduct_temp']=empty($person->introduct)?'':get_html($basepath->F_WWWPATH.$person->introduct, $basepath);
            $qualification_project=!empty($person)&&!empty($person->project_name)?"<br/>服务项目：".$person->project_name:'';
            $data['describe_html']="服务者：".$data['name'].'        '.(!empty($person)?$person->qualification_type:'').$qualification_project."<br/>驻场场馆：".$data['site_name']."<br/>场馆地址：".(!empty($person)?$person->area_address:'')."<br/>场馆电话：".(!empty($person)?$person->phone:'')."<br/>资质等级：<font color=\"#ff7e00\">".$data['levelname']."</font>";
        }
		$data['project_list']=$project_list;
        $data['stime_datas']=$stime;
        /**
         * 1.预订规则：
场地：仅能在同一项目同一场地类型同一日期下选择场地时段，最多只可预订4个时段。
服务者：仅能在同一项目同一日期下选择服务时段，最多只可预订4个时段。
 超出4个时段时文本提示“最多只可选择4个时段”
         */
        $data['sel_max']=4;
        $data['sel_max_notify']='最多只可选择4个时段';
        
        //发布了预订服务的日期，前端用于标记
        $start_date=0;$end_date=0;
        if(!empty($s_data)){
            $start_date=$s_data[0]->s_date;
            $end_date=$s_data[0]->s_date;
        }
        $data['show_date']=array();
        $dmap=array();
        $di=0;
        foreach($s_data as $i=>$h){
        	if(empty($dmap[$h['s_date']])){
	        	$data['show_date'][$di]=$h['s_date'];
	        	$dmap[$h['s_date']]=$di;
	        	$di++;
        	}
            if($start_date>$s_data[$i]->s_date){
                $start_date = $s_data[$i]->s_date;
            }
            if($end_date<$s_data[$i]->s_date){
                $end_date = $s_data[$i]->s_date;
            }
        }
		$data['start_date']=$start_date;
		$data['end_date']=$end_date;
        
	    set_error_tow($data,count($data),0,"拉取数据成功",0,"拉取数据成功",1);
    }

	/**
	 * 获取动动约服务资源，根据类型+id，日期、项目、场地类型获取发布的服务时间段及价格、预订状态
	 */
	public function actionGet_service_source(){
        $data=get_error(1,"");
        $param=decodeAskParams($_REQUEST,0);
        $id=$param['id'];   //ServiceList的id
        $gfid=$param['gfid'];   //gfid
        $t_typeid=$param['t_typeid'];   //ServiceList的t_typeid
		$server_date=empty($param['server_date'])?date('Y-m-d'):(strlen($param['server_date'])>10?date('Y-m-d',strtotime($param['server_date'])):$param['server_date']); //服务日期
		$project_id=empty($param['project_id'])?'':$param['project_id']; //项目id
        $site_type=empty($param['site_type'])?'':$param['site_type']; //场地类型 1518=单场，1519=半场，1520=全场

        $cr = new CDbCriteria;
        $cr->condition='f_check=2 and if_user=649 and t_typeid='.$t_typeid;
        if($t_typeid==1){
            $cr->condition.=' and site_id='.$id;
            $cl = new CDbCriteria;
            $cl->condition='f_check=2 and if_user=649 and site_id='.$id;
            if ($server_date != '') {
                $cl->condition.=' and star_time<="' . $server_date . '"';
                $cl->condition.=' and end_time>="' . $server_date . '"';
            }
            if(!empty($project_id)){
                $cl->condition.=' and find_in_set("'.$project_id.'",t.project_ids)';
            }
            $cl->condition=get_where($cl->condition,!empty($t_typeid),'t_typeid',$t_typeid,'');
            $cl->condition=get_where($cl->condition,!empty($site_type),'site_type',$site_type,'');
            $cl->order = 'id DESC';
            
        }elseif($t_typeid==2){
            $cr->condition.=' and server_sourcer_id='.$id;
        }
        if(!empty($project_id)){
            $cr->condition.=' and find_in_set("'.$project_id.'",t.project_ids)';
        }
        $cr->condition.=' and down=0';  
        $cr->condition=get_where($cr->condition,!empty($t_typeid),'t_typeid',$t_typeid,'');
        $cr->condition=get_where($cr->condition,!empty($site_type),'site_type',$site_type,'');
        $cr->order = 'id DESC';
        if ($server_date != '') {
            $cr->condition.=' and s_date="' . $server_date . '"';
        }
        
        $set_data = QmddServerSetData::model()->findAll($cr);
        $s2='id,info_id,list_id,site_id,server_sourcer_id,t_typeid,t_typename,t_stypeid,t_stypename,s_code,s_name,s_timename,s_timestar,s_timeend,s_date,s_gfid,s_gfaccount,s_gfname,sale_price,club_id,club_name,project_ids,order_project_id,order_project_name,order_gfid,order_account,order_name,order_date,is_conflict';
        $set_data=toArray($set_data,$s2);
        
        $data=array('error'=>1,'msg'=>'fail');
		$data['datas']=$set_data;
        
	    set_error_tow($data,count($set_data),0,"拉取数据成功",0,"拉取数据成功",1);
    }
    
	/**
	 * 获取动动约详情接口，废弃，根据2020年10月业务调整后该接口不符合业务需求
	 */
	public function actionNew_service_detail(){
        $data=get_error(1,"");
        $param=decodeAskParams($_REQUEST,0);
        $id=$param['id'];   //ServiceList的id
        $gfid=$param['gfid'];   //gfid
        $t_typeid=$param['t_typeid'];   //ServiceList的t_typeid
		$server_date=empty($param['server_date'])?date('Y-m-d'):(strlen($param['server_date'])>10?date('Y-m-d',strtotime($param['server_date'])):$param['server_date']); //服务日期
		$project_id=empty($param['project_id'])?'':$param['project_id']; //项目id
        $site_type=empty($param['site_type'])?'':$param['site_type']; //场地类型 1518=单场，1519=半场，1520=全场

        $path_www=getShowUrl('file_path_url');

        $cr = new CDbCriteria;
        $cr->condition='f_check=2 and if_user=649 and s_timestar>now()';
        if($t_typeid==1){
            $cr->condition.=' and site_id='.$id;
            
            $site=GfSite::model()->find('id='.$id);
            $club_id=$site->user_club_id;   //club_id

            $cl = new CDbCriteria;
            $cl->condition='f_check=2 and if_user=649 and site_id='.$id.' and t_typeid='.$t_typeid;
            if ($server_date != '') {
                $cl->condition.=' and star_time<="' . $server_date . '"';
                $cl->condition.=' and end_time>="' . $server_date . '"';
            }
            if(!empty($project_id)){
                $cl->condition.=' and find_in_set("'.$project_id.'",t.project_ids)';
            }
            $cl->condition=get_where($cl->condition,!empty($t_typeid),'t_typeid',$t_typeid,'');
            $cl->condition=get_where($cl->condition,!empty($site_type),'site_type',$site_type,'');
            $cl->order = 'id DESC';
            $list=QmddServerSetList::model()->findAll($cl);
            $list=cArray($list,'id as list_id,s_name');
            
            if(!empty($site))$gProject=GfSiteProject::model()->findAll('site_id='.$site->id);
            $gProjectId='';
            if(!empty($gProject))foreach($gProject as $g){
                $gProjectId.=$g->project_id.',';
            }
        }elseif($t_typeid==2){
            $cr->condition.=' and server_sourcer_id='.$id;
            
            $list=QmddServerSetList::model()->find('server_sourcer_id='.$id);
            $club_id=$list->club_id;   //club_id
            if(!empty($list))$sourcer=QmddServerSourcer::model()->find('id='.$list->server_sourcer_id);
            if(!empty($sourcer))$person=QmddServerPerson::model()->find('id='.$sourcer->s_name_id);
            if(!empty($person))$per=QualificationsPerson::model()->find('id='.$person->qualificate_id);
            
        }
        if(!empty($project_id)){
            $cr->condition.=' and find_in_set("'.$project_id.'",t.project_ids)';
        }
        $cr->condition.=' and down=0';  
        $cr->condition=get_where($cr->condition,!empty($t_typeid),'t_typeid',$t_typeid,'');
        $cr->condition=get_where($cr->condition,!empty($site_type),'site_type',$site_type,'');
        $cr->order = 'id DESC';
        $cr->group = 's_date';
        $cr->select = 's_date';
        $s_data = QmddServerSetData::model()->findAll($cr);
        if ($server_date != '') {
            $cr->condition.=' and s_date="' . $server_date . '"';
        }
        $cr->group = '';
        $cr->select = '';
        $set_data = QmddServerSetData::model()->findAll($cr);
        $s2='id,info_id,list_id,site_id,server_sourcer_id,t_typeid,t_typename,t_stypeid,t_stypename,s_code,s_name,';
        $s2.='s_timename,s_timestar,s_timeend,s_date,s_gfid,s_gfaccount,s_gfname,sale_price,club_id,club_name,project_ids,';
        $s2.='order_project_id,order_project_name,order_gfid,order_account,order_name,order_date,is_conflict,is_conflict_up';
        $set_data=toArray($set_data,$s2);
        
        $stime = QmddServerTime::model()->findAll('state=2');
        $stime=toArray($stime,'id,timename');

        $cr->group = 'project_ids';
        $pl='';
        $p_data = QmddServerSetData::model()->findAll($cr);
        foreach($p_data as $p){
            $pl.=($pl==''?'':',').$p->project_ids;
        }
        $project_list=array();
        if($pl!=''){
            $pa2=explode(",",$pl);
            foreach($pa2 as $ip=>$p2){
                $pj=ProjectList::model()->find('id='.$p2);
                $project_list[$ip]['id']=$pj->id;
                $project_list[$ip]['project_name']=$pj->project_name;
            }
        }
        if($t_typeid==1){
            $cr->group = 'site_type';
            $site_type = QmddServerSetData::model()->findAll($cr);
            $site_type=cArray($site_type,'site_type as f_id');
            if(!empty($site_type))foreach($site_type as $si=>$s){
                $s_type=BaseCode::model()->find('f_id='.$s['f_id']);
                $site_type[$si]['F_NAME']=empty($s_type)?'':$s_type->F_NAME;
            }
        }

        $data=array();
        $data=array('error'=>1,'msg'=>'fail');
        $count1 = Yii::app()->db->createCommand('select count(*) as countq from personal_subscription where news_type=1522 and news_id='.$id.' and gf_user_type=210 and gfid='.$gfid.' and if_remind=1193')->queryAll();
        $data['is_subscribe']=$count1[0]['countq']>0?1:0;
        if(!empty($club_id)){
            $count2 = Yii::app()->db->createCommand('select count(*) as countq from book_club where book_gfid='.$gfid.' and club_id='.$club_id)->queryAll();
            $data['is_book_club']=$count2[0]['countq']>0?1:0;
        }else{
            $data['is_book_club']=0;
        }
        if($t_typeid==1){
            $data['loge']=!empty($site)?$path_www.$site->site_pic:'';
            $data['slide']=!empty($site)?$site->site_scroll:'';
            $data['name']=!empty($site)?$site->site_name:'';
            $data['address']=!empty($site)?$site->site_address:'';
            $data['latitude']=!empty($site)?$site->site_latitude:'';
            $data['Longitude']=!empty($site)?$site->site_longitude:'';
            $data['phone']=!empty($site)?$site->contact_phone:'';
            $data['club_id']=!empty($site)?$site->user_club_id:'';
            $data['club_name']=!empty($site)?$site->user_club_name:'';
            $data['levelid']=!empty($site)?$site->site_level:'';
            $data['levelname']=!empty($site)?$site->site_level_name:'';
            $data['level_logo']=!empty($site)?$path_www.$site->site_level_logo:'';
            $data['site_envir']=!empty($site)?$site->site_envir:'';
            if(!empty($site))$base_code=BaseCode::model()->find('f_id='.$site->site_envir);
            $data['site_envir_name']=!empty($base_code)?$base_code->F_NAME:'';
			$basepath = BasePath::model()->getPath(171);
            $data['introduct_temp']=!empty($site)?get_html($basepath->F_WWWPATH.$site->site_description, $basepath):'';
            $data['site_type']=$site_type;
            $facility=array();
            if(!empty($site))$facility=GfSiteCredit::model()->findAll('id in('.$site->site_facilities.')');
            $facility=toArray($facility,'id,item_name');
            $data['facility']=$facility;
            $data['site_list']=$list;
        }elseif($t_typeid==2){
            $data['loge']=!empty($sourcer)?$path_www.$sourcer->logo_pic:'';
            $data['slide']=!empty($sourcer)?$sourcer->s_picture:'';
            $data['name']=!empty($sourcer)?$sourcer->s_name:'';
            $data['site_name']=!empty($person)?$person->servic_site_name:'';
            $data['address']=!empty($sourcer)?$sourcer->area:'';
            $data['latitude']=!empty($sourcer)?$sourcer->latitude:'';
            $data['Longitude']=!empty($sourcer)?$sourcer->Longitude:'';
            $data['phone']=!empty($sourcer)?$sourcer->contact_number:'';
            $data['club_id']=!empty($person)?$person->club_id:'';
            $data['club_name']=!empty($person)?$person->club_name:'';
            $data['levelid']=!empty($sourcer)?$sourcer->s_levelid:'';
            $data['levelname']=!empty($sourcer)?$sourcer->s_levelname:'';
            $data['level_logo']=!empty($sourcer)?$path_www.$sourcer->s_level_logo:'';
            $data['identity_type']=!empty($per)?$per->identity_type:'';
            $data['identity_type_name']=!empty($per)?$per->identity_type_name:'';
            $data['identity_num']=!empty($per)?$per->identity_num:'';
            $data['identity_title']=!empty($per)?$per->qualification_title:'';
			$basepath = BasePath::model()->getPath(269);
            $data['introduct_temp']=empty($person->introduct)?'':get_html($basepath->F_WWWPATH.$person->introduct, $basepath);
        }
		$data['project_list']=$project_list;
		$data['datas']=$set_data;
        $data['stime_datas']=$stime;
        
        $start_date=0;$end_date=0;
        if(!empty($s_data)){
            $start_date=$s_data[0]->s_date;
            $end_date=$s_data[0]->s_date;
        }
        foreach($s_data as $i=>$h){
            if($start_date>$s_data[$i]->s_date){
                $start_date = $s_data[$i]->s_date;
            }
            if($end_date<$s_data[$i]->s_date){
                $end_date = $s_data[$i]->s_date;
            }
        }
		$data['start_date']=$start_date;
		$data['end_date']=$end_date;
        
	    set_error_tow($data,count($set_data),0,"拉取数据成功",0,"拉取数据成功",1);
    }
	
	/**
	 * 预订服务接口
	 *  $param = {
             "contact_phone"=>"",
             "project_id"=>"188",
             "data_id"=>"95497",
             "gfid"=>"25910",
             "ts"=>"1578020632219",
             "visit_id"=>"408098",
             "visit_type"=>"1",
             "visit_gfid"=>"25910",
             "device_type"=>"5",
             "login_dev"=>"2a5f2088-9d91-4324-a0fc-86e03985c5d1",
             "client_version"=>"200",
             "visit_key"=>"4bb64e610cf62bfea8933447a01f3f06"
         };
         $param=json_decode(base64_decode("eyJjb250YWN0X3Bob25lIjoiMTM3ODg1MzA5ODciLCJwcm9qZWN0X2lkIjoiMTg4IiwiZGF0YV9pZCI6IjI1NTA3NyIsImdmaWQiOiIxMzkwIn0="),true);
	 */
	public function actionNew_scheduled_service(){
        $param=decodeAskParams($_REQUEST,1);
		$data=get_error(1,'');
        $gfid=$param['gfid'];     //预订人gfid
        $gf_user=userlist::model()->find('GF_ID='.$gfid);
        $project_id=empty($param['project_id'])?'':$param['project_id'];   //预订的项目
        if(!empty($project_id)){
            $project_list=ProjectList::model()->find('id='.$project_id);
            $project_name = $project_list->project_name;
        }
        $data_id=$param['data_id'];   //io_service/new_service_detail返回datas的id 多个使用,隔开
        $contact_phone=empty($param['contact_phone'])?'':$param['contact_phone'];   //预订的项目
		
        $path_www=getShowUrl('file_path_url');
        $id_arr=explode(',',$data_id);
        $datas=array();
        $str='';
        $money=0.00;
        $logo_pic='';
        $order_num='';
        
        foreach($id_arr as $i=>$v){
            $cr = 'f_check=2 and if_user=649 and id='.$v;
            if(!empty($project_id)){
                $cr.=' and find_in_set("'.$project_id.'",t.project_ids)';
            }
            $set_data = QmddServerSetData::model()->findAll($cr);
            $s2='id,info_id,list_id,site_id,server_sourcer_id,t_typeid,t_typename,t_stypeid,t_stypename,s_code,';
            $s2.='s_name,s_timename,s_timestar,s_timeend,s_date,s_gfid,s_gfaccount,s_gfname,sale_price,area,club_id,';
            $s2.='club_name,project_ids,order_project_id,order_project_name,order_gfid,order_account,order_name,order_date,is_conflict';
            $set_data=toArray($set_data,$s2);

            if(count($set_data)>0){
                if(!empty($set_data[0]['order_gfid'])&&$set_data[0]['order_gfid']>0){
                    // $str=$str.$set_data[0]['s_date'].' '.$set_data[0]['s_timename'].',';
                    set_error($data,1,"预订失败".$set_data[0]['s_date'].' '.$set_data[0]['s_timename'].'已被预定',1);
                }
                else{
                    if($set_data[0]['is_conflict']>0){
                		set_error($data,1,$set_data[0]['s_name'].' '.$set_data[0]['s_date'].' '.$set_data[0]['s_timename']."预订失败，同资源同时段预订冲突关闭",1);
                	}
                    $datas[$i]=$set_data[0];
                    $money=$money+$set_data[0]['sale_price'];
                    $sourcer=QmddServerSourcer::model()->find('id='.$set_data[0]['server_sourcer_id']);
                    $sql = ' and s_date="'.$set_data[0]['s_date'].'"'.' and s_timename="'.$set_data[0]['s_timename'].'"';
                    if(!empty($sourcer)){
                    	$datas[$i]['show_service_title']=$sourcer->s_name;
                    	$datas[$i]['show_service_data_title']=$project_name.' '.date("m/d",strtotime($set_data[0]['s_date'])).' '.$set_data[0]['s_timename'];
                        if($sourcer->t_typeid==1){
	                    	$datas[$i]['show_service_title']=$sourcer->site_name;
	                    	$datas[$i]['show_service_data_title']=$project_name.' '.$sourcer->site_typename.' '.$sourcer->s_name.' '.date("m/d",strtotime($set_data[0]['s_date'])).' '.$set_data[0]['s_timename'];
                
                            $sou_parent = !empty($sourcer->site_parent) ? $sourcer->site_parent : $sourcer->s_name_id;
                            if($sou_parent){
                            	$p_where =!empty($sourcer->site_parent)?'s_name_id in ('.$sourcer->site_parent.')':'';
                            	$s_where =!empty($sourcer->s_name_id)?'find_in_set('.$sourcer->s_name_id.',site_parent)':'';
                            	$sou1=QmddServerSourcer::model()->findAll('t_typeid=1 and ('.$p_where.(empty($p_where)?'':' or ').$s_where.')');
                                
//                                $sou1 = QmddServerSourcer::model()->findAll('t_typeid=1 and (s_name_id in ('.$sou_parent.') or find_in_set('.$sou_parent.',site_parent))');
                                
                                if($sou1){
                                	$soid='';
                                	foreach($sou1 as $s1){
                                		$soid.=empty($soid)?$s1->id:(','.$s1->id);
//                                    $sd1 = QmddServerSetData::model()->find($config_where." and server_sourcer_id=".$s1->id.$sql.' and is_conflict>0');
//                                    if($sd1){
//                                        set_error($data,1,$set_data[0]['s_name'].' '.$set_data[0]['s_date'].' '.$set_data[0]['s_timename']."预订失败，同资源同时段预订冲突关闭",1);
//                                    }
//                                    else{
//                                        QmddServerSetData::model()->updateAll(array('is_conflict'=>1,'is_conflict_up'=>$set_data[0]['id'])," server_sourcer_id=".$s1->id." and id<>".$v.$sql);
//                                    }
                                	}
                                	//QmddServerSetData::model()->updateAll(array('is_conflict'=>1,'is_conflict_up'=>$set_data[0]['id'])," server_sourcer_id in(".$soid.") and id<>".$v.$sql);	
                                	QmddServerSetData::model()->updateSQL("update qmdd_server_set_data set is_conflict=is_conflict+1,is_conflict_up=concat(is_conflict_up,',',".$set_data[0]['id'].",',') where server_sourcer_id in(".$soid.") and id<>".$v.$sql);
                                
                                }
                            }
                            $site=GfSite::model()->find('id='.$sourcer->site_id);
                            if(!empty($site))$logo_pic=$site->site_pic;
                        }
                        elseif($sourcer->t_typeid==2){
                            $logo_pic=$sourcer->logo_pic;
                        }
                    }
                }
            }else{
                set_error($data,1,"预订失败",1);
            }
        }
        // if($str!=''){
        //     set_error($data,1,"预订失败".rtrim($str,',').'已被预定',1);
        // }
        $effective_time=date("Y-m-d H:i:s",strtotime("+5 minute"));
        $order_data=array('order_type'=>353,'buyer_type'=>210,'order_gfid'=>$gfid,'rec_name'=>$gf_user->ZSXM,'rec_phone'=>$gf_user->security_phone,'contact_phone'=>$contact_phone==''?$gf_user->security_phone:$contact_phone,'money'=>$money,'order_money'=>$money,'total_money'=>$money,'product_ico'=>$logo_pic,'effective_time'=>$effective_time);
		$add_order=Carinfo::model()->addOrder($order_data);
		if(empty($add_order['order_num'])){
			set_error($data,1,"预订失败",1);
		}
		$add_order['effective_time']=$effective_time;
        foreach($datas as $k=>$n){
        	$add_service=array('order_type'=>353
        	,'project_id'=>$project_id
        	,'project_name'=>$project_name
        	,'data_id'=>$n['server_sourcer_id']
        	,'supplier_id'=>$n['club_id']
        	,'gfid'=>$gfid
        	,'gf_account'=> $gf_user->GF_ACCOUNT
        	,'gf_name'=>$gf_user->ZSXM
        	,'contact_phone'=>($contact_phone==''?$gf_user->security_phone:$contact_phone)
        	,'service_id'=>$n['server_sourcer_id']
        	,'service_code'=>$n['s_code']
        	,'service_ico'=>$logo_pic
        	,'show_service_title'=>$n['show_service_title']
        	,'service_data_id'=>$n['id']
        	,'service_data_name'=>($n['s_date'].' '.$n['s_timename'])
        	,'show_service_data_title'=>$n['show_service_data_title']
        	,'service_name'=>$n['s_name']
        	,'servic_time_star'=>$n['s_timestar']
        	,'servic_time_end'=>$n['s_timeend']
        	,'buy_count'=>1
        	,'buy_price'=>$n['sale_price']
        	,'udate'=>date('Y-m-d h:i:s')
        	,'check_way'=>793
        	,'state'=>2
        	,'state_time'=>date('Y-m-d h:i:s')
        	,'order_itme'=>757
        	,'is_pay'=>($n['sale_price']<=0?464:463)
        	,'order_state'=>($n['sale_price']<=0?1462:1169)
        	,'service_address'=>$n['area']
        	,'t_stypeid'=>$n['t_stypeid']
        	,'qmdd_server_set_list_id'=>$n['list_id']
        	,'shopping_order_num'=>$add_order['order_num']
        	,'effective_time'=>$add_order['effective_time']);
				$add_data=GfServiceData::model()->addServiceData($add_service);//写入服务报名表
                if(!empty($add_data)){
                    $this->save_shopping($add_data,$k);
					
                    QmddServerSetData::model()->updateByPk($n['id'],array('order_project_id'=>$project_id,'order_project_name'=>!empty($project_list)?$project_list->project_name:'','order_gfid'=>$gfid,'order_account'=>$gf_user->GF_ACCOUNT,'order_name'=>$gf_user->ZSXM,'order_date'=>date('Y-m-d h:i:s'),'order_num'=>$add_data['order_num']));

                    $order_num=$order_num.$add_data['order_num'].',';
                }

        }
		$data['order_num']=$add_order['order_num'];
		set_error_tow($data,!empty($data['order_num']),0,"预订成功",1,"预订失败",1);
    }

    /**
	 * 生成待支付订单明细信息
	 */
	function save_shopping($model,$no){
        $base_code = BaseCode::model()->find('f_id=353');
        if(!empty($model['project_id'])){
            $sign_level = ClubMemberList::model()->find('gf_account='.$model['gf_account'].' and member_project_id='.$model['project_id'].' and club_status=337');
        }else{
            $sign_level = ClubMemberList::model()->find('gf_account='.$model['gf_account'].' and club_status=337');
        }
        $add_order_data=CommonTool::model()->getKeyArray($model,'order_type,supplier_id,qmdd_server_set_list_id,buy_price,project_id,project_name,gfid,gf_name,service_id,service_code,service_ico,service_name,show_service_title,service_data_id,service_data_name,show_service_data_title',array());
        $add_order_data['order_num']=$model['shopping_order_num'];
        $add_order_data['order_no']=$no;
        $add_order_data['order_type_name']=$base_code->F_NAME;
        $add_order_data['total_pay']=$model['buy_price'];// 购买订单总额
        $add_order_data['buy_amount']=$model['buy_price']; // 购买实际金额
        $add_order_data['buy_count']=1;
        $add_order_data['uDate']=date('Y-m-d H:i:s');
        $add_order_data['gf_service_id']=$model['id'];
        $add_order_data['effective_time']=$model['effective_time'];
        if(!empty($sign_level)){
            $add_order_data['buy_level'] = $sign_level->project_level_id;
            $add_order_data['buy_level_name'] = $sign_level->project_level_name;
            $add_order_data['gf_club_id'] = empty($sign_level->club_id)?0:$sign_level->club_id;
        }
        $add_d=CardataCopy::model()->addOrderData($add_order_data);//写入待支付订单详细
    }

    /**
     * 二维码签到接口.
     * $sign_gfid = 签到学员gfid.
     * $scan_gfid = 扫描人gfid.
     * $sign_code = 签到验证码.
     * 签到成功，发送通知335给预订者
     */
    public function actionScan_sign(){
        // gf_service_data.id=9627
        // $_POST = array('sign_gfid'=>'26421','scan_gfid'=>'25910','sign_code'=>'35420146040');
        $param=decodeAskParams($_REQUEST,1);
        $sign_gfid = $param['sign_gfid'];
        $scan_gfid = $param['scan_gfid'];
        $sign_code = $param['sign_code'];
        $sv = 0;
        $data = get_error(1,'');
        $find_service = GfServiceData::model()->find('order_type=353 and state=2 and is_pay=464 and gfid='.$sign_gfid.' and sign_code="'.$sign_code.'"');// and order_state=1170
        if(!empty($find_service)){
            $authorization = ServiceAuthorization::model()->find('id='.$find_service->authorization_id);
            if(!empty($authorization) && strpos($authorization->authorized_person_id,$scan_gfid)!==false){
                if(empty($find_service->sign_come) || $find_service->sign_come=='0000-00-00 00:00:00'){
                    $sv = $this->save_achievemen_data($find_service->id);
                    if($sv>0){
                        $content_html = 
                            '<font>【动动约签到通知】</font><br>
                            <font>服务流水号：'.$find_service->order_num.'</font><br>
                            <font>预定服务时间：'.substr($find_service->servic_time_star,0,10).' '.substr($find_service->servic_time_star,11,-3).'-'.substr($find_service->servic_time_end,11,-3).'</font><br>
                            <font>已签到成功</font><br>
                            <font>预定详情</font>';
                        $pic = BasePath::model()->get_www_path();
                        $send_data = array(
                            'type' => '【动动约签到通知】',
                            'title' => $find_service->service_name,
                            'pic' => $pic.$find_service->service_ico,
                            'service_code' => $find_service->order_num,
                            'service_type' => $find_service->order_type,
                            'service_id' => $find_service->service_id,
                            'service_data_id' => $find_service->service_data_id,
                            'content' => '',
                            'content_html' => $content_html,
                        );
                        send_msg(335,0,$sign_gfid,$send_data);
                        $data = get_error(0,'签到成功');
                    }
                    else{
                        $data = get_error(1,'签到失败');
                    }
                }
                else{
                    $data = get_error(2,'已在'.$find_service->sign_come.'签到过');
                }
            }
            else{
                $data = get_error(3,'未授权');
            }
        }
        else{
            $data = get_error(4,'没有签到数据');
        }
        set_error($data,$data['error'],$data['msg'],1);
    }

    /**
     * 签到同时在qmdd_achievemen_data表添加待评论数据.
     */
    function save_achievemen_data($d){
        $modelName = 'GfServiceData';
        $model = $this->loadModel($d, $modelName);
        $achie = QmddAchievemen::model()->findAll('f_type='.$model->order_type);
        $orderInfo = MallSalesOrderData::model()->find('orter_item=757 and gf_service_id='.$model->id.' and order_num="'.$model->info_order_num.'"');
        if(!empty($achie))foreach($achie as $v){
            $achie_data = QmddAchievemenData::model()->find('gf_service_data_id='.$model->id.' and f_achievemenid='.$v->f_id);
            $data = array();
            if(empty($achie_data)){
                $achie_data = new QmddAchievemenData();
                $achie_data->isNewRecord = true;
                unset($achie_data->f_id);
            }
            if(!empty($orderInfo)){
                $achie_data->order_num_id = $orderInfo->id;
            }
            $achie_data->order_type = $model->order_type;
            $achie_data->order_type_name = $model->order_type_name;
            $achie_data->service_id = $model->service_id;
            $achie_data->service_code = $model->service_code;
            $achie_data->service_ico = $model->service_ico;
            $achie_data->service_name = $model->service_name;
            $achie_data->service_data_id = $model->service_data_id;
            $achie_data->service_data_name = $model->service_data_name;
            $achie_data->gf_id = $model->gfid;
            $achie_data->gf_service_data_id = $model->id;
            $achie_data->service_order_num = $model->order_num;
            $achie_data->club_id = $model->supplier_id;
            $achie_data->f_achievemenid = $v->f_id;
            $sf=$achie_data->save();
        }
        $model->sign_come = date('Y-m-d H:i:s');
        $model->order_state = 1171;
        $model->is_invalid = 1;
        $sv = $model->save();
        return $sv;
    }
    
    /**
     * 获取动动约订单列表
     */
    function actionGet_ddy_order_list(){
        $param=decodeAskParams($_REQUEST,1);
    	GfServiceData::model()->getDdyOrderList($param);
    }
    
    /**
     * 根据订单号获取动动约服务详情
     */
    function actionGet_ddy_order_detail(){
        $param=decodeAskParams($_REQUEST,1);
    	GfServiceData::model()->getDdyOrderDetail($param);
    }
    /**
     * 获取动动约服务单列表
     */
    function actionGet_ddy_service_order_list(){
        $param=decodeAskParams($_REQUEST,1);
    	GfServiceData::model()->getDdyServiceList($param);
    }
    
    /**
     * 根据服务单号获取动动约服务详情
     */
    function actionGet_ddy_service_order_detail(){
        $param=decodeAskParams($_REQUEST,1);
    	GfServiceData::model()->getDdyServiceDetail($param);
    }

    // 获取手机区域号列表
    function actionGetPhoneCountryCodeList(){
        $criteria = new CDbCriteria;
        $criteria->select = 'english_name,chinese_name,country_code';
        $list = TCountry::model()->findAll($criteria,array(),false);
        set_error($list,0,'获取成功',1);
    }

    // 手机号获取验证码
    function actionGetSmsCode(){
        $param = decodeAskParams($_REQUEST,0);
        $countryCode = $param['country_code'];
        $phone = $param['phone'];
        $type = $param['type'];

        $rs = $this->getSmsCode($countryCode,$phone,$type);
        $data = array();
        if(empty($rs['result'])){
            set_error($data,1,'发送验证码失败',1);
        }
        $data = array('smsCode' => $rs['smsCode']);
        set_error($data,0,'发送验证码成功',1);
    }

    // 获取验证码
    function getSmsCode($countryCode,$phone,$type){
        $randomCode = random();
        $result = sendSms($phone,"您的验证码是：".$randomCode."。请不要把验证码泄露给其他人。",$countryCode);
        $this->saveSmsCode($countryCode,$phone,$randomCode,$result,$type);
        $returnArr = array('smsCode' => $randomCode, 'result' => $result);
        return $returnArr;
    }

    // 保存验证码记录
    function saveSmsCode($countryCode,$phone,$randomCode,$sendState,$type){
        $log = new PhoneSmsLog();
        $log->phone_code = $countryCode;
        $log->phone = $phone;
        $log->sms_code = $randomCode;
        $log->uDate = date('Y-m-d H:i:s');
        $log->type = $type;
        $log->send_state = 1;
        if (empty($sendState)){
            $log->send_state = 0;
        }
        $log->send_time=date('Y-m-d H:i:s');
        $log->save();
    }



}

?>