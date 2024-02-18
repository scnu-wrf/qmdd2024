<div class="box">
    <div class="box-title c">
        <h1>
            <span>
                当前界面：会员》账号冻结注销》注销审核
            </span>
            <script>var webstate = <?php echo $_REQUEST['state']; ?></script>
        </h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-detail-tab" style="margin-top: 15px; border: 0px;">
            <ul class="c">
                <li id="waitting_for_exam" style="width:150px;"><a href="javascript:;" onclick="on_exam(1);">待审核：<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span></a></li>
                <li id="exam_list" style="width:150px;"><a href="javascript:;" onclick="on_exam(0);">审核记录</a></li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="state" id="state" value="<?php echo Yii::app()->request->getParam('state');?>">
                <label style="margin-right:10px;">
                    <span>操作时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $startDate;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $endDate;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit" id="click_submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th width="3%">序号</th>
                        <th width="10.7%">GF账号</th>
                        <th width="10.7%"><?php echo $model->getAttributeLabel('GF_NAME'); ?></th>
                        <th width="10.7%"><?php echo $model->getAttributeLabel('user_state'); ?></th>
                        <th width="10.7%">注销方式</th>
                        <th width="10.7%">注销原因</th>
                        <th width="10.7%"><?php echo $model->getAttributeLabel('state'); ?></th>
                        <th width="10.7%">申请时间</th>
                        <th width="10.7%">操作</th>
                    </tr>
                </thead>
                <tbody>
<?php
$index = 1;
foreach($arclist as $v){
?>
                    <tr>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->GF_ACCOUNT; ?></td>
                        <td><?php echo $v->GF_NAME; ?></td>
                        <td><?php echo ($v->user_state == 649) ? '已注销' : $v->user_state_name; ?></td>
                        <td><?php if($v->lock_way == 0) {echo '平台注销';}else if($v->lock_way == 1) {echo '用户申请';}; ?></td><!-- 平台注销/用户申请 -->
                        <td><?php echo $v->lock_reason; ?></td>
                        <td><?php echo $v->state_name; ?></td>
                        <td><?php echo $v->uDate; ?></td>
                        <td>
                            <?php
                                if(Yii::app()->request->getParam('state') == 1) {
                                    echo show_command('审核',$this->createUrl('update_exam', array('id' => $v->ID, 'action' => 'shutdown_exam')));
                                }else if(Yii::app()->request->getParam('state') == 0){
                                    echo show_command('详情',$this->createUrl('update_exam', array('id' => $v->ID, 'action' => 'shutdown_check')));
                                }

                            ?>
                        </td>
                    </tr>
<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->

        <div class="box-page c"><?php $this->page($pages);?></div>

    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
$(function(){
    var $lock_date_start=$('#lock_date_start,#start_date');
    var $lock_date_end=$('#lock_date_end,#end_date');
    $lock_date_start.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
    });
    $lock_date_end.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
    });
});
</script>
<script>
    var screen = document.documentElement.clientWidth;
    var sc = screen-100;
    var add_html =
        '<div id="add_format" style="width:'+sc+'px;">'+
            '<form id="add_form" name="add_form">'+
                '<table id="table_tag" style="width:100%;border: solid 1px #d9d9d9;">'+
                    '<thead>'+
                        '<tr class="table-title">'+
                            '<td colspan="8" style="padding: 5px;">账号选择&nbsp;&nbsp;<input type="button" class="btn btn-blue" onclick="add_tag();" value="选择"></td>'+
                        '</tr>'+
                    '</thead>'+
                '</table>'+
            '</form>'+
        '</div>';


    var if_data=0;
    function add_tag(){
        $.dialog.data('GF_ID', 0);
        $.dialog.open('<?php echo $this->createUrl("select/gfuser");?>',{
        id:'gfzhanghao',
		lock:true,opacity:0.3,
		width:'500px',
		// height:'60%',
        title:'选择具体内容',
        close: function () {
            if($.dialog.data('GF_ID')>0){
                var content =
                '<tr style="text-align:center;">'+
                    '<td style="width:60px;border:solid 1px #d9d9d9;">账号</td>'+
                    '<td style="width:100px;border:solid 1px #d9d9d9;">昵称</td>'+
                    '<td style="width:100px;border:solid 1px #d9d9d9;">注销原因</td>'+
                '</tr>'+
                '<tr style="text-align:center;" class="add_len">'+
                    '<input id="gf_id" name="gf_id" type="hidden" value="'+$.dialog.data('GF_ID')+'">'+
                    '<td style="border:solid 1px #d9d9d9;padding:5px;">'+$.dialog.data('GF_ACCOUNT')+'</td>'+
                    '<td style="border:solid 1px #d9d9d9;padding:5px;">'+$.dialog.data('GF_NAME')+'</td>'+
                    '<td style="border:solid 1px #d9d9d9;padding:5px;">'+
                        '<input id="user_state" name="user_state" type="hidden" value="649">'+
                        '<textarea class="input-text" id="lock_reason" name="lock_reason"></textarea>'+
                    '</td>'+
                '</tr>';
                $("#table_tag tbody").remove();
                $("#table_tag").append(content);
                if_data=1;
            }
         }
       });
    }
    function add_member(){
        if_data=0;
        $.dialog({
            id:'tianjia',
            lock:true,
            opacity:0.3,
            height: '60%',
            // width:'80%',
            title:'添加账号处理',
            content:add_html,
            button:[
                {
                    name:'注销',
                    callback:function(){
                        return fn_add_tr();
                    },
                    focus:true
                },
                {
                    name:'取消',
                    callback:function(){
                        return true;
                    }
                }
            ]
        });
        $('.aui_main').css('height','auto');
    }

    function fn_add_tr(){
        if(if_data==0){
            return false;
        }
        var form=$('#add_form').serialize();
        we.loading('show');
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('cancel',array());?>',
            data: form,
            dataType: 'json',
            success: function(data) {
                if(data.status==1){
                    we.loading('hide');
                    $.dialog.list['tianjia'].close();
                    we.success(data.msg, data.redirect);
                }else{
                    we.loading('hide');
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }

    // 切换待审核与审核记录
    function on_exam(state){
        // var exam = $('.exam p span').text();
        // if(exam > 0){
        // if($('#state').val() == 0) {
        if(state == '1') {
            $('#state').val(1);
            // $('.box-search select').html('<option value>请选择</option>');
            $('.box-search .input-text').val('');
            document.getElementById('click_submit').click();
        }else {
            $('#state').val(0);
            document.getElementById('click_submit').click();
        }
    }
    // 页面加载完成时添加导航栏选中
    $(window).load(function() {
        if(webstate == 0) {
            document.getElementById('waitting_for_exam').className='';
            document.getElementById('exam_list').style.backgroundColor='#FDE9D9';
            document.getElementById('exam_list').className='current';
        }else if(webstate == 1) {
            document.getElementById('exam_list').className='';
            document.getElementById('waitting_for_exam').style.backgroundColor='#FDE9D9';
            document.getElementById('waitting_for_exam').className='current';
        }
    });

</script>
