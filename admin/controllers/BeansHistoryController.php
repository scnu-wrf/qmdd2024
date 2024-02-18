<?php

class BeansHistoryController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($object='',$start_date = '', $end_date = '', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'user_state=506 and state=2 and got_beans_clubid='.get_session('club_id');
        // $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
        // $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
		if ($start_date != '') {
            $criteria->condition.=' AND uDate>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' AND uDate<="' . $end_date . '"';
        }
        $criteria->condition=get_where($criteria->condition,!empty($object),'object',$object,''); 
		$criteria->condition=get_like($criteria->condition,'got_beans_code,got_beans_name',$keywords,'');		
        $criteria->order = 'uDate DESC';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['object'] = BaseCode::model()->getReturn('734,1480,1481,1482');
        parent::_list($model, $criteria, 'index', $data);
    }

    // 体育豆积分列表
    public function actionIndex_list($start_time='',$end_time='',$min_credit='', $max_credit='', $min_beans='', $max_beans='', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $club_model = ClubList::model();
        $user_model = userlist::model();
        $club_criteria = new CDbCriteria;	
        $user_criteria = new CDbCriteria;
        $club_criteria->select='t.id,t.club_code,t.club_name,t.beans,t.club_credit,t.cb_uDate';
        $user_criteria->select='t.GF_ID,t.GF_ACCOUNT,t.GF_NAME,t.beans,t.CREDIT,t.cb_uDate';
        $start_time=empty($start_time) ? date("Y-m-d") : $start_time;
        $end_time=empty($end_time) ? date("Y-m-d") : $end_time;
		$club_criteria->condition = 't.t.unit_state=648 and if(t.club_type in(8,189,380),t.state=2 and t.edit_state=2,t.state=2) and (t.beans>0 or t.club_credit>0)';	
        $user_criteria->condition = 't.t.passed=2 and (t.beans>0 or t.CREDIT>0)';	
        
        $club_criteria->condition .=' and left(t.cb_uDate,10)>="'.$start_time.'"';
        $user_criteria->condition .=' and left(t.cb_uDate,10)>="'.$start_time.'"';
        $club_criteria->condition .=' and left(t.cb_uDate,10)<="'.$end_time.'"';
        $user_criteria->condition .=' and left(t.cb_uDate,10)<="'.$end_time.'"';

		if ($min_credit != '') {
            $club_criteria->condition.=' AND t.club_credit>="' . $min_credit . '"';
            $user_criteria->condition.=' AND t.CREDIT>="' . $min_credit . '"';
        }
        if ($max_credit != '') {
            $club_criteria->condition.=' AND t.club_credit<="' . $max_credit . '"';
            $user_criteria->condition.=' AND t.CREDIT<="' . $max_credit . '"';
        }
		if ($min_beans != '') {
            $club_criteria->condition.=' AND t.beans>="' . $min_beans . '"';
            $user_criteria->condition.=' AND t.beans>="' . $min_beans . '"';
        }
        if ($max_beans != '') {
            $club_criteria->condition.=' AND t.beans<="' . $max_beans . '"';
            $user_criteria->condition.=' AND t.beans<="' . $max_beans . '"';
        }
		$club_criteria->condition=get_like($club_criteria->condition,'t.club_code,t.club_name',$keywords,'');
		$club_criteria->condition=get_like($club_criteria->condition,'t.GF_ACCOUNT,t.GF_NAME',$keywords,'');
        $clist = $club_model->findAll($club_criteria);
        $ulist = $user_model->findAll($user_criteria);

        $arclist=array_merge($clist,$ulist);
        if(!empty($arclist))foreach($arclist as $arr2){
            $flag[]=$arr2["cb_uDate"];
        }
        if(!empty($arclist)){
            array_multisort($flag, SORT_ASC, $arclist);
        }

        $data = array();
        $data['start_time'] = $start_time;
        $data['end_time'] = $end_time;
        
        $count = count($arclist);
        $pages = new CPagination($count);
        $pages->pageSize = 15;

        $arclist=$this->delByValue($arclist,$pages->getCurrentPage(),$pages->getPageSize());
        $data = array_merge($data, array('model' => $model, 'arclist' => $arclist, 'pages' => $pages, 'count'=>$count));
        $this->render('index_list', $data);
    }

    public function delByValue($arr, $page, $pageSize){
        foreach($arr as $k=>$v){
            if($k<((($page+1)*$pageSize)-$pageSize)||($k+1)>(($page+1)*$pageSize)){
                unset($arr[$k]);
            }
        }
        $arclist=$arr;
        return $arclist;
    }

    public function actionIndex_tyd_confirmed($keywords = '',$time_start='',$time_end='',$state='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 't.got_beans_reson=734 and t.state=2';
        if($state==''){
            $criteria->condition .= ' and !isnull(t.exchange_time)';
        }else{
            $criteria->condition .= ' and isnull(t.exchange_time)';
        }
        if($state==''){
            $time_start=empty($time_start) ? date("Y-m-d") : $time_start;
            $time_end=empty($time_end) ? date("Y-m-d") : $time_end;
        }
        if ($time_start != '') {
            $criteria->condition.=' AND left(t.exchange_time,10)>="'.$time_start.'"';
        }
        if ($time_end != '') {
            $criteria->condition.=' AND left(t.exchange_time,10)<="'.$time_end.'"';
        }
		$criteria->condition=get_like($criteria->condition,'got_beans_code,got_beans_name',$keywords,'');
        $criteria->order = 't.uDate DESC';
        $data = array();
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        $data['count1'] = $model->count('got_beans_reson=734 and state=2 and isnull(exchange_time)');
        parent::_list($model, $criteria, 'index_tyd_confirmed', $data);
    }

    /**
     * 确认
     */
    public function actionConfirmed($id,$al) {
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
        $alter='';
        if(!empty($al)&&$al=='tongguo'){
            $alter='已审核';
        }
        show_status($sn,$alter,Yii::app()->request->urlReferrer,'操作失败');
    }

    public function actionIndex_return( $keywords = '',$time_start='',$time_end='',$state='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'object=1481 and user_state=506';
        if($state==''){
            $criteria->condition .= ' and state in(2,373)';
            $time_start=empty($time_start) ? date("Y-m-d") : $time_start;
            $time_end=empty($time_end) ? date("Y-m-d") : $time_end;
        }elseif($state==371){
            $criteria->condition .= ' and state in(371)';
        }
        if ($time_start != '') {
            $criteria->condition.=' AND left(t.exchange_time,10)>="'.$time_start.'"';
        }
        if ($time_end != '') {
            $criteria->condition.=' AND left(t.exchange_time,10)<="'.$time_end.'"';
        }
		$criteria->condition=get_like($criteria->condition,'got_beans_code,got_beans_name',$keywords,'');
        $criteria->order = 'exchange_time DESC';
        $data = array();
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        $data['count1'] = $model->count('object=1481 and state=371 and isnull(exchange_time)');
        parent::_list($model, $criteria, 'index_return',$data);
    }

    public function actionIndex_beans_detail( $object='',$keywords = '',$time_start='',$time_end='',$member_id='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'user_state=506 and state=2';
        $criteria->condition=get_where($criteria->condition,!empty($object),' object',$object,''); 
        if($member_id==''){
            $time_start=empty($time_start) ? date("Y-m-d") : $time_start;
            $time_end=empty($time_end) ? date("Y-m-d") : $time_end;
        }else{
            $criteria->condition.=' and if(isnull(got_beans_clubid),got_beans_gfid='.$member_id.',got_beans_clubid='.$member_id.')';
        }
        if ($time_start != '') {
            $criteria->condition.=' AND left(uDate,10)>="'.$time_start.'"';
        }
        if ($time_end != '') {
            $criteria->condition.=' AND left(uDate,10)<="'.$time_end.'"';
        }
		$criteria->condition=get_like($criteria->condition,'got_beans_code,got_beans_name',$keywords,'');
        $criteria->order = 'uDate DESC';
        $data = array();
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        $data['object'] = BaseCode::model()->getReturn('734,1480,1481,1482');
        parent::_list($model, $criteria, 'index_beans_detail',$data);
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

}
