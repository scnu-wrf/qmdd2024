
<?php
$txt='';
if(!isset($_REQUEST['flag'])){
        $_REQUEST['flag']='index';
}
$flag=$_REQUEST['flag'];
if($flag=='search'){
    $txt='商品上架查询》';
} elseif ($flag=='pass') {
    $txt='商品上架审核》';
} elseif ($flag=='check') {
    $txt='商品上架审核》待审核》';
} elseif ($flag=='index') {
    $txt='商品上架申请》';
} elseif ($flag=='sale') {
    $txt='上架方案列表》';
}
?>
<div class="box">
    <div class="box-title c">
      <h1>当前界面：商城》商品上架》<?php echo $txt; ?><a class="nav-a">详情</a></h1>
      <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
  </div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table class="table-title">
                    <tr>
                        <td>方案信息</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'supplier_id'); ?></td>
                        <td width="35%">
                            <span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->club_list->club_name;?></span><?php } ?></span>
                        </td>
                        <td width="15%"><?php echo $form->labelEx($model, 'star_time'); ?></td>
                        <td width="35%"><?php echo $model->star_time;?>
                            <br><span class="msg">显示开始时间到时，商品上线显示前端</span>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'event_code'); ?></td>
                        <td><?php echo $model->event_code; ?></td>
                         <td><?php echo $form->labelEx($model, 'end_time'); ?></td>
                         <td><?php echo $model->end_time;?>
                             <br><span class="msg">下线时间一到，商品自动取消显示前端</span>
                         </td>
                    </tr>
                      <tr>
                        <td><?php echo $form->labelEx($model, 'event_title'); ?></td>
                        <td><?php echo $model->event_title;?></td>
                         <td><?php echo $form->labelEx($model, 'start_sale_time'); ?></td>
                         <td><?php echo $model->start_sale_time;?>
                            <br><span class="msg">销售开始时间到时，商品方可购买</span>
                         </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'if_user_state'); ?></td>
                        <td>
                            <?php echo $form->radioButtonList($model, 'if_user_state', array(649=>'上线', 648=>'下线'), $htmlOptions = array('separator' => '', 'class' => 'input-check','disabled'=>'true', 'template' => '<span class="check">{input}{label}</span>')); ?>
                            <?php echo $form->error($model, 'user_state_name', $htmlOptions = array()); ?>
                            <br><span class="msg">选择上线，在上下线期间内商品可显示前端；选择下线，在上下线期间内商品不显示前端</span>
                        </td>
                         <td><?php echo $form->labelEx($model, 'down_time'); ?></td>
                         <td><?php echo $model->down_time;?>
                            <br><span class="msg">销售结束时间到时，商品自动下架</span>
                         </td>
                    </tr>
                    <tr class="table-title">
                        <td colspan="4">商品信息</td>
                    </tr>                                     
                </table>
            
<table id="product">
    <tr>
        <td width="20%" style="text-align:center;">商品信息</td>
        <td width="10%" style="text-align:center;">全国统一零售价</td>
        <td width="10%" style="text-align:center;">数量</td>
        <td width="10%" style="text-align:center;">销售价</td>
        <td width="10%" style="text-align:center;">运费</td>
     </tr>
<?php $a_count=0;
 if(isset($product_list)) if (is_array($product_list)) foreach ($product_list as $v) { ?>
 <tr>
   <td><p>商品编号：<?php echo $v->product_code; ?></p><p>商品货号：<?php if (!empty($v->product)) echo $v->product->supplier_code; ?></p><p>商品名称：<?php echo $v->product_name; ?></p><p>型号/规格：<?php echo $v->json_attr; ?></p></td>
   <td><?php echo $v->oem_price; ?></td>
   <td><?php echo $v->Inventory_quantity; ?></td>
   <td><?php echo $v->sale_price; ?></td>
   <td><?php echo $v->post_price; ?></td>
                     </tr> 

<?php $a_count=$a_count+$v->available_quantity; } ?>                     
</table>
          <div class="mt15">
            <table class="table-title">
                <tr>
                    <td>操作信息</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td width='15%'><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                    <td width='85%'>
                        <?php echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text' ,'value'=>'')); ?>
                        <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td width="15%">可执行操作</td>
                    <td>
                    <?php echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过')); ?>
                    <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
                <tr>
                    <td>操作记录</td>
                    <td style="padding:0;">
                        <table class="showinfo" style="margin:0;">
                            <tr>
                                <th style="width:20%;">操作时间</th>
                                <th style="width:20%;">操作人</th>
                                <th>操作备注</th>
                            </tr>
                            <tr>
                                <td><?php echo $model->update_date; ?></td>
                                <td><?php echo $model->reasons_admin_nick; ?></td>
                                <td><?php echo $model->reasons_failure; ?></td>
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
