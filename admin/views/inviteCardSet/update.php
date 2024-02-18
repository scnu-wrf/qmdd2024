<?php
$action=$_GET['r'];
//echo $action.'<br>';
//$aa='inviteCardSet/';
//echo strlen($aa).'<br>';
$action2 = substr($action,14,1);
//echo $action2;
    $TypeArray = array(
        '0'=>'固定文字',
        '1'=>'二维码',
        '2'=>'固定图片',
        '3'=>'直线',
        '4'=>'模板文字',
        '5'=>'模板图片'			
    );

    $txt_alignArray = array(
        '0'=>'左对齐',
        '1'=>'居中',
        '2'=>'右对齐'
    );
	
    $txt_typefaceArray = array(
        '0'=>'normal',
        '1'=>'sans_serif',
        '2'=>'monospace'
    );
	


    $txt_styleArray = array(
        '0'=>'正常',
        '1'=>'加粗',
        '2'=>'斜体',
        '3'=>'加粗斜体'
    );

    $data1 = array(
        'gfname'=>'用户昵称',
        'title'=>'标题',
        'content'=>'简介',
        'time'=>'时间',
        'club_name'=>'发布单位'
    );
    $data2 = array(
        'icon'=>'用户头像',
        'pic'=>'信息图片'
    );
?>
<style type="text/css">
.inputstyle {
width: 40px;
line-height: 20px;
}
.inputstyle2 {
width: 80px;
line-height: 20px;
}



</style>
<div class="box">
  <div class="box-title c">
    <h1><span> <i class="fa fa-home"></i>当前界面：直播》直播设置》邀请卡设置》<a class="nav-a">
