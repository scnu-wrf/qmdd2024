
            <div style="display:none;" class="box-detail-tab-item">
                <table class="list" id="pricing_list">
                    <tr class="table-title">
                        <th width="20%">商品信息</th>
                        <th width="10%">会员类型</th>
                        <th width="10%">认证类型</th>
                        <th width="10%">会员级别ID</th>
                        <th width="10%">销售价格</th>
                        <th width="10%">体育豆</td>
                        <th width="15%">保险信息</th>
                        <th width="10%">操作</th>
                     </tr>
<script>
var p_num=0;
</script>
                     <?php echo $form->hiddenField($model, 'pricing', array('class' => 'input-text')); ?>
                     <?php if(isset($pricinglist)) if (is_array($pricinglist)) foreach ($pricinglist as $p) { ?>
                     <tr>
                       <input type="hidden" class="input-text" name="pricing[<?php echo $p->id;?>][id]" value="<?php echo $p->id;?>" />
                       <input type="hidden" class="input-text set_details_id" name="pricing[<?php echo $p->id;?>][set_details_id]" value="<?php echo $p->set_details_id;?>" />
                         <td><p>产品货号：<?php echo $p->product_data_code; ?></p><p>产品名称：<?php echo $p->product_name; ?></p><p>产品规格：<?php echo $p->json_attr; ?></p><p>上架来源：<?php echo $p->purpose_name; ?></p><p>销售方式：<?php echo $p->shop_name; ?></p><p>服务信息：<?php echo $p->service_code; ?>-<?php echo $p->service_name; ?>-<?php echo $p->service_data_name; ?></p></td>
                         <td><?php $customer_type=BaseCode::model()->getCustomer($p->customer_type); ?>
                       <select name="pricing[<?php echo $p->id;?>][customer_type]">
                         <option value="<?php echo $p->customer_type; ?>"><?php echo $p->customer_name; ?></option>
                         <?php if (is_array($customer_type)) foreach ($customer_type as $k) { ?>
                         <option value="<?php echo $k->f_id; ?>"><?php echo $k->F_NAME; ?></option>
                         <?php } ?>
                       </select></td>
                         <td><?php $gf_paytype=BaseCode::model()->getPaytype($p->gf_salesperson_paytype); ?>
                       <select name="pricing[<?php echo $p->id;?>][gf_salesperson_paytype]">
                         <option value="<?php echo $p->gf_salesperson_paytype; ?>"><?php echo $p->paytype; ?></option>
                         <?php if (is_array($gf_paytype)) foreach ($gf_paytype as $k) { ?>
                         <option value="<?php echo $k->f_id; ?>"><?php echo $k->F_NAME; ?></option>
                         <?php } ?>
                       </select></td>
                         <td><?php $level=MemberCard::model()->getLevel($p->customer_level_id); ?>
                       <select name="pricing[<?php echo $p->id;?>][customer_level_id]">
                         <option value="<?php echo $p->customer_level_id; ?>"><?php echo $p->level_name; ?></option>
                         <?php if (is_array($level)) foreach ($level as $k) { ?>
                         <option value="<?php echo $k->f_id; ?>"><?php echo $k->card_name; ?></option>
                         <?php } ?>
                       </select></td>
                         <td><input type="text" class="input-text shopping_price" name="pricing[<?php echo $p->id;?>][shopping_price]" value="<?php echo $p->shopping_price; ?>" /></td>
                         <td><input type="text" class="input-text shopping_beans" name="pricing[<?php echo $p->id;?>][shopping_beans]" value="<?php echo $p->shopping_beans; ?>" /></td>
                         <td><div id="datails_box_<?php echo $p->id;?>"></div><input type="button" id="datails_select_btn_<?php echo $p->id;?>" class="btn" value="选择保险" /></td>
                         <td><a class="btn" href="javascript:;" onclick="fnDeletePricing(this);" title="删除定价"><i class="fa fa-trash-o"></i></a>
                         <a class="btn" href="javascript:;" onclick="fnCopyPricing(this);" title="复制"><i class="fa fa-copy"></i></a></td>
                     </tr>  
<script>
p_num=<?php echo $p->id;?>;
</script> 
                     <?php } ?>                    
               </table>  
            </div><!--box-detail-tab-item end-->
 <script>
$MallPriceSet_pricing=$('#MallPriceSet_pricing');
$pricing=$('#pricing');
var fnDeletePricing=function(op){
	var pnum=0;
	var details_id=$(op).parent().parent().find('.set_details_id').val();
	$('#pricing_list').find('.set_details_id').each(function(){
		if($(this).val()==details_id){
			pnum++;
        }
	});
	if(pnum<2){
		we.msg('minus','该商品至少有一个定价方案');
        return false;
	}
	$(op).parent().parent().remove();
	fnUpdatePricing();
};
	var fnUpdatePricing=function(){
    var isEmpty=true;
    $pricing.find('.input-text').each(function(){
        if($(this).val()!=''){
            isEmpty=false;
            //return false;
        }
    });
    if(!isEmpty){
        $MallPriceSet_pricing.val('1').trigger('blur');
    }else{
        $MallPriceSet_pricing.val('').trigger('blur');
    }
 };

/////复制商品定价
p_num=p_num+1; 
var fnCopyPricing=function(op){
	var p_html='';
	var set_details_id = $(op).parent().parent().find('.set_details_id').val();
	var shopping_price = $(op).parent().parent().find('.shopping_price').val();
	var shopping_beans = $(op).parent().parent().find('.shopping_beans').val();
	var html_arr=[];
	var html_select=[];
    $(op).parent().parent().find('td').each(function(){
        html_arr.push($(this).html());
    });
	$(op).parent().parent().find('select').each(function(){
        html_select.push($(this).html());
    });
	p_html = p_html+'<tr><input type="hidden" class="input-text" name="pricing['+p_num+'][id]" value="null" /><input type="hidden" class="input-text set_details_id" name="pricing['+p_num+'][set_details_id]" value="'+set_details_id+'" /><td>'+html_arr[0]+'</td>'+
	'<td><select name="pricing['+p_num+'][customer_type]">'+html_select[0]+'</select></td>'+
	'<td><select name="pricing['+p_num+'][gf_salesperson_paytype]">'+html_select[1]+'</select></td>'+
	'<td><select name="pricing['+p_num+'][customer_level_id]">'+html_select[2]+'</select></td>'+
	'<td><input type="text" class="input-text shopping_price" name="pricing['+p_num+'][shopping_price]" value="'+shopping_price+'" /></td>'+
	'<td><input type="text" class="input-text shopping_beans" name="pricing['+p_num+'][shopping_beans]" value="'+shopping_beans+'" /></td>'+
	'<td><div id="datails_box_'+p_num+'"></div><input type="button" id="datails_select_btn_'+p_num+'" class="btn" value="选择保险" /></td>'+
	'<td><a class="btn" href="javascript:;" onclick="fnDeletePricing(this);" title="删除定价"><i class="fa fa-trash-o"></i></a><a class="btn" href="javascript:;" onclick="fnCopyPricing(this);" title="复制定价"><i class="fa fa-copy"></i></a></td></tr>';
	$('#pricing_list').append(p_html);
	p_num++;
}

 
 


</script> 

