<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>添加分类</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <table class="table-title">
            <tr>
                <td>分类信息</td>
            </tr>
        </table>
        <table>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 't_code'); ?></td>
                <td width="35%">
				    <?php echo $form->textField($model, 't_code', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 't_code', $htmlOptions = array()); ?></td>
                <td width="15%"><?php echo $form->labelEx($model, 'tn_code'); ?></td>
                <td width="35%">
                    <?php echo $form->textField($model, 'tn_code', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'tn_code', $htmlOptions = array()); ?>
                </td>
             </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'sn_name'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'sn_name', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'sn_name', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'tn_image'); ?></td>
                <td>
                    <?php echo $form->hiddenField($model, 'tn_image', array('class' => 'input-text fl')); ?>
                    <?php $basepath=BasePath::model()->getPath(159);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                    <script>we.uploadpic('<?php echo get_class($model);?>_tn_image','<?php echo $picprefix;?>');</script>
                    <?php echo $form->error($model, 'tn_image', $htmlOptions = array()); ?>
                </td>
            </tr>
            <?php echo $form->hiddenField($model, 'fater_id', array('class' => 'input-text','value'=>$_REQUEST['pid'])); ?>
            <tr>
                <td><?php echo $form->labelEx($model, 'fater_id'); ?></td>
                <td><?php echo $_REQUEST['sn_name']; ?></td>
                <td><?php echo $form->labelEx($model, 'base_f_id_one'); ?></td>
                <td>
                    <?php echo $form->dropDownList($model, 'base_f_id_one', Chtml::listData(BaseCode::model()->getCode(349), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange' =>'selectOnchang(this)'));
                   $arr=BaseCode::model()->getOrderType2(); ?>
<script> 
var $order_type2= <?php echo json_encode($arr)?>;
</script> 
                    <?php echo $form->dropDownList($model, 'base_f_id', Chtml::listData(BaseCode::model()->getOrderType(), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                    <?php echo $form->error($model, 'base_f_id_one', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'auto_id'); ?></td>
                <td>
                  <?php echo $form->dropDownList($model, 'auto_id', Chtml::listData(AutoFilterSet::model()->getTypename('attribute'), 'id', 'name'), array('prompt'=>'请选择')); ?>
                    <?php echo $form->error($model, 'auto_id', $htmlOptions = array()); ?></td>
                <td><?php echo $form->labelEx($model, 'queue_number'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'queue_number', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'queue_number', $htmlOptions = array()); ?>
                </td>
                
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'project_list'); ?></td>
                <td colspan="3">
                    <?php echo $form->hiddenField($model, 'project_list', array('class' => 'input-text')); ?>
                    <span id="project_box"></span>
                    <input id="project_add_btn" class="btn" type="button" value="添加">
                    <?php echo $form->error($model, 'project_list', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'if_list_dispay'); ?></td>
                <td>
                    <?php echo $form->radioButtonList($model, 'if_list_dispay', array(1 => '显示', 2 => '不显示'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                    <?php echo $form->error($model, 'if_list_dispay'); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'if_menu_dispay'); ?></td>
                <td>
                    <?php echo $form->radioButtonList($model, 'if_menu_dispay', array(1 => '显示', 2 => '不显示'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                    <?php echo $form->error($model, 'if_menu_dispay'); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'if_examine'); ?></td>
                <td>
                    <?php echo $form->radioButtonList($model, 'if_examine', array(1 => '不需要', 2 => '需要'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                    <?php echo $form->error($model, 'if_examine'); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'examine_time'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'examine_time', array('class' => 'input-text', 'value'=>'')); ?>
                    <?php echo $form->error($model, 'examine_time', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'if_reduce_inventory'); ?></td>
                <td>
                    <?php echo $form->radioButtonList($model, 'if_reduce_inventory', array(1 => '减', 2 => '不减'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                    <?php echo $form->error($model, 'if_reduce_inventory'); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'long_pay_time'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'long_pay_time', array('class' => 'input-text', 'value'=>'')); ?>秒
                    <?php echo $form->error($model, 'long_pay_time', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'is_post'); ?></td>
                <td>
                    <?php echo $form->radioButtonList($model, 'is_post', array(1 => '是', 2 => '否'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                    <?php echo $form->error($model, 'is_post'); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'sign_long_cycle'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'sign_long_cycle', array('class' => 'input-text', 'value'=>'')); ?>天
                    <?php echo $form->error($model, 'sign_long_cycle', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'if_apply_return'); ?></td>
                <td>
                    <?php echo $form->radioButtonList($model, 'if_apply_return', array(1 => '支持', 2 => '不支持'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                    <?php echo $form->error($model, 'if_apply_return'); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'return_cycle'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'return_cycle', array('class' => 'input-text', 'value'=>'')); ?>天
                    <?php echo $form->error($model, 'return_cycle', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'if_invoice'); ?></td>
                <td>
                    <?php echo $form->radioButtonList($model, 'if_invoice', array(1 => '可', 2 => '不可'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                    <?php echo $form->error($model, 'if_invoice'); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'invoice_cycle'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'invoice_cycle', array('class' => 'input-text', 'value'=>'')); ?>天
                    <?php echo $form->error($model, 'invoice_cycle', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'star_time'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'star_time', array('style'=>'width:120px;', 'class' => 'input-text', 'value'=>'')); ?>
                    <?php echo $form->error($model, 'star_time', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'end_time'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'end_time', array('style'=>'width:120px;', 'class' => 'input-text', 'value'=>'')); ?>
                    <?php echo $form->error($model, 'end_time', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'tn_memo'); ?></td>
                <td colspan="3">
                    <?php echo $form->textArea($model, 'tn_memo', array('class' => 'input-text' ,'value'=>'')); ?>
                    <?php echo $form->error($model, 'tn_memo', $htmlOptions = array()); ?>
                </td>
            </tr>
            </tr>
        </table>
        
        <div class="box-detail-submit"><?php echo show_shenhe_box(array('baocun'=>'保存'));?><button class="btn" type="button" onclick="we.back();">取消</button></div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
$(function(){
    var $start_time=$('#<?php echo get_class($model);?>_star_time');
    var $end_time=$('#<?php echo get_class($model);?>_end_time');
    $start_time.on('click', function(){
        var end_input=$dp.$('<?php echo get_class($model);?>_end_time')
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'<?php echo get_class($model);?>_end_time\')}'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'<?php echo get_class($model);?>_star_time\')}'});
    });
});
</script>
<script>
// 删除已添加项目
var fnDeleteProject=function(op){
    $(op).parent().remove();
    fnUpdateProject();
};
// 项目添加或删除时，更新
var fnUpdateProject=function(){
    var arr=[];
    $('#project_box span').each(function(){
        arr.push($(this).attr('data-id'));
    });
    $('#MallProductsTypeSname_project_list').val(we.implode(',',arr));
};

$(function(){
    // 添加项目
    var $project_box=$('#project_box');
    $('#project_add_btn').on('click', function(){
        $.dialog.data('project_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/project");?>',{
            id:'xiangmu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('project_id')==-1){
                    var boxnum=$.dialog.data('project_title');
                    for(var j=0;j<boxnum.length;j++) {
                        if($('#project_item_'+boxnum[j].dataset.id).length==0){
                            var s1='<span class="label-box" id="project_item_'+boxnum[j].dataset.id;
                            s1=s1+'" data-id="'+boxnum[j].dataset.id+'">'+boxnum[j].dataset.title;
                            $project_box.append(s1+'<i onclick="fnDeleteProject(this);"></i></span>');
                            fnUpdateProject(); 
                        }
                    }
                }
            }
        });
    });    
});
function selectOnchang(obj){ 
  var show_id=$(obj).val();
  var  p_html ='<option value="">请选择</option>';
  if (show_id>0) {
     for (j=0;j<$order_type2.length;j++) 
        if($order_type2[j]['fater_id']==show_id)
       {
        p_html = p_html +'<option value="'+$order_type2[j]['f_id']+'">';
        p_html = p_html +$order_type2[j]['F_NAME']+'</option>';
      }
    }
   $("#MallProductsTypeSname_base_f_id").html(p_html);
}
</script>