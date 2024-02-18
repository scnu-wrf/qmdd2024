<?php if(empty($_GET["apply_type"])){
    $_GET["apply_type"]=0;
}
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：财务》发票管理》开票管理》<a class="nav-a">待开票</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end--> 
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="apply_type" value="<?php echo $_GET["apply_type"];?>">
                <label style="margin-right:10px;">
                    <span>申请时间：</span>
                    <input style="width:80px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start;?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end;?>">
                </label>
                <label style="margin-right:10px;">
                        <span>开票类型：</span>
                        <?php echo downList($company_personer,'f_id','F_NAME','company_personer'); ?>
                </label>
                <label style="margin-right:10px;">
                        <span>发票类型：</span>
                        <?php echo downList($category,'f_id','F_NAME','category'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="销售商家/申请人姓名" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                    <tr class="table-title">
                        <th style="text-align:center; width:25px;">序号</th>
                        <th>申请人</th>
                        <th><?php echo $model->getAttributeLabel('company_personer');?></th>
                        <th><?php echo $model->getAttributeLabel('invoice_category');?></th>
                        <th><?php echo $model->getAttributeLabel('invoiced_amount');?></th>
                        <th><?php echo $model->getAttributeLabel('main_unit');?></th>
                        <th>订单状态</th>
                        <th><?php echo $model->getAttributeLabel('receipt_state');?></th>
                        <th style="width:70px;"><?php echo $model->getAttributeLabel('udate');?></th>
                        <th>操作</th>
                    </tr>
<?php $index=1;
foreach($arclist as $v){ ?>
<?php $o_data=MallSalesOrderData::model()->find('gf_invoice_id='.$v->id.' and orter_item=757'); ?>
<?php $logistics=OrderInfoLogistics::model()->find('id='.$o_data->logistics_id); ?>
                    <tr>
                        <td style="text-align:center;"><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php if(!empty($v->orderinfo)) echo $v->orderinfo->order_gfaccount.'('.$v->orderinfo->order_gfname.')';  ?></td>
                        <td><?php if(!empty($v->type)){ echo $v->type->F_NAME; } ?></td>
                        <td><?php if(!empty($v->base_code)){ echo $v->base_code->F_NAME; } ?></td>
                        <td><?php echo $v->invoiced_amount; ?></td>
                        <td><?php if(!empty($v->club_list)) echo $v->club_list->club_name; ?></td>
                        <td><?php echo $logistics->logistics_state_name; ?></td>
                        <td><?php if(!empty($v->state)){ echo $v->state->F_NAME; } ?></td>
                        <td><?php echo $v->udate; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑">开票</a>
                        </td>
                    </tr>
                   <?php $index++; } ?>
                </table>
                 
        </div><!--box-table end-->
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
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',minDate:"#F{$dp.$D(\'time_start\')}"});
    });
</script>
