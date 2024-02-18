<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑录入属性</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
            <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table class="detail">
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'title'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'title', array('class' => 'input-text', 'style'=>'width:300px;')); ?>
                        <?php echo $form->error($model, 'title', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'logo'); ?>：</th>
                    <td>
                        <?php echo $form->hiddenField($model, 'logo', array('class' => 'input-text fl')); ?>
                        <?php $basepath=BasePath::model()->getPath(196);$picprefix='';
                            if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <?php if($model->logo!=''){?>
                        <div class="upload_img fl" id="upload_pic_GfFriendshipLink_logo">
                            <a href="<?php echo $basepath->F_WWWPATH.$model->logo;?>" target="_blank">
                                <img src="<?php echo $basepath->F_WWWPATH.$model->logo;?>" width="100">
                            </a>
                        </div>
                        <?php }?>
                        <script>we.uploadpic('<?php echo get_class($model);?>_logo','<?php echo $picprefix;?>');</script>
                        <?php echo $form->error($model, 'logo', $htmlOptions = array()); ?>
                    </td>
                    
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'link_address'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'link_address', array('class' => 'input-text', 'style'=>'width:300px;')); ?>
                        <?php echo $form->error($model, 'link_address', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'email'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'email', array('class' => 'input-text', 'style'=>'width:300px;')); ?>
                        <?php echo $form->error($model, 'email', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'udate'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'udate', array('class' => 'input-text', 'style'=>'width:300px;')); ?>
                        <?php echo $form->error($model, 'udate', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'state_qmddname'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'state_qmddname', array('class' => 'input-text', 'style'=>'width:300px;')); ?>
                        <?php echo $form->error($model, 'state_qmddname', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                	<td>可执行操作：</td>
                    <td>
                    	<?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核','tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'reasons_failure'); ?>：</th>
                    <td width:>
                        <?php echo $form->textField($model, 'reasons_failure', array('class' => 'input-text', 'style'=>'width:300px;')); ?>
                        <!--<?php echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text' ,'value'=>'')); ?>-->
                        <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
            <table class="showinfo">
                <tr>
                    <th style="width:20%;border:solid 1px #d9d9d9;">操作时间</th>
                    <th style="width:20%;border:solid 1px #d9d9d9;">操作人</th>
                    <th style="width:20%;border:solid 1px #d9d9d9;">审核状态</th>
                    <th style="border:solid 1px #d9d9d9;">操作备注</th>
                </tr>
                <tr>
                    <td style="border:solid 1px #d9d9d9;"><?php echo $model->udate; ?></td>
                    <td style="border:solid 1px #d9d9d9;"><?php echo $model->state_qmddname; ?></td>
                    <td style="border:solid 1px #d9d9d9;"><?php echo $model->state_name; ?></td>
                    <td style="border:solid 1px #d9d9d9;"><?php echo $model->reasons_failure; ?></td>
                </tr>
            </table>
            <?php $this->endWidget(); ?>
        </div><!--box-table end-->
    </div><!--box-content end-->
</div><!--box end-->
