
<style>
    table{
        table-layout:auto!important;
    }
</style>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：会员》龙虎会员管理》龙虎会员列表》添加</h1><span class="back">
        <a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    
     <?php $form = $this->beginWidget('CActiveForm', get_form_list());?>
    <div class="box-detail">
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table class="mt15">
                	<tr class="table-title">
                    	<td colspan="4" >项目信息</td>
                    </tr>
                    <tr>
                        <?php echo $form->hiddenField($model, 'logon_way', array('value' => 1375)); ?>
                        <td width="100px">
                          <?php echo $form->labelEx($model, 'member_project_id'); ?>
                        </td>
                        <td colspan="3">
                          <?php echo $form->dropDownList($model, 'member_project_id', Chtml::listData(ProjectList::model()->getProject(), 'id', 'project_name'), array('prompt' => '请选择', 'onchange' => 'changeTr(this);'));?>
                          <?php echo $form->error($model, 'member_project_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <!-- <tr>
                        <td class="fontStyle1"><?php //echo $form->labelEx($model, 'certificate_type'); ?></td>
                        <td>
                            <?php //echo $form->hiddenField($model, 'certificate_type', array('class' => 'input-text')); ?>
                            <span id="certificate_box">
                                <?php //if(!empty($model->certificate_type)) { ?>
                                    <span class="label-box">
                                        <?php //echo $model->qualification_title;?>
                                    </span>
                                <?php //} ?>
                            </span>
                            <input id="certificate_select_btn" class="btn" type="button" value="选择">
                            <?php //echo $form->error($model, 'certificate_type', $htmlOptions = array()); ?>
                        </td>
                        <td class="fontStyle1"><?php //echo $form->labelEx($model, 'qualification_code'); ?></td>
                        <td>
                            <?php //echo $form->textField($model, 'qualification_code', array('class' => 'input-text')); ?>
                            <?php //echo $form->error($model, 'qualification_code', $htmlOptions = array()); ?>
                        </td>
                    -->
                    <!-- <tr>
                        <td class="fontStyle1"><?php //echo $form->labelEx($model, 'qualification_image'); ?></td>
                        <td colspan="3">
                            <?php //echo $form->hiddenField($model, 'qualification_image', array('class' => 'input-text fl')); ?>
                            <?php //$basepath=BasePath::model()->getPath(123);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php //if($model->qualification_image!=''){?><div class="upload_img fl" id="upload_pic_<?php //echo get_class($model);?>_qualification_image"><a href="<?php //echo $basepath->F_WWWPATH.$model->qualification_image;?>" target="_blank"><img src="<?php //echo $basepath->F_WWWPATH.$model->qualification_image;?>" width="70"></a></div><?php //}?>
                            <script>we.uploadpic('<?php //echo get_class($model);?>_qualification_image', '<?php //echo $picprefix;?>');</script>
                            <?php //echo $form->error($model, 'qualification_image', $htmlOptions = array()); ?>
                        </td>
                    </!--> 
                    <tr>
                        <td class="fontStyle1"><?php echo $form->labelEx($model, 'gf_account'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'gf_account', array('class' => 'input-text')); ?>
                            <?php echo $form->hiddenField($model, 'member_gfid'); ?>
                            <span id="account_box">
                            <?php if($model->gf_account!=null){?>
                            <span class="label-box"><?php echo $model->gf_account;?></span>
                            <?php }?>
                            </span>
                            <input id="account_select_btn" class="btn" type="button" value="选择">
                            <?php echo $form->error($model, 'gf_account', $htmlOptions = array()); ?>
                        </td>
                        <td class="fontStyle1"><?php echo $form->labelEx($model, 'zsxm'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'zsxm', array('class' => 'input-text','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'zsxm', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="fontStyle1"><?php echo $form->labelEx($model, 'project_level_xh'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'project_level_id', array('class' => 'input-text')); ?>
                            <!-- <?php //echo $form->hiddenField($model, 'project_level_xh'); ?> -->
                            <!-- <span id="level_box">
                            <?php //if($model->project_level_name!=null){?>
                            <span class="label-box"><?php //echo $model->project_level_name;?></span>
                            <?php //}?>
                            </span> -->
                            <select name="ClubMemberList[project_level_xh]" id="ClubMemberList_project_level_xh" onchange="getScore(this)">
                            <option value="">请选择</option>
                            </select>
                            <?php echo $form->error($model, 'project_level_xh', $htmlOptions = array()); ?>
                        </td>
                        <td class="fontStyle1"><?php echo $form->labelEx($model, 'integral'); ?></td>
                        <td>
                            <!-- <span id="integral_box"><?php //echo $model->integral; ?></span> -->
                            <?php echo $form->textField($model, 'integral', array('class' => 'input-text','readonly'=>'readonly','style'=>'border:none;')); ?>
                            <?php echo $form->error($model, 'integral', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>可执行操作</td>
                        <td colspan="3">
                        <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
<?php $this->endWidget();?>
  </div><!--box-detail end-->
</div><!--box end-->
<script>
    //选择证书等级
    var $certificate_box=$('#certificate_box');
    $('#certificate_select_btn').on('click', function(){
        $.dialog.data('id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/certificate_type");?>',{
        id:'zhengshu',
		lock:true,opacity:0.3,
		width:'500px',
		height:'60%',
        title:'选择具体内容',		
        close: function () {
            if($.dialog.data('id')>0){
                $('#ClubMemberList_certificate_type').val($.dialog.data('id'));
                $certificate_box.html('<span class="label-box">'+$.dialog.data('F_NAME')+'</span>');                
            }
         }
       });
    });

    
	// 选择账号
    var $account_box=$('#account_box');
    $('#account_select_btn').on('click', function(){
		var type_id = $('#ClubMemberList_logon_way').val(); 
		var project_id = $('#ClubMemberList_member_project_id').val(); 
        $.dialog.data('GF_ID', 0);
        $.dialog.open('<?php echo $this->createUrl("select/gfuser");?>',{
        id:'gfzhanghao',
		lock:true,opacity:0.3,
		width:'500px',
		height:'60%',
        title:'选择具体内容',		
        close: function () {
            if($.dialog.data('GF_ID')>0){
                if($.dialog.data('passed')==2){
                    $('#ClubMemberList_gf_account').val($.dialog.data('GF_ACCOUNT'));
                    $('#ClubMemberList_member_gfid').val($.dialog.data('GF_ID'));
                    $('#ClubMemberList_zsxm').val($.dialog.data('zsxm'));
                    $account_box.html('<span class="label-box">'+$.dialog.data('GF_ACCOUNT')+'</span>');  
                    getLevel($.dialog.data('GF_ID'),project_id);
                }else{
                    we.msg('minus','该账号未实名');
                }
            }
         }
       });
    });

    function changeTr(e){
		var gfId = $('#ClubMemberList_member_gfid').val(); 
		var projectId = $(e).val(); 
        getLevel(gfId,projectId)
    }
    var integral=0;
    function getLevel(gfId,projectId){
       $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('getLevel');?>&gf_id='+gfId+'&project_id='+projectId,
            dataType: 'json',
            success: function(e) {
                console.log(e)
                var data=e.data;
                integral=e.integral;
                var content='<option value="">请选择</option>';
                $.each(data,function(k,info){
                    content+='<option value="'+info.member_level_xh+'" level_id="'+info.member_level+'" card_score="'+info.card_score+'"';
                    if(info.member_level_xh==e.level_xh){
                        content+='selected disabled="disabled"';
                    }
                    content+='>'+info.member_level_name+'</option>'
                })
                $("#ClubMemberList_project_level_xh").html(content);
                $("#ClubMemberList_integral").val(integral);  
            }
        });
    }
    function getScore(e){
        var score=$(e).find('option:selected').attr('card_score');
        if(score>integral){
            $("#ClubMemberList_integral").val(score);
        }else{
            $("#ClubMemberList_integral").val(integral);
        }
    }
</script>