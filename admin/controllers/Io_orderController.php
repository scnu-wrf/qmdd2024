
<?php
class Io_orderController extends BaseController {
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

	/**
	 * 获取动动约订单确认接口
	 * (根据2020年10月业务调整后该接口不符合业务需求，废弃)
	 */
	public function actionGet_service_add_order_info(){
        $param=decodeAskParams($_REQUEST,1);
        $order_num=$param['order_num'];     //订单编号

        $s_name='';
        $gf_name='';
        $settlement = Carinfo::model()->find('order_type=353 and order_num="'.$order_num.'"');
        $car_copy = CardataCopy::model()->findAll('order_type=353 and order_num="'.$order_num.'"');
        
        $datas=array();
        if(!empty($car_copy))foreach($car_copy as $n=>$v){
            $sourcer=QmddServerSourcer::model()->find('id='.$v->service_id);
            if(!empty($sourcer))if($sourcer->t_typeid==1){//场地
                $list=QmddServerSetList::model()->find('server_sourcer_id='.$v->service_id);
                if(!empty($sourcer->site_id))$site=GfSite::model()->find('id='.$sourcer->site_id);
                if(!empty($site))$s_name=$site->site_name;
                $datas[$n]['site_type']=!empty($list)?$list->site_type:'';
                if(!empty($list->site_type))$site_type=BaseCode::model()->find('f_id='.$list->site_type);
                $datas[$n]['site_type_name']=!empty($site_type)?$site_type->F_NAME:'';
            }elseif(!empty($sourcer))if($sourcer->t_typeid==2){//服务者
                $s_name=$sourcer->s_name;
            }
            $gf_name=$v->gf_name;
            $datas[$n]['project_id']=$v->project_id;
            $datas[$n]['project_name']=$v->project_name;
            $datas[$n]['service_name']=$v->service_name;
            $datas[$n]['service_data_name']=$v->service_data_name;
            $datas[$n]['buy_count']=$v->buy_count;
            $datas[$n]['buy_price']=$v->buy_price;
            $datas[$n]['total_pay']=$v->total_pay;
            $datas[$n]['buy_amount']=$v->buy_amount;
        }
		$data=get_error(1,'fail');
		$data['s_name']=$s_name;
		$data['datas']=$datas;
		$data['contact_phone']=empty($settlement->contact_phone)?'':$settlement->contact_phone;
		$data['gf_name']=empty($gf_name)?'':$gf_name;
		// $data['money']=$settlement->money;
		// $data['order_money']=$settlement->order_money;
		// $data['total_money']=$settlement->total_money;
		$data['order_Date']=$settlement->order_Date;
		$data['effective_time']=$settlement->effective_time;
		set_error_tow($data,count($data),0,"拉取数据成功",0,"拉取数据成功",1);
    }

	/**
	 * 修改订单信息
	 * (根据2020年10月业务调整后该接口不符合业务需求，废弃)
	 */
	public function actionAlter_order_info(){
        $param=decodeAskParams($_REQUEST,1);
        $order_num=$param['order_num'];     //订单编号
        $gfid=$param['gfid'];     //gfid
        $contact_phone=empty($param['contact_phone'])?'':$param['contact_phone'];     //联系电话
        
        $count = Carinfo::model()->updateAll(array('contact_phone' => $contact_phone), 'order_num="'.$order_num.'" and order_gfid='.$gfid);
        $count2 = GfServiceData::model()->updateAll(array('contact_phone' => $contact_phone), 'shopping_order_num="'.$order_num.'" and gfid='.$gfid);
        
        $st=0;
        if($count>0&&$count2>0){
            $st=1;
        }
        $data=array();
        $data=array('error'=>1,'msg'=>'fail');
		set_error_tow($data,$st,0,"成功",1,"失败",1);
    }

