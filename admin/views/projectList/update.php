<style>
    td{ cursor: default; }
</style>
<div class="box">
    <div id="t0" class="box-title c"><h1><i class="fa fa-table"></i>编辑项目管理</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <?php if($model->id=='') echo $form->hiddenField($model, 'project_type', array('value'=>$_REQUEST['pid'])); ?>
        <?php $_REQUEST['fater_id']=empty($_REQUEST['fater_id'])?"":$_REQUEST['fater_id'];echo $form->hiddenField($model, 'fater_id', array('value'=>$_REQUEST['fater_id'])); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <?php echo $form->hiddenField($model, 'if_del', array('value' => 648)); ?>
                <table id="t1">
                    <tr class="table-title">
                        <td colspan="4">基本信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'CODE'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'CODE', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'CODE', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'financial_code'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'financial_code', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'financial_code', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'project_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'project_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'project_name', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'project_e_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'project_e_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'project_e_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'IF_VISIBLE'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'IF_VISIBLE', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'IF_VISIBLE', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'IF_DEFAULT'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'IF_DEFAULT', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'IF_DEFAULT', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'project_simple_code'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'project_simple_code', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'project_simple_code', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'project_logo'); ?></td>
                        <td><?php echo $form->hiddenField($model, 'project_logo', array('class' => 'input-text fl')); ?>
                        <?php $basepath=BasePath::model()->getPath(271);$picprefix='';
                        if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <?php if($model->project_logo!=''){?>
                      <div class="upload_img fl" id="upload_pic_QmddGfSite_project_logo">
                         <a href="<?php echo $basepath->F_WWWPATH.$model->project_logo;?>" target="_blank">
                         <img src="<?php echo $basepath->F_WWWPATH.$model->project_logo;?>" style="max-height:70px; max-width:70px;"></a></div>
                         <?php }?>
                      <script>we.uploadpic('<?php echo get_class($model);?>_project_logo','<?php echo $picprefix;?>');</script>
                      <!--span class="msg">注：图片格式530*530;文件大小≤2M；数量≤1张 </span-->
                            <?php echo $form->error($model, 'project_logo', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <?php if((!empty($_REQUEST['pid'])&&$_REQUEST['pid']==1)||(!empty($model->id)&&$model->project_type==1)){?>
                <table id="t2" class="mt15">
                    <tr class="table-title">
                        <td colspan="4">服务机构各类服务者最低要求人数</td>
                    </tr>
                    <!-- <tr>
                        <td><?php echo $form->labelEx($model, 'project_jl'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'project_jl', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'project_jl', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'project_cp'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'project_cp', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'project_cp', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'project_m'); ?></td>
                        <td colspan="">
                            <?php echo $form->textField($model, 'project_m', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'project_m', $htmlOptions = array()); ?>
                        </td>
                        <td></td>
                        <td></td>
                    </tr> -->
                    <tr>
                        <?php echo $form->hiddenField($model, 'ProjectSerivce', array('class' => 'input-text')); ?>
                        <?php $num=0;foreach($clubServicerType as $b){?>
                        <?php 
                            if(!empty($model->id)){
                                $scount=ProjectSerivce::model()->find('project_id='.$model->id.' and qualification_type_id='.$b->member_second_id);
                            }
                        ?>
                        <td><?php echo $b->member_second_name;?>最低人数</td>
                        <td colspan="">
                            <input class="input-text" type="text" name="ProjectSerivce[<?=$b->member_second_id;?>][<?php echo !empty($scount->id)?$scount->id:0;?>]" value="<?php echo !empty($scount->id)?$scount->min_count:1;?>">
                        </td>
                    <?php 
                        $num++;if($num%2==0&&count($clubServicerType)!=$num){echo '</tr><tr>';}};
                        if($num%2!=0){echo '<td></td><td></td>';};
                    ?>
                    </tr>
                </table>
                <?php }?>
                <?php echo $form->hiddenField($model, 'project_game', array('class' => 'input-text')); ?>
                <div class="mt15" id="project_game">
<script>
    var pr_list=0;
</script>
                    <?php 
                        $game=BaseCode::model()->getCode(664);
                        $pgame=BaseCode::model()->getCode(647);
                        if(!empty($project_list_game)) foreach($project_list_game as $v) {
                    ?>
                    <table class="t3 add_btn_list mt15" style="margin-top:15px;">
                        <tr class="table-title">
                            <td colspan="4">赛事设置&nbsp;
                                <a class="btn" onclick="add_list_btn()"><i class="fa fa-plus"></i>添加</a>
                                <a class="btn" href="javascript:;" onclick="fnDelete(this);" title="删除"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td style="cursor:hand">竞赛项目</td>
                            <td>
                                <input name="project_game[<?php echo $v->id ?>][id]" class="input-text" type="hidden" value="<?php echo $v->id; ?>">
                                <input name="project_game[<?php echo $v->id ?>][game_item]" class="input-text" type="text" value="<?php echo $v->game_item; ?>">
                            </td>
                            <td>赛事方式</td>
                            <td><?php $v->game_model=explode(',',$v->game_model); ?>
                                <?php echo $form->checkBoxList($v, 'game_model', Chtml::listData(BaseCode::model()->getCode(664), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>','name'=>'project_game['.$v->id.'][game_model]')); ?>
                                <div><span style="padding-left: 0px;" class="msg">*可多选</span></div>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'game_sex'); ?></td>
                            <td>
                                <?php echo $form->dropDownList($v, 'game_sex', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择','name'=>'project_game['.$v->id.'][game_sex]')); ?>
                            </td>
                            <td><?php echo $form->labelEx($model, 'game_age'); ?></td>
                            <td>
                                <?php echo $form->dropDownList($v, 'game_age', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择','name'=>'project_game['.$v->id.'][game_age]')); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'game_weight'); ?></td>
                            <td>
                                <?php echo $form->dropDownList($v, 'game_weight', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择','name'=>'project_game['.$v->id.'][game_weight]')); ?>
                            </td>
                            <td><?php echo $form->labelEx($model, 'game_man_num'); ?></td>
                            <td>
                                <?php echo $form->dropDownList($v, 'game_man_num', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择','name'=>'project_game['.$v->id.'][game_man_num]')); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'game_team_num'); ?></td>
                            <td>
                                <?php echo $form->dropDownList($v, 'game_team_num', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择','name'=>'project_game['.$v->id.'][game_team_num]')); ?>
                            </td>
                            <td><?php echo $form->labelEx($model, 'game_team_mem_num'); ?></td>
                            <td>
                                <?php echo $form->dropDownList($v, 'game_team_mem_num', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择','name'=>'project_game['.$v->id.'][game_team_mem_num]')); ?>
                            </td>
                        </tr>
                    </table>
<script>
    pr_list=<?php echo $v->id; ?>;
</script>
                <?php }else{?>
                    <table id="t4" class="add_btn_list">
                        <tr class="table-title" style="margin-top:15px;">
                            <td colspan="4">赛事设置&nbsp;
                                <a class="btn" onclick="add_list_btn()"><i class="fa fa-plus"></i>添加</a>
                            </td>
                        </tr>
                        <tr>
                            <td>竞赛项目</td>
                            <td>
                                <input name="project_game[new][id]" class="input-text" type="hidden" value="null">
                                <input name="project_game[new][game_item]" class="input-text" type="text">
                            </td>
                            <td>赛事方式</td>
                            <td>
                                <input id="ytproject_game_new_game_model" type="hidden" value="" name="project_game[new][game_model]">
                                <span id="project_game_new_game_model">
                                    <?php foreach($game as $h) { ?>
                                        <span class="check">
                                            <input class="input-check" id="project_game_new_game_model_<?php echo $h->f_id; ?>" value="<?php echo $h->f_id; ?>" type="checkbox" name="project_game[new][game_model][]">
                                            <label for="project_game_new_game_model_<?php echo $h->f_id; ?>"><?php echo $h->F_NAME; ?></label>
                                        </span>
                                    <?php } ?>
                                </span>
                                <div><span style="padding-left: 0px;" class="msg">*可多选</span></div>
                            </td>
                        </tr>
                        <tr>
                            <td>性别要求</td>
                            <td>
                                <select name="project_game[new][game_sex]">
                                    <option value>请选择</option>
                                    <?php foreach($pgame as $g){ ?>
                                        <option value="<?php echo $g->f_id; ?>"><?php echo $g->F_NAME; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>年龄要求</td>
                            <td>
                                <select name="project_game[new][game_age]">
                                    <option value>请选择</option>
                                    <?php foreach($pgame as $g){ ?>
                                        <option value="<?php echo $g->f_id; ?>"><?php echo $g->F_NAME; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>体重要求</td>
                            <td>
                                <select name="project_game[new][game_weight]">
                                    <option value>请选择</option>
                                    <?php foreach($pgame as $g){ ?>
                                        <option value="<?php echo $g->f_id; ?>"><?php echo $g->F_NAME; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>人数要求</td>
                            <td>
                                <select name="project_game[new][game_man_num]">
                                    <option value>请选择</option>
                                    <?php foreach($pgame as $g){ ?>
                                        <option value="<?php echo $g->f_id; ?>"><?php echo $g->F_NAME; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>队数要求</td>
                            <td>
                                <select name="project_game[new][game_team_num]">
                                    <option value>请选择</option>
                                    <?php foreach($pgame as $g){ ?>
                                        <option value="<?php echo $g->f_id; ?>"><?php echo $g->F_NAME; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>队数人数要求</td>
                            <td>
                                <select name="project_game[new][game_team_mem_num]">
                                    <option value>请选择</option>
                                    <?php foreach($pgame as $g){ ?>
                                        <option value="<?php echo $g->f_id; ?>"><?php echo $g->F_NAME; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                <?php }?>
                </div>
                <div class="mt15 priny_1">
                    <table id="t5">
                        <tr>
                            <td><?php echo $form->labelEx($model, 'project_description_temp'); ?></td>
                            <td colspan="3">
                                <?php echo $form->hiddenField($model, 'project_description_temp', array('class' => 'input-text')); ?>
                                <script>we.editor('<?php echo get_class($model);?>_project_description_temp', '<?php echo get_class($model);?>[project_description_temp]');</script>
                                <?php echo $form->error($model, 'project_description_temp', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                    </table>
                    <table class="nodis">
                        <tr>
                            <td>可执行操作</td>
                            <td colspan="3">
                                <?php echo show_shenhe_box(array('baocun'=>'保存')); ?>
                                <button class="btn" type="button" onclick="we.back();">取消</button>
                                <button class="btn" type="button" onclick="printpage();">打印</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail-->
</div><!--box end-->
<script>

    var fnDelete=function(op){
        $(op).parent().parent().parent().parent().remove();
        var tab_add=$('.add_btn_list').length;
        if(tab_add<1){
            add_list_btn();
        }
    };
    
    var num = pr_list+1;
    var $project_game = $('#project_game');
    var $ProjectList_project_game=$('#ProjectList_project_game');
    var add_list_btn=function(){
        var s_html='';
        s_html=
            '<table class="add_btn_list" style="margin-top:15px;">'+
                '<tr class="table-title" style="margin-top:15px;">'+
                    '<td colspan="4">赛事设置&nbsp;&nbsp;'+
                        '<a class="btn" onclick="add_list_btn()"><i class="fa fa-plus"></i>添加</a>&nbsp;'+
                        '<a class="btn" href="javascript:;" onclick="fnDelete(this);" title="删除"><i class="fa fa-trash-o"></i></a>'+
                    '</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>竞赛项目</td>'+
                    '<td>'+
                        '<input name="project_game['+num+'][id]" class="input-text" type="hidden" value="null">'+
                        '<input name="project_game['+num+'][game_item]" class="input-text" type="text">'+
                    '</td>'+
                    '<td>赛事方式</td>'+
                    '<td>'+
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
                    '<td>性别要求</td>'+
                    '<td>'+
                        '<select name="project_game['+num+'][game_sex]">'+
                            '<option value>请选择</option>'+
                            '<?php foreach($pgame as $g){ ?>'+
                            '<option value="<?php echo $g->f_id; ?>"><?php echo $g->F_NAME; ?></option>'+
                            '<?php } ?>'+
                        '</select>'+
                    '</td>'+
                    '<td>年龄要求</td>'+
                    '<td>'+
                        '<select name="project_game['+num+'][game_age]">'+
                            '<option value>请选择</option>'+
                            '<?php foreach($pgame as $g){ ?>'+
                            '<option value="<?php echo $g->f_id; ?>"><?php echo $g->F_NAME; ?></option>'+
                           ' <?php } ?>'+
                        '</select>'+
                    '</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>体重要求</td>'+
                    '<td>'+
                        '<select name="project_game['+num+'][game_weight]">'+
                            '<option value>请选择</option>'+
                            '<?php foreach($pgame as $g){ ?>'+
                            '<option value="<?php echo $g->f_id; ?>"><?php echo $g->F_NAME; ?></option>'+
                            '<?php } ?>'+
                        '</select>'+
                    '</td>'+
                    '<td>人数要求</td>'+
                    '<td>'+
                        '<select name="project_game['+num+'][game_man_num]">'+
                            '<option value>请选择</option>'+
                            '<?php foreach($pgame as $g){ ?>'+
                            '<option value="<?php echo $g->f_id; ?>"><?php echo $g->F_NAME; ?></option>'+
                            '<?php } ?>'+
                        '</select>'+
                    '</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>队数要求</td>'+
                    '<td>'+
                        '<select name="project_game['+num+'][game_team_num]">'+
                            '<option value>请选择</option>'+
                            '<?php foreach($pgame as $g){ ?>'+
                            '<option value="<?php echo $g->f_id; ?>"><?php echo $g->F_NAME; ?></option>'+
                            '<?php } ?>'+
                        '</select>'+
                    '</td>'+
                    '<td>队数人数要求</td>'+
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
        $project_game.append(s_html);
        num++;
    }
</script>
<script>
    function printpage(){
        var html='';
        var html1 = '<table>'+$('#ProjectList_project_description_temp').val()+'</table>';
        var t0='<table>'+$('#t0').html()+'</table>';
        var t1='<table>'+$('#t1').html()+'</table>';
        var t2='<table style="margin-top:15px;">'+$('#t2').html()+'</table>';
        var t3='<table>'+$('#project_game').html()+'</table>';
        var t4='<table>'+$('#t4').html()+'</table>';
        var t5='<table style="margin-top:15px;"><td style="width:25%;">项目简介</td><td>'+html1+'</td></table>';
        var dis_t='';
        if(t3){
            dis_t=dis_t+t0+t1+t2+t3+t5;
        }
        else{
            dis_t=dis_t+t0+t1+t2+t5;
        }
        
        var newWin = window.open('', '', '');
        newWin.document.write('<head>\
            <style>\
                .box-detail table, .box-detail-table{\
                    table-layout:fixed;\
                    width:100%;\
                    border-spacing:1px;\
                    border-collapse:collapse;\
                    background:#ccc;}\
                .box-detail td, .box-detail-table td{\
                    padding:10px;\
                    background:#fff;\
                    border: 1px solid black;\
                    text-align:left;}\
                .box-detail table.table-title{\
                    border-collapse:collapse;\
                    border-top:1px #ccc solid;\
                    border-right:1px #ccc solid;\
                    border-left:1px #ccc solid;}\
                .table-title td{background:#efefef;}\
                .box-detail-table td{text-align:left;}\
                #t4 {margin-top:15px;}\
                .input-text {border:none;}\
                .btn {display:none;}\
                .current {display:none;}\
                .nodis {display:none;}\
                #edui1_bottombar {display:none;}\
                #edui1_toolbarbox {display:none;}\
                select {appearance:none;-webkit-appearance:none;border:none;}\
            </style>\
            </head>');
        newWin.document.write('<div><div class="box-detail">'+dis_t+'</div></div>');
        newWin.print();
        newWin.close(); //关闭新产生的标签页
    }
</script>