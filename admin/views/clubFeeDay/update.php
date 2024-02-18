<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>详情</h1><span class="back"><a href="javascript:;" class="btn" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div>
    <div class="box-content">
        <div class="box-table">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <span class="box-detail-bd">
            <table class="detail">
                <tr>
                    <td><?php echo $form->labelEx($model, 'f_code'); ?>：</td>
                    <td colspan="5">
                        <?php echo $form->textField($model, 'f_code', array('class' => 'input-text', 'style' => 'width:300px;')); ?>
                        <?php echo $form->error($model, 'f_code', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'f_name'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 'f_name', array('class' => 'input-text', 'style' => 'width:300px;')); ?>
                        <?php echo $form->error($model, 'f_name', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'f_day'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 'f_day', array('class' => 'input-text', 'style' => 'width:300px;')); ?>
                        <?php echo $form->error($model, 'f_day', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>可执行操作：</td>
                    <td colspan="3">
                        <?php echo show_shenhe_box(array('baocun'=>'保存')); ?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div>
        <?php $this->endWidget(); ?>
        </div>
    </div>
</div><!--box end-->
<script>
    // 删除已添加项目
    function fnDeleteProject(event){
        $(event).parent().remove();
        fnUpdateClub($(this).parent().attr("data_id"));
    };

    // 推荐到单位更新、删除
    var $project_box=$('#project_box');
    var $QmddServerUsertype_project_ids=$('#QmddServerUsertype_project_ids');
    function fnUpdateClub(){
        var arr=[];
        $project_box.find('span').each(function(){
            arr.push($(this).attr('data_id'));
        });
        $QmddServerUsertype_project_ids.val(we.implode(',', arr));
    };
    var $project_box=$('#project_box');
    var QmddServerUsertype_project_ids=$("#QmddServerUsertype_project_ids").val();
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
                    console.log(boxnum)
                    for(var j=0;j<boxnum.length;j++) {
                        if($('#project_item_'+boxnum[j].dataset.id).length==0){
                            var s1='<span class="label-box" id="project_item_'+boxnum[j].dataset.id;
                            s1=s1+'" data_id="'+boxnum[j].dataset.id+'">'+boxnum[j].dataset.title;
                            $project_box.append(s1+'<i onclick="fnDeleteProject(this);"></i></span>');
                            fnUpdateClub(); 
                        }
                    }
                }
            }
        });
    });
</script>