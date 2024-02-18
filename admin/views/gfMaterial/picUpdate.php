<div class="box">

    <div class="box-title c">
        <h1><i class="fa fa-table"></i>上传图片</h1>
     </div><!--box-title end-->

    <div class="box-detail">
       <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <table class="table-title">
            <tr>
                <td>图片信息</td>
            </tr>
        </table>
        <table>
  
        <table class="mt15">

        
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'v_title'); ?></td>
                <td width="85%">
                    <?php echo $form->textField($model, 'v_title', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'v_title', $htmlOptions = array()); ?>
                </td>
            </tr>

        
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'group_id'); ?></td>
                <td width="85%">
                    <?php echo $form->dropDownList($model, 'group_id', Chtml::listData($group, 'id', 'group_name'), array('prompt'=>'请选择')); ?>
                    <?php echo $form->error($model, 'group_id', $htmlOptions = array()); ?>
                </td>
            </tr>
            
            <tr >            
                <td><?php echo $form->labelEx($model, 'v_pic'); ?></td>
                <td >
                    <?php echo $form->hiddenField($model, 'v_pic', array('class' => 'input-text fl')); ?>
                    <?php $basepath=BasePath::model()->getPath(177);$picprefix='';
                    if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <?php if($model->v_pic!=''){?>
                            <div class="upload_img fl" id="upload_pic_v_pic">
                            <a href="<?php echo $basepath->F_WWWPATH.$model->v_pic;?>" target="_blank">
                            <img src="<?php echo $basepath->F_WWWPATH.$model->v_pic;?>" width="100"></a></div>
                        <?php }?>
                        <script>we.uploadpic('<?php echo get_class($model);?>_v_pic','<?php echo $picprefix;?>');</script>
                    <?php echo $form->error($model, 'v_pic', $htmlOptions = array()); ?>
                </td>
            </tr>

 
        </table>

        <!-- 隐藏域 -->

        <?php
            if (Yii::app()->session['club_id'] != null){
               echo $form->hiddenField($model, 'club_id', array('class' => 'input-text', 'value'=>Yii::app()->session['club_id'])); }

            if (Yii::app()->session['admin_id'] != null){
               echo $form->hiddenField($model, 'admin_id', array('class' => 'input-text', 'value'=>Yii::app()->session['admin_id'])); }

            echo $form->hiddenField($model, 'v_file_path', array('class' => 'input-text', 'value'=>$basepath->F_WWWPATH)); 
            echo $form->hiddenField($model, 'v_file_zt', array('class' => 'input-text', 'value'=>1)); 
            echo $form->hiddenField($model, 'v_type', array('class' => 'input-text', 'value'=>252));        

        ?>


        <div class="box-detail-submit">
            <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
            <a class="btn" href="<?php echo $this->createUrl('select/materialPicture', array('type'=>252));?>" >取消</a>
        </div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
