<div class="box">
    <div class="box-title c">
        <h1>当前界面：首页》设置》账号密码</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
	<?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
   <div class="box-detail">
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table width="100%" class="mt15" style="table-layout:auto;">
                    <tr style="text-align:center;">
                        <td colspan="4">单位账号密码</td>
                    </tr>
                    <tr> 
                        <td width="15%">单位名称</td> 
                        <td width="85%">
                            <?php echo $model->lang_type==1?$model->admin_gfnick:$model->club_name; ?> 
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'password2'); ?></td>
                        <td>
                            <?php echo $form->passwordField($model, 'password2', array('class' => 'input-text','onChange' =>'verifyPassword(this)')); ?>
                            <?php echo $form->error($model, 'password2', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'password3'); ?></td>
                        <td>
                            <?php echo $form->passwordField($model, 'password3', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'password3', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'password4'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'password', array('class' => 'input-text')); ?>  
                            <?php echo $form->passwordField($model, 'password4', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'password4', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:center;">
                            <?php
                                echo show_shenhe_box(array('tongguo'=>'确定')).'&nbsp;<button class="btn" type="button" onclick="we.back();">取消</button>';
                            ?>
                        </td>
                    </tr>
                </table> 

            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    // 验证密码
    function verifyPassword(obj){
        console.log('ccc')
        var changval=$(obj).val();
        console.log(changval)
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('verifyPassword').'&id='.$model->id;?>&password='+changval,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                if(data.status==0){
                    $(obj).val('');
                    we.msg('minus', data.msg);
                }
            }
        });
    }

    $("#tongguo").on("click",function(){
        var change_password=$("#Clubadmin_password4").val();
        $("#Clubadmin_password").val(change_password)
    })
</script>