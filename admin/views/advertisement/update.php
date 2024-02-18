<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑广告</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <table class="table-title">
            <tr>
                <td>广告信息</td>
            </tr>
        </table>
        <table>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'adver_code'); ?></td>
                <td colspan="3"><?php echo $model->adver_code;?></td>
            </tr>
        </table>
        <table class="mt15">
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'ADVER_TITLE'); ?></td>
                <td width="35%">
                    <?php echo $form->textField($model, 'ADVER_TITLE', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'ADVER_TITLE', $htmlOptions = array()); ?>
                </td>
                <td width="15%"><?php echo $form->labelEx($model, 'club_id'); ?></td>
                <td>
                    <span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->club_name;?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text')); ?></span><?php } else {?><span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value'=>get_session('club_id'))); ?></span><?php } ?></span>
                    <?php echo $form->error($model, 'club_id', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'advertisement_pic'); ?></td>
                <td>
                    <?php echo $form->hiddenField($model, 'advertisement_pic', array('class' => 'input-text fl')); ?>
                    <?php $basepath=BasePath::model()->getPath(174);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                    <?php if($model->advertisement_pic!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_advertisement_pic"><a href="<?php echo $basepath->F_WWWPATH.$model->advertisement_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->advertisement_pic;?>" width="100"></a></div><?php }?>
                    <input style="margin-left:5px;" id="picture_select_btn" class="btn" type="button" value="图库选择" >
                    <script>we.uploadpic('<?php echo get_class($model);?>_advertisement_pic', '<?php echo $picprefix;?>');</script>
                    <?php echo $form->error($model, 'advertisement_pic', $htmlOptions = array()); ?>
                    <span class="msg" id="adver_picpx"></span>
                </td>
                <td><?php echo $form->labelEx($model, 'project_list'); ?></td>
                <td>
                    <?php echo $form->hiddenField($model, 'project_list', array('class' => 'input-text',)); ?>
                    <span id="project_box">
                        <?php 
                        if(!empty($project_list)){
                        if (is_array($project_list)) foreach($project_list as $v){?>
                        <span class="label-box" id="project_item_<?php echo $v->project_id?>" data-id="<?php echo $v->project_id?>"><?php if (!empty($v->project_list)) {
                         echo $v->project_list->project_name;} else { echo '无效项目';} ?><i onclick="fnDeleteProject(this);"></i></span>
                        <?php }}?>
                    </span>
                    <input id="project_add_btn" class="btn" type="button" value="添加">
                    <?php echo $form->error($model, 'project_list', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'sname_id'); ?></td>
                <td >
                    <span id="classify_box"><?php if($model->sname_id!=''){?><span class="label-box"><?php echo $model->mall_products_type_sname->sn_name; ?></span><?php }?></span>
                    <input id="classify_select_btn" class="btn" type="button" value="选择">
                    <?php echo $form->hiddenField($model, 'sname_id'); ?>
                    <?php echo $form->error($model, 'sname_id', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'show_all_club'); ?></td>
                <td >
                   <?php echo $form->checkBox($model, 'show_all_club', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'show_all_club', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'advertisement_type'); ?></td>
                <td>
                    <?php echo $form->dropDownList($model, 'advertisement_type', Chtml::listData(AdverName::model()->getParentAll(), 'id', 'adv_name'), array('prompt'=>'请选择')); ?>
                    <!--select id="sub_advertisement_type" class="sub_advertisement_type" name="sub_advertisement_type">
                        <php foreach(AdverName::model()->getByfid(5) as $v){?>
                        <option value="<php echo $v->id;?>"<php if($sub_product_list_type==$v->id){?> selected<php }?>><php echo $v->adv_name;?></option>
                        <php }?>
                    </select-->
                    <?php echo $form->error($model, 'advertisement_type', $htmlOptions = array()); ?>
                    <?php $arr=AdverName::model()->getPicpx(); ?>
<script>
var $picpx = <?php echo json_encode($arr); ?>;
</script>
                </td>
                <td><?php echo $form->labelEx($model, 'ADVER_URL_ID'); ?></td>
                <td>
                    <?php echo $form->dropDownList($model, 'ADVER_URL_ID', Chtml::listData(AdverUrl::model()->getAll(), 'id', 'ADV_URL_NAME'), array('prompt'=>'请选择')); ?>
                    <?php echo $form->error($model, 'ADVER_URL_ID', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr style="display:none;" id="row-ADVER_WHERE">
                <td><?php echo $form->labelEx($model, 'ADVER_WHERE'); ?></td>
                <td colspan="3">
                    <span id="ADVER_WHERE_box"><?php if($model->ADVER_WHERE!=''){?><span class="label-box"><?php Yii::app()->runController('select/getAdverService/adver_url_id/'.$model->ADVER_URL_ID.'/id/'.$model->ADVER_WHERE);?></span><?php }?></span>
                    <input id="service_select_btn" class="btn" type="button" value="选择">
                    <?php echo $form->hiddenField($model, 'ADVER_WHERE'); ?>
                    <?php echo $form->error($model, 'ADVER_WHERE', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr style="display:none;" id="row-ADVER_URL">
                <td><?php echo $form->labelEx($model, 'ADVER_URL'); ?></td>
                <td colspan="3">
                    <div id="row-ADVER_URL_text"><?php echo $form->textField($model, 'ADVER_URL', array('class' => 'input-text fl', 'placeholder'=>'请输入跳转网址')); ?></div>
                    <?php $basepath=BasePath::model()->getPath(174);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                    <div id="row-ADVER_URL_pic">
                        <div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_ADVER_URL"><?php if($model->ADVER_URL!='') { ?><a href="<?php echo $model->ADVER_URL;?>" target="_blank"><img src="<?php echo $model->ADVER_URL;?>" width="100"></a><?php } ?></div>
                        <script>we.uploadpic('<?php echo get_class($model);?>_ADVER_URL', '<?php echo $picprefix;?>', '','',function(e1,e2){fnAllpath(e1.allpath);},'');</script>
                    </div>
                    <?php echo $form->error($model, 'ADVER_URL', $htmlOptions = array()); ?>
                </td>
            </tr>
<script>
// 上传完成时图片处理（全路径赋值）
var fnAllpath=function(allpath){
    $('#upload_pic_Advertisement_ADVER_URL').html('<a href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"></a>');
    $('#Advertisement_ADVER_URL').val(allpath);
};
</script>
            <tr style="display:none;" id="row-subgoods">
                <td>选择指定商品</td>
                <td colspan="3">
                    <input id="product_add_btn" class="btn" type="button" value="添加">
                    <br>
                    <table id="product_list" style="width:80%; text-align:center;" class="showinfo">
                        <tr>
                            <th style="width:25%;">商品</th>
                            <th style="width:25%;">自定义封面</th>
                            <th style="width:25%;">自定义标题</th>
                            <th>&nbsp;</th>
                        </tr>
                        <?php if($model->advertisement_type==5){?>
                        <?php if (is_array($sub_product_list)) foreach($sub_product_list as $v){?>
                        <?php //dump($v->productData);exit;?>
                        <tr id="product_item_<?php echo $v->ADVER_WHERE;?>">
                            <td><?php echo $v->mall_products->name;?><input name="sub_product_list[<?php echo $v->ADVER_WHERE;?>][id]" value="<?php echo $v->id;?>" type="hidden"></td>
                            <td>
                                <div class="upload_img fl" id="upload_pic_sub_product_list_<?php echo $v->ADVER_WHERE;?>"><a href="<?php echo $basepath->F_WWWPATH.$v->advertisement_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH. $v->advertisement_pic;?>" width="100"></a></div>
                                <script>we.uploadpic('sub_product_list_<?php echo $v->ADVER_WHERE;?>', '<?php echo $picprefix;?>');</script>
                                <input id="sub_product_list_<?php echo $v->ADVER_WHERE;?>" name="sub_product_list[<?php echo $v->ADVER_WHERE;?>][pic]" value="<?php echo $v->advertisement_pic;?>" type="hidden">
                            </td>
                            <td><input style="width:90%;" class="input-text" name="sub_product_list[<?php echo $v->ADVER_WHERE;?>][title]" value="<?php echo $v->ADVER_TITLE;?>" type="text"></td>
                            <td><a onclick="fnDeleteProduct(this);" href="javascript:;">删除</a></td>
                        </tr>
                        <?php }?>
                        <?php }?>
                    </table>
                </td>
            </tr>
            <tr style="display:none;" id="row-subgoods2">
                <td>选择增值商品</td>
                <td colspan="3">
                    <input id="product_add2_btn" class="btn" type="button" value="添加">
                    <br>
                    <table id="product_list2" style="width:80%; text-align:center;" class="showinfo">
                        <tr>
                            <th style="width:25%;">商品</th>
                            <th style="width:25%;">自定义封面</th>
                            <th style="width:25%;">自定义标题</th>
                            <th>&nbsp;</th>
                        </tr>
                        <?php if($model->advertisement_type==5){?>
                        <?php if (is_array($sub_product_list2)) foreach($sub_product_list2 as $v){?>
                        <?php //dump($v->productData);exit;?>
                        <tr id="product_item_<?php echo $v->ADVER_WHERE;?>">
                            <td><?php echo $v->mall_products->name;?><input name="sub_product_list2[<?php echo $v->ADVER_WHERE;?>][id]" value="<?php echo $v->id;?>" type="hidden"></td>
                            <td>
                                <div class="upload_img fl" id="upload_pic_sub_product_list2_<?php echo $v->ADVER_WHERE;?>"><a href="<?php echo $basepath->F_WWWPATH.$v->advertisement_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH. $v->advertisement_pic;?>" width="100"></a></div>
                                <script>we.uploadpic('sub_product_list2_<?php echo $v->ADVER_WHERE;?>', '<?php echo $picprefix;?>');</script>
                                <input id="sub_product_list2_<?php echo $v->ADVER_WHERE;?>" name="sub_product_list2[<?php echo $v->ADVER_WHERE;?>][pic]" value="<?php echo $v->advertisement_pic;?>" type="hidden">
                            </td>
                            <td><input style="width:90%;" class="input-text" name="sub_product_list2[<?php echo $v->ADVER_WHERE;?>][title]" value="<?php echo $v->ADVER_TITLE;?>" type="text"></td>
                            <td><a onclick="fnDeleteProduct(this);" href="javascript:;">删除</a></td>
                        </tr>
                        <?php }?>
                        <?php }?>
                    </table>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'ADVER_DATE_START'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'ADVER_DATE_START', array('style'=>'width:120px;', 'class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'ADVER_DATE_START', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'ADVER_DATE_END'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'ADVER_DATE_END', array('style'=>'width:120px;', 'class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'ADVER_DATE_END', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'advertisement_number'); ?></td>
                <td colspan="3">
                    <?php echo $form->textField($model, 'advertisement_number', array('style'=>'width:120px;', 'class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'advertisement_number', $htmlOptions = array()); ?>
                </td>
            </tr>
        </table>
        
        
        <div class="mt15">
            <table class="table-title">
                <tr>
                    <td>审核信息</td>
                </tr>
            </table>
            <table>
            	<tr>
                    <td width='15%'><?php echo $form->labelEx($model, 'ADVER_STATE'); ?></td>
                    <td width='85%'>
                        <?php echo $form->radioButtonList($model, 'ADVER_STATE', array(649 => '上线', 648 => '下线'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'ADVER_STATE'); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                    <td>
                        <?php echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text' ,'value'=>'')); ?>
                        <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
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
                <td><?php echo $model->admin_gfnick; ?></td>
                <td><?php echo $model->state_name; ?></td>
                <td><?php echo $model->reasons_failure; ?></td>
            </tr>
        </table>
        
        
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
var club_id=<?php echo $model->club_id;?>;
$(function(){
    var $start_time=$('#<?php echo get_class($model);?>_ADVER_DATE_START');
    var $end_time=$('#<?php echo get_class($model);?>_ADVER_DATE_END');
	$start_time.on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
    $end_time.on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss '});});
});
//从图库选择图片
var $Single=$('#Advertisement_advertisement_pic');
    $('#picture_select_btn').on('click', function(){
		var club_id=$('#Advertisement_club_id').val();
        $.dialog.data('app_icon', 0);
        $.dialog.open('<?php echo $this->createUrl("gfMaterial/materialPictureAll", array('type'=>252,'fd'=>174));?>&club_id='+club_id,{
            id:'picture',
            lock:true,
            opacity:0.3,
            title:'请选择素材',
            width:'100%',
            height:'90%',
            close: function () {
                if($.dialog.data('material_id')>0){
                    $Single.val($.dialog.data('app_icon')).trigger('blur');

                    $('#upload_pic_Advertisement_advertisement_pic').html('<a href="<?php echo $basepath->F_WWWPATH;?>'+art.dialog.data('app_icon')
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
</script>
<script>
// 删除已添加项目
var fnDeleteProject=function(op){
    $(op).parent().remove();
    fnUpdateProject();
};
// 项目添加或删除时，更新
var fnUpdateProject=function(){
    var arr=[];
    $('#project_box span').each(function(){
        arr.push($(this).attr('data-id'));
    });
    $('#Advertisement_project_list').val(we.implode(',',arr));
};
fnUpdateProject();

// 广告类型为赛事馆时，跳转类型只能是二级商品
var $Advertisement_advertisement_type=$('#Advertisement_advertisement_type');
var $Advertisement_ADVER_URL_ID=$('#Advertisement_ADVER_URL_ID');
var $row_subgoods=$('#row-subgoods');
var $row_subgoods2=$('#row-subgoods2');
//var $sub_advertisement_type=$('#sub_advertisement_type');
var fnUpdateAdverUrl=function(){
    $Advertisement_ADVER_URL_ID.find('option[value=16]').attr('disabled', true);
    if($Advertisement_advertisement_type.val()==5){
        //$sub_advertisement_type.show();
        //$Advertisement_ADVER_URL_ID.hide();
        $Advertisement_ADVER_URL_ID.find('option[value=16]').attr('disabled', false);
        $Advertisement_ADVER_URL_ID.val(16).prop('disabled', true);
        $row_subgoods.show();
		$row_subgoods2.show();
        $('#row-ADVER_WHERE').hide();
    }else{
        //$sub_advertisement_type.hide();
        $Advertisement_ADVER_URL_ID.show();
        $Advertisement_ADVER_URL_ID.prop('disabled', false);
        $Advertisement_ADVER_URL_ID.find('option[value=16]').attr('disabled', true);
        $row_subgoods.hide();
		$row_subgoods2.hide();
		$('#row-ADVER_WHERE').show();
        if($Advertisement_ADVER_URL_ID.val()===null){
            $Advertisement_ADVER_URL_ID.val('');
        }
    }
};
fnUpdateAdverUrl();    
// 选择广告类型pic_px
    $Advertisement_advertisement_type.on('change', function(){
        fnUpdateAdverUrl();
		fnUpdatePicpx();
    });
    

var fnUpdatePicpx=function(){
	if ($Advertisement_advertisement_type.val()>0){
		for (var j=0;j<$picpx.length;j++){
			if($picpx[j]['id']==$Advertisement_advertisement_type.val()){
				if($picpx[j]['pic_px'].length>0) {
					$('#adver_picpx').text($picpx[j]['pic_px']);
				} else {
					$('#adver_picpx').text('');
				}
			}
	    }
	}
	
}
fnUpdatePicpx();
// 删除已添加商品$picpx
var fnDeleteProduct=function(op){
    $(op).parent().parent().remove();
};

$(function(){
    // 添加项目
    var $project_box=$('#project_box');
    $('#project_add_btn').on('click', function(){
		var club_id=$('#Advertisement_club_id').val();
        $.dialog.data('project_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/project");?>&club_id='+club_id,{
            id:'xiangmu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('project_id')==-1){
                    var boxnum=$.dialog.data('project_title');
                    for(var j=0;j<boxnum.length;j++) {
                        if($('#project_item_'+boxnum[j].dataset.id).length==0){
                            var s1='<span class="label-box" id="project_item_'+boxnum[j].dataset.id;
                            s1=s1+'" data-id="'+boxnum[j].dataset.id+'">'+boxnum[j].dataset.title;
                            $project_box.append(s1+'<i onclick="fnDeleteProject(this);"></i></span>');
                            fnUpdateProject(); 
                        }
                    }
                }
            }
        });
    });
    
	// 选择分类
    var $classify_box=$('#classify_box');
    var $Advertisement_sname_id=$('#Advertisement_sname_id');
    $('#classify_select_btn').on('click', function(){
        $.dialog.data('classify_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/classify", array('fid'=>161));?>',{
            id:'fenlei',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                //console.log($.dialog.data('club_id'));
                if($.dialog.data('classify_id')>0){
                    classify_id=$.dialog.data('classify_id');
                    $Advertisement_sname_id.val($.dialog.data('classify_id')).trigger('blur');
                    $classify_box.html('<span class="label-box">'+$.dialog.data('classify_title')+'</span>');
                }
            }
        });
    });
    
    // 跳转类型切换
    var adver_url_json=<?php echo AdverUrl::model()->getAllJson();?>;
    var adver_url_id=$('#Advertisement_ADVER_URL_ID').val();
    var $row_adver_where=$('#row-ADVER_WHERE');
    var $row_adver_url=$('#row-ADVER_URL');
    var $row_adver_url_text=$('#row-ADVER_URL_text');
    var $row_adver_url_pic=$('#row-ADVER_URL_pic');
    var $row_subgoods=$('#row-subgoods');
	var $row_subgoods2=$('#row-subgoods2');
    var $Advertisement_ADVER_WHERE=$('#Advertisement_ADVER_WHERE');
    var $ADVER_WHERE_box=$('#ADVER_WHERE_box');
    var fnAdverUrlIdChange=function(adver_url_id, setEmpty){
        if(setEmpty==undefined){
            setEmpty=true;
        }

        if(setEmpty){
            $Advertisement_ADVER_WHERE.val('');
            $ADVER_WHERE_box.html('');
        }
        if(adver_url_json[adver_url_id].ADV_URL_TABLE!=''){
            $row_adver_where.show();
            $row_adver_url.hide();
        }else{
            if(adver_url_id==15){
                if(setEmpty){
                    $('#Advertisement_ADVER_URL').val('');
                    $('#upload_pic_Advertisement_ADVER_URL').html('');
                }
                $row_adver_url_text.hide();
                $row_adver_url_pic.show();
            }else{
                if(setEmpty){
                    $('#Advertisement_ADVER_URL').val('');
                    $('#upload_pic_Advertisement_ADVER_URL').html('');
                }
                $row_adver_url_text.show();
                $row_adver_url_pic.hide();
            }
            $row_adver_url.show();
            $row_adver_where.hide();
        }
        
        if($Advertisement_advertisement_type.val()==5){
            $row_adver_where.hide();
        }
    };
    $('#Advertisement_ADVER_URL_ID').on('change', function(){
        adver_url_id=$(this).val();
        fnAdverUrlIdChange(adver_url_id);
    });
    fnAdverUrlIdChange(<?php echo $model->ADVER_URL_ID;?>, false);
    
    $('#service_select_btn').on('click', function(){
		
		var club_id=$('#Advertisement_club_id').val();
        if(club_id<=0){
            we.msg('minus', '请先登录发布单位管理员帐号');
            return false;
        }
        $.dialog.data('id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/adverService");?>'+'&adver_url_id='+adver_url_id+'&noid=<?php echo $model->id;?>&club_id='+club_id,{
            id:'fuwu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('id')>0){
                    $Advertisement_ADVER_WHERE.val($.dialog.data('id'));
                    $ADVER_WHERE_box.html('<span class="label-box">'+$.dialog.data('title')+'</span>');
                }
            }
        });
    });
    
    // 添加二级商品
    var $product_list=$('#product_list');
    $('#product_add_btn').on('click', function(){
        $.dialog.data('product_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/products");?>',{
            id:'shangpin',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                //console.log($.dialog.data('product_id'));
                if($.dialog.data('product_id')>0){
                    if($('#product_item_'+$.dialog.data('product_id')).length==0){
                        $product_list.append('<tr id="product_item_'+$.dialog.data('product_id')+'">'+
                            '<td>'+$.dialog.data('product_name')+'<input name="sub_product_list['+$.dialog.data('product_id')+'][id]" value="null" type="hidden"></td>'+
                            '<td><div class="upload_img fl" id="upload_pic_sub_product_list_'+$.dialog.data('product_id')+'"><a href="<?php echo $basepath->F_WWWPATH;?>'+$.dialog.data('product_pic')+'" target="_blank"><img src="<?php echo $basepath->F_WWWPATH;?>'+$.dialog.data('product_pic')+'" width="100"></a></div><div class="fl" id="box_sub_product_list_'+$.dialog.data('product_id')+'"></div><input id="sub_product_list_'+$.dialog.data('product_id')+'" name="sub_product_list['+$.dialog.data('product_id')+'][pic]" value="'+$.dialog.data('product_pic')+'" type="hidden"></td>'+
                            '<td><input style="width:90%;" class="input-text" name="sub_product_list['+$.dialog.data('product_id')+'][title]" value="'+$.dialog.data('product_name')+'" type="text"></td>'+
                            '<td><a onclick="fnDeleteProduct(this);" href="javascript:;">删除</a></td>'+
                        '</tr>');
                        we.uploadpic('sub_product_list_'+$.dialog.data('product_id'), '<?php echo $picprefix;?>');
                    }
                }
            }
        });
        //$product_list.append('');
    });
	
	// 添加二级商品
    var $product_list2=$('#product_list2');
    $('#product_add2_btn').on('click', function(){
        $.dialog.data('product_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/products");?>',{
            id:'shangpin',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                //console.log($.dialog.data('product_id'));
                if($.dialog.data('product_id')>0){
                    if($('#product_item2_'+$.dialog.data('product_id')).length==0){
                        $product_list2.append('<tr id="product_item2_'+$.dialog.data('product_id')+'">'+
                            '<td>'+$.dialog.data('product_name')+'</td>'+
                            '<td><div class="upload_img fl" id="upload_pic_sub_product_list2_'+$.dialog.data('product_id')+'"><a href="<?php echo $basepath->F_WWWPATH;?>'+$.dialog.data('product_pic')+'" target="_blank"><img src="<?php echo $basepath->F_WWWPATH;?>'+$.dialog.data('product_pic')+'" width="100"></a></div><div class="fl" id="box_sub_product_list2_'+$.dialog.data('product_id')+'"></div><input id="sub_product_list2_'+$.dialog.data('product_id')+'" name="sub_product_list2['+$.dialog.data('product_id')+'][pic]" value="'+$.dialog.data('product_pic')+'" type="hidden"></td>'+
                            '<td><input style="width:90%;" class="input-text" name="sub_product_list2['+$.dialog.data('product_id')+'][title]" value="'+$.dialog.data('product_name')+'" type="text"></td>'+
                            '<td><a onclick="fnDeleteProduct(this);" href="javascript:;">删除</a></td>'+
                        '</tr>');
                        we.uploadpic('sub_product_list2_'+$.dialog.data('product_id'), '<?php echo $picprefix;?>');
                    }
                }
            }
        });
        //$product_list.append('');
    });
    
//    var fnCheckState=function(){
//        if($('input[name="Advertisement[state]"]:checked').val()==373){
//            $('#state_msg').show();
//        }else{
//            $('#state_msg').hide();
//        }
//    };
//    fnCheckState();
//    // 审核未通过原因
//    $('#Advertisement_state').on('click', function(){
//        fnCheckState();
//    });
});
</script>