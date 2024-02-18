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
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th>收费项目编号</th>
                        <th>收费项目名称</th>
                        <th>绑定商品编号</th>
                    </tr>
                </thead>
                <tbody>
                <?php $num=1; foreach($arclist as $v){ ?>
                    <tr data-id="<?php echo $v->id; ?>" data-code="<?php echo $v->code; ?>" data-title="<?php echo $v->name; ?>">
                        <td><?php echo $num; ?></td>
                        <td><?php echo $v->code; ?></td>
                        <td><?php echo $v->name; ?></td>
                        <td><?php echo $v->product_code; ?></td>
                    </tr>
                <?php $num++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var arclist=<?php echo json_encode(toArray($arclist,'id,code,name,product_id,product_code,product_name'));?>
</script>
<script>
    $(function(){
        api = $.dialog.open.api;	// 			art.dialog.open扩展方法
        if (!api) return;

        // 操作对话框
        api.button(
            {
                name:'取消',
                callback:function(){
                    return true;
                }
            }
        );
        $('.box-table tbody tr').on('click', function(){
            var th=$(this);
            $.dialog.data('id', th.attr('data-id'));
            $.dialog.data('code', th.attr('data-code'));
            $.dialog.data('name', th.attr('data-title'));
            $.each(arclist,function(e,q){
                if(th.attr('data-id')==q.id){
                    $.dialog.data('data', JSON.stringify(q));
                }
            })
            $.dialog.close();
        });
    });
</script>