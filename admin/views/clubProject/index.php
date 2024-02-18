<?php
if(!isset($_REQUEST['club_id'])){
     $_REQUEST['club_id']=get_session('club_id');
 }
 if(!isset($_REQUEST['club_name'])){
     $_REQUEST['club_name']=get_session('club_name');
 }
 ?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：项目 》单位项目管理 》各单位项目查询</h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
    	<!-- <div class="box-header">
            <a class="btn" href="<?php //echo $this->createUrl('create',array('club_id'=>$_REQUEST['club_id'],'club_name'=>$_REQUEST['club_name']));?>"><i class="fa fa-plus"></i>申请新项目</a>
        </div>box-header end -->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="club_id" value="<?php echo $_REQUEST["club_id"];?>">
                <input type="hidden" name="club_name" value="<?php echo $_REQUEST["club_name"];?>">
                <label style="margin-right:20px;">
                    <span>审核状态：</span>
                    <select name="state">
                        <option value="">请选择</option>
                        <?php if(is_array($base_code)) foreach($base_code as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('state')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入项目名称 / 单位名称" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list"><!--此处项目，链接club_project表-->
                	<tr class="table-title">
                    	<td>序号</td>
                        <th><?php echo $model->getAttributeLabel('p_code');?></th>
                        <td><?php echo $model->getAttributeLabel('club_name');?></td>
                        <td><?php echo $model->getAttributeLabel('club_type');?></td>
                        <td><?php echo $model->getAttributeLabel('project_id');?></td>
                        <td><?php echo $model->getAttributeLabel('project_level');?></td>
                        <td><?php echo $model->getAttributeLabel('state_name');?></td>
                        <td><?php echo $model->getAttributeLabel('effective_date');?></td>  
                        <td><?php echo $model->getAttributeLabel('valid_until');?></td>
                        <td>操作</td>
                    </tr>
                    <?php
					$index = 1;
					 foreach($arclist as $v){ ?>
                    <tr>
                    	<td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->p_code; ?></td>
                        <td><?php echo $v->club_name; ?></td>
                        <td><?php echo $v->club_type_name; ?></td>
                        <td><?php echo $v->project_name; ?></td>
                        <td><?php echo $v->level_name; ?></td>
                        <!-- <td><?php //echo $v->level_name; ?>（<?php //echo $v->project_credit; ?>分）</td> -->
                        <td><?php echo $v->state_name; ?></td>
                        <td><?php echo $v->entry_validity; ?></td>
                        <td><?php echo $v->effective_date.'<br>'.$v->valid_until; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('qualificationClub/index1',array('id'=>$v->id, 'club_id'=>$v->club_id, 'project_id'=>$v->project_id));?>" title="服务者信息">服务者信息</a>
                            <?php echo show_command('详情',$this->createUrl('update', array('id'=>$v->id))); ?>
                        </td>
                    </tr>
                   <?php $index++; } ?>
                </table>
                 
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>
