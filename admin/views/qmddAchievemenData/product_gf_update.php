<?php
    $mark = array(1=>'★☆☆☆☆',2=>'★★☆☆☆',3=>'★★★☆☆',4=>'★★★★☆',5=>'★★★★★');
    $club_f_mark  =  array(1=>'<span>★☆☆☆☆</span>',2=>'<span>★★☆☆☆</span>',3=>'<span>☆☆☆☆☆</span>',4=>'<span>★★★★☆</span>',5=>'<span>★★★★★</span>');
?>
<?php $basepath=BasePath::model()->getPath(175);?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》评价管理》商城评价管理》<a class="nav-a">详情</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table>
                <tr class="table-title">
                    <td colspan="4">评价信息</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'order_num'); ?></td>
                    <td>商品信息</td>
                    <td><?php echo $form->labelEx($model, 'gf_zsxm'); ?></td>
                    <td><?php echo $form->labelEx($model, 'evaluate_time'); ?></td>
                </tr>
                <tr>
                    <td><?php echo $model->order_num; ?></td>
                    <td><?php echo $model->product_title; ?>，<?php echo $model->json_attr; ?></td>
                    <td><?php echo $model->gf_zsxm; ?>(<?php echo $model->gf_account; ?>)</td>
                    <td><?php echo $model->evaluate_time; ?></td>
                </tr>
            </table>
            <table class="mt15">
                <?php if(!empty($o_type))foreach($o_type as $t){ ?>
                <?php $v1=QmddAchievemenData::model()->find('order_num="'.$model->order_num.'" and product_id='.$model->product_id.' and f_achievemenid='.$t->f_id); ?>
                    <tr>
                        <td><?php echo $t->f_achid_name; ?></td>
                        <td colspan="3"><?php if(!empty($v1) && ($v1->f_mark1==0||$v1->f_mark1==1||$v1->f_mark1==2||$v1->f_mark1==3||$v1->f_mark1==4||$v1->f_mark1==5)) echo $mark[$v1->f_mark1]; ?>
                            &nbsp;&nbsp;<?php echo $v1->f_mark1_name; ?>
                        </td>
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
                            if(!empty($model->evaluate_img)){
                                $eval_img  =  explode(',', $model->evaluate_img);
                                foreach($eval_img as $v2){
                                    echo '<a href="'.$basepath->F_WWWPATH.$v2.'" target="_blank"><img style="max-height:100px; max-width:100px" src="'.$basepath->F_WWWPATH.$v2.'"></a>&nbsp;&nbsp;';
                                }
                            }
                        ?>
                    </td>
                </tr>
            </table>
            <table class="mt15">
                <tr class="table-title">
                    <td colspan="4">单位评价</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'club_f_mark'); ?></td>
                    <td colspan="3">
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
                    <td colspan="3"><?php echo $form->textArea($model,'club_evaluate_info',array('class'=>'input-text','maxlength'=>'120','placeholder'=>'*限制文字在120字以内'))?></td>
                </tr>
            </table>
            <table class="mt15">
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
                        <?php echo show_shenhe_box(array('baocun'=>'确定')); ?>
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