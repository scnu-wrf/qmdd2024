<div class="box">
    <div class="box-title c">
        <h1>当前界面：财务 》毛利结算设置 》<?= empty($model->id)?'添加':'详情';?></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end--> 
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="4">基本信息</td>
                </tr>
                <tr>
                    <td width="10%;"><?php echo $form->labelEx($model, 'code'); ?></td>
                    <td width="40%;" colspan="3">
                        <?php echo $model->code; ?>
                        <?php echo $form->error($model, 'admin_gfnick', $htmlOptions = array()); ?>
                    </td>
                </tr>  
                <tr>
                    <td width="10%;"><?php echo $form->labelEx($model, 'admin_gfnick'); ?></td>
                    <td width="40%;">
                        <?php echo $form->textField($model, 'admin_gfnick', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'admin_gfnick', $htmlOptions = array()); ?>
                    </td>
                    <td width="10%;"><?php echo $form->labelEx($model, 'user_name'); ?></td>
                    <td width="40%;">
                        <?php echo $form->textField($model, 'user_name', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'user_name', $htmlOptions = array()); ?>
                    </td>
                </tr>  
                <tr>
                    <td><?php echo $form->labelEx($model, 'add_time'); ?></td>
                    <td>
                        <?php echo $form->textField($model, 'add_time', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'add_time', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'check_time'); ?></td>
                    <td>
                        <?php echo $form->textField($model, 'check_time', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'check_time', $htmlOptions = array()); ?>
                    </td>
                </tr> 
                <tr>
                    <td><?php echo $form->labelEx($model, 'type'); ?></td>
                    <td>
                        <?php echo $form->hiddenField($model, 'type', array('class' => 'input-text')); ?>
                        <span id="classify_box">
                            <?php 
                                if(!empty($model->type)){
                                    $text='';
                                    foreach(explode(",",$model->type) as $t){
                                        $type=MallProductsTypeSname::model()->find('id='.$t);
                                        $text.=$type->sn_name.'-';
                                    }
                                    echo '<span class="label-box">'.rtrim($text, '-').'</span>'; 
                                }
                            ?>
                        </span>
                        <input id="classify_add_btn" class="btn" type="button" value="选择分类">
                        <?php echo $form->error($model, 'type', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'product_id'); ?></td>
                    <td>
                        <?php echo $form->hiddenField($model, 'product_id', array('class' => 'input-text')); ?>
                        <span id="fee_box">
                            <?php 
                                if(!empty($model->product_id)){
                                    echo '<span class="label-box">'.$model->product_name.'&nbsp;'.$model->product_code.'&nbsp;'.$model->json_attr.'</span>'; 
                                }
                            ?>
                        </span>
                        <input id="fee_add_btn" class="btn" type="button" value="选择">
                        <?php echo $form->error($model, 'product_id', $htmlOptions = array()); ?>
                    </td>
                </tr>  
            </table>
            <table class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="2">设置毛利率</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'gf_gross'); ?></td>
                    <td><?php echo $form->labelEx($model, 'club_gross'); ?></td>
                </tr>
                <tr>
                    <td>
                        <?php $model->gf_gross=floatval($model->gf_gross);echo $form->textField($model, 'gf_gross', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'gf_gross', $htmlOptions = array()); ?>
                    </td>
                    <td>
                        <?php $model->club_gross=floatval($model->club_gross);echo $form->textField($model, 'club_gross', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'club_gross', $htmlOptions = array()); ?>
                    </td>
                </tr> 
            </table>
            <table class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="2">操作信息</td>
                </tr>
                <tr>
                    <td width="10%"><?php echo $form->labelEx($model, 'content'); ?></td>
                    <td>
                        <?php echo $form->textArea($model, 'content', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'content', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td width="10%;">可执行操作</td>
                    <td>
                        <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>

$('#GfServiceInfo_add_time,#GfServiceInfo_check_time').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });

// 选择分类
var $classify_add_btn=$('#classify_add_btn');
$classify_add_btn.on("click",function(){
    $.dialog.data('classify_id', 0);
    $.dialog.open('<?php echo $this->createUrl("select/gross_type");?>',{
        id:'fenlei',
        lock:true,
        opacity:0.3,
        title:'选择具体内容',
        width:'80%',
        height:'90%',
        close: function () {
            if($.dialog.data('classify_id')>0){
                $("#GfServiceInfo_type").val($.dialog.data('classify_str'));
                $("#classify_box").html('<span class="label-box">'+$.dialog.data('classify_title')+'</span>');
            }
        }
    });
})

// 选择收费项目
var $fee_add_btn=$('#fee_add_btn');
$fee_add_btn.on("click",function(){
    $.dialog.data('product_id', 0);
    $.dialog.open('<?php echo $this->createUrl("select/memberfee");?>',{
        id:'shoufeixiangmu',
        lock:true,
        opacity:0.3,
        title:'选择具体内容',
        width:'80%',
        height:'90%',
        close: function () {
            if($.dialog.data('product_id')>0){
                $("#GfServiceInfo_product_id").val($.dialog.data('product_id'));
                var data=$.parseJSON($.dialog.data('data'));
                $("#fee_box").html('<span class="label-box">'+data.product_code+'&nbsp;'+data.name+'&nbsp;'+data.json_attr+'</span>');
            }
        }
    });
})

</script> 



