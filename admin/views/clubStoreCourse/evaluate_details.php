<?php
    $mark = array(1=>'★☆☆☆☆',2=>'★★☆☆☆',3=>'★★★☆☆',4=>'★★★★☆',5=>'★★★★★');
    $club_f_mark  =  array(1=>'<span>★☆☆☆☆</span>',2=>'<span>★★☆☆☆</span>',3=>'<span>☆☆☆☆☆</span>',4=>'<span>★★★★☆</span>',5=>'<span>★★★★★</span>');
?>
<?php $basepath=BasePath::model()->getPath(175);?>
<div class="box">
    <div class="box-title c"><h1>当前界面：培训/活动 》课程评价 》评价列表 》详情</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="4">评价信息</td>
                </tr>
                <tr class="table-title">
                    <td style="width:25%;">服务流水号</td>
                    <td style="width:25%;">课程标题</td>
                    <td style="width:25%;">评价人</td>
                    <td style="width:25%;">评价时间</td>
                </tr>
                <tr>
                    <td><?php echo $model->service_order_num; ?></td>
                    <td><?php echo $model->service_name; ?></td>
                    <td><?php echo $model->gf_account.'/'.$model->gf_account; ?></td>
                    <td><?php echo $model->evaluate_time; ?></td>
                </tr>
            </table>
            <table class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="4">评价信息</td>
                </tr>
                <tr>
                    <td style="width:10%">课程内容</td>
                    <td colspan="3"><?php echo $model->service_name; ?></td>
                </tr>
                <tr>
                    <td style="width:10%"><?php echo '服务单位'; ?></td>
                    <td colspan="3"><?php if(!is_null($model->club_list))echo $model->club_list->club_name; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'evaluate_info'); ?></td>
                    <td colspan="3"><?php echo $model->evaluate_info; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'evaluate_img'); ?></td>
                    <td colspan="3">
                        <?php
                            if(!empty($model->evaluate_img)){
                                $eval_img  =  explode('|', $model->evaluate_img);
                                if(!empty($eval_img))foreach($eval_img as $v2){
                                    echo '<a href="'.$basepath->F_WWWPATH.$v2.'" target="_blank"><img style="max-height:100px; max-width:100px" src="'.$basepath->F_WWWPATH.$v2.'"></a>&nbsp;&nbsp;';
                                }
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
                    <td style="width:10%"><?php echo '单位回复'; ?></td>
                    <td>
                        <?php echo $form->textArea($model,'club_evaluate_info',array('class'=>'input-text','maxlength'=>'120','placeholder'=>'*限制文字在120字以内'))?>
                        <?php echo $form->error($model, 'club_evaluate_info', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'club_f_mark'); ?></td>
                    <td>
                        <?php echo $form->hiddenField($model,'club_f_mark'); ?>
                        <?php
                            if(!isset($model->club_f_mark)||$model->club_f_mark==0){
                                echo '<span class="club_f_mark">☆</span><span class="club_f_mark">☆</span><span class="club_f_mark">☆</span><span class="club_f_mark">☆</span><span class="club_f_mark">☆</span>';
                            }else if($model->club_f_mark==1){
                                echo '<span class="club_f_mark">★</span><span class="club_f_mark">☆</span><span class="club_f_mark">☆</span><span class="club_f_mark">☆</span><span class="club_f_mark">☆</span>';
                            }else if($model->club_f_mark==2){
                                echo '<span class="club_f_mark">★</span><span class="club_f_mark">★</span><span class="club_f_mark">☆</span><span class="club_f_mark">☆</span><span class="club_f_mark">☆</span>';
                            }else if($model->club_f_mark==3){
                                echo '<span class="club_f_mark">★</span><span class="club_f_mark">★</span><span class="club_f_mark">★</span><span class="club_f_mark">☆</span><span class="club_f_mark">☆</span>';
                            }else if($model->club_f_mark==4){
                                echo '<span class="club_f_mark">★</span><span class="club_f_mark">★</span><span class="club_f_mark">★</span><span class="club_f_mark">★</span><span class="club_f_mark">☆</span>';
                            }else if($model->club_f_mark==5){
                                echo '<span class="club_f_mark">★</span><span class="club_f_mark">★</span><span class="club_f_mark">★</span><span class="club_f_mark">★</span><span class="club_f_mark">★</span>';
                            }
                        ?>
                        <?php echo $form->error($model, 'club_f_mark', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
            <table class="mt15" style="table-layout:auto;">
                <tr>
                	<td style="width:10%">可执行操作</td>
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