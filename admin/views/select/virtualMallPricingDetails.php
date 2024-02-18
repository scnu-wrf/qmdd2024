<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="keywords" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入编码/商品名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check" style="width: 2%;">
                            <input id="j-checkall" class="input-check" type="checkbox" value="全选">
                            <span style="display:none;">
                                <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="add_chose();">添加</a>
                            </span>
                        </th>
                        <th>商品编码</th>
                        <th>商品名称</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($arclist as $v){ ?>
                        <tr id="line<?php echo $v->id; ?>" 
                            data-id="<?php echo $v->id;?>" 
                            data-name="<?php echo $v->product_name; ?>" 
                            data-code="<?php echo $v->product_code; ?>"
                            data-productid="<?php echo $v->product_id; ?>">
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td width="20%"><?php echo $v->product_code; ?></td>
                            <td width="30%"><?php echo $v->product_name; ?></td>
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
        $('.box-table tbody tr').on('click', function(){
            var $this=$(this);
            if($this.hasClass('selected')){
                $this.find('input').prop("checked", false);
                $this.removeClass('selected');
            } else {
                $this.find('input').prop("checked", true);
                $this.addClass('selected');
            }
        });

        api = $.dialog.open.api;	// 			art.dialog.open扩展方法
        if (!api) return;

        // 操作对话框
        api.button(
            {
                name:'确定',
                callback:function(){
                    return add_chose();
                },
                focus:true
            },
            {
                name:'取消',
                callback:function(){
                    return true;
                }
            }
        );
    });

    function add_chose(){
        var boxnum = $('table.list ').find('.selected');
        $.dialog.data('id', -1);
        $.dialog.data('mall_name', boxnum);
        $.dialog.close();
    };
</script>