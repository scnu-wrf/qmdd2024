<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约》补贴券管理》补贴券登记》<a class="nav-a">查看场地</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
        <span class="back"><a class="btn" href="<?php echo $this->createUrl('testSubsidy/StaIndex');?>"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="staCode" value="<?php echo Yii::app()->request->getParam('staCode');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" placeholder="编号 / 名称" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="text-align: center;">序号</th>
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
                    <tr>
                        <td style="text-align: center;"><?php echo $index; ?></td>
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
                    <a class="btn" href="<?php echo $this->createUrl('testSubsidy/index',array('venCode'=>$v->code,'staCode'=>$staCode)); ?>" title="编辑">补贴券登记</a>
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
    var deleteUrl = '<?php echo $this->createUrl('testSubsidy/Delete', array('id'=>'ID'));?>';
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