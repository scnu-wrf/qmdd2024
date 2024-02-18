<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>商品毛利设置详情</h1><span class="back"><a href="javascript:;" class="btn" onclick="we.back();"><i class="fa fa-reply">返回</i></a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <div class="box-detail-bd">
                <table class="table-title">
                    <tr>
                        <td colspan="4">基本信息</td>
                    </tr> 
                </table>
                <table>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'gf_salesperson_info_id'); ?></td>
                        <td width="35%"><?php echo $form->hiddenField($model, 'gf_salesperson_info_id'); ?>
                        <span id="profit_box"><?php if($model->f_name!=null){?><span class="label-box"><?php echo $model->f_name;?></span><?php } ?></span>
                            <input id="salesperson_profit_btn" class="btn" type="button" value="选择">
                            <?php echo $form->error($model, 'gf_salesperson_info_id', $htmlOptions = array()); ?>
                        </td>
                        <td width="15%"><?php echo $form->labelEx($model, 'f_code'); ?></td>
                        <td width="35%"><span id="f_code"><?php echo $model->f_code;?></span>
                            <?php echo $form->error($model, 'f_code', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'star_time'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'star_time', array('class' => 'input-text','style'=>'width:120px;')); ?>
                            <?php echo $form->error($model, 'star_time', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'end_time'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'end_time', array('class' => 'input-text','style'=>'width:120px;')); ?>
                            <?php echo $form->error($model, 'end_time', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'f_content'); ?></td>
                        <td colspan="3"><?php echo $form->textField($model, 'f_content', array('class'=>'input-text')); ?></td>
                    </tr>
                </table>
                <table class="mt15">
                    <tr>
                        <td>
                    <input id="product_select_btn" class="btn" type="button" value="添加商品">
                <?php if (!empty($model->id)) { ?>
                    <input class="btn btn-blue" type="button" onclick="importfile();" value="批量导入">
                <?php } ?>
                    </td>
                    </tr>
                    <?php echo $form->hiddenField($model, 'product', array('class' => 'input-text')); ?>
                </table>
                <table id="product">
                    <tr>
                        <td style="text-align:center;width:40px;">序号</td>
                        <td style="text-align:center;">商品编号</td>
                        <td style="text-align:center;">商品名称</td>
                        <td style="text-align:center;">型号规格</td>
                        <td style="text-align:center;">操作</td>
                    </tr>
<?php $index_num=0; ?>
<?php if(!empty($product_list)) foreach ($product_list as $v) { ?>
                    <tr id="set_item_<?php echo $v->product_code; ?>">
                        <td style="text-align:center;"><?php echo $index_num; ?></td>
                        <td><?php echo $v->product_code; ?></td>
                        <td><?php echo $v->product_name; ?></td>
                        <td><?php echo $v->json_attr; ?></td>
                        <td><a class="btn" href="javascript:;" onclick="fnDeleteProduct(this);" title="删除"><i class="fa fa-trash-o"></i></a></td>
                    </tr>
<?php $index_num++; } ?>
                </table>
                <table class="mt15">
                    <tr>
                        <td width="15%">可执行操作</td>
                        <td><?php echo show_shenhe_box(array('baocun'=>'保存'));?></td>
                    </tr>
                </table>
            </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script>
    var $start_time=$('#<?php echo get_class($model);?>_star_time');
    var $end_time=$('#<?php echo get_class($model);?>_end_time');
    $start_time.on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
    $end_time.on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss '});});
function importfile(){
        $.dialog.open('<?php echo $this->createUrl("upExcel",array('id'=>$model->id));?>',{
            id:'sensitive',
            lock:true,
            opacity:0.3,
            title:'导入商品信息',
            width:'80%',
            height:'80%',
            close: function () {
                window.location.reload(true);
            }
        });
}
// 选择毛利分配方案
    var $salesperson_profit_btn=$('#salesperson_profit_btn');
     $salesperson_profit_btn.on('click', function(){
        $.dialog.data('profit_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/salesperson_profit");?>',{
            id:'maoli',
            lock:true,
            opacity:0.3,
            title:'选择毛利方案',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('profit_id')>0){
                    $('#MallProfitInfo_gf_salesperson_info_id').val($.dialog.data('profit_id'));
                    $('#profit_box').html('<span class="label-box">'+$.dialog.data('profit_name')+'</span>');
                    $('#f_code').html($.dialog.data('profit_code'));
                }
            }
        });
    });
//添加商品
    $product = $('#product');
    var num=<?php echo $index_num; ?>;
    //var num=0;
     $('#product_select_btn').on('click', function(){
         var html_str='';
        $.dialog.data('product_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/products");?>',{
            id:'shangpin',
            lock:true,
            opacity:0.3,
            title:'选择商品',
            width:'80%',
            height:'80%',
            close: function () {
                if($.dialog.data('id')==-1){
                    var boxnum=$.dialog.data('products');
                    for(var j=0;j<boxnum.length;j++) {
                        if($('#set_item_'+boxnum[j].dataset.pcode).length==0){
                            html_str = html_str +'<tr id="set_item_'+boxnum[j].dataset.pcode+'">'+
                            '<td style="text-align:center;">'+num+'</td>'+
                            '<td>'+boxnum[j].dataset.pcode+
                            '<input type="hidden" class="input-text" name="product['+num+'][id]" value="null" />'+
                            '<input type="hidden" name="product['+num+'][product_code]" value="'
                            +boxnum[j].dataset.pcode+'" />'+
                            '<input type="hidden" name="product['+num+'][product_name]" value="'
                            +boxnum[j].dataset.name+'" />'+
                            '<input type="hidden" name="product['+num+'][json_attr]" value="'
                            +boxnum[j].dataset.attr+'" />'+
                            '</td>'+
                            '<td>'+boxnum[j].dataset.name+'</td>'+
                            '<td>'+boxnum[j].dataset.attr+'</td>'+
                            '<td><a class="btn" href="javascript:;" onclick="fnDeleteProduct(this);" title="删除">'
                            +'<i class="fa fa-trash-o"></i></a></td></tr>';
                             num++;
                               
                        }
                    }
                    $product.append(html_str);
                }
            }
        });
    });
    var fnDeleteProduct=function(op){
    $(op).parent().parent().remove();
    };
</script>