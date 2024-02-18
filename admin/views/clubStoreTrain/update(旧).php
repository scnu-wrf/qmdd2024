

<div class="box">
    <div class="box-title c">
    <h1><i class="fa fa-table"></i>详细详情</h1>
    <span class="back">
    <a class="btn" href="javascript:;" onclick="we.back();">
    <i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">

           <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <div class="box-detail-tab">
            <ul class="c">
                <li class="current">基本信息</li>
                <li>培训描述</li>
                <li>套餐清单</li>
                <li>报名须知</li>
            </ul>
        </div><!--box-detail-tab end-->
    

            
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table border="0" cellspacing="1" cellpadding="0" class="product_publish_content">
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'train_code'); ?></td>
                        <td width="85%" colspan="3"><?php echo $model->train_code;?></td>
                    </tr>

                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'train_title'); ?></td>
                        <td width="35%"><?php echo $form->textField($model, 'train_title', array('class' => 'input-text')); ?></td>
                        <td width="15%"><?php echo $form->labelEx($model, 'train_clubid'); ?></td>
                        <td width="35%">
                            <span id="club_box"><?php if($model->train_clubid!=null){?><span class="label-box"><?php echo $model->train_clubname;?><?php echo $form->hiddenField($model, 'train_clubid', array('class' => 'input-text')); ?></span><?php } else {?><span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'train_clubid', array('class' => 'input-text','value'=>get_session('club_id'))); ?></span><?php } ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'train_type1_id'); ?></td>
                        <td>
                        <?php echo $form->dropDownList($model, 'train_type1_id', Chtml::listData(MallProductsTypeSname::model()->getCode(181), 'id', 'sn_name'), array('prompt'=>'请选择')); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'train_type2_id'); ?></td>
                        <td>
                        <?php echo $form->dropDownList($model, 'train_type2_id', Chtml::listData(BaseCode::model()->getCode(383), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                        </td>
                    </tr>

                     
                    <tr>
                        <td><?php echo $form->labelEx($model, 'train_phone'); ?></td>
                        <td><?php echo $form->textField($model, 'train_phone', array('class' => 'input-text','maxlength'=>'11')); ?>
                        <?php echo $form->error($model, 'train_phone', $htmlOptions = array()); ?>
                        </td>    
                        <td><?php echo $form->labelEx($model, 'if_train_live'); ?></td><!---->
                        <td>
                            <?php echo $form->dropDownList($model, 'if_train_live', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                        </td>
                    </tr>
                    <tr>
                        
                        <td><?php echo $form->labelEx($model, 'train_project_id'); ?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'train_project_id', array('class' => 'input-text')); ?>
                            <span id="project_box"><?php if($model->project_list!=null){?><span class="label-box" id="project_item_<?php echo $model->train_project_id;?>" data-id="<?php echo $model->train_project_id;?>"><?php echo $model->project_list->project_name;?></span><?php }?></span>
                            <input id="project_add_btn" class="btn" type="button" value="选择">
                            <?php echo $form->error($model, 'train_project_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'train_buy_start'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'train_buy_start', array('class' => 'input-text')); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'train_buy_end'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'train_buy_end', array('class' => 'input-text')); ?>
                        </td> 
                    </tr>
<tr>
                        <td><?php echo $form->labelEx($model, 'train_start'); ?></td>
                        <td><?php echo $form->textField($model, 'train_start', array('class' => 'input-text')); ?></td>
                        <td><?php echo $form->labelEx($model, 'train_end'); ?></td>
                        <td><?php echo $form->textField($model, 'train_end', array('class' => 'input-text')); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'dispay_start_time'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'dispay_start_time', array('class' => 'input-text')); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'dispay_end_time'); ?></td>
                        <td id="dt_dispay_end_time">
                            <?php echo $form->textField($model, 'dispay_end_time', array('class' => 'input-text')); ?>
                        </td> 
                    </tr>
                    

                     <tr>
                        <td><?php echo $form->labelEx($model, 'train_address'); ?></td>
                        <td colspan="3" id="d_train_address">
                            <?php echo $form->textField($model, 'train_address', array('class' => 'input-text')); ?>
                            <?php echo $form->hiddenField($model, 'longitude'); ?>
                            <?php echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'train_address', $htmlOptions = array()); ?>
                        </td>
                    </tr>
 
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'train_logo'); ?></td>
                        <td colspan="3" id="dpic_train_logo">
                            <?php echo $form->hiddenField($model, 'train_logo', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(133);$picprefix='';
                            if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->train_logo!=''){?>
                             <div class="upload_img fl" id="upload_pic_ClubStoreTrain_train_logo">
                             <a href="<?php echo $basepath->F_WWWPATH.$model->train_logo;?>" target="_blank">
                             <img src="<?php echo $basepath->F_WWWPATH.$model->train_logo;?>" width="100"></a></div>
                             <?php }?>
                             <input style="margin-left:5px;" id="picture_select_btn" class="btn" type="button" value="图库选择" >
                            <script>we.uploadpic('<?php echo get_class($model);?>_train_logo','<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'train_logo', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'train_pic'); ?></td>
                        <td colspan="3" id="dpicm_train_pic">
                            <?php echo $form->hiddenField($model, 'train_pic', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(223);$picprefix='';
                            if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php
                             if($model->train_pic!=''){
                                ?>
                             <div class="upload_img fl" id="upload_pic_ClubStoreTrain_train_pic">
                             <a href="<?php echo $basepath->F_WWWPATH.$model->train_pic;?>" target="_blank">
                             <img src="<?php echo $basepath->F_WWWPATH.$model->train_pic;?>" width="100"></a></div>
                             <?php }?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_train_pic','<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'train_pic', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                        
              </table>
        </div><!--box-detail-tab-item end-->
            
        <div style="display:none;" class="box-detail-tab-item"><!--培训描述开始-->
            <?php echo $form->hiddenField($model, 'train_description_temp', array('class' => 'input-text')); ?>
            <script>we.editor('<?php echo get_class($model);?>_train_description_temp', '<?php echo get_class($model);?>[train_description_temp]');</script>
            <?php echo $form->error($model, 'train_description_temp', $htmlOptions = array()); ?>
            
        </div><!--box-detail-tab-item end-->
        
        <div style="display:none;" class="box-detail-tab-item"><!--套餐清单开始-->
            <?php echo $form->hiddenField($model, 'train_info_temp', array('class' => 'input-text')); ?>
            <script>we.editor('<?php echo get_class($model);?>_train_info_temp', '<?php echo get_class($model);?>[train_info_temp]');</script>
            <?php echo $form->error($model, 'train_info_temp', $htmlOptions = array()); ?>
            
        </div><!--box-detail-tab-item end-->
        
        <div style="display:none;" class="box-detail-tab-item"><!--报名须知开始-->
            <?php echo $form->hiddenField($model, 'train_sign_declare_temp', array('class' => 'input-text')); ?>
            <script>we.editor('<?php echo get_class($model);?>_train_sign_declare_temp', '<?php echo get_class($model);?>[train_sign_declare_temp]');</script>
            <?php echo $form->error($model, 'train_sign_declare_temp', $htmlOptions = array()); ?>
            
        </div><!--box-detail-tab-item end-->
    </div><!--box-detail-bd end-->
    <div class="mt15">  
         <table>
            <tr  class="table-title"> 
                <td colspan="4">审核信息</td>
            </tr>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'reasons_for_failure'); ?></td>
                <td width="85%" colspan="3">
                   <?php echo $form->textArea($model, 'reasons_for_failure', array('class' => 'input-text' )); ?>
                    <?php echo $form->error($model, 'reasons_for_failure', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td>可执行操作</td>
<td colspan="3">
<?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核','tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
    <!--button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
    <button onclick="submitType='shenhe'" class="btn btn-blue" type="submit">提交审核</button>
    <button onclick="submitType='tongguo'" class="btn btn-blue" type="submit">审核通过</button>
    <button onclick="submitType='butongguo'" class="btn btn-blue" type="submit">审核不通过</button-->
    <button class="btn" type="button" onclick="we.back();">取消</button>
</td>
            </tr>
        </table>
         <table class="showinfo">
            <tr>
                <th style="width:20%;">操作时间</th>
                <th style="width:20%;">操作人</th>
                <th style="width:20%;">状态</th>
                <th>操作备注</th>
            </tr>
            <tr>
                <td><?php echo $model->uDate; ?></td>
                <td><?php echo $model->train_gfname; ?></td>
                <td><?php echo $model->train_state_name; ?></td>
                <td><?php echo $model->reasons_for_failure; ?></td>
            </tr>
          </table>
       </div>    
    </div>       
    <?php $this->endWidget(); ?>
     </div><!--box-table end-->
    </div><!--box-content end-->
   <div id="dialog2" title="百度地图" style="display: none;"></div>

<script>
    we.tab('.box-detail-tab li','.box-detail-tab-item',function(index){
        if(index==4){
        }
        return true;
    });
	
	//从图库选择图片
var $Single=$('#ClubStoreTrain_train_logo');
    $('#picture_select_btn').on('click', function(){
		var club_id=$('#ClubStoreTrain_train_clubid').val();
        $.dialog.data('app_icon', 0);
        $.dialog.open('<?php echo $this->createUrl("gfMaterial/materialPictureAll", array('type'=>252,'fd'=>49));?>&club_id='+club_id,{
            id:'picture',
            lock:true,
            opacity:0.3,
            title:'请选择素材',
            width:'100%',
            height:'90%',
            close: function () {
                if($.dialog.data('material_id')>0){
                    $Single.val($.dialog.data('app_icon')).trigger('blur');

                    $('#upload_pic_ClubStoreTrain_train_logo').html('<a href="<?php echo $basepath->F_WWWPATH;?>'+art.dialog.data('app_icon')
                    +'" target="_blank"> <img src="<?php echo $basepath->F_WWWPATH;?>'+art.dialog.data('app_icon')
                    +'"  width="100"></a>');

                   // $('#Gfapp_app_icon_x').val($.dialog.data('dataX')).trigger('blur');
                    //$('#Gfapp_app_icon_y').val($.dialog.data('dataY')).trigger('blur');
                    //$('#Gfapp_app_icon_w').val($.dialog.data('dataWidth')).trigger('blur');
                    //$('#Gfapp_app_icon_h').val($.dialog.data('dataHeight')).trigger('blur');
               }

            }
        });
    });
    
    //var train_clubid=0;

    $('#ClubStoreTrain_train_start').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
    $('#ClubStoreTrain_train_end').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss '});});
    
    $('#ClubStoreTrain_train_buy_start').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
    $('#ClubStoreTrain_train_buy_end').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
    
    $('#ClubStoreTrain_dispay_start_time').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
    $('#ClubStoreTrain_dispay_end_time').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});



    // 滚动图片处理
    var $train_pic=$('#ClubStoreTrain_train_pic');
    var $upload_pic_train_pic=$('#upload_pic_train_pic');
    
    // 添加或删除时，更新图片
    var fnUpdatescrollPic=function(){
        var arr1=[];
        $upload_pic_train_pic.find('a').each(function(){
            arr1.push($(this).attr('data-savepath'));
        });
        $train_pic.val(we.implode(',',arr1));
        $upload_box_scroll_pic_img.show();
        // if(arr1.length>=5) {
        //     $upload_box_scroll_pic_img.hide();
        // }
    };
    // 上传完成时图片处理
    var fnscrollPic=function(savename,allpath){
        $upload_pic_train_pic.append('<a class="picbox" data-savepath="'+
        savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i></a>');
        fnUpdatescrollPic();
    };


   

$(function(){

    // 选择服务地区
    var $ClubStoreTrain_train_address=$('#ClubStoreTrain_train_address');
    var $ClubStoreTrain_longitude=$('#ClubStoreTrain_Longitude');
    var $ClubStoreTrain_latitude=$('#ClubStoreTrain_latitude');
    $ClubStoreTrain_train_address.on('click', function(){
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
                    $ClubStoreTrain_train_address.val($.dialog.data('maparea_address'));
                    $ClubStoreTrain_longitude.val($.dialog.data('maparea_lng'));
                    $ClubStoreTrain_latitude.val($.dialog.data('maparea_lat'));
                }
            }
        });
    });

    
    // 选择单位
    var $club_box=$('#club_box');
    var $ClubStoreTrain_train_clubid=$('#ClubStoreTrain_train_clubid');
    $('#club_select_btn').on('click', function(){
        $.dialog.data('club_id', 0);
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
                    club_id=$.dialog.data('club_id');
                    $ClubStoreTrain_train_clubid.val($.dialog.data('club_id')).trigger('blur');
                    $club_box.html('<span class="label-box">'+$.dialog.data('club_title')+'</span>');
                }
            }
        });
    });
    
    // 项目添加或删除时，更新
    var $ClubStoreTrain_train_project_id=$('#ClubStoreTrain_train_project_id');
    var $project_box=$('#project_box');
    
    // 选择项目
    var $project_add_btn=$('#project_add_btn');
    $project_add_btn.on('click', function(){
		var club_id=$('#ClubStoreTrain_train_clubid').val();
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
                    if($('#project_item_'+$.dialog.data('project_id')).length==0){
                       project_id=$.dialog.data('project_id');
                    $ClubStoreTrain_train_project_id.val($.dialog.data('project_id')).trigger('blur');
                       $project_box.html('<span class="label-box" id="project_item_'+$.dialog.data('project_id')+'" data-id="'+$.dialog.data('project_id')+'">'+$.dialog.data('project_title')+'</span>'); 
                    }
                }
            }
        });
    });
});  
</script> 
