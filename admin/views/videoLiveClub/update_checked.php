<?php
$txt='';
if(!isset($_REQUEST['flag'])){
        $_REQUEST['flag']='live';
}
$flag=$_REQUEST['flag'];
if($flag=='index'){
    $txt='直播单位申请》';
} elseif ($flag=='checked') {
    $txt='直播单位审核》待审核》';
} elseif ($flag=='fail') {
    $txt='取消/审核未通过》';
} elseif ($flag=='live') {
    $txt='直播单位列表》';
} elseif ($flag=='pass') {
    $txt='直播单位审核》';
}
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播》直播单位》<?php echo $txt; ?><a class="nav-a">详情</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table class="table-title">
                <tr>
                    <td>基本信息</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model, 'club_code'); ?></td>
                    <td width="35%"><?php echo $form->textField($model, 'club_code', array('class' => 'input-text','disabled'=>'true')); ?>
                        <?php echo $form->error($model, 'title', $htmlOptions = array()); ?>
                    </td>
                    <?php echo $form->hiddenField($model, 'club_id'); ?>
                    <td width="15%"><?php echo $form->labelEx($model, 'club_name'); ?></td>
                    <td width="35%"><?php echo $form->textField($model, 'club_name', array('class' => 'input-text','disabled'=>'true')); ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'apply_name'); ?></td>
                    <td><?php echo $model->apply_name; ?></td>
                    <td><?php echo $form->labelEx($model, 'contact_phone'); ?></td>
                    <td><?php echo $model->contact_phone; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'email'); ?></td>
                    <td><?php echo $model->email; ?></td>
                    <td><?php echo $form->labelEx($model, 'contact_address'); ?></td>
                    <td><?php echo $model->contact_address; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'server_type'); ?></td>
                    <td colspan="3">
                        <?php echo $form->checkBoxList($model, 'server_type', Chtml::listData(VideoClassify::model()->getCode(366), 'id', 'sn_name'),
                          $htmlOptions = array('separator' => '', 'class' => 'input-check','disabled'=>'true', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?>
                         <?php echo $form->error($model, 'server_type', $htmlOptions = array()); ?>
                    </td>
                </tr>                                    
            </table>
        </div><!--box-detail-bd end-->
        <div class="mt15" style="text-align:center;">
        <?php echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>
            
<?php $this->endWidget(); ?>
  </div><!--box-detail end-->
</div><!--box end-->
