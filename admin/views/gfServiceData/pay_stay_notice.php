<?php
    check_request('game_id',0);
    check_request('data_id',0);
    $game_data_id = GameListData::model()->find('id='.$_REQUEST['data_id']);
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名 》 赛事报名 》 报名缴费待通知</h1>
        <span style="float:right;">
            <a class="btn" href="<?php echo $this->createUrl('pay_notice'); ?>">返回上一层</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;min-width:280px;">
                    <span style="font-weight: bold;">赛事名称：</span>
                    <?php echo downList($game_id,'id','game_title','game_id','id="game_id" onchange="changeGameid(this);"'); ?>
                </label>
                <label style="margin-right:10px;min-width:255px;">
                    <span style="font-weight: bold;">竞赛项目：</span>
                    <select name="data_id" id="data_id">
                        <option value="">请选择</option>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span style="font-weight: bold;">关键字：</span>
                    <input style="width:150px;" type="text" class="input-text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="请输入姓名/GF账号">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
                <br>
                <div>
                    <div>
                        <span style="display:inline-block;width:150px;font-weight: bold;">选择对象</span>
                        <span style="display:inline-block;width:150px;font-weight: bold;">收费方式</span>
                        <span style="display:inline-block;width:250px;font-weight: bold;">可执行操作</span>
                    </div>
                    <div>
                        <span style="display:inline-block;width:150px;">
                            <input id="j-checkall" class="input-check" type="checkbox">
                            <label for="j-checkall">全选</label>
                        </span>
                        <label style="min-width:150px;">
                            <span class="check">
                                <input class="input-check" id="radio_1" value="1" checked="checked" type="radio" name="radio_money">
                                <label for="radio_1">实缴报名费</label>
                            </span>
                            <span class="check">
                                <input class="input-check" id="radio_0" value="0" type="radio" name="radio_money">
                                <label for="radio_0">免单</label>
                            </span>
                        </label>
                        <a style="vertical-align: middle;" href="javascript:;" class="btn btn-blue" onclick="checkval('.check-item input:checked');">确认通知</a>
                    </div>
                </div>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"></th>
                        <th style='text-align: center;' class="list-id">序号</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('order_num1');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('service_game_id');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('service_game_data_id');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('uptype');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('gf_account');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('gf_name1');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('buy_price1');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('udate1');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td style="text-align: center;" class="check check-item"><input class="input-check" type="checkbox" value="<?php echo $v->id; ?>"></td>
                        <td style="text-align: center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style="text-align: center;"><?php echo $v->order_num; ?></td>
                        <td style="text-align: center;"><?php echo $v->service_name; ?></td>
                        <td style="text-align: center;"><?php echo $v->service_data_name; ?></td>
                        <td style="text-align: center;"><?php if(!empty($v->service_data_id)) echo $v->game_list_data->game_player_team_name; ?></td>
                        <td style="text-align: center;"><?php echo $v->gf_account; ?></td>
                        <td style="text-align: center;"><?php echo $v->gf_name; ?></td>
                        <td style="text-align: center;"><?php echo $v->buy_price; ?></td>
                        <td style="text-align: center;"><?php echo $v->udate; ?></td>
                        <td style="text-align: center;">
                            <a href="javascript:;" class="btn" onclick="clickNotice(<?php echo $v->id; ?>);">通知</a>
                        </td>
                    </tr>
                <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content || gamesign-lt end-->
</div><!--box end-->
<script>
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

    var $this, $temp1 = $('.check-item .input-check'), $temp2 = $('.box-table .list tbody tr');
    $('#j-checkall').on('click', function(){
        $this = $(this);
        if($this.is(':checked')){
            $temp1.each(function(){
                if(this.disabled!=true){
                    this.checked = true;
                }
            });
            $temp2.addClass('selected');
        }else{
            $temp1.each(function(){
                this.checked = false;
            });
            $temp2.removeClass('selected');
        }
    });

    var s_ont = 0;
    function checkval(op){
        s_ont++;
        var str = '';
        $(op).each(function() {
            str += $(this).val() + ',';
        });
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        else{
            we.msg('minus','请选择要通知的人员');
            return false;
        }
        clickNotice(str);
    };

    function clickNotice(id){
        var radio = $('input:radio:checked').val();
        if(s_ont>0){
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('notice');?>&id='+id+'&radio='+radio,
                dataType: 'json',
                success: function(data) {
                    if(data.status==1){
                        we.success(data.msg, data.redirect);
                    }
                    else{
                        we.msg('minus','操作失败');
                    }
                },
                error: function(request){
                    we.msg('minus','操作错误');
                }
            });
        }
        s_ont = 0;
    }
</script>