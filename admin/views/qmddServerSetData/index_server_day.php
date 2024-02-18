<?php
    check_request('t_typeid',0);
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
        <h1>当前界面：动动约 》服务预订 》服务预订查询 》日服务查询</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div>
    <div class="box-header" style="height:29px;">
        <div class="box-detail-tab box-detail-tab-green" style="margin-bottom: 0;display:inline-block;border:0;">
            <ul class="c">
                <li class="current"><a href="<?php echo $this->createUrl('index_server_day'); ?>">日服务查询</a></li>
                <li><a href="<?php echo $this->createUrl('index_server_month'); ?>">月服务查询</a></li>
            </ul>
        </div><!--box-detail-tab end-->
        <div style="float:right;">
            <span class="span_style" style="background-color:#ffffff;"></span> <span style="vertical-align: middle;">未发布服务</span>
            <span class="span_style" style="background-color:#68BC54;"></span> <span style="vertical-align: middle;">正在售卖</span>
            <span class="span_style" style="background-color:#BFBFBF;"></span> <span style="vertical-align: middle;">已超时</span>
            <span class="span_style" style="background-color:#F4B084;"><b>已订</b></span> <span style="vertical-align: middle;">已被预订</span>
            <span class="span_style" style="background-color:#BFBFBF;"><b>冲突</b></span> <span style="vertical-align: middle;">资源冲突</span>
            <span class="span_style" style="background-color:#BFBFBF;"><b>关</b></span> <span style="vertical-align: middle;">关闭资源</span>
        </div>
    </div>
    <div class="box-content" style="margin:0;">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get" style="display:inline-block;">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>服务类型：</span>
                    <?php echo downList($t_typeid,'id','t_name','t_typeid','id="t_typeid" onchange="changeGetUserType(this);"'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>选择年月日：</span>
                    <input style="width:120px;" class="input-text" type="text" id="s_date" name="s_date" value="<?php echo $nowDate;?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-header end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                    <th rowspan="3" style="width:5%;"><?php echo $model->getAttributeLabel('site_name'); ?></th>
                    <th rowspan="3" style="width:5%;"><?php echo $model->getAttributeLabel('order_project_id'); ?></th>
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
                    <?php $index = 1; $now = date('Y-m-d H:i:s'); foreach($arclist as $v) {?>
                        <tr>
                            <?php
                                if(!empty($v->project_ids)){
                                    $project_list = ProjectList::model()->findAll('id in('.$v->project_ids.')');
                                    $s_sty = '';
                                    if($_REQUEST['t_typeid']==1) $s_sty = ' and site_type=if(site_type=0,0,'.$v->site_type.')';
                                    if($_REQUEST['t_typeid']==2) $s_sty = ' and s_gfid='.$v->s_gfid;
                                    $list = $model->findAll($condition.$s_sty.' and club_id='.$v->club_id.' and t_typeid='.$v->t_typeid.' and s_name="'.$v->s_name.'" and project_ids in('.$v->project_ids.')');
                                    // echo $condition.$s_sty.' and club_id='.$v->club_id.' and t_typeid='.$v->t_typeid.' and s_name="'.$v->s_name.'" and project_ids in('.$v->project_ids.')'.'<br>';
                                }
                                $project = '';
                                if(!empty($project_list))foreach($project_list as $pl){
                                    if(!empty($project)) $project .= '，';
                                    $project .= $pl->project_name;
                                }
                            ?>
                            <td><?php echo $v->s_name; ?></td>
                            <td><?php echo $project; ?></td>
                            <?php
                                $gray = '#BFBFBF';  // 灰色
                                $green = '#68BC54';  // 绿色
                                $orange = '#F4B084';  // 橙色
                                $ic = '<i class="fa fa-user" style="color: white;"></i>';
                                if(!empty($server_time))foreach($server_time as $key => $st){
                                    $color = '#fff';
                                    $cursor = '';
                                    $onclick = '';
                                    // $icon = '';
                                    $txt = '无';
                                    $tid = '';
                                    $sale_price = '';
                                    // $sttime = explode('-',$st->timename);
                                    $start_time = $st->start_time;
                                    $end_time = $st->end_time;
                                    if(!empty($list))foreach($list as $ls){
                                        $lstime = explode('-',$ls->s_timename);
                                        // $fl = 0;
                                        // $fid = 0;
                                        /* 对比服务时间的与服务时间段设置的时间 */
                                        if($lstime[0]<=$start_time && $lstime[1]>=$end_time){
                                            $tid = $ls->id;
                                            /* 判断未下架|关闭的显示 */
                                            if($ls->down==0){
                                                $txt = '';
                                                if(!empty($ls->order_gfid)){
                                                    // echo $ls->order_gfid;
                                                    $color = $orange;
                                                    // $icon = '';
                                                    $cursor = 'cursor: pointer';
                                                    $onclick = 'onclick="clickDetails('.$ls->id.',this);"';
                                                    $sale_price = '已订';
                                                }
                                                else{
                                                    $sale_price = '';//<span class="t_text">￥'.$v->sale_price.'</span>
                                                    if($now<$ls->s_timeend){
                                                        $color = $green;
                                                        $txt = '<input class="tid tid_'.$ls->id.'" type="hidden" value="'.$ls->id.'"><input type="hidden" class="t_span" value="'.$tid.'">';
                                                    }
                                                    else{
                                                        $color = $gray;
                                                    }
                                                }
                                                /* 如果是场地，并且有相同时间被预定的场地时 例：全场、半场、单场
                                                    全场被预定了，单场与半场不能被预定（显示冲突图标$ic）
                                                    单场或半场被预定了，全场不能被预定（显示冲突图标$ic）
                                                */
                                                // if($ls->t_typeid==1){
                                                //     $sou = QmddServerSourcer::model()->find('id='.$ls->server_sourcer_id);
                                                //     $sql = ' and s_date="'.$ls->s_date.'"'.' and s_timename="'.$ls->s_timename.'" and order_gfid>0';
                                                //     if(!empty($sou)){
                                                //         $sou_parent = !empty($sou->site_parent) ? $sou->site_parent : $sou->s_name_id;
                                                //         if($sou_parent!=''){
                                                //             $sou1 = QmddServerSourcer::model()->findAll('t_typeid=1 and (s_name_id in ('.$sou_parent.') or find_in_set('.$sou_parent.',site_parent))');
                                                //             // $sou2 = QmddServerSourcer::model()->findAll('t_typeid=1 and find_in_set('.$sou->site_parent.',site_parent)');
                                                //             if(!empty($sou1))foreach($sou1 as $s1){
                                                //                 $sd1 = QmddServerSetData::model()->find('server_sourcer_id='.$s1->id.$sql);
                                                //                 if(!empty($sd1)){
                                                //                     $fl++;
                                                //                     $fid = $sd1->id;
                                                //                 }
                                                //             }
                                                //             // if(!empty($sou2))foreach($sou2 as $s2){
                                                //             //     $sd2 = QmddServerSetData::model()->find('server_sourcer_id='.$s2->id.$sql);
                                                //             //     if(!empty($sd2)) $fl++;
                                                //             // }
                                                //         }
                                                //     }
                                                // }
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
                                            // $icon = '';
                                            $sale_price = '冲突';
                                        }
                                    }
                                    echo '<td style="background-color:'.$color.';'.$cursor.'" id="'.$tid.'" class="tid_'.$tid.'" '.$onclick.'>'.$sale_price.$txt.'</td>';
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
        $('#s_date').on('click',function(){
            WdatePicker({dateFmt:"yyyy-MM-dd"});
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