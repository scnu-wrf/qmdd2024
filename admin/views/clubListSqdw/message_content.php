<?php
    if($_SERVER['SERVER_NAME']=='qmdd.gf41.net'){
        $url='https://qmdd.gf41.net/';
    }else if($_SERVER['SERVER_NAME']=='qmdd.gfinter.net'){
        $url='https://qmdd.gfinter.net/admin/privilege.php?act=login';
    }else if($_SERVER['SERVER_NAME']=='oss.gfinter.net'){
        $url='https://oss.gfinter.net/qmdd_admin/admin/privilege.php?act=login';
    }
?>
<div class="box">
    <h1>【意向入驻审核】通知</h1>
    <?php if($_REQUEST['state']==372){?>
    <p>恭喜您，您申请入驻【全民动动-社区单位】初审已通过！</p>
    <p>请您前往<?= $url;?>完善“认证信息”，“信息认证”审核通过后，方可视为入驻成功，获得相应的后台管理权限。</p>
    <p>1.单位管理账号：<?=$model->club_code;?>  初始登录密码：123456</p>
    <p>2.请您妥善保管账号及登录密码，为保障信息安全，请您尽快修改登录密码！</p>
    <?php }elseif($_REQUEST['state']==373){?>
    <p>抱歉，您的“<?=$model->company?>”意向入驻申请审核未通过。</p>
    <?php }?>
</div><!--box end-->