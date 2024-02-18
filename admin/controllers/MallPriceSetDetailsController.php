<?php

class MallPriceSetDetailsController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
    ///库存及销售明细
    public function actionIndex($keywords = '',$supplier='',$start_time='',$end_time='') {
         $this->ShowView($keywords,$supplier,$start_time,$end_time,' AND t.supplier_id='.get_session('club_id'),'',$mth=1,'index');
    }
    ///库存及销售明细查询
    public function actionIndex_gf($keywords = '',$supplier='',$start_time='',$end_time='') {
         $this->ShowView($keywords,$supplier,$start_time,$end_time,'','',$mth=1,'index_gf');
    }
    ///在销售商品列表
    public function actionIndex_sale($keywords = '',$supplier='',$start_time='',$end_time='') {
        $now=date('Y-m-d H:i:s');
         $this->ShowView($keywords,$supplier,$start_time,$end_time,' AND t.supplier_id='.get_session('club_id'),' and t.start_sale_time<="'.$now.'" and t.down_time>="'.$now.'"',$mth=0,'index_sale');
    }
    ///在销售商品查询
    public function actionIndex_sale_gf($keywords = '',$supplier='',$start_time='',$end_time='') {
        $now=date('Y-m-d H:i:s');
         $this->ShowView($keywords,$supplier,$start_time,$end_time,'',' and t.start_sale_time<="'.$now.'" and t.down_time>="'.$now.'"',$mth=0,'index_sale_gf');
    }

    ///待售商品列表
    public function actionIndex_forsale($keywords = '',$supplier='',$start_time='',$end_time='') {
        $now=date('Y-m-d H:i:s');
         $this->ShowView($keywords,$supplier,$start_time,$end_time,' AND t.supplier_id='.get_session('club_id'),' and t.start_sale_time>"'.$now.'"',$mth=0,'index_forsale');
    }
    ///待售商品查询
    public function actionIndex_forsale_gf($keywords = '',$supplier='',$start_time='',$end_time='') {
        $now=date('Y-m-d H:i:s');
         $this->ShowView($keywords,$supplier,$start_time,$end_time,'',' and t.start_sale_time>"'.$now.'"',$mth=0,'index_forsale_gf');
    }

    public function ShowView($keywords = '',$supplier='',$start_time='',$end_time='',$club='',$time='',$mth=0,$viewfile) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        if($mth==1){
            $now=date('Y-m-d');
            $now_m=date("Y-m-d",strtotime("-1 months",strtotime($now)));
            if ($start_time=='') $start_time=$now_m;
        }
        $criteria = new CDbCriteria;
        $criteria->join= "JOIN mall_price_set on t.set_id=mall_price_set.id";
        $cr='t.pricing_type=361 and t.f_check=2 and down_pricing_set_id=0';
        $cr.=$club;
        $cr.=$time;
        $cr=get_where($cr,($start_time!=""),'t.start_sale_time>=',$start_time.' 00:00:00','"');
        $cr=get_where($cr,($end_time!=""),'t.down_time<=',$end_time.' 23:59:59','"');
        $cr=get_like($cr,'t.supplier_name',$supplier,'');
        $cr=get_like($cr,'set_code,product_code,product_name',$keywords,'');
        $criteria->condition=$cr;
        //$criteria->group='t.id';
        $criteria->order = 't.start_sale_time DESC';
        //$criteria->order= 't.set_code DESC';
        $data = array();
        $data['start_time'] = $start_time;
        $data['end_time'] = $end_time;
        parent::_list($model, $criteria, $viewfile, $data);
    }
///单位-每日销售统计
    public function actionIndex_count($keywords = '',$supplier='',$start_time='',$end_time='') {
        $this->ShowCount($keywords,$supplier,$start_time,$end_time,' AND t.supplier_id='.get_session('club_id'),'index_count');
    }
