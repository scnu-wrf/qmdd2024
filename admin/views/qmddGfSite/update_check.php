<div class="box">
    <div class="box-title c"> 
        <h1>当前界面：动动约》场馆管理》场馆审核》<a class="nav-a">待审核</a></h1>
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
                        <?php echo $model->site_code;?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'site_name'); ?></td>
                    <td> 
                        <?php echo $model->site_name;?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'contact_phone'); ?></td>
                    <td> 
                        <?php echo $model->contact_phone;?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'site_level_name'); ?></td>
                    <td> 
                        <?php echo $model->site_level_name;?>
                    </td>
                </tr>
                <tr>
                    <td colspan="1"><?php echo $form->labelEx($model, 'site_address'); ?></td>
                    <td colspan="3"> 
                        <?php echo $model->site_address;?>
                    </td>
                </tr>
                <tr>
                    <?php setbkcolor(0);?>
                    <?php echo readData($form,$model,'reasons_failure:1:3');?>
                </tr>
            </table>
            <table style="margin-top: -1px;">
            <tr>
                <td colspan="1">操作</td>
                <td colspan="3">
                    <?php
                     echo show_shenhe_box(array('pass'=>'审核通过'));  
                     echo show_shenhe_box(array('notpass'=>'审核不通过'));
                    ?>
                    <button class="btn" type="button" onclick="we.back();">取消</button>
                </td>
            </tr>
            </table>
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->