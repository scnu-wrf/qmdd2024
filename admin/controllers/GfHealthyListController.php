<?php

class GfHealthyListController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = 'GfHealthyList';
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '', $health_state = '', $start_date = '', $end_date = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition=get_where_club_project('club_id','');
        $criteria->condition=get_where($criteria->condition,!empty($health_state),'t.health_state',$health_state,'');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'t.health_date>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'t.health_date<=',$end_date,'"');
		$criteria->condition=get_like($criteria->condition,'code,gf_name',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['health_state'] = BaseCode::model()->getCode(647);
        parent::_list($model, $criteria, 'index', $data);
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

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['user']= array();
            if(isset($model->gf_account) && !empty($model->gf_account)) {
                $data['user'] = userlist::model()->find('GF_ACCOUNT="'.$model->gf_account.'"');
            }
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    function saveData($model,$post){
        $model->attributes = $post;
        $sv = $model->save();
        $this->save_project_name($model->id,$post['gf_healthy_model']);
        show_status($sv, '保存成功'/*, get_cookie('_currentUrl_'),'保存失败'*/);
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

    public function save_project_name($id,$gf_healthy_model){
        // $gf_healthy=GfHealthyValues::model()->findAll('h_id='.$id);
        $arr=array();
        $model2 = new GfHealthyValues();
        // 保存体检信息
        if(isset($_POST['gf_healthy_model'])){
            foreach($_POST['gf_healthy_model'] as $v){
                if($v['id']=='null'){
                    $model2->isNewRecord = true;
                    unset($model2->id);
                    $model2->h_id = $id;
                    $model2->model_id = $v['model_id'];
                    $model2->attr_name = $v['attr_name'];
                    $model2->attr_unit = $v['attr_unit'];
                    $model2->attr_values = $v['attr_values'];
                    $model2->attr_input_type = $v['attr_input_type'];
                    $model2->save();
                }
                else{
                    $model2->updateByPk($v['id'],array(
                        'id' => $v['id'],
                        'model_id' => $v['model_id'],
                        'attr_name' => $v['attr_name'],
                        'attr_unit' => $v['attr_unit'],
                        'attr_values' => $v['attr_values'],
                        'attr_input_type' => $v['attr_input_type']
                    ));
                    $arr[]=$v['id'];
                }
            }
        }
        // if(isset($gf_healthy)) {
        //     foreach ($gf_healthy as $k) {
        //         if(!in_array($k->id,$arr)) {
        //             GfHealthyValues::model()->deleteAll('id='.$k->id);
        //         }
        //     }
        // }
    }
    
    public function actionValidate($gf_account=0) {
        $user=userlist::model()->find('GF_ACCOUNT="'.$gf_account.'"');
        if(!empty($user)) {
            ajax_status_gamesign(1, $user->GF_ID, $user->ZSXM,$user->IDNAME,$user->PHONE, $user->real_sex,$user->real_sex_name,$user->real_birthday,$user->id_card_type_name,$user->id_card);
        }
        else{
            ajax_status(0, '帐号不存在');
        }
    }

    public function actionPrompt($attr_values=0){
        $gf_model=GfHealthyModel::model()->find();
        $show_val=$_POST['show_val'];
        if(!empty($gf_model)){
            ajax_status_attr(1,$gf_model->attr_name,$gf_model->attr_values);
        }
        // else{
        //     ajax_status_attr(0,'错误');
        // }
    }
}