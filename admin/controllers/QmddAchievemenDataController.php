<?php

class QmddAchievemenDataController extends BaseController {
    
    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
    // 动动约评价
    public function actionIndex($keywords = '',$order_type = '') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition='club_id='.get_session('club_id').' and order_type=353';
        // $criteria->condition='order_type=353';
        // $criteria->order='service_order_num';
        $criteria->condition = get_like($criteria->condition,'service_order_num,gf_zsxm,service_name',$keywords,'');
        // $criteria->condition=get_where($criteria->condition,!empty($order_type),'order_type',$order_type,'');
        // $criteria->select='';
        $criteria->group='gf_service_data_id';
        $data = array();
        // $data['order_type_list']=BaseCode::model()->getOrderType();
        parent::_list($model, $criteria,'index', $data);
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            if(isset($model->gf_service_data_id)){
                $data['eval_list'] = QmddAchievemenData::model()->findAll('gf_service_data_id='.$model->gf_service_data_id);
            }
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    // 赛事评价
    public function actionGame_index($keywords = '',$order_type = '') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition='club_id='.get_session('club_id').' and order_type=351';
        $criteria->condition='order_type=351';
        // $criteria->order='service_order_num';
        $criteria->condition = get_like($criteria->condition,'service_order_num,gf_zsxm,service_name',$keywords,'');
        $criteria->group='gf_service_data_id';
        $data = array();
        // $data['order_type_list']=BaseCode::model()->getOrderType();
        parent::_list($model, $criteria,'game_index', $data);
    }
    // 赛事评价详情
    public function actionGame_update($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            if(isset($model->gf_service_data_id)){
                $data['eval_list'] = QmddAchievemenData::model()->findAll('gf_service_data_id='.$model->gf_service_data_id);
            }
            $this->render('game_update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    //供应商-商品评价
    public function actionProduct_index($keywords = '',$start='',$end='') {
        $this->ShowViewProduct($keywords,$start,$end,' and club_id='.get_session('club_id'),'product_index');
    }
    //平台-商品评价
    public function actionProduct_gf_index($keywords = '',$start='',$end='') {
        $this->ShowViewProduct($keywords,$start,$end,'','product_gf_index');
    }
    public function ShowViewProduct($keywords='',$start='',$end='',$club,$viewfile) {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        if ($start=='') $start=$now;
        $criteria = new CDbCriteria;
        $cr='order_type=361';
        $cr.=$club;
        $cr=get_where($cr,($start!=""),'evaluate_time>=',$start.' 00:00:00','"');
        $cr=get_where($cr,($end!=""),'evaluate_time<=',$end.' 23:59:59','"');
        $cr= get_like($cr,'order_num,gf_zsxm,service_name',$keywords,'');
        $criteria->condition=$cr;
        $criteria->group='order_num_id';
        $criteria->order = 'f_id DESC';
        $data = array();
        $data['start'] = $start;
        $data['end'] = $end;
        parent::_list($model, $criteria, $viewfile, $data);
    }
    // 供应商-商品评价详情
    public function actionproduct_update($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            if(isset($model->order_num)){
                $data['eval_list'] = QmddAchievemenData::model()->findAll('order_num="'.$model->order_num.'" and product_id='.$model->product_id);
            }
            $data['o_type']= QmddAchievemen::model()->findAll('f_type=361');
            $this->render('product_update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
    // 平台-商品评价详情
    public function actionproduct_gf_update($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            if(isset($model->order_num)){
                $data['eval_list'] = QmddAchievemenData::model()->findAll('order_num="'.$model->order_num.'" and product_id='.$model->product_id);
            }
            $data['o_type']= QmddAchievemen::model()->findAll('f_type=361');
            $this->render('product_gf_update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    function saveData($model,$post) {
        $model->attributes = $post;
        $now=date('Y-m-d H:i:s');
        //$model->club_evaluate_time=$now;
        $sv=0;
        //$sv=$model->save();
        if($model){
            QmddAchievemenData::model()->updateAll(array(
                'club_evaluate_info'=>$model->club_evaluate_info,
                'is_dispay'=>$model->is_dispay,
                'club_f_mark'=>$model->club_f_mark,
                'club_evaluate_time'=>$now
            ),'order_num_id='.$model->order_num_id);
            $sv++;
            /*
            if(!empty($sin)){
                $sin->club_evaluate_info=$model->club_evaluate_info;
                $sin->club_evaluate_time=date('Y-m-d H:i:s');
                $sin->is_dispay=$model->is_dispay;
                $sin->club_f_mark=$model->club_f_mark;
                $sin->save();
            }
            */
        }
        show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }

    public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $order_num_id = QmddAchievemenData::model()->find('f_id='.$id);
        $count = $model->deleteAll('order_num_id in (' . $order_num_id->order_num_id . ')');
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }
}