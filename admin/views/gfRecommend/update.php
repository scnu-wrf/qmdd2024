
<div class="box">
    <div class="box-title c">
		<?php if($_GET['recommend_type']==0){ ?>
        <h1><i class="fa fa-table"></i>直播推送详情</h1>
		<?php }else if($_GET['recommend_type']==1){ ?>
		<h1><i class="fa fa-table"></i>资讯推送详情</h1>
		<?php }else if($_GET['recommend_type']==2){ ?>
		<h1><i class="fa fa-table"></i>赛事推送详情</h1>
		<?php } ?>
	<span class="back">
    <a class="btn" href="javascript:;" onclick="we.back();">
    <i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table class="table-title">
                <tr>
                    <td>单位信息</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td width="15%">单位编码</td>
                    <td width="35%"><?php if(!empty($model->club_list)) { echo $model->club_list->club_code; } else{ echo get_session('club_code'); } ?></td>
                    <td width="15%">单位名称</td>
                    <td width="35%">
                        <span id="club_box"><?php if(!empty($model->club_list)){?><span class="label-box"><?php echo $model->club_list->club_name;?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text')); ?></span><?php } else {?><span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value'=>get_session('club_id'))); ?></span><?php } ?></span>
                        <?php echo $form->error($model, 'club_id', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'video_live_code'); ?></td>
                    <td><span id="code_box"><?php echo $model->video_live_code; ?></span></td>
                    <td><?php echo $form->labelEx($model, 'video_live_title'); ?></td>
                    <td>
						<span id="title_box"><?php echo $model->video_live_title; ?></span>
						<?php echo $form->hiddenField($model, 'recommend_type', array('class' => 'input-text','value'=>$_GET['recommend_type'])); ?>
                        <?php echo $form->hiddenField($model, 'video_live_id', array('class' => 'input-text')); ?>
						<input id="live_select_btn" class="btn" type="button" value="选择">
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'recommend_club_id'); ?></td>
                    <td colspan="3">
						<?php echo $form->hiddenField($model, 'recommend_club_id', array('class' => 'input-text')); ?>
                        <span id="club_list_box">
							<?php if(!empty($club_list)) foreach($club_list as $v){?><span class="label-box" id="club_item_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>"><?php echo $v->club_name; ?><i onclick="fnDeleteClub(this);"></i></span><?php }?>
						</span>
                        <input id="club_list_add_btn" class="btn" type="button" value="添加单位">
                        <?php echo $form->error($model, 'club_list', $htmlOptions = array()); ?>
					</td>
                </tr>                                     
            </table>
        </div><!--box-detail-bd end-->
        <div class="mt15" style="text-align:center;">
        <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>
            
<?php $this->endWidget(); ?>
  </div><!--box-detail end-->
</div><!--box end-->
<script>

	// 选择直播
    var $video_live_id=$('#GfRecommend_video_live_id');
    var club_id=$('#GfRecommend_club_id').val();
	var recommend_type=$('#GfRecommend_recommend_type').val();
	var video_live_id=$video_live_id.val();
	var video_live_id_new='';
    $('#live_select_btn').on('click', function(){
		video_live_id_new=$video_live_id.val();
		var url='';
		if(recommend_type==0){
			url+='<?php echo $this->createUrl("videolive");?>&recommend_type='+recommend_type;
		}else if(recommend_type==1){
			url+='<?php echo $this->createUrl("clubnews");?>&recommend_type='+recommend_type;
		}else if(recommend_type==2){
			url+='<?php echo $this->createUrl("game");?>&recommend_type='+recommend_type;
		}
		url+='&club_id='+club_id+'&video_live_id='+video_live_id+'&video_live_id_new='+video_live_id_new;
        $.dialog.open(url,{
            id:'zhibo',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
			close: function () {
                if($.dialog.data('video_live_id')>0){
                    $video_live_id.val($.dialog.data('video_live_id')).trigger('blur');
                    $('#code_box').html($.dialog.data('video_live_code'));
                    $('#title_box').html($.dialog.data('video_live_title'));
                }
            }
        });
    });

    // 选择推送到的单位
    $('#club_list_add_btn').on('click', function(){
        $.dialog.data('club_id', 0);
		var url='<?php echo $this->createUrl("gfRecommendClub/clubmore");?>&club_id='+club_id;
		console.log(url)
        $.dialog.open(url,{
            id:'tuijiandanwei',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('club_id')==-1){
                    var boxnum=$.dialog.data('club_title');
                    for(var j=0;j<boxnum.length;j++)
                    {
                        if($('#club_item_'+boxnum[j].dataset.id).length==0){    
                            var s1='<span class="label-box" id="club_item_'+boxnum[j].dataset.id;
                            s1=s1+'" data-id="'+boxnum[j].dataset.id+'">'+boxnum[j].dataset.title;
                            $club_list_box.append(s1+'<i onclick="fnDeleteClub(this);"></i></span>');
                            fnUpdateClub(); 
                        }
                    }
                 }
            }
        });
    });
// 推荐到单位更新、删除
var $club_list_box=$('#club_list_box');
var $VideoLive_club_list=$('#GfRecommend_recommend_club_id');
var fnUpdateClub=function(){
    var arr=[];
    var id;
    $club_list_box.find('span').each(function(){
        id=$(this).attr('data-id');
        arr.push(id);
    });
    $VideoLive_club_list.val(we.implode(',', arr)).trigger('blur');
};

var fnDeleteClub=function(op){
    $(op).parent().remove();
    fnUpdateClub();
};

	
</script>
