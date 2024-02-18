<?php
    check_request('game_id',0);
    check_request('data_id',0);
?>
<style>
    html {
        font-size: 13.333333vw;
    }
    body {
        font-size: .3rem;
        font-family: -apple-system,SF UI Text,Arial,PingFang SC,Hiragino Sans GB,Microsoft YaHei,WenQuanYi Micro Hei,sans-serif;
        -webkit-text-size-adjust: none;
    }
    .team-operation {
        overflow: hidden;
    }
    .team {
        width: 40%;
        text-align: center;
    }
    .team p.name {
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        text-align: center;
        font-size: .4rem;
    }
    .team .num {
        margin: .8rem 0;
        font-size: .8rem;
    }
    .team .increase,.team .decrease {
        width: 90%;
        margin: 0 auto .4rem;
        color: #fff;
        text-align: center;
        font-size: .6rem;
        border-radius: 5px;
    }
    .game-operation {
        text-align: center;
        margin-top: .5rem;
    }
    .game-operation .start, .game-operation .end {
        display: inline-block;
        width: 2rem;
        height: .8rem;
        line-height: .8rem;
        margin: 0 0.5rem;
        text-align: center;
        font-size: .4rem;
        border: 1px solid #0099ff;
        border-radius: 10px;
    }
    .game-operation .start_time, .game-operation .end_time {
        display: inline-block;
        margin: 0 .9rem;
    }
