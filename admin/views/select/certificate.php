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
                    <?php $count=BaseCode::model()->count('fater_id='.$v->select_id);?>
                        <tr class="manage <?=$count>0?'list-open':''?>" data-id="<?php echo $v->select_id; ?>" data-title="<?php echo $v->select_title; ?>" >
                            <td class="first"><?php echo $v->select_title; ?></td>
                        </tr>
                    <?php if($count>0){?>
                    <?php $type=BaseCode::model()->findAll('fater_id='.$v->select_id); foreach($type as $v2){ ?>
                            <tr style="display:none;" class="manage" data-id="<?php echo $v2->f_id; ?>" data-title="<?php echo $v2->F_NAME; ?>" fater_id="<?php echo $v2->fater_id; ?>">
                                <td class="first" style="padding-left:30px;background-position-x: 10px;"><?php echo $v2->F_NAME; ?></td>
                            </tr>
                        <?php }?>
                    <?php }?>

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
    $(".manage").on('click',function(){
        var $this=$(this);
        if(!$this.hasClass('list-open')&&!$this.hasClass('list-close')){
            $.dialog.data('f_id',$(this).attr('data-id'));
            $.dialog.data('F_TCODE',$(this).attr('data-code'));
            $.dialog.data('F_NAME',$(this).attr('data-title'));
            $.dialog.close();
            return false;
        }
        if($this.hasClass('list-open')){
            $this.removeClass('list-open').addClass('list-close');
            $(".manage[fater_id='"+$this.attr('data-id')+"']").css("display","table-row");
        }else{
            $this.removeClass('list-close').addClass('list-open');
            $(".manage[fater_id='"+$this.attr('data-id')+"']").css("display","none");
        }
    })

    // $('.box-table tbody tr').on('click', function(){
    //     $.dialog.data('f_id',$(this).attr('data-id'));
	// 	$.dialog.data('F_TCODE',$(this).attr('data-code'));
    //     $.dialog.data('F_NAME',$(this).attr('data-title'));
    //     $.dialog.close();
    // });
});
</script>