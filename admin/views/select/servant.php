<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="club_id" value="<?php echo $_GET["club_id"];?>">
                <input type="hidden" name="project_id" value="<?php echo $_GET["project_id"];?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="keywords" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th colspan="4">点击选择</th>
                    </tr>
                    <tr>
                        <td style="text-align:center;">服务类别</td>
                        <td style="text-align:center;">服务编号</td>
                        <td style="text-align:center;">服务者姓名</td>
                        <td style="text-align:center;">服务者等级</td>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
                    <tr data-id="<?php echo $v->id;?>" data-person_id="<?php echo $v->person_id;?>" data-name="<?php echo $v->qualification_name; ?>" data-code="<?php echo $v->qcode; ?>" data-type="<?php echo $v->qualification_type; ?>" data-level="<?php echo $v->qualification_level_name; ?>">
                        <td width="20%"><?php echo $v->qualification_type; ?></td>
                        <td width="30%"><?php echo $v->qcode; ?></td>
                        <td width="20%"><?php echo $v->qualification_name; ?></td>
                        <td width="20%"><?php echo $v->qualification_level_name; ?></td>
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
    api.button(
        {
            name: '取消'
        }
    );
    $('.box-table tbody tr').on('click', function(){
        var $this=$(this);
        $.dialog.data('servant_id', $this.attr('data-id'));
        $.dialog.data('servant_name', $this.attr('data-name'));
        $.dialog.data('servant_code', $this.attr('data-code'));
        $.dialog.data('person_id', $this.attr('data-person_id'));
		$.dialog.data('servant_level', $this.attr('data-level'));
		$.dialog.data('servant_type', $this.attr('data-type'));
        $.dialog.close();
    });
});
</script>