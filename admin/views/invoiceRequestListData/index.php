
<div class="box">
    <div class="box-title c">
        <h1>当前界面：财务》发票管理》<a class="nav-a">开票管理</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end--> 
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('invoiceRequestList/index',array('apply_type'=>1458));?>">发票申请(<span class="red"><?php echo $num1;?></span>)</a>
            <a class="btn" href="<?php echo $this->createUrl('invoiceRequestList/index',array('apply_type'=>1457));?>">待开票(<span class="red"><?php echo $num2;?></span>)</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>开票时间：</span>
                    <input style="width:80px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start;?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end;?>">
                </label>
                <label style="margin-right:10px;">
                        <span>开票类型：</span>
                        <?php echo downList($company_personer,'f_id','F_NAME','company_personer'); ?>
                </label><label style="margin-right:10px;">
                        <span>发票类型：</span>
                        <?php echo downList($category,'f_id','F_NAME','category'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                	<tr class="table-title">
                    	<th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="text-align:center; width:25px;">序号</th>
                        <th width="10%"><?php echo $model->getAttributeLabel('invoice_number');?></th>
                        <th width="10%"><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th width="16%">商品信息</th>
                        <th>申请人</th>
                        <th><?php echo $model->getAttributeLabel('invoice_category');?></th>
                        <th><?php echo $model->getAttributeLabel('invoice_category');?></th>
                        <th><?php echo $model->getAttributeLabel('invoiced_amount');?></th>
                        <th><?php echo $model->getAttributeLabel('main_unit');?></th>
                        <th><?php echo $model->getAttributeLabel('receipt_state');?></th>
                        <th style="width:70px;"><?php echo $model->getAttributeLabel('logistics_date');?></th>
                        <th>操作</th>
                    </tr>
<?php $index=1;
foreach($arclist as $v){ ?>
<?php $invoice=InvoiceRequestListData::model()->find('id='.$v->invoice_id); ?>
<?php $in_data=MallSalesOrderData::model()->findAll('invoice_data_id='.$v->id.' and gf_invoice_id='.$v->invoice_request_list_id.' and orter_item=757'); ?>
                                    <tr>
                    	<td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style="text-align:center;"><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php echo $v->invoice_number; ?></td>
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php if(!empty($in_data)) foreach ($in_data as $p) {
                            echo $p->product_title.'，'.$p->json_attr.'，'.$p->buy_count.'<br>';
                        } ?></td>
                        <td><?php if(!empty($v->orderinfo)) echo $v->orderinfo->order_gfaccount.'('.$v->orderinfo->order_gfname.')';  ?></td>
                        <td><?php if(!empty($v->type)){ echo $v->type->F_NAME; } ?></td>
                        <td><?php if(!empty($v->base_code)){ echo $v->base_code->F_NAME; } ?></td>
                        <td><?php echo $v->invoiced_amount; ?></td>
                        <td><?php if(!empty($v->club_list)){ echo $v->club_list->club_name; } ?></td>
                        <td><?php if(!empty($v->state)){ echo $v->state->F_NAME; } ?></td>
                        <td><?php echo $v->logistics_date; ?></td>
                        <td>
  <?php if($v->cancl_invoice==1 && empty($invoice)){ ?>
                            <a class="btn" href="<?php echo $this->createUrl('second',array('id'=>$v->id));?>"><i class="fa fa-plus"></i>开票</a>
                            <?php } ?>
                        	<a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="详情">查看</a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                   <?php $index++; } ?>
                </table>
                 
        </div><!--box-table end<i class="fa fa-list"></i>-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
    var $time_start=$('#start');
    var $time_end=$('#end');
    var end_input=$dp.$('#end');
    $time_start.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',onpicked:function(){end_input.click();}});
    });
    $time_end.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',minDate:"#F{$dp.$D(\'start\')}"});
    });
// 开票商品明细
var fnInfodataLog=function(invoice_id){
    $.dialog.open('<?php echo $this->createUrl("infodata");?>&invoice_id='+invoice_id,{
        id:'mingxi',
        lock:true,
        opacity:0.3,
        title:'商品明细',
        width:'90%',
        height:'90%',
        close: function () {}
    });
};

</script>
