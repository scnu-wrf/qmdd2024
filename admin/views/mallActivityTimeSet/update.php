
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>限时抢时段</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
           <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table class="detail">
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'star_time'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'star_time', array('class' => 'input-text', 'style'=>'width:100px;')); ?>
                        <?php echo $form->error($model, 'star_time', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model, 'end_time'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'end_time', array('class' => 'input-text', 'style'=>'width:100px;')); ?>
                        <?php echo $form->error($model, 'end_time', $htmlOptions = array()); ?>
                    </td>
                </tr>
                
                <tr>
                    <th>&nbsp;</th>
                    <td>
                        <button class="btn btn-blue" type="submit">保存</button>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
            <?php $this->endWidget(); ?>
        </div><!--box-table end-->
    </div><!--box-content end-->
</div><!--box end-->


<script>

$('#mallActivityTimeSet_star_time').on('click', function(){
WdatePicker({startDate:'00:00:00 ',dateFmt:'HH:mm:ss'});});
$('#mallActivityTimeSet_end_time').on('click', function(){
WdatePicker({startDate:'00:00:00 ',dateFmt:'HH:mm:ss '});});

</script> 
