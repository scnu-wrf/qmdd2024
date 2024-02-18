<div class="box-detail-bd">
            <div style="display:<?php echo $st1; ?>;" class="box-detail-tab-item">
                <table class="table-title">
                    <tr>
                        <td>基本信息</td>
                    </tr>
                </table>
                <table>                    
                    <tr> 
                        <td width="15%"><?php echo $form->labelEx($model, 'f_typeid'); ?></td>
                        <td width="35%"><?php echo $form->hiddenField($model, 'f_typeid'); ?>
                        <?php echo $typename; ?>
                        <?php echo $form->error($model, 'f_typeid', $htmlOptions = array()); ?>
                        </td>
                        <td width="15%"><?php echo $form->labelEx($model, 't_stypeid'); ?></td>
                        <td width="35%">
                             <?php echo $form->dropDownList($model, 't_stypeid', Chtml::listData(QmddServerUsertype::model()->getType($type), 'id', 'f_uname'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 't_stypeid', $htmlOptions = array()); ?>
                        </td>
                    </tr> 
                    <tr>
                        <td><?php echo $form->labelEx($model, 'set_code'); ?></td>
                        <td><?php echo $model->set_code; ?></td>
                         <td><?php echo $form->labelEx($model, 'server_start'); ?></td>
                         <td>
                            <?php echo $form->textField($model, 'server_start', array('class' => 'input-text','onclick'=>'fnSetDate(this);')); ?>
                            <?php echo $form->error($model, 'server_start', $htmlOptions = array()); ?>
                         </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'set_name'); ?></td>
                        <td><?php echo $form->textField($model, 'set_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'set_name', $htmlOptions = array()); ?>
                        </td>
                         <td><?php echo $form->labelEx($model, 'server_end'); ?></td>
                         <td>
                             <?php echo $form->textField($model, 'server_end', array('class' => 'input-text','onclick'=>'fnSetDate(this);')); ?>
                             <?php echo $form->error($model, 'server_end', $htmlOptions = array()); ?>
                         </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'star_time'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'star_time', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'star_time', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'end_time'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'end_time', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'end_time', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'if_user_state'); ?></td>
                        <td colspan="3">
                            <?php echo $form->radioButtonList($model, 'if_user_state', array(649=>'上线', 648=>'下线'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                            <?php echo $form->error($model, 'user_state_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>                                  
                </table>

 <table class="mt15 table-title">
    <tr><td>服务信息<input id="product_select_btn" class="btn" type="button" value="选择资源"></td></tr>
 </table>
 <script>
 var oldnum=0;
 var s_no=0;
 </script>
 <?php echo $form->hiddenField($model, 'product', array('class' => 'input-text')); ?>
 <div><!--场地资源-->
 <table>
    <tr>
        <td width="10%" style='text-align: center;'>序号</td>
        <td width="20%" style="text-align:center;">资源名称</td>
        <td width="10%" style="text-align:center;">资源等级</td>
        <td width="10%" style="text-align:center;">服务项目</td>
        <td width="15%" style="text-align:center;">场地类型</td>
        <td width="15%" style="text-align:center;">场地名称</td>
        <td width="10%" style="text-align:center;">操作</td>
     </tr>
</table>               
<table id="product">
 <?php $index = 1; ?>
<?php if(!empty($model->set_list)) foreach ($model->set_list as $v) { ?>
 <tr data-server="<?php echo $v->server_sourcer_id;?>">
   <td width="10%" style="text-align:center;"><?php echo $index ?></td>
   <td width="20%" title="<?php echo $v->s_name; ?>"><input type="hidden" name="product[<?php echo $v->id;?>][id]" value="<?php echo $v->id;?>" />
    <span style="display:inline-block;max-width: 20%;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><?php echo $v->s_name; ?></span>
<input type="hidden" name="product[<?php echo $v->id;?>][s_code]" value="<?php echo $v->s_code;?>" />
<input type="hidden" name="product[<?php echo $v->id;?>][s_name]" value="<?php echo $v->s_name;?>" />
<input type="hidden" name="product[<?php echo $v->id;?>][server_sourcer_id]" value="<?php echo $v->server_sourcer_id;?>" /></td>
   <td width="10%"><?php echo $v->s_levelname;?></td>
<?php if(!empty($v->project_ids)) $project=ProjectList::model()->findAll('id in('.$v->project_ids.')'); ?>
   <td width="10%"><?php if(!empty($project))foreach($project as $p) echo $p->project_name; ?></td>
   <td width="15%"><?php $sitetype=BaseCode::model()->getSiteType2($v->site_type); ?>
       <select name="product[<?php echo $v->id;?>][site_type]">
         <option value="<?php echo $v->site_type; ?>"><?php if(!empty($v->sitetype)) echo $v->sitetype->F_NAME; ?></option>
         <?php if (is_array($sitetype)) foreach ($sitetype as $k) { ?>
         <option value="<?php echo $k->f_id; ?>"><?php echo $k->F_NAME; ?></option>
         <?php } ?>
       </select></td>
    <td width="15%"><input type="text" class="input-text" name="product[<?php echo $v->id;?>][site_name]" value="<?php echo $v->site_name;?>" /></td>
   <td width="10%"><a class="btn" href="javascript:;" onclick="fnMemberprice(<?php echo $v->id;?>);" title="可约服务明细">可约服务明细</a>&nbsp;<a class="btn" href="javascript:;" onclick="fnDeleteProduct(this);" title="删除"><i class="fa fa-trash-o"></i></a></td>
   </tr>
 <script>
 var oldnum=<?php echo $v->id;?>;
 var s_no=<?php echo $index;?>;
 </script>
<?php $index++; } ?>                     
               </table>
</div>
<?php $basepath=BasePath::model()->getPath(258);?>
                <table class="table-title">
                    <tr>
                        <td>展示图文</td>
                    </tr>
                </table>
                <table>
                    <tr> 
                        <td width="15%"><?php echo $form->labelEx($model, 'info_pic'); ?></td>
                        <td><span id="show"></span>
                    <input id="ytQmddServerSetInfo_info_pic" type="hidden" value="" name="QmddServerSetInfo[info_pic]"><span id="QmddServerSetInfo_info_pic">
                    <?php if(!empty($infopic)) foreach ($infopic as $p) { ?><span class="check"><input class="input-check" id="QmddServerSetInfo_info_pic_<?php echo $p->id; ?>" value="<?php echo $p->logo_pic; ?>"<?php if($model->info_pic==$p->logo_pic) echo ' checked="checked"'; ?> type="radio" name="QmddServerSetInfo[info_pic]"><label for="QmddServerSetInfo_info_pic_<?php echo $p->id; ?>"><a href="<?php echo $basepath->F_WWWPATH.$p->logo_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$p->logo_pic;?>" width="100"></a></label></span>
                <?php } ?>
                    </span>
                            <?php echo $form->error($model, 'info_pic', $htmlOptions = array()); ?>
                        </td>
                    </tr>
<?php $p_num=0; ?>    
                    <tr> 
                        <td><?php echo $form->labelEx($model, 'info_prove'); ?></td>
                        <td>
                    <input id="ytQmddServerSetInfo_info_prove" type="hidden" value="" name="QmddServerSetInfo[info_prove]"><span id="QmddServerSetInfo_info_prove">
                    <?php if(!empty($infoprove)) foreach ($infoprove as $pr) { ?>
                    <span class="check"><input class="input-check" id="QmddServerSetInfo_info_prove_<?php echo $p_num; ?>" value="<?php echo $pr; ?>" <?php if(in_array($pr,$info_prove)) echo ' checked="checked"'; ?> type="checkbox" name="QmddServerSetInfo[info_prove][]"><label for="QmddServerSetInfo_info_prove_<?php echo $p_num; ?>"><a href="<?php echo $basepath->F_WWWPATH.$pr;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$pr;?>" width="100"></a></label></span>
                <?php $p_num++; } ?>
                    </span>
                            <?php echo $form->error($model, 'info_prove', $htmlOptions = array()); ?>
                        </td>
                    </tr>
<?php $d_num=0; ?>
                    <tr> 
                        <td><?php echo $form->labelEx($model, 'info_description'); ?></td>
                        <td>
                    <input id="ytQmddServerSetInfo_info_description" type="hidden" value="" name="QmddServerSetInfo[info_description]"><span id="QmddServerSetInfo_info_description">
                    <?php if(!empty($infopic)) foreach ($infopic as $d) { ?>
                    <span class="check"><input class="input-check" id="QmddServerSetInfo_info_description_<?php echo $d_num; ?>" value="<?php echo $d->description; ?>" <?php if(in_array($d->description,$info_description)) echo ' checked="checked"'; ?> type="checkbox" name="QmddServerSetInfo[info_description][]"><label for="QmddServerSetInfo_info_description_<?php echo $d_num; ?>"><?php echo $d->s_name; ?></label></span>
                <?php $d_num++; } ?>
                        </td>
                    </tr>
                </table> 
        <div class="mt15">
            <table>
                <tr>
                    <td width="15%">可执行操作</td>
                    <td>
                        <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div>             
    </div><!--box-detail-tab-item end-->
    <div style="display:<?php echo $st2; ?>;" class="box-detail-tab-item">
        <table class="table-title">
            <tr><td>服务时间价格设置</td></tr>
        </table>
<?php echo $form->hiddenField($model, 'setdata', array('class' => 'input-text')); ?>
        <table>
            <tr>
                <td width="25">服务资源</td>
                <td width="25">服务项目</td>
            <?php if(!empty($server_time)) foreach ($server_time as $t) { ?>
                <td><?php echo $t->start_time; ?><br><?php echo $t->end_time; ?></td>
            <?php }?>
            </tr>
    <?php if(!empty($model->set_list)) foreach ($model->set_list as $s) { ?>
            <tr>
                <td><?php echo $s->s_name; ?></td>
                <input type="hidden" name="setdata[<?php echo $s->id; ?>][list_id]" value="<?php echo $s->id; ?>">
<?php if(!empty($s->project_ids)) $project=ProjectList::model()->findAll('id in('.$s->project_ids.')'); ?>
                <td><?php if(!empty($project))foreach($project as $p)   echo $p->project_name; ?></td>
            <?php if(!empty($server_time)) foreach ($server_time as $t) { ?>
            <?php $price='';
            $set_data=QmddServerSetData::model()->find('(info_id='.$id.' and list_id='.$s->id.' and s_timename="'.$t->timename.'") order by id DESC');
            if(!empty($set_data)) $price=$set_data->sale_price; ?>
                <td><input class="input-text" type="text" name="setdata[<?php echo $s->id; ?>][<?php echo $t->timename; ?>]" value="<?php echo $price; ?>" style="width:70%;"></td>
            <?php }?>
            </tr>
<?php } ?>
        </table>
        <div class="mt15">
            <table>
                <tr>
                    <td width="15%">可执行操作</td>
                    <td>
                        <?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div><!--box-detail-bd end-->
<?php $site_type=BaseCode::model()->getCode(1517); ?>
<script>

	//添加服务资源
	$QmddServerSetInfo_product = $('#QmddServerSetInfo_product');
	$product = $('#product');
	var num=oldnum+1;
	 $('#product_select_btn').on('click', function(){
		var type = $('#QmddServerSetInfo_f_typeid').val();
		var html_str='';
        var idarr=[];
        var codearr=[];
        var namearr=[];
        var id='';
        var code='';
        var name='';
        var level='';
        var project='';
		if (club_id=='') {
			we.msg('minus','抱歉，系统没有获取到单位信息');
            return false;
		}
		if (type=='') {
			we.msg('minus','请先选择服务类型');
            return false;
		}
		
        $.dialog.data('product_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/server_sourcer");?>&club_id='+club_id+'&type='+type,{
            id:'fuwuziyuan',
            lock:true,
            opacity:0.3,
            title:'选择服务资源',
            width:'80%',
            height:'80%',
            close: function () {
                if($.dialog.data('id')==-1){
                    var boxnum=$.dialog.data('products');
                    for(var j=0;j<boxnum.length;j++) {
                        idarr.push(boxnum[j].dataset.id);
                        codearr.push(boxnum[j].dataset.code);
                        namearr.push(boxnum[j].dataset.name);            
                        level=boxnum[j].dataset.level;
                        project=boxnum[j].dataset.project;
                    }
                    id=we.implode(',',idarr);
                    code=we.implode(',',codearr);
                    name=we.implode('/',namearr);
                    s_no++;
                    html_str = html_str + '<tr data-server="'+id+'">'+
                    '<td width="10%" style="text-align: center;">'+s_no+'</td>'+
                    '<td width="20%">'+name+
                    '<input type="hidden" name="product['+num+'][id]" value="null" />'+
                    '<input type="hidden" name="product['+num+'][s_code]" value="'+code+'" />'+
                    '<input type="hidden" name="product['+num+'][s_name]" value="'+name+'" />'+
                    '<input type="hidden" name="product['+num+'][server_sourcer_id]" value="'+id+'" /></td>'+
                    '<td width="10%">'+level+'</td>'+
                    '<td width="10%">'+project+'</td>'+
                    '<td width="15%"><select name="product['+num+'][site_type]">'+
                        '<option value=" ">请选择</option><?php if (!empty($site_type)) foreach ($site_type as $s) { ?><option value="<?php echo $s->f_id; ?>"><?php echo $s->F_NAME; ?></option><?php } ?></select></td>'+
                    '<td width="15%"><input type="text" class="input-text" style="width:80%;" name="product['+num+'][site_name]" /></td>'+
                    '<td width="10%"><a class="btn" href="javascript:;" onclick="fnDeleteProduct(this);" title="删除">'
                    +'<i class="fa fa-trash-o"></i></a></td></tr>';
                    $product.append(html_str);
                    num++;
                    fnUpdateProduct();
                }
            }
        });
    });
</script> 
