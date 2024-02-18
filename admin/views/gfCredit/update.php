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
                        <td colspan="2">
                            <?php echo $form->textField($model, 'code', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'code', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->labelEx($model, 'object'); ?>
                        </td>
                        <td colspan="2">
                            <?php echo $form->hiddenField($model, 'object', array('class' => 'input-text', 'value' => 1476)); ?>
                            消费置换积分
                            <?php echo $form->error($model, 'object', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->labelEx($model, 'item_type'); ?>
                        </td>
                        <td colspan="2">
                            <?php echo $form->dropDownList($model, 'item_type', Chtml::listData(BaseCode::model()->findAll('f_id in(675,351,359,357,358,355,1162) order by F_TYPECODE ASC'), 'f_id', 'F_NAME'), array('prompt' => '请选择')); ?>
                            <?php echo $form->error($model, 'item_type', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->labelEx($model, 'consumer_type'); ?>
                        </td>
                        <td colspan="2">
                            <?php echo $form->dropDownList($model, 'consumer_type', Chtml::listData(BaseCode::model()->findAll('f_id in(210,1124,1467,1479)'), 'f_id', 'F_NAME'), array('prompt' => '请选择')); ?>
                            <?php echo $form->error($model, 'consumer_type', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150px">
                            <?php echo $form->labelEx($model, 'value'); ?>
                        </td>
                        <td colspan="2">
                            <?php echo $form->textField($model, 'value', array('class' => 'input-text','style' => 'width:25px;')); ?>
                            元 :
                            <?php echo $form->textField($model, 'credit', array('class' => 'input-text','style' => 'width:25px;')); ?>
                            积分
                            <?php echo $form->error($model, 'value', $htmlOptions = array()); ?>
                            <?php echo $form->error($model, 'credit', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150px" rowspan="4">归属单位积分比例</td>
                        <td width="150px">
                            <?php echo $form->labelEx($model, 'item_value'); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'item_value', array('class' => 'input-text','style' => 'width:25px;')); ?>
                            元 :
                            <?php echo $form->textField($model, 'gredit', array('class' => 'input-text','style' => 'width:25px;')); ?>
                            积分
                            <?php echo $form->error($model, 'item_value', $htmlOptions = array()); ?>
                            <?php echo $form->error($model, 'gredit', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150px">
                            <?php echo $form->labelEx($model, 'sqdw_value'); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'sqdw_value', array('class' => 'input-text','style' => 'width:25px;')); ?>
                            元 :
                            <?php echo $form->textField($model, 'sqdw_gredit', array('class' => 'input-text','style' => 'width:25px;')); ?>
                            积分
                            <?php echo $form->error($model, 'sqdw_value', $htmlOptions = array()); ?>
                            <?php echo $form->error($model, 'sqdw_gredit', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150px">
                            <?php echo $form->labelEx($model, 'zlhb_value'); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'zlhb_value', array('class' => 'input-text','style' => 'width:25px;')); ?>
                            元 :
                            <?php echo $form->textField($model, 'zlhb_gredit', array('class' => 'input-text','style' => 'width:25px;')); ?>
                            积分
                            <?php echo $form->error($model, 'zlhb_value', $htmlOptions = array()); ?>
                            <?php echo $form->error($model, 'zlhb_gredit', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150px">
                            <?php echo $form->labelEx($model, 'sjyj_value'); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'sjyj_value', array('class' => 'input-text','style' => 'width:25px;')); ?>
                            元 :
                            <?php echo $form->textField($model, 'sjyj_gredit', array('class' => 'input-text','style' => 'width:25px;')); ?>
                            积分
                            <?php echo $form->error($model, 'sjyj_value', $htmlOptions = array()); ?>
                            <?php echo $form->error($model, 'sjyj_gredit', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150px">
                            <?php echo $form->labelEx($model, 'remark'); ?>
                        </td>
                        <td colspan="2">
                            <?php echo $form->textArea($model, 'remark', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'remark', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="2">
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