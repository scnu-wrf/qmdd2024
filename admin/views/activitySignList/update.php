<div class="box">
    <div class="box-title c">
        <h1>
            <?php 
            if(empty($_REQUEST['index'])){
                echo '当前界面：培训/活动 》活动管理 》报名 》详情';
            }elseif($_REQUEST['index']==1){
                echo '当前界面：培训/活动 》活动报名 》活动报名 》添加报名';
            }elseif($_REQUEST['index']==2){
                if($model->state==371){
                    echo '当前界面：培训/活动》活动报名》报名审核》待审核》详情';
                }else{
                    echo '当前界面：培训/活动》活动报名》报名审核》详情';
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
                        <td style="width:10%;"><?php echo $form->labelEx($model, 'activity_title'); ?>：</td>
                        <td style="width:40%;" class="red"><?php echo $model->activity_title;?></td>
                        <td style="width:10%;">项目：</td>
                        <td style="width:40%;"><?php echo $activity_data->project_name;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'activity_data_id'); ?>：</td>
                        <td class="red"><?php echo $model->activity_data_content;?></td>
                        <td>可报名人数：</td>
                        <td><?php echo $activity_data->apply_number;?></td>
                    </tr>
                    <tr>
                        <td>活动费用(元)：</td>
                        <td><?php echo $activity_data->activity_money;?></td>
                        <td>报名审核方式：</td>
                        <td><?php if(!is_null($activity_data->check_way))echo $activity_data->check_way->F_NAME; ?></td>
                    </tr>
                    <tr>
                        <td>报名年龄(最小)：</td>
                        <td>
                            <?php echo $activity_data->min_age;?>&nbsp;
                            <?php echo ActivityList::model()->getAge(strtotime($activity_data->min_age)).'周岁';?>
                        </td>
                    </tr>
                    <tr>
                        <td>报名年龄(最大)：</td>
                        <td colspan="3">
                            <?php echo $activity_data->max_age;?>&nbsp;
                            <?php echo ActivityList::model()->getAge(strtotime($activity_data->max_age)).'周岁';?>
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
                            <?php //echo $form->textField($model, 'sign_account', array('class' => 'input-text'));
                                echo $model->sign_account; ?>
                            <?php echo $form->error($model, 'sign_account', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'sign_name'); ?></td>
                        <td>
                            <?php //echo $form->textField($model, 'sign_name', array('class' => 'input-text')); 
                                echo $model->sign_name; ?>
                            <?php echo $form->error($model, 'sign_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'sign_sex'); ?></td>
                        <td>
                            <?php //echo $form->dropDownList($model, 'sign_sex', Chtml::listData(ActivityListData::model()->findAll('activity_id='.$model->activity_id), 'id', 'activity_content'), array('prompt'=>'请选择')); 
                                echo $model->sign_sex_name; ?>
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