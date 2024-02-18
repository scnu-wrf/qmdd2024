<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动 》课程发布 》发布课程</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create'),'添加'); ?>
            <?php echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="index" value="<?php echo Yii::app()->request->getParam('index');?>">
				<label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php echo downList($project_list,'project_id','project_name','project_id'); ?>
                </label>
                <label>
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入编号或标题">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('course_code');?></th>
                        <th><?php echo $model->getAttributeLabel('course_title');?></th>
                        <th><?php echo $model->getAttributeLabel('course_type2_id');?></th>
                        <th><?php echo $model->getAttributeLabel('project_id');?></th>
                        <th><?php echo $model->getAttributeLabel('course_money');?></th>
                        <th><?php echo $model->getAttributeLabel('dispay_star_time');?></th>
                        <th><?php echo $model->getAttributeLabel('is_online');?></th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->course_code; ?></td>
                            <td><?php echo $v->course_title; ?></td>
                            <td><?php echo $v->course_type2_name; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php echo $v->course_money; ?></td>
                            <td><?php echo $v->dispay_star_time.'<br>'.$v->dispay_end_time; ?></td>
                            <td><?php if(!is_null($v->online))echo $v->online->F_NAME; ?></td>
                            <td><?php echo $v->state_name; ?></td>
                            <td>
                                <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id))); ?>
                                <?php echo show_command('删除','\''.$v->id.'\''); ?>
                            </td>
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
</script>