</style>
<div class="box-content">
    <div class="box-header" style="border-bottom:3px solid #2eb3eb;padding: 20px 20px 20px 0;">
        <!-- <a class="btn" href="<?php //echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a> -->
        <!-- <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a> -->
        <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        <!-- <div class="box-search"> -->
            <form action="<?php echo Yii::app()->request->url;?>" method="get" style="display:inline-block;width: 100%;">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>赛事：</span>
                    <?php echo downList($game_id,'id','game_title','game_id','id="game_id" style="width:calc((100% / 3) - 20px);" onchange="changeGameid(this);"'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>项目：</span>
                    <select name="data_id" id="data_id">
                        <option value="">请选择</option>
                    </select>
                </label>
                <label style="margin-left:20px;">
                    <select id="rounds" name="rounds" onchange="onchanGetSite(this);" style="width:calc((100% / 3) - 20px);">
                        <option value="">请选择阶段</option>
                        <?php if(!empty($rounds)) foreach($rounds as $v){?>
                        <option value="<?php echo $v->arrange_tcode;?>"<?php if(Yii::app()->request->getParam('rounds')==$v->arrange_tcode||$v->arrange_tcode==$r){?> selected<?php }?> gameid="<?php echo $v->game_id;?>" dataid="<?php echo $v->game_data_id;?>" v_id="<?php echo $v->id;?>"><?php echo $v->arrange_tname;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-left:20px;">
                    <select id="group" name="group" onchange="onchanGetMatches(this);" style="width:calc((100% / 3) - 20px);">
                        <option value="">请选择组别</option>
                        <?php if(!empty($group)) foreach($group as $v){?>
                        <option value="<?php echo $v->arrange_tcode;?>"<?php if(Yii::app()->request->getParam('group')==$v->arrange_tcode||$v->arrange_tcode==$g){?> selected<?php }?> gameid="<?php echo $v->game_id;?>" dataid="<?php echo $v->game_data_id;?>" v_id="<?php echo $v->id;?>"><?php echo $v->arrange_tname;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-left:20px;">
                    <select id="matches" name="matches" style="width:calc((100% / 3) - 20px);">
                        <option value="">请选择场次</option>
                        <?php if(!empty($matches)) foreach($matches as $v){?>
                        <option value="<?php echo $v->arrange_tcode;?>"<?php if(Yii::app()->request->getParam('matches')==$v->arrange_tcode||$v->arrange_tcode==$m){?> selected<?php }?> gameid="<?php echo $v->game_id;?>" dataid="<?php echo $v->game_data_id;?>" v_id="<?php echo $v->id;?>"><?php echo $v->arrange_tname;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-left:20px;">
                    <select id="time" name="time" style="width:calc((100% / 3) - 20px);margin-top: 20px;">
                        <option value="">请选择比赛时间</option>
                        <?php if(!empty($time)) foreach($time as $v){?>
                        <option value="<?php echo substr($v->star_time,0,10);?>"<?php if(Yii::app()->request->getParam('time')==substr($v->star_time,0,10)||substr($v->star_time,0,10)==$t){?> selected<?php }?> gameid="<?php echo $v->game_id;?>" dataid="<?php echo $v->game_data_id;?>"><?php echo substr($v->star_time,0,10);?></option>
                        <?php }?>
                    </select>
                </label>
                <button id="onat" class="btn btn-blue" type="submit" style="margin-top:20px;float:right">查询</button>
            </form>
        <!-- </div>box-search end -->
    </div><!--box-header end-->
    <div class="box-table">
        <div class="team-operation">
        <?php foreach($arclist as $v){?>
            <?php if($v->game_mode==662){?>
                <?php $arclist[0]->id==$v->id?$fl='left':$fl='right'?>
                <div class="team" style="float:<?php echo $fl;?>">
                    <p class="name"><?php echo $v->arrange_tname; ?></p>
                    <p class="num"><?php echo floatval($v->game_score); ?></p>
                    <!-- <div class="increase">+</div>
                    <div class="decrease">-</div> -->
                    <button class="btn btn-blue increase" onclick="get_register('<?php echo $v->id;?>',1);" href="javascript:;">+</button>
                    <button class="btn btn-blue decrease" onclick="get_register('<?php echo $v->id;?>',0);" href="javascript:;" >-</button>
                </div>
            <?php } ?>
        <?php } ?>
        </div>
        <!-- <div class="game-operation">
            <?php //foreach($matches as $m1){?>
                <?php //if($m1->arrange_tcode==$m){?>
                    <div class="start">开始</div>
                    <div class="end">结束</div>
                    <div class="start_time"><?php //echo substr($m1->star_time,11,19); ?></div>
                    <div class="end_time"><?php //echo substr($m1->end_time,11,19); ?></div>
                <?php // } ?>
            <?php // } ?>
        </div> -->
    </div><!--box-table end-->
</div><!--box-content end-->
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

    $(function(){
        $("#onat").on("click",function(){
            if($('#rounds').val()==''){
                we.msg('minus','请选择阶段');
                return false;
            }
            if($('#group').val()==''){
                we.msg('minus','请选择组别');
                return false;
            }
            if($('#matches').val()==''){
                we.msg('minus','请选择场次');
                return false;
            }
        })
    })
    function onchanGetSite(obj){
        var show_id = $('#rounds option:selected').attr('v_id');
        var game_id = $('#rounds option:selected').attr('gameid');
        var data_id = $('#rounds option:selected').attr('dataid');
        var code = $(obj).val();
        var str_length=5;
        var p_html ='<option value="">请选择组别</option>';
        console.log(show_id);
        if (show_id>0) {
            $.ajax({
                type:'post',
                url:'<?php echo $this->createUrl("game_group"); ?>&game_id='+game_id+'&data_id='+data_id+'&code='+code+'&length='+str_length,
                dataType: 'json',
                success: function(data){
                    console.log(data);
                    if(data!=''){
                        for (j=0;j<data.length;j++){
                            p_html = p_html +'<option value="'+data[j]['arrange_tcode']+'" gameid="'+data[j]['game_id']+'" dataid="'+data[j]['game_data_id']+'" v_id="'+data[j]['id']+'">';
                            p_html = p_html +data[j]['arrange_tname']+'</option>';
                        }
                    }
                    $("#group").html(p_html);
                    $("#matches").html('<option value="">请选择</option>');
                    // $("#star_time").html(date);
                }
            })
        }
    }
    function onchanGetMatches(obj){
        var show_id = $('#group option:selected').attr('v_id');
        var game_id = $('#group option:selected').attr('gameid');
        var data_id = $('#group option:selected').attr('dataid');
        var code = $(obj).val();
        var str_length=7;
        var p_html ='<option value="">请选择场次</option>';
        var date ='<option value="">请选择比赛时间</option>';
        console.log(show_id);
        if (show_id>0) {
            $.ajax({
                type:'post',
                url:'<?php echo $this->createUrl("game_group"); ?>&game_id='+game_id+'&data_id='+data_id+'&code='+code+'&length='+str_length,
                dataType: 'json',
                success: function(data){
                    console.log(data);
                    if(data!=''){
                        for (j=0;j<data.length;j++){
                            p_html = p_html +'<option value="'+data[j]['arrange_tcode']+'" gameid="'+data[j]['game_id']+'" dataid="'+data[j]['game_data_id']+'" v_id="'+data[j]['id']+'">';
                            p_html = p_html +data[j]['arrange_tname']+'</option>';
                            
                            date = date +'<option value="'+data[j]['star_time']+'">';
                            date = date +data[j]['star_time'].substr(0,10)+'</option>';
                        }
                    }
                    $("#matches").html(p_html);
                    $("#time").html(date);
                }
            })
        }

    }
    
    function get_register(id,ck){
        $.ajax({
            type: 'get',
            url: '<?php echo $this->createUrl('get_register');?>&id='+id+'&ck='+ck,
            dataType: 'json',
            success: function(data) {
                console.log(data);
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                }else{
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }
</script>