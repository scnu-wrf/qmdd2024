<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i><?php if(empty($model->id)) {?>添加客服类型设置<?php }else{?>编辑客服类型设置<?php }?></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
	<div class="box-detail">
		<?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
		<div class="box-detail-bd">
			<table>
                <tr>
                    <td><?php echo $form->labelEx($model, 'type_1'); ?></td>
                    <td>
						<?php $PARTNAME=array(array("id"=>"8","name"=>"社区单位"),array("id"=>"189","name"=>"战略伙伴"),array("id"=>"1086","name"=>"集团公司")); echo $form->dropDownList($model, 'type_1', Chtml::listData($PARTNAME, 'id', 'name'), array('prompt'=>'请选择')); ?><?php echo $form->error($model,'type_1'); ?><?php echo $form->hiddenField($model, 'type_name_1', array('class' => 'input-text','value'=>(empty($model->id))?'':$model->type_name_1)); ?>
					</td>
					<script>
						var PARTNAME_8=[];
						var PARTNAME_189=[];
						var PARTNAME_1086=[];
						var ProblemType=[];
						<?php 
							$PARTNAME_8=ClubType::model()->findAllBySql("select a.* from club_type as a,(select * from club_type where f_id=1467) as b where left(a.f_ctcode,3)=b.f_ctcode and a.f_level=2");
							$PARTNAME_189=ClubType::model()->findAllBySql("select a.* from club_type as a,(select * from club_type where f_id=1124) as b where left(a.f_ctcode,3)=b.f_ctcode and a.f_level=2");
							$PARTNAME_1086=ClubType::model()->findAllBySql("select a.* from club_type as a,(select * from club_type where f_id=1125) as b where left(a.f_ctcode,3)=b.f_ctcode and a.f_level=2");
							$ProblemType=GfCustomerProblemType::model()->findAll();
							foreach($PARTNAME_8 as $k=>$v){?>PARTNAME_8[<?php echo $k; ?>]={"id":"<?php echo $v->id;?>","name":"<?php echo $v->f_ctname;?>"};<?php } ?>
						<?php foreach($PARTNAME_189 as $k=>$v){?>PARTNAME_189[<?php echo $k; ?>]={"id":"<?php echo $v->id;?>","name":"<?php echo $v->f_ctname;?>"};<?php } ?>
						<?php foreach($PARTNAME_1086 as $k=>$v){?>PARTNAME_1086[<?php echo $k; ?>]={"id":"<?php echo $v->id;?>","name":"<?php echo $v->f_ctname;?>"};<?php } ?>
						<?php foreach($ProblemType as $k=>$v){?>ProblemType[<?php echo $k; ?>]={"id":"<?php echo $v->id;?>","name":"<?php echo $v->name;?>"};<?php } ?>
						$("#GfCustomerTypeSet_type_1").on("change",function(){
							$("#GfCustomerTypeSet_type_name_1").val($(this).find("option:selected").text());
							$("#GfCustomerTypeSet_type_name_2").val("");
							var options='<option value="">请选择</option>';
							if($(this).val()==8){
								$.each(PARTNAME_8,function(k,v){
									options+='<option value="'+v["id"]+'">'+v["name"]+'</option>';
								})
							}else if($(this).val()==189){
								$.each(PARTNAME_189,function(k,v){
									options+='<option value="'+v["id"]+'">'+v["name"]+'</option>';
								})
							}else if($(this).val()==1086){
								$.each(PARTNAME_1086,function(k,v){
									options+='<option value="'+v["id"]+'">'+v["name"]+'</option>';
								})
							}
							$("#GfCustomerTypeSet_type_2").html(options);
							$("#GfCustomerTypeSet_type_2").on("change",function(){
								$("#GfCustomerTypeSet_type_name_2").val($(this).find("option:selected").text());
							})
						})
					</script>
                </tr>
				<tr>
					<td><?php echo $form->labelEx($model, 'type_2'); ?></td>
                    <td>
						<select name="GfCustomerTypeSet[type_2]" id="GfCustomerTypeSet_type_2">
							<option value="">请选择</option>
							<?php if(!empty($model->id)) {
								if(($model->type_1)=="8"){
									foreach($PARTNAME_8 as $k=>$v){?>
										<option value="<?php echo $v->id; ?>"<?php echo ($v->id==$model->type_2)?' selected="selected"':''; ?>><?php echo $v->f_ctname; ?></option>
									<?php }
								}else if(($model->type_1)=="189"){
									foreach($PARTNAME_189 as $k=>$v){?>
										<option value="<?php echo $v->id; ?>"<?php echo ($v->id==$model->type_2)?' selected="selected"':''; ?>><?php echo $v->f_ctname; ?></option>
									<?php }
								}else if(($model->type_1)=="1086"){
									foreach($PARTNAME_1086 as $k=>$v){?>
										<option value="<?php echo $v->id; ?>"<?php echo ($v->id==$model->type_2)?' selected="selected"':''; ?>><?php echo $v->f_ctname; ?></option>
									<?php }
								}
							}?>
						</select>
						<?php echo $form->error($model,'type_2'); ?><?php echo $form->hiddenField($model, 'type_name_2', array('class' => 'input-text','value'=>(empty($model->id))?'':$model->type_name_2)); ?>
					</td>
				</tr>
				<tr>
                    <td><?php echo $form->labelEx($model, 'customer_service_type'); ?></td>
                    <td>
						<?php $customer_service_type_list=array(array("id"=>"1","name"=>"平台客服"),array("id"=>"2","name"=>"商城客服"),array("id"=>"3","name"=>"单位客服")); echo $form->dropDownList($model, 'customer_service_type', Chtml::listData($customer_service_type_list, 'id', 'name'), array('prompt'=>'请选择')); ?><?php echo $form->error($model,'customer_service_type'); ?>
					</td>
                </tr>
				<tr>
					<td><?php echo $form->labelEx($model, 'problem_type'); ?></td>
                    <td>
						<span id="problem_type_box">
							
						</span>
						<input id="problem_type_btn" class="btn" type="button" value="选择">
						<?php echo $form->hiddenField($model, 'problem_type', array('class' => 'input-text','value'=>(empty($model->id))?'':$model->problem_type)); ?>
						<?php echo $form->error($model,'problem_type'); ?>
						<script>
						var problem_type_json=[];
						$.each(ProblemType,function(k,v){
							$.each($("#GfCustomerTypeSet_problem_type").val().split(","),function(m,n){
								if(n==v.id){
									problem_type_json.push({"id":v.id,"name":v.name});
									var s1='<span class="label-box" id="problem_item_'+v.id;
									s1=s1+'" data-id="'+v.id+'">'+v.name;
									$("#problem_type_box").append(s1+'<i onclick="fnDeleteClub(this);"></i></span>');
								}
							})
						})
						$.dialog.data('problem_type',JSON.stringify(problem_type_json))
						</script>
					</td>
				</tr>
            </table>
		</div><!--box-detail-bd end-->
		<div id="operate" class="mt15" style="text-align:center;">
			<?php echo show_shenhe_box(array('baocun'=>'保存'));?>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>
		<?php $this->endWidget(); ?>
	</div><!--box-table end-->
