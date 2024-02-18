<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
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
                    <tr class="list-open product_ul" id="product_<?php echo $v->id; ?>" data-id="<?php echo $v->id; ?>" data-name="<?php echo $v->chinese_name; ?>" data-code="<?php echo $v->country_code_three; ?>">
                        <td class="first"><?php echo $v->chinese_name; ?></td>
                    </tr>
                    <?php if(!empty($v->country_code_three)) $province=TRegion::model()->findAll('country_code ="'.$v->country_code_three.'" AND level=1'); 
					  if (isset($province)) if (is_array($province)) foreach($province as $v2){ 
					?>
                    <tr style="display:none;" class="item item_<?php echo $v->id; ?>" data-id="<?php echo $v2->id; ?>" data-name="<?php echo $v2->region_name_c; ?>" data-code="<?php echo $v2->country_code; ?>">
                        <td><?php echo $v2->region_name_c; ?></td>
                    </tr>
                    <!--<php if(!empty($v->country_code_three)) $city=TRegion::model()->findAll('country_code ="'.$v->country_code_three.'" AND level=3'); 
					  if (isset($city)) if (is_array($city)) foreach($city as $v3){ 
					?>
                    <tr style="display:none;" class="item item_<php echo $v->id; ?>" data-id="<php echo $v3->id; ?>" data-name="<php echo $v3->region_name_c; ?>" data-code="<php echo $v3->country_code; ?>">
                        <td><php echo $v3->region_name_c; ?></td>
                    </tr>
                    <php }?>-->
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
        }else{
            $this.removeClass('list-close').addClass('list-open');
        }
    });
    $('.box-table tr.item').on('click', function(){
		var id=$(this).attr('data-id');
		var code=$(this).attr('data-code');
        var title=$(this).attr('data-name');
        $.dialog.data('area_id', id);
		$.dialog.data('area_code', code);
        $.dialog.data('area_title', title);
        $.dialog.close();
    });
});
</script>