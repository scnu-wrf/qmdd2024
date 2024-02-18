<div style="display:none;" class="box-detail-tab-item">
<script>
var post_num=0;
</script>
     <div id="post_list" style="margin-bottom:10px;">
     <?php $count_type2=BaseCode::model()->getCode(711); ?>
                     <?php echo $form->hiddenField($model, 'post_list', array('class' => 'input-text')); ?>
                     <?php if(!empty($post_list)) { if (is_array($post_list)) foreach ($post_list as $q) { ?>
                <table class="mt15">
                	<tr class="table-title">
                    	<td colspan="4" >邮费方案<input type="button" class="btn" onclick="fnDeletePostlist(this);" value="删除方案" /></td>
                    </tr>
                    <input type="hidden" class="input-text" name="post_list[<?php echo $q->id;?>][id]" value="<?php echo $q->id;?>" />
                    <tr>
                        <td width="15%">计算方式</td>
                        <?php $count_type=BaseCode::model()->getCounttype($q->type); ?>
                        <td colspan="3"><select name="post_list[<?php echo $q->id ?>][type]">
                          <option value="<?php echo $q->type; ?>"><?php echo $q->base_code->F_NAME; ?></option>
                         <?php if(!empty($count_type)) foreach ($count_type as $c) { ?> 
                          <option value="<?php echo $c->f_id; ?>"><?php echo $c->F_NAME; ?></option>
                          <?php } ?>
                        </select></td>
                    </tr> 
                    <tr>
                        <td>单件最低数量（件）</td>
                        <td><input type="text" class="input-text" name="post_list[<?php echo $q->id ?>][count_min]" value="<?php echo $q->count_min; ?>" /></td>
                        <td>单件最高数量（件）</td>
                        <td><input type="text" class="input-text" name="post_list[<?php echo $q->id ?>][count_max]" value="<?php echo $q->count_max; ?>" /></td>
                    </tr> 
                    <tr>
                        <td>单件最低总价（元）</td>
                        <td><input type="text" class="input-text" name="post_list[<?php echo $q->id ?>][price_min]" value="<?php echo $q->price_min; ?>" /></td>
                        <td>单件最高总价（元）</td>
                        <td><input type="text" class="input-text" name="post_list[<?php echo $q->id ?>][price_max]" value="<?php echo $q->price_max; ?>" /></td>
                    </tr>   
                    <tr>
                        <td>可免邮数量（件）</td>
                        <td><input type="text" class="input-text" name="post_list[<?php echo $q->id ?>][post_count]" value="<?php echo $q->post_money; ?>" /></td>
                        <td>最高邮费（元）</td>
                        <td><input type="text" class="input-text" name="post_list[<?php echo $q->id ?>][post_max]" value="<?php echo $q->post_max; ?>" /><p>商品最多邮费，超过此值按此值计算</p></td>
                    </tr>    
                    <tr>
                        <td>总邮费（元）</td>
                        <td><input type="text" class="input-text" name="post_list[<?php echo $q->id ?>][post_money]" value="<?php echo $q->post_money; ?>" /></td>
                        <td>单件邮费（元）</td>
                        <td><input type="text" class="input-text" name="post_list[<?php echo $q->id ?>][post_price]" value="<?php echo $q->post_price; ?>" /></td>
                    </tr>
                    <tr>
                        <td width="15%">物流公司</td>
                        <td colspan="3">
                        <input type="hidden" class="input-text logistics_id" name="post_list[<?php echo $q->id;?>][logistics_id]" value="<?php echo $q->logistics_id;?>" />
                        <span class="logistics_box"><?php if($q->logistics_id!=null){?><span class="label-box"><?php echo $q->logistics->f_name;?></span><?php }?></span>
                        <input type="button" id="logistics_select_btn_<?php echo $q->id ?>" class="btn" value="选择物流" /></td>
                    </tr>  
                    <tr>
                        <td width="15%">区域免邮</td>
                        <td colspan="3">
                        <?php $area_list=MallProductsPostArea::model()->findAll('post_id='.$q->id);
						$area_arr = array();
						
						  ?>
                        <input type="hidden" class="input-text" id="area_list_<?php echo $q->id;?>" name="post_list[<?php echo $q->id;?>][area_list]" />
                        <span class="area_box" id="area_box_<?php echo $q->id ?>">
                        <?php if (!empty($area_list)) if (is_array($area_list)) foreach ($area_list as $d) {?>
                        <?php $area_arr[]=$d->post_area_code; ?>
                        <span class="label-box" id="area_item_<?php echo $q->id; ?>_<?php echo $d->post_area_code; ?>"><input type="hidden" class="area_id" value="<?php echo $d->post_area_code; ?>" /><?php echo $d->t_region->region_name_c; ?><i onclick="fnDeleteArea(this);"></i></span>
                        <?php } ?>
                        </span>
                        <input type="button" id="area_select_btn_<?php echo $q->id ?>" class="btn" value="选择区域" /></td>
                    </tr>
                </table>
<script>
var area_id = we.implode(',',<?php echo json_encode($area_arr); ?>);
$('#area_list_<?php echo $q->id;?>').val(area_id);
post_num= <?php echo $q->id; ?>;
//// 选择物流
   // var $service_box=$('#service_box_'+num);
    $('#logistics_select_btn_'+post_num).on('click', function(){
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
                    $this.parent().find('.logistics_id').val($.dialog.data('logistics_id'));
					$this.parent().find('.logistics_box').html('<span class="label-box">'+$.dialog.data('logistics_company')+'</span>');
                }
            }
        });
    });
