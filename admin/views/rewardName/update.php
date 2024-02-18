<?php
    $model->gift_type = empty($model->gift_type) ? 0 : $model->gift_type;
?>
<div class="box">
    <div class="box-title c">
        <h1>直播 》直播设置 》礼物红包设置 》<a class="nav-a"><?php echo (empty($model->id)) ? '添加' : '详情' ?></a></h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a>
        </span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list());?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <div class="mt15">
                    <table style="table-layout:auto;">
                        <tr class="table-title">
                            <td colspan="2">打赏信息</td>
                        </tr>
                        <tr>
                            <td width="15%"><?php echo $form->labelEx($model,'interact_type'); ?></td>
                            <td width="85%">
                                <?php echo $form->dropDownList($model,'interact_type',Chtml::listData($gift,'f_id','F_NAME'),array('prompt'=>'请选择','onchange'=>'changeInteract(this);')); ?>
                                <span style="margin-left:10px;"><?php echo $form->labelEx($model,'gift_type'); ?>：</span>
                                <select name="RewardName[gift_type]" id="RewardName_gift_type">
                                    <option value="">请选择</option>
                                </select>
                                <?php echo $form->error($model,'interact_type',$htmlOptions = array()); ?>
                                <?php echo $form->error($model,'gift_type',$htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="15%"><?php echo $form->labelEx($model, 'reward_code'); ?></td>
                            <td width="85%">
                                <?php echo $form->textField($model, 'reward_code', array('class' => 'input-text','style'=>'width:10%;')); ?>
                                <?php echo $form->error($model, 'reward_code', $htmlOptions = array()); ?>
                            </td>
                        </tr> 
                        <tr>
                            <td width="15%"><?php echo $form->labelEx($model, 'reward_name'); ?></td>
                            <td width="85%">
                                <?php echo $form->textField($model, 'reward_name', array('class' => 'input-text','style'=>'width:10%;')); ?>
                                <?php echo $form->error($model, 'reward_name', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="15%"><?php echo $form->labelEx($model, 'reward_price'); ?></td>
                            <td width="85%">
                                <?php echo $form->textField($model, 'reward_price', array('class' => 'input-text','style'=>'width:10%;')); ?>
                                <?php echo $form->error($model, 'reward_price', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'reward_pic'); ?></td>
                            <td>
                                <?php echo $form->hiddenField($model, 'reward_pic'); ?>
                                <div class="upload_img fl" id="upload_pic_RewardName_reward_pic"> 
                                    <?php if(!empty($model->reward_pic)) {?>
                                        <a href="<?php echo $model->reward_pic;?>" target="_blank">
                                            <img src="<?php echo $model->reward_pic;?>" width="100">
                                        </a>
                                    <?php }?>
                                </div>
                                <script>we.uploadpic('<?php echo get_class($model);?>_reward_pic','','','');</script>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'reward_gif'); ?></td>
                            <td>
                                <?php echo $form->hiddenField($model, 'reward_gif'); ?>
                                <div class="upload_img fl" id="upload_pic_RewardName_reward_gif"> 
                                    <?php if(!empty($model->reward_gif)) {?>
                                        <a href="<?php echo $model->reward_gif;?>" target="_blank">
                                            <img src="<?php echo $model->reward_gif;?>" width="100">
                                        </a>
                                    <?php }?>
                                </div>
                                <script>we.uploadpic('<?php echo get_class($model);?>_reward_gif','','','');</script>
                            </td>
                        </tr>
                    </table>
                </div>
            </div><!--box-detail-tab-item end   style="display:block;"-->
        </div><!--box-detail-bd end-->
        <div class="box-detail-submit">
            <?php
                echo show_shenhe_box(array('baocun'=>'保存'));
            ?>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    changeInteract($('#RewardName_interact_type'));
    function changeInteract(obj){
        var obj = $(obj).val();
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('getInteract'); ?>&interact='+obj,
            dataType: 'json',
            success: function(data){
                // console.log(data);
                var s_html = '<option value>请选择</option>';
                for(var i=0;i<data.length;i++){
                    s_html += '<option value="'+data[i]['id']+'"';
                    if(data[i]['id']==<?php echo $model->gift_type; ?>){
                        s_html += 'selected';
                    }
                    s_html += '>'+data[i]['name']+'</option>';
                }
                $('#RewardName_gift_type').html(s_html);
            },
            errer: function(request){
                we.msg('minus','获取错误');
            }
        });
    }
</script>