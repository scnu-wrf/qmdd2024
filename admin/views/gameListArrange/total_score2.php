<?php
    check_request('game_id',0);
    check_request('data_id',0);
    check_request('score_confirm',0);
    $data1 = GameListData::model()->find('id='.$_REQUEST['data_id']);
    $data_title = '姓名';
    if(!empty($data1) && $data1->game_player_team!=665){
        $data_title = '团队名称';
    }
?>
<style>
    .box-table .list tr th,.box-table .list tr td{ text-align: center; }
    /* .box-search{margin-top: 0;padding-top: 0;border-top: 0;} */
    .aui_content{ height:auto;overflow:auto;padding:5px 5px!important; }
    /* .aui_main{ height:auto!important; } */
    .cld{ background-color: #f8f8f8;display: none; }
    .list .input-text{ width: 25%;text-align: center; }
    /* .input-check{ vertical-align: -webkit-baseline-middle;vertical-align: -moz-middle-with-baseline; } */
    .list tr:hover td { background: none!important; }
    .nav-ul li{ display:inline-block;width:8%;padding:5px;text-align:center;background-color:#5b8d98;color:white;cursor:pointer;margin-top:5px; }
</style>
<div class="box" style="margin: 0px 10px 10px 0;">
    <div class="gamesign c">
        <div class="box-title c" style="width: 99%;position: fixed;background-color: #F2F2F2;z-index: 99;">
            <h1>当前界面：赛事/排名 》赛事成绩 》赛事名次确认</h1>
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
                <label style="margin-right:10px;">
                    <span>状态：</span>
                    <select name="score_confirm" id="score_confirm">
                        <option value="">请选择</option>
                        <option value="649" <?php if($_REQUEST['score_confirm']==649) echo 'selected'; ?>>已确定</option>
                        <option value="648" <?php if($_REQUEST['score_confirm']==648) echo 'selected'; ?>>未确定</option>
                    </select>
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <?php if($_REQUEST['game_id']!=0) { ?>
            <div class="gamesign-rt game_list_arrange" style="background-color:#e0e0e0;top: 105px;">
                <div class="gamesign-group">
                	<span class="gamesign-title">竞赛项目</span>
                    <?php foreach($game_data1 as $v){ ?>
                        <a <?php if($data_id==$v->id){?> class="current"<?php }?> href="<?php echo $this->createUrl('gameListArrange/total_score2', array('game_id'=>$v->game_id,'data_id'=>$v->id));?>"><?php echo $v->game_data_name;?></a>
                    <?php }?>
                </div>
            </div><!--gamesign-rt end-->
        <?php } ?>
        <div class="<?php if($_REQUEST['game_id']!=0) { ?>gamesign-lt <?php } else { ?>box-content<?php } ?>" style="border:none;padding:0 0;">
            <div class="box-content" style="margin: 105px 0 0 0;">
                <?php if(1==2 && $_REQUEST['game_id']>0) {?>
                    <div class="box-detail-tab mt15">
                        <ul class="c">
                            <li><a href="<?php echo $this->createUrl('total_score',array('game_id'=>$_REQUEST['game_id'],'data_id'=>$_REQUEST['data_id'])); ?>">赛事名次录入</a></li>
                            <li class="current"><a href="<?php echo Yii::app()->request->url; ?>">赛事名次确认</a></li>
                        </ul>
                    </div>
                <?php }if($_REQUEST['game_id']>0) {?>
                <div class="box-header">
                    <span style="display:inline-block;width:60px;">
                        <input id="j-checkall" class="input-check" type="checkbox">
                        <label for="j-checkall">全选</label>
                    </span>
                    <a style="vertical-align: middle;" href="javascript:;" class="btn btn-blue" onclick="checkval('.check-item input:checked',1);">确认名次</a>
                    <a style="vertical-align: middle;" href="javascript:;" class="btn" onclick="checkval('.check-item input:checked',0);">取消确认</a>
                </div>
                <?php }?>
                <div class="box-table">
                    <table class="list">
                        <thead>
                            <th></th>
                            <th style="width: 5%;"><?php echo $model->getAttributeLabel('gf_rank'); ?></th>
                            <th><?php echo $data_title; ?></th>
                            <th><?php echo $model->getAttributeLabel('victory_num'); ?></th>
                            <th><?php echo $model->getAttributeLabel('transport_num'); ?></th>
                            <th><?php echo $model->getAttributeLabel('gf_game_score_total'); ?></th>
                            <th>状态</th>
                            <th>操作</th>
                        </thead>
                        <tbody>
                            <?php $index = 1; foreach($arclist as $v) {?>
                                <?php
                                    $tname = ($v->game_player_id==665) ? 'sign_name' : 'team_name';
                                    $sname = (empty($v->$tname)) ? $v->f_sname : $v->$tname;
                                    // $h1 = ' and (ifnull('.$tname.' or '.$tname.'="轮空",f_sname))';
                                    $h1 = ' and (ifnull('.$tname.',f_sname)="'.$sname.'")';
                                    $sql_act = 'game_data_id='.$v->game_data_id.$h1;
                                    $vict = GameListArrange::model()->findAll($sql_act.' and game_order=1 and score_confirm=1');
                                    $tran = GameListArrange::model()->findAll($sql_act.' and game_order>1 and score_confirm=1');
                                    $score_confirm = GameListArrange::model()->count($sql_act.' and score_confirm=1');
                                    // $sql = 'SELECT sum(gf_game_score) FROM game_list_arrange t where score_confirm=1 and '.$sql_act;
                                    // echo $sql_act.' and game_order=1 and score_confirm=1'.'<br>';
                                    // $integral = Yii::app()->db->createCommand($sql)->queryScalar();
                                    $order = GameListOrder::model()->find('arrange_id='.$v->id.' and length(arrange_tcode)=2');
                                    // if($integral=='') $integral=0;
                                    $vic = (empty($v->victory_num)) ? count($vict) : $v->victory_num;
                                    $tra = (empty($v->transport_num)) ? count($tran) : $v->transport_num;
                                    $integral = $vic * 3;
                                    $integral = $integral + $tra;
                                    $victory_num = (empty($v->victory_num)) ? count($vict) : $v->victory_num;
                                    $transport_num = (empty($v->transport_num)) ? count($tran) : $v->transport_num;
                                    $gf_score = (!empty($order->game_integral_score)) ? $order->game_integral_score : $integral;
                                ?>
                                <tr>
                                    <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                                    <td><?php echo $v->actual_total_upper_order; ?></td>
                                    <td><?php echo $sname; ?></td>
                                    <td>
                                        <input 
                                            type="hidden" class="input-text onkeyup" 
                                            onchange="changeintegral(this,'v',<?php echo $index; ?>);" 
                                            id="victory_num_<?php echo $index; ?>" 
                                            name="victory_num_<?php echo $index; ?>" 
                                            attrval="<?php echo $index; ?>" 
                                            attrname="victory_num" 
                                            value="<?php echo $victory_num; ?>">
                                        <?php echo $victory_num; ?>
                                    </td>
                                    <td>
                                        <input 
                                            type="hidden" class="input-text onkeyup" 
                                            onchange="changeintegral(this,'t',<?php echo $index; ?>);" 
                                            id="transport_num_<?php echo $index; ?>" 
                                            name="transport_num_<?php echo $index; ?>" 
                                            attrval="<?php echo $index; ?>" 
                                            attrname="transport_num" 
                                            value="<?php echo $transport_num; ?>">
                                        <?php echo $transport_num; ?>
                                    </td>
                                    <td><?php echo $gf_score; ?></td>
                                    <td><?php echo ($v->total_order_confirm==0) ? '未确认' : '已确认'; ?></td>
                                    <td>
                                        <?php
                                            $ck = ($v->total_order_confirm==0) ? 1 : 0;
                                            $c = ($v->total_order_confirm==0) ? '确认名次' : '取消确认';
                                            echo '<a href="javascript:;" class="btn" onclick="clickOrderConfirm('.$v->id.','.$ck.')">'.$c.'</a>';
                                        ?>
                                    </td>
                                </tr>
                            <?php $index++; }?>
                        </tbody>
                    </table>
                </div><!--box-table end-->
            <div class="box-page c"><?php $this->page($pages); ?></div>
        </div><!--box-content || gamesign-lt end-->
    </div>
</div><!--box end-->
<script>
    var $temp1 = $('.check-item .input-check');
    var $temp2 = $('.box-table .list tbody tr');
    $('#j-checkall').on('click', function() {
        var $this = $(this);
        if ($this.is(':checked')) {
            $temp1.each(function() {
                if(this.disabled!=true){
                    this.checked = true;
                }
            });
            $temp2.addClass('selected');
        } else {
            $temp1.each(function() {
                this.checked = false;
            });
            $temp2.removeClass('selected');
        }
    });

    function checkval(op,n){
        var str = '';
        $(op).each(function() {
            str += $(this).val() + ',';
        });
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        else{
            we.msg('minus','请选择要确认/取消的数据');
            return false;
        }
        clickOrderConfirm(str,n);
    };

    function clickOrderConfirm(id,n){
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('saveTotalScore2'); ?>&id='+id+'&n='+n,
            dataType: 'json',
            success: function(data){
                we.success(data.msg, data.redirect);
            },
            error: function(request){
                console.log('warning');
            }
        });
    }
</script>