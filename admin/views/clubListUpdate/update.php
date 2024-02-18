<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>单位信息</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">基本信息</li>
                <li>其它信息</li>
                <li>关于我们</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                	<tr class="table-title">
                    	<td colspan="4">申请信息</td>
                    </tr>
                	<tr>
                    	<td width="15%"><?php echo $form->labelEx($model, 'club_code'); ?></td>
                        <td width="35%"><?php echo $model->club_code;?></td>
                        <td width="15%"><?php echo $form->labelEx($model, 'financial_code'); ?></td>
                        <td width="35%">
                            <?php echo $form->textField($model, 'financial_code', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'financial_code', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                    	<td><?php echo $form->labelEx($model, 'club_logo_pic'); ?></td>
                        <td>
                        <div style="width:70px; height:70px;overflow:hidden;float:left">
							<?php echo $form->hiddenField($model, 'club_logo_pic', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(123);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->club_logo_pic!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_club_logo_pic"><a href="<?php echo $basepath->F_WWWPATH.$model->club_logo_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->club_logo_pic;?>" width="100"></a></div><?php }?> 
                         </div>
                            <script>we.uploadpic('<?php echo get_class($model);?>_club_logo_pic', '<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'club_logo_pic', $htmlOptions = array()); ?>
                   
                        </td>
                        <td><?php echo $form->labelEx($model, 'club_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'club_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'club_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                    	<td><?php echo $form->labelEx($model, 'individual_enterprise'); ?></td>
                        <td>
                            <?php echo $form->radioButtonList($model, 'individual_enterprise', Chtml::listData(BaseCode::model()->getCode(402), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'individual_enterprise'); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'apply_club_gfaccount'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'apply_club_gfaccount', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'apply_club_gfaccount', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                    	<td><?php echo $form->labelEx($model, 'company'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'company', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'company', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'organization_code'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'organization_code', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'organization_code', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                    	<td><?php echo $form->labelEx($model, 'certificates_number'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'certificates_number', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'certificates_number', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'valid_until'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'valid_until', array('class' => 'input-text', 'style'=>'width:100px;')); ?>
                            <?php echo $form->error($model, 'valid_until', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                    	<td><?php echo $form->labelEx($model, 'club_address'); ?></td>
                    	<td>
                        	<?php echo $form->textField($model, 'club_address', array('class' => 'input-text')); ?>
                            <?php echo $form->hiddenField($model, 'Longitude'); ?>
                            <?php echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'club_address', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'apply_time'); ?></td>
                   	  <td><?php echo $model->apply_time;?></td>
                    </tr>
                    <tr>
                    	<td><?php echo $form->labelEx($model, 'club_type'); ?></td>
                        <td>
                        	<?php echo $form->dropDownList($model, 'club_type', Chtml::listData(BaseCode::model()->getClubtype(), 'f_id', 'F_NAME'), 
                               array('prompt'=>'请选择','onchange' =>'selectOnchang(this)'));
                              $arr=BaseCode::model()->getClub_type2();
                         ?>
<script> // html5中默认的script是javascript,故不需要特别指定script language 
var $d_club_type2= <?php echo json_encode($arr)?>;
</script> 

                            <?php echo $form->error($model, 'club_type', $htmlOptions = array()); ?>
                            <?php echo $form->dropDownList($model, 'partnership_type', Chtml::listData(BaseCode::model()->getClub_type2_all(), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'partnership_type', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'management_category'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'management_category', array('class' => 'input-text')); ?>
                            <span id="classify_box">
                            <?php foreach($management_category as $v){?><span class="label-box" id="classify_item_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>"><?php echo $v->name;?><i onclick="fnDeleteClassify(this);"></i></span><?php } ?></span>
                            <input id="classify_add_btn" class="btn" type="button" value="添加分类">
                            <?php echo $form->error($model, 'management_category', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                    	<td><?php echo $form->labelEx($model, 'certificates'); ?></td>
                        <td  colspan="3">
                        <div>
							<?php echo $form->hiddenField($model, 'certificates', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(219);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->certificates!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_certificates"><a href="<?php echo $basepath->F_WWWPATH.$model->certificates;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->certificates;?>" style="max-height:100px; max-width:100px;"></a></div><?php }?>
                        </div>
                            <script>we.uploadpic('<?php echo get_class($model);?>_certificates', '<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'certificates', $htmlOptions = array()); ?>
                        
                        </td>
                    </tr>
                    <tr><!--此外为多国，链接club_list_pic表-->
                        <td><?php echo $form->labelEx($model, 'club_list_pic'); ?></td>

                        <td colspan="3">
                        <div>
                            <?php echo $form->hiddenField($model, 'club_list_pic', array('class' => 'input-text')); ?>
                            <div class="upload_img fl" id="upload_pic_club_list_pic" >
                            <?php $basepath=BasePath::model()->getPath(187);$picprefix=''; if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
								if(!empty($club_list_pic)){
                                if(is_array($club_list_pic)) foreach($club_list_pic as $v) { ?>
                                <a class="picbox" data-savepath="<?php  echo $v['club_aualifications_pic'];?>" 
                                href="<?php  echo $basepath->F_WWWPATH.$v['club_aualifications_pic'];?>" target="_blank">
                                <img src="<?php echo $basepath->F_WWWPATH.$v['club_aualifications_pic'];?>" style="max-height:100px; max-width:100px;">
                                <i onclick="$(this).parent().remove();fnUpdateClub_list_pic();return false;"></i></a>
                                <?php }?>
                                <?php }?>
                            </div>
                        </div>
							<script>
                                  
                                 we.uploadpic('<?php echo get_class($model);?>_club_list_pic','<?php echo $picprefix;?>','','',function(e1,e2){fnClub_list_pic(e1.savename,e1.allpath);},5);
                            </script>
                        
                            <?php echo $form->error($model, 'club_list_pic', $htmlOptions = array()); ?>
                           
                        </td>
                    </tr>
                </table>
                <div class="mt15">
                <table style='margin-top:5px;'>
                	<tr class="table-title">
                    	<td colspan="2" >法人信息</td>
                    </tr>
                    <tr>
                    	<td width="15%"><?php echo $form->labelEx($model, 'apply_club_gfnick'); ?></td>
                    	<td width="85%">
                             <?php echo $form->textField($model, 'apply_club_gfnick', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'apply_club_gfnick', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'apply_club_phone'); ?></td>
                    	<td>
                            <?php echo $form->textField($model, 'apply_club_phone', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'apply_club_phone', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                    	<td><?php echo $form->labelEx($model, 'apply_club_email'); ?></td>
                    	<td>
                            <?php echo $form->textField($model, 'apply_club_email', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'apply_club_email', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                    	<td><?php echo $form->labelEx($model, 'apply_club_id_card'); ?></td>
                    	<td>
                            <?php echo $form->textField($model, 'apply_club_id_card', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'apply_club_id_card', $htmlOptions = array()); ?>
                        </td>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'id_card_face'); ?></td>
                        <td>
                         <div style="width:70px; height:70px;overflow:hidden;float:left">
                            <?php echo $form->hiddenField($model, 'id_card_face', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(214);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->id_card_face!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_id_card_face"><a href="<?php echo $basepath->F_WWWPATH.$model->id_card_face;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->id_card_face;?>" width="100"></a></div><?php }?>
                         </div>
                    	<script>we.uploadpic('<?php echo get_class($model);?>_id_card_face', '<?php echo $picprefix;?>');</script>
                        <?php echo $form->error($model, 'id_card_face', $htmlOptions = array()); ?>
                         
                        </td>
                    </tr>
                </table>
                </div>
                <div class="mt15">
                <table style='margin-top:5px;'>
                	<tr class="table-title">
                    	<td colspan="2">联系人信息</td>
                    </tr>
                    <tr>
                    	<td  width="15%"><?php echo $form->labelEx($model, 'apply_name'); ?></td>
                    	<td width="85%">
                            <?php echo $form->textField($model, 'apply_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'apply_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'contact_phone'); ?></td>
                    	<td>
                            <?php echo $form->textField($model, 'contact_phone', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'contact_phone', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                    	<td><?php echo $form->labelEx($model, 'email'); ?></td>
                    	<td>
                            <?php echo $form->textField($model, 'email', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'email', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                    	<td><?php echo $form->labelEx($model, 'apply_id_card'); ?></td>
                    	<td>
                            <?php echo $form->textField($model, 'apply_id_card', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'apply_id_card', $htmlOptions = array()); ?>
                        </td>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'contact_id_card_back'); ?></td>
                        <td>
                        <div style="width:70px; height:70px;overflow:hidden;">
                            <?php echo $form->hiddenField($model, 'contact_id_card_back', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(218);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->contact_id_card_back!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_contact_id_card_back"><a href="<?php echo $basepath->F_WWWPATH.$model->contact_id_card_back;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->contact_id_card_back;?>" width="70"></a></div><?php }?>
                        </div>
                    	<script>we.uploadpic('<?php echo get_class($model);?>_contact_id_card_back', '<?php echo $picprefix;?>');</script>
                        <?php echo $form->error($model, 'contact_id_card_back', $htmlOptions = array()); ?>
                        
                        </td>
                    </tr>
                </table>
                </div>
                <div class="mt15">
                <table>
                	<tr class="table-title">
                    	<td colspan="2">银行信息</td>
                    </tr>
                    <tr>
                    	<td width="15%"><?php echo $form->labelEx($model, 'bank_name'); ?></td>
                    	<td width="85%">
                            <?php echo $form->textField($model, 'bank_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'bank_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'bank_branch_name'); ?></td>
                    	<td>
                            <?php echo $form->textField($model, 'bank_branch_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'bank_branch_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                    	<td><?php echo $form->labelEx($model, 'bank_account'); ?></td>
                    	<td>
                            <?php echo $form->textField($model, 'bank_account', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'bank_account', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                </div>
                
                <div class="mt15">
                <table>
                	<tr class="table-title">
                    	<td colspan="4">推荐单位信息</td>
                    </tr>
                    <tr>
                    	<td><?php echo $form->labelEx($model, 'recommend'); ?></td>
                    	<td colspan="3">                            
                        	<?php echo $model->recommend_clubname;?>
                         </td>
                    </tr>
                </table>
                </div>

            </div><!--box-detail-tab-item end   style="display:block;"-->
            <div class="box-detail-tab-item"  style="display:none;">
            	<table>
                    <tr class="table-title">
                    	<td colspan="2" >其他信息</td>
                    </tr>
                	<tr>
                    	<td width="15%"><?php echo $form->labelEx($model, 'news_clicked'); ?></td>
                        <td><?php echo $model->news_clicked;?></td>
                    </tr>
                    <tr>
                    	<td><?php echo $model->getAttributeLabel('book_club_num');?></td>
                        <td><?php echo $model->book_club_num;?></td>
                    </tr>
                    <tr>
                    	<td><?php echo $model->getAttributeLabel('club_credit');?></td>
                        <td><?php echo $model->club_credit;?></td>
                    </tr>
                    <tr>
                    	<td><?php echo $model->getAttributeLabel('beans');?></td>
                        <td><?php echo $model->beans;?></td>
                    </tr>
                    <tr>
                    	<td><?php echo $model->getAttributeLabel('isRecommend');?></td>
                        <td>
                        	<?php echo $form->radioButtonList($model, 'isRecommend', Chtml::listData(BaseCode::model()->getCode(515), 'f_id', 'F_SHORTNAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                            <span class="msg">注：是否推荐显示在手机/网页单位列表上</span>
                            <?php echo $form->error($model, 'isRecommend', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                    	<td><?php echo $model->getAttributeLabel('dispay_xh');?></td>
                        <td>
						<?php echo $form->textField($model, 'dispay_xh', array('class' => 'input-text','style'=>'width:200px')); ?>
                        <span class="msg">注：显示序号，值越大排序越大前面，不填写默认排序</span>
                        </td>
                    </tr>

                </table>

            </div><!--box-detail-tab-item end-->
            <div class="box-detail-tab-item"  style="display:none;"><!--关于我们开始-->
            	<?php echo $form->hiddenField($model, 'about_me_temp', array('class' => 'input-text')); ?>
				<script>we.editor('<?php echo get_class($model);?>_about_me_temp', '<?php echo get_class($model);?>[about_me_temp]');</script>
                <?php echo $form->error($model, 'about_me_temp', $htmlOptions = array()); ?>
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
                    <td width='15%'><?php echo $form->labelEx($model, 'reasons_for_failure'); ?></td>
                    <td width='85%'>
                        <?php echo $form->textArea($model, 'reasons_for_failure', array('class' => 'input-text' ,'value'=>'')); ?>
                        <?php echo $form->error($model, 'reasons_for_failure', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                	<td>可执行操作</td>
                    <td>
                        <?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核','tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                    <!--button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
                    <button onclick="submitType='shenhe'" class="btn btn-blue" type="submit">提交审核</button>
                    <button onclick="submitType='tongguo'" class="btn btn-blue" type="submit">审核通过</button>
                    <button onclick="submitType='butongguo'" class="btn btn-blue" type="submit">审核不通过</button-->
                    <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div>
        <table class="showinfo">
            <tr>
                <th style="width:20%;">操作时间</th>
                <th style="width:20%;">操作人</th>
                <th style="width:20%;">审核状态</th>
                <th>操作备注</th>
            </tr>
            <tr>
                <td><?php echo $model->uDate; ?></td>
                <td><?php echo $model->reasons_adminname; ?></td>
                <td><?php echo $model->state_name; ?></td>
                <td><?php echo $model->reasons_for_failure; ?></td>
            </tr>
        </table>
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
we.tab('.box-detail-tab li','.box-detail-tab-item',function(index){
    if(index==3){
    }
    return true;
});


$('#ClubList_valid_until').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });

// 滚动图片处理
var $club_list_pic=$('#ClubList_club_list_pic');
var $upload_pic_club_list_pic=$('#upload_pic_club_list_pic');
var $upload_box_club_list_pic=$('#upload_box_Club_list_pic');

// 添加或删除时，更新图片
var fnUpdateClub_list_pic=function(){
    var arr=[];
    $upload_pic_club_list_pic.find('a').each(function(){
        arr.push($(this).attr('data-savepath'));
    });
    $club_list_pic.val(we.implode(',',arr));
    $upload_box_club_list_pic.show();
    if(arr.length>=5) {
        $upload_box_club_list_pic.hide();
    }
};
// 上传完成时图片处理
var fnClub_list_pic=function(savename,allpath){
    $upload_pic_club_list_pic.append('<a class="picbox" data-savepath="'+
    savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdateClub_list_pic();return false;"></i></a>');
    fnUpdateClub_list_pic();
};

// 删除分类
var $classify_box=$('#classify_box');
var $ClubList_management_category=$('#ClubList_management_category');
var fnUpdateClassify=function(){
    var arr=[];
    var id;
    $classify_box.find('span').each(function(){
        id=$(this).attr('data-id');
        arr.push(id);
    });
    $ClubList_management_category.val(we.implode(',', arr));
};

var fnDeleteClassify=function(op){
    $(op).parent().remove();
    fnUpdateClassify();
};
$(function(){
    // 添加或删除时，更新图片搭配club_list_pic的value值
    var arr_pic=[];
    $upload_pic_club_list_pic.find('a').each(function(){
        arr_pic.push($(this).attr('data-savepath'));
    });
    $club_list_pic.val(we.implode(',',arr_pic));
    $upload_box_club_list_pic.show();
    if(arr_pic.length>=5) {
        $upload_box_club_list_pic.hide();
    }
 // 添加分类
    var $classify_add_btn=$('#classify_add_btn');
    $classify_add_btn.on('click', function(){
        $.dialog.data('classify_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/category", array('fid'=>211));?>',{
            id:'xiangmu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('classify_id')>0){
                    if($('#classify_item_'+$.dialog.data('classify_id')).length==0){
                       $classify_box.append('<span class="label-box" id="classify_item_'+$.dialog.data('classify_id')+'" data-id="'+$.dialog.data('classify_id')+'">'+$.dialog.data('classify_title')+'<i onclick="fnDeleteClassify(this);"></i></span>');
                       fnUpdateClassify();
                    }
                }
            }
        });
    });
    
    // 选择服务地区
    var $ClubList_club_address=$('#ClubList_club_address');
    var $ClubList_Longitude=$('#ClubList_Longitude');
    var $ClubList_latitude=$('#ClubList_latitude');
    $ClubList_club_address.on('click', function(){
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
                    $ClubList_club_address.val($.dialog.data('maparea_address'));
                    $ClubList_Longitude.val($.dialog.data('maparea_lng'));
                    $ClubList_latitude.val($.dialog.data('maparea_lat'));
                }
            }
        });
    });
	
});

 function selectOnchang(obj){ 
  var show_id=$(obj).val();
  var  p_html ='<option value="">请选择</option>';
  if (show_id>0) {
    //'partnership_type
     for (j=0;j<$d_club_type2.length;j++) 
        if($d_club_type2[j]['fater_id']==show_id)
       {
        p_html = p_html +'<option value="'+$d_club_type2[j]['f_id']+'">';
        p_html = p_html +$d_club_type2[j]['F_NAME']+'</option>';
      }
    }
   $("#ClubList_partnership_type").html(p_html);
}
</script>