<?php if (!isset($_GET["club_id"])) {
    $_GET["club_id"]=0;
}
?>
<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="club_id" value="<?php echo $_GET["club_id"];?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="club" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox" value="全选"><span style="display:none;"><a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="add_chose();">添加</a></span></th>
                        <th style="text-align:center;">商品编号</th>
                        <th style="text-align:center;">商品货号</th>
                        <th style="text-align:center;">商品名称</th>
                        <th style="text-align:center;">型号/规格</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
                    <tr id="line<?php echo $v->id; ?>" data-id="<?php echo $v->id;?>" 
                        data-name="<?php echo $v->name;?>" 
                        data-code="<?php echo $v->supplier_code;?>"
                        data-pcode="<?php echo $v->product_code;?>"
                        data-pic="<?php echo $v->product_ICO;?>" 
                        data-attr="<?php echo $v->json_attr;?>" 
                        data-price="<?php echo $v->price;?>">
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td width="15%"><?php echo $v->product_code; ?></td>
                        <td width="15%"><?php echo $v->supplier_code; ?></td>
                        <td width="40%"><?php echo $v->name; ?></td>
                        <td width="20%"><?php echo $v->json_attr; ?></td>
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
        var parentt = $.dialog.parent;  // 父页面window对象
        api = $.dialog.open.api;    // art.dialog.open扩展方法
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
        $.dialog.data('products', boxnum);
        $.dialog.close();
    };
/*$(function(){
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
});*/
</script>