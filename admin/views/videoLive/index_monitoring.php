<style>
	.menu-cells-wrap {
		padding: 2px;
		/* width: 100%; */
		box-sizing: content-box;
	}
	.menu-cell {
		width: 20rem;
		display: inline-block;
		position: relative;
		box-sizing: border-box;
		background: white;
		margin-bottom: 15px; 
	}
	.menu-cell>div {
		box-sizing: border-box;
		position: absolute;
		padding: 2px;
		width: 100%;
		height: 100%;
		left: 0;
		top: 0;
	}
	.menu-cell:before {
		content: "";
		display: inline-block;
		padding-bottom: 100%;
		width: .1px;
		vertical-align: middle;
	}
	.content-wrap {
		position: relative;
		width: 100%;
		height: 70%;
		box-sizing: content-box;
		background: #6c614b;
	}
	.content-wrap-info {
		position: relative;
		width: 100%;
		height: 30%;
		overflow: hidden;
		box-sizing: content-box;
	}
	.menu-cell:active {
		border-color: lightblue;
	}
	.content {
		position: absolute;  
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
	}
	.content-wrap:hover{
		border:1px red solid;
	}
	.div-set{
		float:left;
		border:1px solid black;
		border-radius:10px;
		background-color:white;
		width: 20%;
		text-align: center;
		margin-right: 2%;
		margin-bottom: 2px;
		cursor:pointer;
	}
	.div-set-on{
		float:left;
		border:1px solid black;
		border-radius:10px;
		background-color:#00FF7F;
		width: 20%;
		text-align: center;
		margin-right: 2%;
		margin-bottom: 2px;
		cursor:pointer;
	}
	.div-set-close{
		float:left;
		border:1px solid black;
		border-radius:10px;
		background-color:red;
		width: 20%;
		text-align: center;
		margin-right: 2%;
		margin-bottom: 2px;
		cursor:pointer;
	}
	.span-info{
		float: left;width:25%;
	}
	/* onmouseover */
</style>
<script src="https://cdn.jsdelivr.net/hls.js/latest/hls.min.js"></script>
<div class="box-title c">
	<h1>点/直播管理 》监听监看管理 》<a class="nav-a">直播监控</a></h1>
	<span style="float:right;padding-right:15px;">
		<a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
	</span>
</div><!--box-title end-->
<style>
.cont{
overflow: hidden;/*内容超出后隐藏*/
text-overflow: ellipsis;/* 超出内容显示为省略号*/
white-space: nowrap;/*文本不进行换行*/
}
</style>
<div class="menu-cells-wrap">
	<?php $state=['关闭','打开','直播',"切播",'断流','打开']; foreach ($model as $v) { ?>
    <div class="menu-cell" id='<?php echo $v->id;?>'><div>
		<a href="<?php echo $this->createUrl('platform', array('id'=>$v->id));?>" <?php if($v->is_rtmp==1){ ?> onmouseover="mouse('<?php echo $v->id; ?>',1);" onmouseout="mouse('<?php echo $v->id; ?>',0);"<?php }?>>
			<?php if (!empty($v->logo)) {$v->logo=BasePath::model()->get_www_path().$v->logo;} ?>
			<div id="video_img_<?php echo $v->id; ?>" class="content-wrap">
				<img src="<?php echo $v->logo; ?>" width="100%" height="100%">
			</div>
		</a>
		<div class="content-wrap-info">
			<div>
				<span style="width: 75%;font-weight: bold;font-size: 15px;display: inline-block;">
					<p class="cont" ><?php echo $v->title;?></p>
				</span>
				<span style="float: right;">点击量:<?php echo $v->clicked;?></span>
			</div>
			<div>
				<span class="span-info">
					<?php echo $v->getAttributeLabel("is_online").":";?>
				</span>
				<div id="is_online" <?php if(!$v->is_online) { ?>class="div-set-close" <?php }else{ ?>class="div-set-on"<?php }?>>
					<?php echo $state[$v->is_online+4];?>
				</div>
				<span class="span-info">
					<?php echo  $v->getAttributeLabel("is_talk").": ";?>
				</span>
				<div id="is_talk" <?php if(!$v->is_talk) { ?>class="div-set-close" <?php }else{ ?>class="div-set-on"<?php }?>>
					<?php echo $state[$v->is_talk];?>
				</div>
				<span class="span-info">
					<?php echo $v->getAttributeLabel("is_reward").":";?>
				</span>
				<div id="is_reward" <?php if(!$v->is_reward) { ?>class="div-set-close" <?php }else{ ?>class="div-set-on"<?php }?>>
					<?php echo $state[$v->is_reward];?>
				</div>
				<span class="span-info">
					<?php echo $v->getAttributeLabel("is_open_comments").":";?>
				</span>
				<div id="open_comments" <?php if(!$v->open_comments) { ?>class="div-set-close" <?php }else{ ?>class="div-set-on"<?php }?>>
					<?php echo $state[$v->open_comments];?>
				</div>
				<span class="span-info">
					<?php echo $v->getAttributeLabel("is_reward_red_packets").": ";?> 
				</span>
				<div id="is_reward_red_packets" <?php if(!$v->is_reward_red_packets) { ?>class="div-set-close" <?php }else{ ?>class="div-set-on"<?php }?>>
					<?php echo $state[$v->is_reward_red_packets];?>
				</div>
				<span class="span-info">
					<?php echo  $v->getAttributeLabel("line_show").":";?>               
				</span>
				<div id="line_show" <?php if($v->line_show) { ?>class="div-set-close" <?php }else{ ?>class="div-set-on"<?php }?>>
					<?php echo $state[$v->line_show+2];?>
				</div>
			</div>
		</div>
      	</div>
    </div>
	<?php }?>
