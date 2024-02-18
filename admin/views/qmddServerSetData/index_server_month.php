<?php
    check_request('t_typeid',0);
    $myDate = $nowDate;
    $seDate = substr($myDate,5,9);
    $c1 = ($seDate<10?substr($seDate,1,2):$seDate);
    $days = cal_days_in_month(CAL_GREGORIAN, $c1, date('Y'));
?>
<style>
    .span_style{
        display: inline-block;
        text-align: center;
        width: 80px;
        height: 25px;
        border:1px solid #000000;
        line-height: 2;
        font-size: 13px;
        vertical-align: middle;
    }
    table{
        border-collapse:collapse;
    }
    th[class=first]{
        text-align: center!important;
        border: 1px solid #000000!important;
        width: 110px!important;
        height: 50px!important;
        position: relative!important;
        padding: 0!important;
    }
    th[class=first]:before{
        content: "";
        position: absolute;
        width: 1px;
        height: 121px;
        top: 0;
        left: -2px;
        border-right: 1px solid #000000;
        transform: rotate(-66deg);
        transform-origin: top;
    }
    th[class=first] p:nth-child(1){
        width: 2.2em;
        position: absolute;
        top: 18%;
        right: 14%;
    }
    th[class=first] p:nth-child(2){
        width: 30px;
        position: absolute;
        bottom: 18%;
        left: 14%;
    }
    .t2{
        position: absolute;
        border-top: 10px solid #fff;
        border-right: 10px solid transparent;
        border-left: 10px solid transparent;
        top: 140px;
        left: 24px;
    }
    .tip2{
        display: black;
        position: absolute;
        left: -45px;
        top: -164px;
        font-size: 12px;
        line-height: 20px;
        padding: 10px;
        border: solid 1px #ccc;
        border-radius: 10px;
        background-color: #fff;
    }
    .op_remove{
        display: inline;
    }
    .span_tip{
        margin-left: 0;
    }
