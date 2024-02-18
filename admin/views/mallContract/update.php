
<div class="box">
    <div class="box-title c">
    <h1><i class="fa fa-table"></i>合同详情</h1><span class="back">
    <a class="btn" href="javascript:;" onclick="we.back();">
    <i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
                <table>
                	<tr class="table-title">
                    	<td colspan="6" >合同信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'c_code'); ?></td>
                        <td colspan="2"><?php echo $model->c_code; ?>
                        <?php echo $form->error($model, 'c_code', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'c_title'); ?></td>
                        <td colspan="2"><?php echo $form->textField($model, 'c_title', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'c_title', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'c_no'); ?></td>
                        <td colspan="2"><?php echo $form->textField($model, 'c_no', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'c_no', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'supplier_id'); ?></td>
                        <td colspan="2"><?php echo $form->hiddenField($model, 'supplier_id', array('class' => 'input-text')); ?>
                            <span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->club_list->club_name;?></span><?php } ?></span>
                            <input id="club_select_btn" class="btn" type="button" value="选择">
                             <?php echo $form->error($model, 'supplier_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                      <tr>
                         <td><?php echo $form->labelEx($model, 'star_time'); ?></td>
                         <td colspan="2">
                            <?php echo $form->textField($model, 'star_time', array('class' => 'input-text','style'=>'width:120px;')); ?>
                            <?php echo $form->error($model, 'star_time', $htmlOptions = array()); ?>
                         </td>
                         <td><?php echo $form->labelEx($model, 'end_time'); ?></td>
                         <td colspan="2">
                             <?php echo $form->textField($model, 'end_time', array('class' => 'input-text','style'=>'width:120px;')); ?>
                             <?php echo $form->error($model, 'end_time', $htmlOptions = array()); ?>
                         </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'data_sourcer_bz'); ?></td>
                        <td colspan="5"><?php echo $form->textField($model, 'data_sourcer_bz', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'data_sourcer_bz', $htmlOptions = array()); ?>
                        </td>
                    </tr>  
                    <tr>
                        <td colspan="6"><input id="product_select_btn" class="btn" type="button" value="添加商品"></td>
                    </tr>                                     
                </table>
 <script>
 var oldnum=0;
 </script>               
<table class="list" id="product">
    <tr class="table-title">
        <th width="10%" style="text-align:center;">商品编号</th>
        <th width="20%" style="text-align:center;">商品名称</th>
        <th width="10%" style="text-align:center;">型号/规格</th>
        <th width="10%" style="text-align:center;">采购单价</th>
        <th width="10%" style="text-align:center;">采购数量</th>
        <th width="10%" style="text-align:center;">操作</th>
     </tr>
 <?php echo $form->hiddenField($model, 'product', array('class' => 'input-text')); ?>
<?php if(isset($product_list)) if (is_array($product_list)) foreach ($product_list as $v) { ?>
 <tr id="set_item_<?php echo $v->product_id; ?>">
   <td><input type="hidden" class="input-text" name="product[<?php echo $v->id;?>][id]" value="<?php echo $v->id;?>" /><?php echo $v->product_code; ?>
<input type="hidden" class="input-text" name="product[<?php echo $v->id;?>][product_id]" value="<?php echo $v->product_id;?>" /></td>
   <td><?php echo $v->product_name; ?></td>
   <td><?php echo $v->json_attr; ?></td>
   <td><input type="text" style="width:80%;" class="input-text" name="product[<?php echo $v->id;?>][purchase_price]" value="<?php echo $v->purchase_price; ?>" /></td>
   <td><input type="text" style="width:80%;" class="input-text" name="product[<?php echo $v->id;?>][purchase_quantity]" value="<?php echo $v->purchase_quantity; ?>" /></td>   
   <td><a class="btn" href="javascript:;" onclick="fnDeleteProduct(this);" title="删除"><i class="fa fa-trash-o"></i></a></td>
                     </tr> 
<script>
oldnum=<?php echo $v->id ?>;
</script>
<?php } ?>                     
               </table>
        </div><!--box-detail-bd end-->
        <div class="mt15" style="text-align:center;">
        <?php
		 if(!empty($model->f_check)){
			$state=$model->f_check;
		} else {
			$state=721;
		}?>
            <?php //if($state<>372 && $state<>371) 
			 echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));?>
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
	$start_time.on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
    $end_time.on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss '});});
});
//console.log($('#MallContract_star_time').val());



	//添加商品
	$MallContract_product = $('#MallContract_product');
	$product = $('#product');
	var num=oldnum+1;
	var html_sec='';
	 $('#product_select_btn').on('click', function(){
		 var club_id = $('#MallContract_supplier_id').val();
		 var html_str='';
		if (club_id=='') {
			we.msg('minus','抱歉，系统没有获取到供应商');
            return false;
		}
        $.dialog.data('product_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/products");?>&club_id='+club_id,{
            id:'shangpin',
            lock:true,
            opacity:0.3,
            title:'选择采购商品',
            width:'80%',
            height:'80%',
            close: function () {
                if($.dialog.data('id')==-1){
                    var boxnum=$.dialog.data('products');
                    for(var j=0;j<boxnum.length;j++) {
                        if($('#set_item_'+boxnum[j].dataset.id).length==0){
                            html_str = html_str +'<tr id="set_item_'+boxnum[j].dataset.id+'">'+
                            '<td>'+boxnum[j].dataset.code+
                            '<input type="hidden" class="input-text" name="product['+num+'][id]" value="null" />'+
                            '<input type="hidden" class="input-text" name="product['+num+'][product_id]" value="'
                            +boxnum[j].dataset.id+'" /></td>'+
                            '<td>'+boxnum[j].dataset.name+'</td>'+
                            '<td>'+boxnum[j].dataset.attr+'</td>'+
                            '<td><input type="text" style="width:80%;" class="input-text" name="product['+num+'][purchase_price]" /></td>'+
                            '<td><input type="text" style="width:80%;" class="input-text" name="product['+num+'][purchase_quantity]" /></td>'+
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
        $MallContract_product.val('1').trigger('blur');
    }else{
        $MallContract_product.val('').trigger('blur');
    }
 };
// 选择供应商
    var $club_box=$('#club_box');
    var $ClubList_club_id=$('#MallContract_supplier_id');
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
</script> 

