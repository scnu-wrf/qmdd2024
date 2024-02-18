
<?php
    function countDown($end) {
        $now = time();
        $count_down = strtotime($end) - $now;
        $day = floor($count_down / 3600 / 24);
        $hour = floor($count_down / 3600 % 24);
        $min = floor($count_down / 60 % 60);
        $sec = floor($count_down % 60);
        $out = $day.'天 ';
        $out .= numCorrect($hour).':';
        $out .= numCorrect($min).':';
        $out .= numCorrect($sec);
        echo $out;
    }
    // 补正显示
    function numCorrect($num) {
        if($num < 0) {
            $num = -$num;   // 取绝对值
        }
        return ($num < 10) ? '0'.$num : $num;   // 补正格式
    }
?>
<div class="box">
    <div class="box-title c">
        <h1>
            <span>
                当前界面：系统》账号管理》解冻确认
                <?php
                    if($_REQUEST['state'] != 0) {
                        if($_REQUEST['state'] == 3) {
                            echo '》立即解冻';
                        }else {
                            echo ($_REQUEST['state'] == 1) ? '》待确认' : '》超时未确认';
                        }
                    }
                ?>
            </span>
        </h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
        <?php if($_REQUEST['state'] != 0) { ?>
            <span class="back"><a class="btn" href="javascript:;" onclick="on_exam(0);"><i class="fa fa-reply"></i>返回上一层</a></span>
        <?php } ?>
    </div>
    <div class="box-content">
        <div class="box-header" style="<?php echo ($_REQUEST['state'] == 3) ? 'display: none;' : ''; ?>">
            <?php if ($_REQUEST['state'] == 0) { ?>
            <span id="unconfirmed" class="exam" onclick="on_exam(1);">待确认解冻：<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span></span>
            <span id="timeout" class="exam" onclick="on_exam(2);">超时未解冻：<span style="color:red;font-weight: bold;"><?php echo $count2; ?></span></span>
            <span class="btn" onclick="on_exam(3);">立即解冻</span>
            <?php
            }else {
                if($_REQUEST['state'] == 1) {
            ?>
            <a class="btn btn-blue">到时解冻</a>
            <?php
            }
            if($_REQUEST['state'] == 1 || $_REQUEST['state'] == 2) { ?>
            <a class="btn btn-blue">立即解冻</a>
            <?php } ?>
            <?php } ?>
        </div><!--box-header end-->
        <div class="box-search" style="<?php if($_REQUEST['state'] == 1 || $_REQUEST['state'] == 2) echo 'display: none;'; ?>">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="state" id="state" value="<?php echo Yii::app()->request->getParam('state');?>">
                <?php if(Yii::app()->request->getParam('state') == 0) { ?>
                <label style="margin-right:10px;">
                    <span>确认时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $startDate; ?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $endDate; ?>">
                </label>
                <?php } ?>
                <label style="margin-right:10px;">
                    <span><?php echo ($_REQUEST['state'] ==3) ? '解冻对象' : '关键字' ?>：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="账号/姓名">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list" style="text-align:left;">
                <thead>
                    <tr>
                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th >序号</th>
                        <th ><?php echo $model->getAttributeLabel('GF_ACCOUNT');?></th>
                        <th ><?php echo $model->getAttributeLabel('GF_NAME');?></th>
                        <th ><?php echo $model->getAttributeLabel('user_state');?></th>
                        <th ><?php echo $model->getAttributeLabel('lock_reason');?></th>
                        <th >冻结处理</th>
                        <th ><?php echo $model->getAttributeLabel('lock_date_start');?></th>
                        <th>冻结剩余时间</th>
                        <th><?php echo $model->getAttributeLabel('remedy_btn'); ?></th>
                        <th>确认日期</th>
                        <th>操作员</th>

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
                        <td >冻结处理</td>
                        <td><?php echo $v->lock_date_start.' - '.$v->lock_date_end; ?></td>
                        <td><?php countDown($v->lock_date_end); ?></td>
                        <td>
                            <?php
                                if(is_null($v->remedy_btn)) {
                                    echo '';
                                }elseif($v->remedy_btn==1) {
                                    echo '常规解冻';
                                }elseif($v->remedy_btn==0) {
                                    echo '立即解冻';
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if($v->user_state==506) {
                                    echo $v->uDate;
                                }
                            ?>
                        </td>
                        <td>
                            <?php echo $v->admin_gfid.'/'.$v->admin_gfname; ?>
                        </td>
                    </tr>
                    <script>var end = new Date('<?php echo $v->lock_date_end; ?>');</script>
<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->

        <div class="box-page c"><?php $this->page($pages);?></div>

    </div><!--box-content end-->
</div><!--box end-->
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
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

    // 计时器
    // setInterval(function() {
    //     var now = new Date();
    //     var CountDown = end.getTime() - now.getTime();
    //     var day = 0;
    //     var hour = 0;
    //     var min = 0;
    //     var sec = 0;
    //     if(CountDown >= 0) {
    //         day = CountDown / 3600000 / 24;
    //         hour = CountDown / 3600000 % 24;
    //         min = CountDown / 60000 % 60;
    //         sec = CountDown / 1000 % 60;
    //     }
    //     function toDouble(num) {
    //         return num < 10 ? '0' + num : num;
    //     }
    //     $("#countDown").html(day+'天 '+hour+':'+min+':'+sec);
    // }, 1000);
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

    function on_exam(num){
        if(num == 1) {
            var exam = $('#unconfirmed span').text();
            if(exam>0){
                $('#state').val(1);
                document.getElementById('click_submit').click();
            }else {
                $('#state').val(0);
                document.getElementById('click_submit').click();
            }
        }else if(num == 2) {
            var exam = $('#timeout span').text();
            if(exam>0){
                $('#state').val(2);
                document.getElementById('click_submit').click();
            }else {
                $('#state').val(0);
                document.getElementById('click_submit').click();
            }
        }else if(num == 3) {
            $('#state').val(3);
            document.getElementById('click_submit').click();
        }else if(num == 0) {
            $('#state').val(0);
            document.getElementById('click_submit').click();
        }
    }
</script>