<?php
    if(!isset($_REQUEST['game_id'])){
        $_REQUEST['game_id']=0;
    }
    if(!isset($_REQUEST['project_id'])){
        $_REQUEST['project_id']=0;
    }
    if(!isset($_REQUEST['p_id'])){
        $_REQUEST['p_id']=1;
    }

    if(!empty($model->sign_game_data_id) || $model->sign_game_data_id!=0){
        $gamedata=GameListData::model()->find('id='.$model->sign_game_data_id);
    }
    if(!empty($model->referee_gfid)) {
		$user=GfUser1::model()->find('GF_ID='.$model->referee_gfid);
    }
    $disabled = ($_REQUEST['p_id']==0) ? 'disabled' : '';
?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回裁判列表</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="4">赛事信息</td>
                </tr>
                <tr>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'order_num'); ?></td>
                    <td style="width:35%;"><?php echo $model->order_num; ?></td>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'game_id'); ?></td>
                    <td style="width:35%;">
                        <?php echo $form->dropDownList($model,'game_id',Chtml::listData($game_id,'id','game_title'),array('prompt'=>'请选择', 'onchange'=>'"changeGameid(this);"')); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'project_id'); ?></td>
                    <td>
                        <?php echo $form->dropDownList($model,'project_id',Chtml::listData(ProjectList::model()->getProject(),'id','project_name'),array('prompt'=>'请选择')); ?>
                    </td>
                	<td><?php echo $form->labelEx($model, 'sign_game_data_id'); ?></td>
                    <td>
                        <?php echo $form->dropDownList($model,'sign_game_data_id',Chtml::listData(GameListData::model()->findAll('game_id='.$model->game_id.' '),'id','game_data_name'),array('prompt'=>'请选择')); ?>
                    </td>
                </tr>
            </table>
            <br/>
            <table style="table-layout:auto;">
                <tr class="table-title">
                	<td colspan="4">裁判信息</td>
                </tr>
                <tr>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'referee_gfaccount'); ?></td>
                    <td style="width:35%;"><?php echo $form->hiddenField($model, 'referee_gfid'); ?>                       
                        <?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'referee_gfaccount', array('class' => 'input-text','oninput' =>'accountOnchang(this)','onpropertychange' =>'accountOnchang(this)')) : $model->referee_gfaccount; ?>
                        <?php echo $form->error($model, 'referee_gfaccount', $htmlOptions = array()); ?>
                    </td>
                    <td style="width:15%;">联系电话</td>
                    <td style="width:35%;" id='phone'><?php if(isset($user->PHONE)) {echo $user->PHONE;} ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'real_name'); ?></td>
                    <?php echo $form->hiddenField($model, 'real_name'); ?>
                    <td id='real_name'><?php echo $model->real_name; ?></td>
                    <td><?php echo $form->labelEx($model, 'sex'); ?></td>
                    <?php echo $form->hiddenField($model, 'sex'); ?>
                    <td id='sex'><?php if(!empty($model->base_code)) echo $model->base_code->F_NAME; ?></td>
                </tr>
                <tr>
                    <td>免冠头像</td>
                    <td colspan="3">
                        <?php $basepath=BasePath::model()->getPath(191);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <div id="img_box"><?php if(isset($user->IDNAME)){?><a href="<?php echo $basepath->F_WWWPATH.$user->IDNAME;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$user->IDNAME;?>" width="100" height="100"></a><?php }?></div> 
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'referee_code'); ?></td>
                    <?php echo $form->hiddenField($model, 'referee_code'); ?>
                    <td id='referee_code'>
                        <?php echo $model->referee_code; ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'referee_type'); ?></td>
                    <td>
                        <?php echo $form->dropDownList($model, 'referee_type', Chtml::listData(BaseCode::model()->getCode(650), 'f_id', 'F_NAME'), array('prompt'=>'请选择','disabled'=>$disabled)); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'send_msg'); ?></td>
                    <td colspan="3">
                        <?php echo ($_REQUEST['p_id']!=0) ? $form->textArea($model, 'send_msg', array('style' => 'width:90%;height:60px;')) : $model->send_msg; ?>
                        <?php echo $form->error($model, 'send_msg', $htmlOptions = array()); ?>
                    </td>  
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'agree_state_name'); ?>：</td>
                    <td><?php echo $model->agree_state_name; ?></td>
                    <td><?php echo $form->labelEx($model, 'send_date'); ?></td>
                    <td><?php echo $model->send_date; ?></td>
                </tr>
                <tr>
                    <td>可执行操作</td>
                    <td colspan="3">
                        <?php
                            if($_REQUEST['p_id']!=0){
                                if($model->agree_state==371 && !empty($model->id)){
                                    echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过'));
                                }
                                else if($model->agree_state==721 || empty($model->id)){
                                    echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));
                                }
                            }
                        ?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
            <table class="showinfo">
                <tr>
                    <th style="width:20%;">操作人</th>
                    <th style="width:20%;">操作时间</th>
                    <th style="width:20%;">审核状态</th>
                    <th style="width:20%;">支付状态</th>
                    <th>操作备注</th>
                </tr>
                <tr>
                    <td><?php echo get_session('club_name');?></td>
                    <td><?php echo $model->uDate; ?></td>
                    <td><?php echo $model->agree_state_name; ?></td>
                    <td></td>

                    <td></td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
    
