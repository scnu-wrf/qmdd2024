 <?php
 
    if (!isset($_REQUEST['pid'])) {$_REQUEST['pid']=0;}
    if (!isset($_REQUEST['appname'])) {$_REQUEST['appname']='';}


?> 
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>应用更新</h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create',array('pid'=>$_REQUEST['pid'],'appname'=>$_REQUEST['appname']));?>"><i class="fa fa-plus"></i>更新</a>

        </div><!--box-header end-->

        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input style="display:none;" class="input-text" type="text" name="pid" value="<?php echo $_REQUEST["pid"];?>">
            </form>
        </div><!--box-search end-->        

<!-- 更新时间    更新包名    版本号 状态 -->

        <div class="box-table">
            <table class="list">
                <thead>
                    <tr align="center">
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('dispay_time');?></th>
                        <th><?php echo $model->getAttributeLabel('name');?></th>
                        <th><?php echo $model->getAttributeLabel('version');?></th>
                        <th><?php echo $model->getAttributeLabel('state_name');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>


                    <?php 
                    $i=1; 
                    $index = 1;
                    foreach($arclist as $v){ ?>
                    <tr align="center">
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo ($v->dispay_time=='0000-00-00 00:00:00') ? '' : $v->dispay_time; ?></td>
                        <td><?php echo $v->name; ?></td>
                        <td><?php echo $v->version; ?></td>
                        <td><?php echo $v->state_name; ?></td>
                        <td>
                        &nbsp;&nbsp;<a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id,'pid'=>$v->app_id,'appname'=>$v->app_name));?>" title="编辑"><i class="fa fa-edit"></i></a>
                        </td>
                        
                    </tr>




                    <?php $i++; $index++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->                






        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>