<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>详情</h1><span class="back">
        <a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table class="mt15">
                	<tr class="table-title">
                    	<td colspan="4" >项目信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'club_id'); ?></td>
                        <td>
							<span id="club_box"><?php if($model->club_id!=null){?><span class="label-box"><?php echo $model->club_name;?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text')); ?></span><?php } else {?><span class="label-box"><?php echo $_REQUEST['club_name'];?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value'=>$_REQUEST['club_id'])); ?></span><?php } ?></span>
                            <?php echo $form->error($model, 'club_id', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'p_code'); ?></td>
                        <td><?php echo $model->p_code; ?></td> 
                    </tr>
                    <tr>
                    	<td><?php echo $form->labelEx($model, 'project_id'); ?></td>
                        <td>
                            <?php 
                                $projectid=$model->getClubProject();
                                $clubproject=ProjectList::model()->getClubProject();
                            ?>
                            <script>
                                var $projectid = <?php echo json_encode($projectid) ?>;
                                var $clubproject = <?php echo json_encode($clubproject) ?>;
                            </script>
                            <select id="ClubProject_project_id" name="ClubProject[project_id]">
                                <?php if(!empty($model->project_id)) { ?>                            
                                    <option class="clubp" value="<?php echo $model->project_id; ?>"><?php echo $model->project_list->project_name;?> </option>
							    <?php }?>
                            </select>
                            <?php echo $form->error($model, 'project_id', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'add_time'); ?></td>
                        <td><?php echo $model->add_time;?></td>
                    </tr>
                    <tr>
                         <td><?php echo $form->labelEx($model, 'approve_state'); ?></td>
                        <td>
                            <!--php echo $form->dropDownList($model, 'approve_state', Chtml::listData(BaseCode::model()->getApproveState(), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); -->
                            <?php if(!empty($model->approvestate)) echo $model->approvestate->F_NAME; ?>
                            <?php echo $form->error($model, 'approve_state', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'valid_until'); ?></td>
                        <td><?php echo $model->valid_until;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'project_level'); ?></td>
                        <td><?php echo $model->level_name;?></td>
                        <td><?php echo $form->labelEx($model, 'project_credit'); ?></td>
                        <td>（<?php echo $model->project_credit;?>&nbsp;分）</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'project_state'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'project_state', Chtml::listData(BaseCode::model()->getProjectState(), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'project_state', $htmlOptions = array()); ?>
                        </td>
                        
                        <td><?php echo $form->labelEx($model, 'auth_state'); ?></td>
                        <td>
                            <?php if(!empty($model->auth_state)) echo $model->authstate->F_NAME;?>
                        </td>
                    </tr>
                    <tr>
                    	<td><?php echo $form->labelEx($model, 'apply_content'); ?></td>
                        <td colspan="3"><?php echo $model->apply_content;?>
                            <?php echo $form->textArea($model, 'apply_content', array('class' => 'input-text','maxlength'=>'100')); ?>
                            <?php echo $form->error($model, 'apply_content', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'qualification_pics'); ?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'qualification_pics', array('class' => 'input-text')); ?>
                            <div class="upload_img fl" id="upload_pic_qualification_pics">
                                <?php $basepath=BasePath::model()->getPath(126);$picprefix=''; foreach($qualification_pics as $v) if($v){ ?>
                                    <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>"target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$v;?>" width="100">
                                        <i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i>
                                    </a>
                                <?php }?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <div class="mt15" style="table-layout:auto;">
            <table>
                <tr class="table-title">
                    <td colspan="4">审核信息</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'refuse'); ?></td>
                    <td colspan="3">
                       <?php echo $form->textArea($model, 'refuse', array('class' => 'input-text' )); ?>
                       <?php echo $form->error($model, 'refuse', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                	<td>可执行操作</td>
                    <td colspan="3">
                        <?php echo show_shenhe_box(array('shenhe'=>'提交审核','tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
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
                    <td><?php echo $model->admin_gfname; ?></td>
                    <td><?php echo $model->refuse_state_name; ?></td>
                    <td><?php echo $model->refuse; ?></td>
                </tr>
            </table>
        </div>
    <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
//判断数组中是否有该元素,如：Array.in_array(element);
    Array.prototype.in_array = function (element) {
        for (var i = 0; i < this.length; i++) {
            if (this[i] == element) {
        　　    return true;  
            }
        }
        return false;
    }
</script> 