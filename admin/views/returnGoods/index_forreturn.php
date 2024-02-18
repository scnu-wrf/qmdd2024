
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》收/发货管理》退/换货收货处理》<a class="nav-a">待退货</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->     
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>审核时间：</span>
                    <input style="width:80px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start; ?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end; ?>">
                </label>
                <label style="margin-right:10px;">
                        <span>售后类型：</span>
                        <?php echo downList($change_type,'f_id','F_NAME','change_type'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>售后单号：</span>
                    <input style="width:220px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="售后单号">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="text-align:center; width:25px;">序号</th>
                        <th style="width:10%;"><?php echo $model->getAttributeLabel('order_num');?></th></th>
                        <th><?php echo $model->getAttributeLabel('change_type');?></th>
                        <th>退换商品</th>
                        <th><?php echo $model->getAttributeLabel('ret_count');?></th>
                        <th><?php echo $model->getAttributeLabel('after_sale_state');?></th>
                        <th style="width:70px;"><?php echo $model->getAttributeLabel('uDate');?></th>
                        <th>商品退回倒计时</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td style="text-align:center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php echo (!empty($v->change_base)) ? $v->change_base->F_NAME : ''; ?></td>
                        <td><?php echo $v->orderdata->product_title; ?>，<?php echo $v->orderdata->json_attr; ?></td>
                        <td><?php echo $v->ret_count; ?></td>
                        <td><?php echo $v->after_sale_state_name; ?></td>
                        <td><?php echo $v->uDate; ?></td>
                        <td><?php 
                        $time1 = strtotime(date("Y-m-d H:i:s"));
                        $now_m=date("Y-m-d H:i:s",strtotime("+7 day",strtotime($v->uDate)));
                        $time2 = strtotime($now_m);
                        $all=$time2-$time1;
                        $days=floor($all/86400);
                        $all1=$all-($days*86400);
                        $hours=floor($all1/3600);
                        $all2=$all1-($hours*3600);
                        $minus=floor($all2/60);
                        $sec=$all2%60;
                         echo ($time2>$time1) ? $days.'天'.$hours.'时'.$minus.'分'.$sec.'秒' : '超时未退'; ?></td>
                        <td>
                            <a class="btn" href="javascript:;" onclick="fnClose(<?php echo $v->id;?>);" title="编辑">退换关闭</a>
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
    function fnClose(id){
        var a=confirm("确定关闭吗？");
        if(a==false){
            return false;
        }
        we.loading('show');
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('close');?>&id='+id,
            dataType: 'json',
            success: function(data) {
                if(data.status==1){
                    we.loading('hide');
                    we.success(data.msg, data.redirect);
                }else{
                    we.loading('hide');
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }
</script>