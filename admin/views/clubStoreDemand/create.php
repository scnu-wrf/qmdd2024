<?php 
    if(!empty($model->club_id)){
        $model->club_id=0;
    }
?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>添加服务</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">基本信息</li>
                <li>详细描述</li>
                <li>服务时间</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block" class="box-detail-tab-item">
                <table>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'title'); ?></td>
                        <td width="35%">
                            <?php echo $form->textField($model, 'title', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'title', $htmlOptions = array()); ?>
                        </td>
                        <td width="15%">服务单位</td>
                        <td width="35%">
                            <?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text')); ?>
                            <span id="club_box"><?php if($model->club_id!=null){?><span class="label-box"><?php echo $model->club_name;?></span><?php }?></span>
                            <input id="club_select_btn" class="btn" type="button" value="选择">
                            <?php echo $form->error($model, 'club_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'project_id'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'project_id', array('class' => 'input-text')); ?>
                            <span id="project_box"></span><input id="project_add_btn" class="btn" type="button" value="选择">
                            <?php echo $form->error($model, 'project_id', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'level_code'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'level_code', array('class' => 'input-text', 'style' => 'width:100px;')); ?>
                            <?php echo $form->error($model, 'level_code', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'type_code'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'type_code', Chtml::listData(MallProductsTypeSname::model()->getCode(173), 'id', 'sn_name'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'type_code', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'data_id'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'type_code_person'); ?>
                            <?php echo $form->hiddenField($model, 'data_id'); ?>
                            <span style="margin-right:10px; display:none;" id="service_person_main">
                                <span id="service_person_box"><span class="label-box">请选择服务者</span></span>
                                <input id="service_person_btn" class="btn" type="button" value="选择">
                            </span>
                            <span style="display:none;" id="service_place_main">
                                <span id="service_place_box"><span class="label-box">请选择场地</span></span>
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
                            <script>we.uploadpic('<?php echo get_class($model);?>_imgUrl','<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'imgUrl', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'service_pic_img'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'service_pic_img', array('class' => 'input-text')); ?>
                            <div class="upload_img fl" id="upload_pic_ClubStoreDemand_service_pic_img">
                                <?php foreach($service_pic_img as $v) if($v) {?>
                                <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px;"><i onclick="$(this).parent().remove();fnUpdateServicePic();return false;"></i></a>
                                <?php }?>
                            </div>
                            <script>we.uploadpic('<?php echo get_class($model);?>_service_pic_img','<?php echo $picprefix;?>','','',function(e1,e2){fnServicePic(e1.savename,e1.allpath);},5);</script>
                            <?php echo $form->error($model, 'service_pic_img', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'area'); ?></td>
                        <td >
                            <?php echo $form->textField($model, 'area', array('class' => 'input-text')); ?>
                            <?php echo $form->hiddenField($model, 'longitude'); ?>
                            <?php echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'area', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'site_contain'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'site_contain', array('class' => 'input-text', 'style'=>'width:40px;')); ?>
                            <span class="msg">人</span>
                            <?php echo $form->error($model, 'site_contain', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'detail_gfaccount'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'detail_gfaccount', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'detail_gfaccount', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'detail_gfname'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'detail_gfname', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'detail_gfname', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'local_and_phone'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'local_and_phone', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'local_and_phone', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'budget_amount'); ?></td>
                        <td><?php echo $form->textField($model, 'budget_amount', array('class' => 'input-text')); ?></td>
                    </tr>
                </table>
                <div class="mt15">
                    <table class="table-title">
                        <tr>
                            <td>申请服务</td>
                        </tr>
                    </table>
                    <table style="margin-top:0;">
                        <tr>
                            <td width="15%">服务主题</td>
                            <!--<td><?php echo $model->data_name;?></td>-->
                            <td width="35%">
                                <?php echo $form->hiddenField($model, 'service_type', array('class' => 'input-text')); ?>
                                <span id="clubstore_box"><?php if(is_array('title')) { foreach($title as $v){?><span class="label-box" id="clubstore_item_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>"><?php echo $v->title;?><i onclick="fnDeleteClubstore(this);"></i></span><?php } }?></span>
                                </span><?php echo $form->error($model, 'service_type', $htmlOptions = array()); ?>
                            </td>
                            <td width="15%"></td>
                            <td width="35%" readonly>
                                <!--<input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>" readonly>-->
                                <!--<?php echo $model->club_service_detailed_id->service_date ;?>-->
                            </td>
                        </tr>
                    </table>
                </div>
            </div><!--box-detail-tab-item end-->
            <div class="box-detail-tab-item">
                <?php echo $form->hiddenField($model, 'introduceUrl_temp', array('class' => 'input-text')); ?>
                <script>we.editor('<?php echo get_class($model);?>_introduceUrl_temp', '<?php echo get_class($model);?>[introduceUrl_temp]');</script>
                <?php echo $form->error($model, 'introduceUrl_temp', $htmlOptions = array()); ?>
            </div><!--box-detail-tab-item end-->
            <div class="box-detail-tab-item">
                <div class="box-msg red">注意：您的有效服务时间范围为：<span id="service_time_range"></span>，且每一行时间段不能重叠</div>

                <table id="timelist" class="showinfo" data-num="new">
                    <tr class="table-title">
                        <th width="15%">服务日期</th>
                        <th width="15%">开始时间</th>
                        <th width="15%">结束时间</th>
                        <th width="25%">服务说明</th>
                        <th width="8%">可售数量</th>
                        <th width="8%">已售数量</th>
                        <th width="14%">操作</th>
                    </tr>
                    <tr class="item" data-id="new">
                        <td><input onchange="fnUpdateTimelist();" class="service-date input-text" type="text" name="timelist[new][service_date]" onclick="fnSetDate(this);" readonly></td>
                        <td><input onchange="fnUpdateTimelist();" class="service-date input-text" type="text" name="timelist[new][service_datatime_start]" onclick="fnSetTime(this);" readonly></td>
                        <td><input onchange="fnUpdateTimelist();" class="service-date input-text" type="text" name="timelist[new][service_datatime_end]" onclick="fnSetTime(this);" readonly></td>
                        <td><input onchange="fnUpdateTimelist();" class="input-text" type="text" name="timelist[new][time_declare]"></td>
                        <td><input onchange="fnUpdateTimelist();" class="service-date-num input-text" type="text" name="timelist[new][saleable_quantity]"></td>
                        <td><input onchange="fnUpdateTimelist();" class="service-date-num input-text" type="text" name="timelist[new][auantity_sold]"></td>
                        <td style="text-align:left;"><input onclick="fnAddServiceDate();" class="btn" type="button" value="添加行"><input style="margin-left:10px;" onclick="fnRemoveServiceDate(this);" class="btn" type="button" value="删除行"></td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <div class="mt15">
            <table class="table-title">
                <tr>
                    <td>管理员操作</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td width="15%">操作备注</td>
                    <td width="35%">
                        <?php echo $form->textArea($model, 'reasons_for_failure', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'reasons_for_failure'); ?>
                    </td>
                    <td width="15%">可执行操作</td>
                    <td width="35%">
                        <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                        <button onclick="submitType='tongguo'" class="btn btn-blue" type="submit">审核通过</button>
                        <button onclick="submitType='butongguo'" class="btn btn-blue" type="submit">审核不通过</button>
                        <input id="clubstore_add_btn" class="btn btn-blue" type="button" value="申请服务">
                    </td>
                </tr>
            </table>
        </div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
$(function(){
    var $start_time=$('#start_date');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
});
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
        $('.service-date-product').each(function(){
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
// 单位为该单位id
var club_id=0;
var data_id=0;
var service_person_id=0;
var service_person_type_code=0;
var service_person_project_id=0;
var service_person_project_name='';
var service_place_id=0;
var project_id=0;

// 滚动图片处理
var $service_pic_img=$('#ClubStoreDemand_service_pic_img');
var $upload_pic_ClubStoreDemand_service_pic_img=$('#upload_pic_ClubStoreDemand_service_pic_img');
var $upload_box_ClubStoreDemand_service_pic_img=$('#upload_box_ClubStoreDemand_service_pic_img');
// 添加或删除时，更新图片
var fnUpdateServicePic=function(){
    var arr=[];
    $upload_pic_ClubStoreDemand_service_pic_img.find('a').each(function(){
        arr.push($(this).attr('data-savepath'));
    });
    $service_pic_img.val(we.implode(',',arr));
    $upload_box_ClubStoreDemand_service_pic_img.show();
    if(arr.length>=5) {
        $upload_box_ClubStoreDemand_service_pic_img.hide();
    }
};

// 上传完成时图片处理
var fnServicePic=function(savename,allpath){
    $upload_pic_ClubStoreDemand_service_pic_img.append('<a class="picbox" data-savepath="'+
    savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdateServicePic();return false;"></i></a>');
    fnUpdateServicePic();
};

// 项目添加或删除时，更新
var $ClubStoreDemand_project_id=$('#ClubStoreDemand_project_id');
var $project_box=$('#project_box');

// 初始化时间，用于计算有效期限
var all_start_date='';
var all_end_date='';
var person_start_date='';
var person_end_date='';
var place_start_date='';
var place_end_date='';

// 选择服务时间
var $timelist=$('#timelist');
var fnSetDate=function(op){
    //console.log(all_start_date+'===='+all_end_date);
    // if(all_start_date=='' || all_end_date==''){ we.msg('minus', '请先选择服务人/场地'); return false; }
    if($dp!=undefined){ $dp.minDate=all_start_date;$dp.maxDate=all_end_date; }
    WdatePicker({dateFmt:'yyyy-MM-dd',realDateFmt:'yyyy-MM-dd',minDate:all_start_date,maxDate:all_end_date,onpicked:function(dp){
        //$dp.cal.minDate=all_start_date;$dp.cal.maxDate=all_end_date;
        // 判断时间是否在有效范围内
        //console.log(dp.cal.getNewDateStr());return false;
        var time=strtotime(dp.cal.getNewDateStr());
        var current_id=$(op).parent().parent().attr('data-id');
        var current_line=$(op).parent().parent().find('input');
        var star_time=current_line.eq(1).val();
        var end_time=current_line.eq(2).val();
        $timelist.find('.item').each(function(){
            var $this=$(this);
            var this_id=$this.attr('data-id');
            //对比已经新添加的时间
            console.log(current_id==this_id);
            if(current_id!=this_id){
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
};

var fnSetTime=function(op){
   WdatePicker({dateFmt:'HH:mm:ss',realDateFmt:'HH:mm:ss',onpicked:function(dp){
   var current_id=$(op).parent().parent().attr('data-id');
   var current_line=$(op).parent().parent().find('input');
   var date=strtotime(current_line.eq(0).val());
   var star_time = current_line.eq(1).val();
   var end_time = current_line.eq(2).val();
   //console.log('123'+current_line.eq(0).val());
   $timelist.find('.item').each(function(){
   var $this=$(this);
   var this_id=$this.attr('data-id');
   if(current_id!=this_id){
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

var fnSetTime=function(op){
    WdatePicker({dateFmt:'HH:mm:ss',realDateFmt:'HH:mm:ss'});
};

// 添加服务时间
var $timelist=$('#timelist');
var $ClubStoreDemand_timelist=$('#ClubStoreDemand_timelist');
var fnAddServiceDate=function(){
    var timelist_num=$timelist.attr('data-num')+1;
    $timelist.append('<tr class="item" data-id="'+timelist_num+'">'+
        '<td><input onchange="fnUpdateTimelist();" class="service-date input-text" type="text" name="timelist['+timelist_num+'][service_date]" onclick="fnSetDate(this);" readonly></td>'+
        '<td><input onchange="fnUpdateTimelist();" class="service-date input-text" type="text" name="timelist['+timelist_num+'][service_datatime_start]" onclick="fnSetTime(this);" readonly></td>'+
        '<td><input onchange="fnUpdateTimelist();" class="service-date input-text" type="text" name="timelist['+timelist_num+'][service_datatime_end]" onclick="fnSetTime(this);" readonly></td>'+
        '<td><input onchange="fnUpdateTimelist();" class="input-text" type="text" name="timelist['+timelist_num+'][time_declare]"></td>'+
        '<td><input onchange="fnUpdateTimelist();" class="service-date-num input-text" type="text" name="timelist['+timelist_num+'][num]"></td>'+
        '<td><input onchange="fnUpdateTimelist();" class="service-date-num input-text" type="text" name="timelist['+timelist_num+'][num2]"></td>'+
        '<td style="text-align:left;"><input onclick="fnAddServiceDate();" class="btn" type="button" value="添加行"><input style="margin-left:10px;" onclick="fnRemoveServiceDate(this);" class="btn" type="button" value="删除行"></td>'+
    '</tr>');
    $timelist.attr('data-num',timelist_num);
    fnUpdateTimelist();
};
// 删除服务时间
var fnRemoveServiceDate=function(op){
    $(op).parent().parent().remove();
    fnUpdateTimelist();
};
var fnUpdateTimelist=function(){
    var isEmpty=true;
    $timelist.find('.input-text').each(function(){
        if($(this).val()!=''){
            isEmpty=false;
            return false;
        }
    });
    if(!isEmpty){
        $ClubStoreDemand_timelist.val('1').trigger('blur');
    }
    else{
        $ClubStoreDemand_timelist.val('').trigger('blur');
    }
}

// 删除申请服务
var $clubstore_box=$('#clubstore_box');
var $ClubStoreDemand_service_type=$('#ClubStoreDemand_service_type');
var fnUpdateClubstore=function(){
    var arr=[];
    var id;
    $clubstore_box.find('span').each(function(){
        id=$(this).attr('data-id');
        arr.push(id);
    });
    $ClubStoreDemand_service_type.val(we.implode(',', arr));
};
var fnDeleteClubstore=function(op){
    $(op).parent().remove();
    fnUpdateClubstore();
};

$(function(){
    var $ClubStoreDemand_club_id=$('#ClubStoreDemand_club_id');
    var $club_box=$('#club_box');
    
    var $service_person_box=$('#service_person_box');
    var $service_place_box=$('#service_place_box');
    
    var $service_person_main=$('#service_person_main');
    var $service_place_main=$('#service_place_main');
 
    var $ClubStoreDemand_type_code=$('#ClubStoreDemand_type_code');
    var $ClubStoreDemand_type_code_person=$('#ClubStoreDemand_type_code_person');
    var $ClubStoreDemand_data_id=$('#ClubStoreDemand_data_id');
 
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
        $ClubStoreDemand_type_code_person.val('');
        $ClubStoreDemand_data_id.val('');
        $service_person_box.html('<span class="label-box">请选择服务者</span>');
        $service_place_box.html('<span class="label-box">请选择场地</span>');
    };
    // 更新服务者/场地
    var fnUpdateDataId=function(){
        var type_id=$ClubStoreDemand_type_code.val();
        $ClubStoreDemand_type_code_person.val('');
        $ClubStoreDemand_data_id.val('');
        all_start_date='';
        all_end_date='';
        if(type_id==174){
            if(service_place_id!=0){
                $ClubStoreDemand_data_id.val(service_place_id);
            }
            $service_person_main.hide();
            $service_place_main.show();
            all_start_date=place_start_date;
            all_end_date=place_end_date;
        }else if(type_id==180){
            if(service_person_id!=0 && service_place_id!=0){
                // $ClubStoreDemand_type_code_person.val(service_person_id+','+service_place_id);
                $ClubStoreDemand_data_id.val(service_person_id+','+service_place_id);
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
                $ClubStoreDemand_type_code_person.val(service_person_id);
                // $ClubStoreDemand_data_id.val(service_person_id);
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
    

    // 选择单位
    var 
    $('#club_select_btn').on('click', function(){
        $.dialog.data('club_id', -1);
        $.dialog.open('<?php echo $this->createUrl("select/club", array('partnership_type'=>16));?>',{
            id:'danwei',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('club_id')>0){
                    if($.dialog.data('club_id')!=club_id){fnResetDataId();}
                    club_id=$.dialog.data('club_id');
                    $ClubStoreDemand_club_id.val($.dialog.data('club_id')).trigger('blur');
                    $club_box.html('<span class="label-box">'+$.dialog.data('club_title')+'</span>');
                }
            }
        });
    });

    // 申请服务
    var $clubstore_add_btn=$('#clubstore_add_btn');
    $('#clubstore_add_btn').on('click', function(){
        $.dialog.data('club_store', 0);
        $.dialog.open('<?php echo $this->createUrl("select/clubStore");?>',{
            id:'shenqingfuwu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('club_store')>0){
                    if($('#clubstore_item_'+$.dialog.data('club_store')).length==0){

                       $clubstore_box.html('<span class="label-box" id="clubstore_item_'+$.dialog.data('club_store')+'" data-id="'+$.dialog.data('club_store')+'">'+$.dialog.data('club_store_title')+$.dialog.data('club_store_club')+$.dialog.data('club_store_datailed')'<i onclick="fnDeleteClubstore(this);"></i></span>');
                       fnUpdateClubstore();
                    }
                }
            }
        });
    });
    
    // 添加项目
    $project_add_btn.on('click', function(){
        $.dialog.data('project_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/project");?>',{
            id:'xiangmu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('project_id')>0){
                       project_id=$.dialog.data('project_id');
                       $ClubStoreDemand_project_id.val(project_id);
                       $project_box.append('<span class="label-box" id="project_item_'+$.dialog.data('project_id')+'" data-id="'+$.dialog.data('project_id')+'">'+$.dialog.data('project_title')+'</span>');
                }
            }
        });
    });
    
    // 选择服务类型
    $ClubStoreDemand_type_code.on('change', function(){
        fnUpdateDataId();
    });

    // 选择服务者
    $('#service_person_btn').on('click', function(){ 
        // if(club_id<=0){
        //     we.msg('minus', '请先选择发布单位');
        //     $ClubStoreDemand_club_id.trigger('blur');
        //      return false;
        // }else{
        //     club_id=$ClubStoreDemand_club_id.val();
        // }
        // if(project_id<=0){
        //     we.msg('minus', '请先选择服务项目');
        //     $ClubStoreDemand_project_id.trigger('blur');
        //      return false;
        // }
        $.dialog.data('gfid', 0);
        $.dialog.open('<?php echo $this->createUrl("select/qualification");?>',{
            id:'fuwuzhe',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('gfid')>0){
                    service_person_id=$.dialog.data('gfid');
                    $ClubStoreDemand_type_code_person.val($.dialog.data('gfid')).trigger('blur');
                    $service_person_box.html('<span class="label-box">'+$.dialog.data('qualification_title')+'</span>');
                }
            }
        });
    });
    
    // 选择场地
    var $service_place_btn=$('#service_place_btn');
    $service_place_btn.on('click', function(){
        // if(club_id<=0){
        //     we.msg('minus', '请先选择发布单位');
        //     $ClubStoreDemand_club_id.trigger('blur');
        //      return false;
        // }
        // if(project_id<0){
        //     we.msg('minus', '请先选择服务项目');
        //     $ClubStoreDemand_project_id.trigger('blur');
        //      return false;
        // }
        $.dialog.data('club_cd_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/gfSite");?>',{
            id:'changdi',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('club_cd_id')>0){
                    service_place_id=$.dialog.data('club_cd_id');
                    $ClubStoreDemand_data_id.val($.dialog.data('club_cd_id')).trigger('blur');
                    $service_place_box.html('<span class="label-box">'+$.dialog.data('club_title')+'</span>');
                }
            }
        });
    });
    
    // 选择服务地区
    var $ClubStoreDemand_area=$('#ClubStoreDemand_area');
    var $ClubStoreDemand_longitude=$('#ClubStoreDemand_longitude');
    var $ClubStoreDemand_latitude=$('#ClubStoreDemand_latitude');
    $ClubStoreDemand_area.on('click', function(){
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
                    $ClubStoreDemand_area.val($.dialog.data('maparea_address'));
                    $ClubStoreDemand_longitude.val($.dialog.data('maparea_lng'));
                    $ClubStoreDemand_latitude.val($.dialog.data('maparea_lat'));
                }
            }
        });
    });
});
</script>