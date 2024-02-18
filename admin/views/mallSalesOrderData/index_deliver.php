<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》收/发货管理》<a class="nav-a">发货跟踪</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content"> 
          <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>下单时间：</span>
                    <input style="width:80px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start;?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>物流单号：</span>
                    <input style="width:200px;" class="input-text" placeholder="请输入物流单号" type="text" name="logistics_number" value="<?php echo Yii::app()->request->getParam('logistics_number');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" placeholder="订单号/编号/名称" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>            
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="width:25px;">序号</th>
                        <th width="10%"><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th width="10%"><?php echo $model->getAttributeLabel('product_code');?></th>
                        <th width="15%">商品信息</th>
                        <th><?php echo $model->getAttributeLabel('gf_name');?></th>
                        <th>商品状态</th>
                        <th>物流信息</th>
                        <th style="width:70px;">发货时间</th>
                        <th style="width:70px;">签收时间</th>
                        <th style="width:70px;">下单时间</th>
                    </tr>
                </thead>
                <tbody>
					<?php
                     $index = 1; 
                     foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php echo $v->product_code; ?></td>
                        <td><?php echo $v->product_title; ?>，<?php echo $v->json_attr; ?>，<?php echo $v->buy_count; ?></td>
                        <td><?php if(!empty($v->order_info)) echo $v->order_info->order_gfaccount; ?>(<?php echo $v->gf_name; ?>)
                        </td>
                        <td><?php echo (!empty($v->logistics)) ? $v->logistics->logistics_state_name : '未发货';?></td>
                        <td><?php if(!empty($v->logistics)) echo $v->logistics->logistics_name.'/'.$v->logistics->logistics_number; ?></td>
                        <td><?php if(!empty($v->logistics)) echo $v->logistics->logistics_date; ?></td>
                        <td><?php if(!empty($v->logistics)) echo $v->logistics->sign_date; ?></td>
                        <td><?php echo $v->order_Date; ?></td>
                 
                    </tr>
					<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        </div>
        
        <div class="box-page c"><?php $this->page($pages); ?></div>

</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

$(function(){
    var $start_time=$('#start');
    var $end_time=$('#end');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
});
function excel(){
    $("#is_excel").val(1);
    var v=$("#is_excel").val();
    $("#submit_button").click();
    //$("#is_excel").val('0');
}
</script>