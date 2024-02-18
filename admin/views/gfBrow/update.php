<div class="box">
    <div class="box-title c">
    <h1><i class="fa fa-table"></i>作品详情</h1><span class="back">
    <a class="btn" href="javascript:;" onclick="we.back();">
    <i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table class="mt15">
                    <tr>
						<td width="15%"><?php echo $form->labelEx($model, 'gf_account'); ?></td>
						<td><?php echo $model->gf_account;?></td>		
                    </tr>
					<tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'gf_name'); ?></td>
                        <td width="35%"><?php echo $model->gf_name;?></td>
                    </tr>
                    <tr>
                   		<td ><?php echo $form->labelEx($model, 'add_time'); ?></td>
                        <td width="35%"><?php echo $model->add_time;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'brow_type'); ?></td>
                        <td>
                           <?php echo $form->radioButtonList($model, 'brow_type', array(0=>'小表情', 1=>'大表情'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                            <?php echo $form->error($model, 'brow_type', $htmlOptions = array()); ?>
                            <br><span class="msg">小表情：30*30；大表情：110*110</span>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'brow_title'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'brow_title', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'brow_title', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'brow_patent'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'brow_patent', array('class' => 'input-text fl')); ?>
                            <?php $basepath1=BasePath::model()->getPath(240);$picprefix1='';if($basepath1!=null){ $picprefix1=$basepath1->F_CODENAME; }?>
                            <?php if($model->brow_patent!=''){?><div class="upload_img fl" id="upload_pic_brow_patent"><a href="<?php echo $basepath1->F_WWWPATH.$model->brow_patent;?>" target="_blank"><img src="<?php echo $basepath1->F_WWWPATH.$model->brow_patent;?>" width="100"></a></div><?php }?>
                            <input style="margin-left:5px;" id="patent_select_btn" class="btn" type="button" value="图库选择" >
                            <script>we.uploadpic('<?php echo get_class($model);?>_brow_patent','<?php echo $picprefix1;?>');</script>
                            <?php echo $form->error($model, 'brow_patent', $htmlOptions = array()); ?>
                        </td>
                        
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'brow_pic'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'brow_pic', array('class' => 'input-text')); ?>
                            <?php $basepath2=BasePath::model()->getPath(238);$picprefix2='';if($basepath2!=null){ $picprefix2=$basepath2->F_CODENAME; }?>
                            <?php if($model->brow_pic!=''){?><div class="upload_img fl" id="upload_pic_brow_pic"><a href="<?php echo $basepath2->F_WWWPATH.$model->brow_pic;?>" target="_blank"><img src="<?php echo $basepath2->F_WWWPATH.$model->brow_pic;?>" width="100"></a></div><?php }?>
                            <input style="margin-left:5px;" id="pic_select_btn" class="btn" type="button" value="图库选择" >
                            <script>we.uploadpic('<?php echo get_class($model);?>_brow_pic','<?php echo $picprefix2;?>');</script>
                            <?php echo $form->error($model, 'brow_pic', $htmlOptions = array()); ?>
                        </td>
                    </tr>
					<tr>
                        <td><?php echo $form->labelEx($model, 'brow_banner'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'brow_banner', array('class' => 'input-text fl')); ?>
                            <?php $basepath3=BasePath::model()->getPath(239);$picprefix3='';if($basepath3!=null){ $picprefix3=$basepath3->F_CODENAME; }?>
                            <?php if($model->brow_banner!=''){?><div class="upload_img fl" id="upload_pic_brow_banner"><a href="<?php echo $basepath3->F_WWWPATH.$model->brow_banner;?>" target="_blank"><img src="<?php echo $basepath3->F_WWWPATH.$model->brow_banner;?>" width="100"></a></div><?php }?>
                            <input style="margin-left:5px;" id="banner_select_btn" class="btn" type="button" value="图库选择" >
                            <script>we.uploadpic('<?php echo get_class($model);?>_brow_banner','<?php echo $picprefix3;?>');</script>
                            <?php echo $form->error($model, 'brow_banner', $htmlOptions = array()); ?>
                        </td>
                        
                    </tr>
					<tr>
                     <td colspan="2" style="padding:0;">
                            <?php echo $form->hiddenField($model, 'gf_brow_data', array('class' => 'input-text')); ?>
