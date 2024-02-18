<?php

class ClubServiceMemberController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
	public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition="t.club_id=".get_session("club_id");
		$data = array();
        parent::_list($model, $criteria, 'index', $data);
    }
	
    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('update', $data);
        } else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }
    public function actionCreate() {
		$modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionCancel($id,$al){
        $ids = explode(',',$id);
        foreach($ids as $d){
            $modelName = $this->model;
            $model = $this->loadModel($d, $modelName);
            $model->f_vip=0;
            $sn=$model->save();
        }
        show_status($sn,$al,Yii::app()->request->urlReferrer,'失败');
    }

    function saveData($model,$post) {
		$model->attributes =$post;
		$sv=$model->save(); 
        show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }
	
    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }
	//停用
    public function actionDisable($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        $now=date('Y-m-d H:i:s');
        foreach ($club as $d) {
			$model->updateByPk($d,array('state'=>648));
			$count++;
        }
        if ($count > 0) {
            ajax_status(1, '操作成功');
        } else {
            ajax_status(0, '操作失败');
        }
    }
	//启用
    public function actionEnable($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
			$model->updateByPk($d,array('state'=>649));
			$count++;
        }
        if ($count > 0) {
            ajax_status(1, '操作成功');
        } else {
            ajax_status(0, '操作失败');
        }
    } 
	
	//客服账号列表-选择客服账号
    public function actionCustomer_service_list($keywords = '') {
		$data = array();
        $model = ServiceSetup::model();
        $criteria = new CDbCriteria;
		$w1 = 't.club_id='.get_session("club_id");
		$w1.=' and customer_service=1 and m.id IS NULL';
		$criteria->condition=get_like($w1,'admin_gfaccount,admin_gfnick',$keywords,'');
		$criteria->join = 'left join gf_club_customer_service_group_member m on t.id=m.admin_id and t.club_id=m.club_id';//排除已添加客服
		$criteria->order = 'id DESC';
        parent::_list($model, $criteria, 'customer_service_list', $data);
    }
	
	//在线工作台
    public function actionService_chat($id) {
		$modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('service_chat', $data);
        } else{
            // $this->saveData($model,$_POST[$modelName]);
        }
    }
	public function actionSend_msg(){
		$purl=BasePath::model()->path_java."IMMsgService/IMMsgServlet";
		$ts =$_POST['ts']; 
		$visit_id =$_POST['visit_id']; 
		$data =$_POST['data']; 
		$post_data=array("ts"=>$ts,"visit_id"=>$visit_id,"data"=>$data);
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $purl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取数据返回  true
        curl_setopt($ch, CURLOPT_POST, 1); //POST数据// 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); //post变量true
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// https请求 不验证证书和hosts
        $dat = curl_exec($ch);
        curl_close($ch);
        exit($dat);
	}

}
