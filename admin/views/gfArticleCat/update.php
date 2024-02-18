<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑文章分类</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
            <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table class="detail">
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'cat_name'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'cat_name', array('class' => 'input-text', 'style'=>'width:300px;')); ?>
                        <?php echo $form->error($model, 'cat_name', $htmlOptions = array()); ?>
                    </td>
                    <td>
                        <?php echo $form->hiddenField($model, 'cat_type', array('class' => 'input-text', 'value'=>$_REQUEST["type"])); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'parent_id'); ?>：</td>
                    <td>
                        <!--<?php echo $form->dropDownList($model, 'parent_id', Chtml::listData(AutoFilterSet::model()->getTypename('attribute'), 'id', 'name'), array('prompt'=>'请选择')); ?>-->
                        <?php echo $form->dropDownList($model, 'parent_id', Chtml::listData(GfArticleCat::model()->getAll(),'id','cat_name','cat_type'), array('prompt'=>'请选择')); ?>
                        <?php echo $form->error($model, 'parent_id', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'sort_order'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'sort_order', array('class' => 'input-text', 'style'=>'width:300px;')); ?>
                        <?php echo $form->error($model, 'sort_order', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr> 
                    <td class="detail-hd"><?php echo $form->labelEx($model, 'show_in_nav'); ?>：</td>
                    <td>
                        <?php echo $form->radioButtonList($model, 'show_in_nav', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'keywords'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'keywords', array('class' => 'input-text', 'style'=>'width:300px;')); ?>
                        <?php echo $form->error($model, 'keywords', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'cat_desc'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'cat_desc', array('class' => 'input-text', 'style'=>'width:300px;')); ?>
                        <?php echo $form->error($model, 'cat_desc', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                	<td>可执行操作：</td>
                    <td>
                    	<?php echo show_shenhe_box(array('baocun'=>'保存'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
            <?php $this->endWidget(); ?>
        </div><!--box-table end-->
    </div><!--box-content end-->
</div><!--box end-->
<!--<script>
    function selectOnchang(obj){ 
    var show_id=$(obj).val();
    var  p_html ='<option value="">请选择</option>';
    if (show_id>0) {
        for (j=0;j<$order_type2.length;j++) 
            if($order_type2[j]['parent_id']==show_id)
        {
            p_html = p_html +'<option value="'+$order_type2[j]['f_id']+'">';
            p_html = p_html +$order_type2[j]['F_NAME']+'</option>';
        }
        }
    $("#MallProductsTypeSname_base_f_id").html(p_html);
    }
</script>-->