<div class="box">
    <div class="box-title c">
    <h1><i class="fa fa-table"></i>社区服务者</h1><span class="back">
    <a class="btn" href="javascript:;" onclick="we.back();">
    <i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list());      ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table class="mt15">
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'qcode'); ?></td>
                <td width="35%"><?php echo $model->qualifications_person->qcode;?></td>
                <td width="15%"><?php echo $form->labelEx($model, 'qualification_gfaccount'); ?></td>
                <td width="35%">
            <span class="label-box"><?php echo $model->qualifications_person->qualification_gfaccount;?></span></span>
                 </td>
        </tr>
        <tr>
            <td ><?php echo $form->labelEx($model, 'qualification_name'); ?></td>
            <td ><?php echo $model->qualifications_person->qualification_name; ?></td>
            <td ><?php echo $form->labelEx($model, 'qualification_title'); ?></td>
            <td ><?php echo $model->qualifications_person->qualification_title; ?></td>
         </tr>
        <tr>
          <td ><?php echo $form->labelEx($model, 'qualification_project_id'); ?></td>
          <td ><span class="label-box"><?php echo $model->qualifications_person->qualification_project_name;?></span></td>
          <td ><?php echo $form->labelEx($model, 'qualification_type'); ?></td>
          <td ><span class="label-box"><?php echo $model->qualifications_person->qualification_type;?></span></td>
          </tr>
        <tr>
    <tr>
        <td ><?php echo $form->labelEx($model, 'qualification_code'); ?></td>
        <td ><span class="label-box"><?php echo $model->qualifications_person->qualification_code;?></span></td>
        <td ><?php echo $form->labelEx($model, 'qualification_time'); ?></td>
        <td ><span class="label-box"><?php echo $model->qualifications_person->qualification_code;?></span> </td>
    </tr>     
    <tr>
        <td ><?php echo $form->labelEx($model, 'start_date'); ?></td>
        <td ><span class="label-box"><?php echo $model->qualifications_person->qualification_code;?></span> </td>
        <td ><?php echo $form->labelEx($model, 'end_date'); ?></td>
        <td ><span class="label-box"><?php echo $model->qualifications_person->qualification_code;?></span>
      </td>
    </tr>     
    <td ><?php echo $form->labelEx($model, 'qualification_code_year'); ?></td>
    <td >
     <span class="label-box"><?php echo $model->qualifications_person->qualification_code;?></span>
  </td>
    <td ><?php echo $form->labelEx($model, 'qualification_code_num'); ?></td>
    <td >
   <span class="label-box"><?php echo $model->qualifications_person->qualification_code;?></span>
  </td>
<tr>
    <td ><?php echo $form->labelEx($model, 'qualification_gf_code'); ?></td>
    <td >
    <span class="label-box"><?php echo $model->qualifications_person->qualification_code;?></span>
  </td>
    <td ><?php echo $form->labelEx($model, 'qualification_identity_num'); ?></td>
    <td >
    <span class="label-box"><?php echo $model->qualifications_person->qualification_code;?></span>
    </td>
    </tr>     
    <tr>
         <td ><?php echo $form->labelEx($model, 'qualification_level'); ?></td>
        <td >
          <span class="label-box"><?php echo $model->qualifications_person->qualification_code;?></span>
        </td>

         <td ><?php echo $form->labelEx($model, 'if_apply_display'); ?></td>
        <td width="35%">
       <span class="label-box"><?php echo $model->qualifications_person->qualification_code;?></span>
        </td>
        </tr>
     
 <td><?php echo $form->labelEx($model, 'qualification_pic'); ?></td>
    <td colspan="3">
 <?php echo $form->hiddenField($model, 'qualification_pic',array('class' => 'input-text','value'=>'')); ?>
                <div class="upload_img fl" id="upload_pic_scroll_qualification_pic">
                <?php $basepath=BasePath::model()->getPath(143);$picprefix='';
                if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                $qualification_pic=explode(',',$model->qualifications_person->qualification_pic);
                foreach($qualification_pic as $v) if(!empty($v))
                    {?>
                <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v;?>" width="100">
                <i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i></a>
                <?php }?>
                </div>
        <script>
          we.uploadpic('<?php echo get_class($model);?>_scroll_qualification_pic','<?php echo $picprefix;?>','','',function(e1,e2){fnscrollPic(e1.savename,e1.allpath);},5);
            </script>
                <?php echo $form->error($model, 'qualification_pic', $htmlOptions = array()); ?>
            </td>
        </tr>
      
    </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <!--div class="mt15">
            <table class="table-title"><tr> <td>审核信息</td></tr></table>
            <table>
                <tr>
                    <td width="15%"><php echo $form->labelEx($model, 'state'); ?></td>
                    <td width="35%">
                        <php echo $form->radioButtonList($model, 'state', Chtml::listData(BaseCode::model()->getShenheState(), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <php echo $form->error($model, 'state'); ?>
                    </td>
                    <td width="15%"><php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                    <td width="35%">
                       <php echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text' )); ?>
                        <php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
        </div-->
        <div class="box-detail-submit">
          <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
          <button onclick="submitType='shenhe'" class="btn btn-blue" type="submit">提交审核</button>
          <button class="btn" type="button" onclick="we.back();">取消</button>
         </div>
<?php $this->endWidget();?>
<script>
 we.tab('.box-detail-tab li','.box-detail-tab-item');
$('#ClubQualificationPerson_qualification_time').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
$('#ClubQualificationPerson_start_date').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
$('#ClubQualificationPerson_end_date').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});

// 滚动图片处理
var $upload_pic_pic=$('#upload_pic_scroll_qualification_pic');
var $upload_box_pic=$('#upload_box_scroll_qualification_pic');
var $scroll_pic_img=$('#ClubQualificationPerson_scroll_qualification_pic');


// 添加或删除时，更新图片
var fnUpdatescrollPic=function(){
    var arr=[];var s1="";
    $upload_pic_pic.find('a').each(function(){
         s1=$(this).attr('data-savepath');
      //  console.log(s1);
        if(s1!=""){
        arr.push($(this).attr('data-savepath'));}
    });
    $('#ClubQualificationPerson_qualification_pic').val(we.implode(',',arr));
    $upload_box_pic.show();
    if(arr.length>=5) {  $upload_box_pic.hide();}
};
// 上传完成时图片处理
var fnscrollPic=function(savename,allpath){
    $upload_pic_pic.append('<a class="picbox" data-savepath="'+
    savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i></a>');
    fnUpdatescrollPic();
};

// 选择服务者
$('#account_select_btn').on('click', function(){ 
    $.dialog.data('select_data', 0);
    $.dialog.open('<?php echo $this->createUrl("select/gfuser");?>',{
    id:'select_data_id',lock:true,opacity:0.3,  width:'500px',height:'60%',
    title:'选择具体内容',
    close: function () {
        //console.log($.dialog.data('club_id'));
        if($.dialog.data('gfid')>0){
        $('#qualification_gfaccount_show').html('<span class="label-box">'+$.dialog.data('gfaccount')+'</span>');
        $('#ClubQualificationPerson_qualification_gfaccount').val($.dialog.data('gfaccount'));
        $('#ClubQualificationPerson_gfid').val($.dialog.data('gfid'));
        $('#ClubQualificationPerson_qualification_name').val($.dialog.data('gfname'));
       }
    }
    });
});
    

</script> 
  </div><!--box-detail end-->
</div><!--box end-->


