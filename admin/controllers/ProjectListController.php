<?php

class ProjectListController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = 'ProjectList';
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '',$pid = 1,$CODE='',$is_excel='0'){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'if_del=648';
        // if($pid <2){
            // $criteria->condition.=' AND  project_type = 1';
        // }
        // else if($pid =2  ){
        //     $criteria->condition.=' AND ( project_type = "' . $pid . '" AND left(CODE,2) ="'.$CODE.'") ';
        // }
        if($keywords !== ''){
            $criteria->condition.=' AND (CODE like "%' . $keywords . '%" OR project_name like "%' . $keywords . '%" OR project_e_name like "%' . $keywords . '%" OR project_type like "%' . $keywords . '%" OR project_simple_code like "%' . $keywords . '%")';
        }
        $data = array();
        if(!isset($is_excel) || $is_excel != '1'){
            $data = array();
            $criteria->order = 'CODE ASC';
            parent::_list($model, $criteria, 'index', $data);
        }
        else{
            $arclist = $model->findAll($criteria);
            $data=array();
            $title = array();
            foreach ($model->labelsOfList() as $fv) {
                array_push($title, $model->attributeLabels()[$fv]);
            }
            array_push($data, $title);
            foreach ($arclist as $v) {
                $item = array();
                foreach ($model->labelsOfList() as $fv) {
                    $s = '';
                    if ($fv == '') {
                        $s = ProjectList::model()->getName($v->$fv);
                    } else {
                        $s = $v->$fv;
                    }
                    array_push($item, $s);
                }
                array_push($data, $item);
            }
            parent::_excel($data,'项目管理表.xls');
        }
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['clubServicerType']=ClubServicerType::model()->findAll('is_club_qualification=1');
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
            $basepath = BasePath::model()->getPath(184);
            $model->project_description_temp=get_html($basepath->F_WWWPATH.$model->project_description, $basepath);
            $data['model'] = $model;
            //$data['model']->game_model=explode(',',$data['model']->game_model);
            $data['project_list_game'] = ProjectListGame::model()->findAll('project_id='.$model->id);
            $data['clubServicerType']=ClubServicerType::model()->findAll('is_club_qualification=1');
            $this->render('update', $data);
        }
        else{
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    function saveData($model,$post){
        $model->attributes = $post;
        $sv=$model->save(); 
        $this->save_project_serivce($model->id,$post['ProjectSerivce']);
        $this->save_project_game($model->id,$post['project_game']);
        show_status($sv,'保存成功',get_cookie('_currentUrl_'),'保存失败');
    }

    public function save_project_serivce($id,$project_serivce){
        if(isset($_POST['ProjectSerivce'])){
            foreach($_POST['ProjectSerivce'] as $a=>$b){
                foreach($b as $m=>$n){
                    $ps=ProjectSerivce::model()->find('project_id='.$id.' and qualification_type_id='.$a);
                    if(empty($ps)){
                        $ps = new ProjectSerivce();
                        $ps->isNewRecord = true;
                        unset($ps->id);
                    }
                    $ps->qualification_type_id=$a;
                    $ps->project_id=$id;
                    $ps->min_count=$n;
                    $ps->save();
                }
            }
        }
    }

    public function save_project_game($id,$project_game,$pl=0){
        $attr=ProjectListGame::model()->findAll('project_id='.$id);
        $arr= array();
        // ProjectListGame::model()->deleteAll('project_id='.$id);
        if(isset($_POST['project_game'])){
            foreach($_POST['project_game'] as $v){
                if($v['game_item']==''){
                    continue;
                }
                $model2 = ProjectListGame::model()->find('id='.$v['id']);
                if(empty($model2)){
                    $model2 = new ProjectListGame();
                    $model2->isNewRecord = true;
                    unset($model2->id);
                }
                $model2->project_id = $id;
                $model2->game_item = $v['game_item'];
                $model2->game_model = gf_implode(',',$v['game_model']);
                $model2->game_sex = $v['game_sex'];
                $model2->game_age = $v['game_age'];
                $model2->game_weight = $v['game_weight'];
                $model2->game_man_num = $v['game_man_num'];
                $model2->game_team_num = $v['game_team_num'];
                $model2->game_team_mem_num = $v['game_team_mem_num'];
                $model2->save();
                $arr[]=$v['id'];
            }
        }
        if($pl==0 && isset($attr)) {
            foreach ($attr as $k) {
                if(!in_array($k->id,$arr)) {
                    ProjectListGame::model()->deleteAll('id='.$k->id);
                }
            }
        }
        return true;
    }

    //逻辑删除
    public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
            $model->updateByPk($d,array('if_del'=>649));
            $count++;
            
        }
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }

    //逻辑删除
    public function actionDelete1($id) {
        $modelName = 'ProjectListGame';
        $model = $modelName::model();
        $count = $model->deleteAll('id in('.$id.')');
        show_status($count, '删除成功', Yii::app()->request->urlReferrer,'删除失败');
    }

    // 竞赛项目设置
    public function actionIndex_game_project_setting($keywords = ''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'project_type=1 and IF_VISIBLE=649 and if_del=648';
        $criteria->condition = get_like($criteria->condition,'CODE,project_name',$keywords,'');
        $criteria->order = 'CODE ASC';
        $data = array();
        parent::_list($model, $criteria, 'index_game_project_setting', $data);
    }

    // 添加竞赛项目设置
    public function actionCreate_game_project_setting() {
        $modelName = 'ProjectListGame';
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_game_project_setting', $data);
        } else {
            $this->post_save_project_game($model,$_POST);
        }
    }

    // 修改竞赛项目设置
    public function actionUpdate_game_project_setting($id,$fater_id=0) {
        $modelName = (empty($fater_id)) ? 'ProjectListGame' : $this->model;
        $model = $this->loadModel($id, $modelName);
        $mn = empty($fater_id) ? 1 : 0;
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $act = (empty($fater_id)) ? 'id='.$id : 'project_id='.$fater_id;
            $data['project_list'] = ProjectListGame::model()->findAll($act);
            $this->render('update_game_project_setting', $data);
        } else {
            $this->post_save_project_game($model,$_POST,$mn);
        }
    }

    // 保存经死啊项目设置
    function post_save_project_game($model,$post,$mn=1){
        $post_name = ($mn==1) ? 'ProjectListGame' : $this->model;
        $post_id = ($mn==1) ? 'project_id' : 'id';
        $sv = $this->save_project_game($post[$post_name][$post_id],$_POST['project_game'],$mn);
        show_status($sv,'保存成功',get_cookie('_currentUrl_'),'保存失败');
    }
}
