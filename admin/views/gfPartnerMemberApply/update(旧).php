<?php
    if($model->effective_start_time=='0000-00-00 00:00:00'){
        $model->effective_start_time='';
    }
    if($model->effective_end_time=='0000-00-00 00:00:00'){
        $model->effective_end_time='';
    }
?>
<style>
    .picbox{z-index:1;}
    .search_div{display:none;position:absolute;z-index:9999; width:20.9%;left:51.45%;}
    .search_ul li{width:auto;background-color:#fcfcfc;text-align:left;}
    .search_ul li:hover{color:lightskyblue;background-color:#f0f0f0;border-color:#4d90fe;}
</style>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i><?php if(empty($model->id)){?>添加成员<?php }else{?>编辑<?php }?></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table id="t0" class="mt15">
                <tr>
                    <td style="background:#efefef;" colspan="4" >基本信息</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'type'); ?></td>
                    <td>
                        <?php if(!empty($model->id)) {?>
                            <?php echo $form->dropDownList($model, 'type', Chtml::listData(BaseCode::model()->getCode(402), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange' =>'selectOnchang(this)','disabled'=>'disabled')); ?>
                        <?php }else{?>
                            <?php echo $form->dropDownList($model, 'type', Chtml::listData(BaseCode::model()->getCode(402), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange' =>'selectOnchang(this)')); ?>
                        <?php }?>
                        <?php echo $form->error($model, 'type', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'partner_id'); ?></td>
                    <td>
                        <?php
                            $club_id=ClubList::model()->find('id='.get_session('club_id'));
                            if($club_id->club_type==189){echo $club_id->club_name;} else{?>
                            <span id="club_box">
                                <?php if($model->partner_name!=null){?>
                                    <span id="club_box1" class="label-box"><?php echo $model->partner_name;?></span>
                                <?php }?>
                            </span>
                            <input id="club_select_btn" class="btn" type="button" value="选择" <?php if(!empty($model->id)){?>disabled="disabled" style="color:#bbb;"<?php }?>>
                            <?php echo $form->error($model, 'partner_id', $htmlOptions = array()); ?>
                        <?php }?>
                        <input class="input-text" name="GfPartnerMemberApply[partner_id]" id="GfPartnerMemberApply_partner_id" type="hidden" value="<?php if(!empty($model->partner_id)){echo $model->partner_id;}else{if($club_id->club_type==189) {echo $club_id->id;}} ?>">
                        <input class="input-text" name="GfPartnerMemberApply[club_logo]" id="GfPartnerMemberApply_club_logo" type="hidden" value="<?php if(!empty($model->club_logo)){echo $model->club_logo;}else{if($club_id->club_type==189) {echo $club_id->club_logo_pic;}} ?>">
                    </td>
                </tr>
                <tr>
                    <td class="dis_col"><?php echo $form->labelEx($model, 'zsxm'); ?></td>
                    <td class="dis_col" colspan="">
                        <?php echo $form->textField($model, 'zsxm', array('class'=>'input-text')); ?>
                        <?php echo $form->error($model, 'zsxm', $htmlOptions = array()); ?>
                    </td>
                    <td class="dis_club_id"><?php echo $form->labelEx($model, 'club_id'); ?></td>
                    <td class="dis_club_id">
                        <?php if(empty($model->id) && $club_id->club_type==189){?>
                            <input type="hidden" id="GfPartnerMemberApply_club_id" name="GfPartnerMemberApply[club_id]1" value="<?php echo $club_id->id; ?>">
                            <span id="club_list_box">
                                <?php if($club_id->id!=null){?>
                                    <span id="club_list_box1" class="label-box"><?php echo $club_id->club_name;?></span>
                                <?php }?>
                            </span>
                            <input id="club_list_id" class="btn" type="button" value="选择" <?php if(!empty($model->id)){?>disabled="disabled" style="color:#bbb;"<?php }?>>
                        <?php }else{?>
                        <?php if(!empty($model->club_id)){ ?>
                            <span class="label-box"><?php echo $model->club_name;?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text')); ?></span>
                        <?php }else{?>
                            <span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value'=>get_session('club_id'))); ?></span>
                        <?php }}?>
                    </td>
                    <td class="dis_account" style="display:none;"><?php echo $form->labelEx($model, 'gf_account'); ?></td>
                    <!-- <td class="dis_account" style="display:none;">
                    <?php echo $form->hiddenField($model, 'gfid'); ?>
                        <?php if(empty($model->id)) {?>
                            <?php echo $form->textField($model, 'gf_account', array('class' => 'input-text','oninput' =>'accountOnchang(this)','onpropertychange' =>'accountOnchang(this)')); ?>
                        <?php }else{?>
                            <?php echo $model->gf_account; ?>
                        <?php }?>
                        <?php echo $form->error($model, 'gf_account', $htmlOptions = array()); ?>
                    </td> -->
                    <td style="display:none;" class="dis_account">
                        <?php echo $form->hiddenField($model, 'gfid', array('class' => 'input-text')); ?>                       
                        <?php echo $form->hiddenField($model, 'gf_account', array('class' => 'input-text')); ?>
                        <span id="account_box"><?php if(!empty($model->qualification_gfaccount)) { ?><span class="label-box"><?php echo $model->gf_account;?></span><?php } ?></span>
                        <input id="account_select_btn" class="btn" type="button" value="选择">
                        <?php echo $form->error($model, 'gf_account', $htmlOptions = array()); ?>
                        <input type="button"  name='show_gfid_msg' id='show_gfid_msg' onClick="location='<?php echo $this->createUrl("gfUser1/update");?>&id='+gfid"  value="帐号信息详情>>" />
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'id_card'); ?></td>
                    <td id="dis_card">
                        <?php if(empty($model->id)) {?>
                            <?php echo $form->textField($model, 'id_card', array('class'=>'input-text')); ?>
                        <?php }else{?>
                            <?php echo $model->id_card; ?>
                        <?php }?>
                        <?php echo $form->error($model, 'id_card', $htmlOptions = array()); ?>
                    </td>
                    <td class="dis_club_id"><?php echo $form->labelEx($model, 'club_address'); ?></td>
                    <td id="club_address" class="dis_club_id"><?php echo $form->textField($model, 'club_address', array('class'=>'input-text')); ?></td>
                    <!-- <td><?php echo $form->labelEx($model, 'gf_account'); ?></td>
                    <td>
                        <?php echo $form->hiddenField($model, 'gfid'); ?>
                        <?php if(empty($model->id)) {?>
                            <?php echo $form->textField($model, 'gf_account', array('class' => 'input-text','oninput' =>'accountOnchang(this)','onpropertychange' =>'accountOnchang(this)')); ?>
                        <?php }else{?>
                            <?php echo $model->gf_account; ?>
                        <?php }?>
                        <?php echo $form->error($model, 'gf_account', $htmlOptions = array()); ?>
                    </td> -->
                </tr>
                <tr>
                    <td class="detail-hd"><?php echo $form->labelEx($model, 'project_id'); ?></td>
                    <td id="dis_project">
                        <?php echo $form->hiddenField($model, 'project_id', array('class' => 'input-text')); ?>
                        <span id="project_box">
                            <?php if($model->project_list!=null){?>
                                <span id="project_id1" class="label-box"><?php echo $model->project_list->project_name;?></span>
                            <?php }?>
                        </span>
                        <input id="project_select_btn" class="btn" type="button" value="选择" <?php if(!empty($model->id)){?>disabled="disabled" style="color:#bbb;"<?php }?>>
                        <?php echo $form->error($model, 'project_id', $htmlOptions = array()); ?>
                    </td>
                    <td class="dis_club_id">是否GF平台单位</td>
                    <td id="isclub_id" class="dis_club_id"><?php if(!empty($model->club_list->id))if($model->club_id) {?>是<?php }else{?>否<?php }?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'apply_time'); ?></td>
                    <td colspan="3"><?php echo $model->apply_time; ?></td>
                </tr>
            </table>
            <?php echo $form->hiddenField($model, 'setlist');?>
            <?php
                $model->id=empty($model->id) ? 0 : $model->id;
                $basepath=BasePath::model()->getPath(178);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                if(!empty($model->club_id)&&!empty($model->project_id)&&!empty($model->type)){
                    $memberset = GfPartnerMemberSet::model()->find('club_id='.$model->club_id.' AND project_id='.$model->project_id.' AND type='.$model->type);
                }
                $content = GfPartnerMemberContent::model()->findAll('apply_id='.$model->id);
            ?>
            <table id="t1" class="mt15">
                <tr class="set_title">
                    <td style="background:#efefef;" colspan="4" style="">入会信息&nbsp;&nbsp;
                        <input id="setlist_select_btn" class="btn" type="button" value="生成入会信息" <?php if(!empty($model->id)){?>disabled="disabled" style="color:#bbb;"<?php }?>>
                    </td>
                </tr>
                <tr>
                    <td>填写入会信息</td>
                    <td colspan="3">
                        <?php echo $form->hiddenField($model, 'setlist'); ?>
                        <table id="setlist" class="showinfo">
                            <tr class="set_title table-title">
                                <td>属性名称</td>
                                <td>属性值</td>
                                <td>属性单位</td>
                            </tr>
                            <?php if(!empty($content))foreach($content as $v){?>
                                <?php
                                    $notattr=$v->attr_id;
                                    if(!empty($notattr)){
                                        if(!empty($memberset)) {$values = GfPartnerMemberValues::model()->findAll('set_id='.$memberset->id.' AND set_input_id='.$v->attr_id);}
                                    }
                                ?>
                                <tr class="oldset">
                                    <input class="input-text" name="setlist[<?php echo $v->id;?>][attr_name]" type="hidden" value="<?php echo $v->attr_name;?>">
                                    <input class="input-text" name="setlist[<?php echo $v->id;?>][attr_content]" type="hidden" value="<?php echo $v->attr_content;?>">
                                    <input class="input-text" name="setlist[<?php echo $v->id;?>][attr_pic]" type="hidden" value="<?php echo $v->attr_pic;?>">
                                    <input class="input-text" name="setlist[<?php echo $v->id;?>][attr_id]" type="hidden" value="<?php echo $v->attr_id;?>">
                                    <input class="input-text" name="setlist[<?php echo $v->id;?>][attr_unit]" type="hidden" value="<?php echo $v->attr_unit;?>">
                                    <input class="input-text" name="setlist[<?php echo $v->id;?>][attr_value_type]" type="hidden" value="<?php echo $v->attr_value_type;?>">
                                    <input class="input-text" id="values_input_<?php echo $v->id;?>" name="setlist[<?php echo $v->id;?>][attr_value_id]" type="hidden" value="<?php echo $v->attr_value_id;?>">
                                    <input class="input-text" name="setlist[<?php echo $v->id;?>][id]" type="hidden" value="<?php echo $v->id;?>">
                                    <td><?php echo $v->attr_name; ?></td>
                                    <?php if($v->attr_value_type==677){?>
                                        <td><input class="input-text" type="text" name="setlist[<?php echo $v->id; ?>][attr_content]" value="<?php echo $v->attr_content; ?>" disabled="disabled"></td>
                                    <?php }else if(($v->attr_value_type==678) || ($v->attr_value_type==682)){ ?>
                                        <td>
                                            <select name="setlist[<?php echo $v->id;?>][attr_value_id]" disabled="disabled">
                                                <option value>请选择</option>
                                                <?php if(!empty($values)){ foreach($values as $g){ $select_id=$g->id; ?>
                                                    <option value="<?php echo $g->id; ?>" <?php if($select_id==$v->attr_value_id) {?>selected<?php }?>><?php echo $g->attr_values; ?></option>
                                                <?php }} ?>
                                            </select>
                                        </td>
                                    <?php }else if($v->attr_value_type==681){?>
                                        <td><textarea class="input-text" type="text" name="setlist[<?php echo $v->id;?>][attr_content]" disabled="disabled"><?php echo $v->attr_content; ?></textarea></td>
                                    <?php }else if($v->attr_value_type==683){ //$pic_values = explode(',', $v->attr_pic);?>
                                        <td>
                                            <?php echo $form->hiddenField($model, 'attr_pic', array('class' => 'input-text fl')); ?>
                                            <input class="input-text" type="hidden" name="setlist[<?php echo $v->id;?>][attr_pic]" id="GfPartnerMemberApply_attr_pic_<?php echo $v->id;?>" value="<?php echo $v->attr_pic;?>">
                                            <div class="upload_img fl" id="upload_pic_GfPartnerMemberApply_attr_pic_<?php echo $v->id;?>" style="margin-left: 0.5rem;">
                                                <?php if($v->attr_pic!=''){ //foreach ($pic_values as $p) {?>
                                                    <a class="picbox" data-savepath="<?php echo $basepath->F_WWWPATH.$v->attr_pic;?>" href="<?php echo $basepath->F_WWWPATH.$v->attr_pic;;?>" target="_blank">
                                                        <img src="<?php echo $basepath->F_WWWPATH.$v->attr_pic;?>" width="100">
                                                    </a>
                                                <?php }//}?>
                                            </div>
                                            <?php if(empty($model->id)) {?>
                                                <script>we.uploadpic('<?php echo get_class($model);?>_attr_pic_<?php echo $v->id;?>','<?php echo $picprefix;?>');</script>
                                            <?php }?>
                                            <?php echo $form->error($model, 'attr_pic', $htmlOptions = array()); ?>
                                        </td>
                                    <?php }else if($v->attr_value_type==720){ ?>
                                        <td>
                                            <input id="search_values_<?php echo $v->id;?>" class="input-text" type="text" name="setlist[<?php echo $v->id;?>][attr_content]" oninput="oninputattrname_<?php echo $v->id;?>(this);" onpropertychange="oninputattrname_<?php echo $v->id;?>(this);" value="<?php echo $v->attr_content;?>" disabled="disabled">
                                            <div id="search_div_<?php echo $v->id;?>" class="search_div">
                                                <ul id="search_ul" class="search_ul">
                                                    <?php if(!empty($values)){ foreach($values as $k) {?>
                                                        <li class="input-text" onclick="search_click_<?php echo $v->id;?>(this);" value="<?php echo $k->id; ?>"><?php echo $k->attr_values; ?></li>
                                                    <?php }}?>
                                                </ul>
                                            </div>
                                            <script>
                                                function oninputattrname_<?php echo $v->id;?>(obj){
                                                    var search_val=$(obj).val();
                                                    var show_val=$('#search_values_<?php echo $v->id;?>').val();
                                                    if(search_val.length>=0){
                                                        $.ajax({
                                                            type: 'post',
                                                            url: '<?php echo $this->createUrl('prompt');?>',
                                                            data: {show_val:show_val},
                                                            dataType: 'json',
                                                            success: function(data){
                                                                if(data.status==1){
                                                                    if(search_val!=''){
                                                                        $('#search_div_<?php echo $v->id;?>').show();
                                                                    }
                                                                    else{
                                                                        $('#search_div_<?php echo $v->id;?>').hide();
                                                                    }
                                                                }
                                                                else{
                                                                    $(obj).val('');
                                                                    we.msg('minus', data.msg);
                                                                }
                                                            }
                                                        })
                                                    }
                                                }
                                                function search_click_<?php echo $v->id;?>(obj){
                                                    var li=$(obj).text();
                                                    var li1=$(obj).val();
                                                    $('#search_values_<?php echo $v->id;?>').val(li);
                                                    $('#values_input_<?php echo $v->id;?>').val(li1);
                                                    $('#search_div_<?php echo $v->id;?>').hide();
                                                }
                                                $(document).on("click",function(e){
                                                    if($(e.target).closest("#search_div_<?php echo $v->id;?>").length==0){
                                                        $("#search_div_<?php echo $v->id;?>").hide();
                                                    }
                                                });
                                            </script>
                                        </td>
                                    <?php }else{?>
                                        <td><?php echo $v->attr_name; ?></td>
                                    <?php }?>
                                    <td><?php echo $v->attr_unit; ?></td>
                                </tr>
                            <?php }?>
                        </table>
                    </td>
                </tr>
            </table>
            <table id="t2" class="mt15">
                <tr>
                    <td colspan="4" style="background:#efefef;">会员信息</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'state_certificate_code'); ?></td>
                    <td><?php echo $model->state_certificate_code;?></td>
                    <td><?php echo $form->labelEx($model, 'member_type_id'); ?></td>
                    <td>
                        <select id="GfPartnerMemberApply_member_type_id" name="GfPartnerMemberApply[member_type_id]">
                            <option value>请选择</option>
                            <?php
                                if(!empty($memberset)){$values=GfPartnerMemberValues::model()->findAll('set_id='.$memberset->id.' AND set_input_id is null');}
                                if(!empty($values)){ foreach($values as $g){ $select_id=$g->id;
                            ?>
                                <option value="<?php echo $g->id; ?>" <?php if($model->member_type_id==$select_id){?>selected<?php } ?>><?php echo $g->attr_values; ?></option>
                            <?php }} ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'effective_start_time'); ?></td>
                    <td>
                        <?php if(!empty($model->id)) {?>
                            <?php echo $form->textField($model, 'effective_start_time', array('class'=>'input-text','disabled'=>'disabled')); ?>
                        <?php }else{?>
                            <?php echo $form->textField($model, 'effective_start_time', array('class'=>'input-text')); ?>
                        <?php }?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'effective_end_time'); ?></td>
                    <td>
                        <?php if(!empty($model->id)) {?>
                            <?php echo $form->textField($model, 'effective_end_time', array('class'=>'input-text','disabled'=>'disabled')); ?>
                        <?php }else{?>
                            <?php echo $form->textField($model, 'effective_end_time', array('class'=>'input-text')); ?>
                        <?php }?>
                    </td>
                </tr>
            </table>
            <table id="t3" class="mt15">
                <tr>
                    <td style="background:#efefef;" colspan="4" >管理员操作</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'auth_state'); ?></td>
                    <td>
                        <?php echo $model->auth_state_name;?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                    <td>
                        <?php echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
                    </td>
                </tr>
			</table>
            <table class="mt15">
            	<tr>
                    <td>可执行操作</td>
                    <td id="check_state" colspan="3">
                        <?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核','tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
               			<button class="btn" type="button" onclick="printpage();">打印</button>
                    </td>
                </tr>
            </table>
			<table id="t4" class="showinfo">
                <tr>
                    <td width="20%">操作时间</td>
                    <td width="20%">操作人</td>
                    <td width="20%">操作事项</td>
                    <td>备注</td>
                </tr>
                <tr>
                    <td><?php echo $model->update; ?></td>
                    <td><?php echo $model->admin_name; ?></td>
                    <td><?php echo $model->state_name; ?></td>
                    <td><?php echo $model->reasons_failure; ?></td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
        <?php $this->endWidget(); ?>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var club_id=0;
    var project_id=0;
    function selectOnchang(obj){
        var show_type=$(obj).val();
        if(show_type==403){
            $("#t1").show();
            $('.dis_club_id').hide();
            $('.dis_account').show();
            document.getElementById('dis_card').colSpan=3;
            document.getElementById('dis_project').colSpan=3;
        }
        else{
            $("#t1").hide();
            $('.dis_account').hide();
            $('.dis_club_id').show();
            document.getElementById('dis_card').colSpan=1;
            document.getElementById('dis_project').colSpan=1;
        }
    };

    var $setlist=$('#setlist');
    $('#setlist_select_btn').on('click',function(){
        $('#setlist tr').not('.set_title').remove();
        var type=$('#GfPartnerMemberApply_type').val();
        var club_id=$('#GfPartnerMemberApply_club_id').val();
        var project_id=$('#GfPartnerMemberApply_project_id').val();
        var club_box1=document.getElementById('club_box1');
        var project_id1=document.getElementById('project_id1');
        if(club_id=='' || project_id==''){
            we.msg('minus', '请先选择入会单位与入会项目');
			return false;
        }
        $.ajax({
            type: 'get',
            url: '<?php echo $this->createUrl("gfPartnerMemberApply/getMemberInputset");?>',
            data: {type:type,club_id:club_id,project_id:project_id},
            dataType:'json',
            success: function(data) {
                if(data==''){
                    we.msg('minus','没有填写入会模板');
                }
                if(typeof(data)!=="undefined"){
                    var p_html = '';
                    var num=0;
                    while(num<data.length){
                        p_html=p_html+
                            '<tr class="oldset">'+
                                '<input name="setlist['+num+'][attr_id]" type="hidden" value="'+data[num]['id']+'">'+
                                '<input name="setlist['+num+'][attr_name]" type="hidden" value="'+data[num]['attr_name']+'">'+
                                '<input name="setlist['+num+'][attr_unit]" type="hidden" value="'+data[num]['attr_unit']+'">'+
                                '<input name="setlist['+num+'][attr_value_type]" type="hidden" value="'+data[num]['attr_input_type']+'">'+
                                '<input name="setlist['+num+'][id]" type="hidden" value="null">'+
                                '<td>'+data[num]['attr_name']+'</td>';
                        if(data[num]['attr_input_type']==678 || data[num]['attr_input_type']==682){
                            var s_html='';
                            p_html=p_html+'<td><select name="setlist['+num+'][attr_value_id]"><option value>请选择</option>';
                            $(function(){
                                var type=$('#GfPartnerMemberApply_type').val();
                                var club_id=$('#GfPartnerMemberApply_club_id').val();
                                var project_id=$('#GfPartnerMemberApply_project_id').val();
                                $.ajax({
                                    type: 'get',
                                    url: '<?php echo $this->createUrl("gfPartnerMemberApply/down"); ?>&set_input_id='+data[num]['id'],
                                    data: {type:type,club_id:club_id,project_id:project_id},
                                    dataType: 'json',
                                    async: false,
                                    success: function(data){
                                        if(data!=''){
                                            for(var i=0;i<data.length;i++) {
                                                s_html=s_html+'<option value="'+data[i]['id']+'">'+data[i]['attr_values']+'</option>';
                                            }
                                        }
                                    }
                                });
                            });
                            p_html=p_html+s_html+'</select></td>';
                        }
                        else if(data[num]['attr_input_type']==681){
                            p_html=p_html+'<td><textarea class="input-text" type="text" name="setlist['+num+'][attr_content]"></textarea></td>';
                        }
                        else if(data[num]['attr_input_type']==683){
                            p_html=p_html+
                                '<td>'+
                                    '<input class="input-text" name="GfPartnerMemberApply['+num+'][attr_pic]" id="GfPartnerMemberApply_attr_pic['+num+']" type="hidden">'+
                                    '<input id="GfPartnerMemberApply_attr_pic_'+num+'" name="setlist['+num+'][attr_pic]" type="hidden">'+
                                    '<div id="box_GfPartnerMemberApply_attr_pic_'+num+'" style="margin-left:0.5rem;">$setlist.append(p_html);<script>we.uploadpic("GfPartnerMemberApply_attr_pic_'+num+'", "<?php echo $picprefix;?>");<\/script></div>'+
                                '</td>';
                        }
                        else if(data[num]['attr_input_type']==720){
                            var s_html='';
                            p_html=p_html+
                                '<td width="100%;">'+
                                    '<input id="search_values'+num+'" class="input-text" type="text" name="setlist['+num+'][attr_content]" oninput="oninputattrname'+num+'(this);" onpropertychange="oninputattrname'+num+'(this);">'+
                                    '<input id="values_input'+num+'" class="input-text" type="hidden" name="setlist['+num+'][attr_value_id]">'+
                                    '<div id="search_div'+num+'" class="search_div"><ul id="search_ul" class="search_ul">';
                                        $(function(){
                                            var type=$('#GfPartnerMemberApply_type').val();
                                            var club_id=$('#GfPartnerMemberApply_club_id').val();
                                            var project_id=$('#GfPartnerMemberApply_project_id').val();
                                            $.ajax({
                                                type: 'get',
                                                url: '<?php echo $this->createUrl("gfPartnerMemberApply/down"); ?>&set_input_id='+data[num]['id'],
                                                data: {type:type,club_id:club_id,project_id:project_id},
                                                dataType: 'json',
                                                async: false,
                                                success: function(data){
                                                    if(data!=''){
                                                        for(var i=0;i<data.length;i++) {
                                                            s_html=s_html+'<li class="input-text" onclick="search_click'+num+'(this);" value="'+data[i]['id']+'">'+data[i]['attr_values']+'</li>';
                                                        }
                                                    }
                                                }
                                            });
                                        });
                            p_html=p_html+s_html+'</ul></div></td>'+
                                '<script>'+
                                    'function oninputattrname'+num+'(obj){'+
                                        'var search_val=$(obj).val();'+
                                        'if(search_val!=""){'+
                                            '$("#search_div'+num+'").show();'+
                                        '}'+
                                        'else{'+
                                            '$("#search_div'+num+'").hide();'+
                                        '}'+
                                    '}'+
                                    'function search_click'+num+'(obj){'+
                                        'var li=$(obj).text();'+
                                        'var li1=$(obj).val();'+
                                        '$("#search_values'+num+'").val(li);'+
                                        '$("#values_input'+num+'").val(li1);'+
                                        '$("#search_div'+num+'").hide();'+
                                    '}'+
                                    '$(document).on("click",function(e){'+
                                        'if($(e.target).closest("#search_div'+num+'").length==0){'+
                                            '$("#search_div'+num+'").hide();'+
                                        '}'+
                                    '});'+
                                '<\/script>';
                        }
                        else{
                            p_html=p_html+'<td><input onchange="fnUpdateAttrlist();" class="input-text" name="setlist['+num+'][attr_content]" type="text"></td>';
                        }
                        p_html=p_html+'<td>'+data[num]['attr_unit']+'</td></tr>';
                        num++;
                    }
                    $setlist.append(p_html);
                    fnUpdateAttrlist();
                }
            },
            error: function(){
                we.msg('minus',club_box1.innerHTML+'没有'+'"'+project_id1.innerHTML+'"'+'这个项目');
                return false;
            }
        });
    });

    var fnUpdateAttrlist=function(){
        var isEmpty=true;
        $setlist.find('.input-text').each(function(){
            if($(this).val()!=''){
                isEmpty=false;
                //return false;
            }
        });
        if(!isEmpty){
            $('#GfPartnerMemberApply_setlist').val('1').trigger('blur');
        }else{
            $('#GfPartnerMemberApply_setlist').val('').trigger('blur');
        }
    };

    function accountOnchang(obj){
        var changval=$(obj).val();
        if (changval.length>=6) {
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('validate');?>&gfid='+changval,
                data: {gfid:changval},
                dataType: 'json',
                success: function(data) {
                    if(data.status==1){
                        $('#GfPartnerMemberApply_gfid').val(data.gfid);
                        $('#GfPartnerMemberApply_zsxm').val(data.zsxm);
                        $('#GfPartnerMemberApply_id_card').val(data.card_num);
                    }
                    else{
                        $(obj).val('');
                        we.msg('minus', data.msg);
                    }
                }
            });
        }
    }

    $(function(){
        $('#GfPartnerMemberApply_effective_start_time').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});
        });
        $('#GfPartnerMemberApply_effective_end_time').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});
        });

        var dis_type=$('#GfPartnerMemberApply_type').val();
        if(dis_type==403){
            $("#t1").show();
        }
        else{
            $("#t1").hide();
        }

        // 添加项目
        var $project_box=$('#project_box');
        var $GfPartnerMemberApply_project_id=$('#GfPartnerMemberApply_project_id');
        $('#project_select_btn').on('click', function(){
            $.dialog.data('project_id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/project_list");?>',{
                id:'danwei',
                lock:true,
                opacity:0.3,
                title:'选择具体内容',
                width:'500px',
                height:'60%',
                close: function () {
                    if($.dialog.data('project_id')>0){
                        project_id=$.dialog.data('project_id');
                        $GfPartnerMemberApply_project_id.val($.dialog.data('project_id')).trigger('blur');
                        $project_box.html('<span id="project_id1" class="label-box">'+$.dialog.data('project_title')+'</span>');
                    }
                }
            });
        });
        
        // 选择单位
        var $club_box=$('#club_box');
        var $partner_id=$('#GfPartnerMemberApply_partner_id');
        var $club_logo=$('#GfPartnerMemberApply_club_logo');
        var $club_address=$('#GfPartnerMemberApply_club_address');
        $('#club_select_btn').on('click', function(){
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
                        club_id=$.dialog.data('club_id');
                        $partner_id.val($.dialog.data('club_id')).trigger('blur');
                        $club_logo.val($.dialog.data('club_logo_pic'));
                        // $club_address.val($.dialog.data('club_address'));
                        // $('#club_address').text($.dialog.data('club_address'));
                        $('#isclub_id').html('是');
                        $club_box.html('<span id="club_box1" class="label-box">'+$.dialog.data('club_title')+'</span>');
                    }
                }
            });
        });

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
                        $club_address.val($.dialog.data('club_address'));
                        $('#GfPartnerMemberApply_club_id').val($.dialog.data('club_id')).trigger('blur');
                        $('#club_list_box').html('<span id="club_list_box1" class="label-box">'+$.dialog.data('club_title')+'</span>');
                    }
                }
            });
        });
    });

    // 选择服务者
    var $account_box=$('#account_box');
    $('#account_select_btn').on('click', function(){ 
        $.dialog.data('GF_ID', 0);
        $.dialog.open('<?php echo $this->createUrl("select/gfuser");?>',{
        id:'gfzhanghao',
		lock:true,opacity:0.3,
		width:'500px',
		height:'60%',
        title:'选择具体内容',		
        close: function () {
            //console.log($.dialog.data('club_id'));
            if($.dialog.data('GF_ID')>0){
                $('#GfPartnerMemberApply_gfid').val($.dialog.data('GF_ID'));
                $('#GfPartnerMemberApply_gf_account').val($.dialog.data('GF_ACCOUNT'));
                $account_box.html('<span class="label-box">'+$.dialog.data('GF_ACCOUNT')+'</span>');
				gfid=$('#GfPartnerMemberApply_gfid').val();               
            }
         }
       });
    });

    function printpage(){
        var html='';
        for(var i=0;i<5;i++){
            html += '<table>'+$("#t"+i).html()+"</table>";
            html+="<br>";
        }
        
        var newWin = window.open('', '', '');
        newWin.document.write('<head><style>#print-content{font-size:14px}</style> \
            <style> \
                .box-detail table, .box-detail-table{\
                    table-layout:fixed;\
                    width:100%;\
                    border-spacing:1px;\
                    border-collapse:collapse;\
                    background:#ccc;}\
                .box-detail td, .box-detail-table td{\
                    padding:10px;\
                    background:#fff; \
                    border: 1px solid black; \
                    text-align:left;}\
                .box-detail table.table-title{ \
                    border-collapse:collapse; \
                    border-top:1px #ccc solid;	\
                    border-right:1px #ccc solid;\
                    border-left:1px #ccc solid;}\
                .table-title td{background:#efefef;}\
                .box-detail-bd{padding:50px;}\
                .btn{display:none;}\
                .input-text {border:none;}\
                .search_div {display:none;}\
                .box-detail-table td{text-align:left;}\
                textarea{resize:none;}\
                select {appearance:none;-webkit-appearance:none;border:none;}\
            </style> \
            </head>');
        newWin.document.write('<div><div class="box-detail">'+html+"</div></div>");
        newWin.print();
        newWin.close(); //关闭新产生的标签页
    }
</script>