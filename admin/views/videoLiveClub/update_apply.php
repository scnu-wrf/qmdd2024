<style>

    .step li{
        width: calc(100% / 3);
    }
</style>
<?php
if($model->state==721 || $model->state==373){
        $left='calc(100%/6)';
        $bar='calc(12%)';  
    }elseif($model->state==371){
        $left='calc(50%)';
        $bar='calc(45%)';
    }elseif($model->state==372){
        $left='calc(100%)';
        $bar='calc(80%)';
    }else{
        $left='calc(100%/6)';
        $bar='calc(12%)';
    }
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：首页》直播单位管理》<a class="nav-a">直播单位申请</a></h1>
    </div>
    <div class="box-detail">
        <div class="step">
            <div class="step_bar">
                <div class="step_bg">
                    <div class="step_left" style="width:<?php echo $left; ?>;"></div>
                    <div class="step_float" style="left:<?php echo $bar; ?>;"></div>
                </div>
            </div>
            <ul>
                <li>提交直播单位申请</li>
                <li>直播单位审核</li>
                <li>申请完成</li>
            </ul>
        </div>
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table class="table-title">
                <tr>
                    <td>基本信息</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model, 'club_code'); ?></td>
                    <td width="35%"><?php echo $form->textField($model, 'club_code', array('class' => 'input-text','disabled'=>'true')); ?>
                        <?php echo $form->error($model, 'title', $htmlOptions = array()); ?>
                    </td>
                    <?php echo $form->hiddenField($model, 'club_id'); ?>
                    <td width="15%"><?php echo $form->labelEx($model, 'club_name'); ?></td>
                    <td width="35%"><?php echo $form->textField($model, 'club_name', array('class' => 'input-text','disabled'=>'true')); ?></td>
                </tr>
                <?php echo $form->hiddenField($model, 'club_type'); ?>
                <?php echo $form->hiddenField($model, 'partnership_type'); ?>
                <?php //echo $form->hiddenField($model, 'partnership_name'); ?>
                <tr>
                    <td><?php echo $form->labelEx($model, 'apply_name'); ?></td>
                    <td><?php echo $form->textField($model, 'apply_name', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'apply_name', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'contact_phone'); ?></td>
                    <td><?php echo $form->textField($model, 'contact_phone', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'contact_phone', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'email'); ?></td>
                    <td><?php echo $form->textField($model, 'email', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'email', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'contact_address'); ?></td>
                    <td><?php echo $form->textField($model, 'contact_address', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'contact_address', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'server_type'); ?></td>
                    <td colspan="3">
                        <?php echo $form->checkBoxList($model, 'server_type', Chtml::listData(VideoClassify::model()->getCode(366), 'id', 'sn_name'),
                          $htmlOptions = array('separator' => '', 'class' => 'input-check', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?>
                         <?php echo $form->error($model, 'server_type'); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <?php echo $form->checkBoxList($model, 'is_read', array(649=>'已阅读并同意'),
                              $htmlOptions = array('separator' => '', 'class' => 'input-check', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?>
    《<a href="https://gw.gfinter.net/?device_type=7&c=info&a=page_switch&category=rule&page=video_live_agreement" target="_bank">GF平台直播功能开通服务协议</a>》
                    </td>
                </tr>                                    
            </table>
        </div><!--box-detail-bd end-->
        <div id="operate" class="mt15" style="text-align:center;">

        <?php 
         if($model->state==721) { 
            //echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核')); ?>
            <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
            <button onclick="submitType='shenhe'" class="btn btn-blue" type="submit">提交审核</button>
        <?php }elseif ($model->state==373) {
            echo $model->base_code->F_NAME; ?>
            <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
            <button onclick="submitType='shenhe'" class="btn btn-blue" type="submit">提交审核</button
        <?php } else {
            echo '已提交，'.$model->base_code->F_NAME;

        }?>
        </div>
            
<?php $this->endWidget(); ?>
  </div><!--box-detail end-->
</div><!--box end-->
<script>

$(function(){
   
    $('#operate .btn-blue:eq(1)').on('click',function(){
        var is_read=$("#VideoLiveClub_is_read input[type='checkbox']").prop("checked");
        if(is_read==false){
            we.msg('minus','请先阅读并同意《直播服务协议》');
            return false;
        }

    });

});



	
</script>
