<?php
    check_request('t_typeid',0);
    check_request('t_stypeid',0);
?>
<style>
    .box-table .list tr th,.box-table .list tr td{
        text-align:center;
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
    .list td{
        /* text-align:center; */
        cursor: pointer;
    }
    .not_pointer{
        cursor: default!important;
    }
    .fa-check{
        font-size: 16px;
        float: right;
        position: relative;
    }
</style>
<div class="box">
    <div class="box-title c" style="position: relative;">
        <h1>当前界面：动动约 》服务安排 》日服务安排表</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
        <br><br>
        <small>可查询各服务类型中的所有服务资源每日安排情况</small>
    </div>
    <div class="box-header">
        <a href="javascript:;" class="btn btn-blue" onclick="clickServer(0);">开启服务</a>
        <a href="javascript:;" class="btn btn-blue" onclick="clickServer(1);">关闭服务</a>
        <div style="float:right;">
            <span class="span_style" style="background-color:#ffffff;"></span> <span style="vertical-align: middle;">未发布服务</span>
            <span class="span_style" style="background-color:#68BC54;">￥100</span> <span style="vertical-align: middle;">正在售卖</span>
            <span class="span_style" style="background-color:#BFBFBF;">￥100</span> <span style="vertical-align: middle;">已超时</span>
            <span class="span_style" style="background-color:#F4B084;"><!--<i class="fa fa-user" style="color: white;"></i>-->已订</span> <span style="vertical-align: middle;">已被预订</span>
            <?php if($_REQUEST['t_typeid']==1) {?>
            <span class="span_style" style="background-color:#BFBFBF;"><!--<i class="fa fa-user" style="color: white;"></i>-->冲突</span> <span style="vertical-align: middle;">资源冲突</span>
            <?php }?>
            <span class="span_style" style="background-color:#BFBFBF;">关</span> <span style="vertical-align: middle;">关闭资源</span>
        </div>
    </div>
    <div class="box-content" style="margin:0;">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get" style="display:inline-block;">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>服务日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="s_date" name="s_date" value="<?php echo $nowDate;?>">
                </label>
                <label style="margin-right:20px;">
                    <span>服务类型：</span>
                    <?php echo downList($t_typeid,'id','t_name','t_typeid','id="t_typeid" onchange="changeGetUserType(this);"'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>服务类别：</span>
                    <select name="t_stypeid" id="t_stypeid">
                        <option value="">请选择</option>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>服务项目：</span>
                    <?php echo downList($project_list,'project_id','project_name','project_id'); ?>
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-header end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <?php
                            if($_REQUEST['t_typeid']==1) {
                                echo '<th rowspan="3" style="width:5%;">'.$model->getAttributeLabel('site_name').'</th>';
                                echo '<th rowspan="3" style="width:5%;">'.$model->getAttributeLabel('order_project_id').'</th>';
                                echo '<th rowspan="3" style="width:5%;">'.$model->getAttributeLabel('site_type').'</th>';
                            }
                            elseif($_REQUEST['t_typeid']==2){
                                echo '<th rowspan="3" style="width:5%;">'.$model->getAttributeLabel('s_gfname').'</th>';
                                echo '<th rowspan="3" style="width:5%;">'.$model->getAttributeLabel('order_project_id').'</th>';
                            }
                            elseif($_REQUEST['t_typeid']==3){
                                echo '<th rowspan="3" style="width:5%;">'.$model->getAttributeLabel('order_project_id').'</th>';
                                echo '<th rowspan="3" style="width:5%;">'.$model->getAttributeLabel('about_type').'</th>';
                                if($_REQUEST['t_stypeid']==15){
                                    echo '<th rowspan="3" style="width:5%;">'.$model->getAttributeLabel('server_feferee').'</th>';
                                }
                                else{
                                    echo '<th rowspan="3" style="width:5%;">'.$model->getAttributeLabel('server_site').'</th>';
                                }
                            }
                            else{
                                echo '<th rowspan="3" style="width:5%;">'.$model->getAttributeLabel('site_name').'</th>';
                                echo '<th rowspan="3" style="width:5%;">'.$model->getAttributeLabel('order_project_id').'</th>';
                            }
                        ?>
                    </tr>
                    <tr>
                        <?php
                            $server_time = QmddServerTime::model()->findAll('state=372 order by timename');
                            if(!empty($server_time))foreach($server_time as $st){
                                echo '<th>'.$st->start_time.'</th>';
                            }
                        ?>
                    </tr>
                    <tr>
                        <?php
                            if(!empty($server_time))foreach($server_time as $st){
                                echo '<th>'.$st->end_time.'</th>';
                            }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $index = 1;
                        $gray = '#BFBFBF';  // 灰色
                        $green = '#68BC54';  // 绿色
                        $orange = '#F4B084';  // 橙色
                        $now = date('Y-m-d H:i:s');
                        $ic = '<i class="fa fa-user" style="color: white;"></i>';
                        foreach($arclist as $v) {
                    ?>
                        <tr>
                            <?php
                                if(!empty($v->project_ids)){
                                    $project_list = ProjectList::model()->findAll('id in('.$v->project_ids.')');
                                    $s_sty = '';
                                    if($_REQUEST['t_typeid']==1) $s_sty = ' and site_type=ifnull(site_type,0)';
                                    if($_REQUEST['t_typeid']==2) $s_sty = ' and s_gfid='.$v->s_gfid;
                                    $list = $model->findAll($condition.$s_sty.' and s_name="'.$v->s_name.'" and club_id='.$v->club_id.' and t_typeid='.$v->t_typeid.' and t_typeid='.$v->t_typeid.' and project_ids in('.$v->project_ids.')');
                                    // echo $condition.$s_sty.' and s_name="'.$v->s_name.'" and club_id='.$v->club_id.' and t_typeid='.$v->t_typeid.' and t_typeid='.$v->t_typeid.' and project_ids in('.$v->project_ids.')'.'<br>';
                                }
                                $project = '';
                                if(!empty($project_list))foreach($project_list as $pl){
                                    if(!empty($project)) $project .= '，';
                                    $project .= $pl->project_name;
                                }
                                if($_REQUEST['t_typeid']==1) {
                                    $type = (!empty($v->site_type) && !empty($v->base_site_type)) ? $v->base_site_type->F_NAME : '';
                                    $sname = (!empty($v->server_sourcer_list)) ? $v->server_sourcer_list->s_name : '';
                                    echo '<td class="not_pointer">'.$sname.'</td>';
                                    echo '<td class="not_pointer">'.$project.'</td>';
                                    echo '<td class="not_pointer">'.$type.'</td>';
                                }
                                elseif($_REQUEST['t_typeid']==2){
                                    echo '<td class="not_pointer">'.$v->s_gfname.'</td>';
                                    echo '<td class="not_pointer">'.$project.'</td>';
                                }
                                elseif($_REQUEST['t_typeid']==3){
                                    echo '<td class="not_pointer">'.$project.'</td>';
                                    echo '<td class="not_pointer">'.$v->s_name.'</td>';
                                    if($_REQUEST['t_stypeid']==15){
                                        echo '<td class="not_pointer">'.$v->s_name.'</td>';
                                    }
                                    else{
                                        echo '<td class="not_pointer">'.$v->s_gfname.'</td>';
                                    }
                                }
                                else{
                                    echo '<td class="not_pointer">'.$v->s_name.'</td>';
                                    echo '<td class="not_pointer">'.$project.'</td>';
                                }
                            ?>
                            <?php
                                if(!empty($server_time))foreach($server_time as $st){
                                    $color = '#fff';
                                    $image = '';
                                    $txt = '无';
                                    $tid = '';
                                    $sale_price = '';
                                    $start_time = $st->start_time;
                                    $end_time = $st->end_time;
                                    /* 服务类型=场地 */
                                    if(!empty($list))foreach($list as $ls){
                                        $lstime = explode('-',$ls->s_timename);
                                        /* 对比服务时间的与服务时间段设置的时间 */
                                        if($lstime[0]<=$start_time && $lstime[1]>=$end_time){
                                            $tid = $ls->id.$v->site_type;
                                            /* 判断未下架|关闭的显示 */
                                            if($ls->down==0){
                                                $txt = '';
                                                if(!empty($ls->order_gfid)){
                                                    $color = $orange;
                                                    $sale_price = '已订';
                                                }
                                                else{
                                                    $sale_price = '<span class="t_text">￥'.$v->sale_price.'</span>';
                                                    if($now<$ls->s_timeend){
                                                        $color = $green;
                                                        $txt = '<input class="tid tid_'.$ls->id.'" type="hidden" value="'.$ls->id.'"><input type="hidden" class="t_span" value="'.$tid.'">';
                                                    }
                                                    else{
                                                        $color = $gray;
                                                    }
                                                }
                                            }
                                            /* 已关闭|下架的时间段 */
                                            else{
                                                $color = $gray;
                                                $sale_price = '<span class="t_text">关</span>';
                                                $txt = '<input class="tid" type="hidden" value="'.$ls->id.'"><input type="hidden" class="t_span" value="'.$tid.'">';
                                            }
                                        }
                                        if($ls->is_conflict==1){
                                            $color = $gray;
                                            $sale_price = '冲突';
                                        }
                                    }
                                    echo '<td style="background-color:'.$color.';" class="tid_'.$tid.'">'.$sale_price.$txt.'</td>';
                                }
                            ?>
                        </tr>
                    <?php $index++; }?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    $(function(){
        var $star_time=$('#s_date');
        $star_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
        changeGetUserType($('#t_typeid'));
    });

    function changeGetUserType(op){
        var type_id = $(op).val();
        if(type_id>0){
            $.ajax({
                type: 'get',
                url: '<?php echo $this->createUrl('getUserType'); ?>&type_id='+type_id,
                dataType: 'json',
                success: function(data){
                    // console.log(data);
                    var html = '<option value="">请选择</option>';
                    var sed = <?php echo $_REQUEST['t_stypeid']; ?>;
                    if(data!=''){
                        for(var i=0;i<data.length;i++){
                            html += '<option value="'+data[i]["id"]+'"';
                            if(data[i]["id"]==sed){
                                html += 'selected';
                            }
                            html += '>'+data[i]['f_uname']+'</option>';
                        }
                    }
                    $('#t_stypeid').html(html);
                }
            })
        }
    }

    $('.list td').on('click',function(){
        var len = $(this).find('.fa-check').length;
        var txt = $(this).find('.t_text').text();
        var tid = $(this).find('.tid').length;
        var t_span = $(this).find('.t_span').val();
        var bgcolor = $(this).css('background-color');
        // #BFBFBF=灰色，rgb(191, 191, 191)=灰色
        // #F4B084=橙色，rgb(244, 176, 132)=橙色
        console.log(txt,bgcolor,t_span,tid,len);
        if(txt=='≠' || (bgcolor!='#BFBFBF' && bgcolor!='rgb(191, 191, 191)' && bgcolor!='#F4B084' && bgcolor!='rgb(244, 176, 132)')){
            if(tid==1 && len==0){
                $('.tid_'+t_span).css({'width':$(this).width(),'height':$(this).height()});
                $('.tid_'+t_span).append('<i class="fa fa-check"></i>');
            }
            else{
                $('.tid_'+t_span).find('.fa-check').remove();
            }
        }
    })

    function clickServer(n){
        var mes = n==0 ? '开启' : '关闭';
        var a = confirm('是否'+mes);
        if(a){
            var str = '';
            $('.list td').each(function(){
                if($(this).find('.fa-check').length>0){
                    str += $(this).find('.tid').val() + ',';
                }
            })
            if (str.length>0) {
                str = str.substring(0,str.length-1);
            }
            else{
                alert('请先选择要【'+mes+'】的时间段');
                return false;
            }
            var str1 = split_str(str);
            save_server_detail(str1,n);
        }
    }

    // 去除重复
    function split_str(str){
        var strArr = str.split(',');
        strArr.sort();//排序
        var result = new Array();
        var tempStr = "";
        for(var i in strArr){
            if(strArr[i] != tempStr){
                result.push(strArr[i]);
                tempStr=strArr[i];
            }
        }
        return result.join(',');
    }

    function save_server_detail(str,n){
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('save_server_detail'); ?>&id='+str+'&down='+n,
            dataType: 'json',
            success: function(data){
                // console.log(data);
                if(data.status==1){
                    we.success(data.msg,data.redirect);
                }
                else{
                    we.msg('minus',data.msg);
                }
            },
            error: function(request){
                console.log(request);
            }
        })
    }
</script>