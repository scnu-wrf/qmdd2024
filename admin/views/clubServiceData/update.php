<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑服务</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">基本信息</li>
                <li>详细描述</li>
                <li>服务时间</li>
                <li>服务赠品</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'title'); ?></td>
                        <td width="35%">
                            <?php echo $form->textField($model, 'title', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'title', $htmlOptions = array()); ?>
                        </td>
                        <td width="15%"><?php echo $form->labelEx($model, 'club_id'); ?></td>
                        <td width="35%">
                            <span id="club_box"><?php if($model->club_id!=null){?><span class="label-box"><?php echo $model->club_name;?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text')); ?></span><?php } else {?><span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value'=>get_session('club_id'))); ?></span><?php } ?></span>
                            <?php echo $form->error($model, 'club_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'project_id'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'project_id', array('class' => 'input-text')); ?>
                            <span id="project_box"><?php if(!empty($model->project_id)){?><span class="label-box"><?php echo $model->project_name;?></span><?php }?></span>
                            <input id="project_add_btn" class="btn" type="button" value="选择">
                            <?php echo $form->error($model, 'project_id', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'site_contain'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'site_contain', array('class' => 'input-text', 'style'=>'width:40px;')); ?>
                            <span class="msg">人</span>
                            <?php echo $form->error($model, 'site_contain', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'type_code'); ?></td>
                        <td width="35%">
                            <?php echo $form->dropDownList($model, 'type_code', Chtml::listData(MallProductsTypeSname::model()->getCode(173), 'id', 'sn_name'), array('prompt'=>'请选择','onchange'=>'selecttype(this);')); ?>
                            <?php echo $form->error($model, 'type_code', $htmlOptions = array()); ?>
                        </td>
                        <td width="15%"><?php echo $form->labelEx($model, 'data_id'); ?></td>
                        <td width="35%">
                            <?php echo $form->hiddenField($model, 'type_code_person'); ?>
                            <?php echo $form->hiddenField($model, 'data_id'); ?>
                            <span style="margin-right:10px;<?php if($model->type_code==174){?> display:none;<?php }?>" id="service_person_main">
                                <span id="service_person_box"><span class="label-box"><?php if($model->type_code==180 || $model->type_code==225){?><?php if(!empty($person)) echo $person->qualification_name;?>-<?php if(!empty($person)) echo $person->project_name;?>-<?php if(!empty($person)) echo $person->qualification_type;?><?php }else{ ?>请选择服务者<?php } ?></span></span>
                                <input id="service_person_btn" class="btn" type="button" value="选择">
                            </span>
                            <span style="margin-right:10px;<?php if($model->type_code==225){?> display:none;<?php }?>" id="service_place_main">
                                <span id="service_place_box"><span class="label-box"><?php if($model->type_code==180 || $model->type_code==174){ if(!empty($place)) echo $place->site_name; }else{ ?>请选择场地<?php } ?></span></span>
                                <input id="service_place_btn" class="btn" type="button" value="选择">
                            </span>
                            <?php echo $form->error($model, 'data_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'imgUrl'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'imgUrl', array('class' => 'input-text')); ?>
                            <?php $basepath=BasePath::model()->getPath(135);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->imgUrl!=''){?><div class="upload_img fl" id="upload_pic_ClubServiceData_imgUrl">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->imgUrl;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$model->imgUrl;?>" width="100">
                                </a>
                            </div>
                            <?php } ?>
                            <input style="margin-left:5px;" id="picture_select_btn" class="btn" type="button" value="图库选择" >
                            <script>we.uploadpic('<?php echo get_class($model);?>_imgUrl','<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'imgUrl', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'service_pic_img'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'service_pic_img', array('class' => 'input-text')); ?>
                            <?php $basepath=BasePath::model()->getPath(226);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->service_pic_img!=''){?> 
                                <div class="upload_img fl" id="upload_pic_ClubServiceData_service_pic_img">
                                    <?php 
                                    if(!empty($service_pic_img)) foreach($service_pic_img as $v) if($v) {?>
                                    <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px;"><i onclick="$(this).parent().remove();fnUpdateScrollpic();return false;"></i></a>
                                    <?php }?>
                                </div>
                            <?php } ?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_service_pic_img','<?php echo $picprefix;?>','','',function(e1,e2){fnScrollpic(e1.savename,e1.allpath);},5);</script>
                            <span class="msg">注：图片格式1080*1080;文件大小≤2M；数量≤5张 </span>
                            <?php echo $form->error($model, 'service_pic_img', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'area'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'area', array('class' => 'input-text')); ?>
                            <?php echo $form->hiddenField($model, 'longitude'); ?>
                            <?php echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'area', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'local_and_phone'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'local_and_phone', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'local_and_phone', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
            <div class="box-detail-tab-item">
                <?php echo $form->hiddenField($model, 'introduceUrl_temp', array('class' => 'input-text')); ?>
                <script>we.editor('<?php echo get_class($model);?>_introduceUrl_temp', '<?php echo get_class($model);?>[introduceUrl_temp]');</script>
                <?php echo $form->error($model, 'introduceUrl_temp', $htmlOptions = array()); ?>
            </div><!--box-detail-tab-item end-->
            <div class="box-detail-tab-item">
                <div class="box-msg red">注意：您的有效服务时间范围为：<span id="service_time_range"></span>，且每一行时间段不能重叠</div>
                <table id="timelist" class="showinfo" data-num="new">
                    <tr>
                        <th width="15%">服务日期</th>
                        <th width="15%">开始时间</th>
                        <th width="15%">结束时间</th>
                        <th width="30%">服务说明</th>
                        <th>数量</th>
                        <th>操作</th>
                    </tr>
                    <?php if(empty($model->club_service_detailed)){?>
                    <tr class="item" data-id="new">
                        <td><input style="width:80%;" class="service-date input-text" type="text" name="timelist[new][service_date]" value="" onclick="fnSetDate(this);" readonly></td>
                        <td><input style="width:80%;" class="service-date input-text" type="text" name="timelist[new][service_datatime_start]" value="" onclick="fnSetTime(this);" readonly></td>
                        <td><input style="width:80%;" class="service-date input-text" type="text" name="timelist[new][service_datatime_end]" value="" onclick="fnSetTime(this);" readonly></td>
                        <td><input style="width:80%;" class="input-text" type="text" name="timelist[new][time_declare]" value=""></td>
                        <td><input style="width:80%;" class="service-date-num input-text" type="text" name="timelist[new][num]" value=""></td>
                        <input class="input-text" type="hidden" name="timelist[new][id]" value="null">
                        <input class="input-text if_del" type="hidden" name="timelist[new][if_del]" value="510">
                        <td style="text-align:left;"><input onclick="fnAddServiceDate();" class="btn" type="button" value="添加行"></td>
                    </tr>
                    <?php }else{?>
                        <?php foreach($model->club_service_detailed as $v){?>
                            <tr class="item <?php if ($v->if_del==509) { ?>itemoff<?php } ?>" data-id="<?php echo $v->id;?>">
                                <td><input style="width:80%;" class="service-date input-text" type="text" name="timelist[<?php echo $v->id;?>][service_date]" value="<?php echo $v->service_date;?>" onclick="fnSetDate(this);" readonly></td>
                                <td><input style="width:80%;" class="service-date input-text" type="text" name="timelist[<?php echo $v->id;?>][service_datatime_start]" value="<?php echo $v->service_datatime_start;?>" onclick="fnSetTime(this);" readonly></td>
                                <td><input style="width:80%;" class="service-date input-text" type="text" name="timelist[<?php echo $v->id;?>][service_datatime_end]" value="<?php echo $v->service_datatime_end;?>" onclick="fnSetTime(this);" readonly></td>
                                <td><input style="width:80%;" class="input-text" type="text" name="timelist[<?php echo $v->id;?>][time_declare]" value="<?php echo $v->time_declare;?>"></td>
                                <td><input style="width:80%;" class="service-date-num input-text" type="text" name="timelist[<?php echo $v->id;?>][num]" value="<?php echo $v->saleable_quantity;?>"></td>
                                <input class="input-text" type="hidden" name="timelist[<?php echo $v->id;?>][id]" value="<?php echo $v->id;?>">
                                <input class="input-text if_del" type="hidden" name="timelist[<?php echo $v->id;?>][if_del]" value="<?php echo $v->if_del;?>">
                                <td style="text-align:left;"><input onclick="fnAddServiceDate();" class="btn" type="button" value="添加行"><input style="margin-left:10px;" onclick="fnOffServiceDate(this, <?php echo $v->id;?>);" class="btn" type="button" value="<?php if ($v->if_del==509) { ?>已下架<?php } else { ?>下架<?php } ?>"><input type="hidden" name="timeoff[]" value=""></td>
                            </tr>
                        <?php }?>
                    <?php }?>
                </table>
            </div><!--box-detail-tab-item end-->
            <div class="box-detail-tab-item">
                <table id="giftlist" class="showinfo">
                    <tr>
                        <th width="20%">服务时间</th>
                        <th width="60%">赠品</th>
                        <th>操作</th>
                    </tr>
                    <?php if(!empty($model->club_service_detailed)){?>
                    <?php foreach($model->club_service_detailed as $v){?>
                    <tr class="gift_item <?php if ($v->if_del==509) { ?>itemoff<?php } ?>" id="gift_item_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>">
                        <td><span class="red"><?php echo $v->service_date;?></span> <?php echo $v->service_datatime_start;?> 至 <?php echo $v->service_datatime_end;?></td>
                        <td>
                            <table data-num="new" class="showinfo">
                                <?php if(!empty($v->gift_association)){?>
                                <?php foreach($v->gift_association as $v2){?>
                                <tr id="gift_item_<?php echo $v->id;?>_<?php echo $v2->relation_id;?>">
                                    <td width="60%">
                                        <input type="hidden" name="gift[<?php echo $v->id;?>][<?php echo $v2->id;?>][relation_type]" value="<?php echo $v2->relation_type;?>">
                                        <input type="hidden" name="gift[<?php echo $v->id;?>][<?php echo $v2->id;?>][relation_id]" value="<?php echo $v2->relation_id;?>">
                                        <input type="hidden" name="gift[<?php echo $v->id;?>][<?php echo $v2->id;?>][relation_ico]" value="<?php echo $v2->relation_ico;?>">
                                        <input type="hidden" name="gift[<?php echo $v->id;?>][<?php echo $v2->id;?>][relation_name]" value="<?php echo $v2->relation_name;?>">
                                        <input type="hidden" name="gift[<?php echo $v->id;?>][<?php echo $v2->id;?>][relation_json_attr]" value="<?php echo $v2->relation_json_attr;?>">
                                        <?php echo $v2->relation_name;?>
                                    </td>
                                    <td><input style="width:30px;" class="input-text" type="text" name="gift[<?php echo $v->id;?>][<?php echo $v2->id;?>][relation_num]" value="<?php echo $v2->relation_num;?>" placeholder="数量"></td>
                                    <td><input onclick="fnDeleteGift(this);" class="btn" type="button" value="删除"></td>
                                </tr>
                                <?php }?>
                                <?php }?>
                            </table>
                        </td>
                        <td style="text-align:left;"><input onclick="fnAddGift(this);" class="btn" type="button" value="添加赠品"></td></tr>
                    <?php }?>
                    <?php }?>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <div class="mt15">
            <table id="gf_service" style="display:none;">
                <tr class="table-title">
                    <td colspan="5">服务者信息 <!--<a class="btn" onclick="add_list_btn()"><i class="fa fa-plus"></i>添加</a>--></td>
                </tr>
                <tr style="text-align:center;">
                    <td>服务类别</td>
                    <td>服务人编号</td>
                    <td>服务人姓名</td>
                    <td>服务等级</td>
                    <td>操作</td>
                </tr>
            </table>
            <table id="gf_place" class="mt15" style="display:none;">
                <tr class="table-title">
                    <td colspan="5">场地信息 <!--<a class="btn" onclick="add_list_btn()"><i class="fa fa-plus"></i>添加</a>--></td>
                </tr>
                <tr style="text-align:center;">
                    <td>服务类别</td>
                    <td>服务信息</td>
                    <td>服务名称</td>
                    <td>服务等级</td>
                    <td>操作</td>
                </tr>
            </table>
        </div>
        <div class="mt15">
            <table class="" style="table-layout:auto">
                <tr class="table-title">
                    <td colspan="4">管理员操作</td>
                </tr>
                <tr>
                    <td width='15%'><?php echo $form->labelEx($model, 'reasons_for_failure'); ?></td>
                    <td width='85%' colspan="3">
                        <?php echo $form->textArea($model, 'reasons_for_failure', array('class' => 'input-text' ,'value'=>'')); ?>
                        <?php echo $form->error($model, 'reasons_for_failure', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                	<td>可执行操作</td>
                    <td colspan="3">
                        <?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核','tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div>
        <table class="showinfo">
            <tr>
                <th style="width:20%;">操作时间</th>
                <th style="width:20%;">操作人</th>
                <th style="width:20%;">状态</th>
                <th>操作备注</th>
            </tr>
            <tr>
                <td><?php echo $model->reasons_time; ?></td>
                <td><?php echo $model->reasons_adminname;  ?></td>
                <td><?php echo $model->state_name; ?></td>
                <td><?php echo $model->reasons_for_failure; ?></td>
            </tr>
        </table>
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    objLimitTime=new Object();
    <?php if(!empty($model->club_service_detailed)){?>
        <?php foreach($model->club_service_detailed as $v){?>
            objLimitTime[<?php echo $v->id;?>]=['<?php echo $v->service_date;?>','<?php echo $v->service_datatime_start;?>','<?php echo $v->service_datatime_end;?>', '1'];
        <?php }?>
    <?php }?>
    we.tab('.box-detail-tab li','.box-detail-tab-item',function(index){
        if(index==3){
            var istrue=true;
            // 检查服务时间是否填写完善
            $('.service-date').each(function(){
                if($(this).val()==''){
                    istrue=false;
                    return false;
                }
            });
            $('.service-date-num').each(function(){
                if($(this).val()==''){
                    istrue=false;
                    return false;
                }
            });
            if(istrue){
                fnUpdateGiftList();
                return true;
            }
            we.msg('minus','请完善服务时间信息');
            return false;
        }
        return true;
    });

    selecttype($('#ClubServiceData_type_code'));
    function selecttype(obj){
        var obj = $(obj).val();
        if(obj==174){
            $('#gf_place').show();
            $('#gf_service').hide();
        }
        else if(obj==180){
            $('#gf_place').show();
            $('#gf_service').show();
        }
        else if(obj==225){
            $('#gf_service').show();
            $('#gf_place').hide();
        }
        else{
            $('#gf_place').hide();
            $('#gf_service').hide();
        }
    }
    
    // 单位为该单位id
    var club_id=<?php echo $model->club_id;?>;
    var service_person_id=<?php if(isset($person) && $person!=null){ echo $person->id; }else{ echo '0'; }?>;
    var service_person_type_code=<?php if(isset($person) && $person!=null){ if(!empty($person->mall_products_type_sname->id)){ echo $person->mall_products_type_sname->id;}else{ echo '0'; } }else{ echo '0'; }?>;
    var service_person_project_id=<?php if(isset($person) && $person!=null){ echo $person->project_id; }else{ echo '0'; }?>;
    var service_person_project_name='<?php if(isset($person) && $person!=null){ echo $person->project_name; }?>';
    var service_place_id=<?php if(isset($place) && $place!=null){ echo $place->id; }else{ echo '0'; }?>;
    var project_id=<?php if($model->project_id!=''){ echo $model->project_id; }else{ echo '0'; } ?>;

    // 滚动图片处理
    var $service_pic_img=$('#ClubServiceData_service_pic_img');
    var $upload_pic_service_pic_img=$('#upload_pic_ClubServiceData_service_pic_img');
    var $upload_box_service_pic_img=$('#upload_box_ClubServiceData_service_pic_img');
    // 添加或删除时，更新图片
    var fnUpdateScrollpic=function(){
        var arr=[];
        $upload_pic_service_pic_img.find('a').each(function(){
            arr.push($(this).attr('data-savepath'));
        });
        $service_pic_img.val(we.implode(',',arr));
        var as=$service_pic_img.val(we.implode(',',arr));
        $upload_box_service_pic_img.show();
        if(arr.length>=5) {
            $upload_box_service_pic_img.hide();
        }
    }

    // 上传完成时图片处理
    var fnScrollpic=function(savename,allpath){
        $upload_pic_service_pic_img.append('<a class="picbox" data-savepath="'+
        savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdateScrollpic();return false;"></i></a>');
        fnUpdateScrollpic();
    };

    // 项目添加或删除时，更新
    var $ClubServiceData_project_id=$('#ClubServiceData_project_id');
    var $project_box=$('#project_box');

    // 初始化时间，用于计算有效期限
    var all_start_date='<?php if(isset($person) && isset($place) && !empty($person) && !empty($place)){ if(strtotime($person->start_date)>strtotime($place->site_date_start)){ echo $person->start_date; }else{ echo $place->site_date_start; } }elseif(isset($person) && $person!=null){ echo $person->start_date; }elseif(isset($place) && $place!=null){ echo $place->site_date_start; }?>';
    var all_end_date='<?php if(isset($person) && isset($place) && !empty($person) && !empty($place)){ if(strtotime($person->end_date)>strtotime($place->site_date_end)){ echo $place->site_date_end; }else{ echo $person->end_date; } }elseif(isset($person) && $person!=null){ echo $person->end_date; }elseif(isset($place) && $place!=null){ echo $place->site_date_end; }?>';
    var person_start_date='<?php if(isset($person) && $person!=null){ echo $person->start_date; }?>';
    var person_end_date='<?php if(isset($person) && $person!=null){ echo $person->end_date; }?>';
    var place_start_date='<?php if(isset($place) && $place!=null){ echo $place->site_date_start; }?>';
    var place_end_date='<?php if(isset($place) && $place!=null){ echo $place->site_date_end; }?>';
    $('#service_time_range').html('<span class="green">'+all_start_date+'</span>至<span class="green">'+all_end_date+'</span>');
    // 选择服务时间
    var $timelist=$('#timelist');
    var fnSetDate=function(op){
        //console.log(all_start_date+'===='+all_end_date);
        if(all_start_date=='' || all_end_date==''){ we.msg('minus', '请先选择服务人/场地'); return false; }
        if($dp!=undefined){
            $dp.minDate=all_start_date;$dp.maxDate=all_end_date;
        }
        WdatePicker({dateFmt:'yyyy-MM-dd',realDateFmt:'yyyy-MM-dd',minDate:all_start_date,maxDate:all_end_date,onpicked:function(dp){
            //$dp.cal.minDate=all_start_date;$dp.cal.maxDate=all_end_date;
            // 判断时间是否在有效范围内
            //console.log(dp.cal.getNewDateStr());return false;
            var time=strtotime(dp.cal.getNewDateStr());
            var current_id=$(op).parent().parent().attr('data-id');
            var current_line=$(op).parent().parent().find('input');
            var star_time = current_line.eq(1).val();
            var end_time = current_line.eq(2).val();
            //console.log('123'+star_time);
            $timelist.find('.item').each(function(){
                var $this=$(this);
                var this_id=$this.attr('data-id');
                ///对比已经发布的时间
                if(!isNaN(parseInt(this_id))){
                    for(var i in objLimitTime){
                        if(time==strtotime(objLimitTime[i][0]) && ((star_time>=objLimitTime[i][1] && star_time<=objLimitTime[i][2]) || (end_time>=objLimitTime[i][1] && end_time<=objLimitTime[i][2]))){
                            we.msg('minus', '服务时间与现有时间冲突');
                            $(op).val('');
                            return false;
                        }
                    }
                }else if(current_id!=this_id){
                    //对比已经新添加的时间
                    var $input=$this.find('input');
                    var input_date=$input.eq(0).val();
                    var input_start=$input.eq(1).val();
                    var input_end=$input.eq(2).val();
                    //console.log($input.eq(0).val());
                    if(input_date!='' && time==strtotime(input_date) && ((star_time>=input_start && star_time<=input_end) || (end_time>=input_star && end_time<=input_end))){
                        we.msg('minus', '服务时间与现有时间冲突');
                        $(op).val('');
                        return false;
                    }
                }
            });
            //console.log(current_id);
        }});
    }

    var fnSetTime=function(op){
        WdatePicker({dateFmt:'HH:mm:ss',realDateFmt:'HH:mm:ss',onpicked:function(dp){
            // var time=dp.cal.getNewDateStr();
            // console.log('123'+time);
            var current_id=$(op).parent().parent().attr('data-id');
            var current_line=$(op).parent().parent().find('input');
            var date=strtotime(current_line.eq(0).val());
            var star_time = current_line.eq(1).val();
            var end_time = current_line.eq(2).val();
            //console.log('123'+current_line.eq(0).val());
            $timelist.find('.item').each(function(){
                var $this=$(this);
                var this_id=$this.attr('data-id');
                ///对比已经发布的时间
                if(!isNaN(parseInt(this_id))){
                    for(var i in objLimitTime){
                        if(date==strtotime(objLimitTime[i][0]) && ((star_time>=objLimitTime[i][1] && star_time<=objLimitTime[i][2]) || (end_time>=objLimitTime[i][1] && end_time<=objLimitTime[i][2]))){
                            we.msg('minus', '服务时间与现有时间冲突');
                            $(op).val('');
                            return false;
                        }
                    }
                }else if(current_id!=this_id){
                    //对比已经新添加的时间
                    var $input=$this.find('input');
                    var input_date=$input.eq(0).val();
                    var input_start=$input.eq(1).val();
                    var input_end=$input.eq(2).val();
                    //console.log($input.eq(0).val());
                    if(input_date!='' && date==strtotime(input_date) && ((star_time>=input_start && star_time<=input_end) || (end_time>=input_star && end_time<=input_end))){
                        we.msg('minus', '服务时间与现有时间冲突');
                        $(op).val('');
                        return false;
                    }
                }
            });
        }});
        ///console.log(current_id);
    };

    // 添加服务时间
    var fnAddServiceDate=function(){
        var timelist_num=$timelist.attr('data-num')+1;
        var html='<tr class="item" data-id="'+timelist_num+'">'+
            '<td><input style="width:80%;" class="service-date input-text" type="text" name="timelist['+timelist_num+'][service_date]" value="" onclick="fnSetDate(this);" readonly></td>'+
            '<td><input style="width:80%;" class="service-date input-text" type="text" name="timelist['+timelist_num+'][service_datatime_start]" value="" onclick="fnSetTime(this);" readonly></td>'+
            '<td><input style="width:80%;" class="service-date input-text" type="text" name="timelist['+timelist_num+'][service_datatime_end]" value="" onclick="fnSetTime(this);" readonly></td>'+
            '<td><input style="width:80%;" class="input-text" type="text" name="timelist['+timelist_num+'][time_declare]" value=""></td>'+
            '<td><input style="width:80%;" class="service-date-num input-text" type="text" name="timelist['+timelist_num+'][num]" value=""></td><input class="input-text" type="hidden" name="timelist['+timelist_num+'][id]" value="null"><input class="input-text if_del" type="hidden" name="timelist['+timelist_num+'][if_del]" value="510">'+
            '<td style="text-align:left;"><input onclick="fnAddServiceDate();" class="btn" type="button" value="添加行"><input style="margin-left:10px;" onclick="fnRemoveServiceDate(this);" class="btn" type="button" value="删除行"></td>'+
        '</tr>';
        $timelist.attr('data-num',timelist_num);
        $timelist.append(html);
    };

    // 删除服务时间
    var fnRemoveServiceDate=function(op){
        $(op).parent().parent().remove();
    };

    var fnDeleteProduct=function(op){
        // alert('确定删除吗？');
        var a=confirm("确定删除吗？");
        if(a==true){
            $(op).parent().parent().remove();
        }
        else{
            console.log('取消删除');
        }
    };

    // 下架服务时间
    var fnOffServiceDate=function(op, id){
        var $this=$(op);
        var $tr=$this.parent().parent();
        var $offinput=$this.next('input');
        var $if_del=$this.parent().parent().find('.if_del');
        var dataid=$tr.attr('data-id');
        var $giftitem=$('#gift_item_'+dataid);
        if($tr.hasClass('itemoff')){
            $tr.removeClass('itemoff');
            $this.val('下架');
            $offinput.val('');
            $if_del.val(510);
            $giftitem.removeClass('itemoff');
            objLimitTime[id][3]=1;
        }else{
            $tr.addClass('itemoff');
            $this.val('已下架');
            $offinput.val(id);
            $if_del.val(509);
            $giftitem.addClass('itemoff');
            objLimitTime[id][3]=0;
        }
        //console.log(objLimitTime);
    };


    // 根据服务时间生成服务赠品
    var $giftlist=$('#giftlist');
    var fnUpdateGiftList=function(){
        var num;
        var $this;
        var $input;
        var arrTime=[];
        var arrGift=[];
        $timelist.find('.item').each(function(){
            $this=$(this);
            num=$this.attr('data-id');
            $input=$this.find('input');
            if($('#gift_item_'+num).length==0){
            $giftlist.append('<tr class="gift_item" id="gift_item_'+num+'" data-id="'+num+'">'+
                    '<td><span class="red">'+$input.eq(0).val()+'</span> '+$input.eq(1).val()+' 至 '+$input.eq(2).val()+'</td>'+
                    '<td>'+
                        '<table data-num="'+num+'" class="showinfo">'+
                        '</table>'+
                    '</td>'+
                    '<td style="text-align:left;"><input onclick="fnAddGift(this);" class="btn" type="button" value="添加赠品"></td></tr>'); 
            }else{
                $('#gift_item_'+num+' td:eq(0)').html('<span class="red">'+$input.eq(0).val()+'</span> '+$input.eq(1).val()+' 至 '+$input.eq(2).val());
            }
            arrTime[num]=1;
        });
        $giftlist.find('.gift_item').each(function(){
            $this=$(this);
            if(arrTime[$this.attr('data-id')]==undefined){
                $this.remove();
            }
        });
    };

    // 添加赠品
    var fnAddGift=function(op){
        $.dialog.data('gift_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/gift");?>&club_id='+club_id,{
            id:'liwu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('gift_id')>0){
                    var $giftbox=$(op).parent().prev();
                    var $table=$giftbox.find('table');
                    var pnum=$(op).parent().parent().attr('data-id');
                    var num=$table.attr('data-num')+1;
                    if($('#gift_item_'+pnum+'_'+$.dialog.data('gift_id')).length==0){
                        var html='<tr id="gift_item_'+pnum+'_'+$.dialog.data('gift_id')+'">'+
                                '<td width="60%"><input type="hidden" name="gift['+pnum+']['+num+'][relation_type]" value="'+$.dialog.data('gift_type')+'"><input type="hidden" name="gift['+pnum+']['+num+'][relation_id]" value="'+$.dialog.data('gift_id')+'"><input type="hidden" name="gift['+pnum+']['+num+'][relation_ico]" value="'+$.dialog.data('gift_ico')+'"><input type="hidden" name="gift['+pnum+']['+num+'][relation_name]" value="'+$.dialog.data('gift_name')+'"><input type="hidden" name="gift['+pnum+']['+num+'][relation_json_attr]" value="'+$.dialog.data('gift_json_attr')+'">'+$.dialog.data('gift_name')+' '+$.dialog.data('gift_json_attr')+'</td>'+
                                '<td><input style="width:30px;" class="input-text" type="text" name="gift['+pnum+']['+num+'][relation_num]" value="1" placeholder="数量"></td>'+
                                '<td><input onclick="fnDeleteGift(this);" class="btn" type="button" value="删除"></td>'+
                            '</tr>';
                        $table.attr('data-num', num)
                        $table.append(html);
                    }
                }
            }
        });
    };

    // 删除赠品
    var fnDeleteGift=function(op){
        $(op).parent().parent().remove();
    };

    $(function(){
        var $ClubServiceData_club_id=$('#ClubServiceData_club_id');
        var $club_box=$('#club_box');
        
        var $service_person_box=$('#service_person_box');
        var $service_place_box=$('#service_place_box');
        
        var $service_person_main=$('#service_person_main');
        var $service_place_main=$('#service_place_main');
    
        var $ClubServiceData_type_code=$('#ClubServiceData_type_code');
        var $ClubServiceData_type_code_person=$('#ClubServiceData_type_code_person');
        var $ClubServiceData_data_id=$('#ClubServiceData_data_id');
    
        var $project_add_btn=$('#project_add_btn');
        var $service_time_range=$('#service_time_range');
        // 重置服务者/场地
        var fnResetDataId=function(){
            service_person_id=0;
            service_person_type_code=0;
            service_person_project_id=0;
            service_person_project_name='';
            service_place_id=0;
            all_start_date='';
            all_end_date='';
            person_start_date='';
            person_end_date='';
            place_start_date='';
            place_end_date='';
            $ClubServiceData_type_code_person.val('');
            $ClubServiceData_data_id.val('');
            $service_person_box.html('<span class="label-box">请选择服务者</span>');
            $service_place_box.html('<span class="label-box">请选择场地</span>');
        };
        // 更新服务者/场地
        var fnUpdateDataId=function(){
            var type_id=$ClubServiceData_type_code.val();
            $ClubServiceData_data_id.val('');
            all_start_date='';
            all_end_date='';
            if(type_id==174){
                if(service_place_id!=0){
                    $ClubServiceData_data_id.val(service_place_id);
                }
                $service_person_main.hide();
                $service_place_main.show();
                all_start_date=place_start_date;
                all_end_date=place_end_date;
            }else if(type_id==180){
                if(service_person_id!=0 && service_place_id!=0){
                    $ClubServiceData_data_id.val(service_person_id+','+service_place_id);
                }
                $service_person_main.show();
                $service_place_main.show();
                // 对比服务者和场地的有效时间，选取综合有效时间
                if(person_start_date!='' && place_start_date!=''){
                    if(we.strtotime(person_start_date)>we.strtotime(place_start_date)){
                        all_start_date=person_start_date;
                    }else{
                        all_start_date=place_start_date;
                    }
                }
                if(person_end_date!='' && place_end_date!=''){
                    if(we.strtotime(person_end_date)>we.strtotime(place_end_date)){
                        all_end_date=place_end_date;
                    }else{
                        all_end_date=person_end_date;
                    }
                }
            }else if(type_id==225){
                if(service_person_id!=0){
                    $ClubServiceData_data_id.val(service_person_id);
                }
                $service_person_main.show();
                $service_place_main.hide();
                all_start_date=person_start_date;
                all_end_date=person_end_date;
            }
            //console.log(all_start_date+'===='+all_end_date);
            if(all_start_date!='' && all_end_date!=''){
                $service_time_range.html('<span class="green">'+all_start_date+'</span>至<span class="green">'+all_end_date+'</span>');
            }else{
                $service_time_range.html('');
            }
        };
        //fnUpdateDataId();
        
        // 选择项目
        $project_add_btn.on('click', function(){
            var club_id=$('#ClubServiceData_club_id').val();
            $.dialog.data('project_id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/project_list");?>&club_id='+club_id,{
                id:'xiangmu',
                lock:true,
                opacity:0.3,
                title:'选择具体内容',
                width:'500px',
                height:'60%',
                close: function () {
                    if($.dialog.data('project_id')>0){
                        project_id=$.dialog.data('project_id');
                        $ClubServiceData_project_id.val(project_id);
                        $project_box.html('<span class="label-box">'+$.dialog.data('project_title')+'</span>'); 
                    }
                }
            });
        });
        
        // 选择服务类型
        $ClubServiceData_type_code.on('change', function(){
            fnUpdateDataId();
        });
        
        // 选择服务者
        var $gf_service=$('#gf_service');
        $('#service_person_btn').on('click', function(){
            var num=1;
            var club_id=$('#ClubServiceData_club_id').val();
            var project_id=$('#ClubServiceData_project_id').val();
            if(club_id==''){
                we.msg('minus', '请先选择发布单位');
                return false;
            }
            if(project_id<=0){
                we.msg('minus', '请先选择项目服务项目');
                $ClubServiceData_project_id.trigger('blur');
                return false;
            }

            $.dialog.data('service_person_id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/servicePerson");?>'+'&club_id='+club_id+'&project_id='+project_id+'&ser_gf='+1,{
                id:'fuwuzhe',
                lock:true,
                opacity:0.3,
                title:'选择具体内容',
                width:'500px',
                height:'60%',
                close: function() {
                if($.dialog.data('service_person_id')==-1){
                    var boxnum=$.dialog.data('service_person_title');
                    for(var j=0;j<boxnum.length;j++) {
                        // num=num+1;
                        if($('#service_item_'+boxnum[j].dataset.serid).length==0){
                            $gf_service.append(
                                '<tr style="text-align:center;" id="service_item_'+boxnum[j].dataset.serid+'">'+
                                    '<td>'+boxnum[j].dataset.typename+
                                        '<input type="hidden" class="input-text" name="product['+num+'][id_null]" value="null">'+
                                        '<input type="hidden" class="input-text" name="product['+num+'][title]" value="'+boxnum[j].dataset.title+'">'+
                                        '<input type="hidden" class="input-text" name="product['+num+'][name]" value="'+boxnum[j].dataset.name+'">'+
                                        '<input type="hidden" class="input-text" name="product['+num+'][levelname]" value="'+boxnum[j].dataset.levelname+'">'+
                                        '<input type="hidden" class="input-text" name="product['+num+'][typecode]" value="'+boxnum[j].dataset.typecode+'">'+
                                        '<input type="hidden" class="input-text" name="product['+num+'][account]" value="'+boxnum[j].dataset.account+'">'+
                                    '</td>'+
                                    '<td>'+boxnum[j].dataset.title+'</td>'+
                                    '<td>'+boxnum[j].dataset.name+'</td>'+
                                    '<td>'+boxnum[j].dataset.levelname+'</td>'+
                                    '<td><a class="btn" href="javascript:;" onclick="fnDeleteProduct(this);" title="删除"><i class="fa fa-trash-o"></i></a></td>'+
                                '</tr>'
                            );
                            num++;
                        }
                    }
                }
            }
            });
        });
        
        // 选择场地
        var $service_place_btn=$('#service_place_btn');
        $service_place_btn.on('click', function(){
            if(club_id<0){
                if($ClubServiceData_club_id.val()===''){
                    $ClubServiceData_club_id.trigger('blur');
                    return false;
                }else{
                    club_id=$ClubServiceData_club_id.val();
                }
            }
            if(project_id<=0){
                we.msg('minus', '请先选择项目服务项目');
                $ClubServiceData_project_id.trigger('blur');
                return false;
            }
            $.dialog.data('service_place_id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/servicePlace");?>'+'&club_id='+club_id+'&project_id='+project_id,{
                id:'changdi',
                lock:true,
                opacity:0.3,
                title:'选择具体内容',
                width:'500px',
                height:'60%',
                close: function () {
                    //console.log($.dialog.data('club_id'));
                    if($.dialog.data('service_place_id')>0){
                        service_place_id=$.dialog.data('service_place_id');
                        place_start_date=$.dialog.data('service_place_start_date');
                        place_end_date=$.dialog.data('service_place_end_date');
                        $service_place_box.html('<span class="label-box">'+$.dialog.data('service_place_title')+'</span>');
                        fnUpdateDataId();
                    }
                }
            });
        });
        
        // 选择服务地区
        var $ClubServiceData_area=$('#ClubServiceData_area');
        var $ClubServiceData_longitude=$('#ClubServiceData_longitude');
        var $ClubServiceData_latitude=$('#ClubServiceData_latitude');
        $ClubServiceData_area.on('click', function(){
            $.dialog.data('maparea_address', '');
            $.dialog.open('<?php echo $this->createUrl("select/mapArea");?>',{
                id:'diqu',
                lock:true,
                opacity:0.3,
                title:'选择服务地区',
                width:'907px',
                height:'504px',
                close: function () {;
                    if($.dialog.data('maparea_address')!=''){
                        $ClubServiceData_area.val($.dialog.data('maparea_address'));
                        $ClubServiceData_longitude.val($.dialog.data('maparea_lng'));
                        $ClubServiceData_latitude.val($.dialog.data('maparea_lat'));
                    }
                }
            });
        });
    });

    //从图库选择图片
    var $Single=$('#ClubServiceData_imgUrl');
    $('#picture_select_btn').on('click', function(){
        var club_id=$('#ClubServiceData_club_id').val();
        $.dialog.data('app_icon', 0);
        $.dialog.open('<?php echo $this->createUrl("gfMaterial/materialPictureAll", array('type'=>252,'fd'=>135));?>&club_id='+club_id,{
            id:'picture',
            lock:true,
            opacity:0.3,
            title:'请选择素材',
            width:'100%',
            height:'90%',
            close: function () {
                if($.dialog.data('material_id')>0){
                    $Single.val($.dialog.data('app_icon')).trigger('blur');
                    $('#upload_pic_ClubServiceData_imgUrl').html('<a href="<?php echo $basepath->F_WWWPATH;?>'+art.dialog.data('app_icon')+'" target="_blank"> <img src="<?php echo $basepath->F_WWWPATH;?>'+art.dialog.data('app_icon')+'"  width="100"></a>');
                    // $('#Gfapp_app_icon_x').val($.dialog.data('dataX')).trigger('blur');
                    //$('#Gfapp_app_icon_y').val($.dialog.data('dataY')).trigger('blur');
                    //$('#Gfapp_app_icon_w').val($.dialog.data('dataWidth')).trigger('blur');
                    //$('#Gfapp_app_icon_h').val($.dialog.data('dataHeight')).trigger('blur');
                }
            }
        });
    });
</script>
