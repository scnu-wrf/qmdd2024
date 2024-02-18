<?php //var_dump($_SESSION);?>
<div class="box">
    <div class="box-title c">
        <h1>
            当前界面：系统 》体育豆 》体育豆赠送管理 》
            <?php 
                if($_REQUEST['index']==1){
                    echo '添加方案';
                }elseif($_REQUEST['index']==2){
                    echo '待审核';
                }elseif($_REQUEST['index']==3){
                    echo '审核';
                }elseif($_REQUEST['index']==4){
                    echo '审核';
                }else{
                    echo '详情';
                }
            ?>
        </h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <div class="box-detail-bd">
                <table style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="8">基本信息</td>
                    </tr>
                    <tr>
                        <td style="width:10%;"><?php echo $form->labelEx($model,'code'); ?></td>
                        <td>
                            <?php echo $form->textField($model,'code',array('class'=>'input-text')); ?>
                            <?php echo $form->error($model,'code',$htmlOptions = array()); ?>
                        </td>
                        <td style="width:10%;"><?php echo $form->labelEx($model,'name'); ?></td>
                        <td>
                            <?php echo $form->textField($model,'name',array('class'=>'input-text')); ?>
                            <?php echo $form->error($model,'name',$htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:10%;"><?php echo $form->labelEx($model,'admin_id'); ?></td>
                        <td>
                            <?php if(empty($model->id)){?>
                                <span class="label-box">
                                    <?php  echo get_session('admin_name'); ?>
                                    <?php echo $form->hiddenField($model, 'admin_id', array('value' => get_session('admin_id'))); ?>
                                </span>
                            <?php }else{?>
                                <span class="label-box">
                                    <?php  echo $model->admin_gfnick; ?>
                                    <?php echo $form->hiddenField($model, 'admin_id', array('class' => 'input-text')); ?>
                                </span>
                            <?php }?>
                            <?php echo $form->error($model, 'admin_id', $htmlOptions = array()); ?>
                        </td>
                        <td style="width:10%;"><?php echo $form->labelEx($model,'f_username'); ?></td>
                        <td>
                            <?php echo $form->textField($model,'f_username',array('class'=>'input-text')); ?>
                            <?php echo $form->error($model,'f_username',$htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:10%;"><?php echo $form->labelEx($model,'add_time'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'add_time', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'add_time', $htmlOptions = array()); ?>
                        </td>
                        <td style="width:10%;"><?php echo $form->labelEx($model,'check_time'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'check_time', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model,'check_time',$htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width='10%'><?php echo $form->labelEx($model, 'opinion'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textArea($model, 'opinion', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'opinion', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width='10%'><?php echo $form->labelEx($model, 'remark'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textArea($model, 'remark', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'remark', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <div class="box-table data_box" style="padding:0;">
                    <table class="list mt15" style="border-collapse: collapse;border-spacing: 0;">
                        <thead>
                            <tr class="table-title">
                                <td colspan="4" style='border-color:#ccc;padding:10px;'>会员信息</td>
                                <?php if(empty($model->id)||$model->state==721){?>
                                    <td colspan="" style='text-align: center;border-color:#ccc;padding:5px;' >
                                        <input type="button" class="btn" onclick="add_member();" value="添加账号">
                                    </td>
                                <?php }?>
                            </tr>
                            <tr class="table-title">
                                <th>GF账号/管理账号</th>
                                <th>姓名/名称</th>
                                <th>赠豆数量</th>
                                <th style="width: 300px;">备注</th>
                                <?php if(empty($model->id)||$model->state==721){?>
                                    <th style="width: 150px;">操作</th>
                                <?php }?>
                            </tr>
                        </thead>
                        <?php $index=0;if(!empty($data))foreach($data as $v){?>
                            <tr class="data" data-index="<?= $index;?>">
                                <?php if($v->got_beans_gfid>0){?>
                                    <input class="got_beans_gfid" name="attr_data[<?= $index;?>][got_beans_gfid]" type="hidden" value="<?= $v->got_beans_gfid;?>">
                                    <?php 
                                        $g=GfUser1::model()->find('GF_ID='.$v->got_beans_gfid);
                                        if(!empty($g)){
                                            echo '<td>'.$g->GF_ACCOUNT.'</td><td>'.$g->GF_NAME.'</td>';
                                        }
                                    ?>
                                <?php }elseif($v->got_beans_clubid>0){?>
                                    <input class="got_beans_clubid" name="attr_data[<?= $index;?>][got_beans_clubid]" type="hidden" value="<?= $v->got_beans_clubid;?>">
                                    <?php 
                                        $c=ClubList::model()->find('id='.$v->got_beans_clubid);
                                        if(!empty($c)){
                                            echo '<td>'.$c->club_code.'</td><td>'.$c->club_name.'</td>';
                                        }
                                    ?>
                                <?php }?>
                                <td>
                                    <input class="input-text" name="attr_data[<?= $index;?>][got_beans_num]" type="text" value="<?= $v->got_beans_num;?>">
                                </td>
                                <td>
                                    <textarea class="input-text" style="height:16px;overflow:hidden;" name="attr_data[<?= $index;?>][remark]"><?= $v->remark;?></textarea>
                                </td>
                                <?php if(empty($model->id)||$model->state==721){?>
                                    <td>
                                        <input class="btn remove_data" type="button" value="删除">
                                    </td>
                                <?php }?>
                            </tr>
                        <?php $index++;}?>
                    </table>
                </div>
                <table class="mt15">
                    <tr>
                        <td width="10%;">操作</td>
                        <td colspan="5">
                            <?php if(!empty($model->id)){?>
                                <?php if($model->state==371){
                                    if(!empty($_REQUEST['index'])&&$_REQUEST['index']==2){
                                        echo show_shenhe_box(array('quxiao'=>'撤销申请')).'<button class="btn" type="button" onclick="we.back();">取消</button>';
                                    }else{
                                        echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过')).'<button class="btn" type="button" onclick="we.back();">取消</button>';
                                    }
                                }elseif($model->state==721){
                                    echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核')).'<button class="btn" type="button" onclick="we.back();">取消</button>';
                                }else{
                                    echo $model->state_name;
                                };?>
                            <?php }else{?>
                                <?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));?>
                                <button class="btn" type="button" onclick="we.back();">取消</button>
                            <?php }?>
                        </td>
                    </tr>
                </table>
            </div>
        <?php $this->endWidget();?>
    </div>
</div>
<script>
    $('#BeansSendInfo_add_time,#BeansSendInfo_check_time').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});
    });

    var add_html = 
        '<div id="add_format" style="width:500px;">'+
            '<form id="add_form" name="add_form">'+
                '<table class="list" id="table_tag" style="width:100%;border: solid 1px #d9d9d9;table-layout:auto;">'+
                    '<thead>'+
                        '<tr>'+
                            '<td style="width:100px;padding: 5px;">账号类型&nbsp;&nbsp;</td>'+
                            '<td>'+
                            '<span class="check">'+
                            '<input class="input-check qType" id="gfUser" name="qType" type="radio" value="0" checked>'+
                            '<label for="gfUser">GF会员</label>&nbsp;&nbsp;'+
                            '<input class="input-check qType" id="club" name="qType" type="radio" value="1">'+
                            '<label for="club">单位</label>&nbsp;&nbsp;'+
                            '</span>'+
                            '</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td style="width:100px;padding: 5px;">账号</td>'+
                            '<td><input id="account" class="input-text" type="text" ></td>'+
                        '</tr>'+
                    '</thead>'+
                '</table>'+
            '</form>'+
        '</div>';

    function add_member(){
        if_data=0;
        $.dialog({
            id:'tianjia',
            lock:true,
            opacity:0.3,
            height: '60%',
            // width:'80%',
            title:'选择',
            content:add_html,
            button:[
                {
                    name:'保存',
                    callback:function(){
                        return fn_add_tr();
                    },
                    focus:true
                },
                {
                    name:'取消',
                    callback:function(){
                        return true;
                    }
                }
            ]
        });
        $('.aui_main').css('height','auto');
    }

    function fn_add_tr(){
        var changval=$("#account").val();
        var val = $('input[name="qType"]:checked').val();
        if(val==0){
            showGfUser(changval);
        }else{
            showClub(changval);
        }
        return false;
    }

    function showGfUser(id){
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('validate'); ?>&gf_account='+id,
            dataType: 'json',
            success: function(e) {
                console.log(e)
                if(e.error==0){
                    var datas=e.datas[0];
                    if($(".data").length==0){
                        var length=$(".data").length;
                    }else{
                        var length=parseInt($(".data").last().attr('data-index'))+1;
                    }
                    if($(".got_beans_gfid[value='"+datas.GF_ID+"']").length>0){
                        we.msg('minus','该账号已添加，请勿重复添加');
                    }else{
                        var content='';
                        content+='<tr class="data" data-index="'+length+'">';
                        content+='<input class="got_beans_gfid" name="attr_data['+length+'][got_beans_gfid]" type="hidden" value="'+datas.GF_ID+'">';
                        content+='<td>'+datas.GF_ACCOUNT+'</td>';
                        content+='<td>'+datas.GF_NAME+'</td>';
                        content+='<td><input class="input-text" name="attr_data['+length+'][got_beans_num]" type="text" ></td>';
                        content+='<td><textarea class="input-text" style="height:16px;overflow:hidden;" name="attr_data['+length+'][remark]" ></textarea></td>';
                        content+='<td><input class="btn remove_data" type="button" value="删除"></td>';
                        content+='</tr>';
                        $(".data_box .list").append(content);
                        $(".aui_state_highlight").next().click();
                        
                    }
                }else{
                    we.msg('minus', e.msg);
                    return false;
                }
            }
        });
    }

    function showClub(id){
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('exist');?>&code='+id,
            dataType: 'json',
            success: function(e) {
                console.log(e)
                if(e.error==0){
                    var datas=e.datas[0];
                    if($(".data").length==0){
                        var length=$(".data").length;
                    }else{
                        var length=parseInt($(".data").last().attr('data-index'))+1;
                    }
                    if($(".got_beans_clubid[value='"+datas.id+"']").length>0){
                        we.msg('minus','该账号已添加，请勿重复添加');
                    }else{
                        var content='';
                        content+='<tr class="data">';
                        content+='<input class="got_beans_clubid" name="attr_data['+length+'][got_beans_clubid]" type="hidden" value="'+datas.id+'">';
                        content+='<td>'+datas.club_code+'</td>';
                        content+='<td>'+datas.club_name+'</td>';
                        content+='<td><input class="input-text" name="attr_data['+length+'][got_beans_num]" type="text" ></td>';
                        content+='<td><textarea class="input-text" style="height:16px;overflow:hidden;" name="attr_data['+length+'][remark]" ></textarea></td>';
                        content+='<td><input class="btn remove_data" type="button" value="删除"></td>';
                        content+='</tr>';
                        $(".data_box .list").append(content);
                        $(".aui_state_highlight").next().click();
                    }
                }else{
                    we.msg('minus', e.msg);
                    return false;
                }
            }
        });
    }

    $(document).on("click",".remove_data",function(){
        $(this).parent().parent().remove();
    })
    
    // 网页内按下回车触发
    document.onkeydown=function(event){
        if(event.keyCode==13){
            return false;                               
        }
    }

</script>