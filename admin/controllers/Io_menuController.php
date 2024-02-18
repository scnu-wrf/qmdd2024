
<?php
class Io_menuController extends BaseController {
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

	/**
	 * 获取单个菜单
	 * 44-2.0底部菜单,45-2.0GF平台-列表1,46-2.0GF平台-列表2,47-2.0GF平台-列表3,48-2.0说说-顶部菜单,49-2.0说说-服务功能
	      ,50-2.0我的(粉丝、关注、收藏、积分／体育豆),51-2.0我的订单,52-2.0我的管理,53-2.0我的服务,54-2.0设置
	      60-启动页
	 */	
	 public function actionGet_menu_by_ver(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"获取失败");
		$menu_type=$param['menu_type'];
		$menu_ver=empty($param['menu_ver'])?'':$param['menu_ver'];
//		$club_id=empty($param['club_id'])?'':$param['club_id'];
//		$project_id=empty($param['project_id'])?'':$param['project_id'];
		$dispay_type=empty($param['device_type'])?"":($param['device_type']+727);
		$menu_area=QmddFunctionArea::model()->find('id='.$menu_type);
		if(empty($menu_area)){
			set_error($data,1,'获取失败',1);
			return;
		}
		if(!empty($menu_ver)&&$menu_ver==$menu_area['f_version']){
			set_error($data,0,'已是最新版本',1);
		}
		$ver=$menu_area['f_version'];
    	$data['ver']=$ver;
    	$data['name']=str_replace('2.0','',$menu_area['area_name']);
    	
