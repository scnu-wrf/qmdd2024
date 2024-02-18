<?php
    if($_SERVER['SERVER_NAME']==wwwsportnet()){
        $url=httpssportnet();
    }else if($_SERVER['SERVER_NAME']==wwwsportnet()){
        $url=wwwsportnet();
    }else {
        $url=wwwsportnet();
    }
    $url.='\index.php?r=index/login';
?>
<div class="box">
    <?php if(@$_REQUEST['state']==2){?>
        <h1>【供应商-意向入驻审核通知】</h1>  
        <p>恭喜您申请入驻【得闲体育-供应商】初审已通过！ 请您前往<?= $url;?>，完善商家认证，商家认证审核通过后，方可视为入驻成功，获得相应的后台管理权限。</p>
        <p>1.登录账号：<?=$model->club_code;?>  初始登录密码：123456</p>
        <p>2.请您妥善保管账号及登录密码，为保障信息安全，请您尽快修改登录密码！</p>
    <?php }elseif(@$_REQUEST['state']==373){?>
        <h1>【供应商-意向入驻审核通知】</h1>  
        <p>很抱歉，“<?=$model->company?>供应商”意向入驻申请初审未通过！</p>
    <?php }elseif(@$_REQUEST['edit_state']==2){?>
        <h1>【社区商家认证审核通知】</h1>  
        <p>恭喜您成功入驻【得闲体育-供应商】！ 您可前往后台管理系统进行操作<?= $url;?></p>
        <p>1.供应商管理账号：<?=$model->club_code;?>  初始登录密码：123456</p>
        <p>2.请您妥善保管账号及登录密码，为保障信息安全，请您尽快修改登录密码！</p>
     <?php }elseif(@$_REQUEST['edit_state']==373){?>
        <h1>【社区商家认证审核通知】</h1>  
        <p>很抱歉，您申请入驻【得闲体育-供应商】审核未通过！ 您可前往<?= $url;?>，修改商家认证信息重新提交，商家认证审核通过后，方可视为入驻成功，获得相应的后台管理权限。
</p>
        <p>1.登录账号：<?=$model->club_code;?>  初始登录密码：123456</p>
        
    <?php }?>
</div>
