<?php
    if(!isset($_REQUEST['gf_id'])){
        $_REQUEST['gf_id'] = 0;
    }
?>
<style>.box-table .list tr th,.box-table .list tr td{text-align: center;}.box-detail-tab li{ width:150px; }</style>
<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>会员信息</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-content" style="padding-top: 20px;">
        <div class="box-detail-tab">
            <ul class="c">
                <li><a href="<?php echo $this->createUrl('update',array('id'=>$_REQUEST['gf_id'])); ?>">会员信息</a></li>
                <!-- <li><a href="<?php //echo $this->createUrl('update',array('id'=>$_REQUEST['gf_id'],'cl_a'=>'a2')); ?>">实名信息</a></li> -->
                <!-- <li><a href="<?php echo $this->createUrl('update',array('id'=>$_REQUEST['gf_id'],'cl_a'=>'a3')); ?>">归属单位及龙虎信息</a></li> -->
                <li class="current">登录信息</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-table" style="padding-top: 0;">
            <table class="list">
                <thead>
                    <tr>
                        <th>登录时间</th>
                        <th>登录 ip</th>
                        <th>登录地区</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($arclist as $v){ ?>
                        <tr>
                            <td><?php echo $v->login_time; ?></td>
                            <td><?php echo $v->login_ip; ?></td>
                            <td><?php echo $v->login_address; ?></td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->