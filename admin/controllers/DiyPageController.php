<?php

class DiyPageController extends BaseController {
	//protected $project_list = '';
    protected $model = '';

    public function init() {
        $this->model = 'DiyPage';
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionDelete($id) {
        parent::_clear($id);
    }

    public function saveData($model,$post) {
       $model->attributes =$post;
       show_status($model->save(),'保存成功', get_cookie('_currentUrl_'),'保存失败');  
    }

    public function picLabels() {
         return 'image';
     }

    public function actionIndex($keywords="") {    
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        if(!empty($show))
            $criteria->addCondition("show='$show'");

        $criteria->condition = get_like($criteria->condition,'name',$keywords,'');
		$criteria->order = 'id';
		$data = array();
		parent::_list($model, $criteria, 'index', $data);
    }


   public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $code=setGetValue('code',getAutoNo('DiyPage',get_session('gfaccount')));
            //$model->uptime = date('Y-m-d H:i:s');
            $model->code = $code;
            $data['model'] = $model;
            $data['sign'] = 'create';
            $this->render('update', $data);
        }else{
            $model->code = setGetValue('code');
        
            $model->name = $_POST['DiyPage']['name'];
            $model->uptime = $_POST['DiyPage']['uptime'];
            $model->offtime = $_POST['DiyPage']['offtime'];
            $model->show = $_POST['DiyPage']['show'];
            $model->remark = $_POST['DiyPage']['remark'];
            $model->type = $_POST['DiyPage']['type'];
            put_msg($_POST);
            show_status($model->save(false),'保存成功',get_cookie('_currentUrl_'),'保存失败');
        }
    }

    public function actionIndex_diy($id,$keywords='') {    
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = "ActivityDiy";
        Yii::import($modelName); // 加入这一行
        $model = Yii::createComponent($modelName); // 更新这一行
        $modelNamepage = $this->model;
        $modelpage =  $this->loadModel($id, $modelNamepage);

        $criteria = new CDbCriteria;
        $data = array('modelpage' => $modelpage);
        parent::_list($model, $criteria, 'index_diy(4)', $data);
    }

     public function actionUpdate($id,$index='') { 
    
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $rates = $model->findAll();
        $data = array('model' => $model, 'sign'=>'update');
        if (!Yii::app()->request->isPostRequest) {
            
        }
        parent::_update($model, 'update', $data, get_cookie('_currentUrl_'));
    }




//保存到page表的html
    // public function actionSaveDivContent()
    // {
    // $page_id = $_REQUEST['page_id'];
    // $divContent = $_REQUEST['divContent'];
    // $modelName = 'DiyPage';
    // echo $modelName;
    // var_dump($divContent) ;
    // // 根据 $page_id 查找对应的 ActivityDiy 对象
    // // $ID=1;
    // // $model = ActivityDiyPage::model()->findByPk('id='.$ID);
    // // $model->html=2;
    // // $model->save();
    //   $model = $modelName::model()->find("id='$page_id'");
    //   $model->html=$divContent;
    //   $model->save(false);
    // }


public function actionSaveDivContent(){
    $page_id = $_REQUEST['page_id'];
    $divContent = $_REQUEST['divContent'];
    $modelName = 'DiyPage';
      $model = DiyPage::model()->find("id=".$page_id);
      $model->html=$divContent;
      $s1=$model->save(false);

      $data = array('save'=>"id=".$page_id,'ok'=>$s1);
 
     echo CJSON::encode($data);
  }

}
