<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>详细</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        
        <table id="t0" class="table-title">
            <tr>
                <td>意见反馈详细信息</td>
            </tr>
        </table>
        <table id="t1">
			<?php
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
            ?>
        </table>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'active-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'afterValidate' => 'js:function(form,data,hasError){
                    if(!hasError){
                        we.overlay("show");
                        $.ajax({
                            type:"post",
                            url:form.attr("action"),
                            data:form.serialize()+"&submitType="+submitType,
                            dataType:"json",
                            success:function(d){
                                if(d.status==1){
                                    we.success(d.msg, d.redirect);
                                }else{
                                    we.error(d.msg, d.redirect);
                                }
                            }
                        });
                    }else{
                        var html="";
                        var items = [];
                        for(item in data){
                            items.push(item);
                            html+="<p>"+data[item][0]+"</p>";
                        }
                        we.msg("minus", html);
                        var $item = $("#"+items[0]);
                        $item.focus();
                        $(window).scrollTop($item.offset().top-10);
                    }
                }',
            ),
        ));
        ?>
        
        
        <div class="mt15">
            <table id="t2" class="table-title">
                <tr>
                    <td>审核状态</td>
                </tr>
            </table>
            <table id="t3">
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
        <?php $this->endWidget(); ?>
        <table id="t4" class="showinfo">
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
</script>
