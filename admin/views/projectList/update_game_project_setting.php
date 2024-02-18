<?php
    $game=BaseCode::model()->getCode(664);
    $pgame=BaseCode::model()->getCode(647);
    $fater_id = (!empty($_REQUEST['fater_id'])) ? $_REQUEST['fater_id'] : 0;
?>
<style>
    .btn i {
        margin-right: 0;
    }
</style>
<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>竞赛项目设置</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list());$model->id = empty($model->id) ? 0 : $model->id; ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table style="table-layout:auto;">
                    <tr>
                        <td style="width:10%;">赛事项目</td>
                        <td colspan="4" style="width:80%;">
                            <?php
                                $project_id = (empty($fater_id)) ? 'project_id' : 'id';
                                $down_list = ProjectList::model()->findAll('project_type=1 and IF_VISIBLE=649 and if_del=648');
                                echo $form->dropDownList($model, $project_id, Chtml::listData($down_list, 'id', 'project_name'), array('prompt'=>'请选择'));
                                echo $form->error($model,$project_id,$htmlOptions = array());
                            ?>
                        </td>
                        <td style="border-left: 0;">
                            <?php if(empty($model->$project_id) || !empty($fater_id)) {?>
                                <a class="btn" onclick="add_list_btn()" style="cursor: pointer;"><i class="fa fa-plus"></i>添加竞赛项目</a>
                            <?php }?>
                        </td>
                    </tr>
                </table>
                <div id="project_game">
                    <?php
                        $num = 1;
                        if(!empty($project_list))foreach($project_list as $pl){
                    ?>
                    <table class="add_btn_list mt15" style="table-layout:auto;">
                        <tr class="table-title">
                            <td colspan="6">
                                <span style="display: inline-block;width: 95%;font-weight:700;">竞赛项目信息（<?php echo $num; ?>）</span>
                                <?php if(empty($pl->project_id) || !empty($fater_id)) {?>
                                    <span style="display: inline-block;">
                                        <a class="btn" href="javascript:;" onclick="fnDelete(this);" title="删除"><i class="fa fa-trash-o"></i></a>
                                    </span>
                                <?php }?>
                            </td>
                            <?php echo $form->hiddenField($pl,'id',array('name'=>'project_game['.$pl->id.'][id]')); ?>
                        </tr>
                        <tr>
                            <td style="width:10%;"><?php echo $form->labelEx($pl,'project_code'); ?></td>
                            <td style="width:23.333%;"><?php echo $pl->project_code; ?></td>
                            <td style="width:10%;"><?php echo $form->labelEx($pl,'game_item'); ?></td>
                            <td style="width:23.333%;"><?php echo $form->textField($pl,'game_item',array('class'=>'input-text','name'=>'project_game['.$pl->id.'][game_item]')); ?></td>
                            <td style="width:10%;"><?php echo $form->labelEx($pl,'game_model'); ?></td>
                            <td style="width:23.333%;">
                                <?php $pl->game_model = explode(',',$pl->game_model); ?>
                                <?php echo $form->checkBoxList($pl, 'game_model', Chtml::listData(BaseCode::model()->getCode(664), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>','name'=>'project_game['.$pl->id.'][game_model]')); ?>
                                <div><span style="padding-left: 0px;" class="msg">*可多选</span></div>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($pl, 'game_sex'); ?></td>
                            <td>
                                <?php echo $form->dropDownList($pl, 'game_sex', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择','name'=>'project_game['.$pl->id.'][game_sex]')); ?>
                            </td>
                            <td><?php echo $form->labelEx($pl, 'game_age'); ?></td>
                            <td>
                                <?php echo $form->dropDownList($pl, 'game_age', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择','name'=>'project_game['.$pl->id.'][game_age]')); ?>
                            </td>
                            <td><?php echo $form->labelEx($pl, 'game_weight'); ?></td>
                            <td>
                                <?php echo $form->dropDownList($pl, 'game_weight', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择','name'=>'project_game['.$pl->id.'][game_weight]')); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($pl, 'game_man_num'); ?></td>
                            <td>
                                <?php echo $form->dropDownList($pl, 'game_man_num', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择','name'=>'project_game['.$pl->id.'][game_man_num]')); ?>
                            </td>
                            <td><?php echo $form->labelEx($pl, 'game_team_num'); ?></td>
                            <td>
                                <?php echo $form->dropDownList($pl, 'game_team_num', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择','name'=>'project_game['.$pl->id.'][game_team_num]')); ?>
                            </td>
                            <td><?php echo $form->labelEx($pl, 'game_team_mem_num'); ?></td>
                            <td>
                                <?php echo $form->dropDownList($pl, 'game_team_mem_num', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择','name'=>'project_game['.$pl->id.'][game_team_mem_num]')); ?>
                            </td>
                        </tr>
                    </table>
                    <?php $num++; }?>
                </div>
                <table class="mt15">
                    <tr>
                        <td style="width:10%;">可执行操作</td>
                        <td colspan="5">
                            <?php echo show_shenhe_box(array('baocun'=>'保存')); ?>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget(); ?>
    </div><!--box-detail-->
</div><!--box end-->
<script>
    var fnDelete=function(op){
        $(op).parent().parent().parent().parent().parent().remove();
        var tab_add=$('.add_btn_list').length;
        if(tab_add<1){
            add_list_btn();
        }
    };
    
    $(function(){
        var this_id = '<?php echo $model->id; ?>';
        if(this_id==0){
            add_list_btn();
        }
    })
    
    var add_list_btn=function(){
        var num = $('.add_btn_list').length;
        num++;
        var s_html = 
            '<table class="add_btn_list mt15" style="table-layout:auto;">'+
                '<tr class="table-title" style="margin-top:15px;">'+
                    '<td colspan="6">'+
                        '<span style="display: inline-block;width: 95%;font-weight:700;">竞赛项目信息（'+num+'）</span>'+
                        '<span style="display: inline-block;">'+
                            '<a class="btn" href="javascript:;" onclick="fnDelete(this);" title="删除"><i class="fa fa-trash-o"></i></a>'+
                        '</span>'+
                    '</td>'+
                '</tr>'+
                '<tr>'+
                    '<td style="width:10%;">竞赛项目编号</td>'+
                    '<td style="width:23.333%;"></td>'+
                    '<td style="width:10%;">比赛项目</td>'+
                    '<td style="width:23.333%;">'+
                        '<input name="project_game['+num+'][id]" class="input-text" type="hidden" value="null">'+
                        '<input name="project_game['+num+'][game_item]" class="input-text" type="text">'+
                    '</td>'+
                    '<td style="width:10%;">比赛方式</td>'+
                    '<td style="width:23.333%;">'+
                        '<input id="ytproject_game_'+num+'_game_model" type="hidden" value="" name="project_game['+num+'][game_model]">'+
                        '<span id="project_game_'+num+'_game_model">'+
                            '<?php foreach ($game as $h) { ?>'+
                            '<span class="check">'+
                                '<input class="input-check" id="project_game_'+num+'_game_model_<?php echo $h->f_id; ?>" value="<?php echo $h->f_id; ?>" type="checkbox" name="project_game['+num+'][game_model][]">'+
                                '<label for="project_game_'+num+'_game_model_<?php echo $h->f_id; ?>"><?php echo $h->F_NAME; ?></label>'+
                            '</span>'+
                            '<?php } ?>'+
                        '</span>'+
                        '<div><span style="padding-left: 0px;" class="msg">*可多选</span></div>'+
                    '</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>要求性别</td>'+
                    '<td>'+
                        '<select name="project_game['+num+'][game_sex]">'+
                            '<option value>请选择</option>'+
                            '<?php foreach($pgame as $g){ ?>'+
                            '<option value="<?php echo $g->f_id; ?>"><?php echo $g->F_NAME; ?></option>'+
                            '<?php } ?>'+
                        '</select>'+
                    '</td>'+
                    '<td>要求年龄</td>'+
                    '<td>'+
                        '<select name="project_game['+num+'][game_age]">'+
                            '<option value>请选择</option>'+
                            '<?php foreach($pgame as $g){ ?>'+
                            '<option value="<?php echo $g->f_id; ?>"><?php echo $g->F_NAME; ?></option>'+
                           ' <?php } ?>'+
                        '</select>'+
                    '</td>'+
                    '<td>要求体重</td>'+
                    '<td>'+
                        '<select name="project_game['+num+'][game_weight]">'+
                            '<option value>请选择</option>'+
                            '<?php foreach($pgame as $g){ ?>'+
                            '<option value="<?php echo $g->f_id; ?>"><?php echo $g->F_NAME; ?></option>'+
                            '<?php } ?>'+
                        '</select>'+
                    '</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>要求人数</td>'+
                    '<td>'+
                        '<select name="project_game['+num+'][game_man_num]">'+
                            '<option value>请选择</option>'+
                            '<?php foreach($pgame as $g){ ?>'+
                            '<option value="<?php echo $g->f_id; ?>"><?php echo $g->F_NAME; ?></option>'+
                            '<?php } ?>'+
                        '</select>'+
                    '</td>'+
                    '<td>要求队数</td>'+
                    '<td>'+
                        '<select name="project_game['+num+'][game_team_num]">'+
                            '<option value>请选择</option>'+
                            '<?php foreach($pgame as $g){ ?>'+
                            '<option value="<?php echo $g->f_id; ?>"><?php echo $g->F_NAME; ?></option>'+
                            '<?php } ?>'+
                        '</select>'+
                    '</td>'+
                    '<td>要求队数人数</td>'+
                    '<td>'+
                        '<select name="project_game['+num+'][game_team_mem_num]">'+
                            '<option value>请选择</option>'+
                            '<?php foreach($pgame as $g){ ?>'+
                            '<option value="<?php echo $g->f_id; ?>"><?php echo $g->F_NAME; ?></option>'+
                            '<?php } ?>'+
                        '</select>'+
                    '</td>'+
                '</tr>'+
            '</table>';
        $('#project_game').append(s_html);
    }
</script>