</div><!--box end-->
<script>
    function accountOnchang(obj){
        var changval=$(obj).val();  
        if (changval.length>=6) {
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('validate');?>&gf_account='+changval,
                data: {gf_account:changval, project_id:$('#GameRefereesList_project_id').val()},
                dataType: 'json',
                success: function(data) {
                    if(data.status==1){
                        $('#GameRefereesList_sign_game_contect').val(data.contect);
                        $('#GameRefereesList_referee_gfid').val(data.gfid);
                        $('#GameRefereesList_real_name').val(data.real_name);
                        $('#GameRefereesList_sex').val(data.sex);
                        $('#GameRefereesList_referee_code').val(data.gf_code);
                        $('#phone').text(data.contect);
                        $('#sex').text(data.sex_name);
                        $('#real_name').text(data.real_name);
                        $('#referee_code').text(data.gf_code);
                        $('#img_box').html('<a href="<?php echo $basepath->F_WWWPATH;?>'+data.head_pic+'" target="_blank"><img src="<?php echo $basepath->F_WWWPATH;?>'+data.head_pic+'" width="100" height="100"></a>');
                    }else{
                        $(obj).val('');
                        we.msg('minus', data.msg);
                    }
                }
            });
        }
    }

    $(function(){
        fnUpdateClassify();
    });
    // 竞赛项目
    var $GameRefereesList_sign_game_data_id=$('#GameRefereesList_sign_game_data_id');
    var fnUpdateClassify=function(){
        var arr=[];
        var id;
        $referees_box.find('span').each(function(){
            id=$(this).attr('data-id');
            arr.push(id);
        });
        $GameRefereesList_sign_game_data_id.val(we.implode(',', arr));
    };

    var fnDeleteClassify=function(op){
        $(op).parent().remove();
        fnUpdateClassify();
    };

    // 选择竞赛项目
    var $referees_box=$('#referees_box');
    $('#referees_select_btn').on('click', function(){
        var game_id=$('#GameRefereesList_game_id').val();
        var project_id=$('#GameRefereesList_project_id').val();
        $.dialog.data('game_list_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/gameListData");?>&game_id='+game_id+'&project_id='+project_id,{
            id:'danwei',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                //console.log($.dialog.data('club_id'));
                if($.dialog.data('game_list_id')>0){
                    if($('#classify_item_'+$.dialog.data('game_list_id')).length==0){
                    $referees_box.append('<span class="label-box" id="classify_item_'+$.dialog.data('game_list_id')+'" data-id="'+$.dialog.data('game_list_id')+'">'+$.dialog.data('game_list_title')+'<i onclick="fnDeleteClassify(this);"></i></span>');
                    fnUpdateClassify();
                    } 
                }
            }
        });
    });

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
</script>