///财务-商品销售统计
    public function actionIndex_count_gf($keywords = '',$supplier='',$start_time='',$end_time='') {
        $this->ShowCount($keywords,$supplier,$start_time,$end_time,'','index_count_gf');
    }
    public function ShowCount($keywords = '',$supplier='',$start_time='',$end_time='',$club='',$viewfile) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d H:i:s');
        $today=date('Y-m-d');
        if ($start_time=='') $start_time=$today;
        if ($end_time=='') $end_time=$today;
        $criteria = new CDbCriteria;
        $criteria->join= "JOIN mall_price_set on t.set_id=mall_price_set.id";
        $cr=' mall_price_set.pricing_type=361 and t.f_check=2 and t.down_pricing_set_id=0';
        $cr.=$club;
        $cr.=' and t.star_time<="'.$now.' 00:00:00" and t.end_time>="'.$now.' 23:59:59"';
        $cr=get_like($cr,'t.supplier_name',$supplier,'');
        $cr=get_like($cr,'t.set_code,t.product_code,t.product_name',$keywords,'');
        $criteria->condition=$cr;
        //$criteria->group='t.id';
        $criteria->order = 't.start_sale_time DESC';
        $data = array();
        $sql='change_type=0'.$club.' AND order_Date >="'.$today.' 00:00:00"';
        $sqlr='change_type=1137'.$club.' AND order_Date >="'.$today.' 00:00:00" and ret_state=2';
        $data['t_num']=MallSalesOrderData::model()->count($sql);
        $data['r_num']=MallSalesOrderData::model()->count($sqlr);
        $orderdata=MallSalesOrderData::model()->findAll($sql);
        $r_data=MallSalesOrderData::model()->findAll($sqlr);
        $p=0;
        $r=0;
        foreach($orderdata as $v){
            $p=$p+$v->buy_amount+$v->post;  
        }
        foreach($r_data as $v){
            $r=$r+$v->ret_amount;    
        }
        $data['money']=$p;
        $data['r_money']=$r;
        $data['start_time'] = $start_time;
        $data['end_time'] = $end_time;
        parent::_list($model, $criteria, $viewfile, $data);
    } 

    public function actionIndex_lower($keywords = '',$start_time='',$end_time='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        $now_m=date("Y-m-d",strtotime("-1 months",strtotime($now)));
        if ($start_time=='') $start_time=$now_m;
        $criteria = new CDbCriteria;
        $criteria->join= "JOIN mall_price_set on t.set_id=mall_price_set.id";
        $cr='t.pricing_type=361 and t.f_check=2 and down_pricing_set_id>0';
        $cr.=' AND t.supplier_id='.get_session('club_id');
        $cr=get_where($cr,($start_time!=""),'t.down_time>=',$start_time.' 00:00:00','"');
        $cr=get_where($cr,($end_time!=""),'t.down_time<=',$end_time.' 23:59:59','"');
        $cr=get_like($cr,'set_code,product_code,product_name',$keywords,'');
        $criteria->condition=$cr;
        //$criteria->group='t.id';
        $criteria->order = 't.down_time DESC';
        //$criteria->order= 't.set_code DESC';
        $data = array();
        $data['start_time'] = $start_time;
        $data['end_time'] = $end_time;
        parent::_list($model, $criteria, 'index_lower', $data);
    }
    //查看销售明细
	public function actionLog($detail_id) {
        $model = MallSalesOrderData::model();
        $criteria = new CDbCriteria;
        $cr= 'set_detail_id='.$detail_id;
        $cr.=' and (ret_state=2 or ret_state=0 or ret_state="" or ret_state is null)';
        $criteria->condition=$cr;
        $criteria->order = 'id ASC';
        $data = array();
		$data['detail']=MallPriceSetDetails::model()->find('id='.$detail_id);
        parent::_list($model, $criteria, 'log', $data,20);
    } 
	//刷新库存
	public function actionQuantity($detail_id) {
        $modelName = $this->model;
        $model = $this->loadModel($detail_id, $modelName);
		$count=0;
        $orderdata=MallSalesOrderData::model()->find('set_detail_id='.$detail_id);
		if(!empty($orderdata)) {
			$orderdata->order_no=$orderdata->order_no+1;
			$st=$orderdata->save();
		} else {
			$count=MallPriceSetDetails::model()->updateAll(array('sale_order_data_quantity'=>0 ),'id='.$detail_id);
			MallPricingDetails::model()->updateAll(array('sale_order_data_quantity'=>0 ),'set_details_id='.$detail_id);
		}
		ajax_status(1, '刷新成功');
	
    }          

}

 

