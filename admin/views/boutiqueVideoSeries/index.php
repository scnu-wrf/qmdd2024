<div class="box">
    <div class="box-title c">
		<h1>当前界面：视频》视频分集管理》<a class="nav-a">视频分集列表</a></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
	</div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
				<label style="margin-right:10px;">
                    <span>发布时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                </label>
                <label style="margin-right:20px;">
                    <span>发布类型：</span>
                    <select name="publish_classify">
                        <option value="">请选择</option>
                        <?php foreach($publish_classify as $k=>$v){?>
                        <option value="<?php echo $k;?>"<?php if(Yii::app()->request->getParam('publish_classify')==$k){?> selected<?php }?>><?php echo $v;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="视频分集编号/名称">
                </label>
				<input class="input-text" type="hidden" name="search_date" value="1">
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="text-align:center;width: 30px;">序号</th>
                        <th style="text-align:center;width: 120px;"><?php echo $model->getAttributeLabel('video_series_code');?></th>
                        <th style="text-align:center;width: 150px;"><?php echo $model->getAttributeLabel('video_id');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('publish_classify');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('video_series_title');?></th>
                        <th style="text-align:center;width: 110px;"><?php echo $model->getAttributeLabel('video_series_num');?><span style="color:#7a7a7a;font-size:smaller;">(双击修改)</span></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('video_source_id');?><span style="color:#7a7a7a;font-size:smaller;">(点击播放)</span></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('video_format');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('video_duration');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('is_uplist');?></th>
                        <th style="text-align:center;">操作</th>
                    </tr>
                </thead>
                <tbody>
				<?php $index = 1;
				 foreach($arclist as $k=>$v){ ?>
                    <tr>
                        <td style="text-align:center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$k+1 ?></span></td>
                        <td><?php echo $v->video_series_code; ?></td>
                        <td><?php echo $v->video_title; ?></td>
                        <td><?php echo $v->publish_classify_name; ?></td>
                        <td><?php echo $v->video_series_title; ?></td>
                        <td ondblclick="changeSeries_num(this);"><span class="video_series_num"><?php echo $v->video_series_num; ?></span><input type="text" class="input-text video_series_num_input" style="width:80%;display:none;" value="<?php echo $v->video_series_num; ?>" data-id="<?php echo $v->id; ?>"></td>
                        <td><span id="video_box" class="fl"><?php if($v->gf_material!=null){?><span class="label-box" style="max-width: 120px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;word-break: keep-all;"><a href="<?php echo $this->createUrl("gfMaterial/video_player", array('id'=>$v->gf_material->id));?>" target="_blank" title="<?php if($v->gf_material->v_title!=''){ echo $v->gf_material->v_title; }else{ echo $v->gf_material->v_name; }?>"><?php if($v->gf_material->v_title!=''){ echo $v->gf_material->v_title; }else{ echo $v->gf_material->v_name; }?></a></span><?php }?></span></td>
                        <td><?php echo $v->video_format; ?></td>
                        <td><?php echo $v->video_duration; ?></td>
                        <td><?php echo $v->is_uplist ==1?'上线':'下线'; ?></td>
                        <td>
							<a class="btn" href="<?php echo $this->createUrl('video_detail', array('id'=>$v->id));?>" title="详情">详情</a>
							<?php if($v->is_uplist==1){ ?>
                            <a class="btn" href="javascript:;" onclick="we.down('<?php echo $v->id;?>', downUrl);" title="下线">下线</a>
							<?php } else{ ?>
							<a class="btn" href="javascript:;" onclick="we.online('<?php echo $v->id;?>', onlineUrl);" title="上线">上线</a>
							<?php }?>
							<a class="btn" href="javascript:;" onclick="downtype('<?php echo $v->id;?>', downtypeUrl, 1);" title="下架">下架</a>
                        </td>
                    </tr>
					<?php $index++; } ?>
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
    var $star_time=$('#start_date');
    var $end_time=$('#end_date');
    $star_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
</script>
<script>
var downUrl = '<?php echo $this->createUrl('down', array('id'=>'ID'));?>';
var onlineUrl = '<?php echo $this->createUrl('online', array('id'=>'ID'));?>';
</script>
<script>
var downtypeUrl = '<?php echo $this->createUrl('downtype', array('id'=>'ID','down_type'=>'DownType'));?>';
function downtype(id, url, down_type){
	we.overlay('show');
	if (id == '' || id == undefined) {
        we.msg('error', '请选择要下架的视频分集', function() {
            we.loading('hide');
        });
        return false;
    }
	var fnCancel = function() {
		url = url.replace(/ID/, id);
		url = url.replace(/DownType/, down_type);
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
    };
    $.fallr('show', {
        buttons: {
            button1: {text: '下架', danger: true, onclick: fnCancel},
            button2: {text: '取消'}
        },
        content: '确定下架？',
        icon: 'trash',
        afterHide: function() {
            we.loading('hide');
        }
    });
}

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