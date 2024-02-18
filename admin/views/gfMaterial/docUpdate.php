<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑电子文档素材</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <table>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'v_title'); ?></td>
                <td width="35%">
                    <?php echo $form->textField($model, 'v_title', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'v_title', $htmlOptions = array()); ?>
                </td>
                <td width="15%"><?php echo $form->labelEx($model, 'group_id'); ?></td>
                <td>
                    <?php echo $form->dropDownList($model, 'group_id', Chtml::listData($group, 'id', 'group_name'), array('prompt'=>'请选择')); ?>
                    <?php echo $form->error($model, 'group_id', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'v_pic'); ?></td>
                <td colspan="3">
                    <?php echo $form->hiddenField($model, 'v_pic', array('class' => 'input-text fl')); ?>
                    <?php $basepath=BasePath::model()->getPath(177);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                    <script>we.uploadpic('<?php echo get_class($model);?>_v_pic','<?php echo $picprefix;?>');</script>
                    <?php echo $form->error($model, 'v_pic', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'v_name'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'v_name', array('class' => 'input-text')); ?>
                    <div class="msg">例如：2017/09/08/16/87_gm_238__081627250245.txt</div>
                    <?php echo $form->error($model, 'v_name', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'v_file_path'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'v_file_path', array('class' => 'input-text', 'value'=>'http://upload.gf41.net:60/')); ?>
                    <div class="msg">例如：http://upload.gf41.net:60/</div>
                    <?php echo $form->error($model, 'v_file_path', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'v_file_size'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'v_file_size', array('class' => 'input-text', 'style'=>'width:100px;')); ?>
                    <span class="msg">例如：50M</span>
                    <?php echo $form->error($model, 'v_file_size', $htmlOptions = array()); ?>
                </td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <div class="box-detail-submit"><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button><button class="btn" type="button" onclick="we.back();">取消</button></div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
$(function(){
    var $product_code = $('#product_code');
    var $product_name = $('#product_name');
    var $product_attr = $('#product_attr');
    var $product_price = $('#product_price');
    var $product_data_id = $('#AdverName_product_data_id');
    $('#product_select_btn').on('click', function(){
        $.dialog.data('product_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/productData");?>',{
            id:'shangpin',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('product_id')>0){
                    $product_data_id.val($.dialog.data('product_id'));
                    $product_code.html($.dialog.data('product_code'));
                    $product_name.html($.dialog.data('product_name'));
                    $product_attr.html($.dialog.data('product_attr'));
                    $product_price.html('预估价格：'+$.dialog.data('product_price')+'，以当时价格为准');
                }
            }
        });
    });
});
</script>