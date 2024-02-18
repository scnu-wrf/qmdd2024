<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>待支付列表</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>订单号：</span>
                    <input style="width:200px;" class="input-text" placeholder="请输入订单号" type="text" name="order_num" value="<?php echo Yii::app()->request->getParam('order_num');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>下单时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                </label>
                <br/>
                <label style="margin-right:10px;">
                    <span>收货人：</span>
                    <input style="width:200px;" class="input-text" placeholder="请输入收货人姓名" type="text" name="gf_name" value="<?php echo Yii::app()->request->getParam('gf_name');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>联系电话：</span>
                    <input style="width:200px;" class="input-text" placeholder="请输入收货人联系电话" type="text" name="rec_phone" value="<?php echo Yii::app()->request->getParam('rec_phone');?>">
                </label>
                <label style="margin-right:20px;">
                    <span>商品类型：</span>
                    <select name="order_type">
                        <option value="">请选择</option>
                        <?php foreach($order_type as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('order_type')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <br/>
                <label style="margin-right:20px;">
                    <span>收货地区：</span>
                    <select name="province"></select><select name="city"></select><select name="area"></select>
                    <script>new PCAS("province","city","area","<?php echo Yii::app()->request->getParam('province');?>","<?php echo Yii::app()->request->getParam('city');?>","<?php echo Yii::app()->request->getParam('area');?>");</script>
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('rec_name');?></th>
                        <th><?php echo $model->getAttributeLabel('rec_phone');?></th>
                        <th><?php echo $model->getAttributeLabel('order_type');?></th>
                        <th><?php echo $model->getAttributeLabel('order_money');?></th>
                        <th><?php echo $model->getAttributeLabel('total_money');?></th>
                        <th><?php echo $model->getAttributeLabel('order_Date');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody><?php $basepath=BasePath::model()->getPath(130);?>
					<?php
                    $index = 1;

                     foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php echo $v->rec_name; ?></td>
                        <td><?php echo $v->rec_phone; ?></td>
                        <td><?php if (!empty($v->order_type)) echo $v->ordertype->F_NAME; ?></td>
                        <td><?php echo $v->order_money; ?></td>
                        <td><?php echo $v->total_money; ?></td>
                        <td><?php echo $v->order_Date; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
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
    var $start_time=$('#start_date');
    var $end_time=$('#end_date');
    $start_time.on('click', function(){
        var end_input=$dp.$('end_date')
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'end_date\')}'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'start_date\')}'});
    });
});
</script>