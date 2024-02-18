<?php
    check_request('game_id',0);
    check_request('data_id',0);
    if(!isset($_REQUEST['arrange_tcode'])){
        $_REQUEST['arrange_tcode'] = '';
    }
    $data1 = GameListData::model()->find('id='.$_REQUEST['data_id']);
    $data_title = '姓名';
    if(!empty($data1) && $data1->game_player_team!=665){
        $data_title = '团队名称';
    }
?>
<style>
    .box-table .list tr th,.box-table .list tr td{ text-align: center; }
    .list .input-text{ text-align: center; }
    .list tr:hover td { background: none!important; }
</style>
<div class="box" style="margin: 0px 10px 10px 0;">
    <div class="gamesign c">
        <div class="box-title c" style="width: 99%;position: fixed;background-color: #F2F2F2;z-index: 99;">
            <h1>当前界面：赛事/排名 》赛事成绩 》赛事名次录入</h1>
            <span style="float:right;margin-right:15px;">
                <a class="btn" href="javascript:;" onclick="we.reload();" style="vertical-align: bottom;margin-left:20px;"><i class="fa fa-refresh"></i>刷新</a>
            </span>
        </div><!--box-title end-->
        <div class="box-search" style="margin-top: 43px;width: 99%;z-index: 99;position: fixed;">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="data_id" value="<?php echo $_REQUEST['data_id']; ?>">
                <label style="margin-right:10px;">
                    <span>赛事：</span>
                    <?php echo downList($game_id,'id','game_title','game_id','id="game_id" onchange="changeGameid(this);"'); ?>
                </label>
                <?php if(!empty($data_id)) {?>
                    <label style="margin-right:10px;">
                        <span>选择赛事阶段：</span>
                        <select name="arrange_tcode" id="">
                            <option value="">请选择</option>
                            <?php
                                $stage = GameListArrange::model()->findAll('game_data_id='.$data_id.' and length(arrange_tcode)=4');
                                if(!empty($stage))foreach($stage as $st){
                            ?>
                                <option value="<?php echo $st->arrange_tcode ?>" <?php if($_REQUEST['arrange_tcode']==$st->arrange_tcode) echo 'selected'; ?>><?php echo $st->arrange_tcode; ?></option>
                            <?php }?>
                        </select>
                    </label>
                <?php }?>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <?php if($_REQUEST['game_id']!=0) { ?>
            <div class="gamesign-rt game_list_arrange" style="background-color:#e0e0e0;top: 105px;">
                <div class="gamesign-group">
                	<span class="gamesign-title">竞赛项目</span>
                    <!-- <a <?php //if($data_id==0){?> class="current"<?php //}?> href="<?php //echo $this->createUrl('gameListArrange/total_score', array('game_id'=>$_REQUEST['game_id']));?>">全部</a> -->
                    <?php foreach($game_data1 as $v){ ?>
                        <?php foreach($game_list1 as $v2) {?>
                            <a <?php if($data_id==$v->id){?> class="current"<?php }?> href="<?php echo $this->createUrl('gameListArrange/total_score', array('game_id'=>$v->game_id,'data_id'=>$v->id));?>"><?php echo $v->game_data_name;?></a>
                        <?php }?>
                    <?php }?>
                </div>
            </div><!--gamesign-rt end-->
        <?php } ?>
        <div class="<?php if($_REQUEST['game_id']!=0) { ?>gamesign-lt <?php }?>" style="border:none;padding:0 0;">
            <div class="box-content" style="margin: 105px 0 0 0;">
                <?php if($_REQUEST['game_id']>0) {?>
                    <div class="box-detail-tab mt15">
                        <ul class="c">
                            <li class="current"><a href="<?php echo Yii::app()->request->url; ?>">赛事名次录入</a></li>
                            <li><a href="<?php echo $this->createUrl('total_score2',array('game_id'=>$_REQUEST['game_id'],'data_id'=>$_REQUEST['data_id'])); ?>">赛事名次确认</a></li>
                        </ul>
                    </div>
                <?php }?>
                <form id="save_total" name="save_total">
                    <div class="box-table">
                        <table class="list">
                            <thead>
                                <th style="width:5%;">序号</th>
                                <th><?php echo $data_title; ?></th>
                                <th><?php echo $model->getAttributeLabel('victory_num'); ?></th>
                                <th><?php echo $model->getAttributeLabel('transport_num'); ?></th>
                                <th><?php echo $model->getAttributeLabel('gf_game_score_total'); ?></th>
                                <th><?php echo $model->getAttributeLabel('gf_rank'); ?></th>
                            </thead>
                            <tbody>
                                <?php $index = 1; foreach($arclist as $v) {?>
                                    <?php
                                        // $count = strlen($v->arrange_tcode);
                                        $v->sign_id = empty($v->sign_id) ? 0 : $v->sign_id;
                                        $v->team_id = empty($v->team_id) ? 0 : $v->team_id;
                                        $group = ($v->game_player_id==665) ? 'sign_id' : 'team_id';
                                        // $vid = ($v->game_player_id==665) ? 'sign_id>0 and sign_id='.$v->sign_id : 'team_id>0 and team_id='.$v->team_id;
                                        $vname = ($v->game_player_id==665) ? $v->sign_name : $v->team_name;
                                        $cname = (!empty($vname)) ? $vname : $v->f_sname;
                                        // $tcode = substr($v->arrange_tcode,0,4);
                                        // and left(arrange_tcode,7)="'.substr($v->arrange_tcode,0,7).'" //
                                        $h1 = ($v->game_player_id==665) ? ' and (sign_id=0 or (sign_name<>"" and sign_name is not null and sign_name<>"轮空"))' : ' and (team_id=0 or (team_name<>"" and team_name is not null and team_name<>"轮空"))';
                                        $h2 = ($v->game_player_id==665) ? 'sign_name='.$v->sign_id : 'team_name='.$v->team_id;
                                        $h3 = ($v->game_player_id==665) ? 'sign_name="'.$vname.'"' : 'team_name="'.$vname.'"';
                                        $sql_act = 'game_data_id='.$v->game_data_id.$h1.' and ('.$h2.' or '.$h3.' or f_sname="'.$v->f_sname.'")';
                                        $vict = GameListArrange::model()->findAll($sql_act.' and game_order=1');
                                        $tran = GameListArrange::model()->findAll($sql_act.' and game_order>1');
                                        // $sql = 'select min(game_order),count(*) from game_list_arrange where game_data_id='.$v->game_data_id.' and ('.$vid.') and game_order>0 group by '.$group;
                                        // $sql = 'select * from game_list_arrange where game_data_id='.$v->game_data_id.' and ('.$vid.') and game_order>0 group by '.$group;
                                        // $vict = Yii::app()->db->createCommand($sql)->queryAll();
                                        $sql = 'SELECT sum(gf_game_score) FROM game_list_arrange t where '.$sql_act;
                                        $integral = Yii::app()->db->createCommand($sql)->queryScalar();
                                        $order = GameListOrder::model()->find('arrange_id='.$v->id.' and length(arrange_tcode)=2');
                                        if($integral=='') $integral=0;
                                        $vic = (empty($v->victory_num)) ? count($vict) : $v->victory_num;
                                        $tra = (empty($v->transport_num)) ? count($tran) : $v->transport_num;
                                        $integral = $vic * 3;
                                        $integral = $integral + $tra;
                                        $gf_score = (!empty($order->game_integral_score)) ? $order->game_integral_score : $integral;
                                        $victory_num = (empty($v->victory_num)) ? count($vict) : $v->victory_num;
                                        $transport_num = (empty($v->transport_num)) ? count($tran) : $v->transport_num;
                                        // echo $victory_num;
                                        // echo $transport_num;
                                        // echo $sql_act.'<br>';
                                        // echo $v->actual_total_upper_order;
                                    ?>
                                    <tr>
                                        <input type="hidden" id="id_<?php echo $index; ?>" name="id_<?php echo $index; ?>" value="<?php echo $v->id; ?>">
                                        <input type="hidden" name="order_id_<?php echo $index; ?>" value="<?php if(!empty($v->game_list_order))echo $v->game_list_order->id; ?>">
                                        <td><span class="num num-1"><?php echo $index; ?></span></td>
                                        <td><?php echo $cname; ?></td>
                                        <td>
                                            <!-- <input 
                                                type="hidden" class="input-text onkeyup" 
                                                onchange="changeintegral(this,'v',<?php //echo $index; ?>);" 
                                                id="victory_num_<?php //echo $index; ?>" 
                                                name="victory_num_<?php //echo $index; ?>" 
                                                attrval="<?php //echo $index; ?>" 
                                                attrname="victory_num" 
                                                value="<?php //echo $victory_num; ?>"> -->
                                            <span id="victory_num1_<?php echo $index; ?>"><?php echo $victory_num; ?></span>
                                        </td>
                                        <td>
                                            <!-- <input 
                                                type="hidden" class="input-text onkeyup" 
                                                onchange="changeintegral(this,'t',<?php //echo $index; ?>);" 
                                                id="transport_num_<?php //echo $index; ?>" 
                                                name="transport_num_<?php //echo $index; ?>" 
                                                attrval="<?php //echo $index; ?>" 
                                                attrname="transport_num" 
                                                value="<?php //echo $transport_num; ?>"> -->
                                            <span id="transport_num1_<?php echo $index; ?>"><?php echo $transport_num; ?></span>
                                        </td>
                                        <td>
                                            <!-- <input 
                                                type="hidden" id="game_integral_score_<?php //echo $index; ?>" 
                                                name="game_integral_score_<?php //echo $index; ?>" 
                                                attrname="gf_game_score" 
                                                value="<?php //echo $gf_score; ?>"> -->
                                            <span id="gf_score_<?php echo $index; ?>"><?php echo $gf_score; ?></span>
                                        </td>
                                        <td>
                                            <!-- <input 
                                                type="hidden" class="input-text onkeyup submit_form" 
                                                attrval="<?php //echo $index; ?>" 
                                                attrname="total_score_order" 
                                                id="total_score_order_<?php //echo $index; ?>" 
                                                name="total_score_order_<?php //echo $index; ?>" 
                                                value="<?php //echo $v->actual_total_upper_order; ?>"> -->
                                            <?php echo $v->actual_total_upper_order; ?>
                                        </td>
                                    </tr>
                                <?php $index++; }?>
                            </tbody>
                        </table>
                    </div><!--box-table end-->
                </form>
                <div class="box-page c"><?php $this->page($pages); ?></div>
            </div><!--box-content || gamesign-lt end-->
        </div>
    </div><!--box end-->
