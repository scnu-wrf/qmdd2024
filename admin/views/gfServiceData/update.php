   <div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>服务预订详情</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table>
                <tr  class="table-title">
                	<td colspan="4">
                    服务预订详情
                    </td>  
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'order_num'); ?></td>
                    <td colspan='3'><?php echo $model->order_num; ?></td>
                </tr>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model, 'order_type'); ?></td>
                    <td width="35%" ><?php echo $model->order_type_name; ?></td>
                    <td width="15%"><?php echo $form->labelEx($model, 'project_id'); ?></td>
                    <td width="35%" ><?php echo $model->project_name; ?></td>
                </tr>
                <tr>
                	<td width="15%"><?php echo $form->labelEx($model, 'service_type'); ?></td>
                    <td width="35%" ><?php echo $model->service_type_name; ?>&nbsp;&nbsp;<?php echo $model->game_user_type_name; ?></td>
                    <td width="15%"><?php echo $form->labelEx($model, 'data_id'); ?></td>
                    <td width="35%" ><?php echo $model->data_name; ?></td>
                </tr>
                <tr>
                	<td width="15%"><?php echo $form->labelEx($model, 'supplier_id'); ?></td>
                    <td width="35%" ><?php echo $model->supplier_name; ?></td>
                    <td width="15%"><?php echo $form->labelEx($model, 'add_time'); ?></td>
                    <td width="35%" ><?php echo $model->add_time; ?></td>
                </tr>
            </table>
            <br/>
            <table>
            	 <tr  class="table-title">
                	<td colspan="4">下单人信息</td>
                </tr>
                <tr>
                	<td width="15%"><?php echo $form->labelEx($model, 'gf_account'); ?></td>
                    <td width="35%" ><?php echo $model->gf_account; ?></td>
                    <td width="15%"><?php echo $form->labelEx($model, 'gf_name'); ?></td>
                    <td width="35%" ><?php echo $model->gf_name; ?></td>
                </tr>
                <tr>
                	<td width="15%"><?php echo $form->labelEx($model, 'contact_phone'); ?></td>
                    <td width="35%" ><?php echo $model->contact_phone; ?></td>
                    <td width="15%">成员信息</td>
                    <td width="35%" >
                    	<a href="<?php echo $this->createUrl("gameSignList/index",array('order_num'=>$model->order_num));?>"><input type="button"  name='show_gfid_msg' id='show_gfid_msg' value="成员信息>>" /></a>
                    </td>
                </tr>
            </table>
            <br/>
            <table>
            	 <tr  class="table-title">
                	<td colspan="6">服务信息</td>
                </tr>
                <tr>
                	<td width="10%"><?php echo $form->labelEx($model, 'service_code'); ?></td>
                    <td width="10%"><?php echo $form->labelEx($model, 'service_ico'); ?></td>
                    <td width="45%"><?php echo $form->labelEx($model, 'service_name'); ?></td>
                    <td width="20%"><?php echo $form->labelEx($model, 'service_data_id'); ?></td>
                    <td width="10%"><?php echo $form->labelEx($model, 'buy_count'); ?></td>
                    <td width="10%"><?php echo $form->labelEx($model, 'buy_price'); ?></td>
                </tr>
                <tr>
                	<td><?php echo $model->service_code; ?></td>
                    <td>
                   		<?php echo $form->hiddenField($model, 'service_ico', array('class' => 'input-text fl')); ?>
						<?php $basepath=BasePath::model()->getPath(135);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <?php if($model->service_ico!=''){?><div class="upload_img fl" id="upload_pic_ClubNews_news_pic"><a href="<?php echo $basepath->F_WWWPATH.$model->service_ico;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->service_ico;?>" width="70"></a></div><?php }?>
                        <?php echo $form->error($model, 'service_ico', $htmlOptions = array()); ?>
                    
                    </td>
                    <td><?php echo $model->service_name; ?></td>
                    <td><?php echo $model->service_data_name; ?></td>
                    <td><?php echo $model->buy_count; ?></td>
                    <td><?php echo $model->buy_price; ?></td>
                </tr>
                <tr>
                	<td width="10%"><?php echo $form->labelEx($model, 'set_code'); ?></td>
                    <td colspan="2" width="40%"><?php echo $model->set_code; ?></td>
                    <td width="10%"><?php echo $form->labelEx($model, 'set_name'); ?></td>
                    <td colspan="2"><?php echo $model->set_name; ?></td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
        <div class="mt15">
            <table class="table-title">
                <tr>
                    <td>审核信息</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td width='15%'><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                    <td width='85%'>
                        <?php echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text' ,'value'=>'')); ?>
                        <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                	<td>可执行操作</td>
                    <td>
                    	<?php echo show_shenhe_box(array('baocun'=>'保存','tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                        <button onclick="submitType='quxiao'" class="btn btn-blue" type="submit">取消服务</button>
                        <button class="btn" type="button" onclick="we.back();">取消操作</button>
                    </td>
                </tr>
            </table>
        </div>
        <table class="showinfo">
            <tr>
                <th style="width:25%;">操作时间</th>
                <th style="width:25%;">操作人</th>
                <th style="width:25%;">状态</th>
                <th>操作备注</th>
            </tr>
            <tr>
                <td><?php echo $model->state_time; ?></td>
                <td><?php echo $model->admin_name; ?></td>
                <td><?php echo $model->state_name; ?>|<?php echo $model->is_pay_name; ?>|<?php echo $model->order_state_name; ?></td>
                <td><?php echo $model->reasons_failure; ?></td>
            </tr>
        </table>
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->