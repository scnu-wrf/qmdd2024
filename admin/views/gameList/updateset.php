<?php
    check_request('type',0);
    check_post('data_id',0);
    check_post('data_type',0);

    if($_REQUEST['type']==810){
        $model->game_type=810;
    }
    if($_REQUEST['type']==163){
        $model->game_type=163;
    }
    if(!empty($model->dispay_star_time=='0000-00-00 00:00:00')){
        $model->dispay_star_time='';
    }
    if(!empty($model->dispay_end_time=='0000-00-00 00:00:00')){
        $model->dispay_end_time='';
    }
    if(!empty($model->id)) {
        $gamedata=GameListData::model()->count('game_id='.$model->id);
    }
    $sh = $model->state;
    $disabled ='disabled';
    $arr=BaseCode::model()->getCode_id2();
?>
<script> // html5中默认的script是javascript,故不需要特别指定script language 
    var $d_club_type2= <?php echo json_encode($arr)?>;
</script>
<div class="box">
    <div id="t0" class="box-title c">
        <h1><i class="fa fa-table"></i></i><?php if($model->id=='') {?>基本信息<?php }else{?><?php echo $model->game_title.' /基本信息'; }?></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo get_cookie('_currentUrl_');?>');"><i class="fa fa-reply"></i>返回赛事列表</a></span>
    </div><!--box-title end-->
    <div class="box-detail" style="padding-top:15px;">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table id="t1" class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="8">基本信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_code'); ?></td>
                        <td colspan="1"><?php echo $model->game_code; ?></td>
                        <td ><?php echo $form->labelEx($model, 'game_title'); ?></td>
                        <td colspan="5"><?php echo $model->game_title; ?></td>
                    </tr>
                    <tr>
                        <td width="8%;"><?php echo $form->labelEx($model, 'game_level'); ?></td>
                        <td width="17%;"><?php echo $model->base_game_type->F_NAME.'&nbsp;&nbsp;&nbsp;'.$model->level_name; ?></td>
                        <td width="8%;"><?php echo $form->labelEx($model, 'game_area'); ?></td>
                        <td width="17%;"><?php echo $model->area_name; ?></td>
                        <td width="8%;"><?php echo $form->labelEx($model, 'local_men'); ?></td>
                        <td width="17%;"><?php echo $model->local_men; ?></td>
                        <td width="8%;"><?php echo $form->labelEx($model,'local_and_phone');?></td>
                        <td width="17%;"><?php echo $model->local_and_phone; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_address'); ?></td>
                        <td colspan="3"><?php echo $model->game_address; ?></td>
                        <td><?php echo $form->labelEx($model,'navigatio_address'); ?></td>
                        <td colspan="3">
                            <?php
                                echo $model->navigatio_address;
                                echo $form->hiddenField($model, 'Longitude');
                                echo $form->hiddenField($model, 'latitude');
                            ?>
                        </td>
                    </tr>
                </table>
                <table id="t2" class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="8">赛事设置</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_apply_way_referee'); ?></td>
                        <td><?php echo $model->base_apply_way->F_NAME; ?></td>
                        <td><?php echo $form->labelEx($model, 'game_check_way'); ?></td>
                        <td><?php echo $model->base_check_way->F_NAME; ?></td>
                        <td><?php echo $form->labelEx($model, 'if_game_live'); ?></td>
                        <td><?php echo $model->base_game_live->F_NAME; ?><span class="msg">*【是】展示前端</span></td>
                        <td><?php echo $form->labelEx($model, 'game_online'); ?></td>
                        <td><?php echo $model->base_game_online->F_NAME; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'Signup_date'); ?></td>
                        <td>
                            <?php echo  $form->textField($model, 'Signup_date', array('class' => 'input-text')) ; ?>
                            <?php echo $form->error($model,'Signup_date',$htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'Signup_date_end'); ?></td>
                        <td>
                            <?php echo  $form->textField($model, 'Signup_date_end', array('class' => 'input-text')) ; ?>
                            <?php echo $form->error($model,'Signup_date_end',$htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_time'); ?></td>
                        <td>
                            <?php echo  $form->textField($model, 'game_time', array('class' => 'input-text')) ; ?>
                            <?php echo $form->error($model,'game_time',$htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_time_end'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'game_time_end', array('class' => 'input-text')) ; ?>
                            <?php echo $form->error($model,'game_time_end',$htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'dispay_star_time'); ?></td>
                        <td colspan="3">
                            <?php echo  $form->textField($model, 'dispay_star_time', array('class' => 'input-text')) ; ?>
                            <?php echo $form->error($model, 'dispay_star_time', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'dispay_end_time'); ?></td>
                        <td id="dt_dispay_end_time" colspan="3">
                            <?php echo $form->textField($model, 'dispay_end_time', array('class' => 'input-text')) ; ?>
                            <?php echo $form->error($model, 'dispay_end_time', $htmlOptions = array()); ?>
                        </td> 
                    </tr>
                </table>
                <?php $model1 = GameListData::model();
                  $tmp=$model1->findAll('game_id='.$model->id);
                ?>
                <table id="t2" class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="10">赛事项目明细</td>
                    </tr>
                    <tr>
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;'><?php echo $model1->getAttributeLabel('game_data_code');?></th>
                        <th style='text-align: center;'><?php echo $model1->getAttributeLabel('project_name');?></th>
                        <th style='text-align: center;'><?php echo $model1->getAttributeLabel('game_data_name');?></th>
                        <th style='text-align: center;'><?php echo $model1->getAttributeLabel('game_mode');?></th>
                        <th style='text-align: center;'><?php echo $model1->getAttributeLabel('game_money');?></th>
                        <th style='text-align: center;'><?php echo $model1->getAttributeLabel('number_of');?></th>
                        <th style='text-align: center;'><?php echo $model1->getAttributeLabel('game_group_star');?></th>
                        <th style='text-align: center;'><?php echo $model1->getAttributeLabel('game_group_end');?></th>
                    </tr>
                    <tbody>
                    <?php $index = 1;foreach($tmp as $v){ ?>
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
                <table id="t7" class="mt15">
                    <tr class="table-title">
                        <td colspan="4">审核信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'state'); ?></td>
                        <td><?php echo $model->state_name; ?></td>
                        <td><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                        <td><?php echo $model->reasons_failure; ?></td>
                    </tr>
                    <tr>
                        <td>可执行操作</td>
                        <td colspan="3">
                            <?php $box=array('baocun'=>'保存'); echo show_shenhe_box($box); ?>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    $('#GameList_game_time').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm'});});
    $('#GameList_game_time_end').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm'});});

    $('#GameList_Signup_date').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm'});});
    $('#GameList_Signup_date_end').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm'});});

    $('#GameList_dispay_star_time').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
    $('#GameList_dispay_end_time').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
</script>