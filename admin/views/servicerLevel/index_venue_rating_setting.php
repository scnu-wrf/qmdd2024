<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约 》场馆管理 》场馆等级设置</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div> <!--box-title end-->
    <div class="box-content"> 
        <div class="box-header"> 
            <?php
                $y = show_command('添加',$this->createUrl('create_venue_rating_setting'));
                if(!empty($y)){
                    echo '<a class="btn" href="javascript:;" onclick="clickPopup(0);"><i class="fa fa-plus"></i>添加</a>';
                }
            ?>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div>
        <!--box-header end--> 
        <div class="box-table">
            <table class="list" style="text-align:left;">
                <thead>
                <tr>
                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                    <th>序号</th>
                    <th><?php echo $model->getAttributeLabel('card_name');?></th>
                    <th><?php echo $model->getAttributeLabel('card_level_logo');?></th>
                    <th><?php echo $model->getAttributeLabel('card_score');?></th>
                    <th><?php echo $model->getAttributeLabel('card_end_score');?></th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>   
                    <?php $path = BasePath::model()->getPath(303); $index = 1;foreach($arclist as $v){?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->card_name;?></td>
                            <td>
                                <div class="f1">
                                    <a href="<?php echo $path->F_WWWPATH.$v->card_level_logo; ?>">
                                        <img src="<?php echo $path->F_WWWPATH.$v->card_level_logo; ?>" width="50px;" alt="">
                                    </a>
                                </div>
                            </td>
                            <td><?php echo $v->card_score;?></td>
                            <td><?php echo $v->card_end_score;?></td>
                            <td>
                                <?php
                                    $y = show_command('修改',$this->createUrl('update_venue_rating_setting', array('id'=>$v->id)));
                                    if(!empty($y)){
                                        echo '<a class="btn" href="javascript:;" onclick="clickPopup('.$v->id.');" title="编辑"><i class="fa fa-edit"></i></a>';
                                    }
                                ?>
                                <?php echo show_command('删除','\''.$v->id.'\''); ?>
                            </td>
                        </tr>
                    <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end--> 
</div><!--box end--> 
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

    function clickPopup(id,n){
        var url = id>0 ? '<?php echo $this->createurl('update_venue_rating_setting'); ?>&id='+id : '<?php echo $this->createurl('create_venue_rating_setting'); ?>';
        var title = id>0 ? '等级设置' : '添加等级';
        $.dialog.data('id', 0);
        $.dialog.open(url,{
            id:'popup',
            lock:true,
            opacity:0.3,
            title:title,
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('id')>0){
                    we.reload();
                }
            }
        });
        return false;
    }
</script>