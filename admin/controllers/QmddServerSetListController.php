<?php

class QmddServerSetListController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
    ///列表搜索
     public function actionIndex($shopping_type = '', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->condition=get_where_club_project('club_id','');// AND supplier_id='.get_session('club_id');
        $tmp_id=0;
        if (!empty($keywords)){
            $tmp=MallPriceSet::model()->find("event_code='".$keywords."'");
            if (!empty($tmp)){
              $tmp_id=1;
              $criteria->condition=' set_id='.$tmp->id;
            }
        }
        if($tmp_id==0){
	    	$criteria->condition=get_like($criteria->condition,'s_code,s_name',$keywords,'');
        }
	    $criteria->order = 's_code';
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }
    
    
	public function actionLog($detail_id) {
        $model = MallSalesOrderData::model();
        $criteria = new CDbCriteria;
		//$criteria->together = array('mall_shopping_car_copy');
        $criteria->condition= 'qmdd_server_set_list_id='.$detail_id.' and order_type=353';
        $criteria->order = 'id ASC';
        $data = array();
		$bd_amount=0;
		$data['detail']=QmddServerSetList::model()->find('id='.$detail_id);
		$data['b_count']=MallSalesOrderData::model()->count('qmdd_server_set_list_id='.$detail_id.' and order_type=353 and change_type=0');
		$b_data=MallSalesOrderData::model()->findAll('qmdd_server_set_list_id='.$detail_id.' and order_type=353 and change_type=0');
		if(!empty($b_data)) foreach($b_data as $b){
			$bd_amount=$bd_amount+$b->buy_amount;
		}
		$data['s_amount']=$bd_amount;
		$data['r_count']=MallSalesOrderData::model()->count('qmdd_server_set_list_id='.$detail_id.' and order_type=353 and change_type=1137');
        parent::_list($model, $criteria, 'log', $data,20);
    } 
	
	public function actionQuantity($detail_id) {
        $modelName = $this->model;
        $model = $this->loadModel($detail_id, $modelName);	
        $orderdata=MallSalesOrderData::model()->find('set_detail_id='.$detail_id);
		if(!empty($orderdata)) {
			$orderdata->order_no=$orderdata->order_no+1;
			$st=$orderdata->save();
		} else {
			$model->available_quantity=0;
			$st=$model->save();
			MallPricingDetails::model()->updateAll(array('available_quantity'=>0 ),'set_detail_id='.$detail_id);
		}
		ajax_status(1, '刷新成功');
	
    } 
    ///已发布列表
     public function actionIndex_list($keywords ='',$star='',$end='',$project=0,$stype='',$userstate='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        $now_m=date("Y-m-d",strtotime("-1 months",strtotime($now)));
        //if ($star=='') $star=$now_m;
        $criteria = new CDbCriteria;
        $criteria->join= "JOIN qmdd_server_set_info on t.info_id=qmdd_server_set_info.id";
        $criteria->join.= " JOIN qmdd_server_set_data on t.id=qmdd_server_set_data.list_id";
        $cr='t.f_check=2';
        $cr.=' and t.club_id='.get_session('club_id');
        if ($project>0) $cr.=' and find_in_set('.$project.',t.project_ids)';
        $cr=get_where($cr,$stype,' t.t_stypeid',$stype,'');
        $cr=get_where($cr,$userstate,' qmdd_server_set_info.if_user_state',$userstate,'');
        $cr=get_where($cr,$star,'qmdd_server_set_data.s_timestar>=',$star.' 00:00:00','"');
        $cr=get_where($cr,$end,'qmdd_server_set_data.s_timeend<=',$end.' 23:59:59','"');
        $cr=get_like($cr,'qmdd_server_set_info.set_code,t.s_name,t.s_code',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 't.id DESC';
        $criteria->group = 't.id';
        $data = array();
        $data['star'] =$star;
        $data['end'] =$end;
        $data['project'] = ClubProject::model()->getProject(get_session('club_id'));
        $data['stype'] = QmddServerUsertype::model()->getServerusertype();
        $data['userstate'] = BaseCode::model()->getCode(647);
        parent::_list($model, $criteria, 'index_list', $data);
    } 
    ///各单位已发布服务查询
    public function actionIndex_search($keywords = '',$star='',$end='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        $now_m=date("Y-m-d",strtotime("-1 months",strtotime($now)));
        if ($star=='') $star=$now_m;
        $criteria = new CDbCriteria;
        $criteria->join= "JOIN qmdd_server_set_info on t.info_id=qmdd_server_set_info.id";
        $cr='t.f_check=2';
        //$cr.=' and t.club_id='.get_session('club_id');
        $cr.=' and t.server_end>="'.$now.'"';
        $cr=get_where($cr,$star,'qmdd_server_set_info.reasons_time>=',$star.' 00:00:00','"');
        $cr=get_where($cr,$end,'qmdd_server_set_info.reasons_time<=',$end.' 23:59:59','"');
        $cr=get_like($cr,'qmdd_server_set_info.set_code,t.s_name,t.s_code',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 't.id DESC';
        $data = array();
        $data['star'] =$star;
        $data['end'] =$end;
        
        parent::_list($model, $criteria, 'index_search', $data);
    }  
    ///各单位历史服务发布列表
    public function actionIndex_log($keywords = '',$star='',$end='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        $now_m=date("Y-m-d",strtotime("-1 months",strtotime($now)));
        if ($star=='') $star=$now_m;
        $criteria = new CDbCriteria;
        $criteria->join= "JOIN qmdd_server_set_info on t.info_id=qmdd_server_set_info.id";
        $cr='t.f_check=2';
        $cr.=' and t.club_id='.get_session('club_id');
        $cr.=' and t.server_end<"'.$now.'" and qmdd_server_set_info.end_time<"'.$now.'"';
        $cr=get_where($cr,$star,'qmdd_server_set_info.reasons_time>=',$star.' 00:00:00','"');
        $cr=get_where($cr,$end,'qmdd_server_set_info.reasons_time<=',$end.' 23:59:59','"');
        $cr=get_like($cr,'qmdd_server_set_info.set_code,t.s_name,t.s_code',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 't.id DESC';
        $data = array();
        $data['star'] =$star;
        $data['end'] =$end;
        parent::_list($model, $criteria, 'index_log', $data);
    }          

    public function actionGetList(){
        $modelName = $this->model;
        //$s1="name:s_name,price:sale_price,place:club_name,distance:info_id";
        $s1="s_name:name,sale_price:price,club_name:place,info_id:distance";
       put_msg('line 151'.$s1);
        $tmp1 = $modelName::model()->findAll("s_gfid<=8");
        $tmp2 = $modelName::model()->findAll();//"s_gfid<=8"
        $data1=toIoArray($tmp1,$s1);
        $data2=toIoArray($tmp2,$s1);
        $data=array('dataa'=>$data1,'datab'=>$data2);
        echo CJSON::encode($data);
    }

}

 

