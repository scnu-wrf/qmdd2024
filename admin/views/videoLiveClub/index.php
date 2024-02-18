
<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播》直播单位》<a class="nav-a">直播单位申请</a></h1>
        <span class="back"><a class="btn" href="<?php echo $this->createUrl('index');?>"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end--> 
    <div class="box-content">
    	<div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create'),'添加'); ?>
            <?php echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>申请日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start" name="start" value="<?php echo Yii::app()->request->getParam('start');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end" name="end" value="<?php echo Yii::app()->request->getParam('end');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="名称 / 帐号" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                	<tr class="table-title">
                    	<th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="text-align:center;">序号</th>
                        <th><?php echo $model->getAttributeLabel('club_code');?></th>
                        <th><?php echo $model->getAttributeLabel('club_name');?></th>
                        <th><?php echo $model->getAttributeLabel('partnership_type');?></th>
                        <th><?php echo $model->getAttributeLabel('apply_name');?></th>
                        <th><?php echo $model->getAttributeLabel('contact_phone');?></th>
                        <th><?php echo $model->getAttributeLabel('state');?></th>
                        <th><?php echo $model->getAttributeLabel('apply_time');?></th>
                        <th>操作</th>
                    </tr>
 <?php   $index = 1;
    foreach($arclist as $v){ ?>
                    <tr>
                    	<td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->club_code; ?></td>
                        <td><?php echo $v->club_name; ?></td>
                        <td><?php echo $v->partnership_name; ?></td>
                        <td><?php echo $v->apply_name; ?></td>
                        <td><?php echo $v->contact_phone; ?></td>
                        <td><?php echo $v->state_name; ?></td>
                        <td><?php echo $v->apply_time; ?></td>
                        <td>
                            <?php if($v->state==721){ ?>
                        	<a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <?php echo show_command('删除','\''.$v->id.'\''); ?>
                        <?php } ?>
                            <?php if($v->state==371){ ?>
                            <a class="btn" href="<?php echo $this->createUrl('update_checked', array('id'=>$v->id,'flag'=>'index'));?>" title="详情">查看</a>
                            <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $v->id;?>', cancel);" title="撤销申请">撤销申请</a>
                        <?php } ?>
                        </td>
                    </tr>
   <?php  $index++; } ?>
                </table>
                 
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
var cancel = '<?php echo $this->createUrl('cancelSubmit', array('id'=>'ID'));?>';
    var $start=$('#start');
    var $end=$('#end');
    $start.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
</script>
