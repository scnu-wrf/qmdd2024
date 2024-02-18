<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="club_id" value="<?php echo Yii::app()->request->getParam('club_id');?>">
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
                    <?php if(empty($v->fater_id)){?>
                        <tr class="manage <?php foreach($ctMark as $v2){if($v2->fater_id==$v->id)echo 'list-open ';}?>" data-id="<?php echo $v->id; ?>" data-title="<?php echo $v->ct_name; ?>" >
                            <td class="first"><?php echo $v->ct_name; ?></td>
                        </tr>
                    <?php }else{?>
                        <tr style="display:none;" class="manage <?php foreach($ctMark as $v2){if($v2->fater_id==$v->id)echo 'list-open ';}?>" ct_mark="<?php echo $v->ct_mark; ?>" data-id="<?php echo $v->id; ?>" data-title="<?php echo $v->ct_name; ?>" fater_id="<?php echo $v->fater_id; ?>" >
                            <td class="first" style="padding-left:<?php echo $v->ct_mark*20;?>px;background-position-x: <?php echo $v->ct_mark*10;?>px;"><?php echo $v->ct_name; ?></td>
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
    var title='';
    $(".manage").on('click',function(){
        var $this=$(this);
        if(!$this.hasClass('list-open')&&!$this.hasClass('list-close')){
            var fater_id=$this.attr('fater_id');
            var id=$this.attr('data-id');
            title=$this.attr("data-title");
            getSelectChild(fater_id);
            console.log(fater_id)
            $.dialog.data('classify_id', id);
            $.dialog.data('classify_title', title);
            $.dialog.close();
            return false;
        }
        if($this.hasClass('list-open')){
            $this.removeClass('list-open').addClass('list-close');
            $(".manage[fater_id='"+$this.attr('data-id')+"']").css("display","table-row");
        }else{
            $this.removeClass('list-close').addClass('list-open');
            $(".manage[fater_id='"+$this.attr('data-id')+"']").css("display","none");
            getChild($this.attr("data-id"))
        }
    })
    function getSelectChild(info_id){
        if(info_id){
            var th=$(".manage[data-id='"+info_id+"']");
            title=th.attr("data-title")+'-'+title
            getSelectChild(th.attr("fater_id"));
        }
        /*
        * 遍历数据，查找info_id的所有父级元素并添加
        */
    }
    function getChild(info_id){
        $(".manage[fater_id='"+info_id+"']").each(function(){
            var th=$(this);
            if(th.attr("fater_id") == info_id){
                th.css("display","none");
                if(!th.hasClass('list-close')){
                    th.removeClass('list-close');
                }else{
                    th.removeClass('list-close').addClass('list-open');
                }
                getChild(th.attr("data-id"));
            }
        })
        /*
        * 遍历数据，查找info_id的所有下级元素并隐藏元素
        */
    }

});
</script>