</style>
<div class="box">
    <div class="box-title c" style="position: relative;">
        <h1>当前界面：动动约 》服务预订 》服务预订查询 》月服务查询</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div>
    <div class="box-header" style="height:29px;">
        <div class="box-detail-tab box-detail-tab-green" style="margin-bottom: 0;display:inline-block;border:0;">
            <ul class="c">
                <li><a href="<?php echo $this->createUrl('index_server_day'); ?>">日服务查询</a></li>
                <li class="current"><a href="<?php echo $this->createUrl('index_server_month'); ?>">月服务查询</a></li>
            </ul>
        </div><!--box-detail-tab end-->
        <div style="float:right;">
            <span class="span_style" style="background-color:#ffffff;"></span> <span style="vertical-align: middle;">未发布服务</span>
            <span class="span_style" style="background-color:#68BC54;"></span> <span style="vertical-align: middle;">正在售卖</span>
            <span class="span_style" style="background-color:#BFBFBF;"></span> <span style="vertical-align: middle;">已超时</span>
            <span class="span_style" style="background-color:#F4B084;"><b>已订</b></span> <span style="vertical-align: middle;">已被预订</span>
            <span class="span_style" style="background-color:#BFBFBF;"><b>关</b></span> <span style="vertical-align: middle;">关闭资源</span>
        </div>
    </div>
    <div class="box-content" style="margin:0;">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get" style="display:inline-block;">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>服务类型：</span>
                    <?php //echo downList($type_list,'id','t_name','t_typeid','id="t_typeid" onchange="changeGetUserType(this);"'); ?>
                    <select id="t_typeid" name="t_typeid" style="vertical-align: middle;" onchange="changeGetUserType(this);">
                        <option value="">请选择</option>
                            <?php foreach($type_list as $tl){?>
                                <option value="<?php echo $tl->id;?>" <?php if($tl->id==$t_typeid) echo 'selected'; ?>><?php echo $tl->t_name;?></option>
                            <?php }?>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>服务资源：</span>
                    <input style="width:150px;" type="text" class="input-text" id="s_name" name="s_name" value="<?php echo $s_name; ?>" placeholder="请选择查询资源名称">
                </label>
                <label style="margin-right:10px;">
                    <span>选择年月日：</span>
                    <input style="width:120px;" class="input-text" type="text" id="s_date" name="s_date" value="<?php echo $nowDate;?>">
                </label>
                <button id="submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-header end-->
        <div class="box-table">
            <table class="list" style="border:1px solid #000000;">
                <tr>
                    <th class="first"><div><p>日期</p><p>时间</p></div></th>
                    <?php for($d=1;$d<=$days;$d++){ $d1=$d < 10 ? '0'.$d: $d;?>
                        <td style="text-align: center;border:1px solid #000000;" value="<?php echo $myDate==''?date('Y-m').'-'.$d1:$myDate.'-'.$d1 ?>"><?php echo $d;?></td>
                    <?php }?>
                </tr>
                <?php
                    $time = QmddServerTime::model()->findAll('timename order by timename ASC');
                    $now = date('Y-m');
                    $now2 = date('Y-m-d H:i:s');
                    if(!empty($time)) foreach($time as $h){
                        $time_arr = explode('-', $h->timename);
                        $start_time = $h->start_time;
                        $end_time = $h->end_time;
                ?>
                <tr>
                    <td style="text-align: center;border:1px solid #000000;"><?php echo $h->timename;?></td>
                    <?php for($d=1;$d<=$days;$d++){
                        $d1 = $d < 10 ? '0'.$d: $d; 
                        $td_col = '#fff';
                        $text = '';
                        $cursor = '';
                        $onclick = '';
                        $tid = '';
                        // $ic = '<i class="fa fa-user" style="color: white;"></i>';
                        $m1 = $myDate=='' ? date('Y-m').'-'.$d1 : $myDate.'-'.$d1;
                        if (!empty($arclist)) foreach ($arclist as $v1) {
                            $s_time_arr = explode('-', $v1->s_timename);
                            $Hour_start = $s_time_arr[0];
                            $Hour_end = $s_time_arr[1];
                            if($v1->s_date==$m1 && $Hour_start<=$start_time && $Hour_end>=$end_time){
                                $tid = $v1->id;
                                if($v1->down==1){
                                    $text = '关';
                                    $td_col = '#BFBFBF';
                                }
                                else{
                                    if(!empty($v1->order_gfid)){
                                        $td_col = '#F4B084';
                                        $text = '已订';
                                        $cursor = 'cursor: pointer';
                                        $onclick = 'onclick="clickDetails(\''.$v1->id.'\',this);"';
                                    }
                                    else{
                                        $text = '';
                                        if($now2<$v1->s_timeend){
                                            $td_col = '#68BC54';
                                        }
                                        else{
                                            $td_col = '#BFBFBF';
                                        }
                                    }
                                }
                            }
                        }
                        echo '<td id="'.$tid.'" style="text-align: center;border:1px solid #000000;background-color:'.$td_col.';'.$cursor.'" '.$onclick.'>'.$text.'</td>';
                    }?>
                    </tr>
                <?php } ?>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    $(function(){
        $('#s_date').on('click',function(){
            WdatePicker({dateFmt:"yyyy-MM"});
        })
    })

    $("#submit").on("click",function(){
        var t_typeid = $("#t_typeid").val();
        var s_name = $("#s_name").val();
        if(t_typeid==''){
            we.msg('minus','请选择服务类型');
            return false;
        }
        if(s_name==''){
            we.msg('minus','请选择服务名称');
            return false;
        }
    })

    $('#s_name').on('click',function(){
        var t_typeid = $('#t_typeid').val();
        if(t_typeid<1){
            we.msg('minus','请选择服务类型');
            return false;
        }
        $.dialog.data('id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/servername",array('club_id'=>get_session('club_id')));?>&t_typeid='+t_typeid,{
            // 'server_type'=>
            id:'xiangmu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('id')>0){
                    $('#s_name').val($.dialog.data('text'));
                }
            }
        });
    })

    $('body').on('click',function(){
        clear_class();
    })

    function clear_class(){
        $('.op_remove').remove();
    }

    var list_width = $('.list').width();
    // console.log(list_width);
    function clickDetails(id,op){
        // console.log(id,op);
        var c_top = document.getElementById(id).offsetTop;
        var c_left = document.getElementById(id).offsetLeft;
        var offset = $(op).height();
        var s_tip_top = '';
        var s_tip_top2 = '';
        var s_tip_left = '';
        var s_t2_border_top = '';
        var s_t2_top = '';
        var s_t2_left = '';
        if(c_top<230){
            s_tip_top = 'top:33px;';
            s_t2_border_top = 'border-top:0;border-bottom:10px solid #fff;';
            s_t2_top = 'top:-10px;';
        }
        if(offset<=20 && c_top<230){
            s_tip_top = 'top:33px;';
        }
        if(offset>=36 && c_top<230){
            s_tip_top = 'top:42px;';
        }
        if(offset>=54 && c_top<230){
            s_tip_top = 'top:51px;';
            s_t2_border_top = 'border-top:0;border-bottom:10px solid #fff;';
            s_t2_top = 'top:-10px;';
        }
        if(offset<=20 && c_top>230){
            s_tip_top = 'top:-155px;';
        }
        if(offset>=54 && c_top>230){
            s_tip_top2 = 'top:-174px;';
        }
        if(offset>=72 && c_top>230){
            s_tip_top2 = 'top:-183px;';
        }
        // console.log(list_width,c_left,offset,c_top);
        if(list_width-c_left<350){
            s_tip_left = 'left: -358px;';
            s_t2_left = 'left: 338px;';
        }

        // console.log(c_top,c_left,offset);
        $.ajax({
            type: 'get',
            url: '<?php echo $this->createUrl('getDetails'); ?>&id='+id,
            dataType: 'json',
            success: function(data){
                // console.log(data);
                var html = '';
                if(data!=''){
                    html = 
                        '<div class="op_remove">'+
                            '<span class="span_tip">'+
                                '<div class="tip2" style="width:350px;'+s_tip_top+s_tip_left+s_tip_top2+'">'+
                                    '<p><span style="float:left;width:65px;">服务资源：</span><span>'+data['s_name']+'</span></p>'+
                                    '<p><span style="float:left;width:65px;">项&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;目：</span><span>'+data['order_project_name']+'</span></p>'+
                                    '<p><span style="float:left;width:65px;">时&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;段：</span><span>'+data['s_timename']+'</span></p>'+
                                    '<p><span style="float:left;width:65px;">订&nbsp;&nbsp;单&nbsp;&nbsp;号：</span><span>'+data['order_num']+'</span></p>'+
                                    '<p><span style="float:left;width:65px;">服务流水：</span><span>'+data['info_order_num']+'</span></p>'+
                                    '<p><span style="float:left;width:65px;">预&nbsp;&nbsp;定&nbsp;&nbsp;人：</span><span>'+data['order_account']+'/'+data['order_name']+'</span></p>'+
                                    '<i class="t2" style="'+s_t2_border_top+s_t2_top+s_t2_left+'"></i>'+
                                '</div>'+
                            '</span>'+
                        '</div>';
                    $(op).append(html);
                }
            },
            error: function(request){

            }
        })
    }
</script>