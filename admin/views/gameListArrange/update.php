<?php
    if(!isset($_REQUEST['p_id'])){
        $_REQUEST['p_id'] = 1;
    }
    if(!isset($model->id)){
        $model->id=0;
    }
    $time='0000-00-00 00:00:00';
    if(!empty($model->votes_star_time==$time)){
        $model->votes_star_time='';
    }
    if(!empty($model->votes_end_time==$time)){
        $model->votes_end_time='';
    }
    if(!empty($model->star_time==$time)){
        $model->star_time='';
    }
    if(!empty($model->end_time==$time)){
        $model->end_time='';
    }
    if(!empty($model->rele_date_start==$time)){
        $model->rele_date_start='';
    }
    if(!isset($_REQUEST['data_id'])){
        $_REQUEST['data_id']=0;
    }
    if(empty($_REQUEST['game_id'])){
        $_REQUEST['game_id']=0;
    }
    if(!isset($_REQUEST['game_format'])){
        $_REQUEST['game_format']=0;
    }
    if(!empty($model->game_data_id)){
        $game_data=GameListData::model()->find('id='.$model->game_data_id);
        $gamelist=GameList::model()->find('id='.$model->game_id);
    }
    else{
        $game_data=GameListData::model()->find('id='.$_REQUEST['data_id']);
        $gamelist=GameList::model()->find('id='.$_REQUEST['game_id']);
    }
    $disabled = ($_REQUEST['p_id']==0) ? 'disabled' : '';
    $readonly = ($_REQUEST['p_id']==0) ? 'readonly' : '';
    $team=$game_data->game_player_team;
