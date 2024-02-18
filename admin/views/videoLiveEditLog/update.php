<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播》直播管理》直播信息更改》<a class="nav-a">添加更改</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
			<button id="live_select_btn" class="btn" type="button">选择直播</button><br><br>
			
        </div><!--box-detail-bd end-->
		
        <div id="operate" class="mt15" style="text-align:center;">
            <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
	$('#live_select_btn').on('click', function(){
		var url='';
		url+='<?php echo $this->createUrl("select/videolive");?>';
		url+='&club_id=<?php echo get_session("club_id") ?>&edit=1';
        $.dialog.data('video_live_id', 0);
        $.dialog.open(url,{
            id:'zhibo',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
			close: function () {
                if($.dialog.data('video_live_id')>0){
					console.log($.dialog.data('video_live_id'));
                }
            }
        });
    });
</script>