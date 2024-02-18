<div class="box">
    <div class="box-title c">
		<h1>当前界面：视频》视频管理》<?php if(Yii::app()->request->getParam('club')==1){?>各单位视频列表<?php }else if(Yii::app()->request->getParam('down')==1){?>历史/下架列表<?php }else{?>视频列表<?php }?>》<a class="nav-a">视频分集</a></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span><span class="back"><a class="btn" href="javascript::" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span>
	</div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="text-align:center;width: 30px;">序号</th>
                        <th style="text-align:center;width: 120px;"><?php echo $model->getAttributeLabel('video_series_code');?></th>
                        <th style="text-align:center;width: 150px;"><?php echo $model->getAttributeLabel('video_id');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('publish_classify');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('video_series_title');?></th>
                        <th style="text-align:center;width: 120px;"><?php echo $model->getAttributeLabel('video_series_num');?><span style="color:#7a7a7a;font-size:smaller;">(双击修改)</span></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('video_source_id');?><span style="color:#7a7a7a;font-size:smaller;">(点击播放)</span></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('video_format');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('video_duration');?></th>
						<?php if(Yii::app()->request->getParam('down')==1){?>
                        <th style="text-align:center;">状态</th>
						<?php }else{?>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('is_uplist');?></th>
						<?php }?>
						<?php if(Yii::app()->request->getParam('club')==1||Yii::app()->request->getParam('down')==1){?>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('club_id');?></th>
						<?php }?>
						<?php if(Yii::app()->request->getParam('down')==1){?>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('down_time');?></th>
						<?php }?>
                    </tr>
                </thead>
                <tbody>
				<?php foreach($arclist as $k=>$v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style="text-align:center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$k+1 ?></span></td>
                        <td><?php echo $v->video_series_code; ?></td>
                        <td><?php echo $v->video_title; ?></td>
                        <td><?php echo $v->publish_classify_name; ?></td>
                        <td><?php echo $v->video_series_title; ?></td>
                        <td ondblclick="changeSeries_num(this);"><span class="video_series_num"><?php echo $v->video_series_num; ?></span><input type="text" class="input-text video_series_num_input" style="width:80%;display:none;" value="<?php echo $v->video_series_num; ?>" data-id="<?php echo $v->id; ?>"></td>
                        <td><span class="fl"><?php if($v->gf_material!=null){?><span class="label-box" style="max-width: 120px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;word-break: keep-all;"><a href="<?php echo $this->createUrl("gfMaterial/video_player", array('id'=>$v->gf_material->id));?>" target="_blank" title="<?php if($v->gf_material->v_title!=''){ echo $v->gf_material->v_title; }else{ echo $v->gf_material->v_name; }?>"><?php if($v->gf_material->v_title!=''){ echo $v->gf_material->v_title; }else{ echo $v->gf_material->v_name; }?></a></span><?php }?></span></td>
                        <td><?php echo $v->video_format; ?></td>
                        <td><?php echo $v->video_duration; ?></td>
						<?php if(Yii::app()->request->getParam('down')==1){?>
                        <td><?php echo $v->down_type_name; ?></td>
						<?php }else{?>
                        <td><?php echo $v->is_uplist ==1?'上线':'下线'; ?></td>
						<?php }?>
						<?php if(Yii::app()->request->getParam('club')==1||Yii::app()->request->getParam('down')==1){?>
                        <td><?php echo $v->club_name; ?></td>
						<?php }?>
						<?php if(Yii::app()->request->getParam('down')==1){?>
                        <td><?php echo $v->down_time; ?></td>
						<?php }?>
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
function changeSeries_num(obj){
	$(obj).find(".video_series_num").hide();
	$(obj).find(".video_series_num_input").show();
	var t=$(obj).find(".video_series_num_input").val();
	$(obj).find(".video_series_num_input").val("").focus().val(t);
}
$(".video_series_num_input").on("blur",function(){
	var t=$(this).val();
	var v=$(this).prev().html()
	var id=$(this).attr("data-id");
	var obj=$(this);
	if(t!=v){
		var url = '<?php echo $this->createUrl('changeSeries_num', array('id'=>'ID','video_series_num'=>'SeriesNum'));?>';
		url = url.replace(/ID/, id);
		url = url.replace(/SeriesNum/, t);
		console.log(url)
		we.overlay('show');
		$.ajax({
			type: 'get',
			url: url,
			dataType: 'json',
			success: function(data) {
				if (data.status == 1) {
					we.msg('check', data.msg, function() {
						we.loading('hide');
						obj.hide();
						obj.prev().html(t).show();
					});
				} else {
					we.msg('error', data.msg, function() {
						we.loading('hide');
						obj.val(v).hide();
						obj.prev().show();
					});
				}
			}
		});
	}else{
		obj.hide();
		obj.prev().show();
	}
})
</script>