
<div class="box">
    <div class="box-title c"><h1>当前界面：视频》视频分集管理》发布视频分集》<a class="nav-a">编辑</a></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span></div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
		<div class="box-detail-bd" style="margin-top: 10px;">
			<table>
				<tr>
                    <td width="15%">选择视频</td>
                    <td>
						<input class="input-text" readonly="readonly" style="width:200px;" id="video_title" type="text" value="<?php echo $model->video_title;?>" autocomplete="off">
						<input id="video_select_btn" class="btn" type="button" value="选择">
						<?php echo $form->error($model, 'video_id'); ?>
						<?php echo $form->hiddenField($model, 'video_id', array('class' => 'input-text')); ?>
						<?php echo $form->hiddenField($model, 'series_publish_id', array('class' => 'input-text')); ?>
					</td>
					<td width="15%"><?php echo $form->labelEx($model, 'publish_classify'); ?></td>
					<td width="35%"><?php echo $model->publish_classify_name;?></td>
                </tr>
				<tr>
					<td width="15%">是否上线 <span class="required">*</span><br><span style="color:#7a7a7a;font-size:smaller;">是:上线,展示前端<br>否:下线,不展示前端</span></td>
					<td colspan=3>
						<?php echo $form->radioButtonList($model, 'is_uplist', Chtml::listData(array(array("id"=>"1","name"=>"是"),array("id"=>"0","name"=>"否")), 'id', 'name'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
						<?php echo $form->error($model, 'is_uplist'); ?>
					</td>
				</tr>
			</table>
			<table class="table-title" style="margin-top:10px;table-layout:auto;">
				<tr>
					<td width="90%">视频分集</td>
					<td><input onclick="fnAddProgram();" class="btn" type="button" value="添加行"></td>
				</tr>
			</table>
			<table>
				<tr>
					<td>
						<?php echo $form->hiddenField($model, 'programs_list'); ?>
						<input name="fileCode" id="fileCode" value="204_gm" type="hidden" />
						<table id="program_list" class="showinfo" data-num="new" style="margin:0;table-layout:auto;">
							<tr class="table-title">
								<td width="20%">分集编号</td>
								<td width="15%">分集名称<span class="required">*</span></td>
								<td width="8%">分集排序<span class="required">*</span></td>
								<td>视频文件<span class="required">*</span><span style="color:#7a7a7a;font-size:smaller;">（点击播放）</span></td>
								<td width="8%">格式</td>
								<td width="8%">时长</td>
								<td width="6%">操作</td>
							</tr>
							<?php if(!empty($programs)){?>
								<?php foreach($programs as $k=>$v){?>
							<tr>
								<td><?php echo $v->video_series_code;?></td>
								<td><input type="hidden" class="input-text" name="programs_list[<?php echo $v->id;?>][id]" value="<?php echo $v->id;?>" />
								<input onchange="fnUpdateProgram();" class="input-text up_title" name="programs_list[<?php echo $v->id;?>][video_series_title]" value="<?php echo $v->video_series_title;?>" style="width:80%;"></td>
								<td><input onchange="fnUpdateProgram();" class="input-text up_title" name="programs_list[<?php echo $v->id;?>][video_series_num]" value="<?php echo $v->video_series_num;?>" style="width:80%;"></td>
								<td class="up_btn">
									<span class="fl">
										<div class="up_progress" style="width: 200px;height: 25px;line-height: 25px;background-color:#f7f7f7;box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);border-radius:4px;background-image:linear-gradient(to bottom,#f5f5f5,#f9f9f9);display:none;">
											<div class="up_finish" style="<?php echo empty($v->video_source_id)?'width: 0%;':'width: 100%;'?>background-color: #149bdf;
background-image:linear-gradient(45deg,rgba(255,255,255,0.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,0.15) 50%,rgba(255,255,255,0.15) 75%,transparent 75%,transparent);background-size:40px 40px;height: 100%;color: #fff;text-align: right;padding-right: 5px;box-sizing: border-box;" progress="0"><?php echo empty($v->video_source_id)?'':'100%'?></div>
										</div>
									</span>
									<span class="fl video_box"><?php if($v->gf_material!=null){?><span class="label-box" style="max-width: 120px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;word-break: keep-all;"><a href="<?php echo $this->createUrl("gfMaterial/video_player", array('id'=>$v->gf_material->id));?>" target="_blank" title="<?php if($v->gf_material->v_title!=''){ echo $v->gf_material->v_title; }else{ echo $v->gf_material->v_name; }?>"><?php if($v->gf_material->v_title!=''){ echo $v->gf_material->v_title; }else{ echo $v->gf_material->v_name; }?></a></span><?php }?></span>
									<div class="upload fl">
										<script>we.materialVideoNew("<?php echo $this->createUrl('GfMaterial/saveMaterial');?>");</script>
									</div>
									<input style="margin-left:5px;" class="btn fl video_select_btn" type="button" value="选择视频">
									<input type="hidden" class="input-text up_source" name="programs_list[<?php echo $v->id;?>][video_source_id]" value="<?php echo $v->video_source_id;?>" />
									<input type="hidden" class="input-text" name="programs_list[<?php echo $v->id;?>][video_format]" value="<?php echo $v->video_format;?>" />
									<input type="hidden" class="input-text" name="programs_list[<?php echo $v->id;?>][video_duration]" value="<?php echo $v->video_duration;?>" />
								</td>
								<td><?php echo $v->video_format;?></td>
								<td><?php echo $v->video_duration;?>分钟</td>
								<td style="text-align:left;"><input onclick="fnDeleteProgram(this);" class="btn" type="button" value="删除"></td>
							</tr>
								<?php }?>
							<?php } else { ?>
							<tr>
								<td><span style="color:#7a7a7a">系统生成</span></td>
								<td><input type="hidden" class="input-text" name="programs_list[new][id]" value="null" /><input onchange="fnUpdateProgram();" class="input-text up_title" name="programs_list[new][video_series_title]"></td>
								<td class="up_btn">
									<span class="fl">
										<div class="up_progress" style="width: 200px;height: 25px;line-height: 25px;background-color:#f7f7f7;box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);border-radius:4px;background-image:linear-gradient(to bottom,#f5f5f5,#f9f9f9);display:none;">
											<div class="up_finish" style="width: 0%;background-color: #149bdf;
background-image:linear-gradient(45deg,rgba(255,255,255,0.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,0.15) 50%,rgba(255,255,255,0.15) 75%,transparent 75%,transparent);background-size:40px 40px;height: 100%;color: #fff;text-align: right;padding-right: 5px;box-sizing: border-box;" progress="0"></div>
										</div>
									</span>
									<span class="fl video_box"></span>
									<div class="upload fl">
										<script>we.materialVideoNew("<?php echo $this->createUrl('GfMaterial/saveMaterial');?>");</script>
									</div>
									<input style="margin-left:5px;" class="btn fl video_select_btn" type="button" value="选择视频">
									<input type="hidden" class="input-text up_source" name="programs_list[new][video_source_id]" value="null" />
									<input type="hidden" class="input-text" name="programs_list[new][video_format]" />
									<input type="hidden" class="input-text" name="programs_list[new][video_duration]" />
								</td>
								<td></td>
								<td></td>
								<td style="text-align:left;"><input onclick="fnDeleteProgram(this);" class="btn" type="button" value="删除"></td>
							</tr>
							<?php }?>
						</table>
						<?php echo $form->error($model, 'programs_list', $htmlOptions = array()); ?>
					</td>
				</tr>
			</table>
			<table class="table-title" style='margin-top:10px;'><tr><td>操作信息</td></tr></table>
			<table>
				<tr>
					<td width="15%"><?php echo $form->labelEx($model, 'state'); ?></td>
					<td colspan="3"><?php echo $model->state_name;?></td>
				</tr>
				
				<?php if($model->state==371){//待审核?>
				<tr>
					<td>可执行操作</td>
					<td colspan="3">
						<?php echo show_shenhe_box(array('chexiao'=>'撤销'));?>
						<button class="btn" type="button" onclick="we.back();">取消</button>
					</td>
				</tr>
				<?php }else if($model->state==372||$model->state==373){//审核通过、审核未通过?>
				<tr>
					<td>操作备注</td>
					<td colspan="3">
						<?php echo $model->reasons_failure;?>
					</td>
				</tr>
					<?php if($model->state==373){//审核未通过?>
				<tr>
					<td>可执行操作</td>
					<td colspan="3">
						<button id="shanchu" onclick="delete_video('<?php echo $model->id;?>', deleteUrl);" class="btn btn-blue" type="button"> 删除</button>
						<button class="btn" type="button" onclick="we.back();">取消</button>
					</td>
				</tr>
					<?php }?>
				<?php }else{//编辑中、退回修改?>
					<?php if($model->state==1538){//退回修改?>
				<tr>
					<td>操作备注</td>
					<td colspan="3">
						<?php echo $model->reasons_failure;?>
					</td>
				</tr>
					<?php }?>
				<tr>
					<td>可执行操作</td>
					<td colspan="3">
						<?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));?>
						<button class="btn" type="button" onclick="we.back();">取消</button>
					</td>
				</tr>
				<?php }?>
			</table>
        </div><!--box-detail-bd end-->
        <div class="box-detail-submit">
 </div>

