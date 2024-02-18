
<div class="box">
    <!-- <div class="box-detail-tab">
        <ul class="c">
            <li><a href="<?php //echo $this->createUrl('clubProject/index_confirmed'); ?>">服务机构入驻实收费用列表</a></li>
            <li><a href="<?php //echo $this->createUrl('qualificationsPerson/index_confirmed'); ?>">服务者入驻实收费用列表</a></li>
            <li><a href="#">龙虎会员注册实收费用列表</a></li>
            <li class="current" style="border-right:none;"><a href="<?php //echo $this->createUrl('clubProject/index_strat_confirmed'); ?>">战略伙伴会员注册实收费用列表</a></li>
        </ul>
    </div>box-detail-tab end -->
    <div class="box-title c">
        <h1>
            <?php if(empty($_REQUEST['free_state_Id'])){echo '当前界面：项目》单位项目费用》项目缴费确认';}elseif(!empty($_REQUEST['free_state_Id'])&&$_REQUEST['free_state_Id']==1201){echo '当前界面：项目》单位项目费用》项目缴费确认》待确认';}?>
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
                    <span>注册项目：</span>
                    <?php echo downList($project,'id','project_name','project'); ?>
                </label>
                <?php if(!empty($_REQUEST['free_state_Id'])&&$_REQUEST['free_state_Id']==1201){?>
                    <label style="display: inline-block;width: 200px;padding-top: 5px;">
                        <span>费用方案：</span>
                        <?php echo downList($fee_list,'id','name','pay_blueprint','style="margin-left: 12px;width: 92px;"'); ?>
                    </label>
                <?php }?>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入项目名称 / 单位名称" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
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
                        <th><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('p_code');?></th>
                        <th><?php echo $model->getAttributeLabel('club_name');?></th>
                        <th><?php echo $model->getAttributeLabel('club_type');?></th>
                        <th><?php echo $model->getAttributeLabel('project_id');?></th>
                        <th><?php echo $model->getAttributeLabel('pay_blueprint');?></th>
                        <th><?php echo $model->getAttributeLabel('cost_admission');?></th>
                        <th><?php echo $model->getAttributeLabel('pay_way');?></th>
                        <th><?php echo $model->getAttributeLabel('cost_account');?></th>
                        <th>状态</th>
                        <?php if(empty($_REQUEST['free_state_Id'])){?>
                            <th>确认时间</th>
                            <th><?php echo $model->getAttributeLabel('confirm_adminid');?></th> 
                        <?php }else{?>
                            <th>操作时间</th>
                        <?php }?>
                        <th>操作</th>
                    </tr>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td><?php echo $v->order_num; ?></td>
                            <td><?php echo $v->p_code; ?></td>
                            <td><?php echo $v->club_name; ?></td>
                            <td><?php echo $v->club_type_name; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php echo $v->pay_blueprint_name; ?></td>
                            <td><?php echo $v->cost_admission; ?></td>
                            <td><?php echo $v->pay_way_name; ?></td>
                            <td><?php echo $v->cost_account; ?></td>
                            <td><?php echo $v->free_state_name; ?></td>
                            <td><?php echo $v->uDate; ?></td>
                            <?php if(empty($_REQUEST['free_state_Id'])){?>
                                <td><?php echo (!is_null($v->confirmAdmin)?$v->confirmAdmin->send_adminname:'').'/'.$v->confirm_adminname; ?></td>
                            <?php }?>
                            <td>
                                <?php if(empty($_REQUEST['free_state_Id'])){?>
                                    <?php echo show_command('详情',$this->createUrl('update_unit', array('id'=>$v->id))); ?>
                                <?php }else{?>
                                    <a class="btn btn-blue" href="javascript:;" onclick="checkval(<?=$v->id;?>,'one')">确认</a>
                                <?php }?>
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
    var $start_time=$('#time_start');
    var $end_time=$('#time_end');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
         WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });

    function on_exam(){
        var exam = $('.exam p span').text();
        $('#free_state_Id').val(1201);
        $('.box-search select').html('<option value>请选择</option>');
        $('.box-search .input-text').val('');
        document.getElementById('click_submit').click();
    }
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
