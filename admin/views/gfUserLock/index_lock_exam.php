<div class="box">
    <div class="box-title c">
        <h1>
            <span>当前界面：系统》账号冻结注销》冻结审核</span>
            <script>var webstate = <?php echo $_REQUEST['state']; ?></script>
        </h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
        <?php // if(Yii::app()->request->getParam('state')==1) { ?>
            <!-- <span class="back"><a class="btn" href="javascript:;" onclick="on_exam();"><i class="fa fa-reply"></i>返回上一层</a></span> -->
        <?php // } ?>
    </div>
    <div class="box-content">
        <?php // if(empty($_REQUEST['state'])){ ?>
            <!-- <div class="box-header">
                <span class="exam" onclick="on_exam();"><p>待审核：<span style="color:red;font-weight: bold;"><?php // echo $count1; ?></span></p></span>
            </div> -->
        <?php // } ?>
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
                    <span><?php echo ($_REQUEST['state'] == 1) ? '申请' : '审核' ?>日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $startDate; ?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $endDate; ?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" id="input-text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="账号/姓名">
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
                        <th width="<?php echo ($_REQUEST['state'] == 1) ? '12%' : '9.7%'; ?>"><?php echo $model->getAttributeLabel('GF_ACCOUNT');?></th>
                        <th width="<?php echo ($_REQUEST['state'] == 1) ? '12%' : '9.7%'; ?>"><?php echo $model->getAttributeLabel('GF_NAME');?></th>
                        <th width="<?php echo ($_REQUEST['state'] == 1) ? '12%' : '9.7%'; ?>"><?php echo $model->getAttributeLabel('user_state');?></th>
                        <th width="<?php echo ($_REQUEST['state'] == 1) ? '12%' : '9.7%'; ?>"><?php echo $model->getAttributeLabel('lock_reason');?></th>
                        <th width="<?php echo ($_REQUEST['state'] == 1) ? '12%' : '9.7%'; ?>">冻结处理</th>
                        <?php if($_REQUEST['state'] == 1) { ?>
                            <th width="12%">审核状态</th>
                            <th width="12%">申请时间</th>
                        <?php }else { ?>
                            <th width="9.7%">冻结状态</th>
                            <th width="9.7%"><?php echo $model->getAttributeLabel('lock_date_start');?></th>
                            <th width="9.7%">审核日期</th>
                            <th width="9.7%"><?php echo $model->getAttributeLabel('admin_gfname'); ?></th>
                        <?php } ?>
                        <th width="<?php echo ($_REQUEST['state'] == 1) ? '12%' : '9.7%'; ?>">操作</th>
                        <!--<th ><?php //echo $model->getAttributeLabel('admin_gfid');?></th>
                        <th ><?php //echo $model->getAttributeLabel('uDate');?></th>-->
                    </tr>
                </thead>
                <tbody>
<?php
$index = 1;
//print_r($arclist);
foreach($arclist as $v){

?>
                    <tr>
                    <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->GF_ID); ?>"></td>
                        <td ><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td ><?php echo $v->GF_ACCOUNT; ?></td>
                        <td ><?php echo $v->GF_NAME; ?></td>
                        <td ><?php echo $v->user_state_name; ?></td>
                        <td ><?php echo $v->lock_reason; ?></td>
                        <!-- <td > -->
                            <?php
                                // if(is_null($v->remedy_btn)){
                                //     echo '';
                                // }elseif($v->remedy_btn==1){
                                //     echo '常规解冻';
                                // }elseif($v->remedy_btn==0){
                                //     echo '立即解冻';
                                // }
                            ?>
                        <!-- </td> -->
                        <td><?php echo ($v->lock_way == 1282) ? '冻结7日' : (($v->lock_way == 1283) ? '冻结30日' : (($v->lock_way == 507) ? '永久冻结' : $v->lock_way)); ?></td>
                        <td><?php echo !empty($v->state) ? $v->state_name : ''; ?></td>
                        <?php if($_REQUEST['state'] == 1) {}else{ ?>
                            <td><?php echo $v->lock_date_start.' - '.$v->lock_date_end ?></td>
                        <?php } ?>
                        <td><?php echo $v->uDate; ?></td>
                        <?php if($_REQUEST['state'] == 1) {}else{ ?>
                            <td ><?php if(!empty($v->admin_gfid)) echo $v->admin_gfid.'/'.$v->admin_gfname; ?></td>
                        <?php } ?>
                        <td>
                            <?php
                                if($_REQUEST['state'] == 1) {
                                    echo show_command('审核',$this->createUrl('update_exam', array('id'=>$v->ID, 'action'=>'lock_exam'))).'&nbsp;&nbsp;';
                                }else {
                                    echo show_command('详情',$this->createUrl('update_exam', array('id'=>$v->ID, 'action'=>'lock_check')));
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

    var screen = document.documentElement.clientWidth;

    // function on_exam(){
    //     var exam = $('.exam p span').text();
    //     if(exam>0){
    //         $('#state').val(1);
    //         $('.box-search .input-text').val('');
    //         $('.box-search .start_date').val('');
    //         document.getElementById('click_submit').click();
    //     }else {
    //         $('#state').val(0);
    //         document.getElementById('click_submit').click();
    //     }
    // }

    // 切换待审核与审核记录
    function on_exam(state){
        // var exam = $('.exam p span').text();
        // if(exam > 0){
        // if($('#state').val() == 0) {
        if(state == '1') {
            $('#state').val(1);
            $('.box-search select').html('<option value>请选择</option>');
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