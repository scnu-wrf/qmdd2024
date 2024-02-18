<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播》直播管理》<a class="nav-a">节目单</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
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
                    <span>日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="program_time_start" name="program_time_start" value="<?php echo $time_start; ?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="program_time_end" name="program_time_end" value="<?php  echo $time_end; ?>">
                </label>
                <label style="margin-right:20px;">
                    <span>直播标题：</span>
                    <?php echo downList($live_list,'id','title','live_id'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="节目名称" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                	<tr class="table-title">
                    	<th style='text-align: center;'>序号</th>
                        <th style="width:15%;"><?php echo $model->getAttributeLabel('live_id');?></th>
                        <th><?php echo $model->getAttributeLabel('program_code');?></th>
                        <th style="width:15%;"><?php echo $model->getAttributeLabel('title');?></th>
                        <th><?php echo $model->getAttributeLabel('program_time');?></th>
                        <th><?php echo $model->getAttributeLabel('program_end_time');?></th>
                        <th><?php echo $model->getAttributeLabel('online');?></th>
                        <th>操作</th>
                    </tr>
					<?php $index = 1;
					if(is_array($arclist)) foreach($arclist as $v){ ?>
                    <tr>
                    	<td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php if(!empty($v->video_live)) echo $v->video_live->title; ?></td>
                        <td><?php echo $v->program_code; ?></td>
                        <td><?php echo $v->title; ?></td>
                        <td><?php echo $v->program_time; ?></td>
                        <td><?php echo $v->program_end_time; ?></td>
                        <td><?php echo ($v->online==649) ? '上线' : '下线'; ?></td>
                        <td>
							<a class="btn" href="<?php echo $this->createUrl('update_program', array('id'=>$v->id));?>" title="编辑">编辑</a>
							<?php if($v->online==649){ ?>
                            <a class="btn" href="javascript:;" onclick="we.down('<?php echo $v->id;?>', downUrl);" title="下线处理">下线</a>
							<?php } else{ ?>
                            <a class="btn" href="javascript:;" onclick="we.online('<?php echo $v->id;?>', onlineUrl);" title="上线处理">上线</a>
							<?php }?>
							<?php if(strtotime($v->program_end_time)-strtotime(date("Y-m-d H:i:s"))>0){ ?>
								<a class="btn" href="javascript:;" onclick="we.end('<?php echo $v->id;?>', endUrl);" title="直播结束">直播结束</a>
							<?php } else{ ?>
								<a class="btn" href="javascript:;" title="已结束">已结束</a>
							<?php }?>
							
							<a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除">删除</a>
                        </td>
                    </tr>
                   <?php $index++; } ?>
                </table>
                 
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var downUrl = '<?php echo $this->createUrl('down', array('id'=>'ID'));?>';
var onlineUrl = '<?php echo $this->createUrl('online', array('id'=>'ID'));?>';
var endUrl = '<?php echo $this->createUrl('end', array('id'=>'ID'));?>';
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

var $program_time_start=$('#program_time_start');
var $program_time_end=$('#program_time_end');
$program_time_start.on('click', function(){
	WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
});
$program_time_end.on('click', function(){
	WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
});
</script>