    /**
	 * 获取动动约订单列表 （前端：我的-我的预订）
	 * 动动约服务单gf_service_data，
	 */
	public function actionGet_order_list(){
        $param=decodeAskParams($_REQUEST,1);
        $gfid=$param['gfid'];     //gfid
        $order_state=empty($param['order_state'])?'':$param['order_state'];     //订单状态
        $page=empty($param['page'])||$param['page']<1?1:$param['page']; //第几页
        $_GET['page']=$page;
        $pageSize=empty($param['pageSize'])?0:$param['pageSize'];       //每页条数

        $path_www=getShowUrl('file_path_url');

        $data=array('error'=>1,'msg'=>'fail');
        $no_limit=array('id'=>'0','name'=>'全部');
        //订单状态列表
        $cr = new CDbCriteria;
        $cr->condition='f_id in(1169,1462,1171,1172,1173,1521)';
        $cr->order = 'f_typecode';
        $order_state_list=BaseCode::model()->findAll($cr);
        $order_state_list=cArray($order_state_list,'f_id as id,F_SHORTNAME as name');
        array_unshift($order_state_list,$no_limit);
        $data['order_state_list']=$order_state_list;

        $cr = new CDbCriteria;
        $cr->condition='t.is_show=649 and t.order_type=353 and t.state in(2,374) and !isNull(t.shopping_order_num) and t.gfid='.$gfid;
        $cr->condition=get_where($cr->condition,!empty($order_state),'t.order_state',$order_state,'');
        $cr->order = 't.id DESC';
        $cr->join = "JOIN qmdd_server_usertype t2 on t2.id=t.t_stypeid";
        $cr->group='t.shopping_order_num,if(t.order_state in(1171,1172,1521) and t2.t_server_type_id in(1,2),t.id,"")';
        
        //符合条件的订单总数
        $count = GfServiceData::model()->count($cr);
        //获取的订单列表
        $pages = new CPagination($count);
        $pages->pageSize = $pageSize;
        $pages->applylimit($cr);
        $gf_data=GfServiceData::model()->findAll($cr);
        $datas=array();
        foreach($gf_data as $i=>$v){
            $sourcer=QmddServerSourcer::model()->find('id='.$v->data_id);
            $list=QmddServerSetList::model()->find('id='.$v->qmdd_server_set_list_id);
            $set_data=QmddServerSetData::model()->find('id='.$v->service_data_id);
            $datas[$i]['logo_pic']='';
            $datas[$i]['s_name']='';
            if(!empty($set_data)&&$set_data->t_typeid==1){//场地
                $site=GfSite::model()->find('id='.$set_data->site_id);
                $datas[$i]['logo_pic']=!empty($site)?$path_www.$site->site_pic:'';
                $datas[$i]['s_name']=!empty($site)?$site->site_name:'';
            }elseif(!empty($set_data)&&$set_data->t_typeid==2){//服务者
                $datas[$i]['logo_pic']=!empty($sourcer)?$path_www.$sourcer->logo_pic:'';
                $datas[$i]['s_name']=!empty($sourcer)?$sourcer->server_name:'';
            }
            $datas[$i]['order_state']=$v->order_state;
            $datas[$i]['order_state_name']=$v->order_state_name;
            $datas[$i]['return_state']=$v->order_state;
            $datas[$i]['return_state_name']=$v->order_state_name;
            $datas[$i]['after_sale_state']=$v->order_state;
            $datas[$i]['after_sale_state_name']=$v->order_state_name;
            if($v->order_state==1521){//已申请退款
                $order_data=MallSalesOrderData::model()->find('ret_state<>374 and orter_item=758 and gf_service_id='.$v->id);
                if(!empty($order_data))$goods=ReturnGoods::model()->find('order_num="'.$order_data->order_num.'" and order_data_id='.$order_data->id.' and cancel=1145');
//                 $datas[$i]['return_state']=empty($goods)?'':$goods->state==466?1154:1153;
//                 $datas[$i]['return_state_name']=empty($goods)?'':$goods->state==466?'已退款':'待确认';
                $datas[$i]['after_sale_state']=empty($goods)?'':$goods->after_sale_state;
                $datas[$i]['after_sale_state_name']=$datas[$i]['after_sale_state']==1150?'待审核':($datas[$i]['after_sale_state']==1153?'待确认':($datas[$i]['after_sale_state']==1154?'待退款成功':(empty($goods)?'':$goods->after_sale_state_name)));//empty($goods)?'':$goods->after_sale_state_name;
                $datas[$i]['return_state']=$datas[$i]['after_sale_state'];
                $datas[$i]['return_state_name']=$datas[$i]['after_sale_state_name'];
            }
            $usertype=QmddServerUsertype::model()->find('id='.$v->t_stypeid);      
            $datas[$i]['t_typeid']=empty($usertype)?'':$usertype->t_server_type_id;
            $datas[$i]['t_typename']=empty($usertype)?'':$usertype->t_name;
            $datas[$i]['t_stypeid']=$v->t_stypeid;
            $datas[$i]['t_stypename']=$v->t_stypename;
            $os = array("1171", "1172", "1521");
            $ot = array("1", "2");
            $datas[$i]['order_num']=$v->shopping_order_num;

            $goods=ReturnGoods::model()->find('return_order_num="'.$v->shopping_order_num.'" and order_gfid='.$gfid.' and cancel=1145');
            $datas[$i]['return_order_num']=empty($goods)?'':$goods->order_num;

            $datas[$i]['effective_time']=$v->effective_time;//待支付订单最后支付时间
            if(in_array($v->order_state, $os) && !empty($usertype) &&in_array($usertype->t_server_type_id, $ot)){
                $gf_datas=GfServiceData::model()->findAll('id="'.$v->id.'"');
            }else{
                $gf_datas=GfServiceData::model()->findAll('is_show=649 and shopping_order_num="'.$v->shopping_order_num.'"');
            }

            $re_count=MallSalesOrderData::model()->count('order_type=353 and order_num="'.$v->info_order_num.'" and gfid='.$gfid.' and left(service_data_name,16)>=date_add(now(), interval 2 hour) and buy_amount>0');
            $datas[$i]['is_refund']=$re_count>0?1:2;//是否可退款，1可以，2不可以
            foreach($gf_datas as $m=>$n){
                $datas[$i]['datas'][$m]['id']=$n->id;
                $datas[$i]['datas'][$m]['order_num']=$n->order_num;
                $datas[$i]['datas'][$m]['project_id']=$n->project_id;
                $datas[$i]['datas'][$m]['project_name']=$n->project_name;
                $datas[$i]['datas'][$m]['site_type']=empty($list)?'':$list->site_type;
                if(!empty($list->site_type)&&$list->site_type>0)$site_type=BaseCode::model()->find('f_id='.$list->site_type);
                $datas[$i]['datas'][$m]['site_type_name']=empty($site_type)?'':$site_type->F_NAME;
                $datas[$i]['datas'][$m]['service_id']=$n->service_id;
                $datas[$i]['datas'][$m]['service_name']=$n->service_name;
                $datas[$i]['datas'][$m]['service_data_id']=$n->service_data_id;
                $datas[$i]['datas'][$m]['service_data_name']=$n->service_data_name;
                
                $datas[$i]['datas'][$m]['show_name']=$n->project_name.' '.date("m/d",strtotime($n->servic_time_star)).substr($n->service_data_name,10)."             ¥".$n->buy_price;
                if(!empty($set_data)&&$set_data->t_typeid==1){
                	$datas[$i]['datas'][$m]['show_name']=$n->project_name.' '.$datas[$i]['datas'][$m]['site_type_name'].' '.$n->service_name.' '.date("m/d",strtotime($n->servic_time_star)).substr($n->service_data_name,10)."             ¥".$n->buy_price;
                }
            }
        }
        
		$data['datas']=$datas;
		$data['totalCount']=$pages->getItemCount();
		$data['now_page']=$page;
		set_error_tow($data,$pages->getItemCount(),0,"拉取数据成功",0,"无数据",1);
    }

    
    /**
	 * 动动约订单操作
	 * type //1取消订单，2撤销退款，3确认退款,4-删除已完成退款单
	 */
    public function actionCancel_order(){
        $data=get_error(1,"");
        $param=decodeAskParams($_REQUEST,1);
        $type=$param['type'];     //1取消订单，2撤销退款，3确认退款,4-删除已完成退款单
        $gfid=$param['gfid'];     //gfid
        $order_num=$param['order_num'];     //1传订单编号，2和3传退订编号
        $server_num=empty($param['server_num'])?'':$param['server_num'];   //服务流水号,type=2或3时服务者类型类型为场地/服务者时必填
		$type_cname='';
		switch($type){
			case 1:
			$type_cname='取消';
			break;
			case 2:
			$type_cname='撤销';
			break;
			case 3:
			$type_cname='确认';
			break;
			case 4:
			$type_cname='删除';
			break;
		}
        if($type==2||$type==3||$type==4){
            $orderData=MallSalesOrderData::model()->find('orter_item=758 and order_num="'.$order_num.'"');
            if(empty($orderData)){
                set_error($data,1,$type_cname."操作失败,不存在该退订单",1);
            }
            $set_data=QmddServerSetData::model()->find('id='.$orderData->service_data_id);
            if(empty($orderData)){
                set_error($data,1,$type_cname."操作失败,不存在该预订",1);
            }
        }
        if($type==1){
            $count = GfServiceData::model()->updateAll(array('state'=>374,'order_state'=>1173), 'order_state=1169 and is_pay=463 and shopping_order_num="'.$order_num.'" and gfid='.$gfid);
        }elseif($type==2){
            if($set_data->t_typeid==1||$set_data->t_typeid==2){
                if(empty($server_num)){
                    set_error($data,1,$type_cname."操作失败",1);
                }
                $gf_data=GfServiceData::model()->find('order_num="'.$server_num.'"');
                if(empty($gf_data)){
                    set_error($data,1,$type_cname."操作失败",1);
                }
                $order_data=MallSalesOrderData::model()->find('ret_state<>374 and order_type=353 and orter_item=758 and order_num="'.$order_num.'" and gfid='.$gfid.' and gf_service_id='.$gf_data->id);
                if(empty($order_data)){
                    set_error($data,1,$type_cname."操作失败",1);
                }
                GfServiceData::model()->updateByPk($gf_data->id,array('cancelled'=>0,'cancel_time'=>'','order_state'=>1462));
                $c1 = MallSalesOrderData::model()->updateAll(array('ret_state'=>374), 'id='.$order_data->id);

                $c2 = ReturnGoods::model()->updateAll(array('cancel'=>1146,'after_sale_state'=>1156), 'order_type=353 and order_num="'.$order_num.'" and order_gfid='.$gfid.' and order_data_id='.$order_data->id.' and cancel<>1146');
                $count=$c1>0&&$c2>0?1:0;
            }else{
                $c1 = MallSalesOrderData::model()->updateAll(array('ret_state'=>374), 'order_type=353 and  orter_item=758 and order_num="'.$order_num.'" and gfid='.$gfid);
                $c2 = ReturnGoods::model()->updateAll(array('cancel'=>1146,'after_sale_state'=>1156), 'order_type=353 and order_num="'.$order_num.'" and order_gfid='.$gfid.' and cancel<>1146');
                $count=$c1>0&&$c2>0?1:0;
            }
        }elseif($type==3){
            if($set_data->t_typeid==1||$set_data->t_typeid==2){
                if(empty($server_num)){
                    set_error($data,1,"缺少server_num参数",1);
                }
                $gf_data=GfServiceData::model()->find('order_num="'.$server_num.'"');
                if(empty($gf_data)){
                    set_error($data,1,$type_cname."操作失败",1);
                }
                $order_data=MallSalesOrderData::model()->find('ret_state<>374 and order_type=353 and orter_item=758 and order_num="'.$order_num.'" and gfid='.$gfid.' and gf_service_id='.$gf_data->id);
                if(empty($order_data)){
                    set_error($data,1,$type_cname."操作失败",1);
                }
                $count = ReturnGoods::model()->updateAll(array('after_sale_state'=>1155), 'order_type=353 and order_num="'.$order_num.'" and order_gfid='.$gfid.' and order_data_id='.$order_data->id.' and after_sale_state<>1155');
            }else{
                $count = ReturnGoods::model()->updateAll(array('after_sale_state'=>1155), 'order_type=353 and order_num="'.$order_num.'" and order_gfid='.$gfid.' and after_sale_state<>1155 and cancel<>1146');
            }
        }elseif($type==4){
        	if($set_data->t_typeid==1||$set_data->t_typeid==2){
                if(empty($server_num)){
                    set_error($data,1,"缺少server_num参数",1);
                }
                $gf_data=GfServiceData::model()->find('order_num="'.$server_num.'"');
                if(empty($gf_data)){
                    set_error($data,1,$type_cname."操作失败",1);
                }
                $order_data=MallSalesOrderData::model()->find('orter_item=758 and order_num="'.$order_num.'" and gfid='.$gfid.' and gf_service_id='.$gf_data->id);
                if(empty($order_data)){
                    set_error($data,1,$type_cname."操作失败",1);
                }
                $count = GfServiceData::model()->updateAll(array('is_show'=>648), 'order_num="'.$server_num.'"');
                $count = ReturnGoods::model()->updateAll(array('if_del'=>649), 'order_type=353 and order_num="'.$order_num.'" and order_gfid='.$gfid.' and order_data_id='.$order_data->id.' and after_sale_state in(1155,1156)');
            }else{
                $count = ReturnGoods::model()->updateAll(array('if_del'=>649), 'order_type=353 and order_num="'.$order_num.'" and order_gfid='.$gfid.' and after_sale_state in(1155,1156)');
            }
        }
        if($type==2||$type==3||$type==4){
            $record = new OrderRecord();
            $record->isNewRecord = true;
            unset($record->id);
            $record->order_id=$orderData->info_id;
            $record->order_num=$orderData->order_num;
            $record->is_pay=464;
            $record->order_state=466;
            $record->order_state_des_content='服务退订';
            $record->order_state_des_time=date('Y-m-d H:i:s');
            $record->user_member=210;
            $record->operator_gfid=$gfid;
            $record->operator_gfname=$orderData->gf_name;
            $record->change_type=1137;
            $sa=$record->save();
        }
        $data=array('error'=>1,'msg'=>'fail');
        set_error_tow($data,$count,0,$type_cname."操作成功",1,$type_cname."操作失败",1);
    }

