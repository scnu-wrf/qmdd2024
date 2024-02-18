<?php
    if(!isset($_REQUEST['p_id'])){
        $_REQUEST['p_id'] = 1;
    }
    if(!isset($model->id)){
        $model->id=0;
    }
    $time='1990-01-01 00:00:01';
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
        <h1>当前界面：赛事 》赛事管理 》赛事列表 》赛程/成绩 》<a class="nav-a">添加赛段</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回列表</a></span>
    </div><!--box-title end-->
    <div id="t1" class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                    <tr>
                        <td width="12%"><?php echo $form->labelEx($model, 'game_name'); ?></td>
                        <td colspan=6><?php echo $game_name;?><?php echo $form->hiddenField($model, 'game_id', array('class' => 'input-text', 'value'=>$game_id)); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'project_id'); ?></td>
                        <td colspan=6>						
                            <?php echo $form->dropDownList($model, 'project_id', Chtml::listData($project_list, 'project_id', 'project_name'), array('prompt'=>'请选择','onchange'=>'changeProjectid(this);')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_data_id'); ?></td>
                        <td colspan=6>
							<select name="GameListArrange[game_data_id]" id="GameListArrange_game_data_id" onchange="changeDataid(this);">
								<option value="">请选择</option>
							</select>
							<?php echo $form->hiddenField($model, 'game_mode', array('class' => 'input-text')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_mode'); ?></td>
                        <td colspan=6 id="game_mode_name"></td>
                    </tr>
                    <tr>
                        <td colspan=7>赛段设置</td>
                    </tr>
				</table>
				<table style="table-layout:auto;" id="program_list" data-num="new">
                    <tr class="table-title">
                        <td width="12%">赛段编码</td>
                        <td>赛段名称</td>
                        <td>赛制</td>
                        <td>总签位数</td>
                        <td>总组数</td>
                        <td>每组签位数</td>
                        <td>操作</td>
                    </tr>
                    <tr>
                        <td><span style="color:#7a7a7a;text-align:center;">系统生成</span></td>
                        <td><input type="hidden" class="input-text" name="programs_list[new][id]" value="null" /><input onchange="fnUpdateProgram();" class="input-text up_title" name="programs_list[new][arrange_tname]" value=""></td>
                        <td><?php echo $form->dropDownList($model, 'game_format', Chtml::listData(array_merge(BaseCode::model()->getCode(985),BaseCode::model()->getCode(988)), 'f_id', 'F_NAME'),array('prompt'=>'请选择','onchange' =>''))?></td>
                        <td>总签位数</td>
                        <td>总组数</td>
                        <td>每组签位数</td>
                        <td>操作</td>
                    </tr>
				</table>
				<table>
                    <tr>
                        <td width="12%">操作</td>
                        <td colspan=6>
							<?php echo show_shenhe_box(array('baocun'=>'保存'));?>
							<button class="btn" type="button" onclick="we.back();">取消</button>
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
<script>
    function changeProjectid(obj){
        var val = $(obj).val();
        var s_html = '<option value>请选择</option>';
        if(val > 0){
            var pr = '<?php echo $data_id; ?>';
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('GameSignList/getDataByProject'); ?>&game_id=<?php echo $game_id;?>&project_id='+val,
                dataType: 'json',
                success: function(data) {
                    for(var i=0;i<data[0].length;i++){
                        s_html += '<option value="'+data[0][i]['id']+'" '+((data[0][i]['id']==pr) ? 'selected>' : ' game_mode="'+data[0][i]['game_mode']+'" game_mode_name="'+data[0][i]['game_mode_name']+'">')+data[0][i]['game_data_name']+'</option>';
                    }
                    $('#GameListArrange_game_data_id').html(s_html);
                }
            });
        }
        else{
            $('#GameListArrange_game_data_id').html(s_html);
        }
    }
	function changeDataid(obj){
		var game_mode = $(obj).find("option:selected").attr("game_mode");
		var game_mode_name = $(obj).find("option:selected").attr("game_mode_name");
		$("#GameListArrange_game_mode").val(game_mode);
		$("#game_mode_name").html(game_mode_name);
	}
</script>
