<?php

class ReturnGoodsController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
   

    /**
     * 售后申请处理
     */
    public function actionIndex_after_sale($change_type='',$good_sent='',$order_num='',$order_account='',$ret_state='',$after_sale_state='',$time_start='',$time_end='',$exam=0,$is_excel=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        if($exam==1){
            $after_sale_state = 1150;
        }
        //$fid = '1150,1151,1152,1153,1154,1287,1288,1155,1156';
        $fid = '1151,1153';
        $whe = " order by FIND_IN_SET(`f_id`,'".$fid."')";

        $criteria->join = "JOIN mall_sales_order_data on t.order_data_id = mall_sales_order_data.id";

        if($exam==1){
            $criteria->condition = 'if_del=648 and after_sale_state = 1150';
        }elseif(!empty($time_start)){
            $criteria->condition = 'if_del = 648 and after_sale_state != 1150 and mall_sales_order_data.ret_state =2';
        }else{

            $criteria->condition = 'if_del = 648 and after_sale_state != 1150 and mall_sales_order_data.ret_state =2  and left(t.order_date,10)="'.date('Y-m-d').'"';
        }//"'.date('Y-m-d').'"

            $criteria->condition .= ' AND exists(select * from mall_sales_order_data where id=t.order_data_id and '.get_where_club_project('supplier_id','').')';
        
        $criteria->condition=get_where($criteria->condition,!empty($change_type),'t.change_type',$change_type,'');
        $criteria->condition=get_where($criteria->condition,!empty($after_sale_state),'t.after_sale_state',$after_sale_state,'');
        $criteria->condition=get_where($criteria->condition,!empty($time_start),'left(t.order_date,10)>=',$time_start,'"');
        $criteria->condition=get_where($criteria->condition,!empty($time_end),'left(t.order_date,10)<=',$time_end,'"');
        $criteria->condition=get_like($criteria->condition,'t.order_num,ret_logistics,return_order_num,mall_sales_order_data.product_title',$order_num,'');
        //$criteria->order = 'find_in_set(`after_sale_state`,"'.$fid.'"),order_date DESC';
        $criteria->order = 'order_date DESC';
        $data = array();
        $data['count1'] = $model->count('if_del=648 and after_sale_state=1150 AND exists(select * from mall_sales_order_data where id=t.order_data_id and '.get_where_club_project('supplier_id','').')');
        $data['ret_state'] = BaseCode::model()->getReturn('2,373');
        $data['after_sale_state'] = BaseCode::model()->getReturn($fid,$whe);
        if(!isset($is_excel) || $is_excel != '1'){
            parent::_list($model, $criteria, 'index_after_sale', $data);
        }
        else{
            $this->exc($model,$criteria);
        }
    }

    /**
     * 审核未通过列表
     */
    public function actionIndex_examine_nopass($order_num='',$order_account='',$ret_state='',$after_sale_state='',$time_start='',$time_end='',$exam=0,$is_excel=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        if($exam==1){
            $after_sale_state = 1150;
        }
        $fid = '1151,1153';
        $whe = " order by FIND_IN_SET(`f_id`,'".$fid."')";

        //$criteria->join = "JOIN mall_sales_order_data on t.return_order_num = mall_sales_order_data.order_num";
        $criteria->join = "JOIN mall_sales_order_data on t.order_data_id = mall_sales_order_data.id";

        if(!empty($time_start)){
            $criteria->condition = 'if_del=648 and mall_sales_order_data.ret_state = 373';
        }else{
            $criteria->condition = 'if_del=648 and mall_sales_order_data.ret_state = 373 and left(t.order_date,10)="'.date('Y-m-d').'"';
        }
        $criteria->condition .= ' AND exists(select * from mall_sales_order_data where id=t.order_data_id and '.get_where_club_project('supplier_id','').')';  //  and (ret_state='.$ret_state.' or ret_state is not null)
        if($order_account!=''){
            $criteria->condition .= ' AND exists(select * from mall_sales_order_info where order_num=t.order_num and order_gfaccount="'.$order_account.'")';
        }
        $criteria->condition=get_where($criteria->condition,!empty($after_sale_state),'after_sale_state',$after_sale_state,'');
        $criteria->condition=get_where($criteria->condition,!empty($time_start),'left(t.uDate,10)>=',$time_start,'"');
        $criteria->condition=get_where($criteria->condition,!empty($time_end),'left(t.uDate,10)<=',$time_end,'"');
        $criteria->condition=get_like($criteria->condition,'t.order_num,ret_logistics,return_order_num,mall_sales_order_data.product_title',$order_num,'');
        //$criteria->order = 'find_in_set(`after_sale_state`,"'.$fid.'"),order_date DESC';
        $criteria->order = 'order_date DESC';
        $data = array();
        $data['count1'] = $model->count('if_del=648 and after_sale_state=1150 AND exists(select * from mall_sales_order_data where id=t.order_data_id and '.get_where_club_project('supplier_id','').')');
        $data['ret_state'] = BaseCode::model()->getReturn('2,373');
        $data['after_sale_state'] = BaseCode::model()->getReturn($fid,$whe);
        if(!isset($is_excel) || $is_excel != '1'){
            parent::_list($model, $criteria, 'index_examine_nopass', $data);
        }
        else{
            $this->exc($model,$criteria);
        }
    }


    // 退/换货收货处理
	public function actionIndex($keywords='',$change_type='',$start='',$end='',$is_excel=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        if ($start=='') $start=$now;
        $criteria = new CDbCriteria;
        $cr='if_del=648';
        $cr.=' and supplier_id='.get_session('club_id');
        $cr_count=$cr;
        $cr.=' and take_date<>""';
		$cr=get_where($cr,$change_type,'change_type',$change_type,'');
        $cr=get_where($cr,($start!=""),'take_date>=',$start.' 00:00:00','"');
        $cr=get_where($cr,($end!=""),'take_date<=',$end.' 23:59:59','"');
		$cr=get_like($cr,'order_num,ret_logistics,return_order_num',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = ' take_date DESC';
        $cr_for=$cr_count.' and after_sale_state=1151 and (ret_logistics is null or ret_logistics="")';
        $cr_count.=' and after_sale_state=1152 and (consignee_id is null or consignee_id="") and ret_logistics<>""';
        $data = array();
        $data['receiv_num'] = $model->count($cr_count);
        $data['for_num'] = $model->count($cr_for);
        $data['change_type'] = BaseCode::model()->getCode(1136);
        $data['start'] = $start;
        $data['end'] = $end;
        if(!isset($is_excel) || $is_excel != '1'){
            parent::_list($model, $criteria, 'index', $data);
        }
        else{
            $this->exc($model,$criteria);
        }
    }
    // 退/换货收货处理-待退货
    public function actionIndex_forreturn($keywords='',$change_type='',$start='',$end='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr='if_del=648';
        $cr.=' and supplier_id='.get_session('club_id');
        $cr.=' and after_sale_state=1151 and (ret_logistics is null or ret_logistics="")';
        $cr=get_where($cr,$change_type,'change_type',$change_type,'');
        $cr=get_where($cr,($start!=""),'uDate>=',$start.' 00:00:00','"');
        $cr=get_where($cr,($end!=""),'uDate<=',$end.' 23:59:59','"');
        $cr=get_like($cr,'order_num',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = ' uDate ASC';
        $data = array();
        $data['change_type'] = BaseCode::model()->getCode(1136);
        $data['start'] = $start;
        $data['end'] = $end;
        parent::_list($model, $criteria, 'index_forreturn', $data);
    }

//换货发货处理-待换货
    public function actionIndex_change($keywords = '',$start='',$end='') {
         $this->ShowViewChange($keywords,$start,$end,' and after_sale_state=1288',0,'index_change');
    }
//换货发货处理-待换货
    public function actionIndex_forchange($keywords = '') {
         $this->ShowViewChange($keywords,'','',' and after_sale_state=1287',1,'index_forchange');
    }
    public function ShowViewChange($keywords='',$start='',$end='',$state,$for=0,$viewfile) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d');
        if ($start=='' && $for==0) $start=$now;
        $criteria->join = "JOIN mall_sales_order_data on t.order_data_id=mall_sales_order_data.id";
        $cr='t.supplier_id='.get_session('club_id');
        $cr.=' and if_del=648';
        $cr.=$state;
        $cr=get_where($cr,($start!=""),'change_date>=',$start.' 00:00:00','"');
        $cr=get_where($cr,($end!=""),'change_date<=',$end.' 23:59:59','"');
        $cr=get_like($cr,'t.order_num,t.change_no',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order =($for==0) ? 'change_date DESC' : 'take_date DESC';
        $data = array();
        $data['num'] = $model->count('if_del=648 and after_sale_state=1287 and supplier_id='.get_session('club_id'));
        $data['start'] = $start;
        $data['end'] = $end;
        parent::_list($model, $criteria, $viewfile, $data);
    }

    // 退/换货查询
    public function actionIndex_search($keywords='',$change_type='',$state='',$start='',$end='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d');
        if ($start=='') $start=$now;
        $criteria->join = "JOIN mall_sales_order_data on t.order_data_id=mall_sales_order_data.id";
        $cr='if_del=648';
        //$cr.=' and supplier_id='.get_session('club_id');
        $cr=get_where($cr,$change_type,'t.change_type',$change_type,'');
        $cr=get_where($cr,$state,'mall_sales_order_data.ret_state',$state,'');
        $cr=get_where($cr,($start!=""),'t.order_date>=',$start.' 00:00:00','"');
        $cr=get_where($cr,($end!=""),'t.order_date<=',$end.' 23:59:59','"');
        $cr=get_like($cr,'t.order_num,mall_sales_order_data.product_title,mall_sales_order_data.supplier_name',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = ' order_date DESC';
        $data = array();
        $data['change_type'] = BaseCode::model()->getCode(1136);
        $data['state'] = BaseCode::model()->findAll('f_id in (371,2,373,374)');
        $data['start'] = $start;
        $data['end'] = $end;
        parent::_list($model, $criteria, 'index_search', $data);
    }

    /**
     * 退/换货申请审核处理
     */
    public function actionIndex_exam($order_num='',$order_account='',$ret_state='',$after_sale_state='',$time_start='',$time_end='',$exam=0,$is_excel=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        if($exam==1){
            $after_sale_state = 1150;
        }
        $fid = '1150,1151,1152,1153,1154,1287,1288,1155,1156';
        $whe = " order by FIND_IN_SET(`f_id`,'".$fid."')";
        $criteria->condition = 'if_del=648';  //  and after_sale_state='.$after_sale_state.' order by find_in_set(`after_sale_state`,"1153")
        $criteria->condition .= ' AND exists(select * from mall_sales_order_data where id=t.order_data_id and '.get_where_club_project('supplier_id','').')';  //  and (ret_state='.$ret_state.' or ret_state is not null)
        if($order_account!=''){
            $criteria->condition .= ' AND exists(select * from mall_sales_order_info where order_num=t.order_num and order_gfaccount="'.$order_account.'")';
        }
		$criteria->condition=get_where($criteria->condition,!empty($after_sale_state),'after_sale_state',$after_sale_state,'');
		$criteria->condition=get_where($criteria->condition,!empty($time_start),'left(order_date,10)>=',$time_start,'"');
		$criteria->condition=get_where($criteria->condition,!empty($time_end),'left(order_date,10)<=',$time_end,'"');
		$criteria->condition=get_like($criteria->condition,'order_num,ret_logistics,return_order_num',$order_num,'');
        $criteria->order = 'find_in_set(`after_sale_state`,"'.$fid.'"),order_date';
        $data = array();
        $data['count1'] = $model->count('if_del=648 and after_sale_state=1150 AND exists(select * from mall_sales_order_data where id=t.order_data_id and '.get_where_club_project('supplier_id','').')');
        $data['ret_state'] = BaseCode::model()->getReturn('2,373');
        $data['after_sale_state'] = BaseCode::model()->getReturn($fid,$whe);
        if(!isset($is_excel) || $is_excel != '1'){
            parent::_list($model, $criteria, 'index_exam', $data);
        }
        else{
            $this->exc($model,$criteria);
        }
    }

    /**
     * 收货管理
     */
    public function actionIndex_receiv($order_num='',$after_sale_state='',$order_account='',$time_start='',$time_end='',$is_excel=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition='if_del=648';  //  and after_sale_state not in(1150,1151,1152)
        $criteria->condition .= ' AND exists(select * from mall_sales_order_data where id=t.order_data_id and '.get_where_club_project('supplier_id','').')';
        if($order_account!=''){
            $criteria->condition .= ' AND exists(select * from mall_sales_order_info where order_num=t.order_num and order_gfaccount="'.$order_account.'")';
        }
		$criteria->condition=get_where($criteria->condition,!empty($after_sale_state),'after_sale_state',$after_sale_state,'');
		$criteria->condition=get_like($criteria->condition,'order_num,ret_logistics,return_order_num',$order_num,'');
        $criteria->order = 'find_in_set(`after_sale_state`,"1153")';
		$data = array();
		$data['after_sale_state'] = BaseCode::model()->getReturn('1150,1151,1153,1154,1155,1156');
		$data['order_type'] = BaseCode::model()->getOrderType();
        if(!isset($is_excel) || $is_excel != '1'){
            parent::_list($model, $criteria, 'index_receiv', $data);
        }
        else{
            $this->exc($model,$criteria);
        }
    }
 
    //交易退款
    public function actionIndex_refunds_day($keywords='',$start='',$end='',$order_type=0,$for=0,$is_excel=0) {
         $this->ShowViewRefunds($keywords,$start,$end,$order_type,' and after_sale_state in (1154,1155) and state=466',$for,$is_excel,'index_refunds_day');
    }
    //交易退款-待退款
    public function actionIndex_refunds($keywords='',$start='',$end='',$order_type=0,$for=1,$is_excel=0) {
         $this->ShowViewRefunds($keywords,$start,$end,$order_type,' and after_sale_state=1153 and state<>466',$for,$is_excel,'index_refunds');
    }

    public function ShowViewRefunds($keywords='',$start='',$end='',$order_type=0,$state,$for=0,$is_excel=0,$viewfile) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->join = "JOIN mall_sales_order_data on t.order_data_id=mall_sales_order_data.id";
        //$criteria->join.= " JOIN mall_sales_order_info on t.order_info_id=mall_sales_order_info.id";
        $now=date('Y-m-d');
        if ($start=='' && $for==0) $start=$now;
        $if_test=($for==0) ? 't.ret_date' : 't.order_date';
        $cr='t.if_del=648 and t.change_type=1137';
        $cr.=$state;
        $cr=get_where($cr,$order_type,' t.order_type',$order_type,'');
        $cr=get_where($cr,($start!=""),$if_test.'>=',$start.' 00:00:00','"');
        $cr=get_where($cr,($end!=""),$if_test.'<=',$end.' 23:59:59','"');
        $cr=get_like($cr,'t.order_num,t.gf_name,t.return_order_num,mall_sales_order_data.supplier_name',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order =($for==0) ? 't.ret_date DESC' : 't.order_date ASC';
        $data = array();
        $cu = new CDbCriteria;
        $cu->join = "JOIN mall_sales_order_data on t.order_data_id=mall_sales_order_data.id";
        $cu->condition='t.if_del=648 and t.after_sale_state=1153 and t.change_type=1137';
        $data['for_num'] = $model->count($cu);
        $data['start'] =$start;
        $data['end'] =$end;
        $data['order_type'] = BaseCode::model()->getProductType();
        if(!isset($is_excel) || $is_excel != '1'){
            parent::_list($model, $criteria, $viewfile, $data);
        }else{
            $this->exc($model,$criteria);
        }
    }

    public function get_refunds_str($order_num='',$after_sale_state='',$order_account='',$time_start='',$time_end='',$refunds=0,$out=0) {
        $cr="if_del=648 and after_sale_state=1153 and ret_no='' and change_type=1137";
        $order_type = 361;
        if($out==1){ $order_type = 353;}
        $cr .= ' AND exists(select * from mall_sales_order_data where id=t.order_data_id and order_type='.$order_type.')';
        if($order_account!=''){
            $cr .= ' AND exists(select * from mall_sales_order_info where order_num=t.return_order_num and order_gfaccount="'.$order_account.'")';
        }
        $cr=get_where($cr,$after_sale_state,'after_sale_state',$after_sale_state,'');
        $cr=get_where($cr,$time_start,'left(order_date,10)>=',$time_start,'"');
        $cr=get_where($cr,$time_end,'left(order_date,10)<=',$time_end,'"');
        $cr=get_like($cr,'order_num,ret_logistics,return_order_num',$order_num,'');
        return $cr;
    }
   
    


    // * 动动约退款*/
    public function actionIndex_refunds_about($order_num='',$after_sale_state='',$order_account='',$time_start='',$time_end='',$refunds='',$is_excel=0) {
        $this->actionIndex_refunds($order_num,$after_sale_state,$order_account,$time_start,$time_end,$refunds,$is_excel,1);
    }

    /**
     * 未发货退货确认
     */
    public function actionIndex_unshipped($keywords='',$time_start='',$time_end='',$order_account='',$is_excel=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr="consignee_id=0 and good_sent=472 and order_type=361 and ".get_where_club_project('supplier_id','');
        // if($order_account!=''){
        //     $cr .= ' AND exists(select * from mall_sales_order_info where order_num=t.order_num and order_gfaccount="'.$order_account.'")';
        // }
		$cr=get_where($cr,$time_start,'left(order_date,10)>=',$time_start,'"');
		$cr=get_where($cr,$time_end,'left(order_date,10)<=',$time_end,'"');
		$criteria->condition=get_like($cr,'order_num',$keywords,'');
        $criteria->order = 'order_date';
        $data = array();
		$data['after_sale_state'] = BaseCode::model()->getReturn('1153,1154,1155,1156');
		$data['order_type'] = BaseCode::model()->getOrderType();
        if(!isset($is_excel) || $is_excel != '1'){
            parent::_list($model, $criteria, 'index_unshipped', $data);
        }
        else{
            $this->exc($model,$criteria);
        }
    }


    /**
     * 打印
     */
    function exc($model,$criteria){
        $arclist = $model->findAll($criteria);
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
                if ($fv == 'return_goods') {
                    $s = $v->order_record->order_num;
                } else {
                    $s = $v->$fv;
                }
                array_push($item, $s);
            }
            array_push($data, $item);
        }
        parent::_excel($data,'退换货列表.xls');
    }

    /**
     * 退/换货收货
     */
    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $this->render('update_exam', $this->get_data($model));
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    /**
     * 收货列表
     */
    public function actionUpdate_receiv($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
             $this->render('Update_receiv', $this->get_data($model));
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }
	
	public function actionUpdate_deliver($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $this->render('update_exam', $this->get_data($model));
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }
//发货列表
    public function actionUpdate_change($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $this->render('update_change', $this->get_data($model));
        } else {
            $model->attributes =$_POST[$modelName];
            $model->after_sale_state=1288;
            $model->after_sale_state_desc='已发货';
            $model->change_date=date('Y-m-d h:i:s');
            $st=$model->save();
            $this->save_order_recode($model,$_POST[$modelName],$model->after_sale_state_desc);
            show_status($st,'已发货',Yii::app()->request->urlReferrer,'发货失败');
        }
   
    }
 
    /**
     * 退/换货申请审核
     */
	public function actionUpdate_exam($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $this->render('update_exam', $this->get_data($model));
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }
    
       /**
     * 退/换货申请审核
     */
    public function get_data($model) {
        $data = array();
        $w1="order_num='".$model->order_num."'";
        $data['model'] = $model;
        $data['order_data'] = MallSalesOrderData::model()->findAll($w1);
        $data['order_record'] = OrderRecord::model()->findAll($w1);
        if($model->img != '') {
            $data['img'] = explode(',', $model->img);
        }
        return $data;
     }
    /**
     * 退款详情
     */
	public function actionUpdate_refunds($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $this->render('update_refunds', $this->get_data($model));
        } else {
            $model->attributes = $_POST[$modelName];
            if($model->state==466){
                $model->after_sale_state =1154; 
            }
            
            $model->ren_nameid = get_session('admin_id');
            $model->ren_d = get_session('gfaccount');
            $model->ren_name = get_session('admin_name');
            $model->ret_date = date('Y-m-d H:i:s');
            $sv=$model->save();
            show_status($sv,'操作成功', get_cookie('_currentUrl_'),'操作失败'); 
        }
    }

    function saveData($model,$post) {

	    if(empty($post['ret_state'])){
            ajax_status(0, '请做审核操作');

        }

        if($post['ret_state']==373){


        } elseif(empty($post['return_club_name']) && $post['after_sale_type'] !=0){
            ajax_status(0, '请填写收货人，或者直接选择地址');


        }elseif(empty($post['return_club_tel']) && $post['after_sale_type'] !=0){
            ajax_status(0, '请填写联系电话，或者直接选择地址');

        }elseif(empty($post['return_club_address']) && $post['after_sale_type'] !=0){
            ajax_status(0, '请填写退货地址，或者直接选择地址');

        } elseif(empty($post['return_club_mail_code']) && $post['after_sale_type'] !=0){
            ajax_status(0, '请填写邮政编码，或者直接选择地址');

        }


        $model->attributes = $post;
        $model->act_ret_money = $_POST['refund_money'];//确认退款金额

        $this->save_goods_num($model,$post);
        $this->save_order_recode($model,$post,$model->desc);
        if($model->after_sale_state==1154){
            $model->ren_nameid = get_session('admin_id');
            $model->ren_name = get_session('admin_name');
            $model->ret_date = date('Y-m-d H:i:s');
        }
        $st=$model->save();
        $url = get_cookie('_currentUrl_');
        if($_POST['submitType']=='baocun'){
            $url = Yii::app()->request->urlReferrer;
        }
        show_status($st,'操作成功', $url,'操作失败');
    }

    /**
     * 保存操作记录
     */
    public function save_order_recode($model,$post,$msg){
        $orderrecode = new OrderRecord();
        $orderrecode->isNewRecord = true;
        unset($orderrecode->id);
        $orderrecode->order_id = $model->id;
        $orderrecode->order_num = $model->order_num;
        $orderrecode->is_pay = 464;
        $orderrecode->order_state = 465;
        $orderrecode->order_state_des_content = $msg;
        $orderrecode->operator_gfid = Yii::app()->session['gfid'];
        $orderrecode->operator_gfname = Yii::app()->session['admin_name'];
        $orderrecode->user_member = 502;
        $orderrecode->logistics_state = $model->after_sale_state;
        $orderrecode->save();
    }

    public function save_goods_num($model,$post){

        $model->attributes = $post;

        //$model->ret_state=get_check_code($_POST['submitType']);
        //$order_data=MallSalesOrderData::model()->find('order_num="'.$model->return_order_num.'"');
        $order_data=MallSalesOrderData::model()->find('id="'.$model->order_data_id.'"');
        if(!empty($order_data)){

                $order_data->ret_state=$post['ret_state'];
                if($model->change_type==1137){
                    $order_data->ret_amount=$model->ret_money;
                }
                $model->supplier_id = $order_data->supplier_id;
                $model->order_type = $order_data->order_type;

                $model->good_sent = ($order_data->logistics_id>0) ? 473 : 472;
                //$model->state = 465;

                if($post['ret_state']==373){
                    $model->after_sale_state = 1336;
                }else{
                    $model->after_sale_state = $post['after_sale_state'];
                }


                $model->desc = $post['desc'];
                $model->return_club_name = @$post['return_club_name'];
                $model->return_club_tel = @$post['return_club_tel'];
                $model->return_club_address = @$post['return_club_address'];
                $model->return_club_mail_code = @$post['return_club_mail_code'];

                $model->uDate = date('Y-m-d H:i:s');

                $order_data->save();
                $model->save();
        } else{
            ajax_status(0, '没有获取到商品信息');
        }
    }

    // 修改删除状态
    public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $len = explode(',',$id);
        $count = 0;
        foreach($len as $d){
            $model->updateByPk($d,array('if_del'=>649));
            $count++;
        }
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }
//退换货收货处理-已退回
    public function actionReceiv_list($keywords=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = ReturnGoods::model();
        $criteria = new CDbCriteria;
        $cr='supplier_id='.get_session('club_id');
        $cr.=' and if_del=648 and after_sale_state=1152 and (consignee_id is null or consignee_id="") and ret_logistics<>""';
        $criteria->condition=get_like($cr,'order_num,return_order_num,ret_logistics',$keywords,'');
        //$criteria->order ='code';
        $data = array();
        parent::_list($model, $criteria, 'receiv_list', $data);
    }
