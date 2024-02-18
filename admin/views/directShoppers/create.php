<?php

    $pid=Yii::app()->request->getParam('p_id');

     if(isset($pid)) { 
        $project_list=ProjectList::model()->findAll(array(
                        'select'=>'id,project_name',
                        'condition' =>'id='.$pid,)
                    
                        );
     }else{
        $project_list=array();
     }
?>

<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>添加导购</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
       <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <table class="table-title">
            <tr>
                <td>导购信息</td>
            </tr>
        </table>
        <table>

<!--                    'project_id'=>'项目Id',
            'club_star'=>'单位星级（0-9星）ID，关联member_card表ID',
            'club_star_name'=>'等级名称',
            'synthesize_num'=>'实物综合商品导购窗口数量',
            'profession_num'=>'实物专业商品导购窗口数量',
            'single_profession_num'=>'实物单件专业商品导购件数',
            'digital_synthesize_num'=>'数字综合商品导购窗口数量',
            'digital_profession_num'=>'数字专业商品导购窗口数量',
            'digital_single_profession_num'=>'数字单件专业商品导购件数',
            'shopping_days'=>'可导购天数', -->    

        <table class="mt15">
            <tr>
                <td width="20%"><?php echo $form->labelEx($model, 'project_list'); ?></td>
                <td width="80%">

                    <?php echo $form->hiddenField($model, 'project_list', array('class' => 'input-text')); ?>
                    <span id="project_box"><?php foreach($project_list as $v){?><span class="label-box" id="project_item_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>"><?php echo $v->project_name;?><i onclick="fnDeleteProject(this);"></i></span><?php }?></span>
                    <input id="project_add_btn" class="btn" type="button" value="添加项目">
                    <?php echo $form->error($model, 'project_list', $htmlOptions = array()); ?>    


                </td>
            </tr>

            <tr>
                <td width="20%"><?php echo $form->labelEx($model, 'club_star'); ?></td>
                <td width="80%">
                    <?php
                    echo $form->dropDownList($model, 'club_star', Chtml::listData(MemberCard::model()->findAll() , 'f_id', 'card_name'), array('prompt'=>'请选择')); 
                     echo $form->error($model, 'club_star', $htmlOptions = array()); ?>

                </td>
            </tr>            

            <tr>
                <td width="20%"><?php echo $form->labelEx($model, 'synthesize_num'); ?></td>
                <td width="80%">
                    <?php echo $form->textField($model, 'synthesize_num', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'synthesize_num', $htmlOptions = array()); ?>
                </td>
            </tr>

            <tr>
                <td width="20%"><?php echo $form->labelEx($model, 'profession_num'); ?></td>
                <td width="80%">
                    <?php echo $form->textField($model, 'profession_num', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'profession_num', $htmlOptions = array()); ?>
                </td>
            </tr>


            <tr>
                <td width="20%"><?php echo $form->labelEx($model, 'single_profession_num'); ?></td>
                <td width="80%">
                    <?php echo $form->textField($model, 'single_profession_num', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'single_profession_num', $htmlOptions = array()); ?>
                </td>
            </tr>

            <tr>
                <td width="20%"><?php echo $form->labelEx($model, 'digital_synthesize_num'); ?></td>
                <td width="80%">
                    <?php echo $form->textField($model, 'digital_synthesize_num', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'digital_synthesize_num', $htmlOptions = array()); ?>
                </td>
            </tr>

            <tr>
                <td width="20%"><?php echo $form->labelEx($model, 'digital_profession_num'); ?></td>
                <td width="80%">
                    <?php echo $form->textField($model, 'digital_profession_num', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'digital_profession_num', $htmlOptions = array()); ?>
                </td>
            </tr>

            <tr>
                <td width="20%"><?php echo $form->labelEx($model, 'digital_single_profession_num'); ?></td>
                <td width="80%">
                    <?php echo $form->textField($model, 'digital_single_profession_num', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'digital_single_profession_num', $htmlOptions = array()); ?>
                </td>
            </tr>

            <tr>
                <td width="20%"><?php echo $form->labelEx($model, 'shopping_days'); ?></td>
                <td width="80%">
                    <?php echo $form->textField($model, 'shopping_days', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'shopping_days', $htmlOptions = array()); ?>
                </td>
            </tr>
            
        </table>


        <div class="box-detail-submit"><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button><button class="btn" type="button" onclick="we.back();">取消</button></div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->


<script>
    we.tab('.box-detail-tab li');
   // 添加项目
    var $project_add_btn=$('#project_add_btn');
    $project_add_btn.on('click', function(){
        $.dialog.data('project_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/projectPro", array('project_type'=>1));?>',{
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
 

// 删除项目
var $project_box=$('#project_box');
var $DirectShoppers_project_list=$('#DirectShoppers_project_list');
var fnUpdateProject=function(){
    var arr=[];
    var id;
    $project_box.find('span').each(function(){
        id=$(this).attr('data-id');
        arr.push(id);
    });
    $DirectShoppers_project_list.val(we.implode(',', arr));
};

var fnDeleteProject=function(op){
    $(op).parent().remove();
    fnUpdateProject();
};


</script>