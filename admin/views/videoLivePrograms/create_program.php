
<div class="box">
    <div class="box-title c">
    <h1><i class="fa fa-table"></i><?php echo (empty($model->id)) ? '添加' : '编辑'; ?>节目单</h1><span class="back">
    <a class="btn" href="javascript:;" onclick="we.back();">
    <i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
		<div class="box-detail-bd">
			<table>
				<tr>
                    <td style="width:100px;">所属直播</td>
                    <td><?php echo $form->dropDownList($model, 'live_id', Chtml::listData($live_list, 'id', 'title'), array('prompt'=>'请选择','style'=>'width:218px;')); ?></td>
                </tr>
			</table>
			<?php echo $form->error($model, 'live_id', $htmlOptions = array()); ?>
			<table class="table-title" style="margin-top: 10px;">
                <tr>
                    <td style="text-align:center;width:40px;">序号</td>
                    <td style="text-align:center;">节目单号</td>
                    <td style="text-align:center;">节目单名称</td>
                    <td style="text-align:center;">开始时间</td>
                    <td style="text-align:center;">结束时间</td>
                    <td style="text-align:center;">操作</td>
                </tr>
			</table>
			<?php echo $form->hiddenField($model, 'programs_list'); ?>
			<table id="program_list" data-num="1">
				<tr>
					<td style="text-align:center;width:40px;">1</td>
					<td></td>
                    <td><input onchange="fnUpdateProgram();" class="input-text" name="programs_list[1][title]" value=""></td></td>
                    <td><input onchange="fnUpdateProgram();" class="input-text" name="programs_list[1][program_time]" onclick="fnSetDateTime(this);" onblur="fnCountMinute(this);" readonly></td>
                    <td><input onchange="fnUpdateProgram();" class="input-text" name="programs_list[1][program_end_time]" onclick="fnSetDateTime(this);" onblur="fnCountMinute(this);" readonly></td>
					<td style="text-align:left;"><input onclick="fnAddProgram();" class="btn" type="button" value="添加行"></td>
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
// 添加删除更新节目
var $program_list=$('#program_list');
var $VideoLivePrograms_programs_list=$('#VideoLivePrograms_programs_list');
var fnAddProgram=function(){
    var num=parseInt($program_list.attr('data-num'))+1;
    $program_list.append('<tr><td style="text-align:center;width:40px;">'+num+'</td><td></td>'+
        '<td><input onchange="fnUpdateProgram();" class="input-text" name="programs_list['+num+'][title]"></td>'+
        '<td><input onchange="fnUpdateProgram();" class="input-text" name="programs_list['+num+'][program_time]" onclick="fnSetDateTime(this);" onblur="fnCountMinute(this);" readonly></td>'+
        '<td><input onchange="fnUpdateProgram();" class="input-text" name="programs_list['+num+'][program_end_time]" onclick="fnSetDateTime(this);" onblur="fnCountMinute(this);" readonly></td>'+
        '<td style="text-align:left;"><input onclick="fnAddProgram();" class="btn" type="button" value="添加行">&nbsp;<input onclick="fnDeleteProgram(this);" class="btn" type="button" value="删除"></td>'+
        '</tr>');
    $program_list.attr('data-num',num);
};
var fnDeleteProgram=function(op){
    $(op).parent().parent().remove();
    fnUpdateProgram();
};
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
var fnCountMinute=function(op){
    var current_line=$(op).parent().parent().find('input');
    var star_time = current_line.eq(1).val();
    var end_time = current_line.eq(2).val();
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
</script>
