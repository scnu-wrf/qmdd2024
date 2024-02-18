
<div class="box">
    <div class="box-title c">
    <h1><i class="fa fa-table"></i>上架方案详情</h1><span class="back">
    <a class="btn" href="javascript:;" onclick="we.back();">
    <i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
            供应商：<span id="club_box"><?php if($model->club_list!=null){?><span><?php echo $model->club_list->club_name;?></span><?php } ?></span>
                <table class="mt15">
                	<tr class="table-title">
                    	<td colspan="6" >方案信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'event_code'); ?></td>
                        <td colspan="2"><?php echo $model->event_code; ?></td>
                        <td><?php echo $form->labelEx($model, 'event_title'); ?></td>
                        <td colspan="2"><?php echo $model->event_title; ?></td>
                    </tr>
                      <tr>
                         <td><?php echo $form->labelEx($model, 'star_time'); ?></td>
                         <td colspan="2"><?php echo $model->star_time;?>
                            <br><span class="msg">上线时间一到，商品自动显示前端</span>
                         </td>
                         <td><?php echo $form->labelEx($model, 'end_time'); ?></td>
                         <td colspan="2"><?php echo $model->end_time;?>
                             <br><span class="msg">下线时间一到，商品自动取消显示前端</span>
                         </td>
                    </tr>
                    <tr>
                         <td><?php echo $form->labelEx($model, 'start_sale_time'); ?></td>
                         <td colspan="2"><?php echo $model->start_sale_time;?></td>
                         <td><?php echo $form->labelEx($model, 'down_time'); ?></td>
                         <td colspan="2"><?php echo $model->down_time;?></td>
                    </tr> 
                    <tr>
                        <td><?php echo $form->labelEx($model, 'if_user_state'); ?></td>
                        <td colspan="5">
                            <?php echo $form->radioButtonList($model, 'if_user_state', array(649=>'上线', 648=>'下线'), $htmlOptions = array('separator' => '', 'class' => 'input-check','disabled'=>'true', 'template' => '<span class="check">{input}{label}</span>')); ?>
                            <?php echo $form->error($model, 'user_state_name', $htmlOptions = array()); ?>
                            <br><span class="msg">选择上线，在上下线期间内商品可显示前端；选择下线，在上下线期间内商品不显示前端</span>
                        </td>
                    </tr>                                     
                </table>
            
<table class="list" id="product">
    <tr class="table-title">
        <th width="20%" style="text-align:center;">商品信息</th>
        <th width="10%" style="text-align:center;">数量</th>
        <th width="10%" style="text-align:center;">全国统一零售价</th>
        <th width="10%" style="text-align:center;">销售价</th>
        <th width="10%" style="text-align:center;">运费</th>
     </tr>
<?php $a_count=0;
 if(isset($product_list)) if (is_array($product_list)) foreach ($product_list as $v) { ?>
 <tr>
   <td><p>商品编号：<?php echo $v->product_code; ?></p><p>商品名称：<?php echo $v->product_name; ?></p><p>型号/规格：<?php echo $v->json_attr; ?></p></td>
   <td><?php echo $v->Inventory_quantity; ?></td>
   <td><?php echo $v->oem_price; ?></td>
   <td><?php echo $v->sale_price; ?></td>
   <td><?php echo $v->post_price; ?></td>
                     </tr> 

<?php $a_count=$a_count+$v->available_quantity; } ?>                     
               </table>
                
            </div><!--box-detail-tab-item end-->
            
        </div><!--box-detail-bd end-->
        <div class="mt15" style="text-align:center;">
          <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>
            
<?php $this->endWidget(); ?>
  </div><!--box-detail end-->
</div><!--box end-->
