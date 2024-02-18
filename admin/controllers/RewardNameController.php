<?php

class RewardNameController extends BaseController {

    protected $model = '';
    
    public function init() {
        $this->model = 'RewardName';
        parent::init();
    }

    ///列表搜索
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_like($criteria->condition,'reward_code,reward_name',$keywords,'');
        $criteria->order = 'gift_type,reward_code';
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }

    // 打赏礼物名称审核
    // public function actionIndex_exam($keywords='',$state=371) {
    //     set_cookie('_currentUrl_', Yii::app()->request->url);
    //     $modelName = $this->model;
    //     $model = $modelName::model();
    //     $criteria = new CDbCriteria;
    //     $criteria->condition = 'state='.$state;
    //     $criteria->condition = get_like($criteria->condition,'reward_code,reward_name',$keywords,'');
    //     $criteria->order = 'id';
    //     $data = array();
    //     $data['state'] = BaseCode::model()->getReturn('371,2');
    //     parent::_list($model, $criteria, 'index_exam', $data);
    // }

    public function actionCreate() {   
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['gift'] = BaseCode::model()->getCode(1393);
            $this->render('update', $data);
        }else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $data['gift'] = BaseCode::model()->getCode(1393);
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]); 
        }
    }/*曾老师保留部份，---结束*/
  
    function saveData($model,$post) {
        $model->attributes = $post;
        $model->state = get_check_code($_POST['submitType']);
        $st = $model->save();
        show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }

    public function actionDelete($id) {
        parent::_clear($id);
    }

    public function actionUse_state($id){
        $modelName = $this->model;
        $model = $this->loadModel($id,$modelName);
        $sv = $model->updateAll(array('state'=>2),'id='.$id);
        show_status($sv,'审核成功',Yii::app()->request->urlReferrer);
    }

    public function actionGetInteract($interact){
        $arr = array();
        if(!empty($interact)){
            $data = GiftType::model()->findAll('interact_type='.$interact);
            if(!empty($data))foreach($data as $key => $val){
                $arr[$key]['id'] = $val->id;
                $arr[$key]['name'] = $val->name;
            }
        }
        echo CJSON::encode($arr);
    }
}
