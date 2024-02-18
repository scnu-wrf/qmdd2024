<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>添加报告</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
            <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table class="mt15">
                <tr class="table-title">
                    <td colspan="4" >基本信息</td>
                </tr>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model, 'gf_name'); ?>：</td>
                    <td colspan="3" width="35%">
                        <?php echo $form->textField($model, 'gf_name', array('class' => 'input-text', 'style'=>'width:100px;')); ?>
                        <?php echo $form->error($model, 'gf_name'); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'health_date'); ?>：</td>
                    <td colspan="3">
                        <?php echo $form->textField($model, 'health_date', array('class' => 'input-text', 'style'=>'width:100px;')); ?>
                        <?php echo $form->error($model, 'health_date', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'health_state'); ?>：</td>
                    <td colspan="3">
                        <?php echo $form->radioButtonList($model, 'health_state', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'health_state'); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'club_id'); ?>：</td>
                    <td colspan="3">
                        <span id="club_box"><span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value'=>get_session('club_id'))); ?></span></span>
                        <?php echo $form->error($model, 'club_id', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="center">
                        <button class="btn btn-blue" type="submit">保存</button>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
            <?php $this->endWidget(); ?>
        </div><!--box-detail-bd end-->
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    var club_id=0;
    var project_id=0;

    $(function(){
        $('#GfHealthyList_health_date').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });

        // 选择项目
        var $project_box=$('#project_box');
        var $GfHealthyList_project_id=$('#GfHealthyList_project_id');
        $('#project_select_btn').on('click', function(){
            var club_id=$('#GfHealthyList_club_id').val();
            $.dialog.data('project_id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/project_list");?>&club_id='+club_id,{
                id:'danwei',
                lock:true,
                opacity:0.3,
                title:'选择具体内容',
                width:'500px',
                height:'60%',
                close: function () {
                    if($.dialog.data('project_id')>0){
                        project_id=$.dialog.data('project_id');
                        $GfHealthyList_project_id.val($.dialog.data('project_title')).trigger('blur');
                        $project_box.html('<span class="label-box">'+$.dialog.data('project_title')+'</span>');
                    }
                }
            });
        });
        
        // // 选择单位
        // var $club_box=$('#club_box');
        // var $GfHealthyList_club_id=$('#GfHealthyList_club_id');
        // $('#club_select_btn').on('click', function(){
        //     $.dialog.data('club_id', 0);
        //     $.dialog.open('<?php echo $this->createUrl("select/club", array('partnership_type'=>16));?>',{
        //         id:'danwei',
        //         lock:true,
        //         opacity:0.3,
        //         title:'选择具体内容',
        //         width:'500px',
        //         height:'60%',
        //         close: function () {
        //             //console.log($.dialog.data('club_id'));
        //             if($.dialog.data('club_id')>0){
        //                 club_id=$.dialog.data('club_id');
        //                 $GfHealthyList_club_id.val($.dialog.data('club_id')).trigger('blur');
        //                 $club_box.html('<span class="label-box">'+$.dialog.data('club_title')+'</span>');
        //             }
        //         }
        //     });
        // });
    });
</script>
