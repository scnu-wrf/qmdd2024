<div class="box">
    <div class="box-title c">
        <h1>当前界面：财务》发票管理》开票管理》待开票》<a class="nav-a">详情</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list());?>
        <table class="table-title">
            <tr>
                <td>申请信息</td>
            </tr>  
        </table>
        <table>
            <tr>
                <td width="15%">申请人</td>
                <td width="35%"><?php if(!empty($model->orderinfo)) echo $model->orderinfo->order_gfaccount.'('.$model->orderinfo->order_gfname.')';  ?></td>
                <td width="15%"><?php echo $form->labelEx($model, 'receipt_email'); ?></td>
                <td width="35%"><?php echo $model->receipt_email; ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'company_personer'); ?></td>
                <td>
                    <?php echo $form->dropDownList($model, 'company_personer', Chtml::listData(BaseCode::model()->getCode(402), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange'=>'selectComPer(this)','disabled'=>'true')); ?>
                    <?php echo $form->error($model, 'company_personer', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'rec_name'); ?></td>
                <td><?php echo $model->rec_name; ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'invoice_category'); ?></td>
                <td>
                    <?php echo $form->dropDownList($model, 'invoice_category', Chtml::listData(BaseCode::model()->getCode(375), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange'=>'selectCategory(this)','disabled'=>'true')); ?>
                    <?php echo $form->error($model, 'invoice_category', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'rec_phone'); ?></td>
                <td><?php echo $model->rec_phone; ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'receipt_head'); ?></td>
                <td><?php echo $model->receipt_head; ?></td>
                <td><?php echo $form->labelEx($model, 'rec_address'); ?></td>
                <td><?php echo $model->rec_address; ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'branch_account'); ?></td>
                <td><?php echo $model->branch_account; ?></td>
                <td><?php echo $form->labelEx($model, 'registered_phone'); ?></td>
                <td><?php echo $model->registered_phone; ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'bank_account'); ?></td>
                <td><?php echo $model->bank_account; ?></td>
                <td><?php echo $form->labelEx($model, 'registered_address'); ?></td>
                <td><?php echo $model->registered_address; ?></td>
            </tr>
            <tr id="ComPer" style="display:none;">
                <td><?php echo $form->labelEx($model, 'tax_number'); ?></td>
                <td colspan="3"><?php echo $model->tax_number; ?></td>
            </tr>
        </table>
        <table class="table-title">
            <tr>
                <td>开票商品</td>
            </tr>  
        </table>
        <table>
<?php $o_data=MallSalesOrderData::model()->find('gf_invoice_id='.$model->id.' and orter_item=757'); ?>
<?php $logistics=OrderInfoLogistics::model()->find('id='.$o_data->logistics_id); ?>
            <tr>
                <td width="10%"><?php echo $form->labelEx($model, 'order_num'); ?></td>
                <td><?php echo $model->order_num;  ?></td>
                <td width="10%">订单状态</td>
                <td><?php echo $logistics->logistics_state_name; ?></td>
                <td width="10%"><?php echo $form->labelEx($model, 'main_unit'); ?></td>
                <td><?php if(!empty($model->club_list)) echo $model->club_list->club_name; ?></td>
                <td width="10%"><?php echo $form->labelEx($model, 'invoiced_amount'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'invoiced_amount', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'invoiced_amount', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td>商品信息</td>
                <td colspan="7">
                <?php if(!empty($in_data)) foreach ($in_data as $p) {
                            echo $p->product_title.'，'.$p->json_attr.'，'.$p->buy_count.'<br>';
                } ?>
                </td>
            </tr>
        </table>
        <table style="table-layout:auto;">
            <tr class="table-title">
                <td colspan="4">开票信息</td>
            </tr> 
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'invoice_number'); ?></td>
                <td colspan="3"><?php echo $form->textField($model, 'invoice_number', array('class' => 'input-text')); ?>
                     <?php echo $form->error($model, 'invoice_number', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'receipt_state'); ?></td>
                <td colspan="3"><?php if(!empty($model->state)) echo $model->state->F_NAME; ?></td>
            </tr>
            <tr id="Category" style="display:none;">
                <td width="15%"><?php echo $form->labelEx($model, 'logistics_id'); ?></td>
                <td width="35%">
                <?php echo $form->hiddenField($model, 'logistics_id', array('class' => 'input-text')); ?>
                <?php echo $form->hiddenField($model, 'logistics_name', array('class' => 'input-text')); ?>
                <span id="logistics_box"><?php if(!empty($model->logistics_name)) { ?><span class="label-box"><?php echo $model->logistics_name;?></span><?php } ?></span>
                    <input type="button" id="logistics_select_btn" class="btn" value="选择物流" /></td>
                <td width="15%"><?php echo $form->labelEx($model, 'logistics_number'); ?></td>
                <td width="35%"><?php echo $form->textField($model, 'logistics_number', array('class' => 'input-text')); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'electronics_images'); ?></td>
                <td colspan="3">
                <?php echo $form->hiddenField($model, 'electronics_images', array('class' => 'input-text fl')); ?>
            <?php $basepath=BasePath::model()->getPath(160);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
            <?php if(!empty($model->electronics_images)){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_electronics_images"><a href="<?php echo $basepath->F_WWWPATH.$model->electronics_images;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->electronics_images;?>" width="100" height="100"></a></div><?php }?>
            <script>we.uploadpic('<?php echo get_class($model);?>_electronics_images', '<?php echo $picprefix;?>');</script>
                    
                    <?php echo $form->error($model, 'electronics_images', $htmlOptions = array()); ?>
                </td>
            </tr><tr>
                <td>可执行操作</td>
                <td colspan="3">
                <?php echo show_shenhe_box(array('baocun'=>'确定'));?>
                <button class="btn" type="button" onclick="we.back();">取消</button>
                </td>
            </tr>
        </table>
        
<?php $this->endWidget();?>

  </div><!--box-detail end-->
</div><!--box end-->

<script>
selectComPer($('#InvoiceRequestList_company_personer'));
function selectComPer(obj){
    var show_type=$(obj).val();
    if(show_type==404){ 
        $('#ComPer').show();
    } else{
        $('#ComPer').hide();
    }
}
selectCategory($('#InvoiceRequestList_company_personer'));
function selectCategory(obj){
    var show_type=$(obj).val();
    if(show_type==378 || show_type==376){ 
        $('#Category').show();
    } else{
        $('#Category').hide();
    }
}
// 选择物流
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
                $('#InvoiceRequestListData_logistics_id').val($.dialog.data('logistics_id'));
                $('#InvoiceRequestListData_logistics_name').val($.dialog.data('logistics_company'));
                $('#logistics_box').html('<span class="label-box">'+$.dialog.data('logistics_company')+'</span>');
            }
        }
    });
});

</script> 