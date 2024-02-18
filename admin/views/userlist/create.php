<?php
//$_REQUEST['passed'] == 136 =>选择 '注册'进入的该页面
//$_REQUEST['passed'] == 2 =>选择 '实名注册'进入的该页面
    $txt = '';
    if($_REQUEST['passed'] == 136) {
        $txt = '注册账号';
    } else if($_REQUEST['passed'] == 2 && empty($model->GF_ID)) {
        $txt = '实名注册';
    } // else if($_REQUEST['passed'] == 2 && !empty($model->GF_ID)) {
        // $txt = '账号实名';
    // }
    if(!isset($_REQUEST['action'])) $_REQUEST['action'] = '';
    if($_REQUEST['action'] == 'realname') {
        $txt = '账号实名';
    }
    //如果是已经注册再来实名认证flag为false;
    $flag=empty($model->GF_ID);
?>

<style>.box-detail-tab li{ width:150px; }.item_center table td{text-align:center;}</style>
<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i><?= '当前界面:会员 》会员管理 》注册会员列表 》'.$txt;?></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->
	<?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
   <div class="box-detail">
        <!-- <div class="box-detail-tab" style="margin-top:10px;">
            <ul class="c">
                <li class="<?//=$_REQUEST['passed']==136?'current':'';?>"><a href="<?php //echo $this->createUrl('create',array('passed'=>136));?>">普通注册</a></li>
                <li class="<?//=$_REQUEST['passed']==2?'current':'';?>"><a href="<?php //echo $this->createUrl('create',array('passed'=>2));?>">实名注册</a></li>
            </ul>
        </div> -->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table width="100%" class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4"><?php echo $_REQUEST['passed'] == 136?'注册账号':'实名注册';?></td>
                    </tr>
                    <!--
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'GF_ACCOUNT'); ?></td>
                        <td width="85%" id="dr_gf_account" >
                            <?php echo $form->hiddenField($model, 'GF_ACCOUNT', array('class' => 'input-text')); ?>
                            <?php echo $form->hiddenField($model, 'GF_ID', array('class' => 'input-text')); ?>
                            <span id="account_box">
                                <?php if(!empty($model->GF_ID)) echo '<span class="label-box">'.$model->GF_ACCOUNT.'</span>'; ?>
                            </span>
                            <?php
                                if($_REQUEST['action'] == 'realname') {
                                    if(empty($model->GF_ID)) echo '<input id="select_account" class="btn" type="button" value="选择">';
                                }else {
                                    if(empty($model->GF_ID)) echo '<input id="check" class="btn" type="button" value="选择">';
                                }
                            ?>
                        </td>
                    </tr>
                    -->
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'GF_NAME'); ?></td>
                        <td width="85%" id="df_gf_name">
                            <?php if($_REQUEST['action'] == 'realname') {
                                echo $form->textField($model, 'GF_NAME', array('class' => 'input-text', 'disabled' => 'disabled'));
                            }else {
                                echo $flag?
                                $form->textField($model, 'GF_NAME', array('class' => 'input-text')):
                                $model->GF_NAME;
                            } ?>
                            <?php echo $form->error($model, 'GF_NAME', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    
                        <tr> 
                            <td><?php  echo $form->labelEx($model, 'security_phone'); ?></td>
                            <td>
                                <?php  echo $flag?
                                $form->textField($model, 'security_phone', array('class' => 'input-text')):
                                $model->security_phone
                                ; ?>
                                <?php  echo $form->error($model, 'security_phone', $htmlOptions = array()); ?>
                             </td> 
                         </tr> 
                         <?php if($flag){?>
                            <tr>
                                <td><?php echo $form->labelEx($model, 'GF_PASS'); ?></td>
                                <td>
                                    <?php echo $form->passwordField($model, 'GF_PASS', array('class' => 'input-text','placeholder'=>'密码位数不小于6位')); ?>
                                    <?php echo $form->error($model, 'GF_PASS', $htmlOptions = array()); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $form->labelEx($model, 'GF_PASS2'); ?></td>
                                <td>
                                    <?php echo $form->passwordField($model, 'GF_PASS2', array('class' => 'input-text','placeholder'=>'请再次输入密码')); ?>
                                    <?php echo $form->error($model, 'GF_PASS2', $htmlOptions = array()); ?>
                                </td>
                            </tr>
                            <?php } ?>
                        <tr> 

                            <td><?php  echo $form->labelEx($model, 'EMAIL'); ?></td>
                            <td>
                                <?php  echo $flag?
                                $form->textField($model, 'EMAIL', array('class' => 'input-text')):
                                $model->EMAIL;
                                 ?>
                                <?php  echo $form->error($model, 'EMAIL', $htmlOptions = array()); ?>
                             </td> 
                        </tr> 
                </table>
                <div id="reloadRN"><!-- change realname -->
                <table width="100%" style="table-layout:auto; margin-top:10px;">

                <?php if($_REQUEST['passed']==2){?>
                    <tr class="table-title">
                        <td colspan="4">实名信息</td>
                    </tr>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'ZSXM'); ?></td>
                        <td width="35%">
                            <?php echo $form->textField($model, 'ZSXM', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'ZSXM', $htmlOptions = array()); ?>
                        </td>
                        <!-- <td>
                            <?php echo $form->labelEx($model, 'real_sex'); ?>
                            <?php // echo $form->labelEx($model, 'SEX'); ?>
                        </td>
                        <td>
                            <?php // echo $form->dropDownList($model, 'SEX', Chtml::listData(array(array('value' => '1', 'name' => '男'), array('value' => '0', 'name' => '女')), 'value', 'name'), array('prompt'=>'请选择')); ?>
                            <?php // echo $form->dropDownList($model, 'real_sex', '"205":"\u7537","207":"\u5973"', array('prompt'=>'请选择')); ?>
                            <?php echo $form->dropDownList($model, 'real_sex', Chtml::listData(BaseCode::model()->getSex(204), 'f_id', 'F_NAME'), array('prompt' => '请选择')); ?>
                            <?php // echo $form->error($model, 'SEX', $htmlOptions = array()); ?>
                            <?php echo $form->error($model, 'real_sex', $htmlOptions = array()); ?>
                        </td> -->
                    </tr>
                   <!--  <tr>
                        <td><?php echo $form->labelEx($model, 'real_birthday'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'real_birthday', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'real_birthday', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'native'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'native', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'native', $htmlOptions = array()); ?>
                        </td>
                    </tr> -->
                    <tr>
                       <!--  <td><?php echo $form->labelEx($model, 'id_card_type'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'id_card_type', Chtml::listData(BaseCode::model()->getCode(842), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'id_card_type', $htmlOptions = array()); ?>
                        </td> -->
                        <td><?php echo $form->labelEx($model, 'id_card'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'id_card', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'id_card', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                   <!--  <tr>
                        <td><?php echo $form->labelEx($model, 'id_card_validity_start'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'id_card_validity_start', array('class' => 'input-text', 'style' => 'width: 180px;', 'placeholder'=>'开始日期')); ?>
                            <?php echo ' - '.$form->textField($model, 'id_card_validity_end', array('class' => 'input-text', 'style' => 'width: 180px;', 'placeholder'=>'截止日期')); ?>
                            <?php echo $form->error($model, 'id_card_validity_start', $htmlOptions = array()); ?>
                            <?php echo $form->error($model, 'id_card_validity_end', $htmlOptions = array()); ?>
                        </td>
                    </tr> -->
                    <!-- <tr>
                    	<td class="id_card_pic1"><?php echo $form->labelEx($model, 'id_card_pic'); ?> <span class="required">*</span></td>
                        <td class="id_card_pic2" colspan="3">
                            <div style="float: left; display: block; margin-right: 100px;">
                                <?php echo $form->hiddenField($model, 'id_card_pic', array('class' => 'input-text fl')); ?>
                                <?php $basepath=BasePath::model()->getPath(123);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                                <?php if($model->id_card_pic!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_id_card_pic"><a href="<?php echo $basepath->F_WWWPATH.$model->id_card_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->id_card_pic;?>" width="70"></a></div><?php }?>
                                <script>we.uploadpic('<?php echo get_class($model);?>_id_card_pic', '<?php echo $picprefix;?>', '', '', '', '', '上传正面');</script>
                                <?php echo $form->error($model, 'id_card_pic', $htmlOptions = array()); ?>
                            </div>
                            <div style="margin-left: 85px;" class="id_pic">
                                <?php echo $form->hiddenField($model, 'id_pic', array('class' => 'input-text fl')); ?>
                                <?php $basepath=BasePath::model()->getPath(123);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                                <?php if($model->id_pic!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_id_pic"><a href="<?php echo $basepath->F_WWWPATH.$model->id_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->id_pic;?>" width="70"></a></div><?php }?>
                                <script>we.uploadpic('<?php echo get_class($model);?>_id_pic', '<?php echo $picprefix;?>', '', '', '', '', '上传反面');</script>
                                <?php echo $form->error($model, 'id_pic', $htmlOptions = array()); ?>
                            </div>
                        </td>
                    </tr> -->
                    <table width="100%" class="mt15" style="table-layout:auto;">
                        <tr>
                            <td width="15%">操作</td>
                            <td colspan="3">
                                <?php
                                    echo show_shenhe_box(array('submit'=>'提交认证')).'&nbsp;<button class="btn" type="button" onclick="we.back();">取消</button>';
                                ?>
                            </td>
                        </tr>
                    </table>
                <?php }else{ ?>
                    <table width="100%" class="mt15" style="table-layout:auto;">
                        <tr>
                            <td width="15%">操作</td>
                            <td colspan="3">
                                <?php
                                    echo show_shenhe_box(array('quxiao'=>'注册')).'&nbsp;<button class="btn" type="button" onclick="we.back();">取消</button>';
                                ?>
                            </td>
                        </tr>
                    </table>
                <?php } ?>
                </table>
                <?php echo $form->hiddenField($model, 'logon_way', array('class' => 'input-text','value' => 1375)); ?>
                <?php echo $form->hiddenField($model, 'logon_way_name', array('class' => 'input-text','value' => '后台添加')); ?>
                </div><!-- change realname end -->
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    $("input[type='password'],#userlist_GF_NAME").on("focus",function(){
        $(this).removeAttr('readonly');
    })
    $("input[type='password'],#userlist_GF_NAME").on("blur",function(){
        $(this).attr('readonly',true);
    })
    // 选择账号
    var $account_box=$('#account_box');
    $('#check').on('click', function(){
        $.dialog.data('id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/GfIdelUserAllNumber");?>',{
        id:'geren',
		lock:true,opacity:0.3,
		width:'500px',
		height:'60%',
        title:'选择账号',
        close: function () {
            if($.dialog.data('id')>0){
                $('#userlist_GF_ACCOUNT').val($.dialog.data('account'));
                // $('#userlist_GF_ID').val($.dialog.data('id'));
                $account_box.html('<span class="label-box">'+$.dialog.data('account')+'</span>');
            }
         }
       });
    });

    // 选择需要实名的账号
    // $('#select_account').on('click', function(){
    //     $.dialog.data('id', 0);
    //     $.dialog.open('<?php echo $this->createUrl("select/GfIdelUserAllNumber");?>', {});
    // });

    $("#select_account").on("click",function(){
        $.dialog.data('GF_ID', 0);
            $.dialog.open('<?php echo $this->createUrl("select/gfuser");?>&passed=0&action=realname',{
            id:'zhanghao',
            lock:true,opacity:0.3,
            width:'500px',
            // height:'60%',
            title:'选择未登记账号',
            close: function () {
                if($.dialog.data('GF_ID')>0){
                    $('#userlist_GF_ACCOUNT').val($.dialog.data('GF_ACCOUNT'));
                    $('#userlist_GF_ID').val($.dialog.data('GF_ID'));
                    $account_box.html('<span class="label-box">' + $.dialog.data('GF_ACCOUNT') + '</span>');
                    $('#userlist_GF_NAME').val($.dialog.data('GF_NAME'));
                    // $gf_name_box.val($.di).data('GF_NAME');
                    setTimeout("reRealname("+$.dialog.data('GF_ID')+")","100");
                    // window.location.href('');
                }
            }
        });
    });

    function reRealname(id) {
        // alert(id);
        // alert(account);
        // alert(id);
        document.getElementById('reloadRN').innerHTML="";
        $('#reloadRN').load('"index?r=userlist/update_realname&id="+id');
        // window.location.href("index?r=userlist/update_realname&id="+id);
    }

    // 获取性别
    $(function() {
        $('#sex').on('change', function() {
            var sex = $(this).val();
        })
    });

    $('#userlist_real_birthday').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});});
    $('#userlist_id_card_validity_start').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});});
    $('#userlist_id_card_validity_end').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});});

    $("#userlist_id_card_type").on("change",function(){
        if($(this).val()==843||$(this).val()==845){
            $(".id_pic").show();
        }else{
            $(".id_pic").hide();
        }
    })

    // 验证账号
    function uniqueName(obj){
        var changval=$(obj).val();
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('exist');?>&name='+changval,
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
        if($("#userlist_id_card_type").val()==''){
            we.msg('minus', '请选择证件类型');
            return false;
        }
        if($("#userlist_id_card_type").val()==843||$("#userlist_id_card_type").val()==845){
            if($("#userlist_id_card_pic").val()==''){
                we.msg('minus', '请上传证件正面');
                return false;
            }
            if($("#userlist_id_pic").val()==''){
                we.msg('minus', '请上传证件反面');
                return false;
            }
        }else{
            if($("#userlist_id_card_pic").val()==''){
                we.msg('minus', '请上传个人信息页');
                return false;
            }
        }
    });
</script>