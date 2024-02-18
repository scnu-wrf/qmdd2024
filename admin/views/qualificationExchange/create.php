<div class="box">
    <div class="box-title c"><h1>当前界面：会员 》龙虎会员管理 》资质置换龙虎积分 》添加</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
            <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
			<table class="detail" border="0" style="width:65%">
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'gf_account'); ?>：</th>
                    <td colspan="3">
                        <?php echo $form->hiddenField($model, 'gf_account', array('class' => 'input-text')); ?>
                        <?php echo $form->hiddenField($model, 'get_score_gfid'); ?>
                        <span id="account_box">
                        <?php if($model->gf_account!=null){?>
                        <span class="label-box"><?php echo $model->gf_account;?></span>
                        <?php }?>
                        </span>
                        <input id="account_select_btn" class="btn" type="button" value="选择">
                        <?php echo $form->error($model, 'gf_account', $htmlOptions = array()); ?>
                    </td>
                </tr>
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'zsxm'); ?>：</th>
                    <td colspan="3">
                        <?php echo $form->textField($model, 'zsxm', array('class' => 'input-text','readonly'=>'readonly','style'=>'width:200px','placeholder'=>'请选择GF账号')); ?>
                        <?php echo $form->error($model, 'zsxm', $htmlOptions = array()); ?>
                    </td>
                </tr>
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'get_score_project_id'); ?>：</th>
                    <td colspan="3">
                        <?php echo $form->dropDownList($model, 'get_score_project_id', Chtml::listData(ProjectList::model()->getProject(), 'id', 'project_name'), array('prompt' => '请选择', 'onchange' => 'changeTr(this);'));?>
                        <?php echo $form->error($model, 'get_score_project_id', $htmlOptions = array()); ?>
                    </td>
                </tr>
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'type_id'); ?>：</th>
                    <td colspan="3">
                        <?php echo $form->dropDownList($model, 'type_id', Chtml::listData(ClubServicerType::model()->findAll('type=501'), 'member_second_id', 'member_second_name'), array('prompt' => '请选择'));?>
                        <?php echo $form->error($model, 'type_id', $htmlOptions = array()); ?>
                    </td>
                </tr>
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'qua_id'); ?>：</th>
                    <td colspan="3">
                        <?php echo $form->hiddenField($model, 'qua_id', array('class' => 'input-text')); ?>
                        <span id="certificate_box">
                            <?php if(!empty($model->qua_id)) { ?>
                                <span class="label-box">
                                    <?php echo $model->person_name;?>
                                </span>
                            <?php } ?>
                        </span>
                        <input id="certificate_select_btn" class="btn" type="button" value="选择">
                        <?php echo $form->error($model, 'qua_id', $htmlOptions = array()); ?>
                    </td>
                </tr>
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'person_code'); ?>：</th>
                    <td colspan="3">
                        <?php echo $form->textField($model, 'person_code', array('class' => 'input-text','style'=>'width:200px')); ?>
                        <?php echo $form->error($model, 'person_code', $htmlOptions = array()); ?>
                    </td>
                </tr>
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'person_pic'); ?>：</th>
                    <td colspan="3">
                        <?php echo $form->hiddenField($model, 'person_pic', array('class' => 'input-text fl')); ?>
                        <?php $basepath=BasePath::model()->getPath(123);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <?php if($model->person_pic!=''){?>
                            <div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_person_pic">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->person_pic;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$model->person_pic;?>" width="70">
                                </a>
                            </div>
                        <?php }?>
                        <script>we.uploadpic('<?php echo get_class($model);?>_person_pic', '<?php echo $picprefix;?>');</script>
                        <?php echo $form->error($model, 'person_pic', $htmlOptions = array()); ?>
                    </td>
                </tr>
				
				<tr>
                    <th class="detail-hd" style="text-align: right;"><?php echo $form->labelEx($model, 'get_score'); ?>：</th>
                    <td colspan="3" style="font: bold;font-size: 36px; color: #EF5510;">
                        <?php echo $form->hiddenField($model, 'get_score'); ?>
                     	<span id="score_box"><?php echo  $model->get_score ?></span>
                    </td>
                </tr>
                <?php if($model->state==371){?>
				<tr>
					<th class="detail-hd" style="text-align: right">可执行操作：</th>
					<td colspan="3">
						 <?php echo show_shenhe_box(array('tongguo'=>'保存'));?>
                         <button class="btn" type="button" onclick="we.back();">取消</button>
					</td>
				</tr>
                <?php }?>
			</table>
           
            <?php $this->endWidget(); ?>
        </div><!--box-table end-->
    </div><!--box-content end-->
</div><!--box end-->
<script>
	// 选择账号
    var $account_box=$('#account_box');
    $('#account_select_btn').on('click', function(){
        $.dialog.data('GF_ID', 0);
        $.dialog.open('<?php echo $this->createUrl("select/gfuser");?>',{
        id:'gfzhanghao',
		lock:true,opacity:0.3,
		width:'500px',
		height:'60%',
        title:'选择具体内容',		
        close: function () {
            if($.dialog.data('GF_ID')>0){
                console.log($.dialog.data('passed'))
                if($.dialog.data('passed')==372){
                    $('#QualificationExchange_get_score_gfid').val($.dialog.data('GF_ID'));
                    $('#QualificationExchange_gf_account').val($.dialog.data('GF_ACCOUNT'));
                    $('#QualificationExchange_zsxm').val($.dialog.data('zsxm'));
                    $account_box.html('<span class="label-box">'+$.dialog.data('GF_ACCOUNT')+'</span>');  
                }else{
                    we.msg('minus','该账号未实名');
                }
            }
         }
       });
    });
    
    //选择证书等级
    var $certificate_box=$('#certificate_box');
    $('#certificate_select_btn').on('click', function(){
		var type_id = $('#QualificationExchange_type_id').val(); 
        if(type_id==''){
            we.msg('minus','请选择资质类型');
            return false;
        }
        $.dialog.data('id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/certificate_type");?>&type_id='+type_id,{
            id:'zhengshu',
            lock:true,opacity:0.3,
            width:'500px',
            height:'60%',
            title:'选择具体内容',		
            close: function () {
                if($.dialog.data('id')>0){
                    $('#QualificationExchange_qua_id').val($.dialog.data('id'));
                    $certificate_box.html('<span class="label-box">'+$.dialog.data('fater_name')+'-'+$.dialog.data('F_NAME')+'</span>');    
                    $("#score_box").html($.dialog.data('F_COL3'));        
                }
            }
       });
    });
</script>