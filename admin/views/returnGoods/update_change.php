
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》收/发货管理》换货发货处理》待换货》<a class="nav-a">详情</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table id="goods_num" style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="6">换货信息</td>
                </tr>
                <tr>
                    <td style="text-align:center;">订单编号</td>
                    <td style="text-align:center;">售后单号</td>
                    <td style="text-align:center;">商品货号</td>
                    <td style="text-align:center;">换货商品</td>
                    <td style="text-align:center;">换货数量</td>
                    <td style="text-align:center;">换货规格</td>
                </tr>
                <tr class="return_produce">
                    <td><?php echo $model->return_order_num; ?></td>
                    <td><?php echo $model->order_num; ?></td>
                    <td><?php if(!empty($model->product)) echo $model->product->supplier_code; ?></td>
                    <td><?php echo $model->ret_product_title; ?></td>
                    <td><?php echo $model->ret_count; ?></td>
                    <td><?php echo $model->ret_json_attr; ?></td>
                </tr>
            </table>
            <table class="table-title">
                <tr>
                    <td>发货信息</td>
                </tr>
            </table>
            <table>
                <?php $info=MallSalesOrderInfo::model()->find('order_num="'.$model->return_order_num.'"'); ?>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model,'change_logistics_id'); ?></td>
                    <td width="35%"><?php echo $form->hiddenField($model, 'change_logistics_id'); ?>
                    <?php echo $form->hiddenField($model, 'change_logistics_name'); ?>
                        <span id="logistics_box"><span class="label-box"><?php echo $model->change_logistics_name;?></span></span>
                        <input id="logistics_select_btn" class="btn" type="button" value="选择">
                        <?php echo $form->error($model, 'change_logistics_id', $htmlOptions = array()); ?>
                    </td>
                    <td width="15%">收货人</td>
                    <td width="35%"><?php echo $info->rec_name; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'change_no'); ?></td>
                    <td><?php echo $form->textField($model,'change_no',array('class'=>'input-text')); ?>
                        <?php echo $form->error($model, 'change_no', $htmlOptions = array()); ?>
                    </td>
                    <td>联系电话</td>
                    <td><?php echo $info->rec_phone; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'change_post'); ?></td>
                    <td>¥<?php echo $form->textField($model,'change_post',array('class'=>'input-text','style'=>'width:80px;')); ?>
                        <?php echo $form->error($model, 'change_post', $htmlOptions = array()); ?>
                    </td>
                    <td>收货地址</td>
                    <td><?php echo $info->rec_address; ?></td>
                </tr>
            </table>
            <table class="table-title">
                <tr>
                    <td>操作信息</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model,'after_sale_state'); ?></td>
                    <td width="85%"><?php echo $model->after_sale_state_name; ?></td>
                </tr>
                <tr>
                    <td>可执行操作</td>
                    <td width="85%">
                        <!--button onclick="submitType='fahuo'" class="btn btn-blue" type="submit">确认1</button-->
                        <?php if($model->after_sale_state==1287) echo show_shenhe_box(array('baocun'=>'确认')); ?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
                <tr>
                    <td>操作记录</td>
                    <td width="85%" style="padding:0;">
                        <table class="showinfo" style="margin:0;">
                            <tr>
                                <th style="width:20%;">操作人</th>
                                <th style="width:20%;">操作时间</th>
                                <th>操作备注</th>
                            </tr>
                            <?php foreach($order_record as $o){?>
                            <tr>
                                <td><?php echo $o->operator_gfname; ?></td>
                                <td><?php echo $o->order_state_des_time; ?></td>
                                <td><?php echo $o->order_state_des_content; ?></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
   

    $('#logistics_select_btn').on('click', function(){
		var html_s='';
        $.dialog.data('logistics_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/logistics");?>',{
            id:'fuwu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('logistics_id')>0){				
                    $('#ReturnGoods_change_logistics_id').val($.dialog.data('logistics_id'));
                    $('#ReturnGoods_change_logistics_name').val($.dialog.data('logistics_company'));
					$('#logistics_box').html('<span class="label-box">'+$.dialog.data('logistics_company')+'</span>');
                }
            }
        });
    });
</script>