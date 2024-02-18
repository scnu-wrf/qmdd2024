<div class="box">
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <input onclick="fnOpenVideoLiveService_GF(<?php echo $model->id;?>,<?php echo $model->code;?>);" class="btn btn-blue" type="button" value="得闲体育云直播频道">&nbsp;&nbsp;
			<!-- 旧URL ：https://lvbs.cloud.tencent.com/live/play.html?url -->
            <a href="https://ui.gfinter.net/livepage/play.html?url=<?php echo $model->live_source_HLS_H; ?>" target="_blank"><input class="btn btn-blue" type="button" value="直播测试"></a>
            <table>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model, 'channelState'); ?></td>
                    <td width="35%">
                        <?php echo $form->radioButtonList($model, 'channelState', Chtml::listData(BaseCode::model()->getCode(695), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'channelState', $htmlOptions = array()); ?>
                    </td>
                    <td width="15%"><?php echo $form->labelEx($model, 'isRecord'); ?></td>
                    <td width="35%">
                        <?php echo $form->radioButtonList($model, 'isRecord', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'isRecord', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'live_source_RTMP'); ?></td>
                    <td colspan="3">
                        <?php echo $form->hiddenField($model, 'live_source_secret');?>
                        <?php echo $form->hiddenField($model, 'live_source_time');?>
                        <?php echo $form->textField($model, 'live_source_RTMP', array('class' => 'input-text', 'readonly'=>'readonly')); ?>
                        <?php echo $form->error($model, 'live_source_RTMP', $htmlOptions = array()); ?>
                                
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'live_source_RTMP_H'); ?></td>
                    <td colspan="3">
                        <?php echo $form->textField($model, 'live_source_RTMP_H', array('class' => 'input-text', 'readonly'=>'readonly')); ?>
                        <?php echo $form->error($model, 'live_source_RTMP_H', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'live_source_RTMP_N'); ?></td>
                    <td colspan="3">
                        <?php echo $form->textField($model, 'live_source_RTMP_N', array('class' => 'input-text', 'readonly'=>'readonly')); ?>
                        <?php echo $form->error($model, 'live_source_RTMP_N', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'live_source_HLS_H'); ?></td>
                    <td colspan="3">
                        <?php echo $form->textField($model, 'live_source_HLS_H', array('class' => 'input-text', 'readonly'=>'readonly')); ?>
                        <?php echo $form->error($model, 'live_source_HLS_H', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'live_source_HLS_N'); ?></td>
                    <td colspan="3">
                        <?php echo $form->textField($model, 'live_source_HLS_N', array('class' => 'input-text', 'readonly'=>'readonly')); ?>
                        <?php echo $form->error($model, 'live_source_HLS_N', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align:center;"><div id="operate"><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">确定</button></div>
                    </td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
// 生成直播频道
var $VideoLive_live_source_RTMP=$('#VideoLive_live_source_RTMP');
var $VideoLive_live_source_RTMP_H=$('#VideoLive_live_source_RTMP_H');
var $VideoLive_live_source_RTMP_N=$('#VideoLive_live_source_RTMP_N');
var $VideoLive_live_source_HLS_H=$('#VideoLive_live_source_HLS_H');
var $VideoLive_live_source_HLS_N=$('#VideoLive_live_source_HLS_N');
var $VideoLive_live_source_time=$('#VideoLive_live_source_time');
var $VideoLive_live_source_secret=$('#VideoLive_live_source_secret');
var fnOpenVideoLiveService_GF=function(live_id,live_code){
    we.loading('show');
    $.ajax({
        type: 'get',
        url: '<?php echo $this->createUrl('getVideoLiveInfo_GF',array('live_id'=>$model->id,'live_code'=>$model->code));?>',
        dataType: 'json',
        success: function(data) {
            we.loading('hide');
            console.log(data);
            if (data.status == 1) {
                $VideoLive_live_source_time.val(data.push_url_date);
                $VideoLive_live_source_secret.val(data.push_url_secret);
                $VideoLive_live_source_RTMP.val(data.push_url);
                $VideoLive_live_source_RTMP_H.val(data.play_rtmp);
                $VideoLive_live_source_RTMP_N.val(data.play_rtmp_sd);
                $VideoLive_live_source_HLS_H.val(data.play_hls);
                $VideoLive_live_source_HLS_N.val(data.play_hls_sd);
            } else {
                we.msg('minus', '直播编码为空，无法生成直播频道');
                return false;
            }
        }
    });
}

$(function(){

    $('#operate .btn-blue:eq(0)').on('click',function(){
        setTimeout(function() {
            parent.location.reload();
        }, 1500);
        //$.dialog.close();
    });
});


</script>