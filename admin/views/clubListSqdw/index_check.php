<div class="box">
    <div class="box-title c">
        <h1>当前界面：社区单位》社区管理》<a class="nav-a">社区审核</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" placeholder="场馆编号 / 场馆名称" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
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
                        <th><?php echo $model->getAttributeLabel('club_code');?></th>
                        <th><?php echo $model->getAttributeLabel('club_name');?></th>
                        <th><?php echo $model->getAttributeLabel('club_address');?></th>
                        <th><?php echo $model->getAttributeLabel('contact_phone');?></th>
                        <th><?php echo $model->getAttributeLabel('email');?></th>
                        <th><?php echo $model->getAttributeLabel('club_logo_pic');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1; ?>
<?php foreach($arclist as $v){ ?>
                    <tr id="hidden_<?php echo $v->id?>">
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php echo $v->club_code; ?></td>
                        <td><?php echo $v->club_name; ?></td>
                        <td><?php echo $v->club_address; ?></td>
                        <td><?php echo $v->contact_phone; ?></td>
                        <td><?php echo $v->email; ?></td>
                        <td>
                        <?php if(!empty($v->club_logo_pic)){?>
                            <img src="<?php echo $v->club_logo_pic;?>" width="100" height="80">
                        <?php } else{?>
                            暂未上传图片
                        <?php }?>
                        </td>
                        <td>
                    <a class="btn" href="<?php echo $this->createUrl('Updatecheck', array('id'=>$v->id));?>" title="审核">审核</a>
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