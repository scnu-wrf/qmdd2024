<?php 
    $team=665;
    if(isset($model->game_play_id)){
        if(!empty($model->game_list_data->game_player_team)){
            $model->game_play_id = $model->game_list_data->id;
            $team=$model->game_list_data->game_player_team;//'个人团队，类型ID 665-个人 666-团队',
        }
    }
    if(!isset($_REQUEST['p_id'])){
        $_REQUEST['p_id']=1;
    }
    if(!isset($model->id)) $model->id=0;
    $time='0000-00-00 00:00:00';
    if(!empty($model->votes_star_time==$time)){
        $model->votes_star_time='';
    }
    if(!empty($model->votes_end_time==$time)){
        $model->votes_end_time='';
    }
    if(!empty($model->star_time==$time)){
        $model->star_time='';
    }
    if(!empty($model->end_time==$time)){
        $model->end_time='';
    }
    if(!isset($_REQUEST['data_id'])){
        $_REQUEST['data_id']=0;
    }
    if(!isset($_REQUEST['len'])){
        $_REQUEST['len']=0;
    }
    if(!empty($model->game_data_id)){
        $game_data=GameListData::model()->find('id='.$model->game_data_id);
    }
    else {
        $game_data=GameListData::model()->find('id='.$_REQUEST['data_id']);
    }
