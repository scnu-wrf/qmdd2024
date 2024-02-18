<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>添加品牌</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'active-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'afterValidate' => 'js:function(form,data,hasError){
                    if(!hasError){
                        we.overlay("show");
                        $.ajax({
                            type:"post",
                            url:form.attr("action"),
                            data:form.serialize()+"&submitType="+submitType,
                            dataType:"json",
                            success:function(d){
                                if(d.status==1){
                                    we.success(d.msg, d.redirect);
                                }else{
                                    we.error(d.msg, d.redirect);
                                }
                            }
                        });
                    }else{
                        var html="";
                        var items = [];
                        for(item in data){
                            items.push(item);
                            html+="<p>"+data[item][0]+"</p>";
                        }
                        we.msg("minus", html);
                        var $item = $("#"+items[0]);
                        $item.focus();
                        $(window).scrollTop($item.offset().top-10);
                    }
                }',
            ),
        ));
        ?>
        <table class="table-title">
            <tr>
                <td>品牌信息</td>
            </tr>
        </table>
        <table>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'Brand_TITLE'); ?></td>
                <td width="35%">
                    <?php echo $form->textField($model, 'Brand_TITLE', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'Brand_TITLE', $htmlOptions = array()); ?>
                </td>
                <td width="15%"><?php echo $form->labelEx($model, 'Brand_Logo_Pic'); ?></td>
                <td width="35%">
                    <?php echo $form->hiddenField($model, 'Brand_Logo_Pic', array('class' => 'input-text fl')); ?>
                    <?php $basepath=BasePath::model()->getPath(116);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                    <script>we.uploadpic('<?php echo get_class($model);?>_Brand_Logo_Pic','<?php echo $picprefix;?>');</script>
                    <?php echo $form->error($model, 'Brand_Logo_Pic', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'project_list'); ?></td>
                <td colspan="3">
                    <?php echo $form->hiddenField($model, 'project_list', array('class' => 'input-text')); ?>
                    <span id="project_box"></span>
                    <input id="project_add_btn" class="btn" type="button" value="添加">
                    <?php echo $form->error($model, 'project_list', $htmlOptions = array()); ?>
                </td>
                            
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'Brand_content'); ?></td>
                <td colspan="3">
                    <?php echo $form->textArea($model, 'Brand_content', array('class' => 'input-text' ,'value'=>'')); ?>
                    <?php echo $form->error($model, 'Brand_content', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'Brand_DATE_BEGIN'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'Brand_DATE_BEGIN', array('style'=>'width:120px;', 'class' => 'input-text', 'value'=>'')); ?>
                    <?php echo $form->error($model, 'Brand_DATE_BEGIN', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'Brand_DATE_END'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'Brand_DATE_END', array('style'=>'width:120px;', 'class' => 'input-text', 'value'=>'')); ?>
                    <?php echo $form->error($model, 'Brand_DATE_END', $htmlOptions = array()); ?>
                </td>
            </tr>
        </table>
        <div class="mt15">
            <table class="table-title">
                <tr>
                    <td>审核信息</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model, 'Brand_state'); ?></td>
                    <td width="35%">
                    <?php echo $form->radioButtonList($model, 'Brand_state', array(1 => '上架', 0 => '下架'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'Brand_state'); ?>
                    </td> 
                    <td width="15%">&nbsp;</td>
                    <td width="35%">&nbsp;</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'state'); ?></td>
                    <td>
                        <?php echo $form->radioButtonList($model, 'state', Chtml::listData(BaseCode::model()->getCode(370), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'state'); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'reasons_for_failure'); ?></td>
                    <td>
                        <?php echo $form->textArea($model, 'reasons_for_failure', array('class' => 'input-text' ,'value'=>'')); ?>
                        <?php echo $form->error($model, 'reasons_for_failure', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="box-detail-submit"><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button><button onclick="submitType='shenhe'" class="btn btn-blue" type="submit">提交审核</button><button class="btn" type="button" onclick="we.back();">取消</button></div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
var club_id=0;
$(function(){
    var $start_time=$('#<?php echo get_class($model);?>_Brand_DATE_BEGIN');
    var $end_time=$('#<?php echo get_class($model);?>_Brand_DATE_END');
    $start_time.on('click', function(){
        var end_input=$dp.$('<?php echo get_class($model);?>_Brand_DATE_END')
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'<?php echo get_class($model);?>_Brand_DATE_END\')}'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'<?php echo get_class($model);?>_Brand_DATE_BEGIN\')}'});
    });
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
    $('#Brand_project_list').val(we.implode(',',arr));
};

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
                if($.dialog.data('project_id')>0){
                    if($('#project_item_'+$.dialog.data('project_id')).length==0){
                       $project_box.append('<span class="label-box" id="project_item_'+$.dialog.data('project_id')+'" data-id="'+$.dialog.data('project_id')+'">'+$.dialog.data('project_title')+'<i onclick="fnDeleteProject(this);"></i></span>'); 
                       fnUpdateProject();
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