//// 添加免邮区域
   // var $service_box=$('#service_box_'+num);
    $('#area_select_btn_'+post_num).on('click', function(){
		var html_s='';
		$this=$(this);
        $.dialog.data('area_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/area");?>',{
            id:'fuwu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
				if($.dialog.data('area_id')>0){
                    if($('#area_item_<?php echo $q->id; ?>_'+$.dialog.data('area_id')).length==0){
                       $this.parent().find('.area_box').append('<span class="label-box" id="area_item_<?php echo $q->id; ?>_'+$.dialog.data('area_id')+'" data-id="'+$.dialog.data('area_id')+'"><input type="hidden" class="area_id" value="'+$.dialog.data('area_id')+'" />'+$.dialog.data('area_title')+'<i onclick="fnDeleteArea(this);"></i></span>'); 
                       fnUpdateArea(<?php echo $q->id; ?>);
                    }
                }
            }
        });
    });
fnUpdateArea(<?php echo $q->id; ?>);
</script>
                <?php } } else { ?>
                <table class="mt15">
                	<tr class="table-title">
                    	<td colspan="4" >邮费方案<input type="button" class="btn" value="删除方案" /></td>
                    </tr>
                    <input type="hidden" class="input-text" name="post_list[0][id]" value="null" />
                    <tr>
                        <td width="15%">计算方式</td>
                        <td colspan="3"><select name="post_list[0][type]">
						<?php if(!empty($count_type2)) foreach ($count_type2 as $c2) { ?> 
                          <option value="<?php echo $c2->f_id; ?>"><?php echo $c2->F_NAME; ?></option>
                          <?php } ?></select></td>
                    </tr> 
                    <tr>
                        <td>单件最低数量（件）</td>
                        <td><input type="text" class="input-text" name="post_list[0][count_min]" /></td>
                        <td>单件最高数量（件）</td>
                        <td><input type="text" class="input-text" name="post_list[0][count_max]" /></td>
                    </tr> 
                    <tr>
                        <td>单件最低总价（元）</td>
                        <td><input type="text" class="input-text" name="post_list[0][price_min]" /></td>
                        <td>单件最高总价（元）</td>
                        <td><input type="text" class="input-text" name="post_list[0][price_max]" /></td>
                    </tr>   
                    <tr>
                        <td>可免邮数量（件）</td>
                        <td><input type="text" class="input-text" name="post_list[0][post_count]" /></td>
                        <td>最高邮费（元）</td>
                        <td><input type="text" class="input-text" name="post_list[0][post_max]" /><p>商品最多邮费，超过此值按此值计算</p></td>
                    </tr>    
                    <tr>
                        <td>总邮费（元）</td>
                        <td><input type="text" class="input-text" name="post_list[0][post_money]" /></td>
                        <td>单件邮费（元）</td>
                        <td><input type="text" class="input-text" name="post_list[0][post_price]" /></td>
                    </tr>
                    <tr>
                        <td width="15%">物流公司</td>
                        <td colspan="3"><input type="hidden" class="input-text logistics_id" name="post_list[0][logistics_id]" /><span class="logistics_box"></span><input type="button" id="logistics_select_btn_new" class="btn" value="选择物流" /></td>
                    </tr>  
                    <tr>
                        <td width="15%">区域免邮</td>
                        <td colspan="3"><input type="hidden" class="input-text" id="area_list_0" name="post_list[0][area_list]" /><span class="area_box" id="area_box_0"></span><input type="button" id="area_select_btn_0" class="btn" value="选择区域" /></td>
                    </tr>
                </table>
				<?php }?>
                
   </div>
                <input type="button" class="btn" onclick="fnAddpostplan();" value="新增方案" /> 
            </div><!--box-detail-tab-item end-->
