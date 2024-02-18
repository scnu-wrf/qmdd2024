<?php
    // $s1="f_id,card_code,type,typename,mamber_type,mamber_type_name,card_name,card_xh,short_name,up_type,up_type_name,job_partner_num,card_level,charge";
    // $s2=MemberCard::model()->findAll('mamber_type is not null and mamber_type not in(1157,1158) order by mamber_type_name DESC,card_code');
    // $member=toArray($s2,$s1);
    $s1="id,type,member_type_id,member_type_code,member_type_name,member_second_id,member_second_code,member_second_name,entry_way,entry_way_name,card_name,card_xh,card_level,card_score,card_end_score,certificate_type";
    $s2=ServicerLevel::model()->findAll('if_del=510');
    $member=toArray($s2,$s1);
    $fee=ClubMembershipFee::model()->findAll();
?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table">详细</i></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <div class="box-detail-bd">
                <table style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="8">基本信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'name'); ?></td>
                        <td>
                            <?php echo $form->textField($model,'name',array('class'=>'input-text')); ?>
                            <?php echo $form->error($model,'name',$htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model,'fee_day_id'); ?></td>
                        <td colspan="3"><?php echo $form->radioButtonList($model,'fee_day_id',Chtml::listData(ClubFeeDay::model()->findAll(),'id','f_name'),$htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'feeid'); ?></td>
                        <td>
                            <?php //echo $form->dropDownList($model,'fee_name',Chtml::listData(ClubMembershipFee::model()->findAll(),'id','name'),array('prompt'=>'请选择')); ?>
                            <?php echo $form->hiddenField($model,'fee_name'); ?>
                            <?php echo $form->hiddenField($model,'fee_code'); ?>
                            <?php echo $form->hiddenField($model,'product_id'); ?>
                            <?php echo $form->hiddenField($model,'product_code'); ?>
                            <?php echo $form->hiddenField($model,'product_name'); ?>
                            <select name="ClubMembershipFeeScaleInfo[feeid]" id="ClubMembershipFeeScaleInfo_feeid" onchange="salename(this);">
                                <option value>请选择</option>
                                <?php if(!empty($fee))foreach($fee as $s) {?>
                                    <option value="<?php echo $s->id; ?>" code="<?php echo $s->code; ?>" feename="<?php echo $s->name; ?>" productid="<?php echo $s->product_id; ?>" productcode="<?php echo $s->product_code; ?>" productname="<?php echo $s->product_name; ?>" <?php if($model->feeid==$s->id){ echo 'selected=selected'; } ?>><?php echo $s->name; ?></option>
                                <?php }?>
                            </select>
                        </td>
                        <td><?php echo $form->labelEx($model, 'is_project_scale'); ?></td>
                        <td><?php echo $form->radioButtonList($model,'is_project_scale',Chtml::listData(BaseCode::model()->getCode(647),'f_id','F_NAME'),$htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')) ?></td>
                        <td><?php echo $form->labelEx($model,'club_id'); ?></td>
                        <td>
                            <span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value'=>get_session('club_id'))); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'expiry_date_start'); ?></td>
                        <td><?php echo $form->textField($model, 'expiry_date_start', array('class'=>'input-text')); ?></td>
                        <td><?php echo $form->labelEx($model, 'expiry_date_end'); ?></td>
                        <td colspan="3"><?php echo $form->textField($model, 'expiry_date_end', array('class'=>'input-text')); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'levetypeid') ?></td>
                        <td colspan="7">
                            <?php echo $form->dropDownList($model,'levetypeid',Chtml::listData(ClubType::model()->findAll('length(f_ctcode)=3 order by f_ctcode'),'id','f_ctname'),array('prompt'=>'请选择','onchange' => 'selectlevet(this);')); ?>, 
                            <?php echo $form->error($model, 'member_type_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <table id="scale_info" class="mt15" style="table-layout:auto;">
                    <?php
                        $num=0;
                        $re=0;
                        $model->id=empty($model->id) ? 0 : $model->id;
                        $fee_data=ClubMembershipFeeData::model()->findAll('scale_info_id='.$model->id);
                        if(!empty($fee_data)){
                            echo '<tr class="table-title"><td colspan="9">收费明细</td></tr><tr style="text-align:center;font-weight:bold;">';
                            echo '<td>会员类型(一级)</td><td>会员类型(二级)</td><td>入驻方式</td><td>会员等级</td><td>收费金额(元)</td>';
                            echo '</tr>';
                            foreach($fee_data as $f){
                                $mamber_type = ServicerLevel::model()->findAll('id='.$f->levelid);
                                foreach($mamber_type as $t){
                                    if($t->member_type_id==$f->levetypeid){
                                        echo '<tr>
                                        <input type="hidden" name="scale_info['.$num.'][id_null]" value="'.$f->id.'">
                                        <input type="hidden" name="scale_info['.$num.'][levelid]" value="'.$f->levelid.'">
                                        <input type="hidden" name="scale_info['.$num.'][card_name]" value="'.$f->levelname.'">
                                        <input type="hidden" name="scale_info['.$num.'][member_type]" value="'.$f->member_type.'">
                                        <input class="entry_way" type="hidden" name="scale_info['.$num.'][entry_way]" value="'.$f->entry_way.'">
                                        <td>'.$f->levetypename.'</td>
                                        <td>'.$f->member_name.'</td>
                                        <td>'.$f->entry_way_name.'';
                                        if($t->type==1){
                                            if($f->entry_way==453){
                                                echo '(普通)';
                                            }else if($f->entry_way==454){
                                                echo '(VIP)';
                                            }
                                        }
                                        echo '</td>
                                        <td>'.$f->levelname.'</td>
                                        <td><input class="input-text mony" type="text" name="scale_info['.$num.'][scale_amount]" value="'.$f->scale_amount.'" style="width:72%;"></td>
                                        </tr>';
                                        $num=$num+1;
                                    }
                                }
                            }
                        }
                    ?>
                </table>
                <table class="mt15">
                    <tr>
                        <td width="10%;">操作</td>
                        <td colspan="5"><?php echo show_shenhe_box(array('baocun'=>'保存')); ?></td>
                    </tr>
                </table>
            </div>
        <?php $this->endWidget();?>
    </div>
</div>
<script>

    $('#ClubMembershipFeeScaleInfo_date_start').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'ClubMembershipFeeScaleInfo_date_end\')}'});
    });
    $('#ClubMembershipFeeScaleInfo_date_end').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:"yyyy-MM-dd HH:mm:ss",minDate:"#F{$dp.$D(\'ClubMembershipFeeScaleInfo_date_start\')}"});
    });
    $('#ClubMembershipFeeScaleInfo_date_start_scale').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'ClubMembershipFeeScaleInfo_date_end_scale\')}'});
    });
    $('#ClubMembershipFeeScaleInfo_date_end_scale').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:"yyyy-MM-dd HH:mm:ss",minDate:"#F{$dp.$D(\'ClubMembershipFeeScaleInfo_date_start_scale\')}"});
    });
    var end_input=$dp.$('ClubMembershipFeeScaleInfo_expiry_date_end');
    $('#ClubMembershipFeeScaleInfo_expiry_date_start').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'ClubMembershipFeeScaleInfo_expiry_date_end\')}'});
    });
    $('#ClubMembershipFeeScaleInfo_expiry_date_end').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:"yyyy-MM-dd",minDate:"#F{$dp.$D(\'ClubMembershipFeeScaleInfo_expiry_date_start\')}"});
    });

    $('.mony').focus(function(){
        $(this).css({"border-color":"#4D90FE","box-shadow":"0 0 0 #ccc"});
    });
    
    $('.mony').blur(function(){
        var c=$(this);
        // var reg = /^[0-9]*\.?[0-9]+$/;
        var reg = /^[0-9]+([.]{1}[0-9]{1,2})?$/;
        if(!reg.test(c.val())){
            var temp_amount=c.val().replace(reg,'');
            we.msg('minus',"\u6574\u6570\uFF0C\u4E14\u6700\u591A\u4E24\u4F4D\u5C0F\u6570\u70B9");
            $(this).css({'border-color':'#f00','box-shadow':'0px 0px 3px #f00;'});
            $(this).val(temp_amount.replace(/[^\d\.]/g,''));
        }else{
            $(this).css({"border-color":"#d9d9d9","box-shadow":"0 0 0 #ccc"});
        }
        
        var entry_way=$(this).parents('tr').find(".entry_way").val();
        if(entry_way==453){
            if($(this).val()>0){
                $(this).val('0.00');
                we.msg('minus',"该类型入驻方式为免费");
            }
        }
    });

    function salename(obj){
        var attr = $('#ClubMembershipFeeScaleInfo_feeid option:selected');
        var code = attr.attr('code');
        var name = attr.attr('feename');
        var productid = attr.attr('productid');
        var productcode = attr.attr('productcode');
        var productname = attr.attr('productname');
        $('#ClubMembershipFeeScaleInfo_fee_name').val(name);
        $('#ClubMembershipFeeScaleInfo_fee_code').val(code);
        $('#ClubMembershipFeeScaleInfo_product_id').val(productid);
        $('#ClubMembershipFeeScaleInfo_product_code').val(productcode);
        $('#ClubMembershipFeeScaleInfo_product_name').val(productname);
    }

    //单位类型二级联动下拉菜单
    changeType($('#ClubMembershipFeeScaleInfo_levetypeid'));
    function changeType(obj) {
        var show_id = $(obj).val();
        var p_html = '<option value="">请选择</option>';
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('getType'); ?>',
            data: {id: show_id},
            dataType: 'json',
            success: function(data) {
            for (var i = 0; i < data.length; i++) {
                p_html += '<option  value="' + data[i]['id'] + '"';
                if (data[i]['id'] == "<?php echo $model->lowerleveltypeid; ?>") {
                p_html += 'selected';
                }
                p_html += '>' + data[i]['f_ctname'] + '</option>';
            }
            $("#clind_type").html(p_html);
            }
        });
    }
    var member=<?php echo json_encode($member); ?>;
    function selectlevet(obj){
        console.log(member)
        var obj = $(obj).val();
        var g_html='<tr class="table-title"><td colspan="9">收费明细</td></tr><tr style="text-align:center;font-weight:bold;">';
        g_html += '<td>会员类型(一级)</td><td>会员类型(二级)</td><td>入驻方式</td><td>会员等级</td><td>收费金额(元)</td>';
        g_html += '</tr>';
        var num=0;
        $.each(member,function(k,info){
            if(info.member_type_id==obj){
                console.log(info)
                g_html += '<tr>';
                g_html += '<input type="hidden" name="scale_info['+num+'][levelid]" value="'+info.id+'">';
                g_html += '<input type="hidden" name="scale_info['+num+'][card_name]" value="'+info.card_name+'">';
                g_html += '<input type="hidden" name="scale_info['+num+'][id_null]" value="null">';
                g_html += '<input type="hidden" name="scale_info['+num+'][member_type]" value="'+info.member_second_id+'">';
                g_html += '<input class="entry_way" type="hidden" name="scale_info['+num+'][entry_way]" value="'+info.entry_way+'">';
                g_html += '<td>'+info.member_type_name+'</td><td>'+info.member_second_name+'</td><td>'+info.entry_way_name+'';
                if(info.type=='1'){
                    if(info.entry_way==453){
                        g_html += '(普通)';
                    }else if(info.entry_way==454){
                        g_html += '(VIP)';
                    }
                }
                g_html += '</td><td>'+info.card_name+'</td>';
                g_html += '<td><input class="input-text mony" type="text" name="scale_info['+num+'][scale_amount]" value="0" style="width:72%;"></td>';
                g_html += '</tr>';
                num=num+1;
            }
        })
        $('#scale_info').html(g_html);
    }

    var fnDeleteClub=function(op){
        $(op).parent().remove();
        $('#ClubMembershipFeeScaleInfo_club_id').val('');
        $('#ClubMembershipFeeScaleInfo_club_name').val('');
        $('#ClubMembershipFeeScaleInfo_gf_id').val('');
        $('#ClubMembershipFeeScaleInfo_gf_name').val('');
    };

    function club_select_btn(){
        var fee_type = $('#ClubMembershipFeeScaleInfo_fee_type').val();
        type_club();
        // if(fee_type==403){
        //     type_list();
        // }
        // else{
        //     type_club();
        // }
    }
    var $club_box=$('#club_box');

    // 选择个人
    // function type_list(){
    //     $.dialog.data('id', 0);
    //     $.dialog.open('<?php //echo $this->createUrl("select/clubmemberlist");?>',{
    //         id:'geren',
    //         lock:true,
    //         opacity:0.3,
    //         title:'选择具体内容',
    //         width:'500px',
    //         height:'60%',
    //         close: function () {
    //             if($.dialog.data('id')>0){
    //                 club_id=$.dialog.data('id');
    //                 $('#ClubMembershipFeeScaleInfo_club_id').val($.dialog.data('club_id'));
    //                 $('#ClubMembershipFeeScaleInfo_club_name').val($.dialog.data('club_name'));
    //                 $('#ClubMembershipFeeScaleInfo_gf_id').val($.dialog.data('gf_account'));
    //                 $('#ClubMembershipFeeScaleInfo_gf_name').val($.dialog.data('zsxm'));
    //                 $club_box.html('<span class="label-box">'+$.dialog.data('club_name')+'<i onclick="fnDeleteClub(this);"></i></span>');
    //             }
    //         }
    //     });
    // };
    
    // 选择单位
    function type_club(){
        $.dialog.data('club_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/club");?>',{
            id:'danwei',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('club_id')>0){
                    club_id=$.dialog.data('club_id');
                    $('#ClubMembershipFeeScaleInfo_club_id').val($.dialog.data('club_id'));
                    $('#ClubMembershipFeeScaleInfo_club_name').val($.dialog.data('club_title'));
                    $club_box.html('<span class="label-box">'+$.dialog.data('club_title')+'<i onclick="fnDeleteClub(this);"></i></span>');
                }
            }
        });
    };
</script>