?>
<div class="box">
    <div id="t0" class="box-title c">
        <h1><i class="fa fa-table"></i><?php if($game_data){?><?php echo $game_data->game_name; ?> - <?php echo $game_data->game_data_name?> - 赛事成绩<?php }?></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回列表</a></span>
    </div><!--box-title end-->
    <div id="t1" class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                    <tr class="table-title">
                        <td colspan="4">赛事信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_name'); ?></td>
                        <td>
                            <span><?php if($model->game_name!=null){?><?php echo $form->hiddenField($model, 'game_name', array('class' => 'input-text')); ?><span class="label-box"><?php echo $model->game_name;?></span><?php } else { ?><?php echo $form->hiddenField($model, 'game_name', array('class' => 'input-text', 'value'=>$game_data->game_id)); ?><span class="label-box"><?php echo $game_data->game_name;?></span> <?php }?></span>
                        </td>
                        <td><?php echo $form->labelEx($model, 'project_id'); ?></td>
                        <td>						
                            <span><?php if($model->game_list_data!=null){?><?php echo $form->hiddenfield($model, 'project_id', array('class' => 'input-text')); ?><span class="label-box"><?php echo $game_data->project_name;?></span><?php } else {?><?php echo $form->hiddenfield($model, 'project_id', array('class' => 'input-text', 'value'=>$game_data->project_id)); ?><span class="label-box"><?php echo $game_data->project_name;?></span><?php } ?></span>
                        </td>
                    </tr>
                    <tr>
                        <?php if($model->id=='') {?>
                        <td style="display:none">
                            <?php echo $form->hiddenField($model, 'fater_id', array('class' => 'input-text', 'value'=>$_REQUEST["pid"])); ?>
                        </td>
                        <?php }?>
                        <td><?php echo $form->labelEx($model, 'game_data_id'); ?></td>
                        <td colspan="3">
                            <span><?php if($model->game_list_data!=null){?><?php echo $form->hiddenfield($model, 'game_data_id', array('class' => 'input-text')); ?><span class="label-box"><?php echo $model->game_list_data->game_data_name;?></span><?php } else {?><?php echo $form->hiddenfield($model, 'game_data_id', array('class' => 'input-text', 'value'=>$_REQUEST['data_id'])); ?><span class="label-box"><?php echo $game_data->game_data_name;?></span><?php } ?></span>                       
                        </td>
                        <td style="display:none;"><?php echo $form->hiddenField($model, 'game_play_id', array('class' => 'input-text')); ?></td>
                    </tr>
                </table>
                <br>
                <table>
                    <tr class="table-title">
                        <td colspan="4">赛程信息</td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->labelEx($model, 'arrange_tcode'); ?>&nbsp;&nbsp;
                            <span class="span_tip">
                                <a href="javascript:;" class="dis_rounds"><i class="fa fa-question"></i></a>
                                <div class="tip" style="width:200px;">
                                    <p>数据取赛事编码相同位数并大于7位数编码</p>
                                    <i class="t"></i>
                                </div>
                            </span>
                        </td>
                        <td><?php echo $model->arrange_tcode; ?></td>
                        <td><?php echo $form->labelEx($model, 'game_format'); ?></td>
                        <td><?php if($model->game_format) echo $model->base_code_game_format->F_NAME; ?></td>
                        <!--<td><?php echo $form->labelEx($model, 'game_over'); ?></td>
                        <td><?php echo $model->game_over_name; ?></td>-->
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'team_name'); ?></td>
                        <td><?php echo $model->team_name; ?></td>
                        <td><?php echo $form->labelEx($model, 'game_site'); ?></td>
                        <td><?php echo $model->game_site;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'rounds'); ?></td>
                        <td><?php echo $model->rounds; ?></td>
                        <td><?php echo $form->labelEx($model, 'matches'); ?></td>
                        <td><?php echo $model->matches; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'describe'); ?></td>
                        <td colspan="3"><?php echo $model->describe; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'star_time'); ?></td>
                        <td><?php echo $model->star_time; ?></td>
                        <td><?php echo $form->labelEx($model, 'end_time'); ?></td>
                        <td><?php echo $model->end_time; ?></td>
                    </tr>
                </table>
                <table class="mt15">
                    <tr>
                        <td colspan="4" style="background:#efefef;">投票设置</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'if_votes'); ?></td>
                        <td colspan="3"><?php echo $form->hiddenField($model, 'if_votes', array('class' => 'input-text')); ?><?php echo $model->if_votes_name; ?></td>
                    </tr>
                    <tr id="vote_time" style="display:none"><!--开通投票时打开-->
                        <td><?php echo $form->labelEx($model, 'votes_star_time'); ?></td>
                        <td><?php echo $model->votes_star_time; ?></td>
                        <td><?php echo $form->labelEx($model, 'votes_end_time'); ?></td>
                        <td><?php echo $model->votes_end_time; ?></td>
                    </tr>
                </table>
                <?php echo $form->hiddenField($model, 'team_data', array('class' => 'input-text')); ?>
                <table class="mt15">
                    <tr class="table-title">
                        <td colspan="9">参赛团队/成员成绩</td>
                    </tr>
                </table>
                <table id="team_data" class="mt15" style="margin-top:0;">
                    <tr>
                        <td><?php echo $form->labelEx($model, 'school_report'); ?></td>
                        <td colspan="5">
                            <?php echo $form->hiddenField($model, 'school_report', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(198);$picprefix=''; if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->school_report!=''){?>
                                <div class="upload_img fl" id="upload_pic_GameListArrangeScore_school_report">
                                    <a href="<?php echo $basepath->F_WWWPATH.$model->school_report;?>" target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$model->school_report;?>">
                                    </a>
                                </div>
                            <?php }?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_school_report','<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'school_report', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>签号</td>
                        <td>参赛团队/成员</td>
                        <td>本场成绩</td>
                        <td>比赛积分</td>
                        <td>当场名次</td>
                        <td>赛事结果</td>
                    </tr>
                    <?php
                        $type = ($model->game_player_id==665) ? 'sign_id' : 'team_id';
                        $name = $model->game_player_id==665 ? 'sign_name' : 'team_name';
                    ?>
                    <tr>
                        <td><?php echo $form->textField($model, 'arrange_tcode',array('class'=>'input-text','readonly'=>'readonly')); ?></td>
                        <td><?php echo $form->textField($model, $name,array('class'=>'input-text','readonly'=>'readonly')); ?></td>
                        <td><?php echo $form->textField($model, 'game_mark',array('class'=>'input-text','readonly'=>'readonly')); ?></td>
                        <td><?php echo $form->textField($model, 'game_score',array('class'=>'input-text','readonly'=>'readonly')); ?></td>
                        <td><?php echo $form->textField($model, 'game_order',array('class'=>'input-text','readonly'=>'readonly')); ?></td>
                        <td><?php if(!empty($model->is_promotion))echo $model->base_is_promotion->F_NAME; ?></td>
                    </tr>
                </table>
                <table class="mt15">
                    <tr class="table-title">
                        <td colspan="4">审核信息</td>
                    </tr>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                        <td colspan='3'>
                            <?php echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text' )); ?>
                            <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr class="dis_btn">
                        <td>可执行操作</td>
                        <td colspan="3">
                            <?php if($_REQUEST['p_id']!=0) echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核','tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                            <!-- <button class="btn" type="reset" title="此处重置仅能对本场成绩、当前名次进行重置">重置</button> -->
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                            <button class="btn" type="button" onclick="printpage();" title="保存后可打印">打印</button>
                        </td>
                    </tr>
                </table>
                <table class="showinfo">
                    <tr>
                        <td style="width:20%;">操作时间</td>
                        <td style="width:20%;">操作人</td>
                        <td style="width:20%;">状态</td>
                        <td>操作备注</td>
                    </tr>
                    <tr>
                        <td><?php echo $model->uDate; ?></td>
                        <td><?php echo $model->state_qmddname; ?></td>
                        <td><?php echo $model->state_name; ?></td>
                        <td><?php echo $model->reasons_failure; ?></td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
