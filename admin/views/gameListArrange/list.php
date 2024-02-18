<?php
    check_request('p_id',1);
    check_request('game_id',0);
    check_request('data_id',0);
    check_request('check_team',0);
    check_request('arrange_tcode',0);
    if(!isset($_REQUEST['back'])) $_REQUEST['back'] = 0;
    if(!isset($_REQUEST['back'])){
        $_REQUEST['back'] = 0;
    }
    $url = '';
    if($_REQUEST['back']==1){
        $url = 'gameList/index_list';
    }
    else if($_REQUEST['back']==2){
        $url = 'gameList/game_club_search';
    }
    else if($_REQUEST['back']==3){
        $url = 'gameList/game_history_search';
    }
    else if($_REQUEST['back']==4){
        $url = 'gameList/game_club_history_search';
    }
    $bstr = 'f_id,F_NAME';
    $gformat = BaseCode::model()->getCode(984);
    $game_mode = BaseCode::model()->getReturn('662,663');
    echo $_REQUEST['arrange_tcode'];
?>
<style>
    .box-table .list tr th,.box-table .list tr td{ text-align: center; }
    .aui_content{ height:auto;overflow:auto;padding:5px 5px!important;max-height: 400px!important;min-height:300px!important; }
    .aui_main{ height:auto!important; }
    .btn i{ margin-right: 0; }
    .switch{ width:50px; }
    .btn_fath{ position:relative; border-radius:20px; }
    .btn1{ float:left; }
    .btn2{ float:right; }
    .btnSwitch{height:25px;width:25px;border:none;color:#fff;line-height:22px;font-size:14px;text-align:center;z-index:1;}
    .move{width:20px;height:20px;z-index:100;border-radius:20px;cursor:pointer;position:absolute;border:1px solid #828282;background-color:#f1eff0;}
    .on .move{left:29px;}
    .on.btn_fath{background-color:#44b549;height:22px}
    .off.btn_fath{background-color:#828282;height:22px}
    .nav-ul li{ display:inline-block;width:8%;padding:5px;text-align:center;background-color:#5b8d98;color:white;cursor:pointer;margin-top:5px; }
    .td_bor{ border-bottom: solid 2px #d6841e; }
    .box-detail-tab li { width: 120px; }
    .gamesign-group a:nth-last-child(1){ margin-bottom:100px; }
    .span_inline_block{ display: inline-block;width: 50px; }
</style>
<div class="box" style="margin: 0px 10px 10px 0;">
    <div class="box-title c" style="width: 99%;position: fixed;top: 0px;background-color: #F2F2F2;z-index: 99;">
        <h1>当前界面：赛事/排名 》赛事发布 》赛程安排</h1>
        <span class="back">
            <?php if($_REQUEST['back']>0) {?>
                <a class="btn" href="<?php echo $this->createUrl($url); ?>">返回上一层</a>
            <?php }?>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;
        </span>
    </div><!--box-title end-->
    <div class="box-search" style="margin-top: 43px;width: 99%;z-index: 99;position: fixed;top: 0px;">
        <form action="<?php echo Yii::app()->request->url;?>" method="get">
            <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
            <input type="hidden" name="submitType" id="submitType" value="">
            <input type="hidden" name="back" value="<?php echo $_REQUEST['back']; ?>">
            <input type="hidden" name="arrange_tcode" id="arrange_tcode" value="<?php echo $_REQUEST['arrange_tcode']; ?>">
            <label style="margin-right:10px;">
                <span class="span_inline_block">赛事：</span>
                <?php echo downList($game_id,'id','game_title','game_id','id="game_id" onchange="changeGameid(this,1);"'); ?>
            </label>
            <label id="label2" style="margin-right:10px;">
                <span class="span_inline_block">项目：</span>
                <select name="data_id" id="data_id" onchange="changeDataid(this);">
                    <option value="">请选择</option>
                </select>
            </label>
            <label style="margin-right:10px;">
                <span class="span_inline_block">关键字：</span>
                <input style="width:120px;" type="text" class="input-text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="请输入编码">
            </label>
            <label class="check"><input id="check_team" name="check_team" class="input-check" type="checkbox"<?php echo ($_REQUEST['check_team']=='0') ? '' :'checked="checked"' ;?>>显示参者队</label>
            <button id="search_submit" onclick="submitType='find';" class="btn btn-blue" type="submit">查询</button>
            <?php if($_REQUEST['data_id']) {?>
                <a class="btn btn-blue" style="vertical-align: middle;" href="javascript:;" onclick="clickArrangeAdd('1');">添加赛事阶段</a>
                <a class="btn btn-blue" style="vertical-align: middle;" href="javascript:;" onclick="clickTimeSetting();">赛程时间设置</a>
            <?php }?>
            <a style="display:none;vertical-align: middle;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </form>
    </div><!--box-search end-->
    <?php if($_REQUEST['data_id']>0) {?>
    <div id="code_stage" style="position: fixed;width: 100%;height: auto;padding: 5px 0 5px 0;top: 99px;z-index: 99;background-color: #f2f2f2;">
        <ul class="nav-ul">
            <li class="nav-li all" onclick="clickTname('all',2);" code="all">所有</li>
            <?php
                $arrange = $model->findAll('game_data_id='.$_REQUEST['data_id'].' and length(arrange_tcode)=4 order by arrange_tcode');
                if(!empty($arrange))foreach($arrange as $ar){
            ?>
                <li class="nav-li" onclick="clickTname('<?php echo $ar->arrange_tcode; ?>',2);" code="<?php echo $ar->arrange_tcode; ?>"><?php echo $ar->arrange_tname; ?></li>
            <?php }?>
        </ul>
    </div>
    <?php }?>
    <div class="box-content" style="margin: 0 0;margin-top: 130px;">
        <form id="save_time" name="save_time">
            <div class="box-table">
                <table class="list">
                    <thead>
                        <tr>
                            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                            <th><?php echo $model->getAttributeLabel('arrange_tcode');?></th>
                            <th><?php echo $model->getAttributeLabel('arrange_tname2');?></th>
                            <th><?php echo $model->getAttributeLabel('game_player_id');?></th>
                            <th style="width:6%;"><?php echo $model->getAttributeLabel('describe1');?></th>
                            <th style="width:12%;"><?php echo $model->getAttributeLabel('game_site');?></th>
                            <th style="width:7%;"><?php echo $model->getAttributeLabel('game_time');?></th>
                            <th style="width:7%;"><?php echo $model->getAttributeLabel('star_time');?></th>
                            <th><?php echo $model->getAttributeLabel('upper_code1'); ?></th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $index = 1;
                        $sno = count($arclist);
                        foreach($arclist as $v){
                            $len=strlen(trim($v->arrange_tcode));
                            $sc = '';
                            if($len==4) $sc = substr($v->arrange_tcode,0,4);
                            if($len==5) $sc = substr($v->arrange_tcode,0,4).' '.substr($v->arrange_tcode,0,5);
                            if($len==7 || $len==9) $sc = substr($v->arrange_tcode,0,4).' '.substr($v->arrange_tcode,0,5).' '.substr($v->arrange_tcode,0,7);
                            if($len==7 || $len==5) $gmode = $model->findAll('game_data_id='.$v->game_data_id.' and left(arrange_tcode,'.$len.')="'.$v->arrange_tcode.'" and length(arrange_tcode)=9');
                    ?>
                        <tr class="<?php echo $sc; ?> tr">
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><?php echo $v->arrange_tcode; ?></td>
                            <td><?php echo $v->arrange_tname; ?></td>
                            <td><?php echo ($v->game_player_id==665) ? $v->sign_name : $v->team_name; ?></td>
                            <td>
                                <?php
                                    if(!empty($v->describe)){
                                        if(strstr($v->describe,'vs')==true){
                                            $l = explode('vs',$v->describe);
                                            echo trim($l[0]).' VS '.trim($l[1]);
                                        }
                                    }
                                    else{
                                        if($len==7){
                                            if($v->game_mode==663){
                                                $b = '<br>';
                                                if(!empty($gmode))foreach($gmode as $gm){
                                                    echo $gm->arrange_tname.$b;
                                                }
                                            }
                                        }
                                    }
                                ?>
                            </td>
                            <td>
                                <input type="hidden" id="arr_id_<?php echo $index; ?>" name="arr_id_<?php echo $index; ?>" value="<?php echo $v->id; ?>">
                                <?php
                                    if($len==7){
                                        echo '<input type="text" class="input-text sub" colfield="game_site" colid="'.$index.'" value="'.$v->game_site.'">';
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    $ten = substr($v->star_time,0,10);
                                    if($ten=='0000-00-00'){ $ten = '';}
                                    if($len==7){
                                        echo '<input type="text" class="input-text time sub" colfield="star_time" colid="'.$index.'" value="'.$ten.'" style="width:80%;">';
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    $tan = substr($v->star_time,11,-3);
                                    if($tan=='00:00'){ $tan = '';}
                                    if($len==7){
                                        echo '<input type="text" class="input-text time1 sub star_time_ten'.$index.'" colfield="star_time_ten" colid="'.$index.'" value="'.$tan.'" style="width:80%;">';
                                    }
                                ?>
                            </td>
                            <td style="text-align: left;">
                                <?php
                                    if($v->game_format==985 && $len==7){
                                        if(!empty($gmode))foreach($gmode as $up){
                                            if($up->upper_order>0){
                                                $od = ($up->upper_order==1) ? '胜' : '败';
                                                echo $od.'：'.$up->upper_code.'<br>';
                                            }
                                        }
                                    }
                                    else{
                                        if($v->game_format==988 && $len==5){
                                            if(!empty($gmode))foreach($gmode as $up){
                                                if(!empty($up->upper_code)){
                                                    echo '晋级：'.$up->upper_code.'<br>';
                                                }
                                            }
                                        }
                                    }
                                ?>
                            </td>
                            <td style="text-align:left;position:relative;">
                                <a class="btn" href="javascript:;" onclick="clickLwind('<?php echo $v->id; ?>','<?php echo $v->arrange_tcode; ?>');">编辑</a>
                                <?php
                                    if($len==4){
                                        echo '<a href="javascript:;" class="btn" onclick="group_add(\''.$v->id.'\',\''.$v->arrange_tname.'\');">添加小组</a>&nbsp;';
                                    }
                                    if(($len==5 && $v->game_format!=985) || ($len==7 && $v->game_format==985)){
                                        echo '<a href="javascript:;" class="btn" onclick="group_prom('.$v->id.',\''.$v->arrange_tcode.'\');">晋级方向</a>&nbsp;';
                                    }
                                    echo '<a class="btn delete" href="javascript:;" onclick="we.dele(\''.$v->id.'\', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>&nbsp;';
                                    if($len==4 || $len==5 || ($len==7 && $_REQUEST['check_team'])){
                                        echo '<a href="javascript:;" class="btn dg_'.substr($v->arrange_tcode,0,4).' dg_'.substr($v->arrange_tcode,0,5).' dg_'.substr($v->arrange_tcode,0,7).'" 
                                            attrcode="'.$v->arrange_tcode.'" onclick="clickCode(this,\''.$v->arrange_tcode.'\');" onc="0" style="position:absolute;right:5px;"><i class="fa fa-chevron-up"></i></a>';
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php $index++; } ?>
                    </tbody>
                </table>
            </div><!--box-table end-->
        </form>
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content || gamesign-lt end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

    var se_data_id = '<?php echo $_REQUEST['data_id']; ?>';
    $(function(){
        $('.time').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
        $('.time1').on('click', function(){
            WdatePicker({startDate:'00:00:00',dateFmt:'HH:mm'});
        });
        // 默认显示方式
        $('.nav-ul li:nth-child(1)').addClass('td_bor');
        var type = $('.nav-ul li:nth-child(2)').attr('code');
        var data_id = sessionStorage.getItem('dataid');
        var session_type = sessionStorage.getItem('code_type');
        var this_top = sessionStorage.getItem('this_top');
        var code_stage = $('#code_stage').innerHeight();
        var document_width = $(document).width();
        if(se_data_id<1) sessionStorage.clear();
        if(session_type!='' && session_type!=null && session_type!='null' && session_type!=undefined && data_id=='<?php echo $_REQUEST['data_id']; ?>') type = session_type;
        clickTname(type);
        // this_top = parseInt(this_top);//-223
        $(window).scrollTop(this_top);
        if(code_stage==null || code_stage=='null' || code_stage<1) $('.box-content').css('margin-top','90px');
        if(code_stage>50) $('.box-content').css('margin-top','165px');
        // console.log(code_stage,document_width);
        if(document_width<=1220){
            if(se_data_id>0){
                $('#label2').after('<br>');
            }
            $('#code_stage').css('top','135px');
            if(code_stage>50){
                $('.box-content').css('margin-top','200px');
            } else if(code_stage<50 && code_stage>10){
                $('.box-content').css('margin-top','165px');
            }
        }
    });

    document.addEventListener('visibilitychange',function(){
        var isHidden = document.hidden;
        if(isHidden){
            // console.log('6666');
        } else {
            // console.log('3333');
            sessionStorage.clear();
        }
    });

    // 点击选择阶段
    function clickTname(code,n=1){
        // we.loading('hide');
        var c = $('.'+code);
        $('.nav-li').removeClass('td_bor');
        $('.nav-li').each(function(){
            if($(this).attr('code')==code){
                $(this).addClass('td_bor');
            }
        });
        if(code=='all'){
            $('.tr').show();
            $('.all').addClass('td_bor');
        }
        else{
            $('.tr').hide();
            $('.'+code).show();
        }
        sessionStorage.setItem('code_type',code);
        sessionStorage.setItem('dataid','<?php echo $_REQUEST['data_id']; ?>');
        if(n==2){
            we.loading('show');
            $('#loading').css({'top':'25%','background-size':'3%'});
            $('#arrange_tcode').val(code);
            sessionStorage.removeItem('this_top');
            $('#search_submit').click();
        }
    }

    $('.delete').on('click',function(){
        var m = document.documentElement.scrollTop;
        sessionStorage.setItem('this_top',m);
    })

    function clickArrangeAdd(n=0){
        if(n==1){
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('arrangeAdd', array('game_id'=>$_REQUEST['game_id'],'data_id'=>$_REQUEST['data_id']));?>&ln='+n,
                dataType: 'json',
                success: function(data){
                    // console.log(data);
                }
            });
            setTimeout(function() {
                we.reload();
            }, 500);
        }
    }

    var back = '<?php echo $_REQUEST['back']; ?>';
    changeGameid($('#game_id'));
    function changeGameid(op,n=0){
        var obj = $(op).val();
        var s_html = '<option value>请选择</option>';
        if(obj > 0){
            var pr = '<?php echo $_REQUEST['data_id']; ?>';
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('data_id'); ?>&game_id='+obj,
                dataType: 'json',
                success: function(data) {
                    for(var i=0;i<data.length;i++){
                        s_html += '<option value="'+data[i]['id']+'" '+((data[i]['id']==pr) ? 'selected>' : '>')+data[i]['game_data_name']+'</option>';
                    }
                    $('#data_id').html(s_html);
                    if(n==1){
                        $('#arrange_tcode').val('');
                    }
                }
            });
        }else{
            $('#data_id').html(s_html);
        }
        // 从赛事列表进来的不可编辑
        if(back>0){
            $(op).attr('disabled',true);
        }
    }

    function changeDataid(op){
        $('#arrange_tcode').val('');
    }

    // 查询时去除赛事id的不可编辑，否则后台获取不到数据
    $('#search_submit').on('click',function(){
        $('#game_id').removeAttr('disabled');
    })

    var num = 0;
    function group_html(group_id){
        var Html=
        '<div style="width:100%;">'+
            '<form action="" id="group_form" name="group_form">'+  
                '<table id="group_table" class="box-detail-table showinfo">'+
                    '<tr id="group_name">'+
                        '<td style="width:12%;">赛制</td>'+
                        '<td style="width:12%;">对阵方式</td>'+
                        '<td>组编码 <span>(26个英文字母内)</span></td>'+
                        '<td><span>自定义组名称</span><br><span>(例1：16强、8强、半决赛)</span><br><span>(例2：A组、B组、C组)</span></td>'+
                        '<td class="g_num">参赛人数/队数</td>'+
                        '<td class="is_hidden" style="display:none;">每场总人数/队数</td>'+
                        '<td class="is_hidden" style="display:none;">总场次</td>'+
                        '<td class="is_hidden is_hidden1" style="display:none;">操作</td>'+
                    '</tr>'+
                    '<tr class="group_num col_len">'+
                        '<td class="group_num_gformat_'+num+'"><select id="gformat_'+num+'" name="gformat_'+num+'" onchange="onchangeGamemode(this,'+num+','+group_id+');">'+group_select('gformat',num)+'</select></td>'+
                        '<td class="group_num_game_mode_'+num+'"><select id="game_mode_'+num+'" name="game_mode_'+num+'" onchange="onchangeGamemode(this,'+num+','+group_id+');">'+group_select('game_mode',num)+'</select></td>'+
                        '<td class="group_num_group_code_'+num+'"><input type="text" class="input-text" name="group_code_'+num+'" value=""></td>'+
                        '<td class="group_num_group_name_'+num+'"><input type="text" class="input-text" name="group_name_'+num+'" value=""></td>'+
                        '<td class="g_num"><input type="text" class="input-text" name="group_len_'+num+'" value="" ></td>'+
                        '<td class="is_hidden" style="display:none;"><input type="text" class="input-text" name="group_total_site_'+num+'" value="" ></td>'+
                        '<td class="is_hidden" style="display:none;"><input type="text" class="input-text" name="group_total_peop_'+num+'" value="" ></td>'+
                        '<td class="is_hidden is_hidden1" style="display:none;">'+
                            '<a href="javascript:;" class="btn delCol" onclick="clickDelete(this,'+group_id+',0);">删除</a>&nbsp;'+
                            '<a href="javascript:;" class="btn addCol" onclick="clickAddCol('+group_id+',0);">添加行</a>'+
                        '</td">'+
                    '</tr>'+
                '</table>'+
                '<input type="hidden" name="game_id" id="game_id" value="<?php echo $_REQUEST['game_id']; ?>">'+
                '<input type="hidden" name="data_id" id="data_id" value="<?php echo $_REQUEST['data_id']; ?>" >'+
                '<input type="hidden" name="gr_id" id="gr_id" value="'+group_id+'" >'+
            '</form>'+
        '</div>';
        num++;
        return Html;
    }

    // 监听下拉的事件
    function onchangeGamemode(obj,n,id){
        if($('#gformat_'+n).val()==''){
            $(obj).val('');
            we.msg('minus','先选择赛制');
            return false;
        }
        var obj = $(obj).val();
        var gformat = $('#gformat_'+n).val();
        var game_mode = $('#game_mode_'+n).val();
        if((obj==663 && gformat==985) || (obj==985 && game_mode==663)){
            $('.g_num').hide();
            $('.is_hidden').show();
            $('.delCol').attr('onclick','clickDelete(this,'+id+',0);');
            $('.addCol').attr('onclick','clickAddCol('+id+',0);');
        }
        else{
            if((obj==662 && gformat==988) || (obj==988 && game_mode==662)){
                $('.is_hidden1').show();
                $('.delCol').attr('onclick','clickDelete(this,'+id+',1);');
                $('.addCol').attr('onclick','clickAddCol('+id+',1);');
            }
            else{
                $('.g_num').show();
                $('.is_hidden').hide();
            }
        }
        if(((obj==662 && gformat==985) || (obj==663 && gformat==988)) || ((obj==985 && game_mode==663) || (obj==988 && game_mode==662) || (obj==988 && game_mode==663))){
            $('.group_num').not(':eq(0)').remove();
            onchangeGamemode($('.group_num eq:(0)'),n,id);
        }
    }

    // 删除行
    function clickDelete(op,id,n){
        $(op).parent().parent().remove();

        var len = $('.col_len').length;
        if(len<1){
            clickAddCol(id,n);
        }
    }

    // 添加行
    function clickAddCol(id,n){
        var len = num++;
        var sa = '';
        var g_num = 'display:none;';
        if(n==1){
            sa = 'display:none;';
            g_num = '';
        }
        // console.log('sa='+sa+'g_num='+g_num,n);
        var a_html = 
            '<tr class="group_num col_len">'+
                '<td class="group_num_gformat_'+len+'"><select id="gformat_'+len+'" name="gformat_'+len+'" onchange="onchangeGamemode(this,'+len+','+id+');">'+group_select('gformat',len)+'</select></td>'+
                '<td class="group_num_gformat_'+len+'"><select id="game_mode_'+len+'" name="game_mode_'+len+'" onchange="onchangeGamemode(this,'+len+','+id+');">'+group_select('game_mode',len)+'</select></td>'+
                '<td><input type="text" class="input-text" name="group_code_'+len+'"></td>'+
                '<td><input type="text" class="input-text" name="group_name_'+len+'"></td>'+
                '<td class="g_num" style="'+g_num+'"><input type="text" class="input-text" name="group_len_'+len+'"></td>'+
                '<td class="is_hidden" style="'+sa+'"><input type="text" class="input-text" name="group_total_site_'+len+'" value="" ></td>'+
                '<td class="is_hidden" style="'+sa+'"><input type="text" class="input-text" name="group_total_peop_'+len+'" value="" ></td>'+
                '<td class="is_hidden is_hidden1" style="">'+
                    '<a href="javascript:;" class="btn" onclick="clickDelete(this,'+id+','+n+');">删除</a>&nbsp;'+
                    '<a href="javascript:;" class="btn addCol" onclick="clickAddCol('+id+','+n+');">添加行</a>'+
                '</td">'+
            '</tr>';
            $('#group_table').append(a_html);
    }

    // 下拉选择
    var gformat = <?php echo json_encode(toArray($gformat,$bstr)); ?>;
    var game_mode = <?php echo json_encode(toArray($game_mode,$bstr)); ?>;
    function group_select(m,n){
        n = n-1;
        var gf = $('#gformat_'+n).val();
        var gm = $('#game_mode_'+n).val();
        var ls = (m=='gformat') ? gformat : game_mode;
        var lk = (m=='gformat') ? gf : gm;
        var s_html = '<option value>请选择</option>';
        for(var i=0;i<ls.length;i++){
            s_html += '<option value="'+ls[i]['f_id']+'"';
            if(ls[i]['f_id']==lk){
                s_html += 'selected';
            }
            s_html += '>'+ls[i]['F_NAME']+'</option>';
        }
        return s_html;
    }

    // 添加小组
    function group_add(group_id,gna){
        $.dialog({
            id:'upperporm', lock:true, opacity:0.3,height: '45%',
            title:gna+'添加小组',
            width:'70%', 
            content:group_html(group_id),
            button:[
                {
                    name:'保存',
                    focus:true,
                    callback:function(){
                        var sctop = document.documentElement.scrollTop;
                        group_add_data('<?php echo $this->createUrl('GroupAdd'); ?>','group_form','',0,sctop);
                    },
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

    // 晋级方向
    function group_prom(id,t_code){
        var s_html = 
        '<div style="width:500px;">'+
            '<form id="upper_form" name="upper_form">'+  
                '<table id="upp_len" class="box-detail-table showinfo">'+
                    '<tr>'+
                        '<td style="width:10%;">名次</td>'+
                        '<td style="width:40%;">晋级方向</td>'+
                        '<td style="width:30%;">总名次(总排名)</td>'+
                        '<td style="width:20%;">晋级签号</td>'+
                    '</tr>';
                    $.ajax({
                        type: 'post',
                        url: '<?php echo $this->createUrl('upper_code'); ?>&id='+id+'&code='+t_code,
                        dataType: 'json',
                        success:function(data){
                            var k_html = '';
                            var j = 1;
                            for(var i=0;i<data.length;i++){
                                var tname = (data[i]['arrange_tname']==undefined) ? '' : data[i]['arrange_tname'];
                                var order = (data[i]['upper_order']==0 || data[i]['upper_order']=='') ? j : data[i]['upper_order'];
                                var torder = (data[i]['total_order']==null || data[i]['total_order']=='null') ? '' : data[i]['total_order'];
                                k_html +=
                                '<tr class="upper_code">'+
                                    '<input type="hidden" name="id_'+i+'" value="'+data[i]['id']+'">'+
                                    '<td>'+j+'<input type="hidden" id="upper_no'+i+'" name="upper_no'+i+'" value="'+order+'"></td>'+
                                    '<td><input type="text" class="input-text" id="upp_code'+i+'" name="upp_code'+i+'" oninput="checkTcode(this,'+id+','+i+');" onpropertychange="checkTcode(this,'+id+','+i+');" value="'+data[i]['upper_code']+'"></td>'+
                                    '<td><input type="text" class="input-text" id="total_code'+i+'" name="total_code'+i+'" style="width: 70%;" value="'+torder+'"></td>'+
                                    '<td><input type="hidden" class="input-text" id="arrange_tname_'+i+'" name="arrange_tname_'+i+'" value="'+tname+'"><span id="span_'+i+'">'+tname+'</span></td>'+
                                '</tr>';
                                j++;
                            }
                            $('#upp_len').append(k_html);
                        }
                    });
                s_html += '</table>'+
            '</form>'+
        '</div>';
        $.dialog({
            id:'uppercode',
            lock:true,
            opacity:0.3,
            height: '45%',
            title:'添加'+t_code+'组晋级方向',
            content:s_html,
            button:[
                {
                    name:'保存',
                    focus:true,
                    callback:function(){
                        if($('.upper_code').length<1){
                            we.msg('minus','没有数据');
                            return false;
                        }
                        var sctop = document.documentElement.scrollTop;
                        group_add_data('<?php echo $this->createUrl('game_order'); ?>','upper_form',id,0,sctop);
                    },
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

    // acc=0刷新，否则不刷新
    function group_add_data(action,form_cd,id='',acc=0,m=''){
        var form=$('#'+form_cd).serialize();
        we.loading('show');
        $.ajax({
            type: 'post',
            url: action+'&id='+id,
            data: form,
            dataType: 'json',
            success: function(data){
                //   console.log(data);
                if(data.status==1){
                    we.loading('hide');
                    if(acc==0){
                        we.success(data.msg, data.redirect);
                        if(m!=''){
                            sessionStorage.setItem('this_top',m);
                        }
                    }
                    else{
                        we.msg('check', data.msg);
                        return false;
                    }
                }else{
                    we.loading('hide');
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }

    $('.sub').blur(function(){
        var filed = $(this).attr('colfield');
        var colid = $(this).attr('colid');
        var arrid = $('#arr_id_'+colid).val();
        var star_time_ten = $('.star_time_ten'+colid).val();
        var form = $(this).val();
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('saveSiteTime'); ?>',
            data: {form:form,filed:filed,colid:colid,arrid:arrid,star_time_ten:star_time_ten},
            dataType: 'json',
            success: function(data){
                if(data==1){
                    console.log('成功');
                }
            }
        });
    });

    // 收缩与打开
    function clickCode(op,code){
        var du = ($(op).attr('onc')==0) ? 'down' : 'up';
        var at = ($(op).attr('onc')==0) ? 1 : 0;
        if($(op).attr('onc')==0){
            $('.'+code +':gt(0)').each(function(){
                $(this).hide();
            });
        }
        else{
            $('.'+code +':gt(0)').each(function(){
                $(this).show();
            });
            var code_count = code.slice(0,code.length);
            // console.log(code.length,code_count);
            $('.dg_'+code_count +':gt(0)').each(function(){
                if($(this).attr('onc')==1){
                    $('.'+$(this).attr('attrcode') +':gt(0)').each(function(){
                        $(this).hide();
                    });
                }
            });
        }
        $(op).html('<i class="fa fa-chevron-'+du+'"></i>');
        $(op).attr('onc',at);
    }

    // 修改编码与签号
    function clickLwind(id,code){
        var s_html = 
        '<div style="width:500px;">'+
            '<form id="click_window" name="click_window">'+  
                '<table id="window_'+id+'" class="box-detail-table showinfo">'+
                    '<tr><td style="width:30%;">名次</td><td style="width:70%;">项目信息编辑</td></tr>';
                    $.ajax({
                        type: 'get',
                        url: '<?php echo $this->createUrl('click_window'); ?>&id='+id,
                        dataType: 'json',
                        success:function(data){
                            var k_html =
                            '<tr class="title_win">'+
                                '<td>赛程编码</td>'+
                                '<td><input type="text" class="input-text" id="arrange_tcode" name="arrange_tcode" value="'+data.arrange_tcode+'"></td>'+
                            '</tr>'+
                            '<tr class="title_win">'+
                                '<td>项目/赛段/组/场/签号</td>'+
                                '<td><input type="text" class="input-text" id="arrange_tname" name="arrange_tname" value="'+data.arrange_tname+'"></td>'+
                            '</tr>';
                            $('#window_'+id).append(k_html);
                        }
                    });
                s_html += '</table>'+
            '</form>'+
        '</div>';
        $.dialog({
            id:'signcode',
            lock:true,
            opacity:0.3,
            height: '45%',
            title:code+'组编辑',
            content:s_html,
            button:[
                {
                    name:'保存',
                    focus:true,
                    callback:function(){
                        var sctop = document.documentElement.scrollTop;
                        group_add_data('<?php echo $this->createUrl('save_window'); ?>','click_window',id,0,sctop);
                    },
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

    // 获取晋级方向编码的签号
    function checkTcode(o,id,n){
        var code = $(o).val();
        if(code.length>8){
            $.ajax({
                type: 'get',
                url: '<?php echo $this->createUrl('checkTcode'); ?>&code='+code+'&id='+id,
                dataType: 'json',
                success: function(data){
                    // console.log(data);
                    if(data!=''){
                        $('#arrange_tname_'+n).val(data);
                        $('#span_'+n).html(data);
                    }
                },
                error: function(request){
                    console.log('没有这个签号');
                }
            });
        }
        else{
            $('#arrange_tname_'+n).val('');
            $('#span_'+n).html('');
        }
    }

    function clickTimeSetting(){
        var s_html = 
            '<div style="width:800px;">'+
                '<form action="" id="time_setting" name="time_setting">'+  
                    '<table id="time_setting_table" class="box-detail-table showinfo">'+
                        '<tr id="group_name">'+
                            '<td>阶段编码</td>'+
                            '<td>阶段名称</td>'+
                            '<td>是否显示</td>'+
                            '<td>显示时间</td>'+
                        '</tr>';
                        $.ajax({
                            type: 'post',
                            url: '<?php echo $this->createUrl('get_time',array('game_id'=>$_REQUEST['game_id'],'data_id'=>$_REQUEST['data_id'])); ?>',
                            dataType: 'json',
                            success:function(data){
                                if(data!=''){
                                    var k_html = '';
                                    var s_num = 1;
                                    for(var i=0;i<data.length;i++){
                                        var ofo = (data[i]['if_rele']==649) ? 'on' : 'off';
                                        var time = (data[i]['rele_date_start']==null) ? '' : data[i]['rele_date_start'];
                                        k_html +=
                                        '<tr>'+
                                            '<td>'+data[i]['arrange_tcode']+'</td>'+
                                            '<td>'+data[i]['arrange_tname']+'</td>'+
                                            '<td>'+
                                                '<div class="switch">'+
                                                    '<div class="btn_fath clearfix '+ofo+'" onclick="toogle(this,'+data[i]['id']+')">'+
                                                        '<div class="move" data-state="'+ofo+'"></div>'+
                                                        '<div class="btnSwitch btn1">是</div>'+
                                                        '<div class="btnSwitch btn2 ">否</div>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</td>'+
                                            '<td>'+
                                                '<input type="hidden" class="input-text" name="arr_id_'+s_num+'" value="'+data[i]['id']+'">'+
                                                '<input type="text" class="input-text blur_time" name="rele_date_start_'+s_num+'" value="'+time+'">'+
                                            '</td>'+
                                        '</tr>';
                                        s_num++;
                                        var l_html = '<input type="hidden" class="input-text" id="length" name="length" value="'+data.length+'">';
                                    }
                                    $('#time_setting_table').append(k_html+l_html);
                                }
                            }
                        });
                        s_html += '</table>'+
                '</form>'+
            '</div>';
        $.dialog({
            id:'setting',
            lock:true,
            opacity:0.3,
            height: '45%',
            title:'赛程时间设置',
            content:s_html,
            close:function(){}
        });
    }

    function toogle(th,id) {
        var ele = $(th).children(".move");
        var re = '';
        if (ele.attr("data-state") == "on") {
            ele.animate({
                left: "0"
            }, 300, function() {
                ele.attr("data-state", "off");
            });
            $(th).removeClass("on").addClass("off");
            re = '0';
        }
        else if (ele.attr("data-state") == "off") {
            ele.animate({
                left: '29px'
            }, 300, function() {
                $(this).attr("data-state", "on");
            });
            $(th).removeClass("off").addClass("on");
            re = '1';
        }
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('rele'); ?>&id='+id+'&if_rele='+re,
            dataType: 'json',
            success: function(data){
                console.log('成功');
            }
        })
    }

    $('body').on('blur','.blur_time',function(){
        if(this.value=='' || this.value==undefined){
            console.log('为空');
            return false;
        }
        var form = $('#time_setting').serialize();
        var length = $('#length').val();
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('saveReleTime'); ?>&length='+length,
            data: form,
            dataType: 'json',
            success: function(data){
                if(data==1){
                    console.log('成功');
                }
            }
        });
    });

    $('body').on('click','.blur_time',function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});
    });
</script>