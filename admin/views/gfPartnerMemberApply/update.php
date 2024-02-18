<style>
    .box-detail-bd table{
        table-layout:auto!important;
        background-color:transparent!important;
    }
    .box-detail-bd table tr td:nth-child(2n+1){
        width:23px;
    }
    .box-detail-bd table tr td:nth-child(2n+2){
        width:300px;
    }
    .input-text,select{
        width:300px!important;
        height: 30px;
        box-sizing: border-box;
    }
</style>
<?php 
    $basepath=BasePath::model()->getPath(217);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
?>
<script>
    var type=<?php echo $_REQUEST['type'];?>
</script>
<div class="box">
    <div class="box-title c"><h1><?php if(empty($model->id)){?>邀请成员<?php }else{?><?=$_REQUEST['type']==403?'个人申请审核详情':'单位申请审核详情'?><?php }?></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <!-- <div class="box-detail-tab">
            <ul class="c">
                <li class="current" >基本信息</li>
                <li >其他信息</li>
            </ul>
        </div> -->
        <?php echo $form->hiddenField($model, 'type', array('class' => 'input-text','value' => $_REQUEST['type'])); ?>
        <div class="box-detail-bd">
            <div class="box-detail-tab-item item_center" style="display:block;">
            <table id="t0" class="mt15">
                <!-- <tr>
                    <td style="background:#efefef;" colspan="4" >入会项目</td>
                </tr> -->
                <?php if(!empty($model->id)&&$model->auth_state!=1483){?>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'code'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'code', array('class'=>'input-text not_null')); ?>
                            <?php echo $form->error($model, 'code', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                <?php }?>
                <tr>
                    <td><?php echo $form->labelEx($model, 'partner_id'); ?></td>
                    <td>
                        <?php if(!empty($model->partner_id)){ ?>
                            <span class="label-box"><?php echo $model->partner_name;?><?php echo $form->hiddenField($model, 'partner_id', array('class' => 'input-text not_null')); ?></span>
                        <?php }else{?>
                            <span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'partner_id', array('class' => 'input-text not_null','value'=>get_session('club_id'))); ?></span>
                        <?php }?>
                        <?php echo $form->error($model, 'partner_id', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
            <?php if($_REQUEST['type']==403){?>
            <table id="t1" class="">
                <!-- <tr>
                    <td style="background:#efefef;" colspan="4" >个人基本信息</td>
                </tr> -->
                <tr>
                    <td><?php echo $form->labelEx($model, 'project_id'); ?></td>
                    <td >
                        <?php echo $form->hiddenField($model, 'project_id', array('class' => 'input-text not_null')); ?>
                            <span id="project_box">
                                <?php if($model->project_list!=null){?>
                                    <span class="label-box"><?php echo $model->project_list->project_name;?></span>
                                <?php }?>
                            </span>
                            <?php if(empty($model->id)){?>
                            <input id="project_select_btn" class="btn" type="button" value="选择">
                            <?php }?>
                        <?php echo $form->error($model, 'project_id', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
            <?php }?>
            <?php if($_REQUEST['type']==404){?>
            <table id="t2" class="" >
                <!-- <tr>
                    <td style="background:#efefef;" colspan="8" >单位基本信息</td>
                </tr> -->
                <tr>
                    <?php $club_id=ClubList::model()->find('id='.get_session('club_id'));?>
                    <td><?php echo $form->labelEx($model, 'project_id'); ?>：</td>
                    <td >
                        <?php echo $form->hiddenField($model, 'project_id', array('class' => 'input-text')); ?>
                            <span id="project_box">
                                <?php if($model->project_list!=null){?>
                                    <span class="label-box"><?php echo $model->project_list->project_name;?></span>
                                <?php }?>
                            </span>
                            <?php if(empty($model->id)){?>
                            <input id="project_select_btn" class="btn" type="button" value="选择">
                            <?php }?>
                        <?php echo $form->error($model, 'project_id', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
            <?php }?>
            <?php echo $form->hiddenField($model, 'content'); ?>
            </div><!--box-detail-tab-item-->
            <table>
                <?php if(empty($model->id)){?>
                    <?php
                        $inputset = GfPartnerMemberInputset::model()->findAll('isNull(set_id) and is_invite=649 and type='.$_REQUEST['type']);
                        $k=0;
                        if(isset($inputset))foreach($inputset as $arr){
                        $values = GfPartnerMemberValues::model()->findAll('set_input_id='.$arr->id);
                    ?>
                    <tr>
                        <td><label class="info_elemt"><?=$arr->attr_name;?> <span class="required">*</span></label></td>
                        <td>
                            <?php 
                                if($arr->attr_input_type==677){
                                    echo '<input type="text" class="input-text not_null" name="content['.$arr->id.']['.$arr->attr_input_type.']"';
                                    if(!is_null($arr->apply_column)){
                                        echo ' id="GfPartnerMemberInputset'.$arr->id.'" ';
                                        if($_REQUEST['type']==403){
                                            if($arr->apply_column=='gf_account'){
                                                echo ' onchange="accountOnchang(this)"';
                                            }
                                            if($arr->apply_column=='zsxm'||$arr->apply_column=='sex'||$arr->apply_column=='native'||$arr->apply_column=='birthdate'){
                                                echo ' readonly="readonly" placeholder="请输入账号" ';
                                            }
                                        }elseif($_REQUEST['type']==404){
                                            if($arr->apply_column=='club_code'){
                                                echo ' onchange="codeOnchang(this)"';
                                            }
                                            if($arr->apply_column=='club_name'||$arr->apply_column=='club_address'){
                                                echo ' readonly="readonly" placeholder="请输入单位账号" ';
                                            }
                                        }
                                    }
                                    echo 'style="width:30%;height:26px;box-sizing: border-box;"><br>';
                                }else if($arr->attr_input_type==678){
                                    echo '<select id="GfPartnerMemberInputset'.$arr->id.'" class="selt not_null" int="'.$arr->id.'" attr_id="'.$arr->attr_input_type.'" name="content['.$arr->id.']['.$arr->attr_input_type.']" onchange="get_value_id(this)" style="min-width:300px;box-sizing: border-box;">';
                                    echo '<option>请选择</option>';
                                    if(isset($values))foreach($values as $val){
                                        echo '<option value="'.$val->attr_values.'" value_id="'.$val->id.'">'.$val->attr_values.'</option>';
                                    }
                                    echo '</select><br>';
                                }else if($arr->attr_input_type==681){
                                    echo '<textarea id="GfPartnerMemberInputset'.$arr->id.'" rows="5" name="content['.$arr->id.']['.$arr->attr_input_type.']" class="input-text not_null"></textarea><br>';
                                }else if($arr->attr_input_type==683){
                                    echo '<input id="GfPartnerMemberInputset'.$arr->id.'" class="file_btn not_null" name="content['.$arr->id.']['.$arr->attr_input_type.']" type="hidden">';
                                    echo '<div id="box_file_btn"><script>we.uploadpic("GfPartnerMemberInputset'.$arr->id.'", "'.$picprefix.'");</script></div>';
                                }else if($arr->attr_input_type==720){
                                    echo '<input id="GfPartnerMemberInputset'.$arr->id.'" type="text" name="content['.$arr->id.']['.$arr->attr_input_type.']" class="input-text not_null"/><datalist id="url_list_'.$k.'">';
                                    if(isset($values))foreach($values as $val){
                                        echo '<option label="" value="'.$val->attr_values.'"/>';
                                    }
                                    echo '</datalist><br>';
                                }else{
                                    echo '<input id="GfPartnerMemberInputset'.$arr->id.'" type="text" name="content['.$arr->id.']['.$arr->attr_input_type.']" class="input-text not_null" style="width:30%;height:26px;box-sizing: border-box;"><br>';
                                }
                            ?>
                        </td>
                    </tr>
                <?php $k++;}}?>
            </table>
            <div style="" id="member_set" class="">
                <?php if(!empty($model->id)){?>
                <table class="">
                    <!-- <tr>
                        <td style="background:#efefef;" colspan="4" >其他信息</td>
                    </tr> -->
                    <?php 
                        $set=GfPartnerMemberSet::model()->find('type='.$model->type.' and club_id='.$model->partner_id.' and project_id='.$model->project_id);
                        $is_invite='';
                        if($model->auth_state==1483){
                            $is_invite=' and is_invite=649';
                        }
                        if(isset($set)){
                            $inputset = GfPartnerMemberInputset::model()->findAll('(isNull(set_id) or set_id='.$set->id.') and type='.$model->type.$is_invite);
                        }else{
                            $inputset = GfPartnerMemberInputset::model()->findAll('isNull(set_id) and type='.$model->type.$is_invite);
                        }
                        if(isset($inputset))foreach($inputset as $arr){
                        $content=GfPartnerMemberContent::model()->find('apply_id='.$model->id.' and attr_id='.$arr->id);
                    ?>   
                    <tr>
                        <td>
                            <span class="info_elemt"><?=$arr->attr_name;?></span>
                        </td>
                        <td>
                        <?php if($arr->attr_input_type==677){?>
                            <input type="text" class="input-text" name="content[<?=$arr->id;?>][<?=$arr->attr_input_type?>]" <?= isset($content)?'value="'.$content->attr_content.'" readonly="readonly"':'';?> style="width:30%;height:26px;box-sizing: border-box;"><br>
                        <?php }else if($arr->attr_input_type==678){
                            if(isset($set)){
                                $values = GfPartnerMemberValues::model()->findAll('set_id='.$set->id.' and set_input_id='.$arr->id);
                            }else{
                                $values = GfPartnerMemberValues::model()->findAll('set_input_id='.$arr->id);
                            } ?>
                             <select class="selt" set_id="<?=$arr->set_id?>" int="<?=$arr->id?>" attr_id="<?=$arr->attr_input_type?>" name="content[<?=$arr->id?>][<?=$arr->attr_input_type?>]" <?=isset($content)?'disabled="disabled"':'';?> style="min-width:300px;box-sizing: border-box;">
                             <option value="">请选择</option>
                             <?php foreach($values as $v){?>
                                 <option value="<?=$v->attr_values?>" value_id="<?=$v->id?>" <?=isset($content)&&$content->attr_value_id==$v->id?'selected':''?>><?=$v->attr_values?></option>
                            <?php }?>
                             </select><br>
                        <?php }else if($arr->attr_input_type==681){?>
                             <textarea rows="5" name="content[<?=$arr->id;?>][<?=$arr->attr_input_type;?>]" class="input-text" <?=isset($content)?'readonly="readonly"':'';?> ><?=isset($content)?$content->attr_content:'';?></textarea><br>
                        <?php }else if($arr->attr_input_type==683){?>
                             <input id="file_btn" class="file_btn" name="content[<?=$arr->id;?>][<?=$arr->attr_input_type;?>]" type="hidden">
                             <div id="box_file_btn">
                                <div class="upload_img fl" id="upload_pic_file_btn">
                                    <?php if(!empty($content->attr_pic)){?>
                                        <a href="<?php echo $basepath->F_WWWPATH.$content->attr_pic;?>" target="_blank">
                                            <img src="<?php echo $basepath->F_WWWPATH.$content->attr_pic;?>">
                                        </a>
                                    <?php }?>
                                </div>

                                <!-- <script>we.uploadpic("file_btn", "<?php // echo $picprefix;?>");</script> -->
                            </div>
                        <?php }else if($arr->attr_input_type==720){?>
                            <input type="text" name="content[<?=$arr->id;?>][<?=$arr->attr_input_type;?>]" class="input-text" readonly="readonly" <?=isset($content)?'value="'.$content->attr_content.'" readonly="readonly':'';?> /><datalist id="url_list_'+k+'">
                            <!-- <?php //if(info.datas){?>
                                <?php //$.each(info.datas,function(m,n){?>
                                    <option label="" value="'+n.attr_values+'">
                                    <?php //})?>
                                    <?php //} ?> 
                            </datalist><br> -->
                        <?php }else{?>
                            <input type="text" name="content[<?=$arr->id;?>][<?=$arr->attr_input_type;?>]" class="input-text" style="width:30%;height:26px;box-sizing: border-box;"><br>
                        <?php }?>
                        </td>
                    </tr>
                    <?php }?>
                </table>
                <?php }?>
            </div><!--box-detail-tab-item-->
            <table class="mt15">
            	<tr>
                    <td><?=empty($model->id)?'可执行操作':'审核状态';?></td>
                    <td id="check_state" colspan="">
                        <?php if(empty($model->id)){?>
                            <button id="yaoqing" onclick="submitType='yaoqing'" class="btn btn-blue" type="submit">发送邀请</button>&nbsp;
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        <?php }else{?>
                            <?php if($model->state==372&&$model->auth_state==931){
                                echo '<button id="tongguo" onclick="submitType='."'tongguo'".'" class="btn btn-blue" type="submit">保存</button>&nbsp;';
                            }elseif($model->state==371&&$model->auth_state==929){
                                echo show_shenhe_box(array('tongguo'=>'同意加入','butongguo'=>'拒绝加入')).'
                                <button class="btn" type="button" onclick="we.back();">取消</button>';
                            }elseif($model->state==721){
                                echo show_shenhe_box(array('tongguo'=>'确认保存')).'
                                <button class="btn" type="button" onclick="we.back();">取消</button>';
                            }elseif(!empty($_REQUEST['index'])&&$_REQUEST['index']==4&&$model->state==372&&$model->auth_state==1485){
                                echo '<button id="jiechu" onclick="submitType='."'jiechu'".'" class="btn btn-blue" type="submit">同意解除</button>&nbsp;
                                <button id="bujiechu" onclick="submitType='."'bujiechu'".'" class="btn btn-blue" type="submit">拒绝解除</button>&nbsp;
                                <button class="btn" type="button" onclick="we.back();">取消</button>';
                            }else{
                                if($model->auth_state==1483){
                                    echo $model->auth_state_name;
                                }elseif($model->auth_state==1484||$model->auth_state==1485){
                                    echo '<button id="tongguo" onclick="submitType='."'tongguo'".'" class="btn btn-blue" type="submit">保存</button>&nbsp;';
                                    echo $model->state_name;
                                }else{
                                    echo $model->state_name;
                                }
                            };?>
                        <?php }?>
                    </td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
        <?php $this->endWidget(); ?>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var partnerId=$("#GfPartnerMemberApply_partner_id").val();
    var projectId=0;
    $(".box-detail-tab li").click(function(){
        var index=$(this).index();
        if(index==1){
            if($("#GfPartnerMemberApply_partner_id").val()==''){
                we.msg('minus','请选择入会单位');
                return false;
            }
            if($("#GfPartnerMemberApply_project_id").val()==''){
                we.msg('minus','请选择项目');
                return false;
            }
        }
        $("*").removeClass("current");
        $(this).addClass("current");
        $(".box-detail-tab-item").hide();
        $(".box-detail-tab-item").eq(index).show();
    })
        // 选择项目
    var $project_box=$('#project_box');
    var $GfPartnerMemberApply_project_id=$('#GfPartnerMemberApply_project_id');
    $('#project_select_btn').on('click', function(){
        $.dialog.data('project_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/project_list");?>&club_id='+partnerId,{
            id:'danwei',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                //console.log($.dialog.data('club_id'));
                if($.dialog.data('project_id')>0){
                    projectId=$.dialog.data('project_id');
                    $GfPartnerMemberApply_project_id.val($.dialog.data('project_id')).trigger('blur');
                    $project_box.html('<span class="label-box">'+$.dialog.data('project_title')+'</span>');
            
            var club_code=$("#GfPartnerMemberInputset2116").val();
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('memberSet');?>&type='+type+'&partner_id='+partnerId+'&project_id='+projectId+'&club_code='+(club_code==''?0:club_code),
                dataType: 'json',
                success: function(e) {
                    console.log(e);
                    if(e.pro_count<=0&&club_code!=''){
                        we.msg('minus','暂不支持申请，申请单位无'+$("#project_box span").text()+'项目');
                        $("#project_box").empty();
                        $("#GfPartnerMemberApply_project_id").val('');
                        return false;
                    }
                    var data=e.data;
                    var content='';
                    content+='<table class="">';
                    $.each(data,function(k,info){
                        var required=(info.is_required==649?'&nbsp;<span class="required">*</span>':'');
                        var not_null=(info.is_required==649?'not_null':'');
                        content+='<tr><td>';
		                content+='<span class="info_elemt">'+info.attr_name+required+'</span>';
                        content+='</td>';
                        content+='<td>';
                        if(info.attr_input_type==677){
                            content+='<input type="text" class="input-text '+not_null+'" name="content['+info.id+']['+info.attr_input_type+']" style="width:30%;height:26px;box-sizing: border-box;"><br>';
                        }else if(info.attr_input_type==678){
                            content+='<select class="selt '+not_null+'" set_id="'+info.set_id+'" int="'+info.id+'" attr_id="'+info.attr_input_type+'" name="content['+info.id+']['+info.attr_input_type+']['+info.datas[0].id+']" style="min-width:300px;box-sizing: border-box;">';
                            $.each(info.datas,function(m,n){
                                content+='<option value="'+n.attr_values+'" value_id="'+n.id+'">'+n.attr_values+'</option>';
                            })
                            content+='</select><br>';
                        }else if(info.attr_input_type==681){
                            content+='<textarea rows="5" name="content['+info.id+']['+info.attr_input_type+']" class="input-text '+not_null+'"></textarea><br>';
                        }else if(info.attr_input_type==683){
                            content+='<input id="file_btn" class="file_btn '+not_null+'" name="content['+info.id+']['+info.attr_input_type+']" type="hidden">';
                            content+='<div id="box_file_btn"><script>we.uploadpic("file_btn", "<?php echo $picprefix;?>");<\/script></div>';
                        }else if(info.attr_input_type==720){
                            content+='<input type="text" name="content['+info.id+']['+info.attr_input_type+']" class="input-text '+not_null+'"/><datalist id="url_list_'+k+'">';
                            if(info.datas){
                                $.each(info.datas,function(m,n){
                                    content+='<option label="" value="'+n.attr_values+'"/>';
                                })
                            }
                            content+='</datalist><br>';
                        }
                        // else{
                        //     content+='<input type="text" name="content['+info.id+']['+info.attr_input_type+']" class="input-text '+not_null+'" style="width:30%;height:26px;box-sizing: border-box;"><br>';
                        // }
                        content+='</td></tr>';
                    })
                    content+='</table>';
                    $("#member_set").html(content);
                }
            });
                }
            }
        });
    });

    var show_type;
    function selectTypeOnchang(obj){
        show_type=$(obj).val();
        if(show_type==403){
            $('#t2').hide();
            $('#t1').show();
        }
        else{
            $('#t1').hide();
            $('#t2').show();
        }
    }
    
    

    // 验证GF账号
    function accountOnchang(obj){
        var changval=$(obj).val();
        // if (changval.length>=6) {
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('validate');?>&gf_account='+changval,
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    if(data.status==1){
                        // $('#GfPartnerMemberApply_gfid').val(data.redirect.gfid);
                        $('#GfPartnerMemberInputset2103').val(data.redirect.zsxm);
                        $('#GfPartnerMemberInputset2104').val(data.redirect.sex==205?'男':'女');
                        $('#GfPartnerMemberInputset2106').val(data.redirect.native);
                        $('#GfPartnerMemberInputset2107').val(data.redirect.birthdate);
                        $('#GfPartnerMemberInputset2108').val(data.redirect.id_card);
                    }else{
                        $(obj).val('');
                        // $('#GfPartnerMemberApply_gfid').val(0);
                        we.msg('minus', data.msg);
                    }
                }
            });
        // }
    }
    
    // 验证单位账号
    function codeOnchang(obj){
        var changval=$(obj).val();
        // if (changval.length>=6) {
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('validateCode');?>&code='+changval+'&project_id='+projectId,
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    if(data.status==1){
                        if(projectId>0&&data.redirect.pro_count<=0){
                            we.msg('minus','暂不支持申请，申请单位无'+$("#project_box span").text()+'项目');
                            $("#GfPartnerMemberInputset2116").val('');
                            $("#GfPartnerMemberInputset2117").val('');
                            return false;
                        }
                        $("#GfPartnerMemberInputset2117").val(data.redirect.club_name);
                        // $("#GfPartnerMemberInputset2120").val(data.redirect.club_address);
                        // $("#GfPartnerMemberInputset2121").val(data.redirect.certificates_number);
                        // $("#GfPartnerMemberInputset2122").val(data.redirect.apply_club_gfnick);
                        // $("#GfPartnerMemberInputset2123").val(data.redirect.apply_club_phone);
                    }else{
                        $(obj).val('');
                        // $('#GfPartnerMemberApply_gfid').val(0);
                        we.msg('minus', data.msg);
                    }
                }
            });
        // }
    }

    function get_value_id(e){
        $(e).attr("name",'content['+$(e).attr("int")+']['+$(e).attr("attr_id")+']['+$(e).find(" option:selected").attr("value_id")+']')
    }
    
    $("#tongguo").on("click",function(){
        var tzw = '';
        $(".not_null").each(function(){
            if($(this).val()==''||$(this).val()=='请选择'){
                tzw +='<p style="margin-bottom:10px;">'+$(this).parents('td').prev().find("label").text()+' <span>不能为空</span></p>';
            }
        })
        if(tzw!=''){
            we.msg('minus', tzw);
            return false;
        }
    })
</script>