        $menu_data=QmddFunctionVer::model()->find(" id=".$menu_type);
        if(!empty($menu_data)&&$menu_data['F_ver']==$ver){
        	$data['datas']=json_decode($menu_data['f_data'],true);
        	if(empty($data['datas'])){
        		$data['datas']=array();
        	}
        }else{
        	$datas=QmddFuntionData::model()->getMenuData($param);
        	if(!empty($datas)){
        		$data['datas']=$datas;
        		if(empty($menu_data)){
        			$menu_data=new QmddFunctionVer();
                    $menu_data->isNewRecord = true;
        		}
        		$menu_data->id=$menu_type;
				$menu_data->F_ver=$ver;
				$menu_data->f_data=json_encode($datas,320);
				$res=$menu_data->save();
        	}
        }
		set_error($data,0, '获取成功',1);
    }

	public function actionGet_more_menu_by_ver(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"获取失败");
		$menu_type=$param['menu_type'];
		$menu_ver=empty($param['menu_ver'])?'':$param['menu_ver'];
		$type_array=explode(',',$menu_type);
		$ver_array=explode(',',$menu_ver);
		$ask_ver=array();
		foreach($type_array as $k=>$v){
			$ask_ver[$v]=empty($ver_array[$k])?'':$ver_array[$k];
		}
		$dispay_type=empty($param['device_type'])?"":($param['device_type']+727);
		$cr = new CDbCriteria;
        $cr->condition='id in('.$menu_type.')';
        $cr->select="id,area_name as name,f_version as ver";
		$menu_area=QmddFunctionArea::model()->findAll($cr,array(),false);
		if(empty($menu_area)||count($menu_area)==0){
			set_error($data,1,'获取失败',1);
			return;
		}
        $cr->select="F_ver,f_data";
        $get_num=0;
		foreach($menu_area as $k=>$v){
			$type_id=$v['id'];
			$ver=$v['ver'];
    		$menu_area[$k]['name']=str_replace('2.0','',$v['name']);
			if(!empty($ask_ver[$type_id])&&$ask_ver[$type_id]==$ver){
				unset($ask_ver[$type_id]);
				continue;
			}else{
				$get_num++;
		        $cr->condition=" id=".$type_id.' and F_ver='.$ver;
		        $menu_data=QmddFunctionVer::model()->find($cr,array(),false);
		        if(!empty($menu_data)&&$menu_data['F_ver']==$ver){
		        	$menu_area[$k]['datas']=json_decode($menu_data['f_data'],true);
		        	if(empty($menu_area[$k]['datas'])){
		        		$menu_area[$k]['datas']=array();
		        	}
		        }else{
		        	$datas=QmddFuntionData::model()->getMenuData(array('menu_type'=>$type_id,'device_type'=>$dispay_type));
		        	if(!empty($datas)){
			        	$menu_area[$k]['datas']=$datas;
		        		if(empty($menu_data)){
		        			$menu_data=new QmddFunctionVer();
		                    $menu_data->isNewRecord = true;
		        		}
						$menu_data->id=$type_id;
						$menu_data->F_ver=$ver;
						$menu_data->f_data=json_encode($datas,320);
						$res=$menu_data->save();
		        	}
		        }
			}
		}
		$data['datas']=$menu_area;
		set_error_tow($data,count($data['datas']), 0, '获取成功',1,'获取失败',1);
    }
    
    /**
     * 项目
     */
    public function actionGet_project_list(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"获取失败");
		$now_ver=empty($param['ver'])?'':$param['ver'];
		$menu_data=BaseData::model()->find("F_CODE='PROJECT_LIST'");
		if(empty($menu_data)){
			set_error($data,1,'获取失败',1);
			return;
		}
		if(!empty($now_ver)&&$now_ver==$menu_data['F_ver']){
			set_error($data,0,'已是最新版本',1);
		}
    	$data['ver']=$menu_data['F_ver'];
    	$data['defaul_id']=$menu_data['f_defaul_id'];
    	$data['defaul_name']=$menu_data['f_defaul_name'];
        $data['datas']=array();
        if(!empty($menu_data['f_data'])){
        	$data['datas']=json_decode('['.$menu_data['f_data'].']',true);
        }
		set_error_tow($data,count($data['datas']), 0, '获取成功',1,'获取失败',1);
    }
    
    /**
     * 国家
     */
    public function actionGet_country_list(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"获取失败");
		$now_ver=empty($param['ver'])?'':$param['ver'];
		$menu_data=BaseData::model()->find("F_CODE='country'");
		if(empty($menu_data)){
			set_error($data,1,'获取失败',1);
			return;
		}
		if(!empty($now_ver)&&$now_ver==$menu_data['F_ver']){
			set_error($data,0,'已是最新版本',1);
		}
    	$data['ver']=$menu_data['F_ver'];
        $data['datas']=array();
        if(!empty($menu_data['f_data'])){
        	$data['datas']=json_decode($menu_data['f_data'],true);
        }else{
			$cr = new CDbCriteria;
			$cr->condition='1=1';
        	$cr->select="id,country_code_three as code,english_name as country_en,chinese_name as country_cn,country_code as sms_code,if(is_visible=649,1,0) is_show,(select count(region.id) from t_region region where country_id='{$country_id}' and region.upper_region='') total_count";
        	$country_data=TCountry::model()->findAll($cr,array(),false);
			if(!empty($country_data)){
	        	$data['datas']=$country_data;
	        	$menu_data->f_data=json_encode($country_data,320);
	        	$res=$menu_data->update($menu_data);
			}
        }
		set_error_tow($data,count($data['datas']), 0, '获取成功',1,'获取失败',1);
    }
    
    /**
     * 省/市/区（县）/街道（乡镇）
     * 根据国家country_id
     * 区域编号 获取下级列表
     */
    public function actionGet_region_list(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"获取失败");
		checkArray($param,"country_id",1);
		$country_id=$param['country_id'];
		$parent_code=empty($param['parent_code'])?"":$param['parent_code'];
		$now_ver=empty($param['ver'])?'':$param['ver'];
		$region_code='region_'.$country_id.(empty($parent_code)?'':('_'.$parent_code));
		$menu_data=BaseData::model()->find("F_CODE='".$region_code."'");
		$where="country_id=".$country_id." and upper_region='".$parent_code."'";
		$select="id as code,code as region_code,IFNULL(upper_region,'') as upper_region,region_name_c,region_name_e,(select count(region.id) from t_region region where country_id='{$country_id}' and region.upper_region=t.id) total_count";
		$cr = new CDbCriteria;
        $cr->condition=$where;
        $cr->select=$select;
		if(empty($menu_data)){
			$datas=TRegion::model()->findAll($cr,array(),false);
			if(!empty($datas)){
				$data['datas']=$datas;
				$menu_data=new BaseData();
				unset($menu_data->id);
				$menu_data->F_CODE=$region_code;
				$menu_data->F_ver='0.001';
				$menu_data->f_data=json_encode($datas,320);
				$res=$menu_data->insert($menu_data);
				if($res){
	    			$data['ver']=$menu_data->F_ver;
					$data['datas']=$datas;
					set_error_tow($data,count($data['datas']), 0, '获取成功',1,'获取失败',1);
				}
			}
			set_error($data,1,'获取失败',1);
			return;
		}
		if(!empty($now_ver)&&$now_ver==$menu_data['F_ver']){
			set_error($data,0,'已是最新版本',1);
		}
    	$data['ver']=$menu_data['F_ver'];
        $data['datas']=array();
        if(!empty($menu_data['f_data'])){
        	$data['datas']=json_decode($menu_data['f_data'],true);
        }else{
			$datas=TRegion::model()->findAll($cr,array(),false);
			if(!empty($datas)){
	        	$data['datas']=$datas;
	        	$menu_data->f_data=json_encode($datas,320);
	        	$res=$menu_data->update($menu_data);
			}
        }
		set_error_tow($data,count($data['datas']), 0, '获取成功',1,'获取失败',1);
    }
    
    
    /**
     * 拉取表情包列表及表情包版本号
     * (当本地缓存版本号与获取版本号不一样时，请求Get_brow_data传入id+本地缓存版本号)
     */
    public function ActionGet_brow_list(){
		$data=get_error(1,"获取失败");
		$cr = new CDbCriteria;
        $cr->condition='state=2 and if_user=506';
        $cr->select='id,brow_title,brow_pic,brow_banner,brow_describe,version,brow_type';
    	$brow_list=GfBrow::model()->findAll($cr,array(),false);
    	$data['datas']=$brow_list;
		set_error_tow($data,count($brow_list), 0, '获取成功',1,'获取失败',1);
    }
    
    /**
     * 根据表情包id+版本号获取表情列表,(当本地缓存版本号与Get_brow_list获取版本号不一样时，请求传入本地缓存版本号)
     * 版本号为最新时返回error=0但不返回datas
     */
    public function ActionGet_brow_data(){
        $param=decodeAskParams($_REQUEST,0);
		$data=get_error(1,"获取失败");
		checkArray($param,"id",1);
		$ver=empty($param['ver'])?'':$param['ver'];
		$id=$param['id'];
		$cr = new CDbCriteria;
        $cr->condition='id='.$id;
        $cr->select='version,if(state=2 and if_user=506,1,0) online';
    	$brow=GfBrow::model()->find($cr,array(),false);
    	if(empty($brow)||$brow['online']==0){
    		set_error($data,2,'该表情包不存在',1);
    	}
    	if($ver==$brow['version']){
    		set_error($data,0,'该表情包已是最新版本',1);
    	}
    	$data['ver']=$brow['version'];
        $cr->condition='brow_id='.$id;
        $cr->select="id,brow_cover_map,IF(ifnull(brow_img,'')='',brow_cover_map,brow_img) as brow_img,brow_img_label";
		$list = GfBrowData::model()->findAll($cr,array(),false);
    	$data['datas']=$list;
		set_error_tow($data,count($list), 0, '获取成功',1,'获取失败',1);
    }
}
?>