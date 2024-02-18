<style>.box-detail-tab li { width: 120px; }</style>
<div class="box">
    <div id="t0" class="box-title c">
        <h1>当前界面：赛事/排名 》赛事发布 》<?php echo $model->game_title; ?> 》报名须知 》<?php echo (empty($model->entry_member_notice)) ? '添加' : '详情'; ?></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gameList/index');?>');"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <?php if($model->id!=''){?>
            <div class="box-detail-tab">
                <ul class="c">
                    <?php $action=Yii::app()->controller->getAction()->id;?>
                    <li><a href="<?php echo $this->createUrl('gameList/update',array('id'=>$model->id));?>">基本信息</a></li>
                    <li><a href="<?php echo $this->createUrl('gameListData/index',array('game_id'=>$model->id,'title'=>$model->game_title,'type'=>$model->game_type));?>">竞赛项目</a></li>
                    <li><a href="<?php echo $this->createUrl('gameIntroduction/index',array('game_id'=>$model->id,'title'=>$model->game_title,'type'=>$model->game_type));?>">竞赛规程</a></li>
                    <li class="current"><a href="<?php echo $this->createUrl('gameList/sign_notice',array('id'=>$model->id)); ?>">报名须知</a></li>
                </ul>
            </div><!--box-detail-tab end-->
        <?php }?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
            	<table>
                    <?php echo $form->hiddenField($model,'id');echo $form->error($model,'id'); ?>
                    <tr>
                        <td style="font-weight: bold;"><?php echo $form->labelEx($model,'member_notice');?></td>
                    </tr>
                    <!-- <tr>
                        <td>
                            <?php //echo $form->textarea($model,'member_notice',array('class'=>'input-text','style'=>'height: 300px;width:98%;')); ?>
                        </td>
                    </tr> -->
                    <tr>
                        <td>
                            <?php echo $form->hiddenField($model, 'entry_member_notice', array('class' => 'input-text')); ?>
                            <script>we.editor('<?php echo get_class($model);?>_entry_member_notice', '<?php echo get_class($model);?>[entry_member_notice]');</script>
                        </td>
                    </tr>
                    <?php if($model->game_apply_way_referee==642) {?>
                        <tr>
                            <td style="font-weight: bold;"><?php echo $form->labelEx($model,'team_notice');?></td>
                        </tr>
                        <!-- <tr>
                            <td>
                                <?php //echo $form->textarea($model,'team_notice',array('class'=>'input-text','style'=>'height: 300px;width:98%;')); ?>
                            </td>
                        </tr> -->
                        <tr>
                            <td>
                                <?php echo $form->hiddenField($model, 'entry_team_notice', array('class' => 'input-text')); ?>
                                <script>we.editor('<?php echo get_class($model);?>_entry_team_notice', '<?php echo get_class($model);?>[entry_team_notice]');</script>
                            </td>
                        </tr>
                    <?php }?>
                    <tr>
                        <td style="text-align: center;">
                            <?php if($model->state==721) {
                                echo show_shenhe_box(['baocun'=>'保存']);
                             }?>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->