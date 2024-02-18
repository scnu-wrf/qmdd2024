<?php
  check_request('p_id',1);
  check_request('g_id',0);
  check_request('gd_id',0);
    $arr=GameListArrange::model()->getGame_arrange($f_dataid);
    $game_order=GameListOrder::model()->findAll('game_id='.$game_id.' AND game_data_id='.$f_dataid.' order by game_data_id DESC limit 1');
   
    $base_upper=BaseCode::model()->getGameArrange2(1005);
    $base_state=BaseCode::model()->getGameArrange2(899);
    $comstr1=BaseCode::model()->down_list_bycode(984); 
  echo '<style>.box-search{margin-top: 0;padding-top: 0;border-top: 0;}</style>';
?>
<div class="box">
    <div class="box-content">
        <div class="box-title c">
            <h1><i class="fa fa-table"></i>赛程列表</h1>
            <span style="float:right;">
                <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;
                    <a class="btn" href="javascript:;" onclick="add_tr();">添加</a>
                    <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
                    <a href="javascript:;" class="btn" onclick="arrange_prom();">晋级方向</a>
                <span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gameList/index');?>');"><i class="fa fa-reply"></i>返回赛事列表</a></span>
            </span>
        </div><!--box-title end-->
        <div class="box-content">
            <div class="box-search">
                <form action="<?php echo Yii::app()->request->url;?>" method="get">
                  <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                  <label style="margin-right:10px;">
                  <?php 
                    $combo=array('g_id'=>'名称','gd_id'=>'项目');
                    echo GameList::model()->game2_combom($combo,$game_id);?>
                  </label>
                  <button class="btn btn-blue" type="submit">查询</button>
                </form>
            </div><!--box-search end-->
            <div class="box-table">
                <table class="list">
                    <thead>
                        <tr>
                            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                            <th style='text-align: center;' class="list-id">序号</th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_name');?></th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_data_id');?></th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('arrange_tcode');?></th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('type');?></th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_player_id');?></th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('rounds');?></th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('matches');?></th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('describe');?></th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_site');?></th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('star_time');?></th>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('game_over');?></th>
                            <th style='text-align: center;'>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td style='text-align: center;' class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td style='text-align: center;'><?php echo $v->game_name; ?></td>
                            <td style='text-align: center;'><?php echo $v->game_data_name; ?></td>
                            <td style='text-align: center;'><?php echo $v->arrange_tcode; ?></td>
                            <td style='text-align: center;'><?php if(!empty($v->game_player_id))echo $v->base_game_player_id->F_NAME; ?></td>
                            <td style='text-align: center;'><?php echo ($v->game_player_id==666 || $v->game_player_id==982) ? $v->team_name : $v->sign_name; ?></td>
                            <td style='text-align: center;'><?php echo $v->rounds; ?></td>
                            <td style='text-align: center;'><?php echo $v->matches; ?></td>
                            <td style='text-align: center;'><?php echo $v->describe; ?></td>
                            <td style='text-align: center;'><?php echo $v->game_site; ?></td>
                            <td style='text-align: center;'><?php echo $v->star_time=='0000-00-00 00:00:00' ? '' : $v->star_time; ?></td>
                            <td style='text-align: center;'><?php echo $v->game_over_name; ?></td>
                            <td style='text-align: center;'>
                                <a class="btn" href="<?php echo $this->createUrl('gameListArrangeScore/update',array('id'=>$v->id,'game_id'=>$v->game_list->id,'data_id'=>$v->game_list_data->id,'data_title'=>$v->game_list_data->game_name,'p_id'=>$_REQUEST['p_id']));?>" title="赛事成绩">成绩管理</a>
                                <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id,'p_id'=>$_REQUEST['p_id']));?>" title="编辑"><i class="fa fa-edit"></i></a>
                                <!-- <a class="btn" href="javascript:;" onclick="we.dele('<?php //echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a> -->
                            </td>
                        </tr>
                        <?php $index++; } ?>
                    </tbody>
                </table>
            </div><!--box-table end-->
            <div class="box-page c"><?php $this->page($pages); ?></div>
        </div><!--box-content || gamesign-lt end-->
    </div>
