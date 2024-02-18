<div class="box">
    <div class="box-title c">
        <h1><span>当前界面：系统 》积分/体育豆 》积分兑换活动 》<?=empty($model->f_id)?'添加':'编辑';?></span></h1>
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
                        <td>兑换类型</td>
                        <td>
                            <?php echo $form->dropDownList($model, 'object', Chtml::listData(BaseCode::model()->findAll('f_id in(734,735) order by F_TYPECODE ASC'), 'f_id', 'F_NAME'), array('prompt' => '请选择')); ?>
                            <?php echo $form->error($model, 'object', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>兑换内容</td>
                        <td>
                            <?php echo $form->dropDownList($model, 'item_type', Chtml::listData(BaseCode::model()->findAll('f_id in(734) order by F_TYPECODE ASC'), 'f_id', 'F_NAME'), array('prompt' => '请选择')); ?>
                            <?php echo $form->error($model, 'item_type', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150px">兑换比例</td>
                        <td>
                            <?php echo $form->textField($model, 'credit', array('class' => 'input-text','style' => 'width:25px;')); ?>
                            :
                            <?php echo $form->textField($model, 'beans', array('class' => 'input-text','style' => 'width:25px;')); ?>
                            <?php echo $form->error($model, 'credit', $htmlOptions = array()); ?>
                            <?php echo $form->error($model, 'beans', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150px">
                            <?php echo $form->labelEx($model, 'beans_num'); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'beans_num', array('class' => 'input-text','style' => 'width:130px;')); ?>
                            <?php echo $form->error($model, 'beans_num', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150px">
                            <?php echo $form->labelEx($model, 'beans_date_start'); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'beans_date_start', array('class' => 'input-text','style' => 'width:130px;')); ?>
                            至
                            <?php echo $form->textField($model, 'beans_date_end', array('class' => 'input-text','style' => 'width:130px;')); ?>
                            <?php echo $form->error($model, 'beans_date_start', $htmlOptions = array()); ?>
                            <?php echo $form->error($model, 'beans_date_end', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150px">
                            <?php echo $form->labelEx($model, 'if_use'); ?>
                        </td>
                        <td>
                            <?php echo $form->radioButtonList($model, 'if_use', array(648 => '否', 649 => '是'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                            <?php echo $form->error($model, 'if_use'); ?>
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
<?php 
    $s1 = 'f_id,F_NAME';
    $s2 = BaseCode::model()->findAll('f_id in(734) order by F_TYPECODE ASC');
    $arr = toArray($s2,$s1);
?>
<script>
    $('#GfCredit_beans_date_start,#GfCredit_beans_date_end').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd HH:mm:ss'});
    });

    var data = <?php echo json_encode($arr); ?>;
    $("#GfCredit_object").on("change",function(){
        if($(this).val()==734){
            var content='<option value="">请选择</option>';
            console.log(data)
            $.each(data,function(k,info){
                content+='<option value="'+info.f_id+'">'+info.F_NAME+'</option>';
            })
            $("#GfCredit_item_type").html(content);
        }else if($(this).val()==735){ //目前没有积分兑换礼物选项
            $("#GfCredit_item_type").html('<option value="">请选择</option>');
        }
    })


</script>