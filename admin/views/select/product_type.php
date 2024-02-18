<?php
if(!isset($_REQUEST['order_type'])){
        $_REQUEST['order_type']=0;
    }
?>
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

            <table class="list product_list" id="classify_box">
                <thead>
                    <tr>
                        <th>点击选择</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>

                    <?php if(strlen($v->tn_code)==2 && $v->base_f_id==$_REQUEST['order_type']){?>
                    <tr class="list-open product_ul" id="product_<?php echo $v->id; ?>" data-id="<?php echo $v->id; ?>" data-name="<?php echo $v->sn_name; ?>" data-code="<?php echo $v->tn_code; ?>" data-class="1">
                        <td class="first">1级：<?php echo $v->sn_name; ?></td>
                    </tr>
                <?php } ?>
                        <?php if(strlen($v->tn_code)<=6 && strlen($v->tn_code)<>2){ ?>
                            <?php $class=0;
                             if(strlen($v->tn_code)==4){
                                $class=2;
                            } elseif(strlen($v->tn_code)==6) {
                                $class=3;
                            } ?>
                    <tr style="display:none;" class="list-open product_ul item_<?php echo $class; ?>" id="product_<?php echo $v->id; ?>" data-id="<?php echo $v->id; ?>" data-name="<?php echo $v->sn_name; ?>" data-code="<?php echo $v->tn_code; ?>" data-class="<?php echo $class; ?>">
                        <td class="first<?php echo $class; ?>"><?php echo $class; ?>级：<?php echo $v->sn_name; ?></td>
                    </tr>
                <?php } elseif (strlen($v->tn_code)==8) { ?>

                    <tr style="display:none;" class="item item_4" data-id="<?php echo $v->id; ?>" data-name="<?php echo $v->sn_name; ?>" data-code="<?php echo $v->tn_code; ?>" data-class="4">
                        <td>4级：<?php echo $v->sn_name; ?></td>
                    </tr>
                <?php } ?>
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
    api.button(
        {
            name: '取消'
        }
    );
    var $product_ul=$('.product_ul');
    var $item=$('.item');
    $product_ul.on('click', function(){
        var $this=$(this);
        var this_code=$this.attr('data-code');
        var this_class=parseInt($this.attr('data-class'))+1;
        var this_class2=parseInt($this.attr('data-class'))+2;
        var this_class3=parseInt($this.attr('data-class'))+3;
        var is_open;
        
        $('#classify_box').find('.item_'+this_class).each(function(){
            var sd_code=$(this).attr('data-code');
            var fl=sd_code.indexOf(this_code);
            if(fl==0){
                $(this).hide();
            }
        });
        $('#classify_box').find('.item_'+this_class2).each(function(){
            var sd_code=$(this).attr('data-code');
            var fl=sd_code.indexOf(this_code);
            if(fl==0){
                $(this).hide();
            }
        });
        $('#classify_box').find('.item_'+this_class3).each(function(){
            var sd_code=$(this).attr('data-code');
            var fl=sd_code.indexOf(this_code);
            if(fl==0){
                $(this).hide();
            }
        });
        
        //$('.item_'+this_class).hide();
        //$item.hide();
        if($this.hasClass('list-open')){
            $(this).removeClass('list-close').addClass('list-open');
            $this.removeClass('list-open').addClass('list-close');
            //$('.item_'+this_class).show();
            $('#classify_box').find('.item_'+this_class).each(function(){
            var sd_code=$(this).attr('data-code');
            var fl=sd_code.indexOf(this_code);
            if(fl==0){
                $(this).show();
            }
        });
        }else{
            $this.removeClass('list-close').addClass('list-open');
        }
    });
    $('.box-table tr.item').on('click', function(){
        var id=$(this).attr('data-id');
        var code=$(this).attr('data-code');
        var name=$(this).attr('data-name');
        $.dialog.data('classify_id', id);
        $.dialog.data('classify_code', code);
        $.dialog.data('classify_title', name);
        $.dialog.close();
    });
});
</script>