<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>会员信息</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
   <div class="box-detail">
		<?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
            
            <table class="mt15">
            	<tr class="table-title">
                    <td colspan="4" >基本信息</td>
                </tr>
                <tr > 
                    <td width="15%"><?php echo $form->labelEx($model, 'card_code'); ?></td> 
                    <td width="35%">
                    	<?php echo $form->textField($model, 'card_code', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'card_code', $htmlOptions = array()); ?>
					</td>
                    <td width="15%"><?php echo $form->labelEx($model, 'mamber_type'); ?></td> 
                    <td width="35%">
                        <?php echo $form->dropDownList($model, 'type', Chtml::listData(BaseCode::model()->getCode(208), 'f_id', 'F_NAME'), 
                               array('prompt'=>'请选择','onchange' =>'selectOnchang(this)'));
                              $arr=BaseCode::model()->getMembertype();
                         ?>
<script> // html5中默认的script是javascript,故不需要特别指定script language 
var $d_club_type2= <?php echo json_encode($arr)?>;
</script> 

                            <?php echo $form->error($model, 'type', $htmlOptions = array()); ?>
                            <?php echo $form->dropDownList($model, 'mamber_type', Chtml::listData(BaseCode::model()->getMembertype_all(), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'mamber_type', $htmlOptions = array()); ?>
					</td> 
                </tr>
                <tr > 
                    
                    <td><?php echo $form->labelEx($model, 'card_name'); ?></td>
                    <td>
                    	<?php echo $form->textField($model, 'card_name', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'card_name', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'short_name'); ?></td>
                    <td>
                    	<?php echo $form->textField($model, 'short_name', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'short_name', $htmlOptions = array()); ?>
                    </td> 
                </tr> 
                <tr > 
                    <td><?php echo $form->labelEx($model, 'up_type'); ?></td> 
                    <td>
                    	<?php echo $form->radioButtonList($model, 'up_type', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'up_type', $htmlOptions = array()); ?>
					</td>
                    <td><?php echo $form->labelEx($model, 'if_project'); ?></td>
                    <td>
                    	<?php echo $form->radioButtonList($model, 'if_project', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'if_project', $htmlOptions = array()); ?>
                    </td> 
                </tr> 
                <tr>
                     <td><?php echo $form->labelEx($model, 'salesperson_show'); ?></td>
                     <td>
                         <?php echo $form->radioButtonList($model, 'salesperson_show', array(0=>'不显示', 1=>'显示'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                         <?php echo $form->error($model, 'salesperson_show', $htmlOptions = array()); ?>
                     </td>
					<td><?php echo $form->labelEx($model, 'charge'); ?></td>
                     <td>
                         <?php echo $form->radioButtonList($model, 'charge', array(0=>'不参与', 1=>'参与'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                         <?php echo $form->error($model, 'charge', $htmlOptions = array()); ?>
                     </td>
                </tr>
                
                <tr > 
					<td><?php echo $form->labelEx($model, 'card_xh'); ?></td> 
                    <td>
                    	<?php echo $form->textField($model, 'card_xh', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'card_xh', $htmlOptions = array()); ?>
                    <td><?php echo $form->labelEx($model, 'card_level'); ?></td> 
                    <td>
                    	<?php echo $form->textField($model, 'card_level', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'card_level', $htmlOptions = array()); ?>
					</td>
                    
                </tr>
                <tr > 
                    <td><?php echo $form->labelEx($model, 'card_score'); ?></td> 
                    <td>
                    	<?php echo $form->textField($model, 'card_score', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'card_score', $htmlOptions = array()); ?>
					</td>
                    <td><?php echo $form->labelEx($model, 'card_end_score'); ?></td>
                    <td>
                    	<?php echo $form->textField($model, 'card_end_score', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'card_end_score', $htmlOptions = array()); ?>
                    </td> 
                </tr>  
                 
                <tr > 
					<td><?php echo $form->labelEx($model, 'renew_time'); ?></td>
                    <td>
                    	<?php echo $form->textField($model, 'renew_time', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'renew_time', $htmlOptions = array()); ?>
                    </td> 
					<td><?php echo $form->labelEx($model, 'renew_notice_time'); ?></td>
                    <td>
                    	<?php echo $form->textField($model, 'renew_notice_time', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'renew_notice_time', $htmlOptions = array()); ?>
                    </td> 
                </tr>
				<tr > 
                    <td ><?php echo $form->labelEx($model, 'description'); ?></td>
                    <td colspan="3">
                    	 <?php echo $form->textArea($model, 'description', array('class' => 'input-text' ,'value'=>'')); ?>
                        <?php echo $form->error($model, 'description', $htmlOptions = array()); ?>
                    </td> 
                </tr>
				<tr  class="table-title"> 
                    <td colspan="4">服务者设置（选填）</td> 
                </tr>
				<tr > 
                    <td><?php echo $form->labelEx($model, 'if_service'); ?></td> 
                    <td>
                    	<?php echo $form->radioButtonList($model, 'if_service', array(0=>'不支持', 1=>'支持'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                         <?php echo $form->error($model, 'if_service', $htmlOptions = array()); ?>
					</td>
                    <td><?php echo $form->labelEx($model, 'club_display'); ?></td>
                    <td>
                    	<?php echo $form->radioButtonList($model, 'club_display', array(0=>'不显示', 1=>'显示'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                         <?php echo $form->error($model, 'club_display', $htmlOptions = array()); ?>
                    </td> 
                </tr>
				<tr > 
                    <td><?php echo $form->labelEx($model, 'job_partner_num'); ?></td> 
                    <td>
                    	<?php echo $form->textField($model, 'job_partner_num', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'job_partner_num', $htmlOptions = array()); ?>
						<p>*不填写默认为不限制</p>
					</td>
                    <td><?php echo $form->labelEx($model, 'job_club_num'); ?></td>
                    <td>
                    	<?php echo $form->textField($model, 'job_club_num', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'job_club_num', $htmlOptions = array()); ?>
						<p>*不填写默认为不限制</p>
                    </td> 
                </tr>
                <tr>
                    <td>可执行操作</td>
                    <td colspan="3">
                        <button class="btn btn-blue" type="submit">保存</button>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
                
            </table>

            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        
        
        <?php $this->endWidget(); ?>
        	
    </div><!--box-detail end-->
</div><!--box end-->
<script>

function selectOnchang(obj){ 
  var show_id=$(obj).val();
  var  p_html ='<option value="">请选择</option>';
  if (show_id==501) {
    //'partnership_type
     for (j=0;j<$d_club_type2.length;j++) 
        if($d_club_type2[j]['fater_id']==383)
       {
        p_html = p_html +'<option value="'+$d_club_type2[j]['f_id']+'">';
        p_html = p_html +$d_club_type2[j]['F_NAME']+'</option>';
      }
    } else if (show_id==502) {
		for (j=0;j<$d_club_type2.length;j++) 
        if($d_club_type2[j]['fater_id']==10)
       {
        p_html = p_html +'<option value="'+$d_club_type2[j]['f_id']+'">';
        p_html = p_html +$d_club_type2[j]['F_NAME']+'</option>';
      }
		
	}
   $("#MemberCard_mamber_type").html(p_html);
}
// 删除分类
var $classify_box=$('#classify_box');
var $MallProducts_type=$('#MallProducts_type');
var fnUpdateClassify=function(){
    var arr=[];
    var id;
    $classify_box.find('span').each(function(){
        id=$(this).attr('data-id');
        arr.push(id);
    });
    $MallProducts_type.val(we.implode(',', arr));
};

var fnDeleteClassify=function(op){
    $(op).parent().remove();
    fnUpdateClassify();
};

$(function(){	
	
	// 添加分类, array('fid'=>216)
    var $classify_add_btn=$('#classify_add_btn');
    $classify_add_btn.on('click', function(){
        $.dialog.data('classify_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/product_type");?>',{
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
	
});	
</script>