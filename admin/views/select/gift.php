<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <select id="base_id" name="base_id">
                    <option value="351"<?php if($base_id==351){?> selected<?php }?>>赛事活动</option>
                    <option value="352"<?php if($base_id==352){?> selected<?php }?>>培训服务</option>
                    <option value="353"<?php if($base_id==353){?> selected<?php }?>>动动约服务</option>
                    <option value="354"<?php if($base_id==354){?> selected<?php }?>>活动报名</option>
                    <option value="361"<?php if($base_id==361){?> selected<?php }?>>实物商品</option>
                    <option value="363"<?php if($base_id==363){?> selected<?php }?>>数字商品</option>
                    <option value="364"<?php if($base_id==364){?> selected<?php }?>>虚拟商品</option>
                    <option value="365"<?php if($base_id==365){?> selected<?php }?>>视频点播</option>
                    <option value="366"<?php if($base_id==366){?> selected<?php }?>>视频直播</option>
                </select>
                <input type="hidden" name="club_id" value="<?php echo Yii::app()->request->getParam('club_id');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="club" style="width:150px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
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
                        <tr data-id="<?php echo $v->id; ?>" data-title="<?php echo $v->game_title; ?>" data-ico="<?php if($v->select_item1!=''){ echo $wwwpath; } ?><?php echo $v->select_item1; ?>" data-json-attr="<?php echo $v->select_item2; ?>">
                            <td><?php echo $v->game_title; ?> <?php echo $v->select_item2; ?></td>
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
    api = $.dialog.open.api;
    if (!api) return;

    // 操作对话框
    api.button(
        {
            name: '取消'
        }
    );
    $('.box-table tbody tr').on('click', function(){
        $.dialog.data('gift_type', '<?php echo $base_id;?>');
        $.dialog.data('gift_id', $(this).attr('data-id'));
        $.dialog.data('gift_name', $(this).attr('data-title'));
        $.dialog.data('gift_ico', $(this).attr('data-ico'));
        $.dialog.data('gift_json_attr', $(this).attr('data-json-attr'));
        $.dialog.close();
    });

    $('#base_id').on('change', function(){
        $('form').submit();
    });
});
</script>