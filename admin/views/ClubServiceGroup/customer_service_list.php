
<div class="box">
    <div class="box-content">
		<div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="clubadmin/index">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入账号或姓名">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;'>客服工号</th>
                        <th style='text-align: center;'>客服账号</th>
                        <th style='text-align: center;'>客服姓名</th>
                        <th style='text-align: center;'>客服昵称</th>
                        <th style='text-align: center;'>客服角色</th>
                        <th style='text-align: center;'>账号状态</th>
                    </tr>
                </thead>
                <tbody>
               
					<?php 
					$index = 1;
					foreach($arclist as $v){ 
					?>
					<?php 
						$server=Yii::app()->db->createCommand("select a.admin_gfaccount,a.admin_gfnick,u.ZSXM as admin_name,a.is_on_line,a.last_login from userlist as u,qmdd_administrators as a where u.GF_ID=a.admin_gfid and a.id=".$v->admin_id)->queryRow();
					?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>" data-service_no="<?php echo $v["service_no"];?>" data-admin_gfaccount="<?php echo $server["admin_gfaccount"];?>" data-admin_name="<?php echo $server["admin_name"];?>" data-admin_gfnick="<?php echo $v["admin_nick"];?>" data-service_level_name="<?php echo $v["service_level_name"];?>" data-group_name="<?php echo $v["group_name"];?>" data-state="<?php echo $v["state"]==649?"启用":"停用";?>" data-is_on_line="<?php echo $server["is_on_line"]==947?"在线":"离线";?>" data-last_login="<?php echo $server["last_login"];?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style='text-align: center;'><?php echo $v["service_no"];?></td>
                        <td style='text-align: center;'><?php echo $server["admin_gfaccount"];?></td>
                        <td style='text-align: center;'><?php echo $server["admin_name"];?></td>
                        <td style='text-align: center;'><?php echo $v["admin_nick"];?></td>
                        <td style='text-align: center;'><?php echo $v["service_level_name"];?></td>
                        <td style='text-align: center;'><?php echo $v["state"]==649?"启用":"停用";?></td>
                    </tr>
					<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        
        <div class="box-page c"><?php $this->page($pages);?></div>
        
    </div><!--box-content end-->
</div><!--box end-->
<script>
$(function(){
    api = $.dialog.open.api;	// 			art.dialog.open扩展方法
    if (!api) return;

    // 操作对话框
    api.button({
		name:'确定',
        callback:function(){
			var server_json=[];
			$(".input-check:checked").not("#j-checkall").each(function(k){
				var server={};
				server["id"]=$(this).val();
				server["service_no"]=$(this).attr("data-service_no");
				server["admin_gfaccount"]=$(this).attr("data-admin_gfaccount");
				server["admin_name"]=$(this).attr("data-admin_name");
				server["admin_gfnick"]=$(this).attr("data-admin_gfnick");
				server["service_level_name"]=$(this).attr("data-service_level_name");
				server["group_name"]=$(this).attr("data-group_name");
				server["state"]=$(this).attr("data-state");
				server["is_on_line"]=$(this).attr("data-is_on_line");
				server["last_login"]=$(this).attr("data-last_login");
				server_json.push(server);
			})
			$.dialog.data('server_json', server_json.length>0?JSON.stringify(server_json):'');
			$.dialog.close();
        },
        focus:true
    },{
		name: '取消'
	});
});
</script>
