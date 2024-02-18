<?php
$arr = array();
$sarr = array();
$r = 0;
foreach ($arclist as $d1) foreach ($s_time as $t1) {
    $r1 = $d1->s_date;
    $r2 = $t1->s_timename;
    $arr[$r1][$r2] ='';
    $sarr[$r1][$r2] ='';
    foreach ($s_data as $v1) {
        if ($v1->s_timename == $t1->s_timename && $v1->s_date == $d1->s_date) {
            $arr[$r1][$r2] =$v1->sale_price;
            $sarr[$r1][$r2] =$v1->special;
        }
    }
}
?>
<div class="box">
    <div class="box-content">
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th width="9%">资源编号/名称</th>
                        <th><?php echo $setlist->s_code; ?>/<?php echo $setlist->s_name; ?></th>
                    </tr>
                    <tr>
                        <th>年份</th>
                        <th><?php if (!empty($arclist)) echo substr($arclist[0]['s_date'],0,4); ?>年</th>
                    </tr>
                </thead>
            </table>
            <table class="list">
                <thead>
                    <tr>
                        <th width="9%">服务日期</th>
                   <?php if (!empty($s_time)) foreach ($s_time as $t) { ?>
                        <th><?php echo $t->s_timename; ?></th>
                   <?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php if (!empty($arclist)) foreach ($arclist as $d) { ?>
                    <tr>
                        <td><?php echo substr($d->s_date,-5); ?></td>
  <?php
    if (!empty($s_time)) foreach ($s_time as $t) { ?>
                        <td><?php echo $arr[$d->s_date][$t->s_timename]; ?><?php if($sarr[$d->s_date][$t->s_timename]==1){ ?><span class="red">特</span><?php } ?></td>
  <?php } ?>
                    </tr>
<?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->