	/**
	 * 获取退订确认列表接口
	 */
	public function actionRefund_confirm(){
        $param=decodeAskParams($_REQUEST,1);
        $data=get_error(1,"");
        $gfid=$param['gfid'];     //gfid
        $order_num=$param['order_num'];     //订单编号

        $service_fee=0.00;
        
        //获取订单中已申请退订的服务
        $cr = new CDbCriteria;
        $cr->condition='return_order_num="'.$order_num.'" and cancel=1145';
        $cr->select="group_concat(buy_order_data_id) return_id";
        $rdatas=ReturnGoods::model()->findAll($cr,array(),false);
        //获取订单中未申请退订的服务
        $cr = new CDbCriteria;
        $cr->condition='t.orter_item=757 and t.order_type=353 and t.gfid='.$gfid;
        if(count($rdatas)>0){
            $cr->condition.=" and t.id not in('".$rdatas[0]['return_id']."')";
        }
        $cr->join = "JOIN mall_sales_order_info t2 on t2.id=t.info_id and t2.pay_gfcode='".$order_num."'";
        $orderData=MallSalesOrderData::model()->findAll($cr);
        
        $datas=array();
        foreach($orderData as $i=>$l){
            $list=QmddServerSetList::model()->find('id='.$l->qmdd_server_set_list_id);
            $gf_data=GfServiceData::model()->find('id='.$l->gf_service_id);
            $datas[$i]['id']=$l->id;
            $datas[$i]['order_num']=empty($gf_data)?'':$gf_data->order_num;
            $datas[$i]['project_id']=$l->project_id;
            $datas[$i]['project_name']=$l->project_name;
            $datas[$i]['site_type']=empty($list)?'':$list->site_type;
            if(!empty($list->site_type)&&$list->site_type>0)$site_type=BaseCode::model()->find('f_id='.$list->site_type);
            $datas[$i]['site_type_name']=empty($site_type)?'':$site_type->F_NAME;
            $datas[$i]['service_id']=$l->service_id;
            $datas[$i]['service_name']=$l->service_name;
            $datas[$i]['service_data_id']=$l->service_data_id;
            $datas[$i]['service_data_name']=$l->service_data_name;
            $datas[$i]['buy_count']=$l->buy_count;
            $datas[$i]['buy_price']=$l->buy_price;
            $datas[$i]['total_pay']=$l->total_pay;
            $datas[$i]['buy_amount']=$l->buy_amount;
            $d=substr($l->service_data_name,0,16).':00';
            $hours=(strtotime($d)-time())/3600;
            $datas[$i]['is_refund']=$hours<2&&$l->buy_amount>0?1:0;
            //查询退订服务费
            $set = Yii::app()->db->createCommand('select return_float_Percentage from mall_return_set where type_base_id=353 and return_reason="退订" and return_start_time<='.$hours.' and (return_time is null or (return_time>0 and return_time>'.$hours.'))')->queryAll();
            $set=!empty($set)?$set[0]['return_float_Percentage']:0;
            
            $datas[$i]['service_fee']=$l->buy_amount*($set/100);
        }
        $data['datas']=$datas;
		set_error_tow($data,count($data),0,"拉取数据成功",0,"无数据",1);
    }

