<?php
    $cl_a = '';
    if(!isset($_REQUEST['cl_a'])){
        $_REQUEST['cl_a'] = '';
    }
    $cl_a = $_REQUEST['cl_a'];
    if($cl_a=='a2'){
        echo '<script>$(function(){document.getElementById("a2").click();})</script>';
    }
    else if($cl_a=='a3'){
        echo '<script>$(function(){document.getElementById("a3").click();})</script>';
    }
    $txt = '实名管理 》实名未通过列表';
?>
<div class="box">
    <div class="box-title c">
        <h1><span>当前界面：会员 》<?php echo (strstr($_SERVER['HTTP_REFERER'], 'index_unregist')) ? '实名管理 》未实名账号列表' : '会员管理 》注册会员列表'; ?> 》会员详情</span></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->


   <div class="box-detail">
		<?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="2">基本信息</td>
                </tr>
                <tr>
                    <td style="width:10%"><?php echo $form->labelEx($model, 'TXNAME'); ?></td>
                    <td>
                        <?php echo $form->hiddenField($model, 'TXNAME', array('class' => 'input-text')); ?>
                        <?php $basepath=BasePath::model()->getPath(120);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <?php if($model->TXNAME!=null){?>
                        <div class="upload_img fl" id="upload_pic_GfUser1_imgUrl">
                            <a href="<?php echo $basepath->F_WWWPATH.$model->TXNAME;?>" target="_blank">
                                <img src="<?php echo $basepath->F_WWWPATH.$model->TXNAME;?>" width="100">
                            </a>
                        </div>
                        <?php }?>
                        <?php echo $form->error($model, 'TXNAME', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td width="10%">账号</td>
                    <td id="dr_gf_account" ><?php echo $model->GF_ACCOUNT; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'GF_NAME'); ?></td>
                    <td><?php echo $model->GF_NAME; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'GRQM'); ?></td>
                    <td><?php echo $model->GRQM; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'INTEREST'); ?></td>
                    <td>
                        <?php
                            $text='';
                            if(!empty($model->INTEREST))foreach(explode("|",$model->INTEREST) as $t){
                                $text.=explode(":",$t)[1].',';
                            }
                            echo rtrim($text,',');
                        ?>
                    </td>
                </tr>
            <!-- </table> -->
            <!-- <table class="mt15" style="table-layout:auto;"> -->
                <!-- <tr class="table-title">
                    <td colspan="2">个人信息（隐私）</td>
                </tr> -->
                <tr>
                    <td><?php echo $form->labelEx($model, 'height'); ?></td>
                    <td><?php echo $model->height; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'weight'); ?></td>
                    <td><?php echo $model->weight; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'occupation'); ?></td>
                    <td><?php echo $model->occupation; ?></td>
                </tr>
                <!-- <tr>
                    <td><?php // echo $form->labelEx($model, 'guardian_contact_information'); ?></td>
                    <td><?php // echo $model->guardian_contact_information; ?></td>
                </tr> -->
                <tr>
                    <td style="width:10%"><?php echo $form->labelEx($model, 'security_phone'); ?></td>
                    <td><?php if(!empty($model->security_phone))echo substr_replace($model->security_phone, '****',3, 4); ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'EMAIL'); ?></td>
                    <td>
                        <?php
                            $email_array = explode("@", $model->EMAIL);//邮箱前缀
                            $prevfix = (strlen($email_array[0]) < 4) ? "" : substr($model->EMAIL, 0, 3);
                            $count = 0;
                            $model->EMAIL = preg_replace('/([\d\w+_-]{0,100})@/', '***@', $model->EMAIL, -1, $count);
                            $rs = $prevfix . $model->EMAIL;
                            echo $rs;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'location'); ?></td>
                    <td><?php echo $model->PROVINCE.$model->CITY; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'IDNAME'); ?></td>
                    <td>
                        <?php echo $form->hiddenField($model, 'IDNAME', array('class' => 'input-text')); ?>
                        <?php $basepath=BasePath::model()->getPath(120);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <?php if($model->IDNAME!=null){?>
                        <div class="upload_img fl" id="upload_pic_GfUser1_imgUrl">
                            <a href="<?php echo $basepath->F_WWWPATH.$model->IDNAME;?>" target="_blank">
                                <img src="<?php echo $basepath->F_WWWPATH.$model->IDNAME;?>" width="100">
                            </a>
                        </div>
                        <?php }?>
                        <?php echo $form->error($model, 'IDNAME', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
            <?php if(strstr($_SERVER['HTTP_REFERER'], 'index_unregist')) { ?>
            <table width="100%" class="mt15" style="table-layout:auto;">
                <tr class="table-title"><td colspan="2">操作信息</td></tr>
                <tr>
                    <td>状态</td>
                    <td><?php
                            if ($model->passed == 136) {
                                echo '已失效';
                            }else {
                                echo $model->passed_name;
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>操作</td>
                    <td>
                        <a class="btn" href="javascript:;" onclick="waiting_logoff(<?php echo $model->GF_ID; ?>)">注销账号</a>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
            <?php } ?>
        </div><!--box-detail end-->
    <?php $this->endWidget(); ?>
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('cancel', array('id'=>'ID','al'=>'删除成功'));?>';
    // we.tab('.box-detail-tab li','.box-detail-tab-item',function(index){
    //     if(index==3){ }
    //     return true;
    // });
    document.getElementsByClassName("a2").click();

    $('#GfUser1_real_birthday').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});});

    function look(gf_account){
        $.dialog.open('<?php echo $this->createUrl("look");?>&gf_account='+gf_account,{
            id:'sensitive',
            lock:true,
            opacity:0.3,
            title:'查看归属记录',
            width:'80%',
            height:'70%',
            close: function () {
                // window.location.reload(true);
            }
        });
    }

    // $(".click_li").click(function(){
    //     console.log('327');
    //     var obj = $(this).children("a");
    //     window.location.href=$(obj[0]).attr("href");
    // });

    function click_li(){
        window.location.href="<?php echo $this->createUrl('history',array('gf_id'=>$model->GF_ID)); ?>";
    }

    // we.operate = function(id, url ,show) {
    //     we.overlay('show');
    //     var url1 = url.replace(/ID/, id);
    //         if (id == '' || id == undefined) {
    //             we.msg('error', '请选择要操作的内容', function() {
    //                 we.loading('hide');
    //             });
    //             return false;
    //         }
    //     var fn = function() {
    //         url = url.replace(/ID/, id);
    //         $.ajax({
    //             type: 'get',
    //             url: url,
    //             dataType: 'json',
    //             success: function(data) {
    //                 if (data.status == 1) {
    //                     we.msg('check', data.msg, function() {
    //                         we.loading('hide');
    //                         we.reload();
    //                     });
    //                 } else {
    //                     we.msg('error', data.msg, function() {
    //                         we.loading('hide');
    //                     });
    //                 }
    //             }
    //         });
    //     };
    //     $.fallr('show', {
    //         buttons: {
    //             button1: {text: '确定', danger: true, onclick: fn},
    //             button2: {text: '取消'}
    //         },
    //         content: show,
    //         //icon: 'trash',
    //         afterHide: function() {
    //             we.loading('hide');
    //         }
    //     });
    // };

    function waiting_logoff(id) {
        var user_state = "<?= $model->user_state; ?>";
        if (user_state == 1555) {
            we.msg('check', '提交成功');
        }else {
            we.msg('minus', '提交失败');
            return false;
        }
    }
</script>