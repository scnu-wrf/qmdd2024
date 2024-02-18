<?php
/**
 * 会员-前端接口
 * @author xiyan
 */
class Io_userController extends BaseController {
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
    /**
     * 获取个人资料-报名信息
     */
	public function actionGetRegistrationDatas(){
        $param=decodeAskParams($_REQUEST,1);
        $data=get_error(1,'获取失败');
        /**
         * 动态展示数据{type_state,type_title,type_notify,param,hide}
	     * type_state 展示类型；0-显示项，5-输入项，21-分隔项，104-图片选择项
	     * type_title 展示标题
	     * type_notify 提示内容
	     * param 参数名称
	     * hide 是否隐藏，1-隐藏
         */	
         $data['show_data']=json_decode(base64_decode('W3sgICJ0eXBlX3N0YXRlIjogMCwgImhpZGUiOiAxLCAidHlwZV90aXRsZSI6ICLlp5PlkI0iLCAidHlwZV9ub3RpZnkiOiAiIiwicGFyYW0iOiAicmVhbF9uYW1lIn0sIHsgInR5cGVfc3RhdGUiOiA1LCAidHlwZV90aXRsZSI6ICLnn63lkI0iLCAidHlwZV9ub3RpZnkiOiAi6K+36L6T5YWlIiwgICJwYXJhbSI6ICJzaG9ydF9uYW1lIn0sIHsidHlwZV9zdGF0ZSI6MCwgInR5cGVfdGl0bGUiOiAi5oCn5YirIiwgInR5cGVfbm90aWZ5IjogIiIsICJwYXJhbSI6ICJzZXgiIH0sICAgeyJ0eXBlX3N0YXRlIjowLCAidHlwZV90aXRsZSI6ICLlh7rnlJ/ml6XmnJ8iLCAidHlwZV9ub3RpZnkiOiAiIiwgInBhcmFtIjogImJvcm4iIH0seyJ0eXBlX3N0YXRlIjoyMSwidHlwZV90aXRsZSI6IiJ9LCAgeyAidHlwZV9zdGF0ZSI6IDAsICJ0eXBlX3RpdGxlIjogIuexjei0ryIsICJ0eXBlX25vdGlmeSI6ICIiLCAicGFyYW0iOiAibmF0aXZlIiB9LHsidHlwZV9zdGF0ZSI6IDAsICJ0eXBlX3RpdGxlIjogIuawkeaXjyIsICJ0eXBlX25vdGlmeSI6ICIiLCAicGFyYW0iOiAibmF0aW9uIn0seyAidHlwZV9zdGF0ZSI6IDAsICJ0eXBlX3RpdGxlIjogIui6q+S7veivgeWPtyIsICJ0eXBlX25vdGlmeSI6ICIiLCAicGFyYW0iOiAiaWRfY2FyZCIgfSx7InR5cGVfc3RhdGUiOiAxMiwgInR5cGVfdGl0bGUiOiAi5omL5py65Y+356CBIiwgInR5cGVfbm90aWZ5IjogIuivt+i+k+WFpSIsICJwYXJhbSI6ICJyZWdpc3RyYXRpb25fcGhvbmUiIH0seyJ0eXBlX3N0YXRlIjogMTEsICJ0eXBlX3RpdGxlIjogIuaJgOWcqOWMuuWfnyIsICJ0eXBlX25vdGlmeSI6ICLor7fpgInmi6kiLCAicGFyYW0iOiAicmVnaXN0cmF0aW9uX2FyZWEiIH0seyJ0eXBlX3N0YXRlIjoyMSwidHlwZV90aXRsZSI6IiJ9LCAgeyJ0eXBlX3N0YXRlIjogNSwgInR5cGVfdGl0bGUiOiAi5L2T6YeNKEtnKSIsICJ0eXBlX25vdGlmeSI6ICLor7fovpPlhaUiLCAgInBhcmFtIjogIndlaWdodCJ9LCB7InR5cGVfc3RhdGUiOiA1LCAidHlwZV90aXRsZSI6ICLouqvpq5goY20pIiwgInR5cGVfbm90aWZ5IjogIuivt+i+k+WFpSIsICJwYXJhbSI6ICJoZWlnaHQifSwgeyJ0eXBlX3N0YXRlIjowLCAidHlwZV90aXRsZSI6ICLpvpnomY7nrYnnuqciLCAidHlwZV9ub3RpZnkiOiAiIiwgInBhcmFtIjogImxoIiB9LHsidHlwZV9zdGF0ZSI6MjEsInR5cGVfdGl0bGUiOiIifSwgIHsidHlwZV9zdGF0ZSI6MTA0LCAidHlwZV90aXRsZSI6ICLkuIrkvKDlm77niYciLCAidHlwZV9ub3RpZnkiOiAiIiwgInBhcmFtIjogInJlY2VudF9waG90byJ9LCB7InR5cGVfc3RhdGUiOiAxMDQsICJ0eXBlX3RpdGxlIjogIuS/nemZqSIsICJ0eXBlX25vdGlmeSI6ICIiLCAicGFyYW0iOiAiaW5zdXJhbmNlX3BpYyJ9XQ=='));
		$datas=userlist::model()->GetRegistrationDatas($param,0);
		if(!empty($datas)){
			$data['datas']=$datas;
			set_error($data,0,'获取成功',1);
		}
		set_error($data,0,'报名信息获取失败',1);
    }
	/**
	 * 修改个人资料-报名信息
	 */
	public function actionUpdateRegistrationDatas(){
        $param=decodeAskParams($_REQUEST,1);
		$data=get_error(1,"保存失败");
		$tadd=userlist::model()->UpdateRegistrationDatas($param);
        set_error_tow($data,$tadd,0,'保存成功',1,"保存失败",1);
    }
    
