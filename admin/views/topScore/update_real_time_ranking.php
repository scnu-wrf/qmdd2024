<div class="box">
    <div class="box-title c">
        <h1>当前界面：实时排名榜-个人排名详情</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a>
        </span>
    </div>
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table>
                <tr>
                    <td><?php echo $form->labelEx($model,'top_project_id'); ?></td>
                    <td><?php echo $model->top_project_name; ?></td>
                    <td><?php echo $form->labelEx($model,'box_group'); ?></td>
                    <td><?php  ?></td>
                    <td><?php echo $form->labelEx($model,'top_gfsex'); ?></td>
                    <td><?php if(!empty($model->top_gfsex)) echo $model->base_sex->F_NAME; ?></td>
                </tr>
            </table>
            <table class="mt15">
                <tr>
                    <td>级别</td>
                    <td>积分</td>
                    <td>票数</td>
                    <td>点击率</td>
                    <td>排名</td>
                </tr>
                <?php
                    // $top_score_history = TopScoreHistory::model()->findAll('gf_id='.$model->top_gfid);
                    // if(!empty($top_score_history))foreach($top_score_history as $ts){
                ?>
                    <tr>
                        <td><?php //if(!empty($ts->base_game_area)) echo $ts->base_game_area->F_NAME; ?></td>
                        <td><?php //echo $ts->get_score; ?></td>
                    </tr>
                <?php //}?>
            </table>
        </div>
        <?php $this->endWidget();?>
    </div>
</div>

<?php
public function actionIndex_real_time_ranking($project='',$limit_start=0,$limit_end=0){
    set_cookie('_currentUrl_', Yii::app()->request->url);
    $modelName = $this->model;
    $model = $modelName::model();
    $criteria = new CDbCriteria;
    $criteria->select = '*,@rank := @rank+1 as rank';
    $criteria->alias = 't,(select @rank := 0) q';
    $criteria->condition = get_where_club_project('club_id').' and score_type=839 and credit>0';// and top_project_id='.$project;
    // $criteria->condition .= ' and exists(select * from club_list where club_list.id=t.club_id and club_list.unit_state=648)';
    $criteria->condition = get_where($criteria->condition,!empty($project),'top_project_id',$project,'');
    // $end = (empty($limit_end)) ? 15 : $limit_end;
    $end = (!empty($limit_end)) ? ','.$limit_end : 15;
    // $end = (!empty($limit_end)) ? $limit_end : 15;
    $is_limit = '';
    if(!empty($limit_start)){
        $is_limit = 1;
        if($limit_start==1){
            $limit_start = 1;
        }
        $criteria->condition .= ' limit '.$limit_start.$end;
        // $criteria->limit = $limit_end;
        // $criteria->offset = $limit_start;
    }
    $data = array();
    $data['project_list'] = ProjectList::model()->getProject();
    parent::_list($model, $criteria, 'index_real_time_ranking', $data, $end, $is_limit);
}

public function actionIndex_real_time_ranking($project='',$limit_start=0,$limit_end=0){
    set_cookie('_currentUrl_', Yii::app()->request->url);
    $modelName = $this->model;
    $model = $modelName::model();
    $criteria = new CDbCriteria;
    // $criteria->select = '*,@rank := @rank+1 as rank';
    // $criteria->alias = "t`,".'`(select @rank := 0)` `q';
    $criteria->condition = get_where_club_project('club_id').' and score_type=839 and credit>0';// and top_project_id='.$project;
    $criteria->condition .= ' and exists(select * from club_list where club_list.id=t.club_id and club_list.unit_state=648)';
    $criteria->condition = get_where($criteria->condition,!empty($project),'top_project_id',$project,'');
    // $end = (empty($limit_end)) ? 15 : $limit_end;
    $end = (!empty($limit_end)) ? ','.$limit_end : 15;
    // $end = (!empty($limit_end)) ? $limit_end : 15;
    $is_limit = '';
    if(!empty($limit_start)){
        $is_limit = 1;
        if($limit_start==1){
            $limit_start = 1;
        }
        $criteria->condition .= ' limit '.$limit_start.$end;
        // $criteria->limit = $limit_end;
        // $criteria->offset = $limit_start;
    }
    $data = array();
    $data['project_list'] = ProjectList::model()->getProject();
    parent::_list($model, $criteria, 'index_real_time_ranking', $data, $end, $is_limit);
}

public function actionIndex_real_time_ranking($project='',$limit_start=0,$limit_end=0){
    set_cookie('_currentUrl_', Yii::app()->request->url);
    $modelName = $this->model;
    $model = $modelName::model();
    $criteria = new CDbCriteria;
    $criteria->select = '*,@rank:=@rank+1 as rank';
    // $criteria->select = array('*','@rank:=@rank+1 as rank');
    $criteria->alias = 't,(select @rank:=0) as q';
    $criteria->condition = get_where_club_project('club_id').' and score_type=839 and credit>0';// and top_project_id='.$project;
    // $criteria->condition .= ' and exists(select * from club_list where club_list.id=t.club_id and club_list.unit_state=648)';
    $criteria->condition = get_where($criteria->condition,!empty($project),'top_project_id',$project,'');
    // $end = (empty($limit_end)) ? 15 : $limit_end;
    $end = (!empty($limit_end)) ? ','.$limit_end : 15;
    // $end = (!empty($limit_end)) ? $limit_end : 15;
    $is_limit = '';
    if(!empty($limit_start)){
        $is_limit = 1;
        if($limit_start==1){
            $limit_start = 0;
        }
        $criteria->condition .= ' limit '.$limit_start.$end;
        // $criteria->limit = $limit_end;
        // $criteria->offset = $limit_start;
    }
    $criteria->order = 'credit desc';
    $data = array();
    $data['project_list'] = ProjectList::model()->getProject();
    parent::_list($model, $criteria, 'index_real_time_ranking', $data, $end, $is_limit);
}

$sql = 'select '.$criteria->select.' from top_score '.$criteria->alias.' where '.$criteria->condition;
$arclist = Yii::app()->db->createCommand($sql)->queryAll();
?>