</div><!--box end-->
<script>
    // $('body').on('keyup','.onkeyup',function(){
    //     if(this.value.length==1){
    //         this.value=this.value.replace(/[^1-9]/g,'0');
    //     }
    //     else{
    //         this.value=this.value.replace(/\D/g,'0');
    //     }
    // });

    function changeintegral(obj,code,num){
        var ob = parseInt($(obj).val());
        var m = 0;
        var i = 3;
        var c = 1;
        var transport_num;
        if(code=='v'){
            transport_num = parseInt($('#transport_num_'+num).val());
            m = i * ob;
            m += c * transport_num;
        }
        else{
            transport_num = parseInt($('#victory_num_'+num).val());
            m = c * ob;
            m += i * transport_num;
        }
        $('#game_integral_score_'+num).val(m);
        $('#gf_score_'+num).html(m);
        clickSaveTotal($(obj));
    }

    $('.submit_form').on('blur',function(){
        clickSaveTotal($(this));
    })

    function clickSaveTotal(op){
        var attrval = op.attr('attrval');
        var id = $('#id_'+attrval).val();
        var victory_num = $('#victory_num_'+attrval).val();
        var transport_num = $('#transport_num_'+attrval).val();
        var game_integral_score = $('#game_integral_score_'+attrval).val();
        var total_score_order = $('#total_score_order_'+attrval).val();
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('saveTotalScore'); ?>&id='+id,
            data: {victory_num:victory_num,transport_num:transport_num,game_integral_score:game_integral_score,total_score_order:total_score_order},
            dataType: 'json',
            success: function(data){
                // console.log('成功');
            },
            error: function(request){
                console.log('warning');
            }
        });
    }
</script>