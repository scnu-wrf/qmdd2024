<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="certificate" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list product_list">
                <thead>
                    <tr>
                        <th colspan="2">点击选择</th>
                    </tr>
                </thead>
                <tbody>
<?php if (is_array($arclist)) foreach($arclist as $v){ ?>
                    <tr data-id="<?php echo $v->id; ?>" data-code="<?php echo $v->f_code; ?>" data-title="<?php echo $v->f_name; ?>" >
                        <td class="first"><?php echo $v->f_name; ?></td>
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
    var parentt = $.dialog.parent;				// 父页面window对象
    api = $.dialog.open.api;	// 			art.dialog.open扩展方法
    if (!api) return;

    // 操作对话框
    api.button(
        {
            name: '取消'
        }
    );
    // $(".manage").on('click',function(){
    //     var $this=$(this);
    //     if(!$this.hasClass('list-open')&&!$this.hasClass('list-close')){
    //         $.dialog.data('f_id',$(this).attr('data-id'));
    //         $.dialog.data('F_TCODE',$(this).attr('data-code'));
    //         $.dialog.data('F_NAME',$(this).attr('data-title'));
    //         $.dialog.close();
    //         return false;
    //     }
    //     if($this.hasClass('list-open')){
    //         $this.removeClass('list-open').addClass('list-close');
    //         $(".manage[fater_id='"+$this.attr('data-id')+"']").css("display","table-row");
    //     }else{
    //         $this.removeClass('list-close').addClass('list-open');
    //         $(".manage[fater_id='"+$this.attr('data-id')+"']").css("display","none");
    //         getChild($this.attr("data-id"))
    //     }
    // })

    $('.box-table tbody tr').on('click', function(){
        $.dialog.data('id',$(this).attr('data-id'));
		$.dialog.data('f_code',$(this).attr('data-code'));
        $.dialog.data('f_name',$(this).attr('data-title'));
        $.dialog.close();
    });
});
</script>