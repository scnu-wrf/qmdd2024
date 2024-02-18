
<div class="box" div style="font-size: 9px">
    <div class="box-title c">
    <h1>
        <span>当前界面：服务者》服务者费用》缴费通知</span>
    </h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header"><!--资质人信息--->
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input class="input-text" type="hidden" name="club_id" value="<?php echo Yii::app()->session['club_id'];?>">
                <label style="margin-right:20px;">
                    <span>性别：</span>
                    <select name="sex">
                        <option value="">请选择</option>
                        <?php foreach($sex as $v){?>
                         <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('sex')!==null && Yii::app()->request->getParam('sex')!==''  && Yii::app()->request->getParam('sex')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
				<label style="margin-right:20px;">
                    <span>项目：</span>
                    <select name="project">
                        <option value="">请选择</option>
                        <?php foreach($project as $v){?>
                        <option value="<?php echo $v->id;?>"<?php if(Yii::app()->request->getParam('project')==$v->id){?> selected<?php }?>><?php echo $v->project_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>类型：</span>
                    <select name="type">
                        <option value="">请选择</option>
                        <?php foreach($type as $v){?>
                         <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('type')!==null && Yii::app()->request->getParam('type')!==''  && Yii::app()->request->getParam('type')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>资质等级：</span>
                    <select name="identity">
                        <option value="">请选择</option>
                        <?php foreach($identity as $v){?>
                         <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('identity')!==null && Yii::app()->request->getParam('identity')!==''  && Yii::app()->request->getParam('identity')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>服务者等级：</span>
                    <select name="type_code">
                        <option value="">请选择</option>
                        <?php foreach($type_code as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('type_code')!=null && Yii::app()->request->getParam('type_code')==$v->f_id){?> selected<?php }?>><?php echo $v->card_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>续签状态：</span>
                    <select name="is_pay">
                        <option value="">请选择</option>
                        <?php foreach($is_pay as $v){?>
                         <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('is_pay')!==null && Yii::app()->request->getParam('is_pay')!==''  && Yii::app()->request->getParam('is_pay')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <br>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
               </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="text-align:center;">序号</th>
                        <th><?php echo $model->getAttributeLabel('qualification_gfaccount');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_name');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_sex');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_project_id');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_type_id');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_identity_num');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_level');?></th>
                        <th><?php echo $model->getAttributeLabel('entry_validity');?></th>
                        <th><?php echo $model->getAttributeLabel('time_remaining');?></th>
                        <th><?php echo $model->getAttributeLabel('state_name');?></th>
                        <th><?php echo $model->getAttributeLabel('check_state');?></th>
                        <th><?php echo $model->getAttributeLabel('state_time');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1;foreach($arclist as $v){ ?>
                    <tr>
                        <td style="text-align:center;"><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php echo $v->qualification_gfaccount; ?></td>
                        <td><?php echo $v->qualification_name; ?></td>
                        <td><?php echo $v->qualification_sex=='207'?'女':'男'; ?></td>
                        <td><?php echo $v->qualification_project_name; ?></td>
                        <td><?php echo $v->qualification_type; ?></td>
                        <td><?php echo $v->qualification_title; ?></td>
                        <td><?php echo $v->qualification_level_name; ?></td>
                        <td><?php echo $v->entry_validity; ?></td>
                        <td>
                            <?php 
                                $date=floor((strtotime($v->entry_validity)-time())/86400);
                                echo $date.'天'; 
                            ?>
                        </td>
                        <td><?php echo $v->qualifications_person->acc_status->F_NAME; ?></td>
                        <td><?php echo $v->check_state_name; ?></td>
                        <td><?php echo $v->state_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                             <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
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