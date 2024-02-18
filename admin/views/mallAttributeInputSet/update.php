<?php 
    $f_types=BaseCode::model()->getCode(832);  
    $f_items=BaseCode::model()->getCode(835);  
?>
<div class="box">

    <div class="box-title c">
        <h1><i class="fa fa-table"></i>编辑属性</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
     </div><!--box-title end-->

    <div class="box-detail">
       <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <table class="table-title">
            <tr>
                <td>商品属性信息</td>
            </tr>
        </table>
        <table>
<!-- 
-->   
        <table class="mt15">
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'attr_name'); ?></td>
                <td width="85%">
                    <?php echo $form->textField($model, 'attr_name', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'attr_name', $htmlOptions = array()); ?>
                </td>
            </tr>

            <tr>
                <td width="15%">所属商品类型：</td>
                <td width="85%">
                   <?php
                    echo $form->dropDownList($model, 'cat_id', Chtml::listData(MallAttributeType::model()->findAll(array(
                        'condition' => 'enabled=1',
                        'order' => 'cat_name DESC',
                        )), 'cat_id', 'cat_name'), array('prompt'=>'请选择')); ?> 
                    <?php echo $form->error($model, 'cat_id', $htmlOptions = array()); ?>
                </td>
            </tr>


                    <tr>
                        <td width="15%">能否进行检索：</td>
                        <td width="85%">
                            <?php echo $form->radioButtonList($model, 'attr_index', Chtml::listData(BaseCode::model()->getCode(972), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        	<?php echo $form->error($model, 'attr_index'); ?>

                              <input id="btn_index" type="button" class="btn" value="操作提示" />  
                             <div id="text_index" style="display:none;" >
                                <br>不需要该属性成为检索商品条件的情况请选择不需要检索，需要该属性进行关键字检索商品时选择关键字检索，如果该属性检索时希望是指定某个范围时，选择范围检索。
                             </div>

                            

                        </td>
                    </tr>

                    <tr>
                        <td width="15%">相同属性值的商品是否关联？</td>
                        <td width="85%">
                             <?php echo $form->radioButtonList($model, 'is_linked', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        	<?php echo $form->error($model, 'is_linked'); ?>

                        </td>
                    </tr>

                    <tr>
                        <td width="15%">属性是否可选</td>
                        <td width="85%">
                            
                            <?php echo $form->radioButtonList($model, 'attr_type', Chtml::listData(BaseCode::model()->getCode(968), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        	<?php echo $form->error($model, 'attr_type'); ?>

                            <input id="btn_type" type="button" class="btn" value="操作提示" />  
                            <div id="text_type" style="display:none;" >
                                <br>选择"单选/复选属性"时，可以对商品该属性设置多个值，同时还能对不同属性值指定不同的价格加价，用户购买商品时需要选定具体的属性值。选择"唯一属性"时，商品的该属性值只能设置一个值，用户只能查看该值。
                            </div>

                   <tr>
                        <td width="15%">该属性值的录入方式：</td>
                        <td width="85%">
                            <?php echo $form->radioButtonList($model, 'attr_input_type', Chtml::listData(BaseCode::model()->getCode(676), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        	<?php echo $form->error($model, 'attr_input_type'); ?>
                        </td>
                    </tr>                    
 
            <tr>
                <td><?php echo $form->labelEx($model, 'attr_values'); ?></td>
                    <td>
                        <?php echo $form->textArea($model, 'attr_values', array('class' => 'input-text' ,'value'=>$model->attr_values)); ?>
                        <?php echo $form->error($model, 'attr_values', $htmlOptions = array()); ?>
                        <br><span class="notice-span" style="display:block"  id="noticeList">多值使用英文逗号（,）隔开,排序为升序排序，同值为发布时间升序排序。</span>
                </td>
            </tr>

            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'sort_order'); ?></td>
                <td width="85%">
                    <?php echo $form->textField($model, 'sort_order', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'sort_order', $htmlOptions = array()); ?>
                </td>
            </tr>
                
         
        </table>


        <div class="box-detail-submit"><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button><button class="btn" type="button" onclick="we.back();">取消</button></div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->


<!-- <script type="text/javascript" src="/static/admin/js/jquery.js"></script> -->
<script type="text/javascript">

    $(function () {  
            $("#btn_index").bind("click", function () {  
                $("#text_index").toggle();  
            })  
        }); 


    $(function () {  
            $("#btn_type").bind("click", function () {  
                $("#text_type").toggle();  
            })  
        }); 
</script>