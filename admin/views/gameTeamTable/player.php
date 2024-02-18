<?php
    check_request('game_id',0);
    check_request('data_id',0);
    $game_data_id = GameListData::model()->find('id='.$_REQUEST['data_id']);
    $game_len = 0;
    $sign_num = 0;
    $lg = 0;
    if(!empty($game_data_id)){
        $game_len = ($game_data_id->game_player_team==665) ? $game_data_id->number_of_member : $game_data_id->max_num_team;
        $sign_num = $model->count('sign_game_data_id='.$game_data_id->id.'  and state=372');
        if($game_data_id->game_player_team==666) $lg = 1;
        if($game_data_id->game_player_team!=666 && $game_data_id->game_player_team!=665) $lg = 2;
    }
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名 》 赛事报名 》 成员报名申请</h1>
        <span style="float:right;">
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
                    <span>关键字：</span>
                    <input style="width:150px;" type="text" class="input-text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="请输入姓名/GF账号">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
                <span style="margin-left:20px;">
                    <?php
                        if(!empty($_REQUEST['game_id']) && !empty($_REQUEST['data_id']) && $sign_num<$game_len){
                            echo show_command('添加',$this->createUrl('addsign',array('game_id'=>$_REQUEST['game_id'],'data_id'=>$_REQUEST['data_id'])),'添加','style="vertical-align: middle;"');
                        }
                    ?>
                    <a style="vertical-align: middle;" href="javascript:;" class="btn btn-blue" onclick="checkval('.check-item input:checked');">提交审核</a>
                    <a style="display:none;vertical-align: middle;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
                </span>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style='text-align: center;' class="list-id">序号</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('create_account');?></th>
                        <?php if($lg==1) {?>
                            <th style='text-align: center;'><?php echo $model->getAttributeLabel('logo');?></th>
                        <?php }?>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('name1');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('uptype');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('state1');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $index = 1;
                    $img_path = BasePath::model()->get_www_path();
                    foreach($arclist as $v){
                        $pid = ($v->state==721) ? 1 : 0;
                        $sign_list = GameSignList::model()->findAll('team_id='.$v->id);
                ?>
                    <tr>
                        <td style="text-align: center;" class="check check-item"><input class="input-check" type="checkbox" value="<?php echo $v->id.':1'; ?>" <?php if($v->state==372)echo 'disabled="disabled"'; ?>></td>
                        <td style="text-align: center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style="text-align: center;">
                            <?php
                                if($v->game_list_data->game_player_team!=665 && $v->game_list_data->game_player_team!=666){
                                    $vb = ' / ';
                                    $cf = '';
                                    if(!empty($sign_list))foreach($sign_list as $sl){
                                        if(!empty($cf)) $cf .= $vb;
                                        $cf .= $sl->sign_account;
                                    }
                                    echo $cf;
                                }
                                else{
                                    echo $v->create_account;
                                }
                            ?>
                        </td>
                        <?php if($lg==1) {?>
                            <td style="text-align: center;">
                                <?php if(!empty($v->logo)) {?>
                                    <div class="upload_img fl">
                                        <a href="<?php echo $img_path.$v->logo; ?>" target="_black">
                                            <img src="<?php echo $img_path.$v->logo; ?>" alt="" width="50px;">
                                        </a>
                                    </div>
                                <?php }?>
                            </td>
                        <?php }?>
                        <td style="text-align: center;">
                            <?php
                                if($v->game_list_data->game_player_team!=665 && $v->game_list_data->game_player_team!=666){
                                    $vb = ' / ';
                                    $cf = '';
                                    if(!empty($sign_list))foreach($sign_list as $sl){
                                        if(!empty($cf)) $cf .= $vb;
                                        $cf .= $sl->sign_name;
                                    }
                                    echo $cf;
                                }
                                else{
                                    echo $v->name;
                                }
                            ?>
                        </td>
                        <td style='text-align: center;'><?php if(!empty($v->sign_game_data_id)) echo $v->game_list_data->game_player_team_name; ?></td>
                        <td style="text-align: center;"><?php echo $v->state_name; ?></td>
                        <td style="text-align: center;">
                            <?php echo show_command('修改',$this->createUrl('player_update', array('id'=>$v->id,'game_id'=>$v->game_id,'data_id'=>$v->sign_game_data_id,'p_id'=>$pid))); ?>
                            <?php echo show_command('删除','\''.$v->id.':1'.'\''); ?>
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
    var deleteUrl = '<?php echo $this->createUrl('delete',array('id'=>'ID')); ?>';
    changeGameid($('#game_id'));
    function changeGameid(obj){
        var obj = $(obj).val();
        var s_html = '<option value>请选择</option>';
        var k_html = '<option value>请选择</option>';
        if(obj > 0){
            var pr = '<?php echo $_REQUEST['data_id']; ?>';
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('data_id'); ?>&game_id='+obj,
                dataType: 'json',
                success: function(data) {
                    for(var i=0;i<data[0].length;i++){
                        s_html += '<option value="'+data[0][i]['id']+'" '+((data[0][i]['id']==pr) ? 'selected>' : '>')+data[0][i]['game_data_name']+'</option>';
                    }
                    $('#data_id').html(s_html);
                    for(var j=0;j<data[1].length;j++){
                        k_html += '<option value="'+data[1][j]['project_id']+'" '+((data[1][j]['project_id']==pr) ? 'selected>' : '>')+data[1][j]['project_name']+'</option>';
                    }
                    $('#project').html(k_html);
                }
            });
        }
        else{
            $('#data_id').html(s_html);
            $('#project').html(k_html);
        }
    }

    function checkval(op){
        var str = '';
        $(op).each(function() {
            str += $(this).val() + ',';
        });
        if(str.length > 0){
            str = str.substring(0, str.length - 1);
        }
        else{
            $('.check-item input[type="checkbox"]').css('box-shadow','0px 0px 10px red');
            setTimeout(() => {
                $('.check-item input[type="checkbox"]').css('box-shadow','0px 0px 0px red');
            }, 2500);
            we.msg('minus','请选择成员');
            return false;
        }
        clickCheck(str,371);
    };

    function clickCheck(id,state=721){
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('clickCheck'); ?>&id='+id+'&state='+state,
            dateType: 'json',
            success: function(data){
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
        })
    }
</script>