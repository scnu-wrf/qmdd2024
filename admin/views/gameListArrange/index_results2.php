<?php
    check_request('game_id',0);
    check_request('game_data_id',0);
    check_request('matches_val',0);
    check_request('arrange_tcode',0);
    if(!isset($arrange_tcode)) $arrange_tcode = $_REQUEST['arrange_tcode'];
    if(!isset($_REQUEST['back'])) $_REQUEST['back'] = 0;
    $game = GameList::model()->find('id='.$_REQUEST['game_id']);
    $_REQUEST['game_data_id'] = (empty($_REQUEST['game_data_id'])) ? $game_data_id : $_REQUEST['game_data_id'];
    $page_name = 'obj_';
    $proj_data_id = GameListData::model()->find('id='.$_REQUEST['game_data_id']);
    $star_time = (!empty($_REQUEST['star_time'])) ? $_REQUEST['star_time'] : '';
    $end_time = (!empty($_REQUEST['end_time'])) ? $_REQUEST['end_time'] : '';
    $backc = ($_REQUEST['back']>0) ? 'disabled="disabled"' : '';
    $attrmode = '';
    // $url_name = str_replace([__DIR__.'/','.php'],'',__FILE__);
    if(!empty($proj_data_id)){
        if(!empty($proj_data_id->game_mode)){
            $attrmode = $proj_data_id->game_mode;
        }
        $page = ProjectList::model()->find('id='.$proj_data_id->project_id);
        if(!empty($page)){
            $page_name .= $page->CODE;
        }
    }
    $page_name = strtolower($page_name);
    // $page_name = 'obj_bs';
    $filename = $_SERVER['DOCUMENT_ROOT'].'/'.Yii::app()->request->baseUrl.'/admin/views/gameListArrange/'.$page_name.'.php';
    switch($_REQUEST['back']){
        case 1:
            $url = 'gameList/index_list';
            break;
        case 2:
            $url = 'gameList/game_club_search';
            break;
        case 3:
            $url = 'gameList/game_history_search';
            break;
        case 4:
            $url = 'gameList/game_club_history_search';
            break;
        default:
            $url = '';
    }
