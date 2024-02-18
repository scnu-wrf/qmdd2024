<div class="box">
    <div class="box-title c">
    <h1><i class="fa fa-table"></i>場次信息詳情</h1><span class="back">
    <a class="btn" href="javascript:;" onclick="we.back();">
    <i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table class="mt15">
                    <tr>
                        <td width="20%"><?php echo $form->labelEx($model, 'id'); ?></td>
                        <td width="80%"><?php echo $model->id;?></td> </tr>
                             <tr>
                        <td width="20%"><?php echo $form->labelEx($model, 'game_name'); ?></td>
                        <td width="80%"><?php echo $model->idr->game_name?></td> </tr>
                         <tr>
                        <td width="20%"><?php echo $form->labelEx($model, 'game_data_name'); ?></td>
                        <td width="80%"><?php echo $model->idr->game_data_name;?></td> </tr>
                     <tr>
                        <td width="20%"><?php echo $form->labelEx($model, 'describe'); ?></td>
                        <td width="80%"><?php echo $model->idr->describe;?></td> </tr>
                       <tr>
                        <td width="20%"><?php echo $form->labelEx($model, 'rounds'); ?></td>
                        <td width="80%"><?php echo $model->idr->rounds;?></td> </tr>
                       <tr>
                        <td width="20%"><?php echo $form->labelEx($model, 'matches'); ?></td>
                        <td width="80%"><?php echo $model->idr->matches;?></td> </tr>
                        <tr>
                        <td width="20%"><?php echo $form->labelEx($model, 'game_area'); ?></td>
                        <td width="80%"><?php echo $model->idr->game_area;?></td> </tr>
                        <tr>
                        <td width="20%"><?php echo $form->labelEx($model, 'game_mode'); ?></td>
                        <td width="80%"><?php echo $model->idr->game_mode;?></td> </tr>
                        <tr>
                        <td width="20%"><?php echo $form->labelEx($model, 'star_time'); ?></td>
                        <td width="80%"><?php echo $model->idr->star_time;?></td> </tr>
                        <tr>
                        <td width="20%"><?php echo $form->labelEx($model, 'end_time'); ?></td>
                        <td width="80%"><?php echo $model->idr->end_time;?></td> </tr>
                        <tr>
                        <td width="20%"><?php echo $form->labelEx($model, 'game_over'); ?></td>
                        <td width="80%"><?php echo $model->idr->game_over;?></td> </tr>
                        <tr>
                        <td width="20%"><?php echo $form->labelEx($model, 'game_over_name'); ?></td>
                        <td width="80%"><?php echo $model->idr->game_over_name;?></td> </tr>
                        <tr>
                        <td width="20%"><?php echo $form->labelEx($model, 'votes_star_time'); ?></td>
                        <td width="80%"><?php echo $model->idr->votes_star_time;?></td> </tr>
                        <tr>
                        <td width="20%"><?php echo $form->labelEx($model, 'votes_end_time'); ?></td>
                        <td width="80%"><?php echo $model->idr->votes_end_time;?></td> </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
    

   

<?php $this->endWidget();?>
  </div><!--box-detail end-->
</div><!--box end-->