	/**
	 * 服务单退订申请
	 */
	public function actionApply_refund_service(){
        $param=decodeAskParams($_REQUEST,1);
        $param['gfid']=empty($param['gfid'])?$param['visit_gfid']:$param['gfid'];     //gfid
        $order_data=MallSalesOrderData::model()->find('orter_item=757 and gf_service_id='.$param['id']);
        $data=get_error(1,"");
        if(empty($order_data)){
        	set_error($data,1,"退订失败",1);
        }
        $param['data_id']=$order_data->id;
        $param['order_num']=$order_data->order_num;
		$this->ApplyForOrderReturn($param);
	}
	/**
	 * 申请退订接口
	 */
	public function actionApply_for_order_return(){
        $param=decodeAskParams($_REQUEST,1);
        $this->ApplyForOrderReturn($param);
	}
	/**
	 * 申请退订接口
	 */
	public function ApplyForOrderReturn($param){
        $data=get_error(1,"");
        $gfid=$param['gfid'];     //gfid
        $order_num=$param['order_num'];     //订单编号
        $data_id=$param['data_id'];   //io_service/refund_confirm返回datas的id 多个使用,隔开
//        $return_fee=$param['return_fee'];     //总退款金额
        $fee=0.00;
         $cr = new CDbCriteria;
        $cr->condition='type=757 and order_num="'.$order_num.'" and order_gfid='.$gfid;
        $cr->select='order_type,rec_name,rec_phone,product_ico,order_gfid,money,order_money,total_money,contact_phone,pay_gfcode,pay_type,pay_time';
        $o_info=MallSalesOrderInfo::model()->find($cr,array(),false);
        if(empty($o_info)){
            set_error($data,1,"退订失败",1);
        }
        $order_data=explode(',', $data_id);
        if(empty($order_data)){
            set_error($data,1,"退订失败",1);
        }
        foreach($order_data as $d){
            $o_data=MallSalesOrderData::model()->find('id='.$d.' and purpose<>7 and gfid='.$gfid);
            if(empty($o_data)){
                set_error($data,1,"退订失败",1);
            }
            
            $ro=ReturnGoods::model()->count('return_order_num="'.$o_data->order_num.'" and buy_order_data_id='.$d.' and cancel=1145');
            if($ro>0){
                set_error($data,1,"该预订已申请退款",1);
            }
            $de=substr($o_data->service_data_name,0,16).':00';
            $hours=(strtotime($de)-time())/3600;
            if($hours<2){
                set_error($data,1,"服务开始时间小于两小时不可退订",1);
            }
            //查询退订服务费
            $set = Yii::app()->db->createCommand('select return_float_Percentage from mall_return_set where type_base_id=353 and return_reason="退订" and return_start_time<='.$hours.' and (return_time is null or (return_time>0 and return_time>'.$hours.'))')->queryAll();
            $set=!empty($set)?$set[0]['return_float_Percentage']:0;
            $fee = $fee+($o_data->buy_amount-($o_data->buy_amount*($set/100)));
        }
//        if($fee!=$return_fee){
//            set_error($data,1,"申请退款金额不符",1);
//        }
		//生成退订订单
		$o_info['type']=758;
        $refund_order=MallSalesOrderInfo::model()->addRefundOrder($o_info);
        $data['order_num'] = $refund_order['order_num'];
        if(!empty($refund_order['order_num'])){
            foreach($order_data as $d){
                //记录退订订单明细
		        $cr = new CDbCriteria;
		        $cr->condition='id='.$d;
                $m_data=MallSalesOrderData::model()->find($cr,array(),false);
                $o_data=new MallSalesOrderData();
                $m_data['Return_no']=$m_data['id'];
                unset($m_data['id']);
                $m_data['order_num'] = $refund_order['order_num'];
                $m_data['orter_item'] = 758;
                $m_data['ret_count'] = 1;
                $m_data['ret_state'] = 371;
                $m_data['order_source'] = 1;
                // $o_data->leaving_a_message = '服务退订';
                $de=substr($o_data->service_data_name,0,16).':00';
                $hours=(strtotime($de)-time())/3600;
                $set = Yii::app()->db->createCommand('select return_float_Percentage,id from mall_return_set where type_base_id=353 and return_reason="退订" and return_start_time<='.($hours<0?0:$hours).' and (return_time is null or (return_time>0 and return_time>'.$hours.'))')->queryAll();
                $set_price=!empty($set)?$set[0]['return_float_Percentage']:0;
                $set_id=$set[0]['id'];
                $m_data['ret_amount'] = $o_data->buy_amount-($o_data->buy_amount*($set_price/100));
                $st=$o_data->insert($m_data);

				//退订记录
                $goods = new ReturnGoods();
                $goods->isNewRecord = true;
                unset($goods->id);
                $goods->order_num=$refund_order['order_num'];
                $goods->return_order_num=$order_num;
                $goods->order_info_id=$refund_order['id'];
                $goods->order_data_id=$o_data->id;
                $goods->buy_order_data_id=$m_data['Return_no'];
                $goods->return_id=$set_id;
                $goods->sale_money=$m_data['ret_amount'];
                $goods->ret_count=1;
                $goods->return_float_Percentage=$set_price;
                $goods->ret_money=$m_data['ret_amount'];
                $goods->change_type=1137;
                $goods->order_date=date('Y-m-d H:i:s');
                $goods->supplier_id=$o_data->supplier_id;
                $goods->order_type=$o_data->order_type;
                $sa=$goods->save();
                //写入服务单退订申请时间
                GfServiceData::model()->updateByPk($o_data->gf_service_id,array('cancelled'=>-1,'cancel_time'=>date('Y-m-d H:i:s'),'cancel_type'=>210,'cancel_type_name'=>'GF会员','order_state'=>1521));
            }
        }else{
            set_error($data,1,"退订失败",1);
        }
        set_error($data,0,"退订成功",1);
    }
    
