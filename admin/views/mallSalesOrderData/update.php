   <div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>结算详情</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table>
                <tr  class="table-title">
                	<td colspan="4">
                    订单详情
                    </td>  
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'order_num'); ?></td>
                    <td colspan='3'><?php echo $model->order_num; ?></td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'order_type'); ?></td>
                    <td colspan='3'><?php echo $model->order_type_name; ?></td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'supplier_id'); ?></td>
                    <td colspan='3'><?php echo $model->supplier_name; ?></td>
                </tr>
            </table>
            <br/>
            <table>
            	 <tr  class="table-title">
                	<td colspan="11">商品信息</td>
                </tr>
                <tr>
                	<td width="10%"><?php echo $form->labelEx($model, 'set_name'); ?></td>
                    <td width="10%"><?php echo $form->labelEx($model, 'product_title'); ?></td>
                    <td width="10%"><?php echo $form->labelEx($model, 'product_code'); ?></td>
                    <td width="10%"><?php echo $form->labelEx($model, 'json_attr'); ?></td>
                    <td width="10%"><?php echo $form->labelEx($model, 'purpose'); ?></td>
                    <td width="10%"><?php echo $form->labelEx($model, 'buy_level'); ?></td>
                    <td width="10%"><?php echo $form->labelEx($model, 'buy_count'); ?></td>
                    <td width="10%"><?php echo $form->labelEx($model, 'buy_price'); ?></td>
                    <td width="10%"><?php echo $form->labelEx($model, 'buy_amount'); ?></td>
                    <td width="10%"><?php echo $form->labelEx($model, 'buy_price'); ?></td>
                    <td width="10%"><?php echo $form->labelEx($model, 'buy_price'); ?></td>
                </tr>
                <tr>
                	<td><?php echo $model->set_name; ?></td>
                    <td><?php echo $model->product_title; ?></td>
                    <td><?php echo $model->product_code; ?></td>
                    <td><?php echo $model->json_attr; ?></td>
                    <td><?php echo $model->purpose; ?></td>
                    <td><?php echo $model->buy_level_name; ?></td>
                    <td><?php echo $model->buy_count; ?></td>
                    <td><?php echo $model->buy_price; ?></td>
                    <td><?php echo $model->buy_amount; ?></td>
                    <td><?php echo $model->buy_price; ?></td>
                    <td><?php echo $model->buy_price; ?></td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
        <div class="mt15">
            <table class="table-title">
                <tr>
                    <td>审核信息</td>
                </tr>
            </table>
            <table>
                <tr>
                	<td>可执行操作</td>
                    <td>
                    	<?php echo show_shenhe_box(array('baocun'=>'保存','tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                        <button onclick="submitType='quxiao'" class="btn btn-blue" type="submit">取消服务</button>
                        <button class="btn" type="button" onclick="we.back();">取消操作</button>
                    </td>
                </tr>
            </table>
        </div>
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->