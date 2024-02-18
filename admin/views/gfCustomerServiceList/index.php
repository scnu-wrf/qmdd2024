
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>客服服务记录</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </div><!--box-header end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;'>日期</th>
                        <th style='text-align: center;'>服务流水号</th>
                        <th style='text-align: center;'>业务类型</th>
                        <th style='text-align: center;'>业务来源</th>
                        <th style='text-align: center;'>业务内容</th>
                        <th style='text-align: center;'>咨询用户</th>
                        <th style='text-align: center;'>服务客服</th>
                        <th style='text-align: center;'>服务时长</th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
               
					<?php 
					$index = 1;
					foreach($arclist as $v){ 
					?>
					<?php 
						if(!empty($v->r_adminid)){
							$sql="select u.ZSXM as admin_name,q.admin_gfaccount,q.admin_gfnick,q.last_login from gf_user_1 u,qmdd_administrators q where q.id=".$v->r_adminid." and q.admin_gfid=u.GF_ID";
							$server=Yii::app()->db->createCommand($sql)->queryRow();
						}
					?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style='text-align: center;'><?php echo $v->s_time; ?></td>
                        <td style='text-align: center;'><?php echo $v->code; ?></td>
                        <td style='text-align: center;'><?php echo $v->problem_type_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->problem_type_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->type_content_name; ?></td>
                        <td style='text-align: center;'><?php echo (empty($v->s_gf_account)?'匿名用户':($v->s_gf_account.'('.$v->s_gf_name.')')); ?></td>
                        <td style='text-align: center;'><?php echo empty($v->r_adminid)?'':$server["admin_name"]; ?></td>
                        <td style='text-align: center;'><?php $interval = date_diff(date_create($v->s_time),date_create($v->e_time)); echo $interval->format('%i 分钟'); ?></td>
                        <td style='text-align: center;'>
                            <a class="btn" href="javascript:;" onclick="view_chat('<?php echo $v->id; ?>');">历史记录</a>
                        </td>
                    </tr>
					<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        
        <div class="box-page c"><?php $this->page($pages);?></div>
        
    </div><!--box-content end-->
</div><!--box end-->
<script>
function view_chat(customer_service_id){
	var url='<?php echo $this->createUrl("customer_servic_chat");?>&message_id='+customer_service_id;
	$.dialog.open(url,{
		id:'lishijilu',
		lock:true,
		opacity:0.3,
		title:'历史记录',
		width:'80%',
		height:'60%',
		close: function () {
			
		}
	});
}
</script>