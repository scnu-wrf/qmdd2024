<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑国家列表</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'active-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'afterValidate' => 'js:function(form,data,hasError){
                        if(!hasError){
                            we.overlay("show");
                            $.ajax({
                                type:"post",
                                url:form.attr("action"),
                                data:form.serialize(),
                                dataType:"json",
                                success:function(d){
                                    if(d.status==1){
                                        we.success(d.msg, d.redirect);
                                    }else{
                                        we.error(d.msg, d.redirect);
                                    }
                                }
                            });
                        }else{
                            var items = [];
                            for(item in data){
                                items.push(item);
                            }
                            var $item = $("#"+items[0]);
                            $item.focus();
                            $(window).scrollTop($item.offset().top-10);
                        }
                    }',
                ),
            ));
            ?>
            <table class="detail">
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'country_code_three'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'country_code_three', array('class' => 'input-text', 'style'=>'width:200px;')); ?>
                        <?php echo $form->error($model, 'country_code_three', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'country_code_two'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'country_code_two', array('class' => 'input-text', 'style'=>'width:200px;')); ?>
                        <?php echo $form->error($model, 'country_code_two', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model, 'country_code_num'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'country_code_num', array('class' => 'input-text', 'style'=>'width:200px;')); ?>
                        <?php echo $form->error($model, 'country_code_num', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model, 'english_name'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'english_name', array('class' => 'input-text', 'style'=>'width:200px;')); ?>
                        <?php echo $form->error($model, 'english_name', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model, 'chinese_name'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'chinese_name', array('class' => 'input-text', 'style'=>'width:200px;')); ?>
                        <?php echo $form->error($model, 'chinese_name', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model, 'location'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'location', array('class' => 'input-text', 'style'=>'width:200px;')); ?>
                        <?php echo $form->error($model, 'location', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model, 'local_language'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'local_language', array('class' => 'input-text', 'style'=>'width:200px;')); ?>
                        <?php echo $form->error($model, 'local_language', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model, 'country_code'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'country_code', array('class' => 'input-text', 'style'=>'width:200px;')); ?>
                        <?php echo $form->error($model, 'country_code', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model, 'country_hzcode'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'country_hzcode', array('class' => 'input-text', 'style'=>'width:200px;')); ?>
                        <?php echo $form->error($model, 'country_hzcode', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model, 'country_hzsc'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'country_hzsc', array('class' => 'input-text', 'style'=>'width:200px;')); ?>
                        <?php echo $form->error($model, 'country_hzsc', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model, 'is_visible'); ?>：</th>
                    <td>
                        <?php echo $form->radioButtonList($model, 'is_visible', array(649 => '是', 648 => '否'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'is_visible'); ?>

                    </td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td>
                        <button class="btn btn-blue" type="submit">保存</button>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
            <?php $this->endWidget(); ?>
        </div><!--box-table end-->
    </div><!--box-content end-->
</div><!--box end-->
