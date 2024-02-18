<?php
    check_request('game_id',0);
    check_request('data_id',0);
    if(!isset($_REQUEST['state'])){
        $_REQUEST['state'] = 371;
    }
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名 》 赛事报名 》 成员报名审核</h1>
        <span style="float:right;">
            <a class="btn" href="<?php echo $this->createUrl('gameSignList/index_exam',array('game_id'=>$_REQUEST['game_id'],'data_id'=>$_REQUEST['data_id'])); ?>">返回上一层</a>
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
                <label class="check" style="-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;margin-left:10px;">
                    <input id="check_team" name="check_team" class="input-check" type="checkbox" checked="checked">审核同时发送缴费通知
                </label>
                <a style="vertical-align: middle;" id="j-delete" href="javascript:;" class="btn btn-blue" onclick="checkval('.check-item input:checked');">审核通过</a>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style='text-align: center;' class="list-id">序号</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('sign_game_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('games_desc');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('uptype');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('sign_account');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('sign_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('state');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('add_time1');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td style="text-align: center;" class="check check-item"><input class="input-check check_box" type="checkbox" value="<?php echo $v->id.':0'; ?>" <?php if($v->state==372)echo 'disabled="disabled"'; ?>></td>
                        <td style="text-align: center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style="text-align: center;"><?php echo $v->sign_game_name; ?></td>
                        <td style="text-align: center;"><?php echo $v->games_desc; ?></td>
                        <td style="text-align: center;"><?php if(!empty($v->sign_game_data_id) && !empty($v->game_list_data)) echo $v->game_list_data->game_player_team_name; ?></td>
                        <td style="text-align: center;"><?php echo $v->sign_account; ?></td>
                        <td style="text-align: center;"><?php echo $v->sign_name; ?></td>
                        <td style="text-align: center;"><?php echo $v->state_name; ?></td>
                        <td style="text-align: center;"><?php echo $v->state_time; ?></td>
                        <td style="text-align: center;">
                            <?php echo show_command('审核',$this->createUrl('gameSignList/update', array('id'=>$v->id,'game_id'=>$v->sign_game_id,'data_id'=>$v->sign_game_data_id,'p_id'=>0)),'审核'); ?>
                        </td>
                    </tr>
                <?php $index++; } ?>
                <?php
                    $index1 = $index;
                    $gid = ($_REQUEST['game_id']>0) ? 'game_id='.$_REQUEST['game_id'].' and ' : '';
                    $did = ($_REQUEST['data_id']>0) ? 'sign_game_data_id='.$_REQUEST['data_id'].' and ' : '';
                    $table_list = GameTeamTable::model()->findAll(
                        $gid.$did.'state=371  and exists(select * from game_list_data gl where t.sign_game_data_id=gl.id and gl.state=372 and gl.gl.signup_date_end>now())'
                    );
                    if(!empty($table_list))foreach($table_list as $tl){
                ?>
                    <tr>
                        <td style="text-align: center;" class="check check-item"><input class="input-check check_box" type="checkbox" value="<?php echo $tl->id.':1'; ?>" <?php if($tl->state==372)echo 'disabled="disabled"'; ?>></td>
                        <td style="text-align: center;"><span class="num num-1"><?php echo $index1 ?></span></td>
                        <td style="text-align: center;"><?php echo $tl->game_name; ?></td>
                        <td style="text-align: center;"><?php echo $tl->sign_game_data_name; ?></td>
                        <td style="text-align: center;"><?php if(!empty($tl->sign_game_data_id) && !empty($tl->game_list_data)) echo $tl->game_list_data->game_player_team_name; ?></td>
                        <td style="text-align: center;"><?php echo $tl->create_account; ?></td>
                        <td style="text-align: center;">
                            <?php
                                if($tl->game_list_data->game_player_team!=666){
                                    $sign_list = GameSignList::model()->findAll('team_id='.$tl->id.' ');
                                    $name = '';
                                    $n = ' / ';
                                    if(!empty($sign_list))foreach($sign_list as $sl){
                                        if(!empty($name)) $name .= $n; 
                                        $name .= $sl->sign_name;
                                    }
                                    echo $name;
                                }
                                else{
                                    echo $tl->name;
                                }
                            ?>
                        </td>
                        <td style="text-align: center;"><?php echo $tl->state_name; ?></td>
                        <td style="text-align: center;"><?php echo $tl->state_time; ?></td>
                        <td style="text-align: center;">
                            <?php echo show_command('审核',$this->createUrl('gameTeamTable/player_update', array('id'=>$tl->id,'game_id'=>$tl->game_id,'data_id'=>$tl->sign_game_data_id,'p_id'=>0)),'审核'); ?>
                        </td>
                    </tr>
                <?php $index1++; }?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content || gamesign-lt end-->
</div><!--box end-->
<script>
    $(function(){
        $('.time').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
    });

    var deleteUrl = '<?php echo $this->createUrl('delete',array('id'=>'ID')); ?>';
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
                    for(var i=0;i<data[0].length;i++){
                        s_html += '<option value="'+data[0][i]['id']+'" '+((data[0][i]['id']==pr) ? 'selected>' : '>')+data[0][i]['game_data_name']+'</option>';
                    }
                    $('#data_id').html(s_html);
                }
            });
        }
        else{
            $('#data_id').html(s_html);
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
            we.msg('minus','请选择成员');
            return false;
        }
        clickCheck(str,372);
    };

    function clickCheck(id,state){
        var box = ($('#check_team').is(':checked')==true) ? 1 : 0;
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('clickCheck'); ?>&id='+id+'&state='+state+'&box='+box,
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