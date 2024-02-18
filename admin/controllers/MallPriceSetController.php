<?php

class MallPriceSetController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
	
	public function actionIndex($keywords = '',$state='',$pricing='0') {
		set_cookie('_currentUrl_', Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		$cr= 'down_up>=0 and f_check in (721,371,373)';
		$cr.=' AND supplier_id='.get_session('club_id');
		$cr=get_where($cr,!empty($state),' f_check',$state,'');
		$cr=get_where($cr,$pricing,' pricing_type',$pricing,'');
		$cr=get_like($cr,'event_code,event_title',$keywords,'');
		$criteria->condition=$cr;
		$criteria->order = 'id DESC';
		$data = array();
		$data['state'] = BaseCode::model()->findAll('f_id in (721,371,373)');
		parent::_list($model, $criteria, 'index', $data);
    }
	
	public function actionIndex_supplier($keywords = '',$state='',$userstate='',$pricing='') {
		set_cookie('_currentUrl_', Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		$cr= 'down_up>=0 and f_check in (721,373)';
		$cr.=' AND supplier_id='.get_session('club_id');
		$cr=get_where($cr,!empty($state),' f_check',$state,'');
		$cr=get_where($cr,!empty($userstate),' if_user_state',$userstate,'');
		$cr=get_where($cr,$pricing,' pricing_type',$pricing,'');
		$cr=get_like($cr,'event_code,event_title',$keywords,'');
		$criteria->condition=$cr;
		$criteria->order = 'id DESC';
		$data = array();
		$data['base_code'] =BaseCode::model()->findAll('f_id in (721,373)');
		$data['userstate'] = BaseCode::model()->getCode(647);
		parent::_list($model, $criteria, 'index_supplier', $data);
    }
    //GF官方上架审核
	public function actionIndex_pass($keywords = '',$state='',$start='',$end='',$pricing='') {
         $this->ShowCheck($keywords,$state,$start,$end,'','',' AND supplier_id='.get_session('club_id'),' and f_check in (2,373)','index_pass');
    }
//GF官方上架审核-待审核
    public function actionIndex_check($keywords = '',$start_time='',$end_time='') {
         $this->ShowCheck($keywords,'','','',$start_time,$end_time,' AND supplier_id='.get_session('club_id'),' and f_check=371','index_check');
    }
    public function ShowCheck($keywords = '',$state='',$start='',$end='',$start_time='',$end_time='',$club='',$f_check='',$viewfile) {
		set_cookie('_currentUrl_', Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$now=date('Y-m-d');
        if ($start=='' && $viewfile=='index_pass') $start=$now;
		$criteria = new CDbCriteria;
		$cr= 'down_up>=0 and pricing_type=361';
		$cr.= $f_check;
		$cr.=$club;
		$cr=get_like($cr,'event_code,event_title',$keywords,'');
		$cr=get_where($cr,!empty($state),' f_check',$state,'');
		$cr=get_where($cr,($start!=""),'reasons_time>=',$start.' 00:00:00','"');
		$cr=get_where($cr,($end!=""),'reasons_time<=',$end.' 23:59:59','"');
		$cr=get_where($cr,($start_time!=""),'apply_time>=',$start_time.' 00:00:00','"');
		$cr=get_where($cr,($end_time!=""),'apply_time<=',$end_time.' 23:59:59','"');
		$criteria->condition=$cr;
		$criteria->order = 'id DESC';
		$data = array();
		$data['start'] = $start;
        $data['end'] = $end;
		$data['start_time'] = $start_time;
        $data['end_time'] = $end_time;  
		//$data['base_code'] = BaseCode::model()->getStateType();
        $data['base_code'] = BaseCode::model()->findAll('f_id in (2,373)');
        $data['num'] = $model->count('down_up>=0 and f_check=371 and pricing_type=361'.$club);
        parent::_list($model, $criteria, $viewfile, $data);
    }


    //供应商上架审核
	public function actionIndex_supplier_pass($keywords = '',$state='',$userstate='',$start='',$end='',$pricing='') {
		set_cookie('_currentUrl_', Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$now=date('Y-m-d');
        if ($start=='') $start=$now;
		$criteria = new CDbCriteria;
		$cr= ' down_up>=0 ';
		$cr.= ' and f_check in (2,373)';
		$cr.=' AND supplier_id='.get_session('club_id');
		$cr=get_where($cr,!empty($state),' f_check',$state,'');
		$cr=get_where($cr,!empty($userstate),' if_user_state',$userstate,'');
		$cr=get_where($cr,$pricing,' pricing_type',$pricing,'');
		$cr=get_like($cr,'event_code,event_title',$keywords,'');
		$cr=get_where($cr,($start!=""),'reasons_time>=',$start.' 00:00:00','"');
		$cr=get_where($cr,($end!=""),'reasons_time<=',$end.' 23:59:59','"');
		$criteria->condition=$cr;
		$criteria->order = 'id DESC';
		$data = array();
		$data['start'] = $start;
        $data['end'] = $end;
        $data['base_code'] = BaseCode::model()->findAll('f_id in (2,373)');
		$data['userstate'] = BaseCode::model()->getCode(647);
		$data['num'] = $model->count('down_up>=0 and f_check=371 and pricing_type='.$pricing.' AND supplier_id='.get_session('club_id'));
		parent::_list($model, $criteria, 'index_supplier_pass', $data);
	}

	//供应商上架审核-待审核
	public function actionIndex_supplier_check($keywords = '',$userstate='',$start='',$end='',$pricing=361) {
		set_cookie('_currentUrl_', Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		$cr= 'down_up>=0 ';
		$cr.= ' and f_check=371';
		$cr.=' AND supplier_id='.get_session('club_id');
		$cr=get_where($cr,!empty($userstate),' if_user_state',$userstate,'');
		$criteria->condition=get_where($cr,$pricing,' pricing_type',$pricing,'');
		$cr=get_where($cr,($start!=""),'apply_time>=',$start.' 00:00:00','"');
		$cr=get_where($cr,($end!=""),'apply_time<=',$end.' 23:59:59','"');
		$cr=get_like($cr,'event_code,event_title',$keywords,'');
		$criteria->condition=$cr;
		$criteria->order = 'id DESC';
		$data = array();
		$data['start'] = $start;
        $data['end'] = $end;
		$data['userstate'] = BaseCode::model()->getCode(647);
		parent::_list($model, $criteria, 'index_supplier_check', $data);
	}

//自营-上架方案列表
	public function actionIndex_sale($keywords = '',$userstate='',$start='',$end='',$start_time='',$end_time='') {
         $this->ShowSale($keywords,$userstate,$start,$end,$start_time,$end_time,' AND supplier_id='.get_session('club_id'),'index_sale');
    }
//供应商-上架方案列表
	public function actionIndex_supplier_sale($keywords = '',$userstate='',$start='',$end='',$start_time='',$end_time='') {
         $this->ShowSale($keywords,$userstate,$start,$end,$start_time,$end_time,' AND supplier_id='.get_session('club_id'),'index_supplier_sale');
    }
//上架方案查询
    public function actionIndex_sale_gf($keywords = '',$userstate='',$start='',$end='',$start_time='',$end_time='') {
         $this->ShowSale($keywords,$userstate,$start,$end,$start_time,$end_time,'','index_sale_gf');
    }
    public function ShowSale($keywords = '',$userstate='',$start='',$end='',$start_time='',$end_time='',$club='',$viewfile) {
		set_cookie('_currentUrl_', Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$now=date('Y-m-d H:i:s');
		$criteria = new CDbCriteria;
		$cr='down_up>=0 and f_check=2 and pricing_type=361';
		$cr.=$club;
		$cr.=' and star_time<="'.$now.'" and end_time>="'.$now.'"';
		$cr.=' and start_sale_time<="'.$now.'" and down_time>="'.$now.'"';
		$cr=get_where($cr,($start!=""),'star_time>=',$start.' 00:00:00','"');
		$cr=get_where($cr,($end!=""),'end_time<=',$end.' 23:59:59','"');
		$cr=get_where($cr,($start_time!=""),'start_sale_time>=',$start_time.' 00:00:00','"');
		$cr=get_where($cr,($end_time!=""),'down_time<=',$end_time.' 23:59:59','"');
		$cr = get_where($cr,!empty($userstate),' if_user_state',$userstate,'');
		$cr=get_like($cr,'event_code,event_title',$keywords,'');
		$criteria->condition=$cr;
		$criteria->order = 'id DESC';
		$data = array();
		$data['start'] = $start;
        $data['end'] = $end;
		$data['start_time'] = $start_time;
        $data['end_time'] = $end_time;
        parent::_list($model, $criteria, $viewfile, $data);
    }

	//自营-历史上架方案
    public function actionIndex_log($keywords = '',$supplier='',$start='',$end='') {
         $this->ShowView($keywords,$supplier,$start,$end,' AND supplier_id='.get_session('club_id'),'index_log');
    }
    //供应商-历史上架方案
    public function actionIndex_supplier_log($keywords = '',$supplier='',$start='',$end='') {
         $this->ShowView($keywords,$supplier,$start,$end,' AND supplier_id='.get_session('club_id'),'index_supplier_log');
    }
    //历史上架方案查询
    public function actionIndex_log_gf($keywords = '',$supplier='',$start='',$end='') {
         $this->ShowView($keywords,$supplier,$start,$end,'','index_log_gf');
    }

    public function ShowView($keywords = '',$supplier='',$start='',$end='',$club='',$viewfile) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$now=date('Y-m-d');
		$now_time=date('Y-m-d H:i:s');
        $now_m=date("Y-m-d",strtotime("-1 months",strtotime($now)));
        if ($start=='') $start=$now_m;
		$criteria = new CDbCriteria;
		$cr= ' down_up>=0 ';
		$cr.= ' and f_check=2 and pricing_type=361';
		$cr.=' and end_time<"'.$now_time.'" and down_time<"'.$now_time.'"';
		$cr.=$club;
		$cr=get_where($cr,($start!=""),'down_time>=',$start.' 00:00:00','"');
		$cr=get_where($cr,($end!=""),'down_time<=',$end.' 23:59:59','"');
		$cr=get_like($cr,'supplier_name',$supplier,'');
		$cr=get_like($cr,'event_code,event_title',$keywords,'');
		$criteria->condition=$cr;
		$criteria->order = 'id DESC';
		$data = array();
		$data['start'] = $start;
        $data['end'] = $end;
        parent::_list($model, $criteria, $viewfile, $data);
    }
     //上架方案商品冻结销售
	public function actionIndex_list($keywords = '',$state='',$type='',$userstate='',$supplier='',$star_time='',$end_time=''){
		set_cookie('_currentUrl_', Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		$cr= get_where_club_project('supplier_id','');
		$cr.=' and f_check=2 and end_time>"'.date('Y-m-d H:i:s').'"';
		$cr = get_where($cr,!empty($state),' f_check',$state,'');
		$cr = get_where($cr,!empty($userstate),' if_user_state',$userstate,'');
		$cr = get_where($cr,!empty($type),' pricing_type',$type,'');
		$cr = get_like($cr,'event_code,event_title',$keywords,'');
		$cr = get_like($cr,'supplier_name',$supplier,'');
		$cr = get_where($cr,($star_time!=""),'star_time>=',$star_time,'"');
		$cr = get_where($cr,($end_time!=""),'end_time<=',$end_time,'"');
		$criteria->condition=$cr;
		// $criteria->order = '';
		$data = array();
		$data['base_code'] = BaseCode::model()->getReturn('2,1329');
		parent::_list($model, $criteria, 'index_frozen', $data);
	}
	
	public function actionCreate() {
		$modelName = $this->model;
		$model = new $modelName('create');
		$data = array();
		if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			$data['saletype'] =MallSaleName::model()->getSaleType();
			$data['product_list'] =array();
			$this->render('update', $data);
		} else {
			$this-> saveData($model,$_POST[$modelName]);
		}
    }
	
	public function actionCreate_supplier() {
		$modelName = $this->model;
		$model = new $modelName('create');
		$data = array();
		if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			$data['product_list'] =array();
			$this->render('update_supplier', $data);
		} else {
			$this-> saveData_supplier($model,$_POST[$modelName]);
		}
    }

    public function actionUpdate($id) {
		$modelName = $this->model;
		$model = $this->loadModel($id, $modelName);
		$data = array();
		if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			//$data['PriceInfo'] =MallMemberPriceInfo::model()->find('id='.$model->mall_member_price_id);
			$data['product_list'] =array();
			$data['product_list'] = MallPriceSetDetails::model()->findAll('set_id='.$model->id.' AND flash_sale=0');
			$data['saletype'] =MallSaleName::model()->getSaleType();
			$this->render('update', $data);
		} else {
			$this-> saveData($model,$_POST[$modelName]);
		}
	}
	
	public function actionUpdate_supplier($id) {
		$modelName = $this->model;
		$model = $this->loadModel($id, $modelName);
		$data = array();
		if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			$data['product_list'] =array();
			$data['product_list'] = MallPriceSetDetails::model()->findAll('set_id='.$model->id.' AND flash_sale=0');
			$this->render('update_supplier', $data);
		} else {
			$this-> saveData_supplier($model,$_POST[$modelName]);
		}
  	}
	
	public function actionUpdate_check($id) {
		$modelName = $this->model;
		$model = $this->loadModel($id, $modelName);
		$data = array();
		if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			$data['product_list'] =array();
			$data['product_list'] = MallPriceSetDetails::model()->findAll('set_id='.$model->id.' AND flash_sale=0');
			$this->render('update_check', $data);
		} else {
			$model->attributes =$_POST[$modelName];
			$msg=$model->reasons_for_failure;
			$state=get_check_code($_POST['submitType']);
			$adminID = get_session('admin_id');
		    $admin_nick = get_session('admin_name');
		    $now = date('Y-m-d H:i:s');
			$st=0;
			if(!empty($state)){
				MallPriceSet::model()->updateAll(array('f_check'=>$state,'reasons_adminID'=>$adminID,'reasons_admin_nick'=>$admin_nick,'reasons_for_failure'=>$msg,'reasons_time'=>$now),'id='.$model->id);
				MallPriceSetDetails::model()->updateAll(array('f_check'=>$state),'set_id='.$model->id);
		    	MallPricingDetails::model()->updateAll(array('f_check'=>$state),'set_id='.$model->id);
		    	$st++;
			}
			show_status($st,'已审核',$this->createUrl('mallPriceSet/index_check'),'审核失败');
		}
  	}
//供应商上架审核	
	public function actionUpdate_supplier_check($id) {
		$modelName = $this->model;
		$model = $this->loadModel($id, $modelName);
		$data = array();
		if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			$data['product_list'] =array();
			$data['product_list'] = MallPriceSetDetails::model()->findAll('set_id='.$model->id.' AND flash_sale=0');
			$this->render('update_supplier_check', $data);
		} else {
			$model->attributes =$_POST[$modelName];
			$msg=$model->reasons_for_failure;
			$state=get_check_code($_POST['submitType']);
			$adminID = get_session('admin_id');
		    $admin_nick = get_session('admin_name');
			$now=date('Y-m-d H:i:s');
			$st=0;
			if(!empty($state)){
				MallPriceSet::model()->updateAll(array('f_check'=>$state,'reasons_adminID'=>$adminID,'reasons_admin_nick'=>$admin_nick,'reasons_for_failure'=>$msg,'reasons_time'=>$now),'id='.$model->id);
				MallPriceSetDetails::model()->updateAll(array('f_check'=>$state),'set_id='.$model->id);
		    	MallPricingDetails::model()->updateAll(array('f_check'=>$state),'set_id='.$model->id);
		    	$st++;
			}
			show_status($st,'已审核',get_cookie('_currentUrl_'),'审核失败');
		}
  	}

  	public function actionUpdate_sale($id) {
		$modelName = $this->model;
		$model = $this->loadModel($id, $modelName);
		$data = array();
		if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			$data['product_list'] =array();
			$data['product_list'] = MallPriceSetDetails::model()->findAll('set_id='.$model->id.' AND flash_sale=0');
			$this->render('update_sale', $data);
		}
  	}
	

	function saveData($model,$post) {
		$model->attributes =$post;
		$model->pricing_type=361;
		$model->f_check =get_check_code($_POST['submitType']);
		if($_POST['submitType']=='shenhe') $model->apply_time=date('Y-m-d h:i:s');
		$sv=$model->save();
		MallPriceSetDetails::model()->updateAll(array('f_check'=>$model->f_check ),'set_id='.$model->id.' AND flash_sale=1');
		MallPricingDetails::model()->updateAll(array('f_check'=>$model->f_check ),'set_id='.$model->id.' AND flash_sale=1');
		$this->save_mall_price_set_details($model->id,$model->mall_member_price_id,$post['product']);
		if($_POST['submitType']=='shenhe'){
           $action=get_cookie('_currentUrl_');
           $s='提交成功';$f='提交失败';
        } else {
        	$action=$this->createUrl('update_supplier', array('id'=>$model->id));
        	$s='保存成功';$f='保存失败';
        }
        show_status($sv,$s, $action,$f);
	}
	
	function saveData_supplier($model,$post) {
		$model->attributes =$post;
		$model->pricing_type=361;
		$model->f_check =get_check_code($_POST['submitType']);
		if($_POST['submitType']=='shenhe') $model->apply_time=date('Y-m-d h:i:s');
		$sv=$model->save();
		if($model->f_check=='shenhe'){
           $action=get_cookie('_currentUrl_');
           $s='提交成功';$f='提交失败';
        } else {
        	$action=$this->createUrl('update_supplier', array('id'=>$model->id));
        	$s='保存成功';$f='保存失败';
        }
		MallPriceSetDetails::model()->updateAll(array('f_check'=>$model->f_check ),'set_id='.$model->id.' AND flash_sale=0');
		MallPricingDetails::model()->updateAll(array('f_check'=>$model->f_check ),'set_id='.$model->id.' AND flash_sale=0');
		$this->save_details_supplier($model->id,$post['product']);
        show_status($sv,$s, $action,$f);
	}
	
	 //////////////////////////////// 保存商品/////////////////// 
    public function save_mall_price_set_details($id,$price_id,$product){
		$model= MallPriceSet::model()->find('id='.$id);
		$product_detail=new MallPriceSetDetails();
		$product_detail->updateAll(array('sale_bean2'=>-1,'f_check'=>$model->f_check ),'set_id='.$id.' AND flash_sale=0');//做临时删除标识
		$pricing_detail = new MallPricingDetails();
		$pricing_detail->updateAll(array('no'=>-1 ,'f_check'=>$model->f_check),'set_id='.$id.' AND flash_sale=0');//做临时删除标识
		$arr=array();
		if (isset($_POST['product'])) { 
			$product_detail = new MallPriceSetDetails();
			$pricing_detail = new MallPricingDetails();
			foreach ($_POST['product'] as $v) {
				if($v['sale_id']=='' || $v['product_id']=='' || $v['id']==''){
                	continue;
            	}
				$pricedata= MallMemberPriceData::model()->findAll('infoid='.$price_id.' and sale_typeid='.$v['sale_id']);
				if ($v['id']=='null') {
					$product_detail->isNewRecord = true;
					unset($product_detail->id);
				} else{
					$product_detail=MallPriceSetDetails::model()->find('id='.$v['id']);
				}
				$purchase_price=0;
				$mcontract=MallContractPrice::model()->find('product_id='.$v['product_id'].' and f_check=2 and star_time>="'.$model->star_time.'" and end_time<="'.$model->end_time.'" order by id DESC');
				if(!empty($mcontract)){
					$purchase_price=$mcontract->purchase_price;
				}
				$product_detail->set_id = $id;
				$product_detail->product_id = $v['product_id'];
				$product_detail->sale_id = $v['sale_id'];
				$product_detail->Inventory_quantity = $v['Inventory_quantity'];
				$product_detail->purchase_price = $purchase_price;
				$product_detail->oem_price = $v['oem_price'];
				$product_detail->sale_price = $v['sale_price'];
				$product_detail->sale_bean = $v['sale_bean'];
				//$vp2=0;
				$product_detail->purpose=94;
				$product_detail->shop_purpose=94;
				$product_detail->star_time=$model->star_time;
				$product_detail->end_time=$model->end_time;
				$product_detail->down_time=$model->down_time;
				$product_detail->start_sale_time=$model->start_sale_time;
				$product_detail->supplier_id = $model->supplier_id;
				
				$product_detail->sale_bean2 = 0;//$v['sale_bean2'];
				$product_detail->post_price = $v['post_price'];
				$product_detail->up_price_id = $price_id;
				$product_detail->f_check = $model->f_check;
				$product_detail->save();
				if(!empty($pricedata)) 
				{
					foreach ($pricedata as $p) {
						$inventory=0;
						$show_id=0;
						$show_name='';
						if($p->sale_show_id==1132 || $p->sale_show_id==1134){
							$inventory=0;
						} else {
							$inventory=$v['Inventory_quantity'];
							//$available=$v['available_quantity'];
						}
						$ex="  product_id=".$v['product_id'].' and set_details_id='.$product_detail->id;
						$ex.=" and mall_memmber_price_id=".$p->id;
						$pricing_detail=MallPricingDetails::model()->find($ex);
						if (empty($pricing_detail)){
							$pricing_detail = new MallPricingDetails();
							$pricing_detail->isNewRecord = true;
							unset($pricing_detail->id);
						}
						if($p->sale_show_id<>1135){
							$show_id=$p->sale_show_id;
							$show_name=$p->sale_show_name;
						}
						$pricing_detail->set_id=$id;
						$pricing_detail->set_details_id=$product_detail->id;
						$pricing_detail->customer_type=$p->customer_type;
						$pricing_detail->no=0;
						$pricing_detail->flash_sale=0;
						$pricing_detail->product_id=$v['product_id'];
						$pricing_detail->customer_level_id=$p->sale_levela;
						$pricing_detail->level_code=$p->sale_levelcodea;
						$pricing_detail->shopping_beans=round(($p->sale_beana/100)*$v['sale_bean']);
						$pricing_detail->shopping_price=($p->sale_pricea/100)*$v['sale_price'];
						$pricing_detail->oem_price = $v['oem_price'];
						$pricing_detail->sale_price = $v['sale_price'];	
						$pricing_detail->sale_bean = $v['sale_bean'];	

						$pricing_detail->inventory_quantity=$inventory;	
						$pricing_detail->sale_show_id=$show_id;
						$pricing_detail->sale_show_name=$show_name;
						$pricing_detail->mall_memmber_price_id=$p->id;
						$pricing_detail->sale_max=$p->sale_counta;
						$pricing_detail->discount_price=$p->sale_pricea;
						$pricing_detail->discount_beans=$p->sale_beana;
						$pricing_detail->star_time=$product_detail->star_time;
						$pricing_detail->end_time=$product_detail->end_time;
						$pricing_detail->down_time=$product_detail->down_time;
						$pricing_detail->start_sale_time=$product_detail->start_sale_time;
						$pricing_detail->supplier_id = $model->supplier_id;
						$pricing_detail->f_check = $model->f_check;
						$pricing_detail->save();
					}
				}
			}
		} 
		MallPriceSetDetails::model()->deleteAll('set_id='.$id.' and sale_bean2=-1 AND flash_sale=0');
		MallPricingDetails::model()->deleteAll('set_id='.$id.' and no=-1 AND flash_sale=0');
  	}
	
	 //////////////////////////////// 供应商上架保存商品/////////////////// 
    public function save_details_supplier($id,$product){
		$model= MallPriceSet::model()->find('id='.$id);
		$level= ServicerLevel::model()->find('type=210 and card_xh=0 order by id ASC');
		$level_id=(!empty($level)) ? $level->id : 0;
		$product_detail=new MallPriceSetDetails();
		$product_detail->updateAll(array('sale_bean2'=>-1,'f_check'=>$model->f_check ),'set_id='.$id.' AND flash_sale=0');//做临时删除标识
		$pricing_detail = new MallPricingDetails();
		$pricing_detail->updateAll(array('no'=>-1 ,'f_check'=>$model->f_check),'set_id='.$id.' AND flash_sale=0');//做临时删除标识
		if (isset($_POST['product'])) { 
			$product_detail = new MallPriceSetDetails();
			$pricing_detail = new MallPricingDetails();
			foreach ($_POST['product'] as $v) {
				if ($v['id']=='null') {
					$product_detail->isNewRecord = true;
					unset($product_detail->id);
				} else{
					$product_detail=MallPriceSetDetails::model()->find('id='.$v['id']);
				}
				$purchase_price=0;
				$mcontract=MallContractPrice::model()->find('product_id='.$v['product_id'].' and f_check=2 and star_time>="'.$model->star_time.'" and end_time<="'.$model->end_time.'" order by id DESC');
				if(!empty($mcontract)){
					$purchase_price=$mcontract->purchase_price;
				}
				$product_detail->set_id = $id;
				$product_detail->product_id = $v['product_id'];
				$product_detail->sale_id =3;
				$product_detail->Inventory_quantity = $v['Inventory_quantity'];
				$product_detail->oem_price = $v['oem_price'];
				$product_detail->sale_price = $v['sale_price'];
				$product_detail->purchase_price = $purchase_price;
				$product_detail->purpose=94;
				$product_detail->shop_purpose=94;
				$product_detail->star_time=$model->star_time;
				$product_detail->end_time=$model->end_time;
				$product_detail->down_time=$model->down_time;
				$product_detail->start_sale_time=$model->start_sale_time;
				$product_detail->supplier_id = $model->supplier_id;
				$product_detail->sale_bean2 = 0;
				$product_detail->post_price = $v['post_price'];
				$product_detail->f_check = $model->f_check;
				$product_detail->save();
				if($product_detail->save()) 
				{
					$ex='set_details_id='.$product_detail->id;
					$pricing_detail=MallPricingDetails::model()->find($ex);
					if (empty($pricing_detail)){
						$pricing_detail = new MallPricingDetails();
						$pricing_detail->isNewRecord = true;
						unset($pricing_detail->id);
					}
					$pricing_detail->set_id=$id;
					$pricing_detail->set_details_id=$product_detail->id;
					$pricing_detail->customer_type=210;
					$pricing_detail->customer_level_id=$level_id;
					$pricing_detail->no=0;
					$pricing_detail->flash_sale=0;
					$pricing_detail->product_id=$v['product_id'];
					$pricing_detail->shopping_price=$v['sale_price'];
					$pricing_detail->oem_price = $v['oem_price'];
					$pricing_detail->sale_price = $v['sale_price'];

					$pricing_detail->inventory_quantity=$v['Inventory_quantity'];
					$pricing_detail->sale_show_id=1129;
					$pricing_detail->sale_show_name='普通销售';
					//$pricing_detail->sale_max= $v['sale_max'];
					$pricing_detail->discount_price=100;
					$pricing_detail->discount_beans=100;
					$pricing_detail->star_time=$product_detail->star_time;
					$pricing_detail->end_time=$product_detail->end_time;
					$pricing_detail->down_time=$product_detail->down_time;
					$pricing_detail->start_sale_time=$product_detail->start_sale_time;
					$pricing_detail->supplier_id = $model->supplier_id;
					$pricing_detail->f_check = $model->f_check;
					$pricing_detail->save();
				}
			}
		} 
		MallPriceSetDetails::model()->deleteAll('set_id='.$id.' and sale_bean2=-1 AND flash_sale=0');
		MallPricingDetails::model()->deleteAll('set_id='.$id.' and no=-1 AND flash_sale=0');
  	}

	//查看定价明细
	public function actionMemberprice($detail_id) {
        $data = array();
        $model = MallPricingDetails::model();
        $detail=MallPriceSetDetails::model()->find('id='.$detail_id);
        $criteria = new CDbCriteria;
        $criteria->condition = 'set_details_id='.$detail_id;
        $criteria->order = 'level_code ASC';
        $data['pricedata'] = MallMemberPriceData::model()->findAll('infoid='.$detail->up_price_id.' and sale_typeid='.$detail->sale_id);
        $data['member'] = ServicerLevel::model()->getMember();
        $data['dgmember'] = ServicerLevel::model()->getDgMember();
        $data['clublevel_free'] = ServicerLevel::model()->getClubLevel(453);
        $data['clublevel_pay'] = ServicerLevel::model()->getClubLevel(454);
        $data['detail'] = $detail;
        parent::_list($model, $criteria, 'memberprice', $data,23);
    }
	//限时抢购设置
	
	public function actionFlash_sale($id,$detail_id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['detail'] = MallPriceSetDetails::model()->find('id='.$detail_id);
		    $data['detail_o'] = MallPriceSetDetails::model()->findAll('flash_sale_id='.$detail_id.' AND flash_sale=1');
            $this->render('flash_sale', $data);
        } else {
			$this->save_mall_flash($model,$detail_id,$_POST);
        }
    }
	
	 //////////////////////////////// 保存限时抢购时段设置/////////////////// 
    public function save_mall_flash($model,$detail_id,$post){
		$model->attributes =$post;
		$model->f_check=721;
		$model->save();
		MallPriceSetDetails::model()->updateAll(array('sale_bean2'=>-1,'f_check'=>$model->f_check ),'set_id='.$model->id.' AND flash_sale=1');//做临时删除标识
		MallPricingDetails::model()->updateAll(array('no'=>-1 ,'f_check'=>$model->f_check),'set_id='.$model->id.' AND flash_sale=1');//做临时删除标识
		$detail=MallPriceSetDetails::model()->find('id='.$detail_id);  
		$arr=array();
		if (isset($_POST['flash_s'])) { 
			foreach ($_POST['flash_s'] as $v) {
				$pricedata= MallMemberPriceData::model()->findAll('infoid='.$detail->up_price_id.' and sale_typeid=6');
				if ($v['id']=='null') {
					$product_detail=new MallPriceSetDetails();
					$product_detail->isNewRecord = true;
					unset($product_detail->id);
				} else{
					$product_detail=MallPriceSetDetails::model()->find('id='.$v['id']);
					$arr[]=$v['id'];
				}
				$product_detail->set_id = $model->id;
				$product_detail->product_id = $detail->product_id;
				$product_detail->Inventory_quantity = $v['Inventory_quantity'];
				$product_detail->purchase_price = $detail->purchase_price;
				$product_detail->oem_price = $detail->oem_price;
				$product_detail->sale_price = $detail->sale_price;
				$product_detail->sale_bean = $detail->sale_bean;
				$vp2=0;
				$product_detail->purpose=95;
				$product_detail->shop_purpose=95;
				$product_detail->sale_price2 = $detail->sale_price2;
				$product_detail->sale_bean2 = 0;
				$product_detail->post_price = $detail->post_price;
				$product_detail->flash_sale = 1;
				$product_detail->flash_sale_id = $detail->id;
				$product_detail->up_price_id = $detail->up_price_id;
				$product_detail->up_gross_profit_id = $detail->up_gross_profit_id;
				$product_detail->supplier_id = $detail->supplier_id;
				$product_detail->star_time = $v['star_time'];
				$product_detail->end_time = $v['end_time'];
				$product_detail->start_sale_time = $v['start_sale_time'];
				$product_detail->down_time = $v['down_time'];
				$sv=$product_detail->save();
				if(!empty($pricedata)) 
				{
					foreach ($pricedata as $p) {
						$ex="  product_id=".$detail->product_id.' and set_details_id='.$product_detail->id;
						$ex.=" and customer_level_id=".$p->sale_levela.' AND flash_sale=1';
						$pricing_detail=MallPricingDetails::model()->find($ex);
						if (empty($pricing_detail)){
							$pricing_detail = new MallPricingDetails();
							$pricing_detail->isNewRecord = true;
							unset($pricing_detail->id);
						}
						$pricing_detail->set_id=$model->id;
						$pricing_detail->set_details_id=$product_detail->id;
						$pricing_detail->customer_type=$p->customer_type;
						$pricing_detail->mall_memmber_price_id=$p->id;
						$pricing_detail->no=0;
						$pricing_detail->flash_sale =1;
						$pricing_detail->product_id=$detail->product_id;
						$pricing_detail->customer_level_id=$p->sale_levela;
						$pricing_detail->level_code=$p->sale_levelcodea;
						$pricing_detail->shopping_beans=round(($p->sale_beana/100)*$detail->sale_bean);
						$pricing_detail->shopping_price=($p->sale_pricea/100)*$detail->sale_price;
						$pricing_detail->oem_price = $product_detail->oem_price;
						$pricing_detail->sale_price = $product_detail->sale_price;
						$pricing_detail->inventory_quantity=$product_detail->Inventory_quantity;
						$pricing_detail->star_time = $v['star_time'];
						$pricing_detail->end_time = $v['end_time'];
						$pricing_detail->start_sale_time = $v['start_sale_time'];
						$pricing_detail->down_time = $v['down_time'];
						$pricing_detail->sale_max=$p->sale_counta;
						$pricing_detail->discount_price=$p->sale_pricea;
						$pricing_detail->discount_beans=$p->sale_beana;
						$pricing_detail->sale_show_id=1135;
						$pricing_detail->supplier_id=$detail->supplier_id;
						$st=$pricing_detail->save();
					}
				}
			}
		}
		MallPriceSetDetails::model()->deleteAll('set_id='.$model->id.' and sale_bean2=-1 AND flash_sale=1');
		MallPricingDetails::model()->deleteAll('set_id='.$model->id.' and no=-1 AND flash_sale=1');
	    $modelName = $this->model;
        $model = $this->loadModel($detail->set_id, $modelName);
        $data = array();
        $data['model'] = $model;
        $data['detail'] = MallPriceSetDetails::model()->find('id='.$detail_id);
		$data['detail_o'] = MallPriceSetDetails::model()->findAll('flash_sale_id='.$detail_id.' AND flash_sale=1');
        $this->render('flash_sale', $data);
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
                MallPricingDetails::model()->updateAll(array('f_check'=>721),'set_id='.$d);
                $count++;
            
        }
        if ($count > 0) {
            ajax_status(1, '撤销成功');
        } else {
            ajax_status(0, '撤销失败');
        }
    }

    //下线处理
    public function actionDown($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
                $model->updateByPk($d,array('if_user_state'=>648));
                $count++;
            
        }
        
        if ($count > 0) {
            ajax_status(1, '下线成功');
        } else {
            ajax_status(0, '下线失败');
        }
    }
//上线处理
    public function actionOnline($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
                $model->updateByPk($d,array('if_user_state'=>649));
                $count++;
            
        }
        
        if ($count > 0) {
            ajax_status(1, '上线成功');
        } else {
            ajax_status(0, '上线失败');
        }
    }
	//删除
 	public function actionDelete($id) {
		$modelName = $this->model;
		$model = $modelName::model();
		$club=explode(',', $id);
		$count=$model->deleteAll('id in('.$id.')');
		if(!empty($count)) {
			foreach ($club as $d) {
				MallPriceSetDetails::model()->deleteAll('set_id='.$d);
				MallPricingDetails::model()->deleteAll('set_id ='.$d);
			}
			ajax_status(1, '删除成功');
		} else {
			ajax_status(0, '删除失败');
		}
	}
	
	public function actionRefresh($id){
		$modelName = $this->model;
		$model = $this->loadModel($id,$modelName);
		$model->data_sourcer_bz = $model->data_sourcer_bz+1;
		$sv=$model->save();
		show_status($sv,'刷新成功',Yii::app()->request->urlReferrer,'刷新失败');
	}
}
