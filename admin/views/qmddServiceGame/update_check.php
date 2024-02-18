<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>赛事服务资源详细</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table>
                <tr  class="table-title">
                	<td colspan="4">基本信息</td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'service_code'); ?></td>
                    <td><?php echo $model->service_code;?></td>
                    <td><?php echo $form->labelEx($model, 'club_id'); ?></td>
                    <td><span class="label-box"><?php echo $model->club_name;?></span></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'title'); ?></td>
                    <td><?php echo $model->title;?></td>
                    <td><?php echo $form->labelEx($model, 'server_name'); ?></td>
                    <td><?php echo $model->server_name;?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'local_and_phone'); ?></td>
                    <td><?php echo $model->local_and_phone;?></td>
                    <td><?php echo $form->labelEx($model, 'area'); ?></td>
                    <td><?php echo $model->area;?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'project_id'); ?></td>
                    <td><?php echo $model->project_name;?></td>
                        <td><?php echo $form->labelEx($model, 'imgUrl'); ?></td>
                        <td>
                            <?php $basepath=BasePath::model()->getPath(135);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->imgUrl!=''){?><div class="upload_img fl" id="upload_pic_QmddServiceGame_imgUrl">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->imgUrl;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$model->imgUrl;?>" width="100">
                                </a>
                            </div>
                            <?php } ?>
                            <span class="msg">注：图片格式530*530;文件大小≤2M；数量≤1张 </span>
                            <?php echo $form->error($model, 'imgUrl', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'service_pic_img'); ?></td>
                        <td colspan="3">
                            <?php $basepath=BasePath::model()->getPath(226);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->service_pic_img!=''){?> 
                                <div class="upload_img fl" id="upload_pic_QmddServiceGame_service_pic_img">
                                    <?php 
                                    if(!empty($service_pic_img)) foreach($service_pic_img as $v) if($v) {?>
                                    <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px;"><i onclick="$(this).parent().remove();fnUpdateScrollpic();return false;"></i></a>
                                    <?php }?>
                                </div>
                            <?php } ?>
                            <span class="msg">注：图片格式1080*1080;文件大小≤2M；数量≤5张 </span>
                            <?php echo $form->error($model, 'service_pic_img', $htmlOptions = array()); ?>
                        </td>
                    </tr>
            </table>
            <table class="mt15">
            	<tr class="table-title">
                    <td colspan="4">赛事信息</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'site_contain'); ?></td>
                    <td><?php echo $model->site_contain;?>
                        <span class="msg">人</span>
                    </td>
                    <td><?php echo $form->labelEx($model, 'game_item'); ?></td>
                    <td>
                        <?php if(!empty($game_item)) foreach($game_item as $v){?><span class="label-box" ><?php echo $v->game_item;?></span><?php } ?>
                     </td>
                </tr>
            </table>
            <?php echo $form->hiddenField($model,'servic_person_ids')?>
            <table id="servant_box" class="mt15">
            	<tr class="table-title">
                   <td colspan="5">服务者信息</td>
                </tr>
                <tr>
                	<th>服务类别</th>
                    <th>服务编号</th>
                    <th>服务者姓名</th>
                    <th>服务者等级</th>
                    <th>操作</th>
                </tr>
                <?php 
                        
                        if(!empty($servant_list)) foreach($servant_list as $p){
                ?>
                <tr class="servant_item" id="servant_item_<?php echo $p->id;?>" data-id="<?php echo $p->id;?>">
                    <td><?php echo $p->type_name;?></td>
                    <td><?php echo $p->qualifications_person->qcode;?></td>
                    <td><?php echo $p->qualifications_person->qualification_name;?></td>
                    <td><?php echo $p->qualifications_person->qualification_level_name;?></td>
                    <td><a class="btn" href="<?php echo $this->createUrl('clubQualificationPerson/update',array('id'=>$p->qualification_person_id));?>" title="查看详情">查看详情</a></td>
                </tr>
                <?php } ?>
            </table>
            <?php echo $form->hiddenField($model,'servic_site_ids')?>
            <table id="site_box" class="mt15">
            	<tr class="table-title">
                    <td colspan="4">场地信息</td>
                </tr>
                <tr>
                    <th>服务编号</th>
                    <th>场地名称</th>
                    <th>场地等级</th>
                    <th>操作</th>
                </tr>
                <?php 
                        if(!empty($site_list)) foreach($site_list as $s){
                ?>
                <tr class="site_item" id="site_item_<?php echo $s->id;?>" data-id="<?php echo $s->id;?>">
                    <td><?php echo $s->site_code;?></td>
                    <td><?php echo $s->site_name;?></td>
                    <td><?php echo $s->site_level_name;?></td>
                    <td><a class="btn" href="<?php echo $this->createUrl('qmddGfSite/update',array('id'=>$s->id));?>" title="查看详情">查看详情</a></td>
                </tr>
                <?php }?>
            </table>
            <table class="mt15">
            	<tr class="table-title">
                    <td colspan="4">审核信息</td>
                </tr>
                <tr>
                    <td width='15%'><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                    <td colspan="3">
                        <?php echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text' ,'value'=>'')); ?>
                        <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                	<td>可执行操作</td>
                    <td colspan="3">
                        <?php echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
            <table class="showinfo">
                <tr>
                    <th style="width:20%;">操作时间</th>
                    <th style="width:20%;">操作人</th>
                    <th style="width:20%;">审核状态</th>
                    <th>操作备注</th>
                </tr>
                <tr>
                    <td><?php echo $model->reasons_time; ?></td>
                    <td><?php echo $model->reasons_adminname; ?></td>
                    <td><?php echo $model->state_name; ?></td>
                    <td><?php echo $model->reasons_failure; ?></td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->  
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>


</script>