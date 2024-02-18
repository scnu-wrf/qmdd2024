<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>详细</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                    <tr class="table-title">
                        <td colspan="4">基本信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'gf_user_id'); ?></td>
                        <td><?php if(!empty($model->gf_user_id))echo $model->gf_user->GF_ACCOUNT; ?></td>
                        <td><?php echo $form->labelEx($model,'sc_facult'); ?></td>
                        <td><?php echo $form->textField($model,'sc_facult',array('class'=>'input-text')); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'sc_yeal'); ?></td>
                        <td><?php echo $form->textField($model,'sc_yeal',array('class'=>'input-text')); ?></td>
                        <td><?php echo $form->labelEx($model,'sc_code'); ?></td>
                        <td><?php echo $form->textField($model,'sc_code',array('class'=>'input-text')); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'sc_grade'); ?></td>
                        <td><?php echo $form->textField($model,'sc_grade',array('class'=>'input-text')); ?></td>
                        <td><?php echo $form->labelEx($model,'sc_class'); ?></td>
                        <td><?php echo $form->textField($model,'sc_class',array('class'=>'input-text')); ?></td>
                    </tr>
                    <tr>
                        <td>可执行操作</td>
                        <td colspan="3"><?php echo show_shenhe_box(array('baocun'=>'保存')); ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->