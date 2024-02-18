<div class="box">
    <div class="box-title c">
        <h1>当前界面：财务》订单管理》<a class="nav-a">待支付列表</a></h1>
        <span class="back"><a class="btn" href="<?php echo $this->createUrl('index');?>" ><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end--> 
    <div class="box-content"> 
  
          <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>订单类型：</span>
                    <?php echo downList($order_type,'f_id','F_NAME','order_type'); ?>
                </label>
                <!-- <label style="margin-right:10px;">
                    <span>下单时间：</span>
                    <input style="width:80px;" class="input-text" type="text" id="start" name="start" value="<?php //echo $start;?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end" name="end" value="<?php //echo $end;?>">
                </label> -->
                <label style="margin-right:10px;">
                        <span>关键字：</span>
                        <input style="width:200px;" class="input-text"  placeholder="订单号/购买者账号/场馆名称" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="width:25px;text-align:center;">序号</th>
                        <th><?php echo $model->getAttributeLabel('order_code');?></th>
                        <th><?php echo $model->getAttributeLabel('order_title');?></th>
                        <th><?php echo $model->getAttributeLabel('order_type');?></th>
                        <th><?php echo $model->getAttributeLabel('add_code');?></th>
                        <th><?php echo $model->getAttributeLabel('add_name');?></th>
                        <th><?php echo $model->getAttributeLabel('add_phone');?></th>
                        <th><?php echo $model->getAttributeLabel('stadium_id');?></th>
                        <th><?php echo $model->getAttributeLabel('stadium_name');?></th>
                        <th><?php echo $model->getAttributeLabel('money');?></th>
                        <th><?php echo $model->getAttributeLabel('add_date');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
					<?php
                     $index = 1; 
                     foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->order_code; ?></td>
                        <td><?php echo $v->order_title; ?></td>
                        <td><?php echo $v->order_type; ?></td>
                        <td><?php echo $v->add_code; ?></td>
                        <td><?php echo $v->add_name; ?></td>
                        <td><?php echo $v->add_phone; ?></td>
                        <td><?php echo $v->stadium_id; ?></td>
                        <td><?php echo $v->stadium_name; ?></td>
                        <td><?php echo $v->money; ?></td>
                        <td><?php echo $v->add_date; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="详情">详情</a>
                        </td>
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