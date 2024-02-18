
<div class="box">
  <div class="box-title c">
    <h1><i class="fa fa-table"></i>上架方案详情</h1>
    <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
  </div><!--box-title end-->
  <div class="box-detail">
  <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
    <div class="box-detail-bd">
      <div style="display:block;" class="box-detail-tab-item">
        <table class="table-title">
          <tr>
              <td>方案信息</td>
          </tr>
        </table>
        <table>
          <tr>
            <td width="15%"><?php echo $form->labelEx($model, 'event_code'); ?></td>
            <td width="35%"><?php echo $model->event_code; ?>
            <?php echo $form->error($model, 'event_code', $htmlOptions = array()); ?>
            </td>
            <td width="15%"><?php echo $form->labelEx($model, 'event_title'); ?></td>
            <td width="35%"><?php echo $model->event_title; ?>
                <?php echo $form->error($model, 'event_title', $htmlOptions = array()); ?>
            </td>
          </tr>
          <tr>
            <td><?php echo $form->labelEx($model, 'star_time'); ?></td>
            <td><?php echo $model->star_time; ?>
              <?php echo $form->error($model, 'star_time', $htmlOptions = array()); ?>
              <br><span class="msg">上线显示时间到时，商品上线显示前端</span>
            </td>
            <td><?php echo $form->labelEx($model, 'end_time'); ?></td>
            <td><?php echo $model->end_time; ?>
              <?php echo $form->error($model, 'end_time', $htmlOptions = array()); ?>
              <br><span class="msg">下线时间到时，商品下线，前端取消显示</span>
             </td>
          </tr>
          <tr>
            <td><?php echo $form->labelEx($model, 'start_sale_time'); ?></td>
            <td><?php echo $model->start_sale_time; ?>
                <?php echo $form->error($model, 'start_sale_time', $htmlOptions = array()); ?>
                 <br><span class="msg">销售时间到时，商品方可购买</span>
            </td>
            <td><?php echo $form->labelEx($model, 'down_time'); ?></td>
            <td><?php echo $model->down_time; ?>
                <?php echo $form->error($model, 'down_time', $htmlOptions = array()); ?>
                <br><span class="msg">方案下架时间到时，商品自动下架</span>
            </td>
          </tr>
          <tr>
            <td><?php echo $form->labelEx($model, 'if_user_state'); ?></td>
            <td colspan="3">
                <?php echo $form->radioButtonList($model, 'if_user_state', array(649=>'上线', 648=>'下线'), $htmlOptions = array('separator' => '', 'class' => 'input-check','disabled'=>'true', 'template' => '<span class="check">{input}{label}</span>')); ?>
                <?php echo $form->error($model, 'user_state_name', $htmlOptions = array()); ?>
            </td>
          </tr>
          <tr>
            <td><?php echo $form->labelEx($model, 'supplier_id'); ?></td>
            <td><span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->club_list->club_name;?><?php echo $form->hiddenField($model, 'supplier_id', array('class' => 'input-text')); ?></span><?php } ?>
            </td> 
            <td><?php echo $form->labelEx($model, 'mall_member_price_id'); ?></td>
            <td><?php echo $form->hiddenField($model, 'mall_member_price_id', array('class' => 'input-text')); ?>
                <span id="price_box"><?php if($model->member_price!=null){?><span class="label-box"><?php echo $model->member_price->f_name;?></span><?php } ?></span>
                 <?php echo $form->error($model, 'mall_member_price_id', $htmlOptions = array()); ?>
            </td>                    
          </tr>
          <tr class="table-title">
            <td colspan="4">商品信息
                <input id="product_select_btn" class="btn" type="button" value="添加商品">
            </td>
          </tr>                                      
        </table>
<script>
var oldnum=0;
</script>               
<table id="product">
  <tr>
    <td width="18%" style="text-align:center;">商品信息</td>
    <td width="16%" style="text-align:center;">销售方式</td>
    <td width="8%" style="text-align:center;">全国统一零售价(元)</td>
    <td width="8%" style="text-align:center;">上架数量</td>
    <td width="8%" style="text-align:center;">销售单价(元)</td>
    <td width="8%" style="text-align:center;">体育豆(个)</td>
    <td width="8%" style="text-align:center;">单件运费(元)</td>
    <td width="15%" style="text-align:center;">操作</td>
  </tr>
  <?php echo $form->hiddenField($model, 'product', array('class' => 'input-text')); ?>
  <?php if(isset($product_list)) if (is_array($product_list)) foreach ($product_list as $v) { ?>
  <tr id="set_item_<?php echo $v->product_id; ?>">
  <td><input type="hidden" class="input-text" name="product[<?php echo $v->id;?>][id]" value="<?php echo $v->id;?>" />
  <p>商品编号：<?php echo $v->product_code; ?></p><p>商品货号：<?php if (!empty($v->product)) echo $v->product->supplier_code; ?></p><p>商品名称：<?php echo $v->product_name; ?></p><p>型号/规格：<?php echo $v->json_attr; ?></p>
  <input type="hidden" class="input-text" name="product[<?php echo $v->id;?>][product_id]" value="<?php echo $v->product_id;?>" /></td>
  <td><?php echo $v->sale_name; ?></td>
  <td><?php echo $v->oem_price; ?></td>
  <td><?php echo $v->Inventory_quantity; ?></td>
  <td><?php echo $v->sale_price; ?></td>
  <td><?php echo $v->sale_bean; ?></td>
  <td><?php echo $v->post_price; ?></td>     
  <td><a class="btn" href="javascript:;" onclick="fnMemberprice(<?php echo $v->id;?>);" title="定价明细">定价明细</a>&nbsp;<?php if($v->sale_id==6) { ?><a class="btn" href="javascript:;" onclick="fnFlashsale(<?php echo $v->id;?>);" title="抢购设置">限时抢购</a><?php } ?></td>
                 </tr> 
<script>
oldnum=<?php echo $v->id ?>;
</script>
<?php } ?>                     
</table>
      </div><!--box-detail-tab-item end-->
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
<script>

// 查看定价明细
var fnMemberprice=function(detail_id){
    $.dialog.open('<?php echo $this->createUrl("memberprice");?>&detail_id='+detail_id,{
        id:'huiyuanjia',
        lock:true,
        opacity:0.3,
        title:'定价明细',
        width:'98%',
        height:'98%',
        close: function () {}
    });
};

// 限时抢购设置
var fnFlashsale=function(detail_id){
    $.dialog.open('<?php echo $this->createUrl("flash_sale",array('id'=>$model->id));?>&detail_id='+detail_id,{
        id:'xianshiqiang',
        lock:true,
        opacity:0.3,
        title:'限时抢购设置',
        width:'90%',
        height:'90%',
        close: function () {}
    });
};

</script> 
