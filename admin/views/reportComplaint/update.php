<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>详细</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
    <div class="box-detail">
        
        <!--table id="t0" class="table-title">
            <tr>
                <td>投诉举报详细信息</td>
            </tr>
        </table-->
        <table id="t0">
        	<tr class="table-title">
                <td colspan="4">服务信息</td>
            </tr>
			<?php
			/*
			$temp = $model->attributeLabels() ;
			foreach( $model->labelsOfDetail() as $fk ){
                            $s = '';
                            if ($fk=='report_type_id'){
                                $s = ReportVersion::model()->getName($model->$fk);
                            }elseif($fk=='state' || $fk=='type'){
                                $s = BaseCode::model()->getName($model->$fk);
                            }elseif($fk=='report_pic'){
                                $pics=explode(',',$model->$fk);
                                $s = '';
                                for ($i=0;$i<5;$i++){
                                    if(isset($pics[$i]))
                                        $s.="<img src='".$pics[$i]."' ></img>";
                                }
                            }else{
                                $s= $model->$fk ;
                            }
                            if($fk=='connect_name'){
                                echo "<tr><td width='15%'>反馈人账号</td><td >  $model->gf_account</td><td width='15%'>".$temp[$fk]."</td><td > ${s}</td> </tr>";
                            }else 
                                echo "<tr><td width='15%'>".$temp[$fk]."</td><td colspan='3'> ${s}</td> </tr>";
                        }
						*/
            ?>
                <tr>
                    <td><?php echo $form->labelEx($model, 'type'); ?></td>
                    <td><?php if(!empty($model->m_type)) echo $model->m_type->F_NAME; ?></td>
                    <td><?php echo $form->labelEx($model, 'report_type_id'); ?></td>
                    <td><?php if(!empty($model->r_type)) echo $model->r_type->type; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'connect_code'); ?></td>
                    <td><?php echo $model->connect_code; ?></td>
                    <td><?php echo $form->labelEx($model, 'connect_title'); ?></td>
                    <td><?php echo $model->connect_title; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'report_detail'); ?></td>
                    <td colspan="3"><?php echo $model->report_detail; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'report_pic'); ?></td>
                    <td colspan="3">
                    <?php echo $form->hiddenField($model, 'report_pic',array('class' => 'input-text')); ?>
                            <?php $basepath=BasePath::model()->getPath(188);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <div class="upload_img fl" id="upload_pic_report_pic">
                                <?php 
                                foreach($report_pic as $v) if($v) {?>
                                <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px;"></a>
                                <?php }?>
                            </div>
                    </td>
                </tr>
        </table>
        <div class="mt15">
        	<table id="t1">
                <tr class="table-title">
                    <td colspan="4">用户信息</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'gf_account'); ?></td>
                    <td><?php echo $model->gf_account; ?></td>
                    <td><?php echo $form->labelEx($model, 'connect_name'); ?></td>
                    <td><?php echo $model->connect_name; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'connect_number'); ?></td>
                    <td><?php echo $model->connect_number; ?></td>
                    <td><?php echo $form->labelEx($model, 'connect_eamil'); ?></td>
                    <td><?php echo $model->connect_eamil; ?></td>
                </tr>
         	</table>
        </div>
        <div class="mt15">
        	<table id="t2">
                <tr class="table-title">
                    <td colspan="4">服务指派</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'service_level'); ?></td>
                    <td colspan="3"><?php echo $form->checkBoxList($model, 'service_level', 
                  Chtml::listData(BaseCode::model()->getCode(1013), 'f_id', 'F_NAME'),
                  $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
              <?php echo $form->error($model, 'service_level'); ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'service_department'); ?></td>
                    <td><?php echo $form->dropDownList($model, 'service_department', Chtml::listData(Role::model()->findAll('club_id='.get_session('club_id')), 'f_id', 'f_rname'), array('prompt'=>'请选择')); ?>
                    <?php echo $form->error($model, 'service_department', $htmlOptions = array()); ?></td>
                    <td><?php echo $form->labelEx($model, 'service_adminid'); ?></td>
                    <td><?php echo $form->hiddenField($model, 'service_adminid', array('class' => 'input-text',)); ?>
                    <span id="admin_box">
                        <span class="label-box"><?php echo $model->service_adminid;?></span>
                    </span>
                    <input id="admin_select_btn" class="btn" type="button" value="选择">
                    <?php echo $form->error($model, 'service_adminid', $htmlOptions = array()); ?></td>
                </tr>
         	</table>
        </div>
        <div class="mt15">
            <table id="t3">
            	<tr class="table-title">
                    <td colspan="4">审核状态</td>
                </tr>
                <tr>
                    <td width='15%'><?php echo $form->labelEx($model, 'state'); ?></td>
                    <td>
                        <?php echo $form->radioButtonList($model, 'state', Chtml::listData(BaseCode::model()->getCode(752), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'state'); ?>
                    </td>
                    <td width='15%'><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                    <td>
                        <?php echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text' )); ?>
                        <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="box-detail-submit"><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button><button class="btn" type="button" onclick="we.back();">返回</button><button class="btn" type="button" onclick="printpage();">打印</button></div>
         
        <table  id="t4" class="showinfo">
            <tr>
                <th style="width:20%;">操作时间</th>
                <th style="width:20%;">操作人</th>
                <th style="width:20%;">状态</th>
                <th>操作备注</th>
            </tr>
            <tr>
                <td><?php if($model->state!=371 && $model->state!=721 && isset($model->udate) ){ echo $model->udate; } ?></td>
                <td><?php if($model->state!=371 && $model->state!=721 && isset($model->admin_account)){ echo $model->admin_account; } ?></td>
                <td><?php if(isset($model->base_code->F_NAME) && $model->state!=371 && $model->state!=721){ echo $model->base_code->F_NAME; }?></td>
                <td><?php if($model->state!=371 && $model->state!=721 && isset($model->reasons_failure)){ echo $model->reasons_failure; } ?></td>
            </tr>
        </table>
        
    </div><!--box-detail end-->
	<?php $this->endWidget(); ?>
</div><!--box end-->
<script>
function printpage(){
	var html='';
	for(var i=0;i<5;i++){
		html += '<table>'+$("#t"+i).html()+"</table>";
		if(i==1 || i==3)
			html+="<br>";
	}
	
	var newWin = window.open('', '', '');
	newWin.document.write('<head><style>#print-content{font-size:14px}</style> \
		<style> \
			.box-detail table, .box-detail-table{\
				table-layout:fixed;\
				width:100%;\
				border-spacing:1px;\
				border-collapse:collapse;\
				background:#ccc;}\
			.box-detail td, .box-detail-table td{\
				padding:10px;\
				background:#fff; \
				border: 1px solid black; \
				text-align:left;}\
			.box-detail table.table-title{ \
				border-collapse:collapse; \
				border-top:1px #ccc solid;	\
				border-right:1px #ccc solid;\
				border-left:1px #ccc solid;}\
			.table-title td{background:#efefef;}\
			.box-detail-table td{text-align:left;}\
		</style> \
	   	 </head>');
	newWin.document.write('<div><div class="box-detail">'+html+"</div></div>");
	newWin.print();
	newWin.close(); //关闭新产生的标签页
}

// 选择受理人
    var $admin_box=$('#admin_box');
    var $ReportComplaint_service_adminid=$('#ReportComplaint_service_adminid');
    $('#admin_select_btn').on('click', function(){
        $.dialog.data('adminid', 0);
        $.dialog.open('<?php echo $this->createUrl("select/club_admin");?>',{
            id:'guanliyuan',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('adminid')>0){
                    $ReportComplaint_service_adminid.val($.dialog.data('adminid')).trigger('blur');
                    $admin_box.html('<span class="label-box">'+$.dialog.data('gfnick')+'</span>');
                }
            }
        });
    });
</script>
