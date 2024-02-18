<?php

class  GfServiceData extends BaseModel {
    public $pid = '';
    public $count1 = '';
    public $count2 = '';
	public $count = '';
    public $amount = '';
    public function tableName() {
        return '{{gf_service_data}}';
    }

    /**
     * 模型验证规则
     */
    
     public function rules() {
        return array(
            //array('sign_game_contect', 'numerical', 'integerOnly' => true),
            array('state,reasons_for_failure,order_num,order_type,service_type,service_type_name,project_id,
                    project_name,data_id,data_name,gfid,gf_account,gf_name,service_id,service_name,service_data_id,
                    service_data_name,servic_time_star,servic_time_end,cancelled,cancel_time,service_address,sign_code,sign_come,
                    sign_longitude,sign_latitude,sign_back,t_stypeid,t_stypename,message,shopping_order_num,free_make,
                    free_money,sending_notice_time,pay_confirm,pay_comfirm_time,order_state,buy_price,adminid,is_pay,
                    pay_adminid,pay_admin_name,gf_gross,gf_money,club_gross,club_money', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'game_list_id' => array(self::BELONGS_TO, 'GameList', 'service_id'),
            'game_list_data' => array(self::BELONGS_TO, 'GameListData', 'service_data_id'),
            // 'game_team_table' => array(self::BELONGS_TO, 'GameTeamTable', 'team_id'),
            'serviceTypeName' => array(self::BELONGS_TO, 'BaseCode', 'service_type'),
            'sName' => array(self::BELONGS_TO, 'QmddServerSourcer', 'service_id'),
            'orderNum' => array(self::BELONGS_TO, 'QmddAchievemenData', 'info_order_num'),
            'mall_order_num' => array(self::BELONGS_TO, 'MallSalesOrderInfo', 'info_order_num'),
            'train_list_data' => array(self::BELONGS_TO, 'ClubTrainData', 'service_data_id'),
            'train_sign' => array(self::BELONGS_TO, 'ClubTrainSign', ['order_num'=>'order_num']),
            'course_list' => array(self::BELONGS_TO, 'ClubStoreCourse', 'service_id'),
            'activity_sign' => array(self::BELONGS_TO, 'ActivitySignList', ['order_num'=>'order_num']),
            'service_data' => array(self::BELONGS_TO, 'QmddServerSetData', 'service_data_id'),
            'admin_list' => array(self::BELONGS_TO, 'QmddAdministrators', 'adminid'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'order_num'=>'服务流水号',
            'message'=>'用户留言',
            'order_type'=>'服务类型',
            'order_type_name'=>'服务类型',
			'service_type'=>'服务来源',
			'service_type_name'=>'服务来源',
            'game_user_type' => '赛事类型',
            'project_id' => '服务项目',
            'project_name'=>'服务项目',
            'data_id' => '服务主体',
            'data_name' => '服务标题',
            'supplier_id' => '服务单位',
            'gfid' => '下单人',
            'gf_account' => '帐号',
			'gf_name' => '预订人',
            'contact_phone' => '联系电话',
            'service_id' => '服务名称',
            'service_code' => '服务编码',
            'service_ico' => '缩列图',
            'service_name' => '服务名称',
            'service_data_id' => '规格属性',
            'service_data_name' => '服务时间',  // 预订服务时段
            'servic_time_star'=>'开始时间',
            'servic_time_end'=>'结束时间',
			'buy_count' => '数量',
            'set_code' => '方案编号', 
			'set_name' => '方案名称',
			'buy_price' => '金额(元)',
			'udate' => '发生时间',
			'check_way' => '审核方式',
			'state'=>'审核状态',
			'reasons_for_failure'=>'操作备注',
			'adminid'=>'管理员',
			'admin_name'=>'管理员名称',
			'state_time'=>'操作时间',
			'order_itme'=>'订单类型',
			'info_order_num'=>'订单编号',
			'is_pay'=>'支付状态',
            'order_state'=>'订单状态',
            'order_state_name'=>'订单状态',
            'server_state'=>'服务状态',
            'add_time'=>'预订时间',
            'cancelled'=>'取消单',
            'service_address'=>'服务地址',
            'sign_code'=>'签到验证码',
            'sign_come'=>'签到时间',
            'sign_longitude'=>'签到经度',
            'sign_latitude'=>'签到纬度',
            'sign_back'=>'签退时间',
            't_stypeid'=>'服务类型ID',
            't_stypename'=>'服务类别',
            'shopping_order_num' => '订单编号',  //购物车单号 关联mall_shopping_settlement表order_num
            'free_make' => '收费方式',  //  0是免费，1是收费
            'free_money' => '免费金额',
            'sending_notice_time' => '通知时间',
            'pay_confirm' => '是否确认',  // 0：未确认，1：已确认
            'pay_confirm_time' => '确认时间',
            'pay_adminid' => '缴费确认人',
            'pay_admin_name' => '操作员',
            'notice_content' => '通知内容',
            'gf_gross' => '平台毛利（%）',
            'gf_money' => '平台结算额（元）',
            'club_gross' => '单位毛利率（%）',
            'club_money' => '单位结算额（元）',
            'is_invalid' => '签到状态', // 签到状态,1=有效，2=失效，3=补签

            /* 赛事签到 */
            'service_game_id' => '赛事名称',
            'service_game_data_id' => '竞赛项目',
            'service_game_time' => '比赛开始时间',
            'order_num1' => '订单号',
            'service_code1' => '赛事编号',
            'gf_name1' => '姓名/名称',
            'gf_name2' => '参赛选手/团队',
            'buy_price1' => '费用',
            'buy_price2' => '实付金额',
            'buy_price3' => '实缴报名费',
            'udate1' => '操作时间',
            'uptype' => '报名类型',
            'stay_state' => '状态',
            'supplier_id1' => '发布单位',
            'mall_time' => '支付时间',
            'mall_pay_type' => '支付方式',
            'mall_payment_code' => '支付流水号',
            'server_name_frontEnd' => '服务名称（前端）',
            'service_resources' => '服务资源',
            'adminid2' => '签到操作员',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->add_time = date('Y-m-d h:i:s');
        }
        $this->udate = date('Y-m-d h:i:s');
        return true;
    }

    public function getCode($fater_id) {
        return $this->findAll('fater_id=' . $fater_id);
    }
	
	public function getMaxnum() {
        $md=str_replace('-', '',substr(date('Y-m-d H:i:s'),0,10));
        $tmp= $this->findBysql("select max(order_num) order_num from ".$this->tableName()." where  left(order_num,8)='{$md}'");
        $rs="";
        if (!empty($tmp)){
            $rs=$tmp['order_num'];
        }
        return $rs;
    }
    
    /**
     * 添加服务单
     */
    public function addServiceData($enter){
    	if($enter['order_type']!=351||$enter['game_user_type']==790){//非赛事报名／裁判报名
	    	$enter['state']=371;
	    	$enter['order_state']=1168;
	    	if($enter['check_way']==793||$enter['order_type']==353){//自动审核／动动约
	    		$enter['order_state']=1169;
	    		$enter['state']=2;
	    	}
    	}
    	if($enter['order_type']==351&&$enter==665){//赛事报名个人赛
			$enter['state']=371;
			$enter['order_state']=1168;
		}
    	$gfServiceData=new GfServiceData;	
		$add=$gfServiceData->insert($enter);//写入服务报名表
    	if($add&&empty($enter['order_num'])){
    		$add_id=$gfServiceData->id;
    		$enter['id']=$add_id;
    		//生成服务单编号
    		$code=BaseNo::model()->get_table_code_base(array('table_name'=>'gf_service_data','code_param'=>'order_num','id_param'=>'id','code_length'=>'6','table_id'=>$add_id,'code_year'=>date("Y"),'code_month'=>date("m"),'code_day'=>date("d"),'code_head'=>''));
			
			if(empty($code)){
    			return null;
    		}
    		$enter['order_num']=$code;
    		$gfServiceData->order_num=$enter['order_num'];
    		$add=$gfServiceData->update($gfServiceData);
    		if($add){
    			return $enter;
    		}
    	}
    	return null;
    }
    
    /**
     * 赛事审核通过后缴费订单
     * d.id as details_id,d.set_id,IFNULL(car.gf_service_id,0) as gf_service_id
     * $price_set=array(details_id,set_details_id,set_code,set_id,set_name,shopping_price,shopping_beans,buy_level,buy_level_no,buy_level_name)
     */
    public function addGamePayOrder($param){
    	$gfid=$param['visit_gfid'];
    	$service_order_num=$param['order_num'];
		$price_set=$param['price_set'];
		$gf_user=$param['gf_info'];
		$where="order_num='".$service_order_num."'";
		$gfservice_data=$this->find($where);
		if(empty($gfservice_data)||$gfservice_data['order_type']!=351){
			return array('error'=>1,'msg'=>'服务单获取异常');
		}
		$order_type=$gfservice_data['order_type'];
    	if($gfservice_data['buy_price']<=0&&$gfservice_data['buy_bean']<=0){
    		$gfservice_data->is_pay=464;
    		$gfservice_data->order_state=1462;
			$res=$gfservice_data->update($gfservice_data);
			$update_array=array('is_pay'=>464);
			$res=GameSignList::model()->updateAll($update_array,$where);//更新报名成员信息
			$res=GameteamData::model()->updateAll($update_array,$where);//更新团队信息
			return array('error'=>0,'msg'=>'该服务免费');
    	} 
    	$pay_time=1800;//支付限制时间
    	$money=$price_set['shopping_price'];
        $add_order=toIoArray($gfservice_data,'order_type:order_type,gfid:order_gfid,gf_account:order_gfaccount,gf_name:order_gfname,contact_phone:contact_phone,buy_price:money,buy_bean:beans,service_ico:product_ico',array());
        $add_order['buyer_type']=210;
        $add_order['order_Date']=get_date();
        $add_order['total_money']=$money;
        $add_order['order_money']=$money;
        $add_order['effective_time']=date("Y-m-d H:i:s",$pay_time);
        $in_order = Carinfo::model()->addOrder($add_order);//写入待支付订单
        $in_order_num=$in_order['order_num'];
        if(empty($in_order_num)){
        	return array('error'=>2,'msg'=>'生产订单失败');
        }
    
        // 购物车详细
        $add_order_data=CommonTool::model()->getKeyArray($gfservice_data,'id,order_type,order_type_name,gfid,gf_name,buy_price,buy_bean,supplier_id,supplier_name,project_id,project_name,service_id,service_code,service_ico,service_name,show_service_title,service_data_id,service_data_name,show_service_data_title',array('id'=>'gf_service_id','buy_bean'=>'buy_beans'));
        $add_order_data=array_merge($add_order,CommonTool::model()->getKeyArray($price_set,'details_id,set_details_id,set_id,set_name,sale_show_id,shopping_price,shopping_beans,buy_level,buy_level_no,buy_level_name',array('shopping_price'=>'buy_price','shopping_beans'=>'buy_beans')));
        $add_order_data['buyer_type']=210;
        $add_order_data['buy_count']=1;
        $add_order_data['order_no']=0;
        $add_order_data['uDate']=get_date();
        $add_order_data['total_pay']=$money;
        $add_order_data['buy_amount']=$money;
        $add_order_data['order_num']=$in_order_num;
        $add_order_data['effective_time']=$add_order['effective_time'];
        
        $add_data=CardataCopy::model()->addOrderData($add_order_data);//写入待支付订单详细
       return array('error'=>0,'msg'=>'该服务免费','pay_order_num'=>$in_order_num);
    }


    /**
     * 获取动动约订单列表
     * 请求参数：
用户id，page，per_page，
order_state（订单状态：0-全部，1-待支付、2-已支付、3-已关闭），
type_code（动动约服务类型：0-全部类型,2-教练,3-摄像,12-摄影,13-运动康复,14-场地,15-约练,16-约赛）

返回参数：
order_state_list订单状态[{id编号,name名称}]；
datas[{order_num销售订单号,show_order_title发布单位与订单类型,state_name订单状态,effective_time支付超时时间,control订单可操作功能（待支付（取消订单+支付）；已支付（无）；已关闭（删除）；）,service_pic缩略图url,service_name服务名称,service_fee服务费用,service_content服务类型与服务内容html}]
control（可操作功能：1-取消订单，2-支付，3-删除，4-签到，5-退订，6-评价）
     */
    public function GetDdyOrderList($param){
		checkArray($param,'visit_gfid',1);
		$data=get_error(1,"获取失败");
        $gfid = $param['visit_gfid'];
        $per_page = empty($param['per_page'])?10:$param['per_page'];
        $page=empty($param['page'])?1:$param['page'];
        $page_s = ($page-1)*$per_page;
        $order_state = empty($param['order_state'])?0:$param['order_state'];
        $type_code = empty($param['type_code'])?0:$param['type_code'];
        
        $no_limit=array('id'=>'0','name'=>'全部');
        $cr = new CDbCriteria;
        $cr->condition='f_id in(1169,1462,1173)';
        $cr->order = 'f_typecode';
        $order_state_list=BaseCode::model()->findAll($cr);
        $order_state_list=cArray($order_state_list,'f_id as id,F_SHORTNAME as name');
        array_unshift($order_state_list,$no_limit);
        $data['order_state_list']=$order_state_list;
        
        $w="ifnull(shopping_order_num,'')<>'' and order_type=353 and (is_show=649 or order_state<>1173) and gfid=".$gfid;
        $w=get_where($w,$type_code,'t_stypeid',$type_code);
        if(empty($order_state)){
        	$w.=" and order_state in(1169,1462,1173)";
        }else{
        	$w.=" and order_state =".$order_state;
        }
        $cr = new CDbCriteria;
        $cr->condition=$w." group by shopping_order_num order by order_id desc limit ".$page_s.",".$per_page;
        $cr->select="max(id) as order_id,shopping_order_num as order_num,supplier_id as club_id,supplier_name as club_name,project_id,order_state,order_state_name as state_name,ifnull(effective_time,'') as effective_time,service_ico as service_pic,service_name,sum(buy_price) as service_fee,t_stypename,group_concat(concat(ifnull(show_service_data_title,show_service_title),' ¥',buy_price) separator '<br/>') as service_content";
        $datas=$this->findAll($cr,array(),false);
        foreach($datas as $k=>$v){
        	$datas[$k]['order_type_name']='动动约';
        	$datas[$k]['show_order_title']=$datas[$k]['order_type_name'].' | '.$v['club_name'];
        	$datas[$k]['service_fee']='¥'.$v['service_fee'];
        	$datas[$k]['service_content']=$v['t_stypename'].'<br/>'.$v['service_content'];
        	$datas[$k]['control']='0';
        	switch($v['order_state']){
        		case 1169://待支付
        		$datas[$k]['control']='1,2';
        		break;
        		case 1173://已关闭
        		$datas[$k]['control']='3';
        		break;
        	}
        	unset($datas[$k]['order_id']);
        	unset($datas[$k]['t_stypename']);
        }
        
		$cr->condition=$w;
		$cr->group='shopping_order_num';
        $cr->select='shopping_order_num';
        $total=$this->count($cr,array());
//        $get_count = Yii::app()->db->createCommand('select count(distinct shopping_order_num) as c from gf_service_data where '.$w)->queryAll();
//        $total=count($get_count)>0?$get_count[0]['c']:0;
    	
		$data['datas']=$datas;
		$data['totalCount']=$total;
		$data['now_page']=$page;
		set_error_tow($data,$total,0,"拉取数据成功",0,"无数据",1);
    }
    
    /**
     * 获取动动约订单详情
     * 请求参数：用户id，order_num销售订单号
返回参数：datas[{order_detail销售订单号信息html（订单编号+预定人+联系电话+支付方式+支付时间（仅当已支付状态有支付方式和支付时间））,show_order_title发布单位与订单类型,state_name订单状态，state_notify订单状态提示（待支付-，已支付-请注意服务单开始时间 ，已关闭-订单已取消 ）,effective_time支付超时时间,control订单可操作功能（待支付（取消订单+支付）；已支付（无）；已关闭（删除）；）,service_pic缩略图url,service_name服务名称,service_type服务类型名称，service_fee_title订单总价（固定词），service_fee服务费用,service_datas服务列表[{fee价格,content内容（根据服务类型其格式为：
教练：项目+日期+时段，如 台球 09/15 07:00-08:00
场地：项目+场地类型+场地名称+日期+时段，如 台球 单场 1号场 09/15 07:00-08:00 
摄影／摄像／运动康复：日期+时段，如 09/15 07:00-08:00）}]}]
control（可操作功能：1-取消订单，2-支付，3-删除，4-签到，5-退订，6-评价）
     */
	public function getDdyOrderDetail($param){
		checkArray($param,'visit_gfid,order_num',1);
		$data=get_error(1,"获取失败");
        $gfid = $param['visit_gfid'];
        $order_num = $param['order_num'];
        $gf_info=userlist::model()->getUserInfo($gfid);
        if(empty($gf_info['gf_id'])){
        	set_error($data,1,'访问失败，用户信息异常',1);
        }
    	$cr = new CDbCriteria;
        $cr->condition="(is_show=649 or order_state<>1173) and shopping_order_num='".$order_num."' and gfid=".$gfid;
        $cr->select="id,is_show,shopping_order_num as order_num,gf_account,is_pay,gf_name,contact_phone,add_time,order_type,order_type_name,supplier_id as club_id,supplier_name as club_name,gfid,order_state,order_state_name as state_name,servic_time_star as service_start_time,servic_time_end as service_end_time,service_id,service_ico as service_pic,service_name,buy_price as service_fee,ifnull(show_service_data_title,show_service_title) as content,project_id,t_stypeid,t_stypename as service_type,service_address,effective_time";
        $datas=$this->findAll($cr,array(),false);
        if(count($datas)==0){
        	set_error($data,1,'该订单未找到',1);
        }
        $info=$datas[0];
        $sourcer=QmddServerSourcer::model()->find('id='.$info['service_id']);
        if(!empty($sourcer)){//获取动动约类型与id，用于访问动动约详情
        	$info['t_typeid']=$sourcer->t_typeid;
        	$info['service_id']=$sourcer->t_typeid==1?$sourcer->site_id:$info['service_id'];
        }else{
        	$info['t_typeid']=0;
        }
    	$info['order_fee_title']='订单总价';
    	$total_fee=0.00;
    	$server_data=array();
    	foreach($datas as $k=>$v){
    		$server_data[$k]['content']=$v['content'];
    		$server_data[$k]['is_service_order_num']=0;
    		$total_fee+=$v['service_fee'];
    		$server_data[$k]['fee']='¥'.$v['service_fee'];
    	}
    	$info['order_fee']='¥'.number_format($total_fee,'2');
    	$info['service_datas']=$server_data;
        $info['service_type']=empty($info['service_type'])?'':$info['service_type'];
    	$info['service_show_html']=$info['service_name'].'<br/>'.$info['service_type'];//."<br/><font color=\"#808080\">".$info['service_address'].'</font>';
    	$info['state_notify']='';
        $info['order_type_name']='动动约';
    	$info['show_order_title']=$info['order_type_name'].' | '.$info['club_name'];
    	$zi_space='&#160;&#160;&#160;&#160;&#160;';
    	$font_s=$zi_space."<font color=\"#808080\">";
    	$font_e="</font>";
    	$info['order_detail']='订单编号'.$font_s.$order_num.$font_e.'<br/>预订人'.$zi_space.$font_s.$gf_info['gf_account'].'/'.$gf_info['gf_name'].$font_e.'<br/>联系电话'.$font_s.$info['contact_phone'].$font_e;
    	
    	$info['control']='0';
    	if($info['is_pay']==464){//已支付
    		$info['state_notify']='请注意服务单开始时间';
    		$pay=MallSalesOrderInfo::model()->find("order_num='".$order_num."'");
    		$info['order_detail'].='<br/>支付方式'.$font_s.$pay['pay_supplier_type_name'].$font_e.'<br/>支付时间'.$font_s.date("Y/m/d H:i:s",strtotime($pay['pay_time'])).$font_e;
    	}else{
    		switch($info['order_state']){
	    		case 1169://待支付
	    		$info['control']='1,2';
    			$info['state_notify']="剩   <font color=\"#ff1200\">downtime</font>    分钟关闭";
	    		break;
	    		case 1173://已关闭
	    		$info['control']='3';
    			$info['state_notify']='订单已取消';
	    		break;
	    	}
    		$info['order_detail'].='<br/>预订时间'.$font_s.date("Y/m/d H:i:s",strtotime($info['add_time'])).$font_e;
    	}
    	
    	$data['datas']=$info;
    	set_error($data,0,'获取成功',1);
    }
    
    /**
     * 获取动动约服务单列表
     * 请求参数：
用户id，page，per_page，
service_state（服务单状态：0-全部，1-已预订、2-已结束、3-已退订），
type_code（动动约服务类型：0-全部类型,2-教练,3-摄像,12-摄影,13-运动康复,14-场地,15-约练,16-约赛）

返回参数：
service_state_list服务单状态[{id编号,name名称}]；
datas[{service_order_num 服务单号,refund_order_num 退订单号,state_name服务单状态（已预订-预订成功；已结束-已结束；已退订-（待退款，已退款））,service_start_time服务开始时间,service_end_time服务开始时间,control订单可操作功能（已预订-签到+退订；已结束-评价；已退订-（待退款-无；已退款-删除））,service_name服务名称,service_type服务类型名称,service_fee服务费用,service_content服务内容,is_sign是否已签到（0-否，1-是），is_return是否已退订（0-否，1-是），is_evalua是否已评价（0-否，1-是），is_backfee是否已退款（0-否，1-是）}]
control（可操作功能：1-取消订单，2-支付，3-删除，4-签到，5-退订，6-评价）
     */
    public function GetDdyServiceList($param){
		checkArray($param,'visit_gfid',1);
		$data=get_error(1,"获取失败");
        $gfid = $param['visit_gfid'];
        $per_page = empty($param['per_page'])?10:$param['per_page'];
        $page=empty($param['page'])?1:$param['page'];
        $page_s = ($page-1)*$per_page;
        $service_state = empty($param['service_state'])?1:$param['service_state'];
        $type_code = empty($param['type_code'])?0:$param['type_code'];
        $data['order_state_list']=array(array('id'=>'1','name'=>'已预订'),array('id'=>'2','name'=>'已结束'),array('id'=>'3','name'=>'已退订'));
        $sitetype=BaseCode::model()->findAll("F_TCODE='SITETYPE' and F_CODE<>''");
        
        $w="order_type=353 and is_show=649 and is_pay=464 and gfid=".$gfid;
        $w=get_where($w,$type_code,'t_stypeid',$type_code);
        if(empty($service_state)){
        	$w.=" and order_state in(1462,1170,1171,1172,1521)";
        }else{
        	switch($service_state){
        		case 1:
        		$w.=" and order_state in(1462,1170)";
        		break;
        		case 2:
        		$w.=" and order_state in(1171,1172)";
        		break;
        		case 3:
        		$w.=" and order_state =1521";
        		break;
        	}
        }
        
        $cr = new CDbCriteria;
        $cr->condition=$w." order by id desc limit ".$page_s.",".$per_page;
        $cr->select="id,order_num as service_order_num,info_order_num as order_num,order_state,servic_time_star as service_start_time,servic_time_end as service_end_time,service_name,buy_price as service_fee,t_stypeid,t_stypename as service_type,concat(ifnull(show_service_data_title,show_service_title),' ¥',buy_price)  as service_content,sign_code";
        $datas=$this->findAll($cr,array(),false);
        foreach($datas as $k=>$v){
        	$datas[$k]['service_type']=empty($datas[$k]['service_type'])?'':$datas[$k]['service_type'];
		    $datas[$k]['service_content']=empty($datas[$k]['service_content'])?'':$datas[$k]['service_content'];
        	$datas[$k]['service_content_html']='<b>'.$v['service_name'].' '.$datas[$k]['service_type'].'</b><br/>'.$datas[$k]['service_content'];
        	$datas[$k]['is_sign']=0;
        	$datas[$k]['is_return']=0;
        	$datas[$k]['is_evalua']=0;
        	$datas[$k]['is_backfee']=0;
        	$datas[$k]['control']='0';
        	switch($v['order_state']){
        		case 1462:
        		case 1170:
        		$datas[$k]['service_state_name']='预订成功';
        		$datas[$k]['control']='4,5';
        		break;
        		case 1171:
        		$datas[$k]['service_state_name']='已结束';
        		$datas[$k]['is_sign']=1;
        		$datas[$k]['control']='6';
        		break;
        		case 1172:
        		$datas[$k]['service_state_name']='已结束';
        		$datas[$k]['is_sign']=1;
        		$datas[$k]['is_evalua']=1;
        		$datas[$k]['control']='6';
        		break;
        		case 1521://已退订
        		$datas[$k]['service_state_name']='待退款';
        		$datas[$k]['is_return']=1;
        		$order_data=MallSalesOrderData::model()->find('ret_state<>374 and orter_item=758 and gf_service_id='.$v['id']);//获取订单信息
                if(!empty($order_data))$goods=ReturnGoods::model()->find('order_num="'.$order_data->order_num.'" and order_data_id='.$order_data->id.' and cancel=1145');//获取退货信息
                
                if(!empty($goods)&&$goods->state==466){
                	$datas[$k]['is_backfee']=1;
        			$datas[$k]['control']='3';
        			$datas[$k]['service_state_name']='已退款';
                }
        		break;
        	}
        }
		$cr->condition=$w;
		$cr->group='order_num';
        $cr->select='order_num';
        $total=$this->count($cr,array());
//        $get_count = Yii::app()->db->createCommand('select count(distinct order_num) as c from gf_service_data where '.$w)->queryAll();
//        $total=count($get_count)>0?$get_count[0]['c']:0;
    	
		$data['datas']=$datas;
		$data['totalCount']=$total;
		$data['now_page']=$page;
		$data['return_notify']='退订费按以下规则核收:<br/>服务时间开始前72小时(含）以上不收取退订费；<br/>48小时（含）以上、不足72小时按预订费10%计；<br/>24小时（含）以上、不足48小时按预订费20%计；<br/>2小时（含）以上、不足24小时按预订费30%计；<br/>2小时以内不可退订。';
		$data['return_rule']=array(array('min'=>2,'max'=>24,'restocking'=>30),array('min'=>24,'max'=>48,'restocking'=>20),array('min'=>48,'max'=>72,'restocking'=>10));
		$data['return_content']='预订金额: service_fee元<br/>退订费：restocking_fee元<br/>实退款：back_fee元<br/>实际退订费及应退费按退订交易时间计算。';
		set_error_tow($data,$total,0,"拉取数据成功",0,"无数据",1);
    }
	/**
     * 根据服务单号获取动动约服务详情
     * datas{order_detail销售订单号信息html（订单编号+服务单号+退订单号+预订人+联系电话+预订时间+退订时间（仅当已退订状态有退订单号和退订时间））,show_order_title发布单位与订单类型,state_name订单状态，state_notify订单状态提示（待退款-已退订服务，等待退款；其他-无）,control订单可操作功能（已退款-删除；其他-无）,service_pic缩略图url,service_name服务名称,service_type服务类型名称，service_address服务地址，service_fee_title订单总价（固定词），service_fee服务费用,service_datas服务列表（不是已退订返回该订单所有预订服务，已退订只返回退订服务单）[{fee价格,content内容（根据服务类型其格式为：
教练：项目+日期+时段，如 台球 09/15 07:00-08:00
场地：项目+场地类型+场地名称+日期+时段，如 台球 单场 1号场 09/15 07:00-08:00 
摄影／摄像／运动康复：日期+时段，如 09/15 07:00-08:00）,is_service_order_num是否本单（0-否，1-是）}]，is_backfee是否已退款（0-否，1-是),restocking_fee_norify退订费比例，restocking_fee退订费金额，actual_refund实退款金额}
     */
	public function getDdyServiceDetail($param){
		checkArray($param,'visit_gfid,service_order_num',1);
		$data=get_error(1,"获取失败");
        $gfid = $param['visit_gfid'];
        $service_order_num = $param['service_order_num'];
        $gf_info=userlist::model()->getUserInfo($gfid);
        if(empty($gf_info['gf_id'])){
        	set_error($data,1,'访问失败，用户信息异常',1);
        }
    	$cr = new CDbCriteria;
        $cr->condition="is_show=649 and order_num='".$service_order_num."' and gfid=".$gfid;
        $cr->select="id,order_num as service_order_num,info_order_num as order_num,gf_account,gf_name,contact_phone,add_time,order_type,order_type_name,supplier_id as club_id,supplier_name as club_name,gfid,order_state,servic_time_star as service_start_time,servic_time_end as service_end_time,service_id,service_ico as service_pic,service_name,buy_price as service_fee,project_id,t_stypeid,t_stypename as service_type,service_address,effective_time,sign_code";
        $info=$this->find($cr,array(),false);
        if(empty($info)){
        	set_error($data,1,'该服务单未找到',1);
        }
        $sourcer=QmddServerSourcer::model()->find('id='.$info['service_id']);
        if(!empty($sourcer)){//获取动动约类型与id，用于访问动动约详情
        	$info['t_typeid']=$sourcer->t_typeid;
        	$info['service_id']=$sourcer->t_typeid==1?$sourcer->site_id:$info['service_id'];
        }else{
        	$info['t_typeid']=0;
        }
        $info['service_type']=empty($info['service_type'])?'':$info['service_type'];
    	$info['service_show_html']=$info['service_name'].'<br/>'.$info['service_type'];//."<br/><font color=\"#808080\">".$info['service_address'].'</font>';
    	$info['state_notify']='';
        $info['order_type_name']='动动约';
    	$info['show_order_title']=$info['order_type_name'].' | '.$info['club_name'];
    	$zi_space='&#160;&#160;&#160;&#160;&#160;';
    	$font_s=$zi_space."<font color=\"#808080\">";
    	$font_e="</font>";
    	$info['order_detail']='订单编号'.$font_s.$info['order_num'].$font_e.'<br/>服务单号'.$font_s.$info['service_order_num'].$font_e.'<br/>预订人'.$zi_space.$font_s.$gf_info['gf_account'].'/'.$gf_info['gf_name'].$font_e.'<br/>联系电话'.$font_s.$info['contact_phone'].$font_e.'<br/>预订时间'.$font_s.date("Y/m/d H:i:s",strtotime($info['add_time'])).$font_e;
    	$info['restocking_fee_name']='';
    	$info['restocking_fee_notify']='';
    	$info['restocking_fee']='';
    	$info['actual_refund_name']='';
    	$info['actual_refund']='';
        	$info['is_sign']=0;
        	$info['is_return']=0;
        	$info['is_evalua']=0;
        	$info['is_backfee']=0;
        	$info['control']='0';
    	switch($info['order_state']){
    		case 1462:
    		case 1170:
    		$info['service_state_name']='预订成功';
    		$info['control']='4,5';
    		break;
    		case 1171:
    		$info['service_state_name']='已结束';
    		$info['is_sign']=1;
    		$info['control']='6';
    		break;
    		case 1172:
    		$info['service_state_name']='已结束';
    		$info['is_sign']=1;
    		$info['is_evalua']=1;
    		$info['control']='6';
    		break;
    		case 1521:
    		$info['service_state_name']='待退款';
    		$info['is_return']=1;
    		$order_data=MallSalesOrderData::model()->find('ret_state<>374 and orter_item=758 and gf_service_id='.$info['id']);//获取订单信息
            if(!empty($order_data)){
            	$goods=ReturnGoods::model()->find('order_num="'.$order_data->order_num.'" and order_data_id='.$order_data->id.' and cancel=1145');//获取退订信息
    			$info['order_detail']='订单编号'.$font_s.$info['order_num'].$font_e.'<br/>服务单号'.$font_s.$info['service_order_num'].$font_e.'<br/>退订单号'.$font_s.$order_data->order_num.$font_e.'<br/>预订人'.$zi_space.$font_s.$info['gf_account'].'/'.$info['gf_name'].$font_e.'<br/>联系电话'.$font_s.$info['contact_phone'].$font_e.'<br/>退订时间'.$font_s.date("Y/m/d H:i:s",strtotime($order_data->order_Date)).$font_e;
		    	$info['restocking_fee_name']='退订费';
		    	$info['restocking_fee_notify']='核收'.$goods->return_float_Percentage.'%';
		    	$info['restocking_fee']=($goods->sale_money-$goods->ret_money);
		    	$info['actual_refund_name']='实退款';
		    	$info['actual_refund']=$goods->ret_money;
            }
            
            if(!empty($goods)&&$goods->state==466){
            	$info['is_backfee']=1;
    			$info['control']='3';
    			$info['service_state_name']='已退款';
    			$info['state_name']='已退款';
            }else{
            	$info['state_notify']='已退订服务，等待退款';
    			$info['state_name']='待退款';
            }
    		break;
        }
    	$info['order_fee_title']='订单总价';
    	$total_fee=0.00;
        $cr->condition="info_order_num='".$info['order_num']."'";
        $cr->select="id,buy_price as fee,ifnull(show_service_data_title,show_service_title) as content,0 as is_service_order_num";
    	$server_data=$this->findAll($cr,array(),false);
    	foreach($server_data as $k=>$v){
    		$server_data[$k]['is_service_order_num']=$v['id']==$info['id']?1:0;
    		$total_fee+=$v['fee'];
    		$server_data[$k]['fee']='¥'.$v['fee'];
    	}
    	$info['order_fee']='¥'.number_format($total_fee,'2');
    	$info['service_datas']=$server_data;
		$info['return_notify']='退订费按以下规则核收:<br/>服务时间开始前72小时(含）以上不收取退订费；<br/>48小时（含）以上、不足72小时按预订费10%计；<br/>24小时（含）以上、不足48小时按预订费20%计；<br/>2小时（含）以上、不足24小时按预订费30%计；<br/>2小时以内不可退订。';
		$info['return_rule']=array(array('min'=>2,'max'=>24,'restocking'=>30),array('min'=>24,'max'=>48,'restocking'=>20),array('min'=>48,'max'=>72,'restocking'=>10));
		$info['return_content']='预订金额: service_fee元<br/>退订费：restocking_fee元<br/>实退款：back_fee元<br/>实际退订费及应退费按退订交易时间计算。';
    	$data['datas']=$info;
    	set_error($data,0,'获取成功',1);
    }
}
