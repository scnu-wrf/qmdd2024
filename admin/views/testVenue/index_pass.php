<div class="box">
    <div class="box-title c">
        <h1>当前界面：社区单位》场地管理》<a class="nav-a">场地列表</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
<!--                     <span>操作日期：</span>
                    <input style="width:120px;" class="input-text" placeholder="开始日期" type="text" id="startdate" name="startdate" value="<?php echo Yii::app()->request->getParam('startdate');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" placeholder="结束日期" type="text" id="enddate" name="enddate" value="<?php echo Yii::app()->request->getParam('enddate');?>"> -->
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" placeholder="编号 / 名称" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
                <?php echo show_command('批删除','','删除'); ?>  
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th><?php echo $model->getAttributeLabel('comCode');?></th>
                        <th><?php echo $model->getAttributeLabel('comName');?></th>
                        <th><?php echo $model->getAttributeLabel('staCode');?></th>
                        <th><?php echo $model->getAttributeLabel('staName');?></th>
                        <th><?php echo $model->getAttributeLabel('code');?></th>
                        <th><?php echo $model->getAttributeLabel('name');?></th>
                        <th><?php echo $model->getAttributeLabel('project');?></th>
                        <th><?php echo $model->getAttributeLabel('serType');?></th>
                        <th><?php echo $model->getAttributeLabel('capacity');?></th>
                        <th><?php echo $model->getAttributeLabel('group');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1; ?>
<?php foreach($arclist as $v){ ?>
                    <tr id="hidden_<?php echo $v->id?>">
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php echo $v->comCode; ?></td>
                        <td><?php echo $v->comName; ?></td>
                        <td><?php echo $v->staCode; ?></td>
                        <td><?php echo $v->staName; ?></td>
                        <td><?php echo $v->code; ?></td>
                        <td><?php echo $v->name; ?></td>
                        <td><?php echo $v->project; ?></td>
                        <td><?php echo $v->serType; ?></td>
                        <td><?php echo $v->capacity; ?></td>
                        <td><?php echo $v->group; ?></td>
                        <td>
                <a class="btn" href="<?php echo $this->createUrl('Passdetail', array('id'=>$v->id));?>" title="详情">详情</a>
                    <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id,'index'=>'index_pass'));?>" title="编辑">编辑</a>
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
<script>
    $("#startdate").click(function(){
    WdatePicker({
        startDate:'%Y-%M-%D',
        dateFmt:'yyyy-MM-dd'
    }); 
});

    $("#enddate").click(function(){
    WdatePicker({
        startDate:'%Y-%M-%D',
        dateFmt:'yyyy-MM-dd'
    }); 
});
</script>