</div>
<script>
    $(".span-info").next().on('click', function(){
		var attr=$(this).attr("id");
		var id=$(this).parent().parent().parent().parent().attr("id");
		if(confirm('是否确定?')){
			if($(this).is("#line_show")){
				if($(this).hasClass("div-set-close")){
					$(this).attr("class","div-set-on").text("直播");
					update(id,attr,0);
				}else{
					$(this).attr("class","div-set-close").text("切播");;
					update(id,attr,1);
				}
			}else if($(this).is("#is_online")){
				if($(this).hasClass("div-set-close")){
					$(this).attr("class","div-set-on").text("打开");
					update(id,attr,1);
				}else{
					$(this).attr("class","div-set-close").text("断流");;
					update(id,attr,0);
				}
			}else{
				if($(this).attr("class")=="div-set-close"){
					$(this).attr("class","div-set-on").text("打开");
					update(id,attr,1);
				}else{
					$(this).attr("class","div-set-close").text("关闭");
					update(id,attr,0);
				}
			}
		}
    });

   	function update(id,attr,state){
		$.ajax({
			type: "get",
			url:'<?php echo $this->createUrl("VideoLive/UpdateState");?>',
            data:{id:id,attr:attr,state:state},
			dataType:"json",
			error: function(request) {
				alert('设置失败');
			},
			success: function(data) {
				// we.success(data.msg,data.redirect);
            }
		});
	}

	// 鼠标放置1.5秒执行小窗口播放视频
	var over;
	function mouse(id,n){
		if(n==1){
			over = setTimeout(function(){
				$.ajax({
					type: 'post',
					url: '<?php echo $this->createUrl('mouseVideo'); ?>&id='+id,
					dataType: 'json',
					success: function(data){
						// console.log('191=='+data.logo);
						v_html = 
							'<video id="video" class="video-js vjs-default-skin" width="100%" height="100%" /*controls="controls"*/ autoplay="autoplay" '+
								'x-webkit-airplay="true" x5-video-player-fullscreen="true" preload="auto" '+
								'playsinline="true" webkit-playsinline x5-video-player-typ="h5">'+
							'</video>';
						$('#video_img_'+id).html(v_html);
						if(Hls.isSupported()){
							var video = document.getElementById('video');  // 找到video标签
							var hls = new Hls();  // 创建video.js对象
							hls.loadSource(data.live_source_HLS_H);  // 直播地址
							hls.attachMedia(video);
							// videojs(video).disableProgress({autoDisable: true});  // 失效
							hls.on(Hls.Events.MANIFEST_PARSED,function() {
								video.play();  // 开始播放
							});
						}
					},
					errer: function(request){
						console.log('获取错误\n'+request);
					}
				});
			},1500);
		}
		else{
			clearTimeout(over);
			$.ajax({
				type: 'post',
				url: '<?php echo $this->createUrl('mouseVideo'); ?>&id='+id,
				dataType: 'json',
				success: function(data){
					v_html = '<img src="'+data.logo+'" width="100%" height="100%">';
					$('#video_img_'+id).html(v_html);
				},
				errer: function(request){
					console.log('获取错误\n'+request);
				}
			});
		}
	}
</script>