</div><!--box end-->
<script>
$('#problem_type_btn').on('click', function(){
	// $.dialog.data('problem_type', '');
	var url='<?php echo $this->createUrl("select/problem_type");?>';
	$.dialog.open(url,{
		id:'yewuleixing',
		lock:true,
		opacity:0.3,
		title:'选择具体内容',
		width:'500px',
		height:'60%',
		close: function () {
			if($.dialog.data('problem_type')!=""){
				var problem_type_json=$.parseJSON($.dialog.data('problem_type'));
				var problem_type=[];
				$("#problem_type_box").empty();
				$.each(problem_type_json,function(k,v){
					problem_type.push(v.id);
					var s1='<span class="label-box" id="problem_item_'+v.id;
					s1=s1+'" data-id="'+v.id+'">'+v.name;
					$("#problem_type_box").append(s1+'<i onclick="fnDeleteClub(this);"></i></span>');
				})
				$("#GfCustomerTypeSet_problem_type").val(problem_type.join());
			}
		}
	});
});
var fnDeleteClub=function(op){
	$(op).parent().remove();
	var problem_type=[];
	var problem_type_json=[];
	$("#problem_type_box .label-box").each(function(k){
		problem_type.push($(this).attr("data-id"));
		problem_type_json.push({"id":$(this).attr("data-id"),"name":$(this).text()});
	})
	$.dialog.data('problem_type',JSON.stringify(problem_type_json));
	$("#GfCustomerTypeSet_problem_type").val(problem_type.join());
};
</script>