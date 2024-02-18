
<div class="box">
    <a class="btn" href="javascript:;" onclick="we.reload();" style="vertical-align: middle;float: right; margin-right: 10px;"><i class="fa fa-refresh"></i>刷新</a>
    <div class="box-title c"><h1><?=$_REQUEST['type']==403?'当前界面：会员 》个人成员管理》邀请成员':'当前界面 》 会员 》 单位成员管理 》 单位入会申请'?></h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create',array('type'=>$_REQUEST['type'])),'添加'); ?>
        </div><!-- box-header end -->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="state" value="<?php echo Yii::app()->request->getParam('state');?>">
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
                    <span>申请时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入姓名/账号/项目">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <?php if($_REQUEST['type']==403){?>
                            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                            <th>序号</th>
                            <th>GF账号</th>
                            <th>姓名</th>
                            <th><?= $model->getAttributeLabel('sex');?></th>
                            <th><?= $model->getAttributeLabel('native');?></th>
                            <th><?= $model->getAttributeLabel('apply_phone');?></th>
                            <th><?php echo $model->getAttributeLabel('project_id');?></th>
                            <th><?php echo $model->getAttributeLabel('auth_state');?></th>
                            <th><?php echo $model->getAttributeLabel('apply_time');?></th>
                            <th>操作</th>
                        <?php }else{ ?>
                            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                            <th>序号</th>
                            <th>单位账号</th>
                            <th>申请单位</th>
                            <th><?php echo $model->getAttributeLabel('company_type_id');?></th>
                            <th><?php echo $model->getAttributeLabel('club_region');?></th>
                            <th>联系人</th>
                            <th><?php echo $model->getAttributeLabel('apply_phone');?></th>
                            <th><?php echo $model->getAttributeLabel('project_id');?></th>
                            <th><?php echo $model->getAttributeLabel('auth_state');?></th>
                            <th><?php echo $model->getAttributeLabel('apply_time');?></th>
                            <th>操作</th>
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
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo ($v->type==403) ? $v->gf_account :''; ?></td>
                            <td><?php echo ($v->type==403) ? $v->zsxm : $v->club_name; ?></td>
                            <td><?php echo $v->sex; ?></td>
                            <td><?php echo $v->native; ?></td>
                            <td><?php echo $v->apply_phone; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php echo $v->auth_state_name; ?></td>
                            <td><?php echo $v->apply_time; ?></td>
                            <td>
                                <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'type'=>$v->type))); ?>
                                <?php if($v->auth_state==1483){?>
                                    <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $v->id;?>', cancelUrl);" title="撤销">撤销</a>
                                <?php }?>
                            </td>
                        <?php }else{ ?>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo !empty($v->club_list->club_code)?$v->club_list->club_code:''; ?></td>
                            <td><?php echo $v->club_name; ?></td>
                            <td><?php echo $v->company_type; ?></td>
                            <td><?php echo $v->club_region; ?></td>
                            <td><?php echo $v->zsxm; ?></td>
                            <td><?php echo $v->apply_phone; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php echo $v->auth_state_name; ?></td>
                            <td><?php echo $v->apply_time; ?></td>
                            <td>
                                <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'type'=>$v->type))); ?>
                                <?php if($v->auth_state==1483){?>
                                    <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $v->id;?>', cancelUrl);" title="撤销">撤销</a>
                                <?php }?>
                            </td>
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
    var cancelUrl = '<?php echo $this->createUrl('cancel', array('id'=>'ID','new'=>'state','del'=>374));?>';
    $(function(){
        var $start_date=$('#start_date');
        var $end_date=$('#end_date');
        $start_date.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
        $end_date.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
    });
</script>