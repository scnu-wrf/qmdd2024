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
        <h1>当前界面：赛事/排名 》GF积分管理 》总赛事积分确认</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>赛事：</span>
                    <?php echo downList($game_id,'id','game_title','game_id','id="game_id" onchange="changeGameid(this);"'); ?>
                </label>
                <label id="label2" style="margin-right:10px;">
                    <span class="span_inline_block">项目：</span>
                    <select name="data_id" id="data_id" onchange="changeDataid(this);">
                        <option value="">请选择</option>
                    </select>
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
                            <th style="width:3%;"><?php echo $model->getAttributeLabel('gf_rank'); ?></th>
                            <th><?php echo $model->getAttributeLabel('sign_name'); ?></th>
                            <th><?php echo $model->getAttributeLabel('victory_num'); ?></th>
                            <th><?php echo $model->getAttributeLabel('transport_num'); ?></th>
                            <th><?php echo $model->getAttributeLabel('gf_game_score_total'); ?></th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 1; foreach($arclist as $v) {?>
                            <tr>
                                <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo $v->id; ?>"></td>
                                <td></td>
                                <td><?php echo ($v->game_player_id==665) ? $v->sign_name : $v->team_name; echo '('.$v->f_sname.')'; ?></td>
                                <td><?php echo $v->victory_num; ?></td>
                                <td><?php echo $v->transport_num; ?></td>
                                <td><?php echo $v->gf_game_score; ?></td>
                                <td><?php echo ($v->total_score_confirm==0) ? '未确认' : '已确认'; ?></td>
                                <td>
                                    <?php
                                        $ck = ($v->total_score_confirm==0) ? 1 : 0;
                                        $c = ($v->total_score_confirm==0) ? '确认积分' : '取消确认';
                                        echo '<a href="javascript:;" class="btn" onclick="clickOrderConfirm('.$v->id.','.$ck.')">'.$c.'</a>';
                                    ?>
                                </td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div><!--box-table end-->
        </form>
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content || gamesign-lt end-->
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
        we.hasDelete('.check-item .input-check:checked', '#j-delete');
    });

    changeGameid($('#game_id'));
    function changeGameid(op){
        var obj = $(op).val();
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
        }else{
            $('#data_id').html(s_html);
        }
    }

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
</script>