//收货处理
    public function actionReceiv_data($keywords=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = ReturnGoods::model();
        $criteria = new CDbCriteria;
        $cr='supplier_id='.get_session('club_id');
        $cr.=' and if_del=648 and after_sale_state=1152';
        $cr.=' and (consignee_id is null or consignee_id="") and ret_logistics<>""';
        if($keywords!='') {
            $cr.=' and (order_num="'.$keywords.'" or return_order_num="'.$keywords.'" or ret_logistics="'.$keywords.'")';
        } else{
            $cr.=' and id=-1';
        }
        //$cr=get_like($cr,'order_num,return_order_num,ret_logistics',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order ='id DESC';
        $data = array();
        $data['after'] = BaseCode::model()->findAll('f_id in (1287,1153,1333)');
        parent::_list($model, $criteria, 'receiv_data', $data);
    }

    /**
     * 收货处理
     */
    public function actionQuery($query_num){
        $s = 'if_del=648 and (order_num="'.$query_num.'" or return_order_num="'.$query_num.'" or ret_logistics="'.$query_num.'") and (consignee_id is null or consignee_id="")';
        $model = ReturnGoods::model()->findAll($s);
        $arr = array();
        if(!empty($model))foreach($model as $m){
            $order_info = MallSalesOrderInfo::model()->find('id='.$m->order_info_id);
            $order_data = MallSalesOrderData::model()->find('id='.$m->order_data_id);
            array_push($arr,[$m,$order_info,$order_data]);
        }
        echo CJSON::encode($arr);
    }

    /**
     * 收货处理
     */
    public function actionQuery_ref($query_num){
        $s = 'if_del=648 and (order_num="'.$query_num.'" or return_order_num="'.$query_num.'") and (consignee_id is not null or consignee_id<>"") and (ret_date is null or ret_date="")';
        $model = ReturnGoods::model()->findAll($s);
        $arr = array();
        if(!empty($model))foreach($model as $m){
            $order_info = MallSalesOrderInfo::model()->find('id='.$m->order_info_id);
            $order_data = MallSalesOrderData::model()->find('id='.$m->order_data_id);
            array_push($arr,[$m,$order_info,$order_data]);
        }
        echo CJSON::encode($arr);
    }

    /**
     * 保存收货状态
     */
    public function actionAddForm(){
        $modelName = $this->model;
        $model = $modelName::model();
        $arr=$_POST['arr'];
        $count=0;
        if (isset($arr)) foreach ($arr as $v) {
            if ($v['id'] =='' || $v['after']=='') {
               continue;
             } else {
             $admin_id=get_session('admin_id');
             $admin_name=get_session('admin_name');
             $now=date('Y-m-d H:i:s');
             $msg=($v['after']==1333) ? '退货不合格' : '合格';
             $model->updateAll(
                array('after_sale_state' => $v['after'],
                    'consignee_id' => $admin_id,
                    'consignee_name' => $admin_name,
                    'take_date' => $now,
                    'consignee_msg' => $msg
                ),'id='.$v['id']);  
             $count++;
             } 
        }
        show_status($count,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }

    // 取消收货
    public function actionUnshow($id){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $model->take_name = '';
        $model->take_date = '';
        $model->consignee_id = '';
        $model->consignee_name = '';
        $model->after_sale_state = 1152;
        $sv = $model->save();
        show_status($sv,'取消成功',Yii::app()->request->urlReferrer,'取消失败');
    }
    // 退换关闭
    public function actionClose($id){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $sv=$model->updateAll(
            array('after_sale_state' =>1156),'id='.$id);
        show_status($sv,'已关闭',Yii::app()->request->urlReferrer,'退换关闭失败');
    }

    // 动动约服务退订审核
    public function actionIndex_service_pass($keywords='',$star='',$end='',$t_typeid='',$project_id='') {
         $this->ShowService($keywords,$star,$end,$t_typeid,$project_id,' and mall_sales_order_data.ret_state in (2,373)',0,'index_service_pass');
    }
    // 动动约服务退订审核-待审核
    public function actionIndex_service_check($keywords='',$star='',$end='',$t_typeid='',$project_id='') {
         $this->ShowService($keywords,$star,$end,$t_typeid,$project_id,' and mall_sales_order_data.ret_state=371',1,'index_service_check');
    }
    public function ShowService($keywords='',$star='',$end='',$t_typeid='',$project_id='',$state,$for=0,$viewfile) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $now=date('Y-m-d');
        if ($star=='' && $for==0) $star=$now;
        $criteria = new CDbCriteria;
        $join ="JOIN mall_sales_order_data on t.order_data_id=mall_sales_order_data.id";
        $join.=" JOIN gf_service_data on mall_sales_order_data.gf_service_id=gf_service_data.id";
        $criteria->join=$join;
        $cr=get_where_club_project('t.supplier_id','');
        $cr.=' and t.order_type=353';
        $cr.=$state;
        if($t_typeid!='') $cr.=' and gf_service_id.t_stypeid='.$t_typeid;
        if($project_id!='') $cr.=' and mall_sales_order_data.project_id='.$project_id;
        if($for==1){
            $cr=get_where($cr,$star,'t.order_date>=',$star.' 00:00:00',"'");
            $cr=get_where($cr,$end,'t.order_date<=',$end.' 23:59:59',"'"); 
        } else{
            $cr=get_where($cr,$star,'t.uDate>=',$star.' 00:00:00',"'");
            $cr=get_where($cr,$end,'t.uDate<=',$end.' 23:59:59',"'"); 
        }
        $cr=get_like($cr,'gf_service_data.gf_account,t.gf_name',$keywords,'');
        $criteria->condition=$cr;
        $criteria->group = 't.id';
        $data = array();
        $data['star'] = $star;
        $data['end'] = $end; 
        $data['t_typeid'] = QmddServerUsertype::model()->findAll('if_del=510');
        $data['project_id'] = ProjectList::model()->getProject();
        $data['count1'] = $model->count('order_type=353 and exists(select * from mall_sales_order_data md where md.id=t.order_data_id and md.ret_state=371)');
        parent::_list($model, $criteria, $viewfile, $data);
    }
