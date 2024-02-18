
<?php
class Io_publicController extends BaseController {
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

	/**
	 * 获取2.0菜单
	 * 44-2.0底部菜单,45-2.0GF平台-列表1,46-2.0GF平台-列表2,47-2.0GF平台-列表3,48-2.0说说-顶部菜单,49-2.0说说-服务功能
	      ,50-2.0我的(粉丝、关注、收藏、积分／体育豆),51-2.0我的订单,52-2.0我的管理,53-2.0我的服务,54-2.0设置
	 */
	public function actionGet_home_menu(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"获取失败");
		$menu_type=$param['menu_type'];
		$club_id=empty($param['club_id'])?"":$param['club_id'];
		$project_id=empty($param['project_id'])?"":$param['project_id'];
		$dispay_type=empty($param['device_type'])?"":($param['device_type']+727);
		$img_dir=parent::get_base_path('qmdd_funtion_data','dispay_icon');
		$mt=explode(',',$menu_type);
//		$select="fd.function_id as id,if(ISNULL(fd.id),IFNULL(qf.function_title,''),fd.dispay_title) as name,if(IFNULL(fd.dispay_icon,'')='',if(IFNULL(qf.function_icon,'')='','',concat('{$img_dir}',qf.function_icon)),concat('{$img_dir}',fd.dispay_icon)) as img,if(IFNULL(fd.dispay_click_icon,'')='',if(IFNULL(qf.function_click_icon,'')='','',concat('{$img_dir}',qf.function_click_icon)),concat('{$img_dir}',fd.dispay_click_icon)) as click_img";
//
//		$datas=array();
//		$d_table='qmdd_function qf';
//		$d_select="qf.id,IFNULL(qf.function_title,'') as name,if(IFNULL(qf.function_icon,'')='','',concat('{$img_dir}',qf.function_icon)) as img,if(IFNULL(qf.function_click_icon,'')='','',concat('{$img_dir}',qf.function_click_icon)) as click_img";
//		foreach($mt as $k=>$v){
//			$show_sql_data=$this->getShowSql($v,$dispay_type,$club_id,$project_id);
//			$datas[$v]=parent::get_data_list($show_sql_data['where']." group by fd.function_id",$select,$show_sql_data['table'],"fd.dispay_num desc",0,0,"**");
//		}
//		if(count($mt)>1){
//			$data['datas']=$datas;
//		}else{
//			$data['datas']=$datas[$menu_type];
//		}
		set_error_tow($data,count($data['datas']), 0, '获取成功',1,'获取失败',1);
    }
    
    /**
     * 1-赛事、2-活动、3-培训、4-课程、5-直播、6-资讯动态
     */
    public function actionGet_subscribe_news(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"获取失败");
//        checkArray($param,"visit_gfid",1);
//		$visit_gfid=$param['visit_gfid'];
		$total=8;
        $data['now_page']=1;
        $data['total_count']=$total;
		$datas=array();
		$i=0;
        $cr = new CDbCriteria;
        $cr->condition=" if_del=506 and state in (2,2) and (now() between news_date_start and news_date_end) group by news_type order by news_id desc limit 3";
        $cr->select='6 as type,club_id,news_club_name as club_name,id as news_id,news_title,news_type,news_pic as news_logo,state_time as news_publish_time,0 as project_id';
        $array=ClubNews::model()->findAll($cr,array(),false);
        foreach($array as $v){
        	$datas[$i]=$v;
        	$i++;
        }
        
        $cr->condition="state in (2,2) and (now() between dispay_star_time and dispay_end_time) order by news_id desc ";
        $cr->select='1 as type,game_club_id as club_id,game_club_name as club_name,id as news_id,game_title as news_title,game_type as news_type,game_small_pic as news_logo,publish_time as news_publish_time,0 as project_id';
        $array=GameList::model()->find($cr,array(),false);
        if(!empty($array)){
        	$datas[$i]=$array;
        	$i++;
        }
        
        $cr->condition="state in (2,2) and (now() between dispay_star_time and dispay_end_time) order by news_id desc ";
        $cr->select='2 as type,activity_club_id as club_id,activity_club_name as club_name,id as news_id,activity_title as news_title,0 as news_type,activity_small_pic as news_logo,audit_time as news_publish_time,0 as project_id';
        $array=ActivityList::model()->find($cr,array(),false);
        if(!empty($array)){
        	$datas[$i]=$array;
        	$i++;
        }
        
        $cr->condition="train_state in (2,2) and (now() between dispay_start_time and dispay_end_time) order by news_id desc ";
        $cr->select='3 as type,train_clubid as club_id,train_clubname as club_name,id as news_id,train_title as news_title,0 as news_type,train_logo as news_logo,audit_time as news_publish_time,ifnull(train_project_id,0) as project_id';
        $array=ClubStoreTrain::model()->find($cr,array(),false);
        if(!empty($array)){
        	$datas[$i]=$array;
        	$i++;
        }
        
        $cr->condition="state in (2,2) and (now() between dispay_star_time and dispay_end_time) order by news_id desc ";
        $cr->select='4 as type,course_club_id as club_id,course_club_name as club_name,id as news_id,course_title as news_title,course_type_id as news_type,course_small_pic as news_logo,audit_time as news_publish_time,ifnull(project_id,0) as project_id';
        $array=ClubStoreCourse::model()->find($cr,array(),false);
        if(!empty($array)){
        	$datas[$i]=$array;
        	$i++;
        }
        
        $cr->condition="is_uplist=1 and state=1364 and if_del=648 and channelState in(1,696) and (now() between live_start and live_end) order by news_id desc ";
        $cr->select='5 as type,club_id,club_name,id as news_id,title as news_title,live_type as news_type,logo as news_logo,live_start as news_publish_time,0 as project_id';
        $array=VideoLive::model()->find($cr,array(),false);
        if(!empty($array)){
        	$datas[$i]=$array;
        	$i++;
        }
       $data['datas']=$datas;
		set_error_tow($data,$total, 0, '获取成功',1,'获取失败',1);
    	
    }

}

?>