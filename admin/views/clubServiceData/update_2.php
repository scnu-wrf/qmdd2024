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
                        <td width="15%"><?php if(Yii::app()->session['club_id']==1){?><?php echo $form->labelEx($model, 'club_id'); ?><?php }?></td>
                        <td width="35%">
                            <?php if(Yii::app()->session['club_id']==1){?>
                            <?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text')); ?>
                            <span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->club_list->club_name;?></span><?php }?></span>
                            <input id="club_select_btn" class="btn" type="button" value="选择">
                            <?php echo $form->error($model, 'club_id', $htmlOptions = array()); ?>
                            <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'project_id'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'project_id', array('class' => 'input-text')); ?>
                            <span id="project_box"><?php if($model->project_list!=null){?><span class="label-box" id="project_item_<?php echo $model->project_id;?>" data-id="<?php echo $model->project_id;?>"><?php echo $model->project_list->project_name;?></span><?php }?></span>
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
                            <?php echo $form->dropDownList($model, 'type_code', Chtml::listData(MallProductsTypeSname::model()->getCode(173), 'id', 'sn_name'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'type_code', $htmlOptions = array()); ?>
                        </td>
                        <td width="15%"><?php echo $form->labelEx($model, 'data_id'); ?></td>
                        <td width="35%">
                            <?php echo $form->hiddenField($model, 'type_code_person'); ?>
                            <?php echo $form->hiddenField($model, 'data_id'); ?>
                            <span style="margin-right:10px;<?php if($model->type_code==174){?> display:none;<?php }?>" id="service_person_main">
                                <span id="service_person_box"><span class="label-box"><?php if($model->type_code==180 || $model->type_code==225){?><?php echo $person->qualification_name;?>-<?php echo $person->project_name;?>-<?php echo $person->qualification_type;?><?php }else{ ?>请选择服务者<?php } ?></span></span>
                                <input id="service_person_btn" class="btn" type="button" value="选择">
                            </span>
                            <span style="<?php if($model->type_code==225){?>display:none;<?php }?>" id="service_place_main">
                                <span id="service_place_box"><span class="label-box"><?php if($model->type_code==180 || $model->type_code==174){ echo $place->site_name; }else{ ?>请选择场地<?php } ?></span></span>
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
                            <div class="upload_img fl" id="upload_pic_ClubServiceData_imgUrl">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->imgUrl;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$model->imgUrl;?>" width="100">
                                </a>
                            </div>
                            <script>we.uploadpic('<?php echo get_class($model);?>_imgUrl','<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'imgUrl', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'service_pic_img'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'service_pic_img', array('class' => 'input-text')); ?>
                            <div class="upload_img fl" id="upload_pic_ClubServiceData_service_pic_img">
                                <?php foreach($service_pic_img as $v){?>
                                <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v;?>" width="100"><i onclick="$(this).parent().remove();fnUpdateServicePic();return false;"></i></a>
                                <?php }?>
                            </div>
                            <script>we.uploadpic('<?php echo get_class($model);?>_service_pic_img','<?php echo $picprefix;?>','','',function(savename,allpath){fnServicePic(savename,allpath);},5);</script>
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
                <script>we.editor('<?php echo get_class($model);?>_introduceUrl_temp');</script>
                <?php echo $form->error($model, 'introduceUrl_temp', $htmlOptions = array()); ?>
            </div><!--box-detail-tab-item end-->
            <div class="box-detail-tab-item">
                <div class="box-msg red">注意：您的有效服务时间范围为：<span id="service_time_range"></span>，且每一行时间段不能重叠</div>
                <table id="timelist" class="showinfo" data-num="new">
                    <tr>
                        <th width="25%">开始时间</th>
                        <th width="25%">结束时间</th>
                        <th width="25%">数量</th>
                        <th>操作</th>
                    </tr>
                    <?php if(empty($model->club_service_detailed)){?>
                    <tr class="item" data-id="new">
                        <td><input style="width:80%;" class="service-date input-text" type="text" name="timelist[new][start_date]" value="" onclick="fnSetDate();" readonly></td>
                        <td><input style="width:80%;" class="service-date input-text" type="text" name="timelist[new][end_date]" value="" onclick="fnSetDate();" readonly></td>
                        <td><input style="width:30%;" class="input-text" type="text" name="timelist[new][num]" value=""></td>
                        <td style="text-align:left;"><input onclick="fnAddServiceDate();" class="btn" type="button" value="添加行"></td>
                    </tr>
                    <?php }else{?>
                    <?php foreach($model->club_service_detailed as $v){?>
                    <tr class="item" data-id="<?php echo $v->id;?>">
                        <td><?php echo $v->service_datatime_start;?></td>
                        <td><?php echo $v->service_datatime_end;?></td>
                        <td><?php echo $v->saleable_quantity;?></td>
                        <td style="text-align:left;"><input onclick="fnAddServiceDate();" class="btn" type="button" value="添加行"><input style="margin-left:10px;" onclick="fnOffServiceDate(this, <?php echo $v->id;?>);" class="btn" type="button" value="下架"><input type="hidden" name="timeoff[]" value=""></td>
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
                    <tr class="gift_item" id="gift_item_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>">
                        <td><?php echo $v->service_datatime_start;?><br>至<br><?php echo $v->service_datatime_end;?></td>
                        <td>
                            <table data-num="new" class="showinfo">
                                <?php if(!empty($v->gift_association)){?>
                                <?php foreach($v->gift_association as $v2){?>
                                <tr id="gift_item_<?php echo $v->id;?>_<?php echo $v2->relation_id;?>">
                                    <td width="60%">
                                        <?php echo $v2->relation_name;?>
                                    </td>
                                    <td><?php echo $v2->relation_num;?></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <?php }?>
                                <?php }?>
                            </table>
                        </td>
                        <td style="text-align:left;">&nbsp;</td></tr>
                    <?php }?>
                    <?php }?>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <div class="mt15">
            <table class="table-title">
                <tr>
                    <td>审核信息</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model, 'if_dispay'); ?></td>
                    <td width="35%">
                        <?php echo $form->radioButtonList($model, 'if_dispay', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'if_dispay'); ?>
                    </td>
                    <td width="15%">&nbsp;</td>
                    <td width="35%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model, 'state'); ?></td>
                    <td width="35%">
                        <?php echo $form->radioButtonList($model, 'state', Chtml::listData(BaseCode::model()->getCode(370), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'state'); ?>
                    </td>
                    <td width="15%"><?php echo $form->labelEx($model, 'reasons_for_failure'); ?></td>
                    <td width="35%">
                        <?php echo $form->textArea($model, 'reasons_for_failure', array('class' => 'input-text' ,'value'=>'')); ?>
                        <?php echo $form->error($model, 'reasons_for_failure', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="box-detail-submit"><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button><button onclick="submitType='shenhe'" class="btn btn-blue" type="submit">提交审核</button><button class="btn" type="button" onclick="we.back();">取消</button></div>
        <table class="showinfo">
            <tr>
                <th style="width:20%;">操作时间</th>
                <th style="width:20%;">操作人</th>
                <th style="width:20%;">状态</th>
                <th>操作备注</th>
            </tr>
            <tr>
                <td><?php if($model->state!=371 && $model->state!=''){ echo $model->uDate; } ?></td>
                <td><?php if($model->state!=371 && $model->state!=''){ echo $model->detail_gfname; } ?></td>
                <td><?php if(isset($model->base_code->F_NAME) && $model->state!=371 && $model->state!=''){ echo $model->base_code->F_NAME; }?></td>
                <td><?php if($model->state!=371 && $model->state!=''){ echo $model->reasons_for_failure; } ?></td>
            </tr>
        </table>
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
var submitType='tijiao'
objLimitTime=new Object();
<?php if(!empty($model->club_service_detailed)){?>
<?php foreach($model->club_service_detailed as $v){?>
    objLimitTime[<?php echo $v->id;?>]=['<?php echo $v->service_datatime_start;?>','<?php echo $v->service_datatime_end;?>', '1'];
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
var club_id=<?php echo $model->club_id;?>;
var service_person_id=<?php if(isset($person) && $person!=null){ echo $person->id; }else{ echo '0'; }?>;
var service_person_type_code=<?php if(isset($person) && $person!=null){ echo $person->mall_products_type_sname->id; }else{ echo '0'; }?>;
var service_person_project_id=<?php if(isset($person) && $person!=null){ echo $person->project_id; }else{ echo '0'; }?>;
var service_person_project_name='<?php if(isset($person) && $person!=null){ echo $person->project_name; }?>';
var service_place_id=<?php if(isset($place) && $place!=null){ echo $place->id; }else{ echo '0'; }?>;
var project_id=<?php if($model->project_id!=''){ echo $model->project_id; }else{ echo '0'; } ?>;

// 滚动图片处理
var $ClubServiceData_service_pic_img=$('#ClubServiceData_service_pic_img');
var $upload_pic_ClubServiceData_service_pic_img=$('#upload_pic_ClubServiceData_service_pic_img');
var $upload_box_ClubServiceData_service_pic_img=$('#upload_box_ClubServiceData_service_pic_img');

// 添加或删除时，更新图片
var fnUpdateServicePic=function(){
    var arr=[];
    $upload_pic_ClubServiceData_service_pic_img.find('a').each(function(){
        arr.push($(this).attr('data-savepath'));
    });
    $ClubServiceData_service_pic_img.val(we.implode(',',arr));
    if(arr.length>=5){
        $upload_box_ClubServiceData_service_pic_img.hide();
    }else{
        $upload_box_ClubServiceData_service_pic_img.show();
    }
};

// 上传完成时图片处理
var fnServicePic=function(savepth,allpath){
    $upload_pic_ClubServiceData_service_pic_img.append('<a class="picbox" data-savepath="'+savepth+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdateServicePic();return false;"></i></a>');
    fnUpdateServicePic();
};

// 项目添加或删除时，更新
var $ClubServiceData_project_id=$('#ClubServiceData_project_id');
var $project_box=$('#project_box');

// 初始化时间，用于计算有效期限
var all_start_date='<?php if(isset($person) && isset($place)){ if(strtotime($person->start_date)>strtotime($place->site_date_start)){ echo $person->start_date; }else{ echo $place->site_date_start; } }elseif(isset($person) && $person!=null){ echo $person->start_date; }elseif(isset($place) && $place!=null){ echo $place->site_date_start; }?>';
var all_end_date='<?php if(isset($person) && isset($place)){ if(strtotime($person->end_date)>strtotime($place->site_date_end)){ echo $place->site_date_end; }else{ echo $person->end_date; } }elseif(isset($person) && $person!=null){ echo $person->end_date; }elseif(isset($place) && $place!=null){ echo $place->site_date_end; }?>';
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
    if($dp!=undefined){ $dp.minDate=all_start_date;$dp.maxDate=all_end_date; }
    WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',realDateFmt:'yyyy-MM-dd HH:mm:ss',minDate:all_start_date,maxDate:all_end_date,onpicked:function(dp){
        //$dp.cal.minDate=all_start_date;$dp.cal.maxDate=all_end_date;
        // 判断时间是否在有效范围内
        //console.log(dp.cal.getNewDateStr());return false;
        var time=strtotime(dp.cal.getNewDateStr());
        var current_id=$(op).parent().parent().attr('data-id');
        $timelist.find('.item').each(function(){
            var $this=$(this);
            var this_id=$this.attr('data-id');
            //对比已经发布的时间
            if(!isNaN(parseInt(this_id))){
                for(var i in objLimitTime){
                    if(time>strtotime(objLimitTime[i][0]) && time<strtotime(objLimitTime[i][1])){
                        we.msg('minus', '服务时间与现有时间冲突');
                        $(op).val('');
                        return false;
                    }
                }
            }else if(current_id!=this_id){
                //对比已经新添加的时间
                var $input=$this.find('input');
                var input_start=$input.eq(0).val();
                var input_end=$input.eq(1).val();
                //console.log($input.eq(0).val());
                if(input_start!='' && input_end!='' && time>strtotime(input_start) && time<strtotime(input_end)){
                    we.msg('minus', '服务时间与现有时间冲突');
                    $(op).val('');
                    return false;
                }
            }
        });
        //console.log(current_id);
    }});
};

// 添加服务时间
var fnAddServiceDate=function(){
    var timelist_num=$timelist.attr('data-num')+1;
    var html='<tr class="item" data-id="'+timelist_num+'">'+
        '<td><input style="width:80%;" class="service-date input-text" type="text" name="timelist['+timelist_num+'][start_date]" value="" onclick="fnSetDate(this);" readonly></td>'+
        '<td><input style="width:80%;" class="service-date input-text" type="text" name="timelist['+timelist_num+'][end_date]" value="" onclick="fnSetDate(this);" readonly></td>'+
        '<td><input style="width:30%;" class="service-date-num input-text" type="text" name="timelist['+timelist_num+'][num]" value=""></td>'+
        '<td style="text-align:left;"><input onclick="fnAddServiceDate();" class="btn" type="button" value="添加行"><input style="margin-left:10px;" onclick="fnRemoveServiceDate(this);" class="btn" type="button" value="删除行"></td>'+
    '</tr>';
    $timelist.attr('data-num',timelist_num);
    $timelist.append(html);
};

// 删除服务时间
var fnRemoveServiceDate=function(op){
    $(op).parent().parent().remove();
};

// 下架服务时间
var fnOffServiceDate=function(op, id){
    var $this=$(op);
    var $tr=$this.parent().parent();
    var $offinput=$this.next('input');
    var dataid=$tr.attr('data-id');
    var $giftitem=$('#gift_item_'+dataid);
    if($tr.hasClass('itemoff')){
        $tr.removeClass('itemoff');
        $this.val('下架');
        $offinput.val('');
        $giftitem.removeClass('itemoff');
        objLimitTime[id][2]=1;
    }else{
        $tr.addClass('itemoff');
        $this.val('已下架');
        $offinput.val(id);
        $giftitem.addClass('itemoff');
        objLimitTime[id][2]=0;
    }
    //console.log(objLimitTime);
};


// 根据服务时间生成服务赠品
var $giftlist=$('#giftlist');
var fnUpdateGiftList=function(){
    var num;
    var $this;
    var arrTime=[];
    var arrGift=[];
    $timelist.find('.item').each(function(){
        $this=$(this);
        num=$this.attr('data-id');
        if($('#gift_item_'+num).length==0){
           $giftlist.append('<tr class="gift_item" id="gift_item_'+num+'" data-id="'+num+'">'+
                '<td>'+$this.find('input').eq(0).val()+'<br>至<br>'+$this.find('input').eq(1).val()+'</td>'+
                '<td>'+
                    '<table data-num="'+num+'" class="showinfo">'+
                    '</table>'+
                '</td>'+
                '<td style="text-align:left;"><input onclick="fnAddGift(this);" class="btn" type="button" value="添加赠品"></td></tr>'); 
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
    

    // 选择单位
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
                //console.log($.dialog.data('club_id'));
                if($.dialog.data('club_id')>0){
                    if($.dialog.data('club_id')!=club_id){fnResetDataId();}
                    $ClubServiceData_club_id.val($.dialog.data('club_id')).trigger('blur');
                    club_id=$.dialog.data('club_id');
                    $club_box.html('<span class="label-box">'+$.dialog.data('club_title')+'</span>');
                }
            }
        });
    });
    
    // 选择项目
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
                    if($('#project_item_'+$.dialog.data('project_id')).length==0){
                       project_id=$.dialog.data('project_id');
                       $ClubServiceData_project_id.val(project_id);
                       $project_box.html('<span class="label-box" id="project_item_'+$.dialog.data('project_id')+'" data-id="'+$.dialog.data('project_id')+'">'+$.dialog.data('project_title')+'</span>'); 
                    }
                }
            }
        });
    });
    
    // 选择服务类型
    $ClubServiceData_type_code.on('change', function(){
        fnUpdateDataId();
    });
    
    // 选择服务者
    $('#service_person_btn').on('click', function(){
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

        $.dialog.data('service_person_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/servicePerson");?>'+'&club_id='+club_id+'&project_id='+project_id,{
            id:'fuwuzhe',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                //console.log($.dialog.data('club_id'));
                if($.dialog.data('service_person_id')>0){
                    service_person_id=$.dialog.data('service_person_id');
                    service_person_type_code=$.dialog.data('service_person_type_code');
                    person_start_date=$.dialog.data('service_person_start_date');
                    person_end_date=$.dialog.data('service_person_end_date');
                    $ClubServiceData_type_code_person.val(service_person_type_code);
                    $service_person_box.html('<span class="label-box">'+$.dialog.data('service_person_title')+'</span>');
                    if($('#project_item_'+$.dialog.data('service_person_project_id')).length==0){
                       service_person_project_id=$.dialog.data('service_person_project_id');
                       service_person_project_name=$.dialog.data('service_person_project_name');
                    }
                    fnUpdateDataId();
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
</script>