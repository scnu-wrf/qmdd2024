<?php

class TopScoreController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex_real_time_ranking($keywords='',$project='',$top_gfsex='',$limit_start=0,$limit_end=0,$game_area='',$club_name=''){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        // $end = (empty($limit_end)) ? 15 : $limit_end;
        // $end = (!empty($limit_end)) ? ','.$limit_end : 15;
        // $end = (!empty($limit_end)) ? $limit_end : 15;
        // $criteria->select = '*,@rank := @rank+1 as rank';
        // $criteria->alias = "t`,".'`(select @rank := 0)` `q';
        $str = '';
        $club_name_str = '';
        if(!empty($club_name)) $club_name_str = ' and (cl.club_name like "%'.$club_name.'%")';
        $isexists = ' and exists(select * from club_list cl where cl.id=t.club_id and cl.cl.unit_state=648'.$club_name_str.')';
        if($limit_start>0){
            $str = $this->getTopList($project,$top_gfsex,$game_area,$keywords,$limit_start,$limit_end,$isexists);
            // print_r('25=='.$str);
        }
        if(strlen($str)>0){
            $criteria->condition = 'id in('.$str.')';
        }
        else{
            $criteria->condition = get_where_club_project('club_id').' and top_gfid>0 and score_type=839 and credit>0';// and top_project_id='.$project;
            if(!empty($game_area)){
                $criteria->condition .= ' and find_in_set("'.$game_area.'",t.game_area)';
            }
            $criteria->condition .= $isexists;
            $criteria->condition = get_where($criteria->condition,!empty($project),'top_project_id',$project,'');
            $criteria->condition = get_where($criteria->condition,!empty($top_gfsex),'top_gfsex',$top_gfsex,'');
            $criteria->condition = get_like($criteria->condition,'top_gfaccount,top_gfzsxm',$keywords,'');
        }

        $criteria->order = 'credit desc';

        $data = array();
        $data['project_list'] = ProjectList::model()->getProject();
        $data['game_area_list'] = BaseCode::model()->getReturn('159,160,161,1488,162');
        $data['sex_list'] = BaseCode::model()->getReturn('205,207');
        parent::_list($model, $criteria, 'index_real_time_ranking', $data/*, $end, $is_limit*/);
    }

    /**
     * 搜索名次
     */
    function getTopList($project='',$top_gfsex='',$game_area='',$keywords='',$limit_start='',$limit_end='',$isexists){
        $limit_start = $limit_start - 1;
        $project = (!empty($project)) ? ' and top_project_id='.$project : $project;
        $top_gfsex = (!empty($top_gfsex)) ? ' and top_gfsex='.$top_gfsex : $top_gfsex;
        $game_area = (!empty($game_area)) ? ' and find_in_set('.$game_area.',game_area)' : $game_area;
        $keywords = (!empty($keywords)) ? ' and (top_gfaccount like "%'.$keywords.'%" or top_gfzsxm like "%'.$keywords.'%")' : $keywords;
        $list = TopScore::model()->findAll(get_where_club_project('club_id').' and score_type=839 and credit>0'.$project.$top_gfsex.$game_area.$keywords.$isexists.' order by credit desc limit '.$limit_start.','.$limit_end);
        $str = '';
        if(!empty($list))foreach($list as $ls){
            if(!empty($str)) $str.= ',';
            $str .= $ls->id;
        }
        else{
            $str = 0;
        }
        return $str;
    }

    public function actionUpdate_real_time_ranking($id){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if(!Yii::app()->request->isPostRequest){
            $data['model'] = $model;
            $this->render('update_real_time_ranking',$data);
        }
        else{
            // $this->saveData($model,$_POST[$modelName])
        }
    }

    // function saveData($model,$post){
    //     $model->attributes = $post;
    //     $sv = $model->save();
    //     show_status($sv,'保存成功',get_cookie('_currentUrl_'),'保存失败')
    // }
}