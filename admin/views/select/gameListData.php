<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="game_id" value="<?php echo Yii::app()->request->getParam('game_id');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="game" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入比赛项目/参赛方式/性别/组别">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th width="20%" class="check"><input id="j-checkall" class="input-check" type="checkbox" value="全选"></th>
                        <!-- <th class="check" colspan="2">点击选择 -->
                            <span style="display:none;"><a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="add_chose();">添加</a></span>
                        <!-- </th> -->
                        <th colspan="2">点击选择</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($arclist as $v){ ?>
                        <tr id="line<?php echo $v->select_id; ?>" data-id="<?php echo $v->select_id; ?>" data-code="<?php echo $v->select_code; ?>" data-title="<?php echo $v->select_title; ?>" data-project="<?php echo $v->select_project; ?>" data-sex="<?php echo $v->select_sex; ?>" data-start="<?php echo $v->select_start; ?>" data-end="<?php echo $v->select_end; ?>" >
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->select_id); ?>"></td>
                            <td><?php echo $v->select_title; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
// $(function(){
//     api = $.dialog.open.api;    //          art.dialog.open扩展方法
//     if (!api) return;

//     // 操作对话框
//     api.button( { name: '取消' } );
//     $('.box-table tbody tr').on('click', function(){
//         $.dialog.data('game_list_id', $(this).attr('data-id'));
//         $.dialog.data('game_list_title', $(this).attr('data-title'));
//         $.dialog.data('game_list_code', $(this).attr('data-code'));
//         $.dialog.data('game_list_project', $(this).attr('data-project'));
//         $.dialog.data('game_sex', $(this).attr('data-sex'));
//         $.dialog.data('game_start', $(this).attr('data-start'));
//         $.dialog.data('game_end', $(this).attr('data-end'));
//         $.dialog.close();
//     });
// });

$(function(){
        api = $.dialog.open.api;	// art.dialog.open扩展方法
        if (!api) return;

        // 操作对话框
        api.button(
            {
                name:'确定',
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
        // $('.box-table tbody tr').on('click', function(){
        //     var id=$(this).attr('data-id');
        //     var title=$(this).attr('data-title');
        //     $.dialog.data('dispay_type', id);
        //     $.dialog.data('dispay_title', title);
        //     $.dialog.close();
        // });
    });

    function add_chose(){
        var boxnum = $('table.list ').find('.selected');
        $.dialog.data('id', -1);
        $.dialog.data('dispay_title', boxnum );
        $.dialog.close();
    };
</script>