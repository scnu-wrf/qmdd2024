
<div class="box">
    <div class="box-title c">
    <h1><i class="fa fa-table"></i>添加客服</h1><span class="back">
    <a class="btn" href="javascript:;" onclick="we.back();">
    <i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
        <div style="display:block;" class="box-detail-tab-item">
        <table class="mt15">
			<tr>
				<td width="10%">客服账号</td>
				<td width="90%">
					<?php 
						if(!empty($model->id)){
							$server=Yii::app()->db->createCommand("select q.admin_gfaccount,q.admin_gfnick,u.ZSXM as admin_name from userlist u,qmdd_administrators q where q.id=".$model->admin_id." and q.admin_gfid=u.GF_ID")->queryRow();
						}
					?>
					<input class="input-text" readonly="readonly" style="width:200px;" id="admin_gfaccount" type="text" value="<?php echo (empty($model->id)?"":$server["admin_gfaccount"]);?>" autocomplete="off">
					<input id="account_select_btn" class="btn" type="button" value="选择"><?php echo $form->error($model, 'admin_id'); ?>
					<?php echo $form->hiddenField($model, 'admin_id', array('class' => 'input-text',)); ?>
					<?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text',"value"=>get_session("club_id"))); ?>
					<?php $customer_type_set=Yii::app()->db->createCommand("select * from gf_customer_type_set where type_1=".$_SESSION["club_type"]." and type_2=".$_SESSION["partnership_type"])->queryRow();?>
					<?php echo $form->hiddenField($model, 'customer_service_type', array('class' => 'input-text',"value"=>$customer_type_set["customer_service_type"])); ?>
				</td>
			</tr>
			<tr>
				<td >客服姓名</td>
				<td ><input class="input-text" readonly="readonly" style="width:200px;" id="admin_name" type="text" value="<?php echo (empty($model->id)?"":$server["admin_name"]);?>" autocomplete="off"></td>
			</tr>
			<tr>
				<td >客服工号</td>
				<td ><?php echo $form->textField($model, 'service_no', array('class' => 'input-text','style'=>'width:200px;')); ?><?php echo $form->error($model, 'service_no'); ?></td>
			</tr>
			<tr>
				<td >客服昵称</td>
				<td ><?php echo $form->textField($model, 'admin_nick', array('class' => 'input-text','style'=>'width:200px;')); ?><?php echo $form->error($model, 'admin_nick'); ?></td>
			</tr>
			<tr>
				<td >联系电话</td>
				<td ><?php echo $form->textField($model, 'phone', array('class' => 'input-text','style'=>'width:200px;')); ?><?php echo $form->error($model, 'phone'); ?></td>
			</tr>
			<tr>
				<td >客服角色</td>
				<td ><?php $level=array(array("id"=>"1","name"=>"超级管理员"),array("id"=>"2","name"=>"专线客服")); echo $form->dropDownList($model, 'service_level', Chtml::listData($level, 'id', 'name'), array('prompt'=>'请选择','style'=>'width:218px;')); ?><?php echo $form->error($model, 'service_level'); ?><?php echo $form->hiddenField($model, 'service_level_name', array('class' => 'input-text',)); ?></td>
			</tr>
        </table>
        </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <div class="box-detail-submit">
 <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
  <button class="btn" type="button" onclick="we.back();">取消</button>
 </div>

<?php $this->endWidget();?>

</div>
</div>
<script>
<?php if(!empty($model->id)){?>
	$.dialog.data('admin_id', $("#ClubServiceMember_admin_id").val());
	$.dialog.data('admin_name',$("#admin_name").val());
	$.dialog.data('admin_gfaccount', $("#admin_gfaccount").val());
	$.dialog.data('admin_gfnick', $("#admin_gfnick").val());
<?php }?>
$('#account_select_btn').on('click', function(){
	$.dialog.open('<?php echo $this->createUrl("customer_service_list");?>&club_id=<?php echo get_session("club_id")?>',{
		id:'fuwuzhe',lock:true,opacity:0.3,width:'60%',height:'60%',
		title:'选择具体内容',
		close: function () {
			$("#ClubServiceMember_admin_id").val($.dialog.data('admin_id'));
			$("#admin_gfaccount").val($.dialog.data('admin_gfaccount'));
			$("#ClubServiceMember_admin_nick").val($.dialog.data('admin_gfnick'));
			$("#admin_name").val($.dialog.data('admin_name'));
		}
	});
})
$("#ClubServiceMember_service_level").on("change",function(){
	$("#ClubServiceMember_service_level_name").val($("#ClubServiceMember_service_level option:selected").html())
})
</script>
