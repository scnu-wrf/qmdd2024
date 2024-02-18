<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="club_type" value="<?php echo Yii::app()->request->getParam('club_type');?>">
                <input type="hidden" name="partnership_type" value="<?php echo Yii::app()->request->getParam('partnership_type');?>">
                <input type="hidden" name="edit_state" value="<?php echo Yii::app()->request->getParam('edit_state');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入单位账号">
                </label>
                <button id="box_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('club_code');?></th>
                        <th><?php echo !empty($_REQUEST['club_type'])&&$_REQUEST['club_type']==380?'商家名称':$model->getAttributeLabel('club_name');?></th>
                        <th>状态</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1;foreach($arclist as $v){ ?>
    <tr data-id="<?php echo $v->id; ?>" data-code="<?php echo $v->club_code; ?>" data-title="<?php echo $v->club_name; ?>" data-type="<?php echo $v->partnership_type; ?>" data-typename="<?php echo $v->partnership_name; ?>">
        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
        <td><?php echo $v->club_code; ?></td>
        <td>
            <?php 
                if($v->club_type==1086){
                    echo $v->company;
                }else if(($v->club_type==8||$v->club_type==189||$v->club_type==380)&&$v->edit_state!=372){
                    echo '未完成认证';
                }else{
                    echo $v->club_name;
                }
            ?>
        </td>
        <td><?php echo $v->state!=372?$v->state_name:is_null($v->edit_state)?'待认证':$v->edit_state_name; ?></td>
    </tr>
<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    $(function(){
        api = $.dialog.open.api;	// 			art.dialog.open扩展方法
        if (!api) return;

        // 操作对话框
        api.button( { name: '取消' } );
        $('.box-table tbody tr').on('click', function(){
        //    var id=$(this).attr('data-id');
        //    var title=$(this).attr('data-title');
            $.dialog.data('club_id', $(this).attr('data-id'));
            $.dialog.data('club_code', $(this).attr('data-code'));
            $.dialog.data('club_title', $(this).attr('data-title'));
            $.dialog.data('club_type', $(this).attr('data-type'));
            $.dialog.data('club_typename', $(this).attr('data-typename'));
            $.dialog.close();
        });
    });

    $('#box_submit').on('click',function(){
        if($('#keywords').val().length<10){
            we.msg('minus','请输入完整单位账号');
            return false;
        }
    })
</script>