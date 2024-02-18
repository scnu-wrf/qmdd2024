<style>
	.platform-body {
		padding: 2px;
		min-width: 1152px;
		height: 630px;
		overflow:hidden;
		box-sizing: content-box;
	}
	.main-box{
		width: 84%;
		height: 100%;
		float: left;
		border:1px solid white;
	}
	.main-video-title{
		width: 100%;
		height: 80px;
		float:left;border:1px solid black;
		position: relative;
		box-sizing: border-box;
	}
	.main-video-live{
		width: 100%;
		height: calc(100% - 80px);
		float:left;border:1px solid black;
		position: relative;
		box-sizing: border-box;
	}
	.main-video-box {
		width: 60%;
		height: calc(100% - 50px);
		float:left;border:1px solid white;
		position: relative;
		box-sizing: border-box;
	}
	.main-video-right {
		width: 39%;
		height: 100%;
		border:1px solid white;
		position: relative;
		margin-left: 0.5%;
		overflow: hidden;
	}
	.video-right{
		width: 15%;
		height:100%;
		float:left;
		border:1px solid white;
		position: relative;
		overflow:hidden;
		overflow-y:auto;
		box-sizing: border-box;
	}
	.video-right-box {
		width: 100%;
		height: 50px;
		position: relative;
		overflow: hidden;
		box-sizing: border-box;
		border:1px solid black;
	}
	.main-video-setbox {
		position: relative;
		width: 100%;
		height: 180px;
		box-sizing: content-box;
	}
	.small-icon{
		position: relative;
		width: 25%;
		box-sizing: content-box;
		display: inline-block;
		vertical-align: middle;
	}
	.small-title{
		position: relative;
		width: 70%;
		box-sizing: content-box;
		display: inline-block;
		vertical-align: middle;
		height: 48px;
	}
	.div-set-on{
		float:left;
		border:1px solid black;
		border-radius:10px;
		background-color:#00FF7F;
		width: 50px;
		text-align: center;
		margin-left: 5px;
		cursor:pointer;
	}
	.div-set-close{
		float:left;
		border:1px solid black;
		border-radius:10px;
		background-color:red;
		width: 50px;
		text-align: center;
		margin-left: 5px;
		cursor:pointer;
	}
	.div-set{
		float:left;
		border:1px solid black;
		border-radius:10px;
		background-color:white;
		width: 50px;
		text-align: center;
		margin-left: 5px;
		cursor:pointer;
	}
	.setBox{
		overflow:hidden;
		margin-bottom:3px;
	}
	.span-set{
		width: 60px;
		float:left;
		border:1px solid white;
	}
	.record-box{
		height: calc(100% - 230px);
		width:100%;
	}
	.set-record-box{
		height: 100%;
		width:100%;
		border: 1px solid ;
		box-sizing: border-box;
	}
	.reward-record-box{
		height: 100%;
		width:100%;
		border: 1px solid ;
		box-sizing: border-box;
	}
	.input-box{
		width: 100%;
		height:10%;
		float:left;
		border:1px solid black;
		position: relative;
		box-sizing: border-box;
	}
	.send-input{
		width:75%;
		height:50%;
		margin-top: 1%;
		margin:1% 10px;
		border-radius:50px;
		padding:0 1.5%;
		/* padding-top:0.5%; */
		font-size: 15px;
		outline:none;
		border: solid 1px #ccc;
	}
	.send-button{
		/* margin-left: 1%; */
		width:10%;
		height: 55%;
		border-radius:50px;
		border: solid 1px #ccc;
		background-color: #90c8de;
	}
	.span-button{
		/* float:right; */
		border:1px solid #ccc;
		/* margin-right: 1%; */
		/* margin-top: 1%; */
		text-align: center;
		cursor:pointer;
		padding-top: 0.5%;
		border-radius:10px;
		width: 55px;
		display: inline-block;
		height: 40.43%;
	}
	.gridtable {
		width: 100%;
	}
	.gridtable th {
		padding: 4px;
		border-style: outset;
	}
	.span_tip{
		margin-left:15px;
	}
	.tip{
		width: 150px;
		height: 150px;
		left: -121px;
		top: -181px;
	}
	.tip-ul ul{
		list-style: decimal;
		padding-left:20px;
	}
	.tip-ul li{
		cursor: pointer;
	}
	.setBox-div{
		width: 100%;
		overflow: hidden;
	}
	.setBox-div-left{
		float: left;
		width: 130px;
		overflow: hidden;
	}
	.setBox-div-right{
		overflow: hidden;
		height: 140px;
	}
	.marquee {
		display: block;
		width: 96%;
		height: 48px;
		margin: 0 auto;
		position: absolute;
		overflow: hidden;
	}
	.marquee_text {
		/* position: absolute; */
		/* top: 3px; */
		/* left: 100%; */
		line-height: 30px;
		display: block;
		word-break: keep-all;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	.marquee_state_time {
		font-size: x-small;
		color: #888;
		font-weight: normal;
		display: block;
	}
	#div1{
		position: relative;
		width: 100%;
		height: 20px;
		margin:10px auto;
		overflow: hidden;
	}
	#div1 ul{
		position: absolute;
		left:0;
		top:0;
	}
	.program_list_box {
	    float: left;
	    width: 60%;
	    height: 50px;
	}
	.programs_wrap {
	    display: inline-block;
	    width: 100%;
	    height: 100%;
	    margin: 0 auto;
	    overflow: hidden;
	}
	.programs_wrap .banner {
	    width: auto;
	    height: 100%;
	    white-space: nowrap;
	    position: relative;
	    left: 0;
	}
	.programs_wrap .banner li {
	    width: 140px;
	    text-align: center;
	    border: 1px solid #ddd;
	    float: left;
	    box-sizing: border-box;
	}
	#scroll2::-webkit-scrollbar  
	{  
		width: 1px;  
		height: 1px;  
		background-color: #F5F5F5;  
	}  
	#scroll2::-webkit-scrollbar-track  
	{  
		-moz-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		-o-box-shadow:inset 0 0 6px rgba(0,0,0,0); 
		-ms-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		box-shadow: inset 0 0 6px rgba(0,0,0,0);  
		-moz-border-radius: 10px;  
		-webkit-border-radius: 10px;  
		-o-border-radius: 10px;  
		-ms-border-radius: 10px;  
		border-radius: 10px;  
		background-color: #F5F5F5;  
	}  
	#scroll2::-webkit-scrollbar-thumb  
	{  
		-moz-border-radius: 10px;  
		-webkit-border-radius: 10px;  
		-o-border-radius: 10px;  
		-ms-border-radius: 10px;  
		border-radius: 10px;  
		-moz-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		-o-box-shadow:inset 0 0 6px rgba(0,0,0,0); 
		-ms-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		box-shadow: inset 0 0 6px rgba(0,0,0,0);  
		background-color: #ccc;  
	}
	.video-right::-webkit-scrollbar  
	{  
		width: 1px;  
		height: 1px;  
		background-color: #F5F5F5;  
	}  
	.video-right::-webkit-scrollbar-track  
	{  
		-moz-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		-o-box-shadow:inset 0 0 6px rgba(0,0,0,0); 
		-ms-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		box-shadow: inset 0 0 6px rgba(0,0,0,0);  
		-moz-border-radius: 10px;  
		-webkit-border-radius: 10px;  
		-o-border-radius: 10px;  
		-ms-border-radius: 10px;  
		border-radius: 10px;  
		background-color: #F5F5F5;  
	}  
	.video-right::-webkit-scrollbar-thumb  
	{  
		-moz-border-radius: 10px;  
		-webkit-border-radius: 10px;  
		-o-border-radius: 10px;  
		-ms-border-radius: 10px;  
		border-radius: 10px;  
		-moz-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		-o-box-shadow:inset 0 0 6px rgba(0,0,0,0); 
		-ms-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		box-shadow: inset 0 0 6px rgba(0,0,0,0);  
		background-color: #ccc;  
	}
