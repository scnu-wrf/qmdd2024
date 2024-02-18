<?php

class InvoiceRequestListDataController extends BaseController {

  protected $model = '';
  public function init() {
    $this->model = substr(__CLASS__, 0, -10);
    parent::init();
  }

  public function actionIndex($keywords = '',$start='',$end='',$company_personer = '',$category='') {
    set_cookie('_currentUrl_', Yii::app()->request->url);
    $modelName = $this->model;
    $model = $modelName::model();
    $now=date('Y-m-d');
    if ($start=='') $start=$now;
    $criteria = new CDbCriteria;
    $cr='1=1';
    $cr=get_where($cr,!empty($company_personer),'company_personer',$company_personer,'');
    $cr=get_where($cr,!empty($category),'invoice_category',$category,'');
    $cr=get_where($cr,($start!=""),'logistics_date>=',$start.' 00:00:00','"');
    $cr=get_where($cr,($end!=""),'logistics_date<=',$end.' 23:59:59','"');
    $cr=get_like($cr,'invoice_number,order_num',$keywords,'');
    $criteria->condition=$cr;
    $criteria->order = 'logistics_date DESC';
		$data = array();
    $cu1 = new CDbCriteria;
    $cu2 = new CDbCriteria;
    $join="JOIN mall_sales_order_data on t.id=mall_sales_order_data.gf_invoice_id";
    $join.=" JOIN order_info_logistics on mall_sales_order_data.logistics_id=order_info_logistics.id";
    $cu1->join =$join;
    $cu2->join=$join;
    $co=' (mall_sales_order_data.invoice_data_id=0 or mall_sales_order_data.invoice_data_id="")';
    $co.=' and receipt_state=513';
    $co.=' and mall_sales_order_data.orter_item=757';
    $co.=' and order_info_logistics.logistics_state in (474,475)';
    $cu1->group='t.id';
    $cu2->group='t.id';
    $cu1->condition=$co.' and apply_type=1458';
    $cu2->condition=$co.' and apply_type=1457';
		$data['num1']=InvoiceRequestList::model()->count($cu1);
		$data['num2']=InvoiceRequestList::model()->count($cu2);
    $data['start'] = $start;
    $data['end'] = $end;
    $data['company_personer'] = BaseCode::model()->getCode(402);
    $data['category'] = BaseCode::model()->getCode(375);
    parent::_list($model, $criteria, 'index', $data);
  }
	
	public function actionCreate($id) {
    $modelName = $this->model;
    $model = new $modelName('create');
    $data = array();
    if (!Yii::app()->request->isPostRequest) { 
      if($id==0){
        $tmp=MallSalesOrderData::model()->find('invoice_data_id=0 AND gf_invoice_id<>0 AND supplier_id='.get_session('club_id'));
			  $invoice_id=$tmp->gf_invoice_id;
		  } else {
        $tmp=MallSalesOrderData::model()->find('invoice_data_id=0 AND gf_invoice_id='.$id.' AND supplier_id='.get_session('club_id'));
			  $invoice_id=$id;
		  }
      $data['order_data']=array();
      if(!empty($tmp)){
	      $tmp1=InvoiceRequestList::model()->find("id=".$invoice_id);
        if(!empty($tmp1)){
          $model->invoice_request_list_id=$tmp1->id;
          $model->order_num=$tmp->order_num;
          $model->company_personer=$tmp1->company_personer;
          $model->invoice_category=$tmp1->invoice_category;
          $model->receipt_head=$tmp1->receipt_head;
          $model->tax_number=$tmp1->tax_number;
          $model->registered_address=$tmp1->registered_address;
          $model->registered_phone=$tmp1->registered_phone;
          $model->receipt_email=$tmp1->receipt_email;
          $model->receipt_phone=$tmp1->receipt_phone;
          $model->main_unit=$tmp->supplier_id;
				  $model->rec_name=$tmp1->rec_name;
          $model->rec_code=$tmp1->rec_code;
				  $model->rec_address=$tmp1->rec_address;
				  $model->rec_phone=$tmp1->rec_phone;
          $model->zipcode=$tmp1->zipcode;
				  $model->best_delivery_time=$tmp1->best_delivery_time;
        }
        $data['order_data'] = MallSalesOrderData::model()->findAll('invoice_data_id=0 AND info_id='.$tmp->info_id);
    
      }
        
      $data['model'] = $model;
      $this->render('update', $data);
    } else {
      $this-> saveData($model,$_POST[$modelName]);
    }
    }

