<?php 
    if(!empty($model->type)){
        $_REQUEST['type']=$model->type;
    }
?>
<style>
    .box-detail-bd table{
        table-layout:auto!important;
    }
    /* .box-detail-bd table tr td:nth-child(2n+1){
        width:10px;
    }
    .box-detail-bd table tr td:nth-child(2n+2){
        width:300px;
    } */
    .input-text{
        max-width:300px!important;
    }
</style>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i><?=$_REQUEST['type']==403?'个人':'单位'?>入会模板设置</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <!-- <div class="box-detail-tab" style="margin-top:10px;">
            <ul class="c">
                <li class="<?//=$_REQUEST['type']==403?'current':'';?>"><a href="<?php //echo $this->createUrl('create',array('type'=>403));?>">个人</a></li>
                <li class="<?//=$_REQUEST['type']==404?'current':'';?>"><a href="<?php //echo $this->createUrl('create',array('type'=>404));?>">单位</a></li>
            </ul>
        </div> -->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table border="0" cellspacing="1" cellpadding="0" class="product_publish_content">
                    <tr class="table-title">
                    	<td colspan="2">模板信息</td>
                    </tr>
                    <tr>
                        <td style="width:100px;"><?php echo $form->labelEx($model, 'code'); ?>：</td>
                        <td>
                            <?php echo $form->textField($model, 'code', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'code', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'title'); ?>：</td>
                        <td>
                            <?php echo $form->textField($model, 'title', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'title', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <table class="mt15">
                    <tr class="table-title">
                    	<td colspan="2">入会信息</td>
                    </tr>
                    <tr>
                        <td style="width:100px;"><?php echo $form->labelEx($model, 'project_id'); ?>：</td>
                        <td>
                            <?php echo $form->hiddenField($model, 'project_id', array('class' => 'input-text')); ?>
                                <span id="project_box">
                                    <?php if($model->project_list!=null){?>
                                        <span class="label-box"><?php echo $model->project_list->project_name;?></span>
                                    <?php }?>
                                </span>
                                <input id="project_select_btn" class="btn" type="button" value="选择">
                            <?php echo $form->error($model, 'project_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'club_id'); ?>：</td>
                        <td >
                            <span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->club_list->club_name;?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text')); ?></span><?php } else {?><span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value'=>get_session('club_id'))); ?></span><?php } ?></span>
                            <?php echo $form->error($model, 'club_id', $htmlOptions = array()); ?>
                        </td>
                        <!-- <td><?php echo $form->labelEx($model, 'type'); ?>：</td> -->
                        <!-- <td></td>
                            <?php //echo $form->dropDownList($model, 'type', Chtml::listData(BaseCode::model()->getCode(402), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange'=>'clubTypeTemplate(this)')); ?>
                            <?php //echo $form->error($model, 'type', $htmlOptions = array()); ?>
                        </td>
                        <td colspan="2"></td> -->
                        <?php echo $form->hiddenField($model, 'type',array('value' =>$_REQUEST['type'])); ?>
                    </tr>
                </table>

                <?//=var_dump($attr_data);?>
                <div class="box-table" style="padding:0;">
                    <?php echo $form->hiddenField($model, 'attr_data'); ?>
                    <table id="attr_list" class="list mt15" style="border-collapse: collapse;border-spacing: 0;">
                        <thead>
                            <tr class="table-title">
                                <td colspan="4" style='border-color:#ccc;padding:10px;'>会员信息</td>
                                <td colspan="" style='text-align: center;border-color:#ccc;padding:5px;' >
                                    <input type="button" class="btn" onclick="add_tag(0,-1);" value="添加属性">
                                </td>
                            </tr>
                            <tr class="table-title">
                                <th>属性名称</th>
                                <th>属性录入方式</th>
                                <th>属性单位</th>
                                <th style="width: 300px;">可选属性值</th>
                                <!-- <th>排序号</th> -->
                                <!-- <th>邀请使用</th> -->
                                <th style="width: 150px;">操作</th>
                            </tr>
                        </thead>
                        <?php
                            $fix_info = GfPartnerMemberInputset::model()->findAll('isNull(set_id) and type='.$_REQUEST['type'].' order by sort_order ASC');

                            $content='';$index = 0;
                            if(!empty($fix_info))foreach($fix_info as $t){
                                $content.='<tr class="attr_data" data-id="'.$t->id.'" data-index="'.$index.'">';
                                $content.='<input class="input-text" type="hidden" name="attr_data['.$index.'][attr_id]"  value="'.$t->id.'">';
                                $content.='<td style="border-color:#ccc;padding:5px;">';
                                $content.='<span>'.$t->attr_name.'</span>';
                                $content.='<input class="input-text" type="hidden" name="attr_data['.$index.'][attr_name]"  value="'.$t->attr_name.'"></td>';
                                $content.='<td style="border-color:#ccc;padding:5px;">';
                                $content.='<span>'.$t->base_code->F_NAME.'</span>';
                                $content.='<input class="input-text" type="hidden" name="attr_data['.$index.'][attr_input_type]" value="'.$t->attr_input_type.'"></td>';
                                $content.='<td style="border-color:#ccc;padding:5px;">';
                                $content.='<span>'.$t->attr_unit.'</span>';
                                $content.='<input class="input-text" type="hidden" name="attr_data['.$index.'][attr_unit]" value="'.$t->attr_unit.'"></td>';
                                $content.='<td style="border-color:#ccc;padding:5px;">';
                                $values=GfPartnerMemberValues::model()->findAll('set_input_id='.$t->id);
                                $val='';
                                $n=0;
                                if(!empty($values))foreach($values as $h2){
                                    $val.=$h2->attr_values.',';
                                    $content.='<input class="input-text values_id" type="hidden" name="attr_data['.$index.'][values]['.$n.'][values_id]" value="'.$h2->id.'">';
                                    $content.='<input class="input-text values_name" type="hidden" name="attr_data['.$index.'][values]['.$n.'][values_name]" value="'.$h2->attr_values.'">';
                                    $n++;
                                }
                                $content.='<span>'.rtrim($val, ',').'</span></td>';
                                // $content.='<td style='text-align: center;border-color:#ccc;padding:5px;'>';
                                // $content.='<span>'.$t->sort_order.'</span>';
                                // $content.='<input class="input-text" type="hidden" name="attr_data['.$index.'][sort_order]" value="'.$t->sort_order.'"></td>';
                                // $content.='<td style="border-color:#ccc;padding:5px;">';
                                // $content.='<span>'.$t->isInvite->F_NAME.'</span>';
                                // $content.='<input class="input-text" type="hidden" name="attr_data['.$index.'][is_invite]"  value="'.$t->is_invite.'"></td>';
                                $content.='<td style="border-color:#ccc;padding:5px;">';
                                // $content.='<input onclick="add_tag('.$t->id.','.$index.');" class="btn" type="button" value="编辑">';
                                $content.='</td>';
                                $content.='</tr>';
                                $index++;
                            }
                            echo $content;
                        ?>
                        <?php if(!empty($attr_data))foreach($attr_data as $v){?>
                        <tr class="attr_data" data-id="<?php echo $v->id; ?>" data-index="<?php echo $index;?>">
                            <input class="input-text" type="hidden" name="attr_data[<?php echo $index;?>][attr_id]"  value="<?php echo $v->id; ?>">
                            <td style='border-color:#ccc;padding:5px;'>
                                <span><?php echo $v->attr_name; ?></span>
                                <input class="input-text" type="hidden" name="attr_data[<?php echo $index;?>][attr_name]"  value="<?php echo $v->attr_name;?>">
                            </td>
                            <td style='border-color:#ccc;padding:5px;'>
                                <span><?php if($v->base_code!=null){ echo $v->base_code->F_NAME; } ?></span>
                                <input class="input-text" type="hidden" name="attr_data[<?php echo $index; ?>][attr_input_type]" value="<?php echo $v->attr_input_type; ?>">
                            </td>
                            <td style='border-color:#ccc;padding:5px;'>
                                <span><?php echo $v->attr_unit; ?></span>
                                <input class="input-text" type="hidden" name="attr_data[<?php echo $index; ?>][attr_unit]" value="<?php echo $v->attr_unit; ?>">
                            </td>
                            <td style='border-color:#ccc;padding:5px;'>
                                <?php
                                    $number=GfPartnerMemberValues::model()->findAll('set_input_id='.$v->id);
                                    $values_id='';
                                    $agg='';
                                    $num=0;
                                    if(!empty($number))foreach($number as $h){
                                        $agg.=$h->attr_values.',';
                                        $values_id.=$h->id.',';
                                        echo '<input class="input-text values_id" type="hidden" name="attr_data['.$index.'][values]['.$num.'][values_id]" value="'.$h->id.'"><input class="input-text values_name" type="hidden" name="attr_data['.$index.'][values]['.$num.'][values_name]" value="'.$h->attr_values.'">';
                                        $num++;
                                    }
                                    echo '<span>'.rtrim($agg, ',').'</span>';
                                ?>
                            </td>
                            <!-- <td style='text-align: center;border-color:#ccc;padding:5px;'>
                                <span><? // echo $v->sort_order; ?></span>
                                <input class="input-text" type="hidden" name="attr_data[<?php //echo $index; ?>][sort_order]" value="<?php // echo $v->sort_order; ?>">
                            </td> -->
                            <!-- <td style='border-color:#ccc;padding:5px;'>
                                <span><?php //if($v->isInvite!=null){ echo $v->isInvite->F_NAME; } ?></span>
                                <input class="input-text" type="hidden" name="attr_data[<?php //echo $index; ?>][is_invite]" value="<?php //echo $v->is_invite; ?>">
                            </td> -->
                            <td style='border-color:#ccc;padding:5px;'>
                                <input onclick="add_tag(<?php echo $v->id.','.$index; ?>);" class="btn" type="button" value="编辑">
                                <input class="btn remove_data" type="button" value="删除">
                            </td>
                        </tr>
                        <?php $index++;} ?>
                    </table>
                    <?php echo $form->hiddenField($model, 'remove_attribute', array('class' => 'input-text fl'));?>
                    <?php echo $form->hiddenField($model, 'remove_inputset', array('class' => 'input-text fl'));?>
                </div>
                <table class="mt15">
                    <tr>
                        <td style="width:100px;"><?php echo $form->labelEx($model, 'rules'); ?>：</td>
                        <td>
                            <?php echo $form->dropDownList($model, 'rules', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange' =>'selectRulesOnchang(this)')); ?>
                            <?php echo $form->error($model, 'rules', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr style="display:none;" id="is_rules">
                        <td><?php echo $form->labelEx($model, 'rules_description_temp'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'rules_description_temp', array('class' => 'input-text')); ?>
                            <script>we.editor('<?php echo get_class($model);?>_rules_description_temp', '<?php echo get_class($model);?>[rules_description_temp]');</script>
                            <?php echo $form->error($model, 'rules_description_temp', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <table class="mt15">
                    <tr>
                        <td style="width:100px;">操作</td>
                        <td >
                            <?php echo show_shenhe_box(array('baocun'=>'保存')); ?>
                            <!-- <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>&nbsp; -->
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        </th>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
    <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    // var num=<?php //echo $num;?>;
    var deleteUrl = '<?php echo $this->createUrl('deletedata', array('id'=>'ID'));?>';
    // we.tab('.box-detail-tab li','.box-detail-tab-item');

    function selectPayOnchang(obj){
        var show_id=$(obj).val();
        if(show_id==649){
            $("#is_pay").show();
        }
        else{
            $("#is_pay").hide();
        }
    };
    function clubTypeTemplate(obj){
        var show_id=$(obj).val();
        if(show_id>0){
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('template');?>&type='+show_id,
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    $(".template").remove();
                    var content='';
                    $.each(data,function(k,info){
                        content+= '<tr class="template">';
                        content+= '<td style="text-align: center;border-color:#ccc;padding:10px;">';
                        content+= '<span>'+info.attr_name+'</span>';
                        content+= '</td>';
                        content+= '<td style="text-align: center;border-color:#ccc;padding:10px;">';
                        content+= '<span>';
                        // if($t->base_code!=null){
                        //     content.= $t->base_code->F_NAME;
                        // }
                        content+= '</span>';
                        content+= '</td>';
                        content+= '<td style="text-align: center;border-color:#ccc;padding:10px;">';
                        content+= '<span>'+info.attr_unit+'</span>';
                        content+= '</td>';
                        content+= '<td style="text-align: center;border-color:#ccc;padding:10px;">';
                        content+= '<span>';
                        if(info.datas){
                            var value=[];
                            $.each(info.datas,function(m,n){
                                value.push(n.attr_values);
                            })
                            content+=value.join(',');
                        }
                        content+= '</span>';
                        content+= '<span></span>';
                        content+= '</td>';
                        // content+= '<td style="text-align: center;border-color:#ccc;padding:10px;">';
                        // content+= '<span>'+info.sort_order+'</span>';
                        // content+= '</td>';
                        content+= '<td style="text-align: center;border-color:#ccc;padding:10px;">';
                        content+= '</td>';
                        content+= '</tr>';
                    })
                    $("#attr_list tbody").prepend(content);
                }
            })
        }
    }
    function selectRulesOnchang(obj){
        var show_id=$(obj).val();
        if(show_id==649){
            $("#is_rules").show();
        }
        else{
            $("#is_rules").hide();
        }
    };
    
    function add_tag(e,q){
        var attr_name='';
        var attr_unit='';
        var attr_input_type='';
        var sort_order='';
        var attr_values='';
        var attr_value_id='';
        // var is_invite=648;
        if(q>=0){
            $(".attr_data").each(function(){
                var _th=$(this);
                if(q==_th.attr("data-index")){
                    attr_name=$.trim(_th.children('td').eq(0).text());
                    attr_input_type=$.trim(_th.children('td').eq(1).find('input').val());
                    attr_unit=$.trim(_th.children('td').eq(2).text());
                    // sort_order=$.trim(_th.children('td').eq(4).text());
                    attr_values=$.trim(_th.children('td').eq(3).find('span').text()).split(',');
                    attr_value_id=$.trim(_th.children('td').eq(3).find('input').eq(0).val()).split(',');
                    // is_invite=$.trim(_th.children('td').eq(4).find('input').val());
                }
            })
        }
        var add_html = 
        '<div class="box-detail" id="add_format" style="width:800px;">'+
            '<form id="add_form" name="add_form">'+
                '<table id="table_tag" class="" style="width:100%;">'+
                    '<tr class="table-title">'+
                        '<td colspan="4">添加属性</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>属性名称 <span class="required">*</span></td>'+
                        '<td colspan="3"><input id="attr_name" class="input-text" name="" value="'+attr_name+'"></td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>属性录入方式 <span class="required">*</span></td>'+
                        '<td colspan="3">'+
                            '<?php $base_code=BaseCode::model()->getCode(676); if(!empty($base_code))foreach($base_code as $ba){?>'+
                                '<span class="check"><input class="input-check" change="onchange(this);" value="<?php echo $ba->f_id; ?>" type="radio" name="add_ba"'; attr_input_type==<?=$ba->f_id?>?add_html+='checked="checked"':'';add_html+='><label for=""><?php echo $ba->F_NAME; ?></label></span>'+
                            '<?php }?>'+
                        '</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td >属性单位</td>'+
                        '<td colspan="3"><input id="attr_unit" class="input-text" name="" value="'+attr_unit+'"></td>'+
                        // '<td>排序号 <span class="required">*</span></td>'+
                        // '<td><input id="sort_order" class="input-text" name="" value="'+sort_order+'"></td>'+
                    '</tr>'+
                    // '<tr>'+
                    //     '<td >邀请使用</td>'+
                    //     '<td colspan="3">'+
                    //         '<?php //$base_code=BaseCode::model()->getCode(647); if(!empty($base_code))foreach($base_code as $ba){?>'+
                    //             '<span class="check"><input class="input-check" change="onchange(this);" value="<?php //echo $ba->f_id; ?>" type="radio" name="invite"'; is_invite==<?//=$ba->f_id?>?add_html+='checked="checked"':'';add_html+='><label for=""><?php //echo $ba->F_NAME; ?></label></span>'+
                    //         '<?php //}?>'+
                    //     '</td>'+
                    // '</tr>'+
                    '<table id="attr_values" ';
                    if(attr_input_type!=678&&attr_input_type!=720){
                        add_html+='style="display:none;"';
                    }
                    add_html+='>'+
                    '<tr class="table-title">'+
                        '<td colspan="2">可选属性值 <span class="required">*</span><input style="float:right;" onclick="addAttribute();" class="btn" type="button" value="添加行"></td>'+
                    '</tr>';
                        $('.attr_data[data-index="'+q+'"] .values_id').each(function(k){
                            var $_t=$(this);
                            $('.attr_data[data-index="'+q+'"] .values_name').each(function(m){
                                var $_T=$(this);
                                if(m==k){
                                    add_html+='<tr class="attr_values" value="'+$_t.val()+'">'+
                                    '<td><input class="input-text" name="" value="'+$_T.val()+'"></td>'+
                                    '<td>'+
                                        '<input class="btn r_attr" type="button" value="删除行">'+
                                    '</td>'+
                                    '</tr>';
                                }
                            })
                        })
                    add_html+='</table>'+
                '</table>'+
            '</form>'+
        '</div>';
        $.dialog({
            id:'tianjia',
            lock:true,
            opacity:0.3,
            height: '60%',
            // width: '100%',
            title:'添加属性',
            content:add_html,
            button:[
                {
                    name:'保存',
                    callback:function(){
                        if($("#attr_name").val()==''){
                            we.msg('minus','请输入属性名称');
                            return false;
                        }
                        if(!$('input[name="add_ba"]').is(':checked')) {
                            we.msg('minus','请选中属性录入方式');
                            return false;
                        }
                        // if($("#sort_order").val()==''){
                        //     we.msg('minus','请输入排序号');
                        //     return false;
                        // }
                        var is_must=true;
                        $(".attr_values").each(function(){
                            if($(this).find('td').eq(0).find("input").val()==''){
                                is_must=false;
                            }
                        })
                        if(!is_must){
                            we.msg('minus','请输入属性值');
                            return false;
                        }
                        if(q<0){
                            return fn_add_tr(0);
                        }else{
                            return fn_change_tr(e,q);
                        }
                    },
                    focus:true
                },
                {
                    name:'取消',
                    callback:function(){
                        $("#GfPartnerMemberSet_remove_attribute").val('');
                        remove_arr=[];
                        return true;
                    }
                }
            ]
        });
        $('.aui_main').css('height','auto');
    }
    $(document).on('keyup','#sort_order',function(){
        this.value=this.value.replace(/\D/gi,"");
    })
    var index=<?php echo $index;?>;
    // 添加删除可选属性值
    var index = index+1;
    function addAttribute(){
        var add_h =
        '<tr class="attr_values" value="0">'+
        '<td><input class="input-text" name="" value=""></td>'+
        '<td>'+
        '<input class="btn r_attr" type="button" value="删除行">'+
        '</td>'+
        '</tr>';
        $("#attr_values").append(add_h);
    }
    var remove_arr=[];
    $(document).on("click",".r_attr",function(){
        var removeValue=$(this).parent().parent().attr("value");
        remove_arr.push(removeValue);
        $("#GfPartnerMemberSet_remove_attribute").val(remove_arr.join(','))
        $(this).parent().parent().remove();
    })
    function fn_add_tr(e){
        var length=parseInt($(".attr_data").last().attr('data-index'))+1;
        var text='';
        text+='<tr class="attr_data" data-id="0" data-index="'+length+'">';
        text+='<input class="input-text" type="hidden" name="attr_data['+length+'][attr_id]" value="0">';
        text+='<td style="border-color:#ccc;padding:5px;">';
        text+='<span>'+$("#attr_name").val()+'</span>';
        text+='<input class="input-text" type="hidden" name="attr_data['+length+'][attr_name]" value="'+$("#attr_name").val()+'">';
        text+='</td>';
        text+='<td style="border-color:#ccc;padding:5px;">';
        text+='<span>'+$("input[name='add_ba']:checked").next().text()+'</span>';
        text+='<input class="input-text" type="hidden" name="attr_data['+length+'][attr_input_type]" value="'+$("input[name='add_ba']:checked").val()+'">';
        text+='</td>';
        text+='<td style="border-color:#ccc;padding:5px;">';
        text+='<span>'+$("#attr_unit").val()+'</span>';
        text+='<input class="input-text" type="hidden" name="attr_data['+length+'][attr_unit]" value="'+$("#attr_unit").val()+'">';
        text+='</td>';
        text+='<td style="border-color:#ccc;padding:5px;">';
        var num=0;
        var val=[];
        $(".attr_values").each(function(){
            var th=$(this);
            text+='<input class="input-text values_id" type="hidden" name="attr_data['+length+'][values]['+num+'][values_id]" value="'+th.attr('value')+'">';
            text+='<input class="input-text values_name" type="hidden" name="attr_data['+length+'][values]['+num+'][values_name]" value="'+th.children("td").eq(0).find('input').val()+'">'
            num++;
            val.push(th.children("td").eq(0).find('input').val());
        })
        text+='<span>'+val.join(',')+'</span>';
        text+='</td>';
        // text+='<td style="border-color:#ccc;padding:5px;">';
        // text+='<span>'+$("#sort_order").val()+'</span>';
        // text+='<input class="input-text" type="hidden" name="attr_data['+length+'][sort_order]" value="'+$("#sort_order").val()+'">';
        // text+='</td>';
        // text+='<td style="border-color:#ccc;padding:5px;">';
        // text+='<span>'+$("input[name='invite']:checked").next().text()+'</span>';
        // text+='<input class="input-text" type="hidden" name="attr_data['+length+'][is_invite]" value="'+$("input[name='invite']:checked").val()+'">';
        // text+='</td>';
        text+='<td style="border-color:#ccc;padding:5px;">';
        text+='<input onclick="add_tag(0,'+length+');" class="btn" type="button" value="编辑">&nbsp;';
        text+='<input class="btn remove_data" type="button" value="删除">';
        text+='</td>';
        text+='</tr>';
        $("#attr_list").append(text);
    }
    var remove_data=[];
    $(document).on("click",".remove_data",function(){
        var removeData=$(this).parent().parent().attr("data-id");
        remove_data.push(removeData);
        $("#GfPartnerMemberSet_remove_inputset").val(remove_data.join(','))
        $(this).parent().parent().remove();
    })
    function fn_change_tr(e,q){
        $('.attr_data[data-index="'+q+'"]').children("td").eq(0).find("span").html($("#attr_name").val());
        $('.attr_data[data-index="'+q+'"]').children("td").eq(0).find("input").val($("#attr_name").val());
        $('.attr_data[data-index="'+q+'"]').children("td").eq(1).find("span").html($("input[name='add_ba']:checked").next().text());
        $('.attr_data[data-index="'+q+'"]').children("td").eq(1).find("input").val($("input[name='add_ba']:checked").val());
        $('.attr_data[data-index="'+q+'"]').children("td").eq(2).find("span").html($("#attr_unit").val());
        $('.attr_data[data-index="'+q+'"]').children("td").eq(2).find("input").val($("#attr_unit").val());

        var val=[];
        $('.attr_data[data-index="'+q+'"] .values_id,.attr_data[data-index="'+q+'"] .values_name').remove();
        var num=0;
        var l_index=$('.attr_data[data-index="'+q+'"]').index();
        $(".attr_values").each(function(){
            var th=$(this);
            $('.attr_data[data-index="'+q+'"]').find("td").eq(3).append('<input class="input-text values_id" type="hidden" name="attr_data['+l_index+'][values]['+num+'][values_id]" value="'+th.attr('value')+'"><input class="input-text values_name" type="hidden" name="attr_data['+l_index+'][values]['+num+'][values_name]" value="'+th.children("td").eq(0).find('input').val()+'">');
            num++;
            val.push(th.children("td").eq(0).find('input').val());
        })
        $('.attr_data[data-index="'+q+'"]').children("td").eq(3).find("span").html(val.join(','));
        // $('.attr_data[data-index="'+q+'"]').children("td").eq(4).find("span").html($("#sort_order").val());
        // $('.attr_data[data-index="'+q+'"]').children("td").eq(4).find("input").val($("#sort_order").val());
        // $('.attr_data[data-index="'+q+'"]').children("td").eq(4).find("span").html($("input[name='invite']:checked").next().text());
        // $('.attr_data[data-index="'+q+'"]').children("td").eq(4).find("input").val($("input[name='invite']:checked").val());
    }

    $(function(){
        // 切换可选属性值
        $(document).on("change","input[type='radio']",function(){
            var radio=$("input[type='radio']:checked").val();
            if(radio==678 || radio==720){
                $('#attr_values').show();
            }
            else{
                $('#attr_values').hide();
            }
        })


        var pay_id=$('#GfPartnerMemberSet_if_pay_item').val();
        if(pay_id==649){
            $("#is_pay").show();
        }
        else{
            $("#is_pay").hide();
        }

        var rules_id=$('#GfPartnerMemberSet_rules').val();
        if(rules_id==649){
            $("#is_rules").show();
        }
        else{
            $("#is_rules").hide();
        }

        

        // 选择项目
        var $project_box=$('#project_box');
        var $GfPartnerMemberSet_project_id=$('#GfPartnerMemberSet_project_id');
        $('#project_select_btn').on('click', function(){
            var club_id=$('#GfPartnerMemberSet_club_id').val();
            $.dialog.data('project_id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/project_list");?>&club_id='+club_id,{
                id:'danwei',
                lock:true,
                opacity:0.3,
                title:'选择具体内容',
                width:'500px',
                height:'60%',
                close: function () {
                    //console.log($.dialog.data('club_id'));
                    if($.dialog.data('project_id')>0){
                        var project_id=$.dialog.data('project_id');
                        $GfPartnerMemberSet_project_id.val($.dialog.data('project_id')).trigger('blur');
                        $project_box.html('<span class="label-box">'+$.dialog.data('project_title')+'</span>');

                        is_exist($("#GfPartnerMemberSet_type").val(),club_id,project_id);
                    }
                }
            });
        });
        function is_exist(type,clubId,projectId){
            console.log(type)
            console.log(clubId)
            console.log(projectId)
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('is_exist');?>&type='+type+'&club_id='+clubId+'&project_id='+projectId,
                dataType: 'json',
                success: function(data) {
                    if(data>0){
                        $("#project_box").empty();
                        $("#GfPartnerMemberSet_project_id").val('');
                        we.msg('minus','本项目模板已设置，请勿重复设置');
                        return false;
                    }
                }
            })
        }
    });
</script>