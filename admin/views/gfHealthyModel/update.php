<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i><?php if(empty($model->id)) {?>添加体检模板<?php }else{?>编辑体检模板<?php }?></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
        <div class="box-detail">
            <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <div class="box-detail-bd">
            <table class="mt15">
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model, 'attr_name'); ?>：</td>
                    <td width="35%">
                        <?php echo $form->textField($model, 'attr_name', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'attr_name', $htmlOptions = array()); ?>
                    </td>
                    <td width="15%"><?php echo $form->labelEx($model, 'attr_unit'); ?>：</td>
                    <td width="35%">
                        <?php echo $form->textField($model, 'attr_unit', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'attr_unit', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'sort_order'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 'sort_order', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'sort_order', $htmlOptions = array()); ?>
                        <br><span class="msg">*值越大越往前排</span>
                    </td>
                    <td>可用项目：</td>
                    <td>
                        <?php echo $form->hiddenField($model, 'project_name', array('class' => 'input-text')); ?>
                        <?php 
                            $model->id=empty($model->id) ?0 : $model->id;
                            $project_name = GfHealthyProject::model()->findAll('healthy_id='.$model->id);
                        ?>
                        <span id="project_box">
                            <?php foreach($project_name as $v){?>
                                <span class="label-box" id="project_item_<?php echo $v->project_id;?>" data-id="<?php echo $v->project_id;?>"><?php echo $v->project_list->project_name;?><i onclick="fnDeleteProject(this);"></i></span>
                            <?php }?>
                        </span>
                        <input id="project_add_btn" class="btn" type="button" value="添加项目">
                        <?php echo $form->error($model, 'project_name', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'attr_input_type'); ?>：</td>
                    <td>
                        <?php echo $form->radioButtonList($model, 'attr_input_type', Chtml::listData(BaseCode::model()->getCode(676), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'attr_input_type'); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'attr_values'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 'attr_values', array('class' => 'input-text')); ?><!-- 
                        <input type="button" class="mall_btn" value="＋" onClick="add_input_attr()" />
                        <div id="input_attr_div"></div> -->
                        <?php echo $form->error($model, 'attr_values', $htmlOptions = array()); ?>
                        <br><span class="msg">*在可选值输入<!--，一行代表一个可选值-->，多个值可用英文逗号“,”隔开</span>
                    </td>
                </tr>
                <tr>
                    <td>可执行操作：</td>
                    <td colspan="3">
                        <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
                </table>
            </div>
            <?php $this->endWidget(); ?>
        </div><!--box-table end-->
</div><!--box end-->
<script>
    var project_id=0;
    // 删除项目
    var $project_box=$('#project_box');
    var $GfHealthyModel_project_name=$('#GfHealthyModel_project_name');
    var fnUpdateProject=function(){
        var arr=[];
        var id;
        $project_box.find('span').each(function(){
            id=$(this).attr('data-id');
            arr.push(id);
        });
        $GfHealthyModel_project_name.val(we.implode(',', arr));
    };

    var fnDeleteProject=function(op){
        $(op).parent().remove();
        fnUpdateProject();
    };


    $(function(){
        $('#GfPartnerMemberApply_effective_start_time').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});
        });
        $('#GfPartnerMemberApply_effective_end_time').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});
        });
        
        // 添加项目
        fnUpdateProject();
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
</script>