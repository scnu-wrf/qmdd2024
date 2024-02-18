<?php

class CarinfoController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
	public function actionIndex($start_date='',$end_date='',$order_state='',$is_pay='',$pay_type='',$order_type='',$order_num='',$gf_name='',$rec_phone='', $province = '', $city = '', $area = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$cr=get_where('if_del=0',$order_type,'order_type',$order_type,'');
		$cr=get_like($cr,'order_num',$order_num,'');
		$cr=get_like($cr,'rec_name',$gf_name,'');
		$cr=get_like($cr,'rec_phone',$rec_phone,'');
		$cr=get_where($cr,$start_date,'order_Date>=',$start_date,'"');
        $cr=get_where($cr,$start_date,'order_Date<=',$end_date,'"');
		if ($province !== '') {
            $cr.=' AND t.rec_address like "%' . $province . '%"';
        }
        if ($city == '市辖区' || $city == '市辖县' || $city == '省直辖县级行政区划') {
            $city = '';
        }
        if ($area == '市辖区' || $area == '市辖县' || $area == '省直辖县级行政区划') {
            $area = '';
        }
		$criteria->condition=get_like($cr,'rec_address',$province.$city.$area,'');
        $criteria->order = 'id DESC';
		$data = array();
		$data['pay_type'] = BaseCode::model()->getCode(481);
		$data['order_type'] = BaseCode::model()->getOrderType();
		$data['logistics'] = BaseCode::model()->getCode(471);
        parent::_list($model, $criteria, 'index', $data);
	}
	
	public function actionIndex_club($order_type='',$keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
		$criteria = new CDbCriteria;
		$cr=' order_gfid='.get_session('club_id');
        $cr=get_where($cr,$order_type,'order_type',$order_type,'"');
		$criteria->condition = get_like($cr,'order_num',$keywords,'');
        $criteria->order = 'order_num DESC';
		$data = array();
		$data['order_type'] = BaseCode::model()->getReturn('355,1162');
        parent::_list($model, $criteria, 'index_club', $data);
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
		   $data['model'] = $model;
           $data['best_time'] = BaseCode::model()->getCode(477);
           $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
    public function actionUpdate_club($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
		   $data['model'] = $model;
           $data['pay_set'] = GfPaySet::model()->findAll('pay_client=1031 and is_open_user=1');
           $this->render('update_club', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    function saveData($model,$post) {
       $model->attributes =$post;
       $st=$model->save();
	   if ($_POST['submitType'] == 'mianzhifu') {
		    $orderinfo = new MallSalesOrderInfo();
			$orderinfo->saveOrderinfo($model);
	        MallSalesOrderData::model()->saveOrderdata($model->order_num);
			$count = $model->updateByPk($id,array('if_del'=>649));
			ajax_status(1, '免支付成功', get_cookie('_currentUrl_'));
	    } else if($_POST['submitType'] == 'qvxiao') {
			$count = $model->deleteByPk($model->id);
			show_status($st,'取消订单成功', get_cookie('_currentUrl_'),'取消订单失败');   
		}
	  show_status($st,'操作成功', get_cookie('_setcurrentUrl_'),'操作失败');   
    }
	
	//修改收货信息	
	public function actionReceiptUpdate($rid) {
        $modelName = $this->model;
        $model = $this->loadModel($rid, $modelName);
        //$model = $modelName::model();
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
		   $data['model'] = $model;
          $this->render('receiptUpdate', $data);
        } else {
			$this-> saveData($model,$_POST[$modelName]);		
        }
    }

	//修改费用信息
	public function actionUpdate_cost($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
		   $data['model'] = $model;  
           $this->render('update_cost', $data);
        } else {
			$model->attributes = $_POST[$modelName];
			$st=$model->save();
			show_status($st,'修改成功', get_cookie('_setcurrentUrl_'),'修改失败'); 
        }
    }

    /////////////////////////////////修改收货信息
	public function actionReceipt() {
		$this->actionCost();
	}
	///////////////////////////////////////修改费用信息
	public function actionCost() {
		$modelName = $this->model;
        $model = $modelName::model();
		if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
        } else {
			$id = $_POST['id'];
			$model= $modelName::model()->find('id='.$id);
			$model->attributes = $_POST;
			$action=$this->createUrl('Carinfo/update', array('id'=>$model->id));
			show_status($model->save(),'修改成功', $action,'修改失败'); 
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
