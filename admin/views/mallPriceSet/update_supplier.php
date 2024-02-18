
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》商品上架》商品上架申请》<a class="nav-a">添加方案</a></h1>
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
                            <span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->club_list->club_name;?><?php echo $form->hiddenField($model, 'supplier_id', array('class' => 'input-text')); ?></span><?php } else {?><span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'supplier_id', array('class' => 'input-text', 'value'=>get_session('club_id'))); ?></span><?php } ?></span>
                        </td>
                        <td width="15%"><?php echo $form->labelEx($model, 'star_time'); ?></td>
                        <td width="35%">
                            <?php echo $form->textField($model, 'star_time', array('class' => 'input-text','style'=>'width:120px;')); ?>
                            <?php echo $form->error($model, 'star_time', $htmlOptions = array()); ?>
                            <br><span class="msg">显示开始时间到时，商品上线显示前端</span>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'event_code'); ?></td>
                        <td><?php echo $model->event_code; ?>
                        <?php echo $form->error($model, 'event_code', $htmlOptions = array()); ?>
                        </td>
                         <td><?php echo $form->labelEx($model, 'end_time'); ?></td>
                         <td>
                             <?php echo $form->textField($model, 'end_time', array('class' => 'input-text','style'=>'width:120px;')); ?>
                             <?php echo $form->error($model, 'end_time', $htmlOptions = array()); ?>
                             <br><span class="msg">下线时间一到，商品自动取消显示前端</span>
                         </td>
                    </tr>
                      <tr>
                        <td><?php echo $form->labelEx($model, 'event_title'); ?></td>
                        <td><?php echo $form->textField($model, 'event_title', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'event_title', $htmlOptions = array()); ?>
                        </td>
                         <td><?php echo $form->labelEx($model, 'start_sale_time'); ?></td>
                         <td>
                            <?php echo $form->textField($model, 'start_sale_time', array('class' => 'input-text','style'=>'width:120px;')); ?>
                            <?php echo $form->error($model, 'start_sale_time', $htmlOptions = array()); ?>
                            <br><span class="msg">销售开始时间到时，商品方可购买</span>
                         </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'if_user_state'); ?></td>
                        <td>
                            <?php echo $form->radioButtonList($model, 'if_user_state', array(649=>'上线', 648=>'下线'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                            <?php echo $form->error($model, 'user_state_name', $htmlOptions = array()); ?>
                            <br><span class="msg">选择上线，在上下线期间内商品可显示前端；选择下线，在上下线期间内商品不显示前端</span>
                        </td>
                         <td><?php echo $form->labelEx($model, 'down_time'); ?></td>
                         <td>
                            <?php echo $form->textField($model, 'down_time', array('class' => 'input-text','style'=>'width:120px;')); ?>
                            <?php echo $form->error($model, 'down_time', $htmlOptions = array()); ?>
                            <br><span class="msg">销售结束时间到时，商品自动下架</span>
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
        <td width="20%" style="text-align:center;">商品信息</td>
        <td width="10%" style="text-align:center;">全国统一零售价</td>
        <td width="10%" style="text-align:center;">上架数量</td>
        <td width="10%" style="text-align:center;">销售价</td>
        <td width="10%" style="text-align:center;">单件运费</td>
        <td width="10%" style="text-align:center;">操作</td>
     </tr>
 <?php $a_count=0;
  echo $form->hiddenField($model, 'product', array('class' => 'input-text')); ?>
<?php if(isset($product_list)) if (is_array($product_list)) foreach ($product_list as $v) { ?>
 <tr id="set_item_<?php echo $v->product_id; ?>">
   <td><input type="hidden" class="input-text" name="product[<?php echo $v->id;?>][id]" value="<?php echo $v->id;?>" />
   <p>商品编号：<?php echo $v->product_code; ?></p><p>商品货号：<?php if (!empty($v->product)) echo $v->product->supplier_code; ?></p><p>商品名称：<?php echo $v->product_name; ?></p><p>型号/规格：<?php echo $v->json_attr; ?></p>
<input type="hidden" class="input-text" name="product[<?php echo $v->id;?>][product_id]" value="<?php echo $v->product_id;?>" /></td>
   <td><input type="text" style="width:80%;" class="input-text" name="product[<?php echo $v->id;?>][oem_price]" value="<?php echo $v->oem_price; ?>" /></td>
   <td><input type="text" style="width:80%;" class="input-text" name="product[<?php echo $v->id;?>][Inventory_quantity]" value="<?php echo $v->Inventory_quantity; ?>" /></td>
   <td><input type="text" style="width:80%;" class="input-text" name="product[<?php echo $v->id;?>][sale_price]" value="<?php echo $v->sale_price; ?>" /></td>
   <td><input type="text" style="width:80%;" class="input-text" name="product[<?php echo $v->id;?>][post_price]" value="<?php echo $v->post_price; ?>" /></td>     
   <td><?php if($model->f_check<>372){ ?><a class="btn" href="javascript:;" onclick="fnDeleteProduct(this);" title="删除"><i class="fa fa-trash-o"></i></a><?php } ?></td>
                     </tr> 
<?php $a_count=$a_count+$v->available_quantity; ?> 
<script>
oldnum=<?php echo $v->id ?>;
</script>
<?php } ?>                     
</table>
            <div class="mt15">
                <table class="table-title">
                    <tr>
                        <td>操作信息</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="15%">可执行操作</td>
                        <td>
                        <?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));?>
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
we.tab('.box-detail-tab li','.box-detail-tab-item');
$(function(){
    var $start_time=$('#<?php echo get_class($model);?>_star_time');
    var $end_time=$('#<?php echo get_class($model);?>_end_time');
	var $down_time=$('#<?php echo get_class($model);?>_down_time');
    var $start_sale_time=$('#<?php echo get_class($model);?>_start_sale_time');
	$start_time.on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
    $end_time.on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss '});});
	$down_time.on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss '});});
    $start_sale_time.on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss '});});
});
//console.log($('#MallPriceSet_star_time').val());

