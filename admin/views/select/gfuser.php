<?php
    if(!isset($_REQUEST['lang_type'])){
        $_REQUEST['lang_type'] = 0;
    }
    if(!isset($_REQUEST['action'])) $_REQUEST['action'] = '';
?>
<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="passed" value="<?php echo Yii::app()->request->getParam('passed');?>">
                <input type="hidden" name="lang_type" value="<?php echo Yii::app()->request->getParam('lang_type');?>">
                <label style="margin-right:10px;">
                    <span>查找账号：</span>
                    <input id="gfuser" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入完整账号">
                </label>
                <button id="box_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        <div><p style="font-size: 12px; font-weight: bold;">点击选择</p></div>
            <table class="list">
                <thead>
                    <tr>
                        <th>账号</th>
                        <th>昵称</th>
                        <th>实名状态</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v) { ?>
    <?php if (!empty($v->select_code)) { ?>
                    <tr id="select" data-id="<?php echo $v->select_id; ?>" data-code="<?php echo $v->select_code; ?>" data-title="<?php echo $v->select_title; ?>" data-passed="<?php echo $v->passed; ?>" data-passed_name="<?php echo $v->passed_name; ?>" data-zsxm="<?php echo $v->ZSXM; ?>" data-sex="<?php echo $v->real_sex; ?>" data-card="<?php echo $v->id_card; ?>" data-birthday="<?php echo $v->real_birthday; ?>" data-security_phone="<?php echo $v->security_phone; ?>" data-native="<?php echo $v->native; ?>" data-nation="<?php echo $v->nation; ?>" style="<?php if($v->passed == 371 || $v->passed == 373) echo 'opacity: 0.2'; ?>">
                        <td width="30%"><?php echo $v->select_code; ?></td>
                        <td width="35%"><?php echo $v->select_title; ?></td>
                        <td width="35%">
                            <?php
                                if($v->passed == 136) {
                                    echo "未认证";
                                    // if($_REQUEST['action'] == 'realname') {
                                    //     echo "未认证";
                                    // }else {
                                    //     echo "未注册";
                                    // }
                                }else if($v->passed == 372) {
                                    echo "已认证";
                                }else if($v->passed == 371) {
                                    echo "待审核";
                                }else if($v->passed == 373) {
                                    echo "审核未通过";
                                }else {
                                    echo $v->passed;
                                }
                            ?>
                        </td>
                    </tr>
    <?php }else { ?>
                    <tr><td colspan="3">未查询到相关账号</td></tr>
    <?php } ?>
<?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var disableSelect = $('.box-table tbody tr').css('opacity');
    $(function(){
        var parentt = $.dialog.parent;				// 父页面window对象
        api = $.dialog.open.api;	// 			art.dialog.open扩展方法
        if (!api) return;

        // 操作对话框
        api.button(
            {
                name: '取消'
            }
        );
        $('.box-table tbody tr').on('click', function() {
            if(disableSelect == '1') {
                $.dialog.data('GF_ID',$(this).attr('data-id'));
                $.dialog.data('GF_ACCOUNT',$(this).attr('data-code'));
                $.dialog.data('GF_NAME',$(this).attr('data-title'));
                $.dialog.data('zsxm',$(this).attr('data-zsxm'));
                $.dialog.data('passed',$(this).attr('data-passed'));
                $.dialog.data('real_sex',$(this).attr('data-sex'));
                $.dialog.data('native',$(this).attr('data-native'));
                $.dialog.data('nation',$(this).attr('data-nation'));
                $.dialog.data('real_birthday',$(this).attr('data-birthday'));
                $.dialog.data('id_card',$(this).attr('data-card'));
                $.dialog.data('security_phone',$(this).attr('data-security_phone'));
                $.dialog.close();
            }else {
                return false;
            }
        });
    });

    $('#box_submit').on('click',function(){
        if($('#gfuser').val().length<6){
            we.msg('minus','请输入完整会员账号');
            return false;
        }
    })
</script>
