<style>
    .box-table .list tr th,.box-table .list tr td{
        text-align: center;
    }
</style>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>单位项目待缴费列表</h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a class="btn btn-blue" href="javascript:;" onclick="checkval('.check-item input:checked','0');">正常入驻</a>
            <a class="btn btn-blue" href="javascript:;" onclick="checkval('.check-item input:checked','1');">免费/有偿入驻</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入项目名称 / 单位名称" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <thead>
                <table class="list">
                    <?php $checked = 'checked="checked"'; ?>
                    <tr>
                        <th class="check"><input type="checkbox" id="j-checkall" class="input-check"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('p_code');?></th>
                        <th><?php echo $model->getAttributeLabel('club_name');?></th>
                        <th><?php echo $model->getAttributeLabel('project_id');?></th>
                        <th><?php echo $model->getAttributeLabel('club_type');?></th>
                        <th><?php echo $model->getAttributeLabel('partnership_type');?></th>
                        <th>应收金额</th>
                        <th>收费项目</th>
                        <th>缴费状态</th>
                        <th><?php echo $model->getAttributeLabel('add_time');?></th>
                        <th>操作</th>
                    </tr>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" <?php if(empty($v->mall_order_num))echo $checked; ?> value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td><?php echo $v->order_num; ?></td>
                            <td><?php echo $v->p_code; ?></td>
                            <td><?php echo $v->club_name; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php if(!empty($v->club_type))echo $v->base_club_type->F_NAME; ?></td>
                            <td><?php if(!empty($v->partnership_type))echo $v->base_partnership_type->F_NAME; ?></td>
                            <td><?php if($v->cost_admission>0){ echo $v->cost_admission;}elseif($v->renew>0){ echo $v->renew; } ?></td>
                            <td><?php if($v->cost_admission>0){ echo '入驻费'; }else if($v->renew>0){ echo '续签费'; } ?></td>
                            <td><?php if(empty($v->fee_id))echo '待缴费'; ?></td>
                            <td><?php echo $v->add_time; ?></td>
                            <td>
                                <?php
                                    if(empty($v->mall_order_num)){echo '<a class="btn btn-blue" href="javascript:;" onclick="send('.$v->id.')">通知缴费</a>&nbsp;';}
                                    elseif(!empty($v->mall_order_num)){echo '<a class="btn btn-blue" href="javascript:;" onclick="unsend('.$v->id.')">取消通知</a>&nbsp;';}
                                ?>
                            </td>
                        </tr>
                    <?php $index++; } ?>
                </table>
            </thead>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
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
        var str = '';
        $(op).each(function() {
            str += $(this).val() + ',';
        });
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        if(str.length<1){
            we.msg('minus','请先选中要通知的数据');
            return false;
        }
        if(num==0){ wholeAll(str); }
        else { freeAll(str); }
    };

    // function sendCode(thisBtn,time){
	// 	var clock = '';
	// 	var nums = time;
	// 	var btn;
	// 	btn = thisBtn;
	// 	btn.innerHTML = '请稍等......';
	// 	clock = setInterval(doLoop, 1000); //一秒执行一次
	// 	function doLoop(){
	// 		nums--;
	// 		if(nums > 0){
	// 			btn.innerHTML = '大概'+nums+'秒完成';
	// 		}else{
	// 		clearInterval(clock); //清除js定时器
	// 			btn.disabled = false;
	// 			btn.innerHTML = '操作失败，请重新加载';
	// 			nums = time; //重置时间
	// 		}
	// 	}
	// }

    // 正常入驻
    function wholeAll(id){
        we.loading('show');
        // $('#loading').append('<span id="dpsn_load" style="position:absolute;top: 39%;left: 48%;color:red;"></span>');
        // sendCode(dpsn_load,10);
        $.ajax({
            type:'post',
            url:'<?php echo $this->createUrl('whole'); ?>&id='+id,
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

    // 免费/有偿入驻
    function freeAll(id){
        // var str = id.split(',');
        we.loading('show');
        $.ajax({
            type:'post',
            url:'<?php echo $this->createUrl('free'); ?>&id='+id,
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

    // 单个通知
    function send(id){
        we.loading('show');
        $.ajax({
            type:'post',
            url:'<?php echo $this->createUrl('send'); ?>&id='+id,
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

    // 取消通知
    function unsend(id){
        we.loading('show');
        $.ajax({
            type:'post',
            url:'<?php echo $this->createUrl('unsend'); ?>&id='+id,
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
