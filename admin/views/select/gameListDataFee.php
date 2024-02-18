<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="game_id" value="<?php echo Yii::app()->request->getParam('game_id');?>">
                <!-- <label style="margin-right:10px;">
                    <span>选择赛事：</span>
                    <?php //echo downList($game_list_id,'id','game_title','game_list_id'); ?>
                </label><br> -->
                <label style="margin-right:10px;">
                    <span>选择赛事：</span>
                    <input style="width:200px;" type="text" class="input-text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="请输入竞赛项目名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>点击选择</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($arclist as $v){ ?>
                        <tr data-id="<?php echo $v->id; ?>" data-title="<?php echo $v->game_data_name; ?>">
                            <td><?php echo $v->game_data_name; ?></td>
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
        api = $.dialog.open.api;    //          art.dialog.open扩展方法
        if (!api) return;

        // 操作对话框
        api.button( { name: '取消' } );
        $('.box-table tbody tr').on('click', function(){
            $.dialog.data('id', $(this).attr('data-id'));
            $.dialog.data('game_data_name', $(this).attr('data-title'));
            $.dialog.close();
        });
    });
</script>