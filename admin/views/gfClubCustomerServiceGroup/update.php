<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i><?php if(empty($model->id)) {?>添加客服组<?php }else{?>编辑客服组<?php }?></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
	<div class="box-detail">
		<?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
		<?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value'=>(empty($model->id))?$_SESSION["club_id"]:$model->club_id)); ?>
		<div class="box-detail-bd">
			<table>
                <tr>
                    <td><?php echo $form->labelEx($model, 'group_name'); ?></td>
                    <td>
						<?php echo $form->textField($model, 'group_name', array('class' => 'input-text')); ?><?php echo $form->error($model,'group_name'); ?>
					</td>
					<script>
						var ProblemType=[];
						<?php 
							$ProblemType=GfCustomerProblemType::model()->findAll(); ?>
						<?php foreach($ProblemType as $k=>$v){?>ProblemType[<?php echo $k; ?>]={"id":"<?php echo $v->id;?>","name":"<?php echo $v->name;?>"};<?php } ?>
					</script>
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
							$.each($("#ServiceGroup_problem_type").val().split(","),function(m,n){
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
		<?php if(!empty($model->id)){?>
		<div class="box-detail-bd" style="margin-top: 10px;">
			<div style="overflow: hidden;"><span style="float: left;font-size: larger;margin-bottom: 10px;">【<?php echo $model->group_name;?>】客服成员列表</span><a href="javascript:;" id="add_group_member" style="float: right;font-size: larger;margin-bottom: 10px;">添加组成员</a></div>
			<table class="table-title">
                <tr>
                    <td style="text-align:center;">序号</td>
                    <td style="text-align:center;">客服工号</td>
                    <td style="text-align:center;">客服账号</td>
                    <td style="text-align:center;">客服姓名</td>
                    <td style="text-align:center;">客服昵称</td>
                    <td style="text-align:center;">客服角色</td>
                    <td style="text-align:center;">所属客服组</td>
                    <td style="text-align:center;">账号状态</td>
                    <td style="text-align:center;">在线状态</td>
                    <td style="text-align:center;">最近登录时间</td>
                    <td style="text-align:center;">操作</td>
                </tr>
			</table>
			<?php 
			$group_member=Yii::app()->db->createCommand("select a.*,b.admin_gfid,b.admin_gfaccount,b.admin_gfnick,b.is_on_line,b.last_login,GROUP_CONCAT(g.group_name) as group_name,u.ZSXM from service_group_member as a,qmdd_administrators as b,gf_user_1 as u,service_group g where find_in_set('{$model->id}',a.group_id) and a.admin_id=b.id and u.GF_ID=b.admin_gfid and find_in_set(g.id,a.group_id)")->queryAll();
			?>
			<table id="group_member">
			<?php if(!empty($group_member[0]['id'])){foreach($group_member as $k=>$v){?>
				<tr data-id="<?php echo $v["id"];?>">
					<td style="text-align:center;"><?php echo ($k+1);?></td>
                    <td style="text-align:center;"><?php echo $v["service_no"];?></td>
                    <td style="text-align:center;"><?php echo $v["admin_gfaccount"];?></td>
                    <td style="text-align:center;"><?php echo $v["ZSXM"];?></td>
                    <td style="text-align:center;"><?php echo $v["admin_nick"];?></td>
                    <td style="text-align:center;"><?php echo $v["service_level_name"];?></td>
                    <td style="text-align:center;"><?php echo $v["group_name"];?></td>
                    <td style="text-align:center;"><?php echo $v["state"]==649?'启用':'停用';?></td>
                    <td style="text-align:center;"><?php echo $v["is_on_line"]==947?'在线':'离线';?></td>
                    <td style="text-align:center;"><?php echo $v["last_login"];?></td>
                    <td style="text-align:center;"><a class="btn" href="javascript:;" onclick="del_group_member(this)">删除</a>
				</tr>
			<?php }}?>
			</table>
		</div><!--box-detail-bd end-->
		<?php }?>
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
	var url='<?php echo $this->createUrl("select/club_problem_type");?>&type_1=<?php echo $_SESSION["club_type"]?>&type_2=<?php echo $_SESSION["partnership_type"]?>';
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
				console.log(problem_type)
				$("#ServiceGroup_problem_type").val(problem_type.join());
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
	$("#ServiceGroup_problem_type").val(problem_type.join());
};
$('#add_group_member').on('click', function(){
	$.dialog.data('server_json',"");
	var url='<?php echo $this->createUrl("customer_service_list");?>&group_id=<?php echo $model->id?>';
	$.dialog.open(url,{
		id:'addgroupmember',
		lock:true,
		opacity:0.3,
		title:'添加组成员',
		width:'60%',
		height:'60%',
		close: function () {
			if($.dialog.data('server_json')!=""){
				var server_json=$.parseJSON($.dialog.data('server_json'));
				console.log(server_json)
				var ids=[];
				$.each(server_json,function(k,v){
					ids.push(v["id"]);
				});
				console.log(ids)
				$.ajax({
					type: "post",
					url:'<?php echo $this->createUrl("add_group_member");?>',
					data:{ids:ids.join(),group_id:'<?php echo $model->id?>'},
					dataType:"json",
					error: function(request) {
						we.msg('minus','添加失败');
					},
					success: function(data) {
						we.msg('minus','添加成功');
						var content='';
						$.each(server_json,function(k,v){
							content+='<tr data-id="'+v["id"]+'">'+
							'<td style="text-align:center;">'+($("#group_member tr").length+k+1)+'</td>'+
							'<td style="text-align:center;">'+v["service_no"]+'</td>'+
							'<td style="text-align:center;">'+v["admin_gfaccount"]+'</td>'+
							'<td style="text-align:center;">'+v["admin_name"]+'</td>'+
							'<td style="text-align:center;">'+v["admin_gfnick"]+'</td>'+
							'<td style="text-align:center;">'+v["service_level_name"]+'</td>'+
							'<td style="text-align:center;">'+v["group_name"]+',<?php echo $model->group_name;?>'+'</td>'+
							'<td style="text-align:center;">'+v["state"]+'</td>'+
							'<td style="text-align:center;">'+v["is_on_line"]+'</td>'+
							'<td style="text-align:center;">'+v["last_login"]+'</td>'+
							'<td style="text-align:center;"><a class="btn" href="javascript:;" onclick="del_group_member(this)">删除</a>';
						})
						$("#group_member").append(content);
					}
				});
				
			}
		}
	});
});
function del_group_member(op){
	var id=$(op).parents("tr").attr("data-id");
	$.ajax({
		type: "post",
		url:'<?php echo $this->createUrl("del_group_member");?>',
		data:{id:id,group_id:'<?php echo $model->id?>'},
		dataType:"json",
		error: function(request) {
			we.msg('minus','添加失败');
		},
		success: function(data) {
			$(op).parents("tr").remove();
		}
	});
}
</script>