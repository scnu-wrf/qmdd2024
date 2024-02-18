<style>
.fontStyle1{
 font-size:14px;
 color:#666;
 font-weight:bold;

}
</style>
<?php
    if($model->start_date=='0000-00-00 00:00:00'){
        $model->start_date='';
    }
    if($model->end_date=='0000-00-00 00:00:00'){
        $model->end_date='';
    }
?>
<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>服务者详情表</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div>
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <div class="box-detail-tab">
                <ul class="c">
                    <li class="current">基本信息</li>
                    <li id="a2">实名信息</li>
                </ul>
            </div><!--box-detail-tab end-->
            <div class="box-detail-bd">
                <div style="display:block;" class="box-detail-tab-item">
                   <table width="100%" style="table-layout:auto;">
                        <tr class="table-title">
                            <td class="fontStyle1" colspan="4">基本信息</td>
                        </tr>
                        <!-- <tr>
                            <td><?php echo $form->labelEx($model, 'qcode'); ?></td>
                            <td><?php echo $model->qcode; ?></td>
                            <td><?php echo $form->labelEx($model, 'qualification_project_name'); ?></td>
                            <td><?php echo $model->qualification_project_name; ?></td>
                        </tr> -->
                        
                        <tr>
                            <td width="10%" class="fontStyle1"><?php echo $form->labelEx($model, 'qualification_gf_code'); ?></td>
                            <td colspan="3"><?php echo $model->qualification_gf_code; ?></td>

                        </tr>
                        
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'qualification_gfaccount'); ?></td>
                            <td width="27%"><?php echo $model->qualification_gfaccount; ?></td>
                            <td width="9%" class="fontStyle1"><?php echo $form->labelEx($model, 'qualification_name'); ?></td>
                            <td width="54%"><?php echo $model->qualification_name; ?></td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'qualification_type'); ?></td>
                            <td><?php echo $model->qualification_type; ?></td>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'qualification_project_name'); ?></td>
                            <td><?php echo $model->qualification_project_name; ?></td>
                            <!-- <td><?php echo $form->labelEx($model, 'qualification_title'); ?></td>
                            <td><?php echo $model->qualification_title; ?></td> -->
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'phone'); ?></td>
                            <td><?php echo $model->phone; ?></td>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'email'); ?></td>
                            <td><?php echo $model->email; ?></td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'address'); ?></td>
                            <td colspan="3"><?php echo $model->address; ?></td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'head_pic'); ?></td>
                            <td colspan="3">
                                <?php echo $form->hiddenField($model, 'head_pic', array('class' => 'input-text')); ?>
                                <?php
                                    $basepath=BasePath::model()->getPath(213);
                                    if($model->head_pic!=''){
                                ?>
                                    <div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_head_pic">
                                        <a href="<?php echo $basepath->F_WWWPATH.$model->head_pic;?>" target="_blank">
                                            <img src="<?php echo $basepath->F_WWWPATH.$model->head_pic;?>" style="max-width:100px; max-height:100px;">
                                        </a>
                                    </div>
                                <?php }?>
                            </td>
                        </tr>
                    </table>
                   <table width="100%" style="table-layout:auto; margin-top:10px;">
                        <tr class="table-title">
                            <td  class="fontStyle1" colspan="4">资质信息</td>
                        </tr>
                        <tr>
                            <td width="10%" class="fontStyle1"><?php echo $form->labelEx($model, 'qualification_title'); ?></td>
                            <td colspan="3"><?php echo $model->qualification_identity_type_name.$model->qualification_title; ?></td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'qualification_code'); ?></td>
                            <td colspan="3"><?php echo $model->qualification_code; ?></td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'qualification_image'); ?></td>
                            <td colspan="3">
                                <?php echo $form->hiddenField($model, 'qualification_image',array('class' => 'input-text')); ?>
                                <div class="upload_img fl" id="upload_pic_qualification_image">
                                    <?php
                                        $basepath=BasePath::model()->getPath(121);
                                        foreach($qualification_image as $v) if($v) {
                                    ?>
                                        <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank">
                                            <img src="<?php echo $basepath->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px;">
                                        </a>
                                    <?php }?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'start_date'); ?></td>
                            <td width="40%"><?php echo $model->start_date; ?></td>
                            <td width="4%" class="fontStyle1" style="text-align:center;"><?php echo $form->labelEx($model, 'end_date'); ?></td>
                            <td width="46%"><?php echo $model->end_date; ?></td>
                        </tr>
                        <tr>
                            <td class="fontStyle1">可执行操作</td>
                            <td colspan="3">
                                <?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));?>
                                <button class="btn" type="button" onclick="we.back();">取消</button>
                            </td>
                        </tr>
                    </table>
                    
                    
                    
                    <!--
                    <table class="mt15">
                        <tr class="table-title">
                            <td colspan="4">审核信息</td>
                        </tr>
                        <tr>
                           <td><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                            <td>
                            <?php echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text' )); ?>
                            <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
                            </td> 
                            <td>审核操作</td>
                            <td colspan="3">
                                <?php echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过')); ?>
                                <button class="btn" type="button" onclick="we.back();">取消</button>
                            </td>
                        </tr>
                    </table>
                    
                   <table class="mt15 showinfo">
                        <tr>
                            <th style="width:20%;">操作时间</th>
                            <th style="width:20%;">操作人</th>
                            <th style="width:20%;">状态</th>
                            <th>操作备注</th>
                        </tr>
                        <tr>
                            <td><?php echo $model->uDate; ?></td>
                            <td><?php echo $model->process_preson_nick; ?></td>
                            <td><?php echo $model->check_state_name; ?></td>
                            <td><?php echo $model->reasons_failure; ?></td>
                        </tr>
                    </table> -->
                    
                    
                </div>
                <div class="box-detail-tab-item" style="display:none;">
                <table style="table-layout:auto;">
                    <tr class="table-title">
                        <td class="fontStyle1" colspan="4">实名信息</tr>
                    </tr>
                    <tr>
                        <td class="fontStyle1" style="width:15%;"><?php echo $form->labelEx($model,'qualification_name'); ?></td>
                        <td style="width:35%;"><?php echo $model->qualification_name; ?></td>
                        <td class="fontStyle1" style="width:15%;"><?php echo $form->labelEx($model,'qualification_sex'); ?></td>
                        <td style="width:35%;"><?php echo $model->base_sex->F_NAME; ?></td>
                    </tr>
                    <tr>
                        <td class="fontStyle1"><?php echo $form->labelEx($model,'native'); ?></td>
                        <td><?php echo $model->gf_user_1->native; ?></td>
                        <td class="fontStyle1"><?php echo $form->labelEx($model,'nation'); ?></td>
                        <td><?php echo $model->gf_user_1->nation; ?></td>
                    </tr>
                    <tr>
                        <td class="fontStyle1"><?php echo $form->labelEx($model,'real_birthday'); ?></td>
                        <td><?php echo $model->gf_user_1->real_birthday; ?></td>
                        <td class="fontStyle1"><?php echo $form->labelEx($model,'id_card_type'); ?></td>
                        <td><?php echo $model->gf_user_1->id_card_type_name; ?></td>
                    </tr>
                    <tr>
                        <td class="fontStyle1"><?php echo $form->labelEx($model,'id_card'); ?></td>
                        <td colspan="3"><?php echo $model->gf_user_1->id_card; ?></td>
                    </tr>
                    <tr>
                        <td class="fontStyle1"><?php echo $form->labelEx($model,'id_card_validity_start'); ?></td>
                        <td><?php echo $model->gf_user_1->id_card_validity_start; ?></td>
                        <td class="fontStyle1"><?php echo $form->labelEx($model,'id_card_validity_end'); ?></td>
                        <td><?php echo $model->gf_user_1->id_card_validity_end; ?></td>
                    </tr>
                    <tr>
                        <td class="fontStyle1"><?php echo $form->labelEx($model, 'id_card_pic'); ?></td>
                        <td>
                            <?php $basepath=BasePath::model()->getPath(211);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->gf_user_1->id_card_pic!=null){?>
                            <div class="upload_img fl" id="upload_pic_ClubServiceData_imgUrl">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->gf_user_1->id_card_pic;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$model->gf_user_1->id_card_pic;?>" width="100">
                                </a>
                            </div>
                            <?php }?>
                            <?php echo $form->error($model, 'id_card_pic', $htmlOptions = array()); ?>
                        </td>
                        <td class="fontStyle1" width="15%"><?php echo $form->labelEx($model, 'id_pic'); ?></td>
                        <td>
                            <?php $basepath=BasePath::model()->getPath(210);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->gf_user_1->id_pic!=null){?>
                            <div class="upload_img fl" id="upload_pic_ClubServiceData_imgUrl">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->gf_user_1->id_pic;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$model->gf_user_1->id_pic;?>" width="100">
                                </a>
                            </div>
                            <?php }?>
                            <?php echo $form->error($model, 'id_pic', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
            </div>
            </div>
            <!--box-detail-tab-item end-->
        <?php $this->endWidget();?>
    </div>
</div>
<script>
    we.tab('.box-detail-tab li','.box-detail-tab-item',function(index){
        return true;
    });
    document.getElementsByClassName("a2").click();
</script>