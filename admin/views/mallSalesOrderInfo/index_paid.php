<div class="box">
    <div class="box-title c">
        <h1>当前界面：首页》费用中心》待支付订单</h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->     
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>商品类型：</span>
                    <select name="order_type">
                        <option value="">请选择</option>
                        <?php foreach($order_type as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('order_type')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>         
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <!-- window.location.href="cashier-desks?Code="+Encrypt("orderType=7&orderNum="+$(_that).parents(".order_form").find(".order_num").text()); -->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('product_title');?></th>
                        <th><?php echo $model->getAttributeLabel('order_type');?></th>
                        <th><?php echo $model->getAttributeLabel('money');?></th>
                        <th><?php echo $model->getAttributeLabel('order_money');?></th>
                        <th>支付状态</th>
                        <th><?php echo $model->getAttributeLabel('total_money');?></th> 
                        <th><?php echo $model->getAttributeLabel('pay_supplier_type');?></th>
                        <th><?php echo $model->getAttributeLabel('pay_time');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody><?php $basepath=BasePath::model()->getPath(130);?>
					<?php
                    $index = 1;
                      
                     foreach($arclist as $v){ ?>
                    <tr>
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php if(!empty($v->order_data))echo $v->order_data->product_title; ?></td>
                        <td><?php echo $v->order_type_name; ?></td>
                        <td><?php echo $v->money; ?></td>
                        <td><?php echo $v->order_money; ?></td>
                        <td>已支付</td>
                        <td><?php echo $v->total_money; ?></td>
                        <td><?php echo $v->pay_supplier_type_name; ?></td>
                        <td><?php echo $v->pay_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_paid', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                        </td>
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
</script>