<?php $basepath4=BasePath::model()->getPath(237);$picprefix4=''; if($basepath4!=null){ $picprefix4=$basepath4->F_CODENAME; } ?>
<?php $basepath5=BasePath::model()->getPath(236);$picprefix5=''; if($basepath5!=null){ $picprefix5=$basepath5->F_CODENAME; } ?>
                                <script>
								var pic_num=0;
                                </script>
                                
                                <table id="gf_brow_data" style="margin:0;">
                                    <tr class="table-title">
                                    <td width="15%">封面图</td>
                                    <td width="15%">表情图</td>
                                    <td>名称</td>
                                    <td width="50">操作</td>
                                </tr>
                                <?php if(!empty($model->brow_data)) foreach($model->brow_data as $v) { ?>
                                  <tr>
                                    <input name="gf_brow_data[<?php echo $v->id;?>][id]" value="<?php echo $v->id;?>" type="hidden">
                                    <td>
<div class="upload_img fl" id="upload_pic_gf_brow_data_brow_<?php echo $v->id;?>"><a href="<?php echo $basepath4->F_WWWPATH.$v->brow_cover_map;?>" target="_blank"><img src="<?php echo $basepath4->F_WWWPATH.$v->brow_cover_map;?>" width="50"></a></div>
                                <script>we.uploadpic('gf_brow_data_brow_<?php echo $v->id;?>', '<?php echo $picprefix4; ?>');</script>
                                <input id="gf_brow_data_brow_<?php echo $v->id;?>" name="gf_brow_data[<?php echo $v->id;?>][brow_cover_map]" value="<?php echo $v->brow_cover_map;?>" type="hidden">
                                
                                </td>
                                <td>
<?php if($v->brow_img!=''){?><div class="upload_img fl" id="upload_pic_gf_brow_data_img_<?php echo $v->id;?>"><a href="<?php echo $basepath5->F_WWWPATH.$v->brow_img;?>" target="_blank"><img src="<?php echo $basepath5->F_WWWPATH.$v->brow_img;?>" width="50"></a></div><?php } ?>
                                <script>we.uploadpic('gf_brow_data_img_<?php echo $v->id;?>', '<?php echo $picprefix5; ?>');</script>
                                <input id="gf_brow_data_img_<?php echo $v->id;?>" name="gf_brow_data[<?php echo $v->id;?>][brow_img]" value="<?php echo $v->brow_img;?>" type="hidden">
                                </td>
                                    <td><textarea name="gf_brow_data[<?php echo $v['id'];?>][intro]" class="input-text" style="width:80%;height:80px;" placeholder="请输入表情标签"><?php echo $v['brow_img_label'];?></textarea></td>
                                    <td width="50"><a class="btn" href="javascript:;" onclick="fnDeleteProgram(this);" title="删除"><i class="fa fa-trash-o"></i></a></td>
                                  </tr>
                                  <script>
								 pic_num=<?php echo $v->id;?>;
                                </script>
                                  <?php }?>
                                </table>
                      </td>
                    </tr><!--子图片结束-->
                    <tr>
                        <td>表情包</td>
                        <td><input onclick="fnAddProgram();" class="btn" type="button" value="添加行"></td>
                    </tr>
                    
                    <tr>
                    	<td>可执行操作</td>
                    	<td>
                    	  <?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核','tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                   		  <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>

                </table>
                
<?php //$basepath2=BasePath::model()->getPath(275);$picprefix2='';if($basepath2!=null){ $picprefix2=$basepath2->F_CODENAME; }?>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->

    <?php $this->endWidget();?>
  </div><!--box-detail end-->
</div><!--box end-->
<script>
	//从图库选择图片
