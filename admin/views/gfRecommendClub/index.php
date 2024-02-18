
<div class="box">
    <div class="box-title c">
		<h1>当前界面：系统》业务推送》<a class="nav-a">推送单位管理</a></h1>
        <span class="back"><a class="btn" href="<?php echo Yii::app()->request->url;?>"><i class="fa fa-refresh"></i>刷新</a></span>
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
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="单位名称 / 单位编码" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                	<tr class="table-title">
                    	<th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('club_code');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('partnership_type');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('club_name');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('add_time');?></th>
                        <th style="text-align:center">操作</th>
                    </tr>
                    <?php 
					 if(is_array($arclist)) foreach($arclist as $v){ ?>
                    <tr>
                    	<td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php echo $v->club_code; ?></td>
                        <td><?php echo $v->partnership_name; ?></td>
                        <td><?php echo $v->club_name; ?></td>
                        <td><?php echo $v->add_time; ?></td>
                        <td>
                        	<a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <?php echo show_command('删除','\''.$v->id.'\''); ?>
                        </td>
                    </tr>
                   <?php } ?>
                </table>
                 
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>
