<?php

    $pid=Yii::app()->request->getParam('p_id');

     if(isset($pid)) { 
        $project_list=$pid;
     }else{
        $project_list=array();
     }                
?>

<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>添加导购</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
       <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <table class="table-title">
            <tr>
                <td>导购信息</td>
            </tr>
        </table>
        <table>

<!--                    'project_id'=>'项目Id',
            'club_star'=>'单位星级（0-9星）ID，关联member_card表ID',
            'club_star_name'=>'等级名称',
            'synthesize_num'=>'实物综合商品导购窗口数量',
            'profession_num'=>'实物专业商品导购窗口数量',
            'single_profession_num'=>'实物单件专业商品导购件数',
            'digital_synthesize_num'=>'数字综合商品导购窗口数量',
            'digital_profession_num'=>'数字专业商品导购窗口数量',
            'digital_single_profession_num'=>'数字单件专业商品导购件数',
            'shopping_days'=>'可导购天数', -->    

        <table class="mt15">
            <tr>
                <td width="20%"><?php echo $form->labelEx($model, 'project_list'); ?></td>
                <td width="80%">
                    <?php
                    $model->project_list=Yii::app()->request->getParam('p_id');
                    echo $form->dropDownList($model, 'project_list', Chtml::listData(ProjectList::model()->findAll  
                            (array(
                            'condition' => 'project_type=1',
                            // 'order' => 'project_name ASC',
                            )), 'id', 'project_name'), array('prompt'=>'请选择')); 
                     echo $form->error($model, 'project_list', $htmlOptions = array()); ?>
                </td>
            </tr>

            <tr>
                <td width="20%"><?php echo $form->labelEx($model, 'club_star'); ?></td>
                <td width="80%">
                    <?php
                    echo $form->dropDownList($model, 'club_star', Chtml::listData(MemberCard::model()->findAll() , 'f_id', 'card_name'), array('prompt'=>'请选择')); 
                     echo $form->error($model, 'club_star', $htmlOptions = array()); ?>

                </td>
            </tr>            

            <tr>
                <td width="20%"><?php echo $form->labelEx($model, 'synthesize_num'); ?></td>
                <td width="80%">
                    <?php echo $form->textField($model, 'synthesize_num', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'synthesize_num', $htmlOptions = array()); ?>
                </td>
            </tr>

            <tr>
                <td width="20%"><?php echo $form->labelEx($model, 'profession_num'); ?></td>
                <td width="80%">
                    <?php echo $form->textField($model, 'profession_num', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'profession_num', $htmlOptions = array()); ?>
                </td>
            </tr>


            <tr>
                <td width="20%"><?php echo $form->labelEx($model, 'single_profession_num'); ?></td>
                <td width="80%">
                    <?php echo $form->textField($model, 'single_profession_num', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'single_profession_num', $htmlOptions = array()); ?>
                </td>
            </tr>

            <tr>
                <td width="20%"><?php echo $form->labelEx($model, 'digital_synthesize_num'); ?></td>
                <td width="80%">
                    <?php echo $form->textField($model, 'digital_synthesize_num', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'digital_synthesize_num', $htmlOptions = array()); ?>
                </td>
            </tr>

            <tr>
                <td width="20%"><?php echo $form->labelEx($model, 'digital_profession_num'); ?></td>
                <td width="80%">
                    <?php echo $form->textField($model, 'digital_profession_num', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'digital_profession_num', $htmlOptions = array()); ?>
                </td>
            </tr>

            <tr>
                <td width="20%"><?php echo $form->labelEx($model, 'digital_single_profession_num'); ?></td>
                <td width="80%">
                    <?php echo $form->textField($model, 'digital_single_profession_num', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'digital_single_profession_num', $htmlOptions = array()); ?>
                </td>
            </tr>

            <tr>
                <td width="20%"><?php echo $form->labelEx($model, 'shopping_days'); ?></td>
                <td width="80%">
                    <?php echo $form->textField($model, 'shopping_days', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'shopping_days', $htmlOptions = array()); ?>
                </td>
            </tr>
            

        </table>


        <div class="box-detail-submit"><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button><button class="btn" type="button" onclick="we.back();">取消</button></div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
