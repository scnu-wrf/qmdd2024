<div class="box">
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model,'live_source_RTMP'); ?></td>
                    <td width="35%"><?php echo $model->live_source_RTMP; ?></td>
                    <td width="15%"></td>
                    <td width="35%">
                        <!-- 旧URL ：https://lvbs.cloud.tencent.com/live/play.html?url -->
                        <a href="https://ui.gfinter.net/livepage/play.html?url=<?php echo $model->live_source_HLS_H; ?>" target="_blank"><input class="btn btn-blue" type="button" value="直播测试"></a>
                    </td>
                </tr>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model,'live_source_RTMP_H'); ?></td>
                    <td width="35%"><?php echo $model->live_source_RTMP_H; ?></td>
                    <td width="15%"><?php echo $form->labelEx($model,'live_source_RTMP_N'); ?></td>
                    <td width="35%"><?php echo $model->live_source_RTMP_N; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'live_source_HLS_H'); ?></td>
                    <td><?php echo $model->live_source_HLS_H; ?></td>
                    <td><?php echo $form->labelEx($model,'live_source_HLS_N'); ?></td>
                    <td><?php echo $model->live_source_HLS_N; ?></td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
   

</script>