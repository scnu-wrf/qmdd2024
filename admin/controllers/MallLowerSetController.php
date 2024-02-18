<?php

class MallLowerSetController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    //商家-商品下架申请
    public function actionIndex($keywords = '',$supplier='') {
         $this->ShowView($keywords,$supplier,' AND supplier_id='.get_session('club_id'),'index');
    }
    //GF商城-商品下架
    public function actionIndex_gf($keywords = '',$supplier='') {
         $this->ShowView($keywords,$supplier,'','index_gf');
    }
    public function ShowView($keywords = '',$supplier='',$club='',$viewfile) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr='if_del=648 AND down_up=-1';
        $cr.=' and f_check in (721,371,373)';
        $cr.=$club;
        $cr=get_like($cr,'supplier_name',$supplier,'');
        $cr=get_like($cr,'event_code,event_title',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, $viewfile, $data);
    }

    //商家下架审核
    public function actionIndex_exam($keywords='',$supplier='',$start='',$end='') {
        $this->ShowExam($keywords,$supplier,$start,$end,' AND supplier_id='.get_session('club_id'),'index_exam');
    }
    //GF商城下架审核
    public function actionIndex_exam_gf($keywords='',$supplier='',$start='',$end='') {
        $this->ShowExam($keywords,$supplier,$start,$end,'','index_exam_gf');
    }
    public function ShowExam($keywords = '',$supplier='',$start='',$end='',$club='',$viewfile) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        if ($start=='') $start=$now;
        $criteria = new CDbCriteria;
        $cr='if_del=648 AND down_up=-1';
        $cr.=' and f_check in (2,373)';
        $cr.=$club;
        $cr=get_where($cr,($start!=""),'reasons_time>=',$start.' 00:00:00','"');
        $cr=get_where($cr,($end!=""),'reasons_time<=',$end.' 23:59:59','"');
        $cr=get_like($cr,'supplier_name',$supplier,'');
        $cr=get_like($cr,'event_code,event_title',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
        $data = array();
        $data['start'] = $start;
        $data['end'] = $end;
        $data['num'] = $model->count('down_up>=-1 and f_check=371 and pricing_type=361'.$club);
        parent::_list($model, $criteria, $viewfile, $data);
    }

    //商家下架审核-待审核
    public function actionIndex_check($keywords='',$supplier='',$start='',$end='') {
        $this->ShowCheck($keywords,$supplier,$start,$end,' AND supplier_id='.get_session('club_id'),'index_check');
    }
    public function ShowCheck($keywords = '',$supplier='',$start='',$end='',$club='',$viewfile) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr='if_del=648 AND down_up=-1';
        $cr.=' and f_check=371';
        $cr.=$club;
        $cr=get_where($cr,($start!=""),'apply_time>=',$start.' 00:00:00','"');
        $cr=get_where($cr,($end!=""),'apply_time<=',$end.' 23:59:59','"');
        $cr=get_like($cr,'supplier_name',$supplier,'');
        $cr=get_like($cr,'event_code,event_title',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
        $data = array();
        $data['start'] = $start;
        $data['end'] = $end;
        $data['num'] = $model->count('down_up>=-1 and f_check=371 and pricing_type=361'.$club);
        parent::_list($model, $criteria, $viewfile, $data);
    }
