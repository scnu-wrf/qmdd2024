<?php
    check_request('type',0);
    check_request('p_id',0);
    check_post('data_id',0);
    check_post('data_type',0);
?>
<style>.box-detail-tab li { width: 120px; }</style>
<div class="box">
    <div id="t0" class="box-title c">
        <h1><i class="fa fa-table"></i></i><?php if($model->id=='') {?>基本信息<?php }else{?><?php echo $model->game_title.' /基本信息'; }?></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gameList/index_history');?>');"><i class="fa fa-reply"></i>返回历史列表</a></span>
    </div><!--box-title end-->
    <div class="box-detail" style="padding-top:15px;">
     <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current"><a href="<?php echo $this->createUrl('gameList/update_history',array('id'=>$model->id));?>">基本信息</a></li>
                <li><a href="<?php echo $this->createUrl('gameRefereesList/index_history',array('game_id'=>$model->id,'title'=>$model->game_title,'p_id'=>$_REQUEST['p_id'])); ?>">赛事裁判</a></li>
                <li><a href="<?php echo $this->createUrl('gameSignList/index_history',array('game_id'=>$model->id,'title'=>$model->game_title,'p_id'=>$_REQUEST['p_id'])); ?>">赛事成员</a></li>
                <li><a href="<?php echo $this->createUrl('gameListArrange/index_history',array('game_id'=>$model->id,'title'=>$model->game_title,'p_id'=>$_REQUEST['p_id'])); ?>">赛事赛程</a></li>
                <li><a href="<?php echo $this->createUrl('gameSignList/index_history',array('game_id'=>$model->id,'title'=>$model->game_title,'p_id'=>$_REQUEST['p_id'])); ?>">赛事成绩</a></li>
            </ul>
        </div>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
            	<table class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="8">基本信息</td>
                    </tr>
                    <tr>
                        <td width="10%"><?php echo $form->labelEx($model, 'game_code'); ?></td>
                        <td width="15%"><?php echo $model->game_code; ?></td>
                        <td width="10%;"><?php echo $form->labelEx($model, 'game_club_id'); ?></td>
                        <td>
                            <span id="club_box">
                                <span>
                                    <?php echo $model->game_club_name;?>
                                    <?php echo $form->hiddenField($model, 'game_club_id', array('class' => 'input-text')); ?>
                                </span>
                            </span>
                        </td>
                        <td width="10%"><?php echo $form->labelEx($model, 'game_title'); ?></td>
                        <td colspan="3"><?php echo $model->game_title.$form->hiddenField($model,'game_title'); ?></td>
                    </tr>
                    <tr>
                        <td width="10%"><?php echo $form->labelEx($model, 'game_level'); ?></td>
                        <td width="15%"><?php echo $model->base_game_type->F_NAME.'&nbsp;&nbsp;'.$model->level_name; ?></td>
                        <td width="10%"><?php echo $form->labelEx($model, 'game_area'); ?></td>
                        <td width="15%"><?php echo $model->area_name; ?></td>
                        <td width="10%"><?php echo $form->labelEx($model, 'local_men'); ?></td>
                        <td width="15%"><?php echo  $model->local_men.$form->hiddenField($model,'local_men'); ?></td>
                        <td width="10%"><?php echo $form->labelEx($model, 'local_and_phone'); ?></td>
                        <td width="15%"><?php echo $model->local_and_phone.$form->hiddenField($model,'local_and_phone'); ?></td>
                    </tr>
                    <tr>
                        <td width="10%"><?php echo $form->labelEx($model, 'game_address'); ?></td>
                        <td colspan="3">
                            <?php
                                echo $model->game_address.$form->hiddenField($model,'game_address');
                            ?>
                        </td>
                        <td width="10%"><?php echo $form->labelEx($model,'navigatio_address'); ?></td>
                        <td colspan="3">
                            <?php
                                echo $model->navigatio_address.$form->hiddenField($model,'navigatio_address');
                                echo $form->hiddenField($model, 'Longitude');
                                echo $form->hiddenField($model, 'latitude');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_small_pic'); ?></td>
                        <td id="dpic_game_small_pic">
                            <?php
                                echo $form->hiddenField($model, 'game_small_pic', array('class' => 'input-text fl'));
                                $basepath=BasePath::model()->getPath(118);$picprefix='';
                                if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                if($model->game_small_pic!=''){
                            ?>
                                <div class="upload_img fl" id="upload_pic_GameList_game_small_pic">
                                    <a href="<?php echo $basepath->F_WWWPATH.$model->game_small_pic;?>" target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$model->game_small_pic;?>" width="100">
                                    </a>
                                </div>
                            <?php }?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_big_pic'); ?></td>
                        <td colspan="5">
                            <?php echo $form->hiddenField($model, 'game_big_pic', array('class' => 'input-text')); ?>
                            <div class="upload_img fl" id="upload_pic_GameList_game_big_pic">
                                <?php 
                                    $basepath=BasePath::model()->getPath(207);$picprefix='';
                                    if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                    if(!empty($game_big_pic))foreach($game_big_pic as $v) { 
                                ?>
                                    <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$v;?>" width="100">
                                    </a>
                                <?php }?>
                            </div>
                        </td>
                    </tr>
                    <tr id="web_top" style="display:none;">
                        <td width="10%"><?php echo $form->labelEx($model, 'game_web_top'); ?></td>
                        <td width="38%">
                            <?php echo $form->hiddenField($model, 'game_web_top', array('class' => 'input-text')); ?>
                            <div class="upload_img fl" id="upload_pic_GameList_game_web_top">
                                <?php 
                                    $basepath=BasePath::model()->getPath(206);$picprefix='';
                                    if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                ?>
                                <?php if($model->game_web_top!=''){?>
                                    <a class="picbox" data-savepath="<?php echo $model->game_web_top;?>" href="<?php echo $basepath->F_WWWPATH.$model->game_web_top;?>" target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$model->game_web_top;?>" width="100">
                                    </a>
                                <?php }?>
                            </div>
                        </td>
                        <td width="12%"><?php echo $form->labelEx($model, 'game_web_bg'); ?></td>
                        <td width="38%">
                            <?php echo $form->hiddenField($model, 'game_web_bg', array('class' => 'input-text fl')); ?>
                            <div class="upload_img fl" id="upload_pic_GameList_game_web_bg">
                                <?php 
                                    $basepath=BasePath::model()->getPath(205);$picprefix='';
                                    if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                ?>
                                <?php if($model->game_web_bg!=''){?>
                                    <a class="picbox" data-savepath="<?php echo $model->game_web_bg;?>" href="<?php echo $basepath->F_WWWPATH.$model->game_web_bg;?>" target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$model->game_web_bg;?>" width="100">
                                    </a>
                                <?php }?>
                            </div>
                        </td>
                    </tr>
                    <tr id="web_bg" style="display:none;">
                        <td><?php echo $form->labelEx($model, 'game_web_top_color'); ?></td>
                        <td>
                            <?php echo $form->colorField($model, 'game_web_top_color', array('type'=>'color ')); ?><br>
                            <span class="msg">注：如果选择背景图片，那么背景颜色不会显示</span><br>
                            <span class="msg">注：只在网页端赛事主页显示</span>
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_web_bg_color'); ?></td>
                        <td>
                            <?php echo $form->colorField($model, 'game_web_bg_color', array('type'=>'color ')); ?><br>
                            <span class="msg">注：如果选择背景图片，那么背景颜色不会显示</span><br>
                            <span class="msg">注：只在网页端赛事主页显示</span>
                        </td>
                    </tr>
                </table>
                <table class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="8">赛事设置</td>
                    </tr>
                    <tr>
                        <td width="10%"><?php echo $form->labelEx($model, 'game_apply_way_referee'); ?></td>
                        <td width="15%"><?php if(!empty($model->game_apply_way_referee))echo $model->base_apply_way->F_NAME; ?></td>
                        <td width="10%"><?php echo $form->labelEx($model, 'game_check_way'); ?></td>
                        <td width="15%"><?php if(!empty($model->game_check_way))echo $model->base_check_way->F_NAME; ?></td>
                        <td width="10%"><?php echo $form->labelEx($model, 'if_game_live'); ?></td>
                        <td width="15%"><?php if(!empty($model->if_game_live))echo $model->base_game_live->F_NAME; ?></td>
                        <td width="10%"><?php echo $form->labelEx($model, 'game_online'); ?></td>
                        <td width="15%"><?php echo $model->online_name; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'Signup_date'); ?></td>
                        <td><?php echo $model->Signup_date.$form->hiddenField($model,'Signup_date'); ?></td>
                        <td><?php echo $form->labelEx($model, 'Signup_date_end'); ?></td>
                        <td><?php echo  $model->Signup_date_end.$form->hiddenField($model,'Signup_date_end'); ?></td>
                        <td><?php echo $form->labelEx($model, 'game_time'); ?></td>
                        <td><?php echo $model->game_time.$form->hiddenField($model,'game_time'); ?></td>
                        <td><?php echo $form->labelEx($model, 'game_time_end'); ?></td>
                        <td><?php echo  $model->game_time_end.$form->hiddenField($model,'game_time_end'); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'dispay_star_time'); ?></td>
                        <td colspan="3"><?php echo  $model->dispay_star_time.$form->hiddenField($model,'dispay_star_time'); ?></td>
                        <td><?php echo $form->labelEx($model, 'dispay_end_time'); ?></td>
                        <td colspan="3"><?php echo  $model->dispay_end_time.$form->hiddenField($model,'dispay_end_time'); ?></td> 
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'team_notice'); ?></td>
                        <td colspan="7"><?php echo $model->team_notice; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'member_notice'); ?></td>
                        <td colspan="7"><?php echo $model->member_notice; ?></td>
                    </tr>
                </table>
                <?php
                    $model1 = GameListData::model();
                    $tmp1=$model1->findAll('game_id='.$model->id);
                    $model2 = GameIntroduction::model();
                    $tmp2=$model2->findAll('game_id='.$model->id);
                ?>
                <table class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="10">竞赛项目</td>
                    </tr>
                    <tr class="table-title">
                        <td style='text-align: center;'>序号</th>
                        <td style='text-align: center;'><?php echo $model1->getAttributeLabel('game_data_code');?></td>
                        <td style='text-align: center;'><?php echo $model1->getAttributeLabel('project_id');?></td>
                        <td style='text-align: center;'><?php echo $model1->getAttributeLabel('game_data_name');?></td>
                        <td style='text-align: center;'><?php echo $model1->getAttributeLabel('game_mode');?></td>
                        <td style='text-align: center;'><?php echo $model1->getAttributeLabel('game_money');?></td>
                        <td style='text-align: center;'><?php echo $model1->getAttributeLabel('number_of');?></td>
                        <td style='text-align: center;'><?php echo $model1->getAttributeLabel('game_group_star');?></td>
                        <td style='text-align: center;'><?php echo $model1->getAttributeLabel('game_group_end');?></td>
                    </tr>
                    <tbody>
                    <?php $index = 1;foreach($tmp1 as $v){ ?>
                        <tr>
                            <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td style='text-align: center;'><?php echo $v->game_data_code; ?></td>
                            <td style='text-align: center;'><?php echo $v->project_name; ?></td>
                            <td style='text-align: center;'><?php echo $v->game_data_name; ?></td>
                            <td style='text-align: center;'><?php echo $v->game_mode_name; ?></td>
                            <td style='text-align: center;'><?php echo $v->game_money; ?></td>
                            <td style='text-align: center;'><?php echo ($v->game_player_team==665) ? $v->number_of_member_min.' / '.$v->number_of_member :$v->min_num_team.' / '.$v->max_num_team; ?></td>
                            <td style='text-align: center;'><?php echo $v->game_group_star; ?></td>
                            <td style='text-align: center;'><?php echo $v->game_group_end; ?></td>
                        </tr>
                    <?php $index++; } ?>
                    </tbody>
                </table>
                <table class="mt15">
                    <tr class="table-title">
                        <td colspan="3">竞赛规程</td>
                    </tr>
                    <tr class="table-title">
                        <td style='text-align: center;'>序号</th>
                        <td style='text-align: center;'><?php echo $model2->getAttributeLabel('intro_title');?></td>
                        <td style='text-align: center;'>操作</th>
                    </tr>
                    <tbody>
                        <?php $index1 = 1; foreach($tmp2 as $c) {?>
                            <tr>
                                <td style='text-align: center'><span class="num num-1"><?php echo $index1; ?></span></td>
                                <td style='text-align: center'><?php echo $c->intro_title; ?></td>
                                <td style='text-align: center'><a href="javascript:;" class="btn" onclick="onIntroduction(<?php echo $c->id; ?>);">查看</a></td>
                            </tr>
                        <?php $index1++; }?>
                    </tbody>
                </table>
                <table class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="8">审核信息</td>
                    </tr>
                    <tr>
                        <?php $col = ($_REQUEST['p_id']==0) ? 3 : 7; $wi = ($_REQUEST['p_id']==0) ? '40%' : '90%'; ?>
                        <td width="10%"><?php echo $form->labelEx($model,'state'); ?></td>
                        <td width="<?php echo $wi; ?>" colspan="<?php echo $col; ?>"><?php echo $model->state_name; ?></td>
                        <?php if($_REQUEST['p_id']==0) {?>
                            <td width="10%"><?php echo $form->labelEx($model,'reasons_failure'); ?></td>
                            <td width="40%"><?php echo $model->reasons_failure; ?></td>
                        <?php }?>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    function onIntroduction(id){
        var s_html = '<div id="show_trodu"></div>';
        $.dialog({
            id:'showtrodu',
            lock:true,
            opacity:0.3,
            width: '60%',
            height: '60%',
            title:'查看竞赛规程',
            content:s_html,
        });
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('showtrodu'); ?>&id='+id,
            dataType: 'json',
            success: function(data){
                // console.log(data);
                $('#show_trodu').html(data);
            }
        });
    }
</script>