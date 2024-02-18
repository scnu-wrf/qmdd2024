<?php $cs = Yii::app()->clientScript;?>
<?php $cs->registerCssFile(Yii::app()->request->baseUrl.'/static/admin/css/index.css');?>
<?php $cs->registerScriptFile(Yii::app()->request->baseUrl.'/static/admin/js/index.js', CClientScript::POS_END);?>
<?php  $form = $this->beginWidget('CActiveForm', get_form_list());  ?>
<div class="box">
    <div class="box-detail">
		<div class="subnav">
		<?php foreach($arclist as $k=>$v){ ?>
			<div class="subnav-hd">
				<a href="javascript:;" style="display:table;margin: 10px 0;display:table-cell" class="subnav-hd-title"><i class="fa fa-angle-right"></i><?php echo $v->name;?></a>
				<a style="display:table-cell;padding: 0px 10px 0px 20px;"  href="javascript:void(0)" title="添加" style="width:70px" >
					<span class="check"><input class="input-check" onclick="opterClick(0)" id="problem_type_<?php echo $k;?>" value="<?php echo $v->id;?>" data-name="<?php echo $v->name;?>" type="checkbox"><label for="problem_type_<?php echo $k;?>"></label></span>
				</a>
			</div>
			<ul class="subnav-bd" style="display: none">
				<table  class="bnn" cellspacing="0" cellpadding="0" style="border-right-style:none;border-spacing:0px 0px;">
				<?php 
					$show=GfCustomerProblemType::model()->findAll("fater_id=".$v->id);
					foreach($show as $m=>$n){ ?>
						<tr>
							<td width="2%"></td>
							<td colspan="2"><?php echo $n->name;?></td>
							<td width="70%">
								<li><span class="check"><input class="input-check" onclick="opterClick(0)" id="problem_type_<?php echo $k;?>_<?php echo $m;?>" value="<?php echo $n->id;?>" data-name="<?php echo $n->name;?>" type="checkbox"><label for="problem_type_<?php echo $k;?>_<?php echo $m;?>"></label></span></li>
							</td>
						</tr>
				<?php } ?>
				</table>
			</ul>
		<?php } ?>
		</div>
		<input type="hidden" name="problem_type" id="problem_type" value="">
    </div><!--box-content end-->
</div><!--box end-->
<?php $this->endWidget();?>
<script>
$(function(){
    api = $.dialog.open.api;	// 			art.dialog.open扩展方法
    if (!api) return;

    // 操作对话框
    api.button({
		name:'确定',
        callback:function(){
			var problem_type=$("#problem_type").val();
			$.dialog.data('problem_type', problem_type);
			$.dialog.close();
        },
        focus:true
    },{
		name: '取消'
	});
	if($.dialog.data('problem_type')){
		var problem_type_json=$.parseJSON($.dialog.data('problem_type'));
		$.each(problem_type_json,function(k,v){
			$("input:checkbox[value='"+v.id+"']").trigger("click");
		})
	}else{
		$.dialog.data('problem_type','');
	}
});
$(".subnav-hd input:checkbox").on("click",function(){
	var hd=$(this).parents(".subnav-hd");
	var bds=hd.next(".subnav-bd").find("input:checkbox");
	var hd_checked=$(this).prop("checked");
	bds.prop("checked",hd_checked);
	val_problem_type();
})
$(".subnav-bd input:checkbox").on("click",function(){
	var bd=$(this).parents(".subnav-bd");
	var hd=bd.prev(".subnav-hd").find("input:checkbox");
	var bd_checked=$(this).prop("checked");
	if(bd_checked){
		var t_bd_num=bd.find("input:checkbox:checked").length;
		var bd_num=bd.find("input:checkbox").length;
		if(t_bd_num==bd_num){
			hd.prop("checked",true);
		}
	}else{
		hd.prop("checked",false);
	}
	val_problem_type();
})
function val_problem_type(){
	var problem_type=[];
	$(".subnav-hd input:checkbox").each(function(k){
		if($(this).is(":checked")){
			problem_type.push({"id":$(this).val(),"name":$(this).attr("data-name")});
		}else{
			$(this).parents(".subnav-hd").next(".subnav-bd").find("input:checkbox").each(function(m){
				if($(this).is(":checked")){
					problem_type.push({"id":$(this).val(),"name":$(this).attr("data-name")});
				}
			})
		}
	})
	$("#problem_type").val(JSON.stringify(problem_type));
}
</script>