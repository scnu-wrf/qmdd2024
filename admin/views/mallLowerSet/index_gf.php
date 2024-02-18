
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》GF商城上下架管理》<a class="nav-a">商品下架</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create',array('p_id'=>0)),'添加下架'); ?>
            <?php echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>商家名称：</span>
                    <input style="width:200px;" class="input-text" type="text" name="supplier" value="<?php echo Yii::app()->request->getParam('supplier');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text"  placeholder="请输入方案编码/标题" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                	<tr class="table-title">
                        <th style="text-align:center;" class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="text-align:center;width:25px;">序号</th>
                        <th style="width:10%;"><?php echo $model->getAttributeLabel('event_code');?></th>
                        <th style="width:20%;"><?php echo $model->getAttributeLabel('event_title');?></th>
                        <th><?php echo $model->getAttributeLabel('supplier_id');?></th>
                        <th><?php echo $model->getAttributeLabel('down_time');?></th>
                        <th><?php echo $model->getAttributeLabel('f_check');?></th>
                        <th>操作</th>
                    </tr>
<?php $index=1; foreach($arclist as $v){ ?>
                    <tr>
                    	<td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style="text-align:center;"><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php echo $v->event_code; ?></td>
                        <td><?php echo $v->event_title; ?></td>
                        <td><?php echo $v->supplier_name; ?></td>
                        <td><?php echo $v->down_time; ?></td>
                        <td><?php echo $v->f_check_name; ?></td>
                        <td>
                            <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'p_id'=>0))); ?>
                            <?php echo (!($v->f_check==372 || $v->f_check==371)) ?show_command('删除','\''.$v->id.'\'') : "" ; ?>
                        </td>
                    </tr>
                   <?php $index++; } ?>
                </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>
