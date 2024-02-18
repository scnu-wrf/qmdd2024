<?php
    check_request('t_typeid',0);
    check_request('t_stypeid',0);
?>
<style>
    .span_style{
        display: inline-block;
        text-align: center;
        width: 80px;
        height: 25px;
        border:1px solid #000000;
        line-height: 1.8;
        font-size: 16px;
        vertical-align: middle;
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
        <div style="float:right;">
            <span class="span_style" style="background-color:#68BC54;"></span> <span style="vertical-align: middle;">正在售卖</span>
            <span class="span_style" style="background-color:#BFBFBF;"></span> <span style="vertical-align: middle;">已超时未被预订</span>
            <span class="span_style" style="background-color:#F4B084;"><i class="fa fa-user" style="color: white;"></i></span> <span style="vertical-align: middle;">已被预订</span>
            <span class="span_style" style="background-color:#BFBFBF;"><i class="fa fa-user" style="color: white;"></i></span> <span style="vertical-align: middle;">同资源同时段预订冲突关闭</span>
            <span class="span_style" style="background-color:#BFBFBF;">≠</span> <span style="vertical-align: middle;">单位关闭</span>
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
                                $project_list = ProjectList::model()->findAll('id in('.$v->project_ids.')');
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
                                $s_sty = '';
                                if($_REQUEST['t_typeid']==1) $s_sty = ' and site_type=if(site_type=0,0,'.$v->site_type.')';
                                if($_REQUEST['t_typeid']==2) $s_sty = ' and s_gfid='.$v->s_gfid;
                                $list = $model->findAll($condition.$s_sty.' and club_id='.$v->club_id.' and t_typeid='.$v->t_typeid.' and s_name="'.$v->s_name.'" and project_ids in('.$v->project_ids.')');
                                // echo $condition.$s_sty.' and club_id='.$v->club_id.' and t_typeid='.$v->t_typeid.' and s_name="'.$v->s_name.'" and project_ids in('.$v->project_ids.')'.'<br>';
                                if(!empty($server_time))foreach($server_time as $key => $st){
                                    $color = $gray;
                                    $image = '';
                                    $icon = '';
                                    $txt = '';
                                    $tid = '';
                                    $sale_price = '';
                                    $sttime = explode('-',$st->timename);
                                    if(!empty($list))foreach($list as $ls){
                                        $lstime = explode('-',$ls->s_timename);
                                        /* 对比服务时间的与服务时间段设置的时间 */
                                        if($lstime[0]<=$sttime[0] && $lstime[1]>=$sttime[1]){
                                            $tid = $ls->id;
                                            /* 判断未下架|关闭的显示 */
                                            if($ls->down==0){
                                                /* 判断服务的开始时间小于当前时间并且服务关闭时间大于等于当前时间 */
                                                // echo $now.'***'.$ls->s_timestar.'***'.$ls->s_timeend.'<br>';
                                                if(($now>=$ls->s_timestar && $now<=$ls->s_timeend) || $now<=$ls->s_timeend){
                                                    /* 如果没有gfid那就是未预约 */
                                                    if(empty($ls->order_gfid)){
                                                        $color = $green;
                                                        $txt = '<input class="tid tid_'.$ls->id.'" type="hidden" value="'.$ls->id.'"><input type="hidden" class="t_span" value="'.$tid.'">';
                                                    }
                                                    else{
                                                        $color = $orange;
                                                        $icon = '';
                                                        $sale_price = $ls->gf_order_gfid->ZSXM;
                                                    }
                                                    $sourid = $ls->server_sourcer_id;
                                                    if(count($sourid)>1){
                                                        $day_list = QmddServerSetData::model()->find('find_in_set('.$sid.',server_sourcer_id) and s_date="'.$ls->s_date.'" and s_timename="'.$ls->s_timename.'" and id<>'.$ls->id);
                                                        if(!empty($day_list)){
                                                            // echo 'find_in_set('.$sid.',server_sourcer_id) and s_date="'.$ls->s_date.'" and s_timename="'.$ls->s_timename.'" and id<>'.$ls->id;
                                                            // echo $day_list->id;
                                                            $color = $gray;
                                                            $icon = $ic;
                                                            $sale_price = '';
                                                        }
                                                    }
                                                }
                                                else{
                                                    /* 如果不在服务时间内，并且被预约的显示已预约图标 */
                                                    if(!empty($ls->order_gfid)){
                                                        $color = $orange;
                                                        $icon = '';
                                                        $sale_price = $ls->gf_order_gfid->ZSXM;
                                                    }
                                                    else{
                                                        $color = $gray;
                                                    }
                                                }
                                            }
                                            /* 已关闭|下架的时间段 */
                                            else{
                                                $color = $gray;
                                                $sale_price = '<span class="t_text">≠</span>';
                                                $txt = '<input class="tid" type="hidden" value="'.$ls->id.'"><input type="hidden" class="t_span" value="'.$tid.'">';
                                            }
                                        }
                                        /* 未被预约|时间过期 */
                                        if($color!=$green && $color!=$orange){
                                            $color = $gray;
                                        }
                                    }
                                    echo '<td style="background-color:'.$color.';" class="tid_'.$tid.'">'.$icon.$sale_price.$txt.'</td>';
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
        })
    })
</script>