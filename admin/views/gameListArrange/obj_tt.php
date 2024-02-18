<style>
    .bold{ font-weight: bold;font-size: 15px; }
    .blue_vs{ color: black;font-weight: bold; }
    #game_table td{ text-align:center; }
    .not_padding td{ padding:0; }
    .not_padding td div{ color:white; }
    .span_redio{ display: inline-block;width: 15px;height: 15px;background-color: red;border-radius: 50%;vertical-align: sub;margin-left: 10px; }
    .score_style{ text-align:center;/*border:none;*/font-size:20px; }
    .box-detail-tab li { width: 120px; }
    .not_sele{ -webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none; }
    .input-text1 {padding: 4px 8px;width: 90%;height: 16px;line-height: 16px;vertical-align: middle;color: #333;border: 1px #d9d9d9 solid;}
    .bureau{ width:20%;text-align:center;border-top: 0;border-left: 0;border-right: 0;font-weight: bold;font-size: 1rem; }
    .bureau:focus { border-top: 0;border-left: 0;border-right: 0;}
</style>
<!-- 乒乓球 -->
<div class="box">
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div id="form_div">
                <table id="game_table" class="box-detail-table" style="position: relative;">
                    <tr class="table-title">
                        <td colspan="8" style="text-align:center;">
                            <h3><?php echo $title; ?></h3>
                            <h3>
                                <span style="position:absolute;"><?php echo $model->arrange_tname; ?></span>
                                <span style="position:relative;float: right;">
                                    <input type="button" class="btn" id="stop_refresh" value="停止刷新">
                                    <input type="button" class="btn" id="refresh" value="自动刷新">
                                    <input type="button" class="btn btn-blue" onclick="clickSelectSign();" value="现场名字导入">
                                </span>
                            </h3>
                        </td>
                    </tr>
                    <tr>
                        <td class="bold">主裁姓名</td>
                        <td colspan="3"><?php echo $form->textField($model,'chief_umpire',array('class'=>'input-text1')); ?></td>
                        <td class="bold">胜盘制</td>
                        <td colspan="3">
                            <?php $bureau = explode(',',$model->bureau_num); ?>
                            <input type="text" class="input-text1 onkeyup bureau" id="bureau" name="bureau" placeholder="输入数字" value="<?php echo (isset($bureau[0])) ? $bureau[0] : ''; ?>"> 局 
                            <input type="text" class="input-text1 onkeyup bureau" id="bureau_num" name="bureau_num" placeholder="输入数字" value="<?php echo (isset($bureau[1])) ? $bureau[1] : ''; ?>"> 胜
                        </td>
                    </tr>
                    <tr>
                        <td class="bold">比赛开始时间</td>
                        <td colspan="3">
                            <?php
                                $model->star_time = ($model->star_time=='0000-00-00 00:00:00') ? '' : $model->star_time;
                                echo $form->textField($model,'star_time',array('class'=>'input-text1 time'));
                            ?>
                        </td>
                        <td class="bold">本场比赛计时</td>
                        <td colspan="3"><input type="text" class="input-text1" id="rem_time" name="rem_time" value="<?php echo (empty($model->rem_time)) ? '0:0:0' : $model->rem_time; ?>" style="text-align:center;font-size:1.5rem;"></td>
                    </tr>
                    <tr>
                        <?php
                            $arrange = GameListArrange::model()->findAll('game_data_id='.$model->game_data_id.' and left(arrange_tcode,7)="'.$model->arrange_tcode.'" and length(arrange_tcode)=9 order by arrange_tcode');
                            $name1 = ($model->game_player_id==665) ? $arrange[0]->sign_name : $arrange[0]->team_name;
                            $name2 = ($model->game_player_id==665) ? $arrange[1]->sign_name : $arrange[1]->team_name;
                            $path = BasePath::model()->get_www_path();
                            if(!empty($arrange))foreach($arrange as $key => $val){
                                $pic = ($model->game_player_id==665) ? $path.str_replace('http://upload.gfinter.net/','',$val->sign_logo) : $path.str_replace('http://upload.gfinter.net/','',$val->team_logo);
                                if(!file_exists($pic)) $pic = $path.'2019/06/17/09/85_qf_600__1709291607910.png';
                        ?>
                            <td class="bold">参赛者</td>
                            <td colspan="3">
                                <div class="upload_img">
                                    <a href="<?php echo $pic; ?>" target="_blank">
                                        <img src="<?php echo $pic; ?>" width="100" height="100">
                                    </a>
                                </div>
                            </td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <?php
                            $ball = $arrange[0]->ball_right;
                            if($arrange[0]->ball_right==0 && $arrange[1]->ball_right==0) $ball = 1;
                        ?>
                        <td colspan="4">
                            <input type="hidden" id="id_0" name="id_0" value="<?php echo $arrange[0]->id; ?>">
                            <input type="hidden" id="ball_0" name="ball_0" class="ball" value="1">
                            <span style="padding-left: 25%;">
                                <span id="name_0"><?php echo $name1.'('.$arrange[0]->f_sname.')'; ?></span>
                                <span id="redio_0" class="span_redio" <?php if($ball==0) echo 'style="display:none"'; ?>>
                                    <input type="hidden" id="ball_right_0" name="ball_right_0" value="<?php echo $ball; ?>">
                                </span>
                            </span>
                        </td>
                        <td style="border-top: 0;" class="bold">
                            <span style="margin-top;20px;"><?php echo $val->game_site; ?></span>
                        </td>
                        <td colspan="3">
                            <input type="hidden" id="id_1" name="id_1" value="<?php echo $arrange[1]->id; ?>">
                            <input type="hidden" id="ball_1" name="ball_1" class="ball" value="0">
                            <span id="name_1"><?php echo $name2.'('.$arrange[1]->f_sname.')'; ?></span>
                            <span id="redio_1" class="span_redio" <?php if($arrange[1]->ball_right==0) echo 'style="display:none"'; ?>>
                                <input type="hidden" id="ball_right_1" name="ball_right_1" value="<?php echo $arrange[1]->ball_right; ?>">
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="bold">获胜局</td>
                        <td colspan="3"><input type="text" class="input-text score_style onkeyup" id="winning_bureau_0" name="winning_bureau_0" value="<?php echo $arrange[0]->winning_bureau; ?>"></td>
                        <td class="blue_vs">:</td>
                        <td colspan="3"><input type="text" class="input-text score_style onkeyup" id="winning_bureau_1" name="winning_bureau_1" value="<?php echo $arrange[1]->winning_bureau; ?>"></td>
                    </tr>
                    <tr class="not_padding not_sele">
                        <td rowspan="2" class="bold">输入区</td>
                        <td onclick="clickAddnum('reduce','left',901);" class="clickEvent_0" style="cursor: pointer;">
                            <span style="font-size: 24px;">-</span>
                        </td>
                        <td style="cursor: pointer;">
                            <input type="text" class="input-text score_style" id="bureau_score_0" name="bureau_score_0" value="<?php echo $arrange[0]->bureau_score; ?>" style="border: 0;" readonly="readonly">
                        </td>
                        <td onclick="clickAddnum('add','left',901);" class="clickEvent_0" style="cursor: pointer;">
                            <span style="font-size: 24px;">+</span>
                        </td>
                        <td class="blue_vs">:</td>
                        <td onclick="clickAddnum('reduce','right',901);" class="clickEvent_1" style="cursor: pointer;">
                            <span style="font-size: 24px;">-</span>
                        </td>
                        <td style="cursor: pointer;">
                            <input type="text" class="input-text score_style" id="bureau_score_1" name="bureau_score_1" value="<?php echo $arrange[1]->bureau_score; ?>" style="border: 0;" readonly="readonly">
                        </td>
                        <td onclick="clickAddnum('add','right',901);" class="clickEvent_1" style="cursor: pointer;">
                            <span style="font-size: 24px;">+</span>
                        </td>
                    </tr>
                    <tr class="not_sele">
                        <td colspan="3" onclick="clickChange(901);" style="cursor: pointer;background-color: #EBF1DE;"><span class="bold" style="font-size: 18px;">换发球方</span></td>
                        <td colspan="4" onclick="clickRevoke();" style="cursor: pointer;background-color: #EBF1DE;padding: 10px;font-size: 20px;font-weight: bold;">撤销</td>
                        <!--弃用 <td colspan="2" onclick="clickRecovery(<?php //echo $model->id; ?>);" style="cursor: pointer;background-color: #EBF1DE;padding: 10px;font-size: 20px;font-weight: bold;">恢复</td> -->
                    </tr>
                    <tr class="not_sele">
                        <td class="bold">操作</td>
                        <td colspan="3" id="readyGame" style="cursor: pointer;background-color:#EBF1DE;font-size: 20px;font-weight: bold;" onclick="onTime(this);"><?php echo ($model->game_over==901) ? '比赛继续' : '本场比赛开始'; ?></td>
                        <td colspan="2" onclick="clickOver(0,901);" style="cursor: pointer;background-color:#EBF1DE;padding: 10px;font-size: 20px;font-weight: bold;">本局结束</td>
                        <td colspan="2" onclick="clickOver(1,908);" style="cursor: pointer;background-color:#EBF1DE;padding: 10px;font-size: 20px;font-weight: bold;">比赛结束</td>
                    </tr>
                </table>
            </div>
        </div>
        <?php $this->endWidget();?>
    </div>
</div>
<script>
    // 保存：裁判、计时、开始时间、盘数
    $('body').on('blur','.input-text1',function(){
        var game_over = <?php echo $model->game_over; ?>;
        var gv = get_game_over();
        if(game_over!=gv) game_over=gv;
        save_game_state('<?php echo $this->createUrl('save_retime',array('id'=>$model->id)); ?>');
    });

    // 保存分数
    $('body').on('blur','.input-text',function(){
        var game_over = <?php echo $model->game_over; ?>;
        var gv = get_game_over();
        if(game_over!=gv) game_over=gv;
        save_ajax(game_over);
    });

    // 获取赛事状态
    function get_game_over(){
        data_over = 0;
        $.ajax({
            async: false,
            type: 'get',
            url: '<?php echo $this->createUrl('getGameOver',['id'=>$model->id]); ?>',
            dataType: 'json',
            success: function(data){
                // console.log(data);
                data_over = data;
            }
        });
        return data_over;
    }

    // function onTime(){
        var hour,minute,second;//时 分 秒
        hour=minute=second=0;//初始化
        var millisecond=0;//毫秒
        var int;
    // function Reset()//重置
    // {
    //   window.clearInterval(int);
    //   millisecond=hour=minute=second=0;
    //   document.getElementById('rem_time').value='00时00分00秒00毫秒';
    // }
    // 比赛开始按钮
    var one = 0;
    function onTime(obj){
        var myDate = new Date();
        var getMonth = myDate.getMonth() + 1;
        var getDay = myDate.getDate();
        var getMin = myDate.getMinutes();
        var getSec = myDate.getSeconds();
        var getHou = myDate.getHours();
        getMonth = (getMonth<10) ? '0'+getMonth : getMonth;
        getDay = (getDay<10) ? '0'+getDay : getDay;
        getHou = (getHou<10) ? '0'+getHou : getHou;
        getMin = (getMin<10) ? '0'+getMin : getMin;
        getSec = (getSec<10) ? '0'+getSec : getSec;
        if(one==0){
            var date = myDate.getFullYear()+'-'+getMonth+'-'+getDay+' '+getHou+':'+getMin+':'+getSec;
            $('#GameListArrange_star_time').val(date);
            var time = $('#rem_time').val();
            var spl = time.split(':');
            second = second+parseInt(spl[2].trim());
            minute = minute+parseInt(spl[1].trim());
            hour = hour+parseInt(spl[0].trim());
            int = setInterval(timer,50);
            obj.innerHTML = '比赛暂停';
            one = 1;
        }
        else{
            stop();
            obj.innerHTML = '比赛继续';
        }
        save_ajax(901,1);
        // 更改比赛状态
        save_game_state('<?php echo $this->createUrl('save_game_state',array('id'=>$model->id)); ?>');
    }
    
    // 暂停    
    function stop(){
        window.clearInterval(int);
        hour=minute=second=0;
        one = 0;
    }

    //计时
    function timer(){
        millisecond = millisecond+50;
        if(millisecond>=1000){
            millisecond = 0;
            second = second+1;
        }
        if(second>=60){
            second = 0;
            minute = minute+1;
        }
        if(minute>=60){
            minute = 0;
            hour = hour+1;
        }
        document.getElementById('rem_time').value = hour+':'+minute+':'+second;
        if(millisecond/100 == 0){
            save_game_state('<?php echo $this->createUrl('save_game_time',array('id'=>$model->id)); ?>');
        }
    }
    
    $('body').on('click','.time',function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});
    });
    
    $('body').on('keyup','.onkeyup',function(){
        if(this.value.length==1){
            this.value=this.value.replace(/[^0-9]/g,'');
        }
        else{
            this.value=this.value.replace(/\D/g,'');
        }
    });

    // 加分
    function clickAddnum(n,c,game_over){
        var b = (n=='add') ? 1 : -1;
        if(c=='left'){
            var num1 = parseInt($('#bureau_score_0').val());
            if(b==-1 && num1==0){
                
            }
            else{
                $('#bureau_score_0').val(num1+b);
            }
        }
        else{
            var num1 = parseInt($('#bureau_score_1').val());
                if(b==-1 && num1==0){
                    
                }
                else{
                    $('#bureau_score_1').val(num1+b);
                }
        }
        save_ajax(game_over);
    }

    // 换发球
    function clickChange(game_over){
        var gv = get_game_over();
        if(gv!=game_over) game_over = gv;
        $('.span_redio').each(function(){
            if($(this).css('display')=='none'){
                $(this).css('display','inline-block');
                if($(this).attr('id')=='redio_0'){
                    $('#ball_0').val(1);
                    $('#ball_1').val(0);
                    $('#ball_right_0').val(1);
                    $('#ball_right_1').val(0);
                }
                else{
                    $('#ball_0').val(0);
                    $('#ball_1').val(1);
                    $('#ball_right_0').val(0);
                    $('#ball_right_1').val(1);
                }
            }
            else{
                $(this).css('display','none');
            }
        });
        save_ajax(game_over);
    }

    // 每触发一次加分保存一次
    function save_ajax(game_over,n=0){
        var form = $('#active-form').serialize();
        // console.log(form);
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('save_table_tennis',array('id'=>$model->id)); ?>&game_over='+game_over,
            data: form,
            dataType: 'json',
            success: function(data){
                if(n==0 && data>0 && game_over==908){
                    parent.location.reload();
                }
            },
            error: function(request){
                we.msg('minus','发生错误');
            }
        });
    }

    // 比赛开始时更改赛事状态 || 时间发生改变时
    function save_game_state(url){
        var form = $('#active-form').serialize();
        $.ajax({
            type: 'post',
            url: url,
            data: form,
            dataType: 'json',
            success: function(data){
                // console.log(data);
            },
            error: function(request){
                console.log('发生错误');
            }
        });
    }

    // 比赛结束方式
    function clickOver(n,game_over){
        var s0 = parseInt($('#bureau_score_0').val());
        var s1 = parseInt($('#bureau_score_1').val());
        var vl = parseInt($('#winning_bureau_0').val());
        var vr = parseInt($('#winning_bureau_1').val());
        if(n==0){
            if(s0>s1){
                $('#winning_bureau_0').val(vl+1);
            }
            else if(s1>s0){
                $('#winning_bureau_1').val(vr+1);
            }
            if((s0!=s1) && (s0>0 || s1>0)){
                $('#bureau_score_0').val(0);
                $('#bureau_score_1').val(0);
            }
        }
        else{
            if(s0>0 || s1>0){
                we.msg('minus','本局未结束');
                return false;
            }
            if(vl==vr){
                we.msg('minus','出现平局');
                return false;
            }
            var a = confirm('确认结束吗？');
            if(a==true){
                stop();
                $('#game_over').val(game_over);
                // we.reload();
            }
            else{
                return false;
            }
        }
        save_ajax(game_over);
    }

    // 撤销
    function clickRevoke(){
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('revoke',array('id'=>$model->id,'gtype'=>'tt')); ?>',
            dataType: 'json',
            success: function(data){
                // console.log(data);
                if(data!=''){
                    for(var i=0;i<2;i++){
                        $('#winning_bureau_'+i).val(data['winning_bureau_'+i]);
                        $('#bureau_score_'+i).val(data['bureau_score_'+i]);
                        $('#ball_right_'+i).val(data['ball_right_'+i]);
                        var radio = (data['ball_right_'+i]==1) ? '' : 'none';
                        $('#redio_'+i).css('display',radio);
                    }
                } else{
                      $('#ball_right_0').val(1);
                      $('#ball_right_1').val(0);
                      $('#redio_0').css('display','');
                      $('#redio_1').css('display','none');
                     for(var i=0;i<2;i++){
                        $('#winning_bureau_'+i).val(0);
                        $('#bureau_score_'+i).val(0);
                    }
                }
            }
        });
    }

    // 获取实时分数改变
    function get_score_ajax(){
        $.ajax({
            type: 'get',
            url: '<?php echo $this->createUrl('getScore',array('id'=>$model->id,'bs'=>'0')); ?>',
            dataType: 'json',
            success: function(data){
                // console.log(data);
                if(data!=''){
                    for(var i=0;i<data.length;i++){
                        var tid = $('#id_'+i).val();
                        if(data[i]['id']==tid){
                            $('#bureau_score_'+i).val(data[i]['bureau_score']);
                            $('#winning_bureau_'+i).val(data[i]['winning_bureau']);
                            $('#ball_right_'+i).val(data[i]['ball_right']);
                        }
                    }
                    $('#rem_time').val(data[0]['rem_time']);
                    if(data[0]['ball_right']==1){
                        $('#redio_0').css('display','');
                    }
                    else if(data[1]['ball_right']==1){
                        $('#redio_1').css('display','');
                    }
                    else{
                        $('#redio_0').css('display','');
                        $('#redio_1').css('display','none');
                    }
                }
            },
            error: function(request){
                console.log(request);
            }
        });
    }

    var interval;
    // 点击暂停按钮
    $("#stop_refresh").click(function(){
        if(interval){
            clearInterval(interval);
            interval = null;
        }
        $('#refresh').removeAttr('disabled');
        $('#refresh').css({'background-color':'#eee','border-color':'#dcdcdc','cursor':'default'});
    });
    
    // 点击刷新
    $("#refresh").click(function(){
        $(this).attr('disabled','disabled');
        $(this).css({'background-color':'#ccc','border-color':'#ccc','cursor':'no-drop'});
        interval = setInterval('get_score_ajax()',3000);
    });

    // 现场名字导入
    function clickSelectSign(){
        $.dialog.data('id', 0);
        $.dialog.open('<?php echo $this->createUrl('selectSign',array('id'=>$model->id)); ?>',{
            id:'select_sign',
            lock:true,
            opacity:0.3,
            title:'对比',
            width:'50%',
            height:'70%',
            close: function () {
                if($.dialog.data('tid')>0){
                    $.ajax({
                        type: 'post',
                        url: '<?php echo $this->createUrl('saveSelectSign',array('arr_id'=>$model->id)); ?>&id='+$.dialog.data('tid'),
                        dataType: 'json',
                        success: function(data){
                            if(data==1){
                                we.reload();
                            }
                        },
                        error: function(request){
                            console.log('错误');
                        }
                    });
                }
                else{
                    we.reload();
                }
            }
        });
    }
</script>