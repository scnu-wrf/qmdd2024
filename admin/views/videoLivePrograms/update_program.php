
<div class="box">
    <div class="box-title c">
    <h1><i class="fa fa-table"></i><?php echo (empty($model->id)) ? '添加' : '编辑'; ?>节目单</h1><span class="back">
    <a class="btn" href="javascript:;" onclick="we.back();">
    <i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
		<div class="box-detail-bd" style="margin-top: 10px;">
			<?php echo $form->hiddenField($model, 'programs_list',array("value"=>"1")); ?>
			<table id="program_list">
				<tr>
                    <td style="width:100px;">节目名称</td>
                    <td><?php echo $form->textField($model, 'title', array('class' => 'input-text','onchange'=>"fnUpdateProgram();")); ?></td>
					<td style="width:100px;">开始时间</td>
					<td><?php echo $form->textField($model, 'program_time', array('class' => 'input-text','onclick'=>'fnSetDateTime(this);','onblur'=>'fnCountMinute(this);','onchange'=>"fnUpdateProgram();","readonly"=>"readonly")); ?></td>
					<td style="width:100px;">结束时间</td>
					<td><?php echo $form->textField($model, 'program_end_time', array('class' => 'input-text','onclick'=>'fnSetDateTime(this);','onblur'=>'fnCountMinute(this);','onchange'=>"fnUpdateProgram();","readonly"=>"readonly")); ?></td>
                </tr>
			</table>
			<?php echo $form->error($model, 'programs_list', $htmlOptions = array()); ?>
        </div><!--box-detail-bd end-->
        <div class="box-detail-submit">
 <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
  <button class="btn" type="button" onclick="we.back();">取消</button>
 </div>

<?php $this->endWidget();?>

</div>
</div>
<script>
var fnCountMinute=function(op){
    var star_time = $("#VideoLivePrograms_program_time").val();
    var end_time = $("#VideoLivePrograms_program_end_time").val();
    if((end_time!='') && (star_time!='')){
        if(new Date(star_time)>=new Date(end_time)){
            we.msg('minus', '结束时间必须大于开始时间');
            $(op).val('');
            return false;
        }else{   
            var date1 = new Date(star_time);
            var date2 = new Date(end_time);
            var s1=date1.getTime();
            var s2=date2.getTime();
            var minute=parseInt((s2-s1)/(1000*60));
			if(minute>1440){
				we.msg('minus', '单个节目时长不能超过24小时');
				$(op).val('');
				return false;
			}
        }
    }
    
}

// 设置时间
var fnSetDateTime=function(){
    WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',realDateFmt:'yyyy-MM-dd HH:mm:ss'});
};
var $program_list=$('#program_list');
var $VideoLivePrograms_programs_list=$('#VideoLivePrograms_programs_list');
var fnUpdateProgram=function(){
    var isEmpty=false;
    flag=0;
    $program_list.find('.input-text').each(function(){
        if($(this).val()==''){
            isEmpty=true;
			return false;
        } else{
            flag++;
        }
    });
    if(!isEmpty){
        $VideoLivePrograms_programs_list.val('1').trigger('blur');
    }else{
        $VideoLivePrograms_programs_list.val('').trigger('blur');
    }
};
</script>