<?php $this->endWidget();?>

</div>
</div>
<script>
$(window).on('beforeunload',function(event){
	if($(".up_progress").is(":visible")){
		return "视频正在上传，是否确认离开";
	}
});
$(function(){
	setInterval(function(){$.ajax({url:"<?php echo $this->createUrl('BoutiqueVideo/get_date');?>",type:'post'});}, 600000);
	$.dialog.data('video_id', '<?php echo $model->video_id;?>');
    $.dialog.data('video_title', '<?php echo $model->video_title;?>');
});

$('#video_select_btn').on('click', function(){
	$.dialog.open('<?php echo $this->createUrl("customer_service_list");?>&club_id=<?php echo get_session("club_id")?>',{
		id:'fuwuzhe',lock:true,opacity:0.3,width:'60%',height:'60%',
		title:'选择具体内容',
		close: function () {
			$("#BoutiqueVideoSeries_video_id").val($.dialog.data('video_id'));
			$("#video_title").val($.dialog.data('video_title'));
		}
	});
})
// 选择视频
$('.video_select_btn').on('click', function(){
	var $_this=$(this);
	$.dialog.data('video_id', 0);
	$.dialog.open('<?php echo $this->createUrl("select/material", array("type"=>"253,254","club_id"=>get_SESSION("club_id")));?>',{
		id:'shipin',
		lock:true,
		opacity:0.3,
		title:'选择具体内容',
		width:'500px',
		height:'60%',
		close: function () {
			if($.dialog.data('material_id')>0){
				$_this.parents('.up_btn').find(".video_box").html('<span class="label-box" style="max-width: 120px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;word-break: keep-all;"><a href="../qmdd2018/index.php?r=gfMaterial/video_player&id='+$.dialog.data('material_id')+'" target="_blank" title="'+$.dialog.data('material_title')+'">'+$.dialog.data('material_title')+'</a></span>');
				$_this.parents('.up_btn').find('.input-text').eq(0).val($.dialog.data('material_id'));
				$_this.parents('.up_btn').find('.input-text').eq(1).val($.dialog.data('file_format'));
				$_this.parents('.up_btn').find('.input-text').eq(2).val($.dialog.data('duration'));
				$_this.parents('.up_btn').next('td').html($.dialog.data('file_format'));
				$_this.parents('.up_btn').next('td').next('td').html($.dialog.data('duration')+'分钟');
				fnUpdateProgram();
			}
		}
	});
});
// 添加发布分类
var $publish_classify_add_btn=$('#publish_classify_add_btn');
$publish_classify_add_btn.on('click', function(){
	$.dialog.data('classify_id', 0);
	$.dialog.open('<?php echo $this->createUrl("BoutiqueVideo/classify", array('base_f_id'=>365));?>',{
		id:'xiangmu',
		lock:true,
		opacity:0.3,
		title:'选择发布分类',
		width:'500px',
		height:'60%',
		close: function () {
			if($.dialog.data('classify_id')>0){
				if($('#publish_classify_item_'+$.dialog.data('classify_id')).length==0){
				   $publish_classify_box.html('<span class="label-box" id="publish_classify_item_'+$.dialog.data('classify_id')+'" data-id="'+$.dialog.data('classify_id')+'">'+$.dialog.data('classify_title')+'<i onclick="fnDeletePublishClassify(this);"></i></span>');
				   fnUpdatePublishClassify();
				}
			}
		}
	});
});
// 删除发布分类
var $publish_classify_box=$('#publish_classify_box');
var $BoutiqueVideo_publish_classify=$('#BoutiqueVideoSeries_publish_classify');
var fnUpdatePublishClassify=function(){
    var arr=[];
    var id;
    $publish_classify_box.find('span').each(function(){
        id=$(this).attr('data-id');
        arr.push(id);
    });
    $BoutiqueVideo_publish_classify.val(we.implode(',', arr));
};
var fnDeletePublishClassify=function(op){
    $(op).parent().remove();
    fnUpdatePublishClassify();
};