<div id="dialog2" title="百度地图" style="display: none;"></div>
<script>
    $('#GameListArrange_star_time').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
    $('#GameListArrange_end_time').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss '});});
    $('#GameListArrange_votes_star_time').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
    $('#GameListArrange_votes_end_time').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss '});});

    $(function(){
        var votestype=$('#GameListArrangeScore_if_votes').val();
        var vote_time=$('#vote_time');
        if(votestype==649){
            $('#vote_time').show();
        }
        else{
            $('#vote_time').hide();
        }
    });
</script>
<script>
    function printpage(){
        var html='';
        for(var i=0;i<2;i++){
            html += '<table>'+$("#t"+i).html()+"</table>";
            if(i==1 || i==2);
        }
        
        var newWin = window.open('', '', '');
        newWin.document.write('<head>\
            <style>\
                .box-detail table{\
                    table-layout:fixed;\
                    width:100%;\
                    border-spacing:1px;\
                    border-collapse:collapse;\
                    background:#ccc;}\
                .box-detail td{\
                    padding:10px;\
                    background:#fff;\
                    border: 1px solid black;\
                    text-align:left;}\
                .box-detail table.table-title{\
                    border-collapse:collapse;\
                    border-top:1px #ccc solid;\
                    border-right:1px #ccc solid;\
                    border-left:1px #ccc solid;}\
                .table-title td{background:#efefef;}\
                .box-title {border-bottom: 1px #ddd solid;}\
                .btn {display:none;}\
                .dis_btn {display:none;}\
                .span_tip {display:none;}\
                .mt15 {margin-top:15px;}\
                .input-text {border:none;}\
                .showinfo {margin-top:15px;}\
                .showinfo tr td {text-align:center;}\
                #team_data .input-text {width:90%;overflow-y:hidden;}\
                #team_data,#team_data tr td input {color:black!important;}\
                #team_data tr:nth-of-type(n+2) td {text-align:left;}\
                h1 {font-size:18px;}\
                textarea{resize:none;}\
                select {appearance:none;-webkit-appearance:none;border:none;}\
            </style>\
        </head>');
        newWin.document.write('<div><div class="box-detail">'+html+'</div></div>');
        newWin.print();
        newWin.close(); //关闭新产生的标签页
    }
</script>
