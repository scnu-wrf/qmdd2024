<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="club_id" value="<?php echo $_GET["club_id"];?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="club" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead><tr><th>点击选择</th>
                <th class="check" colspan="2"><input id="j-checkall" class="input-check" type="checkbox">全选&nbsp;&nbsp;&nbsp;<span style="display:none;"><a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="add_chose();">添加</a></span></th>
                </tr></thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
                    <tr id="line<?php echo $v->id; ?>" data-id="<?php echo $v->id; ?>" data-code="<?php echo $v->code; ?>" data-title="<?php echo $v->title; ?>">
                        <td class="check check-item" width="10%"><input class="input-check" type="checkbox" id="id<?php echo CHtml::encode($v->select_id); ?>" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td width="30%"><?php echo $v->code; ?></td>
                        <td width="60%"><?php echo $v->title; ?></td>
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
    api = $.dialog.open.api;    //          art.dialog.open扩展方法
    if (!api) return;

    // 操作对话框
    api.button(
            {
                name:'添加',
                callback:function(){
                    return add_chose();
                },
                focus:true
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
        $.dialog.data('video_live_id', -1);
        $.dialog.data('video_live_code', $(this).attr('data-code'));
        $.dialog.data('video_live_title', boxnum );
        $.dialog.close();
 };
</script>