
<div class="box">
    <div class="box-title c">
    <h1><i class="fa fa-table"></i>上架方案详情</h1><span class="back">
    <a class="btn" href="javascript:;" onclick="we.back();">
    <i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table class="mt15">
                	<tr class="table-title">
                    	<td colspan="4" >方案信息</td>
                    </tr>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'event_code'); ?></td>
                        <td width="35%"><?php echo $model->event_code; ?>
                        <?php echo $form->error($model, 'event_code', $htmlOptions = array()); ?>
                        </td>
                        <td width="15%"><?php echo $form->labelEx($model, 'event_title'); ?></td>
                        <td width="35%"><?php echo $form->textField($model, 'event_title', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'event_title', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'if_user_state'); ?></td>
                        <td >
                            <?php echo $form->radioButtonList($model, 'if_user_state', array(649=>'上线', 648=>'下线'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                            <?php echo $form->error($model, 'user_state_name', $htmlOptions = array()); ?>
                            <br><span class="msg">选择上线，在上下线期间内商品可显示前端；选择下线，在上下线期间内商品不显示前端</span>
                        </td>
                         <td><?php echo $form->labelEx($model, 'flash_sale'); ?></td>
                         <td>
                             <?php echo $form->radioButtonList($model, 'flash_sale', array(0=>'否', 1=>'是'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                             <?php echo $form->error($model, 'flash_sale', $htmlOptions = array()); ?>
                             <br><span class="msg">选择是，可设置时间段；选择否，不可设置时间段</span>
                         </td>
                    </tr>
                      <tr>
                         <td><?php echo $form->labelEx($model, 'star_time'); ?></td>
                         <td>
                            <?php echo $form->textField($model, 'star_time', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'star_time', $htmlOptions = array()); ?>
                            <span class="msg">上线时间一到，商品自动显示前端</span>
                         </td>
                         <td><?php echo $form->labelEx($model, 'end_time'); ?></td>
                         <td>
                             <?php echo $form->textField($model, 'end_time', array('class' => 'input-text')); ?>
                             <?php echo $form->error($model, 'end_time', $htmlOptions = array()); ?>
                             <span class="msg">下线时间一到，商品自动取消显示前端</span>
                         </td>
                    </tr>
                    <tr>
                         <td><?php echo $form->labelEx($model, 'down_time'); ?></td>
                         <td colspan="3">
                            <?php echo $form->textField($model, 'down_time', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'down_time', $htmlOptions = array()); ?>
                         </td>
                    </tr> 
                    <tr>
                        <td><?php echo $form->labelEx($model, 'supplier_id'); ?></td>
                        <td><?php echo $form->hiddenField($model, 'supplier_id', array('class' => 'input-text')); ?>
                            <span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->club_list->club_name;?></span><?php } ?></span>
                            <input id="club_select_btn" class="btn" type="button" value="选择">
                             <?php echo $form->error($model, 'supplier_id', $htmlOptions = array()); ?>
                        </td> 
                        <td>本次上架商品</td>
                        <td><input id="product_select_btn" class="btn" type="button" value="添加商品"></td>
                    </tr>                                     
                </table>
 <script>
 var oldnum=0;
 </script>               
<table class="list" id="product">
    <tr class="table-title">
        <th width="20%" style="text-align:center;">商品信息</th>
        <th width="6%" style="text-align:center;">上架数</th>
        <th width="6%" style="text-align:center;">采购价</td>
        <th width="6%" style="text-align:center;">贴牌价</th>
        <th width="6%" style="text-align:center;">市场价*</th>
        <th width="6%" style="text-align:center;">体育豆*</th>
        <th width="8%" style="text-align:center;">单件运费</th>
        <th width="15%" style="text-align:center;">操作</th>
     </tr>
 <?php echo $form->hiddenField($model, 'product', array('class' => 'input-text')); ?>
<?php $purpose_type=BaseCode::model()->getPurpose(); ?>
<?php if(isset($product_list)) if (is_array($product_list)) foreach ($product_list as $v) { ?>
 <tr>
   <td><input type="hidden" class="input-text" name="product[<?php echo $v->id;?>][id]" value="<?php echo $v->id;?>" />
   <p>商品编号：<?php echo $v->product_code; ?></p><p>商品名称：<?php echo $v->product_name; ?></p><p>型号/规格：<?php echo $v->json_attr; ?></p>
<input type="hidden" class="input-text" name="product[<?php echo $v->id;?>][product_id]" value="<?php echo $v->product_id;?>" /></td>
   <td><input type="text" style="width:80%;" class="input-text" name="product[<?php echo $v->id;?>][Inventory_quantity]" value="<?php echo $v->Inventory_quantity; ?>" /></td>
   <td><input type="text" style="width:80%;" class="input-text" name="product[<?php echo $v->id;?>][purchase_price]" value="<?php echo $v->purchase_price; ?>" /></td>
   <td><input type="text" style="width:80%;" class="input-text" name="product[<?php echo $v->id;?>][oem_price]" value="<?php echo $v->oem_price; ?>" /></td>
   <td><input type="text" style="width:80%;" class="input-text" name="product[<?php echo $v->id;?>][sale_price]" value="<?php echo $v->sale_price; ?>" /></td>
   <td><input type="text" style="width:80%;" class="input-text" name="product[<?php echo $v->id;?>][sale_bean]" value="<?php echo $v->sale_bean; ?>" /></td>
   <td><input type="text" style="width:80%;" class="input-text" name="product[<?php echo $v->id;?>][post_price]" value="<?php echo $v->post_price; ?>" /></td>     
   <td><a class="btn" href="javascript:;" onclick="fnMemberprice(<?php echo $v->id;?>);" title="会员折扣价">定价明细</a>&nbsp;<a class="btn" href="javascript:;" onclick="fnDeleteProduct(this);" title="删除"><i class="fa fa-trash-o"></i></a></td>
                     </tr> 
<script>
oldnum=<?php echo $v->id ?>;
</script>
<?php } ?>                     
               </table>
                
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <div class="mt15" style="text-align:center;">
        <?php
		 if(!empty($model->f_check)){
			$state=$model->f_check;
		} else {
			$state=721;
		}?>
            <?php if($state<>372 && $state<>371) echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));?>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>
            
<?php $this->endWidget(); ?>
  </div><!--box-detail end-->
</div><!--box end-->
<script>
we.tab('.box-detail-tab li','.box-detail-tab-item');
$(function(){
    var $start_time=$('#<?php echo get_class($model);?>_star_time');
    var $end_time=$('#<?php echo get_class($model);?>_end_time');
	var $down_time=$('#<?php echo get_class($model);?>_down_time');
	$start_time.on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
    $end_time.on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss '});});
	$down_time.on('click', function(){
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


// 选择供应商
    var $club_box=$('#club_box');
    var $ClubList_club_id=$('#MallPriceSet_supplier_id');
    $('#club_select_btn').on('click', function(){
        $.dialog.data('club_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/club");?>',{
            id:'danwei',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
           close: function () {
                //console.log($.dialog.data('club_id'));
                if($.dialog.data('club_id')>0){
                   club_id=$.dialog.data('club_id');
                    $ClubList_club_id.val($.dialog.data('club_id')).trigger('blur');
                    $club_box.html('<span class="label-box">'+$.dialog.data('club_title')+'</span>');
                }
            }
        });
    });

	//添加商品
	$MallPriceSet_product = $('#MallPriceSet_product');
	$product = $('#product');
	var num=oldnum+1;
	var html_sec='';
	 $('#product_select_btn').on('click', function(){
		 var club_id = $('#MallPriceSet_supplier_id').val();
		 var price_id = $('#MallPriceSet_mall_member_price_id').val();
		 var html_str='';
		 if (price_id>0) {
			 $.ajax({
			type: 'post',
			url: '<?php echo $this->createUrl('price_select');?>&price_id='+price_id,
			data: {price_id:price_id},
			dataType: 'json',
			success: function(data) {
                html_sec='';
				if((data.sale_id==4) || (data.sale_id==5)){
				 html_sec='<p>销售价：<input type="text" style="width:80%;" class="input-text"" name="product['+num+'][sale_price2]" /></p>';
                 html_sec=html_sec+'<p>体育豆：<input type="text" style="width:80%;" class="input-text" name="product['+num+'][sale_bean2]" /></p>';
				}
			}
			});
			
			
		} else {
			we.msg('minus','请先选择定价方案');
            return false;
		}
		if (club_id=='') {
			we.msg('minus','抱歉，系统没有获取到供应商');
            return false;
		}
		
        $.dialog.data('product_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/products");?>&club_id='+club_id,{
            id:'shangpin',
            lock:true,
            opacity:0.3,
            title:'选择上架商品',
            width:'80%',
            height:'80%',
            close: function () {
            if($.dialog.data('product_id')>0){
				html_str = html_str + '<tr>'+
				'<td><p>商品编号：'+$.dialog.data('product_code')+'</p><p>商品名称：'+$.dialog.data('product_name')
                +'</p><p>型号/规格：'+$.dialog.data('product_attr')+'</p>'+
				'<input type="hidden" class="input-text" name="product['+num+'][id]" value="null" />'+
                '<input type="hidden" class="input-text" name="product['+num+'][product_id]" value="'
                +$.dialog.data('product_id')+'" /></td>'+
				'<td><input type="text" style="width:80%;" class="input-text" name="product['+num+'][Inventory_quantity]" /></td>'+
			    '<td><input type="text" style="width:80%;" class="input-text" name="product['+num+'][purchase_price]" /></td>'+
			    '<td><input type="text" style="width:80%;" class="input-text" name="product['+num+'][oem_price]" /></td>'+
				'<td><input type="text" style="width:80%;" class="input-text" name="product['+num+'][sale_price]" /></td>'+
				'<td><input type="text" style="width:80%;" class="input-text" name="product['+num+'][sale_bean]" /></td>'+
				'<td><input type="text" style="width:80%;" class="input-text" name="product['+num+'][post_price]" /></td>'+
				'<td><a class="btn" href="javascript:;" onclick="fnDeleteProduct(this);" title="删除">'
                +'<i class="fa fa-trash-o"></i></a></td></tr>';
                 $product.append(html_str);
					 num++;
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
