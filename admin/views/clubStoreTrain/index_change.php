
<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动》培训发布》发布培训</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <?php echo show_command('添加','javascript:;','添加更改','onclick="add_change()"'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>日期：</span>
                    <input style="width:100px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                    <span>-</span>
                    <input style="width:100px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入编号/标题" >
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
                        <th><?php echo $model->getAttributeLabel('code');?></th>
                        <th><?php echo $model->getAttributeLabel('title');?></th>
                        <th><?php echo $model->getAttributeLabel('type_id');?></th>
                        <th><?php echo $model->getAttributeLabel('change_time');?></th>
                        <th><?php echo $model->getAttributeLabel('change_adminid');?></th>
                        <th>操作单位</th>
                        <th>操作</th>
                    </tr>
                </thead>
<?php 
    $index = 1;foreach($arclist as $v){
?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->code; ?></td>
                        <td><?php echo $v->title; ?></td>
                        <td><?php echo $v->type_name; ?></td>
                        <td><?php echo $v->change_time; ?></td>
                        <td><?php if(!is_null($v->admin))echo $v->admin->club_code.'/'.$v->change_adminname; ?></td>
                        <td><?php if(!is_null($v->admin))echo $v->admin->club_name; ?></td>
                        <td>
                            <?php echo show_command('详情',$this->createUrl('update_1', array('id'=>$v->id))); ?>
                        </td>
                    </tr>
<?php $index++; } ?>
            </table>
        </div><!--box-table end-->
        
        <div class="box-page c"><?php $this->page($pages);?></div>
        
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

    // 添加更改
    var add_change=function(){
        $.dialog.data('id', 0);
        $.dialog.open('<?php echo $this->createUrl("exchange");?>',{
            id:'genggai',
            lock:true,
            opacity:0.3,
            title:'选择培训',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('id')>0){
                    window.location.href="<?php echo $this->createUrl('update'); ?>&id="+$.dialog.data('id')+"&genggai=true";
                }
            }
        });
        return false;
    };
</script>
