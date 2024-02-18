
<div class="box">
    <div class="box-title c"><h1>详情</h1><span class="back"><a href="javascript:;" class="btn" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div>
    <div class="box-content">
        <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table class="detail" style="table-layout: auto!important;">
                <tr>
                    <td class="detail-hd" width="100px"><?php echo $form->labelEx($model, 'm_title'); ?></td>
                    <td colspan="3">
                        <?php echo $model->m_title; ?>
                    </td>
                </tr>
                <tr>
                    <td class="detail-hd" width="100px"><?php echo $form->labelEx($model, 's_adminid'); ?></td>
                    <td>
                        <?php echo $model->admin->club_name; ?>
                    </td>
                    <td class="detail-hd" width="100px"><?php echo $form->labelEx($model, 's_time'); ?></td>
                    <td>
                        <?php echo $model->s_time; ?>
                    </td>
                </tr>
                <tr>
                    <td class="detail-hd"><?php echo $form->labelEx($model, 'm_message'); ?></td>
                    <td colspan="3">
                        <?php echo $model->m_message; ?>
                    </td>
                </tr>
            </table>
        </div>
        <?php $this->endWidget(); ?>
        </div>
    </div>
</div><!--box end-->
<?php
    $count=ReceiveMessage ::model()->count('r_club_code='.get_session("club_code").' and isNull(read_time) and is_del=648');
?>
<script>
    $(function(){
        var deviceType = parent.window.frames["header-frame"].document.getElementById("m_count");
        deviceType.innerHTML=<?php echo $count;?>
    })
</script>