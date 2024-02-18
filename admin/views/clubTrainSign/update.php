<div class="box">
    <div class="box-title c">
        <h1>
            <?php 
            if(empty($_REQUEST['index'])){
                echo '当前界面：培训/活动 》培训管理 》报名 》详情';
            }elseif($_REQUEST['index']==1){
                echo '当前界面：培训/活动 》培训报名 》报名培训 》添加报名';
            }elseif($_REQUEST['index']==2){
                if($model->state==371){
                    echo '当前界面：培训/活动》培训报名 》报名审核》待审核》详情';
                }else{
                    echo '当前界面：培训/活动》培训报名 》报名审核》详情';
                }
            }
            ?>
        </h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></span>
    </div><!--box-title end-->
    <div class="box-detail">
     <?php $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
            	<table id="t1" style="table-layout:auto;background:none;">
                    <tr>
                        <td style="width:10%;"><?php echo $form->labelEx($model, 'train_title'); ?>：</td>
                        <td style="width:40%;" class="red"><?php echo $model->train_title;?></td>
                        <td style="width:10%;">项目：</td>
                        <td style="width:40%;"><?php echo $train_data->project_name;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'train_data_content'); ?>：</td>
                        <td class="red"><?php echo $model->train_data_content;?></td>
                        <td>培训时间：</td>
                        <td><?php echo $train_data->train_time.'-'.$train_data->train_time_end;?></td>
                    </tr>
                    <tr>
                        <td>培训费用(元)：</td>
                        <td><?php echo $train_data->train_money;?></td>
                        <td>可报名人数：</td>
                        <td><?php echo $train_data->apply_number;?></td>
                    </tr>
                    <tr>
                        <td>报名年龄(最小)：</td>
                        <td>
                            <?php echo $train_data->min_age;?>&nbsp;
                            <?php echo ClubStoreTrain::model()->getAge(strtotime($train_data->min_age)).'周岁';?>
                        </td>
                        <td>报名审核方式：</td>
                        <td><?php if(!is_null($train_data->check_way))echo $train_data->check_way->F_NAME; ?></td>
                    </tr>
                    <tr>
                        <td>报名年龄(最大)：</td>
                        <td colspan="3">
                            <?php echo $train_data->max_age;?>&nbsp;
                            <?php echo ClubStoreTrain::model()->getAge(strtotime($train_data->max_age)).'周岁';?>
                        </td>
                    </tr>
                </table>
                <table class="mt15" id="activity_sign_data" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="2">报名信息</td>
                    </tr>
                    <tr>
                        <td width="150px"><?php echo $form->labelEx($model, 'sign_account'); ?></td>
                        <td>
                            <?php echo $model->sign_account; ?>
                            <?php echo $form->error($model, 'sign_account', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'sign_name'); ?></td>
                        <td>
                            <?php echo $model->sign_name; ?>
                            <?php echo $form->error($model, 'sign_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'sign_sex'); ?></td>
                        <td>
                            <?php echo $model->sign_account; ?>
                            <?php echo $form->error($model, 'sign_sex', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'sige_phone'); ?></td>
                        <td>
                            <?php echo $model->state==721?$form->textField($model, 'sige_phone', array('class' => 'input-text')):$model->sige_phone; ?>
                            <?php echo $form->error($model, 'sige_phone', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <?php 
                        $train_list=ClubStoreTrain::model()->find('id='.$model->train_id);
                        $t_type=ClubStoreType::model()->find('id='.$train_list->train_type1_id);
                        if($t_type->f_id==1504){
                    ?>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'work_unit'); ?></td>
                        <td>
                            <?php echo $model->state==721?$form->textarea($model, 'work_unit', array('class' => 'input-text')):$model->work_unit; ?>
                            <?php echo $form->error($model, 'work_unit', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'Photo'); ?></td>
                        <td>
                            <?php
                                echo $form->hiddenField($model, 'Photo', array('class' => 'input-text fl'));
                                $basepath=BasePath::model()->getPath(288);$picprefix='';
                                if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                if($model->Photo!=''){
                            ?>
                            <div class="upload_img fl" id="upload_pic_ClubTrainSign_Photo">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->Photo;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$model->Photo;?>" width="100">
                                </a>
                            </div>
                            <?php }?>
                            <?php if($model->state==721){ ?>
                                <script>we.uploadpic('<?php echo get_class($model);?>_Photo','<?php echo $picprefix;?>');</script>
                            <?php }?>
                            <?php echo $form->error($model, 'Photo', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td >职称等级</td>
                        <td colspan="3">
                            <?php if($model->state==721){ ?>
                                <?php echo $form->dropDownList($model, 'train_identity_type', Chtml::listData(ClubStoreRank::model()->findAll('isnull(fater_id)'), 'id', 'type_name'), array('prompt' => '请选择','onchange'=>'get_rank(this)')); ?>
                                <?php echo $form->error($model, 'train_identity_type', $htmlOptions = array()); ?>

                                <?php $model->train_identity_type=is_null($model->train_identity_type)?-1:$model->train_identity_type;
                                echo $form->dropDownList($model, 'train_identity_rank', Chtml::listData(ClubStoreRank::model()->findAll('fater_id='.$model->train_identity_type), 'id', 'rank_name'), array('prompt' => '请选择')); ?>
                                <?php echo $form->error($model, 'train_identity_rank', $htmlOptions = array()); ?>
                            <?php }else{?>
                                <?php echo $model->train_identity_type_name.'-'.$model->train_identity_rank_name;?>
                            <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'train_identity_code'); ?></td>
                        <td>
                            <?php echo $model->state==721?$form->textField($model, 'train_identity_code', array('class' => 'input-text')):$model->train_identity_code; ?>
                            <?php echo $form->error($model, 'train_identity_code', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                    <td><?php echo $form->labelEx($model, 'train_identity_image'); ?></td>
                    <td>
                        <?php
                            echo $form->hiddenField($model, 'train_identity_image', array('class' => 'input-text fl'));
                        ?>
                        <div class="upload_img fl" id="upload_pic_ClubTrainSign_train_identity_image">
                            <?php 
                                $basepath=BasePath::model()->getPath(291);$picprefix='';
                                if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                if(!empty($train_identity_image))foreach($train_identity_image as $v) {
                            ?>
                            <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank">
                                <img src="<?php echo $basepath->F_WWWPATH.$v;?>" width="100">
                                <?php if($model->state==721){ ?>
                                    <i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i>
                                <?php }?>
                            </a>
                            <?php }?>

                        </div>
                        <?php if($model->state==721){ ?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_train_identity_image','<?php echo $picprefix;?>','','',function(e1,e2){fnscrollPic(e1.savename,e1.allpath);});</script>
                        <?php }?>
                        <?php echo $form->error($model, 'train_identity_image', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <?php }?>
                </table>
            </div><!--box-detail-tab-item end-->
            <table class="mt15">
                <tr>
                    <td width="150px">可执行操作</td>
                    <td>
                        <?php 
                            echo $form->hiddenField($model, 'state');
                            if($model->state==721){
                                echo show_shenhe_box(array('baocun'=>'保存','tongguo'=>'提交审核'));
                            }elseif($model->state==371){
                                echo '<span style="margin-right:10px;">';
                                echo $form->checkBox($model, 'if_notice', array('value'=>649,'style'=>'vertical-align:middle;','checked'=>'checked'));
                                echo $form->labelEx($model, 'if_notice');
                                echo '</span>';
                                echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过'));
                            }
                        ?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    function get_rank(obj){
        var show_id = $(obj).val();
        var content='<option value="">请选择</option>';
        $("#ClubTrainSign_train_identity_rank").html(content);
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('getRank'); ?>&id='+show_id,
            dataType: 'json',
            success: function(data) {
                $.each(data,function(k,info){
                    content+='<option value="'+info.id+'" >'+info.rank_name+'</option>'
                })
                $("#ClubTrainSign_train_identity_rank").html(content);
            }
        });
    }
</script>