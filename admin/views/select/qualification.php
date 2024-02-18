<?php
$_GET["project_id"]=empty($_GET["project_id"])?'':$_GET["project_id"];
$_GET["type_id"]=empty($_GET["type_id"])?'':$_GET["type_id"];
$_GET["if_del"]=empty($_GET["if_del"])?'506':$_GET["if_del"];
$_GET["free_state_Id"]=empty($_GET["free_state_Id"])?'':$_GET["free_state_Id"];
?>
<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input class="input-text" type="hidden" name="project_id" value="<?php echo $_GET["project_id"];?>">
                <input class="input-text" type="hidden" name="type_id" value="<?php echo $_GET["type_id"];?>">
                <input class="input-text" type="hidden" name="if_del" value="<?php echo $_GET["if_del"];?>">
                <input class="input-text" type="hidden" name="free_state_Id" value="<?php echo $_GET["free_state_Id"];?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="qualification" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th colspan="3">点击选择</th>
                    </tr>
                </thead>
                <tbody>
<?php 
    if(count($arclist)<=0 && !empty($_REQUEST['keywords']))echo '<tr><td>未查询到服务者</td></tr>';
    foreach($arclist as $v){ ?>
                    <tr class="data" data-id="<?php echo $v->id; ?>" data-code="<?php echo $v->qualification_gfaccount; ?>" data-title="<?php echo $v->qualification_name; ?>">
                        <td width="30%"><?php echo $v->qualification_gfaccount; ?></td>
                        <td width="40%"><?php echo $v->qualification_project_name; ?>-<?php echo $v->qualification_type; ?>-<?php echo $v->qualification_name; ?></td>
                        <td width="30%"><?php echo $v->qualification_gf_code; ?></td>
                    </tr>
<?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var arclist=<?php echo json_encode(toArray($arclist,'id,qualification_gf_code,qualification_gfaccount,qualification_name,qualification_project_id,qualification_project_name,qualification_type_id,qualification_type'));?>
</script>
<script>
$(function(){
    var parentt = $.dialog.parent;				// 父页面window对象
    api = $.dialog.open.api;	// 			art.dialog.open扩展方法
    if (!api) return;

    // 操作对话框
    api.button(
        {
            name: '取消'
        }
    );
    $('.box-table tbody .data').on('click', function(){
        var id=$(this).attr('data-id');
        var code=$(this).attr('data-code');
        var title=$(this).attr('data-title');
        $.dialog.data('gfid', id);
        $.dialog.data('qualification_gfaccount', code);
        $.dialog.data('qualification_title', title);
        $.each(arclist,function(e,q){
            if(id==q.id){
                $.dialog.data('data', JSON.stringify(q));
            }
        })
        $.dialog.close();
    });
});
</script>