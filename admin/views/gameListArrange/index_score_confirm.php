<?php
    check_request('game_id',0);
    check_request('data_id',0);
    check_request('score_confirm',0);
?>
<style>
    .box-table .list tr th,.box-table .list tr td{ text-align: center; }
    .list .input-text { width: 50%;text-align:center; }
    .box-table .list tr:hover td { background: none; }
</style>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名 》GF积分管理 》单场赛事积分确认</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>赛事名称：</span>
                    <?php echo downList($game_id,'id','game_title','game_id','id="game_id" onchange="changeGameid(this);"'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>竞赛项目：</span>
                    <select name="data_id" id="data_id">
                        <option value="">请选择</option>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>比赛时间：</span>
                    <input style="width:150px;" type="text" class="input-text time" id="star_time" name="star_time" value="<?php echo  $star_time; ?>">
                    <span>-</span>
                    <input style="width:150px;" type="text" class="input-text time" id="end_time" name="end_time" value="<?php echo  $end_time; ?>">
                </label>
                <label style="margin-right:10px;">
                    <span>状态：</span>
                    <select name="score_confirm" id="score_confirm">
                        <option value="">请选择</option>
                        <option value="649" <?php if($_REQUEST['score_confirm']==649) echo 'selected'; ?>>已确定</option>
                        <option value="648" <?php if($_REQUEST['score_confirm']==648) echo 'selected'; ?>>未确定</option>
                    </select>
                </label>
                <button id="search_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-header">
            <span style="display:inline-block;width:60px;">
                <input id="j-checkall" class="input-check" type="checkbox">
                <label for="j-checkall">全选</label>
            </span>
            <a style="vertical-align: middle;" href="javascript:;" class="btn btn-blue" onclick="checkval('.check-item input:checked',1);">确认积分</a>
            <a style="vertical-align: middle;" href="javascript:;" class="btn" onclick="checkval('.check-item input:checked',0);">取消确认</a>
        </div>
        <form id="save_time" name="save_time">
            <div class="box-table">
                <table class="list">
                    <thead>
                        <tr>
                            <th class="check"></th>
                            <th colspan="8">赛事成绩</th>
                            <th colspan="2">GF排名积分</th>
                            <th rowspan="2">状态</th>
                            <th rowspan="2" style="width:8%;">积分确认</th>
                        </tr>
                        <tr>
                            <th class="check"></th>
                            <th style="width:3%;">序号</th>
                            <th style="width:9%;"><?php echo $model->getAttributeLabel('game_time'); ?></th>
                            <th><?php echo $model->getAttributeLabel('group'); ?></th>
                            <th><?php echo $model->getAttributeLabel('matches'); ?></th>
                            <th><?php echo $model->getAttributeLabel('arrange_tname1'); ?></th>
                            <th><?php echo $model->getAttributeLabel('game_player_id'); ?></th>
                            <th style="width:6%;"><?php echo $model->getAttributeLabel('winning_bureau1'); ?></th>
                            <th style="width:5%;"><?php echo $model->getAttributeLabel('is_promotion'); ?></th>
                            <th style="width:6%;"><?php echo $model->getAttributeLabel('gf_game_score'); ?></th>
                            <th style="width:6%;"><?php echo $model->getAttributeLabel('gf_votes_score'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 1; $lnum = count($arclist); foreach($arclist as $v) {?>
                            <?php
                                $count = strlen($v->arrange_tcode);
                                $tcode = substr($v->arrange_tcode,0,4);
                                $arrange = $model->find('game_data_id='.$v->game_data_id.' and arrange_tcode="'.substr($v->arrange_tcode,0,5).'"');
                                $arrange1 = $model->findAll('game_data_id='.$v->game_data_id.' and left(arrange_tcode,7)="'.$v->arrange_tcode.'" and length(arrange_tcode)=9 order by arrange_tcode');
                                // echo 'game_data_id='.$v->game_data_id.' and left(arrange_tcode,7)="'.$v->arrange_tcode.'" and length(arrange_tcode)=9 order by arrange_tcode'.'<br>';
                                $len = count($arrange1);
                            ?>
                            <?php if($count==7) {?>
                                <tr class="<?php echo $tcode; ?> tr">
                                    <input type="hidden" name="id_<?php echo $index; ?>" value="<?php echo $v->id; ?>">
                                    <td rowspan="<?php echo $len+1; ?>" class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                                    <td rowspan="<?php echo $len+1; ?>"><span class="num num-1"><?php echo $index; ?></span></td>
                                    <td rowspan="<?php echo $len+1; ?>"><?php echo substr($v->star_time,0,10); ?></td>
                                    <td rowspan="<?php echo $len+1; ?>"><?php echo $arrange->arrange_tname; ?></td>
                                    <td rowspan="<?php echo $len+1; ?>"><?php echo $v->arrange_tname; ?></td>
                                </tr>
                            <?php }?>
                            <?php $num = 1;$n = 0; if(!empty($arrange1))foreach($arrange1 as $a1) {?>
                                <tr class="<?php echo $tcode; ?> tr">
                                    <input type="hidden" id="id_<?php echo $index.'_'.$num; ?>" value="<?php echo $a1->id; ?>">
                                    <td><?php echo $a1->arrange_tname; ?></td>
                                    <td><?php echo ($a1->game_player_id==665) ? $a1->sign_name : $a1->team_name; ?></td>
                                    <td><?php echo $a1->winning_bureau; ?></td>
                                    <td><?php if(!empty($a1->is_promotion)) echo $a1->base_is_promotion->F_NAME; ?></td>
                                    <td><input type="text" class="input-text sub_score" id="gf_game_score_<?php echo $index.'_'.$num; ?>" attrname="gf_game_score" attrnum="<?php echo $index.'_'.$num; ?>" value="<?php echo $a1->gf_game_score; ?>"></td>
                                    <td>
                                        <!-- <input type="text" class="input-text sub_score" id="gf_votes_score_<?php //echo $index.'_'.$num; ?>" attrname="gf_votes_score" attrnum="<?php //echo $index.'_'.$num; ?>" value="<?php //echo $a1->gf_votes_score; ?>"> -->
                                        <?php echo $a1->gf_votes_score; ?>
                                    </td>
                                    <?php if($n==0) {?>
                                        <td rowspan="2"><?php echo ($v->score_confirm==0) ? '未确认' : '已确认'; ?></td>
                                        <td rowspan="2">
                                            <?php
                                                $ck = ($v->score_confirm==0) ? 1 : 0;
                                                $cb = ($v->score_confirm==0) ? 'btn-blue' : '';
                                                $c = ($v->score_confirm==0) ? '确认积分' : '取消确认';
                                                echo '<a href="javascript:;" class="btn '.$cb.'" onclick="clickOrderConfirm('.$v->id.','.$ck.')">'.$c.'</a>';
                                            ?>
                                        </td>
                                    <?php }?>
                                </tr>
                            <?php $num++;$n++; }?>
                        <?php if($count==7)$index++; }?>
                    </tbody>
                </table>
            </div><!--box-table end-->
        </form>
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content || gamesign-lt end-->
</div><!--box end-->
<script>
    $('.time').on('click',function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });

    changeGameid($('#game_id'));
    function changeGameid(obj){
        var obj = $(obj).val();
        var s_html = '<option value>请选择</option>';
        if(obj > 0){
            var pr = '<?php echo $_REQUEST['data_id']; ?>';
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('data_id'); ?>&game_id='+obj,
                dataType: 'json',
                success: function(data) {
                    for(var i=0;i<data.length;i++){
                        s_html += '<option value="'+data[i]['id']+'" '+((data[i]['id']==pr) ? 'selected>' : '>')+data[i]['game_data_name']+'</option>';
                    }
                    $('#data_id').html(s_html);
                }
            });
        }
        else{
            $('#data_id').html(s_html);
        }
    }

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
        we.hasDelete('.check-item .input-check:checked', '#j-delete');
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
            we.msg('minus','请选择要确认/取消的场次');
            return false;
        }
        post_json(str,n);
    };

    function post_json(id,n){
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('orderConfirm',array('confirm'=>'score_confirm')); ?>&id='+id+'&num='+n,
            dataType: 'json',
            success: function(data){
                we.success(data.msg, data.redirect);
            },
            error: function(request){
                console.log('错误');
            }
        });
    }

    // 成绩确认 && 取消确认
    function clickOrderConfirm(id,n){
        post_json(id,n);
    }

    // 保存修改的积分
    $('.sub_score').on('blur',function(){
        // console.log($(this).attr('attrname'),$('#id_'+$(this).attr('attrnum')).val(),$(this).val());
        var id = $('#id_'+$(this).attr('attrnum')).val();
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('save_score_votes'); ?>&id='+id,
            data: {attrname:$(this).attr('attrname'),attrval:$(this).val()},
            dataType: 'json',
            success: function(data){
                // console.log(data);
            },
            error: function(request){
                console.log('错误');
            }
        });
    })
</script>