	/**
	 * 获取订单详情
	 */
	public function actionGet_order_details(){
        $param=decodeAskParams($_REQUEST,1);
        $type=$param['type'];     //1为订单详情，2为退订详情
        $gfid=$param['gfid'];     //gfid
        $order_num=$param['order_num'];     /*订单号/服务流水号*/
        
        if($type==1){
            $this->getOrder_details($gfid,$order_num);
        }elseif($type==2){
            $this->getReturn_order_details($gfid,$order_num);
        }
    }

	/**
	 * 获取订单详情
	 */
	function getOrder_details($gfid,$order_num){
        $data=get_error(1,"");
        $path_www=getShowUrl('file_path_url');
        
        $gData=GfServiceData::model()->find('is_show=649 and order_type=353 and (shopping_order_num="'.$order_num.'" or order_num="'.$order_num.'") and gfid='.$gfid);
        if(empty($gData)){
            set_error($data,1,"订单错误",1);
        }

        $cr='type=757 and order_type=353 and order_gfid='.$gfid;
        if($gData->is_pay==464&&!empty($gData->info_order_num)){//已支付
            $cr.=' and pay_gfcode="'.$gData->shopping_order_num.'"';
            $order_info=MallSalesOrderInfo::model()->find($cr);
        }else{//待支付
            $cr.=' and order_num="'.$gData->shopping_order_num.'"';
            $order_info=Carinfo::model()->find($cr);
        }
        if(empty($order_info)){
            set_error($data,1,"订单错误",1);
        }

        $setlist=QmddServerSetList::model()->find('id='.$gData->qmdd_server_set_list_id);
        $data['s_name']='';
        if(!empty($setlist)&&$setlist->t_typeid==1){//场地
            $site=GfSite::model()->find('id='.$setlist->site_id);
            $data['s_name']=!empty($site)?$site->site_name:'';
        }elseif(!empty($setlist)&&$setlist->t_typeid==2){//服务者
            $sourcer=QmddServerSourcer::model()->find('id='.$setlist->server_sourcer_id);
            $data['s_name']=!empty($sourcer)?$sourcer->server_name:'';
        }
        $data['logo']=$path_www.$order_info->product_ico;
        $data['order_num']=(empty($order_info->pay_gfcode)?$order_info->order_num:$order_info->pay_gfcode);
        $data['order_Date']=$order_info->order_Date;
        $data['order_gfid']=$order_info->order_gfid;
        $data['order_gfaccount']=empty($order_info->order_gfaccount)?'':$order_info->order_gfaccount;
        $data['order_gfname']=empty($order_info->order_gfname)?'':$order_info->order_gfname;
        $data['club_id']=!empty($setlist)?$setlist->club_id:'';
        $data['club_name']=!empty($setlist)?$setlist->club_name:'';
        $data['contact_phone']=empty($order_info->contact_phone)?'':$order_info->contact_phone;
        $data['payment_code']=empty($order_info->payment_code)?'':$order_info->payment_code;
        $data['pay_time']=empty($order_info->pay_time)?'':$order_info->pay_time;
        $data['pay_supplier_type']=empty($order_info->pay_supplier_type)?'':$order_info->pay_supplier_type;
        $data['pay_supplier_type_name']=empty($order_info->pay_supplier_type_name)?'':$order_info->pay_supplier_type_name;
        $data['order_state']=$gData->order_state;
        $data['order_state_name']=$gData->order_state_name;

        $data['datas']=[];
        $gf_data=GfServiceData::model()->findAll('is_show=649 and order_type=353 and (shopping_order_num="'.(empty($order_info->pay_gfcode)?$order_info->order_num:$order_info->pay_gfcode).'") and gfid='.$gfid);
        if(!empty($gf_data))foreach($gf_data as $i=>$v){
            $data['datas'][$i]['order_num']=$v->order_num;
            $data['datas'][$i]['project_id']=$v->project_id;
            $data['datas'][$i]['project_name']=$v->project_name;
            $list=QmddServerSetList::model()->find('id='.$v->qmdd_server_set_list_id);
            $data['datas'][$i]['site_type']=empty($list)?'':$list->site_type;
            if(!empty($list->site_type)&&$list->site_type>0)$site_type=BaseCode::model()->find('f_id='.$list->site_type);
            $data['datas'][$i]['site_type_name']=empty($site_type)?'':$site_type->F_NAME;
            $data['datas'][$i]['service_id']=$v->service_id;
            $data['datas'][$i]['service_name']=$v->service_name;
            $data['datas'][$i]['service_data_id']=$v->service_data_id;
            $data['datas'][$i]['service_data_name']=$v->service_data_name;
            $data['datas'][$i]['sign_code']=$v->sign_code;
            $data['datas'][$i]['buy_price']=$v->buy_price;
            $data['datas'][$i]['buy_amount']=$v->buy_price-$v->free_money;
            $data['datas'][$i]['is_sign']=is_null($v->sign_come)?0:1;
            $data['datas'][$i]['sign_come']=empty($v->sign_come)?'':$v->sign_come;
            $data['datas'][$i]['show_name']=$v->project_name.' '.date("m/d",strtotime($v->servic_time_star)).substr($v->service_data_name,10);
            if(!empty($setlist)&&$setlist->t_typeid==1){//场地
            	$data['datas'][$i]['show_name']=$v->project_name.' '.$data['datas'][$i]['site_type_name'].' '.$v->service_name.' '.date("m/d",strtotime($v->servic_time_star)).substr($v->service_data_name,10);
            }
        }

	    set_error_tow($data,count($order_info),0,"拉取数据成功",1,"拉取数据失败",1);
    }
	/**
	 * 获取退订详情
	 */
	function getReturn_order_details($gfid,$order_num){
        $data=get_error(1,"");
        $path_www=getShowUrl('file_path_url');
        
        $cr='is_show=649 and order_type=353 and order_num="'.$order_num.'" and gfid='.$gfid;
        $gf_data=GfServiceData::model()->find($cr);
        if(empty($gf_data)){
            set_error($data,1,"获取失败",1);
        }
        $sale_money=0.00;
        $service_fee=0.00;
        $ret_money=0.00;

        $setlist=QmddServerSetList::model()->find('id='.$gf_data->qmdd_server_set_list_id);
        $data['s_name']='';
        if(!empty($setlist)&&$setlist->t_typeid==1){//场地
            $site=GfSite::model()->find('id='.$setlist->site_id);
            $data['s_name']=!empty($site)?$site->site_name:'';
        }elseif(!empty($setlist)&&$setlist->t_typeid==2){//服务者
            $sourcer=QmddServerSourcer::model()->find('id='.$setlist->server_sourcer_id);
            $data['s_name']=!empty($sourcer)?$sourcer->server_name:'';
        }

        $data['logo']=$path_www.$gf_data->service_ico;
        $data['order_num']=$gf_data->order_num;
        $data['gfid']=$gf_data->gfid;
        $data['gfaccount']=$gf_data->gf_account;
        $data['order_gfname']=$gf_data->gf_name;
        $data['project_id']=$gf_data->project_id;
        $data['project_name']=$gf_data->project_name;
        $data['t_typeid']=empty($setlist)?'':$setlist->t_typeid;
        if(!empty($setlist->t_typeid)&&$setlist->t_typeid>0)$t_type=QmddServerType::model()->find('id='.$setlist->t_typeid);
        $data['t_typeid_name']=empty($t_type)?'':$t_type->t_name;
        $data['t_stypeid']=empty($setlist)?'':$setlist->t_stypeid;
        if(!empty($setlist->t_stypeid)&&$setlist->t_stypeid>0)$t_stype=QmddServerUsertype::model()->find('id='.$setlist->t_stypeid);
        $data['t_stypeid_name']=empty($t_stype)?'':$t_stype->f_uname;
        $data['site_type']=empty($setlist)?'':$setlist->site_type;
        if(!empty($setlist->site_type)&&$setlist->site_type>0){
        	$site_type=BaseCode::model()->find('f_id='.$setlist->site_type);
        	$data['site_type_name']=empty($site_type)?'':$site_type->F_NAME;
        }
        $data['service_id']=$gf_data->service_id;
        $data['service_name']=$gf_data->service_name;
        $data['service_data_id']=$gf_data->service_data_id;
        $data['service_data_name']=$gf_data->service_data_name;
        $data['show_name']=$gf_data->project_name.' '.date("m/d",strtotime($gf_data->servic_time_star)).substr($gf_data->service_data_name,10)."             ¥".$gf_data->buy_price;
        if(!empty($setlist)&&$setlist->t_typeid==1){//场地
        	$data['show_name']=$gf_data->project_name.' '.$data['site_type_name'].' '.$gf_data->service_name.' '.date("m/d",strtotime($gf_data->servic_time_star)).substr($gf_data->service_data_name,10)."             ¥".$gf_data->buy_price;
        }

        $data['return_state']=$gf_data->order_state;
        $data['return_state_name']=$gf_data->order_state_name;
        if($gf_data->order_state==1521){
            $order_data=MallSalesOrderData::model()->find('ret_state<>374 and orter_item=758 and gf_service_id='.$gf_data->id);
            if(!empty($order_data))$goods=ReturnGoods::model()->find('order_num="'.$order_data->order_num.'" and order_data_id='.$order_data->id.' and cancel=1145');
//             $data['return_state']=empty($goods)?'':$goods->state==466?1154:1153;
//             $data['return_state_name']=empty($goods)?'':$goods->state==466?'已退款':'待退款';
//             $data['after_sale_state']=empty($goods)?'':$goods->after_sale_state;
//             $data['after_sale_state_name']=empty($goods)?'':$goods->after_sale_state_name;
            $data['after_sale_state']=empty($goods)?'':$goods->after_sale_state;
            $data['after_sale_state_name']=$data['after_sale_state']==1150?'待审核':($data['after_sale_state']==1153?'待确认':($data['after_sale_state']==11543?'待退款成功':(empty($goods)?'':$goods->after_sale_state_name)));//empty($goods)?'':$goods->after_sale_state_name;
            $data['return_state']=$data['after_sale_state'];
            $data['return_state_name']=$data['after_sale_state_name'];
            $reurn_notify='';
            if(!empty($goods)&&$goods->after_sale_state==1150){
                $reurn_notify='信息退订已提交，待审核中';
            }elseif(!empty($goods)&&$goods->after_sale_state==1153){
                $reurn_notify='信息已审核，待确认中';
            }elseif(!empty($goods)&&$goods->after_sale_state==1154){
                $reurn_notify='已退款，请确认。如三天内未确认，系统自动确认退款完成。';
            }
            $data['reurn_notify']=$reurn_notify;
            $data['ret_type']=empty($goods)?'':$goods->ret_pay_supplier_type;
            if(!empty($goods->ret_pay_supplier_type))$ret_base=BaseCode::model()->find('f_id='.$goods->ret_pay_supplier_type);
            $data['ret_type_name']=empty($ret_base)?'':$ret_base->F_NAME;
        }
        
       $order_data=MallSalesOrderData::model()->find('orter_item=758 and gf_service_id='.$gf_data->id.' and ret_state<>374');
        if(!empty($order_data))$goods = ReturnGoods::model()->find('order_num="'.$order_data->order_num.'" and return_order_num="'.$gf_data->info_order_num.'" and order_gfid='.$gfid.' and cancel=1145');
        if(!empty($goods)){
            $sale_money=$goods->sale_money;
            $service_fee=$goods->sale_money*($goods->return_float_Percentage/100);
            $ret_money=$goods->ret_money;
        }
        $data['is_return']=!empty($order_data)&&$order_data->ret_state==2?1:0;
        $data['sale_money']=$sale_money;
        $data['service_fee']=$service_fee;
        $data['ret_money']=$ret_money;
        $data['return_order_num']=empty($goods)?'':$goods->order_num;
        $data['info_order_num']=empty($goods)?'':$goods->return_order_num;
        $data['add_time']=empty($goods)?'':$goods->order_date;

	    set_error_tow($data,count($gf_data),0,"拉取数据成功",1,"拉取数据失败",1);
    }
    
