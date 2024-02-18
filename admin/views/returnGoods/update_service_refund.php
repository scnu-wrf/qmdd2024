
<div class="box">
    <div class="box-title c">
        <h1>当前界面：财务 》退款管理 》动动约退款 》<a class="nav-a">详情</a></h1>
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
                    <td><?php echo $form->labelEx($model, 'service_total_money'); ?></td>
                    <td>扣除手续费比例(%)</td>
                    <td><?php echo $form->labelEx($model, 'return_float_Percentage'); ?></td>
                    <td><?php echo $form->labelEx($model, 'ret_money'); ?></td>
                    <td><?php echo $form->labelEx($model, 'pay_id'); ?></td>
                    <td><?php echo $form->labelEx($model, 'act_ret_money'); ?></td>
                    <td><?php echo $form->labelEx($model, 'ret_pay_supplier_type'); ?></td>
                    <td><?php echo $form->labelEx($model, 'ret_no'); ?></td>
                </tr>
                <tr>
                    <td><?php if(!empty($model->buy_orderdata)) echo $model->buy_orderdata->buy_amount; ?></td>
                    <td><?php echo $model->return_float_Percentage; ?>%</td>
                    <td><?php echo $model->sale_money*($model->return_float_Percentage/100); ?></td>
                    <td><?php echo $model->ret_money; ?></td>
                    <td><?php echo $model->pay_name; ?></td>
                    <td><?php echo ($model->after_sale_state==1153) ? $form->textField($model, 'act_ret_money', array('class' => 'input-text')) : $model->act_ret_money; ?>
                        <?php echo $form->error($model, 'act_ret_money', $htmlOptions = array()); ?>
                    </td>
                    <td><?php if ($model->after_sale_state==1154){
                        if (!empty($model->ret_pay)) echo $model->ret_pay->F_NAME;
                    } else {
                        echo $form->dropDownList($model, 'ret_pay_supplier_type', Chtml::listData(BaseCode::model()->getCode(482), 'f_id', 'F_NAME'), array('prompt'=>'请选择'));
                    }  ?>
                        <?php echo $form->error($model, 'ret_pay_supplier_type', $htmlOptions = array()); ?></td>
                    <td><?php echo ($model->after_sale_state==1153) ? $form->textField($model, 'ret_no', array('class' => 'input-text')) : $model->ret_no; ?>
                        <?php echo $form->error($model, 'ret_no', $htmlOptions = array()); ?>
                    </td>
                 </tr>
                
            </table>
        <div class="mt15">
            <table>
                <tr>
                    <td width="12%"><?php echo $form->labelEx($model, 'after_sale_state'); ?></td>
                    <td><?php echo $model->after_sale_state_name; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'ret_desc'); ?></td>
                    <td>
                        <?php echo ($model->after_sale_state==1153) ? $form->textArea($model, 'ret_desc', array('class' => 'input-text' ,'value'=>'')) : $model->ret_desc; ?>
                        <?php echo $form->error($model, 'ret_desc', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td>可执行操作</td>
                    <td><?php echo show_shenhe_box(array('baocun'=>'确定'));?>
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