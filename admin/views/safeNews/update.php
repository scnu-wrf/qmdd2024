
<div class="box">
    <div class="box-title c">
    <h1><i class="fa fa-table"></i>保险信息详情</h1><span class="back">
    <a class="btn" href="javascript:;" onclick="we.back();">
    <i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table class="mt15">
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'news_code'); ?></td>
                        <td width="35%"><?php echo $model->news_code;?></td>
                        <td width="15%"><?php echo $form->labelEx($model, 'news_title'); ?></td>
                        <td width="35%">
                            <?php echo $form->textField($model, 'news_title', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'news_title', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'club_id'); ?></td>
                        <td>
                            <span id="club_box"><?php if($model->club_id!=null){?><span class="label-box"><?php echo $model->news_club_name;?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text')); ?></span><?php } else {?><span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value'=>get_session('club_id'))); ?></span><?php } ?></span>
                            <?php echo $form->error($model, 'club_id', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'news_introduction'); ?></td>
                        <td>
                          <?php echo $form->textArea($model,'news_introduction', array('class' => 'input-text', 'maxlength'=>'30' )); ?>
                          <?php echo $form->error($model, 'news_introduction', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'news_date_start'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'news_date_start', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'news_date_start', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'news_date_end'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'news_date_end', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'news_date_end', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'news_pic'); ?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'news_pic', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(256);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->news_pic!=''){?><div class="upload_img fl" id="upload_pic_SafeNews_news_pic"><a href="<?php echo $basepath->F_WWWPATH.$model->news_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->news_pic;?>" width="100"></a></div><?php }?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_news_pic','<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'news_pic', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'news_content'); ?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'news_content_temp', array('class' => 'input-text')); ?>
                            <script>we.editor('<?php echo get_class($model);?>_news_content_temp', '<?php echo get_class($model);?>[news_content_temp]');</script>
                            <?php echo $form->error($model, 'news_content_temp', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <div class="mt15">
            <table class="table-title"><tr> <td>审核信息</td></tr></table>
            <table>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                    <td width="85%">
                        <?php echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text' ,'value'=>'')); ?>
                        <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                	<td>可执行操作</td>
                    <td>
                    <?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核','tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                    <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div>
         
         <table class="showinfo">
            <tr>
                <th style="width:20%;">操作时间</th>
                <th style="width:20%;">操作人</th>
                <th style="width:20%;">状态</th>
                <th>操作备注</th>
            </tr>
            <tr>
                <td><?php echo $model->uDate; ?></td>
                <td><?php echo $model->state_qmddname; ?></td>
                <td><?php echo $model->state_name; ?></td>
                <td><?php echo $model->reasons_failure; ?></td>
            </tr>
        </table>
    <?php $this->endWidget();?>
  </div><!--box-detail end-->
</div><!--box end-->
<script>
we.tab('.box-detail-tab li','.box-detail-tab-item');
var club_id=0;
$('#SafeNews_news_date_start').on('click', function(){
WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
$('#SafeNews_news_date_end').on('click', function(){
WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});


//限制图集简介字数
function LimitText(op){
	 maxlimit = 50;
	 var textval=$(op).val();
	 if (textval.length > maxlimit) {
		 $(op).val(textval.substring(0, maxlimit));
		 we.msg('minus', '字数不得多于50！');
	 }
}



});
</script> 