//商品下架列表
    public function actionIndex_list($keywords = '',$start='',$end='',$supplier=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        $now_m=date("Y-m-d",strtotime("-1 months",strtotime($now)));
        if ($start=='') $start=$now_m;
        $criteria = new CDbCriteria;
        $cr='if_del=648 AND down_up=-1';
        $cr.=' and f_check=2';
        $cr.=' AND supplier_id='.get_session('club_id');
        $cr=get_where($cr,($start!=""),'reasons_time>=',$start.' 00:00:00','"');
        $cr=get_where($cr,($end!=""),'reasons_time<=',$end.' 23:59:59','"');
        $cr=get_like($cr,'supplier_name',$supplier,'');
        $cr=get_like($cr,'event_code,event_title',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'id DESC';
        $data = array();
        $data['start'] = $start;
        $data['end'] = $end;
        parent::_list($model, $criteria, 'index_list', $data);
    }
	
	public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
			$data['product_list'] = array();
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
//商品下架申请详情
    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			$data['product_list'] = array();
            $data['product_list'] = MallPriceSetDetails::model()->findAll('set_id='.$model->id.' order by product_code');
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }
//商品下架审核
    public function actionUpdate_check($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['product_list'] = array();
            $data['product_list'] = MallPriceSetDetails::model()->findAll('set_id='.$model->id.' order by product_code');
            $this->render('update_check', $data);
        } else {
            $model->attributes =$_POST[$modelName];
            $state=get_check_code($_POST['submitType']);
            $now=date('Y-m-d H:i:s');
            $st=0;
            if(!empty($state)){
                MallPriceSet::model()->updateAll(array('f_check'=>$state,'reasons_time'=>$now),'id='.$model->id);
                MallPriceSetDetails::model()->updateAll(array('f_check'=>$state),'set_id='.$model->id);
                if($state==2) $this->save_check_data($model->id,$model->down_time);
                $st++;
            }
            show_status($st,'已审核',get_cookie('_currentUrl_'),'审核失败');
        }
    }
    function saveData($model,$post) {
        $model->attributes =$post;
        $model->down_up=-1;
        $model->if_user_state=648;
        $model->pricing_type=361;
        $model->f_check = get_check_code($_POST['submitType']);
        $o = '保存成功'; $n = '保存失败';
        if($_POST['submitType']=='shenhe'){ 
            $o='提交成功';$n='提交失败';
            $model->apply_time=date('Y-m-d h:i:s');
        }
        $sv=$model->save();
        $this->save_product($model->id,$model->down_time);
        $action=($model->f_check==721) ? $this->createUrl('mallLowerSet/update&id='.$model->id) : get_cookie('_currentUrl_');
        show_status($sv,$o,$action,$n);
    }
    
    public function save_product($id,$down_time){
        $model=MallLowerSet::model()->find('id='.$id);
        $product_detail = new MallPriceSetDetails();
        $product_detail->updateAll(array('sale_bean2'=>-1),'set_id='.$id);
        if(isset($_POST['product'])){
            foreach ($_POST['product'] as $v){
                if($v['id']=='null'){
                    $product_detail->isNewRecord = true;
                    unset($product_detail->id);
                } else {
                    $product_detail = MallPriceSetDetails::model()->find('id='.$v['id']);
                }
                $product_detail->set_id = $id;
                $product_detail->product_code = $v['code'];
                $product_detail->product_name = $v['title'];
                $product_detail->product_id = $v['productid'];
                $product_detail->sale_id = $v['sale_id'];
                $product_detail->if_dispay = 649;
                $product_detail->purpose = 719;
                $product_detail->shop_purpose = 719;
                $product_detail->json_attr=$v['json_attr'];
                $product_detail->supplier_id=$model->supplier_id;
                $product_detail->supplier_name =$model->supplier_name;
                $product_detail->down_pricing_id = 0;
                $product_detail->sale_bean2 = 0;
                $product_detail->down_time = $down_time;
                $product_detail->pricing_type =$model->pricing_type;
                $product_detail->down_pricing_set_id = $v['down_set_id'];
                $product_detail->down_pricing_set_details_id = $v['down_detailsid'];
                $product_detail->up_quantity = $v['upquantity'];
                $product_detail->up_available_quantity =$v['available_quantity'];
                $product_detail->Inventory_quantity =$v['inventory_quantity'];
                $product_detail->f_check =$model->f_check;
                $product_detail->save();
            }
        }
        MallPriceSetDetails::model()->deleteAll('set_id='.$id.' AND sale_bean2=-1');
    }

 public function save_check_data($id,$down_time){ //审核处理
        
        $orderinfo = MallSalesOrderInfo::model()->find('up_down_id='.$id);
        if(empty($orderinfo)){
            $orderinfo = new MallSalesOrderInfo();
            $orderinfo->isNewRecord = true;
           unset($orderinfo->id);
            $orderinfo->order_num = MallSalesOrderInfo::model()->get_new_order_num();
            $orderinfo->order_type = 361;
            $order_name = BaseCode::model()->find('f_id='.$orderinfo->order_type);
            $orderinfo->order_type_name = $order_name->F_NAME;
            $orderinfo->up_down_id = $id;
            $orderinfo->sale_up_down = -1;
        }
        $tmp1=MallPriceSet::model()->find('id='.$id);
        if(!empty($tmp1)){
            $orderinfo->order_title =$tmp1->event_title;
            $orderinfo->up_down_code=$tmp1->event_code;
        }
        $orderinfo->save();

        $product_detail = MallPriceSetDetails::model()->findAll('set_id='.$id);
        $orderdata1 = new MallSalesOrderData();
        $orderdata1->updateAll(array('sale_up_down'=>0),'down_set_id='.$id);
        if(!empty($product_detail)){
            foreach ($product_detail as $v){
                $orderdata = MallSalesOrderData::model()->find('order_num='."'".$orderinfo->order_num."'".' AND set_detail_id='.$v['down_pricing_set_details_id']);
                $set_show = MallPricingDetails::model()->find('set_id='.$v['down_pricing_set_id']);
                if(empty($orderdata)){
                    $orderdata = new MallSalesOrderData();
                    $orderdata->isNewRecord = true;
                    unset($orderdata->id);
                }
                $orderdata->order_num = $orderinfo->order_num;
                $orderdata->info_id = $orderinfo->id;
                $orderdata->product_code = $v['product_code'];
                $orderdata->product_title = $v['product_name'];
                $orderdata->json_attr = $v['json_attr'];
                $orderdata->order_type = $v['pricing_type'];
                $orderdata->order_type_name = $orderinfo->order_type_name;
                $orderdata->product_id = $v['product_id'];
                $orderdata->set_id = $v['down_pricing_set_id'];
                $orderdata->details_id = 0;
                $orderdata->purpose = 10;
                if(!empty($set_show)){
                    $orderdata->sale_show_id = $set_show->sale_show_id;  // 商品原状态
                }
                $orderdata->set_detail_id = $v['down_pricing_set_details_id'];
                $orderdata->buy_count = $v['Inventory_quantity'];
                $orderdata->supplier_id = $v['supplier_id'];
                $orderdata->supplier_name = $v['supplier_name'];
                $orderdata->sale_up_down = -1;  // -1为下架，标识
                $orderdata->down_set_id = $v['set_id'];
                $orderdata->down_set_details_id = $v['id'];
                $orderdata->ret_state = 2;
                $orderdata->save();
            }
        }
        MallSalesOrderData::model()->deleteAll('down_set_id='.$id.' AND sale_up_down=0');
        MallPriceSetDetails::model()->updateAll(array('f_check'=>2),'set_id='.$id);//明细
        MallPriceSet::model()->updateAll(array('f_check'=>2),'id='.$id);//上下单
    }

//撤销申请
    public function actionCancelSubmit($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
                $model->updateByPk($d,array('f_check'=>721));
                MallPriceSetDetails::model()->updateAll(array('f_check'=>721),'set_id='.$d);
                $count++;
            
        }
        if ($count > 0) {
            ajax_status(1, '撤销成功');
        } else {
            ajax_status(0, '撤销失败');
        }
    }
	//逻辑删除	
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
}
