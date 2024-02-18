
<div class="box">
    <div class="box-title c">
    <h1><i class="fa fa-table"></i>推送单位详情</h1><span class="back">
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
                    <td width="15%"><?php echo $form->labelEx($model, 'club_code'); ?></td>
                    <td width="35%"><span id="code_box"><?php echo $model->club_code; ?></span></td>
                    <td width="15%"><?php echo $form->labelEx($model, 'partnership_type'); ?></td>
                    <td width="35%"><span id="type_box"><?php echo $model->partnership_name; ?></span></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'club_name'); ?></td>
                    <td colspan="3">
						<span id="club_box" class="label-box"><?php echo $model->club_name; ?></span>
						<?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text')); ?>
						<input id="club_select_btn" class="btn" type="button" value="选择">
						<?php echo $form->error($model, 'club_id', $htmlOptions = array()); ?>
					</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'club_list'); ?></td>
                    <td colspan="3">
						<?php echo $form->hiddenField($model, 'club_list', array('class' => 'input-text')); ?>
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

// 选择单位
    var $club_box=$('#club_box');
    var $club_id=$('#GfRecommendClub_club_id');
    $('#club_select_btn').on('click', function(){
        $.dialog.data('club_id', 0);
		var url='<?php echo $this->createUrl("select/club");?>&edit_state=372';
		console.log(url)
        $.dialog.open(url,{
            id:'danwei',
            lock:true,
            opacity:0.3,
            title:'选择单位',
            width:'500px',
            height:'60%',
			close: function () {
                //console.log($.dialog.data('club_id'));
                if($.dialog.data('club_id')>0){
                    $club_id.val($.dialog.data('club_id')).trigger('blur');
                    $club_box.html($.dialog.data('club_title'));
                    $('#code_box').html($.dialog.data('club_code'));
                    $('#type_box').html($.dialog.data('club_typename'));
                }
            }
        });
    });

    // 选择可推送到的单位
    $('#club_list_add_btn').on('click', function(){
        $.dialog.data('club_id', 0);
		var url='<?php echo $this->createUrl("clubmore");?>';
        $.dialog.open(url,{
            id:'tuijiandanwei',
            lock:true,
            opacity:0.3,
            title:'选择可推送到的单位',
            width:'500px',
            height:'60%',
            close: function () {
				// console.log($.dialog.data('club_id'));
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
var $VideoLive_club_list=$('#GfRecommendClub_club_list');
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
