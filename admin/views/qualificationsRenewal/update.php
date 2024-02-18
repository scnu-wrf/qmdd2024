<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>服务者信息</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->

    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
     	<div class="box-detail-tab">
            <ul class="c">
                <li class="current">基本信息</li>
                <li id="a2">实名信息</li>
                <li id="a3">服务者管理信息</li>
                <li id="a4">服务者介绍</li>
                <li id="a5">挂靠单位信息</li>
            </ul>
        </div><!--box-detail-tab end-->
        
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table class="mt15">
                	<tr>
                        <td colspan="4" style="background:#fafafa;">申请信息</td>
                    </tr>
                    <tr>	    
                        <td><?php echo $form->labelEx($model, 'qualifications_code'); ?></td>
                        <td colspan="3"><?php echo $model->qualifications_code; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'qualification_gfaccount'); ?></td>
                        <td>
                            <?php echo $form->error($model, 'qualification_gfaccount', $htmlOptions = array()); ?>
                            <?php echo $model->qualification_gfaccount;?>
                        </td> 
                        <td><?php echo $form->labelEx($model, 'qualification_name'); ?></td>
                        <td>
                            <?php echo $model->qualification_name; ?>
                        </td>
                    </tr>
                    <tr>	    
                        <td ><?php echo $form->labelEx($model, 'qualification_type_id'); ?></td>
                        <td colspan="3">
                            <?php echo $model->qualification_type; ?>
                        </td>
                    </tr>
                    <?php if($model->qualification_type_id!=314&&$model->qualification_type_id!=321){?>
                    <tr class="project">	
                        <td ><?php echo $form->labelEx($model, 'qualification_project_id'); ?></td>
                        <td colspan="3">
                            <?php echo $model->qualifications_person->qualification_project_name; ?>
                        </td>
                    </tr>
                    <?php }?>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'phone'); ?></td>
                        <td colspan="3">
                            <?php echo $model->qualifications_person->phone; ?>
                        </td> 
                    </tr>
                    <tr>	
                        <td><?php echo $form->labelEx($model, 'email'); ?></td>
                        <td colspan="3">
                            <?php echo $model->qualifications_person->email; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'address'); ?></td>
                        <td colspan="3">
                            <?php echo $model->qualifications_person->address; ?>
                        </td>
                    </tr>
                    <tr>	
                    	<td><?php echo $form->labelEx($model, 'head_pic'); ?></td>
                        <td colspan="3"> 
                            <?php $basepath=BasePath::model()->getPath(123);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->qualifications_person->head_pic!=''){?><div class="upload_img fl" ><a href="<?php echo $basepath->F_WWWPATH.$model->qualifications_person->head_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->qualifications_person->head_pic;?>" width="70"></a></div><?php }?>
                        </td>
                    </tr>
                </table>
                <table class="mt15">
                	<tr>
                        <td colspan="4" style="background:#fafafa;">资质信息</td>
                    </tr>
                    <?php if($model->qualification_type_id==261||$model->qualification_type_id==268||$model->qualification_type_id==328){?>
                        <tr>
                            <td ><?php echo $form->labelEx($model, 'qualification_identity_num'); ?></td>
                            <td colspan="3"><?php echo $form->hiddenField($model, 'qualification_identity_num', array('class' => 'input-text')); ?>
                                <?php echo $model->qualification_title; ?>
                            </td>
                        </tr>
                        <tr>
                            <td ><?php echo $form->labelEx($model, 'qualification_code'); ?></td>
                            <td colspan="3">
                                <?php echo $model->qualifications_person->qualification_code; ?>
                            </td>
                        </tr>
                        <tr> 
                            <td><?php echo $form->labelEx($model, 'qualification_image'); ?></td>
                            <td colspan="3"> 
                            <?php $basepath=BasePath::model()->getPath(123);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->qualifications_person->qualification_image!=''){?><div class="upload_img fl" ><a href="<?php echo $basepath->F_WWWPATH.$model->qualifications_person->qualification_image;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->qualifications_person->qualification_image;?>" width="70"></a></div><?php }?>
                            </td>
                        </tr>
                        <tr>
                            <td ><?php echo $form->labelEx($model, 'start_date'); ?></td>
                            <td >
                                <?php echo $model->qualifications_person->start_date; ?>
                            </td>
                            <td ><?php echo $form->labelEx($model, 'end_date'); ?></td>
                            <td >
                                <?php echo $model->qualifications_person->end_date; ?>
                            </td>
                        </tr>
                    <?php }else{?>
                        <tr class="experience">
                            <td ><?php echo $form->labelEx($model, 'employment_experience'); ?></td>
                            <td colspan="3">
                                <?php echo $model->qualifications_person->employment_experience; ?>
                            </td>
                        </tr>
                        <?php if($model->qualification_type_id==335){?>
                            <tr class="example">
                                <td><?php echo $form->labelEx($model, 'employment_example'); ?></td>
                                <td colspan="3"> 
                                <?php $basepath=BasePath::model()->getPath(123);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                                <?php if($model->qualifications_person->employment_example!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_employment_example"><a href="<?php echo $basepath->F_WWWPATH.$model->qualifications_person->employment_example;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->qualifications_person->employment_example;?>" width="70"></a></div><?php }?>
                                </td>
                            </tr>
                        <?php }?>
                    <?php }?>
                    <tr>
                        <td>可执行操作</td>
                        <td colspan="3">
                            <button onclick="submitType='tongguo'" class="btn btn-blue" type="submit">审核通过</button>
                            <button onclick="submitType='butongguo'" class="btn btn-blue" type="submit">审核不通过</button>
                            <?php echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
    </div><!--box-detail end-->
</div><!--box end-->

<?php $this->endWidget();?>