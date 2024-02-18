<?php

class MallSalesOrderDataController extends BaseController {

    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
	
//单位-每日销售明细
    public function actionIndex($keywords = '',$start='',$end='',$orter_item='',$order_type='',$is_excel=0) {
         $this->ShowViewIndex($keywords,$start,$end,$orter_item,$order_type,$is_excel,' and supplier_id='.get_session('club_id'),'index');
    }
//财务-每日销售明细
    public function actionIndex_gf($keywords = '',$start='',$end='',$orter_item='',$order_type='',$is_excel=0) {
         $this->ShowViewIndex($keywords,$start,$end,$orter_item,$order_type,$is_excel,'','index_gf','update_print');
    }
//财务-单项结算汇总
    public function actionIndex_gf_single($keywords = '',$start='',$end='',$orter_item='',$order_type='',$is_excel=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        if ($start=='') $start=$now;
        if ($end=='') $end=$now;
        $criteria = new CDbCriteria;
        $criteria->join = "JOIN mall_sales_order_info on t.info_id=mall_sales_order_info.id";
        $cr=' (t.ret_state=2 or t.ret_state=0 or t.ret_state="" or t.ret_state is null)';
        // $cr.=$club;
        $cr=get_where($cr,!empty($order_type),' mall_sales_order_info.order_type',$order_type,'');
        $cr=get_like($cr,'product_title,supplier_name,t.order_num',$keywords,'');
        $cr=get_where($cr,$start,'t.order_Date>=',$start.' 00:00:00','"');
        $cr=get_where($cr,$end,'t.order_Date<=',$end.' 23:59:59','"');
        $criteria->condition=$cr;
        $criteria->order = 'order_Date DESC';
        $data = array();
        // $data['orter_item'] = BaseCode::model()->getCode(756);
        // $data['order_type'] = BaseCode::model()->getProductType();
        // $data['pay_type'] = BaseCode::model()->getCode(482);
        $data['order_type'] = BaseCode::model()->findAll('f_id in (1700,1701)');
        $data['start'] = $start;
        $data['end'] = $end;
        parent::_list($model, $criteria, 'index_gf_single', $data);
    }
//财务-商品每日销售明细汇总
    // public function actionIndex_gf_product($keywords='',$start='',$end='',$orter_item='',$order_type='', $is_excel=0,$club='') {
    public function actionIndex_gf_product($keywords='',$start='',$end='',$orter_item='',$order_type='', $is_excel=0,$club='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        if ($start=='') $start=$now;
        if ($end=='') $end=$now;
        $criteria = new CDbCriteria;
        $criteria->join = "JOIN mall_sales_order_info on t.info_id=mall_sales_order_info.id";
        $cr=' (t.ret_state=2 or t.ret_state=0 or t.ret_state="" or t.ret_state is null)';
        $cr.=$club;
        $cr=get_where($cr,!empty($order_type),' mall_sales_order_info.order_type',$order_type,'');
        $cr=get_where($cr,!empty($orter_item),' t.orter_item',$orter_item,'');
        $cr=get_like($cr,'product_code,product_title,supplier_name',$keywords,'');
        $cr=get_where($cr,$start,'t.order_Date>=',$start.' 00:00:00','"');
        $cr=get_where($cr,$end,'t.order_Date<=',$end.' 23:59:59','"');
        $criteria->condition=$cr;
        $criteria->select = "t.order_Date, t.product_code, SUM(t.total_pay) AS sum_total_pay, SUM(t.buy_count) AS sum_buy_count, SUM(t.ret_count) AS sum_ret_count, SUM(t.ret_amount) AS sum_ret_amount, t.order_type_name, t.product_title, t.json_attr, t.supplier_name, t.id";
        $criteria->group = "DATE(t.order_Date), t.product_code";
        $criteria->order = 't.order_Date DESC';
        $data = array();
        $data['orter_item'] = BaseCode::model()->getCode(756);
        $data['order_type'] = BaseCode::model()->getProductType();
        $data['pay_type'] = BaseCode::model()->getCode(482);
        $data['start'] = $start;
        $data['end'] = $end;
        $sql='change_type=0'.$club.' AND order_Date >="'.$now.' 00:00:00"';
        $sqlr='change_type=1137 and (t.ret_state=2 or t.ret_state=0 or t.ret_state="" or t.ret_state is null)'.$club.' AND order_Date >="'.$now.' 00:00:00"';
        $data['t_num']=$model->count($sql);
        $data['r_num']=$model->count($sqlr);
        $orderdata=$model->findAll($sql);
        $r_data=$model->findAll($sqlr);
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
        parent::_list($model, $criteria, 'index_gf_product', $data);
    }
//财务-商品每日销售明细汇总-详情
    public function actionUpdate_gf_product($order_Date,$product_code) {
            // set_cookie('_currentUrl_', Yii::app()->request->url);
            $modelName = $this->model;
            $model = $modelName::model();
            if (!Yii::app()->request->isPostRequest) {
                $data = array();
                $data['model'] = $model;
                // $data['product_code'] = $product_code;
             
                $criteria = new CDbCriteria;
                $criteria->join = "JOIN mall_sales_order_info on t.info_id=mall_sales_order_info.id";
                $cr=' (t.ret_state=2 or t.ret_state=0 or t.ret_state="" or t.ret_state is null)';
            
                // $cr=get_like($cr,'t.order_Date',DATE($order_Date),'');
                $datetime = DateTime::createFromFormat('Y-m-d H:i:s', $order_Date);
                $data['date']='';
                if ($datetime !== false) {
                    $cr=get_where($cr,$order_Date,' DATE(t.order_Date)',"'".$datetime->format('Y-m-d')."'",'');
                    $data['date']=$datetime->format('Y-m-d');
                }
                // $cr=get_where($cr,$order_Date,' DATE(t.order_Date)',$order_Date,'');
                $cr=get_where($cr,$product_code,' t.product_code',"'".$product_code."'",'');
                
                $criteria->condition=$cr;
                
                $criteria->order = 't.order_Date DESC';
               
                $data['orter_item'] = BaseCode::model()->getCode(756);
                $data['order_type'] = BaseCode::model()->getProductType();
                $data['pay_type'] = BaseCode::model()->getCode(482);
                parent::_list($model, $criteria, 'update_gf_product', $data);
            }
        }
    public function ShowViewIndex($keywords='',$start='',$end='',$orter_item='',$order_type='', $is_excel=0,$club='',$viewfile) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        if ($start=='') $start=$now;
        $criteria = new CDbCriteria;
        $criteria->join = "JOIN mall_sales_order_info on t.info_id=mall_sales_order_info.id";
        $cr=' (t.ret_state=2 or t.ret_state=0 or t.ret_state="" or t.ret_state is null)';
        $cr.=$club;
        $cr=get_where($cr,!empty($order_type),' mall_sales_order_info.order_type',$order_type,'');
        $cr=get_where($cr,!empty($orter_item),' t.orter_item',$orter_item,'');
        $cr=get_like($cr,'product_code,product_title,supplier_name,t.order_num',$keywords,'');
        $cr=get_where($cr,$start,'t.order_Date>=',$start.' 00:00:00','"');
        $cr=get_where($cr,$end,'t.order_Date<=',$end.' 23:59:59','"');
        $criteria->condition=$cr;
        $criteria->order = 'order_Date DESC';
        $data = array();
        $data['orter_item'] = BaseCode::model()->getCode(756);
        $data['order_type'] = BaseCode::model()->getProductType();
        $data['pay_type'] = BaseCode::model()->getCode(482);
        $data['start'] = $start;
        $data['end'] = $end;
        $sql='change_type=0'.$club.' AND order_Date >="'.$now.' 00:00:00"';
        $sqlr='change_type=1137 and (t.ret_state=2 or t.ret_state=0 or t.ret_state="" or t.ret_state is null)'.$club.' AND order_Date >="'.$now.' 00:00:00"';
        $data['t_num']=$model->count($sql);
        $data['r_num']=$model->count($sqlr);
        $orderdata=$model->findAll($sql);
        $r_data=$model->findAll($sqlr);
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
        if($is_excel==1){
            $arclist = $model->findAll($riteriac);
            $data = array();
            $title = array();
            foreach ($model->labelsOfList() as $fv) {
                array_push($title, $model->attributeLabels()[$fv]);
            }
            array_push($data, $title);
            foreach ($arclist as $v) {
                $item = array();
                foreach ($model->labelsOfList() as $fv) {
                    $s = '';
                    $s = $v->$fv;
                    $v->product_code="'".$v->product_code;
                    array_push($item, $s);
                }
                array_push($data, $item);
            }
            // 将数据导出为 Excel 文件
            $filename = 'export.xls';
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename=' . $filename);
            header('Pragma: no-cache');
            header('Expires: 0');
            $fp = fopen('php://output', 'w');
            foreach ($data as $row) {
                foreach ($row as &$item) {
                    $item = iconv('UTF-8', 'GB2312//IGNORE', $item);
                }
                fputcsv($fp, $row, "\t");
            }
            fclose($fp);
            exit;
        } else{
            parent::_list($model, $criteria, $viewfile, $data);
        }
        
    }
    public function actionUpdate_print($id) {
        $modelName = $this->model;
        $model = $modelName::model()->find('id='.$id);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_print', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }


//财务-供应商汇总
    public function actionIndex_gysmx($keywords = '',$start='',$end='',$orter_item='',$order_type='',$is_excel=0) {
         $this->ShowViewIndex($keywords,$start,$end,$orter_item,$order_type,$is_excel,'','index_gysmx');
    }
    public function ShowViewIndex_gysxm($keywords='',$start='',$end='',$orter_item='',$order_type='', $is_excel=0,$club='',$viewfile) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        if ($start=='') $start=$now;
        $criteria = new CDbCriteria;
        $criteria->join = "JOIN mall_sales_order_info on t.info_id=mall_sales_order_info.id";
        $cr=' (t.ret_state=2 or t.ret_state=0 or t.ret_state="" or t.ret_state is null)';
        $cr.=$club;
        $cr=get_where($cr,!empty($order_type),' mall_sales_order_info.order_type',$order_type,'');
        $cr=get_where($cr,!empty($orter_item),' t.orter_item',$orter_item,'');
        $cr=get_like($cr,'product_code,product_title,supplier_name,t.order_num',$keywords,'');
        $cr=get_where($cr,$start,'t.order_Date>=',$start.' 00:00:00','"');
        $cr=get_where($cr,$end,'t.order_Date<=',$end.' 23:59:59','"');
        $criteria->condition=$cr;
        $criteria->order = 'order_Date DESC';
        $data = array();
        $data['orter_item'] = BaseCode::model()->getCode(756);
        $data['order_type'] = BaseCode::model()->getProductType();
        $data['pay_type'] = BaseCode::model()->getCode(482);
        $data['start'] = $start;
        $data['end'] = $end;
        $sql='change_type=0'.$club.' AND order_Date >="'.$now.' 00:00:00"';
        $sqlr='change_type=1137 and (t.ret_state=2 or t.ret_state=0 or t.ret_state="" or t.ret_state is null)'.$club.' AND order_Date >="'.$now.' 00:00:00"';
        $data['t_num']=$model->count($sql);
        $data['r_num']=$model->count($sqlr);
        $orderdata=$model->findAll($sql);
        $r_data=$model->findAll($sqlr);
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
        if($is_excel==1){
            $arclist = $model->findAll($criteriac);
            $data = array();
            $title = array();
            foreach ($model->labelsOfList() as $fv) {
                array_push($title, $model->attributeLabels()[$fv]);
            }
            array_push($data, $title);
            foreach ($arclist as $v) {
                $item = array();
                foreach ($model->labelsOfList() as $fv) {
                    $s = '';
                    $s = $v->$fv;
                    $v->product_code="'".$v->product_code;
                    array_push($item, $s);
                }
                array_push($data, $item);
            }
        } else{
            parent::_list($model, $criteria, $viewfile, $data);
        }
        
    }


  
    
    //财务-对账核算
    public function actionIndex_check($keywords = '',$start='',$end='',$orter_item='',$order_type='',$is_excel=0) {
         $this->ShowViewIndex($keywords,$start,$end,$orter_item,$order_type,$is_excel,'','index_check');
    }
    public function ShowViewIndex_check($keywords='',$start='',$end='',$orter_item='',$order_type='', $is_excel=0,$club='',$viewfile,$pay_gfcode='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        if ($start=='') $start=$now;
        $criteria = new CDbCriteria;
        $criteria->join = " JOIN model_sales_order_info on t.info_id = mall_sales_order_info.id"; 
        $cr=' (t.ret_state=2 or t.ret_state=0 or t.ret_state="" or t.ret_state is null)';
        $cr.=$club;
        $cr=get_where($cr,!empty($order_type),' mall_sales_order_info.order_type',$order_type,'');
        $cr=get_where($cr,!empty($orter_item),' t.orter_item',$orter_item,'');
        $cr=get_like($cr,'product_code,product_title,supplier_name,t.order_num',$keywords,'');
        $cr=get_where($cr,$start,'t.order_Date>=',$start.' 00:00:00','"');
        $cr=get_where($cr,$end,'t.order_Date<=',$end.' 23:59:59','"');
        $criteria->condition=$cr;
        $criteria->order = 'order_Date DESC';
        $data = array();
        $data['orter_item'] = BaseCode::model()->getCode(756);
        $data['order_type'] = BaseCode::model()->getProductType();
        $data['pay_type'] = BaseCode::model()->getCode(482);
        $data['pay_gfcode'] = MallSalesOrderInfo::model()->findAll('pay_gfcode="'.$model->pay_gfcode.'"');
        $data['start'] = $start;
        $data['end'] = $end;
        $sql='change_type=0'.$club.' AND order_Date >="'.$now.' 00:00:00"';
        $sqlr='change_type=1137 and (t.ret_state=2 or t.ret_state=0 or t.ret_state="" or t.ret_state is null)'.$club.' AND order_Date >="'.$now.' 00:00:00"';
        $data['t_num']=$model->count($sql);
        $data['r_num']=$model->count($sqlr);
        $orderdata=$model->findAll($sql);
        $r_data=$model->findAll($sqlr);
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
        if($is_excel==1){
            $arclist = $model->findAll($criteriac);
            $data = array();
            $title = array();
            foreach ($model->labelsOfList() as $fv) {
                array_push($title, $model->attributeLabels()[$fv]);
            }
            array_push($data, $title);
            foreach ($arclist as $v) {
                $item = array();
                foreach ($model->labelsOfList() as $fv) {
                    $s = '';
                    $s = $v->$fv;
                    $v->product_code="'".$v->product_code;
                    array_push($item, $s);
                }
                array_push($data, $item);
            }
        } else{
            parent::_list($model, $criteria, $viewfile, $data);
        }
        
    }


    public function actionIndex_deliver($logistics_number = '',$keywords='',$start='',$end='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $club_id=get_session('club_id');
        $now=date('Y-m-d');
        $now_m=date("Y-m-d",strtotime("-2 week",strtotime($now)));
        if ($start=='') $start=$now_m;
        $criteria = new CDbCriteria;
        $criteria->join = "JOIN mall_sales_order_info on t.info_id=mall_sales_order_info.id";
        if($logistics_number!=''){
            $criteria->join.= " JOIN order_info_logistics on t.logistics_id=order_info_logistics.id";
        }
        $cr='supplier_id='.$club_id;
        $cr.=' and t.order_type=361 AND change_type=0 AND sale_show_id in (1129,1132,1133,1134,1135)';
        $cr=get_where($cr,($start!=""),'t.order_Date>=',$start,'"');
        $cr=get_where($cr,($end!=""),'t.order_Date<=',$end,'"');
        $cr=get_like($cr,'t.order_num,t.product_code,t.product_title',$keywords,'');
        $cr=get_like($cr,'order_info_logistics.logistics_number',$logistics_number,'');
        $criteria->condition=$cr;
        //$criteria->group='t.id';
        $criteria->order = 'order_num DESC';
        $data = array();
        $data['start'] = $start;
        $data['end'] = $end;
        parent::_list($model, $criteria, 'index_deliver', $data,25);
    }

    public function actionIndex_start($order_num = '',$code='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
		$today=date('Y-m-d');
        $criteria = new CDbCriteria;
        $criteria->condition='change_type=0 and supplier_id='.get_session('club_id').' AND (order_Date like "'.$today.'%")';  // order_type=361 AND 
        $criteria->condition=get_like($criteria->condition,'order_num',$order_num,'');
		$criteria->condition=get_like($criteria->condition,'product_code,product_title',$code,'');
        $criteria->order = 'id';
        $data = array();
		$data['t_num']=$model->count('change_type=0 and supplier_id='.get_session('club_id').' AND order_Date like "'.$today.'%"');
		$orderdata=$model->findAll('change_type=0 and supplier_id='.get_session('club_id').' AND order_Date like "'.$today.'%"');
		$p=0;
		$r=0;
		foreach($orderdata as $v){
			$p=$p+$v->buy_amount;
			$r=$r+$v->ret_amount;	
		}
		$data['money']=$p;
		$data['r_money']=$r;
        parent::_list($model, $criteria, 'index_start', $data);
    }

    /**
     * 是否已购买该产品(必须是购买且订单已完成)
     */
    public function isGetProduct($gfid,$service_id=null,$service_data_id=null,$order_type,$gf_user_type=210){
    	
    	$where="order_type={$order_type} and orter_item=757 and gfid=".$gfid." and buyer_type=".$gf_user_type;
    	if(!empty($service_id)){
    		$where.=" and service_id=".$service_id;
    	}
    	if(!empty($service_data_id)){
    		$where.=" and service_data_id=".$service_data_id;
    	}
		$list=$model->findAll($where);
    	return count($list);
    }
}
