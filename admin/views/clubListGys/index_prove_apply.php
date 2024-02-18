<?php //var_dump($_REQUEST);?>
<div class="box">
    <div class="box-title c">
        <h1> <span>当前界面：供应商》供应商认证》添加认证</span> </h1>
        <span style="float:right;padding-right:15px;"> <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a> </span> </div>
    <!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <?php echo show_command('添加','','添加');?>
        </div>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>申请日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入账号/名称">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div>
        <div class="box-table">
            <table class="list" style="text-align:left;">
                <thead>
                <tr>
                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                    <th >序号</th>
                    <th><?php echo $model->getAttributeLabel('club_code');?></th>
                    <th><?php echo $model->getAttributeLabel('company');?></th>
                    <th><?php echo $model->getAttributeLabel('company_type_id'); ?></th>
                    <th><?php echo $model->getAttributeLabel('club_name');?></th>
                    <th><?php echo $model->getAttributeLabel('apply_name');?></th>
                    <th><?php echo $model->getAttributeLabel('contact_phone');?></th>
                    <th>状态</th>
                    <th><?php echo $model->getAttributeLabel('edit_apply_time');?></th>
                    <th>操作</th>
                </tr>
                </thead>

                <tbody>
                    <?php $index = 1;foreach ($arclist as $v) { ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->club_code;?></td>
                        <td><?php echo $v->company;?></td>
                        <td><?php echo $v->company_type;  ?></td>
                        <td><?php echo $v->club_name;?></td>
                        <td><?php echo $v->apply_name;?></td>
                        <td><?php echo $v->contact_phone;?></td>
                        <td><?php echo $v->edit_state_name; ?></td>
                        <td><?php echo $v->uDate;?></td>

                        <td >
                            <?php echo show_command('修改',$this->createUrl('update_data', array('id'=>$v->id,'action'=>'index_prove_apply'))); ?>
                            <a class="btn" href="javascript:;" onclick="we.cancel(<?php echo $v->id;?>, cancelUrl);" title="取消">取消</a>
                        </td>
                    </tr>
                    <?php $index++; } ?>
                </tbody>
            </table>
        </div>
        <!--box-table end-->

        <div class="box-page c">
            <?php $this->page($pages);?>
        </div>
    </div>
    <!--box-content end-->
</div>
<!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
    var cancelUrl = '<?php echo $this->createUrl('cancel', array('id'=>'ID','new'=>'edit_state','del'=>null,'yes'=>'取消成功','no'=>'取消失败'));?>';

     //时分秒：
    $(function(){
        var $start_time=$('#start_date');
        var $end_time=$('#end_date');
        $start_time.on('click', function(){
            var end_input=$dp.$('end_date')
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'end_date\')}'});
        });
        $end_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'start_date\')}'});
        });
    });

    <?php if($_REQUEST['state']!=371){?>
        $(".box-header>.btn:eq(0)").on("click",function(){
            $.dialog.data('club_id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/clubEditlist", array('club_type'=>380,'state'=>2));?>',{
                id:'danwei',
                lock:true,
                opacity:0.3,
                title:'添加认证申请',
                width:'500px',
                height:'60%',
                close: function () {
                    if($.dialog.data('club_id')>0){
                        window.location.href="<?php echo $this->createUrl('update_data'); ?>&id="+$.dialog.data('club_id')+'&action=index_prove_apply';
                    }
                }
            });
            return false;
        })
    <?php }?>
</script>
