<div class="box">
    <div class="box-title c">
        <h1>当前界面：订场管理》场馆可预订时间管理》<a class="nav-a">时间策略管理</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:150px;" class="input-text" placeholder="策略名称" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
                <?php echo show_command('添加',$this->createUrl('create'),'添加'); ?>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
        <thead>
            <tr>
                <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                <th><?php echo $model->getAttributeLabel('code');?></th>
                <th><?php echo $model->getAttributeLabel('name');?></th>
                <th><?php echo $model->getAttributeLabel('timespace');?></th>
                <th><?php echo $model->getAttributeLabel('morning_start');?></th>
                <th><?php echo $model->getAttributeLabel('morning_end');?></th>
                <th><?php echo $model->getAttributeLabel('afternoon_start');?></th>
                <th><?php echo $model->getAttributeLabel('afternoon_end');?></th>
                <th><?php echo $model->getAttributeLabel('night_start');?></th>
                <th><?php echo $model->getAttributeLabel('night_end');?></th>
                <th>操作</th>
            </tr>
        </thead>
                <tbody>
<?php $index = 1; ?>
<?php foreach($arclist as $v){ ?>
                    <tr id="hidden_<?php echo $v->id?>">
                        <td class="check check-item">
                        <input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php echo $v->code; ?></td>
                        <td><?php echo $v->name; ?></td>
                        <td><?php echo $v->timespace; ?>小时</td>
                        <td><?php echo $v->morning_start; ?></td>
                        <td><?php echo $v->morning_end; ?></td>
                        <td><?php echo $v->afternoon_start; ?></td>
                        <td><?php echo $v->afternoon_end; ?></td>
                        <td><?php echo $v->night_start; ?></td>
                        <td><?php echo $v->night_end; ?></td>
                        <td>
                    <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑">编辑</a>
                    <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除">删除</a>
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