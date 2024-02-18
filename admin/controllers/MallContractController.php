<?php

class MallContractController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
	
	public function actionIndex($keywords = '',$state='',$supplier='',$star_time='',$end_time='') {
		set_cookie('_currentUrl_', Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		$criteria->condition=get_where_club_project('supplier_id','');
		$criteria->condition=get_where($criteria->condition,!empty($state),' f_check',$state,'');
		$criteria->condition=get_like($criteria->condition,'c_code,c_no,c_title',$keywords,'');
		$criteria->condition=get_where($criteria->condition,!empty($supplier),'supplier_id',$supplier,'');
		$criteria->condition=get_where($criteria->condition,($star_time!=""),'star_time>=',$star_time,'"');
		$criteria->condition=get_where($criteria->condition,($end_time!=""),'end_time<=',$end_time,'"');
		$criteria->order = 'id DESC';
		$data = array();
		$data['base_code'] = BaseCode::model()->getStateType();
		$data['supplier'] = ClubList::model()->getCode(380);
		parent::_list($model, $criteria, 'index', $data);
    }
//审核列表
    public function actionIndex_check($keywords = '',$supplier='',$star_time='',$end_time='',$pricing='') {
		set_cookie('_currentUrl_', Yii::app()->request->url);
		$modelName = $this->model;
		$model = $modelName::model();
		$criteria = new CDbCriteria;
		$criteria->condition= 'f_check=371';
		$criteria->condition=get_like($criteria->condition,'c_code,c_no,c_title',$keywords,'');
		$criteria->condition=get_where($criteria->condition,!empty($supplier),'supplier_id',$supplier,'');
		$criteria->condition=get_where($criteria->condition,($star_time!=""),'star_time>=',$star_time,'"');
		$criteria->condition=get_where($criteria->condition,($end_time!=""),'end_time<=',$end_time,'"');
		$criteria->order = 'id DESC';
		$data = array();
		$data['supplier'] = ClubList::model()->getCode(380);
		parent::_list($model, $criteria, 'index_check', $data);
    }

	public function actionCreate() {
		$modelName = $this->model;
		$model = new $modelName('create');
		$data = array();
		if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			$data['product_list'] =array();
			$this->render('update', $data);
		} else {
			$this-> saveData($model,$_POST[$modelName]);
		}
    }
	

    public function actionUpdate($id) {
		set_cookie('_updatecurrent_', Yii::app()->request->url);
		$modelName = $this->model;
		$model = $this->loadModel($id, $modelName);
		$data = array();
		if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			$data['product_list'] =array();
			$data['product_list'] = MallContractPrice::model()->findAll('set_id='.$model->id);
			$this->render('update', $data);
		} else {
			$this-> saveData($model,$_POST[$modelName]);
		}
  	}

  	public function actionUpdate_check($id) {
		$modelName = $this->model;
		$model = $this->loadModel($id, $modelName);
		$data = array();
		if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			$data['product_list'] =array();
			$data['product_list'] = MallContractPrice::model()->findAll('set_id='.$model->id);
			$this->render('update_check', $data);
		} else {
			$model->attributes =$_POST[$modelName];
			//$model->f_check =get_check_code($_POST['submitType']);
			$state=get_check_code($_POST['submitType']);
			$st=0;
			if(!empty($state)){
				MallContract::model()->updateAll(array('f_check'=>$state),'id='.$model->id);
				MallContractPrice::model()->updateAll(array('f_check'=>$model->f_check ),'set_id='.$model->id);
		    	$st++;
			}
			
			show_status($st,'已审核',$this->createUrl('mallContract/index_check'),'审核失败');
		}
  	}


	function saveData($model,$post) {
		$model->attributes =$post;
		$model->f_check =get_check_code($_POST['submitType']);
		$sv=$model->save();
		$this->save_purchase_price($model->id,$post['product']);
		$action=$this->createUrl('update', array('id'=>$model->id));
		show_status($sv,'保存成功', $action,'保存失败'); 
	}
	
	 //////////////////////////////// 保存商品/////////////////// 
    public function save_purchase_price($id,$product){
		$model= MallContract::model()->find('id='.$id);
		$product_detail=new MallContractPrice();
		$product_detail->updateAll(array('no'=>-1,'f_check'=>$model->f_check ),'set_id='.$id);//做临时删除标识
		if (isset($_POST['product'])) { 
			$product_detail = new MallContractPrice();
			foreach ($_POST['product'] as $v) {
				if ($v['id']=='null') {
					$product_detail->isNewRecord = true;
					unset($product_detail->id);
				} else{
					$product_detail=MallContractPrice::model()->find('id='.$v['id']);
				}
				
				$product_detail->set_id = $id;
				$product_detail->product_id = $v['product_id'];
				$product_detail->purchase_price = $v['purchase_price'];
				$product_detail->purchase_quantity = $v['purchase_quantity'];
				//$product_detail->up_quantity = $v['up_quantity'];
				$product_detail->star_time=$model->star_time;
				$product_detail->end_time=$model->end_time;
				$product_detail->supplier_id = $model->supplier_id;
				$product_detail->f_check = $model->f_check;
				$product_detail->no=0;
				$product_detail->save();
				
			}
		} 
		MallContractPrice::model()->deleteAll('set_id='.$id.' and no=-1');
  	}

	
	//删除
 	public function actionDelete($id) {
		$modelName = $this->model;
		$model = $modelName::model();
		$club=explode(',', $id);
		$count=$model->deleteAll('id in('.$id.')');
		if(!empty($count)) {
			foreach ($club as $d) {
				MallContractPrice::model()->deleteAll('set_id='.$d);
			}
			ajax_status(1, '删除成功');
		} else {
			ajax_status(0, '删除失败');
		}
	}

}
