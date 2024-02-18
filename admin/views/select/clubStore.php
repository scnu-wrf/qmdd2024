<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="type_code" value="<?php echo Yii::app()->request->getParam('type_code');?>">
                <input type="hidden" name="project_id" value="<?php echo Yii::app()->request->getParam('project_id');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list product_list">
                <thead>
                    <tr>
                        <th>点击选择</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
                    <tr class="list-open product_ul" id="product_<?php echo $v->id; ?>" data-id="<?php echo $v->id; ?>" data-name="<?php echo $v->title; ?>" data-code="<?php echo $v->service_code; ?>">
                        <td class="first">
                            <?php echo $v->project_name ;?>-<?php echo $v->type_name ;?>-<?php echo $v->title; ?>
                        </td>
                    </tr>
                    <?php if(isset($v->club_service_detailed) && !empty($v->club_service_detailed)){?>
                    <?php foreach($v->club_service_detailed as $v2){?>
                    <tr style="display:none;" class="item item_<?php echo $v->id; ?>" 
                        data-id="<?php echo $v2->id; ?>" data-name="<?php echo $v->title; ?>" 
                        data-code="<?php echo $v->service_code; ?>" 
                        data-date="<?php echo $v2->service_date; ?> <?php echo $v2->service_datatime_start;?>-<?php echo $v2->service_datatime_end;?>" 
                        data-club="<?php echo $v->club_name; ?>" data-project="<?php echo $v->project_name; ?>" 
                        data-update="<?php echo $v2->service_date; ?> <?php echo $v2->service_datatime_start;?>" 
                        data-state="<?php echo $v->about_state_name; ?>">
                        <td><?php echo $v2->service_date; ?> <?php echo $v2->service_datatime_start;?>-<?php echo $v2->service_datatime_end;?></td>
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
    api = $.dialog.open.api;	// 			art.dialog.open扩展方法
    if (!api) return;

    // 操作对话框
    api.button(
        {
            name: '取消'
        }
    );
    var $product_ul=$('.product_ul');
    var $item=$('.item');
    $product_ul.on('click', function(){
        var $this=$(this);
        var this_id=$this.attr('data-id');
        var is_open;
        $item.hide();
        if($this.hasClass('list-open')){
            $product_ul.removeClass('list-close').addClass('list-open');
            $this.removeClass('list-open').addClass('list-close');
            $('.item_'+this_id).show();
        }
        else{
            $this.removeClass('list-close').addClass('list-open');
        }
    });
    $('.box-table tr.item').on('click', function(){
        var id=$(this).attr('data-id');
        var code=$(this).attr('data-code');
        var name=$(this).attr('data-name');
		var date=$(this).attr('data-date');
		var update=$(this).attr('data-update');
		var state=$(this).attr('data-state');
		var club=$(this).attr('data-club');
		var project=$(this).attr('data-project');
		var order_num=$(this).attr('data-order-num');
        $.dialog.data('datailed_id', id);
        $.dialog.data('club_code', code);
        $.dialog.data('club_title', name);
		$.dialog.data('club_date', date);
		$.dialog.data('club_update', update);
		$.dialog.data('club_state', state);
		$.dialog.data('club_id', club);
		$.dialog.data('club_project', project);
		$.dialog.data('club_order_num', order_num);

        $.dialog.close();
    });
});
</script>