    /**
     * 入驻类型列表
     */
    public function actionJoin_type(){
		$data=get_error(1,"获取失败");
		$img_dir=getShowUrl('file_path_url');
		$gw_url=getShowUrl("gw_url");
        $cr = new CDbCriteria;
        $cr->condition="if_user=649 and function_area_id=58";
        $cr->order = 'dispay_num desc';
        $cr->select="function_id as id,dispay_title as name,if(IFNULL(dispay_icon,'')='','',concat('{$img_dir}',dispay_icon)) as img";
        $datas=QmddFuntionData::model()->findAll($cr,array(),false);
        foreach($datas as $k=>$v){
        	switch($v['id']){
        		case 159:
        		$datas[$k]['description']='官方组织、科教组织、社会组织、全媒体联盟、企业组织等服务机构入驻及提供推广管理平台';
        		$datas[$k]['rule_name']='入驻说明';
        		$datas[$k]['rule_url']=$gw_url.'?c=info&a=page_switch&category=article&device_type=5&page=战略伙伴入驻服务指南';
        		$datas[$k]['add_name']='入驻';
        		$datas[$k]['type']=189;
        		break;
        		case 160:
        		$datas[$k]['description']='俱乐部、服务机构、个人等运营单位入驻及提供运营管理平台';
        		$datas[$k]['rule_name']='入驻说明';
        		$datas[$k]['rule_url']=$gw_url.'?c=info&a=page_switch&category=article&device_type=5&page=社区单位服务协议';
        		$datas[$k]['add_name']='入驻';
        		$datas[$k]['type']=8;
        		break;
        		case 34:
        		$datas[$k]['description']='裁判员、教练员、单位管理员、摄影师、摄像师、康复等专业服务者入驻及提供在线从业服务';
        		$datas[$k]['rule_name']='入驻说明';
        		$datas[$k]['rule_url']=$gw_url.'?c=info&a=page_switch&category=article&device_type=5&page=服务者入驻规则';
        		$datas[$k]['add_name']='入驻';
        		break;
        		case 10:
        		$datas[$k]['description']='战略伙伴的会员（单位/个人)入会服务';
        		$datas[$k]['rule_name']='入会说明';
        		$datas[$k]['rule_url']=$gw_url.'?c=info&a=page_switch&category=article&device_type=5&page=GF平台/得闲体育功能简介';
        		$datas[$k]['add_name']='入会';
        		break;
        		case 1:
        		$datas[$k]['description']='社区单位学员注册服务';
        		$datas[$k]['rule_name']='注册说明';
        		$datas[$k]['rule_url']=$gw_url.'?c=info&a=page_switch&category=article&device_type=5&page=GF平台/得闲体育功能简介';
        		$datas[$k]['add_name']='注册';
        		break;
        	}
        }
        $data['datas']=$datas;
        set_error_tow($data,count($datas),0,'保存成功',1,"保存失败",1);
    }
    
    
}

?>