</div><!--box end-->
<script>
    var team=' ';
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
    $(function(){
        var $star_time=$('#arrange_star_time');
        var $end_time=$('#arrange_end_time');
        $star_time.on('click', function(){
            var end_input=$dp.$('arrange_end_time')
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'arrange_end_time\')}'});
        });
        $end_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'arrange_star_time\')}'});
        });
    });

    var arrange_sign_Html=
        '<div style="width:600px;">'+
            '<table class="box-detail-table showinfo">'+
                '<tr>'+
                    '<td width="15%">选择组别</td>'+
                    '<td colspan="2">'+
                        '<select onchange="fngroup(this);" id="arrange_group">'+
                            '<option value>请选择</option>'+
                            '<?php if(!empty($arrange))foreach($arrange as $g){?>'+
                                '<?php $cou=strlen($g->arrange_tcode);if($cou==5) {?>'+
                                    '<option value="<?php echo $g->id; ?>" arrcode="<?php echo $g->arrange_tcode; ?>"><?php echo $g->arrange_tname; ?></option>'+
                                '<?php }?>'+
                            '<?php }?>'+
                        '</select>'+
                    '</td>'+
                '</tr>'+
                '<tr><td width="20%">签位号</td><td>队名/人</td><td>操作</td></tr>'+
            '</table>'+
            '<form action="" id="arrange_form" name="arrange_form">'+
                '<table id="arrange_tab1" class="box-detail-table showinfo" style="margin-top:0;"></table>'+
            '</form>'+
        '</div>';

    var arrange_prom_Html=
        '<div style="width:600px;">'+
            '<table class="box-detail-table showinfo">'+
                '<tr>'+
                    '<td>选择组别</td>'+
                    '<td colspan="">'+
                        '<select onchange="fngroupProm(this);" id="arrange_prom">'+
                            '<option value>请选择</option>'+
                            '<?php if(!empty($arrange))foreach($arrange as $g){?>'+
                                '<?php $cou=strlen($g->arrange_tcode);if($cou==5) {?>'+
                                    '<option value="<?php echo $g->id; ?>" arrcode="<?php echo $g->arrange_tcode; ?>"><?php echo $g->arrange_tname; ?></option>'+
                                '<?php }?>'+
                            '<?php }?>'+
                        '</select>'+
                    '</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>'+
                        '<span>小组名次</span>&nbsp;&nbsp;'+
                        '<span class="span_tip">'+
                            '<a href="javascript:;" class="dis_rounds"><i class="fa fa-question"></i></a>'+
                            '<div class="tip" style="width:100px;">'+
                                '<p>小组成绩排名名次</p>'+
                                '<i class="t"></i>'+
                            '</div>'+
                        '</span>'+
                    '</td>'+
                    '<td>'+
                        '<span>晋级方向编码</span>&nbsp;&nbsp;'+
                        '<span class="span_tip">'+
                            '<a href="javascript:;" class="dis_rounds"><i class="fa fa-question"></i></a>'+
                            '<div class="tip" style="width:200px;left: -85px;">'+
                                '<p>取得该小组名次的团队/人将进行的晋级的下一轮赛程编码</p>'+
                                '<i class="t" style="left: 84px;"></i>'+
                            '</div>'+
                        '</span>'+
                    '</td>'+
      
                '</tr>'+
            '</table>'+
            '<form action="" id="arrange_form2" name="arrange_form2">'+
                '<table id="arrange_tab2" class="box-detail-table"></table>'+
            '</form>'+
        '</div>';

    var fnUpdateTeam=function(op){
        $(op).parent().parent().remove();
    }
    
    function fngroup_td_set(num,pv1,pv2){
      var s1='<td id="team_no_'+num+'">';
        s1=s1+'<input id="team_name_'+num+'" class="input-text" type="text" name="arrange_tname'+num+'" value="'+pv1+'" readonly>';
        s1=s1+'<input id="team_id_'+num+'" type="hidden" name="arrange_sign_id'+num+'" value="'+pv2+'"></td>';
        return s1;
    }

    function fngroup(obj){
        var arr_code=$('#arrange_group option:selected').attr('arrcode');
        var len=$(obj).val();
        var ma = {};
        var arr = [];
        var g_html='';var s1="";
        num=0;
        for(i=0;i<all_arr.length;i++){
            var all_i = all_arr[i];
            var n = all_i.arrange_tcode;
            var arr_len=all_arr[i]["arrange_tcode"].length;
            var sub_str=all_arr[i]["arrange_tcode"].substr(0,5);
            if(sub_str==arr_code && arr_len==9){
                if(all_arr[i]["sign_id"]==null || all_arr[i]["sign_name"]==null){
                    all_arr[i]["sign_id"]='';
                    all_arr[i]["sign_name"]='';
                }
                num=num+1;
                g_html=g_html+
                '<tr id="dis_no_'+num+'">'+
                    '<td id="sign_no_'+num+'" width="15%"><input id="sign_input_'+num+'" class="input-text" type="text" name="arrange_tab'+num+'" style="width:75%" value="'+all_arr[i]["arrange_tname"]+'" readonly></td>'+
                    '<input id="arrange_tcode_'+num+'" type="hidden" name="arrange_tcode'+num+'" value="'+all_arr[i]["arrange_tcode"]+'">';
                    <?php if(!empty($arrange)){ if($team==665) {?>
                       s1= fngroup_td_set(num,all_arr[i]["sign_name"],all_arr[i]["sign_id"]);
                    <?php }else{?>
                      s1= fngroup_td_set(num,all_arr[i]["team_name"],all_arr[i]["team_id"]);
                    <?php }}?>
                    g_html=g_html+s1+'<td id="select_no_'+num+'">'+
                        '<a class="btn" href="javascript:;" onclick="select_game_team_'+num+'();">选择团队/成员</a>&nbsp;'+
                        '<a class="btn" href="javascript:;" onclick="clear_'+num+'();">清除信息</a>'+
                    '</td>'+
                '</tr>';
            }
            else{
                $('#arrange_tab_no').html('');
                $('#arrange_tab_team').html('');
                $('#arrange_tab_id').html('');
            }
            // num++;
        }
        $("#arrange_tab1").html(g_html);
    }
    
    function fngroupProm(obj){
        var arr_code=$('#arrange_prom option:selected').attr('arrcode');
        var len=$(obj).val();
        num1=0;
        var g_html='';
        for(i=0;i<all_arr.length;i++){
            var all_i = all_arr[i];
            var n = all_i.arrange_tcode;
            var arr_len=all_arr[i]["arrange_tcode"].length;
            var sub_str=all_arr[i]["arrange_tcode"].substr(0,5);
            if(sub_str==arr_code && arr_len==9){
                num1=num1+1;
                g_html=g_html+'<tr id="dis_no_'+num1+'"><td id="sign_no_'+num1+'"><input id="sign_input_'+num1+'" name="arrange_order'+num1+'" class="input-text" type="text" value="'+all_arr[i]["upper_order"]+'"></td>';
                g_html=g_html+'<td id="team_no_'+num1+'"><input id="team_name_'+num1+'" name="arrange_upper'+num1+'" class="input-text" value="'+all_arr[i]["upper_code"]+'" type="text">';
                g_html=g_html+'<input id="team_id_'+num1+'" name="arrange_code_id'+num1+'" value="'+all_arr[i]["id"]+'" type="hidden"></td></tr>';
            }
            else{
                $('#arrange_tab2').html('');
            }
        }
        $("#arrange_tab2").html(g_html);
    }

    function arrange_prom(){
        $.dialog({
            id:'upperporm',
            lock:true,
            opacity:0.3,
            title:'晋级规则',
            height: '45%',
            content:arrange_prom_Html,
            button:[
                {
                    name:'保存',
                    callback:function(){
                       return fnarrange_prom();
                    },
                    focus:true
                },
                {
                    name:'取消',
                    callback:function(){
                        return true;
                    }
                }
            ]
        });
    }

    function fnarrange_prom(){
        var form1=$('#arrange_form2').serialize();
        we.loading('show');
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('gameArrangeProm',array('data_id'=>$f_dataid,'game_id'=>$_REQUEST['game_id']));?>',
            data: form1,
            dataType: 'json',
            success: function(data) {
                if(data.status==1){
                    we.loading('hide');
                    $.dialog.list['upperporm'].close();
                    we.success(data.msg, data.redirect);
                }else{
                    we.loading('hide');
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }

    function get_ajax_data(url,backcall){
        $.ajax({
            type: 'post',
            url: url,
            data: {},
            dataType: 'json',
            success: function(data) { backcall(data); }
        });
        return false;
    }
   
    var cout=0;

    function group_prom(code){
        cout=code.length;
        var u1="<?php echo $this->createUrl('Getgroupscore',array('data_id'=>$f_dataid,'game_id'=>$_REQUEST['game_id']));?>&game_code="+code;
           get_ajax_data(u1,input_group_prom);
    }
   
    function get_option(base_state,pname,pvalue,poname){
        var s1='<select name="option_'+poname+'"><option value>请选择</option>';
        for (var i1=0;i1<base_state.length;i1++){
            s1=s1+'<option value="'+base_state[i1][pname]+'"';
            if(base_state[i1][pname]==pvalue){
                s1=s1+' selected ';
            }
            s1=s1+'>'+base_state[i1]["F_NAME"]+'</option>';
        }
        return s1+'</select>';
    }

    var base_state=<?php echo json_encode($base_state);?>;
    var base_upper=<?php echo json_encode($base_upper);?>;
    var d1 = document.getElementsByClassName('aui_content');

    function dialog_box(pidname,ptitle,pcontent,preturn_function){
        $.dialog({
            id:pidname,  lock:true,opacity:0.3,title:ptitle,
            content: pcontent, 
            button:[
                {
                    name:'保存',
                    callback:function(){return preturn_function(); },
                    focus:true
                },
                {
                    name:'取消',callback:function(){return true;}
                }
            ]
        });
    }

    
   function get_td_set(num,pv1,pv2){
      var s1='<td><input class="input-text" name="grou_team_name'+num+'" value="'+pv1+'" readonly>';
       s1=s1+'<input type="hidden" name="grou_team_id'+num+'" value="'+pv2+'">';
        return s1;
    }

   function get_score_set(num,pv1,pv2,pv2,pname){
        var s1=get_td_input(num,panme,pv1);
        s1=s1+get_td_input(num,panme+'_mark',pv1);
        s1=x1+get_td_input(num,panme+'_order',pv1);
        return s1;
    }
  function get_td_input(num,pname,pv){
      return '<td><input class="input-text" name="'+pname+num+'" value="'+pv+'"></td>';
   }


    function input_group_prom(data){
        num4=0;
        var s1='<div style="width:500px;"><form action="" id="arrange_form4" name="arrange_form4">';
            s1=s1+'<table class="box-detail-table showinfo"><tr><th colspan="2">晋级方向编码</th></tr>';
            for(var i=0;i<data.length;i++){
                num4=num4+1;
                s1=s1+'<tr><td><input class="input-text" name="group_prom_tcode'+num4+'" value="'+data[i]['upper_order']+'">';
                s1=s1+'<input id="group_prom'+num4+'" name="group_prom_id'+num4+'" value="'+data[i]["id"]+'" type="hidden"></td>';
                s1=s1+'<td><input class="input-text" type="text" name="group_prom_upper'+num4+'" value="'+data[i]['upper_code']+'"></td></tr>';
            }
            s1=s1+'</table></form></div>';
            dialog_box('groupprom','本场晋级方向',s1,fngroup_prom);
    }

    function fngroup_prom(){
        var form3=$('#arrange_form4').serialize();
        we.loading('show');
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('gameGroupProm',array('data_id'=>$f_dataid,'game_id'=>$_REQUEST['game_id']));?>',
            data: form3,
            dataType: 'json',
            success: function(data) {
                 we.loading('hide');
                if(data.status==1){
                    $.dialog.list['groupprom'].close();
                    we.success(data.msg, data.redirect);
                }else{
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }

</script>
<script>
    var screen = document.documentElement.clientWidth;
    var sc = screen-50;
    var o_num = 1;
    var add_html = 
        '<div id="add_format" style="width:'+sc+'px;">'+
            '<form id="add_form" name="add_form">'+
                '<table id="table_tag" style="width:100%;border: solid 1px #d9d9d9;">'+
                    '<thead>'+
                        '<tr class="table-title">'+
                            '<td colspan="10" style="padding: 5px;">添加&nbsp;&nbsp;<input type="button" class="btn btn-blue" onclick="add_tag();" value="添加"></td>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody>'+
                        '<tr style="text-align:center;">'+
                            '<td style="width: 90px;">赛程编码</td>'+
                            '<td style="width: 100px;">名称</td>'+
                            '<td style="width: 50px;">赛制</td>'+
                            '<td style="width: 150px;">比赛场地</td>'+
                            '<td style="width: 115px;">比赛开始时间</td>'+
                            '<td style="width: 115px;">比赛结束时间</td>'+
                            '<td style="width: 80px;">是否开通投票</td>'+
                            '<td style="width: 80px;">是否发布</td>'+
                            '<td style="width: 115px;">发布时间</td>'+
                            '<td style="width: 60px;">操作</td>'+
                        '</tr>'+
                    '</tbody>'+
                '</table>'+
            '</form>'+
        '</div>';

    // var a = '<a class="btn dis_a" href="javascript:;" onclick="tag_dele(this);">删除</a>';
    function tag_dele(op){
        $(op).parent().parent().remove();
    }

    function time(){
        WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm'});
    }

    function add_tr(){
        $.dialog({
            id:'tianjia',
            lock:true,opacity:0.3,height: '80%',title:'添加赛程',
            content:add_html,
            button:[
                {
                    name:'保存', callback:function(){return fn_add_tr();},focus:true
                },
                {
                    name:'取消', callback:function(){ return true; }
                }
            ]
        });
        $('.aui_main').css('height','auto');
    }

    
    function add_tag(){
        var table_tag = $('#table_tag');
        var tab_html = 
            '<tr style="text-align:center;" class="add_len">'+
                '<td>'+input_set(o_num,'arrange_tcode')+'</td>'+
                '<td>'+input_set(o_num,'arrange_tname')+'</td>'+
                '<td>'+select_set(o_num,'game_format',984)+'</td>'+
                '<td>'+input_set(o_num,'game_site')+'</td>'+
                '<td>'+input_set(o_num,'star_time')+'</td>'+
                '<td>'+input_set(o_num,'end_time')+'</td>'+
                '<td>'+select_set(o_num,'if_votes',647)+'</td>'+
                '<td>'+select_set(o_num,'if_rele',647)+'</td>'+
                '<td><input style="width:85%;" type="text" class="input-text" onclick="time(this);" name="table_tag['+o_num+'][rele_date_start]"></td>'+
                '<td class="del_tag"><a class="btn dis_a" href="javascript:;" onclick="tag_dele(this);">删除</a></td>'+
            '</tr>';
        table_tag.append(tab_html);
        o_num++;
    }
    add_tag();//'添加第一条记录'

    function select_set(o_num,snamem,$pcode){
        var s1='<select name="table_tag['+o_num+']['+snamem+']">';
            if($pcode==984)
            s1=s1+'<?php echo BaseCode::model()->down_list_bycode(984); ?>';
            if($pcode==647)
            s1=s1+'<?php echo BaseCode::model()->down_list_bycode(647); ?>';
      return s1+'</select>';
    }
    function input_set(o_num,snamem){
        var s1='<input style="width:80%;" type="text" class="input-text"';
        return s1=s1+' name="table_tag['+o_num+']['+snamem+']">';
    }

    function fn_add_tr(){
        var is_nul = $('#table_tag tbody tr td .input-text');
        if(is_nul.val()==''){
            we.msg('minus','请输入数据');
            return false;
        }
        var form=$('#add_form').serialize();
        we.loading('show');
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('addForm',array('data_id'=>$f_dataid,'game_id'=>$_REQUEST['game_id']));?>',
            data: form,
            dataType: 'json',
            success: function(data) {
                we.loading('hide');
                if(data.status==1){
                    $.dialog.list['tianjia'].close();
                    we.success(data.msg, data.redirect);
                }else{
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }

</script>
<script>
    $(window).resize(function(){
        $('#add_format').css('width',$(window).width()-30);
    });
</script>

<script>
    function select_game_team(num){
        if(team==665){
            select_sign(num,"sign_id",'sign_title','sign_head_pic');
        } else{ 
            select_sign(num,"id",'name','logo');}
    }
    
    function clear(num){
        $('#team_name_'+num).val("");
        $("#team_id_"+num).val("");
        $("#logo_"+num).val("");
    }
    function select_sign(num,pid,pname,plog,idn){
        var purl="<?php echo $this->createUrl('select/gameSignList');?>";
        if(pid=='id'){ purl="<?php echo $this->createUrl('select/gameTeamTable');?>";}
        purl=purl+"&game_list_data_id="+idn;
        $.dialog.data(pid, 0);
        $.dialog.open(purl,{
            id:"menber",lock:true,opacity:0.3,
            title:"选择具体内容",
            width:"600px", height:"70%",
            close: function(){
                if( $.dialog.data(pid)>0){
                    $("#team_id_"+num).val($.dialog.data(pid));+
                    $("#team_name_"+num).val($.dialog.data(pname));
                    $("#logo_"+num).val($.dialog.data(plog));
                }
            }
        });
    }
</script>

