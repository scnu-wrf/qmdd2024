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
						<td><?php echo $form->labelEx($model, 'gf_account'); ?></td>
						<td>
							<?php echo $form->textField($model, 'gf_account', array('class'=>'input-text','oninput' =>'accountOnchang(this)','onpropertychange' =>'accountOnchang(this)')); ?>
							<?php echo $form->error($model, 'gf_account', $htmlOptions = array()); ?>
						</td>		
                    </tr>
					<tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'gf_name'); ?></td>
                        <td width="35%">
							<?php echo $form->textField($model, 'gf_name', array('class' => 'input-text')); ?>
                        	<?php echo $form->hiddenField($model, 'gf_id', array('class' => 'input-text')); ?>
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
                        <td>//，白黄双龙齐双飞
                            <?php echo $form->hiddenField($model, 'brow_patent', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(240);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->brow_patent!=''){?><div class="upload_img fl" id="upload_pic_brow_patent"><a href="<?php echo $basepath->F_WWWPATH.$model->brow_patent;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->brow_patent;?>" width="100"></a></div><?php }?>
                            <input style="margin-left:5px;" id="patent_select_btn" class="btn" type="button" value="图库选择" >
                            <script>we.uploadpic('<?php echo get_class($model);?>_brow_patent','<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'brow_patent', $htmlOptions = array()); ?>
                        </td>
                        
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'brow_pic'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'brow_pic', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(238);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->brow_pic!=''){?><div class="upload_img fl" id="upload_pic_brow_pic"><a href="<?php echo $basepath->F_WWWPATH.$model->brow_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->brow_pic;?>" width="100"></a></div><?php }?>
                            <input style="margin-left:5px;" id="pic_select_btn" class="btn" type="button" value="图库选择" >
                            <script>we.uploadpic('<?php echo get_class($model);?>_brow_pic','<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'brow_pic', $htmlOptions = array()); ?>
                        </td>
                        
                    </tr>
					<tr>
                        <td><?php echo $form->labelEx($model, 'brow_banner'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'brow_banner', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(239);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->brow_banner!=''){?><div class="upload_img fl" id="upload_pic_brow_banner"><a href="<?php echo $basepath->F_WWWPATH.$model->brow_banner;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->brow_banner;?>" width="100"></a></div><?php }?>
                            <input style="margin-left:5px;" id="banner_select_btn" class="btn" type="button" value="图库选择" >
                            <script>we.uploadpic('<?php echo get_class($model);?>_brow_banner','<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'brow_banner', $htmlOptions = array()); ?>
                        </td>
                        
                    </tr>
					
					<tr><!--表情图-->
                     <td><?php echo $form->labelEx($model, 'gf_brow_data'); ?></td>
                     <td>
                            <?php echo $form->hiddenField($model, 'gf_brow_data', array('class' => 'input-text')); ?>
                            <div class="upload_img fl" id="upload_pic_gf_brow_data">
                                <?php $basepath=BasePath::model()->getPath(237);$picprefix='';
                                if($basepath!=null){ $picprefix=$basepath->F_CODENAME; } ?>
                                <script>
								var pic_num=0;
                                </script>
                                <table id="gf_brow_data">
                                <?php if(!empty($gf_brow_data)) foreach($gf_brow_data as $v) { ?>
                                  <tr>
                                    <td width="150"><input type="hidden" name="gf_brow_data[<?php echo $v['id'];?>][id]" value="<?php echo $v['id'];?>" ><input type="hidden" name="gf_brow_data[<?php echo $v['id'];?>][pic]" value="<?php echo $v['brow_cover_map'];?>" ><a class="picbox" data-savepath="<?php echo $v['brow_cover_map'];?>" 
                                href="<?php echo $basepath->F_WWWPATH.$v['brow_cover_map'];?>" target="_blank">
                                <img src="<?php echo $basepath->F_WWWPATH.$v['brow_cover_map'];?>" width="100">
                                </a></td>
                                    <td><textarea oninput="LimitText(this)" onpropertychange="LimitText(this)" name="gf_brow_data[<?php echo $v['id'];?>][intro]" class="input-text" style="width:80%;height:80px;" placeholder="请输入表情标签"><?php echo $v['brow_img_label'];?></textarea></td>
                                    <td width="50"><a class="btn" href="javascript:;" onclick="fnDelPic(this);" title="删除"><i class="fa fa-trash-o"></i></a></td>
                                  </tr>
                                  <script>
								 pic_num=<?php echo $v['id'];?>;
                                </script>
                                  <?php }?>
                                </table>
                            </div>
							<script>         
							  we.uploadpic('<?php echo get_class($model);?>_gf_brow_data','<?php echo $picprefix;?>','','',function(e1,e2){fnscrollPic(e1.savename,e1.allpath);},50);
							</script>
                            <?php echo $form->error($model, 'gf_brow_data', $htmlOptions = array()); ?>
                         
                      </td>
                    </tr><!--子图片结束-->
					
                    <tr>
                    	<td>可执行操作</td>

                    	<td>
                    	  <?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核','tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                   		  <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>

                </table>
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

                    $('#upload_pic_brow_patent').html('<a href="<?php echo $basepath->F_WWWPATH;?>'+art.dialog.data('app_icon')
                    +'" target="_blank"> <img src="<?php echo $basepath->F_WWWPATH;?>'+art.dialog.data('app_icon')
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

                    $('#upload_pic_brow_pic').html('<a href="<?php echo $basepath->F_WWWPATH;?>'+art.dialog.data('app_icon')
                    +'" target="_blank"> <img src="<?php echo $basepath->F_WWWPATH;?>'+art.dialog.data('app_icon')
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

                    $('#upload_pic_brow_banner').html('<a href="<?php echo $basepath->F_WWWPATH;?>'+art.dialog.data('app_icon')
                    +'" target="_blank"> <img src="<?php echo $basepath->F_WWWPATH;?>'+art.dialog.data('app_icon')
                    +'"  width="100"></a>');

               }

            }
        });
    });
	
	///////////////////////////// 删除图片
	var fnDelPic=function(op){
		$(op).parent().parent().remove();
	}
	/////////////////////////////////////////////////////////////////////
	// 上传完成时图片处理
	var fnscrollPic=function(savename,allpath){
		pic_num++;
		$gf_brow_data.append('<tr><td width="150"><input type="hidden" name="gf_brow_data['+pic_num+'][id]" value="null" ><input type="hidden" name="gf_brow_data['+pic_num+'][pic]" value="'+savename+'" ><a class="picbox" data-savepath="'+savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"></a></td><td><textarea oninput="LimitText(this)" onpropertychange="LimitText(this)" name="gf_brow_data['+pic_num+'][intro]" class="input-text" style="width:80%;height:80px;" placeholder="请输入表情标签"></textarea></td><td width="50"><a class="btn" href="javascript:;" onclick="fnDelPic(this);" title="删除"><i class="fa fa-trash-o"></i></a>');

		//fnUpdatescrollPic();
	};
	
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
	
	// 滚动图片处理
	var $gf_brow_data=$('#gf_brow_data');
	var $upload_pic_gf_brow_data=$('#upload_pic_gf_brow_data');
	var $upload_box_scroll_pic_img=$('#upload_box_scroll_pic_img');
	
	// 添加图片到$model->gf_brow_data;
    var arr1=[];
    $upload_pic_gf_brow_data.find('a').each(function(){
        arr1.push($(this).attr('data-savepath'));
    });
    $gf_brow_data.val(we.implode(',',arr1));
    $upload_box_scroll_pic_img.show();

</script>
