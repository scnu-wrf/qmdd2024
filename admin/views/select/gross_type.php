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
<?php 
foreach($arclist as $v){ 
    $ct_mark=strlen($v->tn_code)/2;
    $cr='left(tn_code,'.strlen($v->tn_code).')="'.$v->tn_code.'" and length(tn_code)>'.strlen($v->tn_code);
    $count=MallProductsTypeSname::model()->count($cr);
?>
                    <?php if(strlen($v->tn_code)==2){?>
                        <tr class="manage <?php echo $count>0?'list-open ':'';?>" ct_mark="<?php echo $ct_mark; ?>" data-id="<?php echo $v->id; ?>" data-code="<?php echo $v->tn_code; ?>" data-title="<?php echo $v->sn_name; ?>" >
                            <td class="first"><?php echo $v->sn_name; ?></td>
                        </tr>
                    <?php }else{?>
                        <tr style="display:none;" class="manage <?php echo $count>0?'list-open ':'';?>" ct_mark="<?php echo $ct_mark; ?>" data-id="<?php echo $v->id; ?>" data-code="<?php echo $v->tn_code; ?>" data-title="<?php echo $v->sn_name; ?>" >
                            <td class="first" style="padding-left:<?php echo $ct_mark*20;?>px;background-position-x: <?php echo $ct_mark*10;?>px;"><?php echo $v->sn_name; ?></td>
                        </tr>
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
    var id_str='',title='';
    $(".manage").on('click',function(){
        var $this=$(this);
        var code=$this.attr("data-code");
        if(!$this.hasClass('list-open')&&!$this.hasClass('list-close')){
            var prev_code=code.substring(0,code.length-2);
            var id=$this.attr('data-id');
            title=$this.attr("data-title");
            id_str=$this.attr("data-id");
            getSelectChild(prev_code);
            $.dialog.data('classify_id', id);
            $.dialog.data('classify_str', id_str);
            $.dialog.data('classify_code', code);
            $.dialog.data('classify_title', title);
            $.dialog.close();
            return false;
        }
        if($this.hasClass('list-open')){
            $this.removeClass('list-open').addClass('list-close');
            $(".manage").each(function(){
                var next_code=$(this).attr("data-code");
                if(next_code.substring(0,code.length)==code&&next_code.length==code.length+2){
                    $(this).css("display","table-row");
                }
            })
        }else{
            $this.removeClass('list-close').addClass('list-open');
            $(".manage").each(function(){
                var next_code=$(this).attr("data-code");
                if(next_code.substring(0,code.length)==code&&next_code.length>code.length){
                    $(this).css("display","none")
                    if($(this).hasClass('list-open')||$(this).hasClass('list-close')){
                        $(this).removeClass('list-close').addClass('list-open');
                    }
                }
            })
        }
    })
    function getSelectChild(info_code){
        if(info_code){
            var th=$(".manage[data-code='"+info_code+"']");
            id_str=th.attr("data-id")+','+id_str;
            title=th.attr("data-title")+'-'+title;
            prev_code=th.attr("data-code").substring(0,th.attr("data-code").length-2);
            if(prev_code!=''){
                getSelectChild(prev_code);
            }
        }
        /*
        * 遍历数据，查找info_code的所有父级元素并添加
        */
    }

});
</script>