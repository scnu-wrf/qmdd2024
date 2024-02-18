<div class="box">
    <div class="box-title c">
        <h1><span>当前界面：系统 》积分/体育豆 》积分来源设置 》<?=empty($model->f_id)?'添加':'编辑';?></span></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div>
    <!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table width="100%" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">基本信息</td>
                    </tr>
                    <tr>
                        <td width="150px">
                            <?php echo $form->labelEx($model, 'code'); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'code', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'code', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->labelEx($model, 'object'); ?>
                        </td>
                        <td>
                            <?php echo $form->hiddenField($model, 'object', array('class' => 'input-text', 'value' => 1477)); ?>
                            服务置换积分
                            <?php echo $form->error($model, 'object', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            服务项目
                        </td>
                        <td>
                            <?php echo $form->dropDownList($model, 'item_type', Chtml::listData(BaseCode::model()->findAll('f_id in(1478) order by F_TYPECODE ASC'), 'f_id', 'F_NAME'), array('prompt' => '请选择')); ?>
                            <?php echo $form->error($model, 'item_type', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150px">
                            可获得积分
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'credit', array('class' => 'input-text','style' => 'width:25px;')); ?>
                            <?php echo $form->error($model, 'credit', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="3">
                            <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>
                </table>
            </div> <!--box-detail-tab-item end-->
        </div> <!--box-detail-bd end-->
        <?php $this->endWidget(); ?>
    </div> <!--box-detail end-->
</div> <!--box end-->