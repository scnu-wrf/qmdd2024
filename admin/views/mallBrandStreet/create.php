<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>添加品牌</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <table class="table-title">
            <tr>
                <td>品牌信息</td>
            </tr>
        </table>
        <table>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'brand_title'); ?></td>
                <td width="35%">
                    <?php echo $form->textField($model, 'brand_title', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'brand_title', $htmlOptions = array()); ?>
                </td>
                <td width="15%"><?php echo $form->labelEx($model, 'brand_logo_pic'); ?></td>
                <td width="35%">
                    <?php echo $form->hiddenField($model, 'brand_logo_pic', array('class' => 'input-text fl')); ?>
                    <?php $basepath=BasePath::model()->getPath(167);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                    <script>we.uploadpic('<?php echo get_class($model);?>_brand_logo_pic','<?php echo $picprefix;?>');</script>
                    <?php echo $form->error($model, 'brand_logo_pic', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'project_list'); ?></td>
                <td>
                    <?php echo $form->hiddenField($model, 'project_list', array('class' => 'input-text')); ?>
                    <span id="project_box"></span>
                    <input id="project_add_btn" class="btn" type="button" value="添加">
                    <?php echo $form->error($model, 'project_list', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'brand_state'); ?></td>
                <td>
                    <?php echo $form->radioButtonList($model, 'brand_state', array(649=>'上架', 648=>'下架'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'brand_state'); ?>
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
                <td><?php echo $form->labelEx($model, 'brand_date_begin'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'brand_date_begin', array('style'=>'width:120px;', 'class' => 'input-text', 'value'=>'')); ?>
                    <?php echo $form->error($model, 'brand_date_begin', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'brand_date_end'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'brand_date_end', array('style'=>'width:120px;', 'class' => 'input-text', 'value'=>'')); ?>
                    <?php echo $form->error($model, 'brand_date_end', $htmlOptions = array()); ?>
                </td>
            </tr>
        </table>

        <div class="box-detail-submit"><?php echo show_shenhe_box(array('baocun'=>'保存'));?><button class="btn" type="button" onclick="we.back();">取消</button></div>
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
  
    
//    var fnCheckState=function(){
//        if($('input[name="Advertisement[state]"]:checked').val()==373){
//            $('#state_msg').show();
//        }else{
//            $('#state_msg').hide();
//        }
//    };
//    fnCheckState();
//    // 审核未通过原因
//    $('#Advertisement_state').on('click', function(){
//        fnCheckState();
//    });
});
</script>