<script>
$post_list=$('#post_list');
$MallPriceSet_post_list=$('#MallPriceSet_post_list');

//新增邮费方案
var p_num=post_num+1;
var fnAddpostplan=function(){
	var post_html='';
	post_html=post_html+'<table class="mt15">'+
	'<tr class="table-title"><td colspan="4" >'+
	'邮费方案<input type="button" class="btn" onclick="fnDeletePostlist(this);" value="删除方案" /></td></tr>'+
	'<tr><td width="15%">计算方式</td><input type="hidden" class="input-text" name="post_list['+p_num+'][id]" value="null" />'+
    '<td colspan="3"><select name="post_list['+p_num+'][type]"><?php if(!empty($count_type2)) foreach ($count_type2 as $c2) { ?><option value="<?php echo $c2->f_id; ?>"><?php echo $c2->F_NAME; ?></option><?php } ?></select></td></tr>'+
    '<tr><td>单件最低数量（件）</td>'+
    '<td><input type="text" class="input-text" name="post_list['+p_num+'][count_min]" /></td>'+
    '<td>单件最高数量（件）</td>'+
    '<td><input type="text" class="input-text" name="post_list['+p_num+'][count_max]" /></td></tr>'+
    '<tr><td>单件最低总价（元）</td>'+
    '<td><input type="text" class="input-text" name="post_list['+p_num+'][price_min]" /></td>'+
    '<td>单件最高总价（元）</td>'+
    '<td><input type="text" class="input-text" name="post_list['+p_num+'][price_max]" /></td></tr>'+  
    '<tr><td>可免邮数量（件）</td>'+
    '<td><input type="text" class="input-text" name="post_list['+p_num+'][post_count]" /></td>'+
    '<td>最高邮费（元）</td>'+
    '<td><input type="text" class="input-text" name="post_list['+p_num+'][post_max]" /><p>商品最多邮费，超过此值按此值计算</p></td></tr>'+  
    '<tr><td>总邮费（元）</td>'+
    '<td><input type="text" class="input-text" name="post_list['+p_num+'][post_money]" /></td>'+
    '<td>单件邮费（元）</td>'+
    '<td><input type="text" class="input-text" name="post_list['+p_num+'][post_price]" /></td></tr>'+
    '<tr><td width="15%">物流公司</td>'+
    '<td colspan="3"><input type="hidden" class="input-text logistics_id" name="post_list['+p_num+'][logistics_id]" /><span class="logistics_box"></span><input type="button" id="logistics_select_btn_'+p_num+'" class="btn" value="选择物流" /></td></tr>'+  
    '<tr><td width="15%">区域免邮</td>'+
    '<td colspan="3"><input type="hidden" class="input-text" id="area_list_'+p_num+'" name="post_list['+p_num+'][area_list]" /><span class="area_box" id="area_box_'+p_num+'"></span><input type="button" id="area_select_btn_'+p_num+'" class="btn" value="选择区域" /></td></tr>'+
    '</table>';
	$('#post_list').append(post_html);
	//// 选择物流(新增)
    $('#logistics_select_btn_'+p_num).on('click', function(){
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
                    $this.parent().find('.logistics_id').val($.dialog.data('logistics_id'));
					$this.parent().find('.logistics_box').html('<span class="label-box">'+$.dialog.data('logistics_company')+'</span>');
                }
            }
        });
    });
