<div class="box">
    <div class="box-title c">
        <h1>当前界面：点/直播管理 》 打赏礼物设置与管理 》 <a class="nav-a">虚拟商品设置</a></h1>
    </div><!--box-title end--> 
    <div class="box-content">
    	<div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create'),'添加'); ?>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <?php echo show_command('批删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="请输入商品编码 / 商品名" value="<?php echo Yii::app()->request->getParam('keywords');?>">
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
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('product_code');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('product_name');?></th>
                        <th style="text-align:center;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php echo $v->product_code; ?></td>
                        <td><?php echo $v->product_name; ?></td>
                        <td>
                            <?php echo show_command('修改',$this->createUrl('update',array('id'=>$v->id))); ?>
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