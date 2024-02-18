<style>
    table{
        table-layout:auto!important;
        background-color:transparent!important;
    }
    table tr td:nth-child(2n+1){
        width:100px;
    }
    .input-text,select{
        width:300px!important;
        height: 30px;
        box-sizing: border-box;
    }
</style>

<script>
    var type=<?php echo $_REQUEST['type'];?>
</script>
<?php $club_id=ClubList::model()->find('id='.get_session('club_id'));?>
<?php $basepath=BasePath::model()->getPath(187);$picprefix='';
if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i><?php if(empty($model->id)){?>添加成员<?php }else{?>单位详情<?php }?></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
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
                <?php if(!empty($model->id)&&$model->auth_state!=1483){?>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'code'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'code', array('class'=>'input-text not_null','readonly'=>'readonly'));?>
                            <?php echo $form->error($model, 'code', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                <?php }?>
                <tr> 
                    <td><?php echo $form->labelEx($model, 'partner_id'); ?></td>
                    <td>
                        <?php 
                        if(empty($model->id)){?>
                            <input type="hidden" id="GfPartnerMemberApply_partner_id" class="not_null" name="GfPartnerMemberApply[partner_id]">
                            <span id="club_list_box"></span>
                            <input id="club_list_id" class="btn" type="button" value="选择" <?php if(!empty($model->id)){?>disabled="disabled" style="color:#bbb;"<?php }?>>
                        <?php }else{?>
                        <?php if(!empty($model->partner_id)){ ?>
                            <span class="label-box"><?php echo $model->partner_name;?><?php echo $form->hiddenField($model, 'partner_id', array('class' => 'input-text')); ?></span>
                        <?php }?>
                            <input id="club_list_id" class="btn" type="button" value="选择" <?php if(!empty($model->id)){?>disabled="disabled" style="color:#bbb;"<?php }?>>
                        <?php }?>
                    </td>
                </tr>
            </table>
            <table id="t2" class="">
                <!-- <tr>
                    <td style="background:#efefef;" colspan="6" >单位基本信息</td>
                </tr> -->
                <tr>
                    <td><?php echo $form->labelEx($model, 'project_id'); ?>：</td>
                    <td colspan="" >
                        <?php echo $form->hiddenField($model, 'project_id', array('class' => 'input-text not_null')); ?>
                            <span id="project_box">
                                <?php if($model->project_list!=null){?>
                                    <span class="label-box"><?php echo $model->project_list->project_name;?></span>
                                <?php }?>
                            </span>
                            <input id="project_select_btn" class="btn" type="button" value="选择" <?php if(!empty($model->id)){?>disabled="disabled" style="color:#bbb;"<?php }?>>
                        <?php echo $form->error($model, 'project_id', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
            <?php echo $form->hiddenField($model, 'content'); ?>
            </div><!--box-detail-tab-item-->
            <table>
                <?php if(empty($model->id)){?>
                    <?php
                        $inputset = GfPartnerMemberInputset::model()->findAll('isNull(set_id) and type='.$_REQUEST['type']);
                        $k=0;
                        if(isset($inputset))foreach($inputset as $arr){
                        $values = GfPartnerMemberValues::model()->findAll('set_input_id='.$arr->id);
                    ?>
                    <tr>
                        <td>
                            <label class="info_elemt">
                                <?php 
                                    echo $arr->attr_name;
                                    $not_null='';
                                    if($arr->is_required==649){
                                        echo '&nbsp;<span class="required">*</span>';
                                        $not_null='not_null';
                                    }
                                ?> 
                            </label>
                        </td>
                        <td>
                            <?php 
                                if($arr->attr_input_type==677){
                                    echo '<input type="text" class="input-text '.$not_null.'" name="content['.$arr->id.']['.$arr->attr_input_type.']"';
                                    if(!is_null($arr->apply_column)){
                                        echo ' id="GfPartnerMemberInputset'.$arr->id.'" ';
                                        if($arr->apply_column=='club_code'){
                                            echo 'value="'.get_session('club_code').'" readonly="readonly"';
                                            echo ' onchange="codeOnchang(this)"';
                                        }
                                        if($arr->apply_column=='club_name'){
                                            echo ' readonly="readonly" placeholder="请输入单位账号" ';
                                        }
                                    }
                                    echo 'style="width:30%;height:26px;box-sizing: border-box;"><br>';
                                }else if($arr->attr_input_type==678){
                                    echo '<select id="GfPartnerMemberInputset'.$arr->id.'" class="selt '.$not_null.'" int="'.$arr->id.'" attr_id="'.$arr->attr_input_type.'" name="content['.$arr->id.']['.$arr->attr_input_type.']" onchange="get_value_id(this)" style="min-width:300px;box-sizing: border-box;">';
                                    echo '<option>请选择</option>';
                                    if(isset($values))foreach($values as $val){
                                        echo '<option value="'.$val->attr_values.'" value_id="'.$val->id.'">'.$val->attr_values.'</option>';
                                    }
                                    echo '</select><br>';
                                }else if($arr->attr_input_type==681){
                                    echo '<textarea id="GfPartnerMemberInputset'.$arr->id.'" rows="5" name="content['.$arr->id.']['.$arr->attr_input_type.']" class="input-text '.$not_null.'"></textarea><br>';
                                }else if($arr->attr_input_type==683){
                                    echo '<input id="GfPartnerMemberInputset'.$arr->id.'" class="file_btn '.$not_null.'" name="content['.$arr->id.']['.$arr->attr_input_type.']" type="hidden">';
                                    echo '<div id="box_file_btn"><script>we.uploadpic("GfPartnerMemberInputset'.$arr->id.'", "'.$picprefix.'");</script></div>';
                                }else if($arr->attr_input_type==720){
                                    echo '<input id="GfPartnerMemberInputset'.$arr->id.'" type="text" name="content['.$arr->id.']['.$arr->attr_input_type.']" class="input-text '.$not_null.'"/><datalist id="url_list_'.$k.'">';
                                    if(isset($values))foreach($values as $val){
                                        echo '<option label="" value="'.$val->attr_values.'"/>';
                                    }
                                    echo '</datalist><br>';
                                }else{
                                    echo '<input id="GfPartnerMemberInputset'.$arr->id.'" type="text" name="content['.$arr->id.']['.$arr->attr_input_type.']" class="input-text '.$not_null.'" style="width:30%;height:26px;box-sizing: border-box;"><br>';
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
                        
                        if(isset($set)){
                            $inputset = GfPartnerMemberInputset::model()->findAll('(isNull(set_id) or set_id='.$set->id.') and type='.$model->type);
                        }else{
                            $inputset = GfPartnerMemberInputset::model()->findAll('isNull(set_id) and type='.$model->type);
                        }
                        if(isset($inputset))foreach($inputset as $arr){
                        $content=GfPartnerMemberContent::model()->find('apply_id='.$model->id.' and attr_id='.$arr->id);
                    ?>   
                    <tr>
                        <td>
                            <label class="info_elemt">
                                <?php 
                                    echo $arr->attr_name;
                                    $not_null='';
                                    if($arr->is_required==649){
                                        echo '&nbsp;<span class="required">*</span>';
                                        $not_null='not_null';
                                    }
                                ?> 
                            </label>
                        </td>
                        <td>
                        <?php if($arr->attr_input_type==677){?>
                            <input id="GfPartnerMemberInputset<?=$arr->id?>" type="text" class="input-text <?=$not_null;?>" name="content[<?=$arr->id;?>][<?=$arr->attr_input_type?>]" <?= isset($content)?'value="'.$content->attr_content.'" readonly="readonly"':'';?> style="width:30%;height:26px;box-sizing: border-box;"><br>
                        <?php }else if($arr->attr_input_type==678){
                            if(isset($set)){
                                $values = GfPartnerMemberValues::model()->findAll('set_id='.$set->id.' and set_input_id='.$arr->id);
                            }else{
                                $values = GfPartnerMemberValues::model()->findAll('set_input_id='.$arr->id);
                            } ?>
                             <select id="GfPartnerMemberInputset<?=$arr->id?>" class="selt <?=$not_null;?>" set_id="<?=$arr->set_id?>" int="<?=$arr->id?>" attr_id="<?=$arr->attr_input_type?>" name="content[<?=$arr->id?>][<?=$arr->attr_input_type?>]['+info.datas[0].id+']" <?=isset($content)?'disabled="disabled"':'';?> style="min-width:300px;box-sizing: border-box;">
                                <option value="">请选择</option>
                                <?php foreach($values as $v){?>
                                    <option value="<?=$v->attr_values?>" value_id="<?=$v->id?>" <?=isset($content)&&$content->attr_value_id==$v->id?'selected':''?>><?=$v->attr_values?></option>
                                <?php }?>
                             </select><br>
                        <?php }else if($arr->attr_input_type==681){?>
                             <textarea id="GfPartnerMemberInputset<?=$arr->id?>" rows="5" name="content[<?=$arr->id;?>][<?=$arr->attr_input_type;?>]" class="input-text <?=$not_null;?>" <?=isset($content)?'disabled="disabled"':'';?> ><?=isset($content)?$content->attr_content:'';?></textarea><br>
                        <?php }else if($arr->attr_input_type==683){?>
                             <input id="GfPartnerMemberInputset<?=$arr->id?>" class="file_btn <?=$not_null;?>" name="content[<?=$arr->id;?>][<?=$arr->attr_input_type;?>]" type="hidden">
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
                            <input id="GfPartnerMemberInputset<?=$arr->id?>" type="text" name="content[<?=$arr->id;?>][<?=$arr->attr_input_type;?>]" class="input-text <?=$not_null;?>" disabled="disabled" <?=isset($content)?'value="'.$content->attr_content.'" readonly="readonly':'';?> /><datalist id="url_list_'+k+'">
                            <!-- <?php //if(info.datas){?>
                                <?php //$.each(info.datas,function(m,n){?>
                                    <option label="" value="'+n.attr_values+'">
                                    <?php //})?>
                                    <?php //} ?> 
                            </datalist><br> -->
                        <?php }else{?>
                            <input id="GfPartnerMemberInputset<?=$arr->id?>" type="text" name="content[<?=$arr->id;?>][<?=$arr->attr_input_type;?>]" class="input-text <?=$not_null;?>" style="width:30%;height:26px;box-sizing: border-box;"><br>
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
                            <?php echo show_shenhe_box(array('shenhe'=>'提交审核'));?>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        <?php }else{?>
                            <?php if($model->state==371&&$model->auth_state==929){
                                echo $model->state_name;
                            }elseif($model->state==721){
                                echo show_shenhe_box(array('shenhe'=>'提交')).'
                                <button class="btn" type="button" onclick="we.back();">取消</button>';
                            }elseif($model->state==371&&$model->auth_state==1483){
                                echo '<button id="tongguo" onclick="submitType='."'tongguo'".'" class="btn btn-blue" type="submit">同意</button>&nbsp;
                                <button id="butongguo" onclick="submitType='."'butongguo'".'" class="btn btn-blue" type="submit">不同意</button>&nbsp;
                                <button class="btn" type="button" onclick="we.back();">取消</button>';
                            }elseif($model->state==372&&$model->auth_state==1484){
                                echo '<button id="jiechu" onclick="submitType='."'jiechu'".'" class="btn btn-blue" type="submit">同意解除</button>&nbsp;
                                <button id="bujiechu" onclick="submitType='."'bujiechu'".'" class="btn btn-blue" type="submit">拒绝解除</button>&nbsp;
                                <button class="btn" type="button" onclick="we.back();">取消</button>';
                            }else{
                                if($model->auth_state==1485){
                                    echo $model->auth_state_name;
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

<?php 
    $s1 = 'project_id';
    $s2 = ClubProject::model()->findAll('club_id='.get_session('club_id').' and project_state=506 and auth_state=461');
    $projectAll = toArray($s2,$s1);
?>
<script>
    $(function(){
        $("#GfPartnerMemberInputset2116").change()
    })

    var partnerId='';
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

    
    // 选择账号
    var $account_box=$('#account_box');
    $('#account_select_btn').on('click', function(){
        $.dialog.data('GF_ID', 0);
        $.dialog.open('<?php echo $this->createUrl("select/gfuser");?>',{
        id:'geren',
		lock:true,opacity:0.3,
		width:'500px',
		height:'60%',
        title:'选择具体内容',		
        close: function () {
            if($.dialog.data('GF_ID')>0){
                if($.dialog.data('passed')==372){
                    $('#GfPartnerMemberApply_gfid').val($.dialog.data('GF_ID'));
                    $('#GfPartnerMemberApply_gf_account').val($.dialog.data('GF_ACCOUNT'));
                    $('#GfPartnerMemberApply_zsxm').val($.dialog.data('zsxm'));
                    $('#GfPartnerMemberApply_sex').val($.dialog.data('real_sex')==205?'男':'女');
                    $('#GfPartnerMemberApply_nation').val($.dialog.data('nation'));
                    $('#GfPartnerMemberApply_native').val($.dialog.data('native'));
                    $('#GfPartnerMemberApply_birthdate').val($.dialog.data('real_birthday'));
                    $account_box.html('<span class="label-box">'+$.dialog.data('GF_ACCOUNT')+'</span>');
                }else{
                    we.msg('minus','该账号未实名');
                }        
            }
         }
       });
    });
    
    // 选择入会单位
    $('#club_list_id').on('click', function(){
        $.dialog.data('club_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/clublist", array('club_type'=>189));?>',{
            id:'danwei',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('club_id')>0){
                    partnerId=$.dialog.data('club_id');
                    projectId='';
                    $('#GfPartnerMemberApply_partner_id').val($.dialog.data('club_id'));
                    $('#club_list_box').html('<span id="club_list_box1" class="label-box">'+$.dialog.data('club_title')+'</span>');
                    $("#project_box").empty();
                    $("#GfPartnerMemberApply_project_id").val('');
                }
            }
        });
    });
    // 选择项目
    var $project_box=$('#project_box');
    var $GfPartnerMemberApply_project_id=$('#GfPartnerMemberApply_project_id');
    var projectAll = <?php echo json_encode($projectAll); ?>;
    $('#project_select_btn').on('click', function(){
        if(partnerId==''){
            we.msg('minus','请选择入会单位');
            return false;
        }
        $.dialog.data('project_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/project_list");?>&club_id='+partnerId,{
            id:'danwei',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                var is_EXISTS=false;
                projectAll.find(function(value) {
                    if(value.project_id === $.dialog.data('project_id')) { 
                        is_EXISTS=true;
                    }
                })
                if($.dialog.data('project_id')>0){
                    if(is_EXISTS){
                        projectId=$.dialog.data('project_id');
                        $GfPartnerMemberApply_project_id.val($.dialog.data('project_id')).trigger('blur');
                        $project_box.html('<span class="label-box">'+$.dialog.data('project_title')+'</span>');

                        $.ajax({
                            type: 'post',
                            url: '<?php echo $this->createUrl('memberSet');?>&type='+type+'&partner_id='+partnerId+'&project_id='+projectId+'&club_code='+$("#GfPartnerMemberInputset2116").val(),
                            dataType: 'json',
                            success: function(e) {
                                console.log(e)
                                if(e.pro_count<=0){
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
                                    content+='<label class="info_elemt">'+info.attr_name+required+'</label>';
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
                                        content+='<input id="GfPartnerMemberInputset'+info.id+'" class="file_btn '+not_null+'" name="content['+info.id+']['+info.attr_input_type+']" type="hidden">';
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
                    }else{
                        we.msg('minus', '暂不支持申请，无入会项目');
                        // return false;
                    }
                }
            }
        });
    });
        
    $(document).on("change",".selt",function(){
        $(this).attr("name",'content['+$(this).attr("int")+']['+$(this).attr("attr_id")+']['+$(this).find("option:selected").attr("value_id")+']')
    })

    function click_li(val){
        if(val==403){
            window.location.href="<?php echo $this->createUrl('create',array('type'=>403)); ?>";
        }else{
            window.location.href="<?php echo $this->createUrl('create',array('type'=>404)); ?>";
        }
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
    
    $("#shenhe,#tongyi").on("click",function(){
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

