<?php //var_dump(get_where_club_project('club_id',''))?>
<div id="mask" style="display:none;width: 100%; height: 100%; position: fixed; z-index: 2000; top: 0px; left: 0px; overflow: hidden;"><div class="" style="line-height: 30px;position: absolute;top: calc(50% - 15px);left: calc(50% - 115px);"><span>导入中...</span></div></div>
<div class="box">
    <span style="float:right;padding-right:15px;">
        <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
    </span>
    <div class="box-title c"><h1>当前界面 》 会员 》<?php if($_REQUEST['index']=='1'||$_REQUEST['index']==''){?><?=$_REQUEST['type']==403?' 个人成员管理 》 个人入会审核':' 单位成员管理 》 单位入会审核'?><?php }elseif($_REQUEST['index']=='2'){?> 个人成员管理 》取消/未通过列表<?php }elseif($_REQUEST['index']=='3'){?><?=$_REQUEST['type']==403?' 个人成员管理 》 个人成员列表':' 单位成员管理 》 单位成员列表'?><?php }elseif($_REQUEST['index']=='4'){?><?=$_REQUEST['type']==403?' 个人成员管理 》 个人成员解除':' 单位成员管理 》 单位成员解除'?><?php }?></h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header" <?=$_REQUEST['index']==''||$_REQUEST['index']==2||$_REQUEST['index']==4||$_REQUEST['index']==3?'style="display:none;"':''?>>
            <?php if($_REQUEST['index']==1){?>
            <span class="exam" onclick="on_exam();"><p>待审核：<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span></p></span>
            <?php } ?>
            <?php if($_REQUEST['index']==2){?>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
            <?php } ?>
            <!-- <?php //if($_REQUEST['type']==403&&$_REQUEST['index']==3){?>
                <button class="btn btn-blue" type="button" onclick="javascript:importfile()" >导入</button>
                <a class="btn" href="javascript:;" type="button" onclick="javascript:excel();"><i class="fa fa-file-excel-o"></i>导出</a>
            <?php //}?> -->
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="index" id="index" value="<?php echo Yii::app()->request->getParam('index');?>">
                <input type="hidden" name="state" id="state" value="<?php echo Yii::app()->request->getParam('state');?>">
                <input type="hidden" name="type" value="<?php echo Yii::app()->request->getParam('type');?>">
				<!-- <label style="margin-right:20px;">
                    <span>会员类型：</span>
                    <?php //echo downList($type,'f_id','F_NAME','type'); ?>
                </label> -->
				<label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php echo downList($project_list,'id','project_name','project_id'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>
                        <?php
                            if($_REQUEST['index']==3){
                                echo '入会';
                            }elseif($_REQUEST['index']==1){
                                echo '审核';
                            }elseif($_REQUEST['index']==4){
                                echo '正式解除';
                            }else{
                                echo '申请';
                            }
                        ?>时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="effective_start_time" name="effective_start_time" value="<?php echo $time_start; ?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="effective_end_time" name="effective_end_time" value="<?php  echo $time_end; ?> ">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入会员编号/<?=$_REQUEST['type']==403?'姓名':'名称';?>/账号/项目">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
                <!-- <button class="btn btn-blue" type="button" onclick="javascript:excel();" >导出</button> -->
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <?php if($_REQUEST['type']==403){?>
                            <?php if($_REQUEST['index']==1){?>
                                <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                                <th>序号</th>
                                <th><?php echo $model->getAttributeLabel('code');?></th>
                                <th>GF账号</th>
                                <th>姓名</th>
                                <th><?= $model->getAttributeLabel('sex');?></th>
                                <th><?= $model->getAttributeLabel('native');?></th>
                                <th><?= $model->getAttributeLabel('apply_phone');?></th>
                                <th><?php echo $model->getAttributeLabel('project_id');?></th>
                                <th><?php echo $model->getAttributeLabel('state');?></th>
                                <th><?php echo $model->getAttributeLabel('update');?></th>
                                <th>操作</th>
                            <?php }elseif($_REQUEST['index']==2){?>
                                <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                                <th>序号</th>
                                <th><?php echo $model->getAttributeLabel('code');?></th>
                                <th>GF账号</th>
                                <th>姓名</th>
                                <th><?= $model->getAttributeLabel('sex');?></th>
                                <th><?= $model->getAttributeLabel('native');?></th>
                                <th><?= $model->getAttributeLabel('apply_phone');?></th>
                                <th><?php echo $model->getAttributeLabel('project_id');?></th>
                                <th><?php echo $model->getAttributeLabel('auth_state');?></th>
                                <th>操作</th>
                            <?php }elseif($_REQUEST['index']==3){?>
                                <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                                <th>序号</th>
                                <th><?php echo $model->getAttributeLabel('code');?></th>
                                <th>GF账号</th>
                                <th>姓名</th>
                                <th><?= $model->getAttributeLabel('sex');?></th>
                                <th><?= $model->getAttributeLabel('native');?></th>
                                <th><?= $model->getAttributeLabel('apply_phone');?></th>
                                <th><?php echo $model->getAttributeLabel('project_id');?></th>
                                <th><?php echo $model->getAttributeLabel('auth_state');?></th>
                                <th>入会时间</th>
                                <th>操作</th>
                            <?php }elseif($_REQUEST['index']==4){?>
                                <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                                <th>序号</th>
                                <th><?php echo $model->getAttributeLabel('code');?></th>
                                <th>GF账号</th>
                                <th>姓名</th>
                                <th><?= $model->getAttributeLabel('sex');?></th>
                                <th><?= $model->getAttributeLabel('native');?></th>
                                <th><?= $model->getAttributeLabel('apply_phone');?></th>
                                <th><?php echo $model->getAttributeLabel('project_id');?></th>
                                
                                <th><?php echo $model->getAttributeLabel('auth_state');?></th>
                                <th><?php echo $model->getAttributeLabel('apply_relieve_time');?></th>
                                <th><?php echo $model->getAttributeLabel('relieve_time');?></th>
                                <th>操作</th>
                            <?php }elseif($_REQUEST['index']==5){?>
                                <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                                <th>序号</th>
                                <th><?php echo $model->getAttributeLabel('code');?></th>
                                <th>GF账号</th>
                                <th>姓名</th>
                                <th><?= $model->getAttributeLabel('sex');?></th>
                                <th><?= $model->getAttributeLabel('native');?></th>
                                <th><?= $model->getAttributeLabel('apply_phone');?></th>
                                <th><?php echo $model->getAttributeLabel('project_id');?></th>
                                <th><?php echo $model->getAttributeLabel('apply_time');?></th>
                                <th><?php echo $model->getAttributeLabel('auth_state');?></th>
                                <th>操作</th>
                            <?php } ?>
                        <?php }else{ ?>
                            <?php if($_REQUEST['index']==1){?>
                                <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                                <th>序号</th>
                                <th><?php echo $model->getAttributeLabel('code');?></th>
                                <th>单位账号</th>
                                <th>申请单位</th>
                                <th><?php echo $model->getAttributeLabel('company_type_id');?></th>
                                <th><?php echo $model->getAttributeLabel('club_region');?></th>
                                <th>联系人</th>
                                <th><?php echo $model->getAttributeLabel('apply_phone');?></th>
                                <th><?php echo $model->getAttributeLabel('project_id');?></th>
                                <th><?php echo $model->getAttributeLabel('state');?></th>
                                <th><?php echo $model->getAttributeLabel('update');?></th>
                                <th>操作</th>
                            <?php }elseif($_REQUEST['index']==2){ ?>
                                <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                                <th>序号</th>
                                <th><?php echo $model->getAttributeLabel('code');?></th>
                                <th>单位账号</th>
                                <th>申请单位</th>
                                <th><?php echo $model->getAttributeLabel('company_type_id');?></th>
                                <th><?php echo $model->getAttributeLabel('club_region');?></th>
                                <th>联系人</th>
                                <th><?php echo $model->getAttributeLabel('apply_phone');?></th>
                                <th><?php echo $model->getAttributeLabel('project_id');?></th>
                                <th><?php echo $model->getAttributeLabel('auth_state');?></th>
                                <th>操作</th>
                            <?php }elseif($_REQUEST['index']==3){ ?>
                                <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                                <th>序号</th>
                                <th><?php echo $model->getAttributeLabel('code');?></th>
                                <th>单位账号</th>
                                <th>申请单位</th>
                                <th><?php echo $model->getAttributeLabel('company_type_id');?></th>
                                <th><?php echo $model->getAttributeLabel('club_region');?></th>
                                <th>联系人</th>
                                <th><?php echo $model->getAttributeLabel('apply_phone');?></th>
                                <th><?php echo $model->getAttributeLabel('project_id');?></th>
                                <th>入会时间</th>
                                <th>操作</th>
                            <?php }elseif($_REQUEST['index']==4){ ?>
                                <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                                <th>序号</th>
                                <th><?php echo $model->getAttributeLabel('code');?></th>
                                <th>单位账号</th>
                                <th>申请单位</th>
                                <th><?php echo $model->getAttributeLabel('company_type_id');?></th>
                                <th><?php echo $model->getAttributeLabel('club_region');?></th>
                                <th>联系人</th>
                                <th><?php echo $model->getAttributeLabel('apply_phone');?></th>
                                <th><?php echo $model->getAttributeLabel('project_id');?></th>
                                <th><?php echo $model->getAttributeLabel('auth_state');?></th>
                                <th><?php echo $model->getAttributeLabel('apply_relieve_time');?></th>
                                <th><?php echo $model->getAttributeLabel('relieve_time');?></th>
                                <th>操作</th>
                            <?php }elseif($_REQUEST['index']==5){ ?>
                                <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                                <th>序号</th>
                                <th><?php echo $model->getAttributeLabel('code');?></th>
                                <th>单位账号</th>
                                <th>申请单位</th>
                                <th><?php echo $model->getAttributeLabel('company_type_id');?></th>
                                <th><?php echo $model->getAttributeLabel('club_region');?></th>
                                <th>联系人</th>
                                <th><?php echo $model->getAttributeLabel('apply_phone');?></th>
                                <th><?php echo $model->getAttributeLabel('project_id');?></th>
                                <th><?php echo $model->getAttributeLabel('apply_time');?></th>
                                <th>操作</th>
                            <?php } ?>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
    $index = 1;
    foreach($arclist as $v){ 
?>
                    <tr>
                        <?php if($_REQUEST['type']==403){?>
                            <?php if($_REQUEST['index']==1){?>
                                <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                                <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                                <td><?php echo $v->code; ?></td>
                                <td><?php echo $v->gf_account; ?></td>
                                <td><?php echo $v->zsxm; ?></td>
                                <td><?php echo $v->sex; ?></td>
                                <td><?php echo $v->native; ?></td>
                                <td><?php echo $v->apply_phone; ?></td>
                                <td><?php echo $v->project_name; ?></td>
                                <td><?php echo $v->state_name; ?></td>
                                <td><?php echo $v->update; ?></td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'type'=>$v->type))); ?>
                                </td>
                            <?php }elseif($_REQUEST['index']==2){?>
                                <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                                <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                                <td><?php echo $v->code; ?></td>
                                <td><?php echo $v->gf_account; ?></td>
                                <td><?php echo $v->zsxm; ?></td>
                                <td><?php echo $v->sex; ?></td>
                                <td><?php echo $v->native; ?></td>
                                <td><?php echo $v->apply_phone; ?></td>
                                <td><?php echo $v->project_name; ?></td>
                                <td>
                                    <?php 
                                        if($v->state==374){
                                            echo $v->state_name; 
                                        }else{
                                            echo $v->invite_initiator==210?'单位拒绝加入':'成员拒绝加入'; 
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'type'=>$v->type))); ?>
                                    <?php echo show_command('删除','\''.$v->id.'\''); ?>
                                </td>
                            <?php }elseif($_REQUEST['index']==3){?>
                                <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                                <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                                <td><?php echo $v->code; ?></td>
                                <td><?php echo $v->gf_account; ?></td>
                                <td><?php echo $v->zsxm; ?></td>
                                <td><?php echo $v->sex; ?></td>
                                <td><?php echo $v->native; ?></td>
                                <td><?php echo $v->apply_phone; ?></td>
                                <td><?php echo $v->project_name; ?></td>
                                <td><?php echo $v->auth_state_name; ?></td>
                                <td><?php echo $v->entry_validity; ?></td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'type'=>$v->type))); ?>
                                    <?php if($v->state==372&&$v->auth_state==931){?>
                                        <a class="btn" href="javascript:;" onclick="unuse('<?php echo $v->id;?>', unuseUrl);" title="解除">解除</a>
                                    <?php }?>
                                </td>
                            <?php }elseif($_REQUEST['index']==4){?>
                                <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                                <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                                <td><?php echo $v->code; ?></td>
                                <td><?php echo $v->gf_account; ?></td>
                                <td><?php echo $v->zsxm; ?></td>
                                <td><?php echo $v->sex; ?></td>
                                <td><?php echo $v->native; ?></td>
                                <td><?php echo $v->apply_phone; ?></td>
                                <td><?php echo $v->project_name; ?></td>
                                <td><?php echo $v->auth_state_name; ?></td>
                                <td><?php echo $v->apply_relieve_time; ?></td>
                                <td><?php echo $v->relieve_time; ?></td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'index'=>4,'type'=>$v->type))); ?>
                                    <?php if($v->state==372&&$v->auth_state==1484){?>
                                        <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $v->id;?>', cancelUrl);" title="撤销">撤销</a>
                                    <?php }?>
                                </td>
                            <?php }elseif($_REQUEST['index']==5){?>
                                <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                                <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                                <td><?php echo $v->code; ?></td>
                                <td><?php echo $v->gf_account; ?></td>
                                <td><?php echo $v->zsxm; ?></td>
                                <td><?php echo $v->sex; ?></td>
                                <td><?php echo $v->native; ?></td>
                                <td><?php echo $v->apply_phone; ?></td>
                                <td><?php echo $v->project_name; ?></td>
                                <td><?php echo $v->apply_time; ?></td>
                                <td><?php echo $v->auth_state_name; ?></td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'type'=>$v->type))); ?>
                                </td>
                            <?php } ?>

                        <?php }else{ ?>
                            <?php if($_REQUEST['index']==1){?>
                                <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                                <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                                <td><?php echo $v->code; ?></td>
                                <td><?php $c=!empty($v->club_list->club_code)?$v->club_list->club_code:''; echo $c; ?></td>
                                <td><?php echo $v->club_name; ?></td>
                                <td><?php echo $v->company_type; ?></td>
                                <td><?php echo $v->club_region; ?></td>
                                <td><?php echo $v->zsxm; ?></td>
                                <td><?php echo $v->apply_phone; ?></td>
                                <td><?php echo $v->project_name; ?></td>
                                <td><?php echo $v->state_name; ?></td>
                                <td><?php echo $v->update; ?></td>
                            <td>
                                <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'type'=>$v->type))); ?>
                            </td>
                            <?php }elseif($_REQUEST['index']==2){?>
                                <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                                <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                                <td><?php echo $v->code; ?></td>
                                <td><?php $c=!empty($v->club_list->club_code)?$v->club_list->club_code:''; echo $c; ?></td>
                                <td><?php echo $v->club_name; ?></td>
                                <td><?php echo $v->company_type; ?></td>
                                <td><?php echo $v->club_region; ?></td>
                                <td><?php echo $v->zsxm; ?></td>
                                <td><?php echo $v->apply_phone; ?></td>
                                <td><?php echo $v->project_name; ?></td>
                                <td>
                                    <?php 
                                        if($v->state==374){
                                            echo $v->state_name; 
                                        }else{
                                            echo $v->invite_initiator==210?'拒绝申请':'拒绝邀请'; 
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'type'=>$v->type))); ?>
                                    <?php echo show_command('删除','\''.$v->id.'\''); ?>
                                </td>
                            <?php }elseif($_REQUEST['index']==3){?>
                                <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                                <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                                <td><?php echo $v->code; ?></td>
                                <td><?php $c=!empty($v->club_list->club_code)?$v->club_list->club_code:''; echo $c; ?></td>
                                <td><?php echo $v->club_name; ?></td>
                                <td><?php echo $v->company_type; ?></td>
                                <td><?php echo $v->club_region; ?></td>
                                <td><?php echo $v->zsxm; ?></td>
                                <td><?php echo $v->apply_phone; ?></td>
                                <td><?php echo $v->project_name; ?></td>
                                <td><?php echo $v->update; ?></td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'type'=>$v->type))); ?>
                                    <?php if($v->state==372&&$v->auth_state==931){?>
                                        <a class="btn" href="javascript:;" onclick="unuse('<?php echo $v->id;?>', unuseUrl);" title="解除">解除</a>
                                    <?php }?>
                                </td>
                            <?php }elseif($_REQUEST['index']==4){?>
                                <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                                <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                                <td><?php echo $v->code; ?></td>
                                <td><?php $c=!empty($v->club_list->club_code)?$v->club_list->club_code:''; echo $c; ?></td>
                                <td><?php echo $v->club_name; ?></td>
                                <td><?php echo $v->company_type; ?></td>
                                <td><?php echo $v->club_region; ?></td>
                                <td><?php echo $v->zsxm; ?></td>
                                <td><?php echo $v->apply_phone; ?></td>
                                <td><?php echo $v->project_name; ?></td>
                                <td><?php echo $v->auth_state_name; ?></td>
                                <td><?php echo $v->apply_relieve_time; ?></td>
                                <td><?php echo $v->relieve_time; ?></td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'index'=>4,'type'=>$v->type))); ?>
                                    <?php if($v->state==372&&$v->auth_state==1484){?>
                                        <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $v->id;?>', cancelUrl);" title="撤销">撤销</a>
                                    <?php }?>
                                </td>
                            <?php }elseif($_REQUEST['index']==5){?>
                                <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                                <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                                <td><?php echo $v->code; ?></td>
                                <td><?php $c=!empty($v->club_list->club_code)?$v->club_list->club_code:''; echo $c; ?></td>
                                <td><?php echo $v->club_name; ?></td>
                                <td><?php echo $v->company_type; ?></td>
                                <td><?php echo $v->club_region; ?></td>
                                <td><?php echo $v->zsxm; ?></td>
                                <td><?php echo $v->apply_phone; ?></td>
                                <td><?php echo $v->project_name; ?></td>
                                <td><?php echo $v->apply_time; ?></td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'type'=>$v->type))); ?>
                                </td>
                            <?php } ?>

                        <?php } ?>
                    </tr>
