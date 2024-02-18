<style>
    .box-table .list tr th,.box-table .list tr td{
        text-align:center;
    }
    .box-table .list tr th ul li,.box-table .list tr td ul li{
        display:inline-block;
        width:24%;
    }
    .buy{
        padding: 0!important;
    }
    .buy table{
        width: 100%;
    }
    </style>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>动动约预订收费分类表</h1></div><!--box-title end-->     
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <!-- <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a> -->
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">               
                <label style="margin-right:10px;">
                    <span>订单号：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入订单编号">
                </label>
                <label style="margin-right:10px;">
                    <span>下单时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="list-id">序号</th>
                        <th><?php echo $model->getAttributeLabel('udate');?></th>
                        <th><?php echo $model->getAttributeLabel('info_order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('supplier_name');?></th>
                        <th><?php echo $model->getAttributeLabel('payment_code');?></th>
                        <th class="buy">
                            <table>
                                <tr>服务收费类型</tr>
                                <tr>
                                    <td>场地</td>
                                    <td>服务者</td>
                                    <td>赛事服务</td>
                                    <td>手续费</td>
                                </tr>
                            </table>
                        </th>
                        <th class="buy">
                            <table>
                                <tr>支付方式</tr>
                                <tr>
                                    <td>支付宝</td>
                                    <td>微信</td>
                                    <td>银联</td>
                                    <td>体育豆</td>
                                </tr>
                            </table>
                        </th>
                    </tr>
                </thead>
                <tbody>
					<?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td> 
                        <td><?php echo substr($v->udate,0,10); ?></td>
                        <td><?php echo $v->info_order_num; ?></td>
                        <td><?php echo $v->supplier_name; ?></td>
                        <td><?php if(!empty($v->info_order_num))echo $v->info_num->payment_code; ?></td>
                        <td class="buy">
                            <ul>
                                <li><?php if($v->t_stypeid==14)echo $v->buy_price; ?></li>
                                <li><?php if($v->t_stypeid<14)echo $v->buy_price; ?></li>
                                <li><?php if($v->t_stypeid==15)echo $v->buy_price; ?></li>
                                <li><?php  ?></li>
                            </ul>
                        </td>
                        <td class="buy">
                            <ul>
                                <li><?php if($v->t_stypeid==14)echo $v->buy_price; ?></li>
                                <li><?php if($v->t_stypeid<14)echo $v->buy_price; ?></li>
                                <li><?php if($v->t_stypeid==15)echo $v->buy_price; ?></li>
                                <li><?php  ?></li>
                            </ul>
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
    $(function(){
        var $start_time=$('#start_date');
        var $end_time=$('#end_date');
        $start_time.on('click', function(){
            var end_input=$dp.$('end_date')
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'end_date\')}'});
        });
        $end_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'start_date\')}'});
        });
    });
</script>