	/**
	 * 逻辑删除分单
	 */
	function actionDelete_order_num(){
        $data=get_error(1,"");
        $param=decodeAskParams($_REQUEST,1);
        $gfid=$param['gfid'];     //gfid
        $order_num=$param['order_num'];     //订单号
        $server_num=empty($param['server_num'])?'':$param['server_num'];//服务流水号，传入服务流水号只删除订单里的单个服务，不传删除订单里全部服务
        
        $cr='is_show=649 and order_type=353 and shopping_order_num="'.$order_num.'" and gfid='.$gfid;
        if($server_num!=''){
            $cr.=' and order_num="'.$server_num.'"';
        }
        $count = GfServiceData::model()->updateAll(array('is_show'=>648), $cr);
        $data=array('error'=>1,'msg'=>'fail');
        set_error_tow($data,$count,0,"删除成功",1,"删除失败",1);
    }

	/**
	 * 获取订单可评价列表
	 */
	function actionGet_evaluate_list(){
        $data=get_error(1,"");
        $param=decodeAskParams($_REQUEST,1);
        $gfid=$param['gfid'];     //gfid
//        $order_num=$param['order_num'];     //必填，订单号
        $gf_service_data_id=$param['gf_service_data_id'];     //必填，io_order/get_order_list的datas/datas的id
        $gf_data=GfServiceData::model()->find('id='.$gf_service_data_id.' and order_type=353 and gfid='.$gfid);// and info_order_num="'.$order_num.'"
        if(empty($gf_data)){
            set_error($data,1,"获取失败",1);
        }
        $data=array('error'=>1,'msg'=>'fail');
        $path_www=getShowUrl('file_path_url');
        $data['order_type_name']='动动约';
        $data['club_name']=$gf_data['supplier_name'];
        $data['club_id']=$gf_data['supplier_id'];
        $data['project_id']=$gf_data['project_id'];
		$data['show_order_title']=$data['order_type_name'].' | '.$gf_data['supplier_name'];
		$data['service_pic']=$path_www.$gf_data['service_ico'];
		$data['service_show_html']='<b>'.$gf_data['service_name']."</b><br/>".$gf_data['t_stypename'];//."<br/><font color=\"#808080\">".$gf_data['service_address']."</font>"
		$data['service_content']=$gf_data['show_service_data_title'];
		$data['service_fee']='¥'.$gf_data['buy_price'];

        $setlist=QmddServerSetList::model()->find('id='.$gf_data->qmdd_server_set_list_id);
        $data['id']=$gf_data->id;
        $data['s_name']='';
        if(!empty($setlist)&&$setlist->t_typeid==1){
            $site=GfSite::model()->find('id='.$setlist->site_id);
            $data['s_name']=!empty($site)?$site->site_name:'';
        }elseif(!empty($setlist)&&$setlist->t_typeid==2){
            $data['s_name']=!empty($setlist)?$setlist->s_name:'';
        }
        
        $data['order_num']=$gf_data->info_order_num;
        $data['service_num']=$gf_data->order_num;
        $data['project_id']=$gf_data->project_id;
        $data['club_name']=$gf_data->supplier_name;
        $data['project_name']=$gf_data->project_name;
        $data['t_typeid']=empty($setlist)?'':$setlist->t_typeid;
        if(!empty($setlist->t_typeid)&&$setlist->t_typeid>0)$t_type=QmddServerType::model()->find('id='.$setlist->t_typeid);
        $data['t_typeid_name']=empty($t_type)?'':$t_type->t_name;
        $data['t_stypeid']=empty($setlist)?'':$setlist->t_stypeid;
        if(!empty($setlist->t_stypeid)&&$setlist->t_stypeid>0)$t_stype=QmddServerUsertype::model()->find('id='.$setlist->t_stypeid);
        $data['t_stypeid_name']=empty($t_stype)?'':$t_stype->f_uname;
        $data['site_type']=empty($setlist)?'':$setlist->site_type;
        if(!empty($setlist->site_type)&&$setlist->site_type>0)$site_type=BaseCode::model()->find('f_id='.$setlist->site_type);
        $data['site_type_name']=empty($site_type)?'':$site_type->F_NAME;
        $data['service_id']=!empty($setlist)&&$setlist->t_typeid==1?$setlist->site_id:$gf_data->service_id;
        $data['service_name']=$gf_data->service_name;
        $data['service_data_id']=$gf_data->service_data_id;
        $data['service_data_name']=$gf_data->service_data_name;
	
        $data['service_detail']=$gf_data->project_name.' '.date("m/d",strtotime($gf_data->servic_time_star)).substr($gf_data->service_data_name,10);
        if(!empty($setlist)&&$setlist->t_typeid==1){
        	$data['service_detail']=$gf_data->project_name.' '.$data['site_type_name'].' '.$gf_data->service_name.' '.date("m/d",strtotime($gf_data->servic_time_star)).substr($gf_data->service_data_name,10);
        }
		$data['service_detail_price']=$data['service_detail'].' ￥'.$gf_data['buy_price'];
        
        //评价项目及评价分数设置
        $achie = QmddAchievemen::model()->findAll('f_type='.$gf_data->order_type);
        if(!empty($achie))foreach($achie as $i=>$v){
            $data['datas'][$i]['mark_id']=$v->f_id;
            $data['datas'][$i]['f_achid_name']=$v->f_achid_name;
            $data['datas'][$i]['f_mark']=$v->f_mark;
            $data['datas'][$i]['mark_name']=$v->f_achid_name;
            $data['datas'][$i]['max_score']=$v->f_mark;
            $data['datas'][$i]['mark_datas']=array();
            $mark_datas=BaseCode::model()->findAll("F_TYPECODE like '".$v->f_mark_code."__' and F_CODE >=1 and F_CODE<=".$v->f_mark);
			foreach($mark_datas as $index=>$mark_item){
	            $data['datas'][$i]['mark_datas'][$index]['id']=$mark_item->f_id;
	            $data['datas'][$i]['mark_datas'][$index]['score']=$mark_item->F_CODE;
	            $data['datas'][$i]['mark_datas'][$index]['score_name']='('.$mark_item->F_NAME.')';
	        }
        }
	    set_error_tow($data,count($gf_data),0,"拉取数据成功",1,"拉取数据失败",1);
    }

