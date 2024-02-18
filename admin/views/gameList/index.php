<?php 
   check_request('game_type',0);
   check_post('data_id',0);
   check_post('data_type',0);
?>
<style>
    .box-search div{ display:inline-block; }
    #keywords{ margin-left: 12px; }
</style>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事 》赛事发布 》<a class="nav-a">发布赛事</a></h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;&nbsp;
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create',array('type'=>$_REQUEST['game_type'])),'发布'); ?>
            <?php echo show_command('批删除','','删除'); ?>
            <a class="btn" href="javascript:;" type="button" onclick="javascript:excel();"><i class="fa fa-file-excel-o"></i>导出</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="game_type" value="<?php echo Yii::app()->request->getParam('game_type');?>">
                <div id="select6">
                    <label>
                        <span>关键字：</span>
                        <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入编码或标题">
                    </label>
                    <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                </div>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
            </form>
        </div><!--box-search end-->
        <ul class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th width="110px"><?php echo $model->getAttributeLabel('game_code');?></th>
                        <th width="12%"><?php echo $model->getAttributeLabel('game_title');?></th>
                        <th><?php echo $model->getAttributeLabel('game_level');?></th>
                        <th><?php echo $model->getAttributeLabel('game_area');?></th>
                        <th><?php echo $model->getAttributeLabel('project_list');?></th>
                        <th width="110px"><?php echo $model->getAttributeLabel('signup_time');?></th>
                        <th width="110px"><?php echo $model->getAttributeLabel('effective_time');?></th>
                        <th width="70px"><?php echo $model->getAttributeLabel('game_time1');?></th>
                        <th width="12%"><?php echo $model->getAttributeLabel('game_address');?></th>
                        <th><?php echo $model->getAttributeLabel('state1');?></th>
                        <th width="110px"><?php echo $model->getAttributeLabel('uDate');?></th>
                        <th width="110px">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ $p_id = ($v->state==371 || $v->game_state==149) ? 0 : 1; ?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td style="text-align:center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->game_code; ?></td>
                            <td><?php echo $v->game_title; ?></td>
                            <td><?php echo $v->level_name; ?></td>
                            <td><?php echo $v->area_name; ?></td>
                            <td>
							<?php 
								$project=GameListData::model()->findAll('game_id=' . $v->id .'  group by project_id');
								$tx='';
								if(count($project)>=2){
									$tx=$project[0]['project_name'].' '.$project[1]['project_name'].'...';
								} elseif (count($project)==1) {
									$tx=$project[0]['project_name'];
								} 
								echo $tx;
							?>
							</td>
                            <td><?php echo date("Y-m-d H:i",strtotime($v->Signup_date)).'<br>'.date("Y-m-d H:i",strtotime($v->Signup_date_end)); ?></td>
                            <td><?php echo date("Y-m-d H:i",strtotime($v->effective_time)); ?></td>
                            <td><?php echo date("Y-m-d",strtotime($v->game_time)).'<br>'.date("Y-m-d",strtotime($v->game_time_end)); ?></td>
                            <td><?php echo $v->game_address; ?></td>
                            <td><?php echo $v->state_name; ?></td>
                            <td><?php echo date("Y-m-d H:i",strtotime($v->uDate)); ?></td>
                            <td>
								<?php if($v->state==721){?><a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id,'type'=>$v->game_type,'p_id'=>1));?>" title="编辑">编辑</a>
								<?php }else if($v->state==1538){?><a class="btn" href="<?php echo $this->createUrl('update_audit_return', array('id'=>$v->id,'type'=>$v->game_type,'p_id'=>1));?>" title="修改">修改</a>
								<?php }else if($v->state==373){?><a class="btn" href="<?php echo $this->createUrl('update_audit_fail', array('id'=>$v->id,'type'=>$v->game_type,'p_id'=>1));?>" title="详情">详情</a>
								<?php }else if($v->state==371){?><a class="btn" href="<?php echo $this->createUrl('update_audit_submit', array('id'=>$v->id,'type'=>$v->game_type,'p_id'=>1));?>" title="详情">详情</a>
								<?php }else{?><a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id,'type'=>$v->game_type,'p_id'=>1));?>" title="详情">详情</a>
								<?php }?>
								<?php if($v->state==371){?><a class="btn" href="javascript:;" onclick="chexiao('<?php echo $v->id;?>', chexiaoUrl);" title="撤销">撤销</a>
								<?php }else{?><a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除">删除</a>
								<?php }?>
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
    function excel(){
        $num = $("#is_excel");
        $num.val(1);
        $("#submit_button").click();
        $num.val('');
    }
</script>
<script>
var chexiaoUrl = '<?php echo $this->createUrl('chexiao', array('id'=>'ID'));?>';
function chexiao(id, url){
	we.overlay('show');
	var fnChexiao=function(){
		url = url.replace(/ID/, id);
		$.ajax({
			type: 'get',
			url: url,
			dataType: 'json',
			success: function(data) {
				if (data.status == 1) {
					we.msg('check', data.msg, function() {
						we.loading('hide');
						we.reload();
					});
				} else {
					we.msg('error', data.msg, function() {
						we.loading('hide');
					});
				}
			}
		});
	}
	
	$.fallr('show', {
        buttons: {
            button1: {text: '确定', danger: true, onclick: fnChexiao},
            button2: {text: '取消'}
        },
        content: '确定撤销吗？',
        //icon: 'trash',
        afterHide: function() {
            we.loading('hide');
        }
    });
}
</script>