<?php

class MallSalesOrderInfoController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
    //综合订单查询
    public function actionIndex_all($start='',$end='',$order_num='',$gf_name='',$order_type='',$pay_type='',$index = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
		$now=date('Y-m-d'); 
        if ($start=='') $start=$now;
        $criteria = new CDbCriteria;
        $criteria->join = "JOIN mall_sales_order_data on t.order_data=mall_sales_order_data.order_num";
		$cr=get_where_club_project('mall_sales_order_data.supplier_id','');
		$cr.=' and if_del=648 AND t.type=757';
        $cr=get_where($cr,!empty($order_type),' t.order_type',$order_type,'');
        $cr=get_where($cr,!empty($pay_type),' t.pay_supplier_type',$pay_type,'');
		$cr=get_like($cr,'order_num',$order_num,'');
		$cr=get_like($cr,'t.order_gfaccount,t.order_gfname',$gf_name,'');
		$cr=get_where($cr,$start,'t.pay_time>=',$start.' 00:00:00','"');
        $cr=get_where($cr,$end,'t.pay_time<=',$end.' 23:59:59','"');
        $criteria->condition=$cr;
		$criteria->group = 't.order_num';
		$criteria->select='t.id id,t.order_num order_num,order_gfaccount order_gfaccount,order_gfname order_gfname,sum(mall_sales_order_data.buy_count*mall_sales_order_data.buy_price+mall_sales_order_data.post_total) order_money , sum(mall_sales_order_data.total_pay),sum(mall_sales_order_data.buy_beans) beans total_money,mall_sales_order_data.supplier_name supplier_name,t.order_type_name order_type_name,t.pay_time pay_time,t.pay_supplier_type_name pay_supplier_type_name';
		$criteria->order = 't.pay_time DESC';
		$data = array();
		$data['start'] = $start;
        $data['end'] = $end;
        $data['order_type'] = BaseCode::model()->getOrderType();
        $data['pay_type'] = BaseCode::model()->getCode(482);
        parent::_list($model, $criteria, 'index_all', $data);
    }
    //单位-订单列表
    public function actionIndex($keywords = '',$start='',$end='',$pay_type='',$order_type='') {
        $cr_join = "JOIN mall_sales_order_data on t.id=mall_sales_order_data.info_id";
        $cr_add='';
        $this->ShowViewIndex($keywords,$start,$end,$pay_type,$order_type,' and supplier_id='.get_session('club_id'),$cr_join,$cr_add,'index');
    }
    //商城-已完成订单列表
    public function actionIndex_completed($keywords = '',$start='',$end='',$pay_type='',$order_type='') {
        $cr_join = 'LEFT JOIN mall_sales_order_data ON t.id = mall_sales_order_data.info_id LEFT JOIN order_record ON t.order_num = order_record.order_num';
        $cr_add=' AND t.audit_state = "待审核"  AND order_record.order_state_name = "交易完成"';
         $this->ShowViewIndex($keywords,$start,$end,$pay_type,$order_type,' and supplier_id='.get_session('club_id'),$cr_join,$cr_add,'index_completed');
    }
    //商城-审核通过列表
    public function actionIndex_audit_pass($keywords = '',$start='',$end='',$pay_type='',$order_type='') {
        $cr_join = "JOIN mall_sales_order_data on t.id=mall_sales_order_data.info_id";
        $cr_add=' AND t.audit_state = "审核通过"';
         $this->ShowViewIndex($keywords,$start,$end,$pay_type,$order_type,' and supplier_id='.get_session('club_id'),$cr_join,$cr_add,'index_audit_pass');
    }
    //商城-审核未通过列表
    public function actionIndex_audit_nopass($keywords = '',$start='',$end='',$pay_type='',$order_type='') {
        $cr_join = "JOIN mall_sales_order_data on t.id=mall_sales_order_data.info_id";
        $cr_add=' AND t.audit_state = "审核未通过"';
         $this->ShowViewIndex($keywords,$start,$end,$pay_type,$order_type,' and supplier_id='.get_session('club_id'),$cr_join,$cr_add,'index_audit_nopass');
    }
    //财务-订单列表
    public function actionIndex_gf($keywords = '',$start='',$end='',$pay_type='',$order_type='') {
        $cr_join = "JOIN mall_sales_order_data on t.id=mall_sales_order_data.info_id";
        $cr_add='';
        $this->ShowViewIndex($keywords,$start,$end,$pay_type,$order_type,'',$cr_join,$cr_add,'index_gf');
    }
    //财务-已完成订单列表
    public function actionIndex_gf_completed($keywords = '',$start='',$end='',$pay_type='',$order_type='') {
        $cr_join = 'LEFT JOIN mall_sales_order_data ON t.id = mall_sales_order_data.info_id LEFT JOIN order_record ON t.order_num = order_record.order_num';
        $cr_add=' AND t.audit_state = "待审核"  AND order_record.order_state_name = "交易完成"';
        $this->ShowViewIndex($keywords,$start,$end,$pay_type,$order_type,'',$cr_join,$cr_add,'index_gf_completed');
    }
    //财务-审核通过列表
    public function actionIndex_gf_audit_pass($keywords = '',$start='',$end='',$pay_type='',$order_type='') {
        $cr_join = "JOIN mall_sales_order_data on t.id=mall_sales_order_data.info_id";
        $cr_add=' AND t.audit_state = "审核通过"';
        $this->ShowViewIndex($keywords,$start,$end,$pay_type,$order_type,'',$cr_join,$cr_add,'index_gf_audit_pass');
    }
    //财务-审核未通过列表
    public function actionIndex_gf_audit_nopass($keywords = '',$start='',$end='',$pay_type='',$order_type='') {
        $cr_join = "JOIN mall_sales_order_data on t.id=mall_sales_order_data.info_id";
        $cr_add=' AND t.audit_state = "审核未通过"';
        $this->ShowViewIndex($keywords,$start,$end,$pay_type,$order_type,'',$cr_join,$cr_add,'index_gf_audit_nopass');
    }
    public function ShowViewIndex($keywords='',$start='',$end='',$pay_type='',$order_type='',$club='',$cr_join='',$cr_add='',$viewfile) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        // if ($start=='') $start=$now;
        $criteria = new CDbCriteria;
		// $criteria->join = "JOIN mall_sales_order_data on t.id=mall_sales_order_data.info_id";
        $criteria->join = $cr_join;
		$cr='t.if_del=648 AND t.type=757';
        $cr.=$cr_add;
		$cr.=$club;
        $cr=get_where($cr,!empty($order_type),' t.order_type',$order_type,'');
        $cr=get_where($cr,!empty($pay_type),' t.pay_supplier_type',$pay_type,'');
		$cr=get_like($cr,'t.order_num,order_gfaccount,order_gfname',$keywords,'');
		$cr=get_where($cr,$start,'t.pay_time>=',$start.' 00:00:00','"');
        $cr=get_where($cr,$end,'t.pay_time<=',$end.' 23:59:59','"');
        $criteria->condition=$cr;
		$criteria->group = 't.id';
		$criteria->select='t.id id,t.order_num order_num,order_gfaccount order_gfaccount,order_gfname order_gfname,sum(mall_sales_order_data.buy_count*mall_sales_order_data.buy_price) order_money , sum(mall_sales_order_data.post_total) post, sum(mall_sales_order_data.total_pay) total_money,sum(mall_sales_order_data.bean_discount) bean_discount,t.order_type order_type,t.order_type_name order_type_name,t.pay_time pay_time,t.pay_supplier_type_name pay_supplier_type_name,t.audit_state audit_state';
		$criteria->order = 'pay_time DESC';
		$data = array();
		$data['pay_type'] = BaseCode::model()->getPayway();
		$data['order_type'] = BaseCode::model()->getProductType();
		$data['start'] = $start;
        $data['end'] = $end;
        $cu = new CDbCriteria;
        $cu->join = "JOIN mall_sales_order_data on t.id=mall_sales_order_data.info_id";
        $cu->condition='if_del=648 AND t.type=757 and pay_time>="'.$now.' 00:00:00"'.$club;
        $cu->group = 't.id';
        $data['num'] = $model->count($cu);
        $cp = new CDbCriteria;
        $cp->join = "JOIN mall_sales_order_info on t.info_id=mall_sales_order_info.id";
        $cp->condition='mall_sales_order_info.if_del=648 AND mall_sales_order_info.type=757 and mall_sales_order_info.pay_time>="'.$now.' 00:00:00"'.$club;
        $p_data=MallSalesOrderData::model()->findAll($cp);
        $p_num=0;
        if (!empty($p_data)) foreach($p_data as $p) $p_num=$p_num+$p->buy_count;
        $data['p_num'] =$p_num;
        parent::_list($model, $criteria, $viewfile, $data);
    }
    //支付统计
    public function actionIndex_pay($start='',$end='',$pay_type='',$order_num='',$gf_name='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
		$now=date('Y-m-d');
        if ($start=='') $start=$now;
        $criteria = new CDbCriteria;
		$cr='if_del=648 AND type=757';
		$cr=get_where($cr,$pay_type,'pay_supplier_type',$pay_type,'');
		$cr=get_like($cr,'order_num',$order_num,'');
		$cr=get_like($cr,'order_gfaccount,order_gfname',$gf_name,'');
        $cr=get_where($cr,$start,'t.order_Date>=',$start.' 00:00:00','"');
        $cr=get_where($cr,$end,'t.order_Date<=',$end.' 23:59:59','"');
        $criteria->condition=$cr;
		$criteria->order = 'order_Date ASC';
		$data = array();
		$data['pay_type'] = BaseCode::model()->getPayway();
		$data['start'] = $start;
        $data['end'] = $end;
        parent::_list($model, $criteria, 'index_pay', $data);
    }

    // 订单列表
	public function actionIndex_server($keywords='',$start='',$end='',$order_type=0,$pay_supplier_type='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
		$now = date('Y-m-d');
        if ($start=='') $start = $now;
        $criteria = new CDbCriteria;
        $criteria->join = "JOIN mall_sales_order_data on t.order_num=mall_sales_order_data.order_num";
		$cr = 'if_del=648 AND t.type=757 AND t.order_type='.$order_type.' and '.get_where_club_project('supplier_id');
		$cr = get_where($cr,!empty($pay_supplier_type),'pay_supplier_type',$pay_supplier_type,'');
		$cr = get_where($cr,$start,'left(t.pay_time,10)>=',$start,'"');
        $cr = get_where($cr,$end,'left(t.pay_time,10)<=',$end,'"');
		$cr = get_like($cr,'t.order_num,t.order_gfaccount,t.order_gfname',$keywords,'');
        $criteria->condition = $cr;
        $criteria->group = 't.order_num';
        $select = 't.id id,t.order_num order_num,order_gfaccount order_gfaccount,order_gfname order_gfname,mall_sales_order_data.supplier_name supplier_name,';
        $select .= 'sum(mall_sales_order_data.buy_count*mall_sales_order_data.buy_price+mall_sales_order_data.post_total) order_money,';
        $select .= 'sum(mall_sales_order_data.total_pay) total_money,t.order_type_name order_type_name,t.pay_time pay_time,t.pay_supplier_type_name pay_supplier_type_name';
		$criteria->select = $select;
        $criteria->order = 'pay_time DESC';
		$data = array();
		$data['start'] = $start;
        $data['end'] = $end;
        $data['pay_list'] = BaseCode::model()->getCode('482');
		$cu = new CDbCriteria;
        $cu->join = "JOIN mall_sales_order_data on t.id=mall_sales_order_data.info_id";
        $cu->condition='if_del=648 AND t.type=757 and pay_time>="'.$now.'"';
        $cu->group = 't.id';
        $data['num'] = $model->count($cu);
        parent::_list($model, $criteria, 'index_server', $data);
    }

    //已取消订单列表
    public function actionIndex_Canc($order_num='',$start='',$end='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        if ($end=='') $end=$now;
        $criteria = new CDbCriteria;
        $cr='if_del=649 AND t.type=757 AND pay_time';
        $cr=get_where($cr,$start,'t.pay_time>=',$start.' 00:00:00','"');
        $cr=get_where($cr,$end,'t.pay_time<=',$end.' 23:59:59','"');
        $criteria->order = 'pay_time ASC';
        $data = array();
        $data['start'] = $start;
        $data['end'] = $end;                   
        parent::_list($model, $criteria, 'index_Canc', $data);
    }

    public function actionIndex_member($start='',$end='',$order_num='',$gf_name='',$order_type=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $today=date('Y-m-d');
		$start =  get_date_default($start);
        $end =  get_date_default($end,1);
        $criteria = new CDbCriteria;
        $cr=' if_del=648 AND t.type=757 AND order_type';
        $cr.=($order_type>0) ? '='.$order_type : ' in (355,356,357,358)';
		$cr=get_like($cr,'order_num',$order_num,'');
		$cr=get_like($cr,'order_gfaccount,order_gfname',$gf_name,'');
		$cr=get_where($cr,$start,'pay_time>=',$start,"'");
        $criteria->condition=get_where($cr,$end,'pay_time<=',$end,"'");
		$criteria->order = 'pay_time DESC';
		$data = array();
		$data['start'] = $start;
        $data['end'] = $end;
		$data['order_type'] = BaseCode::model()->findAll('f_id in (355,356,357,358)');
        parent::_list($model, $criteria, 'index_member', $data);
    }
	
	
	public function actionIndex_return($start='',$end='',$pay_type='',$order_num='',$gf_name='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
		$today=date('Y-m-d');
        $criteria = new CDbCriteria;
		$criteria->condition='if_del=648 AND type=758';
		$criteria->condition=get_where($criteria->condition,!empty($pay_type),'pay_supplier_type',$pay_type,'');
		$criteria->condition=get_like($criteria->condition,'order_num',$order_num,'');
		$criteria->condition=get_like($criteria->condition,'order_gfaccount,order_gfname',$gf_name,'');
		$criteria->condition=get_where($criteria->condition,($start!=""),'order_Date>=',$start,'"');
        $criteria->condition=get_where($criteria->condition,($end!=""),'order_Date<=',$end,'"');
		if(empty($order_num) && empty($start) && empty($end) && empty($gf_name)){
			$criteria->condition.=' AND (pay_time like "'.$today.'%")';
		}
		$criteria->order = 'order_Date ASC';
		$data = array();
		$data['pay_type'] = BaseCode::model()->getPayway();
        parent::_list($model, $criteria, 'index_return', $data);

     }
	public function actionIndex_paid($order_type='',$keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
		$criteria = new CDbCriteria;
		if($order_type==''){
			$criteria->condition='order_type in(355,1162) and buyer_type=502 and order_gfid='.get_session('club_id');
		}
		// $criteria->condition.='and buyer_type=502 and order_gfid='.get_session('club_id');
        $criteria->condition=get_where($criteria->condition,!empty($order_type),'order_type',$order_type,'"');
		$criteria->condition = get_like($criteria->condition,'order_num',$keywords,'');
        $criteria->order = 'id DESC';
		$data = array();
		$data['order_type'] = BaseCode::model()->getReturn('355,1162');
        parent::_list($model, $criteria, 'index_paid', $data);
    }
