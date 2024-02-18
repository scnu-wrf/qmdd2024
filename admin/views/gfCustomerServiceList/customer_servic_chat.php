
<div class="box">
    <div class="box-content">
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style='text-align: center;'>发送时间</th>
                        <th style='text-align: center;'>发送方</th>
                        <th style='text-align: center;'>消息内容</th>
                        <th style='text-align: center;'>客服姓名</th>
                        <th style='text-align: center;'>客服昵称</th>
                    </tr>
                </thead>
                <tbody>
               
					<?php 
					$index = 1;
					foreach($arclist as $v){ 
					?>
					<?php 
						$server=Yii::app()->db->createCommand("select a.admin_gfaccount,a.admin_gfnick,u.ZSXM as admin_name,a.is_on_line,a.last_login from gf_user_1 as u,qmdd_administrators as a where u.GF_ID=a.admin_gfid and a.id=".$v->r_adminid)->queryRow();
					?>
                    <tr>
                        <td style='text-align: center;'><?php echo $v->s_time;?></td>
                        <td style='text-align: center;'><?php echo ($v->s_manber==1)?'在线客服':(($v->s_manber==2)?'智能客服':'用户');?></td>
                        <td style='text-align: center;'><?php echo base64_decode(base64_decode($v->m_message));?></td>
                        <td style='text-align: center;'><?php echo $server["admin_name"];?></td>
                        <td style='text-align: center;'><?php echo $server["admin_gfnick"];?></td>
                    </tr>
					<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        
        <div class="box-page c"><?php $this->page($pages);?></div>
        
    </div><!--box-content end-->
</div><!--box end-->