	/**
	 * 评价订单
	 */
	function actionInsert_order_comments(){
        $data=get_error(1,"");
        $param=decodeAskParams($_REQUEST,1);
        $gfid=$param['gfid'];     //gfid
        $order_num=$param['order_num'];     //订单号
        $gf_service_data_id=$param['gf_service_data_id']; //必填，io_order/get_evaluate_list的id
        $f_mark=$param['f_mark'];   //[{"mark_id":"4","mark_score":"5"},{"mark_id":"5","mark_score":"3"}]
        $evaluate_info=empty($param['evaluate_info'])?'':$param['evaluate_info'];     //评价内容
        $evaluate_img=empty($param['evaluate_img'])?'':$param['evaluate_img'];     //评价图片，多张图片以“|”分割
         
        $gf_data=GfServiceData::model()->find('id='.$gf_service_data_id.' and order_type=353 and info_order_num="'.$order_num.'" and gfid='.$gfid);
        if(empty($gf_data)){
            set_error($data,1,"评价失败",1);
        }
        $orderInfo = MallSalesOrderData::model()->find('orter_item=757 and gf_service_id='.$gf_service_data_id.' and order_num="'.$order_num.'"');
        $f_mark=json_decode(base64_decode($f_mark));
        $sf=0;
        foreach($f_mark as $v){
            $achie_data = QmddAchievemenData::model()->find('gf_service_data_id='.$gf_service_data_id.' and f_achievemenid='.$v->mark_id);
            if(empty($achie_data)){
                $achie_data = new QmddAchievemenData();
                $achie_data->isNewRecord = true;
                unset($achie_data->f_id);
                $achie_data->f_achievemenid = $v->mark_id;
                $achie_data->gf_service_data_id = $gf_service_data_id;
            }
            if(!empty($orderInfo)){
                $achie_data->order_num_id = $orderInfo->id;
            }
            $achie_data->order_num = $order_num;
            $achie_data->order_type = $gf_data->order_type;
            $achie_data->order_type_name = $gf_data->order_type_name;
            $achie_data->service_id = $gf_data->service_id;
            $achie_data->service_code = $gf_data->service_code;
            $achie_data->service_ico = $gf_data->service_ico;
            $achie_data->service_name = $gf_data->service_name;
            $achie_data->service_data_id = $gf_data->service_data_id;
            $achie_data->service_data_name = $gf_data->service_data_name;
            $achie_data->gf_id = $gfid;
            $achie_data->service_order_num = $gf_data->order_num;
            $achie_data->club_id = $gf_data->supplier_id;
            $achie_data->f_mark1 = $v->mark_score;
            $achie_data->evaluate_info = $evaluate_info;
            $achie_data->evaluate_img = $evaluate_img;
            $achie_data->evaluate_time = date('Y-m-d H:i:s');
            $sf=$achie_data->save();
        }
        if($sf==1){//更新服务单状态
            GfServiceData::model()->updateByPk($gf_service_data_id,array('order_state'=>1172));
        }
        set_error_tow($data,$sf,0,"评价成功",1,"评价失败",1);
    }

