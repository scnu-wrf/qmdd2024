<div class="box">
    <h1>【社区商家认证审核通知】</h1>
    <?php if($_REQUEST['edit_state']==2){?>
    <p>恭喜您成功入驻【得闲体育-供应商】</p>
    <p>您可前往后台管理系统进行操作https://htt.gdinin.com/index.php</p>
    <p>1.供应商管理账号：<?=$model->club_code;?>  初始登录密码：123456</p>
    <p>2.请您妥善保管账号及登录密码，为保障信息安全，请您尽快修改登录密码！</p>
    <?php }elseif($_REQUEST['edit_state']==373){?>
    <p>很抱歉，您申请入驻【得闲体育-供应商】审核未通过！</p>
    <p>您可前往https://htt.gdinin.com/index.php，修改认证信息重新提交，认证审核通过后，方可视为入驻成功，获得相应的后台管理权限。</p>
    <p>1.登录账号：<?=$model->club_code;?>, 初始登录密码：123456 </p>
    <?php }?>
</div>
