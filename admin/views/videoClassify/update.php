<?php
	if(@empty($_REQUEST['id'])){
		$txt2='添加';
	}else{
		$txt2='编辑';
	}
?>
<div class="box">
    <div class="box-title c"><h1>当前界面：系统》系统设置》视频分类》<?php echo $txt2;?></h1>
    <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div>
    <div class="box-detail">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        
        <table width="100%" style="table-layout:auto; margin-top:10px; ">
                    <tr class="table-title">
                        <td colspan="4">基本信息</td>
                    </tr>
                    <tr>
                        <td width="11%"><?php echo $form->labelEx($model, 'base_f_id'); ?></td>
                        <td colspan="3"><?php echo $form->radioButtonList($model, 'base_f_id', Chtml::listData(BaseCode::model()->findall('f_id in(365,366)'), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'base_f_id'); ?></td>
                    </tr>
                    <tr>
                        <td width="11%"><?php echo $form->labelEx($model, 'tn_code'); ?></td>
                        <td colspan="3"><?php echo $form->textField($model, 'tn_code', array('class' => 'input-text')); ?><?php echo $form->error($model, 'tn_code', $htmlOptions = array()); ?></td>
                    </tr>
                    <tr>
                        <td width="11%"><?php echo $form->labelEx($model, 'sn_name'); ?></td>
                        <td colspan="3"><?php echo $form->textField($model, 'sn_name', array('class' => 'input-text')); ?><?php echo $form->error($model, 'sn_name', $htmlOptions = array()); ?></td>
                    </tr>
                    <tr>
                        <td width="11%"><?php echo $form->labelEx($model, 'if_menu_dispay'); ?></td>
                        <td colspan="3"><?php echo $form->radioButtonList($model, 'if_menu_dispay',array(1 => '显示', 2 => '不显示') , $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'if_menu_dispay'); ?></td>
                    </tr>
                    <tr>
                        <td width="11%"><?php echo $form->labelEx($model, 'queue_number'); ?></td>
                        <td colspan="3"><?php echo $form->textField($model, 'queue_number', array('class' => 'input-text')); ?><?php echo $form->error($model, 'queue_number', $htmlOptions = array()); ?></td>
                    </tr>
                    <tr>
                        <td>可执行操作</td>
                        <td colspan="3">
                        
                            <button id="baocun" onclick="submitType='baocun'" class="btn btn-blue" type="submit"> 保存</button>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>
                </table>
        <?php $this->endWidget(); ?>
    </div>
</div>
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
    $('#MallProductsTypeSname_project_list').val(we.implode(',',arr));
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

function selectOnchang(obj){ 
  var show_id=$(obj).val();
  var  p_html ='<option value="">请选择</option>';
  if (show_id>0) {
     for (j=0;j<$order_type2.length;j++) 
        if($order_type2[j]['fater_id']==show_id)
       {
        p_html = p_html +'<option value="'+$order_type2[j]['f_id']+'">';
        p_html = p_html +$order_type2[j]['F_NAME']+'</option>';
      }
    }
   $("#MallProductsTypeSname_base_f_id").html(p_html);
}
</script>