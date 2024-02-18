<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>详细</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
    <div class="box-detail">
        <?php if($model->rtype_id==1182){?>
            <table class="mt15">
                <tr class="table-title">
                    <td colspan="4">申诉信息</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'report_content'); ?></td>
                    <td colspan="3"><?php echo $model->report_content; ?></td>
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
        <?php }else{?>
            <table id="t1">
                <tr class="table-title">
                    <td colspan="4">举报人信息</td>
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
            <table class="mt15">
                <tr class="table-title">
                    <td colspan="4">举报信息</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'connect_publisher_code'); ?></td>
                    <td><?php echo $model->connect_publisher_code; ?></td>
                    <td><?php echo $form->labelEx($model, 'connect_publisher_title'); ?></td>
                    <td><?php echo $model->connect_publisher_title; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'connect_title'); ?></td>
                    <td><?php echo $model->connect_title; ?>
                <?php if($model->type!=746&&$model->type!=748){echo '<a style="float:right;" onclick="add_tr()">查看</a>';}?></td>
                    <td><?php echo $form->labelEx($model, 'report_type_id'); ?></td>
                    <td><?php if(!empty($model->r_type)) echo $model->r_type->type; ?></td>
                </tr>
            </table>
            <?php if($model->rtype_id==1181){?>
                <table class="mt15">
                    <tr class="table-title">
                        <td colspan="4">被侵权人信息</td>
                    </tr>
                    <tr>
                        <td><?php $model->the_infringed_type=='403'?$n='姓名':$n='名称'; echo $n; ?></td>
                        <td><?php echo $model->the_infringed_name; ?></td>
                        <td><?php $model->the_infringed_type=='403'?$n2='身份证号':$n2='法人姓名'; echo $n2; ?></td>
                        <td><?php echo $model->the_infringed_id_card; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'the_infringed_concat'); ?></td>
                        <td><?php echo $model->the_infringed_concat; ?></td>
                        <td><?php echo $form->labelEx($model, 'the_infringed_eamil'); ?></td>
                        <td><?php echo $model->the_infringed_eamil; ?></td>
                    </tr>
                    <tr>
                        <td><?php $model->the_infringed_type=='403'?$n3='身份证正反面照片':$n3='营业执照照片'; echo $n3; ?></td>
                        <td colspan="3"><?php echo $model->the_infringed_concat; ?></td>
                    </tr>
                </table>
            <?php }?>
            <table class="mt15">
                <tr class="table-title">
                    <td colspan="4">举报描述</td>
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
        <?php }?>
        <?php if($model->audit_status!=2&&$model->audit_status!=373){?>
            <table id="t2" class="mt15">
                <tr class="table-title">
                    <td colspan="4">举报处理操作</td>
                </tr>
                <!-- <tr>
                    <td width='15%'><?php echo $form->labelEx($model, 'reasons_for_failure'); ?></td>
                    <td colspan="3">
                        <?php echo $form->textArea($model, 'reasons_for_failure', array('class' => 'input-text' )); ?>
                        <?php echo $form->error($model, 'reasons_for_failure', $htmlOptions = array()); ?>
                    </td>
                </tr> -->
                <tr>
                    <td width='15%'>审核状态</td>
                    <td colspan="3">
                        <?php echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                    </td>
                </tr>
            </table>
        <?php }?>
        <?php if($model->audit_status==2){?>
            <table class="showinfo">
                <tr class="table-title">
                    <th>违规信息</th>
                    <th>处理部门</th>
                    <th>处理结果</th>
                    <th>是否处理</th>
                </tr>
                <?php if($model->type!=746&&$model->type!=748){?>
                <tr>
                    <td><?php echo $model->connect_title; ?>(违规内容) <a style="float:right;" onclick="add_tr()">查看</a></td>
                    <td><?php echo $form->dropDownList($model, 'service_department', Chtml::listData(Club2List::model()->findAll('club_id='.get_session('club_id')), 'id', 'club2_name'), array('prompt'=>'请选择')); ?>
                    <?php echo $form->error($model, 'service_department', $htmlOptions = array()); ?></td>
                    <td>
                        <?php if($model->rtype_id==1182){$value=1277;}else{$value=1270;}?>
                        <?php echo $form->radioButtonList($model, 'report_processing_msg_id', Chtml::listData(BaseCode::model()->getCode($value), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'report_processing_msg_id'); ?>
                    </td>
                    <td>
                        <?php echo $form->radioButtonList($model, 'state', Chtml::listData(BaseCode::model()->getReturn('753,755'), 'f_id', 'F_SHORTNAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'state'); ?>
                    </td>
                </tr>
                <?php }?>
                <tr>
                    <td>
                    <?php if($model->connect_publisher_type==210){echo $model->connect_publisher_code;}else if($model->connect_publisher_type==502){
                        $lode_ids = explode(',', $model->connect_publisher_project_id);
                        $pName='';
                        foreach($lode_ids as $g){
                            if(!empty($g)){
                                $project_list= ProjectList::model()->findAll('id='.$g);
                                if(!empty($project_list)){
                                    foreach($project_list as $v1){
                                        $str = array($v1->project_name);
                                    }
                                    foreach($str as $n){
                                        $pName .=$n.',';
                                    }
                                }
                            }
                        }
                        echo $model->connect_publisher_code.$pName;
                    } 
                    ?>(违规账号)</td>
                    <td><?php echo $form->dropDownList($model, 'account_service_department', Chtml::listData(Club2List::model()->findAll('club_id='.get_session('club_id')), 'id', 'club2_name'), array('prompt'=>'请选择')); ?>
                    <?php echo $form->error($model, 'account_service_department', $htmlOptions = array()); ?></td>
                    <td>
                        <?php if($model->rtype_id==1182){$value2=1279;}else{$value2=1272;}?>
                        <?php echo $form->radioButtonList($model, 'report_processing_obj_id', Chtml::listData(BaseCode::model()->getCode($value2), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'report_processing_obj_id'); ?>
                    </td>
                    <td>
                        <?php echo $form->radioButtonList($model, 'report_processing_obj_state', Chtml::listData(BaseCode::model()->getCode(752), 'f_id', 'F_SHORTNAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'report_processing_obj_state'); ?>
                    </td>
                </tr>
            </table>
            <!-- <?php //var_dump($_SESSION);?> -->
            <table class="mt15">
                <tr>
                    <td>可执行操作</td>
                    <td colspan="3">
                        <!-- <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button> -->
                        <?php echo show_shenhe_box(array('baocun'=>'确定')); ?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
            <table class="showinfo">
                <tr>
                    <th>操作时间</th>
                    <th>操作人</th>
                    <th colspan="2">操作内容</th>
                </tr>
                <tr>
                    <td><?php if(isset($model->udate) ){ echo $model->udate; } ?></td>
                    <!-- <td><?php if(isset($model->admin_account)){ echo $model->admin_name->role_name.'-'.$model->admin_name->admin_gfnick; } ?></td> -->
                    <td><?php if(isset($model->admin_account)){ echo $model->admin_name->admin_gfnick; } ?></td>
                    <td colspan="2"><?php if(isset($model->auditStatusName->F_NAME)){ echo $model->auditStatusName->F_NAME; }?></td>
                    <!-- <td><?php if(isset($model->reasons_for_failure)){ echo $model->reasons_for_failure; } ?></td> -->
                </tr>
		        <?php $c_record = ClubReportRecord::model()->findAll('report_id='.$model->id); ?>
                <?php foreach($c_record as $v){?>
                    <tr>
                        <td><?php echo $v->add_time; ?></td>
                        <td><?php echo $v->connect_title; ?></td>
                        <td colspan="2">
                            <?php echo $v->content; ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php }?>
         
        
    </div><!--box-detail end-->
	<?php $this->endWidget(); ?>
</div><!--box end-->
<style>
    .aui_content{overflow:auto;padding: 5px 5px!important;}
    #content_table td{border:solid 1px #d9d9d9;padding:5px;height:35px;text-align:center;}
</style>
<script>
var type=<?php echo $model->type?>;
        // 查看的内容
        var add_html = '';
        add_html+='<div id="add_format" style="width:1080px;">';
        add_html+='<form id="add_form" name="add_form">';
        add_html+='<table id="content_table" style="width:100%;border: solid 1px #d9d9d9;">';
        add_html+='<thead>';
        <?php if($model->type==737||$model->type==738||$model->type==739||$model->type==741||$model->type==742){?>
            add_html+='<tr class="table-title">';
            add_html+='<td colspan="3"><?php echo $model->m_type->F_NAME;?></td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td>编码</td>';
            add_html+='<td>缩略图</td>';
            add_html+='<td>标题</td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td><?php echo $model->clubNews->news_code;?></td>';
            add_html+='<td><a href="<?php echo $basepath->F_WWWPATH.$model->clubNews->news_pic;?>" target="_blank"> <img src="<?php echo $basepath->F_WWWPATH.$model->clubNews->news_pic;?>" width="50"></a></td>';
            add_html+='<td><?php echo $model->clubNews->news_title;?></td>';
            add_html+='</tr>';
        <?php }else if($model->type==744){?>
            add_html+='<tr class="table-title">';
            add_html+='<td colspan="3"><?php echo $model->m_type->F_NAME;?></td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td>直播编号</td>';
            add_html+='<td>缩略图</td>';
            add_html+='<td>直播标题</td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td><?php echo $model->videoLive->code;?></td>';
            add_html+='<td><a href="<?php echo $basepath->F_WWWPATH.$model->videoLive->logo;?>" target="_blank"> <img src="<?php echo $basepath->F_WWWPATH.$model->videoLive->logo;?>" width="50"></a></td>';
            add_html+='<td><?php echo $model->videoLive->title;?></td>';
            add_html+='</tr>';
        <?php }else if($model->type==745){?>
            add_html+='<tr class="table-title">';
            add_html+='<td colspan="3"><?php echo $model->m_type->F_NAME;?></td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td>视频编码</td>';
            add_html+='<td>缩略图</td>';
            add_html+='<td>视频标题</td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td><?php echo $model->boutiqueVideo->video_code;?></td>';
            add_html+='<td><a href="<?php echo $basepath->F_WWWPATH.$model->boutiqueVideo->video_logo;?>" target="_blank"> <img src="<?php echo $basepath->F_WWWPATH.$model->boutiqueVideo->video_logo;?>" width="50"></a></td>';
            add_html+='<td><?php echo $model->boutiqueVideo->video_title;?></td>';
            add_html+='</tr>';
        <?php }else if($model->type==740){?>
            add_html+='<tr class="table-title">';
            add_html+='<td colspan="3"><?php echo $model->m_type->F_NAME;?></td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td>赛事编码</td>';
            add_html+='<td>缩略图</td>';
            add_html+='<td>赛事标题</td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td><?php echo $model->gameList->game_code;?></td>';
            add_html+='<td><a href="<?php echo $basepath->F_WWWPATH.$model->gameList->game_small_pic;?>" target="_blank"> <img src="<?php echo $basepath->F_WWWPATH.$model->gameList->game_small_pic;?>" width="50"></a></td>';
            add_html+='<td><?php echo $model->gameList->game_title;?></td>';
            add_html+='</tr>';
        <?php }else if($model->type==977){?>
            add_html+='<tr class="table-title">';
            add_html+='<td colspan="3"><?php echo $model->m_type->F_NAME;?></td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td>编号</td>';
            add_html+='<td>缩略图</td>';
            add_html+='<td>培训标题</td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td><?php echo $model->clubStoreTrain->train_code;?></td>';
            add_html+='<td><a href="<?php echo $basepath->F_WWWPATH.$model->clubStoreTrain->train_logo;?>" target="_blank"> <img src="<?php echo $basepath->F_WWWPATH.$model->clubStoreTrain->train_logo;?>" width="50"></a></td>';
            add_html+='<td><?php echo $model->clubStoreTrain->train_title;?></td>';
            add_html+='</tr>';
        <?php }else if($model->type==981){?>
            add_html+='<tr class="table-title">';
            add_html+='<td colspan="3"><?php echo $model->m_type->F_NAME;?></td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td>资源编号</td>';
            add_html+='<td>缩略图</td>';
            add_html+='<td>资源名称</td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td><?php echo $model->qmddServerSourcer->s_code;?></td>';
            add_html+='<td><a href="<?php echo $basepath->F_WWWPATH.$model->qmddServerSourcer->logo_pic;?>" target="_blank"> <img src="<?php echo $basepath->F_WWWPATH.$model->qmddServerSourcer->logo_pic;?>" width="50"></a></td>';
            add_html+='<td><?php echo $model->qmddServerSourcer->s_name;?></td>';
            add_html+='</tr>';
        <?php }else if($model->type==749){?>
            add_html+='<tr class="table-title">';
            add_html+='<td colspan="4"><?php echo $model->m_type->F_NAME;?></td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td>商品编号</td>';
            add_html+='<td>商品LOGO</td>';
            add_html+='<td>商品名称</td>';
            add_html+='<td>商品规格</td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td><?php echo $model->productId->code;?></td>';
            add_html+='<td><a href="<?php echo $basepath->F_WWWPATH.$model->productId->product_ICO;?>" target="_blank"> <img src="<?php echo $basepath->F_WWWPATH.$model->productId->product_ICO;?>" width="50"></a></td>';
            add_html+='<td><?php echo $model->productId->name;?></td>';
            add_html+='<td><?php echo $model->productId->json_attr;?></td>';
            add_html+='</tr>';
        <?php }else if($model->type==747){?>
            add_html+='<tr class="table-title">';
            add_html+='<td colspan="3"><?php echo $model->m_type->F_NAME;?></td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td>群组头像</td>';
            add_html+='<td>群组名称</td>';
            add_html+='<td>群号码</td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td><a href="<?php echo $basepath->F_WWWPATH.$model->gfCrowdBase->BASE_IMG;?>" target="_blank"> <img src="<?php echo $basepath->F_WWWPATH.$model->gfCrowdBase->BASE_IMG;?>" width="50"></a></td>';
            add_html+='<td><?php echo $model->gfCrowdBase->BASE_NAME;?></td>';
            add_html+='<td><?php echo $model->gfCrowdBase->BASE_NUMBER;?></td>';
            add_html+='</tr>';
        <?php }else if($model->type==958){?>
            add_html+='<tr class="table-title">';
            add_html+='<td colspan="4"><?php echo $model->m_type->F_NAME;?></td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td>发表心情人</td>';
            add_html+='<td>发表心情人账号</td>';
            add_html+='<td>心情内容</td>';
            add_html+='<td>发表时间</td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td><?php echo $model->jlbMoodselse->gfUser->GF_NAME;?></td>';
            add_html+='<td><?php echo $model->jlbMoodselse->gfUser->GF_ACCOUNT;?></td>';
            add_html+='<td><?php echo base64_decode($model->jlbMoodselse->content);?></td>';
            add_html+='<td><?php echo $model->jlbMoodselse->ttime;?></td>';
            add_html+='</tr>';
        <?php }else if($model->type==743){?>
            add_html+='<tr class="table-title">';
            add_html+='<td colspan="7"><?php echo $model->m_type->F_NAME;?></td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td>评论编码</td>';
            add_html+='<td>信息类型</td>';
            add_html+='<td>信息标题</td>';
            add_html+='<td>评论人账号</td>';
            add_html+='<td>评论人昵称</td>';
            add_html+='<td>评论内容</td>';
            add_html+='<td>评论时间</td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td><?php echo $model->commentList->t_code;?></td>';
            add_html+='<td><?php echo $model->commentList->type_name;?></td>';
            add_html+='<td><?php echo $model->commentList->communication_news_title;?></td>';
            add_html+='<td><?php echo $model->commentList->communication_gfaccount;?></td>';
            add_html+='<td><?php echo $model->commentList->communication_gfnick;?></td>';
            add_html+='<td><?php echo $model->commentList->communication_content;?></td>';
            add_html+='<td><?php echo $model->commentList->uDate;?></td>';
            add_html+='</tr>';
        <?php }else if($model->type==980){?>
            add_html+='<tr class="table-title">';
            add_html+='<td colspan="10"><?php echo $model->m_type->F_NAME;?></td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td>订单号</td>';
            add_html+='<td>订单类型</td>';
            add_html+='<td>标题</td>';
            add_html+='<td>评价人帐号</td>';
            add_html+='<td>评价人</td>';
            add_html+='<td>评价类型</td>';
            add_html+='<td>用户评分</td>';
            add_html+='<td>评价内容</td>';
            add_html+='<td>评价图片</td>';
            add_html+='<td>评价时间</td>';
            add_html+='</tr>';
            add_html+='<tr>';
            add_html+='<td><?php echo $model->qmddAchievemenData->order_num;?></td>';
            add_html+='<td><?php echo $model->qmddAchievemenData->order_type_name;?></td>';
            <?php if($model->qmddAchievemenData->order_type==361){?>
                add_html+='<td><?php echo $model->qmddAchievemenData->product_title;?></td>';
            <?php }else{?>
                add_html+='<td><?php echo $model->qmddAchievemenData->service_name;?></td>';
            <?php }?>
            add_html+='<td><?php echo $model->qmddAchievemenData->gf_account;?></td>';
            add_html+='<td><?php echo $model->qmddAchievemenData->gf_zsxm;?></td>';
            add_html+='<td><?php echo $model->qmddAchievemenData->f_achievemen_name;?></td>';
            add_html+='<td><?php echo $model->qmddAchievemenData->f_mark1_name;?></td>';
            add_html+='<td><?php echo $model->qmddAchievemenData->evaluate_info;?></td>';
            add_html+='<td><?php foreach(explode(",", $model->qmddAchievemenData->evaluate_img) as $val){echo '<a href="'.$basepath->F_WWWPATH.$val.'" target="_blank"> <img src="'.$basepath->F_WWWPATH.$val.'" width="50"></a>';} ?></td>';
            add_html+='<td><?php echo $model->qmddAchievemenData->evaluate_time;?></td>';
            add_html+='</tr>';
        <?php }?>
        add_html+='</thead>';
        add_html+='</table>';
        add_html+='</form>';
        add_html+='</div>';
    function add_tr(){
        $.dialog({
            id:'pingbi',
            lock:true,
            opacity:0.3,
            // height: '80%',
            // width:'80%',
            title:'举报内容',
            content:add_html,
            button:[
                // <?php if($model->report_processing_msg_id!=1271){?>
                // {
                //     name:'保存',
                //     callback:function(){
                //         return fn_add_tr();
                //     },
                //     focus:true
                // },
                // <?php }?>
                // {
                //     name:'取消',
                //     callback:function(){
                //         return true;
                //     }
                // }
            ]
        });
        $('.aui_main').css('height','auto');
    }
    function fn_add_tr(){
        var form=$('#add_form').serialize();
        we.loading('show');
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('addForm',array('id'=>$model->id));?>',
            data: form,
            dataType: 'json',
            success: function(data) {
                if(data.status==1){
                    we.loading('hide');
                    $.dialog.list['pingbi'].close();
                    we.success(data.msg, data.redirect);
                }else{
                    we.loading('hide');
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }
</script>
