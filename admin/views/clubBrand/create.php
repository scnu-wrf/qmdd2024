<div class="box">
    <div class="box-title c"><h1>当前界面：商城》品牌管理》发布品牌》添加</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>

        <table class="table-title">
            <tr>
                <td>品牌信息</td>
            </tr>
        </table>
       <table style="table-layout:auto;" width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'brand_title'); ?></td>
                <td width="35%">
                    <?php echo $form->textField($model, 'brand_title', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'brand_title', $htmlOptions = array()); ?>
                </td>
<!--                <td width="15%"><?php //echo $form->labelEx($model, 'brand_logo_pic'); ?></td>
                <td width="35%">
                    <?php //echo $form->hiddenField($model, 'brand_logo_pic', array('class' => 'input-text fl')); ?>
                    <?php //$basepath=BasePath::model()->getPath(167);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                    <script>we.uploadpic('<?php //echo get_class($model);?>_brand_logo_pic','<?php //echo $picprefix;?>');</script>
                    <?php //echo $form->error($model, 'brand_logo_pic', $htmlOptions = array()); ?>
                </td>-->
            </tr>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'brand_type_id'); ?></td>
                <td width="35%">
 <?php if(!empty($model->id)&&$model->state!=721){echo $form->dropDownList($model, 'brand_type_id', Chtml::listData(BaseCode::model()->getCode(1444), 'f_id', 'F_NAME'), array('prompt'=>'请选择',"disabled"=>"disabled" ));}else{echo $form->dropDownList($model, 'brand_type_id', Chtml::listData(BaseCode::model()->getCode(1444), 'f_id', 'F_NAME'), array('prompt'=>'请选择'));} ?>
                    <?php echo $form->error($model, 'brand_type_id', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'brand_logo_pic'); ?></td>
                <td width="35%">
                   <?php echo $form->hiddenField($model, 'brand_logo_pic', array('class' => 'input-text fl')); ?>
                    <?php $basepath=BasePath::model()->getPath(167);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                    <script>we.uploadpic('<?php echo get_class($model);?>_brand_logo_pic','<?php echo $picprefix;?>');</script>
                    <?php echo $form->error($model, 'brand_logo_pic', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'brand_certificate'); ?></td>
                <td width="35%">
                      <?php $base_path=BasePath::model()->getPath(204);$pic_prefix='';if($base_path!=null){ $pic_prefix=$base_path->F_CODENAME; }?>
                            <?php echo $form->hiddenField($model, 'brand_certificate', array('class' => 'input-text')); ?>
                            <div class="upload_img fl" id="upload_pic_ClubBrand_brand_certificate">
                                <?php 
                                foreach($brand_certificate as $v) if($v) {?>
                                <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $base_path->F_WWWPATH.$v;?>" target="_blank"><img src="<?php echo $base_path->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px;"><i onclick="$(this).parent().remove();fnUpdateScrollpic();return false;"></i></a>
                                <?php }?>
                            </div>
                    <script>
                              
                      we.uploadpic('<?php echo get_class($model);?>_brand_certificate','<?php echo $pic_prefix;?>','','',function(e1,e2){ fnScrollpic(e1.savename,e1.allpath);},50);
                        </script>
                        <span>注：规格1080px*809px 1-5张</span>
                            <?php echo $form->error($model, 'brand_certificate', $htmlOptions = array()); ?>
                </td>

            </tr>
            
            
            <tr>
                <td><?php echo $form->labelEx($model, 'brand_content'); ?>：</th>
                <td colspan="3">
				<?php echo $form->textArea($model, 'brand_content', array('style'=>'width:100%;height:90px;')); ?>
				<?php echo $form->error($model, 'brand_content', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                            <td width="15%">可执行操作</td>
                            <td>
                        <?php 
                                  echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));?>
                                <button class="btn" type="button" onclick="we.back();">取消</button>
                            </td>
                        </tr>
        </table>

        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
$(function(){
    var $start_time=$('#<?php echo get_class($model);?>_brand_date_begin');
    var $end_time=$('#<?php echo get_class($model);?>_brand_date_end');
	$start_time.on('click', function(){
WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
$end_time.on('click', function(){
WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss '});});

});


</script>
<script>
// 删除已添加项目
var fnDeleteProject=function(op){
    $(op).parent().remove();
    fnUpdateProject();
};
// 项目添加或删除时，更新
var fnUpdateProject=function(){
    var arr=[];
    $('#project_box span').each(function(){
        arr.push($(this).attr('data-id'));
    });
    $('#MallBrandStreet_project_list').val(we.implode(',',arr));
};
fnUpdateProject();


$(function(){
    // 添加项目
    var $project_box=$('#project_box');
    $('#project_add_btn').on('click', function(){
        $.dialog.data('project_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/project");?>',{
            id:'xiangmu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('project_id')==-1){
                    var boxnum=$.dialog.data('project_title');
                    for(var j=0;j<boxnum.length;j++) {
                        if($('#project_item_'+boxnum[j].dataset.id).length==0){
                            var s1='<span class="label-box" id="project_item_'+boxnum[j].dataset.id;
                            s1=s1+'" data-id="'+boxnum[j].dataset.id+'">'+boxnum[j].dataset.title;
                            $project_box.append(s1+'<i onclick="fnDeleteProject(this);"></i></span>');
                            fnUpdateProject(); 
                        }
                    }
                }
            }
        });
    });
});
  
    
// 滚动图片处理
var $brand_certificate=$('#ClubBrand_brand_certificate');
var $upload_pic_brand_certificate=$('#upload_pic_ClubBrand_brand_certificate');
var $upload_box_brand_certificate=$('#upload_box_ClubBrand_brand_certificate');
// 添加或删除时，更新图片
var fnUpdateScrollpic=function(){
    var arr=[];
    $upload_pic_brand_certificate.find('a').each(function(){
        arr.push($(this).attr('data-savepath'));
    });
    $brand_certificate.val(we.implode(',',arr));
    $upload_box_brand_certificate.show();
    
    if(arr.length>=5) {
        $upload_box_brand_certificate.hide();
    }
};
// 上传完成时图片处理
var fnScrollpic=function(savename,allpath){
	
    $upload_pic_brand_certificate.append('<a class="picbox" data-savepath="'+
    savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdateScrollpic();return false;"></i></a>');
    fnUpdateScrollpic();
};

</script>