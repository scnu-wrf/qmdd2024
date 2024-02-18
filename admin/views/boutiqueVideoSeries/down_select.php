<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="club" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="分集编号/所属视频">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
					<tr>
						<th colspan=6>点击选择</th>
					</tr>
                    <tr>
                        <th width="20%" class="check"><input id="j-checkall" class="input-check" type="checkbox" value="全选"></th>
                        <th class="check">分集编号<span style="display:none;"><a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="add_chose();">添加</a></span></th>
                        <th class="check">所属视频</th>
                        <th class="check">发布分类</th>
                        <th class="check">分集号</th>
                        <th class="check">视频文件<span class="required"></span>（点击播放）</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
                    <tr id="line<?php echo $v->id; ?>" data-id="<?php echo $v->id; ?>">
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php echo $v->video_series_code; ?></td>
                        <td><?php echo $v->video_title; ?></td>
                        <td><?php echo $v->publish_classify_name; ?></td>
                        <td><?php echo $v->video_series_title; ?></td>
                        <td><span class="fl"><?php if($v->gf_material!=null){?><span class="label-box" style="max-width: 120px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;word-break: keep-all;"><a href="<?php echo $this->createUrl("gfMaterial/video_player", array('id'=>$v->gf_material->id));?>" target="_blank" title="<?php if($v->gf_material->v_title!=''){ echo $v->gf_material->v_title; }else{ echo $v->gf_material->v_name; }?>"><?php if($v->gf_material->v_title!=''){ echo $v->gf_material->v_title; }else{ echo $v->gf_material->v_name; }?></a></span><?php }?></span></td>
                    </tr>
<?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
$(function(){
    var parentt = $.dialog.parent;				// 父页面window对象
    api = $.dialog.open.api;	// 			art.dialog.open扩展方法
    if (!api) return;

    // 操作对话框
    api.button(
			{
                name:'下架',
                callback:function(){
					$.dialog.data('down_type',<?php if(empty(get_session('use_club_id'))){echo 3;}else{echo 1;}?>);
                    return add_chose();
                }
            },
            {
                name:'取消',
                callback:function(){
                    return true;
                }
            }
    );
});

function add_chose(){
        var boxnum = $('table.list ').find('.selected');
		if(boxnum.length>0){
			$.dialog.data('video_id', -1);
		}
		$.dialog.data('video_list', boxnum );
        $.dialog.close();
 };
</script>