?>
<style>
    .box-table .list tr th,.box-table .list tr td{ text-align: center; }
    /* .box-search{margin-top: 0;padding-top: 0;border-top: 0;} */
    .aui_content{ height:auto;overflow:auto;padding:5px 5px!important;max-height: 400px!important;min-height:300px!important; }
    .aui_main{ height:auto!important; }
    .list .input-text{ width: 25%;text-align: center; }
    .tr:hover td { background: none!important; }
    .nav-ul li{ display:inline-block;width:8%;padding:5px;text-align:center;background-color:#5b8d98;color:white;cursor:pointer;margin-top:5px; }
    .td_bor{ border-bottom: solid 2px #d6841e; }
    .box-detail-tab li { width: 120px; }
    .list .input-text { width: 50%; }
    .gamesign-group a:nth-last-child(1){ margin-bottom:100px; }
    .table-title:hover td { background: #efefef!important; }
</style>
<div class="box" style="margin: 0px 10px 10px 0;">
    <div class="gamesign c">
        <div class="box-title c" style="width: 99%;position: fixed;background-color: #F2F2F2;z-index: 99;">
            <h1>当前界面：赛事/排名 》 赛事成绩 》 <?php echo (!empty($game)) ? $game->game_title.' /' : ''; ?>成绩录入</h1>
            <span style="float:right;margin-right:15px;">
                <?php if($_REQUEST['back']>0) {?>
                    <a class="btn" href="<?php echo $this->createUrl($url); ?>">返回上一层</a>
                <?php }?>
                <a class="btn" href="javascript:;" onclick="we.reload();" style="vertical-align: bottom;margin-left:20px;"><i class="fa fa-refresh"></i>刷新</a>
            </span>
        </div><!--box-title end-->
        <div class="box-search" style="margin-top: 43px;width: 99%;z-index: 99;position: fixed;">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="submitType" id="submitType" value="">
                <input type="hidden" name="game_data_id" id="game_data_id" value="<?php echo $_REQUEST['game_data_id']; ?>">
                <input type="hidden" name="back" value="<?php echo $_REQUEST['back']; ?>">
                <input type="hidden" name="arrange_tcode" id="arrange_tcode" value="<?php echo $arrange_tcode; ?>">
                <label style="margin-right:10px;">
                    <span>赛事：</span>
                    <?php echo downList($game_id,'id','game_title','game_id','id="game_id" onchange="changeGameid(this);"'.$backc); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>比赛时间：</span>
                    <input style="width:150px;" type="text" class="input-text time" id="star_time" name="star_time" value="<?php echo $star_time; ?>">
                    <span>-</span>
                    <input style="width:150px;" type="text" class="input-text time" id="end_time" name="end_time" value="<?php echo $end_time; ?>">
                </label>
                <button id="search_submit" class="btn btn-blue" type="submit">查询</button>
                <span style="float: right;width: auto;margin-right: 10px;">
                    <a href="javascript:;" class="btn btn-blue" onclick="checkval('.check-item input:checked',1);">确认成绩</a>
                    <a href="javascript:;" class="btn" onclick="checkval('.check-item input:checked',0);">取消确认</a>
                </span>
            </form>
        </div><!--box-search end-->
        <?php if($_REQUEST['game_id']!=0) { ?>
            <div class="gamesign-rt game_list_arrange" style="background-color:#e0e0e0;top: 105px;">
                <div class="gamesign-group">
                	<span class="gamesign-title">竞赛项目</span>
                    <!-- <a <?php //if($data_id==0){?> class="current"<?php //}?> href="<?php //echo $this->createUrl('index_results2', array('game_id'=>$_REQUEST['game_id']));?>">全部</a> -->
                    <?php foreach($game_data1 as $v){ ?>
                        <a <?php if($game_data_id==$v->id){?> class="current"<?php }?> href="<?php echo $this->createUrl('index_results2', array('game_id'=>$v->game_id,'game_data_id'=>$v->id,'back'=>$_REQUEST['back'],'star_time'=>$star_time,'end_time'=>$end_time));?>"><?php echo $v->game_data_name;?></a>
                    <?php }?>
                </div>
            </div><!--gamesign-rt end-->
        <?php } ?>
        <div class="<?php echo ($_REQUEST['game_id']!=0) ? 'gamesign-lt' : 'box-content'; ?>" style="border:none;padding:0 0;margin: <?php echo (!empty($_REQUEST['game_data_id'])) ? '99px' : 0; ?> 0 0 0;">
            <?php if($_REQUEST['game_id']>0) {?>
                <div id="code_stage" style="position: fixed;width: 83%;background-color: #f2f2f2;z-index: 99;padding: 2px 0 7px 0;">
                    <ul class="nav-ul">
                        <?php
                            $arrange = $model->findAll('game_data_id='.$_REQUEST['game_data_id'].' and length(arrange_tcode)=4 order by arrange_tcode');
                            if(!empty($arrange))foreach($arrange as $ar){
                        ?>
                            <li class="nav-li" onclick="clickTname('<?php echo $ar->arrange_tcode; ?>',2);" code="<?php echo $ar->arrange_tcode; ?>"><?php echo $ar->arrange_tname; ?></li>
                        <?php }?>
                    </ul>
                </div>
                <div id="title_top" class="box-detail-tab mt15" style="position: fixed;width: 83%;top: 128px;z-index: 99;">
                    <ul class="c">
                        <?php if(file_exists($filename)){ ?>
                            <li><a href="<?php echo $this->createUrl('index_results1',array('game_id'=>$_REQUEST['game_id'],'game_data_id'=>$_REQUEST['game_data_id'],'matches_val'=>$matches_val,'back'=>$_REQUEST['back'],'star_time'=>$star_time,'end_time'=>$end_time,'arrange_tcode'=>$_REQUEST['arrange_tcode'])) ?>">成绩录入</a></li>
                        <?php }?>
                        <li class="current"><a href="<?php echo Yii::app()->request->url; ?>">成绩确认</a></li>
                    </ul>
                </div>
            <?php }?>
            <form id="save_results1" name="save_results1" style="position: relative;top: 95px;">
                <div class="box-table" style="margin: 0;">
                    <table class="list">
                        <?php
                            $this_site = $model->find('game_data_id='.$_REQUEST['game_data_id'].' and left(arrange_tcode,4)="'.$arrange_tcode.'" and length(arrange_tcode)=4');
                        ?>
                        <thead>
                            <tr id="thead_tr1">
                                <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                                <th style="width:3%;">序号</th>
                                <th style="width:9%;"><?php echo $model->getAttributeLabel('game_time'); ?></th>
                                <th><?php echo $model->getAttributeLabel('group'); ?></th>
                                <th><?php echo $model->getAttributeLabel('matches'); ?></th>
                                <th><?php echo $model->getAttributeLabel('arrange_tname1'); ?></th>
                                <th><?php echo $model->getAttributeLabel('game_player_id'); ?></th>
                                <?php //if(!empty($proj_data_id))if($proj_data_id->project_id==674 || $proj_data_id->project_id==809) { if($proj_data_id->project_id==674){?>
                                <th style="width:5%;"><?php echo $model->getAttributeLabel('single_score'); ?></th>
                                <?php //}?>
                                <th style="width:5%;"><?php echo $model->getAttributeLabel('bureau_score'); ?></th>
                                <th style="width:5%;"><?php echo $model->getAttributeLabel('winning_bureau'); ?></th>
                                <?php //}?>
                                <?php if(!empty($this_site) && $this_site->game_format==988) {?>
                                    <th style="width:5%;"><?php echo $model->getAttributeLabel('game_score'); ?></th>
                                <!-- <th style="width:5%;"><?php //echo $model->getAttributeLabel('game_order'); ?></th> -->
                                <?php }?>
                                <th style="width:5%;"><?php echo $model->getAttributeLabel('is_promotion'); ?></th>
                                <th style="width:5%;"><?php echo $model->getAttributeLabel('gf_game_score'); ?></th>
                                <th style="width:5%;"><?php echo $model->getAttributeLabel('gf_votes_score'); ?></th>
                                <th style="width:5%;">成绩确认</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $index = 1; $lnum = count($arclist); foreach($arclist as $v) {?>
                                <?php
                                    $count = strlen($v->arrange_tcode);
                                    $player = ($v->game_player_id==665) ? '个人' : '团队';
                                    $day = substr($v->star_time,0,10);
                                    $tcode = substr($v->arrange_tcode,0,4);
                                    $arrange = $model->find('game_data_id='.$v->game_data_id.' and arrange_tcode="'.substr($v->arrange_tcode,0,5).'"');
                                    $arrange1 = $model->findAll('game_data_id='.$v->game_data_id.' and left(arrange_tcode,7)="'.$v->arrange_tcode.'" and length(arrange_tcode)=9 order by arrange_tcode');
                                    $arrange2 = $model->findAll('game_data_id='.$v->game_data_id.' and left(arrange_tcode,5)="'.substr($v->arrange_tcode,0,5).'" and length(arrange_tcode)=9');
                                    $len = count($arrange1);
                                    $is_vict = 0;
                                    if(!empty($arrange2))foreach($arrange2 as $ag1){
                                        if($ag1->upper_order_user>0) $is_vict = $is_vict+1;
                                    }
                                    // echo $is_vict;
                                    $btn_blue = ($is_vict>0) ? '' : 'btn-blue';
                                    // echo $arrange1[0]->id;
                                    if($arrange->game_format==988){
                                ?>
                                <tr class="table-title arr_group group_code_<?php echo $arrange->arrange_tcode; ?>" style="display:none;">
                                    <td colspan="11" style="text-align: left;font-weight:700;">
                                        <input class="input-check" id="check_<?php echo $arrange->arrange_tcode; ?>" type="checkbox" onclick="clickGroupSelect('<?php echo $arrange->arrange_tcode; ?>')">
                                        <label for="check_<?php echo $arrange->arrange_tcode; ?>"><?php echo $arrange->arrange_tname; ?></label>
                                    </td>
                                    <td>
                                        <input type="button" class="btn <?php echo $btn_blue; ?> score_<?php echo $arrange->id; ?>" onclick="clickScore('<?php echo $arrange->id; ?>','<?php echo $arrange->arrange_tcode; ?>');" value="小组成绩">
                                    </td>
                                </tr>
                                <?php } if($count==7) {?>
                                    <tr class="<?php echo $tcode; ?> tr">
                                        <input type="hidden" id="id_<?php echo $index; ?>" name="id_<?php echo $index; ?>" value="<?php echo $v->id; ?>">
                                        <td rowspan="<?php echo $len+1; ?>" style="text-align: center;" class="check check-item">
                                            <input class="input-check g_<?php echo $arrange->arrange_tcode; ?>" type="checkbox" value="<?php echo $v->id; ?>" attrval="<?php echo $v->order_confirm; ?>" attrindex="<?php echo $index; ?>">
                                        </td>
                                        <td rowspan="<?php echo $len+1; ?>">
                                            <span class="num num-1 all_num"></span>
                                            <span class="num num-1 chi_num"><?php echo $index; ?></span>
                                        </td>
                                        <td rowspan="<?php echo $len+1; ?>"><?php echo $day; ?></td>
                                        <td rowspan="<?php echo $len+1; ?>" class="group_code" attrname="<?php echo $arrange->arrange_tcode; ?>"><?php echo $arrange->arrange_tname; ?></td>
                                        <td rowspan="<?php echo $len+1; ?>"><?php echo $v->arrange_tname; ?></td>
                                    </tr>
                                <?php }?>
                                <?php $num = 1;$n = 0; if(!empty($arrange1))foreach($arrange1 as $a1) {?>
                                    <?php
                                        $t_name = ($a1->game_player_id==665) ? $a1->sign_name : $a1->team_name;
                                        $down = BaseCode::model()->getCode(1005);
                                    ?>
                                    <tr class="<?php echo $tcode; ?> tr">
                                        <input type="hidden" id="id_<?php echo $index.'_'.$num; ?>" value="<?php echo $a1->id; ?>">
                                        <td><?php echo $a1->arrange_tname; ?></td>
                                        <td><?php echo (empty($t_name)) ? $a1->f_sname : $t_name; ?></td>
                                        <?php //if(!empty($proj_data_id))if($proj_data_id->project_id==674 || $proj_data_id->project_id==809) { if($proj_data_id->project_id==674){?>
                                        <td><input type="text" class="input-text text_style" <?php if($a1->order_confirm==1) echo 'disabled'; ?> attrname="single_score" attrnum="<?php echo $index.'_'.$num; ?>" value="<?php echo $a1->single_score; ?>"></td>
                                        <?php //}?>
                                        <td><input type="text" class="input-text text_style" <?php if($a1->order_confirm==1) echo 'disabled'; ?> attrname="bureau_score" attrnum="<?php echo $index.'_'.$num; ?>" value="<?php echo $a1->bureau_score; ?>"></td>
                                        <td><input type="text" class="input-text text_style" <?php if($a1->order_confirm==1) echo 'disabled'; ?> attrname="winning_bureau" attrnum="<?php echo $index.'_'.$num; ?>" value="<?php echo $a1->winning_bureau; ?>"></td>
                                        <?php //}?>
                                        <?php if(!empty($this_site) && $this_site->game_format==988) {?>
                                            <td><input type="text" class="input-text" attrname="game_score" attrnum="<?php echo $index.'_'.$num; ?>" value="<?php echo $a1->game_score; ?>"></td>
                                        <!-- <td><input type="text" class="input-text" attrname="game_order" attrnum="<?php //echo $index.'_'.$num; ?>" value="<?php //echo $a1->game_order; ?>"></td> -->
                                        <?php }?>
                                        <td>
                                            <select id="is_promotion_<?php echo $index.'_'.$num; ?>" name="is_promotion_<?php echo $index.'_'.$num; ?>" attrname="is_promotion" attrmode="<?php echo $attrmode; ?>" attrnum="<?php echo $index.'_'.$num; ?>" <?php if($a1->order_confirm==1) echo 'disabled'; ?>>
                                                <option value="">请选择</option>
                                                <?php foreach($down as $dw){?>
                                                    <option value="<?php echo $dw->f_id; ?>" <?php if($a1->is_promotion==$dw->f_id) echo 'selected'; ?>><?php echo $dw->F_NAME; ?></option>
                                                <?php }?>
                                            </select>
                                        </td>
                                        <td>
                                            <input 
                                                type="hidden" class="input-text" 
                                                id="gf_game_score_<?php echo $index.'_'.$num; ?>" 
                                                attrname="gf_game_score" 
                                                attrnum="<?php echo $index.'_'.$num; ?>" 
                                                value="<?php echo $a1->gf_game_score; ?>">
                                            <span id="gfscore_<?php echo $index.'_'.$num; ?>"><?php echo $a1->gf_game_score; ?></span>
                                        </td>
                                        <td>
                                            <input 
                                                type="hidden" class="input-text" 
                                                id="gf_votes_score_<?php echo $index.'_'.$num; ?>" 
                                                attrname="gf_votes_score" 
                                                attrnum="<?php echo $index.'_'.$num; ?>" 
                                                value="<?php echo $a1->gf_votes_score; ?>">
                                            <span id="gfvotes_<?php echo $index.'_'.$num; ?>"><?php echo $a1->gf_votes_score; ?></span>
                                        </td>
                                        <?php if($n==0) {?>
                                            <td rowspan="2">
                                                <?php
                                                    $ck = ($v->order_confirm==0) ? 'clickOrderConfirm('.$v->id.',1,'.$index.')' : 'clickOrderConfirm('.$v->id.',0)';
                                                    $c = ($v->order_confirm==0) ? '确认成绩' : '取消确认';
                                                    $bl = ($v->order_confirm==0) ? 'btn-blue' : '';
                                                    echo '<a href="javascript:;" class="btn '.$bl.'" onclick="'.$ck.'">'.$c.'</a>';
                                                ?>
                                            </td>
                                        <?php }?>
                                    </tr>
                                <?php $num++;$n++; }?>
                            <?php $index++; }?>
                        </tbody>
                    </table>
                </div><!--box-table end-->
                <div class="box-page c"><?php $this->page($pages); ?></div>
            </form>
        </div><!--box-content || gamesign-lt end-->
    </div>
</div><!--box end-->
<script>
    // var file_path = '<?php //echo $url_name; ?>';
    var game_data_id = '<?php echo $_REQUEST['game_data_id']; ?>';
    $(function(){
        $('.time').on('click',function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
        // 默认显示方式
        var form_width = $('#save_results1').width();
        $('#code_stage').css('width',form_width+'px');
        $('#title_top').css('width',form_width+'px');
        $('.nav-ul li:nth-child(1)').addClass('td_bor');
        var type = $('.nav-ul li:nth-child(1)').attr('code');
        if(type==undefined || type=='undefined') {sessionStorage.clear();}
        var data_id = sessionStorage.getItem('dataid');
        // var set_file_path = sessionStorage.getItem('set_file_path');
        var session_type = sessionStorage.getItem('code_type');
        // console.log(type,session_type);
        var this_top = sessionStorage.getItem('this_top');
        var code_stage = $('#code_stage').innerHeight();
        var document_width = $(document).width();
        if(session_type!='' && session_type!=null && session_type!='null' && session_type!=undefined && session_type!='undefined' && data_id==game_data_id) type = session_type;// && set_file_path==file_path
        clickTname(type);
        // console.log(type,code_stage,session_type);
        $(window).scrollTop(this_top);
        if(code_stage<10){
            $('#title_top').css('top','90px');
            $('#save_results1').css('top','55px');
        }
        if(code_stage>50){
            $('#title_top').css('top','160px');
            $('#save_results1').css('top','125px');
        }
        $('.group_code').each(function(){
            show_attrname($(this).attr('attrname'));
            return true;
        })

        $('.text_style').each(function(){
            if($(this).val()>0){
                $(this).css('font-weight','700');
            }
        });

        // 按照顺序显示,已显示过的组按钮不再显示
        var group_end_session = sessionStorage.getItem('group_end');
        var group_first = $.trim($('.arr_group').first().text());
        var group_end = $.trim($('.arr_group').last().text());
        if(group_end_session==group_first && group_first!=group_end){
            $('.arr_group').first().remove();
        }
        else{
            sessionStorage.setItem('group_end',group_end);
        }
        
    });

    $('.text_style').on('blur',function(){
        if($(this).val()>0){
            $(this).css('font-weight','700');
        }
        else{
            $(this).css('font-weight','');
        }
    })

    // 显示小组成绩按钮   php不好控制，由js控制
    function show_attrname(code){
        var thead_tr1 = $('#thead_tr1 th').length;
        var tn = thead_tr1 - 1;
        $('.group_code_'+code).not(':eq(0)').remove();
        $('.group_code_'+code+' :eq(0)').attr('colspan',tn);
        $('.group_code_'+code).show();//eq(0).
    }

    // 点击选择阶段
    function clickTname(code,n=1){
        var c = $('.'+code);
        var attr_code = c.attr('code');
        $('.nav-li').removeClass('td_bor');
        $('.nav-li').each(function(){
            if($(this).attr('code')==code){
                $(this).addClass('td_bor');
            }
        });
        if(code=='all'){
            $('.chi_num').hide();
            $('.tr,.all_num').show();
            $('.all').addClass('td_bor');
        }
        else{
            var num1 = 0;
            $('.tr,.all_num').hide();
            $('.'+code+' .chi_num').each(function(){
                num1++;
                $(this).html(num1);
            });
            $('.chi_num').show();
            $('.'+code).show();
        }
        sessionStorage.setItem('code_type',code);
        sessionStorage.setItem('dataid',game_data_id);
        if(n==2){
            we.loading('show');
            $('#loading').css({'top':'25%','background-size':'3%'});
            $('#arrange_tcode').val(code);
            // sessionStorage.setItem('set_file_path',file_path);
            $('#search_submit').click();
        }
    }

    // document.addEventListener('visibilitychange',function(){
    //     var isHidden = document.hidden;
    //     if(isHidden){
    //         // console.log('6666');
    //     } else {
    //         // console.log('3333');
    //         sessionStorage.clear();
    //     }
    // });

    function changeGameid(op){
        $('#game_data_id').val('');
        $('#arrange_tcode').val('');
        sessionStorage.clear();
    }

    $('#save_results1 .input-text,#save_results1 select').on('blur',function(){
        var attrname = $(this).attr('attrname');
        var attrnum = $(this).attr('attrnum');
        var attrmode = $(this).attr('attrmode');
        var this_val = $(this).val();
        var id = $('#id_'+attrnum).val();
        var post_data = {id:id,attrname:attrname,this_val:this_val,master_id:$('#id_'+attrnum.slice(0,1)).val()};
        if(attrname=='is_promotion'){
            var gf_game_score = $('#gf_game_score_'+attrnum);
            var gf_votes_score = $('#gf_votes_score_'+attrnum);
            if(attrmode==662 && $(this).val()==1006){
                gf_game_score.val(3);
                $('#gfscore_'+attrnum).html(3);
            }
            else if(attrmode==662 && $(this).val()==1007){
                gf_game_score.val(2);
                $('#gfscore_'+attrnum).html(2);
            }
            else if(attrmode==662 && $(this).val()==1008){
                gf_game_score.val(1);
                $('#gfscore_'+attrnum).html(1);
            }
            else{
                gf_game_score.val(0);
            }
            post_data = {
                id:id,
                attrname:attrname,
                this_val:this_val,
                gf_game_score:gf_game_score.val(),
                gf_votes_score:gf_votes_score.val(),
                master_id:$('#id_'+attrnum.slice(0,1)).val()
            };
        }
        post_json(post_data,'<?php echo $this->createUrl('save_results1'); ?>',0);
    })

    // data：需要传入的数组，
    // n=1：刷新，
    // op：当前点击的按钮距离页面顶部的距离，刷新后回到点击时的位置
    function post_json(data,url,n=0,op=''){
        if(n==1) we.loading('show');
        $.ajax({
            type: 'post',
            url: url,
            data: data,
            dataType: 'json',
            success: function(data){
                if(n==1 && data.status==1){
                    if(op!=''){
                        sessionStorage.setItem('this_top',op);
                    }
                    we.success(data.msg, data.redirect);
                }
                else if(data.status==0){
                    we.success(data.msg, data.redirect);
                }
            },
            error: function(request){
                console.log('错误');
            }
        });
    }

    // 成绩确认 && 取消确认
    function clickOrderConfirm(id,n,m=0){
        var y = true;
        if(m>0){
            y = search_is_promotion(m);
        }
        if(y){
            var mtop = document.documentElement.scrollTop;
            post_json('','<?php echo $this->createUrl('orderConfirm',array('confirm'=>'order_confirm')); ?>&id='+id+'&num='+n,1,mtop);
        }
    }

    // 判断是否平局
    function search_is_promotion(m){
        var isp1 = $('#is_promotion_'+m+'_1').val();
        var isp2 = $('#is_promotion_'+m+'_2').val();
        if(isp1==isp2){
            we.msg('minus','出现平局');
            return false;
        }
        else{
            return true;
        }
    }

    $('#j-checkall').on('click', function() {
        var $this;
        var $temp1 = $('.check-item .input-check');
        var $temp2 = $('.box-table .list tbody tr');
        $this = $(this);
        if ($this.is(':checked')) {
            $temp1.each(function() {
                this.checked = true;
            });
            $temp2.addClass('selected');
        } else {
            $temp1.each(function() {
                this.checked = false;
            });
            $temp2.removeClass('selected');
        }
    });

    var $index = '<?php echo $index; ?>';
    function checkval(op,n){
        var str = '';
        var jk = true;
        var jn = true;
        $(op).each(function() {
            if(n==1){
                jn = search_is_promotion($(this).attr('attrindex'));
            }
            if($(this).attr('attrval')==1 && n==1){
                jk = false;
            }
            str += $(this).val() + ',';
        });
        if(jk==false){
            we.msg('minus','不可重复确认');
            return false;
        }
        if(jn==false){
            return false;
        }
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        else{
            we.msg('minus','请选择参赛队伍/选手');
            return false;
        }
        clickOrderConfirm(str,n);
    };

    // 查询时去除赛事id的不可编辑，否则后台获取不到数据
    $('#search_submit').on('click',function(){
        $('#game_id').removeAttr('disabled');
    })

    function clickScore(id,code){
        $.dialog({
            id:'score',
            lock:true,
            opacity:0.3,
            height: '60%',
            width: '40%',
            title:code+'组成绩',
            content:get_group_score(id),
            button:[
                {
                    name:'取消',
                    callback:function(){
                        return true;
                    }
                },
                {
                    name:'保存',
                    focus:true,
                    callback:function(){
                        var sctop = document.documentElement.scrollTop;
                        var form = $('#click_window').serialize();
                        post_json(form,'<?php echo $this->createUrl('save_data_score'); ?>',1,sctop);
                    },
                }
            ]
        });
    }

    function get_group_score(id){
        var html = 
        '<div /*style="max-width:600px;"*/>'+
            '<form id="click_window" name="click_window">'+  
                '<table id="window_'+id+'" class="box-detail-table">'+
                    '<input type="hidden" id="datalen" name="datalen" value="">'+
                    '<input type="hidden" id="check_box" name="check_box" value="0">'+
                    '<tr class="title_win">'+
                        '<td>名字</td>'+
                        '<td>胜场</td>'+
                        '<td>败场</td>'+
                        '<td>积分</td>'+
                        '<td>名次</td>'+
                    '</tr>';
                    get_html_tr(id);
                html += '</table>'+
            '</form>'+
        '</div>';
        return html;
    }

    function get_html_tr(id){
        $.ajax({
            type: 'get',
            url: '<?php echo $this->createUrl('get_data_score'); ?>&id='+id,
            dataType: 'json',
            success:function(data){
                // console.log(data);
                var k_html = '';
                if(data!=''){
                    var k = 1;
                    for(var i=0;i<data[0].length;i++){
                        var order = (data[0][i]['upper_order_user']==0 || data[0][i]['upper_order_user']=='' || data[0][i]['upper_order_user']==undefined) ? k : data[0][i]['upper_order_user'];
                        k_html += 
                        '<tr class="title_win">'+
                            '<input type="hidden" name="id_'+i+'" value="'+data[0][i]['id']+'">'+
                            '<td>'+data[0][i]['name']+'</td>'+
                            '<td>'+data[0][i]['vict_num']+'</td>'+
                            '<td>'+data[0][i]['defe_num']+'</td>'+
                            '<td><input type="text" class="input-text" name="group_score_'+i+'" value="'+data[0][i]['group_score']+'"></td>'+
                            '<td><input type="text" class="input-text" name="upper_order_user_'+i+'" value="'+order+'"></td>'+
                        '</tr>';
                        k++;
                    }
                    $('#datalen').val(data[0].length);
                }
                $('#window_'+id).append(k_html);
                var btn_txt = (data[1]==1) ? '取消晋级' : '确认晋级';
                var btn_cls = (data[1]==1) ? '' : 'aui_state_highlight';
                var btn_val = (data[1]==1) ? 0 : 1;
                // var checka = (data[1]==1) ? 'checked="checked"' : '';
                // var append_html = '<input type="checkbox" id="check_click" '+checka+' style="vertical-align: middle;"><label for="check_click">积分确认并晋级</label>';
                var append_html = '<button type="button" class="btn '+btn_cls+'" onclick="clickJinji('+btn_val+');" style="float: left;">'+btn_txt+'</button>';
                $('.aui_buttons').prepend(append_html);
                $('#check_box').val(data[1]);
            }
        });
    }

    function clickJinji(n){
        $('#check_box').val(n);
        var sctop = document.documentElement.scrollTop;
        var form = $('#click_window').serialize();
        post_json(form,'<?php echo $this->createUrl('save_data_score'); ?>',1,sctop);
    }

    // 小组选中
    function clickGroupSelect(code){
        var each_code = $('.check-item .g_'+code);
        each_code.each(function(){
            var cd = (this.checked==true) ? false : true;
            this.checked = cd;
        })
    }

    // $('body').on('click','#check_click',function(){
    //     var n = ($(this).is(':checked')==true) ? 1 : 0;
    //     $('#check_box').val(n);
    // })
</script>