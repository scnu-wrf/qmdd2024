<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
            <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table class="detail product_publish_content" border="1" cellspacing="1" cellpadding="0" style="color:#555;margin-bottom:10px;">
                <!--固定部分-->
                <tr>
                    <td style="padding:10px;background:#efefef;" colspan="4" >基本信息</td>
                </tr>
                <tr>
                    <td style="padding:10px;" width="15%"><?php echo $form->labelEx($model, 'type'); ?></td>
                    <td style="padding:10px;" width="35%" id="d_type">
                        <?php echo $form->dropDownList($model, 'type', Chtml::listData(BaseCode::model()->getCode(402), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange' =>'selectOnchang(this)')); ?>
                        <?php echo $form->error($model, 'type', $htmlOptions = array()); ?>
                    </td> 
                    <td style="padding:10px;"><?php echo $form->labelEx($model, 'club_id'); ?></td>
                    <td style="padding:10px;">
                        <span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->club_list->club_name;?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text')); ?></span><?php } else {?><span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value'=>get_session('club_id'))); ?></span><?php } ?></span>
                        <?php echo $form->error($model, 'club_id', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding:10px;" width="15%"><?php echo $form->labelEx($model, 'zsxm'); ?></td>
                    <td style="padding:10px;" width="35%" id="d_zsxm">
                        <?php echo $form->textField($model, 'zsxm', array('class' => 'input-text',)); ?>
                        <?php echo $form->error($model, 'zsxm', $htmlOptions = array()); ?>
                    </td>
                    <td style="padding:10px;" width="15%"><?php echo $form->labelEx($model, 'club_name'); ?></td>
                    <td style="padding:10px;" width="35%" id="d_club_name">
                        <?php echo $form->textField($model, 'club_name', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'club_name', $htmlOptions = array()); ?>
                    </td> 
                </tr>
                <tr>
                    <td style="padding:10px;" width="15%"><?php echo $form->labelEx($model, 'id_card'); ?></td>
                    <td style="padding:10px;" width="35%" id="d_id_card">
                        <?php echo $form->textField($model, 'id_card', array('class' => 'input-text',)); ?>
                        <?php echo $form->error($model, 'id_card', $htmlOptions = array()); ?>
                    </td>
                    <td style="padding:10px;"><?php echo $form->labelEx($model, 'apply_time'); ?></td>
                    <td style="padding:10px;" id="d_apply_time">
                    <?php echo $model->apply_time; ?></td>
                    </td> 
                </tr>
                <tr>
                    <td style="padding:10px;" class="detail-hd"><?php echo $form->labelEx($model, 'project_id'); ?>：</td>
                    <td style="padding:10px;" >
                        <?php echo $form->hiddenField($model, 'project_id', array('class' => 'input-text')); ?>
                        <span id="project_box">
                           <?php if($model->project_list!=null){?><span class="label-box"><?php echo $model->project_list->project_name;?></span><?php }else{?>
                            <?php ?><span class="label-box" style="display:inline-block;width:20px;"></span><?php }?>
                        </span>
                        <input id="project_select_btn" class="btn" type="button" value="选择">
                        <?php echo $form->error($model, 'project_id', $htmlOptions = array()); ?>
                    </td>
                    <td style="padding:10px;" width="15%"><?php echo $form->labelEx($model, 'club_address'); ?></td>
                    <td style="padding:10px;" width="35%" id="d_club_address">
                        <?php echo $form->textField($model, 'club_address', array('class' => 'input-text',)); ?>
                        <?php echo $form->error($model, 'club_address', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
            <!--非固定信息-->
            <table border="1" cellspacing="1" cellpadding="0" class="detail product_publish_content"  style="color:#555;margin-bottom:10px;display:" id="show_person">
                <tr>
                    <td style="padding:10px;background:#efefef;" colspan="3" style="">入会信息&nbsp;&nbsp;<input id="setlist_select_btn" class="btn" type="button" value="生成入会信息"></td>
                </tr>                
                <tr>
                    <th style='text-align: center;background:#efefef;'>属性名称</th>
                    <th style='text-align: center;background:#efefef;'>属性单位</th>
                    <th style='text-align: center;background:#efefef;'>属性值</th>
                </tr>
                <tbody id="club_inputset">
                    <?php if(!empty($model->club_id)&&!empty($model->project_id)&&!empty($model->type)){
                            $model->id=empty($model->id) ? 0 : $model->id;
                            $memberset = GfPartnerMemberSet::model()->find('club_id = '.$model->club_id.' AND project_id ='.$model->project_id.' AND type='.$model->type);
                            $inputset = GfPartnerMemberInputset::model()->findAll('set_id ='.$memberset->id);
                            $content = GfPartnerMemberContent::model()->findAll('apply_id ='.$model->id);
                            $qmdownlist = QmddDropDownList::model()->find();
                    }?>
                    <?php 
                        $index=0;
                        if(!empty($inputset)){
                            foreach($inputset as $v){
                                $vl="";$index=$index+1;
                                foreach($content as $v1){
                                    if($v->id==$v1->attr_id){
                                        $vl=$v1->attr_content;
                                    }
                                }
                            $fn='field_'.$index;
                            $qmdownlist['row_'.$index]=$v->id;
                            $qmdownlist[$fn]=$v->id;
                    ?>
                    <?php echo $form->hiddenField($qmdownlist,'row_'.$index, array('class' => 'input-text',)); ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $v->attr_name; ?></td>
                            <td style="text-align: center;"><?php echo $v->attr_unit; ?></td>
                            <?php if($v->attr_input_type==677){?>
                                <td style="text-align: center;">
                                    <?php echo $form->textField($qmdownlist, $fn, array('class' => 'input-text',)); ?>
                                </td>
                            <?php }else if($v->attr_input_type==678){?>
                            <td style="padding:10px;"  id="rv_<?php echo $index; ?>">
                                <?php
                                    $v->attr_values=$vl;
                                    echo $form->dropDownList($qmdownlist, $fn, Chtml::listData(GfPartnerMemberValues::model()->findAll('set_id='.$v->id), 'id', 'attr_values'), array('prompt'=>'请选择'));
                                ?>
                            </td><!--下拉-->
                            <?php }else if($v->attr_input_type==681){?>
                                <td style='text-align: center;'><?php echo $form->textArea($qmdownlist, $fn, array('class' => 'input-text'));  ?></td>
                            <?php }else if($v->attr_input_type==683){?>
                                <td style='text-align: center;'></td>
                            <?php }else if(($v->attr_input_type==682)||($v->attr_input_type==720)){?>
                                <td style="padding:10px;"  id="rv_<?php echo $v->attr_combo_id; ?>">
                                    <?php echo $form->dropDownList($qmdownlist, $fn, Chtml::listData(GfPartnerMemberValues::model()->findAll('set_id='.$v->id), 'id', 'attr_values'), array('prompt'=>'请选择')); ?>
                                </td><!--下拉-->
                            <?php }?>
                        </tr>
                    <?php }}?>  
                    <input type="hidden" name="row_num" value="<?php echo $index;?>">
                </tbody>
            </table>
            <table border="1" cellspacing="1" cellpadding="0" class="detail product_publish_content"  style="color:#555;margin-bottom:10px;">
                <tr>
                    <td colspan="4" style="background:#efefef;padding:10px;">会员信息</td>
                </tr>
                <tr>
                    <td width="15%" style="padding:10px;" ><?php echo $form->labelEx($model, 'code'); ?></td>
                    <td width="35%" style="padding:10px;" id="d_state_certificate_code"><?php echo $model->code;?></td>
                    <td width="15%" style="padding:10px;" ><?php echo $form->labelEx($model, 'member_type_name'); ?></td>
                    <td width="35%" id="dcom_member_type_name">
                        <?php echo $form->textField($model, 'member_type_name', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'member_type_name', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding:10px;"><?php echo $form->labelEx($model, 'effective_start_time'); ?></td>
                    <td style="padding:10px;"  id="d_effective_start_time">
                        <?php echo $model->effective_start_time; ?>
                    </td>
                    <td style="padding:10px;"><?php echo $form->labelEx($model, 'effective_end_time'); ?></td>
                    <td style="padding:10px;"  id="d_effective_end_time">
                        <?php echo $model->effective_end_time; ?>
                    </td>
                </tr>
            </table>
            <table border="1" cellspacing="1" cellpadding="0"  class="detail product_publish_content" style="color:#555;margin-bottom:10px;"><!--提交成功后，管理人员类型登录显示-->
                <tr>
                    <td style="padding:10px;background:#efefef;" colspan="4" >管理员操作</td>
                </tr>
                <tr>
                    <td style="padding:10px;" width="15%"><?php echo $form->labelEx($model, 'auth_state'); ?></td>
                    <td style="padding:10px;" width="35%">
                        <?php echo $model->auth_state_name;?>
                    </td>
                    <td style="padding:10px;" width="15%"><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                    <td style="padding:10px;" width="35%">
                        <?php echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding:10px;text-align:center;margin-top:10px;" id="check_state" colspan="4" align="center">
                        <?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));?> 
                        <!--button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
                        <button onclick="submitType='shenhe'" class="btn btn-blue" type="submit">提交审核</button>
                        <button onclick="submitType='tongguo'" class="btn btn-blue" type="submit">审核通过</button>
                        <button onclick="submitType='butongguo'" class="btn btn-blue" type="submit">审核不通过</button-->
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
                <tr>
                    <td style="padding:10px;" colspan="4" style="background:#fafafa;">操作记录</td>
                </tr>
                <tr>   
                    <td style="padding:10px;" width="20%">操作时间</td>          
                    <td style="padding:10px;" width="20%">操作人</td>
                    <td style="padding:10px;" width="20%">操作事项</td>
                    <td style="padding:10px;">备注</td> 
                </tr>
                <tr>             
                    <td id="d_state_time"></td>
                    <td id="d_reviewer_gfid"></td>
                    <td id="d_state"></td>
                    <td id="d_reasons_failure"></td> 
                </tr>
            </table>
            <?php $this->endWidget(); ?>
        </div><!--box-table end-->
    </div><!--box-content end-->
</div><!--box end-->
<script>
    we.tab('.box-detail-tab li','.box-detail-tab-item');

    var club_id=0;
    var project_id=0;
    $(function(){
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
                        $project_box.html('<span class="label-box">'+$.dialog.data('project_title')+'</span>');
                    }
                }
            });
        });

        $('#GfPartnerMemberApply_effective_start_time').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});
        });
        $('#GfPartnerMemberApply_effective_end_time').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});
        });
        
        // 选择单位
        var $club_box=$('#club_box');
        var $GfPartnerMemberApply_club_id=$('#GfPartnerMemberApply_club_id');
        $('#club_select_btn').on('click', function(){
            $.dialog.data('club_id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/club", array('club_type'=>189));?>',{
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
                        $GfPartnerMemberApply_club_id.val($.dialog.data('club_id')).trigger('blur');
                        $club_box.html('<span class="label-box">'+$.dialog.data('club_title')+'</span>');
                    }
                }
            });
        });
    });

    $('#setlist_select_btn').on('click', function(){
        var $club_inputset=$('#club_inputset');
        var type=$('#GfPartnerMemberApply_type').val();
        var club_id=$('#GfPartnerMemberApply_club_id').val();
        var project_id=$('#GfPartnerMemberApply_project_id').val();
        var s2='<?php echo $this->createUrl("GFPartnerMemberApply/getMemberInputset");?>';
        
        $.ajax({
            type: 'get',
            url: s2,
            data: {type:type,club_id:club_id,project_id:project_id},
            dataType:'json',
            success: function(data) {
                if(typeof(data)!=="undefined"){
                    var obj_len=data.length;  //alert(news_contentObj["datas"].length);
                    var i1 = 0;
                    var p_html = '';
                    while (i1 <obj_len) {//alert(train_pid_array[i]);
                        p_html = p_html +'<tr><td>'+data[i1]['attr_name']+'</td>';
                        p_html = p_html +'</tr>';
                        i1++;
                    }
                    $("#club_inputset").html( p_html);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    });
</script>