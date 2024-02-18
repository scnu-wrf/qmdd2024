
<div class="box">
    <div class="box-title c">
		<?php if($_GET['recommend_type']==0){ ?>
        <h1>当前界面：系统》业务推送》<a class="nav-a">直播推送列表</a></h1>
		<?php }else if($_GET['recommend_type']==1){ ?>
		<h1>当前界面：系统》业务推送》<a class="nav-a">资讯推送列表</a></h1>
		<?php }else if($_GET['recommend_type']==2){ ?>
		<h1>当前界面：系统》业务推送》<a class="nav-a">赛事推送列表</a></h1>
		<?php } ?>
        <span class="back"><a class="btn" href="<?php echo Yii::app()->request->url;?>"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end--> 
    <div class="box-content">
    	<div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create') .'&recommend_type='.$_GET['recommend_type'],'添加'); ?>
            <?php echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
				<input type="hidden" name="recommend_type" value="<?php echo $_GET['recommend_type'];?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="推送内容名称 / 推送内容编号" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                	<tr class="table-title">
                    	<th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('club_code');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('club_name');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('video_live_code');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('video_live_title');?></th>
                        <th style="text-align:center">操作</th>
                    </tr>
                    <?php 
					 if(is_array($arclist)) foreach($arclist as $v){ ?>
                    <tr>
                    	<td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php if(!empty($v->club_list)) echo $v->club_list->club_code; ?></td>
                        <td><?php if(!empty($v->club_list)) echo $v->club_list->club_name; ?></td>
                        <td><?php echo $v->video_live_code; ?></td>
                        <td><?php echo $v->video_live_title; ?></td>
                        <td>
                        	<a class="btn" href="<?php echo $this->createUrl('update'.'&recommend_type='.$_GET['recommend_type'], array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
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
