<?php
$arr = array(
    0=>array('name'=>'discount_price','text'=>'价格折扣率'),
    1=>array('name'=>'shopping_price','text'=>'价格'),
    2=>array('name'=>'discount_beans','text'=>'体育豆折扣率'),
    3=>array('name'=>'shopping_beans','text'=>'体育豆'),
    4=>array('name'=>'sale_max','text'=>'限购数量'),
);$arrv = array();$r=0;
foreach ($arclist as $v) foreach ($pricedata as $p) {
    $arrv[$p->id]['discount_price']=$v->discount_price;
    $arrv[$p->id]['shopping_price']=$v->shopping_price;
    $arrv[$p->id]['discount_beans']=$v->discount_beans;
    $arrv[$p->id]['shopping_beans']=$v->shopping_beans;
    $arrv[$p->id]['sale_max']=$v->sale_max;

}
$show_id=0;
$sale_text='';
if($detail->sale_id==3){
    $show_id=1129;
    $sale_text='普通销售';
} elseif ($detail->sale_id==4) {
    $show_id=1132;
    $sale_text='导购销售';
} elseif ($detail->sale_id==5) {
    $show_id=1134;
    $sale_text='二次销售';
} elseif ($detail->sale_id==6) {
    $show_id=0;
    $sale_text='限时抢购';
}
?>
<div class="box">
    <div class="box-content">
        <div class="box-table">
<label style="margin-right:20px;">销售方式：<?php echo $detail->sale_name; ?></label>
<label style="margin-right:20px;">销售单价：<b class="red">¥<?php echo $detail->sale_price; ?></b></label>体育豆（个）：<?php echo $detail->sale_bean; ?>
<?php if($detail->sale_id==4){ ?>
            <table class="list">
                <thead>
                    <tr>
                        <th width="15%" style="text-align:center">单位导购\等级(无偿)</th>
                <?php foreach($clublevel_free as $m){ ?>
                        <th style="text-align:center"><?php echo $m->card_name; ?></th>
                <?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php for($t=0;$t<count($arr);$t++){ ?>
                    <tr>
                        <td><?php echo $arr[$t]['text']; ?></td>
                    <?php foreach($clublevel_free as $m){ ?>   
                        <td><?php foreach($arclist as $v) if($v->customer_level_id==$m->id && $v->sale_show_id==1130){

                         echo $arrv[$v->mall_memmber_price_id][$arr[$t]['name']]; } 
                         if($arr[$t]['name']=='discount_price' || $arr[$t]['name']=='discount_beans') echo '%'; ?></td>
                    <?php } ?>
                    </tr>
<?php } ?>
                </tbody>
            </table>
            <table class="list">
                <thead>
                    <tr>
                        <th width="15%" style="text-align:center">单位导购\等级(有偿)</th>
                <?php foreach($clublevel_pay as $m){ ?>
                        <th style="text-align:center"><?php echo $m->card_name; ?></th>
                <?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php for($t=0;$t<count($arr);$t++){ ?>
                    <tr>
                        <td><?php echo $arr[$t]['text']; ?></td>
                    <?php foreach($clublevel_pay as $m){ ?>   
                        <td><?php foreach($arclist as $v) if($v->customer_level_id==$m->id && $v->sale_show_id==1130){

                         echo $arrv[$v->mall_memmber_price_id][$arr[$t]['name']]; } 
                         if($arr[$t]['name']=='discount_price' || $arr[$t]['name']=='discount_beans') echo '%'; ?></td>
                    <?php } ?>
                    </tr>
<?php } ?>
                </tbody>
            </table>
<?php } ?>
<?php if($detail->sale_id==5){ ?>
            <table class="list">
                <thead>
                    <tr>
                        <th width="15%" style="text-align:center">二次上架\龙虎等级</th>
                <?php foreach($dgmember as $m){ ?>
                        <th style="text-align:center"><?php echo $m->card_name; ?></th>
                <?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php for($t=0;$t<count($arr);$t++){ ?>
                    <tr>
                        <td><?php echo $arr[$t]['text']; ?></td>
                    <?php foreach($dgmember as $m){ ?>   
                        <td><?php foreach($arclist as $v) if($v->customer_level_id==$m->id && $v->sale_show_id==1131){

                         echo $arrv[$v->mall_memmber_price_id][$arr[$t]['name']]; } 
                         if($arr[$t]['name']=='discount_price' || $arr[$t]['name']=='discount_beans') echo '%'; ?></td>
                    <?php } ?>
                    </tr>
<?php } ?>
                </tbody>
            </table>
<?php } ?>
            <table class="list">
                <thead>
                    <tr>
                        <th width="15%" style="text-align:center"><?php echo $sale_text; ?>\会员等级</th>
                <?php foreach($member as $m){ ?>
                        <th style="text-align:center"><?php echo $m->card_name; ?></th>
                <?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php for($t=0;$t<count($arr);$t++){ ?>
                    <tr>
                        <th><?php echo $arr[$t]['text']; ?></th>
                    <?php foreach($member as $m){ ?>   
                        <td><?php foreach($arclist as $v) if($v->customer_level_id==$m->id && $v->sale_show_id==$show_id){

                         echo $arrv[$v->mall_memmber_price_id][$arr[$t]['name']]; } 
                         if($arr[$t]['name']=='discount_price' || $arr[$t]['name']=='discount_beans') echo '%'; ?></td>
                    <?php } ?>
                    </tr>
<?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
    </div><!--box-content end-->
</div><!--box end-->