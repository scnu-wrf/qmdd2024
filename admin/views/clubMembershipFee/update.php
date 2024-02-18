<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>详细</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
            <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
                <table class="detail">
                    <tr>
                        <td class="detail-hd"><?php echo $form->labelEx($model, 'code'); ?></td>
                        <td><?php echo $form->textField($model, 'code', array('class'=>'input-text','style'=>'width:20%;'));?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'name', array('class' => 'input-text','style'=>'width:20%;')); ?>
                            <?php echo $form->error($model, 'name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'product_code'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'product_id'); ?>
                            <?php echo $form->textField($model, 'product_code', array('class'=>'input-text','style'=>'width:20%;','readonly'=>'readonly'));?>
                            <?php echo $form->error($model, 'product_code', $htmlOptions = array()); ?>
                            <input id="product_add_btn" class="btn" type="button" value="选择绑定商品">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'product_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'product_name', array('class' => 'input-text','style'=>'width:20%;','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'product_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'notepad'); ?></td>
                        <td>
                            <?php echo $form->textArea($model, 'notepad', array('class' => 'input-text','style'=>'width:50%;height:80px;')); ?>
                            <?php echo $form->error($model, 'notepad', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>可执行操作</td>
                        <td>
                            <button id="baocun" onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>&nbsp;
                            <!-- <?php //echo show_shenhe_box(array('baocun'=>'保存'));?> -->
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>
                </table>
            <?php $this->endWidget();?>
        </div><!--box-detail end-->
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    // 选择商品
    $(function(){
        $('#product_add_btn').on('click', function(){
            $.dialog.data('product_id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/memberfee");?>',{
                id:'shangpin',
                lock:true,
                opacity:0.3,
                title:'选择具体内容',
                width:'80%',
                height:'90%',
                close: function () {
                    if($.dialog.data('product_id')>0){
                        $('#ClubMembershipFee_product_id').val($.dialog.data('product_id'));
                        $('#ClubMembershipFee_product_code').val($.dialog.data('product_code'));
                        $('#ClubMembershipFee_product_name').val($.dialog.data('product_name'));
                    }
                }
            });
        })
    })
</script>