<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
    var unuseUrl = '<?php echo $this->createUrl('unuse', array('id'=>'ID','new'=>'auth_state','del'=>1484));?>';
    var cancelUrl = '<?php echo $this->createUrl('cancel', array('id'=>'ID','new'=>'auth_state','del'=>931));?>';

    var unuse = function(id, url) {
        we.overlay('show');
        if (id == '' || id == undefined) {
            we.msg('error', '请选择要解除的单位', function() {
                we.loading('hide');
            });
            return false;
        }
        var fnUnuse = function() {
            url = url.replace(/ID/, id);
            console.log(url)
            $.ajax({
                type: 'get',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 1) {
                        we.msg('check', data.msg, function() {
                            we.loading('hide');
                            we.reload();
                        });
                    } else {
                        we.msg('error', data.msg, function() {
                            we.loading('hide');
                        });
                    }
                }
            });
        };
        $.fallr('show', {
            buttons: {
                button1: {text: '解除', danger: true, onclick: fnUnuse},
                button2: {text: '取消'}
            },
            content: '确定解除？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });
    };

    var $effective_start_time=$('#effective_start_time');
    var $effective_end_time=$('#effective_end_time');
    $effective_start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
    });
    $effective_end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
    });

    function on_exam(){
        var exam = $('.exam p span').text();
        if(exam>0){ 
            $('#state').val(371);
            $('#index').val(5);
            $('.box-search select').html('<option value>请选择</option>');
            $('.box-search .input-text').val('');
            document.getElementById('submit_button').click();
        }
    }

    function excel(){
        $("#is_excel").val(1);
        $("#submit_button").click();
        $("#is_excel").val(0);
    }
    
    function importfile(){
        $.dialog.open('<?php echo $this->createUrl("upExcel");?>',{
            id:'sensitive',
            lock:true,
            opacity:0.3,
            title:'导入学生信息',
            width:'60%',
            height:'50%',
            close: function () {
                // window.location.reload(true);
            }
        });
    }
</script>