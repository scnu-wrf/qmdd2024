<div class="box">
    <div class="box-title c">
        <h1>当前界面：订场管理》场馆可预订时间管理》<a class="nav-a">场地策略管理</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:150px;" class="input-text" placeholder="" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>场馆名称：</span>
                    <?php echo downList($stadium,'name','name','stadium'); ?> 
                </label>
                <label style="margin-right:10px;">
                    <span>场地类型：</span>
                    <?php echo downList($place_type,'name','name','type'); ?> 
                </label>
                <label style="margin-right:10px;">
                    <span>包含场地：</span>
                    <?php echo downList($place,'name','name','place'); ?> 
                </label>
                <label style="margin-right:20px;">
                    <span>价格策略：</span>
                    <?php echo downList($price,'name','name','price'); ?>
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
                        <th><?php echo $model->getAttributeLabel('stadium_name');?></th>
                        <th><?php echo $model->getAttributeLabel('place');?></th>
                        <th><?php echo $model->getAttributeLabel('place_type');?></th>
                        <th><?php echo $model->getAttributeLabel('policy_name');?></th>
                        <th><?php echo $model->getAttributeLabel('start_day');?></th>
                        <th><?php echo $model->getAttributeLabel('end_day');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1; ?>
<?php foreach($arclist as $v){ ?>
                    <tr id="hidden_<?php echo $v->id?>">
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php echo $v->stadium_name; ?></td>
                        <td><?php echo $v->place; ?></td>
                        <td><?php echo $v->place_type; ?></td>
                        <td><?php echo $v->policy_name; ?></td>
                        <td><?php echo $v->start_day; ?></td>
                        <td><?php echo $v->end_day; ?></td>
                        <td>
                    <a class="btn" href="<?php echo $this->createUrl('detail', array('id'=>$v->id));?>" title="详细设置">详细设置</a>
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