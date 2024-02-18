
<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播》直播单位》<a class="nav-a">取消/审核未通过</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end--> 
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
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
                    	<th style="text-align:center;">序号</th>
                        <th><?php echo $model->getAttributeLabel('club_code');?></th>
                        <th><?php echo $model->getAttributeLabel('club_name');?></th>
                        <th><?php echo $model->getAttributeLabel('partnership_type');?></th>
                        <th><?php echo $model->getAttributeLabel('server_type');?></th>
                        <th><?php echo $model->getAttributeLabel('state');?></th>
                        <th>操作</th>
                    </tr>
 <?php   $index = 1;
	foreach($arclist as $v){ ?>
                    <tr>
                    	<td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->club_code; ?></td>
                        <td><?php echo $v->club_name; ?></td>
                        <td><?php echo $v->partnership_name; ?></td>
                        <td><?php if(!empty($v->server_type)){
                            $type=VideoClassify::model()->findAll('id in ('.$v->server_type.')');
                            if(!empty($type)) foreach($type as $t){
                                echo $t->sn_name.' ';
                            }
                        }  ?></td>
                        <td><?php echo $v->state_name; ?></td>
                        <td>
                        	<a class="btn" href="<?php echo $this->createUrl('update_checked', array('id'=>$v->id,'flag'=>'fail'));?>" title="详情">查看</a>
                            <?php echo show_command('删除','\''.$v->id.'\''); ?>
                        </td>
                    </tr>
<?php  $index++; } ?>
                </table>
                 
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var $start=$('#start');
    var $end=$('#end');
    $start.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
</script>
