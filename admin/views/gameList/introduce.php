
<div class="box">
    <div class="box-title c">
    <h1><i class="fa fa-table"></i>介绍详情</h1><span class="back">
    <a class="btn" href="javascript:;" onclick="we.back();">
    <i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
     	
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
            	<table border="0" cellspacing="1" cellpadding="0" class="product_publish_content">

                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'intro_title'); ?></td>
                        <td width="85%"><?php echo $form->textField($model, 'intro_title', array('class' => 'input-text')); ?></td>
                        
                    </tr>
                    <tr>
                        
                        <td><?php echo $form->labelEx($model, 'intro_title_en'); ?></td>
                        <td><?php echo $form->textField($model, 'intro_title_en', array('class' => 'input-text')); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'intro_simple_content'); ?></td>
                        <td>
                          <?php echo $form->textArea($model,'intro_simple_content', array('class' => 'input-text', 'maxlength'=>'30' )); ?>
                          <p>*简短介绍，最多可输入30个字符，含数字特殊符号：-&nbsp;/&nbsp;\&nbsp;等；</p>
                          <?php echo $form->error($model, 'intro_simple_content', $htmlOptions = array()); ?>
                        </td>

                    </tr>

                    <tr >
                        <td><?php echo $form->labelEx($model, 'entry_information_url'); ?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'entry_information_url_temp', array('class' => 'input-text')); ?>
                            <script>we.editor('<?php echo get_class($model);?>_entry_information_url_temp', '<?php echo get_class($model);?>[entry_information_url_temp]');</script>
                            <?php echo $form->error($model, 'entry_information_url_temp', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                      
                </table>
            </div><!--box-detail-tab-item end-->

            <div class="box-detail-submit">
              <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
              <button class="btn" type="button" onclick="we.back();">取消</button>
            </div>
         
        
            
        </div><!--box-detail-bd end-->
    <?php $this->endWidget();?>
  </div><!--box-detail end-->
</div><!--box end-->
