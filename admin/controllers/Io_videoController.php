
<?php
/**
 * 
 * 视频-前端接口
 * @author xiyan
 */
class Io_videoController extends BaseController {
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

	/**
	 * 获取视频分类
	 */
	public function actionGet_video_type(){
		$data=get_error(1,"获取失败");
        $datas=VideoClassify::model()->get_videoLive_type(365);
		$data["datas"] = $datas;
		set_error_tow($data,1, 0, '获取成功',1,'获取失败',1);
    }
    
    /**
     * 获取视频分类、推荐数据：id,title,subtitle,logo，
     * 1、点击视频，默认进入“推荐频道”；
		2、广告区：获取各分类频道的最新发布的视频（最多5个）；
		3、分类频道推荐区：
		每个分类（如电视剧）在推荐页均有版块（大推荐+小推荐）
		大推荐区：该分类最新发布的1-5个数据；
		小推荐区：该分类最新发布的第1-16个（共16个），按左右滑动显示。
		当该分类频道无数据时，则推荐版块不显示。
     */
	public function actionGet_recommend_video(){
		$data=get_error(1,"获取失败");
        $tdata=VideoClassify::model()->get_videoLive_type(365);
        $cr = new CDbCriteria;
        $where=BoutiqueVideo::model()->SqlShow();
        $cr->condition=$where;
//        $cr->join = "JOIN gf_material on gf_material.id=t.video_source_id and gf_material.v_file_zt=1 and gf_material.v_type=253";
        $cr->order = 't.video_publish_time DESC';
        $cr->limit = 5;
        $cr->select="id,video_title,ifnull(video_sec_title,'') as video_subtitle,video_logo";
        $adatas=BoutiqueVideo::model()->findAll($cr,array(),false);
        $path_www=getShowUrl('file_path_url');
        $adv=array();
        foreach($adatas as $k=>$v){
        	$v['video_logo']=empty($v['video_logo'])?"":($path_www.$v['video_logo']);
        	$adv[$k]=$v;
        }
        $sdata=array();
        $n=0;
        foreach($tdata as $k=>$v){
        	$tdata[$k]['is_recomment']=0;
	        $cr->condition=$where.' and video_classify='.$v['id'];
        	$cr->limit = 16;
	        $cdatas=BoutiqueVideo::model()->findAll($cr,array(),false);
	        if(empty($cdatas)||count($cdatas)==0){
	        	continue;
	        }
        	$sdata[$n]=$v;
        	$type_adata=array();
        	$type_data=array();
        	foreach($cdatas as $dk=>$dv){
        		$dv['video_logo']=empty($dv['video_logo'])?"":($path_www.$dv['video_logo']);
        		
        		if($dk<5){
        		    $type_adata[$dk]=$dv;
        		}
        		$type_data[$dk]=$dv;
        		
        	}
        	$sdata[$n]['adv_datas']=$type_adata;
        	$sdata[$n]['datas']=$type_data;
        	$n++;
        }
        array_unshift($tdata,array('id'=>'0','code'=>'','name'=>'推荐','is_recomment'=>1));
		$data["type_datas"] = $tdata;
        $data['adv_video']=$adv;
		$data["datas"] = $sdata;
		set_error_tow($data,1, 0, '获取成功',1,'获取失败',1);
    }

