<?php
    $mark = array(1=>'★☆☆☆☆',2=>'★★☆☆☆',3=>'★★★☆☆',4=>'★★★★☆',5=>'★★★★★');
    $club_f_mark  =  array(1=>'<span>★☆☆☆☆</span>',2=>'<span>★★☆☆☆</span>',3=>'<span>☆☆☆☆☆</span>',4=>'<span>★★★★☆</span>',5=>'<span>★★★★★</span>');
?>
<?php $basepath=BasePath::model()->getPath(175);?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>评价详情</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table>
                <tr class="table-title">
                    <td colspan="4">评价信息</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'service_order_num'); ?></td>
                    <td><?php echo $model->service_order_num; ?></td>
                    <td>下单时间</td>
                    <td><?php if(!empty($model->gf_service_data_id))echo $model->orderNum->add_time; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'service_name'); ?></td>
                    <td colspan="3"><?php echo $model->service_name; ?></td>
                </tr>
            </table>
            <table class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="4">评价信息</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'gf_zsxm'); ?></td>
                    <td><?php echo $model->gf_zsxm; ?></td>
                    <td><?php echo $form->labelEx($model, 'gf_account'); ?></td>
                    <td><?php echo $model->gf_account; ?></td>
                </tr>
                <?php if(!empty($eval_list))foreach($eval_list as $v){ ?>
                    <tr>
                        <td><?php echo $v->f_achievemen_name; ?></td>
                        <td><?php if($v->f_mark1==1||$v->f_mark1==2||$v->f_mark1==3||$v->f_mark1==4||$v->f_mark1==5)echo $mark[$v->f_mark1]; ?></td>
                        <td colspan="2"><?php echo $v->f_mark1_name; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td><?php echo $form->labelEx($model, 'evaluate_info'); ?></td>
                    <td colspan="3"><?php echo $model->evaluate_info; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'evaluate_img'); ?></td>
                    <td colspan="3">
                        <?php
                            $eval_img  =  explode('|', $model->evaluate_img);
                            foreach($eval_img as $v2){
                                echo '<a href="'.$basepath->F_WWWPATH.$v2.'" target="_blank"><img style="max-height:100px; max-width:100px" src="'.$basepath->F_WWWPATH.$v2.'"></a>&nbsp;&nbsp;';
                            }
                        ?>
                    </td>
                </tr>
            </table>
            <table class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="3">单位评价</td>
                </tr>
                <tr>
                    <td width="35%"><?php echo $form->labelEx($model, 'club_f_mark'); ?></td>
                    <td>
                        <?php echo $form->hiddenField($model,'club_f_mark'); ?>
                        <?php
                            if(!isset($model->club_f_mark)||$model->servic_f_mark==0){
                                echo '<span class="club_f_mark">☆</span><span class="club_f_mark">☆</span><span class="club_f_mark">☆</span><span class="club_f_mark">☆</span><span class="club_f_mark">☆</span>';
                            }else if($model->club_f_mark==1){
                                echo '<span class="club_f_mark">★</span><span class="club_f_mark">☆</span><span class="club_f_mark">☆</span><span class="club_f_mark">☆</span><span class="club_f_mark">☆</span>';
                            }else if($model->club_f_mark==2){
                                echo '<span class="club_f_mark">★</span><span class="club_f_mark">★</span><span class="club_f_mark">☆</span><span class="club_f_mark">☆</span><span class="club_f_mark">☆</span>';
                            }else if($model->club_f_mark==3){
                                echo '<span class="club_f_mark">★</span><span class="club_f_mark">★</span><span class="club_f_mark">★</span><span class="club_f_mark">☆</span><span class="club_f_mark">☆</span>';
                            }else if($model->club_f_mark==4){
                                echo '<span class="club_f_mark">★</span><span class="club_f_mark">★</span><span class="club_f_mark">★</span class="club_f_mark"><span>★</span><span class="club_f_mark">☆</span>';
                            }else if($model->club_f_mark==5){
                                echo '<span class="club_f_mark">★</span><span class="club_f_mark">★</span><span class="club_f_mark">★</span><span class="club_f_mark">★</span><span class="club_f_mark">★</span>';
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'club_evaluate_info'); ?></td>
                    <td><?php echo $form->textArea($model,'club_evaluate_info',array('class'=>'input-text','maxlength'=>'120','placeholder'=>'*限制文字在120字以内'))?></td>
                </tr>
            </table>
            <!-- <table class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="3">服务者评价</td>
                </tr>
                <tr>
                    <td width="35%"><?php echo $form->labelEx($model, 'servic_f_mark'); ?></td>
                    <td>
                        <?php //echo $form->hiddenField($model,'servic_f_mark'); ?>
                        <?php
                            // if(!isset($model->servic_f_mark)||$model->servic_f_mark==0){
                            //     echo '<span class="servic_f_mark">☆</span><span class="servic_f_mark">☆</span><span class="servic_f_mark">☆</span><span class="servic_f_mark">☆</span><span class="servic_f_mark">☆</span>';
                            // }else if($model->servic_f_mark==1){
                            //     echo '<span class="servic_f_mark">★</span><span class="servic_f_mark">☆</span><span class="servic_f_mark">☆</span><span class="servic_f_mark">☆</span><span class="servic_f_mark">☆</span>';
                            // }else if($model->servic_f_mark==2){
                            //     echo '<span class="servic_f_mark">★</span><span class="servic_f_mark">★</span><span class="servic_f_mark">☆</span><span class="servic_f_mark">☆</span><span class="servic_f_mark">☆</span>';
                            // }else if($model->servic_f_mark==3){
                            //     echo '<span class="servic_f_mark">★</span><span class="servic_f_mark">★</span><span class="servic_f_mark">★</span><span class="servic_f_mark">☆</span><span class="servic_f_mark">☆</span>';
                            // }else if($model->servic_f_mark==4){
                            //     echo '<span class="servic_f_mark">★</span><span class="servic_f_mark">★</span><span class="servic_f_mark">★</span class="servic_f_mark"><span>★</span><span class="servic_f_mark">☆</span>';
                            // }else if($model->servic_f_mark==5){
                            //     echo '<span class="servic_f_mark">★</span><span class="servic_f_mark">★</span><span class="servic_f_mark">★</span><span class="servic_f_mark">★</span><span class="servic_f_mark">★</span>';
                            // }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php //echo $form->labelEx($model, 'servic_evaluate_info'); ?></td>
                    <td><?php //echo $form->textArea($model,'servic_evaluate_info',array('class'=>'input-text','maxlength'=>'120','placeholder'=>'*限制文字在120字以内'))?></td>
                </tr>
            </table> -->
            <table class="mt15" style="table-layout:auto;">
                <tr>      
                    <td><?php echo $form->labelEx($model, 'is_dispay'); ?></td>
                    <td colspan="3">
                    	<?php echo $form->radioButtonList($model, 'is_dispay', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'is_dispay', $htmlOptions = array()); ?>
                    </td> 
                </tr>
                <tr>
                	<td>可执行操作</td>
                    <td colspan="3">
                        <?php echo show_shenhe_box(array('baocun'=>'保存')); ?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    $(".club_f_mark").on("click",function(){
        $(this).siblings('span').html("☆");
        $(this).html("★").prevAll().html("★");
        var index = $(this).index();
        $('#QmddAchievemenData_club_f_mark').val(index);
    })
    $(".servic_f_mark").on("click",function(){
        $(this).siblings('span').html("☆");
        $(this).html("★").prevAll().html("★");
        var index = $(this).index();
        $('#QmddAchievemenData_servic_f_mark').val(index);
    })
</script>