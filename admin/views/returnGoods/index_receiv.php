<style>.box-table .list tr th,.box-table .list tr td{ text-align: center; }</style>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>退款列表</h1></div><!--box-title end-->
    <div class="box-title c">
        <h1><i class="fa fa-home"></i>当前界面：订单>售后管理><a class="nav-a">退款列表</a></h1>
    </div><!--box-title end-->      
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
            <button id="exc_btn" class="btn btn-blue" type="button" onclick="javascript:excel();">导出</button>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>售后状态：</span>
                    <?php echo downList($after_sale_state,'f_id','F_NAME','after_sale_state'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>申请人账号：</span>
                    <input style="width:100px;" class="input-text" type="text" name="order_account" value="<?php echo Yii::app()->request->getParam('order_account'); ?>" placeholder="请输入申请人账号">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:220px;" class="input-text" type="text" name="order_num" value="<?php echo Yii::app()->request->getParam('order_num');?>" placeholder="退换货单号/订单编号/退货物流单号">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('return_order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('change_type');?></th>
                        <th><?php echo $model->getAttributeLabel('order_account');?></th>
                        <th><?php echo $model->getAttributeLabel('ret_logistics');?></th>
                        <th><?php echo $model->getAttributeLabel('revi_state');?></th>
                        <th><?php echo $model->getAttributeLabel('after_sale_state');?></th>
                        <th><?php echo $model->getAttributeLabel('order_date');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $basepath=BasePath::model()->getPath(130);
                        $index = 1;
                        foreach($arclist as $v){
                    ?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><?php echo $v->order_num; ?></td>
                            <td><?php echo $v->return_order_num; ?></td>
                            <td><?php echo (!empty($v->change_type)) ? $v->change_base->F_NAME : ''; ?></td>
                            <td><?php if(!empty($v->order_num) && !empty($v->orderinfo))echo $v->orderinfo->order_gfaccount; ?></td>
                            <td><?php echo $v->ret_logistics; ?></td>
                            <td><?php if(!empty($v->orderdata))echo $v->orderdata->ret_state_name; ?></td>
                            <td><?php echo $v->after_sale_state_name; ?></td>
                            <td><?php echo substr($v->order_date,0,10).'<br>'; echo substr($v->order_date,11); ?></td>
                            <td><a class="btn" href="<?php echo $this->createUrl('update_receiv', array('id'=>$v->id));?>" title="编辑">查看</a></td>
                        </tr>
					<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

    function excel(){
        $("#is_excel").val(1);
        $("#submit_button").click();
        $("#is_excel").val('');
    }
</script>