    /**
     * 根据视频分类获取数据
     * 分类频道显示：
（1）广告区：显示最新发布的1-5个视频；
（2）最近上线：显示最新发布的1-30个视频；
     */
	public function actionGet_video_list(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"获取失败");
		$video_type=$param['video_type'];
        $cr = new CDbCriteria;
        $cr->condition=BoutiqueVideo::model()->SqlShow().' and t.video_classify='.$video_type;
//        $cr->join = "JOIN gf_material on gf_material.id=t.video_source_id and gf_material.v_file_zt=1 and gf_material.v_type=253";
        $cr->order = 't.video_publish_time DESC';
        $cr->limit = 30;
        $cr->select="id,video_title,ifnull(video_sec_title,'') as video_subtitle,video_logo";
        $adatas=BoutiqueVideo::model()->findAll($cr,array(),false);
        $path_www=getShowUrl('file_path_url');
        $datas=array();
        $adv=array();
        foreach($adatas as $k=>$v){
        	$v['video_subtitle']='';
        	$v['video_logo']=empty($v['video_logo'])?"":($path_www.$v['video_logo']);
        	if($k<5){
        		$adv[$k]=$v;
        	}
        		$datas[$k]=$v;
        }
        $data['adv_video']=$adv;
		$data["datas"] = $datas;
		set_error_tow($data,1, 0, '获取成功',1,'获取失败',1);
    }

    /**
     * 关键字搜索视频
     * 1.标题模糊查找
     * 2.视频分类
     * 3.发表年份
     * 4.发布区域
     */
	public function actionSearch_video(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"获取失败");
		$keyword=$param['keyword'];
		$video_type=$param['video_type'];
		$year=$param['year'];
		$area=$param['area'];
		$page=empty($param['page'])?0:$param['page'];
        $_GET['page']=$page;
		$pageSize=empty($param['pageSize'])?0:$param['pageSize'];
		
		$year_data=array();
		$year_data[0]=array('id'=>'全部','name'=>'全部');
		$yi=1;
		for($star=date("Y");$star>2009;$star--){
			$year_data[$yi]=array('id'=>$star,'name'=>$star);
			$yi++;
		}
		$year_data[$yi]=array('id'=>'其他','name'=>'其他');
		$area_data=array(array('id'=>'全部','name'=>'全部'),array('id'=>'内地','name'=>'内地'),array('id'=>'中国香港','name'=>'中国香港'),array('id'=>'中国台湾','name'=>'中国台湾'),array('id'=>'美国','name'=>'美国'),array('id'=>'英国','name'=>'英国'),array('id'=>'韩国','name'=>'韩国'),array('id'=>'泰国','name'=>'泰国'),array('id'=>'日本','name'=>'日本'),array('id'=>'其他','name'=>'其他'));
		if(empty($year)&&empty($area)){
			$data["year_datas"] = $year_data;
			$data["area_datas"] = $area_data;
		}
		
        $tdata=VideoClassify::model()->get_videoLive_type(365);
        $cr = new CDbCriteria;
        $cr->condition=BoutiqueVideo::model()->SqlShow('t');
        if(!empty($keyword)){
        	$cr->condition.=" and video_title like'%".$keyword."%'";
        }
        if(!empty($video_type)){
        	$cr->condition.=" and t.video_classify=".$video_type;
        }
        if(!empty($year)&&$year!='全部'){
        	$cr->condition.=" and year='".$year."'";
        }
        if(!empty($area)&&$area!='全部'){
    		$cr->condition.=" and area='".$area."'";
        }
