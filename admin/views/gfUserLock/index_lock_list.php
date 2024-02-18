<div class="box">
    <div class="box-title c">
        <h1>
            <span>当前界面：系统》账号冻结注销》已冻结列表</span>
            <script>var webstate = <?php echo $_REQUEST['state']; ?></script>
        </h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div>
    <div class="box-content">
        <!-- <div class="box-header"> -->
            <!-- <a class="btn" onclick="add_member()">冻结会员</a> -->
            <!-- <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a> -->
        <!-- </div> --><!--box-header end-->
        <div class="box-detail-tab" style="margin-top: 15px; border: 0px;">
            <ul class="c">
                <li id="locked_list" style="width:150px;"><a href="javascript:;" onclick="on_exam(1);">冻结中&nbsp;<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span></a></li>
                <li id="waitting_for_unlock" style="width:150px;"><a href="javascript:;" onclick="on_exam(2);">近三天待解冻</a></li>
                <li id="unlock_list" style="width:150px;"><a href="javascript:;" onclick="on_exam(0);">已解冻</a></li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="state" id="state" value="<?php echo Yii::app()->request->getParam('state');?>">
                <?php if($_REQUEST['state'] == 1 || $_REQUEST['state'] == 0) { ?>
                <label style="margin-right:10px;">
                    <span><?php echo ($_REQUEST['state'] == 1) ? '冻结日期' : '解冻日期'; ?>：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $startDate;?>">
                    <span <?php echo ($_REQUEST['state'] == 1) ? 'style="margin-left: 10px;">解冻日期：' : '> - '; ?></span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $endDate;?>">
                </label>
                <?php } ?>
                <label style="margin-right:20px;">
                    <span>冻结状态：</span>
                    <select name="user_state">
                        <option value="">请选择</option>
                        <?php $base_code=BaseCode::model()->getReturn('1282,1283,507');?>
                        <?php foreach($base_code as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('user_state')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME; ?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="账号/昵称">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list" style="text-align:left;">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th width="3%">序号</th>
                        <th width="10.7%"><?php echo $model->getAttributeLabel('GF_ACCOUNT');?></th>
                        <th width="10.7%"><?php echo $model->getAttributeLabel('GF_NAME');?></th>
                        <th width="10.7%"><?php echo $model->getAttributeLabel('user_state');?></th>
                        <th width="10.7%"><?php echo $model->getAttributeLabel('lock_reason');?></th>
                        <th width="10.7%"><?php echo $model->getAttributeLabel('lock_way');?></th>
                        <th width="10.7%"><?php echo $model->getAttributeLabel('lock_date_start');?></th>
                        <th width="10.7%"><?php echo $model->getAttributeLabel('lock_date_end');?></th>
                        <th width="10.7%">冻结状态</th>
                        <th width="10.7%">操作</th>
                        <!--<th ><?php //echo $model->getAttributeLabel('admin_gfid');?></th>
                        <th ><?php //echo $model->getAttributeLabel('uDate');?></th>-->
                    </tr>
                </thead>
                <tbody>
<?php
$index = 1;
//print_r($arclist);
foreach($arclist as $v){
    $is_unlock = '';
    if($v->lock_date_end == '9999-09-09 00:00:00' && $v->remedy_btn == 1) {
        $is_unlock = '冻结中';
    }else if($v->lock_date_end != '9999-09-09 00:00:00' && strtotime($v->lock_date_end) > time() && $v->remedy_btn == 1) {
        $is_unlock = '冻结中';
    }else if($v->remedy_btn == 0){
        $is_unlock = '已解冻';
    }else if($v->lock_date_end != '9999-09-09 00:00:00' && strtotime($v->lock_date_end) < time() && $v->remedy_btn == 1) {
        $is_unlock = '已解冻';
    }
?>
                    <tr id="showDate">
                    <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->GF_ID); ?>"></td>
                        <td id="num"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->GF_ACCOUNT; ?></td>
                        <td><?php echo $v->GF_NAME; ?></td>
                        <td><?php echo $v->user_state_name; ?></td>
                        <td><?php echo $v->lock_reason; ?></td>
                        <td><?php echo ($v->lock_way == 1282) ? '冻结7日' : (($v->lock_way == 1283) ? '冻结30日' : (($v->lock_way == 507) ? '永久冻结' : $v->lock_way)); ?></td>
                        <td><?php echo $v->lock_date_start; ?></td>
                        <!-- <td> -->
                            <?php
                                // if($v->user_state==506){
                                //     echo $v->uDate;
                                // }
                            ?>
                        <!-- </td> -->
                        <td><?php echo $v->lock_date_end; ?></td>
                        <td><?php echo $is_unlock; ?></td>
                        <td>
                            <?php echo show_command('详情',$this->createUrl('update', array('id'=>$v->ID, 'action'=>'index_lock_list'))); ?>
                            <?php if($_REQUEST['state'] == 1) echo '<a class="btn" href="javascript:;" onclick="clickUnlock('.$v->ID.')">立即解冻</a>'; ?>
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
	 // 每页全选
    $('#j-checkall').on('click', function(){
        var $this = $(this);
        var $temp1 = $('.check-item .input-check');
        var $temp2 = $('.box-table .list tbody tr');
        if($this.is(':checked')){
            $temp1.each(function(){
                this.checked = true;
            });
            $temp2.addClass('selected');
        }else{
            $temp1.each(function(){
                this.checked = false;
            });
            $temp2.removeClass('selected');
        }
    });

    // 切换冻结中与已冻结
    function on_exam(state){
        // var exam = $('.exam p span').text();
        // if(exam > 0){
        // if($('#state').val() == 0) {
        if(state == 1) {
            $('#state').val(1);
            $('.box-search select').html('<option value>请选择</option>');
            $('.box-search .input-text').val('');
            document.getElementById('click_submit').click();
        }else if(state == 0) {
            $('#state').val(0);
            document.getElementById('click_submit').click();
        }else if(state == 2) {
            $('#state').val(2);
            document.getElementById('click_submit').click();
        }
    }
    // 页面加载完成时添加导航栏选中
    $(window).load(function() {
        if(webstate == 0) {
            document.getElementById('locked_list').className='';
            document.getElementById('waitting_for_unlock').className='';
            document.getElementById('unlock_list').style.backgroundColor='#FDE9D9';
            document.getElementById('unlock_list').className='current';
        }else if(webstate == 1) {
            document.getElementById('unlock_list').className='';
            document.getElementById('waitting_for_unlock').className='';
            document.getElementById('locked_list').style.backgroundColor='#FDE9D9';
            document.getElementById('locked_list').className='current';
        }else if(webstate == 2) {
            document.getElementById('locked_list').className='';
            document.getElementById('unlock_list').className='';
            document.getElementById('waitting_for_unlock').style.backgroundColor='#FDE9D9';
            document.getElementById('waitting_for_unlock').className='current';
        }
    });

    // 立即冻结
    function clickUnlock(id,user_state=506,remedy_btn=0){
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('Unlock'); ?>&id='+id+'&user_state=506&remedy_btn='+remedy_btn,
            dataType: 'json',
            success: function(data){
                console.log(data);
                if (data.status==1){
                    we.success(data.msg, data.redirect);
                }else{
                    we.msg('minus', data.msg);
                }
            },
            error: function(request){
                console.log(request);
            }
        });
    }
</script>


