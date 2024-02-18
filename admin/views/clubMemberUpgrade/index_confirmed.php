
<div class="box">
    <div class="box-title c">
        <h1>
            <span><?php echo empty($_REQUEST['free_state_Id'])?'当前界面：服务者》服务者费用》缴费确认':'当前界面：服务者》服务者费用》缴费确认》待确认'?></span>
        </h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <?php if(empty($_REQUEST['free_state_Id'])){?>
            <span class="exam" onclick="on_exam();"><p>待确认：<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span></p></span>
            <?php }else{?>
                <a class="btn btn-blue" href="javascript:;" onclick="checkval('.check-item input:checked');">确认</a>
            <?php }?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="club_id" value="<?php echo get_session('club_id');?>">
                <input type="hidden" name="free_state_Id" id="free_state_Id" value="<?php echo Yii::app()->request->getParam('free_state_Id');?>">
                <?php if(empty($_REQUEST['free_state_Id'])){?>
                <label style="margin-right:10px;">
                    <span>确认时间：</span>
                    <input style="width:80px;" class="input-text" type="text" placeholder="" id="time_start" name="time_start" value="<?php echo $time_start; ?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" placeholder="" id="time_end" name="time_end" value="<?php echo $time_end; ?>">
                </label>
                <?php }?>
                <label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php echo downList($project,'id','project_name','project'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>龙虎等级：</span>
                    <?php echo downList($level,'id','card_name','member_level'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入账号/姓名" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <thead>
                <table class="list">
                    <?php $checked = 'checked="checked"'; ?>
                    <tr>
                        <?php if(empty($_REQUEST['free_state_Id'])){?>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('order_num') ?></th>
                            <th><?php echo $model->getAttributeLabel('GF_ACCOUNT') ?></th>
                            <th><?php echo $model->getAttributeLabel('ZSXM') ?></th>
                            <th><?php echo $model->getAttributeLabel('project_id') ?></th>
                            <th><?php echo $model->getAttributeLabel('member_level') ?></th>
                            <th><?php echo $model->getAttributeLabel('pay_blueprint') ?></th>
                            <th><?php echo $model->getAttributeLabel('cost_admission') ?></th>
                            <th><?php echo $model->getAttributeLabel('pay_way') ?></th>
                            <th><?php echo $model->getAttributeLabel('cost_account') ?></th>
                            <th><?php echo $model->getAttributeLabel('free_state_Id') ?></th>
                            <th><?php echo $model->getAttributeLabel('auth_state') ?></th>
                            <th><?php echo $model->getAttributeLabel('grade_achieve_time') ?></th>
                            <th>操作</th>
                        <?php }else{?>
                            <th class="check"><input type="checkbox" id="j-checkall" class="input-check"></th>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('order_num') ?></th>
                            <th><?php echo $model->getAttributeLabel('GF_ACCOUNT') ?></th>
                            <th><?php echo $model->getAttributeLabel('ZSXM') ?></th>
                            <th><?php echo $model->getAttributeLabel('project_id') ?></th>
                            <th><?php echo $model->getAttributeLabel('member_level') ?></th>
                            <th><?php echo $model->getAttributeLabel('pay_blueprint') ?></th>
                            <th><?php echo $model->getAttributeLabel('cost_admission') ?></th>
                            <th><?php echo $model->getAttributeLabel('pay_way') ?></th>
                            <th><?php echo $model->getAttributeLabel('cost_account') ?></th>
                            <th><?php echo $model->getAttributeLabel('free_state_Id') ?></th>
                            <th>操作</th>
                        <?php }?>
                    </tr>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <?php if(empty($_REQUEST['free_state_Id'])){?>
                                <td><span class="num num-1"><?php echo $index; ?></td>
                                <td><?php echo $v->order_num; ?></td>
                                <td><?php if(!empty($v->gfUser->GF_ACCOUNT))echo $v->gfUser->GF_ACCOUNT; ?></td>
                                <td><?php if(!empty($v->gfUser->ZSXM))echo $v->gfUser->ZSXM; ?></td>
                                <td><?php echo $v->project_name; ?></td>
                                <td><?php echo $v->member_level_name; ?></td>
                                <td><?php echo $v->pay_blueprint_name; ?></td>
                                <td><?php echo $v->cost_admission; ?></td>
                                <td><?php echo $v->pay_way_name; ?></td>
                                <td><?php echo $v->cost_account; ?></td>
                                <td><?php echo $v->free_state_name; ?></td>
                                <td><?php echo $v->auth_state_name; ?></td>
                                <td><?php echo $v->grade_achieve_time; ?></td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id))); ?>
                                </td>
                            <?php }else{?>
                                <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>" <?php if($v->free_state_Id==1202){echo 'disabled="disabled"';} ?>></td>
                                <td><span class="num num-1"><?php echo $index; ?></td>
                                <td><?php echo $v->order_num; ?></td>
                                <td><?php if(!empty($v->gfUser->GF_ACCOUNT))echo $v->gfUser->GF_ACCOUNT; ?></td>
                                <td><?php if(!empty($v->gfUser->ZSXM))echo $v->gfUser->ZSXM; ?></td>
                                <td><?php echo $v->project_name; ?></td>
                                <td><?php echo $v->member_level_name; ?></td>
                                <td><?php echo $v->pay_blueprint_name; ?></td>
                                <td><?php echo $v->cost_admission; ?></td>
                                <td><?php echo $v->pay_way_name; ?></td>
                                <td><?php echo $v->cost_account; ?></td>
                                <td><?php echo $v->free_state_name; ?></td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id))); ?>
                                    <a class="btn btn-blue" href="javascript:;" onclick="checkval(<?=$v->id;?>,'one')">确认</a>
                                </td>
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
    $(function(){
        var time_start = $('#time_start');
        var time_end = $('#time_end');
        time_start.on('click',function(){
            var end_input=$dp.$('time_end');
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'time_end\')}'});
        });
        time_end.on('click',function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'time_start\')}'});
        });
    })

    // 每页全选
    $('#j-checkall').on('click', function(){
        var $temp1 = $('.check-item .input-check');
        var $temp2 = $('.box-table .list tbody tr');
        var $this = $(this);
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
    // 单选
    $('.check-item .input-check').on('click', function() {
        var $this = $(this);
        if ($this.is(':checked')) {
            $this.parent().parent().addClass('selected');
        } else {
            $this.parent().parent().removeClass('selected');
        }
    });

    function on_exam(){
        var exam = $('.exam p span').text();
        $('#free_state_Id').val(1201);
        $('.box-search select').html('<option value>请选择</option>');
        $('.box-search .input-text').val('');
        document.getElementById('click_submit').click();
    }
    

    // 获取所有选中多选框的值
    checkval = function(op,num){
        // console.log(op)
        if(num=='one'){
            var str = op;
        }else{
            var str = '';
            $(".check-item .input-check:checked").each(function(){
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
        var an = function(){
            confirmed(str);
        }
        $.fallr('show', {
            buttons: {
                button1: {text: '确定', danger: true, onclick: an},
                button2: {text: '取消'}
            },
            content: '是否确认？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });
    };

    // 确认操作
    function confirmed(id){
        console.log(id)
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