<div class="box">
    <div class="box-title c">
        <h1><span>当前界面：服务者》入驻缴费管理》超时未支付</span></h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search" style="padding-bottom: 15px;">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>日期：</span>
                    <input style="width:80px;" class="input-text" type="text" placeholder="" id="time_start" name="time_start" value="<?php echo $time_start; ?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" placeholder="" id="time_end" name="time_end" value="<?php echo $time_end; ?>">
                </label>
                <label style="margin-right:10px;display: inline-block;width: auto;padding-top: 5px;">
                    <span>关键字：</span>
                    <input style="width:150px;" class="input-text" type="text" placeholder="请输入账号/姓名" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit" >查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <tr>
                    <!-- <th class="check" ><input type="checkbox" id="j-checkall" class="input-check"></th> -->
                    <th width="3%">序号</th>
                    <th width="8.8%"><?php echo $model->getAttributeLabel('qualification_gf_code'); ?></th>
                    <th width="8.8%">账号姓名</th>
                    <th width="8.8%"><?php echo $model->getAttributeLabel('qualification_project_id') ?></th>
                    <th width="8.8%"><?php echo $model->getAttributeLabel('qualification_type_id') ?></th>
                    <th width="8.8%"><?php echo $model->getAttributeLabel('logon_way') ?></th>
                    <th width="8.8%"><?php echo $model->getAttributeLabel('pay_way'); ?></th>
                    <th width="8.8%"><?php echo $model->getAttributeLabel('pay_blueprint'); ?></th>
                    <th width="8.8%"><?php echo $model->getAttributeLabel('cost_admission'); ?></th>
                    <th width="8.8%">缴费截止时间</th>
                    <th width="8.8%"><?php echo $model->getAttributeLabel('is_pay'); ?></th>
                    <th width="8.8%">入驻状态</th>
                </tr>
                <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <!-- <td class="check check-item"><input class="input-check" type="checkbox" value="<?php // echo CHtml::encode($v->id); ?>"></td> -->
                        <td><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php echo $v->qualification_gf_code; ?></td>
                        <td><?php echo $v->qualification_gfaccount.'/'.$v->qualification_name; ?></td>
                        <td><?php echo $v->qualification_project_name; ?></td>
                        <td><?php echo $v->qualification_type; ?></td>
                        <td><?php echo $v->logon_way_name; ?></td>
                        <td><?php echo $v->pay_way_name; ?></td>
                        <td><?php echo $v->pay_blueprint_name; ?></td>
                        <td><?php echo $v->cost_admission; ?></td>
                        <td>
                        <?php
                            if(!empty($v->order_num)){
                                $or = Carinfo::model()->find('order_num="'.$v->order_num.'"');
                                echo $or->effective_time;
                            }
                        ?>
                        </td>
                        <td><?php if($v->cost_admission != 0 && $v->is_pay == 463) echo '超时未支付'; ?></td>
                        <td><?php echo ($v->free_state_Id == 1400) ? '入驻失败' : $v->free_state_name; ?></td>
                    </tr>
                <?php $index++; } ?>
            </table>
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

</script>