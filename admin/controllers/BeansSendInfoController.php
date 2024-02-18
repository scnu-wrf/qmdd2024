<?php

class BeansSendInfoController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($start_date = '', $end_date = '', $keywords = '',$index='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        if($index==1){
            $criteria->condition = 'state in(721,373)';
        }elseif($index==2){
            $criteria->condition = 'state in(371)';
        }elseif($index==3){
            $criteria->condition = 'state in(2,373)';
            $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
            $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
            $criteria->condition.=' AND uDate>="' . $start_date . '"';
            $criteria->condition.=' AND uDate<="' . $end_date . '"';
        }elseif($index==4){
            $criteria->condition = 'state in(371)';
        }elseif($index==5){
            $criteria->condition = 'state in(2)';
            if( $start_date != ''){
                $criteria->condition.=' AND uDate>="' . $start_date . '"';
            }
            if( $end_date != ''){
                $criteria->condition.=' AND uDate<="' . $end_date . '"';
            }
        }elseif($index==6){
            $criteria->condition = 'state in(373)';
        }
		$criteria->condition=get_like($criteria->condition,'code,name,f_username',$keywords,'');		
        $criteria->order = 'id DESC';
        $data = array();
        $data['count1'] = $model->count('state=371');
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        parent::_list($model, $criteria, 'index', $data);
    }
    
	public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if(!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        }else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['data'] = BeansHistory::model()->findAll('send_info_id='.$model->id);
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    function saveData($model,$post) {
        $model->attributes =$post;
        $model->state=get_check_code($_POST['submitType']);
        $st=$model->save();
        if($st==1 && !empty($_POST['attr_data'])){
            $this->save_sen_tyd($model, $_POST['attr_data']);
        }
        show_status($st,'保存成功',get_cookie('_currentUrl_'),'保存失败');
    }

    public function save_sen_tyd($model,$data){
        foreach($data as $v){
            if(!empty($v['got_beans_gfid'])){
                $history=BeansHistory::model()->find('send_info_id='.$model->id.' and got_beans_gfid='.$v['got_beans_gfid']);
                if(empty($history)){
                    $history=new BeansHistory();
                    $history->isNewRecord = true;
                    unset($history->id);
                    $history->got_beans_gfid=$v['got_beans_gfid'];
                    $history->uDate=date('Y-m-d H:i:s');
                }
            }elseif(!empty($v['got_beans_clubid'])){
                $history=BeansHistory::model()->find('send_info_id='.$model->id.' and got_beans_clubid='.$v['got_beans_clubid']);
                if(empty($history)){
                    $history=new BeansHistory();
                    $history->isNewRecord = true;
                    unset($history->id);
                    $history->got_beans_clubid=$v['got_beans_clubid'];
                    $history->uDate=date('Y-m-d H:i:s');
                }
            }
            $history->send_info_id=$model->id;
            $history->got_beans_num=$v['got_beans_num'];
            $history->object=1482;
            $history->got_beans_reson=1482;
            $history->state=$model->state;
            if($history->state==2){
                $history->exchange_time=date('Y-m-d H:i:s');
            }
            $history->user_state=506;
            $history->admin_id=get_session('admin_id');
            $history->remark=$v['remark'];
            $history->save();
        }
    }
    
    // 帐号验证
    public function actionValidate($gf_account=0) {
        $s1='GF_ID,GF_ACCOUNT,GF_NAME,passed';
        $s2=userlist::model()->findAll('GF_ACCOUNT="'.$gf_account.'"');
        $user = toArray($s2,$s1);
        if(!empty($user)) {
            ajax_exit(array('error' => 0, 'msg' => '成功', 'datas' => $user));
        } else {
            ajax_exit(array('error' => 1, 'msg' => '账号不存在'));
        }

    }
    // 单位帐号验证
    public function actionExist($code=0) {
        $s1='id,club_code,club_name';
        $s2=ClubList::model()->findAll('club_code="'.$code.'" and unit_state=648 ');
        $club = toArray($s2,$s1);
        if(!empty($club)) {
            ajax_exit(array('error' => 0, 'msg' => '成功', 'datas' => $club));
        } else {
            ajax_exit(array('error' => 1, 'msg' => '账号不存在'));
        }

    }

    public function actionDelete($id) {
        BeansHistory::model()->deleteAll('send_info_id in (' . $id . ')');
        parent::_clear($id);
    }

}
