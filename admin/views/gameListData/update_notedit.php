<div class="box">
    <div id="t1" class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">竞赛项目信息</td>
                    </tr>
                    <tr>
                        <td width="12%;"><?php echo $form->labelEx($model, 'game_data_code'); ?></td>
                        <td width="38%;"><?php echo $model->game_data_code;?></td>
                        <td width="12%;"><?php echo $form->labelEx($model, 'project_id'); ?></td>
                        <td width="38%;">
                            <?php echo $model->project_name; ?>
                            <?php echo $model->game_project_name; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_data_name'); ?></td>
                        <td colspan="3"><?php echo $model->game_data_name; ?></td>
                    </tr>
                    <?php echo $form->hiddenField($model, 'weight'); ?>
                    <tr>
                        <td><?php echo $form->labelEx($model,'game_item'); ?></td>
                        <td><?php echo $model->game_item_name; ?></td>
                        <td><?php echo $form->labelEx($model, 'game_player_team'); ?></td>
                        <td><?php echo $model->game_player_team_name; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_sex'); ?></td>
                        <td><?php echo $model->game_sex_name; ?></td>
                        <td><?php echo $form->labelEx($model, 'game_age'); ?></td>
                        <td><?php echo $model->game_age_name; ?></td>
                    </tr>
                    <tr id="dis_age_name" style="display:none;"><!--如果为自定义参赛组别显示-->
                        <td><?php echo $form->labelEx($model, 'game_age_name') ?></td>
                        <td colspan="3"><?php echo $model->game_age_name; ?></td>
                    </tr>
                    <tr id="dis_weight" style="display:none;">
                        <td><?php echo $form->labelEx($model, 'weight_level'); ?></td>
                        <td colspan="3"><?php echo $model->weight_min; ?></td>
                    </tr>
                </table>
                <table class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">竞赛项目设置</td>
                    </tr>
                    <tr>
                        <td style="width:12%;"><?php echo $form->labelEx($model, 'game_mode'); ?></td>
                        <td style="width:38%;"><?php echo $model->game_mode_name; ?></td>
                        <td style="width:12%;"><?php echo $form->labelEx($model, 'game_dg_level'); ?></td>
                        <td style="width:38%;"><?php echo ($model->game_dg_level!=-1) ? $model->level->card_name : '不限'; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'isSignOnline'); ?></td>
                        <td><?php if(!empty($model->isSignOnline))echo $model->base_isSignOnline->F_NAME; ?></td>
                        <td><?php echo $form->labelEx($model, 'game_check_way'); ?></td>
                        <td><?php if(!empty($model->game_check_way))echo $model->base_game_check_way->F_NAME; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_group_end'); ?></td>
                        <td><?php echo $model->game_group_end; ?></td>
                        <td><?php echo $form->labelEx($model, 'game_group_star'); ?></td>
                        <td><?php echo $model->game_group_star; ?></td>
                    </tr>
                    <tr style="display: none;">
                        <td><?php echo $form->labelEx($model, 'signup_date'); ?></td>
                        <td><?php echo $model->signup_date; ?></td>
                        <td><?php echo $form->labelEx($model, 'signup_date_end'); ?></td>
                        <td><?php echo $model->signup_date_end; ?></td>
                    </tr>
                    <?php if($model->game_player_team==665) {?>
                    <tr id="dis_number"><!--人数-->
                        <td><?php echo $form->labelEx($model, 'number_of_member_min'); ?> <span class="required">*</span></td>
                        <td><?php echo $model->number_of_member_min; ?> /人</td>
                        <td><?php echo $form->labelEx($model, 'number_of_member'); ?> <span class="required">*</span></td>
                        <td><?php echo $model->number_of_member; ?> /人</td>
                    </tr>
                    <?php } else{?>
                    <tr id="dis_num_team"><!--（队数）参赛方式为团队显示，为个人默认不显示-->
                        <td><?php echo $form->labelEx($model, 'min_num_team'); ?> <span class="required">*</span></td>
                        <td><?php echo $model->min_num_team; ?> /队</td>
                        <td><?php echo $form->labelEx($model, 'max_num_team'); ?> <span class="required">*</span></td>
                        <td><?php echo $model->max_num_team; ?> /队</td>
                    </tr>
                    <tr id="dis_team"><!--（队伍人数）参赛方式为团队显示，为个人默认不显示，为混双默认不显示-->
                        <td><?php echo $form->labelEx($model, 'minimum_team'); ?> <span class="required">*</span></td>
                        <td><?php echo $model->minimum_team; ?> /人</td>
                        <td><?php echo $form->labelEx($model, 'team_member'); ?> <span class="required">*</span></td>
                        <td><?php echo $model->team_member; ?> /人</td>
                    </tr>
                    <?php }?>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_physical_examination'); ?></td>
                        <td colspan="3">
                            <?php echo $model->game_physical_examination; ?>
                        </td>
                    </tr>
                    <!--不可兼报项目开始-->
                    <tr>
                        <td>
                            <?php
                                echo $form->labelEx($model, 'F_exclusive_ID'); $model->id=empty($model->id) ?0 : $model->id; 
                                if(!empty($model->F_exclusive_ID)){
                                    // if(is_numeric($model->F_exclusive_ID) || !is_numeric($model->F_exclusive_ID)){
                                        $project_list = GameListData::model()->findAll('id in('.$model->F_exclusive_ID.')');
                                    // }
                                }
                            ?>
                        </td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'F_exclusive_ID', array('class' => 'input-text')); ?>
                            <span id="projectnot_box">
                                <?php if(!empty($project_list)){foreach($project_list as $v){?>
                                    <span class="label-box" id="project_item_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>"><?php echo $v->game_data_name;?></span>
                                <?php }}?>
                            </span>
                        </td>
                    </tr>
                </table>
                <table class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">收费设置</td>
                    </tr>
                    <tr>
                        <td width="12%;"><?php echo $form->labelEx($model, 'game_money'); ?></td>
                        <td width="88%;"><?php echo $model->game_money; ?></td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
    <?php $this->endWidget();?>
  </div><!--box-detail end-->
</div><!--box end-->