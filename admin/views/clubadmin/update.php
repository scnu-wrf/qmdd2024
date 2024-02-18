<?php
    if (isset( $_REQUEST['lang_type'] ) ) {
       $model->lang_type=$_REQUEST['lang_type'];//角色类型
    } 
    if ($model->lang_type>0) $model->club_id=get_session('club_id');
		$da=array("club_id"=>get_session("club_id"),"project_id"=>"0","code_type"=>"GL");
		$tname= (($model->lang_type==0) ?'平台单位' : get_session('club_name').'用户');
	if(empty($model->id)){
		$model->admin_gfaccount=" ";
	}
?>
<html>
<head>
	<link href="./layui/css/layui.css" rel="stylesheet">
</head>
<body>

<div class="box">
    <div class="box-title c">
    	<h1><i class="fa fa-table"></i>系统>权限管理><?php echo $tname; ?>授权>授权详情</h1>
		<span class="back">
			<a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a>
		</span>
	</div><!--box-title end-->
    <div class="box-detail">
     	<?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
			<div style="display:block;" class="box-detail-tab-item">
				<table class="mt15">
					<?php echo $form->hiddenField($model, 'id', array('class' => 'input-text',)); ?>
					<tr>
						<td width="10%"><?php echo $form->labelEx($model, 'admin_gfaccount'); ?></td>
						<td width="90%">
							<?php echo $form->textField($model, 'admin_gfaccount', array('class' => 'input-text','readonly'=>'ture','style'=>'width:200px;')); ?>
							<?php if(isset($isNew)){ ?>
							<input id="club_select_btn" class="btn" type="button" value="选择">
							<?php }; ?>
							<?php echo $form->error($model, 'admin_gfaccount', $htmlOptions = array()); ?>
						</td>
					</tr>
					<tr>
						<td ><?php echo $form->labelEx($model, 'admin_gfnick'); ?></td>
						<td >
							<?php echo $form->textField($model, 'admin_gfnick', array('class' => 'input-text','readonly'=>'ture','style'=>'width:200px;')); ?>
							<?php echo $form->error($model, 'admin_gfnick', $htmlOptions = array()); ?>
						</td>
					</tr>
					<tr>
						<td><?php echo $form->labelEx($model, 'password'); ?></td>
						<td id='funpsd'>
							<?php $password = empty($model->password) ? '123456' : $model->password; ?>
							<input class="input-text" type="password" style="width:200px;" name="Clubadmin[password]" id="Clubadmin_password" value="<?php echo $password; ?>" autocomplete="off">
							<span class="msg">注：默认登录密码为123456，添加成功后请尽快前往更新登录密码</span>
						</td>
					</tr>
					<tr>
						<td><?php echo $form->labelEx($model, 'pay_pass'); ?></td>
						<td id='funpsd'>
							<?php $pay_pass = empty($model->pay_pass) ? '123456' : $model->pay_pass; ?>
							<?php //echo $form->textField($model,'pay_pass',array('class'=>'input-text','type'=>'password','style'=>'width:200px;')); ?>
							<input class="input-text" type="password" style="width:200px;" name="Clubadmin[pay_pass]" id="Clubadmin_pay_pass" value="<?php echo $pay_pass; ?>" autocomplete="off">
							<span class="msg">注：默认支付密码为123456，添加成功后请尽快前往更新支付密码</span>
						</td>
					</tr>
					<!-- <tr> 
						<td><?php echo $form->labelEx($model, 'project_list'); ?></td>
						<td>
							<?php echo $form->hiddenField($model, 'project_list', array('class' => 'input-text',)); ?>
							<span id="project_box">
								<?php 
								if(!empty($project_list)){foreach($project_list as $v){?>
									<span class="label-box" id="project_item_<?php echo $v->project_id?>" data-id="<?php echo $v->project_id?>">
									<?php echo $v->project_list->project_name;?>
									<i onclick="fnDeleteProject(this);"></i>
									</span>
								<?php }}?>
							</span>
							<input id="project_add_btn" class="btn" type="button" value="添加">
							<?php echo $form->error($model, 'project_list', $htmlOptions = array()); ?>
						</td>
					</tr> -->
					<!-- <tr> 
						<td><?php echo $form->labelEx($model, 'project_list'); ?></td>
						<td>
							<div id="project_list">
								<?php foreach($roles['first'] as $k=>$v){ ?>
    							<input type="radio" id="scales<?php echo $k; ?>" name="f_rcode1" value="<?php echo $k; ?>" />
    							<label for="scales"><?php echo $v; ?></label>
    							<?php } ?>
  							</div>
						</td>
					</tr>
					<tr>
						<td><?php echo $form->labelEx($model, 'admin_level'); ?></td>
						<td id="admin_level">
							<?php foreach($roles['second']['A'] as $k=>$v){ ?>
    							<input type="checkbox" id="scales<?php echo $k; ?>" name="f_rcode2" value="<?php echo $v->f_rcode; ?>" />
    							<label for="scales"><?php echo $v->f_rname; ?></label>
    							<?php } ?>
						</td>
					</tr> -->
					<tr>
						<td><?php echo $form->labelEx($model, 'project_list'); ?></td>
						<td style="width:100%">
							<div class="layui-form">
  								<select lay-filter="demo-select-filter">
    							<option value="<?php echo $model->admin_level;?>">请选择</option>
    							<?php foreach($roles['first'] as $k=>$v){ ?>
    								<optgroup label="<?php echo $v;?>">
    									<?php foreach($roles['second'][$k] as $k2=>$v2){ ?>
      									<option value="<?php echo $v2->f_id;?>">
      									<?php echo $v.'-'.$v2->f_rname;?>
      									</option>
      								<?php } ?>
    							</optgroup>
    							<?php } ?>
  								</select>
							</div>
						</td>
						
					</tr>
					<!-- <tr>
						<td><?php echo $form->labelEx($model, 'admin_level'); ?></td>
						<td >
							<?php
								if($model->lang_type=="110" )  {
								$da2=$model->admin_level;
								$model->admin_level=$da2[0];
								echo $form->radioButtonList($model, 'admin_level',
								Chtml::listData(Role::model()->getLevel($model->lang_type,get_session('club_id')), 'f_id', 'f_rname'), 
								$htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
							<?php } else { ?>
								<?php
									echo $form->checkBoxList($model, 'admin_level', 
									Chtml::listData(Role::model()->getLevel($model->lang_type,get_session('club_id')), 'f_id', 'f_rname'),
									$htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
							<?php } ?>
							<?php echo $form->error($model, 'admin_level'); ?>
						</td>
					</tr> -->
					<!-- <tr>
						<td ><?php echo $form->labelEx($model, 'customer_service'); ?></td>
						<td >
							<?php
								echo $form->radioButtonList($model, 'customer_service',
								Chtml::listData(array(array('id'=>'0','name'=>'否'),array('id'=>'1','name'=>'是')), 'id', 'name'), 
								$htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
						</td>
					</tr> -->
				</table>
			</div><!--box-detail-tab-item end-->
		</div><!--box-detail-bd end-->
        <div class="box-detail-submit">
			<?php echo $form->textField($model, 'admin_gfid', array('class' => 'input-text','hidden'=>'ture')); ?>
			<?php echo $form->textField($model, 'club_id', array('class' => 'input-text','hidden'=>'ture')); ?>
			<?php echo $form->textField($model, 'lang_type', array('class' => 'input-text','hidden'=>'ture')); ?>
			<button class="btn btn-blue" onclick="update()" type="button">确认</button>
			<button class="btn" type="button" onclick="we.back();">取消</button>
		</div>
		<?php $this->endWidget();?>
	</div>
</div>

<script src="./layui/layui.js"></script> 
<script>
	var f_id="<?php echo $model->admin_level;?>";
	//选择框事件
	layui.use(function(){
  var form = layui.form;
  var layer = layui.layer;
  // select 事件
  form.on('select(demo-select-filter)', function(data){
     f_id=data.value;
    //layer.msg(this.innerHTML + ' 的 value: '+ data.value); // this 为当前选中 <option> 元素对象
  });
});
function update(){
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('update',array('id'=>$model->id));?>&f_id='+f_id+'&admin_gfaccount='+'<?php echo $model->admin_gfaccount; ?>'+'&admin_gfnick='+'<?php echo $model->admin_gfnick; ?>'+'&password='+'<?php echo $model->password; ?>'+'&pay_pass='+'<?php echo $model->pay_pass; ?>',
            data:{},
            contentType: 'application/json',
            dataType: 'json',
            success: function(data){
                if (data.status == 1) {
                        we.msg('check', data.msg, function() {
                            we.loading('hide');
                            we.back();
                        });
                    } else {
                        we.msg('error', data.msg, function() {
                            we.loading('hide');
                        });
                    }
            },
            errer: function(request){
                we.msg('minus','获取错误');
            }
        });
    }
	
	function read_club(){
		$.dialog.data('club_id', 0);
		$.dialog.open('<?php echo $this->createUrl("select/club", array('partnership_type'=>16));?>',{
			id:'danwei',lock:true,opacity:0.3,width:'500px',height:'60%',
			title:'选择俱乐部',
			close: function () {
				if($.dialog.data('club_id')>0){
				$('#Clubadmin_club_id').val($.dialog.data('club_id'));
				$('#Clubadmin_admin_gfaccount').val($.dialog.data('club_code'));
				$('#Clubadmin_admin_gfnick').val($.dialog.data('club_title'));
				}
			}
		});
	}

	function read_person(){
			$.dialog.data('admin_gfid', 0);
			$.dialog.open('<?php echo $this->createUrl("userlist/SelectUser",$da);?>&lang_type=1',{
				id:'fuwuzhe',lock:true,opacity:0.3,width:'500px',height:'60%',
				title:'选择会员',
				close: function () {
				if($.dialog.data('GF_ID')>0){
					$('#Clubadmin_admin_gfid').val($.dialog.data('GF_ID'));
					//$('#Clubadmin_admin_gfaccount').val($.dialog.data('GF_ACCOUNT')); 手机号代替gf账号
					$('#Clubadmin_admin_gfaccount').val($.dialog.data('security_phone'));
					$('#Clubadmin_admin_gfnick').val($.dialog.data('zsxm'));
				}
			}
		});    
	}
		
	// 删除已添加项目
	var fnDeleteProject=function(op){
		$(op).parent().remove();
		fnUpdateProject();
	};
	// 项目添加或删除时，更新
	var fnUpdateProject=function(){
		var arr=[];
		$('#project_box span').each(function(){
			arr.push($(this).attr('data-id'));
		});
		$('#Clubadmin_project_list').val(we.implode(',',arr));
	};
	fnUpdateProject();

	$(function(){
		// 添加项目
		var $project_box=$('#project_box');
		$('#project_add_btn').on('click', function(){
			$.dialog.data('project_id', 0);
			$.dialog.open('<?php echo $this->createUrl("select/project", array("club_id"=>get_session("club_id")));?>',{
				id:'xiangmu',
				lock:true,
				opacity:0.3,
				title:'选择具体内容',
				width:'500px',
				height:'60%',
				close: function () {
					if($.dialog.data('project_id')==-1){
						var boxnum=$.dialog.data('project_title');
						for(var j=0;j<boxnum.length;j++) {
							if($('#project_item_'+boxnum[j].dataset.id).length==0){
								var s1='<span class="label-box" id="project_item_'+boxnum[j].dataset.id;
								s1=s1+'" data-id="'+boxnum[j].dataset.id+'">'+boxnum[j].dataset.title;
								$project_box.append(s1+'<i onclick="fnDeleteProject(this);"></i></span>');
								fnUpdateProject(); 
							}
						}
					}
				}
			});
		});
	});
	
 </script>
</body>
</html>