  public function actionSecond($id) {
    $modelName = $this->model;
    $model = new $modelName('create');
    $data = array();
    if (!Yii::app()->request->isPostRequest) {
    
      $data['model'] = $model->find('id='.$id);
      $model_old = $model->find('id='.$id);
      $data['order_data'] = MallSalesOrderData::model()->findAll('invoice_data_id='.$id);
      $data['invoice_id'] =$id;

      $this->render('update', $data);
    } else {
      $this-> saveData($model,$_POST[$modelName]);
    }
  }

  public function actionCancel($id) {
      
    if(!empty($id)){
      InvoiceRequestListData::model()->updateAll(array('cancl_invoice'=>1),'id='.$id);
      MallSalesOrderData::model()->updateAll(array('invoice_data_id_cancel'=>1),'invoice_data_id='.$id);
      $sv=1;
    } else {
      $sv=0;
    }
    show_status($sv,'已收回',$this->createUrl('invoiceRequestListData/index'),'收回失败');
  }

  public function actionUpdate($id) {
    $modelName = $this->model;
    $model = $this->loadModel($id, $modelName);
    $data = array();
    if (!Yii::app()->request->isPostRequest) {
      $data['model'] = $model;
      $data['in_data'] = array();
      $data['in_data'] =MallSalesOrderData::model()->findAll('invoice_data_id='.$model->id.' and orter_item=757');
      $this->render('update', $data);
    } else {
        $this-> saveData($model,$_POST[$modelName]);
    }
  }
  

  function saveData($model,$post) {
    $model->attributes = $post;
	  $Request=new InvoiceRequestList();
		$model->receipt_state = 514;
		$model->drawer_admin_id =  Yii::app()->session['admin_id'];
		$model->logistics_date = date('Y-m-d h:i:s');
		$st=$model->save();
    if($model->invoice_id==0){
      $Request->updateAll(array('receipt_state'=>$model->receipt_state,'logistics_date'=>$model->logistics_date),'id='.$model->invoice_request_list_id);
    }
    show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败');
  }

  
  public function actionInfodata($invoice_id) {
    $model = MallSalesOrderData::model();
    $criteria = new CDbCriteria;
    $criteria->condition = 'invoice_data_id='.$invoice_id;
    $criteria->order = 'id DESC';
    $data = array();
    parent::_list($model, $criteria, 'log', $data);
}
    //删除
  public function actionDelete($id) {
    $modelName = $this->model;
    $model = $modelName::model();
		$orderdata=new MallSalesOrderData(); 
		$club=explode(',', $id);
    $count=0;
		foreach ($club as $d) {
      $data_list=$model->find('id ='. $d);
			$model->deleteAll('id ='. $d);
      InvoiceRequestList::model()->updateAll(array('receipt_state'=>513),'id='.$data_list->invoice_request_list_id);//恢复没有开票状态
			$orderdata->updateAll(array('invoice_data_id'=>0),'invoice_data_id='.$d);//恢复没有开票状态
      $orderdata->updateAll(array('invoice_data_id2'=>0),'invoice_data_id2='.$d);//恢复没有开票状态
			$count++;
		}
      if ($count > 0) {
          ajax_status(1, '删除成功');
      } else {
          ajax_status(0, '删除失败');
      }
    }

}
 