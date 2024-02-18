<?php
    check_request('arrange_tcode',0);
    check_request('game_id',0);
    check_request('data_id',$data_id);
    $data_id = $_REQUEST['data_id'];
    $game_id = $_REQUEST['game_id'];
    $game_list = GameList::model()->find('id='.$game_id);
    $game_data = GameListData::model()->find('id='.$data_id);
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
?>
<style>
    .box-table .list tr th,.box-table .list tr td{ text-align: center; }
    .nav-ul li{ display:inline-block;width:8%;padding:5px;text-align:center;background-color:#5b8d98;color:white;cursor:pointer;margin-top:5px; }
    .table-title:hover td { background: #efefef!important; }
    .td_bor{ border-bottom: solid 2px #d6841e; }
</style>
<div class="box" style="margin: 0px 10px 10px 0;">
    <div class="gamesign c">
        <div class="box-title c" style="width: 99%;position: fixed;background-color: #F2F2F2;z-index: 99;">
            <h1>当前界面：赛事/排名 》赛事管理 》赛事列表 》成绩</h1>
            <span style="float:right;margin-right:15px;">
                <a class="btn" href="<?php echo $this->createUrl($url); ?>">返回上一层</a>
                <a class="btn" href="javascript:;" onclick="we.reload();" style="vertical-align: bottom;margin-left:20px;"><i class="fa fa-refresh"></i>刷新</a>
            </span>
        </div><!--box-title end-->
        <div class="gamesign-rt game_list_arrange" style="background-color:#e0e0e0;top: 43px;">
            <div class="gamesign-group">
                <span class="gamesign-title">竞赛项目</span>
                <?php foreach($data_list as $v){ ?>
                    <a <?php if($data_id==$v->id){?> class="current"<?php }?> href="<?php echo $this->createUrl('game_list_sign',array('game_id'=>$v->game_id,'data_id'=>$v->id,'back'=>$_REQUEST['back']));?>"><?php echo $v->game_data_name;?></a>
                <?php }?>
            </div>
        </div><!--gamesign-rt end-->
        <div style="display:none;">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="arrange_tcode" id="arrange_tcode" value="<?php echo $_REQUEST['arrange_tcode']; ?>">
                <input type="hidden" name="game_id" value="<?php echo $_REQUEST['game_id']; ?>">
                <input type="hidden" name="data_id" value="<?php echo $_REQUEST['data_id']; ?>">
                <button id="search_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="<?php echo ($_REQUEST['game_id']!=0) ? 'gamesign-lt' : 'box-content'; ?>">
            <div class="box-header" style="margin-top: 43px;width: 82.4%;z-index: 99;position: fixed;">
                <span style="font-size:14px;font-weight:700;">
                    <span><?php if(!empty($game_data)){ echo $game_data->game_name.' 》'.$game_data->game_data_name.' 》'; }elseif(!empty($game_list)) echo $game_list->game_title.' 》'; ?>成绩</span>
                </span>
            </div>
            <?php if($_REQUEST['game_id']>0) {?>
                <div id="code_stage" style="position: fixed;width: 83.5%;background-color: #f2f2f2;z-index: 99;padding: 2px 0 7px 0;margin-top: 83px;">
                    <ul class="nav-ul">
                        <?php
                            $arrange = $model->findAll('game_data_id='.$data_id.' and length(arrange_tcode)=4 order by arrange_tcode');
                            if(!empty($arrange))foreach($arrange as $ar){
                        ?>
                            <li class="nav-li" onclick="clickTname('<?php echo $ar->arrange_tcode; ?>',2);" code="<?php echo $ar->arrange_tcode; ?>"><?php echo $ar->arrange_tname; ?></li>
                        <?php }?>
                    </ul>
                </div>
                <div id="title_top" class="box-detail-tab" style="position: fixed;width: 83.5%;top: 125px;z-index: 99;">
                    <ul class="c">
                        <li class="current"><a href="<?php echo Yii::app()->request->url; ?>">赛事成绩</a></li>
                        <li><a href="<?php echo $this->createUrl('game_list_publicorder',array('game_id'=>$game_id,'data_id'=>$data_id)); ?>">名次公告</a></li>
                    </ul>
                </div>
            <?php }?>
            <div id="box_content" class="box-table" style="margin-top: 175px;">
                <table class="list">
                    <?php $this_site = $model->find('game_data_id='.$data_id.' and left(arrange_tcode,4)="'.$_REQUEST['arrange_tcode'].'" and length(arrange_tcode)=4'); ?>
                    <thead>
                        <tr>
                            <th style="width: 6%;"><?php echo $model->getAttributeLabel('game_time'); ?></th>
                            <th style="width: 8%;"><?php echo $model->getAttributeLabel('group'); ?></th>
                            <th style="width: 8%;"><?php echo $model->getAttributeLabel('matches'); ?></th>
                            <th style="width: 6%;"><?php echo $model->getAttributeLabel('arrange_tname1'); ?></th>
                            <th><?php echo $model->getAttributeLabel('arrange_tname'); ?></th>
                            <th style="width: 8%;"><?php echo $model->getAttributeLabel('winning_bureau'); ?></th>
                            <?php if(!empty($this_site) && $this_site->game_format==988) {?>
                                <th style="width: 8%;"><?php echo $model->getAttributeLabel('game_score'); ?></th>
                            <?php }?>
                            <th style="width: 8%;"><?php echo $model->getAttributeLabel('is_promotion'); ?></th>
                            <th style="width: 8%;"><?php echo $model->getAttributeLabel('gf_game_score'); ?></th>
                            <th style="width: 8%;"><?php echo $model->getAttributeLabel('gf_votes_score'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 1; $lnum = count($arclist); foreach($arclist as $v) {?>
                            <?php
                                $count = strlen($v->arrange_tcode);
                                $day = substr($v->star_time,0,10);
                                $tcode = substr($v->arrange_tcode,0,4);
                                $arrange = $model->find('game_data_id='.$v->game_data_id.' and arrange_tcode="'.substr($v->arrange_tcode,0,5).'"');
                                $arrange1 = $model->findAll('game_data_id='.$v->game_data_id.' and left(arrange_tcode,7)="'.$v->arrange_tcode.'" and length(arrange_tcode)=9 order by arrange_tcode');
                                $len = count($arrange1);
                            ?>
                            <?php if($count==7) {?>
                                <tr class="<?php echo $tcode; ?> tr">
                                    <td rowspan="<?php echo $len+1; ?>"><?php echo $day; ?></td>
                                    <td rowspan="<?php echo $len+1; ?>" class="group_code" attrname="<?php echo $arrange->arrange_tcode; ?>"><?php echo $arrange->arrange_tname; ?></td>
                                    <td rowspan="<?php echo $len+1; ?>"><?php echo $v->arrange_tname; ?></td>
                                </tr>
                            <?php }?>
                            <?php $num = 1;$n = 0; if(!empty($arrange1))foreach($arrange1 as $a1) {?>
                                <?php $t_name = ($a1->game_player_id==665) ? $a1->sign_name : $a1->team_name; ?>
                                <tr class="<?php echo $tcode; ?> tr">
                                    <input type="hidden" id="id_<?php echo $index.'_'.$num; ?>" value="<?php echo $a1->id; ?>">
                                    <td><?php echo $a1->arrange_tname; ?></td>
                                    <td><?php echo (empty($t_name)) ? $a1->f_sname : $t_name; ?></td>
                                    <td><?php echo $a1->winning_bureau; ?></td>
                                    <td><?php if(!empty($a1->is_promotion)) echo $a1->base_is_promotion->F_NAME; ?></td>
                                    <td><?php echo ($a1->score_confirm==1) ? $a1->gf_game_score : 0; ?></td>
                                    <td><?php echo $a1->gf_votes_score; ?></td>
                                </tr>
                            <?php $num++;$n++; }?>
                        <?php $index++; }?>
                    </tbody>
                </table>
            <div/><!--box-table end-->
            <div class="box-page c"><?php $this->page($pages); ?></div>
        </div><!--box-content || gamesign-lt end-->
    </div>
</div><!--box end-->
<script>
    var game_data_id = '<?php echo $data_id; ?>';
    $(function(){
        // 默认显示方式
        $('.nav-ul li:nth-child(1)').addClass('td_bor');
        var type = $('.nav-ul li:nth-child(1)').attr('code');
        if(type==undefined || type=='undefined') {sessionStorage.clear();}
        var data_id = sessionStorage.getItem('dataid');
        // var set_file_path = sessionStorage.getItem('set_file_path');
        var session_type = sessionStorage.getItem('code_type');
        // console.log(type,session_type);
        var code_stage = $('#code_stage').innerHeight();
        var document_width = $(document).width();
        if(session_type!='' && session_type!=null && session_type!='null' && session_type!=undefined && session_type!='undefined' && data_id==game_data_id) type = session_type;// && set_file_path==file_path
        clickTname(type);
        // console.log(type,code_stage,session_type);
        if(code_stage<10){
            $('#title_top').css('top','90px');
            $('#box_content').css('margin-top','135px');
        }
        if(code_stage>50){
            $('#title_top').css('top','160px');
            $('#box_content').css('margin-top','205px');
        }

        // 按照顺序显示,已显示过的组按钮不再显示
        var group_end_session = sessionStorage.getItem('group_end');
        var group_first = $.trim($('.arr_group').first().text());
        var group_end = $.trim($('.arr_group').last().text());
        if(group_end_session==group_first){
            $('.arr_group').first().remove();
        }
        else{
            sessionStorage.setItem('group_end',group_end);
        }
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
</script>