// 动动约服务退订审核-详情
    public function actionUpdate_service_check($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $this->render('update_service_check', $this->get_data($model));
        } else {
            $model->attributes = $_POST[$modelName];
            $state=get_check_code($_POST['submitType']);
            if($state==2){
                $model->after_sale_state =1153;
                if(!empty($model->orderdata->service_data_id)){
                    QmddServerSetData::model()->updateByPk($model->orderdata->service_data_id,
                        array('order_project_id'=>0,
                            'order_project_name'=>'',
                            'order_gfid'=>0,
                            'order_account'=>'',
                            'order_name'=>'',
                            'order_date'=>'',
                            'order_num'=>''));
                }
           } else if($state==373){
                $model->after_sale_state =1156; 
           }
            
            $model->state_user_id = get_session('admin_id');
            $model->state_user_gfaccount = get_session('gfaccount');
            $model->state_user_name = get_session('admin_name');
            $model->uDate = date('Y-m-d H:i:s');
            $sv=$model->save();
            if(!empty($model->orderdata)) MallSalesOrderData::model()->updateAll(array('ret_state'=>$state),'id='.$model->orderdata->id);//,'ret_amount'=>$model->ret_money
            $this->save_order_recode($model,$_POST[$modelName],$model->desc);
            show_status($sv,'操作成功', get_cookie('_currentUrl_'),'操作失败'); 
        }
    }
    //退款订单列表
    public function actionIndex_refund_list($start='',$end='',$pay_id='',$order_num='',$gf_name='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $today=date('Y-m-d');
        $criteria = new CDbCriteria;
        $criteria->condition='if_del=648';
        $criteria->condition=get_where($criteria->condition,!empty($pay_id),'pay_id',$pay_id,'');
        $criteria->condition=get_like($criteria->condition,'order_num',$order_num,'');
        $criteria->condition=get_where($criteria->condition,($start!=""),'ret_date>=',$start,'"');
        $criteria->condition=get_where($criteria->condition,($end!=""),'ret_date<=',$end,'"');
        if(empty($order_num) && empty($start) && empty($end) && empty($gf_name)){
            $criteria->condition.=' AND (ret_date like "'.$today.'%")';
        }
        $criteria->order = 'ret_date ASC';
        $data = array();
        $data['pay_type'] = BaseCode::model()->getPayway();
        parent::_list($model, $criteria, 'index_refund_list', $data);
        } 

    //动动约退款
    public function actionIndex_service_refund($keywords='',$start='',$end='',$for=0,$is_excel=0) {
         $this->ShowServiceRefund($keywords,$start,$end,' and after_sale_state in (1154,1155) and state=466',$for,$is_excel,'index_service_refund');
    }
    //动动约退款-待退款
    public function actionIndex_service_refundfor($keywords='',$start='',$end='',$for=1,$is_excel=0) {
         $this->ShowServiceRefund($keywords,$start,$end,' and after_sale_state=1153 and state<>466',$for,$is_excel,'index_service_refundfor');
    }

    public function ShowServiceRefund($keywords='',$star='',$end='',$state,$for=0,$is_excel=0,$viewfile) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->join = "JOIN mall_sales_order_data on t.order_data_id=mall_sales_order_data.id";
        $criteria->join.= " JOIN mall_sales_order_info on t.order_info_id=mall_sales_order_info.id";
        $now=date('Y-m-d');
        if ($star=='' && $for==0) $star=$now;
        $if_test=($for==0) ? 't.ret_date' : 't.order_date';
        $cr='t.if_del=648 and t.change_type=1137 and t.order_type=353';
        $cr.=' and mall_sales_order_data.ret_state=2';
        $cr.=$state;
        $cr=get_where($cr,($star!=""),$if_test.'>=',$star.' 00:00:00','"');
        $cr=get_where($cr,($end!=""),$if_test.'<=',$end.' 23:59:59','"');
        $cr=get_like($cr,'t.gf_name,mall_sales_order_info.dreturn_order_num',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order =($for==0) ? 't.ret_date DESC' : 't.order_date ASC';
        $data = array();
        $cu = new CDbCriteria;
        $cu->join = "JOIN mall_sales_order_data on t.order_data_id=mall_sales_order_data.id";
        $cu->condition='t.if_del=648 and t.order_type=353 and t.after_sale_state=1153 and t.change_type=1137 and mall_sales_order_data.ret_state=2';
        $data['for_num'] = $model->count('t.if_del=648 and t.order_type=353 and t.after_sale_state=1153 and t.change_type=1137 and exists(select * from mall_sales_order_data md where md.id=t.order_data_id and md.ret_state=2)');
        $data['star'] =$star;
        $data['end'] =$end;
        if(!isset($is_excel) || $is_excel != '1'){
            parent::_list($model, $criteria, $viewfile, $data);
        }else{
            $this->exc($model,$criteria);
        }
    }
// 动动约退款-详情
    public function actionUpdate_service_refund($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $this->render('update_service_refund', $this->get_data($model));
        } else {
            $model->attributes = $_POST[$modelName];
            $state=get_check_code($_POST['submitType']);
            $model->after_sale_state =1154; 
            $model->state=466;
            $model->ren_nameid = get_session('admin_id');
            $model->ren_gfaccount = get_session('gfaccount');
            $model->ren_name = get_session('admin_name');
            $model->ret_date = date('Y-m-d H:i:s');
            $sv=$model->save();
            $this->save_order_recode($model,$_POST[$modelName],$model->ret_desc);
            show_status($sv,'操作成功', get_cookie('_currentUrl_'),'操作失败'); 
        }
    }
}

    