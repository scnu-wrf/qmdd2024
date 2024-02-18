<?php
    check_request('game_id',0);
    check_request('data_id',0);
    $box = '';
    if(!isset($_REQUEST['check_box'])){
        $_REQUEST['check_box'] = 0;
        $box = 'checked="checked"';
    }
    $checked = 'checked="checked"';
    $sno = 0;
?>
<style>
    .box-table .list tr th,.box-table .list tr td{ text-align: center; }
    /* .box-search{margin-top: 0;padding-top: 0;border-top: 0;} */
    .aui_content{ height:auto;overflow:auto;padding:5px 5px!important;max-height: 400px!important;min-height:300px!important; }
    .aui_main{ height:auto!important; }
    .cld{ background-color: #f8f8f8;display: none; }
    .list .input-text{ width: 25%;text-align: center; }
    /* .input-check{ vertical-align: -webkit-baseline-middle;vertical-align: -moz-middle-with-baseline; } */
    .list tr:hover td { background: none!important; }
</style>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名 》赛事成绩 》成绩录入</h1>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="submitType" id="submitType" value="">
                <label style="margin-right:10px;">
                    <span>赛事：</span>
                    <?php echo downList($game_id,'id','game_title','game_id','id="game_id" onchange="changeGameid(this);"'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>项目：</span>
                    <select name="data_id" id="data_id">
                        <option value="">请选择</option>
                    </select>
                </label>
                <span style="vertical-align: middle;">
                    <span class="check">
                        <input type="radio" id="single_field" class="input-check" <?php echo ($_REQUEST['check_box']==9) ? $checked : $box; ?> name="check_box" value="9">
                        <label for="single_field">单场</label>
                    </span>
                    <span class="check">
                        <input type="radio" id="group" class="input-check" <?php echo ($_REQUEST['check_box']==5) ? $checked : ''; ?> name="check_box" value="5">
                        <label for="group">小组</label>
                    </span>
                </span>
                <button class="btn btn-blue" type="submit">查询</button>
                <a class="btn" href="javascript:;" onclick="we.reload();" style="vertical-align: bottom;margin-left:20px;"><i class="fa fa-refresh"></i>刷新</a>
            </form>
        </div><!--box-search end-->
        <form id="save_results" name="save_results">
            <div class="box-table">
                <table class="list">
                <?php if($_REQUEST['check_box']==9 || $_REQUEST['check_box']==0) {?>
                    <thead>
                        <tr>
                            <th style="width: 5%;">序号</th>
                            <th>场次</th>
                            <th>参赛人/队</th>
                            <th>成绩</th>
                            <th>积分</th>
                            <th>胜者</th>
                            <th>名次</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $index = 1;
                        $index1 = 1;
                        $sno = count($arclist);
                        foreach($arclist as $v){
                            $cond = 'game_data_id='.$v->game_data_id.' and left(arrange_tcode,7)="'.substr($v->arrange_tcode,0,7).'" and length(arrange_tcode)=9';
                            $action = $model->findAll($cond.' order by game_order');
                            echo $action[0]->id.'***'.$v->id.'<br>';
                            $len=strlen(trim($v->arrange_tcode));?>
                            <tr id="tr_<?php echo $v->id; ?>" style="height:47px;">
                                <input type="hidden" name="c_id_<?php echo $index1; ?>" value="<?php echo $v->id; ?>">
                                <?php
                                    if(!empty($action))if($action[0]->id==$v->id){
                                    $row = count($action);
                                ?>
                                    <td rowspan="<?php echo $row; ?>"><span class="num num-1"><?php echo $index; ?></span></td>
                                    <td rowspan="<?php echo $row; ?>">
                                        <?php
                                            $tn4 = $model->find('game_data_id='.$v->game_data_id.' and left(arrange_tcode,4)="'.substr($v->arrange_tcode,0,4).'"');
                                            $tn5 = $model->find('game_data_id='.$v->game_data_id.' and left(arrange_tcode,5)="'.substr($v->arrange_tcode,0,5).'"');
                                            $tn7 = $model->find('game_data_id='.$v->game_data_id.' and left(arrange_tcode,7)="'.substr($v->arrange_tcode,0,7).'"');
                                            echo $tn4->arrange_tname.'/'.$tn5->arrange_tname.'/'.$tn7->arrange_tname;
                                        ?>
                                    </td>
                                <?php $index++; }?>
                                <td>
                                    <?php
                                        if($v->game_player_id==665){
                                            echo ($v->sign_id>0) ? $v->sign_name : $v->arrange_tname;
                                        }
                                        else{
                                            echo ($v->team_id>0) ? $v->team_name : $v->arrange_tname;
                                        }
                                    ?>
                                </td>
                                <td><input type="text" class="input-text" name="c_game_mark_<?php echo $index1; ?>" value="<?php echo $v->game_mark; ?>"></td>
                                <td><input type="text" class="input-text" name="c_game_score_<?php echo $index1; ?>" value="<?php echo $v->game_score; ?>"></td>
                                <td>
                                    <select name="c_is_promotion_<?php echo $index1; ?>">
                                        <option value="">请选择</option>
                                        <?php
                                            $is_promotion = BaseCode::model()->getCode(1005);
                                            foreach($is_promotion as $i){
                                        ?>
                                        <option value="<?php echo $i->f_id; ?>" <?php if($i->f_id==$v->is_promotion)echo 'selected'; ?>><?php echo $i->F_NAME; ?></option>
                                    <?php }?>
                                    </select>
                                </td>
                                <td><input type="text" class="input-text" name="c_game_order_<?php echo $index1; ?>" value="<?php echo $v->game_order; ?>"></td>
                                <?php
                                    if(!empty($action))if($action[0]->id==$v->id){
                                        $time = $model->find('game_data_id='.$v->game_data_id.' and left(arrange_tcode,7)="'.substr($v->arrange_tcode,0,7).'" and length(arrange_tcode)=7');
                                    ?>
                                    <td rowspan="<?php echo $row; ?>">
                                        <?php
                                            $len = count($time);
                                            $id = ($len>0) ? $time->id : '';
                                            $star_time = ($len>0) ? ($time->star_time=='0000-00-00 00:00:00') ? '' : $time->star_time : '';
                                            $end_time = ($len>0) ? ($time->end_time=='0000-00-00 00:00:00') ? '' : $time->end_time : '';
                                            $votes_star_time = ($len>0) ? ($time->votes_star_time=='0000-00-00 00:00:00') ? '' : $time->votes_star_time : '';
                                            $votes_end_time = ($len>0) ? ($time->votes_end_time=='0000-00-00 00:00:00') ? '' : $time->votes_end_time : '';
                                            echo '<a href="javascript:;" class="btn" onclick="onSetting(\''.$id.'\',\''.$star_time.'\',\''.$end_time.'\',\''.$votes_star_time.'\',\''.$votes_end_time.'\');">更多</a>';
                                        ?>
                                    </td>
                                <?php }?>
                            </tr>
                        <?php $index1++; } ?>
                    </tbody>
                <?php }else if($_REQUEST['check_box']==5){?>
                    <thead>
                        <tr>
                            <th style="width: 5%;">序号</th>
                            <th>小组</th>
                            <th>参赛人/队</th>
                            <th>积分</th>
                            <th>名次</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $index = 1;
                        $index1 = 1;
                        $sno = count($arclist);
                        foreach($arclist as $v){
                            $cond = 'game_data_id='.$v->game_data_id.' and left(arrange_tcode,5)="'.substr($v->arrange_tcode,0,5).'" and length(arrange_tcode)=9';
                            $action = $model->findAll($cond.' order by group_score_order');
                            $row = count($action);
                            $len=strlen(trim($v->arrange_tcode));?>
                            <tr id="tr_<?php echo $v->id; ?>" style="height:47px;">
                                <input type="hidden" name="c_id_<?php echo $index1; ?>" value="<?php echo $v->id; ?>">
                                <?php if(!empty($action))if($action[0]->id==$v->id){?>
                                    <td rowspan="<?php echo $row; ?>"><span class="num num-1"><?php echo $index; ?></span></td>
                                    <td rowspan="<?php echo $row; ?>">
                                        <?php
                                            $tn4 = $model->find('game_data_id='.$v->game_data_id.' and left(arrange_tcode,4)="'.substr($v->arrange_tcode,0,4).'"');
                                            $tn5 = $model->find('game_data_id='.$v->game_data_id.' and left(arrange_tcode,5)="'.substr($v->arrange_tcode,0,5).'"');
                                            $tn7 = $model->find('game_data_id='.$v->game_data_id.' and left(arrange_tcode,7)="'.substr($v->arrange_tcode,0,7).'"');
                                            echo $tn4->arrange_tname.'/'.$tn5->arrange_tname.'/'.$tn7->arrange_tname;
                                        ?>
                                    </td>
                                <?php $index++; }?>
                                <td>
                                    <?php
                                        if($v->game_player_id==665){
                                            echo ($v->sign_id>0) ? $v->sign_name : $v->arrange_tname;
                                        }
                                        else{
                                            echo ($v->team_id>0) ? $v->team_name : $v->arrange_tname;
                                        }
                                    ?>
                                </td>
                                <td><input type="text" class="input-text" name="c_group_score_<?php echo $index1; ?>" value="<?php echo $v->group_score; ?>"></td>
                                <td><input type="text" class="input-text" name="c_group_score_order_<?php echo $index1; ?>" value="<?php echo $v->group_score_order; ?>"></td>
                            </tr>
                        <?php $index1++; }?>
                    </tbody>
                <?php }?>
                </table>
            </div><!--box-table end-->
        </form>
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content || gamesign-lt end-->
</div><!--box end-->
<script>
    changeGameid($('#game_id'));
    function changeGameid(obj){
        var obj = $(obj).val();
        if(obj > 0){
            var pr = '<?php echo $_REQUEST['data_id']; ?>';
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('data_id'); ?>&game_id='+obj,
                dataType: 'json',
                success: function(data) {
                    var s_html = '<option value>请选择</option>';
                    for(var i=0;i<data.length;i++){
                        s_html += '<option value="'+data[i]['id']+'" '+((data[i]['id']==pr) ? 'selected>' : '>')+data[i]['game_data_name']+'</option>';
                    }
                    $('#data_id').html(s_html);
                }
            });
        }
    }

    // function input_result(data_id,tcode,id){
    //     var t_id = $('#tr_'+id);

    // }

    $('.input-text,select').blur(function(){
        // if(this.value==undefined){
        //     return false;
        // }
        save_results();
    });

    function save_results(){
        var form = $('#save_results').serialize();
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('save_results',array('sno'=>$sno,'box'=>$_REQUEST['check_box'])); ?>',
            data: form,
            dataType: 'json',
            error:function(){
                we.msg('minus','保存错误');
            },
            success: function(data){
                // console.log(data);
            }
        });
    }

    function onSetting(id,star_time,end_time,votes_star_time,votes_end_time){
        var s_html = 
        '<div id="form_div">'+
            '<form action="" id="time_form" name="time_form">'+
                '<span>'+
                    '<div class="box-detail-tab">'+
                        '<ul class="c">'+
                            '<li class="current" onclick="ontime(this);" data="game_time" style="width: 50%;">比赛时间设置</li>'+
                            '<li onclick="ontime(this);" data="vote_time" style="width: 50%;">投票时间设置</li>'+
                        '</ul>'+
                    '</div>'+
                '</span>'+
                '<table id="game_time" class="box-detail-table">'+
                    '<tr class="table-title">'+
                        '<td colspan="2" style="text-align:center;">比赛时间设置</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>比赛开始时间</td>'+
                        '<td><input type="text" class="input-text time" id="star_time" name="star_time" value="'+star_time+'"></td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>比赛结束时间</td>'+
                        '<td><input type="text" class="input-text time" id="end_time" name="end_time" value="'+end_time+'"></td>'+
                    '</tr>'+
                    '<tr>'+
                        '<input type="hidden" name="t_id" value="'+id+'">'+
                        '<td style="text-align:center;"><input type="button" class="btn" onclick="save_time('+id+',\'star_time\');" value="立即开始"></td>'+
                        '<td style="text-align:center;"><input type="button" class="btn" onclick="save_time('+id+',\'end_time\');" value="立即结束"></td>'+
                    '</tr>'+
                '</table>'+
                '<table id="vote_time" class="box-detail-table" style="display:none;">'+
                    '<tr class="table-title">'+
                        '<td colspan="2" style="text-align:center;">投票时间设置</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>投票开始时间</td>'+
                        '<td><input type="text" class="input-text time" id="votes_star_time" name="votes_star_time" value="'+votes_star_time+'"></td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>投票结束时间</td>'+
                        '<td><input type="text" class="input-text time" id="votes_end_time" name="votes_end_time" value="'+votes_end_time+'"></td>'+
                    '</tr>'+
                    '<tr>'+
                        '<input type="hidden" name="t_id" value="'+id+'">'+
                        '<td style="text-align:center;"><input type="button" class="btn" onclick="save_time('+id+',\'votes_star_time\');" value="立即开始"></td>'+
                        '<td style="text-align:center;"><input type="button" class="btn" onclick="save_time('+id+',\'votes_end_time\');" value="立即结束"></td>'+
                    '</tr>'+
                '</table>'+
            '</form>'+
        '</div>';
        $.dialog({
            id:'group_set',
            lock:true,
            opacity:0.3,
            width: '30%',
            height: '45%',
            title:'更多设置',
            content:s_html,
            button:[
                {
                    name:'保存',
                    focus:true,
                    callback:function(){
                        return save_data('time_form','<?php echo $this->createUrl('save_set'); ?>',id);
                    },
                },
                {
                    name:'取消',
                    callback:function(){
                        window.location.reload(true);
                        return true;
                    }
                }
            ]
        });
    }

    $(function(){
        $('.time').on('click',function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'HH:mm-HH:mm',minDate:'00:00',quickSel:['%H-00','%H-30','%H-00']});
        });
    })

    function ontime(obj){
        var obj = $(obj);
        var attr = obj.attr('data');
        var tab = $('.box-detail-tab ul li');
        tab.css('border-bottom-color','#ffffff');
        obj.css('border-bottom-color','#ff8e24');
        $('#form_div').find('.box-detail-table').css('display','none');
        $('#'+attr).css('display','inline-table');
    }

    function save_data(form_id,url='',id=''){
        var form = $('#'+form_id).serialize();
        we.loading('show');
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('save_set'); ?>&id='+id,
            data: form,
            dataType: 'json',
            success: function(data){
                if(data.status==1){
                    we.loading('hide');
                    we.success(data.msg, data.redirect);
                }else{
                    we.loading('hide');
                    we.msg('minus', data.msg);
                }
            },
            error: function(){
                alert('失败');
            }
        });
        return true;
    }

    function save_time(id,col){
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('save_time'); ?>&id='+id+'&column='+col,
            dataType: 'json',
            success: function(data){
                $('#'+col).val(data);
                if(data.status==1){
                    we.loading('hide');
                    we.success(data.msg, data.redirect);
                }else{
                    we.loading('hide');
                    we.msg('minus', data.msg);
                }
            },
            error: function(){
                alert('失败');
            }
        });
    }
</script>