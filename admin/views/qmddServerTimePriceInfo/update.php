<?php
    $service_type = QmddServerType::model()->findAll();
    $service_user_type = QmddServerUsertype::model()->findAll('if_del=510');
    $t1='id,f_ucode,f_uname,f_member_type,t_server_type_id,t_code,t_name,project_ids';
    $t2=QmddServerUsertype::model()->findAll('if_del=510');
    $user_type=toArray($t2,$t1);
    // $member_card = MemberCard::model()->findAll('type=501 or mamber_type in(1157,1158) and f_id<>63');
    $s1="f_id,mamber_type,mamber_type_name,card_name";
    $s2=MemberCard::model()->findAll('type=501 or mamber_type in(1157,1158) and f_id<>63');
    $member=toArray($s2,$s1);
    $model->f_uid = empty($model->id) ? 0 : $model->f_uid;
    $model->id = empty($model->id) ? 0 : $model->id;
    $time_data = QmddServerTimePriceData::model()->findAll('if_send=649 AND info_id='.$model->id);
    $count = count($time_data);
?>
<script>
    var member=<?php echo json_encode($member);?>;
    var user_type=<?php echo json_encode($user_type);?>;
</script>
<style>
    #service_time td{ padding: 2px; }
    #service_time td input{ width: 75%; }
    /* .dis_service_class{ width: 100px; }
    .dis_service_grade{ width: 101px; } */
    /* #service_time .time{ width: 80px; } */
    /* #service_time .mony{ width: 40px; } */
    #service_time{ background-color:#fff;border:solid 1px #d9d9d9; }
    /* #service_time tr:nth-child(even){ border-left:solid 1px #d9d9d9; } */
    #service_time tr td{ border:solid 1px #d9d9d9;padding:5px; }

    /* @media screen and (min-width: 814px){ #service_time{width:93.2%} }
    @media screen and (min-width: 890px) { #service_time{width:94.4%} }
    @media screen and (min-width: 1030px) { #service_time{width:95.2%;} }
    @media screen and (min-width: 1070px) { #service_time{width:94.9%;} }
    @media screen and (min-width: 1156px) { #service_time{width:95.3%;} }
    @media screen and (min-width: 1210px) { #service_time{width:95.6%;} }
    @media screen and (min-width: 1470px) { #service_time{width:96.35%;} }
    @media screen and (min-width: 1710px) { #service_time{width:96.9%;} } */

    @media screen and (min-width:1556px){ .time_sc{ width:16.29%; } }
    /* @media screen and (max-width:1555px){ .time_sc{ width:16.66%; } } */
    @media screen and (min-width:1765px) and (max-width:1820px){ .time_sc{ width:16.63%; } }
