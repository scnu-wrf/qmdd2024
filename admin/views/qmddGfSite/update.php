<div class="box">
    <div class="box-title c"> 
        <h1>当前界面：动动约》资源登记》场馆登记》<a class="nav-a"><?php echo (empty($model->id)) ? '添加' : '详情'; ?></a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?>
        <div class="box-detail-bd">
            <!-- <div style="display:block;" class="box-detail-tab-item"> -->
            <table>
                <tr class="table-title">
                    <td>场馆信息</td>
                </tr>
            </table>
            <table style="margin-top: -1px;">
                <tr>
                    <td><?php echo $form->labelEx($model, 'site_code'); ?></td>
                    <td> 
                        <?php if($sign == 'create'){?>
                        <?php echo '保存后自动生成';}?>
                        <?php if($sign == 'update'){?>
                        <?php echo $model->site_code;}?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'site_name'); ?></td>
                    <td> 
                        <?php echo $form->textField($model, 'site_name', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'site_name', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <?php setbkcolor(0);?>
                    <?php echo readData($form,$model,'contact_phone');?>
                    <td><?php echo $form->labelEx($model, 'site_level_name'); ?></td>
                    <td>
                        <?php echo $form->radioButtonList($model, 'site_level_name', ['1星'=>'1星','2星'=>'2星','3星'=>'3星','4星'=>'4星','5星'=>'5星'], array('separator'=>'', 'template'=>'<sclass="radio">{input} {label}</span> ')); ?>
                        <?php echo $form->error($model, 'site_level_name'); ?>
                    </td>
                </tr>
                <tr>
                    <?php echo readData($form,$model,'site_address:1:3');?>
                </tr>
            </table>
            <table style="margin-top: -1px;">
            <tr>
                <td colspan="1">操作</td>
                <td colspan="3">
                    <?php
                     echo show_shenhe_box(array('baocun'=>'保存'));  
                     echo show_shenhe_box(array('shenhe'=>'提交审核'));
                    ?>
                    <button class="btn" type="button" onclick="we.back();">取消</button>
                </td>
            </tr>
            </table>
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->