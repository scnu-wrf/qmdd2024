<?php

class GfCreditHistoryController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($object='',$time_start='',$time_end='',  $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state=2 and t.object=502 and gf_id='.get_session('club_id');
        // $time_start=empty($time_start) ? date("Y-m-d") : $time_start;
        // $time_end=empty($time_end) ? date("Y-m-d") : $time_end;
        if ($time_start != '') {
            $criteria->condition.=' AND left(exchange_time,10)>="'.$time_start.'"';
        }
        if ($time_end != '') {
            $criteria->condition.=' AND left(exchange_time,10)<="'.$time_end.'"';
        }
		$criteria->join = "JOIN gf_credit t2 on t.item_code=t2.id";
        $criteria->condition=get_where($criteria->condition,!empty($object),'t2.object',$object,''); 
        $criteria->condition=get_like($criteria->condition,'account,nickname',$keywords,'');
        $criteria->order = 'exchange_time DESC';
        $data = array();
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        $data['object'] = BaseCode::model()->getReturn('734,735,1476,1477');
        parent::_list($model, $criteria, 'index', $data);
    }
	
	public function actionExchange() {
		
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('exchange', $data);
        } else {
            $model->attributes = $_POST[$modelName];
            $model->add_time = date('Y-m-d h:i:s');
            $model->exchange_time = date('Y-m-d h:i:s');
            if ($model->save()) {
                ajax_status(1, '兑换成功');
            } else {
                ajax_status(0, '兑换失败');
            }
        }
       // parent::_create($model, 'exchange', $data);              
    }

    public function actionIndex_confirmed($keywords = '',$time_start='',$time_end='',$state='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        if($state==''){
            $state=2;
            $time_start=empty($time_start) ? date("Y-m-d") : $time_start;
            $time_end=empty($time_end) ? date("Y-m-d") : $time_end;
        }
		$criteria->join = "JOIN gf_credit t2 on t.item_code=t2.id";
        $criteria->condition = 't2.object=1476 and state='.$state;
        if ($time_start != '') {
            $criteria->condition.=' AND left(exchange_time,10)>="'.$time_start.'"';
        }
        if ($time_end != '') {
            $criteria->condition.=' AND left(exchange_time,10)<="'.$time_end.'"';
        }
        $criteria->condition=get_like($criteria->condition,'account,nickname',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        $count1 = new CDbCriteria;
		$count1->join = $criteria->join;
        $count1->condition = 't2.object=1476 and state=371';
        $data['count1'] = $model->count($count1);
        parent::_list($model, $criteria, 'index_confirmed', $data);
    }
    
    public function actionIndex_serve_confirmed($keywords = '',$time_start='',$time_end='',$state='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        if($state==''){
            $state=2;
            $time_start=empty($time_start) ? date("Y-m-d") : $time_start;
            $time_end=empty($time_end) ? date("Y-m-d") : $time_end;
        }
		$criteria->join = "JOIN gf_credit on t.item_code=gf_credit.id";
		$criteria->condition = 'gf_credit.object=1477 and state='.$state;
        if ($time_start != '') {
            $criteria->condition.=' AND left(exchange_time,10)>="'.$time_start.'"';
        }
        if ($time_end != '') {
            $criteria->condition.=' AND left(exchange_time,10)<="'.$time_end.'"';
        }
        $criteria->condition=get_like($criteria->condition,'account,nickname',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        $count1 = new CDbCriteria;
		$count1->join = $criteria->join;
        $count1->condition = 'gf_credit.object=1477 and state=371';
        $data['count1'] = $model->count($count1);
        parent::_list($model, $criteria, 'index_serve_confirmed', $data);
    }


    /**
     * 确认
     */
    public function actionConfirmed($id) {
        $modelName = $this->model;
        $n = explode(',',$id);
        $sn=0;
        foreach($n as $v){
            $model = $this->loadModel($v,$modelName);
            // if($model->state==2) {
            //     $sf=0;
            //     continue;
            // }
            $model->state = 2;
            $model->exchange_time = date('Y-m-d H:i:s');
            $model->admin_id = get_session('admin_id');
            $sn=$model->save();
        }
        show_status($sn,'已确认',Yii::app()->request->urlReferrer,'操作失败');
    }

    public function actionIndex_credit_detail($object='',$keywords = '',$time_start='',$time_end='',$gf_id='',$object2='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'state=2';
		$criteria->join = "JOIN gf_credit on t.item_code=gf_credit.id";
        $criteria->condition=get_where($criteria->condition,!empty($object),'gf_credit.object',$object,''); 
        if($gf_id==''&&$object2==''){
            $time_start=empty($time_start) ? date("Y-m-d") : $time_start;
            $time_end=empty($time_end) ? date("Y-m-d") : $time_end;
        }else{
            $criteria->condition.=' and t.object='.$object2.' and gf_id='.$gf_id;
        }
        if ($time_start != '') {
            $criteria->condition.=' AND left(exchange_time,10)>="'.$time_start.'"';
        }
        if ($time_end != '') {
            $criteria->condition.=' AND left(exchange_time,10)<="'.$time_end.'"';
        }
        $criteria->condition=get_like($criteria->condition,'account,nickname',$keywords,'');
        $criteria->order = 'exchange_time DESC';
        $data = array();
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        $data['object'] = BaseCode::model()->getReturn('734,735,1476,1477');
        parent::_list($model, $criteria, 'index_credit_detail',$data);
    }
}
