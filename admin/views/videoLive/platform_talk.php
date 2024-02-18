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
		height: 50px;
		float:left;border:1px solid black;
		position: relative;
		box-sizing: border-box;
	}
	.main-video-live{
		width: 100%;
		height: calc(100% - 50px);
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
		height: 100px;
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
		height: calc(100% - 110px);
		width:100%;
	}
	.set-record-box{
		height: 25%;
		width:100%;
		border: 1px solid ;
		box-sizing: border-box;
	}
	.reward-record-box{
		height: 75%;
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
	}
	.setBox-div-left{
		display: inline-block;
    	width: 40%;
	}
	.setBox-div-right{
		display: inline-block;
    	width: 40%;
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
	a {
		cursor: pointer;
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
					<td>在线观看：<span style="color:#368EE0;"><?php foreach($programs as $k=>$v){if($v->program_type==1){echo $v->online_num;break;}} ?></span></td>
				</tr>
			</table>
		</div>
		<div class="main-video-live">
			<div style="width: 33%;height: 100%;float: left;overflow-y: auto;overflow-x: hidden;">
				<table style="width:100%;height: 30px;border-bottom: solid 1px;">
					<tr>
						<td style="width:60%;">敏感词审核区</td>
						<td style="width:40%;">待审核：<span id="to_be_audited_count"><?php echo $talkSensitiveCount;?></span></td>
					</tr>
				</table>
				<table style="width:101%;height: 30px;border-bottom: solid 1px;">
					<tr>
						<td style="width:30%;border-right: solid 1px;padding: 3px;">发布人</td>
						<td style="width:30%;border-right: solid 1px;padding: 3px;">敏感内容</td>
						<td style="width:40%;padding: 3px;">类型</td>
					</tr>
				</table>
				<div style="overflow: auto; height: calc(100% - 60px);width: 98%;margin: 0 auto;">
					<iframe name="topIframe" width="100%" height="100%" src="<?php if(!empty($mainVideo)){ echo $this->createUrl('sensitive_text',array('id'=>$mainVideo->id)); }?>" frameborder="0" scrolling="yes"></iframe>
				</div>
			</div>
			<div style="width: 33%;height: 100%;float: left;overflow-y: auto;overflow-x: hidden;border-left: solid 1px;border-right: solid 1px;">
				<table style="width:100%;height: 30px;border-bottom: solid 1px;">
					<tr>
						<td style="text-align:center;">互动聊天</td>
					</tr>
				</table>
				<div style="overflow: auto; height: calc(100% - 30px);width: 98%;margin: 0 auto;">
					<iframe name="topIframe" width="100%" height="100%" src="<?php if(!empty($mainVideo)){ echo $this->createUrl('talk_text',array('id'=>$mainVideo->id)); }?>" frameborder="0" scrolling="yes"></iframe>
				</div>
			</div>
			<div style="height: 100%;overflow-y: auto;overflow-x: hidden;">
				<table style="width:100%;height: 30px;border-bottom: solid 1px;">
					<tr>
						<td style="text-align:center;">敏感用户名单</td>
					</tr>
				</table>
			</div>
		</div>
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
			<a id="<?php echo $k->id;?>" href="<?php echo $this->createUrl('platform_talk', array('id'=>$k->id));?>" title="<?php echo $k->title;?>">
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
<?php }?>