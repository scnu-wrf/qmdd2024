<?php
$txt='';
if(!isset($_REQUEST['flag'])){
        $_REQUEST['flag']='index';
}
$flag=$_REQUEST['flag'];
if($flag=='list'){
    $txt='商品下架列表》';
} elseif ($flag=='exam') {
    $txt='商品下架审核》';
} elseif ($flag=='check') {
    $txt='商品下架审核》待审核》';
} elseif ($flag=='index') {
    $txt='商品下架申请》';
}
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》商品下架》<?php echo $txt; ?><a class="nav-a">详情</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
                <table style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">方案信息</td>
                    </tr>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'supplier_id'); ?></td>
                        <td width="35%">
                            <span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->club_list->club_name;?></span><?php } ?></span>
                        </td>
                        <td width="15%"><?php echo $form->labelEx($model, 'event_code'); ?></td>
                        <td width="35%"><?php echo $model->event_code; ?></td>
                    </tr>
                    <tr> 
                        <td><?php echo $form->labelEx($model, 'event_title'); ?></td>
                        <td><?php echo $model->event_title; ?>
                        <?php echo $form->error($model, 'event_title', $htmlOptions = array()); ?>
                        </td>
                         <td><?php echo $form->labelEx($model, 'down_time'); ?></td>
                         <td><?php echo $model->down_time; ?>
                            <?php echo $form->error($model, 'down_time', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr> 
                        <td><?php echo $form->labelEx($model, 'data_sourcer_bz'); ?></td>
                        <td colspan="3"><?php echo $model->data_sourcer_bz; ?>
                        <?php echo $form->error($model, 'data_sourcer_bz', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr class="table-title">
                        <td colspan="4">下架商品信息</td>
                    </tr>   
                </table>
                <script>var oldnum=0;</script>               
                <table id="product">
                    <tr style="text-align:center;">
                        <td>销售方式</td>
                        <td>商品编号</td>
                        <td>商品名称</td>
                        <td>型号/规格</td>
                        <td>上架数量</td>
                        <td>上架库存数量</td>
                        <td>下架数量</td>
                    </tr>
                    <?php echo $form->hiddenField($model, 'product', array('class' => 'input-text')); ?>
                    <?php $num=1; if(isset($product_list)) if (is_array($product_list)) foreach ($product_list as $v) {?>
                        <tr style="text-align:center;" id="low_item_<?php echo $v->down_pricing_set_details_id; ?>">
                            <td><?php echo $v->sale_name; ?></td>
                            <td><?php echo $v->product_code; ?></td>
                            <td><?php echo $v->product_name; ?></td>
                            <td><?php echo $v->json_attr; ?></td>
                            <td><?php echo $v->up_quantity; ?></td>
                            <td><?php echo $v->up_quantity-$v->up_available_quantity; ?></td>
                            <td><?php echo $v->Inventory_quantity; ?></td>
                        </tr>
                        <script>oldnum=<?php echo $v->id ?>;</script>
                    <?php $num=$num+1; } ?>                     
               </table>
        </div><!--box-detail-bd end-->
        <div class="mt15" style="text-align:center;">
            <?php echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过')); ?>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
