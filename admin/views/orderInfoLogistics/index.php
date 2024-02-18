<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》收/发货管理》<a class="nav-a">发货列表</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->    
    <div class="box-content">
        <div class="box-header">
        <?php echo show_command('添加',$this->createUrl('create',array('gfid'=>0,'club_id'=>0)),'发货'); ?>
        <a class="btn" id="orderdata_btn" href="javascript:;">未发货(<b class="red"><?php echo $datacount; ?></b>)</a>  今日已发：<b><?php echo $num1; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;已发总数：<b><?php echo $num2; ?></b>
        <?php echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>发货时间：</span>
                    <input style="width:80px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start;?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" placeholder="请输入发货单号/物流单号" type="text" name="logistics_number" value="<?php echo Yii::app()->request->getParam('logistics_number');?>">
                </label>            
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style='width:25px;'>序号</th>
                        <th width="10%"><?php echo $model->getAttributeLabel('logistics_xh');?></th>
                        <th width="15%">商品信息</th>
                        <th>下单人</th>
                        <th><?php echo $model->getAttributeLabel('rec_name');?></th>
                        <th width="8%"><?php echo $model->getAttributeLabel('rec_phone');?></th>
                        <th width="20%"><?php echo $model->getAttributeLabel('rec_address');?></th>
                        <th><?php echo $model->getAttributeLabel('logistics_state');?></th>
                        <th style='width: 70px;'><?php echo $model->getAttributeLabel('logistics_date');?></th>
                        <th width="10%">物流信息</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1;
foreach($arclist as $v){ ?>
<?php $r_data=MallSalesOrderData::model()->find('logistics_id='.$v->id.' order by logistics_id_no DESC');
 ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->logistics_xh; ?></td>
                        <td><?php if(!empty($v->mall_sales_order_data)) foreach($v->mall_sales_order_data as $d) {
                            echo '<p>'.$d->product_title.'，'.$d->json_attr.'，'.$d->buy_count.'</p>';
                        }; ?></td>
                        <td><?php if(!empty($r_data->order_info)) echo $r_data->order_info->order_gfaccount.'('.$r_data->gf_name.')'; ?></td>
                        <td><?php echo $v->rec_name; ?></td>
                        <td><?php echo $v->rec_phone; ?></td>
                        <td><?php echo $v->rec_address; ?></td>
                        <td><?php echo $v->logistics_state_name; ?></td>
                        <td><?php echo $v->logistics_date; ?></td>
                        <td><?php echo $v->logistics_name; ?>/<?php echo $v->logistics_number; ?></td>
                        <td>
                        <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                        <?php echo show_command('删除',$v->id); ?>
                        </td>
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

// 查看待发货商品列表
$('#orderdata_btn').on('click', function(){
    $.dialog.open('<?php echo $this->createUrl("orderdata");?>',{
        id:'daifahuo',
        lock:true,
        opacity:0.3,
        title:'待发货列表',
        width:'98%',
        height:'98%',
        close: function () {}
    });
});
</script>