<?php echo $action2 == 'c'  ?  '添加' : '编辑';?></a></span></h1>
    <span class="back"> <a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a> </span> </div>
  <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list());?>
    <div class="box-detail-bd">
      <div style="display:block;" class="box-detail-tab-item">
        <div class="mt15">
          <table  width="100%" style="table-layout:auto;">
            <tr class="table-title">
              <td colspan="2">邀请卡信息</td>
            </tr>
            <tr>
              <td width="11%"><?php echo $form->labelEx($model, 'card_code'); ?></td>
              <td width="89%"><?php echo $form->textField($model, 'card_code', array('class' => 'input-text')); ?><?php echo $form->error($model, 'card_code', $htmlOptions = array()); ?></td>
            </tr>
            <tr>
              <td width="11%"><?php echo $form->labelEx($model, 'card_name'); ?></td>
              <td width="89%"><?php echo $form->textField($model, 'card_name', array('class' => 'input-text')); ?><?php echo $form->error($model, 'card_name', $htmlOptions = array()); ?></td>
            </tr>
            <tr>
              <td width="11%"><?php echo $form->labelEx($model, 'card_img'); ?></td>
              <td width="89%"><?php echo $form->hiddenField($model, 'card_img', array('class' => 'input-text fl')); ?>
                <?php $basepath=BasePath::model()->getPath(274);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                <?php if($model->card_img!=''){?>
                <div class="upload_img fl" id="upload_pic_VideoLive_card_img"><a href="<?php echo BasePath::model()->get_www_path().$model->card_img;?>" target="_blank"><img src="<?php echo BasePath::model()->get_www_path().$model->card_img;?>" width="100"></a></div>
                <?php }?>
                <script>we.uploadpic('<?php echo get_class($model);?>_card_img','<?php echo $picprefix;?>');</script> 
                <?php echo $form->error($model, 'card_img', $htmlOptions = array()); ?> 
                <!--<span class="msg">1042*447</span>--></td>
            </tr>
            <tr>
              <td width="11%"><?php echo $form->labelEx($model, 'card_height'); ?></td>
              <td width="89%"><?php echo $form->textField($model, 'card_height', array('class' => 'input-text')); ?><?php echo $form->error($model, 'card_height', $htmlOptions = array()); ?></td>
            </tr>
            <tr>
              <td><?php echo $form->labelEx($model, 'card_width'); ?></td>
              <td><?php echo $form->textField($model, 'card_width', array('class' => 'input-text')); ?><?php echo $form->error($model, 'card_width', $htmlOptions = array()); ?></td>
            </tr>
            <tr>
              <td>是否使用</td>
              <td><?php echo $form->radioButtonList($model, 'state',array(649=>'是', 648=>'否'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?></td>
            </tr>

    
            
          </table>
          

<?php $basepath2=BasePath::model()->getPath(275);$picprefix2='';if($basepath2!=null){ $picprefix2=$basepath2->F_CODENAME; }?>
          <?php echo $form->hiddenField($model, 'programs_list'); ?>
          
                <table width="100%" id="program_list" class="showinfo" data-num="new"  style="overflow: auto;  margin:10px 0 0 0;table-layout:auto;">            <tr  class="table-title">
              <td  colspan="15" style="text-align:left;">邀请卡内容设置</td>
            </tr>
                  <tr class="table-title">
                    <td width="10%">类型</td>
                    <td width="7%">内容</td>
                    <td width="8%">高<br>（像素px）</td>
                    <td width="6%">宽<br>(像素px)</td>
                    <td width="6%">起点坐标x(像素px)</td>
                    <td width="6%">起点坐标y(像素px)</td>
                    <td width="7%">对齐方式</td>
                    <td width="6%">文字大小(像素px)</td>
                    <td width="7%">系统字体</td>
                    <td width="6%">自定义字体</td>
                    <td width="13%">字体文件</td>
                    <td width="7%">字体样式</td>
                    <td width="3%">图片圆角直径</td>
                    <td width="6%">颜色<br>(A,R,G,B)</td>
                    <td width="5%">操作</td>
                  </tr>
                  <?php $num =0;if(!empty($programs))foreach($programs as $v){?>
                  <tr>
                    <td><select name="programs_list[<?php echo $num;?>][wordType]" onchange="changeWordType(this,<?php echo $num; ?>);">
                        <option value="">内容类型</option>
                        <?php foreach ($TypeArray as $key => $value) {    ?>
                        <?php  if($key == $v->type){ ?>
                        <option value="<?php echo $key?>" selected><?php echo $value?></option>
                        <?php  }else{ ?>
                        <option value="<?php echo $key?>"><?php echo $value?></option>
                        <?php  } ?>
                        <?php }?>
                      </select>
                      <select name="programs_list[<?php echo $num;?>][content_type]" id="content_type_<?php echo $num; ?>">
                        <option value="">请选择</option>
                        <?php
                                                    	if($v->type==4){
															$data3 = $data1;
														}
														elseif($v->type==5){
															$data3 = $data2;
                                                        }
                                                        else{
                                                            $data3 = array();
                                                        }
														foreach($data3 as $key => $val) {
													?>
                        <option value="<?php echo $key; ?>" <?php if($v->content_type==$key) echo 'selected'; ?>><?php echo $val; ?></option>
                        <?php }?>
                      </select></td>
                    <td><input name="programs_list[<?php echo $num;?>][id]" value="<?php echo $v->id;?>" type="hidden" />
                      <input class="inputstyle2" name="programs_list[<?php echo $num;?>][content]" value="<?php echo $v->content;?>"></td>
                    <td><input class="inputstyle"  name="programs_list[<?php echo $num;?>][height]" value="<?php echo $v->height;?>"></td>
                    <td><input class="inputstyle"  name="programs_list[<?php echo $num;?>][width]" value="<?php echo $v->width;?>"></td>
                    <td><input class="inputstyle"  name="programs_list[<?php echo $num;?>][x]" value="<?php echo $v->x;?>"></td>
                    <td><input class="inputstyle"  name="programs_list[<?php echo $num;?>][y]" value="<?php echo $v->y;?>"></td>
                    <td><select  name="programs_list[<?php echo $num;?>][txt_align]">
                        <?php foreach ($txt_alignArray as $key => $value) {?>
                        <?php if($key == $v->txt_align){ ?>
                        <option value="<?php echo $key?>" selected><?php echo $value?></option>
                        <?php }else{ ?>
                        <option value="<?php echo $key?>"><?php echo $value?></option>
                        <?php } ?>
                        <?php }?>
                      </select></td>
                    <td><input class="inputstyle"  name="programs_list[<?php echo $num;?>][txt_size]" value="<?php echo $v->txt_size;?>"></td>
                    <td>
                    
                    <!--<input class="inputstyle"  name="programs_list[<?php //echo $num;?>][txt_typeface]" value="<?php //echo $v->txt_typeface;?>">-->
                    
                     <select  name="programs_list[<?php echo $num;?>][txt_typeface]">
                        <?php foreach ($txt_typefaceArray as $key => $value) {?>
                        <?php if($key == $v->txt_typeface){ ?>
                        <option value="<?php echo $key?>" selected><?php echo $value?></option>
                        <?php }else{ ?>
                        <option value="<?php echo $key?>"><?php echo $value?></option>
                        <?php } ?>
                        <?php }?>
                      </select>
                    
                    </td>
                    
                         <td><input class="inputstyle"  name="programs_list[<?php echo $num;?>][txt_typeface_familyname]" value="<?php echo $v->txt_typeface_familyname;?>"></td>
                    <td>
                    <div id="upload_file_programs_list_<?php echo $num;?>"><a href="<?php echo $basepath->F_WWWPATH.$v->txt_typeface_path;?>" target="_blank"> <?php echo $v->txt_typeface_path;?></a></div>
                      <script>we.uploadfont('programs_list_<?php echo $num;?>', '<?php echo $picprefix2; ?>');</script>
                                <input id="programs_list_<?php echo $num;?>" name="programs_list[<?php echo $num;?>][txt_typeface_path]" value="<?php echo $v->txt_typeface_path;?>" type="hidden">
                                    
                    
                    </td>
                    <td><!--<input class="inputstyle"  name="programs_list[<?php //echo $v->id;?>][txt_style]" value="<?php //echo $v->txt_style;?>">-->
                      
                      <select  name="programs_list[<?php echo $num;?>][txt_style]">
                        <?php foreach ($txt_styleArray as $key => $value) {?>
                        <?php if($key == $v->txt_style){ ?>
                        <option value="<?php echo $key?>" selected><?php echo $value?></option>
                        <?php }else{ ?>
                        <option value="<?php echo $key?>"><?php echo $value?></option>
                        <?php } ?>
                        <?php }?>
                      </select></td>

                    <td><input class="inputstyle"  name="programs_list[<?php echo $num;?>][fillet_diameter]" value="<?php echo $v->fillet_diameter;?>"></td>
                    <td><input class="inputstyle"  name="programs_list[<?php echo $num;?>][color_argb]" value="<?php echo $v->color_argb;?>"></td>
                    <td style="text-align:left;"><input onclick="fnAddProgram();" class="btn" type="button" value="添加行">
                      &nbsp;
                      <input onclick="fnDeleteProgram(this);" class="btn" type="button" value="删除"></td>
                  </tr>
                  <?php $num++; }else{?>
                  <tr>
                    <td><select  name="programs_list[new][wordType]" onchange="changeWordType(this,'num');">
                        <option value="">选择类型</option>
                        <?php foreach ($TypeArray as $key => $value) {?>
                        <option value="<?php echo $key?>"><?php echo $value?></option>
                        <?php }	?>
                      </select>
                      <select name="programs_list[new][content_type]" id="content_type_num" >
                        <option value="">内容类型</option>
                      </select></td>
                    <td><input name="programs_list[new][id]" value="null" type="hidden" />
                      <input class="inputstyle2" name="programs_list[new][content]"></td>
                    <td><input class="inputstyle"  name="programs_list[new][height]" ></td>
                    <td><input class="inputstyle"  name="programs_list[new][width]" ></td>
                    <td><input class="inputstyle"  name="programs_list[new][x]"></td>
                    <td><input class="inputstyle"  name="programs_list[new][y]"></td>
                    <!--<td><input class="inputstyle"  name="programs_list[new][txt_align]"></td>-->
                    <td><select  name="programs_list[new][txt_align]">
                        <option value="">请选择:</option>
                        <?php 	foreach ($txt_alignArray as $key => $value) { ?>
                        <option value="<?php echo $key?>"><?php echo $value?></option>
                        <?php }?>
                      </select></td>
                    <td><input class="inputstyle"  name="programs_list[new][txt_size]"></td>
                    <td>
                    
                    <!--<input class="inputstyle"  name="programs_list[new][txt_typeface]">-->
                    <select  name="programs_list[new][txt_typeface]">
                        <option value="">请选择:</option>
                        <?php 	foreach ($txt_typefaceArray as $key => $value) { ?>
                        <option value="<?php echo $key?>"><?php echo $value?></option>
                        <?php }?>
                      </select>
                    
                    </td>
                    
                    
                    <td><input class="inputstyle"  name="programs_list[new][txt_typeface_familyname]"></td>
                    <td>
                    
                   <div id="upload_file_attr_list_new"></div>
                   <input id="programs_list_new" name="programs_list[new][txt_typeface_path]" value="" type="hidden" />
                   <span id="box_programs_list_new"></span>
                   <script>we.uploadfont('programs_list_new', '<?php echo $picprefix2; ?>');</script>

            
</td>
                    <!--<td><input class="inputstyle"  name="programs_list[new][txt_style]"></td>-->
                    <td><select  name="programs_list[new][txt_style]">
                        <option value="">请选择:</option>
                        <?php 	foreach ($txt_styleArray as $key => $value) { ?>
                        <option value="<?php echo $key?>"><?php echo $value?></option>
                        <?php }?>
                      </select></td>
                    
                    <td><input class="inputstyle"  name="programs_list[new][fillet_diameter]"></td>
                    <td><input class="inputstyle"  name="programs_list[new][color_argb]"></td>
                    <td style="text-align:left;"><input onclick="fnAddProgram();" class="btn" type="button" value="添加行"></td>
                  </tr>
                  <?php }?>
                </table>
                <?php echo $form->error($model, 'programs_list', $htmlOptions = array()); ?>
                
        </div>
      </div>
      <!--box-detail-tab-item end   style="display:block;"--> 
    </div>
    <!--box-detail-bd end-->
    <div class="box-detail-submit"> <?php echo show_shenhe_box(array('baocun'=>'确定'));?>
      <button class="btn" type="button" onclick="we.back();">取消</button>
    </div>
    <?php $this->endWidget(); ?>
  </div>
  <!--box-detail end--> 
</div>
<!--box end--> 




<script>
    // 添加删除更新节目
    var $program_list=$('#program_list');
        var num=<?php echo $num; ?>+1;
    var fnAddProgram=function(){
        //console.log(num);
        $program_list.append(
            '<tr>'+
                //'<td><input class="inputstyle" name="programs_list['+num+'][wordType]"></td>'+
                '<td>'+
                    "<select  name='programs_list["+num+"][wordType]' onchange='changeWordType(this,\""+num+"\");'>"+
                        '<option value="">选择类型</option>'+
                        '<?php foreach ($TypeArray as $key => $value) {   ?>'+
                            '<option value="<?php echo $key?>"><?php echo $value?></option>'+
                        '<?php } ?>'+
                    '</select>'+
                    '<select  name="programs_list['+num+'][content_type]" id="content_type_'+num+'">'+
                        '<option value="">内容类型</option>'+
                    '</select>'+
                '</td>'+
                '<td><input name="programs_list['+num+'][id]" value="null" type="hidden"  /><input class="inputstyle2" name="programs_list['+num+'][content]"></td>'+
                '<td><input class="inputstyle" name="programs_list['+num+'][height]"></td>'+
                '<td><input class="inputstyle" name="programs_list['+num+'][width]"></td>'+
                '<td><input class="inputstyle" name="programs_list['+num+'][x]"></td>'+ 
                '<td><input class="inputstyle" name="programs_list['+num+'][y]"></td>'+
                //'<td><input class="inputstyle" name="programs_list['+num+'][txt_align]"></td>'+
				
                '<td><select  name="programs_list['+num+'][txt_align]"><option value="">请选择:</option><?php foreach ($txt_alignArray as $key => $value) {   ?><option value="<?php echo $key?>"><?php echo $value?></option><?php } ?></select></td>'+
				
                '<td><input class="inputstyle" name="programs_list['+num+'][txt_size]"></td>'+ 
				
               // '<td><input class="inputstyle" name="programs_list['+num+'][txt_typeface]"></td>'+
			   
			    '<td><select  name="programs_list['+num+'][txt_typeface]"><option value="">请选择:</option><?php foreach ($txt_typefaceArray as $key => $value) {   ?><option value="<?php echo $key?>"><?php echo $value?></option><?php } ?></select></td>'+
			   
				  '<td><input class="inputstyle" name="programs_list['+num+'][txt_typeface_familyname]"></td>'+
 '<td>'+
'<div id="upload_file_attr_list_'+num+'"></div>'+
'<input id="programs_list_'+num+'" name="programs_list['+num+'][txt_typeface_path]"  type="hidden" />'+
'<span id="box_programs_list_'+num+'"></span>'+
'<script>we.uploadfont("programs_list_'+num+'", "<?php echo $picprefix2; ?>");<\/script>'+

'</td>'+
		
				
				
                // '<td><input class="inputstyle" name="programs_list['+num+'][txt_style]"></td>'+ 
                '<td><select  name="programs_list['+num+'][txt_style]"><option value="">请选择:</option><?php foreach ($txt_styleArray as $key => $value) {   ?><option value="<?php echo $key?>"><?php echo $value?></option><?php } ?></select></td>'+
              
                '<td><input class="inputstyle" name="programs_list['+num+'][fillet_diameter]"></td>'+ 
                '<td><input class="inputstyle" name="programs_list['+num+'][color_argb]"></td>'+ 	
                '<td style="text-align:left;"><input onclick="fnAddProgram();" class="btn" type="button" value="添加行">&nbsp;<input onclick="fnDeleteProgram(this);" class="btn" type="button" value="删除"></td>'+
            '</tr>'
        );
        $program_list.attr('data-num',num);
        num++;
    };

    var fnDeleteProgram=function(op){
        $(op).parent().parent().remove();
        fnUpdateProgram();
    };

    var fnUpdateProgram=function(){
        var isEmpty=true;
        $program_list.find('.input-text').each(function(){
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

    var data1 = <?php echo json_encode($data1); ?>;
    var data2 = <?php echo json_encode($data2); ?>;
    var a = <?php echo count($data1); ?>;
    function changeWordType(obj,num){
        var show_id=$(obj).val();
        //console.log(show_id+'****'+num);
        var s_html = '<option value>内容类型</option>';
        if(show_id==4){
            for(var i in data1){
                s_html += '<option value="'+i+'">'+data1[i]+'</option>';
            }
        }
        else if(show_id==5){
            for(var j in data2){
                s_html += '<option value="'+j+'">'+data2[j]+'</option>';
            }
        }
       // console.log(s_html);
        $('#content_type_'+num).html(s_html);
    }
	
	

</script>