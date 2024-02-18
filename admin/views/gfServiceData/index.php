<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>服务预订</h1></div><!--box-title end-->     
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
                    <input style="width:200px;" class="input-text" type="text" name="order_num" value="<?php echo Yii::app()->request->getParam('order_num');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>下单时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                </label>
                <label style="margin-right:20px;">
                    <span>审核状态：</span>
                    <select name="state">
                        <option value="">请选择</option>
                        <?php foreach($state as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('state')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <br/>
                <label style="margin-right:20px;">
                    <span>支付状态：</span>
                    <select name="is_pay">
                        <option value="">请选择</option>
                        <?php foreach($is_pay as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('is_pay')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>订单状态：</span>
                    <select name="order_type">
                        <option value="">请选择</option>
                        <?php foreach($order_type as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('order_type')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>用户：</span>
                    <input style="width:200px;" class="input-text" type="text" name="gf_name" value="<?php echo Yii::app()->request->getParam('gf_name');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>联系电话：</span>
                    <input style="width:200px;" class="input-text" type="text" name="contact_phone" value="<?php echo Yii::app()->request->getParam('contact_phone');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check" style="text-align:center;">序号</th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('order_num');?></th> 
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('order_type');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('gf_name');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('service_name');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('order_state');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('is_pay');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('state');?></th> 
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('supplier_id');?></th>                      
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('add_time');?></th>
                        <th style="text-align:center;">操作</th>
                    </tr>
                </thead>
                <tbody>
					<?php
                    $index = 1;
                      
                     foreach($arclist as $v){ ?>
                    <tr>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td> 
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php echo $v->order_type_name; ?></td>
                        <td><?php echo $v->gf_name; ?></td>
                        <td><?php echo $v->service_name; ?></td>
                        <td><?php echo $v->order_state_name; ?></td>
                        <td><?php echo $v->is_pay_name; ?></td>
                        <td><?php echo $v->state_name; ?></td>
                        <td><?php echo $v->supplier_name; ?></td>
                        <td><?php echo $v->add_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>

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