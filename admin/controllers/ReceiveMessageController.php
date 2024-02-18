<?php

class ReceiveMessageController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
	       
    public function actionIndex($keywords='',$start_time='',$end_time='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'is_del=648 and r_club_code="'.get_session("club_code").'"';
        $start_time=empty($start_time) ? date("Y-m-d", strtotime("-1 month")) : $start_time;
        $end_time=empty($end_time) ? date("Y-m-d") : $end_time;
        if ($start_time != '') {
            $criteria->condition.=' and left(s_time,10)>="' . $start_time . '"';
        }
        if ($end_time != '') {
            $criteria->condition.=' and left(s_time,10)<="' . $end_time . '"';
        }
        $criteria->condition=get_like($criteria->condition,'',$keywords,'');
        $criteria->order = 's_time DESC';
        $data = array();
        $data['start_time'] = $start_time;
        $data['end_time'] = $end_time;
        parent::_list($model, $criteria, 'index', $data);
    } 

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            if(empty($model->read_time)){
                $model->read_time= date('Y-m-d H:i:s');
                $model->save();
            }
            $this->render('update', $data);
        } else {
			$this->saveData($model,$_POST[$modelName]);
        }
    }

    //逻辑删除
    public function actionDelete($id, $del = 649, $redirect = '') {
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;

        $criteria->condition = 'id in(' . $id . ')';

        $count = $model->updateAll(array('is_del' => $del), $criteria);
        if ($count > 0) {
            ajax_status(1, '删除成功', $redirect);
        } else {
            ajax_status(0, '删除失败');
        }
    }     

     public function actionMessageCount($msg_json='') {
        $count=ReceiveMessage::model()->count('r_club_code='.get_session("club_code").' and isNull(read_time) and is_del=648');

        $arr=array('visitId' => get_session("visitId"),'count' => $count,'admin_id'=>get_session("admin_id"),'club_code'=>get_session("club_code"),'gfid'=>get_session("gfid"),'gfaccount'=>get_session("gfaccount"),'use_club_id'=>get_session("use_club_id"),'level'=>get_session("level"));
        if($msg_json!=''){
            $secret_key = GfSecretKey::model()->find('is_used=649 order by id desc');
            $arr['msg_json']=aesDecrypt(aesDecrypt($msg_json,$secret_key->encryption),$secret_key->encryption);
        }
        ajax_exit($arr);
     }

    
     
}
