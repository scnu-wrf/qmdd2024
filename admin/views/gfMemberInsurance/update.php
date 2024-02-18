<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>保险详情</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <table>
        	<tr class="table-title">
                <td colspan="4">保险基本信息</td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'policy_number'); ?></td>
                <td><?php echo $form->textField($model, 'policy_number', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'policy_number', $htmlOptions = array()); ?></td>
                <td><?php echo $form->labelEx($model, 'company_id'); ?></td>
                <td><?php echo $form->hiddenField($model, 'company_id', array('class' => 'input-text',)); ?>
                    <span id="company_box">
                        <span class="label-box"><?php echo $model->company_name;?></span>
                    </span>
                    <input id="company_select_btn" class="btn" type="button" value="选择">
                    <?php echo $form->error($model, 'company_id', $htmlOptions = array()); ?></td>
             </tr>
             <tr>
                <td><?php echo $form->labelEx($model, 'insurance_type'); ?></td>
                <td>
                    <?php echo $form->dropDownList($model, 'insurance_type', Chtml::listData(MallProductsTypeSname::model()->getCode(153), 'id', 'sn_name'), array('prompt'=>'请选择')); ?>
                    <?php echo $form->error($model, 'insurance_type', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'insurance_item'); ?></td>
                <td>
                    <?php echo $form->dropDownList($model, 'insurance_item', Chtml::listData(BaseCode::model()->findAll('fater_id=664 AND f_id<>982'), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange'=>'typeOnchange(this)')); ?>
                    <?php echo $form->error($model, 'insurance_item', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'insurance_date_star'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'insurance_date_star', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'insurance_date_star', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'insurance_date_end'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'insurance_date_end', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'insurance_date_end', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'insurance_img'); ?></td>
                <td colspan="3">
                    <?php $basepath=BasePath::model()->getPath(201);$prefix='';if($basepath!=null){ $prefix=$basepath->F_CODENAME; }?>
                            <?php echo $form->hiddenField($model, 'insurance_img', array('class' => 'input-text')); ?>
                            <div class="upload_img fl" id="upload_pic_insurance_img">
                                <?php 
                                foreach($insurance_img as $v) if($v) {?>
                                <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px;"><i onclick="$(this).parent().remove();fnUpdateScrollpic();return false;"></i></a>
                                <?php }?>
                            </div>
                    <script>
                              
                      we.uploadpic('<?php echo get_class($model);?>_insurance_img','<?php echo $prefix;?>','','',function(e1,e2){fnScrollpic(e1.savename,e1.allpath);},5);
                        </script>
                        <span>*请上传保险合同盖章页</span>
                    <?php echo $form->error($model, 'insurance_img', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'shopping_type'); ?></td>
                <td>
                    <?php echo $form->dropDownList($model, 'shopping_type', Chtml::listData(BaseCode::model()->getCode(640), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                    <?php echo $form->error($model, 'shopping_type', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'shopping_address'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'shopping_address', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'shopping_address', $htmlOptions = array()); ?>
                </td>
            </tr>
         </table>
        <table class="mt15">
        	<tr class="table-title">
                <td colspan="4">使用关联（选填）</td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'user_type'); ?></td>
                <td>
                    <?php echo $form->dropDownList($model, 'user_type', Chtml::listData(BaseCode::model()->getOrderType(), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                    <?php echo $form->error($model, 'user_type', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'user_service'); ?></td>
                <td><?php echo $form->hiddenField($model, 'user_service', array('class' => 'input-text')); ?>
                    <span id="service_box">
                        <?php if(!empty($model->userservice)) { ?>
                        <span class="label-box"><?php echo $model->userservice->game_title;?></span>
                        <?php } ?>
                    </span>
                    <input id="service_select_btn" class="btn" type="button" value="选择">
                    <?php echo $form->error($model, 'user_service', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'user_service_data'); ?></td>
                <td><?php echo $form->hiddenField($model, 'user_service_data', array('class' => 'input-text','onchange' =>'dataOnchang(this)')); ?>
                    <span id="servicedata_box">
                    	<?php if(!empty($model->userservice_data)) { ?>
                        <span class="label-box"><?php echo $model->userservice_data->game_data_name;?></span>
                        <?php } ?>
                    </span>
                    <input id="servicedata_select_btn" class="btn" type="button" value="选择">
                    <?php echo $form->error($model, 'user_service_data', $htmlOptions = array()); ?>
                </td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <table class="mt15">
        	<tr class="table-title">
                <td colspan="4">投保人信息</td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'gf_account'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'gf_account', array('class' => 'input-text','oninput' =>'accountOnchang(this)','onpropertychange' =>'accountOnchang(this)')); ?>
                    <?php echo $form->error($model, 'gf_account', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'gf_name'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'gf_name', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'gf_name', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'id_card_type'); ?></td>
                <td>
                    <?php echo $form->dropDownList($model, 'id_card_type', Chtml::listData(BaseCode::model()->getCode(842), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                    <?php echo $form->error($model, 'id_card_type', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'id_card'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'id_card', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'id_card', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'gf_phone'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'gf_phone', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'gf_phone', $htmlOptions = array()); ?>
                </td>
                <td></td><td></td>
            </tr>
        </table>
        <table class="mt15">
        	<tr class="table-title">
                <td colspan="4">被保人信息 <input type="button" class="btn" id="insured_add_btn" value="添加" /></td>
            </tr>
            <tr>
                <td colspan="4">
                  <?php echo $form->hiddenField($model, 'user_list', array('class' => 'input-text')); ?>
                  <table class="list" id="user_list">
                      <tr class="table-title list_header" align="center">
                        <th width="15%">帐号</th>
                        <th width="15%">姓名</th>
                        <th width="15%">证件类型</th>
                        <th width="25%">证件号</th>
                        <th width="15%">联系电话</th>
                        <th width="10%">操作</th>
                      </tr>
                      <?php if(is_array($model->user_insurance)) foreach($model->user_insurance as $v){ ?>
                      <tr>
                        <td>
                        <input class="Insured_id" type="hidden" name="user_list[<?php echo $v->id;?>][id]" value="<?php echo $v->id; ?>" />
                        <input class="Insured_gf_id" type="hidden" name="user_list[<?php echo $v->id;?>][gf_id]" value="<?php echo $v->gf_id; ?>" />
                        <input class="input-text" type="text" readonly name="user_list[<?php echo $v->id;?>][gf_account]" value="<?php echo $v->gf_account; ?>" /></td>
                        <td><?php echo $v->gf_name; ?>
                        <input class="Insured_gf_name" type="hidden" name="user_list[<?php echo $v->id;?>][gf_name]" value="<?php echo $v->gf_name; ?>" /></td>
                        <td><?php echo $v->id_card_type_name; ?>
                        <input class="Insured_id_card_type" type="hidden" name="user_list[<?php echo $v->id;?>][id_card_type]" value="<?php echo $v->id_card_type; ?>" /></td>
                        <td><?php echo $v->id_card; ?>
                        <input class="Insured_id_card" type="hidden" name="user_list[<?php echo $v->id;?>][id_card]" value="<?php echo $v->id_card; ?>" /></td>
                        <td><?php echo $v->gf_phone; ?>
                        <input class="Insured_gf_phone" type="hidden" name="user_list[<?php echo $v->id;?>][gf_phone]" value="<?php echo $v->gf_phone; ?>" /></td>
                        <td><a class="btn" href="javascript:;" onclick="fnInsureddel(this);" title="删除"><i class="fa fa-trash-o"></i></a></td>
                      </tr>
                      <?php }?>                      
                  </table>
                </td>
            </tr>
        </table>
        <div class="box-detail-submit"><?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核','tongguo'=>'审核通过','butongguo'=>'不通过'));?><button class="btn" type="button" onclick="we.back();">取消</button></div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>

$(function(){
    var $start_time=$('#<?php echo get_class($model);?>_insurance_date_star');
    var $end_time=$('#<?php echo get_class($model);?>_insurance_date_end');
	$start_time.on('click', function(){
	WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
	$end_time.on('click', function(){
	WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss '});});

});
typeOnchang($('#GfMemberInsurance_insurance_item'));
function typeOnchang(obj){
	var i_type=$(obj).val();
	console.log('123');
	console.log('ytr=='+i_type);
	if(i_type==665) {
		$('#insured_add_btn').show();
	} else {
		$('#insured_add_btn').hide();
	}
}
// 滚动图片处理
var $insurance_img=$('#GfMemberInsurance_insurance_img');
var $upload_pic_insurance_img=$('#upload_pic_insurance_img');
var $upload_box_insurance_img=$('#upload_box_insurance_img');
// 添加或删除时，更新图片
var fnUpdateScrollpic=function(){
    var arr=[];
    $upload_pic_insurance_img.find('a').each(function(){
        arr.push($(this).attr('data-savepath'));
    });
    $insurance_img.val(we.implode(',',arr));
    $upload_box_insurance_img.show();
    if(arr.length>=5) {
        $upload_box_insurance_img.hide();
    }
};
// 上传完成时图片处理
var fnScrollpic=function(savename,allpath){
    $upload_pic_insurance_img.append('<a class="picbox" data-savepath="'+
    savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdateScrollpic();return false;"></i></a>');
    fnUpdateScrollpic();
};
// 选择保险公司
    var $company_box=$('#company_box');
    var $GfMemberInsurance_company_id=$('#GfMemberInsurance_company_id');
    $('#company_select_btn').on('click', function(){
        $.dialog.data('brand_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/brand");?>',{
            id:'pinpai',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('brand_id')>0){
                    company_id=$.dialog.data('brand_id');
                    $GfMemberInsurance_company_id.val($.dialog.data('brand_id')).trigger('blur');
                    $company_box.html('<span class="label-box">'+$.dialog.data('brand_title')+'</span>');
                }
            }
        });
    });
// 选择服务
    var $service_box=$('#service_box');
    var $GfMemberInsurance_user_service=$('#GfMemberInsurance_user_service');
    $('#service_select_btn').on('click', function(){
		var type=$('#GfMemberInsurance_user_type').val();
		if (type=='') {
			we.msg('minus','请先选择服务类型');
            return false;
		}
        $.dialog.data('service_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/Insurance_service");?>&type='+type,{
            id:'fuwu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('service_id')>0){
                    //company_id=$.dialog.data('service_id');
                    $GfMemberInsurance_user_service.val($.dialog.data('service_id')).trigger('blur');
                    $service_box.html('<span class="label-box">'+$.dialog.data('service_name')+'</span>');
                }
            }
        });
    });
	
	// 选择服务规格
    var $servicedata_box=$('#servicedata_box');
    var $GfMemberInsurance_user_service_data=$('#GfMemberInsurance_user_service_data');
    $('#servicedata_select_btn').on('click', function(){
		var type=$('#GfMemberInsurance_user_type').val();
		var service_id=$('#GfMemberInsurance_user_service').val();
		if (type=='') {
			we.msg('minus','请先选择服务类型');
            return false;
		}
		if (service_id=='') {
			we.msg('minus','请先选择服务名称');
            return false;
		}
        $.dialog.data('servicedatae_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/Insurance_servicedata");?>&type='+type+'&service_id='+service_id,{
            id:'fuwu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('servicedata_id')>0){
                    //company_id=$.dialog.data('service_id');
                    $GfMemberInsurance_user_service_data.val($.dialog.data('servicedata_id')).change();
                    $servicedata_box.html('<span class="label-box">'+$.dialog.data('servicedata_name')+'</span>');
                }
            }
        });
    });
    
</script>
<script>

//根据GF帐号获取投保人信息
function accountOnchang(obj){
  var changval=$(obj).val();
  if (changval.length>=6) {
	  $.ajax({
		type: 'post',
		url: '<?php echo $this->createUrl('achieve');?>&gf_account='+changval,
		data: {gf_account:changval},
		dataType: 'json',
		success: function(data) {
			if(data.status==1){
				$('#GfMemberInsurance_gf_id').val(data.gfid);
				$('#GfMemberInsurance_gf_name').val(data.real_name);
				$('#GfMemberInsurance_gf_phone').val(data.contect);
				$('#GfMemberInsurance_id_card_type').val(data.card_type);
				$('#GfMemberInsurance_id_card').val(data.card_num);
			}else{
				//$(obj).val('');
				we.msg('minus', data.msg);
			}
		}
	});

  }
}

//根据GF帐号获取被保人信息
function InsuredOnchang(obj){
  var changval=$(obj).val();
  if (changval.length>=6) {
	  $.ajax({
		type: 'post',
		url: '<?php echo $this->createUrl('Insured');?>&gf_account='+changval,
		data: {gf_account:changval},
		dataType: 'json',
		success: function(data) {
			if(data.status==1){
				$(obj).parent().parent().find('.Insured_gf_id').val(data.gfid);
				$(obj).parent().parent().find('.Insured_gf_name').val(data.real_name);
				$(obj).parent().parent().find('.gf_name').text(data.real_name);
				$(obj).parent().parent().find('.Insured_gf_phone').val(data.contect);
				$(obj).parent().parent().find('.gf_phone').text(data.contect);
				$(obj).parent().parent().find('.Insured_id_card_type').val(data.card_type);
				$(obj).parent().parent().find('.id_card_type_name').text(data.card_type_name);
				$(obj).parent().parent().find('.Insured_id_card').val(data.card_num);
				$(obj).parent().parent().find('.id_card').text(data.card_num);
			}else{
				$(obj).val('');
				we.msg('minus', data.msg);
			}
		}
	});

  }
}
//根据服务规格获取被保人信息
var num=0;
var $user_list=$('#user_list');
function dataOnchang(obj){
  
  $('#user_list tr').not('.list_header').remove();
  var changval=$(obj).val();
  var user_num=0;
  
  var gf_id=0;
  var gf_account='';
  var gf_name='';
  var gf_phone='';
  var id_card_type='';
  var id_card_type_name='';
  var id_card='';
  var data_html='';
	  $.ajax({
		type: 'post',
		url: '<?php echo $this->createUrl('recognizee');?>&data_id='+changval,
		data: {data_id:changval},
		dataType: 'json',
		success: function(data) {
			if(data!=''){
            	user_num = data.length;
				for(var i=0;i<user_num;i++) {
					gf_id = data[i]["gf_id"];
					gf_account = data[i]["gf_account"];
					gf_name = data[i]["gf_name"];
					gf_phone = data[i]["gf_phone"];
					id_card_type = data[i]["id_card_type"];
					id_card_type_name = data[i]["id_card_type_name"];
					id_card = data[i]["id_card"];
					data_html=data_html+'<tr><td>'+
							'<input class="input-text" type="hidden" name="user_list['+num+'][id]" value="null" /><input class="input-text" type="hidden" name="user_list['+num+'][gf_id]" value="'+gf_id+'" /><input class="input-text" type="text" readonly name="user_list['+num+'][gf_account]" value="'+gf_account+'" /></td>'+
							'<td>'+gf_name+'<input class="input-text" type="hidden" name="user_list['+num+'][gf_name]" value="'+gf_name+'" /></td>'+
							'<td>'+id_card_type_name+'<input class="input-text" type="hidden" name="user_list['+num+'][id_card_type]" value="'+id_card_type+'" /></td>'+
							'<td>'+id_card+'<input class="input-text" type="hidden" name="user_list['+num+'][id_card]" value="'+id_card+'" /></td>'+
							'<td>'+gf_phone+'<input class="input-text" type="hidden" name="user_list['+num+'][gf_phone]" value="'+gf_phone+'" /></td></tr>';
					num++;
					
				}
				$user_list.append(data_html);
				fnUpdateUserlist();
			} else {
				we.msg('minus', '该服务规格没有符合条件的被保人');
			}
		}
	});
}
//添加被保人
$('#insured_add_btn').on('click', function(){
	var in_html='<tr><td>'+
				'<input class="Insured_id" type="hidden" name="user_list['+num+'][id]" value="null" /><input class="Insured_gf_id" type="hidden" name="user_list['+num+'][gf_id]" value="" /><input class="input-text" type="text" oninput="InsuredOnchang(this)" onpropertychange="InsuredOnchang(this)" name="user_list['+num+'][gf_account]" value="" /></td>'+
				'<td><span class="gf_name"></span><input class="Insured_gf_name" type="hidden" name="user_list['+num+'][gf_name]" value="" /></td>'+
				'<td><span class="id_card_type_name"></span><input class="Insured_id_card_type" type="hidden" name="user_list['+num+'][id_card_type]" value="" /></td>'+
				'<td><input class="id_card" type="hidden" name="user_list['+num+'][id_card]" value="" /></td>'+
				'<td><span class="gf_phone"></span><input class="Insured_gf_phone" type="hidden" name="user_list['+num+'][gf_phone]" value="" /></td>'+
				'<td><a class="btn" href="javascript:;" onclick="fnInsureddel(this);" title="删除"><i class="fa fa-trash-o"></i></a></td></tr>';
	$('#user_list').append(in_html);
	num++;

});
var fnInsureddel=function(op){
	$(op).parent().parent().remove();
};
</script>