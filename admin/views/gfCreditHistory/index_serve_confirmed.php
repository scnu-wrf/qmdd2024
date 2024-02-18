
<div class="box">
    <div class="box-title c">
        <h1>
            当前界面：系统》积分/体育豆》服务置换积分确认<?php echo !empty($_REQUEST['state'])?' 》待确认':'';?>
        </h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <?php if(empty($_REQUEST['state'])){?>
            <span class="exam" onclick="on_exam();"><p>待确认：<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span></p></span>
            <?php }else{?>
                <a class="btn btn-blue" href="javascript:;" onclick="checkval('.check-item input:checked');">确认</a>
            <?php }?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="state" id="state" value="<?php echo Yii::app()->request->getParam('state');?>">
                <?php if(empty($_REQUEST['state'])){?>
                    <label style="margin-right:10px;">
                        <span>确认时间：</span>
                        <input style="width:80px;" class="input-text" type="text" placeholder="" id="time_start" name="time_start" value="<?php echo $time_start; ?>">
                        <span>-</span>
                        <input style="width:80px;" class="input-text" type="text" placeholder="" id="time_end" name="time_end" value="<?php echo $time_end; ?>">
                    </label>
                <?php }?>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入账号/名称" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <thead>
                <table class="list">
                    <tr>
                        <th class="check"><input type="checkbox" id="j-checkall" class="input-check"></th>
                        <th>序号</th>
                        <th>积分获得账号</th>
                        <th><?php echo $model->getAttributeLabel('gf_id');?></th>
                        <th>服务项目</th>
                        <th><?php echo $model->getAttributeLabel('service_source');?></th>
                        <th>获得积分</th>
                        <th>服务日期</th>
                        <?php if(empty($_REQUEST['state'])){?>
                            <th><?php echo $model->getAttributeLabel('exchange_time');?></th>
                        <?php }else{?>
                            <th>操作</th>
                        <?php }?>
                    </tr>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td><?php echo $v->account;?></td>
                            <td><?php echo $v->nickname;?></td>
                            <td><?php echo $v->got_credit_reson; ?></td>
                            <td><?php echo $v->service_source; ?></td>
                            <td><?php echo $v->credit; ?></td>
                            <td><?php echo $v->add_time; ?></td>
                            <?php if(empty($_REQUEST['state'])){?>
                                <td><?php echo $v->exchange_time; ?></td>
                            <?php }else{?>
                                <td><a class="btn btn-blue" href="javascript:;" onclick="checkval(<?=$v->id;?>,'one')">确认</a></td>
                            <?php }?>
                        </tr>
                    <?php $index++; } ?>
                </table>
            </thead>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>

    function on_exam(){
        var exam = $('.exam p span').text();
        $('#state').val(371);
        $('.box-search select').html('<option value>请选择</option>');
        $('.box-search .input-text').val('');
        document.getElementById('click_submit').click();
    }

    var $start_time=$('#time_start');
    var $end_time=$('#time_end');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    
    $('#j-checkall').on('click', function(){
        $temp1 = $('.check-item .input-check');
        $temp2 = $('.box-table .list tbody tr');
        $this = $(this);
        if($this.is(':checked')){
            $temp1.each(function(){
                this.checked = true;
            });
            $temp2.addClass('selected');
        }
        else{
            $temp1.each(function(){
                this.checked = false;
            });
            $temp2.removeClass('selected');
        }
    });

    // 获取所有选中多选框的值
    checkval = function(op,num){
        if(num=='one'){
            var str = op;
        }else{
            var str = '';
            $(op).each(function() {
                str += $(this).val() + ',';
            });
        }
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        if(str.length<1){
            we.msg('minus','请先选中要确认的数据');
            return false;
        }
        confirmed(str);
    };

    // 确认操作
    function confirmed(id){
        we.loading('show');
        $.ajax({
            type:'post',
            url:'<?php echo $this->createUrl('confirmed'); ?>&id='+id,
            // data:{id:id},
            dataType:'json',
            success: function(data){
                we.loading('hide');
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                }else{
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }
</script>
