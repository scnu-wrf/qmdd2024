
<style>
    #editor_ClubList_about_me_temp{
        height: 100%;
    }
    #edui1{
        height: 100%;
    }
    #edui1_iframeholder{
        height: 300px!important;
    }
</style>
<div class="box">
    <div class="box-title c"><h1>当前界面：首页 》关于我们 》关于我们</h1></div><!--box-title end-->
    <div class="box-detail">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?>
        <div class="box-detail-bd">
            <table id="t3">
                <tr>
                    <td style="width:150px;">发布单位</td>
                    <td>
                        <?php echo $model->company;?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'about_me'); ?></td>
                    <td style="height:400px;">
                        <?php echo $form->hiddenField($model, 'about_me_temp', array('class' => 'input-text')); ?>
                        <script>we.editor('<?php echo get_class($model);?>_about_me_temp', '<?php echo get_class($model);?>[about_me_temp]');</script>
                        <?php echo $form->error($model, 'about_me_temp', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <?php if(empty($_REQUEST['is_use'])){?>
                <tr style="text-align:center;">
                    <td colspan="2">
                        <button id="jieshao" onclick="submitType='jieshao'" class="btn btn-blue" type="submit"> 保存</button>&nbsp;<button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
                <?php }?>
            </table>
        </div><!--box-detail-bd-->
        <?php $this->endWidget(); ?>
    </div><!--box-detail-->
</div><!--box end-->
