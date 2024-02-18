<?php
    if(isset($model->reasons_adminID)){
        $model->reasons_adminID=='';
    }
    if(empty($model->club_id)){
        $model->club_id=0;
    }
    // if(!empty($model->type_code==174)){
    //     $model->type_code=$model->type_code;
    // }
?>
<style>
    .child_1 td:nth-child(odd){
        width: 15%;
    }
    .child_1 td:nth-child(even){
        width: 35%;
    }
</style>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑服务</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">基本信息</li>
                <!-- <li>详细描述</li>
                <li>服务时间</li> -->
                <!--<li>服务赠品</li>-->
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item child_1">
                <table>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'project_id'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'project_id'); ?>
                            <?php if(!empty($model->project_list))echo $model->project_list->project_name; ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'type_code'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'type_code'); ?>
                            <?php echo $model->type_name; ?>
                        </td>
                    </tr>
                    <?php if($model->type_code==174 || $model->type_code==180){?>
                        <tr id="dis_level_code">
                            <td>场地等级</td>
                            <td><?php if(!empty($model->gf_site))echo $model->gf_site->base_code_site_level->F_NAME; ?></td>
                            <td>场地面积</td>
                            <td><?php if(!empty($model->gf_site))echo $model->gf_site->site_area; ?><span>㎡</span></td>
                        </tr>
                        <tr>
                            <td>场地数量</td>
                            <td colspan="3"><?php  ?></td>
                        </tr>
                    <?php }if($model->type_code==180){?>
                        <tr>
                            <td>裁判等级</td>
                            <td><?php echo (!empty($model->qualifications_person->level_name)) ? $model->qualifications_person->level_name : ''; ?></td>
                            <td>裁判人数</td>
                            <td><?php echo (!empty($model->qualifications_person->level_name)) ? $model->qualifications_person->level_name : ''; ?></td>
                        </tr>
                    <?php }if(($model->type_code==225) || ($model->type_code>174 && $model->type_code<180)){?>
                        <tr>
                            <td>服务者等级</td>
                            <td><?php echo (!empty($model->qualifications_person->level_name)) ? $model->qualifications_person->level_name : ''; ?></td>
                            <td>服务者人数</td>
                            <td><?php echo (!empty($model->qualifications_person->level_name)) ? $model->qualifications_person->level_name : ''; ?></td>
                        </tr>
                    <?php }?>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'area'); ?></td>
                        <td><?php echo $model->area; ?></td>
                        <td><?php echo $form->labelEx($model, 'budget_amount'); ?></td>
                        <td><?php echo $model->budget_amount; ?>元</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'about_club_num'); ?></td>
                        <td><?php echo $model->about_club_num; ?></td>
                        <td><?php echo $form->labelEx($model, 'site_contain'); ?></td>
                        <td><?php echo $model->site_contain; ?></td>
                    </tr>
                    <tr>
                        <td>服务开始时间</td>
                        <td></td>
                        <td>服务结束时间</td>
                        <td></td>
                    </tr>
                </table>
                <div class="mt15 child_1">
                    <table id="clubStore_id" style="table-layout:auto;">
                        <tr class="table-title">
                            <td colspan="4">发起会员信息</td>
                        </tr>
                        <tr>
                            <td>会员帐号</td>
                            <td><?php echo $model->detail_gfaccount; ?></td>
                            <td>会员姓名</td>
                            <td><?php echo $model->detail_gfname; ?></td>
                        </tr>
                        <tr>
                            <td>好评率</td>
                            <td><?php if(!empty($model->detail_gfid))echo $model->userlist->achi_h_ratio; ?></td>
                            <td><?php echo $form->labelEx($model, 'local_and_phone'); ?></td>
                            <td><?php echo $model->local_and_phone; ?></td>
                        </tr>
                    </table>
                </div>
                <?php if($model->state==2) {?>
                <div id="dis_ser" class="mt15 child_1">
                    <table style="table-layout:auto;">
                        <tr class="table-title">
                            <td colspan="4">确认服务</td>
                        </tr>
                        <tr>
                            <td>服务单位</td>
                            <td><?php echo $model->club_name; ?></td>
                            <td>单位星级</td>
                            <td><?php if(!empty($club_project)) echo $club_project->level_name; ?></td>
                        </tr>
                        <tr class="table-title">
                            <td>服务类型</td>
                            <td>编号</td>
                            <td>名称</td>
                            <td>等级</td>
                        </tr>
                        <?php //if(isset($clubStore_id))foreach($clubStore_id as $v){?>
                            <tr>
                                <td><?php echo $model->service_type_name;?></td>
                                <td><?php echo $model->service_code;?></td>
                                <td><?php echo $model->club_name;?></td>
                                <td><?php if(!empty($club_project)) echo $club_project->level_name; ?></td>
                            </tr>
                        <?php //}?>
                    </table>
                </div>
                <?php }?>
            </div><!--box-detail-tab-item end-->
            <!-- <div class="box-detail-tab-item">
                <?php echo $form->hiddenField($model, 'introduceUrl_temp'); ?>
                <script>we.editor('<?php echo get_class($model);?>_introduceUrl_temp', '<?php echo get_class($model);?>[introduceUrl_temp]');</script>
                <?php echo $form->error($model, 'introduceUrl_temp', $htmlOptions = array()); ?>
            </div>
            <div class="box-detail-tab-item">
                <div class="box-msg red">注意：您的有效服务时间范围为：<span id="service_time_range"></span>，且每一行时间段不能重叠</div>
                <table id="timelist" class="showinfo">
                    <tr class="table-title">
                        <th width="15%">服务日期</th>
                        <th width="15%">开始时间</th>
                        <th width="15%">结束时间</th>
                        <th width="25%">服务说明</th>
                        <th width="8%">可售数量</th>
                        <th width="8%">已售数量</th>
                    </tr>
                    <?php if(!empty($timelist)){?>
                    <?php foreach($timelist as $v){?>
                    <tr class="item" data-id="<?php echo $v->id;?>">
                        <td><input onchange="fnUpdateTimelist();" class="service-date input-text" type="text" name="timelist[<?php echo $v->id;?>][service_date]" value="<?php echo $v->service_date;?>" readonly></td>
                        <td><input onchange="fnUpdateTimelist();" class="service-date input-text" type="text" name="timelist[<?php echo $v->id;?>][service_datatime_start]" value="<?php echo $v->service_datatime_start;?>" readonly></td>
                        <td><input onchange="fnUpdateTimelist();" class="service-date input-text" type="text" name="timelist[<?php echo $v->id;?>][service_datatime_end]" value="<?php echo $v->service_datatime_end;?>" readonly></td>
                        <td><input onchange="fnUpdateTimelist();" class="input-text" type="text" name="timelist[<?php echo $v->id;?>][time_declare]" value="<?php echo $v->time_declare;?>" readonly></td>
                        <td><input onchange="fnUpdateTimelist();" class="service-date-num input-text" type="text" name="timelist[<?php echo $v->id;?>][saleable_quantity]" value="<?php echo $v->saleable_quantity;?>" readonly></td>
                        <td><input onchange="fnUpdateTimelist();" class="service-date-num input-text" type="text" name="timelist[<?php echo $v->id;?>][auantity_sold]" value="<?php echo $v->auantity_sold;?>" readonly></td>
                    </tr>
                    <?php }?>
                    <?php }else{?>
                    <tr class="item" data-id="new">
                        <td><input onchange="fnUpdateTimelist();" class="service-date input-text" type="text" name="timelist[new][service_date]" readonly></td>
                        <td><input onchange="fnUpdateTimelist();" class="service-date input-text" type="text" name="timelist[new][service_datatime_start]" readonly></td>
                        <td><input onchange="fnUpdateTimelist();" class="service-date input-text" type="text" name="timelist[new][service_datatime_end]" readonly></td>
                        <td><input onchange="fnUpdateTimelist();" class="input-text" type="text" name="timelist[new][time_declare]" readonly></td>
                        <td><input onchange="fnUpdateTimelist();" class="service-date-num input-text" type="text" name="timelist[new][saleable_quantity]" readonly></td>
                        <td><input onchange="fnUpdateTimelist();" class="service-date-num input-text" type="text" name="timelist[new][auantity_sold]" readonly></td>
                    </tr>
                    <?php }?>
                </table>
            </div> -->
        </div><!--box-detail-bd end-->
        <div class="mt15 child_1">
            <table style="table-layout:auto">
                <tr class="table-title">
                    <td colspan="4">管理员操作</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'reasons_for_failure'); ?></td>
                    <td>
                        <?php echo $form->textArea($model, 'reasons_for_failure',array('class'=>'input-text')); ?>
                        <?php echo $form->error($model, 'reasons_for_failure'); ?>
                    </td>
                    <td>可执行操作</td>
                    <td>
                        <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                        <input onclick="fnClubreply();" class="btn btn-blue" type="button" value="申请服务">
                        <!-- <input id="club_reply" class="btn btn-blue" type="button" value="申请服务"> -->
                    </td>
                </tr>
            </table>
            <table class="showinfo">
                <tr>
                    <th width="20%"><?php echo $form->labelEx($model, 'reasons_time'); ?></th>
                    <th width="20%"><?php echo $form->labelEx($model, 'reasons_adminID'); ?></th>
                    <th width="20%"><?php echo $form->labelEx($model, 'state'); ?></th>
                    <th><?php echo $form->labelEx($model, 'reasons_for_failure'); ?></th>
                </tr>
                <tr>
                    <td><?php echo $model->reasons_time; ?></td>
                    <td><?php echo $model->reasons_adminname; ?></td>
                    <td><?php echo $model->base_code->F_NAME; ?></td>
                    <td><?php echo $model->reasons_for_failure; ?></td>
                </tr>
            </table>
        </div>
        <?php if($model->state==2) { if(!empty($clubStore_id)) {?>
        <div class="mt15">
            <table id="time_list1" style="table-layout:auto">
                <tr class="table-title">
                    <td colspan="7">认领记录</td>
                </tr>
                <tr>
                    <td style="width:14.29%;">约单流水号</td>
                    <td style="width:14.29%;">申请单位</td>
                    <td style="width:14.29%;">申请项目</td>
                    <td style="width:14.29%;">申请时间</td>
                    <td style="width:14.29%;">审核状态</td>
                    <td style="width:14.29%;">服务订单号</td>
                    <td style="width:14.29%;">操作</td>
                </tr>
                <?php $num=0; if(!empty($clubStore_id)) foreach($clubStore_id as $v2){ ?>
                    <tr data-id="<?php echo $num; ?>">
                        <td>
                            <input type="hidden" class="input-text" name="time_list1[<?php echo $num;?>][id]" value="<?php echo $v2->reply_service_datailed_id;?>" />
                            <input type="hidden" class="input-text" name="time_list1[<?php echo $num;?>][order_detail_code]" value="<?php echo $v2->order_detail_code;?>" />
                            <?php echo $v2->order_detail_code;?>
                        </td>
                        <td><input type="hidden" class="input-text" name="time_list1[<?php echo $num;?>][apply_club_id]" value="<?php echo $v2->apply_club_id;?>" /><?php if($v2->club_list!='') echo $v2->club_list->club_name;?></td>
                        <td><input type="hidden" class="input-text" name="time_list1[<?php echo $num;?>][reply_project_id]" value="<?php echo $v2->reply_project_id;?>" /><?php if($v2->project_list!='') echo $v2->project_list->project_name;?></td>
                        <td><input type="hidden" class="input-text" name="time_list1[<?php echo $num;?>][apply_time]" value="<?php echo $v2->apply_time;?>" /><?php if($v2->apply_time!='') echo $v2->apply_time;?></td>
                        <td><input type="hidden" class="input-text" name="time_list1[<?php echo $num;?>][state]" value="<?php echo $v2->state;?>" /><?php if($v2->base_code!='') echo $v2->base_code->F_NAME;?></td>
                        <td><input type="hidden" class="input-text" name="time_list1[<?php echo $num;?>][order_num]" value="<?php echo $v2->order_num;?>" /><?php if($v2->order_num!='') echo $v2->order_num;?></td>
                        <td>
                            <a class="btn" href="javascript:;" onclick="fnLoo(<?php echo $v2->id;?>);">查看</a>
                            <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $num;?>', cancel);">撤销</a>
                        </td>
                    </tr>
                <?php $num++; }?>
            </table>
        </div>
        <?php }}?>
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    var cancel = '<?php echo $this->createUrl('DeleteclubStore', array('id'=>'ID'));?>';

    // 查看
    var fnLoo=function($loo_id){
        $.dialog.open('<?php echo $this->createUrl("loo");?>&loo_id='+$loo_id,{
            id:'look',
            lock:true,
            opacity:0.3,
            title:'查看申请',
            width:'800px',
            height:'40%',
            close: function () {}
        });
    };

    $(function(){
        
        objLimitTime=new Object();
        <?php if(!empty($model->club_service_detailed)){?>
            <?php foreach($model->club_service_detailed as $v){?>
                objLimitTime[<?php echo $v->id;?>]=['<?php echo $v->service_date;?>','<?php echo $v->service_datatime_start;?>','<?php echo $v->service_datatime_end;?>', '1'];
            <?php }?>
        <?php }?>
        we.tab('.box-detail-tab li','.box-detail-tab-item');
    });

    var all_start_date='<?php if(isset($model->qualifications_person) && isset($model->gf_site)){
        if(strtotime($model->qualifications_person->start_date)>strtotime($model->gf_site->site_date_start)){ echo $model->qualifications_person->start_date; }
        else{ echo $model->gf_site->site_date_start; } }
        elseif(isset($model->qualifications_person) && $model->qualifications_person!=null){ echo $model->qualifications_person->start_date; }
        elseif(isset($model->gf_site) && $model->gf_site!=null){ echo $model->gf_site->site_date_start; }?>';
    var all_end_date='<?php if(isset($model->qualifications_person) && isset($model->gf_site)){
        if(strtotime($model->qualifications_person->end_date)>strtotime($model->gf_site->site_date_end)){ echo $model->gf_site->site_date_end; }
        else{ echo $model->qualifications_person->end_date; } }
        elseif(isset($model->qualifications_person) && $model->qualifications_person!=null){ echo $model->qualifications_person->end_date; }
        elseif(isset($model->gf_site) && $model->gf_site!=null){ echo $model->gf_site->site_date_end; }?>';
    var person_start_date='<?php if(isset($model->qualifications_person) && $model->qualifications_person!=null){ echo $model->qualifications_person->start_date; }?>';
    var person_end_date='<?php if(isset($model->qualifications_person) && $model->qualifications_person!=null){ echo $model->qualifications_person->end_date; }?>';
    var place_start_date='<?php if(isset($model->gf_site) && $model->gf_site!=null){ echo $model->gf_site->site_date_start; }?>';
    var place_end_date='<?php if(isset($model->gf_site) && $model->gf_site!=null){ echo $model->gf_site->site_date_end; }?>';
    $('#service_time_range').html('<span class="green">'+all_start_date+'</span>至<span class="green">'+all_end_date+'</span>');
    
    var fnDeleteClub=function(op){
        var a=confirm("确定删除吗？");
        if(a==true){
            $(op).parent().parent().remove();
        }
    };

    // 弹出框内容
    var ClubreplyHtml=
        '<div style="width:900px;height:300px;overflow-y:auto;overflow-x:hidden;">'+
            '<form id="form_reply" name="form_reply">'+
                '<table id="time_list" class="box-detail-table showinfo" style="table-layout:auto;">'+
                    // '<input onclick="fnClubFuwu();" class="btn btn-blue" type="button" value="申请服务">'+
                    '<input onclick="club_reply();" class="btn btn-blue" type="button" value="申请服务">'+
                    '<tr>'+
                        '<th style="width:3%;">序号</th>'+
                        '<th style="width:15%;">约单流水号</th>'+
                        '<th style="width:15%;">申请单位</th>'+
                        '<th style="width:10%;">申请项目</th>'+
                        '<th style="width:15%;">申请时间</th>'+
                        '<th style="width:5%;">操作</th>'+
                    '</tr>'+
                    '<?php $num=1; if(!empty($model->club_service_reply))foreach($model->club_service_reply as $g){ ?>'+
                        '<tr id="club_item_<?php echo $g->id; ?>" >'+
                            '<td style="text-align:center;"><?php echo $num; ?></td>'+
                            '<input type="hidden" class="input-text" name="time_list[<?php echo $num; ?>][id]" value="<?php echo $g->id; ?>">'+
                            '<input type="hidden" class="input-text" name="time_list[<?php echo $num; ?>][code]" value="<?php echo $g->order_detail_code; ?>">'+
                            '<input type="hidden" class="input-text" name="time_list[<?php echo $num; ?>][clubid]" value="<?php echo $g->apply_club_id; ?>">'+
                            '<input type="hidden" class="input-text" name="time_list[<?php echo $num; ?>][clubname]" value="<?php echo $g->club_list->club_name; ?>">'+
                            '<input type="hidden" class="input-text" name="time_list[<?php echo $num; ?>][projectid]" value="<?php echo $g->reply_project_id; ?>">'+
                            // '<input type="hidden" class="input-text" name="time_list[<?php echo $num; ?>][apply_time]" value="<?php echo $g->apply_time; ?>">'+
                            '<td style="text-align:center;"><?php echo $g->order_detail_code; ?></td>'+
                            '<td style="text-align:center;"><?php echo $g->club_list->club_name; ?></td>'+
                            '<td style="text-align:center;"><?php echo $g->project_list->project_name; ?></td>'+
                            '<td style="text-align:center;"><?php echo $g->apply_time; ?></td>'+
                            '<td style="text-align:center;"><a class="btn" href="javascript:;" onclick="fnDeleteClub(this);" title="删除"><i class="fa fa-trash-o"></i></a></td>'+
                        '</tr>'+
                    '<?php $num++; }?>'+
                '</table>'+
            '</form>'+
        '</div>';

    // 弹出框
    var fnClubreply=function(){
        $.dialog({
            id:'fuwu',
            lock:true,
            opacity:0.3,
            title:'申请服务',
            content:ClubreplyHtml,
            button:[
                {
                    name:'确认添加',
                    callback:function(){
                        return fnSaveTimeList();
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
    };
    // 确定并保存服务
    var fnSaveTimeList=function(){
        var form = $('#form_reply').serialize();
        we.loading('show');
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('reply_copy',array('id'=>$model->id));?>',
            data: form,
            dataType: 'json',
            success: function(data) {
                if(data.status==1){
                    we.loading('hide');
                    $.dialog.list['fuwu'].close();
                    we.success(data.msg, data.redirect);
                }else{
                    we.loading('hide');
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    };
    // 申请服务
    $time_list=$('#time_list');
    var project_id=$('#ClubStoreDemand_project_id').val();
    var type_code=$('#ClubStoreDemand_type_code').val();
    // var fnClubFuwu=function(){
    //     var s_html='';
    //     var list_num=num+1;
    //     $.dialog.data('datailed_id', 0);
    //     $.dialog.open('<?php //echo $this->createUrl("select/clubStore");?>&project_id='+project_id+'&type_code='+type_code,{
    //         id:'shenqingfuwu',
    //         lock:true,
    //         opacity:0.3,
    //         title:'选择具体内容',
    //         width:'500px',
    //         height:'60%',
    //         close: function () {
    //             if($.dialog.data('datailed_id')>0){
    //                 datailed_id=$.dialog.data('datailed_id');
    //                 s_html=
    //                     '<tr data-id="'+$.dialog.data('datailed_id')+'">'+
    //                         '<td style="text-align:center;width:15%;"><input id="service_code" type="hidden" class="input-text" name="service_code" value="<?php //echo $model->service_code; ?>" /><?php //echo $model->service_code; ?></td>'+
    //                         '<td style="text-align:center;width:15%;">'+$.dialog.data('club_id')+'</td>'+
    //                         '<td style="text-align:center;width:10%;">'+$.dialog.data('club_project')+'</td>'+
    //                         '<td style="text-align:center;width:15%;"><input type="hidden" id="datailed_id" class="input-text" name="datailed_id" value="'+$.dialog.data('datailed_id')+'" />'+$.dialog.data('club_update')+'</td>'+
    //                         '<td style="text-align:center;width:5%;"><a onclick="fnDeleteClub(this);" href="javascript:;">删除</a></td>'+
    //                     '</tr>';
    //                 $time_list.html(s_html);
    //                 list_num++;
    //             }
    //         }
    //     });
    // };
    // 服务者
    num = <?php echo $num; ?>;
    var club_reply=function(){
        $time_list=$('#time_list');
        $.dialog.data('id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/clubStore");?>&project_id='+project_id+'&type_code='+type_code+'&reply='+1,{
            id:'fuwuzhe',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'800px',
            height:'60%',
            close: function () {
                if($.dialog.data('id')==-1){
                    var boxnum=$.dialog.data('name');
                    for(var j=0;j<boxnum.length;j++) {
                        if($('#club_item_'+boxnum[j].dataset.id).length==0){
                            $time_list.append(
                                '<tr id="club_item_'+boxnum[j].dataset.id+'" style="text-align:center;">'+
                                    '<td style="text-align:center;">'+num+'</td>'+
                                        '<input type="hidden" class="input-text" name="time_list['+num+'][id]" value="null">'+
                                        '<input type="hidden" class="input-text" name="time_list['+num+'][code]" value="'+boxnum[j].dataset.code+'">'+
                                        '<input type="hidden" class="input-text" name="time_list['+num+'][clubid]" value="'+boxnum[j].dataset.clubid+'">'+
                                        '<input type="hidden" class="input-text" name="time_list['+num+'][clubname]" value="'+boxnum[j].dataset.clubname+'">'+
                                        '<input type="hidden" class="input-text" name="time_list['+num+'][projectid]" value="'+boxnum[j].dataset.projectid+'">'+
                                        // '<input type="hidden" class="input-text" name="time_list['+num+'][projectname]" value="'+boxnum[j].dataset.projectname+'">'+
                                    '<td style="text-align:center;">'+boxnum[j].dataset.code+'</td>'+
                                    '<td style="text-align:center;">'+boxnum[j].dataset.clubname+'</td>'+
                                    '<td style="text-align:center;">'+boxnum[j].dataset.projectname+'</td>'+
                                    '<td style="text-align:center;"></td>'+
                                    '<td style="text-align:center;"><a class="btn" href="javascript:;" onclick="fnDeleteClub(this);" title="删除"><i class="fa fa-trash-o"></i></a></td>'+
                                '</tr>'
                            );
                            num++;
                        }
                    }
                }
            }
        });
    };

    var type_id=$('#ClubStoreDemand_type_code').val();
    all_start_date='';
    all_end_date='';
    if(type_id==174){
        all_start_date=place_start_date;
        all_end_date=place_end_date;
    }
    else if(type_id==180){
        // 对比服务者和场地的有效时间，选取综合有效时间
        if(person_start_date!='' && place_start_date!=''){
            if(we.strtotime(person_start_date)>we.strtotime(place_start_date)){
                all_start_date=person_start_date;
            }
            else{
                all_start_date=place_start_date;
            }
        }
        if(person_end_date!='' && place_end_date!=''){
            if(we.strtotime(person_end_date)>we.strtotime(place_end_date)){
                all_end_date=place_end_date;
            }
            else{
                all_end_date=person_end_date;
            }
        }
    }
    else if(type_id==225){
        all_start_date=person_start_date;
        all_end_date=person_end_date;
    }
    if(all_start_date!='' && all_end_date!=''){
        $service_time_range.html('<span class="green">'+all_start_date+'</span>至<span class="green">'+all_end_date+'</span>');
    }
    else{
        $service_time_range.html('');
    };
</script>