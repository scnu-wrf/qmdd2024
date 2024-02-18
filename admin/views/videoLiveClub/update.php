<?php if($flag==1){
    $txt='编辑';
} else{    
    $txt='添加';
}
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播》直播单位》直播单位申请》<a class="nav-a"><?php echo $txt; ?></a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
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
                    <td width="35%"><?php echo $form->textField($model, 'club_code', array('class' => 'input-text','oninput' =>'codeOnchange(this)','onpropertychange' =>'codeOnchange(this)')); ?>
                        <?php echo $form->error($model, 'title', $htmlOptions = array()); ?>
                    </td>
                    <?php echo $form->hiddenField($model, 'club_id'); ?>
                    <td width="15%"><?php echo $form->labelEx($model, 'club_name'); ?></td>
                    <td width="35%"><?php echo $form->textField($model, 'club_name', array('class' => 'input-text','disabled'=>'true')); ?></td>
                </tr>
                <?php echo $form->hiddenField($model, 'club_type'); ?>
                <?php echo $form->hiddenField($model, 'partnership_type'); ?>
                <?php //echo $form->hiddenField($model, 'partnership_name'); ?>
                <tr>
                    <td><?php echo $form->labelEx($model, 'apply_name'); ?></td>
                    <td><?php echo $form->textField($model, 'apply_name', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'apply_name', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'contact_phone'); ?></td>
                    <td><?php echo $form->textField($model, 'contact_phone', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'contact_phone', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'email'); ?></td>
                    <td><?php echo $form->textField($model, 'email', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'email', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'contact_address'); ?></td>
                    <td><?php echo $form->textField($model, 'contact_address', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'contact_address', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'server_type'); ?></td>
                    <td colspan="3">
                        <?php echo $form->checkBoxList($model, 'server_type', Chtml::listData(VideoClassify::model()->getCode(366), 'id', 'sn_name'),
                          $htmlOptions = array('separator' => '', 'class' => 'input-check', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?>
                         <?php echo $form->error($model, 'server_type'); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <?php echo $form->checkBoxList($model, 'is_read', array(649=>'已阅读并同意'),
                              $htmlOptions = array('separator' => '', 'class' => 'input-check', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?>
    《<a href="https://gw.gfinter.net/?device_type=7&c=info&a=page_switch&category=rule&page=video_live_agreement" target="_bank">GF平台直播功能开通服务协议</a>》
                    </td>
                </tr>                                    
            </table>
        </div><!--box-detail-bd end-->
        <div id="operate" class="mt15" style="text-align:center;">
        <?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));?>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>
            
<?php $this->endWidget(); ?>
  </div><!--box-detail end-->
</div><!--box end-->
<script>

$(function(){
   
    $('#operate .btn-blue:eq(1)').on('click',function(){
        var is_read=$("#VideoLiveClub_is_read input[type='checkbox']").prop("checked");
        if(is_read==false){
            we.msg('minus','请先阅读并同意《直播服务协议》');
            return false;
        }

    });

});

//输入单位帐号获取单位信息      
function codeOnchange(obj){
  var changval=$(obj).val();
  //console.log(changval); 
  if (changval.length==10) {
      $.ajax({
        type: 'post',
        url: '<?php echo $this->createUrl('validate');?>&code='+changval,
        data: {code:changval},
        dataType: 'json',
        success: function(data) {
            if(data.status==1){
                $('#VideoLiveClub_club_id').val(data.club_id);
                $('#VideoLiveClub_club_name').val(data.club_name);
                $('#VideoLiveClub_club_type').val(data.club_type);
                $('#VideoLiveClub_partnership_type').val(data.partnership_type);
                //$('#VideoLiveClub_partnership_name').val(data.partnership_name);
                $('#VideoLiveClub_apply_name').val(data.apply_name);
                $('#VideoLiveClub_contact_address').val(data.contact_address);
                $('#VideoLiveClub_contact_phone').val(data.contact_phone);
                $('#VideoLiveClub_email').val(data.email);
            }else{
                we.msg('minus', '帐号有误，没有获取到单位信息');
            }
        }
    });

  }
}


	
</script>
