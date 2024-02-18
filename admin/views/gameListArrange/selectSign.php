<div class="box">
    <div class="box-content">
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="width:5%;">序号</th>
                        <th><?php echo $model->getAttributeLabel('f_no'); ?></th>
                        <th><?php echo $model->getAttributeLabel('f_namea'); ?></th>
                        <th><?php echo $model->getAttributeLabel('f_nameb'); ?></th>
                        <th><?php echo $model->getAttributeLabel('f_time'); ?></th>
                        <th>选择</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td><?php echo $index; ?></td>
                            <td><?php echo $v->f_no; ?></td>
                            <td><?php echo $v->f_namea; ?></td>
                            <td><?php echo $v->f_nameb; ?></td>
                            <td><?php echo $v->f_time; ?></td>
                            <td>
                                <span style="display: inline-block;width: 50%;">
                                    <input type="radio" class="input-check" id="id_<?php echo $index; ?>" name="check_radio" value="<?php echo $v->id; ?>">
                                    <label for="id_<?php echo $index; ?>"><?php echo ($v->f_selected==0) ? '未选' : '已选择'; ?></label>
                                </span>
                                <?php if($v->f_selected>0) {?>
                                    <span>
                                        <a href="javascript:;" class="btn" onclick="clickRemove('<?php echo $v->id; ?>');">清除</a>
                                    </span>
                                <?php }?>
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
    $(function(){
        var parentt = $.dialog.parent;				// 父页面window对象
        api = $.dialog.open.api;	// 			art.dialog.open扩展方法
        if (!api) return;

        // 操作对话框
        api.button(
            {
                name:'确定',
                callback:function(){
                    var radio = $('input:radio:checked').val();
                    return add_chose(radio);
                },
                focus:true
            },
            {
                name:'取消',
                callback:function(){
                    $.dialog.data('tid',0);
                    return true;
                }
            }
        );
    });

    function add_chose(radio=0){
        $.dialog.data('tid', radio);
        $.dialog.close();
    };

    function clickRemove(id){
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('removeSelectSign'); ?>&id='+id,
            dataType: 'json',
            success: function(data){
                if(data==1){
                    we.reload();
                }
            },
            error: function(requeset){
                console.log('错误');
            }
        })
    }
</script>