
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>添加时间</h1><span class="back"><a href="javascript:;" class="btn" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div>
    <div class="box-content">
        <div class="box-table">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table class="detail">
                <tr>
                    <td class="detail-hd"><?php echo $form->labelEx($model, 'start_time'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 'start_time', array('class' => 'input-text','style'=>'width:150px;')); ?>
                        <?php echo $form->error($model, 'start_time', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td class="detail-hd"><?php echo $form->labelEx($model, 'end_time'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 'end_time', array('class' => 'input-text','style'=>'width:150px;')); ?>
                        <?php echo $form->error($model, 'end_time', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td class="detail-hd">可执行操作：</td>
                    <td colspan="3">
                        <!-- <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button> -->
                        <?php echo show_shenhe_box(array('baocun'=>'保存')); ?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        <?php $this->endWidget(); ?>
        </div>
    </div>
</div><!--box end-->
<script>
    $(function(){
        var $start_time=$('#QmddServerTime_start_time');
        var $end_time=$('#QmddServerTime_end_time');
        var $QmddServerTime_timename=$("#QmddServerTime_timename");
        $start_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'HH:mm'});
        });
        $end_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'HH:mm'});
        });
    });
</script>