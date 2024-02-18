<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="club" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入商品编号或商品名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th>商品编号</th>
                        <th>商品名称</th>
                        <th>型号/规格</th>
                        <th>商品分类</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $num=1; foreach($arclist as $v){ ?>
                        <tr data-id="<?php echo $v->id;?>" data-name="<?php echo $v->name;?>" data-code="<?php echo $v->product_code;?>" data-pic="<?php echo $v->product_ICO;?>" data-attr="<?php echo $v->json_attr;?>">
                            <td><?php echo $num; ?></td>
                            <td><?php echo $v->product_code; ?></td>
                            <td><?php echo $v->name; ?></td>
                            <td><?php echo $v->json_attr; ?></td>
                            <td>
                            <?php if(!empty($v->type)){ 
                                $ptype=explode(',', $v->type);
                                if(!empty($ptype)) foreach($ptype as $t){
                                    $types = MallProductsTypeSname::model()->find('tn_code="'.$t.'"');
                                    if(!empty($types)) echo $types->sn_name.' ';   
                            }} ?>
                            </td>
                        </tr>
                    <?php $num++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var arclist=<?php echo json_encode(toArray($arclist,'id,product_code,name,json_attr'));?>
</script>
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
        $.dialog.data('product_id', $this.attr('data-id'));
        $.dialog.data('product_name', $this.attr('data-name'));
        $.dialog.data('product_code', $this.attr('data-code'));
        $.dialog.data('product_pic', $this.attr('data-pic'));
		$.dialog.data('product_attr', $this.attr('data-attr'));
        $.each(arclist,function(e,q){
            if($this.attr('data-id')==q.id){
                $.dialog.data('data', JSON.stringify(q));
            }
        })
        $.dialog.close();
    });
});
</script>