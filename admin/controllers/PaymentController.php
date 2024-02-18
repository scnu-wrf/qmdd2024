<?php
//controller中才是与数据库交互的地方
class PaymentController extends BaseController {
	//protected $project_list = '';
    protected $model = '';
    protected $model2 = '';


    public function init() {
        $this->model = 'Payment';
        $this->model2 = 'paymentStrategy';
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionDelete($id) {
        parent::_clear($id);
    }//用id进行删除

    public function actionDelete2() {
        put_msg('test=c');
        $modelid = $_REQUEST['modelid'];
        $model = paymentStrategy::model()->find('id='."'$modelid'");
        $model->delete();
        $data = array('modelid' => $modelid);
        echo CJSON::encode($data);
    }//用id进行删除


    public function actionIndex($startdate='',$enddate='',$keywords='') {    
        set_cookie('_currentUrl_', Yii::app()->request->url);//生成一个返回index控制器的url
        $modelName = $this->model;
        $model = $modelName::model();
        //$model1=Payment::model();
        $criteria = new CDbCriteria;
        //$criteria->addCondition("site_state_name='待提交'");//考虑是否可以放入或的几种查询
        if(!empty($startdate)) 
            $criteria->addCondition("DATE_FORMAT(uptime,'%Y-%m-%d')>='$startdate'");
        if(!empty($enddate)) 
            $criteria->addCondition("DATE_FORMAT(offtime,'%Y-%m-%d')<='$enddate'");
        if(!empty($keywords)) 
            $criteria->condition = get_like($criteria->condition,'activity_name',$keywords,'');
        $criteria->order = 'id';
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }//结合此处做查询

   /*public function actionNotShow($show=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $show = '0';//未显示
        $criteria->addCondition("show='$show'");
        $criteria->order='id';
        $data = array();
        parent::_list($model,$criteria,'index',$data);
   }*/

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign'] = 'create';
            $this->render('update', $data);
        }else{
            $model->activity_name = $_POST['Payment']['activity_name'];
            $model->uptime = $_POST['Payment']['uptime'];
            $model->offtime = $_POST['Payment']['offtime'];
            $model->site_state_name = $_POST['Payment']['site_state_name'];
            $model->strategy_detail = $_POST['Payment']['strategy_detail'];
            if($model->uptime>$model->offtime){
                show_status(false,'时间有误',get_cookie('_currentUrl_'),'时间有误');
            }
            //put_msg($_POST);
            show_status($model->save(false),'保存成功',get_cookie('_currentUrl_'),'保存失败');
            //true展示第二个参数的内容，false展示第四个参数的内容，第三个参数是展示之后返回的url，
        }
    }
    public function actionIndexpass($startdate='',$enddate='',$keywords='') {    
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition("site_state_name='审核通过'");
        if(!empty($startdate)) 
            $criteria->addCondition("DATE_FORMAT(reasons_time,'%Y-%m-%d')>='$startdate'");
        if(!empty($enddate)) 
            $criteria->addCondition("DATE_FORMAT(reasons_time,'%Y-%m-%d')<='$enddate'");
        if(!empty($keywords)) 
            $criteria->condition = get_like($criteria->condition,'site_code,site_name',$keywords,'');
        $criteria->order = 'id';
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }
    public function actionIndexchecking($startdate='',$enddate='',$keywords='') {    
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition("site_state_name='正在审核'");
        if(!empty($startdate)) 
            $criteria->addCondition("DATE_FORMAT(reasons_time,'%Y-%m-%d')>='$startdate'");
        if(!empty($enddate)) 
            $criteria->addCondition("DATE_FORMAT(reasons_time,'%Y-%m-%d')<='$enddate'");
        if(!empty($keywords)) 
            $criteria->condition = get_like($criteria->condition,'site_code,site_name',$keywords,'');
        $criteria->order = 'id';
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }
    public function actionIndexFail($startdate='',$enddate='',$keywords='') {    
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->addCondition("site_state_name='审核失败'");
        if(!empty($startdate)) 
            $criteria->addCondition("DATE_FORMAT(reasons_time,'%Y-%m-%d')>='$startdate'");
        if(!empty($enddate)) 
            $criteria->addCondition("DATE_FORMAT(reasons_time,'%Y-%m-%d')<='$enddate'");
        if(!empty($keywords)) 
            $criteria->condition = get_like($criteria->condition,'site_code,site_name',$keywords,'');
        $criteria->order = 'id';
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }
    /*public function actionDetail($id){//拿到当前的id
        $modelName = $this->model;
        //put_msg($id);
        $model = $this->loadModel($id, $modelName);//model是用来判断查询哪一个的
        $data = array();
        $data['data'] = paymentStrategy::model()->findALL("payment_id='$id'");
        put_msg($data['data']);
        //拿到数据后传入到新的界面
        $criteria = new CDbCriteria;
        $model = 'paymentStrategy';
      // $data['aa']=1234;
        parent::_list($model, $criteria, 'payment_strategy_detail', $data);
    }*/
    public function actionDetail($id){//拿到当前的id
        set_cookie('_currentUrl2_', Yii::app()->request->url);
        //put_msg(Yii::app()->request->cookies['_currentUrl2_']);
        $modelName = 'paymentStrategy';
        $model = $modelName::model();
        $s=0;
        $s = count(paymentStrategy::model()->findALL("payment_id='$id'"));
        $criteria = new CDbCriteria;
        setGetValue('id',$id);
        //$criteria->addCondition("site_state_name='待提交'");//考虑是否可以放入或的几种查询
        if(!empty($id)) 
            $criteria->addCondition("payment_id='$id'");
        $criteria->order = 'id';
        $data = array();
        $data['s']=$s;
        parent::_list($model, $criteria, 'payment_strategy_detail', $data);
    }
    public function actionDetailCreate(){
        
        $modelName = $this->model2;//
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            
            $data['model'] = $model;
            $data['sign'] = 'create';
            $this->render('updateDetail', $data);
        }else{
            $model->payment_id =setGetValue('id');
            $model->name = $_POST['paymentStrategy']['name'];
            $model->uptime = $_POST['paymentStrategy']['uptime'];
            $model->offtime = $_POST['paymentStrategy']['offtime'];
            $model->type = $_POST['paymentStrategy']['type'];
            //put_msg($_POST);
            show_status($model->save(false),'保存成功',get_cookie('_currentUrl2_'),'保存失败');
        }
    }
    public function  actionStrategyUpdate($id){
        //put_msg( Yii::app()->request->cookies['_currentUrl2_']);
        $modelName = $this->model2;
        $model2 = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model2;
            $data['sign'] = 'update';
            $this->render('updateDetail', $data);
        } else {
            //$model->payment_id =setGetValue('id');
            put_msg('test=a');
            put_msg($_POST);
            $model2->name = $_POST['paymentStrategy']['name'];
            $model2->uptime = $_POST['paymentStrategy']['uptime'];
            $model2->offtime = $_POST['paymentStrategy']['offtime'];
            $model2->type = $_POST['paymentStrategy']['type'];
            put_msg($_POST['paymentStrategy']['name']);
            //put_msg($_POST);
            show_status($model2->save(),'保存成功',get_cookie('_currentUrl2_'),'保存失败');
        }
    }
}
