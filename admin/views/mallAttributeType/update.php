<?php 
    $f_types=BaseCode::model()->getCode(832);  
    $f_items=BaseCode::model()->getCode(835);  
?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>添加应用</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
       <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <table class="table-title">
            <tr>
                <td>商品类型</td>
            </tr>
        </table>
        <table>
<!-- 
-->   
        <table class="mt15">
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'cat_name'); ?></td>
                <td width="85%">
                    <?php echo $form->textField($model, 'cat_name', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'cat_name', $htmlOptions = array()); ?>
                </td>
            </tr>


            <tr>
                <td><?php echo $form->labelEx($model, 'attr_group'); ?></td>
                    <td>
                        <?php echo $form->textArea($model, 'attr_group', array('class' => 'input-text' ,'value'=>$model->attr_group)); ?>
                        <?php echo $form->error($model, 'attr_group', $htmlOptions = array()); ?>
                        <P>每行一个商品属性组。排序也将按照自然顺序排序。</P>
                </td>
            </tr>

            <tr>
                <td><?php echo $form->labelEx($model, 'enabled'); ?></td>
                    <td>
                        <?php echo $form->radioButtonList($model, 'enabled', Chtml::listData(BaseCode::model()->getCode(695), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'enabled'); ?>
                </td>
            </tr>

         
        </table>


        <div class="box-detail-submit"><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button><button class="btn" type="button" onclick="we.back();">取消</button></div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->

