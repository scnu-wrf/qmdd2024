<?php

class AndroidPhoneController extends BaseController {

     protected $model = '';

     public function init() {
         $this->model = substr(__CLASS__, 0, -10);
         parent::init();
     }
    
    

    public function actionIndex($pid =0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->condition = ($pid==0) ? '1' : 'app_id='.$pid;
        //$criteria->condition.= ' AND (app_id=' . $pid .')';
        $criteria->order = 'id DESC';
        $data = array();
        $data['base_path'] = BasePath::model()->getPath(186);
        parent::_list($model, $criteria,'index', $data);
    }
    
 
    public function actionCreate() {

        $modelName = $this->model;
        $model = new $modelName('update');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['model']->ptype=explode(',',$data['model']->ptype); //把字符串打散为数组
            $this->render('update', $data);         
        }else{
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
           $data['model']->ptype=explode(',',$data['model']->ptype); //把字符串打散为数组
           $this->render('update', $data);
        } else {     
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    function saveData($model,$post) {
       $model->attributes =$post;
       $model->app_id = $_POST['app_id'];
       $model->app_name = $_POST['app_name'];
       $model->ptype=gf_implode(',',$post['ptype']); //把数组元素组合为一个字符串


        if ($_POST['submitType'] == 'shenhe') {
            $model->state = 371;
            $model->v_qmddid=get_session('admin_id');
            $model->v_qmddname=get_session('admin_name');
            
        } else if ($_POST['submitType'] == 'baocun') {          
            $model->state = 721;

        } else if ($_POST['submitType'] == 'tongguo') {
            $model->state = 2;
            $model->s_qmddid=get_session('admin_id');
            $model->s_qmddname=get_session('admin_name');
            // if ($_POST['if_state_dispay']==649) {                    
            //     $model->dispay_time=date("h:i:sa");
            // }


        } else if ($_POST['submitType'] == 'butongguo') {
            $model->state = 373;
            $model->s_qmddid=get_session('admin_id');
            $model->s_qmddname=get_session('admin_name');


            
        } else {
            $model->state = 721;
        }
      show_status($model->save(),'保存成功', get_cookie('_currentUrl_'),'保存失败');   
    }


    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }


}  