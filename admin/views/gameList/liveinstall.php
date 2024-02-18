<div class="box">
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model,'video_live_id'); ?></td>
                    <td width="85%">
                        <?php echo $form->hiddenField($model, 'video_live_id', array('class' => 'input-text')); ?>
                        <span id="live_box"><?php if(!empty($video_live)) foreach($video_live as $v){?><span class="label-box" id="live_item_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>"><?php echo $v->title; ?><i onclick="fnDeleteLive(this);"></i></span><?php }?></span>
                        <input id="live_select_btn" class="btn" type="button" value="添加">
                    <?php echo $form->error($model, 'video_live_id', $htmlOptions = array()); ?>
                            
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center;"><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">确定</button></td>
                </tr>
               
            </table>
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
// 选择直播
var $live_box=$('#live_box');
var $video_live_id=$('#GameList_video_live_id');
var club_id=<?php echo $model->game_club_id; ?>;
$('#live_select_btn').on('click', function(){
    $.dialog.data('video_live_id', 0);
    $.dialog.open('<?php echo $this->createUrl("select/videolive_more");?>&club_id='+club_id,{
        id:'zhibo',
        lock:true,
        opacity:0.3,
        title:'选择直播',
        width:'500px',
        height:'60%',
        close: function () {
            if($.dialog.data('video_live_id')==-1){
                var boxnum=$.dialog.data('video_live_title');
                for(var j=0;j<boxnum.length;j++)
                {
                    if($('#club_item_'+boxnum[j].dataset.id).length==0){    
                        var s1='<span class="label-box" id="live_item_'+boxnum[j].dataset.id;
                        s1=s1+'" data-id="'+boxnum[j].dataset.id+'">'+boxnum[j].dataset.title;
                        $live_box.append(s1+'<i onclick="fnDeleteLive(this);"></i></span>');
                        fnUpdateLive(); 
                    }
                }
             }
        }
    });
});

// 直播更新、删除
var fnUpdateLive=function(){
    var arr=[];
    var id;
    $live_box.find('span').each(function(){
        id=$(this).attr('data-id');
        arr.push(id);
    });
    $video_live_id.val(we.implode(',', arr)).trigger('blur');
};

var fnDeleteLive=function(op){
    $(op).parent().remove();
    fnUpdateLive();
};
</script>
