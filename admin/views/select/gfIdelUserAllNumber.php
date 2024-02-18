<style>
    .box-table .list tr:hover td{
        background-color:transparent;
    }
    .box-table .list tr td:hover{
        background-color:#f8f8f8;
    }
</style>
<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>选择指定账号:</span>
                    <input id="gfuser" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
                <!-- <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>换一批</a> -->
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th colspan="4"><div style="float: left;">点击选择</div><div style="text-align: right;"><a style="color: #000000;" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>换一批</a></div></th>
                    </tr>
                </thead>
                <tbody>
                <tr>
				<?php if(count($arclist)>1){?>
				<?php foreach($arclist as $k=>$v){?>
					<td data-id="<?php echo $v->id; ?>" data-account="<?php echo $v->account; ?>"><?php echo $v->account; ?></td>
				<?php if(($k+1)%4==0&&($k+1)!=count($arclist)){?>
                </tr><tr>
				<?php } ?>
				<?php } ?>
				<?php }else if(count($arclist)==1){?>
				<?php foreach($arclist as $k=>$v){?>
					<td <?php if($v->is_use!=1){?>data-id="<?php echo $v->id; ?>" data-account="<?php echo $v->account; ?>"<?php }?> colspan="4"><?php echo $v->account; ?><span style="float:right;margin-right:10%;"><?php if($v->is_use==1){?>已注册<?php }else{?>未注册<?php }?></span></td>
				<?php }?>
				<?php }else{?>
					<td>无账号</td>
				<?php } ?>
                </tr>
                </tbody>
            </table>
        </div><!--box-table end-->
        <!-- <div class="box-page c"><?php //$this->page($pages); ?></div> -->
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
            name: '取消'
        }
    );
    $('.box-table tbody td').on('click', function(){
		if($(this).attr('data-id')){
			$.dialog.data('id',$(this).attr('data-id'));
			$.dialog.data('account',$(this).attr('data-account'));
			$.dialog.close();
		}
    });
});
</script>
