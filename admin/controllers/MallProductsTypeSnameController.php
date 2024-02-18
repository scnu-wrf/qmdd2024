<?php

class MallProductsTypeSnameController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($keywords = '',$code='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->condition = '1';
		$criteria->condition=get_like($criteria->condition,'sn_name',$keywords,'');
		if($code!='') {
			$criteria->condition.=' AND tn_code like "'.$code.'%"';
		}
        $criteria->order = 'tn_code ASC';
	    parent::_list($model, $criteria, 'index');
    }
	
	public function actionIndex1($keywords = '',$pid='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		//$criteria->with = array('mall_products_type_project');
        $criteria->condition = 'fater_id=' . $pid;
		$criteria->condition=get_like($criteria->condition,'t_code,sn_name',$keywords,'');
        $criteria->order = 'id DESC';
        parent::_list($model, $criteria, 'index1');
    }
	
	
	
	 public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
			$data['project_list']=array();
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
			$data['project_list'] = MallProductsTypeProject::model()->findAll('type_id='.$model->id);
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
	
	function saveData($model,$post) {
       $model->attributes =$post;
       $sv=$model->save();  
	   $model->updateAll(array('if_examine'=>$model->if_examine,'examine_time'=>$model->examine_time,'if_reduce_inventory'=>$model->if_reduce_inventory,'long_pay_time'=>$model->long_pay_time,'is_post'=>$model->is_post,'sign_long_cycle'=>$model->sign_long_cycle,'if_apply_return'=>$model->if_apply_return,'return_cycle'=>$model->return_cycle,'if_invoice'=>$model->if_invoice,'invoice_cycle'=>$model->invoice_cycle),'tn_code like "'.$model->tn_code.'%"');
	   $this->save_project_list($model->tn_code,$post['project_list']);
       show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败'); 
 }
  
  public  function save_project_list($type_code,$project_list){   	     
    if(!empty($project_list)){
        $model2 = new MallProductsTypeProject();
        $club_list_pic = array();
        $club_list_pic = explode(',', $project_list);
        $club_list_pic = array_unique($club_list_pic);
		$mptype=MallProductsTypeSname::model()->findAll('tn_code like "'.$type_code.'%"');  
		if(!empty($mptype)) foreach ($mptype as $t) {
			//删除原有项目
    		MallProductsTypeProject::model()->deleteAll('type_id='.$t->id); 
			foreach ($club_list_pic as $v) {
				$model2->isNewRecord = true;
				unset($model2->id);
				$model2->type_id =$t->id;
				$model2->project_id = $v;
				$model2->save();
			}
		}
    }
  }
 
	public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $count = $model->deleteAll('id in(' . $id . ')');
        if ($count > 0) {
            MallProductsTypeProject::model()->deleteAll('type_id in(' . $id . ')');
			// $model->deleteAll('fater_id in(' . $id . ')');
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }
	
}