// 添加删除更新节目
var $program_list=$('#program_list');
var $VideoLive_programs_list=$('#BoutiqueVideoSeries_programs_list');
var fnAddProgram=function(){
    var num=$program_list.attr('data-num')+1;
	var op='up'+new Date().getTime()+parseInt(Math.random()*100000);
	var html='<div id="uploadifive-upload_'+op+'" class="uploadifive-button" style="height: 24px; line-height: 24px; overflow: hidden; position: relative; text-align: center; width: 61px;">上传视频<input id="upload_'+op+'" type="file" accept="video/mp4,audio/mp3" style="font-size: 24px; opacity: 0; position: absolute; right: -3px; top: -3px; z-index: 999;"></div><div id="uploadifive-upload_'+op+'-queue" class="uploadifive-queue"></div>';
	var $video_series_title=$('<input class="input-text up_title" name="programs_list['+num+'][video_series_title]" style="width:80%;" onchange="fnUpdateProgram();">');
	var $txt=$('<td><input type="hidden" class="input-text" name="programs_list['+num+'][id]" value="null" /></td>').append($video_series_title);
	var $video_series_num=$('<td><input class="input-text up_title" name="programs_list['+num+'][video_series_num]" style="width:80%;" onchange="fnUpdateProgram();"></td>');
	var $content=$('<tr><td><span style="color:#7a7a7a">系统生成</span></td></tr>').append($txt).append($video_series_num).append('<td class="up_btn"><span class="fl"><div class="up_progress" style="width: 200px;height: 25px;line-height: 25px;background-color:#f7f7f7;box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);border-radius:4px;background-image:linear-gradient(to bottom,#f5f5f5,#f9f9f9);display:none;"><div class="up_finish" style="width: 0%;background-color: #149bdf;background-image:linear-gradient(45deg,rgba(255,255,255,0.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,0.15) 50%,rgba(255,255,255,0.15) 75%,transparent 75%,transparent);background-size:40px 40px;height: 100%;color: #fff;text-align: right;padding-right: 5px;box-sizing: border-box;" progress="0"></div></div></span><span class="fl video_box"></span>'+
		'<div class="upload fl">'+html+'</div>'+
		'<input style="margin-left:5px;" class="btn fl video_select_btn" type="button" value="选择视频"><input type="hidden" class="input-text up_source" name="programs_list['+num+'][video_source_id]" value="null" /><input type="hidden" class="input-text" name="programs_list['+num+'][video_format]" /><input type="hidden" class="input-text" name="programs_list['+num+'][video_duration]" /></td>'+
        '<td></td>'+
        '<td></td>'+
        '<td style="text-align:left;"><input onclick="fnDeleteProgram(this);" class="btn" type="button" value="删除"></td>');
    $program_list.append($content);
    $program_list.attr('data-num',num);
	fnUpdateProgram();
	var fileForm = document.getElementById('upload_'+op);
	var upload = new Upload();
	fileForm.onchange = function(){
        upload.addFileAndSend(this);
    }
	function Upload(){
        var xhr = new XMLHttpRequest();
        var form_data = new FormData();
        const LENGTH = 1024 * 1024 * 5;
        var start = 0;
        var end = start + LENGTH;
        var blob_num = 1;
        var is_stop = 0;
        var running=false;
		var filename='';
		var filetitle='';
		var res_json;
        //对外方法，传入文件对象
        this.addFileAndSend = function(that){
			$('#upload_'+op).parents('.up_btn').find(".up_progress").show();
			$('#upload_'+op).parents('.up_btn').find(".up_finish").html('0%');
			
			var file = that.files[0];
            var filename = file.name;
            var index = filename.lastIndexOf(".");
    		var suffix = filename.substr(index+1);
        	if(suffix=='mp4'||suffix=='mp3'){
	            //获取音频、视频时长
		        var url = URL.createObjectURL(file);
		        var audioElement = new Audio(url);
		    	var duration;
		        audioElement.addEventListener("loadedmetadata", function (_event) {
		            duration = Math.ceil(audioElement.duration);
		            doFileToMd5(file,duration);
		        });
        	}else{
	            doFileToMd5(file,0);
        	}
        }
        //停止文件上传
        this.stop = function(){
            xhr.abort();
            is_stop = 1;
        }
		
		//获取文件Md5
        function doFileToMd5(file,duration) {
            if (running) {
                return;
            }
            if (file.size==0) {
                return;
            }
            var blobSlice = File.prototype.slice || File.prototype.mozSlice || File.prototype.webkitSlice,
                chunkSize = 1024 * 1024 * 5,                           // read in chunks of 2MB
                chunks = Math.ceil(file.size / chunkSize),
                currentChunk = 0,
                spark = new SparkMD5.ArrayBuffer(),
                time,
                fileReader = new FileReader(),md5_str='';
            fileReader.onload = function (e) {
                spark.append(e.target.result);                 // append array buffer
                currentChunk += 1;
                if (currentChunk < chunks) {
                    loadNext();
                } else {
                    running = false;
                    md5_str=spark.end();
                    askSendFile(file,md5_str,duration);
                }
            };
            fileReader.onerror = function () {
                running = false;
            };
            function loadNext() {
                var start = currentChunk * chunkSize,
                    end = start + chunkSize >= file.size ? file.size : start + chunkSize;
                fileReader.readAsArrayBuffer(blobSlice.call(file, start, end));
            }
            running = true;
            time = new Date().getTime();
            loadNext();
        }
		
        //切割文件
        function cutFile(file){
            var file_blob = file.slice(start,end);
            start = end;
            end = start + LENGTH;
            return file_blob;
        };
        //请求发送文件
        function askSendFile(file,md5_str,duration){
			filetitle=file.name;
			$.ajax({
				url: "/gw/chunk_upload.php",
				type: 'post',
				data: {action:'upload_ask',slen:file.size,segs:Math.ceil(file.size / LENGTH),file_md5:md5_str,fileName:file.name,duration:Math.ceil(duration),fileCode:fileCode.value},
				dataType: 'json',
				success: function (json) {
					res_json=json;
					var filename_arr=json.filename.split('/');
					filename=filename_arr[filename_arr.length-1]
                    if(json.code==0){
                        sendFile(cutFile(file),file,json.fileId);
                    }else if(json.error>0){
						askSendFile(file,md5_str,duration);
					}else{
						askSendFile(file,md5_str,duration);
					}
				}
			});
        }
        //发送文件
        function sendFile(blob,file,fileId){
			var total_blob_num = Math.ceil(file.size / LENGTH);
            form_data = new FormData();
            form_data.append('action','chunk_upload_file');
            form_data.append('file',blob);
            form_data.append('fileId',fileId);
            form_data.append('segno',blob_num);
            form_data.append('start',start-LENGTH);
			$.ajax({
				url: "/gw/chunk_upload.php",
				type: 'post',
				data: form_data,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function (json) {
					if(json.code==0){
                    	var progress;
		                var progressObj = $('#upload_'+op).parents('.up_btn').find(".up_finish").get(0);
		                if(total_blob_num == 1){
		                    progress = 100;
		                }else{
		                    progress = Math.min(100,(blob_num/total_blob_num)* 100 );
		                }
		                progressObj.style.width = progress+'%';
						$('#upload_'+op).parents('.up_btn').find(".up_finish").html(parseInt(progress));
		                var t = setTimeout(function(){
		                    if(start < file.size && is_stop === 0){
		                        sendFile(cutFile(file),file,fileId);
		                    }else{
		                        setTimeout(t);
		                    }
		                },500);
						if(progress == 100){
							var index = filetitle.lastIndexOf(".");
							var suffix = filetitle.substr(index+1);
							var v_type=253;
							if(suffix=="mp3"){
								v_type=254;
							}else if(suffix=="mp4"){
								v_type=253;
							}
							$.ajax({
								url: "<?php echo $this->createUrl('GfMaterial/saveMaterial');?>",
								type: 'post',
								data: {v_title:filetitle,v_type:v_type,v_name:res_json.filename,v_file_path:res_json.fileUrl,v_file_insert_size:sec_format(res_json.playtime_seconds)},
								dataType: 'json',
								success: function (d) {
									var $_this=$('#upload_'+op);
									$_this.parents('.up_btn').find(".up_progress").hide();
									$_this.parents('.up_btn').find(".video_box").html('<span class="label-box" style="max-width: 120px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;word-break: keep-all;"><a href="../qmdd2018/index.php?r=gfMaterial/video_player&id='+d.id+'" target="_blank" title="'+filetitle+'">'+filetitle+'</a></span>');
									$_this.parents('.up_btn').find('.input-text').eq(0).val(d.id);
									$_this.parents('.up_btn').find('.input-text').eq(1).val(d.file_format);
									$_this.parents('.up_btn').find('.input-text').eq(2).val(d.duration);
									$_this.parents('.up_btn').next('td').html(d.file_format);
									$_this.parents('.up_btn').next('td').next('td').html(d.duration+'分钟');
									fnUpdateProgram();
								}
							});
						}
                    }else if(json.error>0){
						sendFile(blob,file,fileId);
					}else{
		                sendFile(blob,file,fileId);
                    }
                    blob_num  += 1;
				}
			});
        }
    }
	// 选择视频
    $('.video_select_btn').on('click', function(){
		var $_this=$(this);
        $.dialog.data('video_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/material", array("type"=>"253,254","club_id"=>get_SESSION("club_id")));?>',{
            id:'shipin',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('material_id')>0){
					$_this.parents('.up_btn').find(".video_box").html('<span class="label-box" style="max-width: 120px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;word-break: keep-all;"><a href="../qmdd2018/index.php?r=gfMaterial/video_player&id='+$.dialog.data('material_id')+'" target="_blank" title="'+$.dialog.data('material_title')+'">'+$.dialog.data('material_title')+'</a></span>');
					$_this.parents('.up_btn').find('.input-text').eq(0).val($.dialog.data('material_id'));
					$_this.parents('.up_btn').find('.input-text').eq(1).val($.dialog.data('file_format'));
					$_this.parents('.up_btn').find('.input-text').eq(2).val($.dialog.data('duration'));
					$_this.parents('.up_btn').next('td').html($.dialog.data('file_format'));
					$_this.parents('.up_btn').next('td').next('td').html($.dialog.data('duration')+'分钟');
					fnUpdateProgram();
                }
            }
        });
    });
};

var fnDeleteProgram=function(op){
    $(op).parent().parent().remove();
    fnUpdateProgram();
};
var fnUpdateProgram=function(){
    var isEmpty=true;
    $program_list.find('.up_title').each(function(k){
        if($(this).val()==''){
            isEmpty=true;
			return false;
        } else{
			isEmpty=false;
        }
    });
	if(!isEmpty){
		$program_list.find('.up_source').each(function(){
			if($(this).val()=='null'){
				isEmpty=true;
				return false;
			} else{
				isEmpty=false;
			}
		});
	}
    if(!isEmpty){
        $VideoLive_programs_list.val('1').trigger('blur');
    }else{
        $VideoLive_programs_list.val('').trigger('blur');
    }
};
</script>