	/**
	 * 获取动动约服务评价详情
	 */
	function actionGet_ddy_evaluate_detail(){
        $param=decodeAskParams($_REQUEST,1);
        $gfid=$param['visit_gfid'];//gfid
        $gf_service_data_id=$param['gf_service_data_id'];//必填，io_order/get_order_list的datas/datas的id
        $data=get_error(1,"");
		$cr = new CDbCriteria;
		$cr->condition="id=".$gf_service_data_id;
		$cr->select="supplier_id as club_id,supplier_name as club_name,service_ico,service_name,t_stypename,service_address,show_service_data_title,buy_price,qmdd_server_set_list_id,project_id";
		$service_data=GfServiceData::model()->find($cr,array(),false);
		if(empty($service_data)){
			set_error($data,1,"获取评价失败",1);
		}
        $order_info=array();
        $path_www=getShowUrl('file_path_url');
        $order_info['order_type_name']='动动约';
        $order_info['club_id']=$service_data['club_id'];
        $order_info['club_name']=$service_data['club_name'];
        $order_info['project_id']=$service_data['project_id'];
		$order_info['show_order_title']=$order_info['order_type_name'].' | '.$service_data['club_name'];
		$order_info['service_pic']=CommonTool::model()->url_path_name($path_www,$service_data['service_ico']);
		$order_info['service_show_html']='<b>'.$service_data['service_name']."</b><br/>".$service_data['t_stypename'];//."<br/><font color=\"#808080\">".$service_data['service_address']."</font>"
		$order_info['service_content']=$service_data['show_service_data_title'];
		$order_info['service_fee']='¥'.$service_data['buy_price'];
        
        $setlist=QmddServerSetList::model()->find('id='.$service_data['qmdd_server_set_list_id']);
        if(!empty($setlist)){
        	$order_info['t_typeid']=$setlist->t_typeid;
        	$order_info['id']=$setlist->t_typeid==1?$setlist->site_id:$setlist->server_sourcer_id;
        }
        
        $cr = new CDbCriteria;
        $cr->condition='gf_service_data_id='.$gf_service_data_id.' and gf_id='.$gfid;
        $cr->select="order_type_name,service_ico,service_id,service_type,service_name,service_data_id,service_data_name,f_achievemenid,f_achievemen_name,f_mark1,f_mark1_name,evaluate_info,evaluate_img,evaluate_time";
        $achie_data = QmddAchievemenData::model()->findAll($cr,array(),false);
		if(empty($achie_data)){
			set_error($data,1,"获取评价失败",1);
		}
        $eva=array();
        foreach($achie_data as $k=>$v){
        	if($k==0){
        		$order_info['evaluate_info']=$v['evaluate_info'];
        		$order_info['evaluate_time']=$v['evaluate_time'];
        		$order_info['evaluate_img']=CommonTool::model()->addto_url_dir($path_www,$v['evaluate_img'],",",'');
        	}
        	
        	$eva[$k]=CommonTool::model()->getKeyArray($v,'f_achievemen_name,f_mark1,f_mark1_name',array());
        	$eva[$k]['f_achievemen_name']='对'.$v['f_achievemen_name'].'评价';
        	$eva[$k]['f_mark1_name']='('.$v['f_mark1_name'].')';
        	$eva[$k]['max_score']=5;
        } 
        $order_info['evaluated']=$eva;
        $data['datas']=$order_info;
        set_error_tow($data,count($achie_data),0,"获取评价成功",1,"获取评价失败",1);
	}

	/**
	 * 获取评价列表
	 */
	function actionGet_product_evaluate_list(){
        $param=decodeAskParams($_REQUEST,1);
        QmddAchievemenData::model()->getEvaluateList($param);
	}
	
	/**
	 * 用户删除自己发表的评价
	 */
	function actionDel_evaluate(){
        $param=decodeAskParams($_REQUEST,1);
        QmddAchievemenData::model()->DelEvaluate($param);
	}
	
}

?>