var $Single=$('#brow_patent');
    $('#patent_select_btn').on('click', function(){
		var club_id=$('#GfBrow_club_id').val();
        $.dialog.data('app_icon', 0);
        $.dialog.open('<?php echo $this->createUrl("gfMaterial/materialPictureAll", array('type'=>252,'fd'=>240));?>&club_id='+club_id,{
            id:'patent',
            lock:true,
            opacity:0.3,
            title:'请选择素材',
            width:'100%',
            height:'90%',
            close: function () {
                if($.dialog.data('material_id')>0){
                    $Single.val($.dialog.data('app_icon')).trigger('blur');

                    $('#upload_pic_brow_patent').html('<a href="<?php echo $basepath1->F_WWWPATH;?>'+art.dialog.data('app_icon')
                    +'" target="_blank"> <img src="<?php echo $basepath1->F_WWWPATH;?>'+art.dialog.data('app_icon')
                    +'"  width="100"></a>');


               }

            }
        });
    });
	
	var $Single=$('#brow_pic');
    $('#pic_select_btn').on('click', function(){
		var club_id=$('#GfBrow_club_id').val();
        $.dialog.data('app_icon', 0);
        $.dialog.open('<?php echo $this->createUrl("gfMaterial/materialPictureAll", array('type'=>252,'fd'=>238));?>&club_id='+club_id,{
            id:'pic',
            lock:true,
            opacity:0.3,
            title:'请选择素材',
            width:'100%',
            height:'90%',
            close: function () {
                if($.dialog.data('material_id')>0){
                    $Single.val($.dialog.data('app_icon')).trigger('blur');

                    $('#upload_pic_brow_pic').html('<a href="<?php echo $basepath2->F_WWWPATH;?>'+art.dialog.data('app_icon')
                    +'" target="_blank"> <img src="<?php echo $basepath2->F_WWWPATH;?>'+art.dialog.data('app_icon')
                    +'"  width="100"></a>');

               }

            }
        });
    });
	
	var $Single=$('#brow_banner');
    $('#banner_select_btn').on('click', function(){
		var club_id=$('#GfBrow_club_id').val();
        $.dialog.data('app_icon', 0);
        $.dialog.open('<?php echo $this->createUrl("gfMaterial/materialPictureAll", array('type'=>252,'fd'=>239));?>&club_id='+club_id,{
            id:'banner',
            lock:true,
            opacity:0.3,
            title:'请选择素材',
            width:'100%',
            height:'90%',
            close: function () {
                if($.dialog.data('material_id')>0){
                    $Single.val($.dialog.data('app_icon')).trigger('blur');

                    $('#upload_pic_brow_banner').html('<a href="<?php echo $basepath3->F_WWWPATH;?>'+art.dialog.data('app_icon')
                    +'" target="_blank"> <img src="<?php echo $basepath3->F_WWWPATH;?>'+art.dialog.data('app_icon')
                    +'"  width="100"></a>');

               }

            }
        });
    });
	
	function accountOnchang(obj){
        var changval=$(obj).val();
        if (changval.length>=6) {
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('validate');?>&gf_account='+changval,
                data: {gf_account:changval},
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    if(data.status==1){
                        $('#GfBrowList_gf_name').val(data.real_name);
                        $('#GfBrowList_gf_id').val(data.gfid);
                    }
                    else{
                        $(obj).val('');
                        we.msg('minus', data.msg);
                    }
                }
            });
        }
    }

	
// 添加删除更新节目
var $gf_brow_data=$('#gf_brow_data');
var num= pic_num+1;

var fnAddProgram=function(){
var b_html='';
b_html = b_html +'<tr><input type="hidden" class="input-text" name="gf_brow_data['+num+'][id]" value="null" />'+
	'<td>'+
	'<div class="upload_img fl" id="upload_pic_gf_brow_data_brow_'+num+'"><a href="" target="_blank"><img src="" width="50"></a></div>'+
	'<input id="gf_brow_data_brow_'+num+'" name="gf_brow_data['+num+'][brow_cover_map]"  type="hidden" />'+
	'<span id="box_gf_brow_data_brow_'+num+'"></span></td>'+
	'<td>'+
	'<div class="upload_img fl" id="upload_pic_gf_brow_data_img_'+num+'"><a href="" target="_blank"><img src="" width="50"></a></div>'+
	'<input id="gf_brow_data_img_'+num+'" name="gf_brow_data['+num+'][brow_img]"  type="hidden" />'+
	'<span id="box_gf_brow_data_img_'+num+'"></span></td>'+
	'<td>'+
	'<textarea name="gf_brow_data['+num+'][intro]" class="input-text" style="width:80%;height:80px;" placeholder="请输入表情标签"></textarea>'+
	'</td>'+
	'<td width="50"><a class="btn" href="javascript:;" onclick="fnDeleteProgram(this);" title="删除"><i class="fa fa-trash-o"></i></a></td>'+
'</tr>';
$gf_brow_data.append(b_html);
we.uploadpic('gf_brow_data_brow_'+num, '<?php echo $picprefix4;?>');
we.uploadpic('gf_brow_data_img_'+num, '<?php echo $picprefix5;?>');
        //$gf_brow_data.attr('data-num',num);
        num++;
}


var fnDeleteProgram=function(op){
    $(op).parent().parent().remove();
    fnUpdateProgram();
};	

    var fnUpdateProgram=function(){
        var isEmpty=true;
        $gf_brow_data.find('.input-text').each(function(){
            if($(this).val()!=''){
                isEmpty=false;
                //return false;
            }
        });
        if(!isEmpty){
            $('#InviteCardSet_programs_list').val('1').trigger('blur');
        }else{
            $('#InviteCardSet_programs_list').val('').trigger('blur');
        }
    };
</script>