</style>
<div class="box-title c">
	<h1>点/直播管理 》监听监看管理 》<a class="nav-a">直播监控</a></h1>
	<span style="float:right;padding-right:15px;">
		<a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
	</span>
</div><!--box-title end-->
<?php if(!empty($mainVideo)){?>
<div class="platform-body">
  	<?php $state=['关闭','打开','直播',"切播",'断流','打开'];  ?>
	<div class="main-box">
		<div class="main-video-title">
			<table style="width:100%;height:100%;">
				<tr>
					<td>直播名称：<?php if (!empty($mainVideo->logo)){ ?><img style="width: 40px;height: 40px;margin: 0 10px;" src="<?php echo BasePath::model()->get_www_path().$mainVideo->logo; ?>"><?php } ?><span style="color:#368EE0;"><?php echo $mainVideo->title; ?></span></td>
					<td>直播单位：<span style="color:#368EE0;"><?php echo $mainVideo->club_name; ?></span></td>
					<td></td>
				</tr>
				<tr>
					<td>正在直播：<span style="color:#368EE0;">
					<?php 
						$program_type=0;
						foreach($programs as $k=>$v){
							if($v->program_type==1){echo $v->title;$program_type=1;break;}
						} 
						if($mainVideo->is_rtmp==1&&$program_type==0){echo '直播调试';}
					?></span></td>
					<td>直播时间：<span style="color:#368EE0;"><?php foreach($programs as $k=>$v){if($v->program_type==1){echo $v->program_time .'~'.$v->program_end_time;break;}} ?></span></td>
					<td>在线观看：<span style="color:#368EE0;"><?php foreach($programs as $k=>$v){if($v->program_type==1){echo $v->online_num;break;}} ?></span></td>
				</tr>
			</table>
		</div>
		<div class="main-video-live">
			<div class="main-video-box">
				<?php if (!empty($mainVideo->logo)) {$mainVideo->logo=BasePath::model()->get_www_path().$mainVideo->logo;?>
					<?php
						if(!empty($mainVideo->live_source_RTMP_H) && $mainVideo->is_uplist==1 && $mainVideo->is_online==1 && $mainVideo->is_rtmp==1){
					?>
						<link href="<?php echo Yii::app()->request->baseUrl; ?>/admin/views/videoLive/js/video-js.min.css" rel="stylesheet">
						<script src="<?php echo Yii::app()->request->baseUrl; ?>/admin/views/videoLive/js/video.min.js"></script>
						<script src="<?php echo Yii::app()->request->baseUrl; ?>/admin/views/videoLive/js/videojs-flash.min.js"></script>
						<link href="<?php echo Yii::app()->request->baseUrl; ?>/admin/views/videoLive/js/DPlayer.min.css" rel="stylesheet">
						<script src="<?php echo Yii::app()->request->baseUrl; ?>/admin/views/videoLive/js/DPlayer.min.js"></script>
						<script src="<?php echo Yii::app()->request->baseUrl; ?>/admin/views/videoLive/js/hls.min.js"></script>
						
						<div id="id_video_container" style="max-width:1080px;width: 100%;height: 100%;"></div>
						<script>
							var dp = new DPlayer({
								element: $("#id_video_container").get(0),
								video: {
									url: '<?php echo $mainVideo->live_source_HLS_H; ?>',
									pic: '<?php echo $mainVideo->logo; ?>'
								}
							});
							dp.play();
							setInterval(function() {
								function isLoad(id,fun){
									$.ajax({
										type: 'post',
										url: '<?php echo $this->createUrl('rtmp_time'); ?>&id='+id,
										dataType: 'json',
										success: function(data) {
											if($.isFunction(fun) && data==1){
												fun(true);
											}
											else{
												fun(false);
											}
										},
										error:function () {
											if($.isFunction(fun)){
												fun(false);
											}
										}
									});
								}
								isLoad('<?php echo $mainVideo->id; ?>',function(res){
									if(res===false){
										console.log('not found');
										player.pause();
										var txt = 
											'<div onselectstart="return false" id="bg" style="display: block; background-color: #ccc; width: 100%; position: absolute; height: 100%; opacity: 0.7; z-index: 1;margin-top: -568px;text-align:center;">'+
												'<p style="line-height: 15;font-weight: bold;font-size: 40px;cursor: default;">直播连接已断开</p>'+
											'</div>';
										if($('#bg').length==0){
											$('.main-video-box').append(txt);
										}
									}
									else{
										if($('#bg').length>0){
											$('#bg').remove();
											player.play();
										}
									}
								});
							}, 3000);
						</script>
					<?php }else{?>
						<img src="<?php echo $mainVideo->logo; ?>" width="100%" height="100%">
					<?php }?>
				<?php }?>
			</div> 
			<div class="program_list_box">
				<div class="programs_wrap">
					<ul class="banner" id="banner">
					<?php foreach($programs as $k=>$v){ ?>
						<li title="<?php echo $v->title; ?>">
							<div style="position: absolute;text-align: center;width: 140px;background: rgba(0,0,0,0.5);height: 50px;color: #fff;line-height: 50px;display: none;cursor: pointer;" class="program_online" data-program_id="<?php echo $v->id; ?>" data-program_online="<?php echo $v->online; ?>"><?php if($v->online==649){ ?>下线<?php }else{ ?>上线<?php } ?></div>
							<div style="height: 20px;line-height: 20px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;word-break: keep-all;"><?php echo $v->title; ?></div>
							<div style="height: 15px;line-height: 15px;font-size:12px;"><?php echo $v->program_time; ?></div>
							<div style="height: 15px;line-height: 15px;"><?php echo $v->program_end_time; ?></div>
						</li>
					<?php }?>
					</ul>
				</div>
			</div>
			<script>
				function update_program(id,attr,state){
					$.ajax({
						type: "get",
						url:'<?php echo $this->createUrl("VideoLive/UpdateProgramState");?>',
						data:{id:id,attr:attr,state:state},
						dataType:"json",
						error: function(request) {
							we.msg('minus','设置失败');
						},
						success: function(data) {
							$('#scroll2>table').append('<tr><td>'+data.message+'</td><td>'+data.time+'</td></tr>');
							var setHeight = $("#scroll2")[0].scrollHeight;
							$("#scroll2").scrollTop(setHeight);
						}
					});
				}
				var count=<?php echo count($programs);?>;
				var ul = document.getElementById("banner");
				var timer = null;
				if($(".programs_wrap").width()<count*140){
					$("#banner").width((count*140)*2);
					for(var i = 0; i <= count-1; i++){
						var li = document.createElement("li");
						var child = ul.children[i];
						li.innerHTML = child.innerHTML;
						ul.appendChild(li);
					}
					timer = setInterval(autoScroll,1);
					var num = 0;
					function autoScroll() {
						num -= 0.25;
						num <= -(count*140) ? num = 0 : num;
						ul.style.left = num + "px";
					}
					$(".programs_wrap").hover(function(){
						clearInterval(timer);
					},function(){
						timer = setInterval(autoScroll,1);
					});
				}
				$(".program_online").on('click', function(){
					var program_id=$(this).attr("data-program_id");
					var program_online=$(this).attr("data-program_online");
					if(program_online=='649'){
						if(confirm('是否确定下线?')){
							update_program(program_id,'online',648);
							$(this).attr('data-program_online','648');
							$(this).html('上线');
						}
					}else{
						if(confirm('是否确定上线?')){
							update_program(program_id,'online',649);
							$(this).attr('data-program_online','649');
							$(this).html('下线');
						}
					}
				});
				$("#banner li").hover(function(){$(this).children('.program_online').show();},function(){$(this).children('.program_online').hide();})
			</script>
			<div  class="main-video-right"> 
				<div class="main-video-setbox">
					<!-- <div class="setBox">
						<h3 id="h3_title"><span id="title_span"><?php //if(!empty($mainVideo)) echo $mainVideo->title;?></span></h3>
					</div> -->
					<div id="div1">
						<h3>直播控制设置</h3>
					</div>
					<div class="setBox-div">
						<div class="setBox-div-left">
							<div class="setBox">
								<span class="span-set">
									<?php if(!empty($mainVideo)) echo $mainVideo->getAttributeLabel("is_online").": ";?> 
								</span>
								<div id="is_online" <?php if(!empty($mainVideo) && !$mainVideo->is_online) { ?>class="div-set-close" <?php }else{ ?>class="div-set-on"<?php }?>>
									<?php if(!empty($mainVideo)) echo $state[$mainVideo->is_online+4];?>
								</div>
							</div>
							<div class="setBox">
								<span class="span-set">
									<?php if(!empty($mainVideo)) echo $mainVideo->getAttributeLabel("gift_reward").": ";?> 
								</span>
								<div id="is_reward" <?php if(!empty($mainVideo) && !$mainVideo->is_reward) { ?>class="div-set-close" <?php }else{ ?>class="div-set-on"<?php }?>>
									<?php if(!empty($mainVideo)) echo $state[$mainVideo->is_reward];?>
								</div>
							</div>
							<div class="setBox">
								<span class="span-set">
									<?php if(!empty($mainVideo)) echo $mainVideo->getAttributeLabel("is_reward_red_packets").": ";?> 
								</span>
								<div id="is_reward_red_packets" <?php if(!empty($mainVideo) && !$mainVideo->is_reward_red_packets) { ?>class="div-set-close" <?php }else{ ?>class="div-set-on"<?php }?>>
									<?php if(!empty($mainVideo)) echo $state[$mainVideo->is_reward_red_packets];?>
								</div>
							</div>
							<div class="setBox">
								<span class="span-set">
									<?php if(!empty($mainVideo)) echo $mainVideo->getAttributeLabel("is_talk").": ";?> 
								</span>
								<div id="is_talk" <?php if(!empty($mainVideo) && !$mainVideo->is_talk) { ?>class="div-set-close" <?php }else{ ?>class="div-set-on"<?php }?>>
									<?php if(!empty($mainVideo)) echo $state[$mainVideo->is_talk];?>
								</div>
							</div>
							<div class="setBox">
								<span class="span-set">
									<?php if(!empty($mainVideo)) echo $mainVideo->getAttributeLabel("is_open_comments").": ";?> 
								</span>
								<div id="open_comments" <?php if(!empty($mainVideo) && !$mainVideo->open_comments) { ?>class="div-set-close" <?php }else{ ?>class="div-set-on"<?php }?>>
									<?php if(!empty($mainVideo)) echo $state[$mainVideo->open_comments];?>
								</div>
							</div>
							<div class="setBox">
								<span class="span-set">
									<?php if(!empty($mainVideo)) echo $mainVideo->getAttributeLabel("line_show").": ";?> 
								</span>
								<div id="line_show" <?php if(!empty($mainVideo) && $mainVideo->line_show) { ?>class="div-set-close" <?php }else{ ?>class="div-set-on"<?php }?>>
									<?php if(!empty($mainVideo)) echo $state[$mainVideo->line_show+2];?>
								</div>
							</div>
						</div>
						<div class="setBox-div-right">
							<div class="set-record-box">
								<span style="color: #888;">设置记录</span>
								<div id="scroll2" style="overflow-x: auto; overflow-y: auto; height:calc(100% - 1.5em); width:98%;margin-left: 1%">
									<table class="gridtable" style="table-layout:auto;">
										<?php foreach ($setRecord as $v){?>
										<tr>
											<td style="width:50%;">
												<?php
													$model2 = VideoLive::model();
													$msg = base64_decode($v->m_message);
													$arr = array('\\','{','}',"'",'"');
													if(!empty($msg)){
														$str = str_replace($arr,"",$msg);
														$exp = explode(':',$str);
														if($exp[0]=="programs_change"){
															$programs_change=json_decode($msg)->programs_change;
															$down = ($programs_change->online==1) ? '上线' : '下线';
															echo '节目 "'.$programs_change->program_title.'" 变更为：'.$down;
														}else{
															if($exp[0] || $exp[1]){
																if($exp[0]=="line_show"){
																	$down = ($exp[1]==1) ? $state[3] : $state[2];
																}else if($exp[0]=="is_online"){
																	$down = ($exp[1]==1) ? $state[5] : $state[4];
																}else{
																	$down = ($exp[1]==0) ? $state[0] : $state[1];
																}
																echo $model2->getAttributeLabel($exp[0]).'变更为：'.$down;
															}
														}
													}
												?>
											</td>
											<td><?php echo date("Y-m-d H:i",strtotime($v->s_time));?></td>
										</tr>
										<?php }?>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="div1">
					<h3>直播互动打赏</h3>
				</div>
				<div class="record-box">
					<div class="reward-record-box">  
						<div style="height: 10%; width:101%;">
							<table class="gridtable">
								<tr>
									<th style="width:15%;text-align:center;"><?php echo $message->getAttributeLabel("s_gfaccount")?></th>
									<th style="width:25%;text-align:center;"><?php echo $message->getAttributeLabel("live_reward_gf_name")?></th>
									<th style="width:15%;text-align:center;"><?php echo $message->getAttributeLabel("live_reward_name")?></th>
									<th style="width:15%;text-align:center;"><?php echo $message->getAttributeLabel("live_reward_price")?></th>
									<th style="width:30%;text-align:center;">打赏时间</th>
								</tr>
							</table>
						</div>
						<div id="scroll1" style="overflow-x: auto; overflow-y: auto; height: 88%;width:98%;margin-left: 1%;margin-top: 1%;">
							<!-- <table class="gridtable">
								<?php //foreach ($rewardRecord as $v){?>
									<tr>
										<td style="width:15%;"><?php //echo $v->s_gfaccount; ?></td>
										<td style="width:32%;"><?php //if(!empty($v->live_reward_gf_name)) echo $v->live_reward_gf_name;else echo $v->live_reward_actor_name;?></td>
										<td style="width:27%;"><?php //echo $v->live_reward_name?></td>
										<td style="width:26%;"><?php //echo $v->live_reward_price?></td>
									</tr>
								<?php //}?>
							</table> -->
							<iframe name="topIframe" width="100%" height="100%" src="<?php if(!empty($mainVideo)){ echo $this->createUrl('reward_text',array('id'=>$mainVideo->id)); }?>" frameborder="0" scrolling="yes"></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- <div class="input-box">
			<input type="text" id="send-input" class="send-input" maxlength="50">
			<button class="send-button" onclick="sendMessage()">发送</button>
			<span class="span_tip">
				<span id="span-button" class="span-button">常用</span>
				<div class="tip">
					<ul class="tip-ul">
						<li>常用-1</li>
						<li>常用-2</li>
						<li>常用-3</li>
						<li>常用-4</li>
						<li>常用-5</li>
					</ul>
				</div>
			</span>
		</div> -->
	</div>
	<div class="video-right">
		<?php
			if(!empty($mainVideo)){
			$condition = get_where_club_project('club_id').' and video_live.if_del=648 and video_live.live_state=372 and video_live.state=1364 and video_live.is_uplist=1 group by video_live.is_rtmp<>1,video_live.id DESC';
			$model = VideoLive::model()->findAllBySql('select video_live.* from video_live join video_live_programs on video_live_programs.live_id=video_live.id and video_live_programs.program_end_time>date_add(now(),interval -5 minute) where '.$condition);
			foreach($model as $k){
				// if(!empty($mainVideo) && $k->id==$mainVideo->id) continue;
				if(!empty($k->logo)){
					$k->logo=BasePath::model()->get_www_path().$k->logo;
				}
				$color = 'red';
				$txt = '';
				if($k->is_online==1 && $k->is_rtmp==1){
					$color = 'green';
					$txt = '直播中';
				}
		?>
			<a id="<?php echo $k->id;?>" href="<?php echo $this->createUrl('platform', array('id'=>$k->id));?>" title="<?php echo $k->title;?>">
				<div class="video-right-box" id='<?php echo $k->id;?>'>
					<div class="small-icon">
						<img src="<?php echo $k->logo; ?>" width="100%" height="48px">
					</div>
					<div class="small-title">
						<!-- <h3 style="display:inline;"><?php //echo $k->title;?></h3> -->
						<h3 id="marquee_<?php echo $mainVideo->id; ?>" class="marquee" style="display:inline;">
							<span id="marquee_text_<?php echo $mainVideo->id; ?>" class="marquee_text"><?php echo $k->title;?></span>
							<span class="marquee_state_time"><?php echo date("Y-m-d H:i",strtotime($k->state_time));?></span>
						</h3>
						<span style="display: inline-block;float: right;margin-bottom: 9px;">
							<span style="display: inline-block;width: 10px;height: 10px;border-radius: 50%;background-color: <?php echo $color; ?>;"></span>
							<?php echo $txt; ?>
						</span>
					</div>
					<?php if($k->id == $mainVideo->id){?>
					<div style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;background: rgba(0,0,0,0.5);color: #fff;font-size: 16px;text-align: center;line-height: 48px;">监控中</div>
					<?php }?>
				</div>
			</a>
		<?php }}?> 
	</div>
</div>
<script>
	$(".setBox>div").on('click', function(){
		var attr=$(this).attr("id");
		var id='<?php if(!empty($mainVideo)) echo $mainVideo->id;?>';
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
				// console.log(request);
				we.msg('minus','设置失败');
			},
			success: function(data) {
                $('#scroll2>table').append('<tr><td>'+data.message+'</td><td>'+new Date(data.time).format("yyyy-MM-dd hh:mm")+'</td></tr>');
                var setHeight = $("#scroll2")[0].scrollHeight;
                $("#scroll2").scrollTop(setHeight);
				// var setHeight = document.getElementById('scroll2').scrollHeight;
				// document.documentElement.scrollTop = setHeight;
				// console.log(setHeight);
            }
		});
   	}

	$(function(){
		var setHeight = document.getElementById('scroll2').scrollHeight;
		// document.documentElement.scrollTop = setHeight;
		$("#scroll2").scrollTop(setHeight)
		// console.log(setHeight);
	})

   	function sendMessage(){
		// var arr1=[];
		// arr1.push('<?php //if(!empty($mainVideo))echo $mainVideo->id;?>');
		// $('.video-right').find('a').each(function(){
		// 	arr1.push($(this).attr('id'));
		// });
		// var id=we.implode(',',arr1);
		var id='<?php if(!empty($mainVideo))echo $mainVideo->id;?>';
		var message=$('.send-input').val();
		if(message!='' && id>0){
			$.ajax({
				type:"get",
				url:'<?php echo $this->createUrl("VideoLive/sendMessage");?>',
				data:{message:message,target:id},
				dataType:"json",
				error:function(request){
					// console.log(request);
					we.msg('minus','发送失败');
				},
				success: function(data) {
					// console.log(data);
					$('.send-input').val("");
				}
			});
		}
	}
	
	$('.tip ul li').on('click',function(){
		console.log($(this).text());
		$('#send-input').val($(this).text());
	});
</script>
<script>
Date.prototype.format = function(format){
	if(isNaN(this.getMonth())){
		return '';
	}
	if(!format){
		format = 'yyyy-MM-dd hh:mm:ss';
	}
	var o = {
		//month
		"M+" : this.getMonth() + 1,
		//day
		"d+" : this.getDate(),
		//hour
		"h+" : this.getHours(),
		//minute
		"m+" : this.getMinutes(),
		//second
		"s+" : this.getSeconds(),
		//quarter
		"q+" : Math.floor((this.getMonth() + 3) / 3),
		//millisecond
		"s" : this.getMilliseconds()
	};
	if(/(y+)/.test(format)){
		format = format.replace(RegExp.$1,(this.getFullYear() + "").substr(4 - RegExp.$1.length));
	}
	for(var k in o){
		if(new RegExp("(" + k + ")").test(format)){
			format = format.replace(RegExp.$1,RegExp.$1.length == 1 ? o[k] : ("00" + o[k]).substr(("" + o[k]).length));
		}
	}
	return format;
};
</script>
<?php }?>