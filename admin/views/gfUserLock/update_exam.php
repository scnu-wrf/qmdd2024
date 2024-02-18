<?php $action = (!empty($_REQUEST['action'])) ? $_REQUEST['action'] : ''; ?>
<div class="box">
    <div class="box-title c">
        <h1>
            <span>当前界面：系统》账号冻结注销》<?php echo ($_REQUEST['action'] == 'shutdown_exam') ? '注销审核》详情' : '冻结审核》待审核'; ?></span>
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
                        <td colspan="2"><?php echo ($_REQUEST['action'] == 'shutdown_exam' || $_REQUEST['action'] == 'shutdown_check') ? '注销会员' : '冻结会员'; ?></td>
                    </tr>
                    <tr>
                        <td width="15%"><?php echo ($_REQUEST['action'] == 'shutdown_exam' || $_REQUEST['action'] == 'shutdown_check') ? '注销账号' : '冻结账号'; ?></td>
                        <td>
                            <?php if(!empty($model->GF_ACCOUNT)) { ?><span style="margin-right: 5px;"><?php echo $model->GF_ACCOUNT; ?></span><?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'GF_NAME'); ?></td>
                        <td>
                            <?php if(!empty($model->GF_NAME)) echo $model->GF_NAME; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'user_state'); ?></td>
                        <td>
                            <?php if(!empty($model->user_state)) echo ($model->user_state == 649) ? '已注销' : $model->user_state_name; ?>
                            <?php echo $form->hiddenField($model, 'user_state', array('class' => 'input-text')); ?>
                            <?php echo $form->hiddenField($model, 'user_state_name', array('class' => 'input-text')); ?>
                        </td>
                        <script>
                            var user_state = '<?php echo $model->user_state; ?>';
                            var user_state_name = '<?php echo $model->user_state_name; ?>';
                        </script>
                    </tr>
                    <?php if($_REQUEST['action'] == 'lock_exam') { ?>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'lock_way'); ?></td>
                        <td>
                            <?php
                                if($model->lock_way == 1282) {
                                    echo '冻结7日';
                                }else if($model->lock_way == 1283) {
                                    echo '冻结30日';
                                }else if($model->lock_way == 507) {
                                    echo '永久冻结';
                                }else {
                                    echo $model->lock_way;
                                }
                            ?>
                            <script type="text/javascript">var lock_way = <?php echo (!empty($model->lock_way)) ? $model->lock_way : 0; ?></script>
                        </td>
                    </tr>
                    <?php } ?>
                    <script type="text/javascript">var shutdown_exam = <?php echo ($_REQUEST['action'] == 'shutdown_exam') ? 1 : 0; ?></script>
                    <tr>
                        <td><?php echo ($_REQUEST['action'] == 'shutdown_exam' || $_REQUEST['action'] == 'shutdown_check') ? '注销原因' : '冻结原因'; ?></td>
                        <td>
                            <?php echo $model->lock_reason; ?>
                        </td>
                    </tr>
                    </table>
                    <table width="100%" class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="2">操作信息</td>
                    </tr>
                    <tr>
                        <td width="15%">状态</td>
                        <td>
                            <?php if(!empty($model->state)) echo $model->state_name; ?>
                        </td>
                    </tr>
                    <?php if($_REQUEST['action'] == 'lock_exam' || $_REQUEST['action'] == 'shutdown_exam') { ?>
                    <tr>
                        <td>审核</td>
                        <td>
                            <?php echo $form->radioButtonList($model, 'state', Chtml::listData(array(array("id"=>"372", "name"=>"审核通过"),array("id"=>"373", "name"=>"审核不通过")), 'id', 'name'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if($_REQUEST['action'] == 'lock_exam') { ?>
                    <tr id="locked" style="display: none;">
                        <td>冻结处理</td>
                        <td>
                            <span id="GfUserLock_is_setdate">
                                <span class="check">
                                    <input id="GfUserLock_is_setdate_0" class="input-check" value="0" type="radio" name="GfUserLock[is_setdate]">
                                    <label for="GfUserLock_is_setdate_0">立即冻结</label>
                                </span>
                                <span class="check">
                                    <input id="GfUserLock_is_setdate_1" class="input-check" value="1" type="radio" name="GfUserLock[is_setdate]">
                                    <label for="GfUserLock_is_setdate_1">指定冻结开始日期</label>
                                </span>
                            </span>
                        </td>
                    </tr>
                    <tr id="locked_date" style="display: none;">
                        <td>冻结日期</td>
                        <td>
                            <?php echo $form->textField($model, 'lock_date_start', array('class' => 'input-text', 'style' => 'width: 150px;')); ?> - <?php echo $form->textField($model, 'lock_date_end', array('class' => 'input-text', 'style' => 'width: 150px;')); ?>
                            <?php echo $form->error($model, 'lock_date_start', $htmlOptions = array()); ?><?php echo $form->error($model, 'lock_date_end', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td>备注</td>
                        <td>需要添加新字段</td>
                    </tr>
                    <?php if($_REQUEST['action'] == 'lock_exam' || $_REQUEST['action'] == 'shutdown_exam') { ?>
                    <tr>
                        <td>操作</td>
                        <td>
                            <?php if($_REQUEST['action'] == 'shutdown_exam') { ?>
                                <button id="submit_btn_shutdown" class="btn btn-blue" type="submit">确定</button>
                            <?php }else if($_REQUEST['action'] == 'lock_exam') { ?>
                                <button id="submit_btn" class="btn btn-blue" type="submit">确定</button>
                            <?php } ?>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            <?php $this->endWidget(); ?>
            </div>
        </div>
    </div><!-- box-detail end -->
</div><!--box end-->
<script type="text/javascript">
    // $('#GfUserLock_state_0').attr('checked', 'checked');alert($('#GfUserLock_state_0').is(':checked'));

    // 冻结日期
    $('#GfUserLock_lock_date_start').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});
    });
    $('#GfUserLock_lock_date_end').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});
    });

    // 立即冻结
    $('#GfUserLock_is_setdate_0').on('change', function(){
        $('#GfUserLock_lock_date_start').val("<?php echo date('Y-m-d H:i:s'); ?>");
        // 添加lock_date_end监听
        if(lock_way == 1282) {
            $('#GfUserLock_lock_date_end').val("<?php echo date('Y-m-d H:i:s', strtotime("+7 day")); ?>");
        }else if(lock_way == 1283) {
            $('#GfUserLock_lock_date_end').val("<?php echo date('Y-m-d H:i:s', strtotime("+30 day")); ?>");
        }else if(lock_way == 507) {
            $('#GfUserLock_lock_date_end').val("<?php echo date('9999-09-09'); ?>");
        }
        $('#GfUserLock_lock_date_start').attr('disabled', 'disabled');
        $('#GfUserLock_lock_date_end').attr('disabled', 'disabled');
    });

    // 指定冻结开始时间
    $('#GfUserLock_is_setdate_1').on('change', function() {
        $('#GfUserLock_lock_date_start').attr('disabled', false);
        $('#GfUserLock_lock_date_end').attr('disabled', false);
    });
    $('#GfUserLock_lock_date_start').on('change', function() {
        if(lock_way == 1282) {
            $('#GfUserLock_lock_date_end').val("<?php echo date('Y-m-d H:i:s', strtotime("+7 day")); ?>");
        }else if(lock_way == 1283) {
            $('#GfUserLock_lock_date_end').val("<?php echo date('Y-m-d H:i:s', strtotime("+30 day")); ?>");
        }else if(lock_way == 507) {
            $('#GfUserLock_lock_date_end').val("<?php echo date('9999-09-09'); ?>");
        }
    });

    // 审核不通过
    $('#GfUserLock_state_1').on('change', function() {
        $('#GfUserLock_lock_date_start').val('');
        $('#GfUserLock_lock_date_end').val('');
        $('#GfUserLock_is_setdate_0').attr('checked', false);
        $('#GfUserLock_is_setdate_1').attr('checked', false);
        $('#locked').attr('style', 'display: none');
        $('#locked_date').attr('style', 'display: none');
        $('#GfUserLock_user_state').val(user_state);
        $('#GfUserLock_user_state_name').val(user_state_name);
    });

    // 审核通过
    $('#GfUserLock_state_0').on('change', function() {
        $('#locked').attr('style', '');
        $('#locked_date').attr('style', '');
        $('#GfUserLock_lock_date_start').val('<?php echo $model->lock_date_start; ?>');
        $('#GfUserLock_lock_date_end').val('<?php echo $model->lock_date_end; ?>');
        $('#GfUserLock_lock_date_start').attr('disabled', false);
        $('#GfUserLock_lock_date_end').attr('disabled', false);
        if(shutdown_exam == 1) {
            $('#GfUserLock_user_state').val(649);
            $('#GfUserLock_user_state_name').val('已注销');
        }
    });
    $('#GfUserLock_state_shutdown_0').on('change', function() {
        $('#GfUserLock_user_state').val(649);
        $('#GfUserLock_user_state_name').val('已注销');
    });

    $('#submit_btn_shutdown').on('click', function() {
        if($('#GfUserLock_state_0').is(':checked') == false && $('#GfUserLock_state_1').is(':checked') == false) {
            // alert('申请操作不能为空');
            we.msg('minus', '申请操作不能为空');
            return false;
        }
    });
</script>