<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>当前界面：点/直播管理>打赏礼物设置与管理>打赏礼物类型><a class="nav-a">详情</a></h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a>
        </span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list());?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <div>
                    <table style="table-layout:auto;">
                        <tr class="table-title">
                            <td colspan="2">类型信息</td>
                        </tr>
                        <tr>
                            <td style="width:15%;"><?php echo $form->labelEx($model,'interact_type'); ?></td>
                            <td style="width:85%;">
                                <?php echo $form->dropDownList($model,'interact_type',Chtml::listData(BaseCode::model()->getCode(1393),'f_id','F_NAME'),array('prompt'=>'请选择')); ?>
                                <?php echo $form->error($model, 'interact_type', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model,'code'); ?></td>
                            <td>
                                <?php echo $form->textField($model,'code',array('class'=>'input-text','style'=>'width:10%;')); ?>
                                <?php echo $form->error($model, 'code', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model,'name'); ?></td>
                            <td>
                                <?php echo $form->textField($model,'name',array('class'=>'input-text','style'=>'width:10%;')); ?>
                                <?php echo $form->error($model, 'name', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model,'is_use'); ?></td>
                            <td><?php echo $form->radioButtonList($model,'is_use',Chtml::listData(BaseCode::model()->getCode(647),'f_id','F_NAME'),$htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?></td>
                        </tr>
                    </table>
                </div>
            </div><!--box-detail-tab-item end   style="display:block;"-->
        </div><!--box-detail-bd end-->
        <div class="box-detail-submit">
            <?php echo show_shenhe_box(array('baocun'=>'保存')); ?>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->