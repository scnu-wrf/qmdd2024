<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播 》虚拟体育币管理 》<a class="nav-a">体育币人工充值</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create'),'充值'); ?>
        </div>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="pricing" value="<?php echo Yii::app()->request->getParam('pricing');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text"  placeholder="请输入帐号" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                <tr class="table-title">
                    <th>序号</th>
                    <th>充值GF账号</th>
                    <th><?php echo $model->getAttributeLabel('pricing_details_id');?></th>
                    <th><?php echo $model->getAttributeLabel('recharge_amount');?></th>
                    <th><?php echo $model->getAttributeLabel('rechange_virtual_coin');?></th>
                    <th>充值时间</th>
                    <!-- <th>操作</th> -->
                </tr>
                <?php $index = 1; foreach($arclist as $v){ ?>
                <tr>
                    <td><span class="num num-1"><?php echo $index; ?></span></td>
                    <td><?php echo $v->s_gfaccount; ?></td>
                    <td><?php if(!empty($v->pricing_details_id) && !empty($v->mall_pricing_details_id)) echo $v->mall_pricing_details_id->product_name; ?></td>
                    <td><?php echo $v->recharge_amount; ?></td>
                    <td><?php echo $v->rechange_virtual_coin; ?></td>
                    <td><?php echo $v->s_time; ?></td>
                    <!-- <td>
                        <?php //echo show_command('修改',$this->createUrl('update',array('id'=>$v->id))); ?>
                    </td> -->
                </tr>
                <?php $index++; } ?>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->