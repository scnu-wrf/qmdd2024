<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="keywords" style="width:200px;" class="input-text" type="text" placeholder="请输入订单号 / 退货-换货单号 / 退货物流单号" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                	<tr>
                        <th width="5%" class="check"><input id="j-checkall" class="input-check" type="checkbox" value="全选"><span style="display:none;"><a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="add_chose();">添加</a></span></th>
                    	<th><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('change_type');?></th>
                        <th>物流公司</th>
                        <th>物流单号</th>
                        <th>退货商品</th>
                        <th><?php echo $model->getAttributeLabel('ret_count');?></th>
                        <th><?php echo $model->getAttributeLabel('after_sale_state');?></th>
                        <th>售后处理</th>
                    </tr>
                </thead>
                <tbody>
                	
<?php $index = 1;
 foreach($arclist as $v){ ?>
                    <?php //$order=MallSalesOrderInfo::model()->find('order_num="'.$v->order_num.'"'); ?>
                    <tr data-id="<?php echo $v->id;?>" data-after="<?php echo $v->after_sale_state;?>">
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                    	<td><?php echo $v->order_num; ?></td>
                        <td><?php if(!empty($v->change_base)) echo $v->change_base->F_NAME; ?></td>
                        <td><?php echo $v->ret_logistics_name; ?></td>
                        <td><?php echo $v->ret_logistics; ?></td>
                        <td><?php echo $v->orderdata->product_title; ?>，<?php echo $v->orderdata->json_attr; ?></td>
                        <td><?php echo $v->ret_count; ?></td>
                        <td><?php echo $v->after_sale_state_name; ?></td>
                        <td>
                            <select id="after_sale_state" name="after_sale_state" onchange="selectAfter(this);">
                        <?php foreach($after as $a){ ?>
                            <option value="<?php echo $a->f_id; ?>"><?php echo $a->F_NAME; ?></option>
                        <?php } ?>
                            </select>
                        </td>
                    </tr>
<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
selectAfter($('#after_sale_state'));
 function selectAfter(obj){
    var after=$(obj).val();
    $(obj).parent().parent().attr('data-after',after);
}

var fnUpdateAfter=function(){
    var arr=new Array();
    var id;
    var after;
    var i=0;
    $('table.list ').find('.selected').each(function(){
        arr[i]={};
        id=$(this).attr('data-id');
        after=$(this).attr('data-after');
        arr[i]['id']=id;
        arr[i]['after']=after;
        i++;
    });
};
$(function(){
    fnUpdateAfter();
    api = $.dialog.open.api;    //art.dialog.open扩展方法
    if (!api) return;
    // 操作对话框
    api.button(
            {
                name:'确认收货',
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
        var arr=new Array();
        var id;
        var after;
        var i=0;
        $('table.list ').find('.selected').each(function(){
            arr[i]={};
            id=$(this).attr('data-id');
            after=$(this).attr('data-after');
            arr[i]['id']=id;
            arr[i]['after']=after;
            i++;
        });
        if(arr.length==0){
            we.msg('minus','请选择要收货的售后单');
            return false;
        }
        we.loading('show');
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('addForm');?>',
            data: {arr:arr},
            dataType: 'json',
            success: function(data) {
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                    //we.msg('minus', data.msg);
                    //$.dialog.close();
                }else{
                    we.loading('hide');
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
        //$.dialog.close();
 };
</script>