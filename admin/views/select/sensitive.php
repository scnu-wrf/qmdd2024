<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo $this->createUrl('addSensitiveType');?>" method="post">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                    请输入类型名称: <input id="addtype-name" name="addtype-name" class="input-text" type="text">
                <button class="btn btn-blue" type="submit">提交</button>
            </form>
        </div>

        <div class="box-table">
            <table class="list">
                <thead><tr><th>敏感词类型</th></tr></thead>
                <tbody>
                    <?php foreach($arclist as $v){ ?>
                        <tr data-id="<?php echo $v->f_id; ?>" data-name="<?php echo $v->F_NAME; ?>" >
                            <td><?php echo $v->F_NAME; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div> 
    </div><!--box-content end-->
</div><!--box end-->

<script>




    $(function(){
        api = $.dialog.open.api;	// 			art.dialog.open扩展方法
        if (!api) return;

        // 操作对话框
        api.button( { name: '取消' } );
        $('.box-table tbody tr').on('click', function(){
        //    var id=$(this).attr('data-id');
        //    var title=$(this).attr('data-title');
            $.dialog.data('f_id', $(this).attr('data-id'));
            $.dialog.data('F_NAME', $(this).attr('data-name'));
            $.dialog.close();
        });
    });
    
</script>