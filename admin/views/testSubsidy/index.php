<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约》补贴券管理》<a class="nav-a">补贴券登记</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
        <span class="back"><a class="btn" href="<?php echo $this->createUrl('testSubsidy/VenIndex',array('staCode'=>$staCode));?>"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="venCode" value="<?php echo Yii::app()->request->getParam('venCode');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" placeholder="编号 / 名称" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
                <?php echo show_command('添加',$this->createUrl('create'),'添加'); ?>
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
                        <th><?php echo $model->getAttributeLabel('venCode');?></th>
                        <th><?php echo $model->getAttributeLabel('venName');?></th>
                        <th><?php echo $model->getAttributeLabel('code');?></th>
                        <th><?php echo $model->getAttributeLabel('name');?></th>
                        <th><?php echo $model->getAttributeLabel('price');?></th>
                        <th><?php echo $model->getAttributeLabel('listTime');?></th>
                        <th><?php echo $model->getAttributeLabel('delistTime');?></th>
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
                        <td><?php echo $v->venCode; ?></td>
                        <td><?php echo $v->venName; ?></td>
                        <td><?php echo $v->code; ?></td>
                        <td><?php echo $v->name; ?></td>
                        <td><?php echo $v->price; ?></td>
                        <td><?php echo $v->listTime; ?></td>
                        <td><?php echo $v->delistTime; ?></td>
                        <td>
                    <a class="btn" onclick="tijiao('<?php echo $v->id?>')" title="提交">提交</a>
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
    var deleteUrl = '<?php echo $this->createUrl('testSubsidy/Delete', array('id'=>'ID'));?>';
</script>
<script>
    function tijiao(modelid) {
        $.ajax({
            type: 'get',
            url: "<?php echo $this->createUrl('testSubsidy/Tijiao');?>",
            data: {
                modelid:modelid
            },
            dataType: 'json',
            success: function(data){
                var s1 = document.getElementById("hidden_"+data.modelid);
                s1.style.display = 'none';
            }
        });
    }
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