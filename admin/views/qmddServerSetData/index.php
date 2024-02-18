
<?php 
    $myDate=$nowDate;
    $seDate=substr($myDate,5,9);
    $c1=($seDate<10?substr($seDate,1,2):$seDate);
    // if($myDate==''){
    //     $c1=date('m');
    // }
    $days = cal_days_in_month(CAL_GREGORIAN, $c1, date('Y'));
    $key_name = QmddServerSetData::model()->find('s_name like "%' . $keywords . '%" OR order_name like "%' . $keywords . '%"');
    if(empty($key_name)){
        if($keywords!='AAA')
            echo "<script>$(document).ready(function(){we.msg('minus','无服务');});</script>";
    }
?>
<style>
    table{
        border-collapse:collapse;
    }
    td[class=first]{
        text-align: center!important;
        border: 1px solid #000000!important;
        width: 110px!important;
        height: 50px!important;
        position: relative!important;
        padding: 0!important;
    }
    td[class=first]:before{
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
    td[class=first] p:nth-child(1){
        width: 2.2em;
        position: absolute;
        top: 18%;
        right: 14%;
    }
    td[class=first] p:nth-child(2){
        width: 30px;
        position: absolute;
        bottom: 18%;
        left: 14%;
    }
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
</style>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约 》服务安排 》月服务安排</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();" style="float:right;"><i class="fa fa-refresh"></i>刷新</a>
        </span>
        <br><br>
        <!-- <small>仅供查询单个服务资源的每月安排情况</small> -->
        <div style="float:right;padding-right:15px;">
            <span class="span_style" style="background-color:#ffffff;"></span> <span style="vertical-align: middle;">未发布服务</span>
            <span class="span_style" style="background-color:#68BC54;"></span> <span style="vertical-align: middle;">正在售卖</span>
            <span class="span_style" style="background-color:#BFBFBF;"></span> <span style="vertical-align: middle;">已超时</span>
            <span class="span_style" style="background-color:#F4B084;"><b>已订</b></span> <span style="vertical-align: middle;">已被预订</span>
            <span class="span_style" style="background-color:#BFBFBF;"><b>关</b></span> <span style="vertical-align: middle;">关闭资源</span>
        </div>
    </div>
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get" style="display:inline-block;">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="news_type" value="<?php echo Yii::app()->request->getParam('news_type');?>">
                <label style="margin-right:10px;width:150px;">
                    <span>服务类型：</span>
                    <select id="project" name="project" style="border:1px solid #000000;max-width:100px;vertical-align: middle;">
                        <option value="">请选择</option>
                        <?php foreach($project_list as $v){?>
                        <option value="<?php echo $v->id;?>"<?php if((Yii::app()->request->getParam('project')!=null && Yii::app()->request->getParam('project')==$v->id)||$v->id==$s_type){?> selected<?php }?>><?php echo $v->t_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:10px">
                    <span>服务标题：</span>
                    <input type="text" style="width:100px;border:1px solid #000000;vertical-align: middle;" class="input-text" id="keywords" name="keywords" value="<?php echo $keywords;?>" placeholder="请输入资源名称">
                </label>
                <label style="margin-right:10px;">
                    <span>选择年月：</span>
                    <input style="width:100px;border:1px solid #000000;vertical-align: middle;" class="input-text" type="text" id="s_date" name="s_date" value="<?php echo $myDate;?>">
                </label>
                <button id="onat" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list" style="border:1px solid #000000;">
                <?php $index = 1;?>
                <tr>
                    <td class="first"><div><p>日期</p><p>时间</p></div></td>
                    <?php for($d=1;$d<=$days;$d++){ $d1=$d < 10 ? '0'.$d: $d;?>
                        <td style="text-align: center;border:1px solid #000000;" value="<?php echo $myDate==''?date('Y-m').'-'.$d1:$myDate.'-'.$d1 ?>"><?php echo $d;?></td>
                    <?php }?>
                </tr>
                <?php
                    $time=QmddServerTime::model()->findAll('timename order by timename ASC');
                    $now = date('Y-m');
                    $now2 = date('Y-m-d H:i:s');
                    if(!empty($time)) foreach($time as $h){
                        // $time_arr = explode('-', $h->timename);
                        $start_time = $h->start_time;
                        $end_time = $h->end_time;
                ?>
                <tr>
                    <td style="text-align: center;border:1px solid #000000;"><?php echo $h->timename;?></td>
                    <?php for($d=1;$d<=$days;$d++){
                        $d1=$d < 10 ? '0'.$d: $d; 
                        $td_col = '#fff';
                        $text='';
                        // $ic = '<i class="fa fa-user" style="color: white;"></i>';
                        $m1 = $myDate=='' ? $now.'-'.$d1 : $myDate.'-'.$d1;
                        if (!empty($arclist)) foreach ($arclist as $v1) {
                            $s_time_arr = explode('-', $v1->s_timename);
                            $Hour_start = $s_time_arr[0];
                            $Hour_end = $s_time_arr[1];
                            if($v1->s_date==$m1 && $Hour_start<=$start_time && $Hour_end>=$end_time){
                                if($v1->down==1){
                                    $text = '关';
                                    $td_col = '#BFBFBF';
                                }
                                else{
                                    if(!empty($v1->order_gfid)){
                                        $td_col = '#F4B084';
                                        $text = '已订';
                                    }
                                    else{
                                        $text = '￥'.$v1->sale_price;
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
                        // $width = (100 - 5) / $days;width: '.$width.'%;
                        echo '<td style="text-align: center;border:1px solid #000000;background-color:'.$td_col.';">'.$text.'</td>';
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
        var $star_time=$('#s_date');
        $star_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM'});
        });
    });
    $("#onat").on("click",function(){
        var keywords=$("#keywords").val();
        var project=$("#project").val();
        // var s_date=$("#s_date").val();
        if(project==''){
            we.msg('minus','请选择服务类型');
            return false;
        }
        if(keywords==''){
            we.msg('minus','请输入服务名称');
            return false;
        }
        // if(s_date==''){
        //     we.msg('minus','请选择年月');
        //     return false;
        // }
    })

    // 添加分类, array('fid'=>216)
    var $keywords=$('#keywords');
    $keywords.on('click', function(){
        var t_typeid=$('#project').val();
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
                    $keywords.val($.dialog.data('text'));
                }
            }
        });
    });
    
</script>