//单位-订单详情
    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
		   $data['model'] = $model;
			$data['order_data'] = MallSalesOrderData::model()->findAll('info_id='.$model->id.' and supplier_id='.get_session('club_id'));
		   $data['order_record'] = OrderRecord::model()->findAll('order_num="'.$model->order_num.'"');
           $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
	}
//商城-订单审核
    public function actionUpdate_audit($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
            $data['order_data'] = MallSalesOrderData::model()->findAll('info_id='.$model->id.' and supplier_id='.get_session('club_id'));
           $data['order_record'] = OrderRecord::model()->findAll('order_num="'.$model->order_num.'"');
          
           $this->render('update_audit', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
    } 
//商城-订单审核通过
    public function actionUpdate_audit_pass($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
            $data['order_data'] = MallSalesOrderData::model()->findAll('info_id='.$model->id.' and supplier_id='.get_session('club_id'));
           $data['order_record'] = OrderRecord::model()->findAll('order_num="'.$model->order_num.'"');
          
           $this->render('update_audit_pass', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
    } 
//商城-订单审核未通过
    public function actionUpdate_audit_nopass($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
            $data['order_data'] = MallSalesOrderData::model()->findAll('info_id='.$model->id.' and supplier_id='.get_session('club_id'));
           $data['order_record'] = OrderRecord::model()->findAll('order_num="'.$model->order_num.'"');
          
           $this->render('update_audit_nopass', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
    }   
//财务-订单详情
	public function actionUpdate_gf($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
		   $data['model'] = $model;
		   $data['order_data'] = MallSalesOrderData::model()->findAll('info_id='.$model->id);
		   $data['order_record'] = OrderRecord::model()->findAll('order_num="'.$model->order_num.'"');
          
           $this->render('update_gf', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
	}
//财务-订单审核
    public function actionUpdate_gf_audit($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
            $data['order_data'] = MallSalesOrderData::model()->findAll('info_id='.$model->id.' and supplier_id='.get_session('club_id'));
           $data['order_record'] = OrderRecord::model()->findAll('order_num="'.$model->order_num.'"');
          
           $this->render('update_gf_audit', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
    } 
//财务-订单审核通过
    public function actionUpdate_gf_audit_pass($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
            $data['order_data'] = MallSalesOrderData::model()->findAll('info_id='.$model->id.' and supplier_id='.get_session('club_id'));
           $data['order_record'] = OrderRecord::model()->findAll('order_num="'.$model->order_num.'"');
          
           $this->render('update_gf_audit_pass', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
    } 
//财务-订单审核未通过
    public function actionUpdate_gf_audit_nopass($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
            $data['order_data'] = MallSalesOrderData::model()->findAll('info_id='.$model->id.' and supplier_id='.get_session('club_id'));
           $data['order_record'] = OrderRecord::model()->findAll('order_num="'.$model->order_num.'"');
          
           $this->render('update_gf_audit_nopass', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
    } 

	
    public function actionUpdate_paid($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
		   $data['model'] = $model;
           $this->render('update_paid', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate_server($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
		   $data['model'] = $model;
		   if(get_session('use_club_id')==0){
		       $data['order_data'] = MallSalesOrderData::model()->findAll('order_num="'.$model->order_num.'"');
		   } else {
			   $data['order_data'] = MallSalesOrderData::model()->findAll('order_num="'.$model->order_num.'" and supplier_id='.get_session('club_id'));
		   }
		   $data['order_record'] = OrderRecord::model()->findAll('order_num="'.$model->order_num.'"');
          
           $this->render('update_server', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
    }

    public function actionUpdate_member($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
		   $data['model'] = $model;
		   $data['order_data'] = MallSalesOrderData::model()->findAll('order_num="'.$model->order_num.'"');
		   $data['order_record'] = OrderRecord::model()->findAll('order_num="'.$model->order_num.'"');
          
           $this->render('update_member', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
    }
	
	public function actionSign_in($id){
        $model = MallSalesOrderInfo::model()->find('id='.$id);
		$orderrecode = new OrderRecord();
		$orderrecode->isNewRecord = true;
		unset($orderrecode->id);
		$orderrecode->order_num = $model->order_num;
		$orderrecode->is_pay = 464;
		$orderrecode->order_state = 469;
		$orderrecode->order_state_des_content = $model->content;
		$orderrecode->user_member = 502;
		$orderrecode->logistics_state = 474;
		$sn=$orderrecode->save();
		$action=$this->createUrl('mallSalesOrderInfo/index');
		
        $achie = QmddAchievemen::model()->findAll('f_type='.$model->order_type);
        $orderInfo = MallSalesOrderData::model()->find('order_num="'.$model->order_num.'"');
        $achie_data = new QmddAchievemenData;
        if(!empty($achie))foreach($achie as $v){
            $achie_data->isNewRecord=true;
            unset($achie_data->f_id);
            if(!empty($orderInfo)){
                $achie_data->order_num_id = $orderInfo->id;
            }
            $achie_data->f_achievemenid = $v->f_id;
            $sf=$achie_data->save();
		}
        $sv= ($sf==1&&$sn==1) ? 1 : 0;
		show_status($sv,'已签收',$action,'签收失败');
	}

    // function saveData($model,$post) {
    //    $model->attributes =$post;
	//    $orderrecode = new OrderRecord();
	//    $o_data=MallSalesOrderData::model()->find('order_num="'.$model->order_num.'"');
	// 	if ($_POST['submitType'] == 'qveren') {
	// 		$orderrecode->isNewRecord = true;
    //         unset($orderrecode->id);
    //         $orderrecode->order_id = $model->id;
    //         $orderrecode->order_num = $model->order_num;
	// 		$orderrecode->is_pay = 464;
	// 		$orderrecode->order_state = 465;
	// 		$orderrecode->order_state_des_content = $model->content;
	// 		$orderrecode->user_member = 502;
	// 		$orderrecode->logistics_state = 472;
    //         $st=$orderrecode->save();
    //     } else if ($_POST['submitType'] == 'fahuodan') {
	// 		//$this->save_deliver($model->order_num,$model->post,$post['deliver_num']);
	// 		if (isset($_POST['deliver_num'])) { 
	// 			$numcount=OrderInfoLogistics::model()->count('order_num="'.$model->order_num.'"');
	// 			$code = substr('00' . strval($numcount), -2);
	// 			foreach ($_POST['deliver_num'] as $v) {
	// 				if ($v['id']=='' || $v['num']=='') {
	// 				   continue;
	// 				 } else {
	// 					$logistics = new OrderInfoLogistics();
	// 					$logistics->isNewRecord = true;
	// 					unset($logistics->id);
	// 					$logistics->order_num = $model->order_num;
	// 					$logistics->logistics_xh = $code;
	// 					$logistics->logistica_price = $model->post;
	// 					$logistics->supplier = $v['supplier_id'];
	// 					$logistics->logistics_order_xh = $v['id'];
	// 					$logistics->buy_count = $v['num'];
	// 					$logistics->logistics_state = 472;
	// 					$sv=$logistics->save();
	// 					if($sv->save()) {
	// 						$orderrecode->isNewRecord = true;
	// 						unset($orderrecode->id);
	// 						$orderrecode->order_id = $model->id;
	// 						$orderrecode->order_num = $model->order_num;
	// 						$orderrecode->is_pay = 464;
	// 						$orderrecode->order_state = 467;
	// 						$orderrecode->order_state_des_content = $model->content;
	// 						$orderrecode->user_member = 502;
	// 						$orderrecode->logistics_state = 472;
	// 						$st=$orderrecode->save();
	// 						ajax_status(1, '生成发货单成功', get_cookie('_currentUrl_'));
	// 					} else {
	// 						ajax_status(0, '生成发货单失败');
	// 					}
	// 				 }
		
	// 			 }		 
 
    //  		}
	// 	} else if ($_POST['submitType'] == 'peisong') {
	// 		$orderrecode->isNewRecord = true;
    //         unset($orderrecode->id);
    //         $orderrecode->order_id = $model->id;
    //         $orderrecode->order_num = $model->order_num;
	// 		$orderrecode->is_pay = 464;
	// 		$orderrecode->order_state = 467;
	// 		$orderrecode->order_state_des_content = $model->content;
	// 		$orderrecode->user_member = 502;
	// 		$orderrecode->logistics_state = 500;
    //         $st=$orderrecode->save();
	// 	} else if ($_POST['submitType'] == 'qianshou') {
	// 		$orderrecode->isNewRecord = true;
    //         unset($orderrecode->id);
    //         $orderrecode->order_num = $model->order_num;
	// 		$orderrecode->is_pay = 464;
	// 		$orderrecode->order_state = 469;
	// 		$orderrecode->order_state_des_content = $model->content;
	// 		$orderrecode->user_member = 502;
	// 		$orderrecode->logistics_state = 474;
    //         $st=$orderrecode->save();
	// 	}
    //    //$st=$model->save();
    //    //$errors = array();
     
	//   show_status($st,'操作成功', get_cookie('_currentUrl_'),'操作失败');   
    // }

    function saveData($model,$post) {
       $model->attributes =$post;
       // 获取审核人
       $model->audited_by=get_session('gfnick');
       // 获取当前时间作为审核时间
       $model->audit_time= date('Y-m-d H:i:s');
       show_status($model->save(),'保存成功', get_cookie('_currentUrl_'),'保存失败');  
    }
	
    //活动/培训订单列表
    public function actionIndex_serve_type($start='',$end='',$pay_type='',$order_type='',$train_type='',$keywords='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        $criteria = new CDbCriteria;
		$criteria->join = "JOIN mall_sales_order_data t2 on t.id=t2.info_id JOIN gf_service_data t3 on t2.gf_service_id=t3.id";
        $criteria->condition = get_where_club_project('t2.supplier_id').' and t.if_del=648 and t.order_type='.$order_type;
        $start=empty($start) ? date("Y-m-d") : $start;
        $end=empty($end) ? date("Y-m-d") : $end;
        if ($start != '') {
            $criteria->condition.=' and left(t.pay_time,10)>="' . $start . '"';
        }
        if ($end != '') {
            $criteria->condition.=' and left(t.pay_time,10)<="' . $end . '"';
        }
        $criteria->condition=get_where($criteria->condition,!empty($pay_type),'t.pay_supplier_type',$pay_type,'');
        if($train_type!=''){
            $criteria->join .= " JOIN club_train_data t4 on t4.id=t2.service_data_id";
            $criteria->condition=get_where($criteria->condition,!empty($train_type),'t4.type_id',$train_type,'');
        }
        $criteria->condition=get_like($criteria->condition,'t.order_num,t.order_gfaccount,t.order_gfname,t3.order_num',$keywords,'');
        $criteria->order = 't.pay_time DESC';
        $data = array();
        $cu = new CDbCriteria;
        $cu->join = "JOIN mall_sales_order_data t2 on t.id=t2.info_id";
        $cu->condition='t.if_del=648 and t.order_type='.$order_type.' and left(t.pay_time,10)="'.$now.'" and '.get_where_club_project('t2.supplier_id');
        $cu->group = 't.id';
        $data['num'] = $model->count($cu);
        $data['pay_type'] = BaseCode::model()->getPayway();
        $data['start'] = $start;
        $data['end'] = $end;
        $tp = new CDbCriteria;
        if($order_type==352){
            $tp->join = "JOIN club_store_type t2 on t.fater_id=t2.id and t2.f_id in(1504,1505)";
        }elseif($order_type==1537){
            $tp->join = "JOIN club_store_type t2 on t.fater_id=t2.id and t2.f_id in(1506)";
        }
        $data['train_type'] = ClubStoreType::model()->findAll($tp);
        parent::_list($model, $criteria, 'index_serve_type', $data);
   }

    public function actionUpdate_serve_type($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $data['order_data'] = MallSalesOrderData::model()->find('info_id='.$model->id);
            $this->render('update_serve_type', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    //逻辑删除
    public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $count = $model->updateByPk($id,array('if_del'=>649));
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }


}
