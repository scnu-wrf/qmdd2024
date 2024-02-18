<?php

class OrderInfoLogisticsController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
	public function actionIndex($start='',$end='',$logistics_number='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $club_id=get_session('club_id');
        $now=date('Y-m-d');
        if ($start=='') $start=$now;
        $criteria = new CDbCriteria;
        $criteria->join = "JOIN mall_sales_order_data on t.id=mall_sales_order_data.logistics_id";
        $criteria->join.= " JOIN mall_sales_order_info on mall_sales_order_data.info_id=mall_sales_order_info.id";
		$cr='supplier='.$club_id;
		$cr=get_like($cr,'logistics_xh,logistics_number,mall_sales_order_info.order_gfaccount',$logistics_number,'');
        $cr=get_where($cr,($start!=""),'logistics_date>=',$start.' 00:00:00','"');
        $cr=get_where($cr,($end!=""),'logistics_date<=',$end.' 23:59:59','"');
        $criteria->condition=$cr;
        $criteria->group='t.id';
        $criteria->order = 't.id DESC';
		$data = array();
		//待发货商品数量统计
		$arr_r = array();
        $arr_r[]=-1;
        $club_id=get_session('club_id');
        $return_data=MallSalesOrderData::model()->findAll('supplier_id='.$club_id.' AND order_type=361 AND change_type=1137 AND sale_show_id in (1129,1132,1133,1134,1135) and ret_state in (371,2)');
        foreach($return_data as $r){
            $arr_r[]=$r->Return_no;
        }
        $return_id=implode(',', $arr_r);
        $csql='supplier_id='.$club_id.' AND logistics_id=0 AND order_type=361 AND change_type=0 AND sale_show_id in (1129,1132,1133,1134,1135) and id not in ('.$return_id.')';

        $data['datacount']=MallSalesOrderData::model()->count($csql);
		$data['logistics'] = BaseCode::model()->getLogisticsType();
		$data['num1']= OrderInfoLogistics::model()->count('supplier='.$club_id.' and logistics_date>="'.$now.' 00:00:00"');//今日已发
		$data['num2']= OrderInfoLogistics::model()->count('supplier='.$club_id);//已发单总数
        $data['start'] = $start;
        $data['end'] = $end;
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate($gfid,$club_id) {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
			$data['order_data'] =array();
			$data['rec_data'] = array();
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
	
	public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
		   $data['model'] = $model;
		   $data['order_data'] = array();
		   $data['rec_data'] =  array();
		   $data['order_data'] = MallSalesOrderData::model()->findAll('logistics_id='.$model->id);
		   $rec_order= MallSalesOrderData::model()->find('logistics_id='.$model->id);
		   if(!empty( $rec_order)){
		     $data['rec_data'] = MallSalesOrderInfo::model()->find('order_num="'.$rec_order->order_num.'"');
		   }
           $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
    }
    function saveData($model,$post) {
       $model->attributes =$post;
	   $arr = array();
	   $r_count=0;
       $arr = explode(',', $post['orderdata']);	   
		if ($_POST['submitType'] == 'fahuo') {
			$model->logistics_state = 473;
			$model->logistics_date = date('Y-m-d H:i:s');
			foreach ($arr as $d) {
				$rd=MallSalesOrderData::model()->find('Return_no='.$d.' and ret_state in (371,2)');
				if(!empty($rd)){
					$r_count=1;break;
				}
			}
        } else if ($_POST['submitType'] == 'qianshou') {
			$model->logistics_state = 474;
			$model->sign_date = date('Y-m-d H:i:s');
		}
		if($r_count==0){
			$st=$model->save();
		    $this->save_orderdata($model->id,$post['orderdata']);
		    if ($_POST['submitType'] == 'fahuo') {
		        $this->save_fahuo($model->id,$post['orderdata']);
		        $return_d=MallSalesOrderData::model()->find('id in ('.$post['orderdata'].')');
				$action=$this->createUrl('create',array('id'=>0,'gfid'=>$return_d->gfid,'club_id'=>$return_d->supplier_id));
		   } elseif ($_POST['submitType'] == 'baocun') {
		   		$this->save_fahuo($model->id,$post['orderdata']);
				$action=get_cookie('_currentUrl_');
		   } else {
				$action=get_cookie('_currentUrl_');
		   }
		  show_status($st,'保存成功', $action,'保存失败');
		} else{
			ajax_status(0, '商品已申请退款，请重新选择发货商品');
		}
          
    }
    //添加发货操作记录
	public function save_fahuo($id,$arr){ 
		$arr_order = explode(',', $arr);	 
		$model=OrderInfoLogistics::model()->find('id='.$id);
		foreach ($arr_order as $v) {
        	$return_d=MallSalesOrderData::model()->find('id='.$v);
        	$orderrecode = new OrderRecord(); 
        	$orderrecode->isNewRecord = true;
            unset($orderrecode->id);
	  		$orderrecode->is_pay = 464;
			$orderrecode->order_state = 465;
			$orderrecode->user_member = 502;
			$orderrecode->operator_gfid = get_session('admin_id');
			$orderrecode->operator_gfname = get_session('admin_name');
            $orderrecode->order_id = $return_d->info_id;
            $orderrecode->order_num = $return_d->order_num;
            $orderrecode->logistics_xh = $return_d->logistics_id_no;
            $orderrecode->logistics_id = $model->id;
            $orderrecode->logistics_state = $model->logistics_state;
            $orderrecode->order_state_des_content ='已发货('.$return_d->product_title.')';
		    $orderrecode->save();
	    }
	}

 
	public function save_orderdata($id,$orderdata_list){  
		$orderdata=new MallSalesOrderData();
	    $orderdata->updateAll(array('logistics_id'=>0 ),'logistics_id='.$id);//恢复没有发货状态标记
	    if(!empty($orderdata_list)){
	        $orderdata = new MallSalesOrderData();
	        $arr = array();
	        $arr = explode(',', $orderdata_list);
	        foreach ($arr as $v) {
	        	$req=0;
				$one_data=MallSalesOrderData::model()->find('id='.$v);
				$no_data=MallSalesOrderData::model()->find('logistics_id='.$id.' AND order_num="'.$one_data->order_num.'"');
				if(!empty($no_data)){
					$code=$no_data->logistics_id_no;
					$req=$no_data->gf_invoice_id;
					$Invoice=InvoiceRequestList::model()->find('id='.$no_data->gf_invoice_id);
					if($Invoice->apply_type==1457){
						$money1=$Invoice->total_money+$one_data->total_pay;
						$money2=$Invoice->invoiced_amount+$one_data->buy_amount;
						InvoiceRequestList::model()->updateAll(array('total_money'=>$money1,'invoiced_amount'=>$money2,'logistics_xh'=>$code),'id='.$no_data->gf_invoice_id);
					}
				} else {
					$count = MallSalesOrderData::model()->count('order_num="'.$one_data->order_num.'" AND logistics_id<>0');
					$code = substr('00' . strval($count+1), -2);

					if($one_data->gf_invoice_id==0 || $one_data->gf_invoice_id=='' || $one_data->gf_invoice_id==null){
						$gf_invoice = new InvoiceRequestList();
						$gf_invoice->isNewRecord = true;
	            		unset($gf_invoice->id);
	            		$gf_invoice->order_num=$one_data->order_num;
	            		$gf_invoice->logistics_xh=$code;
	            		$gf_invoice->detail='平台电子发票';
	            		$gf_invoice->total_money=$one_data->total_pay;
	            		$gf_invoice->invoiced_amount=$one_data->buy_amount;
	            		$gf_invoice->company_personer=403;
	            		$gf_invoice->invoice_category=377;
	            		$gf_invoice->receipt_head=$one_data->gf_name;
	            		$gf_invoice->main_unit=$one_data->supplier_id;
	            		$gf_invoice->receipt_state=513;
						$gf_invoice->save();
						$req=$gf_invoice->id;
					} else{
						$req=$one_data->gf_invoice_id;
					}
				}
				$orderdata->updateAll(array('logistics_id'=>$id,'logistics_id_no'=>$code,'gf_invoice_id'=>$req),'id='.$v);
	        }
	    }
  }
  //获取下单人购买的所有商品
  public function actionAlldata($id,$gfid,$club_id) {
		$arr_r = array();
		$arr_r[]=-1;
		$return_data=MallSalesOrderData::model()->findAll('gfid='.$gfid.' and supplier_id='.$club_id.' AND order_type=361 AND change_type=1137 AND sale_show_id in (1129,1132,1133,1134,1135) and ret_state in (371,2)');
        foreach($return_data as $r){
            $arr_r[]=$r->Return_no;
        }
        $return_id=implode(',', $arr_r);
		$s1='gfid='.$gfid.' and supplier_id='.$club_id;
		$s1.=' AND order_type=361 AND change_type=0';
		$s1.=' AND sale_show_id in (1129,1132,1133,1134,1135)';
		$s1.=' AND (logistics_id=0 or logistics_id='.$id.') and id not in ('.$return_id.')';
		$recognizee=MallSalesOrderData::model()->findAll($s1);
		$arr = array();
        $r=0;
		if(!empty($recognizee)){
			foreach ($recognizee as $v) {
				$order=MallSalesOrderInfo::model()->find('order_num="'.$v->order_num.'"');
				if(!empty($order)){
					$id=0;
					$order_num='';
					$supplier_code='';
					$product_code='';
					$product_title='';
					$json_attr='';
					$buy_count='';
					$rec_name='';
					$rec_address='';
					$rec_phone='';
					$leaving_a_message='';
					if(!empty($v->id)){
						$id=$v->id;
					}
					if(!empty($v->order_num)){
						$order_num=$v->order_num;
					}
					if(!empty($v->supplier_code)){
						$supplier_code=$v->supplier_code;
					}
					if(!empty($v->product_code)){
						$product_code=$v->product_code;
					}
					if(!empty($v->product_title)){
						$product_title=$v->product_title;
					}
					if(!empty($v->json_attr)){
						$json_attr=$v->json_attr;
					}
					if(!empty($v->buy_count)){
						$buy_count=$v->buy_count;
					}
					if(!empty($order->rec_name)){
						$rec_name=$order->rec_name;
					}
					if(!empty($order->rec_address)){
						$rec_address=$order->rec_address;
					}
					if(!empty($order->rec_phone)){
						$rec_phone=$order->rec_phone;
					}
					if(!empty($v->leaving_a_message)){
						$leaving_a_message=$v->leaving_a_message;
					}
					$arr[$r]['orderdata_id'] = $id;
					$arr[$r]['order_num'] = $order_num;
					$arr[$r]['supplier_code'] = $supplier_code;
					$arr[$r]['product_code'] = $product_code;
					$arr[$r]['product_title'] = $product_title;
					$arr[$r]['json_attr'] = $json_attr;
					$arr[$r]['buy_count'] = $buy_count;
					$arr[$r]['rec_name'] = $rec_name;
					$arr[$r]['rec_address'] = $rec_address;
					$arr[$r]['rec_phone'] = $rec_phone;
					$arr[$r]['message'] = $leaving_a_message;
					$r=$r+1;
				}

			}
		}
		ajax_exit($arr);
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
        if(!empty($achie))foreach($achie as $v){
        	$achie_data = QmddAchievemenData::model()->find('order_num_id='.$orderInfo->id.' and f_achievemenid='.$v->f_id);
        	if(empty($achie_data)){
                $achie_data = new QmddAchievemenData();
                $achie_data->isNewRecord=true;
                unset($achie_data->f_id);
            }
            if(!empty($orderInfo)){
                $achie_data->order_num_id = $orderInfo->id;
            }
            $achie_data->f_achievemenid = $v->f_id;
            $sf=$achie_data->save();
		}
        $sv= ($sf==1&&$sn==1) ? 1 : 0;
		show_status($sv,'已签收',$action,'签收失败');
	}
    //获取发货商品的信息
  public function actionsearchdata() {
  	$orderdata = $_POST['orderdata'];
  	//$dataid = explode(',', $orderdata);
		$arr = array();
		$recognizee=MallSalesOrderData::model()->findAll('id in ('.$orderdata.')');
		$r=0;
		if(!empty($recognizee)){
			foreach ($recognizee as $v) {
				$id=0;
				$product_code='';
				$product_title='';
				$json_attr='';
				if(!empty($v->id)){
					$id=$v->id;
				}
				if(!empty($v->product_code)){
					$product_code=$v->product_code;
				}
				if(!empty($v->product_title)){
					$product_title=$v->product_title;
				}
				if(!empty($v->json_attr)){
					$json_attr=$v->json_attr;
				}
				$arr[$r]['orderdata_id'] = $id;
				$arr[$r]['product_code'] = $product_code;
				$arr[$r]['product_title'] = $product_title;
				$arr[$r]['json_attr'] = $json_attr;
				$r=$r+1;
			}
			ajax_exit($arr);
		}
    }

    //查看待发货商品列表
    public function actionOrderdata($keywords = '') {
        $data = array();
        $arr_r = array();
        $arr_r[]=-1;
        $club_id=get_session('club_id');
        $model = MallSalesOrderData::model();
        $return_data=$model->findAll('supplier_id='.$club_id.' AND order_type=361 AND change_type=1137 AND gfid>0 AND sale_show_id in (1129,1132,1133,1134,1135) and ret_state in (371,2)');
        foreach($return_data as $r){
            $arr_r[]=$r->Return_no;
        }
        $return_id=implode(',', $arr_r);
        $criteria = new CDbCriteria;
        $criteria->condition = 'supplier_id='.$club_id.' AND logistics_id=0 AND order_type=361 AND change_type=0 AND sale_show_id in (1129,1132,1133,1134,1135) and id not in ('.$return_id.')';
        $criteria->condition=get_like($criteria->condition,'order_num,product_code,product_title',$keywords,'');
		$criteria->order = 'gfid DESC';
        parent::_list($model, $criteria, 'orderdata', $data);
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
			$orderdata->updateAll(array('logistics_id'=>0 ),'logistics_id='.$d);//恢复没有发货状态标记
			$count++;
		}
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }

}
