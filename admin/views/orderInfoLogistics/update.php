   <?php
   if (!isset($_REQUEST['gfid'])){
    $_REQUEST['gfid']=0;
    }
	if (!isset($_REQUEST['club_id'])){
    $_REQUEST['club_id']=0;
    }
	?>
   <div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》收/发货管理》发货列表》<a class="nav-a">发货</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
        <input type="hidden" name="gfid" value="<?php echo $_REQUEST["gfid"];?>">
        <input type="hidden" name="club_id" value="<?php echo $_REQUEST["club_id"];?>">
            <table class="table-title">
                <tr>
                    <td>基本信息</td>  
                </tr>
            </table>
            <table>
                <?php 
                $rec_name='';
                $rec_address='';
                $rec_phone='';
                if((empty($model->rec_name) || empty($model->rec_address) || empty($model->rec_phone)) && !empty($rec_data)) {
                    $rec_name=$rec_data->rec_name;
                    $rec_address=$rec_data->rec_address;
                    $rec_phone=$rec_data->rec_phone;
                } else {
                    $rec_name=$model->rec_name;
                    $rec_address=$model->rec_address;
                    $rec_phone=$model->rec_phone;
                }
                ?>
                <tr>
                	<td width="8%"><?php echo $form->labelEx($model, 'logistics_xh'); ?></td>
                    <td><?php echo $model->logistics_xh; ?></td>
                    <td width="8%"><?php echo $form->labelEx($model, 'logistics_id'); ?></td>
                    <td>
                    <?php echo $form->hiddenField($model, 'logistics_id', array('class' => 'input-text')); ?>
                    <span id="logistics_box"><?php if($model->logistics!=null){?><span class="label-box"><?php echo $model->logistics->f_name;?></span><?php }?></span>
                        <input type="button" id="logistics_select_btn" class="btn" value="选择物流" />
                        <?php echo $form->error($model, 'logistics_id', $htmlOptions = array()); ?>
                    </td>
                    <td width="8%"><?php echo $form->labelEx($model, 'rec_name'); ?></td>
                    <td><?php echo $form->textField($model, 'rec_name', array('class' => 'input-text','value'=>$rec_name)); ?></td>
                    
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'supplier'); ?></td>
                    <td><span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->supplier_name;?><?php echo $form->hiddenField($model, 'supplier', array('class' => 'input-text')); ?></span><?php } else {?><span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'supplier', array('class' => 'input-text','value'=>get_session('club_id'))); ?></span><?php } ?></span>
                    <?php echo $form->error($model, 'supplier', $htmlOptions = array()); ?></td>
                	<td><?php echo $form->labelEx($model, 'logistics_number'); ?></td>
                    <td><?php echo $form->textField($model, 'logistics_number', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'logistics_number', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'rec_phone'); ?></td>
                    <td><?php echo $form->textField($model, 'rec_phone', array('class' => 'input-text','value'=>$rec_phone)); ?></td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'logistics_date'); ?></td>
                    <td><?php echo $model->logistics_date; ?></td>
                    <td><?php echo $form->labelEx($model, 'logistica_price'); ?></td>
                    <td><?php echo $form->textField($model, 'logistica_price', array('class' => 'input-text')); ?></td>
                    <td><?php echo $form->labelEx($model, 'rec_address'); ?></td>
                    <td><?php echo $form->textField($model, 'rec_address', array('class' => 'input-text','value'=>$rec_address)); ?></td>
            </table>
            <div class="mt15">
            <table width="100%">
                <tr  class="table-title">
                    <td colspan="9">商品信息<input type="button" id="ordernum_add_btn" class="btn" value="选择发货商品" />&nbsp;<button class="btn" type="button" onclick="printpage();">打印商品信息</button></td>  
                </tr>
                <tr id="t0">
                    <td width="10%">订单编号</td>
                    <td width="10%">商品货号</td>
                    <td width="10%">商品编号</td>
                    <td width="10%">商品信息</td>
                    <td width="10%">收货人</td>
                    <td width="20%">收货地址</td>
                    <td width="15%">联系电话</td>
                    <td width="10%">买家留言</td>
                    <td width="5%">选择发货&nbsp;<input id="j-checkall" class="input-check" type="checkbox" value="全选"><span style="display:none;"><a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="add_chose();">全选</a></span></td>
                </tr>
            </table>
        <?php echo $form->hiddenField($model, 'orderdata', array('class' => 'input-text',)); ?>
        <?php echo $form->error($model, 'orderdata', $htmlOptions = array()); ?>
            <table id="orderdata_list" width="100%">
                <?php if(!empty($order_data)) foreach($order_data as $v){?>
                <tr id="line<?php echo $v->id; ?>" data-id="<?php echo $v->id; ?>">
                    <?php $order=MallSalesOrderInfo::model()->find('id='.$v->info_id); ?>
                    <td><?php echo $v->order_num; ?></td>
                    <td><?php echo $v->supplier_code; ?></td>
                    <td><?php echo $v->product_code; ?></td>
                    <td><?php echo $v->product_title; ?>,<?php echo $v->json_attr; ?>,<?php echo $v->buy_count; ?></td>
                    <td><?php echo $order['rec_name']; ?></td>
                    <td><?php echo $order['rec_address']; ?></td>
                    <td><?php echo $order['rec_phone']; ?></td>
                    <td><?php echo $v->leaving_a_message; ?></td>
                    <td class="check check-item"><input class="input-check" name="orderdata" onChange="fnUpdateData();" checked type="checkbox" value="<?php echo $v->id; ?>"></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <?php
         if(!empty($model->logistics_state)){
            $state=$model->logistics_state;
        } else {
            $state=472;
        }?>
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
                        <?php if($state==472){?>
                        <button onclick="submitType='fahuo'" class="btn btn-blue" type="submit">确认发货</button>
                    <?php } ?>
                    <?php if($state==473){?>
                        <?php echo show_shenhe_box(array('baocun'=>'修改'));?>
                        <button onclick="submitType='qianshou'" class="btn btn-blue" type="submit">确认已签收</button>
                    <?php } ?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
<?php if($model->id>0){ ?>
                <tr>
                    <td>操作记录</td>
                    <td style="padding:0;">
                        <table class="showinfo" style="margin:0;">
                            <tr>
                                <th style="width:20%;">操作人</th>
                                <th style="width:20%;">操作时间</th>
                                <th>操作内容</th>
                            </tr>
                            <tr>
                                <td><?php echo $model->admin_nick; ?></td>
                                <td><?php echo $model->USERNAME_DATE; ?></td>
                                <td><?php echo $model->reasons_failure; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
<?php } ?>
            </table>
        </div>
        </div><!--box-detail-bd end-->
        
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
// 删除已添加商品
var fnDeleteData=function(op){
    $(op).parent().parent().remove();
    fnUpdateData();
};
// 商品添加或删除时，更新
function fnUpdateData(){
    obj = document.getElementsByName("orderdata");
    check_val = [];
    for(k in obj){
        if(obj[k].checked)
            check_val.push(obj[k].value);
    }
    $('#OrderInfoLogistics_orderdata').val(we.implode(',',check_val));
}

<?php
   if (!empty($model->id)){
        $id=$model->id;
    } else{
        $id=0;
    }
?>
var id=<?php echo $id; ?>;
show_spmc(<?php echo $id; ?>,<?php echo $_REQUEST['gfid']; ?>,<?php echo $_REQUEST['club_id']; ?>);
fnUpdateData();
//// 添加商品
    $('#ordernum_add_btn').on('click', function(){
		var club_id=$('#OrderInfoLogistics_supplier').val();
		if (club_id=='') {
			we.msg('minus','抱歉，系统没有获取到供应商');
            return false;
		}
	    $.dialog.data('orderdata_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/orderdata");?>&club_id='+club_id,{
            id:'dingdan',
            lock:true,
            opacity:0.3,
            title:'选择发货商品',
            width:'98%',
            height:'98%',
            close: function () {                
                if($.dialog.data('orderdata_id')>0 && $.dialog.data('gfid')>0){
					show_spmc(id,$.dialog.data('gfid'),club_id);	
                }
            }
        });
    });
    function show_spmc(id,gfid,club_id){
            var d_html='';
                    $.ajax({
                        type: 'post',
                        url: '<?php echo $this->createUrl('alldata');?>&id='+id+'&gfid='+gfid+'&club_id='+club_id,
                        data: {id:id,gfid:gfid,club_id:club_id},
                        dataType: 'json',
                        success: function(data) {
                            if(data!=''){
                                 show_spmcing(data);
                              }/*else{
                                we.msg('minus', '没有获取到该用户购买的商品');
                            }*/
                        }
                    }); 

    }

     function show_spmcing(data){
            var d_html='';
            user_num = data.length;
            for(var i=0;i<user_num;i++) {
                d_html=d_html+'<tr id="line'+data[i]['orderdata_id']+'" data-id="'+data[i]['orderdata_id']+'"><td>'+data[i]['order_num']+'</td>'+
                '<td>'+data[i]['supplier_code']+'</td>'+
				'<td>'+data[i]['product_code']+'</td>'+
                '<td>'+data[i]['product_title']+'，'+data[i]['json_attr']+'，'+data[i]['buy_count']+'</td>'+
                '<td>'+data[i]['rec_name']+'</td>'+
                '<td>'+data[i]['rec_address']+'</td>'+
                '<td>'+data[i]['rec_phone']+'</td>'+
                '<td>'+data[i]['message']+'</td>'+
                '<td class="check check-item"><input class="input-check" name="orderdata" onChange="fnUpdateData();" checked type="checkbox" value="'+data[i]['orderdata_id']+'"></td></tr>';
            }
            $('#orderdata_list').html(d_html);
            var $this, $temp1 = $('.check-item .input-check'), $temp2 = $('.box-table .list tbody tr');

        $('#j-checkall').on('click', function() {
            $this = $(this);
            if ($this.is(':checked')) {
                $temp1.each(function() {
                    if(this.disabled!=true){
                        this.checked = true;
                    }
                });
                $temp2.addClass('selected');
            } else {
                $temp1.each(function() {
                    this.checked = false;
                });
                $temp2.removeClass('selected');
            }
            we.hasDelete('.check-item .input-check:checked', '#j-delete');
        });
            fnUpdateData(); 
			$('#OrderInfoLogistics_rec_name').val(data[0]['rec_name']);
			$('#OrderInfoLogistics_rec_address').val(data[0]['rec_address']);
			$('#OrderInfoLogistics_rec_phone').val(data[0]['rec_phone']);   
    }
//// 选择物流
    $('#logistics_select_btn').on('click', function(){
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
                    $('#OrderInfoLogistics_logistics_id').val($.dialog.data('logistics_id'));
					$('#logistics_box').html('<span class="label-box">'+$.dialog.data('logistics_company')+'</span>');
                }
            }
        });
    });
function printpage(){
    var orderdata=$('#OrderInfoLogistics_orderdata').val();
    $.ajax({
        type: 'post',
        url: '<?php echo $this->createUrl('searchdata');?>',
        data: {orderdata:orderdata},
        dataType: 'json',
        success: function(data) {
            if(data!=''){
                var d_html='';
                var data_num = data.length;
                console.log(data_num);
                for(var i=0;i<data_num;i++) {
                    d_html=d_html+'<p>商品编号：'+data[i]['product_code']+'</p>'+
                    '<p>商品名称：'+data[i]['product_title']+'</p>'+
                    '<p>型号/规格：'+data[i]['json_attr']+'</p>';
                }
                var newWin = window.open('', '', '');
        newWin.document.write('<div><div class="box-detail">'+d_html+'</div></div>');
        newWin.print();
        newWin.close(); //关闭新产生的标签页
            }else{
                we.msg('minus', '没有获取到商品信息');
            }
        }
    });
    }
</script>