<div class="box">
    <div class="box-title c">
        <h1>当前界面：点/直播管理 》 打赏礼物设置与管理 》 <a class="nav-a">虚拟货币兑换充值审核</a></h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end--> 
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>审核状态：</span>
                    <?php echo downList($state,'f_id','F_NAME','state'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="请输入" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="text-align:center;">序号</th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('code');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('recharge_amount');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('exchange_num');?></th>
                        <th style="text-align:center;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php echo $v->code; ?></td>
                        <td><?php echo $v->recharge_amount; ?></td>
                        <td><?php echo $v->exchange_num; ?></td>
                        <td>
                            <?php echo show_command('修改',$this->createUrl('update_exam',array('id'=>$v->id))); ?>
                            <?php echo show_command('删除','\''.$v->id.'\''); ?>
                        </td>
                    </tr>
                    <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>