</style>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i><?php echo (empty($model->id)) ? '添加' : '设置' ?>详细</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回列表</a></span></div><!--box-title end-->
    <div class="box-detail">
		<?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table class="mt15">
                    <tr class="table-title">
                        <td colspan="6">基本信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'tp_code'); ?></td>
                        <td><?php echo $model->tp_code; ?></td>
                        <td><?php echo $form->labelEx($model, 'tp_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'tp_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'tp_name', $htmlOption = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'f_typeid'); ?></td>
                        <td>
                            <!-- <?php //echo $form->dropDownList($model, 'f_uid', Chtml::listData($service_type, 'id', 't_name'), array('prompt'=>'请选择','onchange'=>'onchangeFuid(this);')); ?> -->
                            <?php //echo $form->hiddenField($model, 't_code'); ?>
                            <?php //echo $form->hiddenField($model, 't_name'); ?>
                            <select name="QmddServerTimePriceInfo[f_typeid]" id="QmddServerTimePriceInfo_f_typeid" onchange="selectFtypeid(this,0,<?php echo $model->f_uid; ?>);">
                                <option value>请选择</option>
                                <?php foreach($service_type as $s) {?>
                                    <option value="<?php echo $s->id; ?>" tcode="<?php echo $s->t_code; ?>" tname="<?php echo $s->t_name; ?>" <?php if($s->id==$model->f_typeid){ echo 'selected="selected"'; } ?>><?php echo $s->t_name; ?></option>
                                <?php }?>
                            </select>
                            <?php echo $form->error($model, 'f_typeid', $htmlOption = array()); ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="mt15" style="table-layout:auto;">
                <table>
                    <tr class="table-title">
                        <?php echo $form->hiddenField($model, 'f_ucode'); ?>
                        <?php echo $form->hiddenField($model, 'f_uname'); ?>
                        <?php echo $form->hiddenField($model, 't_code'); ?>
                        <?php echo $form->hiddenField($model, 't_name'); ?>
                        <?php echo $form->hiddenField($model, 'project_ids'); ?>
                        <td colspan="15">服务类别：
                            <select name="QmddServerTimePriceInfo[f_uid]" id="QmddServerTimePriceInfo_f_uid" onchange="onchangeFuid(this);">
                                <option value>请选择</option>
                                <?php foreach($service_user_type as $s) {?>
                                    <option value="<?php echo $s->id; ?>" 
                                        membertype="<?php echo $s->f_member_type; ?>" 
                                        fucode="<?php echo $s->f_ucode; ?>" 
                                        funame="<?php echo $s->f_uname; ?>" 
                                        tcode="<?php echo $s->t_code; ?>" 
                                        tname="<?php echo $s->t_name; ?>" 
                                        projectids="<?php echo $s->project_ids; ?>" 
                                        <?php if($s->id==$model->f_uid){ echo 'selected="selected"'; } ?>>
                                        <?php echo $s->f_uname; ?>
                                    </option>
                                <?php }?>
                            </select>
                            <input onclick="add_service();" class="btn btn-blue" type="button" value="添加">
                            <span>
                                <span>售价</span>
                                <spn class="span_tip">
                                    <a href="javascript:;" class="dis_rounds"><i class="fa fa-question"></i></a>
                                    <div class="tip" style="width:100px;">
                                        <p><a href="#" target="_blank">各类服务等级参考价</a></p>
                                        <i class="t"></i>
                                    </div>
                                </span>
                            </span>
                        </td>
                    </tr>
                    <!-- <tr style="text-align:center;">
                        <td class="dis_service_class"><strong>服务类别</strong></td>
                        <td class="dis_service_grade"><strong>等级</strong></td>
                        <td colspan="12"><strong>时间段&价格</strong></td>
                        <?php
                            // for($i=1;$i<7;$i++){
                            //     echo '<td>时间</td>';
                            //     echo '<td>售价</td>';
                            // }
                        ?>
                        <td class="col_time" colspan="1"><strong>操作</strong></td>
                    </tr> -->
                </table>
                <div id="dis_time_table" style="display:inline-flex;width:100%;">
                    <!-- <table style="float:left;width:50px;background-color:#fff;border-top: solid 1px #d9d9d9;border-left: solid 1px #d9d9d9;border-bottom: solid 1px #d9d9d9;">
                        <tr style="display: inline-grid;border-left:solid 1px #d9d9d9;border-bottom:solid 1px #d9d9d9;">
                            <td class="dis_service_class" style="padding:6px 10px 5px;border-top:solid 1px #d9d9d9;">类型</td>
                            <td class="dis_service_grade" style="padding:6px 10px 5px;border-top:solid 1px #d9d9d9;">等级</td>
                            <td style="padding:6px 10px 6px;border-top:solid 1px #d9d9d9;">序号</td>
                            <?php
                                // $model->id = empty($model->id) ? 0 : $model->id;
                                // $data_len = QmddServerTimePriceData::model()->findAll('info_id='.$model->id);
                                // for($o=1;$o<18;$o++){
                                //     echo '<td style="padding:0.59rem;border-top:solid 1px #d9d9d9;text-align:center;">'.$o.'</td>';
                                // }
                            ?>
                        </tr>
                    </table> -->
                    <table id="service_time" style="width:100%;">
                        <?php if(!empty($time_data)) {?>
                            <tr style="display:inline-grid;float:left;">
                                <td class="dis_service_class">类型</td>
                                <td class="dis_service_grade">等级</td>
                                <td>序号</td>
                                <?php
                                    for($b=1;$b<18;$b++){
                                        $data_len = QmddServerTimePriceData::model()->find('info_id='.$model->id.' AND f_dname'.$b.' is not null'.' order by id DESC');
                                        $kj = 'f_dname'.$b;
                                        if(!empty($data_len->$kj)){
                                            echo '<td class="f_time" style="padding:9px;">'.$b.'</td>';
                                        }
                                    }
                                ?>
                            </tr>
                        <?php }?>
                        <?php
                            $num=1;
                            // $wi = '';
                            // if($count==2){ $wi = '48.89%'; }
                            // if($count==3){ $wi = '33.333%'; }
                            // if($count==4){ $wi = '16.5rem'; }
                            // else if($count==5){ $wi = '20%'; }
                            if(!empty($time_data))foreach($time_data as $v){
                        ?>
                            <tr id="time_class_<?php echo $v->f_level; ?>" class="time_sc" style="text-align:center;display:inline-grid;">
                                <input type="hidden" name="service_time[<?php echo $num; ?>][id]" value="<?php echo $v->id; ?>">
                                <input type="hidden" name="service_time[<?php echo $num; ?>][f_dcode]" value="<?php echo $v->f_dcode; ?>">
                                <input type="hidden" name="service_time[<?php echo $num; ?>][f_member_type]" value="<?php echo $v->f_member_type; ?>">
                                <input type="hidden" name="service_time[<?php echo $num; ?>][f_levelname]" value="<?php echo $v->f_levelname; ?>">
                                <input type="hidden" name="service_time[<?php echo $num; ?>][f_level]" value="<?php echo $v->f_level; ?>">
                                <td class="dis_service_class"><?php echo $v->f_uname; ?></td>
                                <td class="dis_service_grade"><?php echo $v->f_levelname; ?></td>
                                <td id="mony_<?php echo $num; ?>" class="dis_service_mony" style="display:inline-flex;">
                                    <span style="width:60%;">时间段</span>
                                    <span style="width:40%;text-align:left;/*margin-left:50px;*/">金额</span>
                                </td>
                                <?php
                                    for($i=1;$i<18;$i++){
                                        if($v{'f_dname'.$i}!='' || !empty($v{'f_dname'.$i})){
                                            echo '<td class="time">
                                                    <input class="input-text i_time" type="text" name="service_time['.$num.'][f_dname'.$i.']" value="'.$v{'f_dname'.$i}.'" style="width:45%;">
                                                    <input class="input-text i_doube" type="text" name="service_time['.$num.'][f_price'.$i.']" value="'.$v{'f_price'.$i}.'" style="width:25%;">
                                                </td>';
                                        }
                                    }
                                ?>
                                <!-- <td id="delect_'.$num.'" class="col_time"><input class="btn" type="button" onclick="timeDelete(<?php echo $v->id; ?>);" value="删除"></td> -->
                            </tr>
                        <?php $time_id = $v->f_level; $num++; }?>
                    </table>
                </div>
            </div>
            </div>
                <table class="mt15">
                    <tr>
                        <td>可执行操作</td>
                        <td colspan="5">
                            <?php echo show_shenhe_box(array('baocun'=>'保存')); ?>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    $(function(){
        count = <?php echo $count; ?>;
        // 判断分辨率
        if(navigator.userAgent.indexOf('Chrome')>-1){
            resolution(count);
        }
        // var f_dname=$('.dname_time');
        // f_dname.on('click', function(){
        //     WdatePicker({startDate:'%y-%M-%D',dateFmt:'HH:mm-HH:mm',minDate:'00:00',quickSel:['%H-00','%H-30','%H-00']});
        // });
        var m_id = <?php echo $model->id; ?>;
        if(m_id==0){
            $('#dis_time_table').hide();
        }
        else{
            $('#dis_time_table').show();
        }

        if(navigator.userAgent.indexOf('Firefox') >= 0){
            var screen4 = document.documentElement.clientWidth;
            if(screen4>1695){
                if(count==2){width = '49.9%';}
                else if(count==4){width = '24.28%';}
                else if(count==6){width = '16.12%';}
                $('.time_sc').css('width',width);
            }
            else if(screen4<=1470 && screen4>1230){
                if(count==2){width = '49.85%';}
                else if(count==4){width = '24.15%';}
                else if(count==6){width = '16.03%';}
                $('.time_sc').css('width',width);
            }
            else if(screen4<=1230 && screen4>1156){
                if(count==2){width = '49.82%';}
                else if(count==4){width = '24%';}
                else if(count==6){width = '15.88%';}
                $('.time_sc').css('width',width);
            }
            else if(screen4<=1156 && screen4>1030){
                if(count==2){width = '49.79%';}
                else if(count==4){width = '23.92%';}
                else if(count==6){width = '15.83%';}
                $('.time_sc').css('width',width);
                $('.i_time').css('width','45%');
                $('.i_doube').css('width','25%');
            }
            else if(screen4<=1030 && screen4>814){
                if(count==2){width = '49.77%';}
                else if(count==4){width = '23.77%';}
                else if(count==6){width = '15.73%';}
                $('.time_sc').css('width',width);
                $('.i_time').css('width','47%');
                $('.i_doube').css('width','23%');
            }
            else if(screen4<=814){
                if(count==2){width = '49.77%';}
                else if(count==4){width = '23.42%';}
                else if(count==6){width = '15.45%';}
                $('.time_sc').css('width',width);
                $('.i_time').css('width','40%');
                $('.i_doube').css('width','20%');
                $('.time').css('padding','1px');
                $('.f_time').css('padding','5px');
            }
        }

        var show_id = $('#QmddServerTimePriceInfo_f_typeid').val();
        selectFtypeid(show_id,1,<?php echo $model->f_uid; ?>);
    });

    function resolution(count){
        var screen4 = document.documentElement.clientWidth;
        var width = '';
        if(screen4>=1695){
            if(count==2){width = '48.9%';}
            else if(count==3){width = '32.6%';}
            else if(count==4){width = '24.44%';}
            else if(count==5){width = '19.54%';}
            else if(count==6){width = '16.29%';}
            $('.time_sc').css('width',width);
        }
        else if(screen4<=1470 && screen4>1390){
            if(count==2){width = '48.7%';}
            else if(count==3){width = '32.48%';}
            else if(count==4){width = '24.35%';}
            else if(count==5){width = '19.46%';}
            else if(count==6){width = '16.23%';}
            $('.time_sc').css('width',width);
        }
        else if(screen4<=1390 && screen4>1230){
            if(count==2){width = '48.6%';}
            else if(count==3){width = '32.42%';}
            else if(count==4){width = '24.3%';}
            else if(count==5){width = '19.43%';}
            else if(count==6){width = '16.2%';}
            $('.time_sc').css('width',width);
        }
        else if(screen4<=1230 && screen4>1190){
            if(count==2){width = '48.4%';}
            else if(count==3){width = '32.25%';}
            else if(count==4){width = '24.2%';}
            else if(count==5){width = '19.36%';}
            else if(count==6){width = '16.14%';}
            $('.time_sc').css('width',width);
        }
        else if(screen4<=1190 && screen4>1156){
            if(count==2){width = '48.4%';}
            else if(count==3){width = '32.22%';}
            else if(count==4){width = '24.2%';}
            else if(count==5){width = '19.36%';}
            else if(count==6){width = '16.13%';}
            $('.time_sc').css('width',width);
        }
        else if(screen4<=1156 && screen4>1070){
            if(count==2){width = '48.3%';}
            else if(count==3){width = '32.2%';}
            else if(count==4){width = '24.17%';}
            else if(count==5){width = '19.32%';}
            else if(count==6){width = '16.1%';}
            $('.time_sc').css('width',width);
            $('.i_time').css('width','45%');
            $('.i_doube').css('width','25%');
        }
        else if(screen4<=1070 && screen4>1030){
            if(count==2){width = '48.3%';}
            else if(count==3){width = '32.12%';}
            else if(count==4){width = '24.1%';}
            else if(count==5){width = '19.26%';}
            else if(count==6){width = '16.06%';}
            $('.time_sc').css('width',width);
            $('.i_time').css('width','45%');
            $('.i_doube').css('width','25%');
        }
        else if(screen4<=1030 && screen4>814){
            if(count==2){width = '48.1%';}
            else if(count==3){width = '32.06%';}
            else if(count==4){width = '24.05%';}
            else if(count==5){width = '19.23%';}
            else if(count==6){width = '16.04%';}
            $('.time_sc').css('width',width);
            $('.i_time').css('width','47%');
            $('.i_doube').css('width','23%');
        }
        else if(screen4<=814){
            if(count==2){width = '47.6%';}
            else if(count==3){width = '31.68%';}
            else if(count==4){width = '23.76%';}
            else if(count==5){width = '19%';}
            else if(count==6){width = '15.82%';}
            $('.time_sc').css('width',width);
            $('.i_time').css('width','45%');
            $('.i_doube').css('width','20%');
            $('.time').css('padding','1px');
            $('.f_time').css('padding','5px');
        }
    }

    $('.input-text').focus(function(){
        $(this).css({"border-color":"#4D90FE","box-shadow":"0 0 0 #ccc"});
    });
    $('.input-text').blur(function(){
        $(this).css({"border-color":"#d9d9d9","box-shadow":"0 0 0 #ccc"});
    });
    
    $('.i_time').blur(function(){
        var c=$(this);
        var reg = /^(([0-1]?\d)|(2[0-4])):[0-5]?\d\-(([0-1]?\d)|(2[0-4])):[0-5]?\d$/;
        if(!reg.test(c.val()) && c.val()!=''){
            var temp_amount=c.val().replace(reg,'');
            we.msg('minus',"\u683C\u5F0F\u4E3A\uFF1A\u0030\u0038\u003A\u0033\u0030\u002D\u0030\u0039\u003A\u0033\u0030\u0020\u6216\uFF1A\u0038\u003A\u0033\u0030\u002D\u0039\u003A\u0033\u0030","",2000);
            $(this).css({'border-color':'#f00','box-shadow':'0px 0px 3px #f00;'});
            // $(this).val(temp_amount.replace(/[^\d\:\d\-\d\:\d]/g,''));
            $(this).val('');
        }
        else{
            $(this).css({"border-color":"#d9d9d9","box-shadow":"0 0 0 #ccc"});
        }
    });

    $('.i_doube').blur(function(){
        var c=$(this);
        var reg = /^[0-9]+([.]{1}[0-9]{1,2})?$/;
        if(!reg.test(c.val()) && c.val()!=''){
            var temp_amount=c.val().replace(reg,'');
            we.msg('minus',"\u6574\u6570\uFF0C\u4E14\u6700\u591A\u4E24\u4F4D\u5C0F\u6570\u70B9");
            $(this).css({'border-color':'#f00','box-shadow':'0px 0px 3px #f00;'});
            $(this).val(temp_amount.replace(/[^\d\.]/g,''));
        }
        else{
            $(this).css({"border-color":"#d9d9d9","box-shadow":"0 0 0 #ccc"});
        }
    });

    function selectFtypeid(obj,num,id){
        if(num==0){
            var obj = $(obj).val();
        }
        colspan(obj);
        if(obj==1){
            show_select(0,1);
        }
        else if(obj==3){
            show_select(0,0);
        }
        else{
            show_select(1,1);
        }

        var k_html ='<option value>请选择</option>';
        if(obj>0){
            for(j=0;j<user_type.length;j++){
                if(user_type[j]['t_server_type_id']==obj){
                    k_html += '<option value="'+user_type[j]['id']+'" membertype="'+user_type[j]['f_member_type']+'"';
                    k_html += ' fucode="'+user_type[j]['f_ucode']+'" funame="'+user_type[j]['f_uname']+'"';
                    if(id==user_type[j]['id']){
                        k_html += 'selected="selected"';
                    }
                    k_html += ' tcode="'+user_type[j]['t_code']+'" tname="'+user_type[j]['t_name']+'">';
                    k_html += user_type[j]['f_uname']+'</option>';
                }
            }
        }
        $("#QmddServerTimePriceInfo_f_uid").html(k_html);
    }

    function colspan(obj){
        var x = document.getElementsByClassName("col_time");
        for(var i = 0; i < x.length; i++){
            if(obj==1){
                x[i].colSpan=2;
            }
            else if(obj==3){
                x[i].colSpan=3;
            }
            else{
                x[i].colSpan=1;
            }
        }
    }

    function show_select(s1,s2){
        show_select_obj(s1,'.dis_service_class');
        show_select_obj(s2,'.dis_service_grade');
    }

    function show_select_obj(s1,o1){
        if(s1==0){
            $(o1).hide();
        }
        else{
            $(o1).show();
        }
    }

    // var time_id = <?php //echo (empty($time_id)) ? '0' : $time_id; ?>;
    // function selectFuid(obj,num){
    //     var attr = $("#service_time_"+num+"_f_uid option:selected");
    //     var show_id = $(obj).val();
    //     var p_html ='<option value="">请选择</option>';
    //     if(show_id>0){
    //         for(j=0;j<member.length;j++){
    //             if(member[j]['mamber_type']==membertype){
    //                 p_html += '<option value="'+member[j]['f_id']+'"';
    //                 (member[j]['f_id']==time_id) ? p_html += ' selected="selected">' : p_html += '>';
    //                 p_html += member[j]['card_name']+'</option>';
    //             }
    //         }
    //     }
    //     $("#service_time_"+num+"_f_level").html(p_html);
    // }
    
    // onchangeFuid($('#QmddServerTimePriceInfo_f_uid'));
    function onchangeFuid(obj){
        var selected_attr = $("#QmddServerTimePriceInfo_f_uid option:selected");
        $('#QmddServerTimePriceInfo_f_ucode').val(selected_attr.attr('fucode'));
        $('#QmddServerTimePriceInfo_f_uname').val(selected_attr.attr('funame'));
        $('#QmddServerTimePriceInfo_t_code').val(selected_attr.attr('tcode'));
        $('#QmddServerTimePriceInfo_t_name').val(selected_attr.attr('tname'));
        $('#QmddServerTimePriceInfo_project_ids').val(selected_attr.attr('projectids'));
    }

    function timeDelete(op){
        var a=confirm("确定删除吗？");
        if(a==true){
            // $(op).remove();
            $('#'+op).remove();
            $('.'+op).remove();
        }
    };

    var num = <?php echo $num; ?>;
    var service_time = $('#service_time');
    var userAgent = navigator.userAgent; //取得浏览器的userAgent字符串

    function add_service(){
        // var screen = document.documentElement.clientWidth;
        // var wi = '70%';
        // if(screen>=1690){ wi = wi; }
        // else if(screen<=1470 && screen>1390){ wi = '72%'; }
        // else if(screen<=1390 && screen>1230){ wi = '74%'; }
        // else if(screen<=1230 && screen>1190){ wi = '76%'; }
        // else if(screen<=1190 && screen>1156){ wi = '78%'; }
        // else if(screen<=1156 && screen>1070){ wi = '80%'; }
        // else if(screen<=1070 && screen>1030){ wi = '82%'; }
        // else if(screen<=1030 && screen>814){ wi = '84%'; }
        // else if(screen<=814){ wi = '86%'; }
        // console.log(wi);
        if($('#QmddServerTimePriceInfo_f_uid').val()==''){
            we.msg('minus','请先选择服务具体类型');
            return false;
        }
        var priceInfo_f_typeid = $('#QmddServerTimePriceInfo_f_typeid').val();
        var info_attr = $("#QmddServerTimePriceInfo_f_uid option:selected");
        var membertype = info_attr.attr('membertype');
        var funame = info_attr.attr('funame');
        var funame = info_attr.attr('funame');
        var display = '';
        var display1 = '';
        var d = 1;
        if(priceInfo_f_typeid == 1){
            display = 'display:none';
            d = 2;
        }
        if(priceInfo_f_typeid == 3){
            display1 = 'display:none';
            d = 3;
        }
        $.dialog.data('logistics_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/qmddServiceTime");?>&membertype='+membertype,{
            id:'fuwu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'80%',
            height:'80%',
            close: function() {
                if($.dialog.data('id')==-1){
                    var s_html = '';
                    var boxnum=$.dialog.data('title');
                    var add_len=$.dialog.data('add_len');
                    var f_dname={};
                    var f_price={};
                    for(var k=1;k<18;k++){
                        f_dname['f_dname'+k]=$.dialog.data('f_dname'+k);
                        f_price['f_price'+k]=$.dialog.data('f_price'+k);
                    }
                    s_html += 
                        '<tr style="display:inline-grid;float:left;">'+
                            '<td class="dis_service_class" style="'+display+display1+'">类型</td>'+
                            '<td class="dis_service_grade" style="'+display1+'">等级</td>'+
                            '<td>序号</td>';
                            for($b=1;$b<=add_len;$b++){
                                s_html += '<td class="f_time" style="padding:9px;">'+$b+'</td>';
                            }
                    s_html += '</tr>';
                    for(var j=0;j<boxnum.length;j++) {
                        // if($('#time_class_'+boxnum[j].dataset.id).length==0){
                            s_html += '<tr id="time_class_'+boxnum[j].dataset.id+'" class="time_sc" style="text-align:center;display:inline-grid;">'+
                            '<input type="hidden" name="service_time['+num+'][id]" value="null">'+
                            '<input type="hidden" name="service_time['+num+'][f_dcode]" value="'+num+'">'+
                            '<input type="hidden" name="service_time['+num+'][f_level]" value="'+boxnum[j].dataset.id+'">'+
                            '<input type="hidden" name="service_time['+num+'][f_levelname]" value="'+boxnum[j].dataset.title+'">'+
                            '<input type="hidden" name="service_time['+num+'][f_member_type]" value="'+membertype+'">';
                            s_html += '<td id="class_'+num+'" class="dis_service_class" style="'+display+display1+'">'+funame+'</td><td id="grade_'+num+'" class="dis_service_grade" style="'+display1+'">'+boxnum[j].dataset.title+'</td>';
                            s_html += '<td id="mony_'+num+'" class="dis_service_mony" style="display:inline-flex;"><span style="width:60%;">时间段</span><span style="width:40%;text-align:left;margin-left:50px;">金额</span></td>';
                            for(var h=1;h<=add_len;h++){
                                s_html += '<td id="f_dname_'+num+'_'+h+'">'+
                                            '<input type="text" class="input-text i_time" name="service_time['+num+'][f_dname'+h+']" value="'+f_dname['f_dname'+h]+'" style="width:45%;">&nbsp;'+
                                            '<input type="text" class="input-text i_doube" name="service_time['+num+'][f_price'+h+']" value="'+f_price['f_price'+h]+'" style="width:25%;">'+
                                        '</td>';
                            }
                        // }
                        num++;
                    }
                    // service_time.append(s_html);
                    if(s_html!==''){
                        $('#dis_time_table').show();
                        service_time.html(s_html);
                        resolution(boxnum.length);
                    }
                }
            }
        });
    }
</script>