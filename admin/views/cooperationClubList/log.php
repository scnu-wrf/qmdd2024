<div class="box">
    <div class="box-content">
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th width="15%">单位</th>
                        <th width="15%">目标单位</th>
                        <th width="10%">类型</th>
                        <th width="30%">原因</th>
                        <th width="20%">时间</th>
                        <th>状态</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
                    <tr>
                        <td><?php echo $v->club->club_name; ?></td>
                        <td><?php echo $v->invite_club->club_name; ?></td>
                        <td><?php if($v->join_or_del==771){ echo '联盟'; }else{ echo '解除'; } ?></td>
                        <td><?php echo $v->join_reason; ?></td>
                        <td><?php echo $v->join_time; ?></td>
                        <td><?php echo $v->base_code->F_NAME; ?></td>
                    </tr>
<?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->