?>
<div class="box">
    <div id="t0" class="box-title c">
        <h1><i class="fa fa-table"></i><?php if(empty($model->id)) {echo '添加赛程';}else{echo '管理详情';} ?></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回列表</a></span>
    </div><!--box-title end-->
    <div id="t1" class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                    <tr class="table-title">
                        <td colspan="4">赛事信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_name'); ?></td>
                        <td>
                            <span><?php if($model->game_name!=null){?><?php echo $form->hiddenField($model, 'game_name', array('class' => 'input-text')); ?><span class="label-box"><?php echo $model->game_name;?></span><?php } else { ?><?php echo $form->hiddenField($model, 'game_name', array('class' => 'input-text', 'value'=>$game_data->game_id)); ?><span class="label-box"><?php echo $game_data->game_name;?></span> <?php }?></span>
                        </td>
                        <td><?php echo $form->labelEx($model, 'project_id'); ?></td>
                        <td>						
                            <span><?php if($model->game_list_data!=null){?><?php echo $form->hiddenfield($model, 'project_id', array('class' => 'input-text')); ?><span class="label-box"><?php echo $game_data->project_name;?></span><?php } else {?><?php echo $form->hiddenfield($model, 'project_id', array('class' => 'input-text', 'value'=>$game_data->project_id)); ?><span class="label-box"><?php echo $game_data->project_name;?></span><?php } ?></span>
                        </td>
                    </tr>
                    <tr>
                        <?php if($model->id=='') {?>
                            <td style="display:none">
                                <?php echo $form->hiddenField($model, 'fater_id', array('class' => 'input-text', 'value'=>$_REQUEST["pid"])); ?>
                            </td>
                        <?php }?>
                        <td><?php echo $form->labelEx($model, 'game_data_id'); ?></td>
                        <td colspan="3">
                            <span><?php if($model->game_list_data!=null){?><?php echo $form->hiddenfield($model, 'game_data_id', array('class' => 'input-text')); ?><span class="label-box"><?php echo $model->game_list_data->game_data_name;?></span><?php } else {?><?php echo $form->hiddenfield($model, 'game_data_id', array('class' => 'input-text', 'value'=>$_REQUEST['data_id'])); ?><span class="label-box"><?php echo $game_data->game_data_name;?></span><?php } ?></span>                       
                        </td>
                        <td style="display:none;"><?php echo $form->hiddenField($model, 'game_play_id', array('class' => 'input-text')); ?></td>
                    </tr>
                </table>
                <table class="mt15">
                    <tr class="table-title">
                        <td colspan="4">赛程信息 </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'arrange_tcode'); ?></td>
                        <td>
                            <?php
                                echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'arrange_tcode', array('class' => 'input-text','style'=>'width:80%')) : $form->hiddenField($model,'arrange_tcode').$model->arrange_tcode;
                            ?>
                            <span class="span_tip">
                                <a href="javascript:;" class="dis_rounds"><i class="fa fa-question"></i></a>
                                <div class="tip">
                                    <img class="tip_img">
                                    <i class="t"></i>
                                </div>
                            </span>
                            <?php echo $form->error($model, 'arrange_tcode', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_format'); ?></td>
                        <td>
                            <?php if($_REQUEST['game_format']>0) {?>
                                <select name="GameListArrange[game_format}" id="GameListArrange_game_format" onchange="selectOnchangGameList(this);" disabled="<?php echo $disabled; ?>">
                                    <option value>请选择</option>
                                    <?php
                                        $base_code=BaseCode::model()->getCode(984);
                                        if(!empty($base_code))foreach($base_code as $ba){ $fid=$ba->f_id; ?>
                                            <option value="<?php echo $fid; ?>" <?php if($fid==$_REQUEST['game_format']) {?>selected<?php }?>><?php echo $ba->F_NAME; ?></option>
                                        <?php }?>
                                </select>
                            <?php }else{?>
                                <?php echo $form->dropDownList($model, 'game_format', Chtml::listData(BaseCode::model()->getCode(984), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange'=>'selectOnchangGameList(this);','disabled'=>$disabled)); ?>
                            <?php }?>
                            <?php echo $form->error($model, 'game_format', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'arrange_tname'); ?></td>
                        <td>
                            <?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'arrange_tname', array('class' => 'input-text')) : $model->arrange_tname; ?>
                            <?php echo $form->error($model, 'arrange_tname', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_site'); ?></td>
                        <td>
                            <?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'game_site', array('class' => 'input-text')) : $model->game_site; ?>
                            <?php echo $form->error($model, 'game_site', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr id="dis_group" style="display:none;">
                        <td><?php echo $form->labelEx($model, 'game_group_name'); ?></td>
                        <td colspan="3"><?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'game_group_name', array('class'=>'input-text')) : $model->game_group_name; ?></td>
                    </tr>
                    <!-- <tr>
                        <td><?php //echo $form->labelEx($model, 'rounds'); ?></td>
                        <td>
                            <?php //echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'rounds', array('class' => 'input-text','placeholder' => '请输入第一轮/第二轮...')) : $model->rounds; ?>
                            <?php //echo $form->error($model, 'rounds', $htmlOptions = array()); ?>
                        </td>
                        <td><?php //echo $form->labelEx($model, 'matches'); ?></td>
                        <td>
                            <?php //echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'matches', array('class' => 'input-text')) : $model->matches; ?>
                            <?php //echo $form->error($model, 'matches', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php //echo $form->labelEx($model, 'describe'); ?></td>
                        <td colspan="3">
                            <?php //echo ($_REQUEST['p_id']!=0) ? $form->textarea($model, 'describe', array('class' => 'input-text')) : $model->describe; ?>
                            <br><span class="msg">*做为点/直播视频短码使用</span>
                        </td>
                    </tr> -->
                   <!--<tr>
                        <td><?php //echo $form->labelEx($model, 'upper_order'); ?></td>
                        <td>
                            <?php //echo $form->textField($model, 'upper_order', array('class' => 'input-text')); ?>
                            <?php //echo $form->error($model, 'upper_order', $htmlOptions = array()); ?>
                        </td>
                        <td><?php //echo $form->labelEx($model, 'upper_code'); ?></td>
                        <td>
                            <?php //echo $form->textField($model, 'upper_code', array('class' => 'input-text')); ?>
                            <?php //echo $form->error($model, 'upper_code', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php //echo $form->labelEx($model, 'group_sort_code'); ?></td>
                        <td>
                            <?php //echo $form->textField($model, 'group_sort_code', array('class' => 'input-text')); ?>
                            <?php //echo $form->error($model, 'group_sort_code', $htmlOptions = array()); ?>
                        </td>
                        <td><?php //echo $form->labelEx($model, 'total_sort_code'); ?></td>
                        <td>
                            <?php //echo $form->textField($model, 'total_sort_code', array('class' => 'input-text')); ?>
                            <?php //echo $form->error($model, 'total_sort_code', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                       <tr>
                        <td><?php //echo $form->labelEx($model, 'total_sore_base'); ?></td>
                        <td colspan="3">
                            <?php //echo $form->textField($model, 'total_sore_base', array('class' => 'input-text')); ?>
                            <?php //echo $form->error($model, 'total_sore_base', $htmlOptions = array()); ?>
                        </td>
                    </tr>-->
                    <tr>
                        <td><?php echo $form->labelEx($model, 'star_time'); ?></td>
                        <td>
                            <?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'star_time', array('class' => 'input-text')) : $model->star_time; ?>
                            <?php echo $form->error($model, 'star_time', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'end_time'); ?></td>
                        <td>
                            <?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'end_time', array('class' => 'input-text')) : $model->end_time; ?>
                            <?php echo $form->error($model, 'end_time', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <table class="mt15">
                    <tr>
                        <td colspan="4" style="background:#efefef;">投票设置</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'if_votes'); ?></td>
                        <td colspan="3"><?php echo $form->dropDownList($model, 'if_votes', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange'=>'selectOnchang(this)','disabled'=>$disabled)); ?></td>
                    </tr>
                    <tr id="vote_time" style="display:none"><!--开通投票时打开-->
                        <td><?php echo $form->labelEx($model, 'votes_star_time'); ?></td>
                        <td><?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'votes_star_time', array('class' => 'input-text')) : $model->votes_star_time; ?></td>
                        <td><?php echo $form->labelEx($model, 'votes_end_time'); ?></td>
                        <td><?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'votes_end_time', array('class' => 'input-text')) : $model->votes_end_time; ?></td>
                    </tr>
                </table>
                <table class="mt15">
                    <tr class="table-title">
                        <td colspan="4">赛程发布设置</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'if_rele'); ?></td>
                        <td class="dis_if_rele"><?php echo $form->dropDownList($model,'if_rele', Chtml::listData(BaseCode::model()->getCode(647),'f_id','F_NAME'),array('prompt'=>'请选择','onchange'=>'selectIfrele(this);','disabled'=>$disabled)); ?></td>
                        <td class="dis_rele_date_start"><?php echo $form->labelEx($model,'rele_date_start'); ?></td>
                        <td class="dis_rele_date_start"><?php echo $form->textField($model,'rele_date_start',array('class'=>'input-text text-time')); ?></td>
                    </tr>
                </table>
                <?php echo $form->hiddenField($model, 'team_data', array('class' => 'input-text')); ?>
                <table class="mt15" id="team_data">
                    <!--隐藏添加按钮和签号显示，增加道次显示，并且只显示一条数据-->
                    <tr class="table-title">
                        <td colspan="5">参赛团队/成员&nbsp;&nbsp;
                            <input onclick="add_team()" class="btn" type="button" value="添加" disabled="<?php echo $disabled; ?>">
                        </td>
                    </tr>
                    <tr style="text-align:center;">
                        <!--<td>签号</td>-->
                        <td>序号</td>
                        <td>编号&nbsp;&nbsp;<span>(临时账号编号在1000以内)</span></td>
                        <td>参赛团队/成员</td>
                        <td><?php echo $form->labelEx($model, 'colour') ?></td>
                        <td><?php echo $form->labelEx($model, 'runway') ?></td>
                        <!-- <td>操作</td> -->
                    </tr>
                    <?php
                        if($team==665){ $programs=GameListArrange::model()->findAll('substr(arrange_tcode,10,0)!=" "'); }
                        else{
                            $model->game_id=empty($model->game_id) ? 0 : $model->game_id;
                            $model->game_data_id=empty($model->game_data_id) ? 0 : $model->game_data_id;
                            $model->arrange_tcode=empty($model->arrange_tcode) ? 0 : $model->arrange_tcode;
                            $len="game_id=".$model->game_id." AND game_data_id=".$model->game_data_id." AND left(arrange_tcode,9)='".$model->arrange_tcode."' AND substr(arrange_tcode,11,1)<>' '";
                            $programs=GameListArrange::model()->findAll(array('order'=>'arrange_tcode','group'=>'arrange_tcode','condition'=>$len));
                        }
                        $num=0;
                        foreach($programs as $v){
                            // $s1=($v->game_player_id==665) ? $v->sign_id : $v->team_id;
                            // $s2=($v->game_player_id==665) ? $v->sign_name : $v->team_name;
                    ?>
                    <tr>
                        <td><input class="input-text" name="team_data[<?php echo $num;?>][t_no]" value="<?php echo $v->arrange_tcode;?>" readonly="<?php echo $readonly; ?>"></td>
                        <td>
                            <input class="input-text" name="team_data[<?php echo $num;?>][t_s_id]" id="id_<?php echo $num;?>" value="<?php echo $v->sign_id;?>" readonly="<?php echo $readonly; ?>">
                            <!-- <script>
                                var len=$('#id_<?php echo $num; ?>');
                                len.onkeyup = function(){
                                    len.value=len.value.replace(/\D/g,'');
                                    if(len.value>1000){
                                        len.value = 1000;
                                    }
                                }
                            </script> -->
                        </td>
                        <td><input class="input-text" name="team_data[<?php echo $num;?>][t_s_name]" id="team_name_<?php echo $num;?>" value="<?php echo $v->sign_name; ?>" readonly="<?php echo $readonly; ?>"></td>
                        <td><input class="input-text" name="team_data[<?php echo $num;?>][colour]" value="<?php echo $v->colour; ?>" readonly="<?php echo $readonly; ?>"></td>
                        <td><input class="input-text" name="team_data[<?php echo $num;?>][runway]" value="<?php echo $v->runway; ?>" readonly="<?php echo $readonly; ?>"></td>
                        <!-- <td style="text-align:center;"> -->
                            <!-- <a class="btn" href="javascript:;" onclick="select_game_team(<?php echo $num;?>);" title="选择">选择团队/成员</a>
                            <a class="btn" href="javascript:;" onclick="fnDeleteTeam(this);" title="删除"><i class="fa fa-trash-o"></i></a> -->
                            <input class="input-text" type="hidden" name="team_data[<?php echo $num; ?>][id]" value="<?php echo $v->id; ?>">
                        <!-- </td> -->
                    </tr>
                    <?php $num=$num+1;}?>
                </table>
                <table class="mt15">
                    <tr class="dis_btn">
                        <td colspan="3" style='text-align:center;'>
                            <?php if($_REQUEST['p_id']!=0) echo show_shenhe_box(array('baocun'=>'保存'));?>
                            <!--<button class="btn" type="reset">重置</button>-->
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                            <button class="btn" type="button" onclick="printpage();" title="保存后可打印">打印</button>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    var team=<?php echo $team;?>;
    var num=<?php echo $num;?>;

    $('#GameListArrange_star_time').on('click', function(){WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm'});});
    $('#GameListArrange_end_time').on('click', function(){WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm'});});
    $('#GameListArrange_votes_star_time').on('click', function(){WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm'});});
    $('#GameListArrange_votes_end_time').on('click', function(){WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm'});});
    $('.text-time').on('click', function(){WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm'});});

    function selectOnchang(obj){
        var votestype=$(obj).val();
        var vote_time=$('#vote_time');
        if (votestype==649) {
            vote_time.show();
        }
        else{
            vote_time.hide();
        }
    }

    function selectOnchangGameList(obj){
        var show_id=$(obj).val();
        if(show_id==988){
            $('#dis_group').show();
        }
        else{
            $('#dis_group').hide();
        }
    }

    function tcode_sign(obj){
        var obj = $(obj).val();
        if(obj.length>=8){
            $('#team_data').show();
        }
        else{
            $('#team_data').hide();
        }
    }

    function selectIfrele(obj){
        var obj = $(obj).val();
        if(obj==649){
            $('.dis_rele_date_start').show();
            $('.dis_if_rele').attr('colspan',1);
        }
        else{
            $('.dis_rele_date_start').hide();
            $('.dis_if_rele').attr('colspan',3);
        }
    }

    $(function(){
        var votestype=$('#GameListArrange_if_votes').val();
        var vote_time=$('#vote_time');
        if(votestype==649){
            $('#vote_time').show();
        }
        else{
            $('#vote_time').hide();
        }

        var group=$('#GameListArrange_game_format').val();
        if(group==988){
            $('#dis_group').show();
        }
        else{
            $('#dis_group').hide();
        }

        var tcode_sign=$('#GameListArrange_arrange_tcode').val();
        if(tcode_sign.length>=8){
            $('#team_data').show();
        }
        else{
            $('#team_data').hide();
        }

        var if_rele = $('#GameListArrange_if_rele').val()
        if(if_rele!=649){
            $('.dis_rele_date_start').hide();
            $('.dis_if_rele').attr('colspan',3);
        }
        else{
            $('.dis_rele_date_start').show();
            $('.dis_if_rele').attr('colspan',1);
        }
    })

    var $team_data=$('#team_data');
    function add_team(){
        var add_h = 
            '<tr>'+
                '<td><input class="input-text" name="team_data['+num+'][t_no]" value></td>'+
                '<td><input class="input-text" name="team_data['+num+'][t_s_id]" id="id_'+num+'" value></td>'+
                '<td><input class="input-text" name="team_data['+num+'][t_s_name]" id="team_name_'+num+'" value></td>'+
                '<td><input class="input-text" name="team_data['+num+'][colour]" value></td>'+
                '<td><input class="input-text" name="team_data['+num+'][runway]" value></td>'+
                // '<td style="text-align:center;">'+
                    // '<a class="btn" href="javascript:;" onclick="select_game_team('+num+');" title="选择">选择团队/成员</a>&nbsp'+
                    // '<a class="btn dele" href="javascript:;" onclick="fnDeleteTeam(this);" title="删除"><i class="fa fa-trash-o"></i></a>'+
                    // '<input class="input-text" type="hidden" name="team_data['+num+'][tean_gf_ida]" id="ida_'+num+'" />'+
                    // '<input class="input-text" type="hidden" name="team_data['+num+'][tean_gf_accounta]" id="accounta_'+num+'" />'+
                    '<input class="input-text" type="hidden" name="team_data['+num+'][id]" value="null">'+
                // '</td>'+
            '</tr>';
        $team_data.append(add_h);
        fnUpdateTeam();
        num++;
    }
    $('#GameListArrange_game_play_id').val(team);

    function select_game_team(prow){
        var pgame_id= $('#GameListArrange_game_data_id').val();
        team=$('#GameListArrange_game_play_id').val();
        if(team==665){select_sign(prow,pgame_id);}
        else{ select_team(prow,pgame_id) ;}
    }
    
    var fnDeleteTeam=function(op){
        $(op).parent().parent().remove();
        fnUpdateTeam();
    }

    var fnUpdateTeam=function(){
        var isEmpty=true;
        $team_data.find('.input-text').each(function(){
            if($(this).val()!=''){
                isEmpty=false;
                //return false;
            }
        });
        if(!isEmpty){
            $('#GameListArrange_team_data').val('1').trigger('blur');
        }else{
            $('#GameListArrange_team_data').val('').trigger('blur');
        }
    };

    // 选择成员
    function select_sign(prow,pid) {
        $.dialog.data('sign_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/gameSignList");?>&game_list_data_id='+pid,{
            id:'menber',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('sign_id')>0){
                    $('#id_'+prow).val($.dialog.data('sign_id'));
                    $('#team_name_'+prow).val($.dialog.data('sign_title'));
                    $('#ida_'+prow).val($.dialog.data('sign_gfid'));
                    $('#accounta_'+prow).val($.dialog.data('sign_account'));
                }
            }
        });
        // console.log(prow);
    }
 
    // 选择团队主队
    function select_team(prow,pid){
        $.dialog.data('team_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/gameTeamTable");?>&game_list_data_id='+pid,{
            id:'danwei',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('team_id')>0){
                    $('#id_'+prow).val($.dialog.data('team_id'));
                    $('#team_name_'+prow).val($.dialog.data('team_title'));
                    $('#ida_'+prow).val($.dialog.data('sign_gfid'));
                    $('#accounta_'+prow).val($.dialog.data('sign_account'));
                }
            }
        });
    }


</script>
<script>
    function printpage(){
        var html='';
        for(var i=0;i<2;i++){
            html += '<table>'+$("#t"+i).html()+"</table>";
            if(i==1 || i==2);
        }
        
        var newWin = window.open('', '', '');
        newWin.document.write('<head>\
            <style>\
                .box-detail table{\
                    table-layout:fixed;\
                    width:100%;\
                    border-spacing:1px;\
                    border-collapse:collapse;\
                    background:#ccc;}\
                .box-detail td{\
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
                .btn {display:none;}\
                .dis_btn {display:none;}\
                .mt15 {margin-top:15px;}\
                .input-text {border:none;}\
                .showinfo {margin-top:15px;}\
                .showinfo tr td {text-align:center;}\
                #team_data tr:nth-child(2) td{text-align:center;}\
                h1 {font-size:18px;}\
                textarea{resize:none;}\
                .msg {font-size:8px;color:#999}\
                select {appearance:none;-webkit-appearance:none;border:none;}\
            </style>\
        </head>');
        newWin.document.write('<div><div class="box-detail">'+html+'</div></div>');
        newWin.print();
        newWin.close(); //关闭新产生的标签页
    }
</script>
