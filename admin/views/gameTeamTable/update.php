<?php
    //include_once $qmdd_init_file;
    if(!isset($_REQUEST['data_id'])){
        $_REQUEST['data_id']=0;
    }
    if(!isset($_REQUEST['game_id'])){
        $_REQUEST['game_id']=0;
    }
    if(!isset($_REQUEST['p_id'])){
        $_REQUEST['p_id']=1;
    }
    if(!empty($model->sign_game_data_id)) {
        $gamedata=GameListData::model()->find('id='.$model->sign_game_data_id);
    } else {
        $gamedata=GameListData::model()->find('id='.$_REQUEST['data_id']);
    }
    if(!empty($gamedata)) {
        $data_type=$gamedata->game_player_team;
    } else {
        $data_type=0;
    }
?>  
<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>团队详情</h1>
        <?php if ($_REQUEST['data_id']>0) { ?>
            <span class="back">
                <a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gameTeamTable/player',array('game_id'=>$_REQUEST['game_id'],'data_id'=>$_REQUEST['data_id'])); ?>');"><i class="fa fa-reply"></i>返回</a>
            </span>
        <?php } ?>
    </div><!--box-title end-->
    <div class="box-detail-tab">
        <ul class="c">
            <?php $action=Yii::app()->controller->getAction()->id;?>
            <li class="current"><a href="<?php echo $this->createUrl('gameTeamTable/update',array('data_id'=>$_REQUEST['data_id'],'game_id'=>$_REQUEST['game_id']));?>">基本信息</a></li>
            <?php if(!empty($model->id)) { ?>
            <li><a href="<?php echo $this->createUrl('gameSignList/index_team',array('data_id'=>$_REQUEST['data_id'],'game_id'=>$_REQUEST['game_id'],'team_id'=>$model->id,'data_type'=>$data_type,'state'=>$model->state,'p_id'=>$_REQUEST['p_id']));?>">成员信息</a></li><?php } ?>
        </ul>
    </div><!--box-detail-tab end-->  
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
    <input type="hidden" name="data_id" value="<?php echo $_REQUEST["data_id"];?>">
        <div class="box-detail-bd">
            <table style="table-layout:auto;">
                <tr class="table-title">
                	<td colspan="4">赛事信息</td>
                </tr>
                <?php if(!empty($gamedata)) echo $form->hiddenField($model, 'money', array('value'=>$gamedata->game_money)); ?>
                <?php echo $form->hiddenField($model, 'data_type', array('class' => 'input-text','value'=>$data_type)); ?>
                <tr>
                	<td style="width:15%;"><?php echo $form->labelEx($model, 'game_id'); ?></td>
                    <td style="width:35%;">
                        <span id="game_box">
                            <?php if($model->game_id!=null){?>
                                <?php echo $form->hiddenField($model, 'game_id', array('class' => 'input-text')); ?>
                                <span class="label-box"><?php echo $model->game_name;?></span>
                            <?php } else { if(!empty($gamedata)) {?>
                                <?php echo $form->hiddenField($model, 'game_id', array('class' => 'input-text', 'value'=>$gamedata->game_id)); ?>
                                <span class="label-box"><?php echo $gamedata->game_name;?></span>
                            <?php } }?>
                        </span>
                    </td>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'sign_project_id'); ?></td>
                    <td style="width:35%;">						
                        <span id="sign_box">
                            <?php if($model->project_list!=null){?>
                                <?php echo $form->hiddenfield($model, 'sign_project_id', array('class' => 'input-text')); ?>
                                <span class="label-box"><?php echo $model->sign_project_name;?></span>
                            <?php } else { if(!empty($gamedata)) {?>
                                <?php echo $form->hiddenfield($model, 'sign_project_id', array('class' => 'input-text', 'value'=>$gamedata->project_id)); ?>
                                <span class="label-box"><?php echo $gamedata->project_name;?></span>
                            <?php } }?>
                        </span>
                    </td>
                    <?php echo $form->error($model, 'game_id', $htmlOptions = array()); ?>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'sign_game_data_id'); ?></td>
                    <td colspan="3">
                        <span id="sign_box">
                            <?php if($model->game_list_data!=null){?>
                                <?php echo $form->hiddenfield($model, 'sign_game_data_id', array('class' => 'input-text')); ?>
                                <span class="label-box"><?php echo $model->game_list_data->game_data_name;?></span>
                            <?php } else { if(!empty($gamedata)) {?>
                                <?php echo $form->hiddenfield($model, 'sign_game_data_id', array('class' => 'input-text', 'value'=>$_REQUEST['data_id'])); ?>
                                <span class="label-box"><?php echo $gamedata->game_data_name;?></span>
                            <?php } }?>
                        </span>                       
                    </td>
                    <!-- <td><?php //echo $form->labelEx($model, 'order_num'); ?></td> -->
                    <!-- <td><?php //echo $model->order_num; ?></td> -->
                </tr>
            </table>
            <table class="mt15" style="table-layout:auto;">
            	 <tr class="table-title">
                	<td colspan="4">团队信息</td>
                </tr>
                <tr>
                    <td style="width:15%;"><?php echo $form->labelEx($model,'code'); ?></td>
                    <td style="width:35%;">
                        <?php echo $form->textField($model,'code',array('class'=>'input-text')); ?>
                        <?php echo $form->error($model,'code',$htmlOptions = array()); ?>
                    </td>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'name'); ?></td>
                    <td style="width:35%;">
                        <?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'name', array('class' => 'input-text')) : $model->name; ?>
                        <?php echo $form->error($model, 'name', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'logo'); ?></td>
                 	<td>
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
                        <?php if($_REQUEST['p_id']!=0) {?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_logo', '<?php echo $picprefix;?>');</script>
                        <?php }?>
                        <?php echo $form->error($model, 'logo', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'tvname'); ?></td>
                    <td>
                        <?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'tvname', array('class' => 'input-text')) : $model->tvname; ?>
                        <div class="msg">注：用于大屏、电视字幕显示</div>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'game_money') ?></td>
                    <td>
                        <?php
                            $game_money = GameListData::model()->find('id='.$_REQUEST['data_id']);
                            if(!empty($game_money)){
                                echo $form->hiddenField($model,'game_money',array('value'=>$game_money->game_money));
                                echo $game_money->game_money;
                            }
                        ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'add_time'); ?></td>
                    <td><?php echo $model->add_time; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'is_pay'); ?></td>
                    <td colspan="3"><?php echo $model->is_pay_name; ?></td>
                </tr>
            </table>
            <table class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="4">审核信息</td>
                </tr>
                <tr>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'state'); ?></td>
                    <td style="width:35%;"><?php echo $model->state_name; ?></td>
                    <td style="width:15%;">可执行操作</td>
                    <td style="width:35%;" colspan="">
                        <?php
                            if($_REQUEST['p_id']!=0){
                                if($model->state==371 && !empty($model->id)){
                                    echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过'));
                                }
                                else if($model->state==721 || empty($model->id)){
                                    echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));
                                }
                            }
                        ?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    $(function(){
        // 选择赛事
        var $game_box=$('#game_box');
        var $GameTeamTable_game_id=$('#GameTeamTable_game_id');
        $('#game_select_btn').on('click', function(){
            $.dialog.data('game_id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/gameList", array('game_type'=>0));?>',{
                id:'danwei',
                lock:true,
                opacity:0.3,
                title:'选择具体内容',
                width:'500px',
                height:'60%',
                close: function () {
                    //console.log($.dialog.data('club_id'));
                    if($.dialog.data('game_id')>0){
                        game_id=$.dialog.data('game_id');
                        $GameTeamTable_game_id.val($.dialog.data('game_id')).trigger('blur');
                        $game_box.html('<span class="label-box">'+$.dialog.data('game_title')+'</span>');
                    }
                }
            });
        });

        // 选择赛事项目
        var $sign_box=$('#sign_box');
        var $GameTeamTable_sign_game_data_id=$('#GameTeamTable_sign_game_data_id');
        $('#sign_select_btn').on('click', function(){
            var gfid = $GameTeamTable_game_id.val();
            if(gfid==''){
                we.msg('minus', '请选择赛事');
                return;
            }
            $.dialog.data('game_list_id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/gameListData");?>&game_id='+$GameTeamTable_game_id.val(),{
                id:'danwei',
                lock:true,
                opacity:0.3,
                title:'选择具体内容',
                width:'500px',
                height:'60%',
                close: function () {
                    //console.log($.dialog.data('club_id'));
                    if($.dialog.data('game_list_id')>0){
                        sign_project_id=$.dialog.data('game_list_id');
                        $GameTeamTable_sign_game_data_id.val($.dialog.data('game_list_id')).trigger('blur');
                        $sign_box.html('<span class="label-box">'+$.dialog.data('game_list_title')+'</span>');
                    }
                }
            });
        });
    
        // 选择单位
        var $club_box=$('#club_box');
        var $GameTeamTable_club_id=$('#GameTeamTable_club_id');
        $('#club_select_btn').on('click', function(){
            $.dialog.data('club_id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/club", array('club_type'=>8,9,189));?>',{
                id:'danwei',
                lock:true,
                opacity:0.3,
                title:'选择具体内容',
                width:'500px',
                height:'60%',
                close: function () {
                    //console.log($.dialog.data('club_id'));
                    if($.dialog.data('club_id')>0){
                        club_id=$.dialog.data('club_id');
                        $GameTeamTable_club_id.val($.dialog.data('club_id')).trigger('blur');
                        $club_box.html('<span class="label-box">'+$.dialog.data('club_title')+'</span>');
                    }
                }
            });
        });
    });
</script>