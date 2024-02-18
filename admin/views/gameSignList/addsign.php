<?php
    if(!isset($_REQUEST['game_id'])){
        $_REQUEST['game_id']=0;
    }
    if(!isset($_REQUEST['data_id'])){
        $_REQUEST['data_id']=0;
    }
    $gamedata=GameListData::model()->find('id='.$_REQUEST['data_id']);
    $team = $gamedata->game_player_team;
    $basepath=BasePath::model()->getPath(191);$picprefix='';
    if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
    $sign_num = GameSignList::model()->count('sign_game_data_id='.$_REQUEST['data_id'].' and state=372');
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名 》 赛事报名 》 成员报名申请 》 添加</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a>
        </span>
    </div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <?php
            echo $form->hiddenField($model,'sign_game_id',array('value'=>$_REQUEST["game_id"]));
            echo $form->hiddenField($model,'sign_game_data_id',array('value'=>$_REQUEST["data_id"]));
            echo $form->error($model,'sign_game_id',$htmlOptions = array());
        ?>
        <div class="box-detail-bd">
            <table id="table_tag">
                <tr class="table-title">
                    <td><?php echo $form->labelEx($model,'sign_game_name'); ?>：</td>
                    <td><?php echo $gamedata->game_name; ?></td>
                    <td><?php echo $form->labelEx($model,'games_desc'); ?>：</td>
                    <td colspan="3"><?php echo $gamedata->game_data_name; ?></td>
                </tr>
                <tr>
                    <td><?php echo $model->getAttributeLabel('sign_account'); ?></td>
                    <td><?php echo $model->getAttributeLabel('sign_name'); ?></td>
                    <td><?php echo $model->getAttributeLabel('sign_sname'); ?>（不是必填）</td>
                    <td><?php echo $model->getAttributeLabel('athlete_rank'); ?>（不是必填）</td>
                    <td><?php echo $model->getAttributeLabel('health_date'); ?>（不是必填）</td>
                    <td>操作</td>
                </tr>
                <?php $num = 0; ?>
                <tr class="tr_len">
                    <td><input type="text" class="input-text onkeyup" name="add_form[<?php echo $num; ?>][sign_account]" maxlength="6" oninput="oninputQuery(this,<?php echo $num; ?>);" onpropertychange="oninputQuery(this,<?php echo $num; ?>);"></td>
                    <td><input type="text" class="input-text" id="name_<?php echo $num; ?>" readonly="readonly"></td>
                    <td><input type="text" class="input-text" name="add_form[<?php echo $num; ?>][sign_sname]"></td>
                    <td><input type="text" class="input-text" name="add_form[<?php echo $num; ?>][athlete_rank]" id="athlete_rank_<?php echo $num; ?>"></td>
                    <td><input type="text" class="input-text time" name="add_form[<?php echo $num; ?>][health_date]"></td>
                    <td>
                        <a href="javascript:;" class="btn" onclick="onDelete(this);">删除</a>
                        <a href="javascript:;" class="btn" onclick="add_tr();">添加行</a>
                    </td>
                </tr>
                <?php $num++; ?>
            </table>
            <table class="mt15">
                <tr style="text-align:center;">
                    <td colspan="6"><?php echo show_shenhe_box(array('baocun'=>'保存')); ?></td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    var num = <?php echo $num; ?>;
    var team = '<?php echo $team; ?>';
    var team_num = '<?php echo $gamedata->number_of_member; ?>';
    function add_tr(){
        var sign_num = <?php echo $sign_num; ?>;
        var tr_len = $('.tr_len').length;
        var s_html = 
            '<tr class="tr_len">'+
                '<td><input type="text" class="input-text onkeyup" name="add_form['+num+'][sign_account]" maxlength="6" oninput="oninputQuery(this,'+num+');" onpropertychange="oninputQuery(this,'+num+');"></td>'+
                '<td><input type="text" class="input-text" id="name_'+num+'"></td>'+
                '<td><input type="text" class="input-text" name="add_form['+num+'][sign_sname]"></td>'+
                '<td><input type="text" class="input-text" name="add_form['+num+'][athlete_rank]" id="athlete_rank_'+num+'"></td>'+
                '<td><input type="text" class="input-text time" name="add_form['+num+'][health_date]"></td>'+
                '<td>'+
                    '<a href="javascript:;" class="btn" onclick="onDelete(this);">删除</a>&nbsp;'+
                    '<a href="javascript:;" class="btn" onclick="add_tr();">添加行</a>'+
                '</td>'+
            '</tr>';
            // console.log('88',team_num-(sign_num+tr_len));
        if(team_num-(sign_num+tr_len)>0){
            $('#table_tag').append(s_html);
            num++;
        }
        else{
            we.msg('minus','报名成员已到最大数');
        }
    }

    function onDelete(op){
        $(op).parent().parent().remove();
        if($('.tr_len').length<1){
            add_tr();
        }
    }

    $('body').on('click','.time', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });

    $('#baocun').on('click',function(){
        var a = confirm('是否保存？');
        if(a==true){
            var is_ok = true;
            $('.onkeyup').each(function(){
                if($(this).val()=='' || $(this).val().length<5){
                    is_ok = false;
                }
            });
            if(!is_ok){
                we.msg('minus','请填写账号信息');
                return false;
            }
        }
        else{
            return false;
        }
    });

    function as(){
        console.log('110');
        we.msg('minus','请填写账号等信息');
        return false;
    }

    var s = 0;
    function oninputQuery(obj,n){
        var changval = $(obj).val();
        if(changval.length==5 || changval.length==6){
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('validate',array('game_id'=>$_REQUEST['game_id'],'data_id'=>$_REQUEST['data_id']));?>&gf_account='+changval,
                dataType: 'json',
                success: function(data) {
                    if(data.status==1){
                        $('#name_'+n).val(data.ZSXM);
                        $('#athlete_rank_'+n).val(data.nathlete_rankame);
                    }
                    else{
                        if(changval.length==6){
                            $(obj).val('');
                            s = 1;
                        }
                        if(s>0){
                            var len = (data.msg.length>16) ? 1500 : 1000;
                            we.msg('minus', data.msg, '', len);
                            s = 0;
                        }
                    }
                }
            });
        }
    }
</script>