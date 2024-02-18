<div class="box" div style="font-size: 9px">
	<div class="box-title c"><h1><i class="fa fa-table"></i>服务者信息</h1></div>
    <div class="box-content">
    	<div class="box-header">
    		<a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a>   
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>性别：</span>
                    <?php echo downList($sex,'f_id','F_NAME','sex'); ?>
                </label>
				<label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php echo downList($project_list,'id','project_name','project'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>类型：</span>
                    <?php echo downList($type_id,'f_id','F_NAME','type_id'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>资质等级：</span>
                    <?php echo downList($identity,'f_id','F_NAME','identity'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>服务者等级：</span>
                    <?php echo downList($type_code,'f_id','card_name','type_code'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>续签状态：</span>
                    <select name="renew_state">
                        <option value="">请选择</option>
                        <?php foreach($renew_state as $v){?>
                         <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('renew_state')==$v->f_id){?> selected<?php }?>><?php if($v->f_id==371){echo '待续签';}else{echo $v->F_NAME;}?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <input name="sky" class="sky" type="radio" value="30" <?php if(Yii::app()->request->getParam('sky')==30||Yii::app()->request->getParam('sky')=='')echo 'checked="checked"';?>><span>30天</span> 
                    <input name="sky" class="sky" type="radio" value="15" <?php if(Yii::app()->request->getParam('sky')==15)echo 'checked="checked"';?>><span>15天</span> 
                    <input name="sky" class="sky" type="radio" value="1" <?php if(Yii::app()->request->getParam('sky')==1)echo 'checked="checked"';?>><span>1天</span> 
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="text-align:center;">序号</th>
                        <th><?php echo $model->getAttributeLabel('gfaccount');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_name');?></th>
                        <th>姓别</th>
                        <th><?php echo $model->getAttributeLabel('project_name');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_type');?></th>
                        <th><?php echo $model->getAttributeLabel('identity_num');?></th>
                        <th>资质有效期</th>
                        <th><?php echo $model->getAttributeLabel('qualification_level');?></th>
                        <th>服务者有效期</th>
                        <th>剩余天数</th>
                        <th><?php echo $model->getAttributeLabel('if_del');?></th>
                        <th><?php echo $model->getAttributeLabel('check_state');?></th>
                        <th><?php echo $model->getAttributeLabel('is_pay');?></th>
                        <th><?php echo $model->getAttributeLabel('renew_state_time');?></th>
                        <th>操作</th>
                       
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1;foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style="text-align:center;"><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php echo CHtml::link($v->gfaccount, array('update', 'id'=>$v->id)); ?></td>
                        <td><?php echo $v->qualification_name; ?></td>
                        <td><?php echo $v->userlist->real_sex_name; ?></td>
                        <td><?php echo $v->project_name; ?></td>
                        <td><?php echo $v->qualification_type; ?></td>
                        <td><?php echo $v->qualification_title; ?></td>
                        <td><?php if(empty($v->end_date)){echo '长期';}else{echo date('Y年m月d日',strtotime($v->end_date));} ?></td>
                        <td><?php echo $v->level_name; ?></td>
                        <td><?php if(!empty($v->expiry_date_end))echo date('Y年m月d日',strtotime($v->expiry_date_end)); ?></td>
                        <td>
                            <?php 
                                $date=floor((strtotime($v->expiry_date_end)-time())/86400);
                                echo $date.'天'; 
                            ?>
                        </td>
                        <td><?php echo $v->acc_status->F_NAME; ?></td>
                        <td><?php echo $v->check_state_name; ?></td>
                        <td><?php echo $v->is_pay_name; ?></td>
                        <td><?php echo $v->renew_state_time; ?></td>
                        <td>
                            <?php echo show_command('详情',$this->createUrl('update', array('id'=>$v->id))); ?>
                            <a class="btn" href="<?php echo $this->createUrl('', array('id'=>$v->id));?>" title="通知">发通知</a>
                        </td>
                    </tr>
                <?php $index++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>