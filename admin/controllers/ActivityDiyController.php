<?php

class ActivityDiyController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionDelete($id) {
        parent::_clear($id);
    }

      function saveData($model,$post) {
       $model->attributes =$post;
       show_status($model->save(),'保存成功', get_cookie('_currentUrl_'),'保存失败');  
    }

    public function actionIndex($keywords='') {    
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        Yii::import($modelName); // 加入这一行
        $model = Yii::createComponent($modelName); // 更新这一行
        $criteria = new CDbCriteria;
        $data = array();
        parent::_list($model, $criteria, '1index', $data, 20);
    }


    public function actionTijiao(){
        $modelid = $_REQUEST['modelid'];
        $modelName = $this->model;
        $model = $modelName::model()->find("id='$modelid'");
        $divHtml = $model->div_html;
        $setHtml = $model->set_html;
        //$model->div_html = $_POST['ActivityDiy']['div_html'];
        $model->save(false);
        $data = array('modelid'=>$modelid,'div_html'=>$divHtml,'set_html'=>$setHtml);
        echo CJSON::encode($data);
}

    public function actionSaveDivContent() {
    $page_id = $_REQUEST['page_id'];
    $divContent = $_REQUEST['divContent'];
    $modelName = 'DiyPage';
    echo $modelName;
    var_dump($divContent) ;
 
      $model = $modelName::model()->find("id='$page_id'");
      $model->html=$divContent;
      $model->save(false);
      echo CJSON::encode($data);
    }

}
