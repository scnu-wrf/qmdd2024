<?php

class InvoiceRequestListController extends BaseController {

    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($keywords = '',$start='',$end='',$company_personer = '',$category='',$apply_type=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        //if ($start=='') $start=$now;
        $criteria = new CDbCriteria;
        $criteria->join = "JOIN mall_sales_order_data on t.id=mall_sales_order_data.gf_invoice_id";
        $criteria->join.= " JOIN order_info_logistics on mall_sales_order_data.logistics_id=order_info_logistics.id";
        $cr=' (mall_sales_order_data.invoice_data_id=0 or mall_sales_order_data.invoice_data_id="")';
        $cr.=' and receipt_state=513';
        $cr.=' and mall_sales_order_data.orter_item=757';
        $cr.=' and order_info_logistics.logistics_state in (474,475)';
        $cr=get_where($cr,!empty($apply_type),'t.apply_type',$apply_type,'');
        $cr=get_where($cr,!empty($company_personer),'t.company_personer',$company_personer,'');
        $cr=get_where($cr,!empty($category),'t.invoice_category',$category,'');
        $cr=get_where($cr,($start!=""),'t.udate>=',$start.' 00:00:00','"');
        $cr=get_where($cr,($end!=""),'t.udate<=',$end.' 23:59:59','"');
        $criteria->condition=get_like($cr,'mall_sales_order_data.supplier_name,mall_sales_order_data.gf_name',$keywords,'');
        //$criteria->group='t.id';
        $criteria->order = 't.id DESC';
		$data = array();
        $data['start'] = $start;
        $data['end'] = $end;
        $data['company_personer'] = BaseCode::model()->getCode(402);
        $data['category'] = BaseCode::model()->getCode(375);
        parent::_list($model, $criteria, 'index', $data);
    }
	
	public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
			$data['order_data'] = array();
            $this->render('update', $data);
          } else {
                 $this-> saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
			$data['in_data'] = array();
            $data['in_data'] =MallSalesOrderData::model()->findAll('gf_invoice_id='.$model->id.' and orter_item=757');
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
  }
  

 function saveData($model,$post) {
        $model->attributes = $post;
		$model->receipt_state = 514;
		$model->drawer_admin_id = get_session('admin_id');
		$model->logistics_date = date('Y-m-d h:i:s');
		$st=$model->save();
		$this->save_data($model->id);
        show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }
public function save_data($id){ 
    $model=InvoiceRequestList::model()->find('id='.$id);
    $listdata= new InvoiceRequestListData();
    $listdata->isNewRecord = true;
    unset($listdata->id);
    $listdata->invoice_request_list_id=$id;
    $listdata->order_num=$model->order_num;
    $listdata->total_money=$model->total_money;
    $listdata->invoiced_amount=$model->invoiced_amount;
    $listdata->company_personer=$model->company_personer;
    $listdata->invoice_category=$model->invoice_category;
    $listdata->receipt_head=$model->receipt_head;
    $listdata->tax_number=$model->tax_number;
    $listdata->registered_address=$model->registered_address;
    $listdata->registered_phone=$model->registered_phone;
    $listdata->branch_account=$model->branch_account;
    $listdata->bank_account=$model->bank_account;
    $listdata->receipt_email=$model->receipt_email;
    $listdata->receipt_phone=$model->receipt_phone;
    $listdata->main_unit=$model->main_unit;
    $listdata->udate=$model->udate;
    $listdata->electronics_images=$model->electronics_images;
    $listdata->invoice_number=$model->invoice_number;
    $listdata->drawer_admin_id=$model->drawer_admin_id;
    $listdata->logistics_date=$model->logistics_date;
    $listdata->receipt_state=$model->receipt_state;
    $listdata->logistics_number=$model->logistics_number;
    $listdata->logistics_id=$model->logistics_id;
    $listdata->logistics_name=$model->logistics_name;
    $listdata->rec_name=$model->rec_name;
    $listdata->rec_address=$model->rec_address;
    $listdata->rec_phone=$model->rec_phone;
    $listdata->save();
	$orderdata=new MallSalesOrderData();
    $orderdata->updateAll(array('invoice_data_id'=>$listdata->id),'gf_invoice_id='.$id.' and orter_item=757');
  }
  
    //删除
  public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
		$orderdata=new MallSalesOrderData(); 
		$club=explode(',', $id);
        $count=0;
		foreach ($club as $d) {
			$model->deleteAll('id ='. $d);
			InvoiceRequestListData::model()->deleteAll('invoice_request_list_id ='.$d);
			$orderdata->updateAll(array('gf_invoice_id'=>0,'invoice_data_id'=>0),'gf_invoice_id='.$d);//恢复没有发货状态标记
			$count++;
		}
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }

}
 