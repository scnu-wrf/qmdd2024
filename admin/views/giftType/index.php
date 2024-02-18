<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播 》直播设置 》<a class="nav-a">互动类型设置</a></h1>
        <span style="float:right;margin-right: 15px;"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end--> 
    <div class="box-content">
    	<div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create'),'添加'); ?>
            <?php echo show_command('批删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>是否使用：</span>
                    <?php echo downList($is_use,'f_id','F_NAME','is_use'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>互动方式：</span>
                    <?php echo downList($interact,'f_id','F_NAME','interact'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入编号 / 名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('interact_type');?></th>
                        <!-- <th><?php //echo $model->getAttributeLabel('code');?></th> -->
                        <th><?php echo $model->getAttributeLabel('name');?></th>
                        <th><?php echo $model->getAttributeLabel('is_use');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                  	<?php $index = 1; foreach($arclist as $v){?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php echo $v->interact_type_name; ?></td>
                        <!-- <td><?php //echo $v->code; ?></td> -->
                        <td><?php echo $v->name; ?></td>
                        <td><?php if(!empty($v->is_use)) echo $v->base_is_use->F_NAME; ?></td>
                        <td>
                            <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id))); ?>
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
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID')); ?>';
</script>
