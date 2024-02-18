<?php $action = (!empty($_REQUEST['action'])) ? $_REQUEST['action'] : ''; ?>
<div class="box">
    <div class="box-title c">
        <h1>
            <span>当前界面：系统》账号冻结注销》<?php echo ($_REQUEST['action'] == 'shutdown_exam' || $_REQUEST['action'] == 'shutdown') ? '账号注销》详情' : '账号冻结》冻结'; ?></span>
        </h1>
        <span class="back">
            <a href="javascript:;" class="btn" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a>
        </span>
    </div>
    <div class="box-detail">
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
            <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
                <table width="100%" class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="2"><?php echo ($_REQUEST['action'] == 'shutdown_exam' || $_REQUEST['action'] == 'shutdown_check' || $_REQUEST['action'] == 'shutdown') ? '注销会员' : '冻结会员'; ?></td>
                    </tr>
                    <?php echo $form->hiddenField($model, 'GF_NAME', array('class' => 'input-text')); ?>
                    <?php echo $form->hiddenField($model, 'user_state', array('class' => 'input-text')); ?>
                    <?php echo $form->hiddenField($model, 'user_state_name', array('class' => 'input-text')); ?>
                    <?php
                        // if($action == 'shutdown') {
                        //     echo $form->hiddenField($model, 'lock_way', array('class' => 'input-text', 'value' => 0));
                        // }else {
                        //     echo $form->hiddenField($model, 'lock_way', array('class' => 'input-text'));
                        // }
                    ?>
                    <?php echo $form->hiddenField($model, 'ZSXM', array('class' => 'input-text')); ?>
                    <?php echo $form->hiddenField($model, 'security_phone', array('class' => 'input-text')); ?>
                    <?php echo $form->hiddenField($model, 'GF_ID', array('class' => 'input-text')); ?>
                    <?php echo $form->hiddenField($model, 'state', array('class' => 'input-text')); ?>
                    <tr>
                        <td width="15%"><?php echo ($_REQUEST['action'] == 'shutdown_exam' || $_REQUEST['action'] == 'shutdown_check' || $_REQUEST['action'] == 'shutdown') ? '注销账号' : '冻结账号'; ?></td>
                        <td id="select_account">
                            <?php echo $form->hiddenField($model, 'GF_ACCOUNT', array('class' => 'input-text')); ?>
                                <span style="margin-right: 5px;"><?php echo $model->GF_ACCOUNT; ?></span>
                            <?php if(empty($model->ID)) { ?>
                                <a id="account_select_btn" class="btn" href="javascript:;" title="选择<?php echo ($_REQUEST['action'] == 'shutdown') ? '注销' : '冻结' ?>账号">选择</a>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'GF_NAME'); ?></td>
                        <td id="select_name">
                            <?php if(!empty($model->GF_NAME)) echo $model->GF_NAME; ?>
                        </td>
                    </tr>
                    <?php if(!empty($model->ID)) { ?>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'user_state'); ?></td>
                        <td>
                            <?php if(!empty($model->user_state)) echo $model->user_state_name; ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'lock_way'); ?></td>
                        <td>
                            <?php
                                if($action == 'shutdown') {
                                    echo $form->hiddenField($model, 'lock_way', array('class' => 'input-text', 'value' => 0));
                                    echo '平台注销';
                                }else if($action == 'index_lock_list' || $model->state == 371) {
                                    if(!empty($model->lock_way)) {
                                        if($model->lock_way == 507) {
                                            echo '永久冻结';
                                        }else if($model->lock_way == 1282) {
                                            echo '冻结7日';
                                        }else if($model->lock_way == 1283) {
                                            echo '冻结30日';
                                        }else if($model->lock_way == 0) {
                                            echo '平台注销';
                                        }else if($model->lock_way == 1) {
                                            echo '用户申请';
                                        }
                                    };
                                }else {
                                    echo $form->dropDownList($model, 'lock_way', Chtml::listData(array(array('value' => '1282', 'name' => '冻结7日'), array('value' => '1283', 'name' => '冻结30日'), array('value' => '507', 'name' => '永久冻结')), 'value', 'name'));
                                    echo $form->error($model, 'lock_way', $htmlOptions = array());
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo ($_REQUEST['action'] == 'shutdown_exam' || $_REQUEST['action'] == 'shutdown_check' || $_REQUEST['action'] == 'shutdown') ? '注销原因' : '冻结原因'; ?></td>
                        <td>
                            <?php
                                if($action == 'index_lock_list' || $model->state == 371) {
                                    if(!empty($model->lock_reason)) echo $model->lock_reason;
                                }else {
                            ?>
                                <?php echo $form->textField($model, 'lock_reason', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'lock_reason', $htmlOptions = array()); ?>
                            <?php } ?>
                        </td>
                    </tr>
                    </table>
                    <table width="100%" class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="2">操作信息</td>
                    </tr>
                    <?php if(!empty($model->state)) { ?>
                        <td width="15%">状态</td>
                        <td><?php echo $model->state_name; ?></td>
                    <?php } ?>
                    <tr>
                        <td width="15%">操作</td>
                        <td>
                            <!-- <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button> -->
                            <?php if($model->state == '371') {} ?>
                            <?php if($model->state == '374') {
                                echo '<button id="click_repost" class="btn btn-blue" type="button">提交审核</button>';
                                echo '<button id="repost_shenhe" class="btn" onclick="submitType=\'shenhe\'" type="submit" style="display: none;">提交审核</button>';
                            } ?>
                            <?php if($model->state == '373') {} ?>
                            <?php if($action != 'index_lock_list' && $action != 'shutdown_list' && $model->state == '') { echo show_shenhe_box(array('shenhe'=>'提交审核')); } ?>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>
                </table>
            <?php $this->endWidget(); ?>
            </div>
        </div>
    </div><!-- box-detail end -->
</div><!--box end-->
<script>
    var if_data=0;
    $('#account_select_btn').on('click', function() {
        $.dialog.data('GF_ID', 0);
        $.dialog.open('<?php echo $this->createUrl("select/gfuser");?>',{
        id:'gfzhanghao',
        lock:true,opacity:0.3,
        width:'500px',
        // height:'60%',
        title:'选择账号',
        close: function () {
            if($.dialog.data('GF_ID')>0){
                $('#GfUserLock_GF_ACCOUNT').val($.dialog.data('GF_ACCOUNT'));
                $('#select_account span').append($.dialog.data('GF_ACCOUNT'));
                $('#GfUserLock_GF_NAME').val($.dialog.data('GF_NAME'));
                $('#select_name').append($.dialog.data('GF_NAME'));
                $('#GfUserLock_user_state').val(506);
                $('#GfUserLock_user_state_name').val('正常');
                $('#GfUserLock_ZSXM').val($.dialog.data('zsxm'));
                $('#GfUserLock_security_phone').val($.dialog.data('security_phone'));
                $('#GfUserLock_GF_ID').val($.dialog.data('GF_ID'));
                $('#GfUserLock_state').val(371);
                if_data=1;
            }
        }
        });
        // success: function(data) {
        //     $('#GF_ACCOUNT').html(data.GF_ACCOUNT);
        //     $('#GF_NAME').html(data.GF_NAME);
        // }
    });

    $('#select_lock_way option').on('click', function() {
        $('#GfUserLock_lock_way').val($('#select_lock_way').val());
    });

    $('#click_repost').on('click', function() {
        $('#GfUserLock_state').val(371);
        document.getElementById('repost_shenhe').click();
    });
</script>