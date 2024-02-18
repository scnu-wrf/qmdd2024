<?php
    if($model->change_date=='0000-00-00 00:00:00'){
        $model->change_date='';
    }
    $ct = $model->change_type;
?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i><?php echo (!empty($model->change_type)) ? $model->change_base->F_NAME : ''; ?>订单详情</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table>
                <tr class="table-title">
                    <td colspan="6">订单信息</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'return_order_num'); ?></td>
                    <td><?php echo $model->return_order_num; ?></td>
                    <td><?php echo $form->labelEx($model,'pay_type'); ?></td>
                    <td><?php if(!empty($model->orderinfo->pay_type_name))echo $model->orderinfo->pay_type_name; ?></td>
                    <td><?php echo $form->labelEx($model,'pay_time'); ?></td>
                    <td><?php if(!empty($model->orderinfo->pay_time))echo $model->orderinfo->pay_time; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'rec_name'); ?></td>
                    <td><?php if(!empty($model->orderinfo->rec_name))echo $model->orderinfo->rec_name; ?></td>
                    <td><?php echo $form->labelEx($model,'rec_phone'); ?></td>
                    <td><?php if(!empty($model->orderinfo->rec_phone))echo $model->orderinfo->rec_phone; ?></td>
                    <td><?php echo $form->labelEx($model,'rec_address'); ?></td>
                    <td><?php if(!empty($model->orderinfo->rec_address))echo $model->orderinfo->rec_address; ?></td>
                </tr>
            </table>
            <table class="mt15">
                <tr class="table-title">
                	<td colspan="6">售后信息</td>
                </tr>
                <?php $record=OrderRecord::model()->find('(order_num="'.$model->order_num.'") order by id DESC'); ?>
                <tr>
                	<td><?php echo $form->labelEx($model, 'order_num'); ?></td>
                    <td><?php echo $model->order_num; ?></td>
                    <td><?php echo $form->labelEx($model, 'order_gfid'); ?></td>
                    <td><?php echo $model->gf_name; ?></td>
                	<td><?php echo $form->labelEx($model, 'order_date'); ?></td>
                    <td><?php echo $model->order_date; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'return_id'); ?></td>
                    <td><?php echo $model->return_reason; ?></td>
                    <td><?php echo $form->labelEx($model, 'reason'); ?></td>
                    <td><?php echo $model->reason; ?></td>
                    <td><?php echo $form->labelEx($model, 'img'); ?></td>
                    <td>
                        <div class="upload_img fl" id="upload_pic_img">
                            <?php if(!empty($img))foreach($img as $i) if($i) { $basepath = BasePath::model()->getPath(169); ?>
                                <a class="picbox" data-savepath="<?php echo $i;?>" href="<?php echo $basepath->F_WWWPATH.$i;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$i;?>" style="width:100px;height:100px;"></a>
                            <?php }?>
                        </div>
                    </td>
                </tr>
            </table>
            <table class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="4">商品退回供应商信息设置</td>
                </tr>
                <tr>
                    <td style="width:16.65%;"><?php echo $form->labelEx($model,'return_club_name'); ?></td>
                    <td style="width:33.35%;"><?php echo $form->textField($model,'return_club_name',array('class'=>'input-text')); ?></td>
                    <td style="width:16.65%;"><?php echo $form->labelEx($model,'return_club_tel'); ?></td>
                    <td style="width:33.35%;">
                        <?php echo $form->textField($model,'return_club_tel',array('class'=>'input-text')); ?>
                        <?php echo $form->error($model,'return_club_tel',$htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'return_club_address'); ?></td>
                    <td><?php echo $form->textField($model,'return_club_address',array('class'=>'input-text')); ?></td>
                    <td><?php echo $form->labelEx($model,'return_club_mail_code'); ?></td>
                    <td>
                        <?php echo $form->textField($model,'return_club_mail_code',array('class'=>'input-text')); ?>
                        <?php echo $form->error($model,'return_club_mail_code',$htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
            <table class="mt15">
                <tr class="table-title">
                    <td colspan="6">用户退回商品信息</td>
                </tr>
                <?php
                    $logistics = ($ct==1137) ? 'ret_logistics' : 'change_no';
                    $logistics_name = ($ct==1137) ? 'ret_logistics_name' : 'change_logistics_name';
                ?>
                <tr>
                    <td><?php echo $form->labelEx($model,$logistics); ?></td>
                    <td><?php echo ($ct==1137) ? $model->ret_logistics : $model->change_no; ?></td>
                    <td><?php echo $form->labelEx($model,$logistics_name); ?></td>
                    <td><?php echo ($ct==1137) ? $model->ret_logistics_name : $model->change_logistics_name; ?></td>
                    <td><?php echo $form->labelEx($model,'change_date'); ?></td>
                    <td><?php echo $model->change_date; ?></td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
        <div class="mt15">
            <?php echo $form->hiddenField($model, 'goods_num'); ?>
            <table id="goods_num" style="table-layout:auto;">
                <tr class="table-title">
                	<td colspan="12">商品信息</td>
                </tr>
                <tr>
                    <td class="check" width="2%"><input id="j-checkall" class="input-check" type="checkbox" value="全选"><span style="display:none;"><a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="add_chose();">添加</a></span></td>
                    <td>商品货号</td>
                    <td>商品编号</td>
                	<td>商品名称</td>
                    <td>型号/规格</td>
                    <td>销售价</td>
                    <td>体育豆</td>
                    <td>运费（单件）</td>
                    <td>退换货数量</td>
                    <td>小计</td>
                    <td>应退货金额</td>
                    <td>确认操作</td>
                </tr>
                <?php
                    $d_num=0;
                    if (!empty($model->order_data_id)){
                        $model->order_num=empty($model->order_num) ? 0 : $model->order_num;
                        $order_data = MallSalesOrderData::model()->findAll('order_num="'.$model->order_num.'" and id='.$model->order_data_id);
                ?>
                    <?php if(!empty($order_data))foreach($order_data as $g) {?>
                    <tr data-count="<?php echo $d_num; ?>">
                        <input type="hidden" name="goods_num[<?php echo $d_num; ?>][not_null]" value="<?php if($g->ret_state==372){echo '372';}else{echo '1';} ?>">
                        <input type="hidden" name="goods_num[<?php echo $d_num; ?>][orderdata_id]" value="<?php echo $g->id; ?>">
                        <input type="hidden" name="goods_num[<?php echo $d_num; ?>][order_num]" value="<?php echo $g->order_num; ?>">
                        <input type="hidden" name="goods_num[<?php echo $d_num; ?>][product_title]" value="<?php echo $g->product_title; ?>">
                        <input type="hidden" name="goods_num[<?php echo $d_num; ?>][product_code]" value="<?php echo $g->product_code; ?>">
                        <input type="hidden" name="goods_num[<?php echo $d_num; ?>][buy_price]" value="<?php echo $g->buy_price; ?>">
                        <input type="hidden" name="goods_num[<?php echo $d_num; ?>][buy_beans]" value="<?php echo $g->buy_beans; ?>">
                        <input type="hidden" name="goods_num[<?php echo $d_num; ?>][buy_count]" value="<?php echo $g->buy_count; ?>">
                        <input type="hidden" name="goods_num[<?php echo $d_num; ?>][json_attr]" value="<?php echo $g->json_attr; ?>">
                        <input type="hidden" name="goods_num[<?php echo $d_num; ?>][gfid]" value="<?php echo $g->gfid; ?>">
                        <input type="hidden" name="goods_num[<?php echo $d_num; ?>][gf_name]" value="<?php echo $g->gf_name; ?>">
                        <input type="hidden" name="goods_num[<?php echo $d_num; ?>][product_id]" value="<?php echo $g->product_id; ?>">
                        <input type="hidden" name="goods_num[<?php echo $d_num; ?>][supplier_id]" value="<?php echo $g->supplier_id; ?>">
                        <input type="hidden" name="goods_num[<?php echo $d_num; ?>][supplier_name]" value="<?php echo $g->supplier_name; ?>">
                        <input type="hidden" name="goods_num[<?php echo $d_num; ?>][project_id]" value="<?php echo $g->project_id; ?>">
                        <input type="hidden" name="goods_num[<?php echo $d_num; ?>][set_id]" value="<?php echo $g->set_id; ?>">
                        <input type="hidden" name="goods_num[<?php echo $d_num; ?>][set_detail_id]" value="<?php echo $g->set_detail_id; ?>">
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($g->id); ?>"></td>
                        <td><?php echo $g->supplier_code; ?></td>
                        <td><?php echo $g->product_code; ?></td>
                        <td><?php echo $g->product_title; ?></td>
                        <td><?php echo $g->buy_price; ?></td>
                        <td><?php echo $g->buy_beans; ?></td>
                        <td><?php echo $g->buy_count; ?></td>
                        <td><?php echo $g->json_attr; ?></td>
                        <td><?php echo $g->buy_price*$g->buy_count; ?></td>
                        <td><input class="input-text" type="text" name="goods_num[<?php echo $d_num; ?>][ret_money]" value="<?php echo $g->ret_amount; ?>"></td>
                        <td><input type="text" class="input-text" name="goods_num[<?php echo $d_num; ?>][ret_count]" value="<?php echo $g->ret_count; ?>"></td>
                        <td>
                            <input id="ret_state_name_<?php echo $d_num; ?>" type="hidden" name="goods_num[<?php echo $d_num; ?>][ret_state_name]" value="">
                            <?php $f_id='372,373'; echo $form->dropDownList($g,'ret_state',Chtml::listData(BaseCode::model()->getReturn($f_id),'f_id','F_NAME'),array('prompt'=>'请选择','name'=>'goods_num['.$d_num.'][ret_state]','onchange'=>'optionRetstart(this,'.$d_num.')')); ?>
                        </td>
                    </tr>
                <?php $d_num++; }}?>
            </table>
        </div>
        <div class="mt15">
            <table>
                <tr class="table-title">
                    <td colspan="4">审核信息</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'after_sale_state'); ?></td>
                    <td>
                        <?php
                            if($ct==1137){
                                $fid = '1150,1151,1153,1154,1155,1156';
                            }
                            else if($ct==1138){
                                $fid = '1150,1151,1152,1154,1155,1156';
                            }
                            else{
                                $fid = '1150,1151,1152,1153,1154,1155,1156';
                            }
                            $basecode = BaseCode::model()->getReturn($fid);
                            echo $form->dropDownList($model, 'after_sale_state',Chtml::listData($basecode,'f_id','F_NAME'));
                        ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'desc'); ?></td>
                    <td>
                        <?php echo $form->textField($model, 'desc', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'desc', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                	<td>可执行操作</td>
                    <td colspan="3">
                    	<button onclick="submitType='qveren'" class="btn btn-blue" type="submit">确认</button>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div>
        <div class="mt15">
            <table>
                <tr class="table-title">
                	<td colspan="5">订单操作记录</td>
                </tr>
                <tr style="text-align:center;">
                	<td>操作人</td>
                    <td>操作时间</td>
                    <td>订单状态</td>
                    <td>售后状态</td>
                    <td>操作备注</td>
                </tr>
                <?php foreach($order_record as $o){?>
                <tr style="text-align:center;">
                	<td><?php echo $o->operator_gfname; ?></td>
                    <td><?php echo $o->order_state_des_time; ?></td>
                    <td><?php echo $o->order_state_name; ?></td>
                    <td><?php if(!empty($o->logistics_state))echo $o->base_logistics_state->F_NAME; ?></td>
                    <td><?php echo $o->order_state_des_content; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    $('#ReturnGoods_ret_date').on('click', function(){WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss '});});
    $('#ReturnGoods_take_date').on('click', function(){WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss '});});
    $('#ReturnGoods_change_date').on('click', function(){WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss '});});

    function optionRetstart(obj,num){
        var option=$('#goods_num_'+num+'_ret_state option:selected');
        if(option.text()=='请选择'){
            $("#ret_state_name_"+num+"").val('');
        }
        else{
            $("#ret_state_name_"+num+"").val(option.text());
        }
    }

    $('#logistics_select_btn').on('click', function(){
		var html_s='';
		$this=$(this);
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