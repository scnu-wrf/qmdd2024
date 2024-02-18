<?php
    check_request('game_id',0);
    check_request('game_data_id',0);
    check_request('arrange_tcode',0);
    if(!isset($_REQUEST['back'])) $_REQUEST['back'] = 0;
    $_REQUEST['game_data_id'] = (empty($_REQUEST['game_data_id'])) ? $data_id : $_REQUEST['game_data_id'];
    $game = GameList::model()->find('id='.$_REQUEST['game_id']);
    $backc = ($_REQUEST['back']>0) ? 'disabled="disabled"' : '';
    // $url_name = str_replace([__DIR__.'/','.php'],'',__FILE__);
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
    .aui_content{ height:auto;overflow:auto;padding:5px 5px!important; }
    /* .aui_main{ height:auto!important; } */
    .cld{ background-color: #f8f8f8;display: none; }
    .list .input-text{ width: 25%;text-align: center; }
    /* .input-check{ vertical-align: -webkit-baseline-middle;vertical-align: -moz-middle-with-baseline; } */
    .list tr:hover td { background: none!important; }
    .nav-ul li{ display:inline-block;min-width:8%;max-width:10%;padding:5px;text-align:center;background-color:#5b8d98;color:white;cursor:pointer;margin-top:5px; }
    .td_bor{ border-bottom: solid 2px #d6841e; }
    .box-detail-tab li { width: 120px; }
    .gamesign-group a:nth-last-child(1){ margin-bottom:100px; }
    /* .game_list_arrange { position: absolute; } */
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
                <input type="hidden" name="matches_val" id="matches_val" value="<?php echo $matches_val; ?>">
                <input type="hidden" name="game_data_id" id="game_data_id" value="<?php echo $_REQUEST['game_data_id']; ?>">
                <input type="hidden" name="back" value="<?php echo $_REQUEST['back']; ?>">
                <input type="hidden" name="arrange_tcode" id="arrange_tcode" value="<?php echo $_REQUEST['arrange_tcode']; ?>">
                <label style="margin-right:10px;">
                    <span>赛事：</span>
                    <?php echo downList($game_id,'id','game_title','game_id','id="game_id" onchange="changeGameid(this);"'.$backc); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>比赛时间：</span>
                    <input style="width:150px;" type="text" class="input-text" id="star_time" name="star_time" value="<?php echo $star_time; ?>">
                    <span>-</span>
                    <input style="width:150px;" type="text" class="input-text" id="end_time" name="end_time" value="<?php echo $end_time; ?>">
                </label>
                <span class="check">
                    <input type="checkbox" id="matches_dis" onclick="clickMatches(this);" class="input-check" <?php if($matches_val==1) echo 'checked="checked"'; ?>>
                    <label for="matches_dis">显示结束的场次</label>
                </span>
                <button id="search_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <?php if($_REQUEST['game_id']!=0) { ?>
            <div class="gamesign-rt game_list_arrange" style="background-color:#e0e0e0;top: 105px;">
                <div class="gamesign-group">
                	<span class="gamesign-title">竞赛项目</span>
                    <!-- <a <?php //if($data_id==0){?> class="current"<?php //}?> href="<?php //echo $this->createUrl('gameListArrange/index_results1', array('game_id'=>$_REQUEST['game_id']));?>">全部</a> -->
                    <?php foreach($game_data1 as $v){ ?>
                        <a <?php if($data_id==$v->id){?> class="current"<?php }?> href="<?php echo $this->createUrl('gameListArrange/index_results1', array('game_id'=>$v->game_id,'game_data_id'=>$v->id,'matches_val'=>$matches_val,'back'=>$_REQUEST['back'],'star_time'=>$star_time,'end_time'=>$end_time));?>"><?php echo $v->game_data_name;?></a>
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
                            <li class="current"><a href="<?php echo Yii::app()->request->url; ?>">成绩录入</a></li>
                        <?php }?>
                        <li><a href="<?php echo $this->createUrl('index_results2',array('game_id'=>$_REQUEST['game_id'],'game_data_id'=>$_REQUEST['game_data_id'],'matches_val'=>$matches_val,'back'=>$_REQUEST['back'],'star_time'=>$star_time,'end_time'=>$end_time,'arrange_tcode'=>$_REQUEST['arrange_tcode'])); ?>">成绩确认</a></li>
                    </ul>
                </div>
            <?php }?>
            <form id="save_results" name="save_results" style="position: relative;top: 95px;">
                <div class="box-table" style="margin: 0;">
                    <table class="list">
                        <thead>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('game_time'); ?></th>
                            <th><?php echo $model->getAttributeLabel('group'); ?></th>
                            <th><?php echo $model->getAttributeLabel('matches'); ?></th>
                            <th><?php echo $model->getAttributeLabel('arrange_tname'); ?></th>
                            <th><?php echo $model->getAttributeLabel('game_site'); ?></th>
                            <th><?php echo $model->getAttributeLabel('game_ready_time'); ?></th>
                            <th><?php echo $model->getAttributeLabel('game_over'); ?></th>
                            <th><?php echo $model->getAttributeLabel('if_votes'); ?></th>
                            <th>操作</th>
                        </thead>
                        <tbody>
                            <?php $index = 1; foreach($arclist as $v) {?>
                                <?php $arrange = $model->find('game_data_id='.$v->game_data_id.' and arrange_tcode="'.substr($v->arrange_tcode,0,5).'"'); ?>
                                <tr class="<?php echo substr($v->arrange_tcode,0,4); ?> tr">
                                    <td>
                                        <span class="num num-1 all_num"></span>
                                        <span class="num num-1 chi_num"><?php echo $index; ?></span>
                                    </td>
                                    <td><?php echo substr($v->star_time,0,10); ?></td>
                                    <td><?php echo $arrange->arrange_tname; ?></td>
                                    <td><?php echo $v->arrange_tname; ?></td>
                                    <td>
                                        <?php
                                            $name = ($v->game_player_id==665) ? '(sign_id>-1 or sign_id="" or sign_id is null)' : '(team_id>-1 or team_id="" or team_id is null)';
                                            $gmode = $model->findAll('game_data_id='.$v->game_data_id.' and left(arrange_tcode,7)="'.$v->arrange_tcode.'" and length(arrange_tcode)=9 and '.$name);
                                            $xname = ($v->game_player_id==665) ? 'sign_name' : 'team_name';
                                            if(!empty($gmode)){
                                                $b = ' VS ';
                                                $str = '';
                                                foreach($gmode as $gm){
                                                    $fname = (empty($gm->$xname)) ? 'f_sname' : $xname;
                                                    $tname = (empty($gm->$fname)) ? 'arrange_tname' : $fname;
                                                    // if($v->game_player_id==665){
                                                    //     $str .= $tname.$b;
                                                    // }
                                                    // else{  // if($v->game_player_id==666)
                                                        $str .= $gm->$tname.$b;
                                                    // }
                                                }
                                                echo rtrim($str, $b);
                                            }
                                            else{
                                                echo $v->describe;
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $v->game_site; ?></td>
                                    <td><?php echo substr($v->star_time,10).'<br>'.substr($v->end_time,10); ?></td>
                                    <td><?php echo $v->game_over_name; ?></td>
                                    <td><?php echo $v->if_votes_name; ?></td>
                                    <td>
                                        <a href="javascript:;" class="btn" onclick="onSetting('<?php echo $v->id; ?>','<?php echo $v->arrange_tname; ?>','<?php echo substr($v->arrange_tcode,0,4); ?>');">计时记分</a>
                                    </td>
                                </tr>
                            <?php $index++; }?>
                        </tbody>
                    </table>
                <div/><!--box-table end-->
            </form>
            <div class="box-page c"><?php $this->page($pages); ?></div>
        </div><!--box-content || gamesign-lt end-->
    </div>
</div><!--box end-->
<script>
    // var file_path = '<?php //echo $url_name; ?>';
    var game_data_id = '<?php echo $_REQUEST['game_data_id']; ?>';
    $(function(){
        $('.input-text').on('click',function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
        // 默认显示方式
        var form_width = $('#save_results').width();
        $('#code_stage').css('width',form_width+'px');
        $('#title_top').css('width',form_width+'px');
        $('#save_results').width();
        $('.nav-ul li:nth-child(1)').addClass('td_bor');
        var type = $('.nav-ul li:nth-child(1)').attr('code');
        if(type==undefined || type=='undefined') sessionStorage.clear();
        var data_id = sessionStorage.getItem('dataid');
        var session_type = sessionStorage.getItem('code_type');
        // var set_file_path = sessionStorage.getItem('set_file_path');
        var code_stage = $('#code_stage').innerHeight();
        var document_width = $(document).width();
        if(session_type!='' && session_type!=null && session_type!='null' && session_type!=undefined && data_id==game_data_id) type = session_type;// && set_file_path==file_path
        clickTname(type);
        // console.log(type,session_type,set_file_path,file_path);
        if(code_stage<10){
            $('#title_top').css('top','90px');
            if(game_data_id<1){
                $('#save_results').css('top','110px');
            }
            else{
                $('#save_results').css('top','55px');
            }
        }
        // if(document_width<=1440){
            // $('#code_stage').css('top','135px');
            if(code_stage>50){
                $('#title_top').css('top','160px');
                $('#save_results').css('top','125px');
            } else if(code_stage<50 && code_stage>10){
                // $('.box-content').css('margin-top','185px');
            }
        // }
    });

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

    function changeGameid(op){
        $('#game_data_id').val('');
        $('#arrange_tcode').val('');
        sessionStorage.clear();
    }

    // 计时计分
    function onSetting(id,cont,code){
        $.dialog.data('id', 0);
        $.dialog.open('<?php echo $this->createUrl('data_query'); ?>&id='+id+'&name=<?php echo $page_name; ?>',{
            id:'tianjia',
            lock:true,
            opacity:0.3,
            title:'计时记分',
            width:'90%',
            height:'90%',
            close: function () {
                // window.location.reload(true);
            }
        });
    }

    function clickMatches(op){
        var ed = ($(op).is(':checked')==true) ? 1 : 0;
        $('#matches_val').val(ed);
    }

    // 查询时去除赛事id的不可编辑，否则后台获取不到数据
    $('#search_submit').on('click',function(){
        $('#game_id').removeAttr('disabled');
    })
</script>