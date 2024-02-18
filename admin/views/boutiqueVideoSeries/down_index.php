<div class="box">
    <div class="box-title c">
		<h1>当前界面：视频》视频分集管理》<a class="nav-a">视频分集下架列表</a></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
	</div><!--box-title end-->
    <div class="box-content">
		<div class="box-header">
            <a class="btn" id="down_select_btn" href="javascript:;">下架</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
				<label style="margin-right:10px;">
                    <span>下架时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="视频编号/名称">
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
                        <th style="text-align:center;">所属视频</th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('publish_classify');?></th>
                        <th style="text-align:center;">分集号</th>
                        <th style="text-align:center;">视频文件<span class="required"></span>（点击播放）</th>
                        <th style="text-align:center;">格式</th>
                        <th style="text-align:center;">时长(分钟)</th>
                        <th style="text-align:center;">状态</th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('club_id');?></th>
                        <th style="text-align:center;">下架时间</th>
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
                        <td><span class="fl"><?php if($v->gf_material!=null){?><span class="label-box" style="max-width: 120px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;word-break: keep-all;"><a href="<?php echo $this->createUrl("gfMaterial/video_player", array('id'=>$v->gf_material->id));?>" target="_blank" title="<?php if($v->gf_material->v_title!=''){ echo $v->gf_material->v_title; }else{ echo $v->gf_material->v_name; }?>"><?php if($v->gf_material->v_title!=''){ echo $v->gf_material->v_title; }else{ echo $v->gf_material->v_name; }?></a></span><?php }?></span></td>
                        <td><?php echo $v->video_format; ?></td>
                        <td><?php echo $v->video_duration; ?></td>
                        <td><?php echo $v->down_type_name; ?></td>
                        <td><?php echo $v->club_name; ?></td>
                        <td><?php echo $v->down_time; ?></td>
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
$(function(){
    var $down_select_btn=$('#down_select_btn');
    $down_select_btn.on('click', function(){
        $.dialog.data('video_id', 0);
        $.dialog.open('<?php echo $this->createUrl("down_select");?>',{
            id:'xiangmu',
            lock:true,
            opacity:0.3,
            title:'选择视频分集',
            width:'65%',
            height:'65%',
            close: function () {
                if($.dialog.data('video_id')==-1){
                    var boxnum=$.dialog.data('video_list');
					var down_type=$.dialog.data('down_type');
					var video_ids=[];
					$.each(boxnum,function(k,v){
						video_ids.push(v.dataset.id);
					});
					downtype(video_ids.join(), downtypeUrl, down_type)
                }
            }
        });
    });
});
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