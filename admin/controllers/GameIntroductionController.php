<?php

class GameIntroductionController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '',$game_id=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'type=0';
        $criteria->condition=get_where($criteria->condition,!empty($game_id),'game_id',$game_id,'');
        // $criteria->condition=get_like($criteria->condition,'intro_title,intro_title_en,intro_simple_content',$keywords,'');//get_where
        $criteria->order = 'id ASC';
        parent::_list($model, $criteria);
    }

    public function actionCreate($game_id,$type,$title) {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName],$game_id);
        }
    }

    public function actionUpdate($id,$game_id,$type,$title) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $basepath = BasePath::model()->getPath(164);
            $model->intro_content_temp=get_html($basepath->F_WWWPATH.$model->intro_content, $basepath);
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName],$game_id);
        }
    }

    function saveData($model,$post,$game_id){
        $model->attributes = $post;
        $sv=$model->save();
        $game_data=GameList::model()->find('id='.$game_id);
        if($sv){
            $game_data->state=721;
            $game_data->save();
        }
        if($_POST['submitType'] == 'baocun'){
            show_status($sv,'保存成功', $this->createUrl('gameIntroduction/index&game_id='.$game_id),'保存失败');
        }
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }
}
