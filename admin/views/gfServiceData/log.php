<div class="box">
    <div class="box-content">
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="text-align: center;">序号</th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('data_name');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('gf_account');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('gf_name');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('servic_time_star');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('servic_time_end');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('buy_price');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('order_state_name');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('state');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('add_time');?></th>
                    </tr>
                </thead>
                <tbody>
<?php 
$index = 1;
foreach($arclist as $v){
?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style="text-align: center"><?php echo $v->data_name; ?></td>
                        <td style="text-align: center"><?php echo $v->gf_account; ?></td>
                        <td style="text-align: center"><?php echo $v->gf_name; ?></td>
                        <td style="text-align: center"><?php echo $v->servic_time_star; ?></td>
                        <td style="text-align: center"><?php echo $v->servic_time_end; ?></td>
                        <td style="text-align: center"><?php echo $v->buy_price; ?></td>
                        <td style="text-align: center"><?php echo $v->order_state_name; ?></td>
                        <td style="text-align: center"><?php echo $v->state_name; ?></td>
                        <td style="text-align: center"><?php echo $v->add_time; ?></td>
                    </tr>
<?php $index++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->