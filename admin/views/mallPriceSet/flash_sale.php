<div class="box">
  <div class="box-content">
    <div class="box-table">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>  
    <div style="margin-bottom:5px;"><a class="btn" href="javascript:;" onclick="fnAddLine();" title="添加时段">添加时段</a></div>
      <table class="list" id="flash_list">
        <thead>
          <tr>
            <th width="10%">商品编码</th>
            <th width="15%">商品名称</th>
            <th width="15%">显示时间</th>
            <th width="15%">抢购时间</th>
            <th width="15%">抢购截止</th>
            <th width="8%">抢购数量</th>
            <th width="5%">操作</th>
          </tr>
        </thead>
<script>
var o_num=0;
</script>
        <tbody>
        <?php echo $form->hiddenField($model, 'flash_s', array('class' => 'input-text')); ?>
<?php foreach($detail_o as $v){ ?>
          <tr>
            <td><input type="hidden" name="flash_s[<?php echo $v->id;?>][id]" value="<?php echo $v->id;?>" />
            <input type="hidden" name="flash_s[<?php echo $v->id;?>][product_id]" value="<?php echo $v->product_id;?>" /><?php echo $v->product_code; ?></td>
            <td><?php echo $v->product_name; ?></td>
            <td><?php echo $v->star_time; ?>-<br><?php echo $v->end_time; ?>
              <input type="hidden" name="flash_s[<?php echo $v->id;?>][star_time]" value="<?php echo $v->star_time; ?>" />
              <input type="hidden" name="flash_s[<?php echo $v->id;?>][end_time]" value="<?php echo $v->end_time; ?>" />
            </td>
            <td><input type="text" style="width:80%;" class="input-text" name="flash_s[<?php echo $v->id;?>][start_sale_time]" value="<?php echo $v->start_sale_time; ?>" onclick="fnSetTime(this);" /></td>
            <td><input type="text" style="width:80%;" class="input-text" name="flash_s[<?php echo $v->id;?>][down_time]" value="<?php echo $v->down_time; ?>" onclick="fnSetTime(this);" /></td>
            <td><input type="text" style="width:80%;" class="input-text" name="flash_s[<?php echo $v->id;?>][Inventory_quantity]" oninput="maxOnchang(this)" onpropertychange="maxOnchang(this)" value="<?php echo $v->Inventory_quantity; ?>" /></td>
            <td><a class="btn" href="javascript:;" onclick="fnDeleteFlash(this);" title="删除"><i class="fa fa-trash-o"></i></a></td>
          </tr>
<script>
var o_num=<?php echo $v->id;?>;
</script>
<?php } ?>
        </tbody>
      </table>
      <div class="box-detail-submit"><!--button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button--><?php if($model->f_check<>372 && $model->f_check<>371) echo show_shenhe_box(array('baocun'=>'保存'));?></div>
        <?php $this->endWidget(); ?>
    </div><!--box-table end--> 
  </div><!--box-content end-->
</div><!--box end-->
<script>

var fnSetTime=function(op){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss '});
}
var fnDeleteFlash=function(op){
    $(op).parent().parent().remove();
};
var f_num=o_num+1;
function fnAddLine(){
	var l_html='';
	l_html='<tr><td>'+
 '<input type="hidden" name="flash_s['+f_num+'][id]" value="null" />'+
 '<input type="hidden" name="flash_s['+f_num+'][product_id]" value="<?php echo $detail->product_id;?>" /><?php echo $detail->product_code; ?></td>'+
 '<td><?php echo $detail->product_name; ?></td>'+
 '<td><input type="hidden" name="flash_s['+f_num+'][star_time]" value="<?php echo $detail->star_time;?>" /><input type="hidden" name="flash_s['+f_num+'][end_time]" value="<?php echo $detail->end_time;?>" /><?php echo $detail->star_time; ?>-<br><?php echo $detail->end_time; ?></td>'+
 '<td><input type="text" style="width:80%;" class="input-text" name="flash_s['+f_num+'][start_sale_time]" value="" onclick="fnSetTime(this);" /></td>'+
 '<td><input type="text" style="width:80%;" class="input-text" name="flash_s['+f_num+'][down_time]" value="" onclick="fnSetTime(this);" /></td>'+
 '<td><input type="text" style="width:80%;" class="input-text" name="flash_s['+f_num+'][Inventory_quantity]"  oninput="maxOnchang(this)" onpropertychange="maxOnchang(this)" value="" /></td>'+
 '<td><a class="btn" href="javascript:;" onclick="fnDeleteFlash(this);" title="删除"><i class="fa fa-trash-o"></i></a></td></tr>';
   $('#flash_list').append(l_html);
	$('#star_time_'+f_num).on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
    $('#end_time_'+f_num).on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss '});});
	 f_num++;
	
}

//商家优惠金额改变函数
function maxOnchang(obj){ 
  var changval=$(obj).val();
  var maxc=<?php echo $detail->Inventory_quantity; ?>;
  //console.log('1=='+discount);
  if(changval>maxc){
	  $(obj).val(0);
	  we.msg('minus','抢购数量不能大于上架数量');
      return false;
  }
}
</script>