// 查看会员价
var fnMemberprice=function(detail_id){
    $.dialog.open('<?php echo $this->createUrl("memberprice");?>&detail_id='+detail_id,{
        id:'huiyuanjia',
        lock:true,
        opacity:0.3,
        title:'会员折扣价格表',
        width:'90%',
        height:'90%',
        close: function () {}
    });
};

	//添加商品
	$MallPriceSet_product = $('#MallPriceSet_product');
	$product = $('#product');
	var num=oldnum+1;
 $('#product_select_btn').on('click', function(){
		 var club_id = $('#MallPriceSet_supplier_id').val();
		 var html_str='';
		if (club_id=='') {
			we.msg('minus','抱歉，系统没有获取到供应商');
            return false;
		}
        $.dialog.data('id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/products");?>&club_id='+club_id,{
            id:'shangpin',
            lock:true,
            opacity:0.3,
            title:'选择上架商品',
            width:'80%',
            height:'80%',
            close: function () {
                if($.dialog.data('id')==-1){
                    var boxnum=$.dialog.data('products');
                    for(var j=0;j<boxnum.length;j++) {
                        if($('#set_item_'+boxnum[j].dataset.id).length==0){
            				html_str = html_str +'<tr id="set_item_'+boxnum[j].dataset.id+'">'+
            				'<td><p>商品编号：'+boxnum[j].dataset.pcode+'</p><p>商品货号：'+boxnum[j].dataset.code+'</p><p>商品名称：'+boxnum[j].dataset.name
                            +'</p><p>型号/规格：'+boxnum[j].dataset.attr+'</p>'+
            				'<input type="hidden" class="input-text" name="product['+num+'][id]" value="null" />'+
                            '<input type="hidden" class="input-text" name="product['+num+'][product_id]" value="'
                            +boxnum[j].dataset.id+'" /></td>'+
                            '<td><input type="text" style="width:80%;" class="input-text" name="product['+num+'][oem_price]" value="'+boxnum[j].dataset.price+'" /></td>'+
            				'<td><input type="text" style="width:80%;" class="input-text" name="product['+num+'][Inventory_quantity]" /></td>'+
            				'<td><input type="text" style="width:80%;" class="input-text" name="product['+num+'][sale_price]" /></td>'+
            				'<td><input type="text" style="width:80%;" class="input-text" name="product['+num+'][post_price]" /></td>'+
            				'<td><a class="btn" href="javascript:;" onclick="fnDeleteProduct(this);" title="删除">'
                            +'<i class="fa fa-trash-o"></i></a></td></tr>';
            					 num++;
                               
                        }
                    }
                    $product.append(html_str);
                    fnUpdateProduct();
                }
            }
        });
    });
	
	var fnDeleteProduct=function(op){
    $(op).parent().parent().remove();
    };
	var fnUpdateProduct=function(){
    var isEmpty=true;
    $product.find('.input-text').each(function(){
        if($(this).val()!=''){
            isEmpty=false;
            //return false;
        }
    });
    if(!isEmpty){
        $MallPriceSet_product.val('1').trigger('blur');
    }else{
        $MallPriceSet_product.val('').trigger('blur');
    }
 };

</script> 
<script>
// 选择毛利分配方案
    var $salesperson_profit_btn=$('#salesperson_profit_btn');
     $salesperson_profit_btn.on('click', function(){
        $.dialog.data('salesperson_profit_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/salesperson_profit");?>',{
            id:'maoli',
            lock:true,
            opacity:0.3,
            title:'选择毛利分配方案',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('salesperson_profit_id')>0){
					$('#MallPriceSet_salesperson_profit_id').val($.dialog.data('salesperson_profit_id'));
                    $('#profit_box').html('<span class="label-box">'+$.dialog.data('salesperson_profit_name')+'</span>');
                }
            }
        });
    });
	// 选择定价方案
    var $member_price_btn=$('#member_price_btn');
    $member_price_btn.on('click', function(){
        $.dialog.data('member_price_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/member_price");?>',{
            id:'dingjia',
            lock:true,
            opacity:0.3,
            title:'选择定价方案',
            width:'80%',
            height:'80%',
            close: function () {
                if($.dialog.data('member_price_id')>0){
					$('#MallPriceSet_mall_member_price_id').val($.dialog.data('member_price_id'));
                    $('#price_box').html('<span class="label-box">'+$.dialog.data('member_price_name')+'</span>');
                }
            }
        });
    });
</script>