//        $cr->join = "JOIN gf_material on gf_material.id=t.video_source_id and gf_material.v_file_zt=1 and gf_material.v_type=253";
        $cr->join = "JOIN video_classify on video_classify.id=t.video_classify";
        $cr->order = 't.video_publish_time DESC';
        $cr->select="t.id,t.video_title,ifnull(t.video_sec_title,'') as video_subtitle,t.video_logo,left(t.video_publish_time,10) video_publish_time,t.video_classify,video_classify.sn_name";
        $count = BoutiqueVideo::model()->count($cr);//符合条件的总数
        $pages = new CPagination($count);
        $pages->setPageSize($pageSize);
        $pages->applylimit($cr);
        $list=BoutiqueVideo::model()->findAll($cr,array(),false);
        $path_www=getShowUrl('file_path_url');
        $adv=array();
        foreach($list as $k=>$v){
        	$v['video_subtitle']='';
        	$v['video_logo']=empty($v['video_logo'])?"":($path_www.$v['video_logo']);
        	$v['video_classify_name']=$v['sn_name'];
        	unset($v['sn_name']);
        	$adv[$k]=$v;
        }
		$data["datas"] = $adv;
		$data['totalCount']=$pages->getItemCount();
		$data['now_page']=$page;
		set_error_tow($data,1, 0, '获取成功',1,'获取失败',1);
    }

    /**
     * 视频详情
     * 视频名称、播放量、简介，试看时长、pay=1需购买，订阅,视频集（集标题、视频地址）、猜你喜欢
     * 评论数据通过评论接口单独获取
     */
	public function actionGet_video_detail(){
        $param=decodeAskParams($_REQUEST,0);
		checkArray($param,'video_id',1);
        $param['device_type']=empty($param['device_type'])?8:$param['device_type'];
		$data=get_error(1,"获取失败");
		$video_id=$param['video_id'];
		$gfid=$param['gfid'];
        $cr = new CDbCriteria;
        $cr->condition='now() between t.video_start and t.video_end and t.state=2  and !isnull(t.video_classify) and isnull(t.live_program_id) and t.id='.$video_id;
        $cr->join = "left JOIN gf_material on gf_material.id=t.video_source_id and gf_material.v_file_zt=1 and gf_material.v_type in (253,254)";
        $cr->select="t.is_uplist,t.down_type,t.id as video_id,t.video_title,IFNULL(t.video_sec_title,'') as video_subtitle,t.video_logo,t.t_duration,t.open_club_member,(case when is_pay=708 or is_pay=710 then 0 else 1 end) as pay,t.gf_price,t.member_price,t.video_classify,t.video_clicked,t.club_id,t.video_end,concat(ifnull(gf_material.v_file_path,''),ifnull(gf_material.v_name,'')) as video_url,IFNULL(gf_material.v_file_size,'') as v_file_size";//
        $adatas=BoutiqueVideo::model()->findAll($cr,array(),false);
        $path_www=getShowUrl('file_path_url');
        if(empty($adatas)){
        	set_error($data,1,'视频不存在或已下线',1);
        }else if($adatas[0]['is_uplist']==0){
            set_error($data,2,'视频已下线',1);
        }else if($adatas[0]['down_type']>0){
            set_error($data,2,'视频已下架',1);
        }
        $data=array_merge($data,$adatas[0]);
        $data['video_logo']=empty($adatas[0]['video_logo'])?"":($path_www.$adatas[0]['video_logo']);
        $data['video_intro']=getShowUrl()."?c=info&a=page_switch&category=video_intro&device_type=".$param['device_type']."&page=".$video_id;
        $video_type=$adatas[0]['video_classify'];
        
        if($data['pay']==1&&!empty($gfid)&&MallSalesOrderData::isGetProduct($gfid,$video_id,null,365)){
			$data['pay']=0;//可直接观看
		}
//			$join_club=$p_clubmemberlist->IsJoinClubProject($gfid,null,$adatas[0]['club_id']);
//			$data['open_club_member']=$adatas[0]['open_club_member']==209?1:0;
//			if($data['open_club_member']==1&&$join_club==0){
//				$data['join_club_id']=$adatas[0]['club_id'];
//			}
		//是否已订阅
        $data['is_collect']=empty($gfid)?0:PersonalSubscription::model()->isSubscription(array('gfid'=>$gfid,'news_type'=>866,'news_id'=>$video_id));
        //视频集
        $cr = new CDbCriteria;
        $cr->condition='t.is_uplist=1 and t.down_type not in (1,2,3) and t.if_del=648 and t.state=2 and t.video_id='.$video_id;
        $cr->join = "JOIN gf_material on gf_material.id=t.video_source_id and gf_material.v_file_zt=1 and gf_material.v_type in (253,254)";
        $cr->select="t.id,t.video_series_code,t.video_series_title,t.video_duration,t.video_clicked,t.video_format,concat(gf_material.v_file_path,gf_material.v_name) as video_url,IFNULL(gf_material.v_file_size,'') as v_file_size";
        $cr->order = "(case when t.video_series_num is null then t.video_series_title+0 else t.video_series_num end)";//t.video_series_title+0 (理论上排序应该正常的，但是实际会出现排序错乱情况)
        $series=BoutiqueVideoSeries::model()->findAll($cr,array(),false);
		$data["datas"] = $series;
		if(count($series)>0){
		    if(!empty($param['video_series_id'])){
		        foreach($series as $k=>$v){
		            if($param['video_series_id']==$v['id']){
		               $data['video_url']=$v['video_url']; 
		               break;
		            }
		        }
		    }else{
		        $data['video_url']=$series[0]['video_url'];
		    }
		}
		
		if(!empty($gfid)&&count($series)>0&&isset($param['visit_id'])){
			//获取最新一条历史观看记录，并增加记录
        	$cr = new CDbCriteria;
	        $cr->condition='if_del=648 and video_id='.$video_id." and s_gfid=".$gfid;
	        $cr->select="ifnull(video_series_id,'')video_series_id,video_series_title,last_time";
	        $cr->join =null;
	        $cr->order = 'id desc';
	        $cr->limit = 1;
			$video_series_id = "";
        	$video_series_title = "";
			if(!empty($param['video_series_id'])){
				$cr->condition.=" and video_series_id=".$param['video_series_id'];
				foreach($data["datas"] as $k=>$v){
					if($v['id']==$param['video_series_id']){
						$video_series_id = $v['id'];
			        	$video_series_title = $v['video_series_title'];
			        	break;
					}
				}
			}
	        $watch=VideoClick::model()->findAll($cr,array(),false);
			$data["last_watch"] =count($watch)==0?array('last_time'=>0): $watch[0];
			if(empty($video_series_id)){
				if(empty($watch)||count($watch)==0||empty($watch[0]['video_series_id'])||$watch[0]['video_series_id']=='0'){
					$video_series_id = $series[0]['id'];
			        $video_series_title = $series[0]['video_series_title'];
		        	$data["last_watch"]['last_time']=0;
		        }else{
			        $video_series_id = $watch[0]['video_series_id'];
			        $video_series_title = $watch[0]['video_series_title'];
		        }
			}
			$watch_id=0;
			foreach($series as $k=>$v){
			    if($video_series_id==$v['id']){
			        $watch_id=$v['id'];
			        $video_series_title=$v['video_series_title'];
			        break;
			    }
			}
			if(empty($watch_id)){
			    $video_series_id = $series[0]['id'];
			    $video_series_title = $series[0]['video_series_title'];
			    $data["last_watch"]['last_time']=0;
			}
	        $data["last_watch"]['video_series_id']=$video_series_id;
	        $data["last_watch"]['video_series_title']=$video_series_title;
			
			$where='s_gfid='.$param['gfid'].' and video_id ='.$video_id;
	        VideoClick::model()->updateAll(array('if_del' => 649), $where);
	        $record = new VideoClick();
	        unset($record->id);
	        $record->video_id = $video_id;
	        $record->video_series_id = $video_series_id;
		    $record->video_series_title = $video_series_title;
	        $record->login_id = $param['visit_id'];
	        $record->s_gfid = $gfid;
	        $sv=$record->save();
		}
		//推荐视频，同类视频
        $cr = new CDbCriteria;
        $cr->condition=BoutiqueVideo::model()->SqlShow('')." and find_in_set(t.video_classify,'".$video_type."') and id<>".$video_id;
        $cr->order = 'video_publish_time DESC';
        $cr->limit = 10;
        $cr->select="id,video_title,ifnull(video_sec_title,'') as video_subtitle,video_logo";
        $adatas=BoutiqueVideo::model()->findAll($cr,array(),false);
        $likes=array();
        foreach($adatas as $k=>$v){
        	$v['video_logo']=empty($v['video_logo'])?"":($path_www.$v['video_logo']);
        	$likes[$k]=$v;
        }
        $data['like_datas']=$likes;
		set_error_tow($data,1, 0, '获取成功',1,'获取失败',1);
    }
    /**
     * 添加视频观看历史记录
     */
	public function actionAdd_video_watch_history(){
        $param=decodeAskParams($_REQUEST,1);
		checkArray($param,'visit_id,gfid,video_id',1);
		$data=get_error(1,"添加失败");
		$where='s_gfid='.$param['gfid'].' and video_id ='.$param['video_id'];
        $del = VideoClick::model()->updateAll(array('if_del' => 649), $where);
        $record = new VideoClick();
        unset($record->id);
        $record->video_id = $param['video_id'];
        $record->video_series_id = $param['video_series_id'];
        $record->video_series_title = $param['video_series_title'];
        $record->login_id = $param['visit_id'];
        $record->s_gfid = $param['gfid'];
        $record->last_time = $param['last_time'];
        $sv=$record->save();
		set_error_tow($data,$sv, 0, '添加成功',1,'添加失败',1);
    }
    /**
     * 删除视频观看历史记录
     */
	public function actionDel_video_watch_history(){
        $param=decodeAskParams($_REQUEST,1);
		checkArray($param,'gfid,video_id',1);
		$data=get_error(1,"删除失败");
		$where='s_gfid='.$param['gfid'].' and video_id in ('.$param['video_id'].')';
        $del = VideoClick::model()->updateAll(array('if_del' => 649), $where);
		set_error_tow($data,$del, 0, '删除成功',1,'删除失败',1);
    }
    /**
     * 获取视频观看历史记录
     */
	public function actionGet_video_watch_history(){
        $param=decodeAskParams($_REQUEST,1);
		checkArray($param,'gfid',1);
		$data=get_error(1,"获取失败");
		$gfid=$param['gfid'];
		$page=empty($param['page'])?0:$param['page'];
        $_GET['page']=$page;
		$pageSize=empty($param['pageSize'])?0:$param['pageSize'];
        $tdata=VideoClassify::model()->get_videoLive_type(365);
        $cr = new CDbCriteria;
        $cr->join = "join boutique_video_click_record on boutique_video_click_record.s_gfid=".$gfid." and boutique_video_click_record.video_id=t.id and boutique_video_click_record.if_del=648 JOIN video_classify on video_classify.id=t.video_classify";
        $cr->order = 'boutique_video_click_record.id DESC';
        $cr->group = 'boutique_video_click_record.video_id';
        $cr->select="t.id,concat(t.video_title,'  ',ifnull(boutique_video_click_record.video_series_title,'')) video_title,t.video_logo,t.video_publish_time,t.video_classify,boutique_video_click_record.last_time,video_classify.sn_name";
        $count = BoutiqueVideo::model()->count($cr);
        $pages = new CPagination($count);
        $pages->setPageSize($pageSize);
        $pages->applylimit($cr);
        $list=BoutiqueVideo::model()->findAll($cr,array(),false);
        $path_www=getShowUrl('file_path_url');
        $adv=array();
        foreach($list as $k=>$v){
        	$v['video_logo']=empty($v['video_logo'])?"":($path_www.$v['video_logo']);
        	$v['video_classify_name']=$v['sn_name'];
        	unset($v['sn_name']);
        	$adv[$k]=$v;
        }
		$data["datas"] = $adv;
		$data['totalCount']=$pages->getItemCount();
		$data['now_page']=$page;
		set_error_tow($data,1, 0, '获取成功',1,'获取失败',1);
    }

    /**
     * 添加视频下载记录
     */
	public function actionAdd_download_record(){
        $param=decodeAskParams($_REQUEST,1);
		$data=get_error(1,"添加失败");
		VideoDownloadRecord::model()->addDownloadRecord($param);
    }
    /**
     * 获取视频下载记录
     */
	public function actionGet_download_record(){
        $param=decodeAskParams($_REQUEST,1);
		$data=get_error(1,"获取失败");
		VideoDownloadRecord::model()->getDownloadRecord($param);
    }
    
}

?>