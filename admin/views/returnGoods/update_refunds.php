<?php 
    if(!isset($_REQUEST['day'])){
        $_REQUEST['day'] = 0;
    }
    $text=($_REQUEST['day']==0) ? '' : '待退款》';
    $ct = $model->change_type;
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：财务》退款管理》交易退款》<?php echo $text; ?><a class="nav-a">详情</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table class="table-title">
                <tr>
                    <td>订单信息</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td width="10%"><?php echo $form->labelEx($model,'order_type'); ?></td>
                    <td><?php if(!empty($model->ordertype)) echo $model->ordertype->F_NAME; ?></td>
                    <td width="10%"><?php echo $form->labelEx($model,'supplier_id'); ?></td>
                    <td><?php if(!empty($model->club_list)) echo $model->club_list->club_name; ?></td> 
                    <td width="10%"><?php echo $form->labelEx($model,'gf_name'); ?></td>
                    <td><?php if(!empty($model->orderinfo)) echo $model->orderinfo->order_gfaccount.'('.$model->orderinfo->order_gfname.')'; ?></td>
                </tr>
            </table>
            <table>
                <tr class="table-title">
                    <td><?php echo $form->labelEx($model,'return_order_num'); ?></td>
                    <td>商品信息</td>
                    <td>商品金额</td>
                    <td><?php echo $form->labelEx($model,'post'); ?></td>
                    <td>商品总额</td>
                    <td><?php echo $form->labelEx($model,'pay_supplier_type'); ?></td>
                    <td><?php echo $form->labelEx($model,'pay_time'); ?></td>
                    <td><?php echo $form->labelEx($model,'payment_code'); ?></td>
                </tr>
                <tr>
                    <td><?php echo $model->return_order_num; ?></td>
                    <td><?php if(!empty($model->orderdata_return)) echo $model->orderdata_return->product_title.'，'.$model->orderdata_return->json_attr.'，'.$model->orderdata_return->buy_count; ?></td>
                    <td><?php if(!empty($model->orderdata_return))echo '¥'.$model->orderdata_return->buy_amount; ?></td>
                    <td><?php if(!empty($model->orderdata_return))echo '¥'.$model->orderdata_return->post_total; ?></td>
                    <td><?php if(!empty($model->orderdata_return))echo '¥'.$model->orderdata_return->total_pay; ?></td>
                    <td><?php if(!empty($model->orderinfo))echo $model->orderinfo->pay_supplier_type_name; ?></td>
                    <td><?php if(!empty($model->orderinfo))echo $model->orderinfo->pay_time; ?></td>
                    <td><?php if(!empty($model->orderinfo))echo $model->orderinfo->payment_code; ?></td>
                </tr>
                <tr>
            </table>

            <table class="table-title">
                <tr>
                    <td>退款信息</td>
                </tr>
            </table>
            <table>
                <tr class="table-title">
                    <td><?php echo $form->labelEx($model,'order_date'); ?></td>
                    <td><?php echo $form->labelEx($model,'refunds_num'); ?></td>
                    <td>退款数量</td>
                    <td><?php echo $form->labelEx($model,'ret_money'); ?></td>
                    <td><?php echo $form->labelEx($model,'state'); ?><span class="required">*</span></td>
                    <td><?php echo $form->labelEx($model,'act_ret_money'); ?><span class="required">*</span></td>
                    <td><?php echo $form->labelEx($model,'ret_pay_supplier_type'); ?><span class="required">*</span></td>
                    <td><?php echo $form->labelEx($model,'ret_no'); ?><span class="required">*</span></td>
                </tr>
                <tr>
                    <td><?php echo $model->order_date; ?></td>
                    <td><?php echo $model->return_order_num; ?></td>
                    <td><?php echo $model->ret_count; ?></td>
                    <td>¥<?php echo $model->ret_money; ?></td>
                    <td><?php if ($model->after_sale_state==1154){
                        echo $model->state_name;
                    } else {
                        echo $form->dropDownList($model, 'state', Chtml::listData(BaseCode::model()->findAll('f_id in(466)'), 'f_id', 'F_NAME'), array());
                    }  ?>
                        <?php echo $form->error($model, 'ret_pay_supplier_type', $htmlOptions = array()); ?></td>
                    <td>¥<?php echo ($model->after_sale_state==1154) ? $model->act_ret_money : $form->textField($model, 'act_ret_money', array('class' => 'input-text','style'=>'width:70%;')); ?>
                        <?php echo $form->error($model, 'act_ret_money', $htmlOptions = array()); ?></td>
                    <td><?php if ($model->after_sale_state==1154){
                        if (!empty($model->ret_pay)) echo $model->ret_pay->F_NAME;
                    } else {
                        echo $form->dropDownList($model, 'ret_pay_supplier_type', Chtml::listData(BaseCode::model()->getCode(482), 'f_id', 'F_NAME'), array('prompt'=>'请选择'));
                    }  ?>
                        <?php echo $form->error($model, 'ret_pay_supplier_type', $htmlOptions = array()); ?></td>
                    <td><?php echo ($model->after_sale_state==1154) ? $model->ret_no : $form->textField($model, 'ret_no', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'ret_no', $htmlOptions = array()); ?></td>
                </tr>
            </table>
        <div class="mt15">
            <table style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="2">操作信息</td>
                </tr>
                <tr>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'ret_message'); ?></td>
                    <td>
                        <?php echo ($model->after_sale_state==1154) ? $model->ret_message : $form->textArea($model, 'ret_message', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'ret_message', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td>可执行操作</td>
                    <td>
                        <?php if($model->after_sale_state==1153){ ?>
                            <?php echo show_shenhe_box(array('baocun'=>'确定')); ?>
                            <a class="btn" href="<?php echo $this->createUrl('index_refunds'); ?>">返回处理下个单</a>
                            <a class="btn" href="<?php echo $this->createUrl('index_refunds_day'); ?>">退回列表</a>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td>操作记录</td>
                    <td style="padding:0;">
                        <table class="showinfo" style="margin:0;">
                            <tr>
                                <th style="width:20%;">操作人</th>
                                <th style="width:20%;">操作时间</th>
                                <th>操作备注</th>
                            </tr>
                            <tr>
                                <td><?php echo $model->ren_name; ?></td>
                                <td><?php echo $model->ret_date; ?></td>
                                <td><?php echo $model->ret_message; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>

</script>