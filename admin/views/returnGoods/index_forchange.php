
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》收/发货管理》<a class="nav-a">换货发货处理</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->     
    <div class="box-content">
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="width:25px; text-align:center;">序号</th>
                        <th><?php echo $model->getAttributeLabel('return_order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th>换货商品</th>
                        <th><?php echo $model->getAttributeLabel('buy_count');?></th>
                        <th><?php echo $model->getAttributeLabel('after_sale_state');?></th>
                        <th>物流信息</th>
                        <th><?php echo $model->getAttributeLabel('take_date');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td style="text-align:center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->return_order_num; ?></td>
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php echo $v->ret_product_title; ?>，<?php echo $v->ret_json_attr; ?></td>
                        <td><?php echo $v->ret_count; ?></td>
                        <td><?php echo $v->after_sale_state_name; ?></td>
                        <td><?php echo $v->ret_logistics_name; ?>/<?php echo $v->ret_logistics; ?></td>
                        <td><?php echo $v->take_date; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_change', array('id'=>$v->id));?>" title="发货详情">发货</a>
                        </td>
                    </tr>
<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->