<?php
    if(!isset($_REQUEST['game_id'])){
        $_REQUEST['game_id']=0;
    }
    if(!isset($_REQUEST['data_id'])){
        $_REQUEST['data_id']=0;
    }
    $gamedata=GameListData::model()->find('id='.$_REQUEST['data_id']);
    $team = $gamedata->game_player_team;
    $sign_num = GameTeamTable::model()->count('sign_game_data_id='.$_REQUEST['data_id'].' and state=372');
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
            echo $form->hiddenField($model,'game_id',array('value'=>$_REQUEST["game_id"]));
            echo $form->hiddenField($model,'sign_game_data_id',array('value'=>$_REQUEST["data_id"]));
            echo $form->error($model,'game_id',$htmlOptions = array());
        ?>
        <div class="box-detail-bd">
            <table>
                <tr class="table-title">
                    <td><?php echo $form->labelEx($model,'game_name'); ?></td>
                    <td colspan="2"><?php echo $gamedata->game_name; ?></td>
                    <td><?php echo $form->labelEx($model,'sign_project_id'); ?></td>
                    <td colspan="2"><?php echo $gamedata->game_data_name; ?></td>
                </tr>
                <?php if($team==666) {?>
                <tr>
                    <td><?php echo $form->labelEx($model,'name'); ?></td>
                    <td colspan="3">
                        <?php echo $form->textField($model,'name',array('class'=>'input-text','style'=>'width:28%;')); ?>
                        <?php echo $form->error($model,'name',$htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model,'tvname'); ?></td>
                    <td><?php echo $form->textField($model,'tvname',array('class'=>'input-text')); ?></td>
                </tr>
                <tr>
                    <td rowspan="3"><?php echo $form->labelEx($model,'logo'); ?></td>
                    <td rowspan="3" <?php if($gamedata->game_player_team==982 || $gamedata->game_player_team==1452){ echo 'colspan="5"'; } ?>>
                        <div>
                            <?php echo $form->hiddenField($model, 'logo', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(182);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->logo!=''){?>
                                <div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_logo">
                                    <a href="<?php echo $basepath->F_WWWPATH.$model->logo;?>" target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$model->logo;?>" width="100" height="100">
                                    </a>
                                </div>
                            <?php }?> 
                        </div>
                        <script>we.uploadpic('<?php echo get_class($model);?>_logo', '<?php echo $picprefix;?>');</script>
                    </td>
                    <td><?php echo $form->labelEx($model,'coach_name'); ?></td>
                    <td><?php echo $form->textField($model,'coach_name',array('class'=>'input-text')); ?></td>
                    <td><?php echo $form->labelEx($model,'coach_phone'); ?></td>
                    <td><?php echo $form->textField($model,'coach_phone',array('class'=>'input-text onkeyup')); ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'tour_leader_name'); ?></td>
                    <td><?php echo $form->textField($model,'tour_leader_name',array('class'=>'input-text')); ?></td>
                    <td><?php echo $form->labelEx($model,'tour_leader_phone'); ?></td>
                    <td><?php echo $form->textField($model,'tour_leader_phone',array('class'=>'input-text onkeyup')); ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'team_doctor_name'); ?></td>
                    <td><?php echo $form->textField($model,'team_doctor_name',array('class'=>'input-text')); ?></td>
                    <td><?php echo $form->labelEx($model,'team_doctor_phone'); ?></td>
                    <td><?php echo $form->textField($model,'team_doctor_phone',array('class'=>'input-text onkeyup')); ?></td>
                </tr>
                <?php }?>
            </table>
            <table id="add_form" class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="8">成员信息（参赛选手的第一录入的选手为创建者）</td>
                </tr>
                <tr>
                    <td style="width:5%;">序号</td>
                    <td>GF账号</td>
                    <td>姓名</td>
                    <td>短名<br>（不是必填）</td>
                    <td>龙虎等级</td>
                    <td>体检报告有效期<br>（不是必填）</td>
                    <td>备注（团队身份、球号等）</td>
                    <td>操作</td>
                </tr>
                <?php
                    $num = 1;
                ?>
                <tr class="tr_len" style="text-align: center;">
                    <td class="sum_n"><?php echo $num; ?></td>
                    <td><input type="text" class="input-text onkeyup sign_account" id="sign_account_<?php echo $num; ?>" name="add_form[<?php echo $num; ?>][sign_account]" oninput="oninputQuery(this,<?php echo $num; ?>);" onpropertychange="oninputQuery(this,<?php echo $num; ?>);"></td>
                    <td><input type="text" class="input-text" id="name_<?php echo $num; ?>" readonly="readonly"></td>
                    <td><input type="text" class="input-text sign_sname" id="sign_sname_<?php echo $num; ?>" name="add_form[<?php echo $num; ?>][sign_sname]"></td>
                    <td>
                        <input type="hidden" class="level" id="level_<?php echo $num; ?>" name="add_form[<?php echo $num; ?>][athlete_rank]">
                        <input type="text" class="input-text athlete_rank" id="athlete_rank_<?php echo $num; ?>">
                    </td>
                    <td><input type="text" class="input-text time health_date" id="health_date_<?php echo $num; ?>" name="add_form[<?php echo $num; ?>][health_date]"></td>
                    <td><input type="text" class="input-text game_man_name" id="game_man_name_<?php echo $num; ?>" name="add_form[<?php echo $num; ?>][game_man_name]"></td>
                    <td>
                        <a href="javascript:;" class="btn" onclick="onDelete(this);">删除</a>
                        <a href="javascript:;" class="btn" onclick="add_tr();">添加行</a>
                    </td>
                </tr>
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
    var team = '<?php echo $team; ?>';
    var team_num = '<?php echo $gamedata->max_num_team; ?>';
    function add_tr(){
        var num = $('.tr_len').length;
        var sign_num = <?php echo $sign_num; ?>;
        if(num==2 && (team==982 || team==1452)){
            alert('双人或混双只能添加2条！');
            return false;
        }
        num++;
        var s_html = 
            '<tr class="tr_len" style="text-align: center;">'+
                '<td class="sum_n">'+num+'</td>'+
                '<td><input type="text" class="input-text onkeyup sign_account" id="sign_account_'+num+'" name="add_form['+num+'][sign_account]" oninput="oninputQuery(this,'+num+');" onpropertychange="oninputQuery(this,'+num+');"></td>'+
                '<td><input type="text" class="input-text name" id="name_'+num+'"></td>'+
                '<td><input type="text" class="input-text sign_sname" id="sign_sname_'+num+'" name="add_form['+num+'][sign_sname]"></td>'+
                '<td><input type="hidden" class="level" id="level_'+num+'" name="add_form['+num+'][athlete_rank]"><input type="text" class="input-text athlete_rank" id="athlete_rank_'+num+'"></td>'+
                '<td><input type="text" class="input-text time health_date" id="health_date_'+num+'" name="add_form['+num+'][health_date]"></td>'+
                '<td><input type="text" class="input-text game_man_name" id="game_man_name_'+num+'" name="add_form['+num+'][game_man_name]"></td>'+
                '<td>'+
                    '<a href="javascript:;" class="btn" onclick="onDelete(this);">删除</a>&nbsp;'+
                    '<a href="javascript:;" class="btn" onclick="add_tr();">添加行</a>'+
                '</td>'+
            '</tr>';
            // console.log('88',team_num,sign_num,num);
        if(team_num-(sign_num+num-1)>0){
            $('#add_form').append(s_html);
        }
        else{
            // we.msg('minus','报名已到最大数');
            alert('报名已到最大数');
        }
    }

    function onDelete(op){
        $(op).parent().parent().remove();
        var s = 1;
        $('.tr_len').each(function(){
            $(this).find('.sum_n').html(s);
            $(this).find('.game_man_name').attr({'name':'add_form['+s+'][game_man_name]','id':'game_man_name_'+s});
            $(this).find('.sign_account').attr({'name':'add_form['+s+'][sign_account]','oninput':'oninputQuery(this,'+s+')','onpropertychange':'oninputQuery(this,'+s+')','id':'sign_account_'+s});
            $(this).find('.name').attr('id','name_'+s);
            $(this).find('.level').attr({'id':'level_'+s,'name':'add_form['+s+'][athlete_rank]'});
            $(this).find('.sign_sname').attr({'name':'add_form['+s+'][sign_sname]','id':'sign_sname_'+s});
            $(this).find('.athlete_rank').attr({'id':'athlete_rank_'+s});
            $(this).find('.health_date').attr({'name':'add_form['+s+'][health_date]','id':'health_date_'+s});
            s++;
        });
        if($('.tr_len').length<1){
            add_tr();
        }
    }

    $('body').on('click','.time', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });

    var sexa = '';
    var sexb = '';
    var dou = ',';
    var acc = '';
    var info = '';
    function oninputQuery(obj,n){
        var changval = $(obj).val();
        if(changval.length==5 || changval.length==6){
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('validate',array('game_id'=>$_REQUEST['game_id'],'data_id'=>$_REQUEST['data_id']));?>&gf_account='+changval,
                dataType: 'json',
                success: function(data) {
                    if(data.status==1){
                        var is_true = true;
                        if(team==982 || team==1452){
                            if(n==1) sexa = data.sex;
                            if(n==2) sexb = data.sex;
                            if(team==982 && sexa==sexb){
                                info = '混双为男女搭配';
                                $(obj).val('');
                                is_true = false;
                            }
                            if(team==1452 && (sexa!='' && sexb!='' && sexa!=sexb)){
                                info = '双人为两男或两女';
                                $(obj).val('');
                                is_true = false;
                            }
                        }
                        if(team!=982 && team!=1452){
                            $('.sign_account').each(function(){
                                if($(this).val()==changval && $(this).attr('id')!=$(obj).attr('id')){
                                    info = '账号已存在';
                                    $(obj).val('');
                                    is_true = false;
                                }
                            })
                        }
                        // if(team!=982 && acc.indexOf(changval)!=-1){
                        //     $(obj).val('');
                        //     info = '账号已存在';
                        // }
                        // // console.log(sexa,sexb,acc,changval);
                        if(!is_true){
                            $('#name_'+n).val('');
                            $('#sign_sname_'+n).val('');
                            $('#level_'+n).val('');
                            $('#athlete_rank_'+n).val('');
                            $('#health_date_'+n).val('');
                            $('#game_man_name_'+n).val('');
                            we.msg('minus',info);
                            return false;
                        }
                        // if(acc!='') acc += dou;
                        // acc += changval;
                        $('#name_'+n).val(data.ZSXM);
                        $('#athlete_rank_'+n).val(data.level);
                        $('#level_'+n).val(data.level_id);
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
        if(changval.length==0){
            $(obj).find('.input-text').val('');
        }
    }

    $('body').on('keyup','.onkeyup',function(){
        if(this.value.length==1){
            this.value=this.value.replace(/[^0-9]/g,'');
        }
        else{
            this.value=this.value.replace(/\D/g,'');
        }
    });

    $('#baocun').on('click',function(){
        var a = confirm('是否保存？');
        if(a==false){
            return false;
        }
        // if(a==true){
        //     var is_ok = true;
        //     $('.onkeyup').each(function(){
        //         if($(this).val()=='' || $(this).val().length<5){
        //             is_ok = false;
        //         }
        //     });
        //     if(!is_ok){
        //         we.msg('minus','请填写账号信息');
        //         return false;
        //     }
        // }
        // else{
        //     return false;
        // }
    });
</script>