//// 添加免邮区域(新增)
    $('#area_select_btn_'+p_num).on('click', function(){
		$this=$(this);
        $.dialog.data('area_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/area");?>',{
            id:'fuwu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
				if($.dialog.data('area_id')>0){
                    if($('#area_item_'+p_num+'_'+$.dialog.data('area_id')).length==0){
                       $this.parent().find('.area_box').append('<span class="label-box" id="area_item_'+p_num+'_'+$.dialog.data('area_id')+'" data-id="'+$.dialog.data('area_id')+'"><input type="hidden" class="area_id" value="'+$.dialog.data('area_id')+'" />'+$.dialog.data('area_title')+'<i onclick="fnDeleteArea(this);"></i></span>');
                       fnUpdateArea_new($this);
                    }
                }
            }
        });
    });
	
//fnUpdateArea(p_num);
p_num++;
	
}

//// new选择物流
    $('#logistics_select_btn_new').on('click', function(){
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
                    $this.parent().find('.logistics_id').val($.dialog.data('logistics_id'));
					$this.parent().find('.logistics_box').html('<span class="label-box">'+$.dialog.data('logistics_company')+'</span>');
                }
            }
        });
    });
//// new添加免邮区域
    $('#area_select_btn_0').on('click', function(){		
		$this=$(this);
        $.dialog.data('area_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/area");?>',{
            id:'fuwu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
				if($.dialog.data('area_id')>0){
                    if($('#area_item_0_'+$.dialog.data('area_id')).length==0){
                       $this.parent().find('.area_box').append('<span class="label-box" id="area_item_0_'+$.dialog.data('area_id')+'" data-id="'+$.dialog.data('area_id')+'"><input type="hidden" class="area_id" value="'+$.dialog.data('area_id')+'" />'+$.dialog.data('area_title')+'<i onclick="fnDeleteArea(this);"></i></span>');
                       fnUpdateArea(0); 
                    }
                }
            }
        });
    });
//fnUpdateArea(0);

var fnDeletePostlist=function(op){
    $(op).parent().parent().remove();
    };
	var fnUpdatePostlist=function(){
    var isEmpty=true;
    $post_list.find('.input-text').each(function(){
        if($(this).val()!=''){
            isEmpty=false;
            //return false;
        }
    });
    if(!isEmpty){
        $MallPriceSet_post_list.val('1').trigger('blur');
    }else{
        $MallPriceSet_post_list.val('').trigger('blur');
    }
 };
 
 // 免邮区域添加或删除时，更新（赋值）
var fnUpdateArea=function(r_num){
    var arr=[];	
    $('#area_box_'+r_num).find('.area_id').each(function(){
        arr.push($(this).attr('value'));
    });
	var area_v = we.implode(',',arr);
	//console.log(area_v);
    $('#area_list_'+r_num).val(area_v);
};
//新增邮费方案-免邮区域赋值
var fnUpdateArea_new=function(op){
    var arr=[];	
	$this=$(op).parent().find('.area_box');
	$input_value=$(op).parent().find('.input-text');
    $this.find('.area_id').each(function(){
        arr.push($(this).attr('value'));
    });
	var area_v = we.implode(',',arr);
    $input_value.val(area_v);
};
 
 	// 删除已添加区域
var fnDeleteArea=function(op){
    $(op).parent().remove();
    fnUpdateArea();
};
 	// 删除邮费方案
var fnDeletePostlist=function(op){
    $(op).parent().parent().parent().remove();
    fnUpdateArea();
};
</script>