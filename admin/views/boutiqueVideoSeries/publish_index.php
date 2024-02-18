<div class="box">
    <div class="box-title c">
		<h1>当前界面：视频》视频分集管理》<a class="nav-a">发布视频分集</a></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
	</div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="视频编号/名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="text-align:center;width: 30px;">序号</th>
                        <th style="text-align:center;width: 120px;"><?php echo $model->getAttributeLabel('video_code');?></th>
                        <th style="text-align:center;width: 200px;"><?php echo $model->getAttributeLabel('video_title');?></th>
                        <th style="text-align:center;width: 120px;"><?php echo $model->getAttributeLabel('publish_classify');?></th>
                        <th>发布分集数</th>
                        <th>分集号</th>
                        <th style="text-align:center;">状态</th>
                        <th style="text-align:center;">操作</th>
                    </tr>
                </thead>
                <tbody>
				<?php foreach($arclist as $k=>$v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->series_ids); ?>"></td>
                        <td style="text-align:center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$k+1 ?></span></td>
                        <td><?php echo $v->video_code; ?></td>
                        <td><?php echo $v->video_title; ?></td>
                        <td><?php echo $v->publish_classify_name; ?></td>
                        <td><?php echo $v->series_publish_num; ?></td>
                        <td><?php echo $v->series_publish_title; ?></td>
                        <td><?php echo $v->state_name; ?></td>
                        <td>
							<?php if($v->state==721){?><a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑">编辑</a>
							<?php }else if($v->state==1538){?><a class="btn" href="<?php echo $this->createUrl('update_audit_return', array('id'=>$v->id));?>" title="修改">修改</a>
							<?php }else if($v->state==373){?><a class="btn" href="<?php echo $this->createUrl('update_audit_fail', array('id'=>$v->id));?>" title="详情">详情</a>
							<?php }else if($v->state==371){?><a class="btn" href="<?php echo $this->createUrl('update_audit_submit', array('id'=>$v->id));?>" title="详情">详情</a>
							<?php }else{?><a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="详情">详情</a><?php }?>
							<?php if($v->state==371){?><a class="btn" href="javascript:;" onclick="chexiao('<?php echo $v->id;?>', chexiaoUrl);" title="撤销">撤销</a><?php }else{?>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->series_ids;?>', deleteUrl);" title="删除">删除</a><?php }?>
                        </td>
                    </tr>
					<?php }?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
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