
<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约 》服务退订 》退订审核》<a class="nav-a">详情</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table>
                <tr class="table-title">
                    <td>订单信息</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td width="12%"><?php echo $form->labelEx($model,'refunds_num'); ?></td>
                    <td width="38%"><?php echo $model->order_num; ?></td>
                    <td width="12%"><?php echo $form->labelEx($model,'order_gfid'); ?></td>
                    <td width="38%"><?php if(!empty($model->orderinfo)) echo $model->orderinfo->order_gfaccount; ?>/<?php echo $model->gf_name; ?></td>
                </tr> 
                <tr>
                    <td><?php echo $form->labelEx($model,'return_order_num'); ?></td>
                    <td><?php echo $model->return_order_num; ?></td>
                    <td><?php echo $form->labelEx($model,'service_order_date'); ?></td>
                    <td><?php echo $model->order_date; ?></td>
                </tr>
<?php
if(!empty($model->orderdata)) $list=GfServiceData::model()->find('id='.$model->orderdata->gf_service_id);
?>
                <tr>
                    <td>退订信息</td>
                    <td colspan="3">
                        <p>服务流水号：<?php if(!empty($list)) echo $list->order_num; ?></p>
                        <p>服务资源：<?php if(!empty($model->orderdata)){ echo $model->orderdata->project_name;?>/<?php echo $model->orderdata->service_name; ?>/<?php echo $model->orderdata->service_data_name; } ?></p>
                        <p>费用：¥<?php  echo $model->sale_money; ?></p>
                    </td>
                </tr> 
                <tr>
                    <td><?php echo $form->labelEx($model,'service_return_reason'); ?></td>
                    <td><?php echo $model->return_reason; ?></td>
                    <td><?php echo $form->labelEx($model,'service_return_cond'); ?></td>
                    <td><?php if(!empty($model->reasonid)) echo $model->reasonid->return_start_time.'小时<距服务时间≤'.$model->reasonid->return_time.'小时'; ?></td>
                </tr>           
            </table>
            <table>
                <tr class="table-title">
                    <td>退订费用明细</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>扣除手续费比例(%)</td>
                    <td><?php echo $form->labelEx($model, 'return_float_Percentage'); ?></td>
                    <td><?php echo $form->labelEx($model, 'ret_money'); ?></td>
                    <td><?php echo $form->labelEx($model, 'pay_id'); ?></td>
                </tr>
                <tr>
                    <td><?php echo $model->return_float_Percentage; ?>%</td>
                    <td><?php echo $model->sale_money*($model->return_float_Percentage/100); ?></td>
                    <td><?php echo $form->textField($model, 'ret_money', array('class' => 'input-text')); ?></td>
                    <td><?php echo $model->pay_name; ?></td>
                 </tr>
                <?php echo $form->error($model, 'ret_money', $htmlOptions = array()); ?>
            </table>
        <div class="mt15">
            <table>
                <tr class="table-title">
                    <td>审核信息</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td width="12%"><?php echo $form->labelEx($model, 'after_sale_state'); ?></td>
                    <td><?php echo $model->after_sale_state_name; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'desc'); ?></td>
                    <td>
                        <?php echo ($model->after_sale_state==1150) ? $form->textArea($model, 'desc', array('class' => 'input-text' ,'value'=>'')) : $model->desc; ?>
                        <?php echo $form->error($model, 'desc', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td>可执行操作</td>
                    <td><?php echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div>
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>

    function optionRetstart(obj,num){
        var option=$('#goods_num_'+num+'_ret_state option:selected');
        if(option.text()=='请选择'){
            $("#ret_state_name_"+num+"").val('');
        }
        else{
            $("#ret_state_name_"+num+"").val(option.text());
        }
    }


</script>